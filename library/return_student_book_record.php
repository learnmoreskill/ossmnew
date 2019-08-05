<?php
require("library_management.php");
$library = new library_management_classes();
$student_book_record = json_decode($library->return_student_book_details());

?>

<div class="table-agile-info">
	<div class="panel panel-default">
		<div class="panel-heading" >
			Return Book Record
		</div>
		<div class="table-responsive" style='padding: 10px;'>
			<table id="returnBook" class="table table-striped b-t b-light">
				<thead>
					<tr>
						<th>Student ID</th>
						<th>BooK ID</th>
						<th>Return Date</th>
						
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($student_book_record as $key) 
					{
						echo "
						<tr>
						<td>".$key->studentId."</td>
						<td>".$key->bookStockId."</td>
						<td>".$key->return_date."</td>
						
						
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
	$('#returnBook').DataTable();
} );
</script>
