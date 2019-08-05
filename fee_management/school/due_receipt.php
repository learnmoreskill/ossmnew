<?php 
    $student_details = json_decode($account->get_student_details_by_sid($student_id));
    $sname = $student_details->sname;
    $sadmsnno = $student_details->sadmsnno;
    $class_name = $student_details->class_name;
    $section_name = $student_details->section_name;
    $due_details = json_decode($account->get_total_student_due_by_student_id_status($student_id,1));
    $advanceAmount = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);
    $pre_discount = 0;
?>

<div style="border: 1px solid red;border-radius: 10px;width:45%;float:left;margin-left: 20px;margin-right: 20px;margin-top: 20px;height:48%;">
        
    <div id="invoice_print" style="margin-bottom: 20px;">
         <table width="100%" style="border-bottom: 1px solid #a8adac;">
            <tbody>
              <tr align="center">
                <td width="80px"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="70px" height="70px"></td>
                <td style="">
                 <p style="font-size: 18;font-style: bold;margin-left:-14px;max-height: 65px;/*overflow: hidden;*/line-height: 0.9"><?php echo $school_details->school_name; ?></p>
                <p style="margin-top: -12px;margin-left:-20px; font-size: 13px;"><?php echo $school_details->school_address; ?></p>
                <p style="margin-top: -15px;margin-left:-20px; font-size: 12px;"><?php echo $school_details->phone_no; ?></p>
                </td>
              </tr>
                       
            </tbody>
        </table>
        <div style="text-align: center;font-size:15px; margin-bottom: 6px;"><b>Dues Reminder</b></div>
        <!-- <div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?>
            
        </div> -->
        <table width="100%" border="0"  style="margin-top: -10px;padding-left: 20px;padding-right: 20px;">    
            <tbody>
                <tr>
                    <td  valign="top" style="width:100%;">
                        <?php echo $sname; ?>
                        <br>
                        Class : <?php echo $class_name." ".$section_name; ?>
                        <br>
                        Admission no: <?php echo $sadmsnno; ?>&nbsp&nbsp Date : <?php echo $date; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
      <!-- payment history -->
        <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
            <thead>
                <tr>
                    <td width="50%">Fee Type</td>
                    <td width="20%">T.Month</td>
                    <td width="30%">Amount</td>
                </tr>
            </thead> 
            <tbody>
                <?php
                $sn=0;
                $all_balance = 0;

                foreach ($due_details as $key){

                    if ($key->feetype_title=='Pre Discount') {
                        $pre_discount = $key->total_balance;
                        continue;
                    }

                    $sn++;
                    $all_balance = $all_balance + $key->total_balance;


                	echo "<tr>
                	<td width='50%''>".$key->feetype_title."</td>
                    <td width='20%''>".$key->total_month."</td>
                    <td width='30%''>".$key->total_balance."</td>
                    </tr>";
                	
                }

                ?>
            </tbody>
           
        </table>
        
        
        <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Total Balance:<?php echo $all_balance ?></td>
                    <td valign="top" style="width: 85px;"></td>
                </tr>
                
            </tbody>
        </table>
        <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Advance Paid:<?php echo $advanceAmount; ?></td>
                    <td valign="top" style="width: 85px;"></td>
                </tr>
                
            </tbody>
        </table>

        <?php if (!empty($pre_discount)) { ?>

            <table style="border-top:1px solid #a8adac;width:100%;">  
                <tbody>
                    <tr>
                        <td valign="top" style="width:300px;text-align: right;">Pre Discount:<?php echo $pre_discount; ?></td>
                        <td valign="top" style="width: 85px;"></td>
                    </tr>
                </tbody>
            </table>

        <?php } ?>

        <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:300px;text-align: right;">Total Payable:<?php echo ((float)$all_balance-(float)$pre_discount-(float)$advanceAmount); ?></td>
                    <td valign="top" style="width: 85px;"></td>
                </tr>
                
            </tbody>
       	 </table>
            <!-- <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
            <tbody>
                <tr>
                </tr>
            </tbody>      
            </table> -->
                    
</div> 

</div>