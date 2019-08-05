<?php
//for nsk and admin
   include('session.php');
   include('../config/sendbulksms.php');
   include("../important/backstage.php");

   $backstage = new back_stage_class();

 if($_SERVER["REQUEST_METHOD"] == "POST") { 
  $class_id=$_POST['class_id'];
  $section_id=$_POST['section_id'];

  $yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));
  $checkAttendaanceBulk= $backstage->check_attendance_bulk();
  
     $sc = 0;
     $pc = 0;
     
     $sqlalss1 = "SELECT * FROM `studentinfo` 
      LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
      WHERE `studentinfo`.`sclass`='$class_id' 
        AND `studentinfo`.`ssec`='$section_id' 
        AND `studentinfo`.`status`=0 
      ORDER BY `studentinfo`.`sroll` ASC";
      
     $resultalss1 = $db->query($sqlalss1);
     if ($resultalss1->num_rows > 0) { 


          // output data of each row
          while($row = $resultalss1->fetch_assoc()) { 
              $usid = $row["sid"];
              $myradio = mysqli_real_escape_string($db,$_POST["$usid"]);

              $sqlalss2 = "INSERT INTO `attendance` (`aid`, `asid`, `astatus`, `aschoolcode`, `aclass`, `asec`, `year_id`, `aclock`) VALUES (NULL, '$usid', '$myradio', '$login_session7', '$class_id', '$section_id', '$yearId', CURRENT_TIMESTAMP)";
              if(mysqli_query($db, $sqlalss2)) {

                  /*if($myradio == 'P')
                  {
                      $pc = $pc +1;
                  } else {*/


                    if($myradio == 'P')//added
                  {//added
                      $pc++;//added
                  } else if($myradio == 'A') {//added
                    $sc++;//added
                  
                  if ($checkAttendaanceBulk==1) {
                    if (strlen($row["spnumber"])>=10) {
                      $bulknumber = substr($row["spnumber"],-10);
                      
                      $bulkmessage="Your child ".$row["sname"]." is absent today for the class. -".$login_session2.", ".$login_session_a; //enter Your Message

                      $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
                    }
                  }

                      

                  }
                      
                  
                  /*$sc = $sc + 1;*/
              } else{ 
                  echo "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
              }
          }   //while close  
     } //if close

   /*if ($sc == $login_session11) {
       $ac = $login_session11 - $pc;*/


        $sql="INSERT INTO `abcheck` (`abid`, `abschoolcode`, `abclass`, `absec`, `abdate`, `abbit`, `abpcount`, `abacount`, `teacher_id`, `teacher_role`, `year_id`) VALUES (NULL, '$login_session7', '$class_id', '$section_id', CURRENT_TIMESTAMP, '1', '$pc', '$sc', '$login_session1', '$login_cat', '$yearId')";
        if(mysqli_query($db, $sql)) {
            ?> <script> alert('Attendance Submitted Successfully'); window.location.href = 'attendance.php?success'; </script> <?php
        } else {
            $success = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
            ?> <script> alert('Incomplete Procedure'); window.location.href = 'attendance.php?fail'; </script> <?php
        }
   /*} else {
       echo "not all student attendance submitted";
       ?> <script> alert('not all'); window.location.href = 'attendance.php?failnotall'; </script> <?php
   }*/ 
 }?>
