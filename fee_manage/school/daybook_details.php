<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');

if(isset($_REQUEST['reuestForDaybookDetails'])){
  $selectedDate = $_REQUEST['reuestForDaybookDetails'];
  $class_id = $_GET['classId'];

  $studentClassCreditDetails = json_decode($account->get_day_book_credit_details_by_class_date($class_id,$selectedDate)); 

}
?>
<style type="text/css">
  
  .cashDetailContainer{
    line-height: 1!important;
    font-size: 15px;
  }
  .payerDetail{
    padding-top: 18px!important;
  }
  .cAmount{
    padding-top: 20px!important;
  }
  .schoolName{
    line-height: 2!important;
  }
</style>
<body>
  
<?php include("../config/navbar.php"); ?>


<section id="main-content" class="mainContentContainer">
  <div class="cMargin">
      <h2 class="text-center">Daybook Report Details, Date <?php echo $selectedDate;  ?></h2>
        

      <br><br>

      <div class="panel panel-default">
        <div class="panel-body">
          <div class="row no-margin">
           <div class="col-md-12 no-padding">
              <h3>Income</h3>
              <table class="table table-hover table-bordered no-margin">
                <thead>
                  <tr>
                    <th>Roll no</th>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Type</th>
                    <th>Ammount</th>
                    <th>Bill No</th>
                    <th>View/Print Bill</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $totalIncome = 0;
                  
                    foreach ($studentClassCreditDetails as $key){ ?> 
                      <tr>
                        <td><?php echo $key->sroll; ?></td>
                        <td><?php echo $key->sname; ?></td>
                        <td><?php echo $key->class_name.' - '.$key->section_name; ?></td>
                        <td><?php echo (($key->bill_type==1)? ' Fee Payment' : 'Advance Payment'); ?></td>
                        <td><?php echo $key->income; ?></td>
                        <td><?php echo $key->bill_number; ?></td>
                        <td>

                          <button class='btn btn-info' style='color:#fff;' onclick='view_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,<?php echo $key->sid; ?>)' ><i class="fa fa-eye"></i> View</button>

                      
                          <button class="btn btn-success" onclick='create_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,<?php echo $key->sid; ?>)' ><i class="fa fa-print"></i> Print</button>

                        </td>
                      </tr>
                      <?php 
                      $totalIncome += $key->income;
                    }
                    ?>
                </tbody>
                <tfoot>
                   <tr class="success">
                    <td colspan="4">Total Income:</td>
                    <td colspan="3"><?php echo $totalIncome; ?></td>
                  </tr>
                </tfoot>
              </table>
            </div>           
          </div>
          </div>
      </div>
      
      
  </div>
  
  
</section>
<!--=====================  START MODAL FOR VIEW BILL ================= -->
<div id="myModal" class="modal fade">
<div class="modal-dialog" style="width: max-content">
    <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><i class="fa fa-eye"></i> Viewing Bill</h4>
            </div>
            <div class="modal-body">
                <p>Loading...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <!-- <button type="submit" class="btn btn-primary">Save changes</button> -->
            </div>
    </div>
</div>
<!--=====================  END MODAL FOR VIEW BILL ================= -->



<?php require('../config/commonFooter.php'); ?>

<script type="text/javascript">
      function create_bill(bill_id,bill_type,sid)
      {
        var url='';
        var type = 'student';
        var student_id = sid;


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
      function view_bill(bill_id,bill_type,sid)
      {
        var url='';
        var type = 'student';
        var student_id = sid;


        if (bill_type==1) {
          url='../school/bill_print_format_student.php?no_count=no_count&type='+type+'&student_id='+student_id+'&bill_id='+bill_id;
        }else{
          url='../school/cashReceipt.php?no_count=no_count&advance_pay_receipt='+student_id+'&bill_id='+bill_id;
        }
        // $('#viewBillBody').src(url);
       $('#myModal').modal('show').find('.modal-body').load(url);
        // $("#myModal").modal();
       // var printWindow = window.open(url, 'Print', '');
       //  printWindow.addEventListener('load', function(){
       //    debugger;
       //    $('#viewBillBody').append(printWindow);
       //      // printWindow.print();
       //      // printWindow.close();
       //      // bill_print_form.type.value = 'student';
       //      // bill_print_form.bill_number.value ='';
       //  }, true);
        
      }
    </script>

</body>
</html>
