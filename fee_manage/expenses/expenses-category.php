<!DOCTYPE html>
<html lang="en">
<?php

include('../session.php');
include('../load_backstage.php');

require('../head.php');
require('../header.php');
?>

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

<?php require('../config/commonFooter.php'); ?>

<script type="text/javascript">

    // LOAD DEFAULT INSERT FIELD AND RECORD
    $('#expenses_category_list').load('../expenses/expenses_category_list.php');
    $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');


    function errorDisplay(errMsg){
        $('#errCat').html(errMsg);
    }
    function submitWithAjax(request,data){

    }
    
    function insert_expense_category_form()
    {
        expenses_category = expenses_category_form.expenses_category.value.trim();

        if(expenses_category.length>0){
            expenses_category = expenses_category.replace(/ /g,"_");

            var response = submitWithAjax('insert',expenses_category);

            if (response) {

                alert(expenses_category +" has been added sucessfully !!");
                expenses_category='';
                expenses_category_form.reset();

            }else{
                errorDisplay('Expense category name can\'t be empty');
            }
            // $('#expenses_category_list').load('../expenses/expenses_category_list.php?category='+a);
            

            
        }else{
            errorDisplay('Expense category name can\'t be empty');
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
            if(b.length>0){
                for(var i=0;i<b.length;i++){
                    b=b.replace(" ","_");
                }        
                            }
        $('#expenses_category_list').load('../expenses/expenses_category_list.php?update_category='+b+'&category_id='+id);
        $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');

    }

</script>
</body>
</html>
