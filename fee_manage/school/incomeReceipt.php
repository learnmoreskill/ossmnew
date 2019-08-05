<?php
include('../session.php');
include('../load_backstage.php');

if (isset($_GET['type']) && $_GET['type']=='income') {
	
	// $student_id=$_GET['advance_pay_receipt'];

    $bill_id = $_GET['bill_id'];

    $updateCount = $account->update_bill_tables_increment_print_count_by_bill_id($bill_id);

    // $student_details = json_decode($account->get_student_details_by_sid($student_id));

	// $advance_bill_details = json_decode($account->get_advance_bill_details_by_bill_id($bill_id));

	// $payable_before = (float)$advance_bill_details->due_before-(float)$advance_bill_details->advance_before;

?>


<!DOCTYPE html>
<html>
<head>
	<title>Cash receipt</title>
	<style type="text/css">
		.cashReceiptContainer{
			width: 21cm;
			/*height: 200px;*/
			/*background-color: red;*/
			/*margin:  5px;*/
			border: 2px solid red;
			padding: 5px;
		}
		.cashHead{
			display: inline-flex;
			width: calc(100% - 10px);
			padding: 5px;

		}
		.cashHead>.logo{
			width: 70%;
			display: inline-flex;

		}
		.logoImg{
			max-height: 60px;
			padding: 5px;
			/*min-height: 80px;*/
		}
		.logoImg>img{
			max-height: inherit;
			/*padding: 10px;*/
			/*min-height: 80px;*/
		}
		.cashHead>.date{
			width: 30%;
			text-align: right;
			position: relative;
		}
		.cashDetailContainer{
			line-height: .5;
		}
		.cashDetail{
			display: inline-flex;
			width: 100%;
		}
		.payerDetail{
		    position: relative;
		    white-space: nowrap;
		    overflow: hidden;
		}
		.cAmount{
			width: 60%;
			position: relative;

		}
		.cMode{
			width: 40%;
			position: relative;
		}
		.checkImg{
			width: 10px;
			height: 10px;
		}
		.cmargin{
			margin: 5px;
		}
		.cPadding{
			padding: 5px;
		}
		.no-margin{
			margin: 0;
		}
	</style>
</head>
<body style="margin: 0">

	
	<?php 
	 //for ($x = 0; $x <= 3; $x++) {
	?>
		  	<div class="cashReceiptContainer">
				<div class="cashHead">

					<div class="logo">
						<div class="logoImg">
							<img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
						</div>
						<div class="sDetail">
							<h3 class="no-margin"><?php echo $school_details->school_name; ?></h3>
							<p class="cmargin"><?php echo $school_details->school_address; ?></p>
							<p class="cmargin"><?php echo $school_details->phone_no; ?></p>
						</div>
					</div>
					<div class="date">
						<p class="cmargin">Refrence no:______________</p>
						<p class="cmargin">Date:______________</p>
						<p class="no-margin" style="position: absolute;left: 130px;top: 5px">022000</p>
						<p class="no-margin" style="position: absolute;left: 130px;top: 28px;">2010-140-10</p>
						
					</div>
				</div>
				<h3 style="margin: 0;text-align: center;">Income Receipt</h3>

				<div class="cashDetailContainer">
					<div class="payerDetail">
						<p>Receipt with thanks from______________________________________________________ Sum of______________________</p>
						<p>Rupees____________________________________________________________________________________________________________________________________</p>
						<p>As___________________________________________ for our institution.</p>
						
						<p class="no-margin" style="position: absolute;left: 180px;top: 13px;    white-space: normal;max-width: 420px;line-height: .8;">guddu kumar patel </p>
						<p class="no-margin" style="position: absolute;left: 660px;top:15px;">50000</p>
						<p class="no-margin" style="position: absolute;left: 60px;top: 40px"><?php echo $account->get_number_in_word(50000); ?></p>
						<p class="no-margin" style="position: absolute;left: 40px;top:65px;">kamawali bai</p>
						<!-- <p class="no-margin" style="position: absolute;left: 410px;top: 65px"><?php echo $student_details->sroll; ?></p>
						<p class="no-margin" style="position: absolute;left: 530px;top:65px;"><?php echo $student_details->class_name; ?></p>
						<p class="no-margin" style="position: absolute;left: 690px;top: 65px"><?php echo $student_details->section_name; ?></p> -->
						
					</div>
					<div class="cashDetail">
						<div class="cAmount">
							Thank you for your contribution.
							<!-- <p>Total payable:___________________</p> -->
							<!-- <p>Received amount:___________________</p> -->
							<!-- <p>Balance due:___________________</p> -->

							<!-- <p class="no-margin" style="position: absolute;left: 110px;top: 15px"><?php echo $payable_before; ?></p> -->
							<!-- <p class="no-margin" style="position: absolute;left: 130px;top:40px;"><?php echo $advance_bill_details->credit; ?></p>
							<p class="no-margin" style="position: absolute;left: 90px;top: 65px"><?php echo ((float)$payable_before-(float)$advance_bill_details->credit); ?></p> -->
						</div>
						<?php $mode='cash' ?>
						<div class="cMode">
							<table border="1" style=" border-collapse: collapse;">
								<tr>
									<th class="cPadding checkImg">
									<?php if ($mode=='cash') { ?>
										<img class="checkImg" src="https://static.thenounproject.com/png/190431-200.png">
									<?php } ?> 
									</th>
									<th class="cPadding">Cash</th>
								
									<th class="cPadding checkImg">
										<?php if ($mode=='cheque') { ?>
										<img class="checkImg" src="https://static.thenounproject.com/png/190431-200.png">
									<?php } ?> 

									</th>
									<th class="cPadding">Cheque</th>
								
									<th class="cPadding checkImg">
										<?php if ($mode=='bank') { ?>
										<img class="checkImg" src="https://static.thenounproject.com/png/190431-200.png">
									<?php } ?> 
									</th>
									<th class="cPadding">Bank</th>
								</tr>
							
							</table>
							<br>
							<br>
							<br>
							<p>Received by:________________________</p>
							<p class="no-margin" style="position: absolute;left: 90px;top: 60px">
							guddu patel<!-- <?php echo (($advance_bill_details->t_role == 1)? $advance_bill_details->pname : (($advance_bill_details->t_role == 5)? $advance_bill_details->staff_name : '' ) ); ?>
								 -->
							</p>

						</div>
					</div>
				</div>

			</div>
	<?php 
		// }
	 ?>

</body>
</html>

<?php 
}else{
	echo "Invalid request for print receipt";
} ?>