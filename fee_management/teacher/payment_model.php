<?php
require("../nepaliDate.php");
require("../account_management.php");
$account = new account_management_classes();

 
 if(isset($_GET['edit_id']) && !empty($_GET['edit_id']))
 {
  $id = $_GET['edit_id'];
  $last_payment_date = $account->get_last_payment_to_employee_date($id);
  $salary = $account->get_employee_salary($id); 
  //$last_payment_month = date("m",strtotime($last_payment_date));
  $last_payment_month = explode('-',$last_payment_date)[1];
 }
?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#bonus_amount,#Deducted_amount').on('input', function() {
      var row = $(this).closest("teacher_payment_form");
      var salary = $('#paying_amount').val();
      var bonus = $('#bonus_amount').val();
      var deducted = $('#Deducted_amount').val();
      if(isNaN(deducted))
      {
      alert(deducted + " is not a number ");
      deducted = 0;
      $('#Deducted_amount').val(0)

      }
      if(isNaN(bonus))
      {
      alert(bonus + " is not a number ");
      bonus = 0;
      $('#bonus_amount').val(0)

      }
    salary = isNaN(parseInt(salary))?0:parseInt(salary);
    bonus = isNaN(parseInt(bonus))?0:parseInt(bonus);
    deducted = isNaN(parseInt(deducted))?0:parseInt(deducted);
    var net_balance = salary + bonus - deducted;
    $('#net_balance_show').val(net_balance);
    });
  });
</script>

<div class="modal-body" style="padding: 0">
 
 
<form id='form' method='post'  name="teacher_payment_form">

    <div class="modal-header" style="padding: 10px;border: 0px;">  
           <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
           <h4 class="modal-title">
           <i class="glyphicon glyphicon-user"></i> Salary Payment
           </h4> 
    </div> 

  <div class="form-row" style="padding-top: 0px;">
    <div class="col-md-6" style="margin-top: 10px;">
      <label for="inputPassword4">Period Starting Date</label>
      <?php
echo "<input type='text' readonly='true' value='".$account->get_nepali_month($last_payment_month)."' class='form-control' name='first_date' >";

      ?>-
    </div>

       <div class="col-md-6" style="margin-top: 10px;">
      <label for="inputPassword4">period Ending Date</label>
      <select onchange='OnSelectionChange (this)'  name='second_date' id='last_payment_date' class='form-control'>
        <option>Choose Month</option>
        <?php
        $m = date('m');
         for($i=$last_payment_month+1; $i<=$m;$i++)
          {
            echo "<option value='$i'>".$account->get_nepali_month($i)."</option>";
          }
         ?>
        </select>
    </div>
  </div>
      
  <div class="form-row">

     <div class="form-group col-md-12" style="margin-top: 10px;">
      <label for="inputEmail4">Paying Amount</label>
      <input readonly="true" type="text" required="" class="form-control" name="paying_amount" id="paying_amount" value='<?php echo $salary; ?>'>
    </div>

    <div class="form-group col-md-6" style="margin-top: 10px;">
      <label for="inputEmail4">Bonus/Reward</label>
      <input type="text"  class="form-control" name="bonus_amount" id="bonus_amount" value='0' placeholder="Bonus Amount">
    </div>
    <div class="form-group col-md-6" style="margin-top: 10px;">
      <label for="inputPassword4">Deduction Amount</label>
      <input type="text" class="form-control" name="Deducted_amount" id="Deducted_amount" value='0' placeholder="Amount to be Deducted">
    </div>

    
  </div>
  <div class="form-group col-md-12">
      <label for="inputPassword4">Net Balance</label>
      <input readonly="true" type="text" class="form-control" id="net_balance_show" value='0'>
      
    </div>

    <div class="form-group col-md-12">
      <label for="inputPassword4">Description</label>
      <textarea class="form-control" name='description' style="resize: none;height: 100px;"></textarea> 
    </div>
   
  
  
   <div class="modal-footer"> 
            <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:red;    border-color: #d43f3a; color:#fff;">Close</button>  

            <input type="submit" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;" name="add_salary" value="Save">
             <a onclick="printExternal()" class='btn btn-info pull-right' style='background-color:#009688; color:#fff;margin-right:10px;'  title='Print'> 
            <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>Print</span></a>
  
  </div> 
</form>
   </div>


<script>
var teacher_id = <?php echo $id ?>;
$(document).ready(function (e) 
{
  $("#form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "../teacher/teacher_submit_management.php?tid="+teacher_id,
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
            window.location.href = '../teacher/payment.php';
           
          
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  
});

</script>
<script>
function printExternal() 
{
  var first_date = teacher_payment_form.first_date.value;
  var second_date = teacher_payment_form.second_date.value;
  var paying_amount = teacher_payment_form.paying_amount.value;
  var bonus_amount = teacher_payment_form.bonus_amount.value;
  var Deducted_amount = teacher_payment_form.Deducted_amount.value;

  url = '../teacher/teacher_payment_receipt.php?tid='+teacher_id+'&first_date='+first_date+'&second_date='+second_date+'&paying_amount='+paying_amount+'&bonus_amount='+bonus_amount+'&Deducted_amount='+Deducted_amount;
    var printWindow = window.open( url, 'Print', '');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
        window.location.href = '../teacher/payment.php';
    }, true);
}
</script>

<script type="text/javascript">
  var first_date = '<?php echo $last_payment_month; ?>';
  var salary = '<?php echo $salary; ?>';
function OnSelectionChange (select) 
{
  var second_date = $('#last_payment_date').val();
  var new_amnt = (second_date-first_date) * salary;
 $('#paying_amount').val(new_amnt);
  $('#net_balance_show').val(new_amnt);
  // $.ajax({
  //   method: "get",
  //   url: '../teacher/teacher_monthly_calculation.php?first_date='+first_date+'&second_date='+second_date+'&emp_id='+teacher_id,
  //   contentType: false,
  //   cache: false,
  //   processData:false,
  // })
  //   .done(function( msg ) 
  //   {
  //     $('#paying_amount').val(msg);
  //     $('#net_balance_show').val(msg);
      
  //   });   
  
}

</script>