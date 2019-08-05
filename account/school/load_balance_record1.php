<?php
require("../account_management.php");
$account = new account_management_classes();

if(isset($_REQUEST['date']))
{
   $date = $_REQUEST['date'];

    $school_expenses_details = json_decode($account->get_school_expenses_record_by_single_date($date));
    $school_income_details = json_decode($account->get_school_income_record_by_date($date));
    $student_income = $account->get_school_income_record_from_student_by_date($date);
    $incomeType_list = json_decode($account->get_incomeType_list());
    $teacher_expenses = $account->get_school_expenses_to_teacher_by_date($date);
    $expenses_category_list = json_decode($account->get_expenses_category_list());
    $total_expenses = $teacher_expenses;
    $total_income = $student_income;
}
else if(isset($_REQUEST['first_date']))
{
    $first_date = $_REQUEST['first_date'];
    $second_date = $_REQUEST['second_date'];
    $school_expenses_details = json_decode($account->get_school_expenses_record_by_two_date($first_date,$second_date));
    $school_income_details = json_decode($account->get_school_income_record_by_two_date($first_date,$second_date));
    $student_income = $account->get_school_income_record_from_student_by_two_date($first_date,$second_date);
    $incomeType_list = json_decode($account->get_incomeType_list());
    $teacher_expenses = $account->get_school_expenses_to_teacher_by_two_date($first_date,$second_date);
    $expenses_category_list = json_decode($account->get_expenses_category_list());
    $total_expenses = $teacher_expenses;
    $total_income = $student_income;
}
else
{
    $school_expenses_details = json_decode($account->get_school_expenses_record());
    $school_income_details = json_decode($account->get_school_income_record());
    $student_income = $account->get_school_income_record_from_student();
    $incomeType_list = json_decode($account->get_incomeType_list());
    $teacher_expenses = $account->get_school_expenses_to_teacher();
    $expenses_category_list = json_decode($account->get_expenses_category_list());
    $total_expenses = $teacher_expenses;
    $total_income = $student_income;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
    <div class="panel-heading">School Balance Sheet</div>
    <div class="row">
        <div class="column">
        </div>
        <div class="column">
        </div>
        <div class="column2">
        </div>
        <div class="column2">
        </div>
    </div>
</body>
</html>
