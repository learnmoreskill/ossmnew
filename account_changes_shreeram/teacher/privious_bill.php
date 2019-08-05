<?php
include("../session.php");
require("../account_management.php");
$pme_id = $_REQUEST['bill_id'];
$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());
$pme_details = json_decode($account->get_pme_details_by_id($pme_id));
$teacher_details =  json_decode($account->get_teacher_record_by_tid($pme_details->teacher_id));
?>
<div id='privous_bill_print_id'>
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
                       <?php echo $teacher_details->tname; ?>
                        <br>
                        Address : 
                        <?php echo $teacher_details->taddress; ?>
                        <br>            
                    </td>
                    <td  valign="top" >
                        Bill No:  <?php echo $pme_id; ?>
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
                    <td width="15%">Deduction/Advance</td>
                    <td width="20%">Amount</td>
                </tr>
            </thead>
            <tbody>
            	  <?php
                    $tax_percent = 1;
                    $net_pay = $pme_details->net_pay;
                    $deduction = $pme_details->deduction;
                    $advance = $pme_details->advance;
                    $bonus = $pme_details->bonus;
                    if($advance==0)
                    {
                    	$salary = $net_pay-$deduction +$bonus;
	                    $tax_amount = ($salary*$tax_percent)/100;
	                    $net_amount = $salary-$tax_amount;
	                   
                    }
                    else
                    {
                    	$salary = 0;
	                    $tax_amount = 0;
	                    $net_amount = $advance;
	                    $deduction = $advance;
	                    $net_pay = $advance;
                    }
                    
                    echo
                    "<td>1.</td>
                    <td>".$salary."</td>
                    <td>".$bonus."</td>
                    <td>".$deduction."</td>
                    <td>".$net_pay."</td>";

                   
                  ?>
            </tbody>
           
        </table>
        
        
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:290px;text-align: right;">Gross Total:</td>
                    <td valign="top" style="width: 85px;"><?php echo $net_amount;  ?></td>
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
                    <td valign="top" style="width:400px;text-align: right;">Net Total:<?php echo $net_pay; ?></td>
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