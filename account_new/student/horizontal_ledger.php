<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        
<?php
include("../session.php");
require("../account_management.php");
require_once("../nepaliDate.php");
$classname=$_REQUEST['className'];
$account = new account_management_classes();

$className = $account->get_class_name_by_class_id($_REQUEST['classId']);

$school_details = json_decode($account->get_school_details_by_id());

$student_details = json_decode($account->get_student_details_by_className($_REQUEST['classId']));

$date = $nepaliDate->full;

$fee_details=json_decode($account->get_fee_from_student_bill_with_studentinfo($_REQUEST['classId']));

$feetitle=array();


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
                    <!-- <td  valign="top" style="width:60%;">
                        Class : 
                        <?php echo $classname;?>
                        <br>            
                    </td>
                    <td valign="top" style="">Due Ledger</td>
                    <td  valign="top" style="text-align: right" >
                        Date : <?php echo $date; ?>
                    </td> -->
                    <td style="text-align:left">Class: <?php echo $className; ?></td>
                    <td style="text-align:right;">Due Ledger</td>
                    <td style="text-align: right">Date:<?php echo $date; ?></td>
                </tr>
            </tbody>
        </table><br>
        
      <!-- payment history -->
        <table class="table" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac; font-size:12px;">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>class</th>
                    <th>sroll</th>
                    <?php
                    
                        foreach ($fee_details as $key) {
                            echo "<th>$key->feetype_title</th>";
                            array_push($feetitle,$key->feetype_title);
                        }                        
                    ?>
                    <th>Gross Total</th>
                    <th>Tution Tax</th>
                    <th>Total</th>
                    
                </tr>
            </thead>
            
            <tbody>
                 <?php
                foreach($student_details as $key)
                { $sid=$key->sid;
                 
                ?>
                <tr>
                        <td><?php echo $key->sname; ?></td>
                        <td><?php echo $key->class_name."-".$key->section_name; ?></td>
                        <td><?php echo $key->sroll; ?></td>
                        <?php 
                        $gross_total=0;
                        $tax_on_tution=0;
                        $total=0;
                        //$a;
                        $index=0;

                        $student_balance= json_decode($account->get_student_balance($sid));

                        
                        foreach($feetitle as $key) { ?>
                        <td>

                            <?php  
                            // echo $feetitle[$index];
                            $fieldFound=false;
                            foreach($student_balance as $key2) {

                                if ($key2->feetype_title==$feetitle[$index] ) {
                                    if($key2->balance){
                                        echo $key2->balance;
                                        $gross_total=$gross_total+$key2->balance;
                                    }else
                                    {
                                         echo "0";                         
                                    } 

                                    if ($key2->feetype_title=='Tution Fee') {
                                        $tax_on_tution=($key2->balance*1/100);
                                    }
                                    $fieldFound=true;
                                }
                            }

                            if (!$fieldFound) {
                                echo "0";

                            }
                            $index=$index+1;

                            ?>
    
                        </td>
                        
                        <?php  ?>
                        
                         <?php }
                         $total=$gross_total+$tax_on_tution;
                          ?>
                             
                              <td><?php echo $gross_total; ?></td>
                              <td><?php echo $tax_on_tution; ?></td>
                              <td><?php echo $total; ?></td>
                                      

                <?php                    
                }
                ?>
            </tr>
            </tbody>
        </table>

