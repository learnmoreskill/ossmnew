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
?>

<div style="border-radius: 10px;float:left;margin-left: 20px;margin-top: 20px;width:100%;">
        
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
        </div> 
    </div>
<?php
foreach ($student_details as $key) 
{
   $student_payment_details = json_decode($account->get_pending_list_by_sid($key->sid));

?>        
        
        <table width="100%" border="0"  style="margin-top:20px;padding-left: 20px;padding-right: 20px;">    
            <tbody>
                <tr>
                    <td  valign="top" style="width:60%;">
                        <?php echo $key->sname; ?>
                       

                    </td>
                    <td  valign="top" >
                         Class : 
                        <?php echo $key->class_name." ".$key->section_name ?>
                    </td>
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
                echo "
                <tr>
                <td width='30%''></td>
                    <td width='15%''>Total</td>
                    <td width='30%'>".$gross_total."</td>
                </tr>";

                ?>
            </tbody>
           
        </table>
        
        
            
       


<?php 
}
}
?>
    
