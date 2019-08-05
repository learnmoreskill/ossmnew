<!DOCTYPE html>
<html lang="en"> 
<?php
include('../session.php');
include('../load_backstage.php');
require('../head.php');
require('../header.php');
?>

<body>
<?php include('../config/navbar.php'); ?> 

    <section id="main-content">
        <section class="wrapper">
             <div class="col-md-4" id='insert_income_details'>
            </div>

            <div class="col-md-8" id='income_list'>
                
            </div>
           
        </section>
    </section>

</section>

<?php require('../config/commonFooter.php'); ?>   

<script type="text/javascript">
    $('#income_list').load('../extraIncome/extra_income_list.php');
    $('#insert_income_details').load('../extraIncome/extra_income_insert.php');
</script>

<script type="text/javascript">
	function delete_extra_income(income_id)
	{
		if(confirm('Do you want to delete !!'))
		{
			 $('#income_list').load('../extraIncome/extra_income_list.php?income_delete_id='+income_id);
		}
	}
	function edit_extra_income(id)
	{
		$('#insert_income_details').load('../extraIncome/extra_income_insert.php?edit_id='+id);
	}

    function printExternal(url){ 
        var printWindow = window.open(url, 'Print', '');
          printWindow.addEventListener('load', function(){
              printWindow.print();
              printWindow.close();
              
              location.reload();

          }, true);
    }
</script>
</body>
</html>
