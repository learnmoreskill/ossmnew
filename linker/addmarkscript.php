<?php
//for admin and nsk
   include('session.php');

   $teacher_id = $login_session1;
   $role = $login_cat;

  if($_SERVER['REQUEST_METHOD']=='POST') {

    if (isset($_POST['add_mark_subjectwise'])) { //to be removed but first check

        $class_id = $_POST["class_id"];
        $section_id = $_POST["section_id"];
        $exam_id = $_POST['examid'];
        $month_id = $_POST["month_id"];

        $subject_type = $_POST['subject_type'];

        $rowno = $_POST['rowno'];
        $selectstd = $_POST['selectstd'];

        $subject_id = $_POST['subject_id'];

        $sid = $_POST['sid'];        

        $obtained = $_POST['obtained'];
        $theoretical = $_POST['theoretical'];
        $practical = $_POST['practical'];

        $yearid = $_POST['yearid'];

        if (empty($month_id)) { $month_id = 0; }

        if ($rowno) {
          

          for ($i=0; $i < $rowno ; $i++) {
            $theory_final = $practical_final = $obtained_final = '';

            if ($selectstd[$i] =="on") {

                  if ($subject_type=='1') {

                    $theory_final = $theoretical[$i];
                    $practical_final = $practical[$i];
                    $obtained_final = $theoretical[$i]+$practical[$i];


                  }else if($subject_type=='0' || $subject_type=='3'){

                    $theory_final = $theoretical[$i];
                    $practical_final = '';
                    $obtained_final = $theoretical[$i];
                  }

                   $sqlmark1 = "INSERT INTO `marksheet` (`marksheet_class`, `marksheet_section`, `mexam_id`, `mstudent_id`, `msubject_id`, `m_theory`, `m_practical`, `m_obtained_mark`, `year_id`, `month`, `role`, `teacher_id`, `m_date`, `marksheet_status`) VALUES ('$class_id', '$section_id', '$exam_id', '$sid[$i]', '$subject_id', '$theory_final', '$practical_final', '$obtained_final', '$yearid', '$month_id','$role', '$teacher_id', CURRENT_TIMESTAMP, 1)";
                    
                    if(mysqli_query($db, $sqlmark1)) { 
                      $msg = "Mark succesfully added"; 
                    } 

                    else {  $msg = "Sorry, Failed to add marks - " . mysqli_error($db); }

            } //end of selected student

          } 

        }else{ $msg = "Empty input.."; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }elseif (isset($_POST['update_marks_hackster'])) {

        $class_id=$_POST["class_id"];
        $section_id=$_POST["section_id"];
        $exam_id=$_POST['exam_id'];

        $year_id=$_POST['year_id'];
        $month_id=$_POST["month_id"];

        $subject_id=$_POST['subject_id'];
        $subject_type=$_POST['subject_type'];

        $rowno=$_POST['rowno'];
        $selectstd = $_POST['selectstd'];

        $marksheet_id = $_POST['marksheet_id'];

        $sid=$_POST['sid'];        

        $theoretical=$_POST['theoretical'];
        $practical=$_POST['practical'];

        $mt1=$_POST['mt'];
        $ot1=$_POST['ot'];
        $eca1=$_POST['eca'];
        $lp1=$_POST['lp'];
        $nb1=$_POST['nb'];
        $se1=$_POST['se'];




        if (empty($month_id)) { $month_id = 0; }

        if ($rowno) {
          $checkAtLeast = 0;
          
//$msg = 'class:'.$class_id.' section:'.$section_id.' exam:'.$exam_id.' year:'.$year_id.' month:'.$month_id.' subjectid:'.$subject_id.' subject_type:'.$subject_type;

          for ($i=0; $i < $rowno ; $i++) {

            $theory_final = $practical_final = $obtained_final = $mt = $ot = $eca = $lp = $nb = $se = '';

//$msg .= "/".$sid[$i].'-'.$marksheet_id[$i].'-'.$selectstd[$i]    ."/";

            if ($selectstd[$i] =="on" && empty($marksheet_id[$i]) ) { $checkAtLeast = 1;

                  if (isset($mt1[$i])) { $mt = $mt1[$i]; }else{ $mt = ''; }
                  if (isset($ot1[$i])) { $ot = $ot1[$i]; }else{ $ot = ''; }
                  if (isset($eca1[$i])) { $eca = $eca1[$i]; }else{ $eca = ''; }
                  if (isset($lp1[$i])) { $lp = $lp1[$i]; }else{ $lp = ''; }
                  if (isset($nb1[$i])) { $nb = $nb1[$i]; }else{ $nb = ''; }
                  if (isset($se1[$i])) { $se = $se1[$i]; }else{ $se = ''; }


                  if ($subject_type=='1') {
                    
                    $theory_final = $theoretical[$i];
                    $practical_final = $practical[$i];

                    $obtained_final = $theoretical[$i]+$practical[$i]+$mt+$ot+$eca+$lp+$nb+$se;

                  }else if($subject_type=='0'){

                    $theory_final = $theoretical[$i];
                    $practical_final = '';

                    $obtained_final = $theoretical[$i]+$mt+$ot+$eca+$lp+$nb+$se;

                  }else if($subject_type=='3'){

                    $theory_final = $theoretical[$i];
                    $practical_final = '';

                    $obtained_final = $theoretical[$i];

                  }

                  

                   $sqlmark1 = "INSERT INTO `marksheet` (`marksheet_class`, `marksheet_section`, `mexam_id`, `mstudent_id`, `msubject_id`, `m_theory`, `m_practical`, `m_mt`, `m_ot`, `m_eca`, `m_lp`, `m_nb`, `m_se`, `m_obtained_mark`, `year_id`, `month`, `role`, `teacher_id`, `m_date`, `marksheet_status`) VALUES ('$class_id', '$section_id', '$exam_id', '$sid[$i]', '$subject_id', '$theory_final', '$practical_final', '$mt', '$ot', '$eca', '$lp', '$nb', '$se', '$obtained_final', '$year_id', '$month_id','$role', '$teacher_id', CURRENT_TIMESTAMP, 1)";
                    
                    if(mysqli_query($db, $sqlmark1)) { 
                      $errMsg .= "Mark succesfully added"; 
                    } 

                    else {  $errMsg .= "Sorry, Failed to add marks - " . mysqli_error($db); }

            }else if ($selectstd[$i] =="on" && !empty($marksheet_id[$i]) ) { $checkAtLeast = 1;

                  if (isset($mt1[$i])) { $mt = $mt1[$i]; }else{ $mt = ''; }
                  if (isset($ot1[$i])) { $ot = $ot1[$i]; }else{ $ot = ''; }
                  if (isset($eca1[$i])) { $eca = $eca1[$i]; }else{ $eca = ''; }
                  if (isset($lp1[$i])) { $lp = $lp1[$i]; }else{ $lp = ''; }
                  if (isset($nb1[$i])) { $nb = $nb1[$i]; }else{ $nb = ''; }
                  if (isset($se1[$i])) { $se = $se1[$i]; }else{ $se = ''; }

                  if ($subject_type=='1') {

                    $theory_final = $theoretical[$i];
                    $practical_final = $practical[$i];

                    $obtained_final = $theoretical[$i]+$practical[$i]+$mt+$ot+$eca+$lp+$nb+$se;

                  }else if($subject_type=='0'){

                    $theory_final = $theoretical[$i];
                    $practical_final = '';

                    $obtained_final = $theoretical[$i]+$mt+$ot+$eca+$lp+$nb+$se;

                  }else if($subject_type=='3'){

                    $theory_final = $theoretical[$i];
                    $practical_final = '';

                    $obtained_final = $theoretical[$i];

                  }


                   $sqlupdate = "UPDATE `marksheet` SET `m_theory` = '$theory_final' , `m_practical` = '$practical_final' , `m_mt` = '$mt' , `m_ot` = '$ot' , `m_eca` = '$eca' , `m_lp` = '$lp' , `m_nb` = '$nb' , `m_se` = '$se' , `m_obtained_mark` = '$obtained_final' WHERE `marksheet_id` = '$marksheet_id[$i]' ";
                    
                    if(mysqli_query($db, $sqlupdate)) { 
                      $errMsg .= "Mark succesfully updated"; 
                    }
                    else {  $errMsg .= "Sorry, Failed to update marks - " . mysqli_error($db); }

            }else if ($selectstd[$i] !="on" && !empty($marksheet_id[$i])) {  $checkAtLeast = 1;

                   $sqldelete = "DELETE FROM `marksheet` WHERE `marksheet_id` ='$marksheet_id[$i]' ";
                    
                    if(mysqli_query($db, $sqldelete)) { 
                      $errMsg .= "Marks succesfully updated"; 
                    } 

                    else {  $errMsg .= "Sorry, Failed to delete marks - " . mysqli_error($db); }

            }else if ($selectstd[$i] !="on" && empty($marksheet_id[$i]) ){

            }

          } 

          if ($checkAtLeast == 1) {  $msg = 'Mark succesfully updated'; 
          }else{ $msg = 'Please add mark.'; }

        }else{ $msg = "Empty input.."; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }
  }

?>