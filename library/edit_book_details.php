<?php
require("library_management.php");
$library = new library_management_classes();
if(isset($_REQUEST['edit_id']))
{
	$edit_id = $_REQUEST['edit_id'];
	$book_details = json_decode($library->get_book_details_by_id($_REQUEST['edit_id']));
	 
}

echo "<section class='panel'>
					    <header class='panel-heading' style='font-size:17px;'>
					      Insert Book Details
					    </header>
				<div class='panel-body'>
		
				<form id='form' name='submitBookRecordForm'>
					<div class='form-group'>
						<label>Class Name</label>
						<input class='form-control' type='text' name='update_className' value=".$book_details->className.">
					</div>
					<div class='form-group'>
						<label>Book Name</label>
						<input class='form-control' type='text' name='update_bookName' value=".$book_details->bookName.">
					</div>
					<div class='form-group'>
						<label>Book Publication</label>
							<input class='form-control' type='text' name='update_bookPublication' value=".$book_details->bookPublication.">
					</div>
					<div class='form-group'>
						<label>Book Writter</label>
						<input class='form-control' type='text' name='update_bookWritter' value=".$book_details->bookWritter.">
					</div>
					<div class='form-group'>
						<label>Storage Location</label>
						<input class='form-control' type='text' name='update_storageLocation' value=".$book_details->storageLocation.">
					</div>	
					<div class='form-group'>
						<input style='margin-bottom: 20px;width:100px;' readonly='true' class='btn btn-primary pull-right' type='submit'  value='Submit' />
					</div>
				</form>
			</div>";
?>

<script>
var id = <?php echo $edit_id; ?>  
$(document).ready(function (e) 
{
	$("#form").on('submit',(function(e) 
	{ 
		e.preventDefault();
		$.ajax
		({
			    url: "upload_book_details.php?bookStockId="+id,
			    type: "POST",
			    data:  new FormData(this),
			    contentType: false,
			    cache: false,
			    processData:false,
			    beforeSend : function()
			   	{
			    	$("#err").fadeOut();
			    },
			    success: function(data)
			    {
			    	alert(data);
			    	if(data=='Update The Record Sucessfully !!')
			    	{
			    		window.location.href = 'insert_book_details.php';
			    	}
			    	
			    },
			    error: function(e) 
			    {
			    	$("#err").html(e).fadeIn();
			    }          
		});
	}));
});

</script>
