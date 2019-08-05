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
  $feetype_details = json_decode($account->get_feetype_details());
  $student_id=$account->get_student_id_by_bill_id($bill_id);
  $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$student_id));

  
}
?>

<div class="modal-body" style="padding: 0">
       <form id='partform' method='post'  name="insert_fee_record">
       	<div class="modal-header" style="padding: 10px;border: 0px;">  
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                 <h4 class="modal-title">
                 <i class="glyphicon glyphicon-user"></i> Edit Deu 
                 </h4> 
          </div> 
<div class="panel panel-body">          
<table class="table table-dark table-responsive">
  <thead>
    <tr>
      <th scope="col">SN</th>
      <th scope="col">Fees Category</th>
      <th scope="col">Amount</th>
    </tr>
  </thead>

  <tbody>
    <?php
    $sn=1;
      foreach ($pending_details as $key) 
      {
        $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
        $balance = $key->balance;
        //$total_balance = $total_balance + $balance;
        echo "<tr>
          <td>".$sn."</td>
          <td>".$feetype."</td>
          <td><input type='text' id='neweditamount".$key->bill_id."' name='neweditamount".$key->bill_id."' value='".$balance."'></td>
          </tr>
        ";
        $sn=$sn+1;
      }

    ?>

</tbody>

</table>
</div>


         <div class="modal-footer"> 
                  <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:red;    border-color: #d43f3a; color:#fff;">Close</button>  

                  <input type="submit" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;" value="Save">
          </div> 
      </form>
   </div>




<script>
	var bill_id = <?php echo $bill_id ?>;
  var className = <?php echo '\''.$className.'\'' ?>;
$(document).ready(function (e) 
{
  $("#partform").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax({
        url: "../student/student_submit_management.php?edit_bill_id="+bill_id,
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
      var edit_due_date = $('#add_due_date').val();

      $.ajax({
      method: "get",
      url: '../student/load_input_fee_calculation.php?bill_id='+bill_id+'&edit_due_date='+edit_due_date+'&className='+className,
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

<script type="text/javascript">
  
    $(document).ready(function(){
       $('#inputfeetype1').on('change',function(){
        //alert($('#inputfeetype1 :selected').text());  
      if
          ($('#inputfeetype1 :selected').text()==('Tution Fee')||
            ($('#inputfeetype1 :selected').text()==('Computer Fee'))||
            ($('#inputfeetype1 :selected').text()==('Bus Fee'))||
            ($('#inputfeetype1 :selected').text()==('Hostel Fee'))
              )
          {
          $('#mydivedit2').hide();
          $('#mydivedit1').show();
          
        }
        else if($('#inputfeetype1 :selected').text()=='Select A fee Catagory')
        {
          $('#mydivedit1').hide();
          $('#mydivedit2').hide();
          
        }
        else
        {
          $('#mydivedit1').hide();
          $('#mydivedit2').show();
          
        }
       });
    });
</script>
