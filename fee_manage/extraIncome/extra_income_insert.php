<?php
include('../session.php');
include('../load_backstage.php');
$edit_id=0;

if(isset($_REQUEST['edit_id']))
{
    $edit_id = $_REQUEST['edit_id'];
   
    
    $income_details = json_decode($account->getIncomeById($_REQUEST['edit_id']));

}

if(isset($_REQUEST['edit_id']))
{
    echo "<div class='form-w3layouts'>
            <div class='row'>
                <div class='col-lg-12'>
                    <section class='panel panel-default'>
                        <div class='panel-heading'  style='font-size:17px;'>
                          Update Extra Income
                        </div>
                        <div class='panel-body'>
        
                            <form id='update_form' name='incomeForm'>
                                <div class='form-group'>
                                    <label>Income Type*</label>
                                    <input required='true' class='form-control' type='text' name='update_income_type' value='".$income_details->income_type."'/>
                                </div>

                                <div class='form-group'>
                                    <label>Amount*</label>
                                    <input id='amount' required='true' class='form-control' type='text' name='update_income_amount' value='".$income_details->income_amount."' disabled>
                                </div>
                                 <div class='form-group'>
                                   <label class='radio-inline'><input type='radio' name='update_payment_mode' ".(($income_details->payment_mode=='cash')? 'checked':'')." value='cash' disabled>Cash</label>
                                  <label class='radio-inline'><input type='radio' name='update_payment_mode' ".(($income_details->payment_mode=='cheque')? 'checked':'')." value='cheque' disabled>Cheque</label>
                                  <label class='radio-inline'><input type='radio' name='update_payment_mode' ".(($income_details->payment_mode=='bank')? 'checked':'')." value='bank' disabled>Bank</label>
                                </div>"
                                .(($income_details->payment_mode!='cash')? "<div id='paymentModeDetailUpdate'>
                                   <div class='form-group'>
                                    <label for='usr'>Reference No.*</label>
                                    <input type='text' class='form-control'
                                    name='update_reference_rumber' id='referenceNumber' disabled value='".$income_details->payment_number."' >
                                    </div>
                                     <div class='form-group'>
                                    <label for='usr'>Bank name*</label>
                                    <input type='text' class='form-control' name='update_bank_name' id='bankName' disabled value='".$income_details->payment_source."' >
                                    </div>
                                </div>":"").
                                "<div class='form-group'>
                                    <label>Description</label>
                                    <input  class='form-control' type='text' name='update_description' value='".$income_details->income_description."'>
                                </div>
                                 <div class='form-group'>
                                    <label>Received from*</label>
                                    <input  class='form-control' type='text' name='update_received_from' value='".$income_details->payment_by."' required>
                                </div>
                                
                                <div class='form-group'>
                                <div class='pull-right'>
                                    <input style='width:100px;' readonly='true' id='updateBtn' class='btn btn-primary' type='submit'  value='Update' />

                                    <div id='updateLoadingBtn' style='display: none; margin-right: 20px;'><img src='../images/loading.gif' width='30px' height='30px'/></div>
                                    </div>
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
                    <section class='panel panel-default'>
                        <div class='panel-heading'  style='font-size:17px;'>
                          Extra Income
                        </div>

                        <div class='panel-body'>
        
                            <form id='insert_form' name='incomeForm'>
                                <div class='form-group'>
                                    <label>Income Title*</label>
                                    <input required='true' class='form-control' type='text' name='income_type' />
                                </div>

                                <div class='form-group'>
                                    <label>Amount*</label>
                                    <input id='amount' required='true' class='form-control' type='text' name='income_amount'>
                                </div>
                                <div class='form-group'>
                                    <label>Payment mode</label><br>

                                   <label class='radio-inline'><input type='radio' name='payment_mode' checked value='cash'>Cash</label>
                                  <label class='radio-inline'><input type='radio' name='payment_mode' value='cheque'>Cheque</label>
                                  <label class='radio-inline'><input type='radio' name='payment_mode' value='bank'>Bank</label>
                                </div>
                                <div id='paymentModeDetail'>

                                </div>

                                <div class='form-group'>
                                    <label>Description</label>
                                    <input  class='form-control' type='text' name='description'>
                                </div>
                                <div class='form-group'>
                                    <label>Received from*</label>
                                    <input  class='form-control' type='text' name='received_from' required>
                                </div>
                                
                                <div class='form-group'>
                                <div class = 'pull-right'>
                                    <input readonly='true' id='submitBtn' class='btn btn-primary' type='submit'  value='Submit' />

                                    <div id='submitLoadingBtn' style='display: none; margin-right: 20px;'><img src='../images/loading.gif' width='30px' height='30px'/></div>
                                  </div>

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
            //$("#err").fadeOut();
            $("#submitBtn").hide();
            $("#submitLoadingBtn").show();
          },
          success: function(data)
          {
             var result = JSON.parse(data);

              if (result.status == 200) {

                var a=confirm("Extra income added successfully.\nDo you want to print the receipt as well?");
                  if(a){
                    printExternal('../school/incomeReceipt.php?type=income&bill_id='+result.bill_id);
                    location.reload();
                  }else{
                    location.reload();
                  }

              }else{
                alert(result.errormsg);
              }

            $("#submitBtn").show();
            $("#submitLoadingBtn").hide();

          },
          error: function(e) 
          {
            $("#submitBtn").show();
            $("#submitLoadingBtn").hide();
            alert('Try Again !!');
          }          
    });
  }));
  
});

</script>
<script>
var update_id = <?php echo $edit_id ?>;
$(document).ready(function (e) 
{
  $("#update_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "../extraIncome/income_submit_management.php?update_id="+update_id,
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            //$("#err").fadeOut();
            $("#updateBtn").hide();
            $("#updateLoadingBtn").show();
          },
          success: function(data)
          {
            var result = JSON.parse(data);

              if (result.status == 200) {

                var a=confirm("Extra income updated successfully.");
                  
                $("#submitBtn").show();
                $("#updateLoadingBtn").hide();
                location.reload();

              }else{
                alert(result.errormsg);
              }

          },
          error: function(e) 
          {
            $("#submitBtn").show();
            $("#updateLoadingBtn").hide();
            alert('Try Again !!');
          }          
    });
  }));

  $('input[type=radio][name=payment_mode]').change(function() {
    // alert("selected: "+this.value);
        $('#paymentModeDetail').empty();

     if (this.value == 'cash') {
      }
      else {
        $('#paymentModeDetail').append("<div class='form-group'>"+
                                    "<label for='usr'>Reference No.*</label>"+
                                    "<input type='text' class='form-control'"+
                                    "name='reference_number' id='reference_number' required>"+
                                    "</div>"+
                                     "<div class='form-group'>"+
                                    "<label for='usr'>Bank name*</label>"+
                                    "<input type='text' class='form-control' name='bank_name'"+
                                     "id='bank_name' required></div>"
                                     );

   }
 });
 
  
});

</script>
<script type="text/javascript" src="../js/gudduJs/printController.js"></script>

