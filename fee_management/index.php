<?php 
   session_start();
  	if(isset($_SESSION['login_user_admin']) OR isset($_SESSION['login_user_accountant']) OR isset($_SESSION['login_user_manager'])){
   	}else{
      header("location:login.php");
   	} 
?>
<!DOCTYPE html>
<html>
<head>
	<title>Redirecting</title>
</head>
<script type="text/javascript">window.location = "school/index.php";</script>
<body>
<p>Please wait,,page redirecting.</p>

</body>
</html>
