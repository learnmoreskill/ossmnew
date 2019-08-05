<?php
require("../account_management.php");
require("../nepaliDate.php");
$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());

if(isset($_REQUEST['type']))
{
    $type = $_REQUEST['type'];
    $bill_number = $_REQUEST['bill_number'];
    $student_id = 0;
    $bill_print_id = 0;
    if($type=='Student')
    {
        $bill_print_details = $account->get_bill_details_by_bill_number($bill_number);
        if(!empty($bill_print_details))
        {
            $student_id = $bill_print_details->std_id;
            $bill_print_id = $bill_print_details->bill_print_id;
            $student_details = json_decode($account->get_student_details_by_sid($student_id));
            $bill_details = json_decode($account->get_bill_details_by_bill_id_std_id($bill_print_id,$student_id));
            // var_dump($bill_details);
            // echo $bill_print_id." ".$student_id;
        }
        $date = $nepaliDate->full;
    }
    else if($type=='Teacher')
    {
        $pay_me_details = json_decode($account->get_pme_details_by_id($bill_number));
        if(!empty($pay_me_details))
        {
            $teacher_details =  json_decode($account->get_teacher_record_by_tid($pay_me_details->teacher_id));
            $pme_id = $pay_me_details->pme_id;
        }
       
    }
    else
    {

    }
}
else
{
    echo "null value";
}

?>
<?php
if(!empty($bill_print_details) || !empty($pay_me_details))
{
?>

<div class="container" style="border: 1px solid red;border-radius: 10px;">
        
    <div id="invoice_print" style="margin-bottom: 20px;">
         <table width="100%" style="border-bottom: 1px solid #a8adac;">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../../uploads/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
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
                <?php 
                if(isset($_REQUEST['type']))
                {
                    if($type=='Student')
                    {
                ?>
                <tr>
                    <td  valign="top" style="width:60%;">
                        <?php echo $student_details->sname; ?>
                        <br>
                        Admission no: 
                        <?php echo $student_details->sadmsnno; ?>
                        <br>
                        Class : 
                        <?php echo $account->get_student_class_name_by_id($student_details->sclass)." ".$account->get_section_name_by_section_id($student_details->ssec) ?>
                        <br>            
                    </td>
                    <td  valign="top" >
                        Bill No: <?php echo $bill_number; ?><br>
                        Date : <?php echo $date; ?>
                    </td>
                </tr>
                <?PHP }
                 else if($type=='Teacher')
                {
                    ?>
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
                        Date : <?php echo $nepaliDate->full; ?>
                    </td>
                </tr>
                <?php
                }
            } ?>
            </tbody>
        </table>
        
      <!-- payment history -->
        <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
            <thead>
                <?php  
                if(isset($_REQUEST['type']))
                {
                    if($type=='Student')
                    {
                ?>
                <tr>
                    <td width="10%">S.No</td>
                    <td width="30%">Fee Type</td>
                    <td width="10%">Dis.</td>
                    <td width="15%">Fine</td>
                    <td width="15%">T.Month</td>
                    <td width="30%">Amount</td>
                </tr>
                <?php
                }
                else if($type=='Teacher')
                {
                ?>
                 <tr>
                    <td width="10%">S.No</td>
                    <td width="30%">Salary</td>
                    <td width="10%">Bonous</td>
                    <td width="15%">Deduction/Advance</td>
                    <td width="20%">Amount</td>
                </tr>
                <?php }} ?>
            </thead>
            <tbody>
                <?php 
                $sn=0;
                $total = 0;
                $tax = 0;
                $net_total=0;

        if(isset($_REQUEST['type']))
        {
            if($type=='Student')
            {
               
                foreach ($bill_details as $key) 
                {
                    
                    $n_month = $last_month = date("m",strtotime($key->last_payment_date));
                    //$month = $account->get_english_month($n_month);
                    $month= $nepaliDate->nmonth;
                    $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
                   $total = $total +  $key->paid;
                   if($feetype=='Tution Fee')
                   {
                    $balance = $key->paid;
                    $tax = $balance/100;
                   }
                      if($feetype=='Tution Fee' || $feetype=='Bus Fee' || $feetype=='Hostel Fee'|| $feetype=='Computer Fee')
                      {
                        $month = NepaliDate::get_nepali_month($n_month);
                        //$month= $n_month;
                      }
                      else
                      {
                        $month = '';
                      }
                   $sn++;
                   echo"<tr>
                        <td>".$sn."</td>
                        <td>".$account->get_feetype_by_feetype_id($key->feetype_id)."</td>
                        <td>".$key->discount."</td>
                        <td>".$key->fine."</td>
                        <td>".$month."</td>
                        <td>".$key->paid."</td>
                    </tr>";
                }
                $net_total = $total + $tax;
            }
            else if($type=='Teacher')
            {
                    $tax_percent = 1;
                    $net_pay = $pay_me_details->net_pay;
                    $deduction = $pay_me_details->deduction;
                    $advance = $pay_me_details->advance;
                    $bonus = $pay_me_details->bonus;
                    if($advance==0)
                    {
                        $salary = $net_pay-$deduction +$bonus;
                        $tax_amount = ($salary*$tax_percent)/100;
                        $net_amount = $salary-$tax_amount;
                        $total = $salary;
                        $tax = $tax_amount;
                        $net_total = $net_amount;
                       
                    }
                    else
                    {
                        $salary = 0;
                        $tax_amount = 0;
                        $net_amount = $advance;
                        $deduction = $advance;
                        $net_pay = $advance;
                        $total = $net_pay;
                    }
                    
                    echo
                    "<td>1.</td>
                    <td>".$salary."</td>
                    <td>".$bonus."</td>
                    <td>".$deduction."</td>
                    <td>".$net_pay."</td>";

                   
            }
        }        
                ?>  

                
            </tbody>
           
        </table>
        
        
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Gross Total:</td>
                    <td valign="top" style="width: 85px;"><?php echo $total; ?></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Education Tax on Tutuion Fee(1%):</td>
                    <td valign="top" style="width: 85px;"><?php echo $tax; ?></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Net Total:</td>
                    <td valign="top" style="width: 85px;"style=""><?php echo $net_total; ?></td>
                </tr>
                
            </tbody>      
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
            <tbody>
                <tr>
                    <?php 
                 $inword =  $account->get_number_in_word($net_total);
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
<?php 
}
else
{
    echo "Invalid Bill Number !!";
}
?>