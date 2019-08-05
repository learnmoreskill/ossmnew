<?php
include("../session.php");
include('../load_backstage.php');

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'student'){

    $bill_id = $_REQUEST['bill_id'];
    $student_id = $_REQUEST['student_id'];

    if ($_GET['no_count']!='no_count') {

        $updateCount = $account->update_bill_tables_increment_print_count_by_bill_id($bill_id);
    }

    $student_details = json_decode($account->get_student_details_by_sid($student_id));

    $bill_details = json_decode($account->get_bill_details_by_bill_id($bill_id));

    //$debit_transaction_list = json_decode($account->get_debit_student_transaction_list_by_bill_id($bill_id));

    $debit_transaction_list_group = json_decode($account->get_debit_student_transaction_list_group_by_feetype_by_bill_id($bill_id));

    $credit_transaction = json_decode($account->get_credit_student_transaction_by_bill_id($bill_id));

    $date = $nepaliDate->full;

    $pre_discount = 0;
    
}else{
    echo "Invalid request";
}

?>
<style type="text/css">
    /*watermark*/
.watermark{
    position: absolute;
    z-index: -1;
    background: white;
    display: block;
    min-height: 40%;
    min-width: 50%;
    text-align: center;
    margin: 0 25%;
}
/*
#content{
    position:absolute;
    z-index:1;
}*/

.bg-text
{
    color:lightgrey;
    font-size:75px;
    transform:rotate(325deg);
    -webkit-transform:rotate(325deg);
}
</style>
<?php
if(!empty($bill_details) || !empty($pay_me_details))
{
?>

<div class="container" style="border: 1px solid red;border-radius: 10px;">
        
    <div id="invoice_print">
        <table width="100%" style="border-bottom: 1px solid #a8adac;">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
                        <td class="schoolName">
                         <p style="font-size: 20;font-style: bold;margin-top: -20px;margin-left:-20px;"><?php echo $school_details->school_name; ?></p>
                        <p style="margin-top: -20px;margin-left:-20px;"><?php echo $school_details->school_address; ?></p>
                        <p style="margin-top: -20px;margin-left:-20px;"><?php echo $school_details->phone_no; ?></p>

                        </td>
                      </tr>
                        
                    </td>

                </tr>
            </tbody>
        </table>
        <!-- <p style="margin: -18px 0 0 0;text-align: center;">Student Copy</p> -->
        <div style="text-align: center;font-size:15px;">Cash Receipt</div>
        <div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?></div>

        <?php if($bill_details->print_count>1){ ?>
            <div class="watermark">
                <p class="bg-text">Duplicte</p>
            </div>
        <?php } ?>
            <table width="100%" border="0"  style="margin-top: -10px;padding-left: 20px;padding-right: 20px;">    
                <tbody>
                   
                    <tr>
                        <td  valign="top" style="width:60%;">
                            <?php echo $student_details->sname; ?>
                            <br>
                            Admission no: 
                            <?php echo $student_details->sadmsnno; ?>
                            <br>
                            Class : <?php echo ((!empty($bill_details->class_name))? $bill_details->class_name : $student_details->class_name) ." ".((!empty($bill_details->section_name))? $bill_details->section_name : $student_details->section_name); ?>
                            <br>            
                        </td>
                        <td  valign="top" >
                            S. N. : <?php echo $bill_details->bill_number; ?><br>
                            Date : <?php echo $bill_details->date; ?>
                        </td>
                    </tr>
                            
                </tbody>
            </table>
        
      <!-- payment history -->
            <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
                <thead>
                    
                    <tr>
                        <td width="10%">S. No</td>
                        <td width="20%">Fee Type</td>
                        <td width="25%">Due Date</td>
                        <!-- <td width="10%">Balance</td>
                        <td width="10%">Dis.</td>
                        <td width="10%">Fine</td> -->
                        <td width="20%">Amount</td>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php 
                    $sn=0;
                    $total = 0;
                    $tax = 0;
                    $net_total=0;
                    $allDiscount = 0;
                    $allFine = 0;


                    foreach ($debit_transaction_list_group as $key) 
                    {
                        if ($key->feetype_title=='Pre Discount') {
                          $pre_discount = $key->balance;
                          continue;
                        }
                        

                        $yearMonth = '';

                        $date_arr = explode (",", $key->balance_date);


                        foreach ($date_arr as &$perdate) {

                          list($bs_year, $bs_month, $bs_day) = explode('-', $perdate);
                          $dateFnxn = new NepaliDate();
                          if ($student_details->payment_type) {
                            $yearMonth  .= $bs_year;
                          }else{
                            $yearMonth .=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.") ";
                          }
                        }
                        
                        $total = $total + $key->balance;
                        $sn++;

                        // if($key->feetype_title=='Tution Fee') {
                        //     $tax = $key->debit/100;
                        // }

                        ?>

                       <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo $key->feetype_title; ?></td>
                            <td><?php echo $yearMonth; ?></td><!-- 
                            <td><?php echo $key->balance; ?></td>
                            <td><?php echo $key->discount; ?></td>
                            <td><?php echo $key->fine; ?></td> -->
                            <td><?php echo $key->balance; ?></td>
                        </tr> 
                        <?php
                        $allDiscount += $key->discount;
                        $allFine += $key->fine;
                    }
                    //$net_total = $total + $tax;
                    $net_total = $total;

                    $allDiscount += $credit_transaction->discount;
                    $allFine += $credit_transaction->fine;
                     
                    ?>  

                    
                </tbody>
               
            </table>
        
        
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Total:</td>
                    <td valign="top" style="width: 168px;"><?php echo $total; ?></td>
                </tr>

                <?php if (!empty($pre_discount)) { ?>

                    <tr>
                    <td valign="top" style="width:450px;text-align: right;">Pre Discount:</td>
                    <td valign="top" style="width: 168px;"><?php echo $pre_discount; ?></td>
                </tr>
                    
                <?php } ?>


                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Discount:</td>
                    <td valign="top" style="width: 168px;"><?php echo $allDiscount; ?></td>
                </tr>

                

                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Fine:</td>
                    <td valign="top" style="width: 168px;"><?php echo $allFine; ?></td>
                </tr>
            </tbody>
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;">  
                <tbody>
                    <tr>
                        <td valign="top" style="width:450px;text-align: right;">Total Payable:</td>
                        <td valign="top" style="width: 168px;"><?php

                            $totalPayableNew = $total - $advanceAmnt - $pre_discount - $allDiscount + $allFine + 0;
                            if($totalPayableNew < 0){ $totalPayableNew = 0; } 
                            echo $totalPayableNew; 

                        ?></td>
                    </tr>                
                </tbody>      
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>

                <?php if (!empty($bill_details->advance_paid)) { ?>

                    <tr>
                    <td valign="top" style="width:450px;text-align: right;">Ajdusted from advance:</td>
                    <td valign="top" style="width: 168px;"><?php echo $bill_details->advance_paid; ?></td>
                </tr>

                <?php } ?>
                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Total Paid:</td>
                    <td valign="top" style="width: 168px;"><?php echo ((!empty($credit_transaction->credit))? $credit_transaction->credit : 0); ?></td>
                </tr>
                
            </tbody>
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;">  
                <tbody>
                    <tr>
                        <td valign="top" style="width:450px;">
                            <span style="padding: 0 20px">Advance Remain:<?php echo $bill_details->advance_after; ?></span>
                            <span style="float: right;">Due Remain:</span>
                        </td>
                        <td valign="top" style="width: 168px;"style=""><?php echo $bill_details->due_after; ?></td>
                    </tr>
                    
                </tbody>      
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
            <tbody>
                <tr>
                    <?php 
                 $inword =  $account->get_number_in_word((!empty($credit_transaction->credit))? $credit_transaction->credit : 0);
                echo "
                <td valign='top' colspan='2' style='width:50px;text-align: left;''>Inword: ".$inword."</td>
                ";
                ?>
            </tr>
            <tr>
                <td>
                    <!-- <pre> -->
                        Received From: <?php echo $credit_transaction->payment_by; ?>
                    <!-- </pre> -->
                </td>
                <td style="text-align: center;">
                    <!-- <pre> -->
                       <span style="text-decoration:underline;"> <?php echo (($bill_details->t_role == 1)? $bill_details->pname : (($bill_details->t_role == 5)? $bill_details->staff_name : '' ) ); ?> </span><br>
                        Received By(Sign)
                    <!-- </pre> -->
                </td>
            </tr>
            </tbody>      
            </table>          
    </div>
</div> 
<?php if($bill_details->print_count<=1 && $_GET['no_count']!='no_count'){ ?>
    <br><br>

    <div class="container" style="border: 1px solid red;border-radius: 10px;">
        
            <div id="invoice_print">
                <table width="100%" style="border-bottom: 1px solid #a8adac;">
                    <tbody>
                        <tr>
                            <td align="center">
                              <tr align="center">
                                <td width="100px"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
                                <td class="schoolName">
                                 <p style="font-size: 20;font-style: bold;margin-top: -20px;margin-left:-20px;"><?php echo $school_details->school_name; ?></p>
                                <p style="margin-top: -20px;margin-left:-20px;"><?php echo $school_details->school_address; ?></p>
                                <p style="margin-top: -20px;margin-left:-20px;"><?php echo $school_details->phone_no; ?></p>

                                </td>
                              </tr>
                                
                            </td>

                        </tr>
                    </tbody>
                </table>
                <!-- <p style="margin: -18px 0 0 0;text-align: center;">Student Copy</p> -->
                <div style="text-align: center;font-size:15px;">Cash Receipt Copy</div>
                <div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?></div>

                <?php if($bill_details->print_count>1){ ?>
                    <div class="watermark">
                        <p class="bg-text">Duplicte</p>
                    </div>
                <?php } ?>
                    <table width="100%" border="0"  style="margin-top: -10px;padding-left: 20px;padding-right: 20px;">    
                        <tbody>
                           
                            <tr>
                                <td  valign="top" style="width:60%;">
                                    <?php echo $student_details->sname; ?>
                                    <br>
                                    Admission no: 
                                    <?php echo $student_details->sadmsnno; ?>
                                    <br>
                                    Class : <?php echo ((!empty($bill_details->class_name))? $bill_details->class_name : $student_details->class_name) ." ".((!empty($bill_details->section_name))? $bill_details->section_name : $student_details->section_name); ?>
                                    <br>            
                                </td>
                                <td  valign="top" >
                                    S. N. : <?php echo $bill_details->bill_number; ?><br>
                                    Date : <?php echo $bill_details->date; ?>
                                </td>
                            </tr>
                                    
                        </tbody>
                    </table>
                
              <!-- payment history -->
                    <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
                        <thead>
                            
                            <tr>
                                <td width="10%">S.No</td>
                                <td width="20%">Fee Type</td>
                                <td width="25%">Due date</td>
                                <!-- <td width="10%">Balance</td>
                                <td width="10%">Dis.</td>
                                <td width="10%">Fine</td> -->
                                <td width="20%">Amount</td>
                            </tr>
                            
                        </thead>
                        <tbody>
                            <?php 
                            $sn=0;
                            $total = 0;
                            $tax = 0;
                            $net_total=0;
                            $allDiscount = 0;
                            $allFine = 0;


                            foreach ($debit_transaction_list_group as $key) 
                            {
                                if ($key->feetype_title=='Pre Discount') {
                                  $pre_discount = $key->balance;
                                  continue;
                                }
                                

                                $yearMonth = '';

                                $date_arr = explode (",", $key->balance_date);


                                foreach ($date_arr as &$perdate) {

                                  list($bs_year, $bs_month, $bs_day) = explode('-', $perdate);
                                  $dateFnxn = new NepaliDate();
                                  if ($student_details->payment_type) {
                                    $yearMonth  .= $bs_year;
                                  }else{
                                    $yearMonth .=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.") ";
                                  }
                                }
                                
                                $total = $total + $key->balance;
                                $sn++;

                                // if($key->feetype_title=='Tution Fee') {
                                //     $tax = $key->debit/100;
                                // }

                                ?>

                               <tr>
                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $key->feetype_title; ?></td>
                                    <td><?php echo $yearMonth; ?></td><!-- 
                                    <td><?php echo $key->balance; ?></td>
                                    <td><?php echo $key->discount; ?></td>
                                    <td><?php echo $key->fine; ?></td> -->
                                    <td><?php echo $key->balance; ?></td>
                                </tr> 
                                <?php
                                $allDiscount += $key->discount;
                                $allFine += $key->fine;
                            }
                            //$net_total = $total + $tax;
                            $net_total = $total;

                            $allDiscount += $credit_transaction->discount;
                            $allFine += $credit_transaction->fine;
                             
                            ?>  

                            
                        </tbody>
                       
                    </table>
                
                
                    <table style="border-top:1px solid #a8adac;width:100%;">  
                    <tbody>
                        <tr>
                            <td valign="top" style="width:450px;text-align: right;">Total:</td>
                            <td valign="top" style="width: 168px;"><?php echo $total; ?></td>
                        </tr>

                        <?php if (!empty($pre_discount)) { ?>

                            <tr>
                            <td valign="top" style="width:450px;text-align: right;">Pre Discount:</td>
                            <td valign="top" style="width: 168px;"><?php echo $pre_discount; ?></td>
                        </tr>
                            
                        <?php } ?>


                        <tr>
                            <td valign="top" style="width:450px;text-align: right;">Discount:</td>
                            <td valign="top" style="width: 168px;"><?php echo $allDiscount; ?></td>
                        </tr>

                        

                        <tr>
                            <td valign="top" style="width:450px;text-align: right;">Fine:</td>
                            <td valign="top" style="width: 168px;"><?php echo $allFine; ?></td>
                        </tr>
                    </tbody>
                    </table>
                    <table style="border-top:1px solid #a8adac;width:100%;">  
                        <tbody>
                            <tr>
                                <td valign="top" style="width:450px;text-align: right;">Total Payable:</td>
                                <td valign="top" style="width: 168px;"><?php

                                    $totalPayableNew = $total - $advanceAmnt - $pre_discount - $allDiscount + $allFine + 0;
                                    if($totalPayableNew < 0){ $totalPayableNew = 0; } 
                                    echo $totalPayableNew; 

                                ?></td>
                            </tr>                
                        </tbody>      
                    </table>
                    <table style="border-top:1px solid #a8adac;width:100%;">  
                    <tbody>

                        <?php if (!empty($bill_details->advance_paid)) { ?>

                            <tr>
                            <td valign="top" style="width:450px;text-align: right;">Ajdusted from advance:</td>
                            <td valign="top" style="width: 168px;"><?php echo $bill_details->advance_paid; ?></td>
                        </tr>

                        <?php } ?>
                        <tr>
                            <td valign="top" style="width:450px;text-align: right;">Total Paid:</td>
                            <td valign="top" style="width: 168px;"><?php echo ((!empty($credit_transaction->credit))? $credit_transaction->credit : 0); ?></td>
                        </tr>
                        
                    </tbody>
                    </table>
                    <table style="border-top:1px solid #a8adac;width:100%;">  
                        <tbody>
                            <tr>
                                <td valign="top" style="width:450px;">
                                    <span style="padding: 0 20px">Advance Remain:<?php echo $bill_details->advance_after; ?></span>
                                    <span style="float: right;">Due Remain:</span>
                                </td>
                                <td valign="top" style="width: 168px;"style=""><?php echo $bill_details->due_after; ?></td>
                            </tr>
                            
                        </tbody>      
                    </table>
                    <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
                    <tbody>
                        <tr>
                            <?php 
                         $inword =  $account->get_number_in_word((!empty($credit_transaction->credit))? $credit_transaction->credit : 0);
                        echo "
                        <td valign='top' colspan='2' style='width:50px;text-align: left;''>Inword: ".$inword."</td>
                        ";
                        ?>
                    </tr>
                    <tr>
                        <td>
                            <!-- <pre> -->
                                Received From: <?php echo $credit_transaction->payment_by; ?>
                            <!-- </pre> -->
                        </td>
                        <td style="text-align: center;">
                            <!-- <pre> -->
                               <span style="text-decoration:underline;"> <?php echo (($bill_details->t_role == 1)? $bill_details->pname : (($bill_details->t_role == 5)? $bill_details->staff_name : '' ) ); ?> </span><br>
                                Received By(Sign)
                            <!-- </pre> -->
                        </td>
                    </tr>
                    </tbody>      
                    </table>          
            </div>
        </div>
        
    
<?php } ?>
<?php 
}else{
    echo "Invalid Bill Number !!";
}
?>