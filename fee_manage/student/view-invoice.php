<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');
?>
<?php

$student_id=$_GET['student_id'];

$student_details = json_decode($account->get_student_details_by_sid($student_id));

$last_bill_id = $account->get_last_bill_print_id_by_student_id($student_id);

$bill_details = json_decode($account->get_bill_details_by_bill_id($last_bill_id));

//$debit_transaction_list = json_decode($account->get_debit_student_transaction_list_by_bill_id($last_bill_id));

$debit_transaction_list_group = json_decode($account->get_debit_student_transaction_list_group_by_feetype_by_bill_id($last_bill_id));

$credit_transaction = json_decode($account->get_credit_student_transaction_by_bill_id($last_bill_id));

?>

<body>
<?php include('../config/navbar.php'); ?>


  <section id="main-content">
    <section class="wrapper">
      <?php 
      if(!empty($bill_details)){ ?>
        <div class="table-agile-info" id='load_edit_teacher_record'>
          <div class="panel panel-default">
            <div class="panel-heading" >
             <h3 class="no-margin"> Bill Details For Student <strong><?php echo $student_details->sname; ?> </strong></h3>
            </div>
            <div class="table-responsive" style='padding: 10px;'>
              <table id='studentDetailsTable' class="table table-striped b-t b-light no-margin">
              
                <div class="alert alert-warning no-margin" role="alert">
                  <span><h4 class="no-margin">Last Bill Details</h4></span>    
                </div>
                <!-- <br> -->
                <thead>
                  <tr>
                    <th scope="col">S.N.</th>
                    <th scope="col">Fees type</th>
                    <th scope="col">Due Date</th>
                    <th scope="col">Balance</th>
                    <th scope="col">Discount</th>
                    <th scope="col">Fine</th>
                    <th scope="col">Amount</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $sn=0;
                  $total = 0;
                  $yearMonth = '';
                  // foreach ($debit_transaction_list as $key) 
                  // {
                    //$n_month = $last_month = date("$nepaliDate->nmonth",strtotime($key->last_payment_date));
                    // $feetype_name = $account->get_feetype_title_by_feetype_id($key->feetype_id);
                    

                    // list($bs_year, $bs_month, $bs_day) = explode('-', $key->balance_date);
                    // $dateFnxn = new NepaliDate();
                    // if ($student_details->payment_type) {
                    //   $yearMonth  = $bs_year;
                    // }else{
                    //   $yearMonth=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.")";
                    // }
                    
                    // $total = $total + $key->debit;
                    // $sn++;  ?>
                    <!-- <tr> 
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $feetype_name; ?></td>
                      <td><?php echo $key->balance; ?></td>
                      <td><?php echo $key->discount; ?></td>
                      <td><?php echo $key->fine; ?></td>
                      <td><?php echo $yearMonth; ?></td>
                      <td><?php echo $key->debit; ?></td>
                    </tr> -->
                    <?php
                  //} 

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
                    $sn++;  ?>
                    <tr> 
                      <td><?php echo $sn; ?></td>
                      <td><?php echo $key->feetype_title; ?></td>
                      <td><?php echo $yearMonth;  ?></td>
                      <td><?php echo $key->balance; ?></td>
                      <td><?php echo $key->discount; ?></td>
                      <td><?php echo $key->fine; ?></td>
                      <td><?php echo $key->debit; ?></td>
                    </tr>
                    <?php
                  } 


                  ?>
                  <tr> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Gross Total:</td>
                    <td><?php echo $total; ?></td>
                  </tr> 
                  <tr> 
                    <td></td>
                    <td>Adjusted from advance:</td>
                    <td><?php echo $bill_details->advance_paid; ?></td>
                    <td>Current paid:</td>
                    <td><?php echo $credit_transaction->credit; ?></td>
                    <td>Total Paid:</td>
                    <td><?php echo $total; ?></td>
                  </tr> 
                  <tr> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Paid by:</td>
                    <td><?php echo $credit_transaction->payment_by; ?></td>
                    <td>Received by:</td>
                    <td><?php echo (($bill_details->t_role==1)? $bill_details->pname : (($bill_details->t_role==5)? $bill_details->staff_name : '')); ?></td>
                  </tr> 
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <?php
      }  
      $bills=json_decode($account->get_bill_list_by_std_id($student_id));
      if(count((array)$bills)>0){ ?>
        <div class="alert alert-warning" role="alert">
          <table id='studentDetailsTable' class="table table-striped b-t b-light no-margin">
            <thead>
              <tr>
                <th scope="col">S.N.</th>
                <th scope="col">Bill Number</th>
                <th scope="col">Bill Type</th>
                <th scope="col">Bill Date</th>
                <th scope="col">Print Count</th>
                <td scope="col">Action</td>
              </tr>
            </thead>
            <tbody>
              <?php
                
                $sn=1;
                foreach ($bills as $key) {
                  ?>
                  <tr>
                  <td><?php echo $sn; ?></td>
                  <td><?php echo $key->bill_number; ?></td>
                  <td><?php echo (($key->bill_type)? 'Payment' : 'Advance'); ?></td>
                  <td><?php echo $key->date; ?></td>
                  <td><?php echo $key->print_count; ?></td>
                  <td><input id='<?php echo $key->id; ?>' onclick='create_bill(this.id,<?php echo $key->bill_type; ?>)' readonly='true' class='btn btn-primary' value='Print Again' style='width:100px';></td>
                  </tr>
                  <?php
                  $sn=$sn+1;
                }
              ?>
            </tbody>

          </table>
        </div>
        <?php
      }else{ ?>
        <div>
          <h5>There are no any student bill founds!! </h5>
        </div>
      <?php 
      }
      ?> 
    </section>
  </section>


<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>
    
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
    <script src="../assets/js/sparkline-chart.js"></script>    
    <script src="../assets/js/zabuto_calendar.js"></script>    
 <script type="text/javascript">
      function create_bill(bill_id,bill_type)
      {
        var url='';
        var type = 'student';
        var student_id = '<?php echo $student_id; ?>';


        if (bill_type==1) {
          url='../school/bill_print_format_student.php?type='+type+'&student_id='+student_id+'&bill_id='+bill_id;
        }else{
          url='../school/cashReceipt.php?advance_pay_receipt='+student_id+'&bill_id='+bill_id;
        }
        
        
       var printWindow = window.open(url, 'Print', '');
        printWindow.addEventListener('load', function(){
            printWindow.print();
            printWindow.close();
            bill_print_form.type.value = 'student';
            bill_print_form.bill_number.value ='';
        }, true);
        
      }
    </script>
</body>
</html>
