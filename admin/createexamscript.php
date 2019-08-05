<?php
   include('session.php');

   require("../important/backstage.php");
  $backstage = new back_stage_class();


    $cnyear = $cal['year'];
    $year_id = json_decode($backstage->get_academic_year_id_by_year($cnyear));

    if($_SERVER['REQUEST_METHOD']=='POST') {

      if (isset($_POST['create_exam'])) {


        $exam_id=$_POST['exam_id'];

        $month=$_POST['month'];

        $class_id=$_POST['class_id'];        
        $rowno=$_POST['create_exam'];

        $subject_id=$_POST['sub'];
        $exam_date=$_POST['examdate'];
        $exam_time=$_POST['examtime'];

        $selected = $_POST['selected'];

        $examtable_id = $_POST['examtable_id'];


        if ($rowno) {
          $checkAtLeast = 0;
           for ($i=0; $i < $rowno ; $i++) {

            if (!empty($exam_date[$i])) {             
               $newdate = $exam_date[$i];
               if($login_date_type==2){
                   $newdate = nToE($newdate);
               }
            }else{  $newdate = '';  }

            if (!empty($exam_time[$i])) {

              $time24 = date("H:i:s", strtotime($exam_time[$i]));

            }else{  $time24 = '';  }
             

              // ADD EXAM TABLE IF EXAMTABLE_ID IS NOT AVAILABLE 
              if ($selected[$i] =="on" && empty($examtable_id[$i])) {             
              
                $checkAtLeast = 1;

                $sql = "INSERT INTO `examtable` (`class_name`, `exam_type`, `subject`, `date`, `time`, `year_id`, `month`, `exam_created_on`) VALUES ('$class_id', '$exam_id', '$subject_id[$i]', ". (($newdate=='')?"NULL":("'".$newdate."'")) . ", ". (($time24=='')?"NULL":("'".$time24."'")) . ", '$year_id', '$month', CURRENT_TIMESTAMP)";
                  
                  if(mysqli_query($db, $sql)) {

                      $errMsg .= "Exam table succesfully added";

                  } else { $errMsg .= "Sorry, Could not able to create exam - " . mysqli_error($db);  }

              // UPDATE EXAM TABLE IF EXAMTABLE_ID IS AVAILABLE
              }else if($selected[$i] =="on" && !empty($examtable_id[$i])){ 

                $checkAtLeast = 1;

                $sql = "UPDATE `examtable` SET `date`=". (($newdate=='')?"NULL":("'".$newdate."'")) . ",`time`=". (($time24=='')?"NULL":("'".$time24."'")) . " WHERE `examtable_id` = '$examtable_id[$i]' ";
                  
                  if(mysqli_query($db, $sql)) {

                      $errMsg .= "Exam table succesfully updated";

                  } else { $errMsg .= "Sorry, Could not able to create exam - " . mysqli_error($db);  }
              
              // DELETE EXAM TABLE IF EXAMTABLE_ID IS AVAILABLE AND NOT SELECTED
              }else if($selected[$i] != "on" && !empty($examtable_id[$i])){

                $checkAtLeast = 1;

                $sqldelete = "DELETE FROM `examtable` WHERE `examtable_id` ='$examtable_id[$i]' ";
                    
                    if(mysqli_query($db, $sqldelete)) {

                      $errMsg .= "Exam table succesfully deleted";

                    }else {  $errMsg .= "Sorry, Failed to delete marks - " . mysqli_error($db); }
              }

          }
          if ($checkAtLeast == 1) {  $msg = 'Exam table succesfully updated'; 
          }else{ $msg = 'Please select exam.'; }
        }else{  $msg = 'Empty input'; }

        $_SESSION['result_success'] = $msg;
        echo $msg;
          
      }

    }

?>