<?php
include('../session.php');
?>
<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<body>
<?php include('../config/sidebar.php'); ?>

    <section id="main-content">
        <section class="wrapper">
             <div class="col-md-4" id='load_insert_expenses_category'>
            </div>

            <div class="col-md-8" id='expenses_category_list'>
                
            </div>
           
        </section>
    </section>

</section>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
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
    $('#expenses_category_list').load('../expenses/expenses_category_list.php');
    $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');
</script>
<script type="text/javascript">
    function submit_form()
    {
        expenses_category = expenses_category_form.expenses_category.value;
        $('#expenses_category_list').load('../expenses/expenses_category_list.php?category='+expenses_category);
        
    }

    function delete_expenses_category(id)
    {
       if(confirm("Do you want to delete !!"))
        {
             $('#expenses_category_list').load('../expenses/expenses_category_list.php?delete_id='+id);
        }
    }

    function edit_expenses_category(id)
    {
        $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php?edit_id='+id);
    }

    function update_category_form(id)
    {
       
        expenses_category = update_expenses_category_form.expenses_category.value;

        
        $('#expenses_category_list').load('../expenses/expenses_category_list.php?update_category='+expenses_category+'&category_id='+id);
        $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');
    }

</script>

</body>
</html>
