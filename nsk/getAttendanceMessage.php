<?php
	include('session.php');
	$section_id = $_GET['secId'];
	$class_id = $_GET['classId'];

    $cd = date("Y-m-d");
    $sqlw1 = "SELECT abbit FROM abcheck WHERE abclass='$class_id' and absec='$section_id' and abdate='$cd'";
    $resultw1 = $db->query($sqlw1);
    if ($resultw1->num_rows > 0) {
        while($row = $resultw1->fetch_assoc()) {
            $setabbit = $row["abbit"];
        }
    }
    if ($setabbit == '1') {
    	echo "The attendace has already been taken for this class. You can click the below button to view today's class strength.";
    	exit;
    } else {
    	echo "Hello, Ready for the attendance.";
    	exit;
    }

?>