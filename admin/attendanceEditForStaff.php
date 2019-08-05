<?php
//for nsk and admin
include('session.php');
include('../config/sendbulksms.php');
include("../important/backstage.php");

$backstage = new back_stage_class();

//$checkAttendaanceBulk= $backstage->check_attendance_bulk();

$edit_id = addslashes($_GET["edit_id"]);
$attendanceFor = addslashes($_GET["attendanceFor"]);
$staff_id = addslashes($_GET["staff_id"]);
$status = addslashes($_GET["status"]);

$staff_code=0;
if ($attendanceFor=='teacher') {
    $staff_code=2;
}else if ($attendanceFor=='staff') {
    $staff_code=5;
}


    $sqlae0 = "SELECT * FROM `attendance_staff_check` 
            WHERE `staff`='$staff_code'  
                AND `date`='$login_today_edate'";
    $resultae0 = $db->query($sqlae0);

    if ($resultae0->num_rows > 0) {
        while($row = $resultae0->fetch_assoc()) {
        
            $opcount =  $row["abpcount"];
            $oacount =  $row["abacount"];
            $attendance_staff_check_id = $row["id"];
        }
    }                   

    $sqlae0a = "SELECT `teachers`.`tname`,`teachers`.`tmobile` 
                FROM `teachers` 
                WHERE `teachers`.`tid`='$staff_id'";
    $resultae0a = $db->query($sqlae0a);
    if ($resultae0a->num_rows > 0) {

        while($row = $resultae0a->fetch_assoc()) {
            $list = $row["tmobile"];
            $name = $row["tname"];
        }
            
    }

    
    if( $status == 'P' || $status == 'L'){      
        $nacount = $oacount + 1;
        $npcount = $opcount - 1;
        
        $sqlae1="UPDATE `attendance_staff` SET `status` = 'A' WHERE `attendance_staff`.`id` = '$edit_id'";
        if(mysqli_query($db, $sqlae1)) {
                
            /*if ($checkAttendaanceBulk==1) {

                if (strlen($list)>=10) {
                    $bulknumber = substr($list,-10);
                    $bulkmessage="Your child ".$mname." is absent today for the class. -".$login_session2.", ".$login_session_a; //enter Your Message
                    $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
                }
            }  */ 
            
        } else {
            $success = "ERROR: Could not able to execute - " . mysqli_error($db);
            ?> <script> alert('Error Code :00ae001 Not Updated');  window.location.href = 'attendanceView.php?type=<?php echo $attendanceFor; ?>&today=today'; </script> <?php 
        } 
                
        $sqlae2="UPDATE `attendance_staff_check` SET `abpcount` = '$npcount', `abacount` = '$nacount' WHERE `attendance_staff_check`.`id` = '$attendance_staff_check_id'";
        if(mysqli_query($db, $sqlae2)) {

            ?> <script> alert('Successfully Updated'); window.location.href = 'attendanceView.php?type=<?php echo $attendanceFor; ?>&today=today'; </script> <?php
                
        } else {
            $success = "ERROR: Could not able to execute - " . mysqli_error($db);
            ?> <script> alert('Error Code :00ae002 Not Updated');  window.location.href = 'attendanceView.php?type=<?php echo $attendanceFor; ?>&today=today';</script> <?php 
        }
            
    } else if( $status == 'A'){      
                
            $nacount = $oacount - 1;
            $npcount = $opcount + 1;
                
            $sqlae4="UPDATE `attendance_staff` SET `status` = 'P' WHERE `attendance_staff`.`id` = '$edit_id'";
            if(mysqli_query($db, $sqlae4)) {


                /*if ($checkAttendaanceBulk==1) {

                    if (strlen($list)>=10) {
                        $bulknumber = substr($list,-10);
                        $bulkmessage="Your child ".$mname." is PRESENT today for the class.Sorry for inconvenience. -".$login_session2.", ".$login_session_a; //enter Your Message
                        $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
                    }
                }*/
                
            } else {
                $success = "ERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae004 Not Updated');  window.location.href = 'attendanceView.php?type=<?php echo $attendanceFor; ?>&today=today'; </script> <?php 
            }
                
                $sqlae5="UPDATE `attendance_staff_check` SET `abpcount` = '$npcount', `abacount` = '$nacount' WHERE `attendance_staff_check`.`id` = '$attendance_staff_check_id'";
            if(mysqli_query($db, $sqlae5)) {

                ?> <script> alert('Successfully Updated'); window.location.href = 'attendanceView.php?type=<?php echo $attendanceFor; ?>&today=today'; </script> <?php
            
            } else {
                $success = "ERROR: Could not able to execute - " . mysqli_error($db);
                ?> <script> alert('Error Code :00ae005 Not Updated'); window.location.href = 'attendanceView.php?type=<?php echo $attendanceFor; ?>&today=today';  </script> <?php echo $success;
            } 
    }  
?>
    
