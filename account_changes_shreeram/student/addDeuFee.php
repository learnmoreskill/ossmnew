
<?php
require("../account_management.php");
$account = new account_management_classes();
$feetype_details = json_decode($account->get_feetype_details());
if(isset($_REQUEST['student_id']))
 {
  $student_id = $_REQUEST['student_id'];
}
?>
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
<div class="modal-body">
       <form id='addform' method='post'  name="insert_fee_record">
       	<div class="modal-header" style="padding: 5px;border: 0px;">  
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                 <h4 class="modal-title">
                 <i class="glyphicon glyphicon-user"></i> Old Add Deu 
                 </h4> 
          </div> 

        <div class="form-row">
           <div class='form-group col-md-12' style='margin-bottom:5px;' id='load_balance_after_calculation'>
              <label for='inputCity'>Fee Type</label>
              <input  type='text'  class='form-control tbalance' name='fee_type' value="Old Deu" readonly="true" >
            </div>
         </div>
         
        <div class="form-row">
           <div class='form-group col-md-12' style='margin-bottom:5px;' id='load_balance_after_calculation'>
              <label for='inputCity'>Amount</label>
              <input  type='text'  class='form-control tbalance' id='due_balance'  name='due_balance'  >
            </div>
         </div>
       
      	  <div class="form-group col-md-12">
            <label for="inputPassword4">Description</label>
            <textarea class="form-control" name='due_description' style="resize: none;height: 100px;"></textarea> 
          </div>
         
        
        
         <div class="modal-footer"> 
                  <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:red;    border-color: #d43f3a; color:#fff;">Close</button>  

                  <input type="submit" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;" value="Save">
          </div> 
      </form>
   </div>




<script>
	var student_id = <?php echo $student_id ?>;

$(document).ready(function (e) 
{
  $("#addform").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "../student/student_submit_management.php?addDue_id="+student_id,
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