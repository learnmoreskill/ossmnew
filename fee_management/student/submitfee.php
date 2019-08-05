<?php
include('../session.php');
include('../load_backstage.php'); 

if(isset($_REQUEST['student_id'])){
 $student_id = $_REQUEST['student_id'];

 $due_details = json_decode($account->get_total_student_due_by_student_id_status($student_id,1));

 //$pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$_GET['student_id']));
 $student_details = json_decode($account->get_student_details_by_sid($student_id));

 $advanceAmount = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);

 $pre_discount = 0;

 //$student_id = $_GET['student_id'];
 $spname = $student_details->spname;
 $sadmsnno = $student_details->sadmsnno;
 $sclass = $student_details->sclass;
 $ssec = $student_details->ssec;
 $dob = $student_details->dob;
 $sroll = $student_details->sroll;
 $sname = $student_details->sname;
 $saddress = $student_details->saddress;
 $spnumber = $student_details->spnumber;
 $payment_type=$student_details->payment_type;
 $status=$student_details->status;
}
 ?>
 <!-- VALIDATION -->

<div class="modal-body" style="padding: 0;">
  <form id='form2' method='post'  name="insert_fee_record" enctype="multipart/form-data">
    <div class="modal-header" style="padding: 10px;border: 0px;">  
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
          <h4 class="modal-title">
            <i class="glyphicon glyphicon-user"></i> Submit Fee 
          </h4> 
    </div> 


    <div class="customClass">
<div class="col-md-12 container-expensestbl overflowScroll">
 <table class="table table-dark table-responsive no-margin" >
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">SN</th>
      <th colspan="3" scope="col">Fees Category</th>
      <th scope="col">Rate Per Month</th>
      <th colspan="2" scope="col">Due Month </th>
      <th  scope="col">Amount</th>
    </tr>
  </thead>

  <tbody>


<?php
$sn=0;
if(isset($_GET['student_id']))
{
   $all_balance = 0;
   $all_balance1 = 0;
   $studentDueCount = 0;

   foreach ($due_details as $key) 
   {

    if ($key->feetype_title=='Pre Discount') {
      $pre_discount = $key->total_balance; ?>

      <input type="hidden" name="studentDueArray[<?php echo $studentDueCount; ?>]" value="<?php echo $key->id; ?>"> <?php

      $studentDueCount++;
      continue;
    }

    $rate = 0;
    $sn++;
    $all_balance = $all_balance + $key->total_balance;

    $rate = (($key->feetype_title=='Tution Fee')? $student_details->tution_fee : (($key->feetype_title=='Bus Fee')? $student_details->bus_fee : (($key->feetype_title=='Hostel Fee')? $student_details->hostel_fee : (($key->feetype_title=='Computer Fee')? $student_details->computer_fee : '') ) ) );

    
    ?>

    <tr> 
     <td>
     </td>
     <td><?php echo $sn; ?></td>
     <td colspan="3"><?php echo $key->feetype_title; ?></td>
     <td><?php echo $rate; ?></td>
     <td colspan="2" >
       
       

        <?php $due_type_details = json_decode($account->get_due_type_details_by_feetype_id_student_id_status($key->feetype_id,$student_id,1)); 

          
          $yearMonth = '';
          $countYearMonth = 0;
          $perbalance = 0;
          

          foreach ($due_type_details as $key1){
            $countYearMonth++;

            list($bs_year, $bs_month, $bs_day) = explode('-', $key1->date);
            $dateFnxn = new NepaliDate();
            if ($payment_type) {
              $yearMonth  = $bs_year;
            }else{
              $yearMonth=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.")";
            } 

            $perbalance += $key1->balance;

            $all_balance1 += $key1->balance;

            ?>

            <input type="hidden" name="studentDueArray[<?php echo $studentDueCount; ?>]" value="<?php echo $key1->id; ?>">

            <?php 
            $studentDueCount++;
          } 
        echo $countYearMonth; 
        ?>

     </td>
     
     <td class='totalCatBalance' id='total<?php echo $key->feetype_id; ?>' value='<?php echo $key->feetype_id; ?>' ><?php echo $perbalance; ?></td>
    
    </tr>
    <?php } ?>
    <tr class='active '>
      <td colspan='4'></td>
      <th colspan='4'>Total </th>
      <td id='total_balance' class="font-weight-bold"><?php echo $all_balance1; ?></td>
    </tr>

    

    
    <tr>
      <td colspan='11'>
        <div class=' row'>
         <h4 class='text-info  col-sm-6'>Advance Deposited: <span id='advanceAmnt' class='font-weight-bold'><?php echo ((!empty($advanceAmount))? $advanceAmount : 0); ?></span></h4>
         <?php if (!empty($pre_discount)) { ?>
         <h4 class='text-info  col-sm-6'>Pre Discount: <span id='preDiscountAmnt' class='font-weight-bold'><?php echo $pre_discount; ?></span></h4>
        <?php } ?>
         
        </div>
      </td>
    </tr>






    <tr> 
      <td colspan='5'>
          <label for='advance' class='col-sm-4  col-form-label' style='margin-top: 8px'>Amount to pay:</label>
          <div class='col-sm-6'>
            <input type='number' class='form-control' id='grandPay' name='grandPay' value="0" min="0" onkeyup='discountCalculate()'>
          </div>
      </td>
      <td colspan='3'>
          <label for='discount' class='col-sm-4 col-form-label' style='margin-top: 8px'>Discount:</label>
          <div class='col-sm-6'>
            <input type='number' class='form-control' id='grandDiscount' name='grandDiscount' value="0" min="0" onkeyup='discountCalculate()'>
          </div>
      </td>
      <td colspan='3'>
          <label for='fine' class='col-sm-4 col-form-label' style='margin-top: 8px'>Fine:</label>
          <div class='col-sm-6'>
            <input type='number' class='form-control' id='grandFine' name='grandFine' value="0" min="0" onkeyup='discountCalculate()'>
          </div>
      </td>
      

    </tr>


    <tr>
       <td colspan='11'>
        <div class=' row'>
          <h4 class='col-sm-4 text-success'>Total payable:<span class='font-weight-bold' id='totalPayable'></span>
          </h4>
           <h4 class='col-sm-4 text-info'>Advance remains:<span class='font-weight-bold' id='advanceRemain'></span>
          </h4>
          
          <h4 class='col-sm-4 text-success'>Dues remains:<span class='font-weight-bold' id='duesRemain'></span>
          </h4>
        </div>
      </td>
    </tr>


    <tr style='height:52px'>
      <td colspan='3' class='alignMiddle'>Payment Mode: </td>
      <td colspan='3' class='alignMiddle'>
          <label class='radio-inline'><input type='radio' name='paymentMode' checked value='cash'>Cash</label>
          <label class='radio-inline'><input type='radio' name='paymentMode' value='cheque'>Cheque</label>
          <label class='radio-inline'><input type='radio' name='paymentMode' value='bank'>Bank</label>
      </td>
      <td  colspan='5'> 
        <div id='payment_ref'>
          
        </div>
      </td>
    </tr>

    



    <tr>
      <td colspan='6'>
        <div class='row'>
         <label for='advance' class='col-sm-4 col-form-label' style='margin-top: 8px'>Received from*:</label>
          <div class='col-sm-6'>
            <input name='paidby' type='text' id='paidby' class='form-control' required autofocus />
          </div>
        </div>
      </td>
      <td colspan='5'>
        <div class='row'>
         <label for='advance' class='col-sm-4 col-form-label' style='margin-top: 8px'>Description:</label>
          <div class='col-sm-6'>
            <input name='description' type='text' id='description' class='form-control' />
          </div>
        </div>
      </td>
    </tr>

     
<?php }   
?>
 
</tbody>  
</table>
  <hr style="padding:5px 0;"> 
</div>
</div>
        
<div class="modal-footer"> 
    <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:red;    border-color: #d43f3a; color:#fff;">Close</button>  
    <div><input type="submit" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;" value="Pay now" id="payBtn">
    	<div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
    </div>

</div> 
</form>
</div>
<script type="text/javascript">
  
   

  var finaltotal=0;
  var total_balance=parseInt(document.getElementById("total_balance").innerHTML);
  var advanceAmnt=parseInt(document.getElementById("advanceAmnt").innerHTML);
  var preDiscountAmnt= <?php echo $pre_discount; ?>;
  preDiscountAmnt = preDiscountAmnt+0;

  function discountCalculate(){

      var grandPay = parseInt(document.getElementById('grandPay').value);
      var grandDiscount = parseInt(document.getElementById('grandDiscount').value);
      var grandFine = parseInt(document.getElementById('grandFine').value);

      if(!(typeof grandPay == "number" && grandPay >= 0) ){ grandPay = 0; }
      if(!(typeof grandDiscount == "number" && grandDiscount >= 0) ){ grandDiscount = 0; }
      if(!(typeof grandFine == "number" && grandFine >= 0) ){ grandFine = 0; }

      var totalPayableNew = total_balance - advanceAmnt - preDiscountAmnt - grandDiscount + grandFine + 0;
      if(!(typeof totalPayableNew == "number" && totalPayableNew >= 0) ){ totalPayableNew = 0; }

      $('#totalPayable').text(totalPayableNew);

      var totalPayableInitial = total_balance - advanceAmnt - preDiscountAmnt;

      if(!(typeof totalPayableInitial == "number" && totalPayableInitial >= 0) ){ totalPayableInitial = 0; }

      if (grandDiscount>totalPayableInitial) {
        alert('Discount is more than payable fee, Please check!!');
        $('#grandDiscount').val(0);
        discountCalculate();
        return;
      }

      var ifaAdvanceLeft = advanceAmnt + preDiscountAmnt + grandPay + grandDiscount - total_balance - grandFine + 0;
      if (ifaAdvanceLeft<=0) {
        ifaAdvanceLeft = 0;
      }
      $('#advanceRemain').text(ifaAdvanceLeft);

      var ifDuesLeft = total_balance + grandFine - advanceAmnt - preDiscountAmnt - grandPay - grandDiscount + 0;
      if (ifDuesLeft<=0) {
        ifDuesLeft = 0;
      }
      $('#duesRemain').text(ifDuesLeft);


  }


function intializePayment(){

  var totalPayableInitial = total_balance - advanceAmnt - preDiscountAmnt;

  if(!(typeof totalPayableInitial == "number" && totalPayableInitial >= 0) ){ totalPayableInitial = 0; }

  $('#totalPayable').text(totalPayableInitial);

  $('#duesRemain').text(totalPayableInitial);

  var ifaAdvanceLeft = advanceAmnt + preDiscountAmnt - total_balance;
  if (ifaAdvanceLeft<=0) {
    ifaAdvanceLeft = 0;
  }
  $('#advanceRemain').text(ifaAdvanceLeft);

}
  

</script>

<script>

var student_id = <?php echo $student_id ?>;

$(document).ready(function (e) 
{  
  $("#form2").on('submit',(function(e) 
  {
    e.preventDefault();
     var frmData=new FormData(this);

    frmData.append("totalBalance",parseInt(document.getElementById('total_balance').innerHTML));
    frmData.append("advanceBefore",parseInt(document.getElementById('advanceAmnt').innerHTML));
    frmData.append("advanceAfter",parseInt(document.getElementById('advanceRemain').innerHTML));
    frmData.append("duesAfter",parseInt(document.getElementById('duesRemain').innerHTML));
    

    $.ajax
    ({
          url: "../student/student_submit_management.php?submit_fee_request="+student_id,
          type: "POST",
          data:  frmData,
          // data:  JSON.stringify(formObj),

          contentType: false,
          cache: false,
          processData:false,

          beforeSend : function()
          {
            $("#payBtn").hide();
            $("#loadingBtn").show();
          },
          success: function(data)
          {
                console.log(data);

                var result = JSON.parse(data);

                if (result.status == 200) {

                  var a=confirm("Payment successfully done.\nDo you want to print the receipt as well?");
                  if(a){
                    var url='../school/bill_print_format_student.php?type=student&student_id=<?php echo $student_id; ?>&bill_id='+result.bill_id;

                     var printWindow = window.open(url, 'Print', '');
                      printWindow.addEventListener('load', function(){
                          printWindow.print();
                          printWindow.close();


                          $("#payBtn").show();
                          $("#loadingBtn").hide();
                          location.reload();

                      }, true);
                  }else{
                    location.reload();
                  }

                }else{
                  alert(result.errormsg);
                }
            
          },
          error: function(e) 
          {
          	$("#payBtn").show();
            $("#loadingBtn").hide();
            alert('Sorry Try Again !!');
            location.reload();
          }          
    });
  }));
});

</script>

<script>
$(document).ready(function(){
     $('input[type=radio][name=paymentMode]').change(function() {
        var payDiv=document.getElementById('payment_ref');
        if (this.value != 'cash') {
           // payDiv.style.display = 'inline-flex';
           $("#payment_ref").empty();
            var txt1 = " <input type='text' class='form-control' id='' name='paymentReferenceNumber' placeholder='Refrence number'  style='margin:0 5px 0 0' required><input type='text' class='form-control' id='' name='bankName' placeholder='Bank name' required>";    
            $("#payment_ref").append(txt1);
        }
        else {
           // payDiv.style.display = 'none';
           $("#payment_ref").empty();

        }
    });
});


window.onload=intializePayment();
</script>