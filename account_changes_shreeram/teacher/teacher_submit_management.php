<?php
require("../account_management.php");
$account = new account_management_classes();
 
 if(isset($_POST['paying_amount']))
 {
   $t_id =  $_GET['tid'];
  $emp_details = json_decode($account->get_employee_account_details_by_empId($t_id));
 
  
  $first_date = $_POST['first_date']; // fine_charge 
  $second_date = $_POST['second_date']; // fine_charge 
  $t_pay = $_POST['paying_amount']; // fine_charge 
  $t_bonus = $_POST['bonus_amount'];// user email
  $t_deduction = $_POST['Deducted_amount']; // fine_charge description
  $description = $_POST['description'];
  if($description=='')
  {
    $description = '';
  }
  $date=date('Y-m-d');
  $t_pay = (double)$t_pay;
  $t_bonus = (double)$t_bonus;
  $t_deduction = (double)$t_deduction;

$net_pay =  $t_pay + $t_bonus - $t_deduction;
$year = date('Y');
$d = date('d');
$m = $account->get_english_month_num($second_date);
$last_payment_date = $year."-".$m."-".$d;

      $advance = json_decode($account->get_teacher_advance_by_teacher_id_status($t_id));
      $total_advance = 0;
      foreach ($advance as $key) 
      {
        $advance = $key->advance;
        $total_advance = $total_advance + $advance;
      }

$teacher_account_id = $emp_details->teacher_account_id;
$old_balance = $emp_details->current_balance;
$withdraw_balance = $emp_details->total_withdrawal;
$new_balance = $old_balance - $t_pay - $total_advance;
$new_withdraw_balance = $withdraw_balance + $net_pay;
if($new_balance<=0)
{
  $new_balance = 0;
}
$account->update_advance_status($t_id);
$account->update_employee_balance_by_empId($teacher_account_id,$new_balance,$new_withdraw_balance,$last_payment_date);   
 
    if($second_date=='Choose Month')
    {
     $errMSG = "Please Select Payment Month !!";
    } 
    else if(empty($t_pay))
    {
     $errMSG = "Please Enter payment !!";
    }
     
    if(!isset($errMSG))
    {
      $staff_id = 0; 
      $advance = 0;
      $last_payment_date = date('Y-m-d');
      
      $user_name = "Birendra shrama";
      $status = 'Paid';
      $account->insert_teacher_payment($t_id,$staff_id,$t_bonus,$advance,$t_deduction,$net_pay,$last_payment_date,$description,$user_name,$status);
          $errMSG='Successfully Paid';
      $account->insertSchoolAccount('', 'Teacher', 0, $net_pay,$date);
      
    }
  
  echo $errMSG;
 }



//=========== Advance Section ===========
 if(isset($_GET['t_id']))
 {
  $tid = $_GET['t_id'];
  $amount = $_GET['amount'];
  $purpose = $_GET['purpose'];
  $date=date('Y-m-d');
  $staff_id = 0; 
  $bonus = 0;
  $advance = $amount;
  $deduction = 0;
  $net_pay = 0;
  $last_payment_date = date('Y-m-d');
  $description = $purpose;
  $user_name = "Birendra shrama";
  $status = 'Pending';
  $account->insert_teacher_payment($tid,$staff_id,$bonus,$advance,$deduction,$net_pay,$last_payment_date,$description,$user_name,$status);
   echo "Successfully Save !!";
   $account->insertSchoolAccount('', 'Teacher', 0, $advance,$date);
  
 }
?>