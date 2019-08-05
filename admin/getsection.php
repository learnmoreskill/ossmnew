<?php
	include('../config/config.php');
	$class = $_GET['q'];

 	$sqlsection = "SELECT * FROM section INNER JOIN class ON `section`.`section_class` = `class`.`class_id` where `class`.`class_name`='$class'";
    $resultsection = $db->query($sqlsection);
    echo "<option value='' >Select Section</option>";
    while($row1 = $resultsection->fetch_assoc()) {


  echo "<option value='".$row1['section_name']."'>".$row1['section_name']."</option>";
 }
 exit;

?>
