<?php
   include('session.php');
   include('../config/sendbulksms.php');
   include("../important/backstage.php");

   $backstage = new back_stage_class();

if (isset($_GET["key"])){
$sid = addslashes($_GET["key"]);
}
date_default_timezone_set('Asia/Kathmandu');
$newdate = date("Y-m-d H:i:s");
$cd = date("Y-m-d");
$sqlcms0 = "SELECT * FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`sid`='$sid' GROUP BY `parents`.`spnumber`";
        $resultcms0 = $db->query($sqlcms0);
        if ($resultcms0->num_rows > 0) {
             while($row = $resultcms0->fetch_assoc()) {
                $sname =  $row["sname"];
                $sclass =  $row["sclass"];
                $ssec = $row["ssec"];

                if (strlen($row["spnumber"])>=10) {
                $spnumber = $list.substr($row["spnumber"],-10).",";
              }
             }
        }
 if($_SERVER["REQUEST_METHOD"] == "POST") {
     
     $ucmsg = $_POST["tcmsg"];
     $ucmsg = stripslashes(str_replace(array("\r", "\n", "\t", "\r\n", "\0", "\x0B"), ' ', $ucmsg));

    header('Content-Type: text/html; charset = utf-8');
    mysqli_query($db,"SET NAMES utf8");
     
     $sqlcms1 = "INSERT INTO `complaint` (`cid`, `csclass`, `cssec`, `csid`, `cmsg`, ,`crole`, `ctid`, `cseen`, `cdate`, `cclock`, `cstatus`) VALUES (NULL, '$sclass', '$ssec', '$sid', '$ucmsg', '$login_cat', '$login_session1', 0, '$cd', '$newdate', 0)";
     
     if(mysqli_query($db, $sqlcms1)) {

    $checkComplaintBulk= $backstage->check_complaint_bulk();
    if ($checkComplaintBulk==1) {

        /*Bulk Sms Service*/
        $bulknumber=$spnumber; //enter Mobile numbers comma seperated
        $bulkmessage=$ucmsg; //enter Your Message 

        $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
    }

?> <script> alert("Complaint added succesfully"); window.location.href = 'mtpmsghistory.php?sent'; </script> <?php    //echo "Message Sent Succesfully" ;




     } else {
         $sucmsg = "ERROR: Could not able to execute - " . mysqli_error($db);
         ?> <script> alert('<?php echo $sucmsg; ?> '); window.location.href = 'mtpmsghistory.php?fail'; </script> <?php
     }
     
 }
?>
