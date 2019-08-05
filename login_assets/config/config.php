<?php
	$servername = "localhost";
	$username = "root";
	$password = "12345";
	$db="a1pathshalaschools";
	// Create connection

	// $conn = new mysqli($servername, $username, $password);
	$conn = mysqli_connect($servername, $username, $password,$db);
	// Check connection
	if ($conn->connect_error) {
		// echo "connect error";
	    die("Connection failed: " . $conn->connect_error);
	} 
	else{
		// echo "Connected successfully";
	}	
?>