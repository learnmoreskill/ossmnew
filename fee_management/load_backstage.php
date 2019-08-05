<?php 

require("account_management.php");
$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());

?>