<?php
   include('session.php');
   include('../config/sendbulksms.php');
   include("../important/backstage.php");

   $backstage = new back_stage_class();

    if (isset($_GET["e5s8cvd5sd5"])){ 
            $rsub = addslashes($_GET["e5s8cvd5sd5"]);
        }

    if (isset($_GET["q7v7s1xv5"])){ 
            $rclock = addslashes($_GET["q7v7s1xv5"]);
        }

    if (isset($_GET["q7v7mdmd5"])){ 
            $rcdate = addslashes($_GET["q7v7mdmd5"]);
        }
    
      if($_SERVER["REQUEST_METHOD"] == "POST") {
          
          $combinedcurlresponse = " ";
          
          $test=$_POST['test'];
          $mobilelist = "";
          if ($test){
              foreach ($test as $t){
                  $ml=substr($t,0,10);
                  $studid=substr($t,10);
                  $mobilelist = $mobilelist.$ml.",";
                  
                  $sqlfnp1 = "INSERT INTO `feenotpaid` (`feenpid`, `feenpsid`, `feenpclock`) VALUES (NULL, '$studid', CURRENT_TIMESTAMP)";
                  
                  if(mysqli_query($db, $sqlfnp1)) {  
                      //echo "inserted";
                      
                  } else { 
                 $succ = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                  }
              }
          }

          $checkFeeNoticeBulk= $backstage->check_feenotice_bulk();
          if ($checkFeeNoticeBulk==1) {

            /*Bulk Sms Service*/
            $bulknumber=$mobilelist;
            $bulkmessage="Notice:Fee dues for your child.Kindly submit by 15th of each month.After 15th of running month 10% of total due will be charged as a late fine.Thank you, $login_session8";

            $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
          }


      }
?> <script> alert("Fee Due Reported Succesfully"); window.location.href = 'welcome.php?sent';  </script> <?php    //echo "Message Sent Succesfully" ;
?>