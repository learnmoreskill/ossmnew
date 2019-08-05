<?php
include('../session.php');
include('../load_backstage.php');

$date = $nepaliDate->full;

if(isset($_POST['add_income_type'])){

	$errMsgArray  = array();

	$income_type = $_POST['add_income_type'];
	$income_amount = $_POST['income_amount'];
	$payment_mode = $_POST['payment_mode'];
	$income_description = $_POST['description'];	
	$payment_by = $_POST['received_from'];


	if($payment_mode=='cash')
    {
      $payment_number = '';
      $payment_source = '';
    }else{

      $payment_number = $_POST['reference_number'];
      $payment_source = $_POST['bank_name'];

      if (empty($payment_number) || empty($payment_source)) {
        array_push($errMsgArray,'Refrence number or Bank name should not be empty');
      }
    }

	if(!is_numeric($income_amount)){ 
		array_push($errMsgArray,'Amount should be in number');
	}

	if(empty($payment_by)){ 
		array_push($errMsgArray,'Received from shoud not be empty');
	}

	if (empty($errMsgArray)) {
		$bill_number = $account->generate_new_bill_number($school_details->school_code,'income');
		if (!$bill_number) {
			array_push($errMsgArray,'Sorry, Failed to generate bill number');
		}
	}

	if (empty($errMsgArray)) {
		$bill_print_id = $account->add_into_bill_tables($bill_number, 3, 0, 0, 0, 0, 0, 0, 0, 0, $date, 0, $LOGIN_CAT , $LOGIN_ID);
		if (!$bill_print_id) {
			array_push($errMsgArray,'Sorry, Failed to add bill number');
		}
	}

	if (empty($errMsgArray)) {

		$insert_income = $account->insertIncome($bill_print_id, $income_type, $income_amount, $income_description, $payment_mode, $payment_source, $payment_number, $payment_by, $date);

		if (!$insert_income) {
        	array_push($errMsgArray,"Failed to add income");
      	}

		if (empty($errMsgArray)) {
	      $response["status"] = 200;
	      $response["message"] = "Success";
	      $response["bill_id"] = $bill_print_id;

	      $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Inserted', 'income as: '.$income_type.', amount: '.$income_amount, 'account', 'url');
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

   echo json_encode($response);

}

if(isset($_POST['update_income_type'])){
	$errMsgArray  = array();

	$incomeId = $_REQUEST['update_id'];

	$income_type = $_POST['update_income_type'];
	$description = $_POST['update_description'];
	$payment_by = $_POST['update_received_from'];

	if(empty($income_type))
	{ 
		array_push($errMsgArray,'Income title shoud not be empty');
	}
	if(empty($payment_by))
	{ 
		array_push($errMsgArray,'Received from shoud not be empty');
	}

	if (empty($errMsgArray)) {

	
		$update_income = $account->updateIncome($incomeId, $income_type, $description,$payment_by, $date);

		if (!$update_income) {
        	array_push($errMsgArray,"Failed to update income");
      	}

		if (empty($errMsgArray)) {
	      $response["status"] = 200;
	      $response["message"] = "Success";

	      $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Updated', 'income id:'.$incomeId.' as :'.$income_type.', paid by: '.$payment_by, 'account', 'url');
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

   echo json_encode($response);
	

}
?>