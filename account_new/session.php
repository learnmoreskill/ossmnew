<?php
   include_once('../config/config.php');
   session_start();
   //Dont remove below line
   include_once("nepaliDate.php");
   
   
       

       
   $LOGIN_CAT = $login_cat = 5;

   $LOGIN_ID = $login_session1 = 2;
      



   $ses_sql1 = mysqli_query($db,"SELECT * FROM `schooldetails` ");
   
   $row1 = mysqli_fetch_array($ses_sql1,MYSQLI_ASSOC);
   //mysqli_close($db);  

   $login_session_a = $row1['school_name'];
   $login_session_b = $row1['school_code'];
   $login_session_c = $row1['school_address'];
   $login_session_d = $row1['slogo'];
   $login_session_e = $row1['pan_no'];
   $login_session_f = $row1['phone_no'];
   $login_session_g = $row1['estd'];
   $login_session_h = $row1['reserved_date'];

   $login_date_type = $row1['date_type'];


   $login_session_bulksmstoken = $row1['sms_token'];	
   
  /*if(isset($_SESSION['login_user_admin']) OR isset($_SESSION['login_user_accountant']) OR isset($_SESSION['login_user_manager'])){
   }else{
      header("location:login.php");
   }*/
?>