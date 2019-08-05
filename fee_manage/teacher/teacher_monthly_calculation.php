<?php
require("../account_management.php");
$account = new account_management_classes();

$first_date = $_GET['first_date'];
$second_date = $_GET['second_date'];
$empId = $_GET['emp_id'];


$n_first_date =  $account->get_nepali_month_num($first_date);
$n_second_date =  $account->get_nepali_month_num($second_date);
$staff_salary = $account->get_employee_salary($empId);
$diff_month = $n_second_date-$n_first_date+1;
$total= $staff_salary*$diff_month;
echo $total;
?>