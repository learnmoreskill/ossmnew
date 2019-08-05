<?php
include("../session.php");
require("../account_management.php");
$_REQUEST['classId'];
$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());
$student_details = json_decode($account->get_student_details_by_className($_REQUEST['classId']));
$date = date('Y-m-d');
?>

<?php
if(count($student_details)==0)
{
	echo "No due record!!";

}
else
{
foreach ($student_details as $key) 
{
   $student_payment_details = json_decode($account->get_pending_list_by_sid($key->sid));
?>
<style type="text/css" media="print">
    @media print {
      body {-webkit-print-color-adjust: exact;}
    }
    @page {
        size:A4 portrait;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
        -webkit-filter:opacity(1);
    }
</style>
<div style="border: 1px solid red;border-radius: 10px;width:45%;float:left;margin-left: 20px;margin-top: 20px;height:48%;">
        
    <div id="invoice_print" style="margin-bottom: 20px;">
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
        <div style="text-align: center;font-size:15px;">Deu Reminder</div>
        <!-- <div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?></div> -->
        <table width="100%" border="0"  style="margin-top: 0px;padding-left: 20px;padding-right: 20px;">    
            <tbody>
                <tr>
                    <td  valign="top" style="width:100%;">
                        <?php echo $key->sname; ?>
                        <br>
                        Admission no: 
                        <?php echo $key->sadmsnno; ?>
                        <br>
                        Class : 
                        <?php echo $key->class_name." ".$key->section_name ?>
                        <br> 
                        Date : <?php echo $date; ?>
                        <br><br>           
                    </td>
                    <!-- <td  valign="top" >
                        Date : <?php echo $date; ?>
                    </td> -->
                </tr>
            </tbody>
        </table>
        
      <!-- payment history -->
        <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
            <thead>
                <tr>
                    <td width="30%">Fee Type</td>
                    <td width="15%">T.Month</td>
                    <td width="30%">Amount</td>
                </tr>
            </thead>
            <tbody>
                <?php
                $gross_total = 0;
                $tution_tax_amount = 0;
                foreach($student_payment_details as $key1)
                {
                    $fee_type = $account->get_feetype_by_feetype_id($key1->feetype_id);
                    if($fee_type=='Tution Fee')
                    {
                        $tution_amount = $key1->balance;
                        $tution_tax_amount = ($tution_amount*1)/100;
                    }
                	$update_month =date("m",strtotime($key1->update_date));
                	$last_payment_month =date("m",strtotime($key1->last_payment_date));
                	$diff_month  = $update_month - $last_payment_month;
                	$amount = $key1->balance;
                	$gross_total = $gross_total + $amount;
                    $net_amount = $gross_total + $tution_tax_amount;
                	if($diff_month<0)
                	{}
                	else
                	{
	                	echo "<tr>
	                	<td width='30%''>".$fee_type."</td>
	                    <td width='15%''>".$diff_month."</td>
	                    <td width='30%''>".$key1->balance."</td>
	                    </tr>";
                	}
                }

                ?>
            </tbody>
           
        </table>
        
        
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Gross Total:<?php echo $gross_total ?></td>
                    <td valign="top" style="width: 85px;"></td>
                </tr>
                
            </tbody>
        </table>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Tax on Tutuion Fee(1%):<?php echo $tution_tax_amount; ?></td>
                    <td valign="top" style="width: 85px;"></td>
                </tr>
                
            </tbody>
       	 </table>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Net Total:<?php echo $net_amount; ?></td>
                    <td valign="top" style="width: 85px;"style=""></td>
                </tr>
                
            </tbody>      
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
            <tbody>
                <tr>
                </tr>
            </tbody>      
            </table>
                    
            
   
</div> 

</div>


<?php 
}
}
?>
    
