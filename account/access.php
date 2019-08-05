<?php
if(!isset($force)) {
  include('session.php');
}
require_once("account_management.php");
$account = new account_management_classes();

$student_details = json_decode($account->get_student_details());
$school_details = json_decode($account->get_school_details_by_id());
date_default_timezone_get('Asia/Kathmandu');
// print_r($nepaliDate);
$current_date = $nepaliDate->full;
//$current_date = date('Y-m-d');
//$current_year=date("y",strtotime($current_date));
$current_year=$nepaliDate->year;
$current_month =$nepaliDate->nmonth;

//$current_month =date("m",strtotime($current_date));
$feetype_details = json_decode($account->get_feetype_details());

$today_expenses = $account->get_total_income_current_date();
$today_income = $account->get_total_expenses_current_date();


foreach ($student_details as $key1) 
{
  $sid = $key1->sid;
    //===IF THE PAYMENT TYPE IS 0 THE STUDENT PAYS FEE IN MONTHLY MANNER===========
  if($key1->payment_type==0)
    {
      foreach ($feetype_details as $key) 
        {
          if($key->feetype_title=='Tution Fee')
            {
              $feetype_id = $key->feetype_id;
              $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);
                if($max_bill_id=='')
                  { 
                    $balance = 0;
                      $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
                  }
                  else
                    { 
                    $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;

                      //$old_balance = $account->get_balance_by_bill_id($max_bill_id);
                      //$last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                      //$status = $account->get_status_by_bill_id($max_bill_id);



                      $last_update_month = explode('-', $last_update_date)[1];
                      $month_diff = $current_month - $last_update_month;
                      $monthly_fee = $key1->tution_fee;
                   
                      //$tution_discount_percent = $key1->tution_discount_percent;
                      //$new_monthly_fee = $monthly_fee - ($monthly_fee*$tution_discount_percent)/100;
                        if($month_diff >= 1 && $status =='Pending')
                          {
                            $balance = $old_balance + ($monthly_fee*$month_diff);
                            $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                          }
                        if($month_diff >= 1 && $status =='Advance')
                          {
                            $advance_balance = $old_balance - ($monthly_fee*$month_diff);
                            $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                          }
                      }    
               }
          else if($key->feetype_title=='Hostel Fee')
          {
            $feetype_id = $key->feetype_id;
             //$feetype_id = $account->get_feetype_id_by_feetype_title('hostel Fee');
            $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);  
            if($max_bill_id=='')
              {
                $balance = 0;
                $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
               }
               else
               {

                $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;

                /*$old_balance = $account->get_balance_by_bill_id($max_bill_id);
                  $last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                  $status = $account->get_status_by_bill_id($max_bill_id);*/




                  $last_update_month =$last_update_month = explode('-', $last_update_date)[1];
                  $month_diff = $current_month - $last_update_month;
                  $hostel_fee = $key1->hostel_fee;
                  //$hostel_discount_percent = $key1->hostel_discount_percent;
                  //$new_hostel_fee = $hostel_fee - ($hostel_fee*$hostel_discount_percent)/100;
                  if($month_diff >= 1 && $status =='Pending')
                  {
                   $balance = $old_balance + ($hostel_fee*$month_diff);
                   $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                  }
                  if($month_diff >= 1 && $status =='Advance')
                  {
                      $advance_balance = $old_balance - ($hostel_fee*$month_diff);
                      $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                  }
                }
            }
          else if($key->feetype_title=='Computer Fee')
          {
            $feetype_id = $key->feetype_id;
            //$feetype_id = $account->get_feetype_id_by_feetype_title('Computer Fee');
            $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);  
            if($max_bill_id=='')
              {
                $balance = 0;
                $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
               }
            else
               {
                $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;


                  /*$old_balance = $account->get_balance_by_bill_id($max_bill_id);
                  $last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                  $status = $account->get_status_by_bill_id($max_bill_id);*/


                  $last_update_month = $last_update_month = explode('-', $last_update_date)[1];
                  $month_diff = $current_month - $last_update_month;  
                  $computer_fee = $key1->computer_fee;
                  //$computer_discount_percent = $key1->computer_discount_percent;
                  //$new_computer_fee = $computer_fee - ($computer_fee*$computer_discount_percent)/100;
                  if($month_diff >= 1 && $status =='Pending')
                    {
                      $balance = $old_balance + ($computer_fee*$month_diff);
                      $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                    }
                  if($month_diff >= 1 && $status =='Advance')
                    {
                      $advance_balance = $old_balance - ($computer_fee*$month_diff);
                      $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                    }
              }
          }
          else if($key->feetype_title=='Bus Fee')
          {
            $feetype_id = $key->feetype_id;
            //$feetype_id = $account->get_feetype_id_by_feetype_title('Bus Fee');
            $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);  
            if($max_bill_id=='')
              {     
                $balance = 0;  
                $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
               }
               else
               {

                $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;


                  /*$old_balance = $account->get_balance_by_bill_id($max_bill_id);                 
                  $last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                  $status = $account->get_status_by_bill_id($max_bill_id);*/
                 
                  
                  //$bus_discount_percent = $key1->bus_discount_percent; 

                  $last_update_month = $last_update_month = explode('-', $last_update_date)[1];
                  $month_diff = $current_month - $last_update_month;
                  $bus_rate = $key1->bus_fee;
                  
                  //$new_bus_rate = $bus_rate - ($bus_rate*$bus_discount_percent)/100;

                  if($month_diff >= 1 && $status =='Pending')
                  {
                      $balance = $old_balance + ($bus_rate*$month_diff);
                      $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                  }
                  if($month_diff >= 1 && $status =='Advance')
                  {
                      $advance_balance = $old_balance - ($bus_rate*$month_diff);
                      $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                  }
              }
          }

      }
     }










    // Calculation for yearly payment mode student
    else if($key1->payment_type==1)
    {
     foreach($feetype_details as $key)
     {
       if($key->feetype_title=='Tution Fee')
            {
              $feetype_id = $key->feetype_id;
              //$feetype_id = $account->get_feetype_id_by_feetype_title('Tution Fee');
              $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);
                if($max_bill_id=='')
                {
                    $balance = 0;
                    $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
                 }
                else
                 {

                  $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;

                    /*$old_balance = $account->get_balance_by_bill_id($max_bill_id);
                    $last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                    $status = $account->get_status_by_bill_id($max_bill_id);*/
                    $last_update_year = date("$nepaliDate->year",strtotime($last_update_date));
                    $year_diff = $current_year - $last_update_year;
                   
                    $annual_fee = $key1->tution_fee;
                    //echo "anual tution fee="."$annual_fee";
                    //$tution_discount_percent = $key1->tution_discount_percent;
                    //$new_monthly_fee = $monthly_fee - ($monthly_fee*$tution_discount_percent)/100;
                    if($year_diff >= 1 && $status =='Pending')
                    {
                     $balance = $old_balance + ($annual_fee*$year_diff);
                     $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                    }
                    if($year_diff >= 1 && $status =='Advance')
                    {
                        $advance_balance = $old_balance - ($annual_fee*$year_diff);
                        $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                    }
              }
              
              
            }

        else if($key->feetype_title=='Hostel Fee')
        {
              $feetype_id = $key->feetype_id;
              //$feetype_id = $account->get_feetype_id_by_feetype_title('Hostel Fee');
              $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);
                if($max_bill_id=='')
                {
                    $balance = 0;
                    $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
                 }
                else
                 {

                  $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;

                    /*$old_balance = $account->get_balance_by_bill_id($max_bill_id);                    
                    $last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                    $status = $account->get_status_by_bill_id($max_bill_id);*/

                    $last_update_year = date("$nepaliDate->year",strtotime($last_update_date));
                    $year_diff = $current_year - $last_update_year;
                   
                    $annual_fee = $key1->hostel_fee;
                    //echo "anual hostel fee="."$annual_fee";
                    //$tution_discount_percent = $key1->tution_discount_percent;
                    //$new_monthly_fee = $monthly_fee - ($monthly_fee*$tution_discount_percent)/100;
                    if($year_diff >= 1 && $status =='Pending')
                    {
                     $balance = $old_balance + ($annual_fee*$year_diff);
                     $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                    }
                    if($year_diff >= 1 && $status =='Advance')
                    {
                        $advance_balance = $old_balance - ($annual_fee*$year_diff);
                        $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                    }
              }
              
              
            }
        else if($key->feetype_title=='Computer Fee')
        {
          $feetype_id = $key->feetype_id;
          //$feetype_id = $account->get_feetype_id_by_feetype_title('Computer Fee');
              $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);
                if($max_bill_id=='')
                {
                    $balance = 0;
                    $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
                 }
                else
                 {

                  $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;

                    /*$old_balance = $account->get_balance_by_bill_id($max_bill_id);
                    $last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                    $status = $account->get_status_by_bill_id($max_bill_id);*/

                    $last_update_year = date("$nepaliDate->year",strtotime($last_update_date));
                    $year_diff = $current_year - $last_update_year;
                   
                    $annual_fee = $key1->computer_fee;
                    //echo "anual computer fee="."$annual_fee";
                    //$tution_discount_percent = $key1->tution_discount_percent;
                    //$new_monthly_fee = $monthly_fee - ($monthly_fee*$tution_discount_percent)/100;
                    if($year_diff >= 1 && $status =='Pending')
                    {
                     $balance = $old_balance + ($annual_fee*$year_diff);
                     $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                    }
                    if($year_diff >= 1 && $status =='Advance')
                    {
                        $advance_balance = $old_balance - ($annual_fee*$year_diff);
                        $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                    }
              }
          
        }
        else if($key->feetype_title=='Bus Fee')
        {
          $feetype_id = $key->feetype_id;
          //$feetype_id = $account->get_feetype_id_by_feetype_title('Bus Fee');
              $max_bill_id = $account->get_max_bill_id_by_feetype_id_sid($feetype_id,$sid);
                if($max_bill_id=='')
                {
                    $balance = 0;
                    $account->insert_data_into_student_bill($sid, $feetype_id, $balance, '', 0, 0, 0, $current_date, $current_date, 'Pending');
                 }
                else
                 {

                  $studentBillDetails=json_decode($account->get_student_bill_details_by_bill_id($max_bill_id));

                    $old_balance=$studentBillDetails->balance;
                    $last_update_date=$studentBillDetails->update_date;
                    $status=$studentBillDetails->status;

                    /*$old_balance = $account->get_balance_by_bill_id($max_bill_id);                    
                    $last_update_date = $account->get_update_date_by_bill_id($max_bill_id);
                    $status = $account->get_status_by_bill_id($max_bill_id);*/

                    $last_update_year = date("$nepaliDate->year",strtotime($last_update_date));
                    $year_diff = $current_year - $last_update_year;
                   
                    $annual_fee = $key1->bus_fee;
                    //echo "anual bus fee="."$annual_fee";
                    //$tution_discount_percent = $key1->tution_discount_percent;
                    //$new_monthly_fee = $monthly_fee - ($monthly_fee*$tution_discount_percent)/100;
                        if($year_diff >= 1 && $status =='Pending')
                        {
                           $balance = $old_balance + ($annual_fee*$year_diff);
                           $account->update_balance_by_bill_id($balance,$max_bill_id,$current_date);
                        }
                        if($year_diff >= 1 && $status =='Advance')
                        {
                            $advance_balance = $old_balance - ($annual_fee*$year_diff);
                            $account->update_balance_by_bill_id($advance_balance,$max_bill_id,$current_date);
                        }
                   }
                 }
        }

     }
    }

$teacher_details = json_decode($account->get_teacher_details());
foreach ($teacher_details as $key) 
{

    $tid = $key->tid;
    $current_balance = 0;
    $total_withdrawal = 0;
    $current_update_date = $nepaliDate->full;
    $withdrawal_date = $nepaliDate->full;
    $teacher_account_id = $account->get_teacher_account_id_by_tid($tid);
    if($teacher_account_id == '')
    {
        $account->create_teacher_account($tid, $current_balance, $total_withdrawal, $current_update_date, $withdrawal_date);    
    }
    else
    {
        $last_update_date = $account->get_current_update_date_by_teacher_account_id($teacher_account_id);
        
        $last_update_month = $last_update_month = explode('-', $last_update_date)[1];
        $month_diff = $current_month - $last_update_month;
                
        $current_balance = $account->get_current_balance_by_teacher_account_id($teacher_account_id);
        $teacher_salary = $account->get_teacher_salary_by_tid($tid);
        $balance = 0;
        if($month_diff>=1)
        {
            $balance = $teacher_salary * $month_diff;
            $new_balance = $current_balance+$balance;
            
            $account->update_teacher_balance($tid,$new_balance,$current_date);

        } 
    }
    
}
echo "success !!";