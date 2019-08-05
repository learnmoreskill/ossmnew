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
						<p class="no-margin" style="position: absolute;left: 130px;top: 5px"><?php echo $advance_bill_details->bill_number; ?></p>
						<p class="no-margin" style="position: absolute;left: 130px;top: 28px;"><?php echo $advance_bill_details->date; ?></p>
						
					</div>
				</div>
				<h3 style="margin: 0;text-align: center;">Cash Receipt</h3>

				<div class="cashDetailContainer">
					<div class="payerDetail">
						<p>Receipt with thanks from______________________________________________________ Sum of______________________</p>
						<p>Rupees____________________________________________________________________________________________________________________________________</p>
						<p>For___________________________________________ Roll___________ Class____________ Section:___________________</p>
						
						<p class="no-margin" style="position: absolute;left: 180px;top: 13px;    white-space: normal;max-width: 420px;line-height: .8;"><?php echo $advance_bill_details->payment_by; ?> </p>
						<p class="no-margin" style="position: absolute;left: 660px;top:15px;"><?php echo $advance_bill_details->credit; ?></p>
						<p class="no-margin" style="position: absolute;left: 60px;top: 40px"><?php numberTowords($advance_bill_details->credit) ?></p>
						<p class="no-margin" style="position: absolute;left: 40px;top:65px;"><?php echo $student_details->sname; ?></p>
						<p class="no-margin" style="position: absolute;left: 410px;top: 65px"><?php echo $student_details->sroll; ?></p>
						<p class="no-margin" style="position: absolute;left: 530px;top:65px;"><?php echo $student_details->class_name; ?></p>
						<p class="no-margin" style="position: absolute;left: 690px;top: 65px"><?php echo $student_details->section_name; ?></p>
						
					</div>
					<div class="cashDetail">
						<div class="cAmount">
							<p>Current balance:___________________</p>
							<p>Payment amount:___________________</p>
							<p>Balance due:___________________</p>

							<p class="no-margin" style="position: absolute;left: 110px;top: 15px"><?php echo $total_payable; ?></p>
							<p class="no-margin" style="position: absolute;left: 130px;top:40px;"><?php echo $advance_bill_details->credit; ?></p>
							<p class="no-margin" style="position: absolute;left: 90px;top: 65px"><?php echo ((float)$total_payable-(float)$advance_bill_details->credit); ?></p>
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
	 ?>
<?php 
function numberTowords($num)
{ 
	$number = $num;
   $no = round($number);
   $point = round($number - $no, 2) * 100;
   $hundred = null;
   $digits_1 = strlen($no);
   $i = 0;
   $str = array();
   $words = array('0' => '', '1' => 'one', '2' => 'two',
    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
    '7' => 'seven', '8' => 'eight', '9' => 'nine',
    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
    '13' => 'thirteen', '14' => 'fourteen',
    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
    '60' => 'sixty', '70' => 'seventy',
    '80' => 'eighty', '90' => 'ninety');
   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
   while ($i < $digits_1) {
     $divider = ($i == 2) ? 10 : 100;
     $number = floor($no % $divider);
     $no = floor($no / $divider);
     $i += ($divider == 10) ? 1 : 2;
     if ($number) {
        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
        $str [] = ($number < 21) ? $words[$number] .
            " " . $digits[$counter] . $plural . " " . $hundred
            :
            $words[floor($number / 10) * 10]
            . " " . $words[$number % 10] . " "
            . $digits[$counter] . $plural . " " . $hundred;
     } else $str[] = null;
  }
  $str = array_reverse($str);
  $result = implode('', $str);
  $points = ($point && $point>0) ?
    "." . $words[$point / 10] . " " . 
          $words[$point = $point % 10]. " paise" : '';
   $res=$result . "rupees  " . $points ;
   	echo ucfirst($res);
}
?>
</body>
</html>