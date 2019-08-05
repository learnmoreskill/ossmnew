<?php
require("library_management.php");
$library = new library_management_classes();
if(isset($_REQUEST['bookId']))
{
	$status = "true";
	$status1="false";
	$bookStockId = $_REQUEST['bookId'];
	$studentId = $_REQUEST['studentId'];
	
	$library->update_status_book_stock_tables($status,$bookStockId);
	$library->update_status_student_library_account_tables($status1,$bookStockId,$studentId);
	//echo "hello working";
}
$student_book_record = json_decode($library->issue_student_book_details());
date_default_timezone_set('Asia/kathmandu');
$current_date = date('Y-m-d'); 


?>

<div class="table-agile-info">
	<div class="panel panel-default">
		<div class="panel-heading">
			Issue Book Record
		</div>
		<div class="table-responsive" style="padding: 10px;">
			<table id='issueBook' class="table table-striped b-t b-light">
				<thead>
					<tr>
						<th>Student ID</th>
						<th>BooK ID</th>
						<th>Issue Date</th>
						<th>Day</th>
						<th>Action</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($student_book_record as $key) 
					{
						$date = $key->date;
						$second = abs(strtotime($date) - strtotime($current_date));
						$day = floor($second / (60*60*24));
						// $years = floor($diff / (365*60*60*24));
						// $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
						// $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

						// printf("%d years, %d months, %d days\n", $years, $months, $days);
						echo "
						<tr>
						<td>".$key->studentId."</td>
						<td>".$key->bookStockId."</td>
						<td>".$key->date."</td>
						<td>".$day."</td>
						<td>
						<button style='padding:0px 5px;' onclick='return_book_click(".$key->bookStockId.",".$key->studentId.")' type='button' class='btn btn-primary' title='Return'>Return</button>
						
						</td>
						
						
					</tr>
						";
					}
					?>
					
				</tbody>
			</table>
		</div>
	</div>	
</div>			

<script type="text/javascript">
	$(document).ready(function() {
	$('#issueBook').DataTable();
} );
</script>
