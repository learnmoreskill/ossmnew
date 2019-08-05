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
             <div class="col-md-4" id='load_insert_feetype'>
            Loading...
            </div>

            <div class="col-md-8" id='load_book_list_details'>
                <div class="table-agile-info" id='load_fee_type'>
                Loading...
            </div>
        
            </div>
           
        </section>
    </section>

</section>

<?php require('../config/commonFooter.php'); ?> 

<script type="text/javascript">
    $('#load_fee_type').load('../student/feetype_list.php');
    $('#load_insert_feetype').load('../student/insert_fee_category.php');

    function errorDisplay(errMsg){
        $('#errCat').html(errMsg);
    }
    

    function submitAddFeeType(e) 
      {
        e.preventDefault();
        let myForm = document.getElementById('add_feetype_form');
        let formData = new FormData(myForm);
        $.ajax
        ({ 
              url: "student_submit_management.php?add_feetype_request=add_feetype_request",
              type: "POST",
              data:  formData,
              contentType: false,
              cache: false,
              processData:false,
              beforeSend : function()
              {
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

                    alert("Fee type added sucessfully");
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
    function submitUpdateFeeType(e) 
      { 
        e.preventDefault();
        let myForm = document.getElementById('update_feetype_form');
        let formData = new FormData(myForm);
        $.ajax
        ({ 
              url: "student_submit_management.php?update_feetype_request=update_feetype_request",
              type: "POST",
              data:  formData,
              contentType: false,
              cache: false,
              processData:false,
              beforeSend : function()
              {
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

                    alert("Fee type updated sucessfully");
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



    function edit_fee_type(id)
    {
        $('#load_insert_feetype').load('../student/insert_fee_category.php?edit_id='+id);
    }


    function delete_fee_type(id)
    { 
        if(confirm("Are you sure to delete fee category?")){
        $('#load_fee_type').load('../student/feetype_list.php?delete_id='+id);
    }
       
    }
</script>

</body>
</html>
