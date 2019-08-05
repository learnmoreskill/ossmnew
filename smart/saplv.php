<?php
  include('session.php');


  /*set active navbar session*/
  $_SESSION['navactive'] = 'saplv';
?>
    <!-- add adminheader and navbar here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Leave Manager</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Request For Leave</span></span>
                            <p class="flow-text">Just fill the form below and submit.</p><br/>

                            <form id="apply_leave_form" method="post" action="saplvscript.php?upd">
                                <div class="input-field col s12">
                                  <input type="text" id="sdate" 
                                  class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" 
                                      onclick="mypicker(this.id)"
                                  name="sdate" required 
                                  placeholder="Enter Start Date" >
                                <label for="sdate">Enter Start Date</label>
                                </div>
                                <div class="input-field col s12">
                                  <input type="text" id="edate" 
                                  class="<?php if($login_date_typee==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                                  name="edate" required
                                  placeholder="Enter End Date" >
                                  <label for="edate">Enter End Date</label>
                                </div>


                                <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="lvreason" name="lvreason" class="materialize-textarea" length="3000" maxlength="3000" required></textarea>
                                            <label for="lvreason">Mention the reason :</label>
                                        </div>
                                    </div>
                                
                                <button class="btn waves-effect waves-light blue lighten-2" type="submit">Submit</button>
                            </form>
                        </div>
                    </div>
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
  $("#apply_leave_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "saplvscript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#err").fadeOut();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Leave request successfully submitted'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });

            }else if (data.trim() === 'Leave request successfully submitted'.trim()) {

              window.location.href = 'saplvhistory.php';
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
});
</script>

