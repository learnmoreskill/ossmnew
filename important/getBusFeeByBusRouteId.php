<?php
	include('../config/config.php');
	$id = $_GET['q'];

 	$sql = "SELECT bus_fee_rate FROM bus_route WHERE bus_route_id='$id'";
    $result = $db->query($sql);
    if ($result) {
    	$row = $result->fetch_assoc();
    	echo $row['bus_fee_rate'];
    }else{
    	echo "";
    }   

 exit;

?>
