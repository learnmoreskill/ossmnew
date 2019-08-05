<?php
//p==t
   include('session.php');
   include('../config/sendbulksms.php');
   include("../important/backstage.php");

   $backstage = new back_stage_class();
   $msg="";

   if($_SERVER['REQUEST_METHOD']=='POST') {

   if (isset($_POST['homework_not_done_request'])) {

     
    $hid = $_POST['e5s8cvd5sd5'];
    $subname = $_POST['s7g4bjge'];
    $rcdate = $_POST['q7v7mdmd5'];
    $test=$_POST['test'];
    if (!empty($test)) {

      $mobilelist = "";
      $reported=0;

      //check variable
      $sentNo = '';
      $count = 0;

      $checkHomeworkNotDoneBulk = $backstage->check_nohomework_bulk();
      $bulkmessage='Notice:Your child has not done '.$subname.' Homework given on '.$rcdate.'.--'.$login_session2.', '.$login_session_a;

      if ($test){
          foreach ($test as $studid){
              
              $sqlhwrs1 = "INSERT INTO `hwnotdone` (`hwndid`, `hwndsid`, `hwndhid`, `hwndclock`) VALUES (NULL, '$studid', '$hid', CURRENT_TIMESTAMP)";
              
              if(mysqli_query($db, $sqlhwrs1)) {

                if ($checkHomeworkNotDoneBulk==1) {
                  $spnumber= $backstage->get_parent_number_by_student_id($studid);

                  if (strlen($spnumber)>=10) {
                    $mobileno = substr($spnumber,-10);
                    $sentNo .= $mobileno.","; //check
                    $count = $count+1; //check
                    $bulkresult .= sendbulk($login_session_bulksmstoken,$mobileno,$bulkmessage);
                  }
                }

                $msg= "Homework report submitted";
                $reported=1;

              }else { $msg = "Sorry!! Failed to submit - " . mysqli_error($db); }

          }
      }
    }else{  $msg= "Student list is empty!!";  }

      if ($reported == 1) {
        $backstage->update_homework_reported_by_id($hid);
      }           

    $_SESSION['result_success']=$msg;
    echo $msg;
  }
}
?>