<?php
   include('session.php');
   $_SESSION['navactive'] = 'trackbusedit';
   
   require("../important/backstage.php");
   $backstage = new back_stage_class();

   $newdate = date("Y-m-d");

   if (isset($_GET["token"])){
        $longid1 = ($_GET["token"]);

        $staff_type="Driver";
        $resultstaff = $db->query("SELECT * FROM `staff_tbl` WHERE `staff_type` = '$staff_type' AND `staff_status`=0");

        if ($longid1=="prf3s765t7y3ww") {
          if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);
            

            $bus_details = json_decode($backstage->get_transportaion_details_by_id($shortid));
        
            }
          }
    }else{

      $transportation_details = json_decode($backstage->get_transportation_details());

      $rowCount = $transportation_details->num_rows;
      if($rowCount > 0) { $found='1';} else{ $found='0';  }
    }

   

?>
    <!-- add adminheade.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

    <main>
        <div class="section no-pad-bot" id="index-banner">
            <?php include_once("../config/schoolname.php");?>
            <div class="github-commit">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">
                      <?php if( (isset($_GET['token']) && @$_GET['token']=="prf3s765t7y3ww") ){ echo "Update Bus Information"; } else { echo "Bus Information"; } ?>
                      </a></div>
                </div>
            </div>
        </div>

<!-- ========================== Edit bus div ==================================== -->
  <?php 
    if(isset($_GET['token']))
       {
      ?>
              <div class="row ">
                  <div class="card blue-grey">
                    <div class="card-content white-text">
                      <span class="card-title"><?php if ($_GET['token']=="prf3s765t7y3ww") {
                        echo "Edit Bus Information";
                      }else if($_GET['token']=="prf3s765addn398"){
                        echo "Add Bus";
                      } ?></span>
                      <form id="update_bus_form" action="updatescript.php" method="post" >
                          <input type="hidden" name="<?php if ($_GET['token']=='prf3s765t7y3ww') {
                        echo 'update_bus_information';
                      }else if($_GET['token']=='prf3s765addn398'){
                        echo 'add_bus_information';
                      } ?>" value="<?php echo $bus_details->bus_id; ?>">


                        <div class="col s6 m3">
                          <div class="input-field">
                            <input type="text" name="bus_number" value="<?php echo $bus_details->bus_number;?>" required class="validate" placeholder="Bus number" >
                            <label class="white-text">Bus Number:</label>
                          </div>
                        </div>

                        <div class="input-field col s6 m3">
                          <select name="trackerType">
                              <option value="" disabled>Select type</option>
                              <option value="device" <?php if ($bus_details->tracker_type=='device') {echo 'selected'; }?> >Device</option>
                              <option value="mobile" <?php if ($bus_details->tracker_type=='mobile') {echo 'selected'; }?> >Mobile</option>
                            </select>
                            <label class="white-text">Tracker Type:</label>
                        </div>

                        <div class="input-field col s6 m4">
                            <select name="staffId">
                              <option value="">Select Driver</option>
                                <?php if ($resultstaff->num_rows > 0) {
                                    while($row = $resultstaff->fetch_assoc()) { ?>
                                    <option value="<?php echo $row['stid'];?>" <?php if($bus_details->stid==$row['stid']){ echo "selected"; } ?> ><?php echo $row["staff_name"]; ?></option>
                                <?php  } } ?>
                            </select>
                            <label class="white-text">Driver:</label>
                        </div>

                        <div class="input-field card-action">
                           <button class="btn waves-effect waves-light right" type="submit"><?php if ($_GET['token']=="prf3s765t7y3ww") {
                        echo "Update";
                      }else if($_GET['token']=="prf3s765addn398"){
                        echo "Add";
                      } ?>
                              <i class="material-icons right">send</i>
                            </button>
                        </div><br><br><br><br><br><br><br>

                      </form>
                      
                    </div>
                    
                  </div>
              </div>



<?php } else { ?>
<!-- ========================== All buss div ==================================== -->
      <div class="row">
            <div class="col s12 m12">
                <table class="centered bordered striped highlight z-depth-4">
                <thead>
                    <tr>
                        <th>Bus Number</th>
                        <th>Driver Name</th>
                        <th>Driver Mobile</th>
                        <th>Tracker Type</th>
                        <?php if ($login_cat == 1 || $pac['edit_transport']) { ?>
                        <th>Action</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                  <?php  foreach ($transportation_details as $trans) 
                      {   ?>
                    <tr>
                      <td>
                          <?php echo $trans->bus_number; ?>
                      </td>
                      <td>
                          <a style="color: black;" href="staffdetails.php?token=2ec9ys77io89s9&key=<?php echo "ae25nj5s3fr596dg@".$trans->stid; ?>">
                        <?php echo $trans->staff_name; ?>
                        </a>
                      </td>
                      <td>
                          <?php echo $trans->staff_mobile; ?>
                      </td>
                      <td>
                          <?php echo $trans->tracker_type; ?>
                      </td>
                      <?php if ($login_cat == 1 || $pac['edit_transport']) { ?>
                      <td>
                        <a  href="trackbusdetails.php?token=prf3s765tbusdw&key=<?php echo "ae25nJ5s3fr596dg@".$trans->bus_id; ?>&bn=<?php echo $trans->bus_number; ?>"> <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Bus route and stoppage" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons blue-text text-lighten-1">remove_red_eye</i></div></a>

                        <a  href="trackbusedit.php?token=prf3s765t7y3ww&key=<?php echo "ae25nJ5s3fr596dg@".$trans->bus_id; ?>"> <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>
                      </td>
                      <?php } ?>
                    </tr>
                    <?php } ?>
                </tbody>
                </table>
                
            </div>
      </div>


      <div class="fixed-action-btn">
        <a href="trackbusedit.php?token=prf3s765addn398" class="btn-floating btn-large red">
          <i class="large material-icons">add</i>
        </a>
      </div>
      <?php } ?>
        
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

  $("#update_bus_form").on('submit',(function(e) 
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
                if (data.trim() !== 'Bus Information succesfully updated'.trim()) { 
                  Materialize.toast(data, 4000, 'rounded');
                  $.ajax({
                    type: "post",
                    url: "../important/clearSuccess.php",
                    data: 'request=' + 'result_success',
                    success: function (data) {
                      //alert(data);
                    }
                  }); 
                } 
                else if (data.trim() === 'Bus Information succesfully updated'.trim()) {

                  window.location.href = 'trackbusedit.php';
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
