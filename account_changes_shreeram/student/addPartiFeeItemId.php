
<?php
require("../account_management.php");
$account = new account_management_classes();

 if($_REQUEST['bill_id'])
 {
	$bill_id = $_REQUEST['bill_id'];
  $className = $_REQUEST['className'];
  $bill_details = $account->get_student_bill_deatails_by_bill_id($_REQUEST['bill_id']); 
  $feetype_id = $bill_details->feetype_id;
  $feetype = $account->get_feetype_by_feetype_id($feetype_id);
  
}
?>

<div class="modal-body" style="padding: 0">
       <form id='partform' method='post'  name="insert_fee_record">
       	<div class="modal-header" style="padding: 10px;border: 0px;">  
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                 <h4 class="modal-title">
                 <i class="glyphicon glyphicon-user"></i> Add Deu 
                 </h4> 
          </div> 
          
      <?php
      if($feetype=='Tution Fee' || $feetype=='Hostel Fee' || $feetype=='Bus Fee'|| $feetype=='Computer Fee')
      {
       ?>  
      	<div class="form-row">

          <div class='form-group col-md-12' style='margin-bottom:5px;'><br>
            <label for='inputCity'>Date</label>
            <input id='add_due_date' type='date' class='form-control tbalance'  placeholder='' name='partdue_date'>
          </div>
     	</div>

      <div class="form-row">
           <div class='form-group col-md-12' style='margin-bottom:5px;' id='load_balance_after_calculation'>
              <label for='inputCity'>Amount</label>
              <input  type='text'  class='form-control tbalance' id='due_balance'  name='partdue_balance'  readonly="true" value="0">
            </div>
        </div>
        <?php }
        else
        {
        ?> 
        <div class="form-row">
           <div class='form-group col-md-12' style='margin-bottom:5px;' id='load_balance_after_calculation'><br>
              <label for='inputCity'>Amount</label>
              <input  type='text'  class='form-control tbalance' id='due_balance'  name='partdue_balance'>
            </div>
        </div> 
        <?php } ?>

          <div class="form-group col-md-12">
            <label for="inputPassword4">Description</label>
            <textarea class="form-control" name='partdue_description' style="resize: none;height: 100px;"></textarea> 
          </div>
         
        
        
         <div class="modal-footer"> 
                  <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:red;    border-color: #d43f3a; color:#fff;">Close</button>  

                  <input type="submit" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;" value="Save">
          </div> 
      </form>
   </div>




<script>
	var bill_id = <?php echo $bill_id ?>;
  var className = <?php echo $className ?>;
$(document).ready(function (e) 
{
  $("#partform").on('submit',(function(e) 
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

<script type="text/javascript">
  $(document).ready(function() {
    $('#due_balance').on('input', function() {
      var row = $(this).closest("insert_fee_record");
      var due_balance = $('#due_balance').val(); 
    
    if(isNaN(due_balance))
    {
      alert(due_balance + " is not a number ");
      insert_fee_record.due_balance.value ='';
    }
    
    });
});
</script>

<script type="text/javascript">
  $(document).ready(function() {
    $('#add_due_date').on('input', function() {
      var row = $(this).closest("insert_fee_record");
      var add_due_date = $('#add_due_date').val();

      $.ajax({
      method: "get",
      url: '../student/load_input_fee_calculation.php?bill_id='+bill_id+'&add_due_date='+add_due_date+'&className='+className,
      contentType: false,
      cache: false,
      processData:false,
    })
      .done(function( msg ) 
      {
        if(isNaN(msg))
        {
          alert(msg);
           $('#due_balance').val('mm/dd/yyyy');
        }
        else
        {
          $('#due_balance').val(msg);
        }
        
      });   
      
    });
});
</script>
