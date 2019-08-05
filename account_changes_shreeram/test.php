<?php
require("account_management.php");
$account = new account_management_classes();
echo $account->total_income();
echo $account->total_expenses();
$school_details = json_decode($account->get_school_details_by_id());
echo $school_details->school_name;
?>