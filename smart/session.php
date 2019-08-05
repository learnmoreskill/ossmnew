<?php

   date_default_timezone_set('Asia/Kathmandu');

   require('../config/config.php');
   session_start();
   
   $user_check = $_SESSION['login_user_student'];
   
   $ses_sql = mysqli_query($db,"SELECT `studentinfo`.*, `parents`.*, `class`.`class_id`, `class`.`class_name`, `section`.`section_id`, `section`.`section_name`  FROM `studentinfo`
         LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
         LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
         LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id`
         WHERE `studentinfo`.`semail`='$user_check' AND `studentinfo`.`status`=0");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC); 

   $countrow = mysqli_num_rows($ses_sql);
   if($countrow != 1) {
   session_destroy();
   unset($_SESSION['login_user_student']);
   header("Location: ../index.php#student");
   exit();
    }
   $LOGIN_CAT = $login_cat = 3;

   $LOGIN_ID = $login_session1 = $row['sid'];
   $login_session2 = $row['sroll'];
   $LOGIN_NAME = $login_session3 = $row['sname'];
   $login_session4 = $row['saddress'];
   $login_session5 = $row['semail'];
   $login_session7 = $row['spname'];
   $login_session8 = $row['spnumber'];
   $LOGIN_EMAIL = $login_session9 = $row['spemail'];
   $login_session12 = $row['class_name'];
   $login_session13 = $row['section_name'];
   $LOGIN_IMAGE = $login_session14 = $row['simage'];
   $LOGIN_SEX = $login_session15 = $row['sex'];
   $LOGIN_MOBILE = $row['smobile'];

   $login_class_id = $row['sclass'];
   $login_section_id = $row['ssec'];


   require('../linker/sessionCommon.php');
	
   
   if(!isset($_SESSION['login_user_student'])){
      header("location:slogin.php");
   }
?>
