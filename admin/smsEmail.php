<?php
   include('session.php');
   $_SESSION['navactive'] = 'smsEmail';
   
   require("../important/backstage.php");
   $backstage = new back_stage_class();

   require("../config/sendbulksms.php");

   $smsdetails= bulksmsdetails($login_session_bulksmstoken);

   $newdate = date("Y-m-d");

   $school_details = json_decode($backstage->get_school_details_by_id());

?>
    <!-- add adminheade.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

    <main>
        <div class="section no-pad-bot" id="index-banner">
            <?php include_once("../config/schoolname.php");?>
            <div class="github-commit">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">SMS and Email Setting</a></div>
                </div>
            </div>
        </div>

      <div class="row">
          <div class="col s12 m5">
              <div class="row ">
                  <div class="card blue-grey">
                    <div class="card-content white-text">
                      <form id="update_mailfrom_setting_form">
                          <span class="card-title">Email Setting</span>
                          <input type="text" name="email" placeholder="From:email id" value="<?php echo $school_details->mailfrom; ?>" >
                          <input type="hidden" name="update_mailfrom_setting">
                          <div id="mailfrom_update_button" style="display: none;"><button class="btn waves-effect waves-light right" type="submit">Update
                        <i class="material-icons right">send</i></div>
                        </button><br>
                      </form>
                    </div>
                  </div>
              </div>

              <div class="row ">
                  <div class="card blue-grey">
                    <div class="card-content white-text">
                        <span class="card-title">Bulk SMS Credit Details</span><br>

                        <?php if ($smsdetails["response_code"]=='202') { ?>
                        <div class="row">
                          <div class="col s6 m6"><span> Credits Available</span></div>

                          <div class="col s6 m6"><span> <?php echo $smsdetails["available_credit"]; ?></span></div>
                        </div>

                        <div class="row">
                          <div class="col s6 m6"><span> Total SMS Sent</span></div>

                          <div class="col s6 m6"><span> <?php echo $smsdetails["total_sms_sent"]; ?></span></div>
                        </div>

                        <?php }else{ ?>

                        <div class="row">
                          <div class="col s6 m6"><span>Credit details not available</span></div>
                        </div>
                          <?php } ?>


                    </div>
                  </div>
              </div>
             
          </div>


            <div class="col s12 m7">
              <form id="update_sms_setting_form">
                <table class="centered bordered striped highlight z-depth-4">
                <thead>
                    <tr>
                        <th>Bulk SMS Setting</th>
                        <th>Disabled/Enabled</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Attendance</td>
                        <td>
                          <div class="switch">
                            <label>
                              Off
                              <input type="checkbox" name="sms_attendance" <?php if($school_details->sms_attendance==0){}elseif ($school_details->sms_attendance==1){echo "checked='checked'"; }  ?> >
                              <span class="lever"></span>
                              On
                            </label>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Fee Not Paid</td>
                        <td>
                          <div class="switch">
                            <label>
                              Off
                              <input type="checkbox" name="sms_feenotice" <?php if($school_details->sms_feenotice==0){}elseif ($school_details->sms_feenotice==1){echo "checked='checked'"; }  ?> >
                              <span class="lever"></span>
                              On
                            </label>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Complaint/Message</td>
                        <td>
                          <div class="switch">
                            <label>
                              Off
                              <input type="checkbox" name="sms_complaint" <?php if($school_details->sms_complaint==0){}elseif ($school_details->sms_complaint==1){echo "checked='checked'"; }  ?> >
                              <span class="lever"></span>
                              On
                            </label>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Homework Not Done</td>
                        <td>
                          <div class="switch">
                            <label>
                              Off
                              <input type="checkbox" name="sms_nohomework" <?php if($school_details->sms_nohomework==0){}elseif ($school_details->sms_nohomework==1){echo "checked='checked'"; }  ?> >
                              <span class="lever"></span>
                              On
                            </label>
                          </div>
                        </td>
                    </tr>
                    <tr>
                        <td>Broadcast</td>
                        <td>
                          <div class="switch">
                            <label>
                              Off
                              <input type="checkbox" name="sms_broadcast" <?php if($school_details->sms_broadcast==0){}elseif ($school_details->sms_broadcast==1){echo "checked='checked'"; }  ?> >
                              <span class="lever"></span>
                              On
                            </label>
                          </div>
                        </td>
                    </tr>
                </tbody>
                </table>
                <input type="hidden" name="update_sms_setting">
                <div id="sms_update_button" class="input-field card-action" style="display: none;">
                  <button class="btn waves-effect waves-light right" type="submit">Update
                    <i class="material-icons right">send</i>
                  </button>
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

  $("#update_sms_setting_form").on('submit',(function(e) 
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
             Materialize.toast(data, 4000, 'rounded');  
             $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              }); 
            
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));

   $("#update_sms_setting_form").on('change',(function(e) 
  {
    document.getElementById("sms_update_button").style.display = "block";
  }));

   $("#update_mailfrom_setting_form").on('keyup',(function(e) 
  {
    document.getElementById("mailfrom_update_button").style.display = "block";
  }));


$("#update_mailfrom_setting_form").on('submit',(function(e) 
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
             Materialize.toast(data, 4000, 'rounded');
             $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });  
            
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));

});

</script>
