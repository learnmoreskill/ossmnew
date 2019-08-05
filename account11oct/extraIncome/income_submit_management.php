<?php
require("../account_management.php");
$account = new account_management_classes();

if(isset($_POST['income_type']))
{
	$income_type = $_POST['income_type'];
	$income_amount = $_POST['income_amount'];
	$income_description = $_POST['description'];
	$date = date('Y-m-d');
	if(is_numeric($income_amount))
	{
		$account->insertSchoolAccount($income_type, '', $income_amount, 0,$date);
		$max_account_id = $account->getMaxSchoolAccountId();

		$account->insertIncome($max_account_id,$income_type, $income_amount, $income_description, $date);

		echo "Sucessfully Saved Income Record !!";
	} 
	else
	{
		echo "Amount in number !!";
	}

}

if(isset($_POST['update_income_type']))
{
	$incomeId = $_REQUEST['update_id'];
	$schoolAccountId = $_REQUEST['schoolAccountId'];
	$income_type = $_POST['update_income_type'];
	$amount = $_POST['update_income_amount'];
	$description = $_POST['update_description'];
	$date = date('Y-m-d');
	if(is_numeric($amount))
	{
		$account->updateIncome($incomeId, $income_type, $amount, $description, $date);
		$account->updateSchoolAccount($schoolAccountId,$income_type, '', $amount, 0, $date);
		echo "Sucessfully Update Income Record !!";
	} 
	else
	{
		echo "Amount in number !!";
	}

}
?>