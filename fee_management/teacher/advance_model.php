<?php
if(isset($_GET['edit_id']))
{
  $tid = $_GET['edit_id'];
}

?>
<script type="text/javascript">
  $(document).ready(function() {
    $('#amount').on('input', function() {
      var row = $(this).closest("advance_form");
      var amount = $('#amount').val();
    if(isNaN(amount))
    {
      alert(amount + " is not a number ");
      $('#amount').val('')
    }
    
    });
});
</script>
<div class="modal-body" style="padding: 0">
<form name="advance_form" >
	  <div class="modal-header"> 
       <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
       <h4 class="modal-title">
       <i class="glyphicon glyphicon-user"></i>  Advance Form
       </h4> 
    </div> 
  
    <div class="form-group" style="padding: 10px 10px 0;">
      <label for="inputEmail4">Advance Amount</label>
      <input type="text" class="form-control" id='amount' name="amount"  placeholder="Example; 1500">
    </div>
    <div class="form-group" style="padding:0 10px 10px;">
      <label for="inputPassword4">Purpose </label>
      <input type="text" class="form-control" name="purpose" placeholder="Personal Used" >
    </div>
     
  
   
   <div class="modal-footer"> 
            <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:#d9534f;    border-color: #d43f3a; color:#fff;">Close</button>  
             <input  class="btn btn-info" style="width:100px; color: #fff;background-color: #5bc0de;border-color: #46b8da;" name="add_salary" onclick="submit_advance_form()" value="Save">
           

        </div> 
</form>
</div>

<script type="text/javascript">
var tid = <?php echo $tid ?>;
function submit_advance_form()
{
  var amount = advance_form.amount.value;
  var purpose = advance_form.purpose.value; 

if(amount=='' && purpose == '')
{
  alert('Please fill Data')
  return false;
}
else
{
  if (isNaN(amount)) 
  {
    alert("Amount must be numbers");
    return false;
  }
}
 $.ajax
      ({
          
      url: "../teacher/teacher_submit_management.php?t_id="+tid+'&amount='+amount+'&purpose='+purpose,
      cache: false
    })
    .done(function( msg ) 
    {
      alert(msg);
      window.location.href = '../teacher/payment.php';
    });
}    
</script>



