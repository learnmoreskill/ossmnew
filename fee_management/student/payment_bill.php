<?php
include('../session.php');
include('../load_backstage.php'); 




    $student_id=$_GET['student_id'];

    $bill_id = $_GET['bill_id'];

    $student_details = json_decode($account->get_student_details_by_sid($student_id));

    $bill_details = json_decode($account->get_bill_details_by_bill_id($bill_id));

    $debit_transaction_list = json_decode($account->get_debit_student_transaction_list_by_bill_id($bill_id));

    $credit_transaction = json_decode($account->get_credit_student_transaction_by_bill_id($bill_id));

    $date = $nepaliDate->full;




?><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"><?php


?>

<div class="container">

    <div id="invoice_print" style="margin-bottom:20px;">
       <table width="100%">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
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
        
        
        
        
        <table width="100%" border="0"  style="padding-left: 20px;padding-right: 20px;">    
            <tbody>
                <tr>
                    <td  valign="top" style="width:60%">
                        Bill Number:<?php echo $bill_details->bill_number; ?>
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

                    </td>
                    <td>
                        <td  valign="top" style="text-align: right;">
                        <br><br>
                        Transaction Date: <?php echo $date; ?><br>
                        Invoice Issue Date : <?php echo $date; ?><br><br><br><br>
                        Class:<?php echo $student_details->class_name; ?>
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
                $sn=0;
                $total = 0;
                $tax = 0;
                $net_total=0;



                 $i=1;
                $tutionfee=0;
                $seramount=0;
                $feearray=array();
                $totalNonTaxableAmount=0;
                foreach ($debit_transaction_list as $key) 
                {
                    $feetype =  $feetype_name = $account->get_feetype_title_by_feetype_id($key->feetype_id);
                    if($feetype=='Tution Fee'){
                        $tutionfee=$key->debit;
                ?>
                <tr>
                    <td><?php echo $i; ?></td>
                    <td><?php echo $feetype; ?></td>
                    <td>0</td>
                    <td><?php echo $key->debit; ?></td>
                    <td><?php echo $key->debit; ?></td>
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
                    <td><?php echo $key->debit; ?></td>
                    <td>0</td>
                    <td><?php echo $key->debit; ?></td>
                    <?php array_push($feearray,$key->debit); $i=$i+1; ?>
                </tr>   
                <?php
                }
                }
                ?>
                <tr>
                    <td></td>
                    <td>Discount %</td>
                    <td><?php $tutionDiscount=0; echo $tutionDiscount; ?></td>
                    <?php
                        $totalDiscountedAmount=0;
                        // $b=($feearray[1]*$student_discount[1]->bus_discount_percent/100);
                        // $c=($feearray[2]*$student_discount[2]->hostel_discount_percent/100);
                        // $d=($feearray[3]*$student_discount[3]->computer_discount_percent/100);
                        $totalDiscountedAmount=$tutionDiscount;
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
                    <td><?php $totalAmt=($tutionfee-$tutionDiscount)+$seramount+$totalNonTaxableAmount+$total; echo $totalAmt; ?></td>
                </tr>
            </tbody>
        </table>

        <br>
    </div>
</div>
<br>
<p style="text-align: left">In Words:<u><?php echo $account->get_number_in_word($totalAmt);?></u>
</p><br>
<p style="float:right">_________________</p>
<p style="text-align:right">Authorized By</p>

