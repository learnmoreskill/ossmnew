<!DOCTYPE html>
<html>
<head>
	<title>Manage a1pathshala</title>
	<link href="css/googleapis.css" rel="stylesheet" >
  	<link href="css/style.css" rel="stylesheet" />

</head>
<body>

	<div id="login_div" class="main-div">
    <h3>Super Admin Login</h3>
    <input type="email" placeholder="Email..." id="email_field" />
    <input type="password" placeholder="Password..." id="password_field" />

    <button onclick="login()">Login</button>
  </div>

  <div id="user_div" class="loggedin-div">
    <h3>Welcome</h3>
    <p id="user_para">Welcome to Firebase web login Example. You're currently logged in.</p>
    <a href="a1.php">a1</a>
    <a href="a2.php">a2</a>
    <button onclick="logout()">Logout</button>
  </div>






  		<!-- Firebase App is always required and must be first -->
		<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-app.js"></script>
		<!-- Add additional services that you want to use -->
		<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-auth.js"></script>
		<script src="https://www.gstatic.com/firebasejs/5.4.2/firebase-database.js"></script>

		<script src="js/f_hackster.js"></script>
		<script src="js/index.js"></script>

</body>
</html>

 