<?php
include('session.php');
include("../important/backstage.php");

   $backstage = new back_stage_class();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['lvreason'])) {

        $lvreason = mysqli_real_escape_string($db,$_POST['lvreason']);
        $newsdate = mysqli_real_escape_string($db,$_POST['sdate']);
        $newedate = mysqli_real_escape_string($db,$_POST['edate']);

        $lvid = mysqli_real_escape_string($db,$_POST['update_leave_request_id']);


        if($login_date_type==2){
            $newsdate = nToE($newsdate);
            $newedate = nToE($newedate);
        }

        if ($newsdate < $login_today_edate) {
          $msg = 'Leave start date is in the past'; 
        }else if($newsdate>$newedate){
          $msg = 'Leave end date is not correct';
        }else if (empty($lvreason)){
            $msg = 'Please type leave reason..';
        }else{
        
            $sqlsls1 = "UPDATE `leavetable` SET `lvsdate` = '$newsdate', `lvedate` = '$newedate', `lvreason` = '$lvreason' WHERE `lvid` = '$lvid'";
        
            if(mysqli_query($db, $sqlsls1)) {
             $msg = 'Leave request updated successfully';   
            } else{ 
             $msg = "Sorry, failled to submit request" . mysqli_error($db);
            }
        }
      $_SESSION['result_success'] = $msg;
      echo $msg;
    }
}
?>