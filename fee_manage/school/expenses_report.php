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
<?php include('../config/navbar.php'); ?>


<section id="main-content">
    <section class="wrapper panel panel-default" style="width:95%;margin:100px 25px 0px;">
    
	<div class="col-md-12">
		<form class="form-inline" name='single_date_form' style="margin-bottom:10px;margin-top: 10px;">
                                     <?php
                                          echo "<div class='form-group'>
                                            <label >Date</label>
                                            <input type='text' name='single_date' class='form-control'  placeholder='Example; 2018' style='color:black;' onkeydown='if(event.keyCode==13){ teacher_statement_by_id(); }'>
                                          </div>
                                     
                                          <input onclick='teacher_statement_by_id()' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
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
                                  echo "<input onclick='teacher_statement_by_id_two_date()' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
                                  ?>
        </form>
	</div>

	 			<div class="panel panel-default" style="margin-top: 120px">
                    <div class="panel-heading" >
                      School Balance Sheet
                    </div>
                    <div class="col-md-6 table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable'   class="table table-striped b-t b-light display">
                            <thead>
                                <tr>
                                  <th scope="col">Income Type</th>
                                  <th scope="col">Amount</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	echo "<tr>
	                            		<td>Student</td>
	                            		<td>".$student_income."</td>
	                            		</tr>";	
	                           foreach ($incomeType_list as $key1) 
	                           {
	                           		$amount = 0;
		                           	foreach ($school_income_details as $key) 
	                            	{
	                            		if($key1->incomeType==$key->incomeFrom)
	                            		{
	                            		$amount = $amount + $key->schoolIncome;
	                            		$total_income = $total_income+$amount;
	                            		}
	                            		
	                            	}
	                            	echo "<tr>
		                            		<td>".$key1->incomeType."</td>
		                            		<td>".$amount."</td>
		                            	</tr>";	

	                           }
                            	

                            	?>
                            </tbody>
               			</table>
               		</div>

               		<div class="col-md-6 table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable'   class="table table-striped b-t b-light display">
                            <thead>
                                <tr>
                                  <th scope="col">Expenses Type</th>
                                  <th scope="col">Amount</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	echo "<tr>
                            		<td>Teacher</td>
                            		<td>".$teacher_expenses."</td>
                            		</tr>";
                            		
                            	foreach ($expenses_category_list as $key) 
                            	{
                            		$amount = 0;
	                            	foreach ($school_expenses_details as $key1) 
	                            	{

	                            		if($key1->expensesTo==$key->exp_cat)
	                            		{
	                            		$amount = $amount + $key1->schoolExpenses;
	                            		$total_expenses = $total_expenses+$amount;
	                            		}
	                            		
	                            	}
	                            	echo "<tr>
	                            		<td>".$key->exp_cat."</td>
	                            		<td>".$amount."</td>
	                            		</tr>";
	                            }	


                            	?>
                            </tbody>
               			</table>
               		</div>
               			<div class="col-md-6 table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable'   class="table table-striped b-t b-light display">
                        	<?php 
                        	echo "<tr style='background:#807d7d;'>
                        	<td style='color:white'>Grand Total:</td>
                        	<td style='color:white'>".$total_income."</td>
                        	</tr>";
                        	 ?>
                        </table>
                    </div>
                    <div class="col-md-6 table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable'   class="table table-striped b-t b-light display">
                        	<?php 
                        	echo "<tr style='background:#807d7d;'>
                        	<td style='color:white'>Grand Total</td>
                        	<td style='color:white'>".$total_expenses."</td>
                        	</tr>";
                        	 ?>
                        </table>
                    </div>
                    
               		</div>
               	</div>

        
    </section>
</section>
<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>
    
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
