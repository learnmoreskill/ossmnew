<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<?php
include('../session.php');
$school_expenses_details = json_decode($account->get_school_expenses_record());
$school_income_details = json_decode($account->get_school_income_record());
$student_income = $account->get_school_income_record_from_student();
$incomeType_list = json_decode($account->get_incomeType_list());
$teacher_expenses = $account->get_school_expenses_to_teacher();
$expenses_category_list = json_decode($account->get_expenses_category_list());
$total_expenses = $teacher_expenses;
$total_income = $student_income;
?>
<body>
<?php include('../config/sidebar.php'); ?>


<section id="main-content">
    <section class="wrapper panel panel-default" style="width:95%;margin:100px 25px 0px;">
    
	<div class="col-md-12">
		<form class="form-inline" name='single_date_form' style="margin-bottom:10px;margin-top: 10px;">
                                     <?php
                                          echo "<div class='form-group'>
                                            <label >Date</label>
                                            <input type='text' name='single_date' class='form-control'  placeholder='Example; 2018' style='color:black;' onkeydown='if(event.keyCode==13){ total_balance_statement(); }'>
                                          </div>
                                     
                                          <input onclick='total_balance_statement()' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
                                      ?>
        </form>
        <form class="form-inline" name='two_date_form'>
            <div class="form-group">
                                        <label >From</label>
                                        <input type="date" class="form-control"  placeholder="Exmple: 2018-01-01" style="color:black;" name='first_date'>
                                      </div>
                                      <div class="form-group">
                                        <label >To</label>
                                        <input type="date" class="form-control"  placeholder="Example; 2018-05-01" style="color:black;" name='second_date'>
                                      </div>
                                      <?php
                                  echo "<input onclick='total_balance_sheet_two_date()' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
                                  ?>
        </form>
	</div>

	 			<div id='total_balance_record' class="panel panel-default" style="margin-top: 120px">
                    
                    
        </div>

        
    </section>
</section>
<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
    <script src="../assets/js/sparkline-chart.js"></script>    
    <script src="../assets/js/zabuto_calendar.js"></script>    
</body>
</html>


<script type="text/javascript">
  $('#total_balance_record').load('../school/load_balance_record.php');
</script>
<script type="text/javascript">
  function total_balance_statement()
  {
      var date = single_date_form.single_date.value;
      $('#total_balance_record').load('../school/load_balance_record.php?date='+date);
  }

  function total_balance_sheet_two_date()
  {
    var first_date = two_date_form.first_date.value;
    var second_date = two_date_form.second_date.value;
    $('#total_balance_record').load('../school/load_balance_record.php?first_date='+first_date+'&second_date='+second_date);
  }

  
</script>