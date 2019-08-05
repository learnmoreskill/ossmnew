<!DOCTYPE html>
<html lang="en">
<?php

include('../session.php');
include('../load_backstage.php');

require('../head.php');
require('../header.php');

$expenses_category_list = json_decode($account->get_expenses_category_list());
?>
<body>
<script type="text/javascript">
  $(document).ready(function() {
    $('#quantity_type_with').on('click', function() {
      $('#load_quantity').show();
      $('#load_rate').show();

      $('#quantity').val('1');
      $('#rate').val('1');
      $('#amount').val('1');
      $('#amount').attr("readonly","true");
    });

    $('#quantity_type_without').on('click', function() {
      $('#load_quantity').hide();
      $('#load_rate').hide();
      $('#amount').removeAttr("readonly");
      
    });

});
</script>

<?php include('../config/navbar.php'); ?>
    <section id="main-content">
        <section class="wrapper">
             <div class="col-md-4" id='insert_exam_type_details'>
            <div class='form-w3layouts'>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel panel-default">
                        <div class="panel-heading"  style='font-size:17px;'>
                          School Expenses
                        </div>
                        <div class="panel-body">
        
                            <form id='addExpensesForm' name='addExpensesForm'>
                                <div class='form-group'>
                                    <label>Expenses Category*</label>
                                    <select required="true" class="form-control" name='category'>
                                        <option value="" selected disabled>Choose expence category</option>
                                    <?php
                                    foreach ($expenses_category_list as $key) 
                                    {
                                       echo "<option value='".$key->ecat_id."'>".$key->exp_cat."</option>";
                                    }
                                    ?>
                                    </select>
                                </div>

                                
                                 <div class='form-group'>
                                    <label>Expense Title*</label>
                                    <input required="true" class="form-control" type="text" name="name" placeholder="Enter title....">
                                </div>

                                <div class='form-group'>
                                    <label>Quantity Type</label>
                                    <div class="form-group">
                                        <input type="radio" checked="true" id='quantity_type_with' name="quantity_type" value="with">
                                        <label style="font-size:12px;">With</label>
                                         <input type="radio" id='quantity_type_without' checked name="quantity_type" value="without">
                                        <label style="font-size:12px;">Without</label>
                                     </div>  
                                </div>

                                <div class='form-group' id='load_quantity' style="display: none">
                                    <label>Quantity</label>
                                    <input id='quantity' class="form-control" type="number" name="quantity" min="1" value="1" >
                                </div>
                                <div class='form-group' id='load_rate' style="display: none">
                                    <label>Rate</label>
                                    <input class="form-control" type="number" name="rate" id="rate" min="1" value="1" >
                                </div>

                                <div class='form-group'>
                                    <label>Expenses Amount*</label>
                                    <input id='amount' required="true" class="form-control" type="number" name="amount" min="1" value="1" >
                                </div>

                                <div class='form-group'>
                                    <label>Description</label>
                                    <input  class="form-control" type="text" name="description" placeholder="Enter description....">
                                </div>
                                <div class='form-group'>
                                    <label>Bill (if any)</label>
                                    <input  class="form-control" type="file" name="file">
                                </div>
                                
                                <div class="form-group">
                                  <div class='pull-right'>
                                     <button id="submitBtn" class='btn btn-primary' type="submit" >Add expense</button>

                                     <div id='loadingBtn' style='display: none; margin-right: 20px;'><img src='../images/loading.gif' width='30px' height='30px'/></div>
                                  </div>
                                  
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
            </div>
            </div>

            <div class="col-md-8" id='expenses_category_list'>
                
            </div>
           
        </section>
    </section>

</section>
    
<?php require('../config/commonFooter.php'); ?>
  
<script type="text/javascript">

    $('#expenses_category_list').load('../expenses/expenses_list.php');




$(document).ready(function (e) 
{
  $("#addExpensesForm").on('submit',(function(e) 
  {
    
    e.preventDefault();
    $.ajax
    ({

          url: "../expenses/expenses_submit_management.php?add_expenses=addexpenses",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            //$("#err").fadeOut();
            $("#submitBtn").hide();
            $("#loadingBtn").show();
          },
          success: function(data)
          {
            var result = JSON.parse(data);

              if (result.status == 200) {

                // var a=confirm("Expenses added successfully.\nDo you want to print the receipt as well?");
                //   if(a){
                //     printExternal('../school/bill_print_format_extra.php?type=expense&bill_id='+result.bill_id);
                //     location.reload();
                //   }else{
                //     location.reload();
                //   }

                alert("Expenses added successfully");
                location.reload();

              }else{
                alert(result.errormsg[0].split(',').join("\n"));
              }

            $("#submitBtn").show();
            $("#loadingBtn").hide();

          },
          error: function(e) 
          {
            //$("#err").html(e).fadeIn();
            $("#submitBtn").show();
            $("#loadingBtn").hide();
             alert('Try Again !!');
          }          
    });
  }));
  // $("#rate").bind('keyup change', function () {
  //   calculateTotalExpence();               
  // });
  // $("#quantity").bind('keyup change', function () {
  //   calculateTotalExpence();           
  // });
});


$(document).ready(function() {
    $('#rate,#quantity').on('input', function() {
      var rate = $('#rate').val();
      var quantity = $('#quantity').val();
      
      if(isNaN(rate))
      {
        alert(rate + " is not a number ");
        $('#rate').val('1');
      }
      if(isNaN(quantity))
      {
        alert(quantity + " is not a number ");
        $('#quantity').val('1');
      }
     calculateTotalExpence();
    });
});

function calculateTotalExpence() 
{
  var rate = document.getElementById("rate").value;
  var qnt = document.getElementById("quantity").value;
  var totalExp = parseFloat(rate*qnt)

  if (!isNaN(totalExp)){

      document.getElementById("amount").value = totalExp;

    } else{
      alert("Rate or quntity must be +ve integer value");
    } 
}

</script>

</body>
</html>
