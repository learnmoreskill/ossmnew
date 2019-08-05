<?php

class library_management_classes
{
	
	function insert_book_stock($className,$bookName,$bookPublication,$bookWritter,$storageLocation,$status)
	{
		require('../config/config.php');
		mysqli_query($db, "INSERT INTO `book_stock_tables`(`bookStockId`, `className`, `bookName`, `bookPublication`, `bookWritter`, `storageLocation`, `created_at`, `updated_at`, `status`) VALUES (null,'$className','$bookName','$bookPublication','$bookWritter','$storageLocation',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP,'$status')");
		mysqli_close($db);
	}

	function delete_book_stock($delete_id)
	{
		require('../config/config.php');
		mysqli_query($db, "DELETE FROM `book_stock_tables` WHERE bookStockId='$delete_id'");
		mysqli_close($db);
	}

	function update_book_stock($bookStockId,$className,$bookName,$bookPublication,$bookWritter,$storageLocation)
	{
		require('../config/config.php');
		mysqli_query($db, "UPDATE `book_stock_tables` SET `className`='$className',`bookName`='$bookName',`bookPublication`='$bookPublication',`bookWritter`='$bookWritter',`storageLocation`='$storageLocation',`updated_at`= CURRENT_TIMESTAMP WHERE bookStockId='$bookStockId'");
		mysqli_close($db);
	}

	function get_book_details_by_id($bookStockId)
	{
		require('../config/config.php');
		$response = array();
		$result = mysqli_query($db,"select * from book_stock_tables where bookStockId='$bookStockId'");
		while($row = mysqli_fetch_assoc($result))
		{
				array_push($response,array(
					"bookStockId" => $row['bookStockId'], 
					"bookName" => $row['bookName'],
					"className" => $row['className'],
					"bookPublication" => $row['bookPublication'],
					"bookWritter" => $row['bookWritter'],
					"storageLocation" => $row['storageLocation'],
				));
				
		}
		mysqli_close($db);
		return  json_encode($response[0]);
	}

	function get_book_stock_details()
	{
		require('../config/config.php');
		$response = array();
		$result = mysqli_query($db,"select * from book_stock_tables");
		while($row = mysqli_fetch_assoc($result))
		{
				array_push($response,array(
					"bookStockId" => $row['bookStockId'], 
					"bookName" => $row['bookName'],
					"className" => $row['className'],
					"bookPublication" => $row['bookPublication'],
					"bookWritter" => $row['bookWritter'],
					"storageLocation" => $row['storageLocation'],
				));
				
		}
		mysqli_close($db);
		return  json_encode($response);
	}

	function get_bookStockId_by_className_bookName($className,$bookName)
	{
		$bookStockId = 0;
		require('../config/config.php');
		$result = mysqli_query($db,"select bookStockId from book_stock_tables where className='$className' and bookName='$bookName'");
		while($row = mysqli_fetch_assoc($result))
		{
			$bookStockId = $row['bookStockId'];
		}
		mysqli_close($db);
		return $bookStockId;
	}

	function get_bookName_by_bookStockId($bookStockId)
	{
		$bookName = "";
		require('../config/config.php');
		$result = mysqli_query($db,"select bookName from book_stock_tables where bookStockId='$bookStockId'");
		while($row = mysqli_fetch_assoc($result))
		{
			$bookName = $row['bookName'];
		}
		mysqli_close($db);
		return $bookName;
	}

	function get_bookName_by_bookStockId_status($status,$bookStockId)
	{
		$bookName = "";
		require('../config/config.php');
		$result = mysqli_query($db,"select bookName from book_stock_tables where bookStockId='$bookStockId' and status = '$status'");
		while($row = mysqli_fetch_assoc($result))
		{
			$bookName = $row['bookName'];
		}
		mysqli_close($db);
		return $bookName;
	}
//=============================== student function =====================
	
	function insert_student_library_record($bookStockId,$studentId,$date,$return_date,$status)
	{
		require('../config/config.php');
		mysqli_query($db, "INSERT INTO `student_library_account_tables`(`studentLibAccountId`, `bookStockId`, `studentId`, `date`, `return_date`, `status`) VALUES (null,'$bookStockId','$studentId','$date','$return_date', '$status');");
		mysqli_close($db);
		
	}

	function return_library_book_by_studentName()
	{
		require('../config/config.php');
		mysqli_query($db, "update student_library_account_tables set status='$status' where studentLibAccountId='$studentLibAccountId'");
		mysqli_close($db);
	}

	function update_library_student_status_by_studentLibAccountId($studentLibAccountId,$status)
	{
		require('../config/config.php');
		mysqli_query($db, "update student_library_account_tables set status='$status' where studentLibAccountId='$studentLibAccountId'");
		mysqli_close($db);
	} 

	
	function issue_student_book_details()
	{
		require('../config/config.php');
		$response = array();
		$result = mysqli_query($db, "select * from student_library_account_tables where status='true' order by studentLibAccountId DESC");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
					"studentLibAccountId" => $row['studentLibAccountId'], 
					"bookStockId" => $row['bookStockId'], 
					"studentId" => $row['studentId'],
					"date" => $row['date'],
					"return_date" => $row['return_date'],
					"status" => $row['status'],
					
				));
		}
		mysqli_close($db);
		return  json_encode($response);
	}

	function return_student_book_details()
	{
		require('../config/config.php');
		$response = array();
		$result = mysqli_query($db, "select * from student_library_account_tables where status='false' order by studentLibAccountId DESC");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
					"studentLibAccountId" => $row['studentLibAccountId'], 
					"bookStockId" => $row['bookStockId'], 
					"studentId" => $row['studentId'],
					"date" => $row['date'],
					"return_date" => $row['return_date'],
					"status" => $row['status'],
					
				));
		}
		mysqli_close($db);
		return  json_encode($response);
	}
//================= return book Details ==========================

	function update_status_book_stock_tables($status,$bookStockId)
	{
		require('../config/config.php');
		mysqli_query($db, "update book_stock_tables set status='$status' where bookStockId='$bookStockId'");
		mysqli_close($db);
	}

	function update_status_student_library_account_tables($status,$bookStockId,$studentId)
	{
		require('../config/config.php');
		mysqli_query($db, "update student_library_account_tables set status='$status' where bookStockId='$bookStockId' and studentId='$studentId'");
		mysqli_close($db);
	}

//=================== student section =========================
	function get_student_name_by_studentId($studentId)
	{
		require('../config/config.php');
		$studentName = "";
		$result = mysqli_query($db, "select sname from studentinfo where sid='$studentId'");
		while($row = mysqli_fetch_assoc($result))
		{
			$studentName = $row['sname'];
		}
		mysqli_close($db);
		return  $studentName;
	}

}

?>
