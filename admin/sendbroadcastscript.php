<?php
//both nsk and admin
   include('session.php');
   include('../config/sendbulksms.php');
   include("../important/backstage.php");

   $backstage = new back_stage_class();
   $count = 0;

 if($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['broadcastmessage'])) {
     $list='';

     $checkstudents = $_POST["checkstudents"];
     $checkparents = $_POST["checkparents"];
     $checkteachers = $_POST["checkteachers"];
     $checkstaff = $_POST["checkstaff"];

     $classes = $_POST["classes"];
     
     $adminmsg = $_POST["broadcastmessage"];

     $alltype = 0;

     $adminmsg = stripslashes(str_replace(array("\r", "\n", "\t", "\r\n", "\0", "\x0B"), ' ', $adminmsg));

      if ( (!empty($checkstudents) || !empty($checkparents)) && empty($classes) ) {
        echo "Class is not selected";
        exit();
      }
      //set class null if student and parent not selected
      if ( empty($checkstudents) && empty($checkparents) ) {
        $classes = '';
      }
      //check any receiver is selected or not
      if (!empty($checkstudents) || !empty($checkparents) || !empty($checkteachers) || !empty($checkstaff)) {

        if (!empty($adminmsg)) {


        if (!empty($checkstudents) && !empty($checkparents) && !empty($checkteachers) && !empty($checkstaff)) { 
          $alltype = 15; 
        }else if(!empty($checkparents) && !empty($checkteachers) && !empty($checkstaff)) { 
          $alltype = 14; 
        }else if(!empty($checkstudents) && !empty($checkteachers) && !empty($checkstaff)) { 
          $alltype = 13; 
        }else if(!empty($checkstudents) && !empty($checkparents) && !empty($checkstaff)) { 
          $alltype = 12; 
        }else if (!empty($checkstudents) && !empty($checkparents) && !empty($checkteachers)) { 
          $alltype = 11; 
        }else if (!empty($checkteachers) && !empty($checkstaff)) { 
          $alltype = 10; 
        }else if (!empty($checkparents) && !empty($checkstaff)) { 
          $alltype = 9; 
        }else if (!empty($checkparents) && !empty($checkteachers)) { 
          $alltype = 8; 
        }else if (!empty($checkstudents) && !empty($checkstaff)) { 
          $alltype = 7; 
        }else if (!empty($checkstudents) && !empty($checkteachers)) { 
          $alltype = 6; 
        }else if (!empty($checkstudents) && !empty($checkparents)) { 
          $alltype = 5; 
        }else if (!empty($checkstaff)) { 
          $alltype = 4; 
        }else if (!empty($checkteachers)) { 
          $alltype = 3; 
        }else if (!empty($checkparents)) { 
          $alltype = 2; 
        }else if (!empty($checkstudents)) { 
          $alltype = 1; 
        }

          //check broadcast is on or off
          $checkBroadcastBulk= $backstage->check_broadcast_bulk();

          $yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));

          header('Content-Type: text/html; charset = utf-8');
          mysqli_query($db,"SET NAMES utf8");

          $sqlbroadcastmsg1 = "INSERT INTO `broadcast`(`id`, `t_role`, `t_id`, `message`, `message_type`, `clock`, `year_id`, `status`) VALUES (null,'$login_cat','$login_session1', '$adminmsg', 1, CURRENT_TIMESTAMP, '$yearId', 0)";
          if(mysqli_query($db, $sqlbroadcastmsg1)) {

            //get the last added id
            $sql_last_id = mysqli_insert_id($db);

            foreach ($classes as $class) {

              $sqlreceiver = "INSERT INTO `b_receiver`(`id`, `broadcast_id`, `all_type`, `class_id`, `section_id`) VALUES (null,'$sql_last_id','$alltype',$class,0)";

              if(mysqli_query($db, $sqlreceiver)) {

                //check alltype for students
                if ($checkBroadcastBulk==1 && ($alltype == 1 || $alltype == 5 || $alltype == 6 || $alltype == 7 || $alltype == 11 || $alltype == 12 || $alltype == 13 || $alltype == 15) ) {

                  $sqlstds = "SELECT `smobile` FROM `studentinfo` WHERE `sclass` = '$class' AND `status`= 0 GROUP BY `smobile`";
                  $resultstds = $db->query($sqlstds);
                  if ($resultstds->num_rows > 0) {
                    while($row = $resultstds->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["smobile"])>=10) {
                        $list .= substr($row["smobile"],-10).","; 
                        $count = $count+1;
                      }
                    } 
                  }
                }

                //check alltype for parents
                if ($checkBroadcastBulk==1 && ($alltype == 2 || $alltype == 5 || $alltype == 8 || $alltype == 9 || $alltype == 11 || $alltype == 12 || $alltype == 14 || $alltype == 15) ) {

                  $sqlprts = "SELECT `parents`.`spnumber` FROM `studentinfo` INNER JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`sclass` = '$class' AND `studentinfo`.`status`= 0 AND `parents`.`spstatus`= 0 GROUP BY `parents`.`spnumber` ";
                  $resultprts = $db->query($sqlprts);
                  if ($resultprts->num_rows > 0) {
                    while($row = $resultprts->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["spnumber"])>=10) {
                        $list .= substr($row["spnumber"],-10).",";
                        $count = $count+1;
                      }
                    } 
                  }
                }
              }
            }

            //insert and send for teacher
            if (!empty($checkteachers)) {
              $sqlteacher = "INSERT INTO `b_receiver`(`id`, `broadcast_id`, `all_type`, `class_id`, `section_id`) VALUES (null,'$sql_last_id',3,0,0)";

              if(mysqli_query($db, $sqlteacher)) {

                //check send broadcast
                if ($checkBroadcastBulk == 1 ) {

                  $sqltchrs = "SELECT `tmobile` FROM `teachers` WHERE `status`= 0 GROUP BY `tmobile` ";
                  $resulttchrs = $db->query($sqltchrs);
                  if ($resulttchrs->num_rows > 0) {
                    while($row = $resulttchrs->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["tmobile"])>=10) {
                        $list .= substr($row["tmobile"],-10).","; 
                        $count = $count+1;
                      }
                    } 
                  }
                }

              }
            }

            //insert and send for staff
            if (!empty($checkstaff)) {
              $sqlstaff = "INSERT INTO `b_receiver`(`id`, `broadcast_id`, `all_type`, `class_id`, `section_id`) VALUES (null,'$sql_last_id',4,0,0)";

              if(mysqli_query($db, $sqlstaff)) {

                //check send broadcast
                if ($checkBroadcastBulk == 1 ) {

                  $sqlstaff = "SELECT `staff_mobile` FROM `staff_tbl` WHERE `staff_status`= 0 GROUP BY `staff_mobile` ";
                  $result_staff = $db->query($sqlstaff);
                  if ($result_staff->num_rows > 0) {
                    while($row = $result_staff->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["staff_mobile"])>=10) {
                        $list .= substr($row["staff_mobile"],-10).","; 
                        $count = $count+1;
                      }
                    } 
                  }
                }

              }
            }
            $bulkresult .= sendbulk($login_session_bulksmstoken,$list,$adminmsg);
            $msg = "Broadcast sent succesfully";
            //$msg = 'Alltype:'.$alltype.'/send count:'.$count.'/'.$list.'/response:'.$bulkresult;
            
          }else{ $msg = "Failed to send - " . mysqli_error($db); }

        }else{ $msg = "Message is empty"; }
      }else{ $msg = "Please select any one receiver"; }

     $_SESSION['result_success']=$msg;
      echo $msg;

/*============================ for personal message ====================*/
  }else if (isset($_POST['personalmessage'])) {

     $list='';

     $group = $_POST["group"];

     $users = $_POST["users"];
     
     $adminmsg = $_POST["personalmessage"];

     $adminmsg = stripslashes(str_replace(array("\r", "\n", "\t", "\r\n", "\0", "\x0B"), ' ', $adminmsg));

    if (!empty($group)) {

      //check any receiver is selected or not
      if (!empty($users)) {

        if (!empty($adminmsg)) {

          //check broadcast is on or off
          $checkBulk= $backstage->check_complaint_bulk();

          $yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));

          header('Content-Type: text/html; charset = utf-8');
          mysqli_query($db,"SET NAMES utf8");

          $sqlbroadcastmsg1 = "INSERT INTO `broadcast`(`id`, `t_role`, `t_id`, `message`, `message_type`, `clock`, `year_id`, `status`) VALUES (null,'$login_cat','$login_session1', '$adminmsg', 2, CURRENT_TIMESTAMP, '$yearId', 0)";
          if(mysqli_query($db, $sqlbroadcastmsg1)) {

            //get the last added id
            $sql_last_id = mysqli_insert_id($db);

            foreach ($users as $user) {

              $sqlreceiver = "INSERT INTO `bp_receiver`(`id`, `broadcast_id`, `r_role`, `r_id`, `seen`, `clock`) VALUES (null,'$sql_last_id','$group',$user, 0, CURRENT_TIMESTAMP)";

              if(mysqli_query($db, $sqlreceiver)) {

                //Check for Parents
                if ($checkBulk==1 && $group==4 ) {

                  $sqlprts = "SELECT `parents`.`spnumber` 
                    FROM `studentinfo` 
                    INNER JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
                    WHERE `studentinfo`.`sid` = '$user' 
                      AND `parents`.`spstatus`= 0 
                    GROUP BY `parents`.`spnumber` ";
                  $resultprts = $db->query($sqlprts);
                  if ($resultprts->num_rows > 0) {
                    while($row = $resultprts->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["spnumber"])>=10) {
                        $list .= substr($row["spnumber"],-10).",";
                        $count = $count+1; 
                      }
                    } 
                  }
                }

                //Check for Students
                if ($checkBulk==1 && $group==3 ) {

                  $sqlstds = "SELECT `smobile` 
                    FROM `studentinfo` 
                    WHERE `sid` = '$user' 
                    GROUP BY `smobile`";
                  $resultstds = $db->query($sqlstds);
                  if ($resultstds->num_rows > 0) {
                    while($row = $resultstds->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["smobile"])>=10) {
                        $list .= substr($row["smobile"],-10).",";
                        $count = $count+1;
                      }
                    } 
                  }
                }

                //check for teachers
                if ($checkBulk==1 && $group==2) {

                  $sqltchrs = "SELECT `tmobile` FROM `teachers` 
                    WHERE `teachers`.`tid`= '$user' 
                    GROUP BY `tmobile` ";
                  $resulttchrs = $db->query($sqltchrs);
                  if ($resulttchrs->num_rows > 0) {
                    while($row = $resulttchrs->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["tmobile"])>=10) {
                        $list .= substr($row["tmobile"],-10).",";
                        $count = $count+1;
                      }
                    } 
                  }
                }

                //check for staff
                if ($checkBulk==1 && $group==5) {

                  $sqlstaff = "SELECT `staff_mobile` 
                    FROM `staff_tbl` 
                    WHERE `staff_tbl`.`stid` = '$user' 
                    GROUP BY `staff_mobile` ";
                  $result_staff = $db->query($sqlstaff);
                  if ($result_staff->num_rows > 0) {
                    while($row = $result_staff->fetch_assoc()) {
                      //mobile number list
                      if (strlen($row["staff_mobile"])>=10) {
                        $list .= substr($row["staff_mobile"],-10).",";
                        $count = $count+1;
                      }
                    } 
                  }
                }

              }
            }
            $bulkresult .= sendbulk($login_session_bulksmstoken,$list,$adminmsg);

            $msg = "Message sent succesfully";
            //$msg = 'group type:'.$group.'/send count:'.$count.'/'.$list.'/response:'.$bulkresult;

          }else{ $msg = "Failed to send - " . mysqli_error($db); }

        }else{ $msg = "Message is empty"; }
      }else{ $msg = "User list is empty!!"; }
    }else{ $msg = "User type not selected!!"; }




    $_SESSION['result_success']=$msg;
    echo $msg;






  }






  exit;
}
?>
