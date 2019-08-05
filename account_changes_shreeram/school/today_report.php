<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<?php
include('../session.php');


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
    
	 			<div class="panel panel-default" style="margin-top: 10px">
                    
                    <div class="col-md-6 table-responsive" style='padding: 10px;'>
                    	<div class="panel-heading"  style="background: #afaeae;">
                      Income Record
                    </div>
                        <table id='studentDetailsTable'   class="table table-striped b-t b-light display" style="background: #f2f2f2;">
                            <thead>
                                <tr>
                                  <th scope="col">Student Name</th>
                                  <th scope="col">Fee Head</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Date</th>
                                 
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	$store_id =0;
                               $incomeTables_record = json_decode($account->getExtraIncome_by_current_date());
                               $current_student_bill_record = json_decode($account->get_stdent_bill_record_by_current_date());
                               $today_total_income = 0;
	                           foreach ($current_student_bill_record as $key) 
	                           {
	                           	$paid = $key->paid;
	                           		echo "<tr>
	                           		<td>"; if($store_id != $key->std_id){ echo $account->get_student_name_by_student_id($key->std_id); } 
	                           		echo "</td>
	                           		<td>".$account->get_feetype_by_feetype_id($key->feetype_id)."</td>
	                           		<td>".$key->paid."</td>
	                           		<td>".$key->last_payment_date."</td>
	                           		</tr>";
	                           		$store_id = $key->std_id;
	                           		$today_total_income = $today_total_income+$paid;
	                           }

	                           foreach($incomeTables_record as $key) 
	                           {
	                           	$amount = $key->incomeAmount;
	                           		echo "<tr>
	                           		<td>Extra Income </td>
	                           		<td>".$key->incomeType."</td>
	                           		<td>".$key->incomeAmount."</td>
	                           		<td>".$key->date."</td>
	                           		</tr>";
	                           		$today_total_income = $today_total_income+$amount;
	                           }

	                           echo "<tr>
	                           
	                           <td></td>
	                           <td><span style='color:black;'> Net Total: </span></td>
	                           <td><span style='color:black;'> ".$today_total_income."</span></td>
	                           <td></td>
	                           </tr>
	                           ";

                            	

                            	?>
                            </tbody>
               			</table>
               		</div>

               		<div class="col-md-6 table-responsive" style='padding: 10px;'>
               			<div class="panel-heading" style="background: #afaeae;" >
                      Expenses Record
                    </div>
                        <table id='studentDetailsTable'   class="table table-striped b-t b-light display" style="background: #f2f2f2;">
                            <thead>
                                <tr>
                                  <th scope="col">Teacher Name</th>
                                  <th scope="col">Payment Head</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Date</th>
                                  
                                </tr>
                            </thead>
                            <tbody>
                            	<?php
                            	
                            	$teacher_payment_record = json_decode($account->get_teacher_payment_record_by_current_date());
                            	$expenses_details = json_decode($account->getExpenses_by_current_date());
                            	$today_total_expenses = 0;
                            	foreach ($teacher_payment_record as $key) 
                            	{
                            		if($key->advance==0)
                            		{
                            			$name = 'Salary';
                            			$amount = $key->net_pay;
                            		}
                            		else
                            		{
                            			$name = 'Advance';
                            			$amount = $key->advance;
                            		}
                            		$today_total_expenses = $today_total_expenses + $amount;
                            		echo"<tr>
                            		<td>".$account->get_teacher_name_by_teacherId($key->teacher_id)."</td>
                            		<td>".$name."</td>
                            		<td>".$amount."</td>
                            		<td>".$key->paid_date."</td>
                            		</tr>";
	                            }

	                            foreach ($expenses_details as $key) 
                            	{
                            		$ecat_amount = $key->expamount;
                            		$today_total_expenses = $today_total_expenses + $ecat_amount;
                            		echo"<tr>
                            		<td>".$key->ecat."</td>
                            		<td>".$key->name."</td>
                            		<td>".$key->expamount."</td>
                            		<td>".$key->date."</td>
                            		</tr>";
	                            }

	                            echo"<tr>
                            		<td></td>
                            		<td><span style='color:black'> Net Total:</span></td>
                            		<td><span style='color:black'>".$today_total_expenses."</span></td>
                            		<td></td>
                            		</tr>";


                            	?>
                            </tbody>
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
