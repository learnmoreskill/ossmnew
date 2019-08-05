<?php
//for nsk and admin
   include('session.php');
   include("../important/backstage.php");

   $backstage = new back_stage_class();

 if($_SERVER["REQUEST_METHOD"] == "POST") {

    $yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));
     
     $subject_id = mysqli_real_escape_string($db,$_POST["subject_id"]);
     $topic = mysqli_real_escape_string($db,$_POST["ttopic"]);
     $class_id = mysqli_real_escape_string($db,$_POST["tclass"]);
     $sec_id = mysqli_real_escape_string($db,$_POST["tsec"]);
     $submitdate=$_POST['submitdate'];

    if (!empty($class_id)) {
    if (!empty($sec_id)) {
    if (!empty($subject_id)) {
    if (!empty($topic)) {
    if (!empty($submitdate)) {

        if (empty($submitdate)) { $submitdate = $login_today_edate; }

        if($login_date_type==2){
            $submitdate = nToE($submitdate);
        }
        if ($submitdate >= $login_today_edate) {

        // header('Content-Type: text/html; charset = utf-8');
        // mysqli_query($db,"SET NAMES utf8");
     
        $sqlhwmsgs1 = "INSERT INTO `homework` (`hid`, `hclass`, `hsec`, `hsubject`, `htopic`, `hrole`, `htid`, `hdate`, `hclock`, `year_id`, `hreported`, `hstatus`) VALUES (NULL, '$class_id', '$sec_id', '$subject_id', '$topic', '$LOGIN_CAT', '$LOGIN_ID', '$submitdate', CURRENT_TIMESTAMP, '$yearId', 0, 0)";
    
        if(mysqli_query($db, $sqlhwmsgs1)) {
             $msg  = 'Homework added successfully';     
        }else{ 
            $msg = "Sorry, Failed to add homework - " . mysqli_error($db);
        }
    }else{  $msg = "The past date of submission is not acceptable";   }
    }else{  $msg = "Please select submission date";   }
    }else{  $msg = "Topic field is empty!!";  }
    }else{  $msg = "Please select subject";   }
    }else{  $msg = "Please select section";   }
    }else{  $msg = "Please select class name";    }

    $_SESSION['result_success']=$msg;
    echo $msg;
 }
?>