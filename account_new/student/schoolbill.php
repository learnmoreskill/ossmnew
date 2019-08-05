<?php
require("../account_management.php");
require("../nepaliDate.php");
$account = new account_management_classes();
$school_details = json_decode($account->get_school_details_by_id());

$student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));

$max_bill_print_id_by_std_id = $account->get_max_bill_print_id_by_student_id($_GET['student_id']);

$bill_details = json_decode($account->get_bill_details_by_bill_id_std_id($max_bill_print_id_by_std_id,$_GET['student_id']));
$bill_number = $account->get_bill_number_by_max_id($max_bill_print_id_by_std_id);
$date = $nepaliDate->full;
$account->update_bill_print_status($max_bill_print_id_by_std_id);
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
        <div style="text-align: center;font-size:15px;">INVOICE</div>
        <!-- <div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?>            
        </div> -->
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
                        <?php echo $student_details->sclass." ".$student_details->ssec ?>
                        <br>            
                    </td>
                    <td  valign="top" style="text-align: right;">
                        Bill No: <?php echo $bill_number; ?><br>
                        Date : <?php echo $date; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        
      <!-- payment history -->
        <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
            <thead>
                <tr>
                    <td width="10%">S.No</td>
                    <td width="30%">Fee Type</td>
                    <td width="10%">Dis.</td>
                    <td width="15%">Fine</td>
                    <td width="15%">T.Month</td>
                    <td width="30%">Amount</td>
                    

                </tr>
            </thead>
            <tbody>
                <?php 
                $sn=0;
                $total = 0;
                $tax = 0;
                $net_total=0;
                foreach ($bill_details as $key) 
                {
                   
                    $n_month = $last_month = date("$nepaliDate->nmonth",strtotime($key->last_payment_date));
                    $month = $account->get_nepali_month($n_month);
                    $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
                   $total = $total +  $key->paid;
                   if($feetype=='Tution Fee')
                   {
                    $balance = $key->paid;
                    $tax = $balance/100;
                   }
                      if($feetype=='Tution Fee' || $feetype=='Bus Fee' || $feetype=='Hostel Fee'|| $feetype=='Computer Fee')
                      {
                        $month = $account->get_nepali_month($n_month);
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

    
