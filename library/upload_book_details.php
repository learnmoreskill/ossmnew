<?php
require("library_management.php");
$library = new library_management_classes();
date_default_timezone_set('Asia/kathmandu');
$current_date = date('Y-m-d'); 
if(isset($_POST['bookName']))
{
	$className = $_POST['className'];
	$bookName = $_POST['bookName'];
	$bookPublication = $_POST['bookPublication'];
	
	$bookWritter = $_POST['bookWritter'];
	$storageLocation = $_POST['storageLocation'];
	$status = 'true';
	if($className=='' && $bookName == '' && $bookPublication == '' && $bookWritter == '' && $storageLocation == '')
	{
		echo "Fill Data Correctly !!";
	}
	else
	{
		$library->insert_book_stock($className,$bookName,$bookPublication,$bookWritter,$storageLocation,$status);
		echo "Insert The Record Sucessfully !!";
	}
	
}

if(isset($_POST['studentId']))
{
	$studentId = $_POST['studentId'];
	$bookStockId = $_POST['bookStockId'];
	$status = 'true';
	$status1='false';
	$bookName = $library->get_bookName_by_bookStockId_status($status,$bookStockId);
	$studentName = $library->get_student_name_by_studentId($studentId);
	
	if($bookStockId == '' && $studentId == '')
	{
		echo "Fill Data Correctly !!";
	}
	else
	{
		if($studentName == '')
		{
			echo "Invalid Student ID !!";
		}
		else
		{
			if($bookName == '')
			{
				echo "This Book is not avaliable !!";
			}
			else
			{
				$library->insert_student_library_record($bookStockId,$studentId,$current_date,$current_date,$status);
				$library->update_status_book_stock_tables($status1,$bookStockId);
				echo "Insert The Record Sucessfully !!";
			}
		}
	}
	
}

if(isset($_POST['returnbook_studentId']))
{

		$studentId = $_POST['returnbook_studentId'];
		$bookStockId = $_POST['returnbook_bookStockId'];;
		$status = "true";
		$status1="false";
		if($bookStockId == '' && $studentId == '')
		{
			echo "Fill Data Correctly !!";
		}
		else
		{
			$library->update_status_book_stock_tables($status,$bookStockId);
			$library->update_status_student_library_account_tables($status1,$bookStockId,$studentId);
			echo "Insert Return Book Record Sucessfully !!";
		}
		
}

if(isset($_POST['update_className']))
{
	$bookStockId = $_REQUEST['bookStockId'];
	$className = $_POST['update_className'];
	$bookName = $_POST['update_bookName'];
	$bookPublication = $_POST['update_bookPublication'];
	$bookWritter = $_POST['update_bookWritter']; 
	$storageLocation = $_POST['update_storageLocation'];
	if($className=='' && $bookName == '' && $bookPublication == '' && $bookWritter == '' && $storageLocation == '')
	{
		echo "Fill Data Correctly !!";
	}
	else
	{
		$library->update_book_stock($bookStockId,$className,$bookName,$bookPublication,$bookWritter,$storageLocation);
		echo "Update The Record Sucessfully !!";
	}
	
}
?>