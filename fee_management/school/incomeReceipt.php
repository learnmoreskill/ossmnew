<?php
include('../session.php'); 
include('../load_backstage.php'); 

if (isset($_GET['type']) && $_GET['type']=='income') {

    $bill_id = $_GET['bill_id'];

    if ($_GET['no_count']!='no_count') {

    	$updateCount = $account->update_bill_tables_increment_print_count_by_bill_id($bill_id);
    }

		$bill_details = json_decode($account->get_bill_details_of_income_by_bill_id($bill_id));

		$income_details = json_decode($account->get_income_details_of_by_bill_id($bill_id));

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
							<p class="no-margin" style="position: absolute;left: 130px;top: 5px"><?php echo $bill_details->bill_number; ?></p>
							<p class="no-margin" style="position: absolute;left: 130px;top: 28px;"><?php echo $bill_details->date; ?></p>
							
						</div>
					</div>
					<h3 style="margin: 0;text-align: center;">Cash Receipt</h3>

					<?php if($bill_details->print_count>1){ ?>
				            <div class="watermark">
				                <p class="bg-text">Duplicte</p>
				            </div>
				    <?php } ?>

					<div class="cashDetailContainer">
						<div class="payerDetail">
							<p>Receipt with thanks from______________________________________________________ Sum of______________________</p>
							<p>Rupees____________________________________________________________________________________________________________________________________</p>
							<p>As___________________________________________ for our institution.</p>
							
							<p class="no-margin" style="position: absolute;left: 180px;top: 13px;    white-space: normal;max-width: 420px;line-height: .8;"><?php echo $income_details->payment_by; ?></p>
							<p class="no-margin" style="position: absolute;left: 660px;top:15px;"><?php echo $income_details->income_amount; ?></p>
							<p class="no-margin" style="position: absolute;left: 60px;top: 40px"><?php echo $account->get_number_in_word($income_details->income_amount); ?></p>
							<p class="no-margin" style="position: absolute;left: 40px;top:65px;"><?php echo $income_details->income_type; ?></p>
							
						</div>
						<div class="cashDetail">
							<div class="cAmount">
								Thank you for your contribution.
							</div>
							<?php $mode=$income_details->payment_mode ?>
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
								<?php echo (($bill_details->t_role == 1)? $bill_details->pname : (($bill_details->t_role == 5)? $bill_details->staff_name : '' ) ); ?>
								</p>

							</div>
						</div>
					</div>

				</div>

		<?php if($bill_details->print_count<=1 && $_GET['no_count']!='no_count'){ ?>
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
							<p class="no-margin" style="position: absolute;left: 130px;top: 5px"><?php echo $bill_details->bill_number; ?></p>
							<p class="no-margin" style="position: absolute;left: 130px;top: 28px;"><?php echo $bill_details->date; ?></p>
							
						</div>
					</div>
					<h3 style="margin: 0;text-align: center;">Cash Receipt Copy</h3>

					<div class="cashDetailContainer">
						<div class="payerDetail">
							<p>Receipt with thanks from______________________________________________________ Sum of______________________</p>
							<p>Rupees____________________________________________________________________________________________________________________________________</p>
							<p>As___________________________________________ for our institution.</p>
							
							<p class="no-margin" style="position: absolute;left: 180px;top: 13px;    white-space: normal;max-width: 420px;line-height: .8;"><?php echo $income_details->payment_by; ?></p>
							<p class="no-margin" style="position: absolute;left: 660px;top:15px;"><?php echo $income_details->income_amount; ?></p>
							<p class="no-margin" style="position: absolute;left: 60px;top: 40px"><?php echo $account->get_number_in_word($income_details->income_amount); ?></p>
							<p class="no-margin" style="position: absolute;left: 40px;top:65px;"><?php echo $income_details->income_type; ?></p>
							
						</div>
						<div class="cashDetail">
							<div class="cAmount">
								Thank you for your contribution.
							</div>
							<?php $mode=$income_details->payment_mode ?>
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
								<?php echo (($bill_details->t_role == 1)? $bill_details->pname : (($bill_details->t_role == 5)? $bill_details->staff_name : '' ) ); ?>
								</p>

							</div>
						</div>
					</div>

				</div>
			<?php } ?>
		

	</body>
	</html>

	<?php 
}else{
	echo "Invalid request for print receipt";
} ?>