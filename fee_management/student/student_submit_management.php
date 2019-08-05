<?php
include('../session.php');
include('../load_backstage.php');
include_once("../nepaliDate.php");

$date = $nepaliDate->full;
$nepali_date = $nepaliDate->full;

//=================== Extra fee collection KRISHNA MAGH 2075 =====================
  if(isset($_GET['add_extra_fee'])){

    $feetype_id = $_POST['feetype_id'];// user name
    $class_id = $_POST['class_id'];// user email
    $fee_amount = $_POST['fee_amount'];// user email
    $description=$_POST['description'];

    if (empty($description)) {
      $description='';
    }

    if(empty($class_id))
    {
      $msg =  "Please Select Class Name";
    }
    else if(empty($feetype_id))
    {
      $msg =  "Please Select fee type";
    }
    else if(empty($fee_amount))
    {
      $msg =  "Please enter amount";
    }
   
    else
    {

      $student_id_list = json_decode($account->get_active_student_id_by_class_id($class_id));
      
      $balance = $fee_amount;
      $current_date = $date;
      
      
      foreach ($student_id_list as $key) 
      {
        $std_id = $key->sid;

        $account->add_fee_into_student_due($std_id, $feetype_id, $balance, $description, $current_date, $LOGIN_CAT, $LOGIN_ID, 1);

      }
      $account->insert_into_extra_fee_collection_tables($class_id,$feetype_id,$balance,$description,$current_date);
      $msg =  "Extra fee added successfully";
    }   
    echo $msg;
  }


 //=================== Advance Payment for Student by hackster =================
 if(isset($_REQUEST['advancePaymentForStudent'])){

    $errMsgArray =array();
    $student_id = $_REQUEST['advancePaymentForStudent'];
    $payment_mode = $_POST['advPaymentMode'];
    $credit = $_POST['advAmount'];
    
    $payment_by = $_POST['advReceivedFrom'];

    $due_before = ((!empty($_POST['dueBefore']))? $_POST['dueBefore'] : 0 );
    $advance_before = ((!empty($_POST['advanceBefore']))? $_POST['advanceBefore'] : 0 );


    

    if($payment_mode=='cash')
    {
      $payment_number = '';
      $payment_source = '';
    }else{

      $payment_number = $_POST['advanceRef'];
      $payment_source = $_POST['advBank'];

      if (empty($payment_number) || empty($payment_source)) {
        array_push($errMsgArray,'Refrence number or Bank name should not be empty');
      }
    }
    if (empty($payment_by)) {
      array_push($errMsgArray,'Received from shoud not be empty');
    }

    if (!is_numeric($credit) && !($credit>0) ) {
      array_push($errMsgArray,'Please input valid amount');
    }

    if (empty($errMsgArray)) {

      $description ='';

      $stdBatchDetails = json_decode($account->get_student_batch_details_by_sid($student_id));
      $class_id = $stdBatchDetails->sclass;
      $section_id = $stdBatchDetails->ssec;
      $student_roll_no = $stdBatchDetails->sroll;

      //GENERATE BILL NUMBER
      $bill_number = $account->generate_new_bill_number($school_details->school_code,'payment');

      //$advance_before = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);

      $advance = $advance_before+$credit;

      $payable_amount_after = $due_before-$advance;
      if ($payable_amount_after<0) {
        $payable_amount_after=0;
      }


      $bill_print_id = $account->add_into_bill_tables($bill_number, 0, $due_before, $advance_before, 0, $payable_amount_after, $advance,$class_id,$section_id,$student_roll_no, $date, 0, $LOGIN_CAT , $LOGIN_ID);

      $addToTransactionCredit = $account->insert_into_student_transaction(1 , $bill_print_id , $student_id , 0 , $credit , 0 , $advance , 0 , 0 , $payment_mode , $payment_number , $payment_source , $payment_by , $date , $description);

      if ($addToTransactionCredit) {
        $response["status"] = 200;
        $response["message"] = "Success";
        $response["bill_id"] = $bill_print_id;
      }else{
        $response["status"] = 201;
        $response["message"] = "failed";
        $response["errormsg"] = $addToTransactionCredit;
      }

      

    }else{

      $response["status"] = 202;
      $response["message"] = "failed";
      $response["errormsg"] = $errMsgArray;
    }





      
    /*foreach ($student_id_list as $key) 
    {
      $std_id = $key->sid;
      $account->insert_student_bill($bill_print_id,$std_id, $feetype_id, $balance, $payment, $discount, $paid, $fine, $update_date, $last_payment_date,$description,$userName, $status); 

    }
    $account->insert_extra_fee_collection_tables($className,$feetype_id,$fee_amount,$date);
    $msg =  "Sucessfully Insert Record !!";*/

    

    

    //return json_encode($response);



    // $response["status"] = 202;
    // $response["message"] = "Multiple user found with same email,Please contact your school.";
    // return json_encode($response);
  
    echo json_encode($response);
 }


//=================== Monthly fee collection =====================
 if(isset($_POST['balance']))
 {
    
    $bill_id = $_REQUEST['id'];
    $balance = $_POST['balance'];
    $discount = $_POST['discount'];
    $student_id=$account->get_student_id_by_bill_id($bill_id);
    $school_code=$account->get_school_code_by_student_id($student_id);
    if(isset($_POST['first_date']))
    {
      $first_date = $_POST['first_date'];
      $second_date = $_POST['second_date'];
      $n_first_month = $account->get_nepali_month_num($first_date);
      $n_second_month = $account->get_nepali_month_num($second_date);
      $year = $nepaliDate->year;
      $day = $nepaliDate->date;
      $last_payment_date = $year."-".$n_second_month."-".$day;

    }

    else
      {
        $last_payment_date = $nepaliDate->full;
      }

    
    $description = $_POST['description'];
    $userName = '';
      if($description=='')
      {
        $description = '';
      }

    $fine = $_POST['fine'];
    $payment_type = $_POST['payment_type'];
    
   
     $bill_details = $account->get_student_bill_deatails_by_bill_id($bill_id);
     $max_bill_print_id = $account->get_max_bill_print_id();
     $bill_print_id = $max_bill_print_id + 1;  
     $std_id = $bill_details->std_id;
    
    
    
      $max_bill_print_id_by_std_id = $account->get_max_bill_print_id_by_student_id($std_id);
      $bill_print_status = $account->get_bill_status_by_max_id($max_bill_print_id_by_std_id);  
    
      $feetype_id = $bill_details->feetype_id;
      $feetype_name = $account->get_feetype_title_by_feetype_id($feetype_id);
      $date = $nepaliDate->full;
      $old_balance = $bill_details->balance;
      $remaining_balance = $old_balance - $balance;
      $current_balance =  $balance -$discount + $fine;
      $payment = $payment_type;
      $discount = $discount;
      $paid = $current_balance;
      $last_payment_date = $last_payment_date;
      $status = 'Paid';

      
      
      if($max_bill_print_id_by_std_id=='')
      {
        $bill_number = $school_code."-".$bill_print_id;
        $account->insert_insert_bill_print_tables($std_id,$bill_number,'false',$nepaliDate->full);
      }
         
          $max_bill_print_id_by_std_id = $account->get_max_bill_print_id_by_student_id($std_id);
          if($bill_print_status=='true')
          {
                  $bill_number = $school_code."-".$bill_print_id;
                  $account->insert_insert_bill_print_tables($std_id,$bill_number,'false',$nepaliDate->full);
                  $account->update_student_bill($bill_id,$bill_print_id,$payment,$discount,$paid,$fine,$last_payment_date,$description,$userName,$status);
                  $account->insertSchoolAccount('Student', '', $paid, 0,$date);

                 $balance1 = $remaining_balance;
                  $payment1 = "";
                  $discount1 = 0;
                  $paid1 = 0;
                  $fine1 = 0;
                  $update_date = $bill_details->update_date;
                  $bill_print_id=0;
                  $description1 = "";
                  $userName1 = "";
                  $status1 = "Pending";
            
                 if($feetype_name=='Tution Fee' || $feetype_name=='Bus Fee' || $feetype_name=='Hostel Fee'|| $feetype_name=='Computer Fee')
                {
                  if($remaining_balance<0)
                  {
                    $status1 = 'Advance';
                    $account->insert_student_bill($bill_print_id,$std_id, $feetype_id, $balance1, $payment1, $discount1, $paid1, $fine1, $update_date, $last_payment_date,$description1,$userName1, $status1); 

                  }
                  else
                  {
                    $status1 = 'Pending';
                    $account->insert_student_bill($bill_print_id,$std_id, $feetype_id, $balance1, $payment1, $discount1, $paid1, $fine1, $update_date, $last_payment_date,$description1,$userName1, $status1); 
                  }
                }  
          }
          else
          {
            $account->update_student_bill($bill_id,$max_bill_print_id_by_std_id,$payment,$discount,$paid,$fine,$last_payment_date,$description,$userName,$status);
            $account->insertSchoolAccount('Student', '', $paid, 0,$date);
            $balance1 = $remaining_balance;
            $payment1 = "";
            $discount1 = 0;
            $paid1 = 0;
            $fine1 = 0;
            $update_date = $bill_details->update_date;
            $bill_print_id=0;
            $description1 = "";
            $userName1 = "";
            $status1 = "Pending";
                if($feetype_name=='Tution Fee' || $feetype_name=='Bus Fee' || $feetype_name=='Hostel Fee'|| $feetype_name=='Computer Fee')
                {
                   if($remaining_balance<0)
                    {
                      $status1 = 'Advance';
                      $account->insert_student_bill($bill_print_id,$std_id, $feetype_id, $balance1, $payment1, $discount1, $paid1, $fine1, $update_date, $last_payment_date,$description1,$userName1, $status1); 
                    }
                    else
                    {
                      $status1 = 'Pending';
                      $account->insert_student_bill($bill_print_id,$std_id, $feetype_id, $balance1, $payment1, $discount1, $paid1, $fine1, $update_date, $last_payment_date,$description1,$userName1, $status1); 
                    }    
                }
                 
        }
        
        echo "Sucessfully Saved !!";
      
    
 }

//=============== add Deu Balance hackster 22/jan/2019 ============
  if(isset($_REQUEST['addDue_id'])){ 

    $std_id =  $_REQUEST['addDue_id'];
    $amount = $_POST['due_balance'];
    $description = $_POST['due_description'];


    //$fee_type = $_POST['fee_type'];
    //$feetype_id = $account->get_feetype_id_by_feetype_title($fee_type);


    $feetype_id = $_POST['feetype_id'];
    
    $current_date = $date;

    if (!empty($feetype_id)) {
      if ($amount>0) {

        $feetype_title = $account->get_feetype_title_by_feetype_id($feetype_id);

        if ($feetype_title == 'Pre Discount') {
          $exist_pre_discount_id = $account->student_due_fee_exist_id_by_student_id_feetype_id($std_id, $feetype_id);
            if (!empty($exist_pre_discount_id)) {

              //update
              $result = $account->update_student_due_details_by_id($exist_pre_discount_id,$amount,$description, $current_date, $LOGIN_CAT, $LOGIN_ID);

            }else{
              //insert
              $result = $account->add_fee_into_student_due($std_id, $feetype_id, $amount, $description, $current_date, $LOGIN_CAT, $LOGIN_ID, 1);
            }

            if ($result) {

              $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Updated', 'Pre discount for student id: '.$std_id.', feetype id:'.$feetype_id.', amount:'.$amount , 'account', 'url');

              echo $description." ". $feetype_title." Updated Successfully";
            }else{
              echo "Sorry, Failed to update";
            }
         
        }else{
    
            $result = $account->add_fee_into_student_due($std_id, $feetype_id, $amount, $description, $current_date, $LOGIN_CAT, $LOGIN_ID, 1);
            
            if ($result) {

              $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Inserted', 'Old due for student id: '.$std_id.', feetype id:'.$feetype_id.', amount:'.$amount , 'account', 'url');

              echo $description." ". $feetype_title." Added Successfully";
            }else{
              echo "Sorry, Failed to add";
            }
        }
      }else{  echo "Sorry, Amount must be greater than or equal to 1";  }
    }else{  echo "Sorry, Feetype id is empty";  } 
  }




/*if(isset($_REQUEST['edit_olddueid']))
{
   $date = $nepaliDate->full;
   $bill_id = $_REQUEST['edit_olddueid'];
   $balance = $_POST['edit_due_balance'];
   $fee_type = $_POST['edit_fee_type'];
   $description = $_POST['edit_due_description'];
   $account->update_student_bill_add_deu($bill_id,$balance,$date,$description,'Pending');
   echo "Sucessfully Update Record !!";
}*/


//========================== SUBMIT FEE BY HACKSTER ===================
if(isset($_REQUEST['submit_fee_request']))
{
  

  $errMsgArray  = array();
  $student_id = $_REQUEST['submit_fee_request'];

  $credit = $_POST['grandPay'];
  $grandDiscount = $_POST['grandDiscount'];
  $grandFine = $_POST['grandFine'];

  $payment_mode = $_POST['paymentMode'];
  $payment_by = $_POST['paidby'];
  $description = $_POST['description'];
  

  $totalBalance = $_POST['totalBalance'];
  $due_after = $_POST['duesAfter'];


  $advance_before = $_POST['advanceBefore'];
  $advance_after = $_POST['advanceAfter'];

  $studentDueArray = $_POST['studentDueArray'];

  if (empty($payment_by)) {
      array_push($errMsgArray,'Received from shoud not be empty');
  }  
    
  
    if($payment_mode=='cash'){
      $payment_number = '';
      $payment_source = '';
    }else{

      $payment_number = $_POST['paymentReferenceNumber'];
      $payment_source = $_POST['bankName'];

      if (empty($payment_number) || empty($payment_source)) {
        array_push($errMsgArray,'Refrence number or Bank name should not be empty');
      }
    }
    
    if ($credit<1) {
       $credit  = 0;
    }


  if (empty($errMsgArray)) {
    

      $stdBatchDetails = json_decode($account->get_student_batch_details_by_sid($student_id));
      $class_id = $stdBatchDetails->sclass;
      $section_id = $stdBatchDetails->ssec;
      $student_roll_no = $stdBatchDetails->sroll;

    $bill_number = $account->generate_new_bill_number($school_details->school_code,'payment');

    $bill_print_id = $account->add_into_bill_tables($bill_number, 1, $totalBalance, $advance_before, $advance_before, $due_after, $advance_after,$class_id,$section_id,$student_roll_no, $date, 0, $LOGIN_CAT , $LOGIN_ID);


    $addToTransactionCredit = $account->insert_into_student_transaction(1 , $bill_print_id , $student_id , 0 , $credit , 0 , $advance_after , $grandDiscount , $grandFine , $payment_mode , $payment_number , $payment_source , $payment_by , $date , $description);

    if (!$addToTransactionCredit) {
        array_push($errMsgArray,"Failed to add credit into student transaction");
    }

    $test1 ='';

    if (!empty($studentDueArray)) {
      foreach ($studentDueArray as $studentDueId) {
        
          $updateStudentDueToPaid = $account->update_student_due_to_paid_by_id($studentDueId);

           if ($updateStudentDueToPaid) {

            $addToTransactionDebit = $account->insert_into_student_transaction(0 , $bill_print_id , $student_id , $studentDueId , 0 , 0 , $advance_after , 0 , 0 , 0 , '' , '' , '' , $date , '');
            
            if (!$updateStudentDueToPaid) {
              array_push($errMsgArray,"Failed to add debit into student transaction");
            }

          }else{
            array_push($errMsgArray,"Failed to update student due to paid");
          }


           // $test1 .=$studentDueId."\n";

          // $countOfLoop++;
        
      }
    }

    if ($due_after>0) {

          $feetype_id = $account->get_feetype_id_by_feetype_title('Back Due');

          $addBackDue  = $account->add_fee_into_student_due($student_id, $feetype_id, $due_after, 'Remain due from last payment', $nepali_date, 0, 0, 1);

           if (!$addBackDue) {
            array_push($errMsgArray,"Failed to add remain due".$addBackDue);
          }
    }


     // array_push($errMsgArray,$test1);
    //array_push($errMsgArray,gettype($active_months->month12));
    //array_push($errMsgArray,$credit);

    if (empty($errMsgArray)) {
      $response["status"] = 200;
      $response["message"] = "Success";
      $response["bill_id"] = $bill_print_id;
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

//=============== add Deu Balance  ============
 if(isset($_POST['partdue_balance']))
 {
    $bill_id = $_REQUEST['id'];
    $amount = $_POST['partdue_balance'];// user name
    
    if(!isset($_POST['partdue_date']))
    {
      $date = $date;
    }
    else
    {
      $date = $_POST['partdue_date'];// user email
    }
    $description = $_POST['partdue_description'];// user email
    $bill_details = $account->get_student_bill_deatails_by_bill_id($bill_id);
    $old_balance = $bill_details->balance;
    $amount = $amount + $old_balance;
    $account->update_student_bill_add_deu($bill_id,$amount,$date,$description,'Pending');
    echo "Sucessfully Add Due!!";
}

if(isset($_POST['editpartdue_balance']))
 {
    $bill_id = $_REQUEST['id'];
    $amount = $_POST['editpartdue_balance'];// user name
    
    if(!isset($_POST['editpartdue_date']))
    {
      $date = $date;
    }
    else
    {
      $date = $_POST['editpartdue_date'];// user email
    }
    $description = $_POST['editpartdue_description'];// user email
    $bill_details = $account->get_student_bill_deatails_by_bill_id($bill_id);
    $old_balance = $bill_details->balance;
    $amount = $amount + $old_balance;
    $account->update_student_bill_add_deu($bill_id,$amount,$date,$description,'Pending');
    echo "Sucessfully Edit Due!!";
}

// created for adding fee for addpartdue.php (addfee modal)
if(isset($_REQUEST['bill_id']))
{
  $bill_id=$_REQUEST['bill_id'];
  $sid=$account->get_student_id_by_bill_id($bill_id);
  $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$sid));
 
  foreach($pending_details as $key)
  {
    $amount=0;
    $newamount1="newamount".$key->bill_id;
    $newdiscription1="addfeediscription".$key->bill_id;
    $amount1=$_POST[$newamount1];
    $amount=$key->balance+$amount1;
    $newdiscription=$_POST[$newdiscription1];
    $account->update_student_bill_add_deu($key->bill_id,$amount,$date,$newdiscription,'pending');
  }
  echo "Dues Added Sucessfully";
}

//created for editing fees for editpartdue.php(editfee modal)

if(isset($_REQUEST['edit_bill_id']))
{
  //print_r(json_encode($_REQUEST));
  $bill_id=$_REQUEST['edit_bill_id'];
  $sid=$account->get_student_id_by_bill_id($bill_id);
  $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$sid));
  //$date = $nepaliDate->full;
  foreach($pending_details as $key)
  {
    $neweditamount1="neweditamount".$key->bill_id;
    $amountedit=$_POST[$neweditamount1];
    $account->update_student_bill_edit_deu($key->bill_id,$amountedit,'pending');
  }
  echo "Dues Edited Sucessfully";
}


//=================== Add Fee Type by hackster =================
if(isset($_REQUEST['add_feetype_request'])){

    $errMsgArray =array();
    $feetype_title = trim($_REQUEST['feetype_title']);
    

    if (empty($feetype_title)) {
      array_push($errMsgArray,"Fee type name can't be empty");
    }else{
      $checkexist = $account->check_feetype_name_exist($feetype_title);
        if ($checkexist) { 
          array_push($errMsgArray,"Fee type name already exist");
        }
    }

    if (empty($errMsgArray)) {

      $insert = $account->insert_feetype($feetype_title);

      if ($insert) {
        $response["status"] = 200;
        $response["message"] = "Success";

        $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Added', 'fee types title: '.$feetype_title , 'account', 'url');
      }else{
        $response["status"] = 201;
        $response["message"] = "failed";
        $response["errormsg"] = $insert;
      }

    }else{

      $response["status"] = 202;
      $response["message"] = "failed";
      $response["errormsg"] = $errMsgArray;
    }

    echo json_encode($response);
}

//=================== Update Fee type by hackster =================
if(isset($_REQUEST['update_feetype_request'])){

    $errMsgArray =array();
    $feetype_title = trim($_REQUEST['feetype_title']);
    $old_feetype_title = trim($_REQUEST['old_feetype_title']);
    $feetype_id = $_REQUEST['feetype_id'];
    

    if (empty($feetype_title)) {
      array_push($errMsgArray,"Fee type name can't be empty");
    }else{
      $checkexist = $account->check_feetype_name_exist_except_id($feetype_title,$feetype_id);
        if ($checkexist) { 
          array_push($errMsgArray,"Fee type name already exist");
        }
    }

    if (empty($errMsgArray)) {

      $update = $account->update_feetype($feetype_title,$feetype_id);

      if ($update) {
        $response["status"] = 200;
        $response["message"] = "Success";

        $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Updated', 'fee types title from: '.$old_feetype_title.' to: '.$feetype_title , 'account', 'url');
      }else{
        $response["status"] = 201;
        $response["message"] = "failed";
        $response["errormsg"] = $update;
      }

    }else{

      $response["status"] = 202;
      $response["message"] = "failed";
      $response["errormsg"] = $errMsgArray;
    }

    echo json_encode($response);
}

//=================== Add Fee Type by hackster =================
if(isset($_REQUEST['deleteAddedDueRequest'])){

    $errMsgArray =array();
    $id = $_REQUEST['deleteAddedDueRequest'];
    

    if (empty($id)) {
      array_push($errMsgArray,"Selected id is empty");
    }

    if (empty($errMsgArray)) {

      $runQuery = $account->delete_student_due_by_id($id);

      if ($runQuery) {
        $response["status"] = 200;
        $response["message"] = "Success";

        $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Deleted', 'student due id: '.$id , 'account', 'url');

      }else{
        $response["status"] = 201;
        $response["message"] = "failed";
        $response["errormsg"] = $insert;
      }

    }else{

      $response["status"] = 202;
      $response["message"] = "failed";
      $response["errormsg"] = $errMsgArray;
    }

    echo json_encode($response);
}


?>