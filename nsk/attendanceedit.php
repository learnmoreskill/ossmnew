<?php
//for nsk and student
include('session.php');
include('../config/sendbulksms.php');
include("../important/backstage.php");

$backstage = new back_stage_class();

$checkAttendaanceBulk= $backstage->check_attendance_bulk();

$class_id = addslashes($_GET["class_id"]);
$section_id = addslashes($_GET["section_id"]);

        $sqlae0 = "SELECT * FROM `abcheck` 
            WHERE `abclass`='$class_id' 
                AND `absec`='$section_id' 
                AND `abdate`='$login_today_edate'";
        $resultae0 = $db->query($sqlae0);
        if ($resultae0->num_rows > 0) {
             while($row = $resultae0->fetch_assoc()) {
                $opcount =  $row["abpcount"];
                $oacount =  $row["abacount"];
                $cabid = $row["abid"];
             }
        }                   

        if (isset($_GET["aaid"])){ 
            $aid = addslashes($_GET["aaid"]);
	    $asid = addslashes($_GET["asid"]);
            $sqlae0a = "SELECT * 
                FROM `studentinfo` 
                LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
                WHERE `studentinfo`.`sid`='$asid'";
            $resultae0a = $db->query($sqlae0a);
            if ($resultae0a->num_rows > 0) {
             while($row = $resultae0a->fetch_assoc()) {
                 $list = $row["spnumber"];
                 $mname = $row["sname"];
             }
        }
        }
        if (isset($_GET["aastatus"])){
            $astatus = addslashes($_GET["aastatus"]);
        }
    
            if( $astatus == 'P')
            {      
                $nacount = $oacount + 1;
                $npcount = $opcount - 1;
                
                $sqlae1="UPDATE `attendance` SET `astatus` = 'A' WHERE `attendance`.`aid` = '$aid'";
    		if(mysqli_query($db, $sqlae1)) {


                
                if ($checkAttendaanceBulk==1) {

                    if (strlen($list)>=10) {
                        $bulknumber = substr($list,-10);
                        $bulkmessage="Your child ".$mname." is absent today for the class. -".$login_session2.", ".$login_session_a; //enter Your Message
                        $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
                    }
                }  

                
            
            } else {
                $success = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae001 Not Updated');  window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today'; </script> <?php 
            } 
                
                $sqlae2="UPDATE `abcheck` SET `abpcount` = '$npcount' WHERE `abcheck`.`abid` = '$cabid'";
    		if(mysqli_query($db, $sqlae2)) {
                
            } else {
                $success = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae002 Not Updated');  window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today';</script> <?php 
            }
                
                $sqlae3="UPDATE `abcheck` SET `abacount` = '$nacount' WHERE `abcheck`.`abid` = '$cabid'";
    		if(mysqli_query($db, $sqlae3)) {
               ?> <script> alert('Successfully Updated'); window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today'; </script> <?php  
            
            } else {
                $success = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae003 Not Updated');  window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today'; </script> <?php 
            }
            
            } 
            else if( $astatus == 'A')
            {      
                $nacount = $oacount - 1;
                $npcount = $opcount + 1;
                
                $sqlae4="UPDATE `attendance` SET `astatus` = 'P' WHERE `attendance`.`aid` = '$aid'";
    		if(mysqli_query($db, $sqlae4)) {


                if ($checkAttendaanceBulk==1) {

                    if (strlen($list)>=10) {
                        $bulknumber = substr($list,-10);
                        $bulkmessage="Your child ".$mname." is PRESENT today for the class.Sorry for inconvenience. -".$login_session2.", ".$login_session_a; //enter Your Message
                        $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
                    }
                }

                
            } else {
                $success = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae004 Not Updated');  window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today'; </script> <?php 
            }
                
                $sqlae5="UPDATE `abcheck` SET `abpcount` = '$npcount' WHERE `abcheck`.`abid` = '$cabid'";
    		if(mysqli_query($db, $sqlae5)) {
            
            } else {
                $success = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae005 Not Updated'); window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today';  </script> <?php echo $success;
            }
                
                $sqlae6="UPDATE `abcheck` SET `abacount` = '$nacount' WHERE `abcheck`.`abid` = '$cabid'";
    		if(mysqli_query($db, $sqlae6)) {
            ?> <script> alert('Attendance Updated'); window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today';   </script> <?php
            } else {
                $success = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae006 Not Updated'); window.location.href = 'alistview.php?class_id=<?php echo $class_id; ?>&section_id=<?php echo $section_id; ?>&today=today';   </script> <?php 
            }
            
            }  
?>
    
