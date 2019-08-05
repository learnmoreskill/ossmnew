<?php
require("../account_management.php");
$account = new account_management_classes();
if(isset($_REQUEST['className']))
{
	$className = $_REQUEST['className'];
	$feetype = $_REQUEST['fee_type'];
	$feetype = str_replace(' ', '_', $feetype);
	$feetype = strtolower($feetype);
	
	echo  $account->get_fee_by_class_name($className,$feetype);

}


?> 