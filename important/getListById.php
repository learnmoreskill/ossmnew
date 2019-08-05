<?php
	include('../config/config.php');

	// old for student to be removed
	/*if (isset($_GET["q"])){
			$class = $_GET['q'];

		 	$sqlsection = "SELECT * FROM section INNER JOIN class ON `section`.`section_class` = `class`.`class_id` where `class`.`class_name`='$class'";
		    $resultsection = $db->query($sqlsection);
		    echo "<option value='' >Select Section</option>";
		    while($row1 = $resultsection->fetch_assoc()) {


		  echo "<option value='".$row1['section_name']."'>".$row1['section_name']."</option>";
		 }
		 exit;



		}else */
	// Get section list by class id 
	 if (isset($_GET["classforsection"])){
			$class_id = $_GET['classforsection'];

		 	$sqlsection = "SELECT * FROM `section` WHERE `section_class`='$class_id' AND `section`.`status` = 0 ";
		    $resultsection = $db->query($sqlsection);
		    echo "<option value='' >Select Section</option>";
		    while($row1 = $resultsection->fetch_assoc()) {


		  echo "<option value='".$row1['section_id']."'>".$row1['section_name']."</option>";
		 }
		 exit;
	// Get subject list by class id
	}elseif (isset($_GET["classforsubject"])) {

			$class_id = $_GET['classforsubject'];

			$sqlsection = "SELECT * FROM `subject` WHERE `subject_class`='$class_id' AND `status`=0 ORDER BY `subject`.`sort_order`";
		    $resultsection = $db->query($sqlsection);
		    echo "<option value='' >Select Subject</option>";
		    while($row1 = $resultsection->fetch_assoc()) {


		  echo "<option value='".$row1['subject_id']."'>".$row1['subject_name']."</option>";
		 }
		 exit;

	// Get exam type list by with selected id
	}elseif (isset($_GET["examTypeListSelectedWithExcept"])) {

			$selected_id = $_GET['examTypeListSelectedWithExcept'];

			$except_exam_id = $_GET['except_exam_id'];

			$sqlexamtype = "SELECT * FROM `examtype` ";
		    $resultexamtype = $db->query($sqlexamtype);
		    echo "<option value='' >Select Exam Type</option>";
		    while($row1 = $resultexamtype->fetch_assoc()) {

		    	if ($row1['examtype_id']!=$except_exam_id) {
		    	 	

		  			echo "<option value='".$row1['examtype_id']."' ".(($row1['examtype_id']==$selected_id)? 'selected' : '')." >".$row1['examtype_name']."</option>";
		  		}
		 }
		 exit;
	
	// Get Subject List By Class Id Unselected
	}elseif (isset($_GET["subjectListByClassIdUnselected"])) {

			$class_id = $_GET['subjectListByClassIdUnselected'];

			 	$sqlsection = "SELECT * FROM `subject` WHERE `subject_class` = '$class_id' AND `status`=0 ORDER BY `subject`.`sort_order` ";
			    $resultsection = $db->query($sqlsection);
			    echo "<option value='' >Select Subject</option>";
			    while($row1 = $resultsection->fetch_assoc()) {


			  echo "<option value='".$row1['subject_id']."'>".$row1['subject_name']."</option>";
			 }
			 exit;
		
	// Get Class Rate list by class id
	}elseif (isset($_GET["classRateByClassId"])) {

			$class_id = $_GET['classRateByClassId'];

			$sql = "SELECT * FROM `class` WHERE `class_id` = '$class_id' ";
		    $result = $db->query($sql);
		    if ($result) {
		    	$row = $result->fetch_object();
		    	echo json_encode($row);
		    }else{
		    	echo "";
		    }
		 exit;
		
	}

?>
