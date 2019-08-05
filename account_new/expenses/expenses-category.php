<?php include('../session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>


<!-- <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<script>
    function loadScript() {
      $(document).ready(function() {
      $('#expenseTable').DataTable();
     });
    }
</script> -->

<body>
<?php include ('../config/navbar.php'); ?>

<?php include('../modelprint.php'); ?>

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
        $('#expenses_category_list').load('../expenses/expenses_category_list.php');
        $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');
    </script>
   
    <script type="text/javascript">
    $('#expenses_category_list').load('../expenses/expenses_category_list.php');
    $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');
</script>
<script type="text/javascript">
    function submit_form()
    {
        expenses_category = expenses_category_form.expenses_category.value;
        var a=expenses_category;
            if(a.length>0){
                for(var i=0;i<a.length;i++){
                    a=a.replace(" ","_");
                }
        $('#expenses_category_list').load('../expenses/expenses_category_list.php?category='+a);
        
        alert(a +" has been added sucessfully !!");
        a='';
                }
    
        
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
        var b=expenses_category;
        if(confirm("Are you sure you want to edit the catagory !!")){
            if(b.length>0){
                for(var i=0;i<b.length;i++){
                    b=b.replace(" ","_");
                }        
                            }
        $('#expenses_category_list').load('../expenses/expenses_category_list.php?update_category='+b+'&category_id='+id);
        $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');

            }
            else
            {

            }

    }














</script>



    <!-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> -->

</body>
</html>
