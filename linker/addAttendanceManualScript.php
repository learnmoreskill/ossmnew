<?php
//for admin and nsk
   include('session.php');

   $teacher_id = $login_session1;
   $role = $login_cat;

  if($_SERVER['REQUEST_METHOD']=='POST') {
    
    if (isset($_POST['update_attendance_hackster'])) {

        $class_id=$_POST["class_id"];
        $section_id=$_POST["section_id"];
        $exam_id=$_POST['exam_id'];

        $year_id=$_POST['year_id'];
        $month_id=$_POST["month_id"];

        $total_attendance=$_POST['total_attendance'];

        $rowno=$_POST['rowno'];
        $selectstd = $_POST['selectstd'];

        $attendance_id = $_POST['attendance_id'];

        $sid=$_POST['sid'];        

        $count=$_POST['count'];


        if (empty($month_id)) { $month_id = 0; }

        if ($rowno) {
          $checkAtLeast = 0;
          $count_final = 0;
          

          for ($i=0; $i < $rowno ; $i++) {

            $count_final = $count[$i].'/'.$total_attendance;

            if ($selectstd[$i] =="on" && empty($attendance_id[$i]) ) { $checkAtLeast = 1;
                  

                   $sqlmark1 = "INSERT INTO `attendance_manual` (`class_id`, `section_id`, `exam_id`, `student_id`, `count`, `year_id`, `month_id`, `role`, `teacher_id`, `clock`, `status`) VALUES ('$class_id', '$section_id', '$exam_id', '$sid[$i]', '$count_final', '$year_id', '$month_id','$role', '$teacher_id', CURRENT_TIMESTAMP, 1)";
                    
                    if(mysqli_query($db, $sqlmark1)) { 
                      $errMsg .= "Attendance succesfully added"; 
                    } 

                    else {  $errMsg .= "Sorry, Failed to add attendance - " . mysqli_error($db); }

            }else if ($selectstd[$i] =="on" && !empty($attendance_id[$i]) ) { $checkAtLeast = 1;

                 


                   $sqlupdate = "UPDATE `attendance_manual` SET `count` = '$count_final' WHERE `id` = '$attendance_id[$i]' ";
                    
                    if(mysqli_query($db, $sqlupdate)) { 
                      $errMsg .= "Attendance succesfully updated"; 
                    }
                    else {  $errMsg .= "Sorry, Failed to update attendance - " . mysqli_error($db); }

            }else if ($selectstd[$i] !="on" && !empty($attendance_id[$i])) {  $checkAtLeast = 1;

                   $sqldelete = "DELETE FROM `attendance_manual` WHERE `id` ='$attendance_id[$i]' ";
                    
                    if(mysqli_query($db, $sqldelete)) { 
                      $errMsg .= "Attendance succesfully updated"; 
                    } 

                    else {  $errMsg .= "Sorry, Failed to delete attendance - " . mysqli_error($db); }

            }else if ($selectstd[$i] !="on" && empty($attendance_id[$i]) ){

            }

          } 

          if ($checkAtLeast == 1) {  $msg = 'Attendance succesfully updated'; 
          }else{ $msg = 'Please add attendance.'; }

        }else{ $msg = "Empty input.."; }

      
    }else{
      $msg ="Invalid request";
    }
    $_SESSION['result_success']=$msg;
    echo $msg;
  }

?>