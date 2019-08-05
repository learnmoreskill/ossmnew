<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<?php
include("../session.php");
include('../load_backstage.php');

$date = $nepaliDate->full;

$class_id = $_REQUEST['classId'];

if (!empty($class_id)) {
    
$className = $account->get_class_name_by_class_id($class_id);

$student_details = json_decode($account->get_active_student_details_by_class_id($class_id));


// $fee_details=json_decode($account->get_fee_from_student_bill_with_studentinfo($class_id));

// $feetitle=array();


//$students=json_decode($account->get_student_bill_details($_REQUEST['className']));
?>

        
    <div id="invoice_print" style="margin-bottom: 20px;">
         <table width="100%" style="border-bottom: 1px solid #a8adac;">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
                        <td style="">
                         <p style="font-size: 20;font-style: bold;"><?php echo $school_details->school_name; ?></p>
                        <p><?php echo $school_details->school_address; ?></p>
                        <p><?php echo $school_details->phone_no; ?></p>
                        </td>
                        <!-- <td style="float: right;font-size: 12px;">PAN.NO:<?php echo $school_details->pan_no; ?></td> -->
                      </tr>
                        
                    </td>

                </tr>
            </tbody>
        </table>
         <div style="text-align:center;font-size:20px;"></div><br>
        <table width="100%" border="0"  style="margin-top: -10px;padding-left: 30px;padding-right: 30px;">    
            <tbody>
                <tr >
                    <td style="text-align:left">Class: <?php echo $className; ?></td>
                    <td style="text-align:right;">Due Ledger</td>
                    <td style="text-align: right">Date:<?php echo $date; ?></td>
                </tr>
            </tbody>
        </table><br>
        
      <!-- payment history -->
        <table class="table" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac; font-size:12px;">
            <thead>
                <tr >
                    <th>Roll No</th>
                    <th>Name</th>
                    <th>Class</th>
                    <th>Total Balance</th>
                    <th>Advanced Paid</th>
                    <th>Total Payable</th>
                    
                </tr>
            </thead>
            
            <tbody>
                 <?php
                foreach($student_details as $key)
                { 
                    $student_id = $key->sid;

                    $balance = 0;
                    $advance = 0;
                    $payable = 0;
                    $balance = $account->get_total_balance_from_student_due_by_std_id($student_id);
                    $advance = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);
                    $payable = (float)$balance-(float)$advance;
                        
                 
                ?>
                <tr <?php echo ((empty($payable))? "style='background: chartreuse;'" : "" );  ?>   >
                        <td><?php echo $key->sroll; ?></td>
                        <td><?php echo $key->sname; ?></td>
                        <td><?php echo $key->class_name."-".$key->section_name; ?></td>    
                        <td><?php echo $balance; ?></td>
                        <td><?php echo $advance; ?></td>
                        <td><?php echo $payable; ?></td>
                                      

                
                </tr >
                <?php                    
                }
                ?>
            </tbody>
        </table>

<?php }else{
echo "No record found";
}  ?>