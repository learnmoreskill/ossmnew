<?php
	include('../config/config.php');
/* ======================================= All student by class id =================== */
	if(isset($_REQUEST['classid'])){

		$class_id = $_GET['classid'];
		$year_id = $_GET['year_id'];

		$result ="";

	 	$sqlsection = "SELECT `studentinfo`.`sid`, `studentinfo`.`sname` 
	 	FROM `studentinfo`  
	 	INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
	 	WHERE  `syearhistory`.`year_id`='$year_id' AND `syearhistory`.`class_id`='$class_id' AND `studentinfo`.`status` = 0
	 	ORDER BY `syearhistory`.`section_id`,`syearhistory`.`roll_no`";

	    $resultsection = $db->query($sqlsection);
	    $result = "<option value='' disabled>Select Student</option>";
	    while($row1 = $resultsection->fetch_assoc()) {

		  $result .= "<option value='".$row1['sid']."' selected>".$row1['sname']."</option>";
		}
		echo $result;
/* ======================================= All active student =================== */
	}else if(isset($_REQUEST['allstudent'])){

		$result ="";

	 	$sql = "SELECT `studentinfo`.`sid`, `studentinfo`.`sname` 
	 	FROM `studentinfo`
	 	INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
	 	WHERE  `syearhistory`.`year_id`='$year_id' AND `studentinfo`.`status` = 0
	 	ORDER BY `syearhistory`.`class_id`,`syearhistory`.`section_id`,`syearhistory`.`roll_no`";

	    $resultsql = $db->query($sql);
	    $result = "<option value='' disabled>Select Student</option>";
	    while($row1 = $resultsql->fetch_assoc()) {

		  $result .= "<option value='".$row1['sid']."' selected>".$row1['sname']."</option>";
		}
		echo $result;
/* ======================================= All student by section id =================== */
	}else if(isset($_REQUEST['sectionid'])){

		$sectionid = $_GET['sectionid'];

		$result ="";

	 	$sqlsection = "SELECT `studentinfo`.`sid`, `studentinfo`.`sname` 
	 	FROM `studentinfo`  
	 	WHERE `studentinfo`.`ssec`='$sectionid' AND `studentinfo`.`status` = 0
	 	ORDER BY `studentinfo`.`sroll`";

	    $resultsection = $db->query($sqlsection);
	    $result = "<option value='' disabled>Select Student</option>";
	    while($row1 = $resultsection->fetch_assoc()) {

		  $result .= "<option value='".$row1['sid']."' selected>".$row1['sname']."</option>";
		}
		echo $result;
/* ======================================= All Teacher =================== */
	}else if(isset($_REQUEST['allteacher'])){

		$result ="";

	 	$sql = "SELECT `teachers`.`tid`, `teachers`.`tname` 
	 	FROM `teachers`
	 	WHERE `teachers`.`status` = 0
	 	ORDER BY `teachers`.`tname`";

	    $resultsql = $db->query($sql);
	    $result = "<option value='' disabled>Select Teacher</option>";
	    while($row1 = $resultsql->fetch_assoc()) {

		  $result .= "<option value='".$row1['tid']."' selected>".$row1['tname']."</option>";
		}
		echo $result;
/* ======================================= All staff =================== */
	}else if(isset($_REQUEST['allstaff'])){

		$result ="";

	 	$sql = "SELECT `staff_tbl`.`stid`, `staff_tbl`.`staff_name` 
	 	FROM `staff_tbl`
	 	WHERE `staff_tbl`.`staff_status` = 0
	 	ORDER BY `staff_tbl`.`staff_name`";

	    $resultsql = $db->query($sql);
	    $result = "<option value='' disabled>Select Staff</option>";
	    while($row1 = $resultsql->fetch_assoc()) {

		  $result .= "<option value='".$row1['stid']."' selected>".$row1['staff_name']."</option>";
		}
		echo $result;
/* ======================================= All techer with selecte techer id =================== */
	}else if (isset($_REQUEST['teacher_id'])){
		$teacher_id = $_GET['teacher_id'];
		$result ="";

	 	$sql = "SELECT * FROM `teachers` WHERE `status` = '0'";
	    $resultsql = $db->query($sql);
	    $result = "<option value='' >Select Teacher</option>";
	    while($row = $resultsql->fetch_assoc()) {

		  $result .= "<option value='".$row['tid']."'".(($teacher_id==$row['tid'])?'selected':'')." >".$row['tname']."</option>";
		}
		echo $result;
/* ================= All student by classid and sectionid with selected student id ======== */
	}else if (isset($_REQUEST['classname'])){
		$class_id = $_GET['classname'];
		$section_id = $_GET['sectionname'];
		$studentid = $_GET['studentid'];
		$result2 ="";

	 	$sql2 = "SELECT * FROM `studentinfo` WHERE `sclass` = '$class_id' AND `ssec` = '$section_id' AND `status` = 0 ";
	    $resultsql2 = $db->query($sql2);
	    $result2 = "<option value='' >Select Student</option>";
	    while($row = $resultsql2->fetch_assoc()) {

		  $result2 .= "<option value='".$row['sid']."'".(($studentid==$row['sid'])?'selected':'')." >".$row['sname']."</option>";
		}
		echo $result2;
/* ======================================= medium with selected medium id =================== */
	}else if (isset($_REQUEST['medium_id'])){
		$medium_id = $_GET['medium_id'];

		$result3 ="";

	 	$sql3 = "SELECT * FROM `medium` WHERE `medium_status` = 0 ";
	    $resultsql3 = $db->query($sql3);
	    $result3 = "<option value='' >Select Medium</option>";
	    while($row3 = $resultsql3->fetch_assoc()) {

		  $result3 .= "<option value='".$row3['medium_id']."'".(($medium_id==$row3['medium_id'])?'selected':'')." >".$row3['medium_name']."</option>";
		}
		echo $result3;
/* ======================================= block with selected block id =================== */
	}else if (isset($_REQUEST['block_id'])){
		$block_id = $_GET['block_id'];

		$result4 ="";

	 	$sql4 = "SELECT * FROM `block` WHERE `block_status` = 0 ";
	    $resultsql4 = $db->query($sql4);
	    $result4 = "<option value='' >Select Block</option>";
	    while($row4 = $resultsql4->fetch_assoc()) {

		  $result4 .= "<option value='".$row4['block_id']."'".(($block_id==$row4['block_id'])?'selected':'')." >".$row4['block_name']."</option>";
		}
		echo $result4;

	}



	exit;
 

?>
