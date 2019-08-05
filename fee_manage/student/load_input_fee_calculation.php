<?php
require("../account_management.php");
require("../nepalidate.php");
$account = new account_management_classes();
if(isset($_REQUEST['second_month']))
{
	$first_month = $_REQUEST['first_month'];
	$second_month = $_REQUEST['second_month'];
	$f_month_number = $account->get_nepali_month_num($first_month);
	$s_month_number = $account->get_nepali_month_num($second_month);

	if($s_month_number<$f_month_number)
	{
		$s_month_number = $s_month_number +12;
	}
	$diff_month = $s_month_number-$f_month_number;
	$diff_month = $diff_month+1;


	$bill_details = $account->get_student_bill_deatails_by_bill_id($_REQUEST['bill_id']); 
	$student_id = $bill_details->std_id;
	$feetype = $account->get_feetype_by_feetype_id($bill_details->feetype_id);
	$student_feerate = $account->get_fee_by_feetype_student_id($student_id,$feetype);

	
	$total_fee = $student_feerate * $diff_month;
	echo $total_fee;
}

if(isset($_REQUEST['add_due_date']))
{
	$add_due_date = $_REQUEST['add_due_date'];
	$bill_id = $_REQUEST['bill_id'];
	$className = $_REQUEST['className'];
	$bill_details = $account->get_student_bill_deatails_by_bill_id($_REQUEST['bill_id']); 
	$feetype_id = $bill_details->feetype_id;
	$std_id = $bill_details->std_id;
	$bus_id = $account->get_bus_id_by_student_id($std_id);
	$feetype = $account->get_feetype_by_feetype_id($feetype_id);
	$feetypelower = strtolower($feetype);

	$current_date = $nepalidate->full;
	$current_month = date("$nepaliDate->nmonth",strtotime($current_date));
	$selected_month = date("$nepaliDate->nmonth",strtotime($add_due_date));

	$current_year = date("$nepaliDate->year",strtotime($current_date));
	$selected_year = date("$nepaliDate->year",strtotime($add_due_date));
	$diff_month = $current_month - $selected_month;
	$diff_year = $current_year - $selected_year;
	$message = '';
	if($diff_year>0)
	{
		$month = $diff_year*12;
		$c_month = $month + $current_month;
	}
	else if($diff_year<0)
	{
		$message = 'You could not select this year !!';
	}
	else
	{
		if($diff_month<0)
		{
			$message = 'You could not select this month !!';
		}
		else
		{
			$c_month = $current_month;
		}
	}

	if($feetype=='Bus Fee')
	{
		
		$fee_rate = $account->get_bus_fee_rate_by_bus_id($bus_id);
	}
	else
	{
		$feetypelower = str_replace(' ', '_', $feetypelower);
		$fee_rate = $account->get_fee_by_class_name($className,$feetypelower);
	}

	if($message=='')
	{
		$new_month_diff = $c_month-$selected_month;
		$deu_amount = $fee_rate*$new_month_diff;
		echo $deu_amount;
	}
	else
	{
		echo $message;
	}

	

}


if(isset($_REQUEST['edit_due_date']))
{
	$edit_due_date = $_REQUEST['edit_due_date'];
	$bill_id = $_REQUEST['bill_id'];
	$className = $_REQUEST['className'];
	$bill_details = $account->get_student_bill_deatails_by_bill_id($_REQUEST['bill_id']); 
	$feetype_id = $bill_details->feetype_id;
	$std_id = $bill_details->std_id;
	$bus_id = $account->get_bus_id_by_student_id($std_id);
	$feetype = $account->get_feetype_by_feetype_id($feetype_id);
	$feetypelower = strtolower($feetype);

	$current_date = $bill_details->last_payment_date;
	$current_month = date("$nepaliDate->nmonth",strtotime($current_date));
	$selected_month = date("$nepaliDate->nmonth",strtotime($edit_due_date));

	$current_year = date("$nepaliDate->year",strtotime($current_date));
	$selected_year = date("$nepaliDate->year",strtotime($edit_due_date));
	$diff_month = $current_month - $selected_month;
	$diff_year = $current_year - $selected_year;
	$message = '';
	if($diff_year>0)
	{
		$month = $diff_year*12;
		$c_month = $month + $current_month;
	}
	else if($diff_year<0)
	{
		$message = 'You could not select this year !!';
	}
	else
	{
		if($diff_month<0)
		{
			$message = 'You could not select this month !!';
		}
		else
		{
			$c_month = $current_month;
		}
	}

	if($feetype=='Bus Fee')
	{
		
		$fee_rate = $account->get_bus_fee_rate_by_bus_id($bus_id);
	}
	else
	{
		$feetypelower = str_replace(' ', '_', $feetypelower);
		$fee_rate = $account->get_fee_by_class_name($className,$feetypelower);
	}

	if($message=='')
	{
		$new_month_diff = $c_month-$selected_month;
		$deu_amount = $fee_rate*$new_month_diff;
		echo $deu_amount;
	}
	else
	{
		echo $message;
	}

	

}
?>