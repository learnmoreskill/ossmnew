<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<?php
include('../session.php');
$expenses_category_list = json_decode($account->get_expenses_category_list());
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

<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>
    
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
    <script src="../assets/js/sparkline-chart.js"></script>    
    <script src="../assets/js/zabuto_calendar.js"></script>    

<script type="text/javascript">
    $('#income_list').load('../extraIncome/extra_income_list.php');
    $('#insert_income_details').load('../extraIncome/extra_income_insert.php');
</script>

<script type="text/javascript">
	function delete_extra_income(id)
	{
		if(confirm('Do you want to delete !!'))
		{
			 $('#income_list').load('../extraIncome/extra_income_list.php?delete_id='+id);
		}
	}
	function edit_extra_income(id)
	{
		$('#insert_income_details').load('../extraIncome/extra_income_insert.php?edit_id='+id);
	}
</script>
</body>
</html>
