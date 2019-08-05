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
<script type="text/javascript">
  $(document).ready(function() {
    $('#quantity_type_with').on('click', function() {
      var status = $('#quantity_type_with').val();
      $('#load_quantity').html("<label>Quantity</label><input class='form-control' type='text' name='quantity'>");
    });

    $('#quantity_type_without').on('click', function() {
      var status = $('#quantity_type_without').val();
      $('#load_quantity').html("<label>Quantity</label><input class='form-control' type='text' name='quantity'>");
      
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
                    <section class="panel">
                        <header class="panel-heading" style='font-size:17px;'>
                          School Expenses
                        </header>
                        <div class="panel-body">
        
                            <form id='form1' name='expensesForm'>
                                <div class='form-group'>
                                    <label>Expenses Category</label>
                                    <select required="true" class="form-control" name='category'>
                                        <option>Choose</option>
                                    <?php
                                    foreach ($expenses_category_list as $key) 
                                    {
                                       echo "<option>".$key->exp_cat."</option>";
                                    }
                                    ?>
                                    </select>
                                </div>

                                <div class='form-group'>
                                    <label>Quantity Type</label>
                                    <div class="form-group">
                                        <input type="radio" checked="true" id='quantity_type_with' name="quantity_type" value="with">
                                        <label style="font-size:12px;">With</label>
                                         <input type="radio" id='quantity_type_without' name="quantity_type" value="without">
                                        <label style="font-size:12px;">Without</label>
                                     </div>  
                                </div>
                                 <div class='form-group'>
                                    <label>Name</label>
                                    <input required="true" class="form-control" type="text" name="name">
                                </div>
                                <div class='form-group' id='load_quantity'>
                                    <label>Quantity</label>
                                    <input id='quantity' required="true" class="form-control" type="text" name="quantity">
                                </div>

                                <div class='form-group'>
                                    <label>Expenses Amount</label>
                                    <input id='amount' required="true" class="form-control" type="text" name="amount">
                                </div>
                                <div class='form-group'>
                                    <label>Description</label>
                                    <input  class="form-control" type="text" name="description">
                                </div>
                                <div class='form-group'>
                                    <label>File</label>
                                    <input  class="form-control" type="file" name="file">
                                </div>
                                
                                <div class="form-group">
                                    <input style='margin-bottom: 20px;width:100px;' readonly="true" class='btn btn-primary pull-right' type="submit"  value="Submit" />
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
    $('#expenses_category_list').load('../expenses/expenses_list.php');
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('#amount1,#quantity').on('input', function() {
      var row = $(this).closest("insert_fee_record");
      var amount = $('#amount').val();
      var quantity = $('#quantity').val();
      
      if(isNaN(amount))
      {
        alert(amount + " is not a number ");
        $('#amount').val('');
      }
      if(isNaN(quantity))
      {
        alert(quantity + " is not a number ");
        $('#quantity').val('');
      }
     
    });
});
</script>


<script>
$(document).ready(function (e) 
{
  $("#form1").on('submit',(function(e) 
  {
    
    e.preventDefault();
    $.ajax
    ({

          url: "../expenses/expenses_submit_management.php",
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
            if(data == 'Sucessfully upload record')
            {
              window.location.href = '../expenses/expenses-details.php';
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

</body>
</html>
