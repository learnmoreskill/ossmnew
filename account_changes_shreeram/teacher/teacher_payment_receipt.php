<?php
include("../session.php");
require("../account_management.php");

$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());

 if(isset($_GET['paying_amount']))
 {
   $t_id =  $_GET['tid'];
  $emp_account_details = json_decode($account->get_employee_account_details_by_empId($t_id));
  $emp_details = json_decode($account->get_employee_details_by_empId($t_id));

 //echo $account->get_employee_details_by_empId($t_id);
 
  $first_date = $_GET['first_date']; // fine_charge 
  $second_date = $_GET['second_date']; // fine_charge 
  $t_pay = $_GET['paying_amount']; // fine_charge 
  $t_bonus = $_GET['bonus_amount'];// user email
  $t_deduction = $_GET['Deducted_amount']; // fine_charge 
  $description = $_GET['description']; // fine_charge 
  if($description=='')
  {
    $description='';
  }

  $t_pay = (double)$t_pay;
  $t_bonus = (double)$t_bonus;
  $t_deduction = (double)$t_deduction;


$year = date('Y');
$d = date('d');
$m = $account->get_english_month_num($second_date);
$last_payment_date = $year."-".$m."-".$d;

//=============== advance amount ==================
      $advance = json_decode($account->get_teacher_advance_by_teacher_id_status($t_id));
      $total_advance = 0;
      foreach ($advance as $key) 
      {
        $advance = $key->advance;
        $total_advance = $total_advance + $advance;
      }
$t_deduction =  $total_advance + $t_deduction;
$net_pay =  $t_pay + $t_bonus - $t_deduction;
$teacher_account_id = $emp_account_details->teacher_account_id;
$old_balance = $emp_account_details->current_balance;
$withdraw_balance = $emp_account_details->total_withdrawal;
$new_balance = $old_balance - $t_pay - $total_advance;
$new_withdraw_balance = $withdraw_balance + $net_pay;
if($new_balance<=0)
{
  $new_balance = 0;
}
$account->update_advance_status($t_id);

$account->update_employee_balance_by_empId($teacher_account_id,$new_balance,$new_withdraw_balance,$last_payment_date);   
 
  if($second_date=='Choose Month')
  {
   $errMSG = "Please Select Payment Month !!";
  } 
  else if(empty($t_pay))
  {
   $errMSG = "Please Enter payment !!";
  }
   
  if(!isset($errMSG))
  {
  
      $staff_id = 0; 
      $advance = 0;
      $last_payment_date = date('Y-m-d');
      $date = date('Y-m-d');
      $user_name = "Birendra shrama";
      $status = 'Paid';
      $account->insert_teacher_payment($t_id,$staff_id,$t_bonus,$advance,$t_deduction,$net_pay,$last_payment_date,$description,$user_name,$status);
      $errMSG = "Succssfully Paid !!";
      $account->insertSchoolAccount('', 'Teacher', 0, $net_pay,$date);
   
      
    
  }
  
  $bill_id = $account->get_max_id_pay_me();
 }
?>

<div class="container" style="border: 1px solid red;border-radius: 10px;height: auto;">
        
    <div id="invoice_print" style="margin-bottom: 50px;">
        <table width="100%" style="border-bottom: 1px solid #a8adac;">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
                        <td style="">
                         <p style="font-size: 20;font-style: bold;margin-top: -20px;margin-left:-20px;"><?php echo $school_details->school_name; ?></p>
                        <p style="margin-top: -20px;margin-left:-20px;"><?php echo $school_details->school_address; ?></p>
                        <p style="margin-top: -20px;margin-left:-20px;"><?php echo $school_details->phone_no; ?></p>
                        </td>
                      </tr>
                        
                    </td>

                </tr>
            </tbody>
        </table>
        <div style="text-align: center;font-size:15px;">INVOICE</div><div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?></div>
        <table width="100%" border="0"  style="margin-top: -10px;padding-left: 20px;padding-right: 20px;">  
            <tbody>
                <tr>
                    <td  valign="top" style="width:60%;">Name:
                       <?php echo $emp_details->tname; ?>
                        <br>
                        Address : 
                        <?php echo $emp_details->taddress; ?>
                        <br>            
                    </td>
                    <td  valign="top" >
                        Bill No: <?php echo $bill_id; ?> 
                        <br>
                        Date : <?php echo date('Y-m-d'); ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
      <!-- payment history -->
        <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
            <thead>
                <tr>
                    <td width="10%">S.No</td>
                    <td width="30%">Salary</td>
                    <td width="10%">Bonous</td>
                    <td width="15%">Deduction</td>
                    <td width="20%">Amount</td>
                </tr>
            </thead>
            <tbody>
                  <?php
                    echo
                    "<td>1.</td>
                    <td>".$t_pay."</td>
                    <td>".$t_bonus."</td>
                    <td>".$t_deduction."</td>
                    <td>".$net_pay."</td>";

                    $tax_percent = 1;
                    $tax_amount = ($net_pay*$tax_percent)/100;
                    $net_amount = $net_pay - $tax_amount;
                  ?>
            </tbody>
           
        </table>
        
        
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:290px;text-align: right;">Gross Total:</td>
                    <td valign="top" style="width: 85px;"><?php echo $net_pay;  ?></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:400px;text-align: right;">Tax(<?php echo $tax_percent; ?>%):<?php echo $tax_amount;  ?></td>
                    <td valign="top" style="width: 85px;"></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:400px;text-align: right;">Net Total:<?php echo $net_amount; ?></td>
                    <td valign="top" style="width: 75px;"></td>
                </tr>
                
            </tbody>      
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
            <tbody>
                <tr>
                  <tr>
                    <?php 
                     $inword =  $account->get_number_in_word($net_amount);
                    echo "
                    <td valign='top' style='width:50px;text-align: left;''>Inword:</td>
                        <td valign='top' style=''>".$inword."</td>
                    ";
                ?>
                </tr>


            </tbody>       
            </table>
                    
            
    </div>
</div>    

