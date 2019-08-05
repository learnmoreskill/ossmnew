<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');

$todayNepaliDate = $nepaliDate->full;


?>
<link rel="stylesheet" type="text/css" href="../assets/css/nepali.datepicker.v2.2.min.css" />
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
      <h2 class="text-center">Daybook</h2>
        <div style="display: inline-flex;">
              <input type="text" id="nepaliDateDayBook" class="form-control nepali-calendar"  placeholder="YYYY-MM-DD" value="<?php echo $todayNepaliDate; ?>" style="margin-right: 5px">
        <button class="btn btn-info" onclick="callDailyReportByDate()">Submit</button>

       <!--  <select class="form-control" style="margin-left: 8px" id="incomeReportType" onchange="incomeReportTypeChange()">
            <option value="categorywise" selected >Fee Type Wise</option>
            <option value="detailwise" selected >Details Wise</option>
            <option value="classwise">Class Wise</option>
        </select>  -->



      </div>

      <br><br>
      <div id="daybookcontent">
        Loading...        
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
<script type="text/javascript" src="../assets/js/nepali.datepicker.v2.2.min.js"></script>


<script type="text/javascript">
  $('#daybookcontent').load('../school/getdaybookreport.php?request_for_daybook_by_date=<?php echo $todayNepaliDate; ?>&incomeReportType=detailwise');


  $(document).ready(function(){
    $('#nepaliDateDayBook').nepaliDatePicker({
      npdMonth: true,
      npdYear: true,
      npdYearCount: 10
    });
  });

  function callDailyReportByDate(){
    var selectedDate = document.getElementById('nepaliDateDayBook').value;
    //var incomeReportType = document.getElementById('incomeReportType').value;
    $('#daybookcontent').load('../school/getdaybookreport.php?request_for_daybook_by_date='+selectedDate+'&incomeReportType=detailwise');
  }
  function incomeReportTypeChange(){
    var selectedDate = document.getElementById('nepaliDateDayBook').value;
    var incomeReportType = document.getElementById('incomeReportType').value;
    $('#daybookcontent').load('../school/getdaybookreport.php?request_for_daybook_by_date='+selectedDate+'&incomeReportType='+incomeReportType);
  }








      function create_bill(bill_id,bill_type,sid){
        var url='';
        var type = 'student';
        var student_id = sid;


        if (bill_type==1) {
          url='../school/bill_print_format_student.php?type='+type+'&student_id='+student_id+'&bill_id='+bill_id;
        }else if (bill_type==0){
          url='../school/cashReceipt.php?advance_pay_receipt='+student_id+'&bill_id='+bill_id;
        }else if (bill_type==3){
          url='../school/incomeReceipt.php?type=income&bill_id='+bill_id;
        }
        
        
       var printWindow = window.open(url, 'Print', '');
        printWindow.addEventListener('load', function(){
            printWindow.print();
            printWindow.close();
            bill_print_form.type.value = 'student';
            bill_print_form.bill_number.value ='';
        }, true);
        
      }


      function view_bill(bill_id,bill_type,sid){
        var url='';
        var type = 'student';
        var student_id = sid;


        if (bill_type==1) {
          url='../school/bill_print_format_student.php?no_count=no_count&type='+type+'&student_id='+student_id+'&bill_id='+bill_id;
        }else if (bill_type==0){
          url='../school/cashReceipt.php?no_count=no_count&advance_pay_receipt='+student_id+'&bill_id='+bill_id;
        }else if (bill_type==3){
          url='../school/incomeReceipt.php?no_count=no_count&type=income&bill_id='+bill_id;
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
    <script type="text/javascript">
function printDiv(divId)
{
  $('.printHide').hide();
  $('.printShow').show();
   var html='<html>'+
   '<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"></head>';
   html+= document.getElementById(divId).innerHTML;

   html+="</html>";

   var printWin = window.open();
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
    setTimeout(function(){printWin.close();},100);
  $('.printHide').show();
  $('.printShow').hide();

}
</script>
</body>
</html>
