<?php
require("library_management.php");
$library = new library_management_classes();
if(isset($_REQUEST['delete_id']))
{
	$library->delete_book_stock($_REQUEST['delete_id']);
}

// $class_details = json_decode($receiption->get_class_details());
// $section_details = json_decode($receiption->get_section_details());

$book_details = json_decode($library->get_book_stock_details());
?>

<div class="table-agile-info">
	<div class="panel panel-default">
		<div class="panel-heading">
			Library Book Detials
		</div>
		<div class="table-responsive" style='padding:10px;'>
			<table id='bookDetails' class="table table-striped b-t b-light">
				<thead>
					<tr>
						<th>Book ID</th>
						<th>Class Name</th>
						<th>Name</th>
						<th>Publication</th>
						<th>Author</th>
						<th>Location</th>
						<th style='width:80px;'>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					foreach ($book_details as $key) 
					{
						echo "
						<tr>
						<td>".$key->bookStockId."</td>
						<td>".$key->className."</td>
						<td>".$key->bookName."</td>
						<td>".$key->bookPublication."</td>
						<td>".$key->bookWritter."</td>
						
						<td>".$key->storageLocation."</td>
						<td>
						<button style='padding:0px 5px;' onclick='edit_book_details(".$key->bookStockId.")' type='button' class='btn btn-primary' title='Edit'><i class='fa fa-edit'></i></button>
						<button style='padding:0px 5px;' onclick='delete_book_details(".$key->bookStockId.")' class='btn btn-danger' title='Delete'><i class='fa fa-remove'></i></button></td>
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
	$('#bookDetails').DataTable();
} );
</script>
