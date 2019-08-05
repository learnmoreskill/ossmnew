<?php

   date_default_timezone_set('Asia/Kathmandu');

   require('../config/config.php');
   session_start();
   
   $user_check = $_SESSION['login_user_parent'];
   
   $ses_sql = mysqli_query($db,"select * from parents where spemail = '$user_check' and spstatus = 0 ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

   $countrow = mysqli_num_rows($ses_sql);
   if($countrow != 1) {
   session_destroy();
   unset($_SESSION['login_user_parent']);
   header("Location: ../index.php#parent");
   exit();
    }
   
   $LOGIN_CAT = $login_cat = 4;

   $LOGIN_ID = $login_session1 = $row['parent_id'];
   $LOGIN_NAME = $login_session2 = $row['spname'];
   $login_session3 = $row['smname'];
   $LOGIN_EMAIL = $login_session4 = $row['spemail'];
   $LOGIN_MOBILE = $login_session5 = $row['spnumber'];
   $login_session6 = $row['spnumber_2'];
   $login_session9 = $row['spprofession'];
   $login_session10 = $row['sp_address'];
   $login_session11 = $row['spstatus'];

   require('../linker/sessionCommon.php');

	
   
   if(!isset($_SESSION['login_user_parent'])){
      header("location:login.php");
   }

?>
