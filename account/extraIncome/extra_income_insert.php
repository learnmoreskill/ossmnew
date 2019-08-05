<?php
require("../account_management.php");
$account = new account_management_classes();

if(isset($_REQUEST['edit_id']))
{
    $edit_id = $_REQUEST['edit_id'];
   
    
    $income_details = json_decode($account->getIncomeById($_REQUEST['edit_id']));
    $schoolAccountId = $income_details->schoolAccountId;
}

if(isset($_REQUEST['edit_id']))
{
    echo"<div class='form-w3layouts'>
            <div class='row'>
                <div class='col-lg-12'>
                    <section class='panel'>
                        <header class='panel-heading' style='font-size:17px;'>
                         Update Extra Income
                        </header>
                        <div class='panel-body'>
        
                            <form id='update_form' name='incomeForm'>
                                <div class='form-group'>
                                    <label>Income Type</label>
                                    <input required='true' class='form-control' type='text' name='update_income_type' value='".$income_details->incomeType."'/>
                                </div>

                                <div class='form-group'>
                                    <label>Amount</label>
                                    <input id='amount' required='true' class='form-control' type='text' name='update_income_amount' value='".$income_details->incomeAmount."'>
                                </div>
                                <div class='form-group'>
                                    <label>Description</label>
                                    <input  class='form-control' type='text' name='update_description' value='".$income_details->incomedescription."'>
                                </div>
                                
                                <div class='form-group'>
                                    <input style='margin-bottom: 20px;width:100px;' readonly='true' class='btn btn-primary pull-right' type='submit'  value='Update' />
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
            </div>";
}
else
{
echo "<div class='form-w3layouts'>
            <div class='row'>
                <div class='col-lg-12'>
                    <section class='panel'>
                        <header class='panel-heading' style='font-size:17px;'>
                          Extra Income
                        </header>
                        <div class='panel-body'>
        
                            <form id='insert_form' name='incomeForm'>
                                <div class='form-group'>
                                    <label>Income Type</label>
                                    <input required='true' class='form-control' type='text' name='income_type' />
                                </div>

                                <div class='form-group'>
                                    <label>Amount</label>
                                    <input id='amount' required='true' class='form-control' type='text' name='income_amount'>
                                </div>
                                <div class='form-group'>
                                    <label>Description</label>
                                    <input  class='form-control' type='text' name='description'>
                                </div>
                                
                                <div class='form-group'>
                                    <input style='margin-bottom: 20px;width:100px;' readonly='true' class='btn btn-primary pull-right' type='submit'  value='Submit' />
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
            </div>";
     }       
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#amount').on('input', function() {
      var row = $(this).closest("incomeForm");
      var due_balance = $('#amount').val();
    if(isNaN(due_balance))
    {
      alert(due_balance + " is not a number ");
      incomeForm.income_amount.value ='';
    }
    
    });
});
</script>

<script>
$(document).ready(function (e) 
{
  $("#insert_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "../extraIncome/income_submit_management.php",
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
            if(data == 'Sucessfully Saved Income Record !!')
            {
              window.location.href = '../extraIncome/income_details.php';
            }

          },
          error: function(e) 
          {
            alert('Try Again !!');
          }          
    });
  }));
  
});

</script>
<script>
var update_id = <?php echo $edit_id ?>;
var schoolAccountId = <?php echo $schoolAccountId ?>;
$(document).ready(function (e) 
{
  $("#update_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "../extraIncome/income_submit_management.php?update_id="+update_id+'&schoolAccountId='+schoolAccountId,
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
            if(data == 'Sucessfully Update Income Record !!')
            {
              window.location.href = '../extraIncome/income_details.php';
            }

          },
          error: function(e) 
          {
            alert('Try Again !!');
          }          
    });
  }));
  
});

</script>

