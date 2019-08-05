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

      function submitExpForm(e) 
      { 
        e.preventDefault();
        let myForm = document.getElementById('expenses_add_category_form');
        let formData = new FormData(myForm);
        $.ajax
        ({ 
              url: "expenses_submit_management.php",
              type: "POST",
              data:  formData,
              contentType: false,
              cache: false,
              processData:false,
              beforeSend : function()
              {
                // $("#err").fadeOut();
                $("#submitBtn").hide();
                $("#loadingBtn").show();
                errorDisplay('');
              },
              success: function(data)
              {

                console.log(data);

                var result = JSON.parse(data);

                if (result.status == 200) {
                
                    $("#loadingBtn").hide();  

                    alert("Expenses Category added sucessfully");
                    location.reload();

                }else{
                    errorDisplay(result.errormsg);
                    $("#submitBtn").show();
                    $("#loadingBtn").hide();
                }
                
              },
              error: function(e) 
              {
                
                alert("try again");
                $("#submitBtn").show();
                $("#loadingBtn").hide();
              }          
        });
      };

      function submitUpdateExpenses(e) 
      { 
        e.preventDefault();
        let myForm = document.getElementById('update_expenses_category_form');
        let formData = new FormData(myForm);
        $.ajax
        ({ 
              url: "expenses_submit_management.php",
              type: "POST",
              data:  formData,
              contentType: false,
              cache: false,
              processData:false,
              beforeSend : function()
              {
                // $("#err").fadeOut();
                $("#submitBtn").hide();
                $("#loadingBtn").show();
                errorDisplay('');
              },
              success: function(data)
              {

                console.log(data);

                var result = JSON.parse(data);

                if (result.status == 200) {
                
                    $("#loadingBtn").hide();  

                    alert("Expenses Category updated sucessfully");
                    location.reload();

                }else{
                    errorDisplay(result.errormsg);
                    $("#submitBtn").show();
                    $("#loadingBtn").hide();
                }
                
              },
              error: function(e) 
              {
                
                alert("try again");
                $("#submitBtn").show();
                $("#loadingBtn").hide();
              }          
        });
      };


    // LOAD DEFAULT INSERT FIELD AND RECORD
    $('#expenses_category_list').load('../expenses/expenses_category_list.php');
    $('#load_insert_expenses_category').load('../expenses/insert_expenses_category.php');


    function errorDisplay(errMsg){
        $('#errCat').html(errMsg);
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
