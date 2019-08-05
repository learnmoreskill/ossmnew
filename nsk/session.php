<?php
   include('../config/config.php');
   session_start();
   
   $user_check = $_SESSION['login_user_teacher'];
   
   $ses_sql = mysqli_query($db,"SELECT * FROM `teachers` WHERE `temail` = '$user_check' and `status` = 0 ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $countrow = mysqli_num_rows($ses_sql);
   if($countrow != 1) {
   session_destroy();
   unset($_SESSION['login_user_teacher']);
   header("Location: ../index.php#teacher");
   exit();
    }
   $LOGIN_CAT = $login_cat = 2;

   $LOGIN_ID = $login_session1 = $row['tid'];
   $LOGIN_NAME = $login_session2 = $row['tname'];
   $LOGIN_EMAIL = $login_session3 = $row['temail'];
   $login_session4 = $row['tgetter'];
   $login_session5 = $row['taddress'];
   $login_session6 = $row['tmobile'];
   $login_session9 = $row['tclass'];
   $login_session10 = $row['tsec'];
   $login_session11 = $row['tcount'];
   $LOGIN_IMAGE = $login_session12 = $row['timage'];
   $LOGIN_SEX = $login_session13 = $row['sex'];

   
   require('../linker/sessionCommon.php');


   
   if(!isset($_SESSION['login_user_teacher'])){
      header("location:login.php");
   }

?>
