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
<aside>
    <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                <p class="centered"><a href="../index.php"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" class="img-circle" width="60"></a></p>
                  <h5 class="centered">
                  <!-- Marcel Newman -->
                </h5>
              <?php if(isset($_SESSION['login_user_admin'])){ ?>
                <li><a  href="../../admin/welcome.php" >Admin Home</a></li>
                <?php } ?>
                <li>
                    <a href="../index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sub-menu ">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Expenses</span>
                    </a>
                    <ul class="sub ">
                        <li ><a href="../expenses/expenses-category.php">Category</a></li>
                        <li><a href="../expenses/expenses-details.php">Expenses</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;">
                        <i class="fa fa-book"></i>
                        <span>Extra-Income</span>
                    </a>
                    <ul class="sub">
                        <li ><a href="../extraIncome/income_details.php">Income</a></li>
                        
                    </ul>
                </li>
                
                <li class="sub-menu " >
                    <a href="javascript:;" >
                        <i class="fa fa-th"></i>
                        <span>Student</span>
                    </a>
                    <ul class="sub dcjq-parent-li">
                        <li><a href="../student/fee-type.php">Fee Type</a></li>
                        <li class="active"><a href="../student/extra-fee-collection.php">Extra Fee</a></li>
                        <li><a href="../student/student-record.php">Fee Collection</a></li>
                    </ul>
                </li>
                <li class="sub-menu ">
                    <a href="javascript:;">
                        <i class="fa fa-tasks"></i>
                        <span>Teacher</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="../teacher/payment.php">Payment</a></li>
                    </ul>
                </li>
                <?php if(isset($_SESSION['login_user_admin'])){  }
                elseif (isset($_SESSION['login_user_accountant'])) { ?>
                <li><a  href="../logout.php">Logout</a></li>
                 <?php } else{} ?>
              
               </ul>
           </div>
     
</aside>


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
