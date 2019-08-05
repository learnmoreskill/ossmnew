<?php
//for all

   include('session.php');
   ?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        <main>
          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Manage Login</a></div>
                    </div>
                </div>
            </div>

             <div class="row">
              <div class="col s12 m6 offset-m3">
                <ul class="collapsible">
                  <li>
                    <div class="collapsible-header light-blue-text center"><h5>Change Email Id</h5></div>
                    <div class="collapsible-body">
                      <form id="updateEmailIdForm">
                        <div class="row padding-5">
                          <div class="row">
                          <div class="input-field">
                            <input name="newEmailId" type="email" class="validate" required placeholder="New Email Id" value="<?php echo $LOGIN_EMAIL; ?>" >
                            </div>
                           </div>
                           <input type="hidden" name="updateEmailId" value="<?php echo $LOGIN_ID; ?>">
                           <input type="hidden" name="loginCatKey" value="<?php echo $LOGIN_CAT; ?>" >
                            <button class="btn waves-effect waves-light" type="submit" >Update
                            <i class="material-icons right">send</i>
                          </button>                          
                        </div>                        
                      </form>
                    </div>
                  </li>
                  <li>
                    <div class="collapsible-header light-blue-text center"><h5>Change Your Password</h5></div>
                    <div class="collapsible-body">
                      <form id="updatePasswordForm">
                        <div class="row padding-5">
                          <div class="row">
                          <div class="input-field">
                            <input name="newpassword" type="password" class="validate" required placeholder="New Password" >
                            </div>
                           </div>
                           <div class="row"> 
                            <div class="input-field">
                              <input name="confirmnewpassword" type="password" class="validate" required placeholder="Confirm New Password">
                            </div>
                            </div>
                            <input type="hidden" name="updatePassword" value="<?php echo $LOGIN_ID; ?>">
                           <input type="hidden" name="loginCatKey" value="<?php echo $LOGIN_CAT; ?>" >
                            <button class="btn waves-effect waves-light" type="submit" name="action">Update
                            <i class="material-icons right">send</i>
                          </button>                          
                        </div>                        
                      </form>
                    </div>
                  </li>
                </ul>
              </div>              
            </div>

        </main>
<?php include_once("../config/footer.php");?>

<?php
if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }
?> 

<script>
$(document).ready(function (e) 
{
  $("#updateEmailIdForm").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "updatescript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            
            $("#overlayloading").show();
            //$("#formsubmit").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Email id succesfully updated'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else 
              if (data.trim() === 'Email id succesfully updated'.trim()) {

              alert(data.trim());
              window.location.href = 'logout.php';
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            //$("#formsubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  }));  


  $("#updatePasswordForm").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "updatescript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            
            $("#overlayloading").show();
            //$("#formsubmit").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Password succesfully updated'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else 
              if (data.trim() === 'Password succesfully updated'.trim()) {

              alert(data.trim());
              window.location.href = 'logout.php';
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#formsubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  }));  
});

</script>
