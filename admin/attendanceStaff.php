<?php
//admin and authorised person
   include('session.php');
   require("../important/backstage.php");
   $backstage = new back_stage_class();


   if (isset($_GET["attendanceFor"]) && $_GET["attendanceFor"] == 'teacher'){
    $_SESSION['navactive'] = 'teacher_attendance';
    $attendaceFor = 'teacher';

    $checkAttendance = $backstage->check_teacher_attendance_done_by_date($login_today_edate);

    if (!$checkAttendance) {
      

        $userList = json_decode($backstage->get_active_teacher_list());

        $rowcount = count((array)$userList);

        if ($rowcount > 0) { $found=1; }else{ $found=0; }

    }

   }else if(isset($_GET["attendanceFor"]) && $_GET["attendanceFor"] == 'staff'){
    $_SESSION['navactive'] = 'staff_attendance';
    $attendaceFor = 'staff';

    $checkAttendance = $backstage->check_staff_attendance_done_by_date($login_today_edate);

    if (!$checkAttendance) {
      

        $userList = json_decode($backstage->get_active_staff_list());

        $rowcount = count((array)$userList);

        if ($rowcount > 0) { $found=1; }else{ $found=0; }

    }

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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Start Attendance For 
                        <?php echo (($attendaceFor == 'teacher')? "Teacher" : (($attendaceFor == 'staff')? "Staff" : "" ) ); ?> </a></div>
                    </div>
                </div>
            </div>
            <div class="container"><br>

            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">View Previous Report By Date</span></span>
                            <form id="attendanceForm" method="get" action="attendanceView.php">
                                <input type="hidden" name="type" value="<?php echo $attendaceFor; ?>" >
                                <div class="input-field col s10">
                                  <input type="text" id="date" 
                                  class="<?php if($login_date_type==1){
                                      echo 'datepicker1';
                                    }else if($login_date_type==2){
                                      echo 'bod-picker';
                                    }else{
                                      echo 'datepicker1';
                                    } ?>" 
                                    name="attendance_by_date" placeholder="Select date" >
                                  <label>Enter Date</label>
                                </div>
                                <button id="findBtn" class="btn waves-effect waves-light blue lighten-2" type="submit">Find</button>
                            </form>
                        </div><br>
                    </div>
                </div>
            </div>
            <?php 
            if ($checkAttendance) { ?>

                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey darken-3">
                            <div class="card-content white-text flow-text">
                                <span class="card-title flow-text"><span style="color:#008ee6;">Today's Attendance</span></span>

                                <form id="attendanceForm" method="get" action="attendanceView.php">
                                    <input type="hidden" name="type" value="<?php echo $attendaceFor; ?>">
                                    <input type="hidden" name="today" value="today">
                                    <div>The attendace has already been taken for <?php echo $attendaceFor; ?>(s). You can click the below button to view today's <?php echo $attendaceFor; ?>(s) strength.</div>
                                    <button id="btnSubmit" class="btn waves-effect waves-light blue lighten-2" type="submit">View</button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>

            <?php 
            }else{

            if ($found == 1) {  ?>

                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey darken-3">
                            <div class="card-content white-text flow-text">
                                <span class="card-title flow-text">Hello, Ready for the attendance</span>
                            </div><br>
                        </div>
                    </div>
                </div>

            
                <form  id="teacher_attendance_form" >
                    <input type="hidden" name="staff_attendance_submit_request" value="<?php echo $attendaceFor; ?>">
                    <table class="centered bordered highlight z-depth-4">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Late</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        // output data of each row
                        foreach ($userList as $userRow) { ?>
                            <tr>
                                <td>
                                    <?php echo $userRow->name; ?>
                                </td>
                                <td>
                                    <?php echo $userRow->mobile; ?>
                                </td>
                                <td>
                                    <input name="<?php echo $userRow->id; ?>" type="radio" id="<?php echo $userRow->id."p" ;?>" value="P" checked required />
                                    <label for="<?php echo $userRow->id."p" ;?>"></label>
                                </td>
                                <td>
                                    <input name="<?php echo $userRow->id; ?>" type="radio" id="<?php echo $userRow->id."a" ;?>" value="A" required />
                                    <label for="<?php echo $userRow->id."a" ;?>"></label>
                                </td>
                                <td>
                                    <input name="<?php echo $userRow->id; ?>" type="radio" id="<?php echo $userRow->id."l" ;?>" value="L" required />
                                    <label for="<?php echo $userRow->id."l" ;?>"></label>
                                </td>
                            </tr>
                            <?php 
                        }
                        ?>
                        </tbody>
                    </table> <br>

                    <div class="right">
                        <button class="btn waves-effect waves-light hoverable  blue lighten-2" type="submit" id="submitBtn" >Submit
                        <i class="material-icons right">send</i>
                      </button>
                      <div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
                    </div>
                        
                </form>
            

            <?php }else {  ?>

            <div class="row">
                <div class="col s12 ">
                    <div class="card grey darken-3">
                        <div class="card-content center white-text">
                            <span class="card-title"><span style="color:#80ceff;">No active <?php echo $attendaceFor; ?> found</span></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>

            <?php } 
        }   ?>

        </main><br>


<?php include_once("../config/footer.php");?>


<script>
$(document).ready(function (e) 
{
  $("#teacher_attendance_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "attendanceSubmitScript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#submitBtn").hide();
            $("#loadingBtn").show();
          },
          success: function(data)
          {
            var result = JSON.parse(data);

            if (result.status == 200) {

                alert('Attendance Submitted Successfully');

                window.location.href = "attendanceView.php?type=<?php echo $attendaceFor; ?>&today=today";

            }else{
              alert(result.errormsg);
            }

            $("#submitBtn").show();
            $("#loadingBtn").hide();

          },
          error: function(e) 
          {
            $("#submitBtn").show();
            $("#loadingBtn").hide();
            alert('Try Again !!');
          }          
    });
  }));
  
});

</script>
