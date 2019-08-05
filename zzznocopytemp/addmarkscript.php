<?php
//for admin and nsk
   include('session.php');

   $teacher_id = $login_session1;
   $role = $login_cat;

  if($_SERVER['REQUEST_METHOD']=='POST') {

    if (isset($_POST['add_mark_studentwise'])) {

            $class_id=$_POST["class_id"];
            $section_id=$_POST["section_id"];
            $exam_id=$_POST['examid'];

            $yearid=$_POST['yearid'];
            $month_id=$_POST["month_id"];

            $rowno=$_POST['rowno'];
            $selectsub = $_POST['selectsub'];

            
            $stud_id=$_POST['studentid'];

            $subject_id=$_POST['sub'];

            $obtained=$_POST['obtained'];
            $theoretical=$_POST['theoretical'];
            $practical=$_POST['practical'];
            $subject_type=$_POST['subject_type'];

            if (!empty($exam_id)) {
              if (!empty($stud_id)) {
                if (!empty($subject_id)) {

            if (empty($month_id)) { $month_id = 0; }

            if (!($exam_id == 5 || $exam_id == 6)){
              $month_id = 0;
            }


            if ($rowno) {

              for ($i=0; $i < $rowno ; $i++) {

                if ($selectsub[$i] =="on") {
                  
                  $sqlcheck="SELECT `marksheet_id` 
                  FROM `marksheet` 
                  WHERE `mexam_id`='$exam_id' 
                    AND `year_id`='$yearid' 
                    AND `month` = '$month_id' 
                    AND `mstudent_id`='$stud_id' 
                    AND `marksheet_class`='$class_id' 
                    AND `msubject_id`='$subject_id[$i]'";
                     $resultcheck=mysqli_query($db, $sqlcheck);
                     $count=mysqli_num_rows($resultcheck);
                     if($count<1){

                      if ($subject_type[$i]=='1') {
                        $obtained_mark = $theoretical[$i]+$practical[$i];
                      }else if($subject_type[$i]=='0' || $subject_type[$i]=='3'){
                        $obtained_mark = $obtained[$i];
                      }


                       $sqlmark1 = "INSERT INTO `marksheet` (`marksheet_class`, `marksheet_section`, `mexam_id`, `mstudent_id`, `msubject_id`, `m_theory`, `m_practical`, `m_obtained_mark`, `year_id`, `month`, `role`, `teacher_id`, `m_date`, `marksheet_status`) VALUES ('$class_id', '$section_id', '$exam_id', '$stud_id', '$subject_id[$i]', '$theoretical[$i]', '$practical[$i]', '$obtained_mark', '$yearid', '$month_id','$role', '$teacher_id', CURRENT_TIMESTAMP, 1)";
                        
                        if(mysqli_query($db, $sqlmark1)) { $msg = "Mark succesfully added"; } 

                        else {  $msg = "Sorry, Failed to add mark - " . mysqli_error($db); }

                  }else{ if($login_cat==1){ $msg = "Mark already added"; }else if($login_cat==2){ $msg = "Mark already added, Please contact admin for any modification."; } }


                }


              }

            }else{$msg = "Empty input..";}

            }else{$msg = "subject is not selected..";}
            }else{$msg = "Please select student..";}
            }else{$msg = "Please select exam..";}

          $_SESSION['result_success']=$msg;
          echo $msg;


    }elseif (isset($_POST['add_mark_subjectwise'])) {

        $class_id=$_POST["class_id"];
        $section_id=$_POST["section_id"];
        $exam_id=$_POST['examid'];
        $month_id=$_POST["month_id"];

        $subject_type=$_POST['subject_type'];

        $rowno=$_POST['rowno'];
        $selectstd = $_POST['selectstd'];

        $subject_id=$_POST['subject_id'];

        $sid=$_POST['sid'];        

        $obtained=$_POST['obtained'];
        $theoretical=$_POST['theoretical'];
        $practical=$_POST['practical'];

        $yearid=$_POST['yearid'];

        if (empty($month_id)) { $month_id = 0; }

        if ($rowno) {
          

          for ($i=0; $i < $rowno ; $i++) {

            if ($selectstd[$i] =="on") {

                  if ($subject_type=='1') {
                    $obtained_mark = $theoretical[$i]+$practical[$i];

                  }else if($subject_type=='0' || $subject_type=='3'){
                    $obtained_mark = $obtained[$i];
                  }

                   $sqlmark1 = "INSERT INTO `marksheet` (`marksheet_class`, `marksheet_section`, `mexam_id`, `mstudent_id`, `msubject_id`, `m_theory`, `m_practical`, `m_obtained_mark`, `year_id`, `month`, `role`, `teacher_id`, `m_date`, `marksheet_status`) VALUES ('$class_id', '$section_id', '$exam_id', '$sid[$i]', '$subject_id', '$theoretical[$i]', '$practical[$i]', '$obtained_mark', '$yearid', '$month_id','$role', '$teacher_id', CURRENT_TIMESTAMP, 1)";
                    
                    if(mysqli_query($db, $sqlmark1)) { 
                      $msg = "Mark succesfully added"; 
                    } 

                    else {  $msg = "Sorry, Failed to add marks - " . mysqli_error($db); }

            } //end of selected student

          } 

        }else{ $msg = "Empty input.."; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }elseif (isset($_POST['update_marks_subjectwise'])) {

        $class_id=$_POST["class_id"];
        $section_id=$_POST["section_id"];
        $exam_id=$_POST['exam_id'];
        $month_id=$_POST["month_id"];

        $subject_type=$_POST['subject_type'];

        $rowno=$_POST['rowno'];
        $selectstd = $_POST['selectstd'];

        $subject_id=$_POST['subject_id'];

        $sid=$_POST['sid'];        

        $obtained=$_POST['obtained'];
        $theoretical=$_POST['theoretical'];
        $practical=$_POST['practical'];

        $yearid=$_POST['yearid'];

        if (empty($month_id)) { $month_id = 0; }

        if ($rowno) {
          

          for ($i=0; $i < $rowno ; $i++) {

            if ($selectstd[$i] =="on") {

                  if ($subject_type=='1') {
                    $obtained_mark = $theoretical[$i]+$practical[$i];

                  }else if($subject_type=='0' || $subject_type=='3'){
                    $obtained_mark = $obtained[$i];
                  }

                   $sqlmark1 = "INSERT INTO `marksheet` (`marksheet_class`, `marksheet_section`, `mexam_id`, `mstudent_id`, `msubject_id`, `m_theory`, `m_practical`, `m_obtained_mark`, `year_id`, `month`, `role`, `teacher_id`, `m_date`, `marksheet_status`) VALUES ('$class_id', '$section_id', '$exam_id', '$sid[$i]', '$subject_id', '$theoretical[$i]', '$practical[$i]', '$obtained_mark', '$yearid', '$month_id','$role', '$teacher_id', CURRENT_TIMESTAMP, 1)";
                    
                    if(mysqli_query($db, $sqlmark1)) { 
                      $msg = "Marks succesfully updated"; 
                    } 

                    else {  $msg = "Sorry, Failed to add marks - " . mysqli_error($db); }

            } //end of selected student

          } 

        }else{ $msg = "Empty input.."; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }
  }

?>