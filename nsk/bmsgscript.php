<?php
   include('session.php');
   include('../config/sendbulksms.php');
   include("../important/backstage.php");

   $backstage = new back_stage_class();

   $msg="";
   $list="";
   $maillist="";
  date_default_timezone_set('Asia/Kathmandu');
  $newdate = date("Y-m-d H:i:s");
  $cd = date("Y-m-d");
 if($_SERVER["REQUEST_METHOD"] == "POST") { 
    if (isset($_POST['teacher_broadcast_to_class'])) {

     $class = mysqli_real_escape_string($db,$_POST["classname"]);
     $section = mysqli_real_escape_string($db,$_POST["section"]);
     $ubmsg = $_POST["tbmsg"];
     $ubmsg = stripslashes(str_replace(array("\r", "\n", "\t", "\r\n", "\0", "\x0B"), ' ', $ubmsg));

     if(!empty($class)){
        if(!empty($section)){
            if(!empty($ubmsg)){

    header('Content-Type: text/html; charset = utf-8');
    mysqli_query($db,"SET NAMES utf8");
          
     $sqlbmsgs1 = "INSERT INTO `broadcasts` (`bmid`, `bmtid`, `bmtname`, `bmtext`, `bmschoolcode`, `bmschoolname`, `bmclass`, `bmsec`, `bmdate`, `bmclock`) VALUES (NULL, '$login_session1', '$login_session2', '$ubmsg', '$LOGIN_SCHOOL_CODE', '$login_session8', '$class', '$section', '$cd', '$newdate')";

     if(mysqli_query($db, $sqlbmsgs1)) {
        
         $sqlbmsgs2 = "SELECT * FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE  `studentinfo`.`sclass`='$class' AND `studentinfo`.`ssec`='$section' AND `studentinfo`.`status`=0 GROUP BY `parents`.`spnumber`";
        $resultbmsgs2 = $db->query($sqlbmsgs2);
        if ($resultbmsgs2->num_rows > 0) {
            while($row = $resultbmsgs2->fetch_assoc()) {

              if (strlen($row["spnumber"])>=10) {
                $list = $list.substr($row["spnumber"],-10).",";
              }
                $maillist = $maillist.$row["spemail"].",";
            } 
        }
         
         $checkBroadcastBulk= $backstage->check_broadcast_bulk();
        if ($checkBroadcastBulk==1) {
 
            /*Bulk Sms Service*/
            $bulknumber=$list; //enter Mobile numbers comma seperated
            $bulkmessage=$ubmsg; //enter Your Message 

            $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
        }


        $msg= "Broadcast message succesfully pushed to selected class students";

     } else{ $msg="ERROR: Could not able to execute - " . mysqli_error($db); }

     }else{ $msg = "Message field is empty"; }
    }else{ $msg = "Please select section"; }
    }else{ $msg = "Please select class"; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }
  }
?>
