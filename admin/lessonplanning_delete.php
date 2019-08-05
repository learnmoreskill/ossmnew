<?php include('session.php'); ?>

 	
<?php
	$id=$_REQUEST['id'];
	$query = "UPDATE `lesson_planning` SET `status`= 1 WHERE id=$id"; 
	$result = mysqli_query($db,$query) or die ( mysqli_error());
	header("Location: lessonplanning.php"); 
?>