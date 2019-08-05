<?php
include('../session.php');
include('../load_backstage.php');
include_once("../nepaliDate.php");

$date = $nepaliDate->full;

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
      $bill_number = $account->generate_new_bill_number($school_details->school_code);

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
      $feetype_name = $account->get_feetype_by_feetype_id($feetype_id);
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

    if(isset($_REQUEST['addDue_id'])){

      $std_id =  $_REQUEST['addDue_id'];
    }
    $amount = $_POST['due_balance'];// user name
    $fee_type = $_POST['fee_type'];// user email
    $description = $_POST['due_description'];// user email

    $feetype_id = $account->get_feetype_id_by_feetype_title($fee_type);
    
    $current_date = $date;

    $account->add_fee_into_student_due($std_id, $feetype_id, $amount, $description, $current_date, $LOGIN_CAT, $LOGIN_ID, 1);

    echo $description." Old Due Added Successfully";
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
if(isset($_REQUEST['submit_fee']))
{
  

  $errMsgArray  = array();
  $student_id = $_REQUEST['submit_fee'];
  $credit = $_POST['payableAmount'];
  $payment_by = $_POST['paidby'];
  $payment_mode = $_POST['paymentMode'];

  $feetype_array = json_decode($_POST['activeFee']);
  $active_months = json_decode($_POST['activeMonths']);

  
  $advance_before = $_POST['advanceBefore'];
  $advance_after = $_POST['advanceAfter'];
  $advance_paid = $advance_before-$advance_after;

  $due_before = $_POST['totalBalance'];
  $totalPaidBalance = $_POST['totalPaidBalance'];
  $due_after = $due_before-$totalPaidBalance;



  if (empty($feetype_array)) {
      array_push($errMsgArray,'No any fee category has been selected');
  }


  if (empty($payment_by)) {
      array_push($errMsgArray,'Received from shoud not be empty');
  }  
    
    

    if($payment_mode=='cash')
    {
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
    //array_push($errMsgArray,"errorMsg");

      $stdBatchDetails = json_decode($account->get_student_batch_details_by_sid($student_id));
      $class_id = $stdBatchDetails->sclass;
      $section_id = $stdBatchDetails->ssec;
      $student_roll_no = $stdBatchDetails->sroll;


    $bill_number = $account->generate_new_bill_number($school_details->school_code);

    $advance_before = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);

    $advance = $advance_before+$credit;

    $bill_print_id = $account->add_into_bill_tables($bill_number, 1, $due_before, $advance_before, $advance_paid, $due_after, $advance_after,$class_id,$section_id,$student_roll_no, $date, 0, $LOGIN_CAT , $LOGIN_ID);

    if ($credit > 0) {
      $addToTransactionCredit = $account->insert_into_student_transaction(1 , $bill_print_id , $student_id , 0 , $credit , 0 , $advance , 0 , 0 , $payment_mode , $payment_number , $payment_source , $payment_by , $date , '');

      if (!$addToTransactionCredit) {
        array_push($errMsgArray,"Failed to add credit into student transaction");
      }
    }




    $test1 ='';

    foreach ($feetype_array as $feetype_id) {
      
      $fullmonth = 'month'.$feetype_id;
      
      $discount = $_POST['discount'.$feetype_id];
      $fine = $_POST['fine'.$feetype_id];
      $description = $_POST['description'.$feetype_id];

      $selectedMonths = $active_months->$fullmonth;

      $dateCount = sizeof($selectedMonths);

      $perDiscount = $discount/$dateCount;
      $perFine = $fine/$dateCount;

      $countOfLoop = 1;
      $addDiscount = 0;
      $addFine = 0;

      foreach ($selectedMonths as $selectedDueId) {

        $perDiscount = floor($perDiscount);
        $perFine = floor($perFine);

        $addDiscount += $perDiscount;
        $addFine += $perFine;

        if ($dateCount==$countOfLoop) {
          $perDiscount +=$discount-$addDiscount;
          $perFine +=$fine-$addFine;
        }

        $getBalanceOfDueId = $account->get_student_due_balance_by_id($selectedDueId);
        $debit = $getBalanceOfDueId+$perFine-$perDiscount;

        $advance = $advance-$debit;

        $updateStudentDueToPaid = $account->update_student_due_to_paid_by_id($selectedDueId);

        if ($updateStudentDueToPaid) {

          $addToTransactionDebit = $account->insert_into_student_transaction(0 , $bill_print_id , $student_id , $selectedDueId , 0 , $debit , $advance , $perDiscount , $perFine , 0 , '' , '' , '' , $date , $description);
          
          if (!$updateStudentDueToPaid) {
            array_push($errMsgArray,"Failed to add debit into student transaction");
          }

        }else{
          array_push($errMsgArray,"Failed to update student due to paid");
        }


        //$test1 .=$selectedDueId."-".$getBalanceOfDueId."-".$perDiscount."-".$perFine."-".$description."-".$debit."-".$advance."\n";

        $countOfLoop++;
      }
    }

    //array_push($errMsgArray,$test1);
    //array_push($errMsgArray,gettype($active_months->month12));
    //array_push($errMsgArray,$credit);

    if (empty($errMsgArray)) {
      $response["status"] = 200;
      $response["message"] = "Success";
      $response["bill_id"] = $bill_print_id;
    }else{
      $response["status"] = 201;
      $response["message"] = "Failed";
      $response["message"] = $errMsgArray;
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


?>