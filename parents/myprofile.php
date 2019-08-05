<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'myprofile';

    ?>
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Welcome <?php echo $login_session2; ?> </a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-panel purple darken-3">
                            <div class="row">
                                    <div class="col s12 m12">
                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">My Profile</span> 

                                <div class="card-content white-text flow-text">
                                <?php if(!empty($login_session2)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Father Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $login_session2; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($login_session3)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Mother Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $login_session3; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($login_session3)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Phone Number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">phone</i>&nbsp;<?php echo $login_session5; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($login_session3)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Mobile Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">phone</i>&nbsp;<?php echo $login_session6; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($login_session3)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Profession" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">work</i>&nbsp;<?php echo $login_session9; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($login_session4)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email ID" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $login_session4; ?>
                                </div>
                                <br><?php } ?>


                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Address" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">home</i>&nbsp;<?php echo $login_session10; ?>
                                </div>
                                <br>


                                        </div>
                                    </div>
                              </div>
                            </div>
                                </div>
                            </div>
                        </div>

                    <!-- Modal Structure -->
                    <div id="modaleditadmin" class="modal">
                      <div class="modal-content">
                        <form id="update_admin_info" action="updatescript.php" method="post" >
                          <h6 align="center">Update your details</h6>
                          <div class="divider"></div>
                          <div class="row">
                              <div class="col s2 offset-m1">
                                  <h6 style="padding-top: 20px">Name</h6>
                              </div>
                              <div class="input-field col s6">
                                <input name="admin_name" id="admin_name" type="text" class="validate" value="<?php echo $login_session2; ?>" required >
                              </div>
                          </div>
                          <div class="row">
                              <div class="col s2 offset-m1">
                                  <h6 style="padding-top: 20px">Email</h6>
                              </div>
                              <div class="input-field col s6">
                                <input name="admin_email" id="admin_email" type="text" class="validate" value="<?php echo $login_session3; ?>" required readonly >
                              </div>
                          </div>
                          <div class="row">
                              <div class="col s2 offset-m1">
                                  <h6 style="padding-top: 20px">Mobile no:</h6>
                              </div>
                              <div class="input-field col s6">
                                <input name="admin_mobile" id="admin_mobile" type="text" class="validate" value="<?php echo $login_session9; ?>" required>
                              </div>
                          </div>

                          <div class="row">
                            <div class="col s2 offset-m1">
                                <h6 style="padding-top: 20px">Gender</h6>
                            </div>
                            <div class="input-field col s6">
                                  <input class="with-gap" name="admin_sex" value="Male" type="radio" id="Male" <?php if ($login_session8=='Male') {echo 'checked';
                                  }?> />
                                  <label for="Male">Male</label>
                                  <input class="with-gap" name="admin_sex" value="Female" type="radio" id="Female" <?php if ($login_session8=='Female') {echo 'checked';
                                  }?> />
                                  <label for="Female">Female</label>
                                  <input class="with-gap" name="admin_sex" value="Other" type="radio" id="Other" <?php if ($login_session8=='Other') {echo 'checked';
                                  }?> />
                                  <label for="Other">Other</label>
                            </div>
                          </div>
                          <input type="hidden" name="update_admin_info">

                          <div class="modal-footer">
                            <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit" name="update_mark">Update<i class="material-icons right">send</i></button>
                          </div>
                        </form>
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

<script type="text/javascript">
  $(document).ready(function (e) 
{
  $("#admin_profile").on('change',(function(e) 
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
            $("#err").fadeOut();
          },
          success: function(data)
          {
            //alert(data);
            if (data!='Profile picture updated') { Materialize.toast(data, 4000, 'rounded'); } 
            else 
              if (data=='Profile picture updated') {
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#delete_admin_profile").on('submit',(function(e) 
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
            $("#err").fadeOut();
          },
          success: function(data)
          {
            //alert(data);
            if (data!='Profile picture deleted') { Materialize.toast(data, 4000, 'rounded'); } 
            else 
              if (data=='Profile picture deleted') {
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#update_admin_info").on('submit',(function(e) 
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
            $("#err").fadeOut();
          },
          success: function(data)
          {
            //alert(data);
            if (data!='Information updated Successfully') { Materialize.toast(data, 4000, 'rounded'); } 
            else 
              if (data=='Information updated Successfully') {
                $('#modaleditadmin').modal('close');
             window.location.href = window.location.href;
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
