<?php
include("../session.php");
include('../load_backstage.php');

if(isset($_REQUEST['type']) && $_REQUEST['type'] == 'student'){

    $bill_id = $_REQUEST['bill_id'];
    $student_id = $_REQUEST['student_id'];

        $updateCount = $account->update_bill_tables_increment_print_count_by_bill_id($bill_id);

        $bill_details = json_decode($account->get_bill_details_by_bill_id($bill_id));

        $student_details = json_decode($account->get_student_details_by_sid($student_id));

        //$debit_transaction_list = json_decode($account->get_debit_student_transaction_list_by_bill_id($bill_id));

        $debit_transaction_list_group = json_decode($account->get_debit_student_transaction_list_group_by_feetype_by_bill_id($bill_id));

        $credit_transaction = json_decode($account->get_credit_student_transaction_by_bill_id($bill_id));

        $date = $nepaliDate->full;
    
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
        <p style="margin: -18px 0 0 0;text-align: center;">Student Copy</p>
        <div style="text-align: center;font-size:15px;">INVOICE</div>
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
                            Class : 
                            <?php echo $student_details->class_name." ".$student_details->section_name; ?>
                            <br>            
                        </td>
                        <td  valign="top" >
                            Bill No: <?php echo $bill_details->bill_number; ?><br>
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
                        <td width="10%">Balance</td>
                        <td width="10%">Dis.</td>
                        <td width="10%">Fine</td>
                        <td width="20%">Amount</td>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php 
                    $sn=0;
                    $total = 0;
                    $tax = 0;
                    $net_total=0;

                   
                    // foreach ($debit_transaction_list as $key) 
                    // {
                        

                    //     list($bs_year, $bs_month, $bs_day) = explode('-', $key->balance_date);
                    //     $dateFnxn = new NepaliDate();
                    //     if ($student_details->payment_type) {
                    //       $yearMonth  = $bs_year;
                    //     }else{
                    //       $yearMonth=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.")";
                    //     }
                        
                    //     $total = $total + $key->debit;
                    //     $sn++;

                    //     // if($key->feetype_title=='Tution Fee') {
                    //     //     $tax = $key->debit/100;
                    //     // }

                    //    echo"<tr>
                    //         <td>".$sn."</td>
                    //         <td>".$key->feetype_title."</td>
                    //         <td>".$key->balance."</td>
                    //         <td>".$key->discount."</td>
                    //         <td>".$key->fine."</td>
                    //         <td>".$yearMonth."</td>
                    //         <td>".$key->debit."</td>
                    //     </tr>";
                    // }

                    foreach ($debit_transaction_list_group as $key) 
                    {
                        

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
                        
                        $total = $total + $key->debit;
                        $sn++;

                        // if($key->feetype_title=='Tution Fee') {
                        //     $tax = $key->debit/100;
                        // }

                       echo"<tr>
                            <td>".$sn."</td>
                            <td>".$key->feetype_title."</td>
                            <td>".$yearMonth."</td>
                            <td>".$key->balance."</td>
                            <td>".$key->discount."</td>
                            <td>".$key->fine."</td>
                            <td>".$key->debit."</td>
                        </tr>";
                    }
                    //$net_total = $total + $tax;
                    $net_total = $total;
                     
                    ?>  

                    
                </tbody>
               
            </table>
        
        
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Gross Total:</td>
                    <td valign="top" style="width: 85px;"><?php echo $total; ?></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:450px;">
                        <span style="padding: 0 20px">Ajdusted from advance:<?php echo $bill_details->advance_paid; ?></span>
                        <span>    Current paid:<?php echo $credit_transaction->credit; ?></span>
                        <span style="float: right;">Total paid:</span>
                    </td>
                    <td valign="top" style="width: 85px;"><?php echo $total; ?></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Other Due Balance:</td>
                    <td valign="top" style="width: 85px;"style=""><?php echo $bill_details->due_after; ?></td>
                </tr>
                
            </tbody>      
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
            <tbody>
                <tr>
                    <?php 
                 $inword =  $account->get_number_in_word($net_total);
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
</div> <br><br>
<?php if($bill_details->print_count<=1){ ?>

<div class="container" style="border: 1px solid red;border-radius: 10px;">
        
    <div id="invoice_print">
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
        <p style="margin: -18px 0 0 0;text-align: center;">Student Copy</p>
        <div style="text-align: center;font-size:15px;">INVOICE</div>
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
                            Class : 
                            <?php echo $student_details->class_name." ".$student_details->section_name; ?>
                            <br>            
                        </td>
                        <td  valign="top" >
                            Bill No: <?php echo $bill_details->bill_number; ?><br>
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
                        <td width="10%">Balance</td>
                        <td width="10%">Dis.</td>
                        <td width="10%">Fine</td>
                        <td width="20%">Amount</td>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php 
                    $sn=0;
                    $total = 0;
                    $tax = 0;
                    $net_total=0;

                   
                    // foreach ($debit_transaction_list as $key) 
                    // {
                        

                    //     list($bs_year, $bs_month, $bs_day) = explode('-', $key->balance_date);
                    //     $dateFnxn = new NepaliDate();
                    //     if ($student_details->payment_type) {
                    //       $yearMonth  = $bs_year;
                    //     }else{
                    //       $yearMonth=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.")";
                    //     }
                        
                    //     $total = $total + $key->debit;
                    //     $sn++;

                    //     // if($key->feetype_title=='Tution Fee') {
                    //     //     $tax = $key->debit/100;
                    //     // }

                    //    echo"<tr>
                    //         <td>".$sn."</td>
                    //         <td>".$key->feetype_title."</td>
                    //         <td>".$key->balance."</td>
                    //         <td>".$key->discount."</td>
                    //         <td>".$key->fine."</td>
                    //         <td>".$yearMonth."</td>
                    //         <td>".$key->debit."</td>
                    //     </tr>";
                    // }

                    foreach ($debit_transaction_list_group as $key) 
                    {
                        

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
                        
                        $total = $total + $key->debit;
                        $sn++;

                        // if($key->feetype_title=='Tution Fee') {
                        //     $tax = $key->debit/100;
                        // }

                       echo"<tr>
                            <td>".$sn."</td>
                            <td>".$key->feetype_title."</td>
                            <td>".$yearMonth."</td>
                            <td>".$key->balance."</td>
                            <td>".$key->discount."</td>
                            <td>".$key->fine."</td>
                            <td>".$key->debit."</td>
                        </tr>";
                    }
                    //$net_total = $total + $tax;
                    $net_total = $total;
                     
                    ?>  

                    
                </tbody>
               
            </table>
        
        
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Gross Total:</td>
                    <td valign="top" style="width: 85px;"><?php echo $total; ?></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:450px;">
                        <span style="padding: 0 20px">Ajdusted from advance:<?php echo $bill_details->advance_paid; ?></span>
                        <span>    Current paid:<?php echo $credit_transaction->credit; ?></span>
                        <span style="float: right;">Total paid:</span>
                    </td>
                    <td valign="top" style="width: 85px;"><?php echo $total; ?></td>
                </tr>
                
            </tbody>
            <table style="border-top:1px solid #a8adac;width:100%;">  
            <tbody>
                <tr>
                    <td valign="top" style="width:450px;text-align: right;">Other Due Balance:</td>
                    <td valign="top" style="width: 85px;"style=""><?php echo $bill_details->due_after; ?></td>
                </tr>
                
            </tbody>      
            </table>
            <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
            <tbody>
                <tr>
                    <?php 
                 $inword =  $account->get_number_in_word($net_total);
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