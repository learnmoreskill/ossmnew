<?php
include('../load_backstage.php');

if(isset($_REQUEST['classId']))
{
	$classId = $_REQUEST['classId'];
	$feetype = $_REQUEST['fee_type'];
	$feetype = str_replace(' ', '_', $feetype);
	$feetype = strtolower($feetype);
	
	echo  $account->get_fee_by_class_id_and_feetype($classId,$feetype);

}


?>