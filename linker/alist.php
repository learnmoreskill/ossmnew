<?php
//for nsk and admin
   include('session.php');
   require("../important/backstage.php");

   $backstage = new back_stage_class();

    $section_id = $_GET['section_id'];
    $class_id = $_GET['class_id'];

    $sqla1 = "SELECT * 
        FROM `studentinfo` 
        WHERE `sclass`='$class_id' 
            AND `ssec`='$section_id' 
            AND `studentinfo`.`status`= 0 
        ORDER BY `studentinfo`.`sroll` ASC";
        $resulta1 = $db->query($sqla1);
        if ($resulta1->num_rows > 0) { $found=1; }else{ $found=0; }

    $csname= json_decode($backstage->get_class_section_name_by_id($class_id,$section_id));
?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#"><?php echo "Start Attendance For Class ".$csname->class_name."-".$csname->section_name; ?> </a></div>
                    </div>
                </div>
            </div>

            <?php if ($found==1) {  ?>

            <div class="container"><br>
                <form id="student_attendance_form" >
                    <input type="hidden" name="student_attendance_submit_request" value="student">
                    <table class="centered bordered highlight z-depth-4">
                        <thead>
                            <tr>
                                <th>Roll No.</th>
                                <th>Name</th>
                                <th>Present</th>
                                <th>Absent</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                        // output data of each row
                        while($row = $resulta1->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php echo $row["sroll"];?>
                                </td>
                                <td>
                                    <?php echo $row["sname"];?>
                                </td>
                                <td>
                                    <input name="<?php echo $row["sid"];?>" type="radio" id="<?php echo $row["sid"]."p ";?>" value="P" checked required />
                                    <label for="<?php echo $row["sid"]."p ";?>"></label>
                                </td>
                                <td>
                                    <input name="<?php echo $row["sid"];?>" type="radio" id="<?php echo $row["sid"]."a ";?>" value="A" required />
                                    <label for="<?php echo $row["sid"]."a ";?>"></label>
                                </td>
                            </tr>
                            <?php 
                        } //while end
                        ?>
                        </tbody>
                    </table> <br>
                    <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                    <input type="hidden" name="section_id" value="<?php echo $section_id; ?>">

                    <div class="right">
                        <button class="btn waves-effect waves-light hoverable  blue lighten-2" type="submit" id="submitBtn" >Submit
                        <i class="material-icons right">send</i>
                      </button>
                      <div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
                    </div>
                </form>
            </div>

            <?php }else {  ?>
            <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">No student found for class: <?php echo $csname->class_name."-".$csname->section_name; ?></span></span>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>

        </main><br>


<?php include_once("../config/footer.php");?>

<script>
$(document).ready(function (e) 
{
  $("#student_attendance_form").on('submit',(function(e) 
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

                window.location.href = 'attendance.php?success';

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
