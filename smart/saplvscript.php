<?php
include('session.php');
include("../important/backstage.php");

   $backstage = new back_stage_class();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['lvreason'])) {

        $lvreason = mysqli_real_escape_string($db,$_POST['lvreason']);
        $newsdate = mysqli_real_escape_string($db,$_POST['sdate']);
        $newedate = mysqli_real_escape_string($db,$_POST['edate']);

        $yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));


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
        
            $sqlsls1 = "INSERT INTO `leavetable` (`lvid`, `lvclass`, `lvsec`, `lvsid`, `lvreason`, `lvsdate`, `lvedate`, `lvschoolcode`, `lvstatus`, `lvrole`, `lvtid`, `year_id`, `lvclock`, `status`) VALUES (NULL, '$login_class_id', '$login_section_id', '$login_session1', '$lvreason', '$newsdate', '$newedate', '$login_session_b', 50, 0, 0, '$yearId', CURRENT_TIMESTAMP, 0)";
        
            if(mysqli_query($db, $sqlsls1)) {
             $msg = 'Leave request successfully submitted';   
            } else{ 
             $msg = "Sorry, failled to submit request" . mysqli_error($db);
            }
        }
      $_SESSION['result_success'] = $msg;
      echo $msg;
    }
}
?>