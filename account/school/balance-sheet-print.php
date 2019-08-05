<?php
require("../account_management.php");
$account = new account_management_classes();

if(isset($_REQUEST['date']))
{
   $date = $_REQUEST['date'];

    $school_expenses_details = json_decode($account->get_school_expenses_record_by_single_date($date));
    $school_income_details = json_decode($account->get_school_income_record_by_date($date));
    $student_income = $account->get_school_income_record_from_student_by_date($date);
    $incomeType_list = json_decode($account->get_incomeType_list());
    $teacher_expenses = $account->get_school_expenses_to_teacher_by_date($date);
    $expenses_category_list = json_decode($account->get_expenses_category_list());
    $total_expenses = $teacher_expenses;
    $total_income = $student_income;
}
else if(isset($_REQUEST['first_date']))
{
    $first_date = $_REQUEST['first_date'];
    $second_date = $_REQUEST['second_date'];
    $school_expenses_details = json_decode($account->get_school_expenses_record_by_two_date($first_date,$second_date));
    $school_income_details = json_decode($account->get_school_income_record_by_two_date($first_date,$second_date));
    $student_income = $account->get_school_income_record_from_student_by_two_date($first_date,$second_date);
    $incomeType_list = json_decode($account->get_incomeType_list());
    $teacher_expenses = $account->get_school_expenses_to_teacher_by_two_date($first_date,$second_date);
    $expenses_category_list = json_decode($account->get_expenses_category_list());
    $total_expenses = $teacher_expenses;
    $total_income = $student_income;
}
else
{
    $school_expenses_details = json_decode($account->get_school_expenses_record());
    $school_income_details = json_decode($account->get_school_income_record());
    $student_income = $account->get_school_income_record_from_student();
    $incomeType_list = json_decode($account->get_incomeType_list());
    $teacher_expenses = $account->get_school_expenses_to_teacher();
    $expenses_category_list = json_decode($account->get_expenses_category_list());
    $total_expenses = $teacher_expenses;
    $total_income = $student_income;
}

?>

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