<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<?php
require("../account_management.php");
require("../nepaliDate.php");
$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());

$student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));
$sid=$_GET['student_id'];
$max_bill_print_id_by_std_id = $account->get_max_bill_print_id_by_student_id($_GET['student_id']);

$bill_details = json_decode($account->get_bill_details_by_bill_id_std_id($max_bill_print_id_by_std_id,$_GET['student_id']));
$bill_number = $account->get_bill_number_by_max_id($max_bill_print_id_by_std_id);
$date = $nepaliDate->full;
//$student_discount=json_decode($account->get_student_discount_by_student_id($sid));
//echo $student_discount[0]->tution_discount_percent;
//echo $student_discount;
//$account->update_bill_print_status($max_bill_print_id_by_std_id);
// echo $max_bill_print_id_by_std_id;
// echo $bill_details;
// echo $bill_number;
?>

<div class="container">

    <div id="invoice_print" style="margin-bottom:20px;">
       <table width="100%">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../../uploads/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
                        <td style="">
                         <p style="font-size: 20;font-style: bold;margin-left:-5px;"><?php echo $school_details->school_name; ?></p><br>
                        <p style="margin-top: -20px;margin-left:-5px;"><?php echo $school_details->school_address; ?></p><br>
                        <p style="margin-top: -20px;margin-left:-5px;"><?php echo $school_details->phone_no; ?></p>
                        </td>
                      </tr>
                        
                    </td>

                </tr>
            </tbody>
        </table>
        <!-- <p style="float:right">Authorized Signature:____________________</p> <br> -->
        <div style="text-align: center;font-size:15px;">INVOICE</div><br><br>
        
        
        <!-- <div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?>            
        </div> -->
        <table width="100%" border="0"  style="margin-top: -10px;padding-left: 20px;padding-right: 20px;">    
            <tbody>
                <tr>
                    <!-- <td  valign="top" style="width:60%;">
                        <!-- <br> -->
                         <!-- Bill Number:<?php echo $bill_number; ?> -->
                         <!-- <br> -->
                        <!-- <?php echo $student_details->sname; ?> -->
                        <!-- <br> -->
                        <!-- Admission no: 
                        <?php echo $student_details->sadmsnno; ?>
                        <br> -->
                        <!-- Class : 
                        <?php echo $student_details->sclass." ".$student_details->ssec ?> -->
                         <!-- <br> 
                    </td> -->
                    
                </tr>
            </tbody>
        </table>
        
        <table width="100%" border="0"  style="padding-left: 20px;padding-right: 20px;">    
            <tbody>
                <tr>
                    <td  valign="top" style="width:60%">
                        Bill Number:<?php echo $bill_number; ?>
                        <br> 
                        School/College PAN:<?php echo $school_details->pan_no; ?>
                        <br>
                        School/College Name: <?php echo $school_details->school_name;?>
                        <br>    
                        Address:<?php echo $school_details->school_address;?>
                        <br>
                        Name of Student:<?php echo $student_details->sname;?>
                        <br>
                        Roll No.:<?php echo $student_details->sroll;?>
                        <br>
                         Account No.:Waiting...  
                        <br> 

                        <!--Fiscal Year:<?php echo $date; ?>
                        <br>
                        Sync with IRD:Waiting...
                        <br>
                        Is Bill Printed:Waiting
                        <br>
                        Is Bill Active:Waiting...
                        <br>
                        Entered Time:Waiting...
                        <br>
                        Printed By:Waiting...
                        <br>
                        Is realtime:Waiting... -->
                    </td>
                    <td>
                        <td  valign="top" style="text-align: right;">
                        <br><br>
                        Transaction Date: <?php echo $date; ?><br>
                        Invoice Issue Date : <?php echo $date; ?><br><br><br><br>
                        Class:<?php echo $account->get_student_class_name_by_id($student_details->sclass); ?>
                    </td>
                    </td>
                    <!-- <td  valign="top" style="text-align: right;">
                        Transaction Date: <?php echo $bill_number; ?><br>
                        Date : <?php echo $date; ?>
                    </td> -->
                </tr>
            </tbody>
        </table><br>
        <p style="text-align: right"><b>Method of payment:Cash/Cheque/Creditor/Others</b></p>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sn.No</th>
                    <th>Fee Description</th>
                    <th>Non Taxable Fee</th>
                    <th>Taxablel Fee</th>
                    <th>Total Amount</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Amount(Rs)</td>
                    <td>Amount(Rs)</td>
                    <td>Amount(Rs)</td>

                </tr>
            </thead>
            <tbody>
                <?php
                $i=1;
                $tutionfee=0;
                $seramount=0;
                $feearray=array();
                $totalNonTaxableAmount=0;
                foreach($bill_details as $key)
                {
                    $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
                    if($feetype=='Tution Fee'){
                        $tutionfee=$key->balance;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $feetype; ?></td>
                    <td>0</td>
                    <td><?php echo $key->balance; ?></td>
                    <td><?php echo $key->balance; ?></td>
                    <?php $i=$i+1; ?>
                </tr>
                <?php
                }
                else
                {
                    ?>
                 <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $feetype; ?></td>
                    <td><?php echo $key->balance; ?></td>
                    <td>0</td>
                    <td><?php echo $key->balance; ?></td>
                    <?php array_push($feearray,$key->balance); $i=$i+1; ?>
                </tr>   
                <?php
                }
                }
                ?>
                <tr>
                    <td></td>
                    <?php $tutionDiscount=($tutionfee*$student_discount[1]->bus_discount_percent/100);?>
                    <td>Discount %</td>
                    <td><?php echo $tutionDiscount; ?></td>
                    <?php
                        $totalDiscountedAmount=0;
                        $b=($feearray[1]*$student_discount[1]->bus_discount_percent/100);
                        $c=($feearray[2]*$student_discount[2]->hostel_discount_percent/100);
                        $d=($feearray[3]*$student_discount[3]->computer_discount_percent/100);
                        $totalDiscountedAmount=$tutionDiscount+$b+$c+$d
                    ?>
                    <td>0</td>
                    <td><?php echo $totalDiscountedAmount; ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Taxable Amount</td>
                    <td>0</td>
                    <td><?php echo $tutionfee; ?></td>
                    <td>0</td>
                </tr> 
                <tr>
                    <td></td>
                    <td>Educational Service Fee 1%</td>
                    <td>0</td>
                    <td><?php $seramount=($tutionfee*1/100); echo $seramount; ?> </td>
                    <td><?php echo $seramount; ?></td>

                    
                </tr>
                <tr>
                    <td></td>
                    <td>Total Amount</td>
                    
                    <td><?php foreach($feearray as $key){$totalNonTaxableAmount=$totalNonTaxableAmount+$key; } echo $totalNonTaxableAmount-$totalDiscountedAmount;?></td>
                    <td><?php echo $tutionfee+$seramount; ?></td>
                    <td><?php $totalAmt=($tutionfee-$tutionDiscount)+$seramount+$totalNonTaxableAmount+total; echo $totalAmt; ?></td>
                </tr>
            </tbody>
        </table>

        <br>
        <!-- <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Sn.No</th>
                    <th>Fee Description</th>
                    <th>Taxable Amount</th>
                    <th>Non Taxablel Amount</th>
                    <th>Total Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Tution Fee</td>
                    <td>2000</td>
                    <td>0</td>
                    <td>2000</td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Admission</td>
                    <td>0</td>
                    <td>5000</td>
                    <td>5000</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Discount(%)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Taxable Amount</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Educational Service Fee(1%)</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Total Amount</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table> -->
    </div>
</div>
<br>
<p style="text-align: left">In Words:<u><?php echo $account->get_number_in_word($totalAmt);?></u>
</p><br>
<p style="float:right">_________________</p>
<p style="text-align:right">Authorized By</p>





    
