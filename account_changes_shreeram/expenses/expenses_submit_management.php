<?php
include('../session.php');
require("../account_management.php");
$account = new account_management_classes();

$valid_extensions = array("jpeg", "jpg", "png"); // valid extensions
$path = '../schoolfile/'.$fianlsubdomain.'/expenses_file/'; // upload directory
if(isset($_POST['category']))
{

	$category = $_POST['category'];
	$name = $_POST['name'];
	
	if(!isset($_POST['quantity']))
	{
		$quantity=0;
	}
	else
	{
		$quantity = $_POST['quantity'];
	}

	$amount = $_POST['amount'];
	$description = $_POST['description'];
	
	$date = date('Y-m-d');

	if(is_numeric($quantity) && is_numeric($amount)) 
	{
		
		
			$file = $_FILES['file']['name'];
			$tem_file = $_FILES['file']['tmp_name'];
			$ext1 = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			if(in_array($ext1,$valid_extensions)) 
	 		{     
				if(file_exists($path.$file)==false)
				{
					$account->insertSchoolAccount('', $category, 0, $amount,$date);
					$max_account_id = $account->getMaxSchoolAccountId();

					move_uploaded_file($tem_file,$path.$file);
					$account->insertExpenses($max_account_id,$category,$name, $quantity, $file, $amount, $description, $date);
					
					
			 		echo "Sucessfully upload record";
				}
				else
				{
					echo "File is already exist";
				}
			}
			else
			{
				$file='';
				$account->insertSchoolAccount('', $category, 0, $amount,$date);
				$max_account_id = $account->getMaxSchoolAccountId();
				$account->insertExpenses($max_account_id,$category,$name, $quantity, $file, $amount, $description, $date);
				echo "Sucessfully upload record";
			}
		
		
	}
	else
	{
		echo "Please Enter The Quantity & Amount In Number !!";
	}
	
}
?>