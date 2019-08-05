<?php
include('session.php');
include('load_backstage.php');


date_default_timezone_get('Asia/Kathmandu');
// print_r($nepaliDate);
$current_date = $nepaliDate->full;
$current_year=$nepaliDate->year;
$current_month =$nepaliDate->nmonth;

//Get all active student details
$student_details = json_decode($account->get_student_details());

//Get All Fee types id and feetypes name
$feetype_details = json_decode($account->get_feetype_details());

//$today_expenses = $account->get_total_income_current_date();
//$today_income = $account->get_total_expenses_current_date();
$description = 'Added by system';

foreach ($student_details as $key1) 
{ 
  $sid = $key1->sid;
    //===IF THE PAYMENT TYPE IS 0 THE STUDENT PAYS FEE IN MONTHLY MANNER===========
    if($key1->payment_type==0){

      	foreach ($feetype_details as $key){

      		$balance=0.0;

          	if($key->feetype_title=='Tution Fee' && !empty($key1->tution_fee)){

              	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year_month($feetype_id,$sid,$current_year,$current_month);

                if(!$checkFeeExist){

                  	$balance = $key1->tution_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }

          	}else if($key->feetype_title=='Hostel Fee'  && !empty($key1->hostel_fee)){

            	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year_month($feetype_id,$sid,$current_year,$current_month);

                if(!$checkFeeExist){

                  	$balance = $key1->hostel_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }
          	}else if($key->feetype_title=='Computer Fee' && !empty($key1->computer_fee)){

            	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year_month($feetype_id,$sid,$current_year,$current_month);

                if(!$checkFeeExist){

                  	$balance = $key1->computer_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }
          	}else if($key->feetype_title=='Bus Fee' && !empty($key1->bus_fee)){

            	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year_month($feetype_id,$sid,$current_year,$current_month);

                if(!$checkFeeExist){

                  	$balance = $key1->bus_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }
          }

      }
    }


    //===IF THE PAYMENT TYPE IS 1 THE STUDENT PAYS FEE IN MONTHLY MANNER===========
    else if($key1->payment_type == 1){

      	foreach($feetype_details as $key){

      		$balance=0.0;

          	if($key->feetype_title=='Tution Fee' && !empty($key1->tution_fee)){
              	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year($feetype_id,$sid,$current_year);

                if(!$checkFeeExist){

                  	$balance = $key1->tution_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }              
              
          	}else if($key->feetype_title=='Hostel Fee' && !empty($key1->hostel_fee)){

              	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year($feetype_id,$sid,$current_year);

                if(!$checkFeeExist){

                  	$balance = $key1->hostel_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }
              
              
          	}else if($key->feetype_title=='Computer Fee' && !empty($key1->computer_fee)){

            	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year($feetype_id,$sid,$current_year);

                if(!$checkFeeExist){

                  	$balance = $key1->computer_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }
          	}else if($key->feetype_title=='Bus Fee' && !empty($key1->bus_fee)){

            	$feetype_id = $key->feetype_id;

              	$checkFeeExist  = $account->check_fee_exist_by_feetypeid_sid_year($feetype_id,$sid,$current_year);

                if(!$checkFeeExist){

                  	$balance = $key1->bus_fee;

                  	$account->add_fee_into_student_due($sid, $feetype_id, $balance, $description, $current_date, 0, 0, 1);

                }
          }
      }

    }
}



//GET ALL ACTIVE TEACHER DETAILS
/*$teacher_details = json_decode($account->get_teacher_details());
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
    
}*/
echo "Account data successfully up to dated.";