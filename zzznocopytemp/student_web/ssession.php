<?php
   include('../config/config.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];
   
   $ses_sql = mysqli_query($db,"select * from studentinfo where semail = '$user_check' ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   
   $login_session = $row['username'];
   $login_session1 = $row['sid'];
   $login_session2 = $row['sroll'];
   $login_session3 = $row['sname'];
   $login_session4 = $row['saddress'];
   $login_session5 = $row['semail'];
   $login_session6 = $row['sgetter'];
   $login_session7 = $row['spname'];
   $login_session8 = $row['spnumber'];
   $login_session9 = $row['spemail'];
   $login_session11 = $row['sschool'];
   $login_session12 = $row['sclass'];
   $login_session13 = $row['ssec'];

	
   
   if(!isset($_SESSION['login_user'])){
      header("location:slogin.php");
   }
?>
