<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<?php
require("../account_management.php");
require("../nepaliDate.php");
$account = new account_management_classes();

 if($_REQUEST['bill_id'])
 {

$bill_id = $_REQUEST['bill_id'];
//echo $bill_id;
$bill_details = $account->get_student_bill_deatails_by_bill_id($_REQUEST['bill_id']); 
$student_id = $bill_details->std_id;
$last_date = $bill_details->last_payment_date;
$balance = $bill_details->balance;

$current_date = $nepaliDate->full;
$last_month = date("$nepaliDate->nmonth",strtotime($last_date));
$last_month = $last_month + 1;

$last_year = date("$nepaliDate->year",strtotime($last_date));


$current_month = date("$nepaliDate->nmonth",strtotime($current_date));
$current_year = date("$nepaliDate->year",strtotime($current_date));
$feetype = $account->get_feetype_title_by_feetype_id($bill_details->feetype_id);
$student_feerate = $account->get_fee_by_feetype_student_id($student_id,$feetype);

}
?>

<script type="text/javascript">
  $(document).ready(function() {
    $('#discount,#fine').on('input', function() {
      var row = $(this).closest("insert_fee_record");
      var salary = $('#balance').val();
      var discount = $('#discount').val();
      var fine = $('#fine').val();
    if(isNaN(discount))
    {
      alert(discount + " is not a number ");
      $('#discount').val('');
      //$('#discount_validation').html('<p>Enter discount in number !!</p>');
    }
    // else
    // {
    //   //$('#discount_validation').html('<p></p>');
    // }
    if(isNaN(fine))
    {
      alert(fine + " is not a number ");
      $('#fine').val('');
    }
      salary = parseInt(salary);
      discount = parseInt(discount);
      fine = parseInt(fine);
      var net_balane = salary - discount + fine;
      $('#net_balance_show').val(net_balane);
    });
});
</script>

<div class="modal-body " style="padding: 0" >
       <form id='formName' method='post' name="insert_fee_record">

          <div class="modal-header" style="padding: 10px;border: 0px;">  
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                 <h4 class="modal-title">
                 <i class="glyphicon glyphicon-user"></i> Student Payment
                 </h4> 
          </div> 
      <?php 
      if($feetype=='Tution Fee' || $feetype=='Bus Fee' || $feetype=='Hostal Fee' || $feetype=='Computer Fee')
      {
      ?>
        <div class="form-row" style="padding-top: 0px;">
          <div class="col-md-6" style="margin-top: 10px;">
            <label for="inputPassword4">period starting Date</label>
            <?php
            echo "<input type='text' readonly='true' value='".$account->get_nepali_month($last_month)."' class='form-control' name='first_date' >";

            ?>
          </div>

             <div class="col-md-6" style="margin-top: 10px;">
            <label for="inputPassword4">period Ending Date</label>
            <select onchange='OnSelectionChange (this)'  name='second_date' id='last_payment_date' class='form-control'>
              <option>Choose Month</option>
              <?php
              $year_diff = $current_year-$last_year;
             
              if($year_diff>0)
              {
                for($i=$last_month; $i<=12;$i++)
                {
                  echo "<option>".$account->get_nepali_month($i)."</option>";
                }
                for($i=1; $i<=12;$i++)
                {
                  echo "<option>".$account->get_nepali_month($i)."</option>";
                }  
              }
              else
              { 
              for($i=$last_month; $i<=12;$i++)
                {
                  echo "<option>".$account->get_nepali_month($i)."</option>";
                }
                
              }
               ?>
              </select>
          </div>
        </div>
        <div class="form-row">
           <div class='form-group col-md-12' style='margin-bottom:5px;' id='load_balance_after_calculation'><br>
              <label for='inputCity'>Balance</label>
              <input readonly='true' type='text' id='balance' class='form-control tbalance'  name='balance' value="0" >
            </div>
         
        <?php  }
        else
        {
         ?>
        <div class="form-row">
           <div class='form-group col-md-12' style='margin-bottom:5px;' id='load_balance_after_calculation'><br>
              <label for='inputCity'>Balance</label>
              <input readonly='true' type='text' id='balance' class='form-control tbalance'  name='balance' value="<?php echo $balance; ?>" >
            </div>
         
          <?php } ?>  

      <div class="form-row">

          <div class='form-group col-md-6' style='margin-bottom:5px;'>
            <label for='inputCity'>Discount</label>
            <input id='discount' type='text' class='form-control tbalance' value="0"  name='discount' placeholder=''>
            <div id='discount_validation' style="color: red;"></div>
          </div>
          <div class='form-group col-md-6' style='margin-bottom:5px;'>
            <label for='inputCity'>Fine</label>
            <input id='fine' type='text' class='form-control tbalance' value="0"  name='fine' placeholder=''>
          </div>
      </div>   
         <div class='form-group col-md-12' style='margin-bottom:5px;'>
            <label for='inputCity'>Payment Type</label>
            <div>
            <input class='form-check-input' type='radio' checked='checked' name='payment_type' id='inlineRadio1' value='cash'>
            <label class='form-check-label' for='inlineRadio1'>Cash</label>
            <input class='form-check-input' type='radio' name='payment_type' id='inlineRadio2' value='Cheque'>
            <label class='form-check-label' for='inlineRadio2'>Cheque</label>
            </div>
          </div>
          
          
        </div>
        <?php 
      if($feetype=='Tution Fee' || $feetype=='Bus Fee' || $feetype=='Hostal Fee' || $feetype=='Computer Fee')
      {
      ?>
        <div class="form-group col-md-12">
            <label for="inputPassword4">Net Balance</label>
            <input readonly="true" type="text" class="form-control" id="net_balance_show" value='0'>
        </div>
        <?php }
        else
        {
        ?>
        <div class="form-group col-md-12">
            <label for="inputPassword4">Net Balance</label>
            <input readonly="true" type="text" class="form-control" id="net_balance_show" value='<?php echo $balance ; ?>'>
        </div>
        <?php
        }
        ?>

          <div class="form-group col-md-12">
            <label for="inputPassword4">Description</label>
            <textarea class="form-control" name='description' style="resize: none;height: 100px;"></textarea> 
          </div>
         
        
        
         <div class="modal-footer"> 
                  <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:red;    border-color: #d43f3a; color:#fff;">Close</button>
                   

                  <input type="submit" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;" name="add_salary" value="Save">
                  
          </div> 
      </form>
   </div>



<script type="text/javascript">
var bill_id = <?php echo $bill_id ?>;
function OnSelectionChange (select) 
{
  var first_date = insert_fee_record.first_date.value;
  var selectedOption = select.options[select.selectedIndex].value;
  $.ajax({
    method: "get",
    url: '../student/load_input_fee_calculation.php?first_month='+first_date+'&second_month='+selectedOption+'&bill_id='+bill_id,
    contentType: false,
    cache: false,
    processData:false,
  })
    .done(function( msg ) 
    {
      $('#balance').val(msg);
      $('#net_balance_show').val(msg);
    });   
}

</script>


<script>
$(document).ready(function (e) 
{
  $("#formName").on('submit',(function(e) 
  {
    
    e.preventDefault();
    $.ajax
    ({
          url: "../student/student_submit_management.php?id="+bill_id,
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

            //window.location.href = '../student/fee-collection.php?student_id='+data;
            location.reload();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  
});

</script>