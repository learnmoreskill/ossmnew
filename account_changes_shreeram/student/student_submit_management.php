<?php
require("../account_management.php");
$account = new account_management_classes();







//=================== Extra fee collection =====================
 if(isset($_POST['fee_category']))
 {
    $fee_category = $_POST['fee_category'];// user name
    $className = $_POST['class_name'];// user email
    $fee_amount = $_POST['fee_amount'];// user email
    if($className=='Choose...')
    {
      $msg =  "Please Select Class Name";
    }
    else if($fee_category=='Choose...')
    {
      $msg =  "Please Select fee type";
    }
    else if($fee_amount=='')
    {
      $msg =  "Please enter amount";
    }
   
    else
    {

    $feetype_id = $account->get_feetype_id_by_feetype_title($fee_category);
    $student_id_list = json_decode($account->get_student_id_by_className($className));
    $date = date('Y-m-d');
    $balance = $fee_amount;
      $payment = "";
      $discount = 0;
      $paid = 0;
      $fine = 0;
      $update_date = $date;
      $last_payment_date = $date;
      $description='';
      $userName='';
      $status = 'Pending';
      $bill_print_id = 0;
      
    foreach ($student_id_list as $key) 
    {
      $std_id = $key->sid;
      $account->insert_student_bill($bill_print_id,$std_id, $feetype_id, $balance, $payment, $discount, $paid, $fine, $update_date, $last_payment_date,$description,$userName, $status); 

    }
    $account->insert_extra_fee_collection_tables($className,$feetype_id,$fee_amount,$date);
  

   $msg =  "Sucessfully Insert Record !!";
  }   
  echo $msg;
 }


//=================== Monthly fee collection =====================
 if(isset($_POST['balance']))
 {
    
    $bill_id = $_REQUEST['id'];
    $balance = $_POST['balance'];
    $discount = $_POST['discount'];

   
    if(isset($_POST['first_date']))
    {
      $first_date = $_POST['first_date'];
      $second_date = $_POST['second_date'];
      $n_first_month = $account->get_english_month_num($first_date);
      $n_second_month = $account->get_english_month_num($second_date);
      $year = date('Y');
    $day = date('d');
     $last_payment_date = $year."-".$n_second_month."-".$day;

    }
    else
    {
      $last_payment_date = date('Y-m-d');
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
      $date = date('Y-m-d');
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
        $bill_number = "GB-".$bill_print_id;
        $account->insert_insert_bill_print_tables($std_id,$bill_number,'false');
      }
          $max_bill_print_id_by_std_id = $account->get_max_bill_print_id_by_student_id($std_id);
          if($bill_print_status=='true')
          {
                  $bill_number = "GB-".$bill_print_id;
                  $account->insert_insert_bill_print_tables($std_id,$bill_number,'false');
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
        
        echo "Sucessfully Save !!";
      
    
 }

 //=============== add Deu Balance  ============
 if(isset($_REQUEST['addDue_id']))
 {
    if(isset($_REQUEST['addDue_id']))
    {
      $std_id =  $_REQUEST['addDue_id'];
    }
    $amount = $_POST['due_balance'];// user name
    $fee_type = $_POST['fee_type'];// user email
    $description = $_POST['due_description'];// user email
    $balance1 = $amount;
    $feetype_id = $account->get_feetype_id_by_feetype_title($fee_type);
            $update_date = date('Y-m-d');
            $last_payment_date = date('Y-m-d');
            
            
    $account->insert_student_bill(0,$std_id, $feetype_id, $balance1, '', 0, 0, 0, $update_date, $last_payment_date,$description,'', 'Pending'); 
   echo "Sucessfully Insert Record !!";
}

if(isset($_REQUEST['edit_olddueid']))
{
   $date = date('Y-m-d');
   $bill_id = $_REQUEST['edit_olddueid']; 
   $balance = $_POST['edit_due_balance'];
   $fee_type = $_POST['edit_fee_type'];
   $description = $_POST['edit_due_description'];
   $account->update_student_bill_add_deu($bill_id,$balance,$date,$description,'Pending');
   echo "Sucessfully Update Record !!";
   
}
?>

<?php
//=============================================
if(isset($_REQUEST['student_id']))
{
  $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$_GET['student_id']));
  $max_bill_print_id = $account->get_max_bill_print_id();
  $bill_print_id = $max_bill_print_id + 1;
  $bill_number = 'GB-'.$bill_print_id; 
  $account->insert_insert_bill_print_tables($_REQUEST['student_id'],$bill_number,'false');
  $max_bill_print_id = $account->get_max_bill_print_id();
  
  foreach ($pending_details as $key) 
  {
    $true_checkbox = "checkbox".$key->bill_id;
    if(isset($_POST[$true_checkbox]))
    {
      $paid = $_POST[$true_checkbox];
      $feetype_id = $key->feetype_id;
      $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
      $std_id = $_REQUEST['student_id'];
      $update_date = $key->update_date;
      $last_payment_date = date('Y-m-d');
    if($feetype=='Tution Fee' || $feetype=='hostel Fee' || $feetype=='Bus Fee'|| $feetype=='Computer Fee')
    {
      $account->insert_student_bill(0,$std_id, $feetype_id, 0, 'Cash', 0, 0, 0, $update_date, $last_payment_date,'','','Pending');
    }
      $account->update_student_bill($key->bill_id,$max_bill_print_id,'Cash',0,$paid,0,$last_payment_date,'','','Paid');
    }
  }
   echo "Sucessfully Insert Payment Record !!";
}

//=============== add Deu Balance  ============
 if(isset($_POST['partdue_balance']))
 {
    $bill_id = $_REQUEST['id'];
    $amount = $_POST['partdue_balance'];// user name
    
    if(!isset($_POST['partdue_date']))
    {
      $date = date('Y-m-d');
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
      $date = date('Y-m-d');
    }
    else
    {
      $date = $_POST['editpartdue_date'];// user email
    }
    $description = $_POST['editpartdue_description'];// user email
    $bill_details = $account->get_student_bill_deatails_by_bill_id($bill_id);
    $old_balance = $bill_details->balance;
    $amount = $amount;
    $account->update_student_bill_add_deu($bill_id,$amount,$date,$description,'Pending');
    echo "Sucessfully Edit Due!!";
}

?>