<?php
include('../session.php');
include('../load_backstage.php'); 

if (isset($_GET['advance_pay_receipt'])) {
	
	$student_id=$_GET['advance_pay_receipt'];

    $bill_id = $_GET['bill_id'];

    if ($_GET['no_count']!='no_count') {
    	$updateCount = $account->update_bill_tables_increment_print_count_by_bill_id($bill_id);
    }
    

    $student_details = json_decode($account->get_student_details_by_sid($student_id));

	$advance_bill_details = json_decode($account->get_advance_bill_details_by_bill_id($bill_id));

	$payable_before = (float)$advance_bill_details->due_before-(float)$advance_bill_details->advance_before;

	?>


	<!DOCTYPE html>
	<html>
		<head>
			<title>Cash receipt</title>
			<style type="text/css">
				.cashReceiptContainer{
					width: 21cm;
					position: relative;
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
			
				.watermark{
				    position: absolute;
				    z-index: -1;
				    background: white;
				    display: block;
				    min-height: 40%;
				    min-width: 50%;
				    text-align: center;
				    margin: 0 20%;
				}

				.bg-text
				{
				    color:lightgrey;
				    font-size:60px;
				    transform:rotate(325deg);
				    -webkit-transform:rotate(325deg);
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
								<p class="no-margin" style="position: absolute;left: 130px;top: 5px"><?php echo $advance_bill_details->bill_number; ?></p>
								<p class="no-margin" style="position: absolute;left: 130px;top: 28px;"><?php echo $advance_bill_details->date; ?></p>
								
							</div>
						</div>
						<div style="text-align: center;">
							<span style="text-decoration: underline;">Student Copy</span>
							
						</div>
						<h3 style="margin: 0;text-align: center;">Cash Receipt</h3>


						<?php if($advance_bill_details->print_count>1){ ?>
				            <div class="watermark">
				                <p class="bg-text">Duplicte</p>
				            </div>
				        <?php } ?>
						<div class="cashDetailContainer">
							<div class="payerDetail">
								<p>Receipt with thanks from______________________________________________________ Sum of______________________</p>
								<p>Rupees____________________________________________________________________________________________________________________________________</p>
								<p>For___________________________________________ Roll___________ Class____________ Section:___________________</p>
								
								<p class="no-margin" style="position: absolute;left: 180px;top: 13px;    white-space: normal;max-width: 420px;line-height: .8;"><?php echo $advance_bill_details->payment_by; ?> </p>
								<p class="no-margin" style="position: absolute;left: 660px;top:15px;"><?php echo $advance_bill_details->credit; ?></p>
								<p class="no-margin" style="position: absolute;left: 60px;top: 40px"><?php echo $account->get_number_in_word($advance_bill_details->credit); ?></p>
								<p class="no-margin" style="position: absolute;left: 40px;top:65px;"><?php echo $student_details->sname; ?></p>
								<p class="no-margin" style="position: absolute;left: 410px;top: 65px"><?php echo ((!empty($advance_bill_details->student_roll_no))? $advance_bill_details->student_roll_no : $student_details->sroll); ?></p>
								<p class="no-margin" style="position: absolute;left: 530px;top:65px;"><?php echo ((!empty($advance_bill_details->class_name))? $advance_bill_details->class_name : $student_details->class_name); ?></p>
								<p class="no-margin" style="position: absolute;left: 690px;top: 65px"><?php echo ((!empty($advance_bill_details->section_name))? $advance_bill_details->section_name : $student_details->section_name); ?></p>
								
							</div>
							<div class="cashDetail">
								<div class="cAmount">
									<p>Total payable:___________________</p>
									<p>Paid amount:___________________</p>
									<p>Balance due:___________________</p>

									<p class="no-margin" style="position: absolute;left: 110px;top: 15px"><?php echo $payable_before; ?></p>
									<p class="no-margin" style="position: absolute;left: 130px;top:40px;"><?php echo $advance_bill_details->credit; ?></p>
									<p class="no-margin" style="position: absolute;left: 90px;top: 65px"><?php echo ((float)$payable_before-(float)$advance_bill_details->credit); ?></p>
								</div>
								<?php $mode=$advance_bill_details->payment_mode; ?>
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
									<p class="no-margin" style="position: absolute;left: 90px;top: 60px"><?php echo (($advance_bill_details->t_role == 1)? $advance_bill_details->pname : (($advance_bill_details->t_role == 5)? $advance_bill_details->staff_name : '' ) ); ?></p>

								</div>
							</div>
						</div>

					</div>
			<?php 
				// }
			if($advance_bill_details->print_count<=1 && $_GET['no_count']!='no_count'){ ?>

				<br><br>

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
								<p class="no-margin" style="position: absolute;left: 130px;top: 5px"><?php echo $advance_bill_details->bill_number; ?></p>
								<p class="no-margin" style="position: absolute;left: 130px;top: 28px;"><?php echo $advance_bill_details->date; ?></p>
								
							</div>
						</div>
						<div style="text-align: center;">
							<span style="text-decoration: underline;">School Copy</span>
							
						</div>
						<h3 style="margin: 0;text-align: center;">Cash Receipt</h3>


						<?php if($advance_bill_details->print_count>1){ ?>
				            <div class="watermark">
				                <p class="bg-text">Duplicte</p>
				            </div>
				        <?php } ?>
						<div class="cashDetailContainer">
							<div class="payerDetail">
								<p>Receipt with thanks from______________________________________________________ Sum of______________________</p>
								<p>Rupees____________________________________________________________________________________________________________________________________</p>
								<p>For___________________________________________ Roll___________ Class____________ Section:___________________</p>
								
								<p class="no-margin" style="position: absolute;left: 180px;top: 13px;    white-space: normal;max-width: 420px;line-height: .8;"><?php echo $advance_bill_details->payment_by; ?> </p>
								<p class="no-margin" style="position: absolute;left: 660px;top:15px;"><?php echo $advance_bill_details->credit; ?></p>
								<p class="no-margin" style="position: absolute;left: 60px;top: 40px"><?php echo $account->get_number_in_word($advance_bill_details->credit); ?></p>
								<p class="no-margin" style="position: absolute;left: 40px;top:65px;"><?php echo $student_details->sname; ?></p>
								<p class="no-margin" style="position: absolute;left: 410px;top: 65px"><?php echo ((!empty($advance_bill_details->student_roll_no))? $advance_bill_details->student_roll_no : $student_details->sroll); ?></p>
								<p class="no-margin" style="position: absolute;left: 530px;top:65px;"><?php echo ((!empty($advance_bill_details->class_name))? $advance_bill_details->class_name : $student_details->class_name); ?></p>
								<p class="no-margin" style="position: absolute;left: 690px;top: 65px"><?php echo ((!empty($advance_bill_details->section_name))? $advance_bill_details->section_name : $student_details->section_name); ?></p>
								
							</div>
							<div class="cashDetail">
								<div class="cAmount">
									<p>Total payable:___________________</p>
									<p>Paid amount:___________________</p>
									<p>Balance due:___________________</p>

									<p class="no-margin" style="position: absolute;left: 110px;top: 15px"><?php echo $payable_before; ?></p>
									<p class="no-margin" style="position: absolute;left: 130px;top:40px;"><?php echo $advance_bill_details->credit; ?></p>
									<p class="no-margin" style="position: absolute;left: 90px;top: 65px"><?php echo ((float)$payable_before-(float)$advance_bill_details->credit); ?></p>
								</div>
								<?php $mode=$advance_bill_details->payment_mode; ?>
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
									<p class="no-margin" style="position: absolute;left: 90px;top: 60px"><?php echo (($advance_bill_details->t_role == 1)? $advance_bill_details->pname : (($advance_bill_details->t_role == 5)? $advance_bill_details->staff_name : '' ) ); ?></p>

								</div>
							</div>
						</div>

					</div>




				<?php 
			} ?>
			
			 
		</body>
	</html>

	<?php 
}else{
	echo "Invalid request for print receipt";
} ?>