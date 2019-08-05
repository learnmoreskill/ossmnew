<?php
   include('session.php');
   require("../important/backstage.php");
   $backstage = new back_stage_class();

   $medium_list = json_decode($backstage->get_medium_list());
   $block_list = json_decode($backstage->get_block_list());

   $newdate = date("Y-m-d");

   if (isset($_GET["token"]) && isset($_GET["class_id"])){
            $longid1 = ($_GET["token"]);

            if ($longid1=="tyughjo56") {
              $class_id=$_GET["class_id"];
              $class_name=$_GET["class_name"];

             $sqlclassdetails = $db->query("SELECT * FROM `class` 
              WHERE `class_id`='$class_id' AND `class`.`status`= 0 
              ORDER BY `class`.`class_id` ASC ");
              if($sqlclassdetails->num_rows)
            {
              $rowsEdit = $sqlclassdetails->fetch_assoc();
              extract($rowsEdit);
            }else{
                $_GET['token']="";
                 }
            $sectionlist = $db->query("SELECT `section_id`, `section_name`, `room_no`, `teacher_id`, `tname`, `sname`, `student_id`, `medium`.* , `block`.* FROM `section` 
              LEFT JOIN `teachers` ON `section`.`teacher_id` = `teachers`.`tid` 
              LEFT JOIN `studentinfo` ON `section`.`student_id` = `studentinfo`.`sid` 
              LEFT JOIN `block` ON `section`.`block_id` = `block`.`block_id` 
              LEFT JOIN `medium` ON `section`.`medium` = `medium`.`medium_id` 
              WHERE `section_class`='$class_id' AND `section`.`status`= 0 
              ORDER BY `section`.`section_name` ASC ");


            $sqlteacher = "SELECT * FROM `teachers` WHERE `status`=0";
            $resultteacher = $db->query($sqlteacher);
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
                    <div class="row center"><a class="white-text text-lighten-4" href="#">Details Of Class <?php echo $class_name; ?> </a></div>
                </div>
            </div>
        </div>
  <?php if($login_cat==1){ ?>
      <div class="row">
          <div class="col s12 m5">
              <div class="row ">
                  <div class="card blue-grey">
                    <div class="card-content white-text">
                      <span class="card-title">Class details</span>

                      <span class="white-text">
                        <?php echo ((!empty($class_name))? "Class Name : ".$class_name : "").((!empty($class_symbolic))? " , Numeric Name : ".$class_symbolic : "");?></span><br>

                      <span class="white-text">Total students:<?php $studentcountinclass = $backstage->get_student_count_in_class($class_id);
                     echo $studentcountinclass;?></span>

                     <span class="white-text">Present:<?php $presentinclass = $backstage->get_present_count_in_class($class_id,$newdate);
                     if($presentinclass){echo $presentinclass;}else{echo 0;}?></span>&nbsp&nbsp

                     <span class="black-text">Absent:<?php $absentinclass = $backstage->get_absent_count_in_class($class_id,$newdate);
                     if($absentinclass){echo $absentinclass;}else{echo 0;} ?></span>
                    </div>
                    
                  </div>
              </div>
              <div class="row ">
                  <div class="card blue-grey">
                    <div class="card-content white-text">
                      <span class="card-title">Add section</span>
                      <form id="update_class_section_form" action="updatescript.php" method="post" >

                        <input type="hidden" name="update_class_section" value="<?php echo $class_id; ?>">
                          
                          <div class="input-field">
                            <input name="new_section" id="new_section" type="text" placeholder="e.g. A" class="validate" required>
                            <label for="new_section">Section Name*</label>
                          </div>
                          <div class="input-field">
                            <input name="new_room" id="new_room" type="text" placeholder="e.g. 207" >
                            <label for="new_room">Room No</label>
                          </div>
                          <div class="input-field">
                            <select name="addblock" id="addblock">
                                <option value="" >Select Block</option>
                                  <?php 
                                  foreach ($block_list as $blockList) {
                                      echo '<option value="'.$blockList->block_id.'"> ' . $blockList->block_name. ' </option>';

                                  }
                                  ?>
                            </select><label>Select Block</label>
                          </div>
                          <div class="input-field">
                            <select name="addmedium" id="addmedium">
                                <option value="" >Select Medium</option>
                                  <?php 
                                  foreach ($medium_list as $mediumList) {
                                      echo '<option value="'.$mediumList->medium_id.'"> ' . $mediumList->medium_name. ' </option>';

                                  }
                                  ?>
                            </select><label>Select medium</label>
                          </div>

                          <div class="input-field card-action">
                             <button class="btn waves-effect waves-light right" type="submit">Update
                                <i class="material-icons right">send</i>
                              </button>
                            </div>

                      </form>
                      
                    </div><br>
                    
                  </div>
              </div>
          </div>
            <div class="col s12 m7">
                <table class="centered bordered striped highlight z-depth-4">
                <thead>
                    <tr>
                        <th>Fee Category</th>
                        <th>Rupees</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Admission Charge Fee</td>
                        <td><?php echo $admission_charge; ?></td>
                    </tr>
                    <tr>
                        <td>Registration Fee</td>
                        <td><?php echo $registration_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Security Fee</td>
                        <td><?php echo $security_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Monthly Tution Fee</td>
                        <td><?php echo $tution_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Annual Fee</td>
                        <td><?php echo $annual_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Computer Fee</td>
                        <td><?php echo $computer_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Hostel Fee</td>
                        <td><?php echo $hostel_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Exam Fee</td>
                        <td><?php echo $exam_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Monthly Test Fee</td>
                        <td><?php echo $monthly_testfee; ?></td>
                    </tr>
                    <tr>
                        <td>Uniform Fee</td>
                        <td><?php echo $uniform_fee; ?></td>
                    </tr>
                    <tr>
                        <td>Book Fee</td>
                        <td><?php echo $book_fee; ?></td>
                    </tr>
                </tbody>
                </table>
            </div>
      </div>
    <?php } ?>
      <div class="row">
          <div class="col s12 m12">

            <?php mysqli_data_seek($sectionlist, 0);
            $i = 0; $j=$sectionlist->num_rows;
            while($row1 = $sectionlist->fetch_assoc()) { ?>


              
              <div class="col s12 <?php if (($j & 1) && ($i == $j - 1)){ echo "m12"; }else{ echo "m6"; } ?>">
                <div class="card blue-grey" style="height: 250px">
                  <div class="card-content white-text">
                    <span class="card-title center">Section : <?php echo $row1["section_name"]; if (!empty($row1["medium_name"])) { echo "( ".$row1["medium_name"]." )";  } ?></span>
                    <span class="white-text">Total students : <?php $studentcountinclass = $backstage->get_student_count_in_class_section($class_id,$row1["section_id"]);
                     echo $studentcountinclass;
                     $attendance_taken = $backstage->get_check_attendance_taken($class_id,$row1["section_id"],$newdate);
                     if($attendance_taken){ ?>

                         <span style="color: #86ff86">&nbsp&nbsp&nbsp&nbsp Present : <?php $presentinclass = $backstage->get_present_count_in_class_section($class_id,$row1["section_id"],$newdate); 
                         if($presentinclass){echo $presentinclass;}else{echo "0";}?> </span>

                         <span style="color: black">&nbsp&nbsp&nbsp&nbsp Absent : <?php $absentinclass = $backstage->get_absent_count_in_class_section($class_id,$row1["section_id"],$newdate);
                         if($absentinclass){echo $absentinclass;}else{echo "0";} ?> </span>

                    <?php }else{ echo "&nbsp&nbsp&nbsp&nbsp Attendance has not been taken today."; }
                     echo "<br/> Class Teacher : ".($row1["tname"] ? $row1["tname"] : 'Not set');
                     echo "<br/> Class Representative : ".($row1["sname"] ? $row1["sname"] : 'Not set');
                     echo ($row1["room_no"] ? '<br/> Room No : '.$row1["room_no"] : '');
                     echo ($row1["block_name"] ? '&nbsp&nbsp&nbsp Block : '.$row1["block_name"] : ''); ?>
                       
                     </span><br>
                  </div>
                  <div class="card-action">
                    <a href="alistview.php?extraudp&extraclass=<?php echo $class_id; ?>&extrasec=<?php echo $row1["section_id"]; ?>&extradate=<?php echo (($login_date_type==2)? eToN($newdate) : $newdate); ?>" class="tooltipped" data-position="top" data-tooltip="Attendance details">
                      <i class="small material-icons">insert_chart</i>
                    </a>
                    <!-- <a href="#">
                      <i class="small material-icons">edit</i>
                    </a> -->
                    <input type="hidden" id="teacher<?php echo $row1["section_id"]; ?>" value="<?php echo $row1["teacher_id"];?>">
                    <input type="hidden" id="student<?php echo $row1["section_id"]; ?>" value="<?php echo $row1["student_id"];?>">
                    <input type="hidden" id="medium<?php echo $row1["section_id"]; ?>" value="<?php echo $row1["medium_id"];?>">
                    <input type="hidden" id="block<?php echo $row1["section_id"]; ?>" value="<?php echo $row1["block_id"];?>">
                    <input type="hidden" id="room<?php echo $row1["section_id"]; ?>" value="<?php echo $row1["room_no"];?>">
                    <input type="hidden" id="section<?php echo $row1["section_id"]; ?>" value="<?php echo $row1["section_name"];?>">

                    <?php 
                    if ($login_cat==1) { ?>   

                      <a  id="<?php echo $row1["section_id"]; ?>" onClick="set_variable(this.id)" href="#model_update_section" class="modal-trigger tooltipped" data-position="top" data-tooltip="Update section name, class teacher and CR" >
                        <i class="material-icons green-text text-lighten-1">border_color</i>
                      </a>

                      <?php 
                    } ?>

                  </div>
                  
                </div>
              </div>

            <?php $i++; } ?>

            </div>
      </div>


<script type="text/javascript">
    function set_variable(obj)
    {

      document.getElementById("update_section_teacher_student").value=obj;

      var teacherid=document.getElementById("teacher"+obj).value;
      var studentid=document.getElementById("student"+obj).value;
      var medium_id=document.getElementById("medium"+obj).value;
      var block_id=document.getElementById("block"+obj).value;
      var room_no=document.getElementById("room"+obj).value;
      var sectionname = document.getElementById("section"+obj).value;

      document.getElementById("section_nameNew").value = sectionname;

      document.getElementById("room_noNew").value = room_no;

      var class_id = "<?php echo $class_id; ?>";

      
      
      
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#teacher_id");
                document.getElementById("teacher_id").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            }
        };
        xmlhttp.open("GET","getstudent.php?teacher_id="+teacherid,true);
        xmlhttp.send();
        $('select').on('contentChanged', function() { 
        // re-initialize 
       $(this).material_select();
         });



        if (window.XMLHttpRequest) {  xmlhttp1 = new XMLHttpRequest();
        } else {  xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");  }
        xmlhttp1.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#student_id");
                document.getElementById("student_id").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            } };
        xmlhttp1.open("GET","getstudent.php?classname="+class_id+"&sectionname="+obj+"&studentid="+studentid,true);
        xmlhttp1.send();
        $('select').on('contentChanged', function() {
       $(this).material_select();
         });


        if (window.XMLHttpRequest) {  xmlhttp2 = new XMLHttpRequest();
        } else {  xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");  }
        xmlhttp2.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#medium_id");
                document.getElementById("medium_id").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            } };
        xmlhttp2.open("GET","getstudent.php?medium_id="+medium_id,true);
        xmlhttp2.send();
        $('select').on('contentChanged', function() { 
       $(this).material_select();
         });


        if (window.XMLHttpRequest) {  xmlhttp3 = new XMLHttpRequest();
        } else {  xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");  }
        xmlhttp3.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#block_id");
                document.getElementById("block_id").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            } };
        xmlhttp3.open("GET","getstudent.php?block_id="+block_id,true);
        xmlhttp3.send();
        $('select').on('contentChanged', function() { 
       $(this).material_select();
         });

       
    }
</script>

   <!-- Modal Structure -->
  <div id="modal_edit_class" class="modal">
    <div class="modal-content">
      <form id="update_class_form" action="updatescript.php" method="post" >
        <h6 align="center">Edit Class Details</h6>
        <div class="divider"></div>
        <div class="row">
            <div class="col s2">
                <h6 style="padding-top: 20px">Class Name</h6>
            </div>
            <div class="input-field col s3">
              <input name="newclassname" id="newclassname" type="text" value="<?php echo $class_name; ?>"  placeholder="e.g. Five" required >
            </div>
            <div class="col s2">
                <h6 style="padding-top: 20px">Class In Numeric</h6>
            </div>
            <div class="input-field col s3">
              <input name="numeric_name" id="numeric_name" type="number" value="<?php echo $class_symbolic; ?>" placeholder="e.g. 5" required >
            </div>
        </div>
        <div class="row">
            <div class="col s2">
                <h6 style="padding-top: 20px">Admission Charge</h6>
            </div>
            <div class="input-field col s8">
              <input name="classadmission" id="classadmission" type="text" value="<?php echo $admission_charge; ?>" required >
            </div>
        </div>
        <div class="row">
            <div class="col s2">
                <h6 style="padding-top: 20px">Registration Fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="registration_fee" id="registration_fee" type="text" value="<?php echo $registration_fee; ?>" required>
            </div>
            <div class="col s2">
                <h6 style="padding-top: 20px">Security Fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="security_fee" id="security_fee" type="text" value="<?php echo $security_fee; ?>" >
            </div>
        </div>
        <div class="row">
            <div class="col s2">
                <h6 style="padding-top: 20px">Monthly Tution Fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="monthy_tution_fee" id="monthy_tution_fee" type="text" value="<?php echo $tution_fee; ?>" required>
            </div>
            <div class="col s2">
                <h6 style="padding-top: 20px">Annual Fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="annual_fee" id="annual_fee" type="text" value="<?php echo $annual_fee; ?>" >
            </div>
        </div>
        <div class="row">
            <div class="col s2">
                <h6 style="padding-top: 20px">Computer Fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="computer_fee" id="computer_fee" type="text" value="<?php echo $computer_fee; ?>">
            </div>
            <div class="col s2">
                <h6 style="padding-top: 20px">Hostel fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="hostel_fee" id="hostel_fee" type="text" value="<?php echo $hostel_fee; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col s2">
                <h6 style="padding-top: 20px">Exam Fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="exam_fee" id="exam_fee" type="text" value="<?php echo $exam_fee; ?>">
            </div>
            <div class="col s2">
                <h6 style="padding-top: 20px">Monthly test fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="monthly_test_fee" id="monthly_test_fee" type="text" value="<?php echo $monthly_testfee; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col s2">
                <h6 style="padding-top: 20px">Uniform fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="uniform_fee" id="uniform_fee" type="text" value="<?php echo $uniform_fee; ?>">
            </div>
            <div class="col s2">
                <h6 style="padding-top: 20px">Book fee</h6>
            </div>
            <div class="input-field col s3">
              <input name="book_fee" id="book_fee" type="text" value="<?php echo $book_fee; ?>">
            </div>
        </div>
        
        <input type="hidden" name="update_class_fee_id" value="<?php echo $class_id; ?>">
    <div class="modal-footer">
      <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit">Update<i class="material-icons right">send</i></button>
    </div>

    </form>
    </div>
  </div> 





  <!-- Modal Structure -->
  <div id="model_update_section" class="modal" style="overflow: visible;">
    <div class="modal-content">
      <form id="update_section_teacher_student_form" action="updatescript.php" method="post" >
        <h6 align="center">Update Section</h6>
        <div class="divider"></div>
        <div class="row">
            <div class="col s6 m2">
                <h6 style="padding-top: 20px">Section Name</h6>
            </div>
            <div class="input-field col s6 m4">
              <input name="section_nameNew" id="section_nameNew" type="text" placeholder="e.g. A" required >
            </div>
            <div class="col s6 m2">
                <h6 style="padding-top: 20px">Medium</h6>
            </div>
            <div class="input-field col s6 m4">
              <select name="medium_id" id="medium_id" class="customSelectDrop">
                </select>
            </div>
        </div>
        <div class="row">
            <div class="col s6 m2">
                <h6 style="padding-top: 20px">Room No</h6>
            </div>
            <div class="input-field col s6 m4">
              <input name="room_noNew" id="room_noNew" type="text" placeholder="e.g. 207" >
            </div>
            <div class="col s6 m2">
                <h6 style="padding-top: 20px">Block</h6>
            </div>
            <div class="input-field col s6 m4">
              <select name="block_id" id="block_id" class="customSelectDrop">
                </select>
            </div>
            
        </div>
        <div class="row">
            <div class="col s6 m2">
                <h6 style="padding-top: 20px">Class Teacher</h6>
            </div>

            <div class="input-field col s6 m4">
                <select name="teacher_id" id="teacher_id" class="customSelectDrop">
                </select>


            </div>
            <div class="col s6 m2">
                <h6 style="padding-top: 20px">C.R.</h6>
            </div>
            <div class="input-field col s6 m4">
              <select name="student_id" id="student_id" class="customSelectDrop">
                </select>
            </div>
        </div>

        <input type="hidden" name="update_section_teacher_student" id="update_section_teacher_student" value="">
    <div class="modal-footer">
      <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit">Update<i class="material-icons right">send</i></button>
    </div>

    </form>
    </div>
  </div>


    <?php if($login_cat==1){ ?>
    <div class="fixed-action-btn">
        <a href="#modal_edit_class" class="modal-trigger btn-floating btn-large red">
          <i class="large material-icons">edit</i>
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

  $("#update_class_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Class updated successfully'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            }else if (data.trim() === 'Class updated successfully'.trim()) {
                $('#modal_edit_class').modal('close');
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  $("#update_class_section_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Section updated successfully'.trim()) {
              Materialize.toast(data, 4000, 'rounded');
              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            }else if (data.trim() === 'Section updated successfully'.trim()) {
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));

  $("#update_section_teacher_student_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Updated successfully'.trim()) {
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
              if (data.trim() === 'Updated successfully'.trim()) {
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
