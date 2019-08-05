<?php
	include('../config/config.php');
	$class_id = $_GET['q'];

 	$sqlsection = "select * from subject where subject_class='$class_id' and `status`=0";
    $resultsection = $db->query($sqlsection);
    echo "<option value='' >Select Subject</option>";
    while($row1 = $resultsection->fetch_assoc()) {


  echo "<option value='".$row1['subject_id']."'>".$row1['subject_name']."</option>";
 }
 exit;

?>