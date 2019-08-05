<?php
   include('session.php');
   $msg="";

   if($_SERVER['REQUEST_METHOD']=='POST') {

   if (isset($_POST['add_subject'])) {

    $checkboxvalue=$_POST['checkboxvalue'];

    $subjectname=$_POST['subjectname'];
    $totalmark=$_POST['totalmark'];
    $passmark=$_POST['passmark'];
    $classname2=$_POST['classname1'];
    $teacherid=$_POST['teacherid'];
    $thfullmark=$_POST['thfullmark'];
    $thpassmark=$_POST['thpassmark'];
    $prcfullmark=$_POST['prcfullmark'];
    $prcpassmark=$_POST['prcpassmark'];

          if (!empty($subjectname)) {
            if (!empty($classname2)) {

              if ($checkboxvalue!="on"){
                if (empty($totalmark)){ $msg="Please fill total mark"; }
                elseif (empty($passmark)){ $msg="Please fill pass mark"; }
                else{
                $thfullmark="";
                $prcfullmark="";
                $thpassmark="";
                $prcpassmark="";
                }
                $subject_type=0;
              }elseif($checkboxvalue=="on"){
                if (empty($thfullmark)){ $msg="Please fill theory full mark"; }
                elseif (empty($thpassmark)){ $msg="Please fill theory pass mark"; }
                elseif (empty($prcfullmark)){ $msg="Please fill Practical full mark"; }
                elseif (empty($prcpassmark)){ $msg="Please fill Practical pass mark"; }
                else{
                $totalmark=$thfullmark+$prcfullmark;
                $passmark=$thpassmark+$prcpassmark;
                }
                $subject_type=1;
              }

              $subject_name=strtolower($subjectname);
              $subject_name1=ucwords($subjectname);
              $subject_name2=strtoupper($subjectname);

              $sqlcheck="SELECT `subject_id` FROM `subject` WHERE `subject_class`='$classname2' AND (`subject_name`='$subjectname' OR `subject_name`='$subject_name' OR `subject_name`='$subject_name1' OR `subject_name`='$subject_name2')";
               $resultcheck=mysqli_query($db, $sqlcheck);
               $count=mysqli_num_rows($resultcheck);
               if($count<1){

                if(empty($msg))
                {
                  $insertintosubject = "INSERT INTO `subject`(`subject_name`, `total_mark`, `subject_theory`, `subject_practical`, `theory_passmark`, `practical_passmark`, `pass_mark`, `subject_class`, `teacher_id`, `subject_type`, `status`) VALUES ('$subjectname','$totalmark','$thfullmark','$prcfullmark','$thpassmark','$prcpassmark','$passmark','$classname2','$teacherid', '$subject_type', 0)";
                  
                  if(mysqli_query($db, $insertintosubject)) {  $msg= "Subject succesfully added"; }
                  else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db); }
                  }


            }else{ $msg = "Subject Name already exists"; }
            }else{ $msg = "Class Name is missing"; }
            }else{ $msg = "Subject  Name is missing"; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }
  }

?>