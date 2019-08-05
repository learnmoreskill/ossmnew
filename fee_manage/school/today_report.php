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
            <option value="classwise">Class Wise</option>
        </select>  -->



      </div>

      <br><br>
      <div id="daybookcontent">
        Loading...        
      </div>
      
  </div>
  
  
</section>
<?php require('../config/commonFooter.php'); ?>
<script type="text/javascript" src="../assets/js/nepali.datepicker.v2.2.min.js"></script>


<script type="text/javascript">
  $('#daybookcontent').load('../school/getdaybookreport.php?request_for_daybook_by_date=<?php echo $todayNepaliDate; ?>&incomeReportType=classwise');


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
    $('#daybookcontent').load('../school/getdaybookreport.php?request_for_daybook_by_date='+selectedDate+'&incomeReportType=classwise');
  }
  function incomeReportTypeChange(){
    var selectedDate = document.getElementById('nepaliDateDayBook').value;
    var incomeReportType = document.getElementById('incomeReportType').value;
    $('#daybookcontent').load('../school/getdaybookreport.php?request_for_daybook_by_date='+selectedDate+'&incomeReportType='+incomeReportType);
  }
</script>
</body>
</html>
