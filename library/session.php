<?php
   /*include('../config/config.php');*/
   session_start();
   
   /*$user_check = $_SESSION['login_user_admin'];
   
   $ses_sql = mysqli_query($db,"select * from principal where pemail = '$user_check' and status = 0 ");
   
   $row = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);
   //mysqli_close($db);
   
   //$login_session = $row['username'];
   $login_session1 = $row['pid'];
   $login_session2 = $row['pname'];
   $login_session3 = $row['pemail'];
   $login_session4 = $row['pschool'];
   $login_session5 = $row['aimage'];*/

	
   
   if(isset($_SESSION['login_user_admin']) OR isset($_SESSION['login_user_librarian'])  OR isset($_SESSION['login_user_manager'])){
   }else{
      header("location:login.php");
   }

?>