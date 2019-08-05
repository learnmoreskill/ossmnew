<?php
class hackster
{
   function get_teacher_details()
		{
			require("../config/config.php");
			$myArray = array();

				$result = mysqli_query($db, "SELECT * FROM `teachers`");

				while($row = mysqli_fetch_assoc($result)) {
			            $myArray[] = $row;
			    }
				mysqli_close($db);
				return json_encode($myArray);
		}
	function get_student_details()
		{
			require("../config/config.php");
				$myArray = array();

				$result = mysqli_query($db, "SELECT * FROM `studentinfo`");

				while($row = mysqli_fetch_assoc($result)) {
			            $myArray[] = $row;
			    }
				mysqli_close($db);
				return json_encode($myArray);
		}
	function get_parent_details()
		{
			require("../config/config.php");
			$myArray = array();
				$result = mysqli_query($db, "SELECT * FROM `parents`");
				while($row = mysqli_fetch_assoc($result)) {
			            $myArray[] = $row;
			    }
				mysqli_close($db);
				return json_encode($myArray);
		}
	function schoolname()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `school_name`, `school_code`  FROM `schooldetails`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}
	function updateStudentEmailAndPassword($newemail,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `studentinfo` SET `semail`='$newemail', `sgetter`='123456' WHERE `sid` = '$id'");
			mysqli_close($db);
		}
	function updateStudentPassword($id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `studentinfo` SET `sgetter`='123456' WHERE `sid` = '$id'");
			mysqli_close($db);
		}
	function parent_email_exist_except_id($email,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `parent_id`  FROM `parents` WHERE `spemail`='$email' AND `parent_id`<>'$id'");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function updateParentEmailAndPassword($newemail,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `parents` SET `spemail`='$newemail', `spphone`='123456' WHERE `parent_id` = '$id'");
			mysqli_close($db);
		}
	function updateParentPassword($id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `parents` SET `spphone`='123456' WHERE `parent_id` = '$id'");
			mysqli_close($db);
		}
	function student_email_exist_except_id($email,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `sid`  FROM `studentinfo` WHERE `semail`='$email' AND `sid`<>'$id'");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function updateTeacherEmailAndPassword($newemail,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `teachers` SET `temail`='$newemail', `tgetter`='123456' WHERE `tid` = '$id'");
			mysqli_close($db);
		}
	function updateTeacherPassword($id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `teachers` SET `tgetter`='123456' WHERE `tid` = '$id'");
			mysqli_close($db);
		}
	function teacher_email_exist_except_id($email,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `tid`  FROM `teachers` WHERE `temail`='$email' AND `tid`<>'$id'");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
}

$hackster = new hackster();
	if($_SERVER['REQUEST_METHOD']=='POST') {
		if (isset($_POST['updateparentlogin'])) {
			$schoolname = json_decode($hackster->schoolname());
			$code = $schoolname->school_code."9724142915";
			$key = $_POST["updateparentlogin"];
			if ($code!=$key) {
			?> <script> alert('sorry dude,,you are not authorised!!!'); window.location.href = 'userlogin.php'; </script> <?php
			}else{
			$parents = json_decode($hackster->get_parent_details());
			$firstschool = strtok($schoolname->school_name, " ");
			$firstschool = trim($firstschool);
			$firstschool = strtolower($firstschool);

			

			foreach ($parents as $parents) {
				$id = $parents->parent_id;
				$email = $parents->spemail;
				if (!empty($parents->spname)) {
					$name = $parents->spname;
				}else{
					$name = $parents->smname;
				}
				

				if(!empty($email)){
					//Invalid email format
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	
	$name1 = strtolower($name);
	$remove = ['.', 'mrs', 'miss', 'ms', 'master', 'dr', 'mr'];
	$name1 = str_replace($remove,"",$name1);
	$firstword = strtok($name1, " ");
	$firstwordfilter = trim($firstword); 


										if (empty($firstwordfilter)) {
											$firstwordfilter = "abc";
										}
										$newemail = $firstwordfilter."@".$firstschool.".com";
										$checkexist = $hackster->parent_email_exist_except_id($newemail,$id);
										if ($checkexist) {
											for ($i=1; $i < 5000; $i++) {
												if (empty($firstwordfilter)) {
													$firstwordfilter = "abc";
												}
												$newemail=$firstwordfilter.$i."@".$firstschool.".com";
												$checkexist1 = $hackster->parent_email_exist_except_id($newemail,$id);
												if ($checkexist1) {
													continue;
													}else{
														$hackster->updateParentEmailAndPassword($newemail,$id);
														break;
													}
											
											}
									}else{
										$hackster->updateParentEmailAndPassword($newemail,$id);
									}
                               
                              }else if ($hackster->parent_email_exist_except_id($email,$id)) {  

    $name1 = strtolower($name);
	$remove = ['.', 'mrs', 'miss', 'ms', 'master', 'dr', 'mr'];
	$name1 = str_replace($remove,"",$name1);
	$firstword = strtok($name1, " ");
	$firstwordfilter = trim($firstword); 
										if (empty($firstwordfilter)) {
											$firstwordfilter = "abc";
										}
										$newemail = $firstwordfilter."@".$firstschool.".com";
										$checkexist = $hackster->parent_email_exist_except_id($newemail,$id);
										if ($checkexist) {
											for ($i=1; $i < 5000; $i++) {
												if (empty($firstwordfilter)) {
													$firstwordfilter = "abc";
												}
												$newemail=$firstwordfilter.$i."@".$firstschool.".com";
												$checkexist1 = $hackster->parent_email_exist_except_id($newemail,$id);
												if ($checkexist1) {
													continue;
													}else{
														$hackster->updateParentEmailAndPassword($newemail,$id);
														break;
													}
											
											}
									}else{
										$hackster->updateParentEmailAndPassword($newemail,$id);
									}
                          	}else{
                          		if (strlen($students->spphone)<6) {
                          		$hackster->updateParentPassword($id);
                          		}
                          	}				

				}else{ 
	$name1 = strtolower($name);
	$remove = ['.', 'mrs', 'miss', 'ms', 'master', 'dr', 'mr'];
	$name1 = str_replace($remove,"",$name1);
	$firstword = strtok($name1, " ");
	$firstwordfilter = trim($firstword); 
					if (empty($firstwordfilter)) {
						$firstwordfilter = "abc";
					}
					$newemail = $firstwordfilter."@".$firstschool.".com";
					$checkexist = $hackster->parent_email_exist_except_id($newemail,$id);
					if ($checkexist) {
						for ($i=1; $i < 5000; $i++) {
							if (empty($firstwordfilter)) {
								$firstwordfilter = "abc";
							}
							$newemail=$firstwordfilter.$i."@".$firstschool.".com";
							$checkexist1 = $hackster->parent_email_exist_except_id($newemail,$id);
							if ($checkexist1) {
								continue;
							}else{
								$hackster->updateParentEmailAndPassword($newemail,$id);
								break;
							}
						
						}
					}else{
						$hackster->updateParentEmailAndPassword($newemail,$id);
					}
				}
			}
			?> <script> alert('parent login details update successfully'); window.location.href = 'userlogin.php'; </script> <?php
		}

		}else if (isset($_POST['updatestudentlogin'])) {
			$schoolname = json_decode($hackster->schoolname());
			$code = $schoolname->school_code."9724142915";
			$key = $_POST["updatestudentlogin"];
			if ($code!=$key) {
			?> <script> alert('sorry dude,,you are not authorised!!!'); window.location.href = 'userlogin.php'; </script> <?php
			}else{
			$students = json_decode($hackster->get_student_details());
			$firstschool = strtok($schoolname->school_name, " ");
			$firstschool = trim($firstschool);
			$firstschool = strtolower($firstschool);

			

			foreach ($students as $students) {
				$id = $students->sid;
				$email = $students->semail;
				$name = $students->sname;

				if(!empty($email)){
					//Invalid email format
					if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
										$firstword = strtok($name, " ");
										$firstword = trim($firstword);
										$firstword = str_replace('.', '', $firstword);
										$firstwordfilter = strtolower($firstword);
										if (empty($firstwordfilter)) {
											$firstwordfilter = "abc";
										}
										$newemail = $firstwordfilter."@".$firstschool.".com";
										$checkexist = $hackster->student_email_exist_except_id($newemail,$id);
										if ($checkexist) {
											for ($i=1; $i < 5000; $i++) {
												if (empty($firstwordfilter)) {
													$firstwordfilter = "abc";
												}
												$newemail=$firstwordfilter.$i."@".$firstschool.".com";
												$checkexist1 = $hackster->student_email_exist_except_id($newemail,$id);
												if ($checkexist1) {
													continue;
													}else{
														$hackster->updateStudentEmailAndPassword($newemail,$id);
														break;
													}
											
											}
									}else{
										$hackster->updateStudentEmailAndPassword($newemail,$id);
									}
                               
                              }else if ($hackster->student_email_exist_except_id($email,$id)) {  

                              			$firstword = strtok($name, " ");
										$firstword = trim($firstword);
										$firstword = str_replace('.', '', $firstword);
										$firstwordfilter = strtolower($firstword);
										if (empty($firstwordfilter)) {
											$firstwordfilter = "abc";
										}
										$newemail = $firstwordfilter."@".$firstschool.".com";
										$checkexist = $hackster->student_email_exist_except_id($newemail,$id);
										if ($checkexist) {
											for ($i=1; $i < 5000; $i++) {
												if (empty($firstwordfilter)) {
													$firstwordfilter = "abc";
												}
												$newemail=$firstwordfilter.$i."@".$firstschool.".com";
												$checkexist1 = $hackster->student_email_exist_except_id($newemail,$id);
												if ($checkexist1) {
													continue;
													}else{
														$hackster->updateStudentEmailAndPassword($newemail,$id);
														break;
													}
											
											}
									}else{
										$hackster->updateStudentEmailAndPassword($newemail,$id);
									}
                          	}else{
                          		if (strlen($students->sgetter)<6) {
                          		$hackster->updateStudentPassword($id);
                          		}
                          	}				

				}else{ 
					$firstword = strtok($name, " ");
					$firstword = trim($firstword);
					$firstword = str_replace('.', '', $firstword);
					$firstwordfilter = strtolower($firstword);
					if (empty($firstwordfilter)) {
											$firstwordfilter = "abc";
										}
					$newemail = $firstwordfilter."@".$firstschool.".com";
					$checkexist = $hackster->student_email_exist_except_id($newemail,$id);
					if ($checkexist) {
						for ($i=1; $i < 5000; $i++) {
							if (empty($firstwordfilter)) {
								$firstwordfilter = "abc";
							}
							$newemail=$firstwordfilter.$i."@".$firstschool.".com";
							$checkexist1 = $hackster->student_email_exist_except_id($newemail,$id);
							if ($checkexist1) {
								continue;
							}else{
								$hackster->updateStudentEmailAndPassword($newemail,$id);
								break;
							}
						
						}
					}else{
						$hackster->updateStudentEmailAndPassword($newemail,$id);
					}
				}
			}
			?> <script> alert('student login details update successfully'); window.location.href = 'userlogin.php'; </script> <?php
		}
		}else if (isset($_POST['updateteacherlogin'])) {
			$schoolname = json_decode($hackster->schoolname());
			$code = $schoolname->school_code."9724142915";
			$key = $_POST["updateteacherlogin"];
			if ($code!=$key) {
			?> <script> alert('sorry dude,,you are not authorised!!!'); window.location.href = 'userlogin.php'; </script> <?php
			}else{

				$teachers = json_decode($hackster->get_teacher_details());
				$schoolname = json_decode($hackster->schoolname());
				$firstschool = strtok($schoolname->school_name, " ");
				$firstschool = trim($firstschool);
				$firstschool = strtolower($firstschool);

				

				foreach ($teachers as $teachers) {
					$id = $teachers->tid;
					$email = $teachers->temail;
					$name = $teachers->tname;

					if(!empty($email)){
						//Invalid email format
						if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
											$firstword = strtok($name, " ");
											$firstword = trim($firstword);
											$firstword = str_replace('.', '', $firstword);
											$firstwordfilter = strtolower($firstword);
											if (empty($firstwordfilter)) {
												$firstwordfilter = "abc";
											}
											$newemail = $firstwordfilter."@".$firstschool.".com";
											$checkexist = $hackster->teacher_email_exist_except_id($newemail,$id);
											if ($checkexist) {
												for ($i=1; $i < 5000; $i++) {
													if (empty($firstwordfilter)) {
														$firstwordfilter = "abc";
													}
													$newemail=$firstwordfilter.$i."@".$firstschool.".com";
													$checkexist1 = $hackster->teacher_email_exist_except_id($newemail,$id);
													if ($checkexist1) {
														continue;
														}else{
															$hackster->updateTeacherEmailAndPassword($newemail,$id);
															break;
														}
												
												}
										}else{
											$hackster->updateTeacherEmailAndPassword($newemail,$id);
										}
	                               
	                              }else if ($hackster->teacher_email_exist_except_id($email,$id)) {  

	                              			$firstword = strtok($name, " ");
											$firstword = trim($firstword);
											$firstword = str_replace('.', '', $firstword);
											$firstwordfilter = strtolower($firstword);
											if (empty($firstwordfilter)) {
												$firstwordfilter = "abc";
											}
											$newemail = $firstwordfilter."@".$firstschool.".com";
											$checkexist = $hackster->teacher_email_exist_except_id($newemail,$id);
											if ($checkexist) {
												for ($i=1; $i < 5000; $i++) {
													if (empty($firstwordfilter)) {
														$firstwordfilter = "abc";
													}
													$newemail=$firstwordfilter.$i."@".$firstschool.".com";
													$checkexist1 = $hackster->teacher_email_exist_except_id($newemail,$id);
													if ($checkexist1) {
														continue;
														}else{
															$hackster->updateTeacherEmailAndPassword($newemail,$id);
															break;
														}
												
												}
										}else{
											$hackster->updateTeacherEmailAndPassword($newemail,$id);
										}
	                          	}else{
	                          		if (strlen($teachers->tgetter)<6) {
	                          		$hackster->updateTeacherPassword($id);
	                          		}
	                          	}				

					}else{ 
						$firstword = strtok($name, " ");
						$firstword = trim($firstword);
						$firstword = str_replace('.', '', $firstword);
						$firstwordfilter = strtolower($firstword);
						if (empty($firstwordfilter)) {
							$firstwordfilter = "abc";
						}
						$newemail = $firstwordfilter."@".$firstschool.".com";
						$checkexist = $hackster->teacher_email_exist_except_id($newemail,$id);
						if ($checkexist) {
							for ($i=1; $i < 5000; $i++) {
								if (empty($firstwordfilter)) {
									$firstwordfilter = "abc";
								}
								$newemail=$firstwordfilter.$i."@".$firstschool.".com";
								$checkexist1 = $hackster->teacher_email_exist_except_id($newemail,$id);
								if ($checkexist1) {
									continue;
								}else{
									$hackster->updateTeacherEmailAndPassword($newemail,$id);
									break;
								}
							
							}
						}else{
							$hackster->updateTeacherEmailAndPassword($newemail,$id);
						}
					}
				}
				?> <script> alert('teacher login details update successfully'); window.location.href = 'userlogin.php'; </script> <?php
		}
			
		}else{
			?> <script> alert('invalid request'); window.location.href = 'userlogin.php'; </script> <?php
	}

	
	}



if(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0' ) {
   ?> <script>  window.location.href = 'userlogin.php'; </script> <?php
} else {
   //echo "not refreshed";
}







?>
<html>
	<head>
		<title>
			Generate email and password script
		</title>
	</head>
	<body>
		<form method="post">
			<h3>Generate Parent Login details</h3>
			<input type="password" name="updateparentlogin" >
			<input type="submit" onclick = "if (! confirm('Are you sure??')) { return false; }">
		</form>
		<form method="post">
			<h3>Generate Student Login details</h3>
			<input type="password" name="updatestudentlogin">
			<input type="submit" onclick = "if (! confirm('Are you sure??')) { return false; }">
		</form>
		<form method="post">
			<h3>Generate Teacher Login details</h3>
			<input type="password" name="updateteacherlogin">
			<input type="submit" onclick = "if (! confirm('Are you sure??')) { return false; }">
		</form>

	</body>
</html>