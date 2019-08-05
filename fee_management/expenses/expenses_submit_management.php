<?php
include('../session.php');
include('../load_backstage.php');

$date = $nepaliDate->full;

$valid_extensions = array("jpeg", "jpg", "png"); // valid extensions
$path = '../schoolfile/'.$fianlsubdomain.'/expenses_file/'; // upload directo


//=================== Add expenses category by hackster =================
if(isset($_REQUEST['add_expense_request'])){

    $errMsgArray =array();
    $expenses_category = trim($_REQUEST['expenses_category']);
    

    if (empty($expenses_category)) {
      array_push($errMsgArray,"Expense category title can't be empty");
    }else{
    	$checkexist = $account->check_expenses_cat_exist($expenses_category);
        if ($checkexist) { 
          array_push($errMsgArray,"Expense category title already exist");
        }
    }

    if (empty($errMsgArray)) {

      $insertIntoExpensesCat = $account->insert_into_expenses_category($expenses_category);

      if ($insertIntoExpensesCat) {
        $response["status"] = 200;
        $response["message"] = "Success";

        $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Added', 'expenses category as: '.$expenses_category , 'account', 'url');
      }else{
        $response["status"] = 201;
        $response["message"] = "failed";
        $response["errormsg"] = $insertIntoExpensesCat;
      }

    }else{

      $response["status"] = 202;
      $response["message"] = "failed";
      $response["errormsg"] = $errMsgArray;
    }

    echo json_encode($response);
}

//=================== Update expenses category by hackster =================
if(isset($_REQUEST['update_expense_request'])){

    $errMsgArray =array();
    $expenses_category = trim($_REQUEST['expenses_category']);
    $old_expenses_category = trim($_REQUEST['old_expenses_category']);
    $expense_cat_id = $_REQUEST['expense_cat_id'];
    

    if (empty($expenses_category)) {
      array_push($errMsgArray,"Expense category title can't be empty");
    }else{
    	$checkexist = $account->check_expenses_cat_exist_except_id($expenses_category,$expense_cat_id);
        if ($checkexist) { 
          array_push($errMsgArray,"Expense category title already exist");
        }
    }

    if (empty($errMsgArray)) {

      $insertIntoExpensesCat = $account->updateExpensesCategory($expenses_category,$expense_cat_id);

      if ($insertIntoExpensesCat) {
        $response["status"] = 200;
        $response["message"] = "Success";

        $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Updated', 'expenses category id:'.$expense_cat_id.' from: '.$old_expenses_category.' to: '.$expenses_category , 'account', 'url');
      }else{
        $response["status"] = 201;
        $response["message"] = "failed";
        $response["errormsg"] = $insertIntoExpensesCat;
      }

    }else{

      $response["status"] = 202;
      $response["message"] = "failed";
      $response["errormsg"] = $errMsgArray;
    }

    echo json_encode($response);
}

//=================== Add Expenses by hackster =================
if(isset($_REQUEST['add_expenses']))
{
	$errMsgArray  = array();

	$ecat_id = $_POST['category'];
	$expenses_title = trim($_POST['name']);
	$quantity_type = $_POST['quantity_type'];

	if ($quantity_type == 'with') {
		$quantity = $_POST['quantity'];
		$rate = $_POST['rate'];

		if(!is_numeric($quantity)  || $quantity<1){ 
			array_push($errMsgArray,'Quantity must be greater than 0');
		}
		if( !is_numeric($rate) || $rate<1){ 
			array_push($errMsgArray,'Rate must be greater than 0');
		}

		$with_quantity = 1;

	}else{
		$quantity = 0;
		$rate = 0;
		$with_quantity = 0;
	}
	
	$amount =  $_POST['amount'];
	$description = $_POST['description'];

	if(empty($ecat_id)){ 
		array_push($errMsgArray,'Please select expenses category');
	}
	if(empty($expenses_title)){ 
		array_push($errMsgArray,'Expense title should not be empty');
	}
	if( !is_numeric($amount) || $amount<1){ 
		array_push($errMsgArray,'Amount must be greater than 0');
	}
	


	if (empty($errMsgArray)) {

		$file = $_FILES['file']['name'];
		if (!empty($file)) {
			
			$tem_file = $_FILES['file']['tmp_name'];
			$ext1 = strtolower(pathinfo($file, PATHINFO_EXTENSION));
			if(!in_array($ext1,$valid_extensions)) {
				array_push($errMsgArray,'Invalid file format'); 
			}else if(file_exists($path.$file)==true){
				array_push($errMsgArray,'File already exist'); 
			}else{
				if(move_uploaded_file($tem_file,$path.$file)){

				}else{ array_push($errMsgArray,'Failed to upload file,Please try again');  }
			}
		}else{
			$file = '';
		}
		if (empty($errMsgArray)) {

			$bill_number = $account->generate_new_bill_number($school_details->school_code,'expense');


			$bill_print_id = $account->add_into_bill_tables($bill_number, 2, 0, 0, 0, 0, 0, 0, 0, 0, $date, 0, $LOGIN_CAT , $LOGIN_ID);

			$add_expense = $account->insertExpenses($bill_print_id, $ecat_id, $expenses_title , $quantity, $rate, $amount, $file, $description, $date);

			if (!$add_expense) {
	        	array_push($errMsgArray,"Failed to add expense");
	      	}

			if (empty($errMsgArray)) {
		      $response["status"] = 200;
		      $response["message"] = "Success";
		      $response["bill_id"] = $bill_print_id;

		      $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Inserted', 'expenses as:'.$expenses_title.', amount: '.$amount.', bill_id: '.$bill_print_id , 'account', 'url');
		   
		    }else{
		      $response["status"] = 201;
		      $response["message"] = "Failed";
		      $response["errormsg"] = $errMsgArray;
		    }

		}else{

    	$response["status"] = 202;
    	$response["message"] = "Failed";
    	$response["errormsg"] = $errMsgArray;

  	}    

	}else{

    	$response["status"] = 202;
    	$response["message"] = "Failed";
    	$response["errormsg"] = $errMsgArray;

  	}    

 echo json_encode($response);

}
?>