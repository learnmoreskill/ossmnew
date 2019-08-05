<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');
?>
<?php

if(isset($_GET['student_id']))
{
  $student_id = $_GET['student_id'];

  $due_details = json_decode($account->get_total_student_due_by_student_id_status($student_id,1));

  $advanceAmount = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);
  $pre_discount = 0;

}
?>

<body>

<?php include('../config/navbar.php'); ?>
 
    <section id="main-content">
        <section class="wrapper panel panel-default" style="margin: 70px 13px 0px;width: calc(100% - 26px);">
             <div class="">

   
<div class="col-md-12">
<?php
  include('studDetailTmplt.php');

?>
  <div class="col-xs-12">
        <?php
        $url = "./layouts/view_print.php";
        ?>


        <!-- <a onclick="printExternal('../student/payment_bill.php?student_id=<?php echo $student_id; ?>')" class='btn btn-danger' style='color:#fff;float: right;'  title='Print'> 
          <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>Print</span></a>
 -->
        <div class="col-xs-6 col-sm-4 col-md-2 col-sm-offset-4 col-md-offset-4">
          <a onclick="create_due_receipt('../student/create_receipt_by_single_student.php?studentId=<?php echo $student_id; ?>')" class='btn btn-danger  btn-block' style='color:#fff;'  title='Print'>
           <i class='fa fa-list-ol' aria-hidden='true'></i> Create Due Receipt
          </a> 
        </div>

        <div class="col-xs-6 col-sm-4 col-md-2">
          <a class='btn btn-danger addFeeItemId btn-block' style='color:#fff;' href='#addFee' data-toggle='modal' data-whatever='<?php echo $student_id; ?>'><i class='fa fa-list-ol' aria-hidden='true'></i>Add Old Due</a>
        </div>

        <div class="col-xs-6 col-sm-4 col-md-2 col-sm-offset-4 col-md-offset-0">
          <a href='../student/fee-statement.php?student_id=<?php echo $student_id; ?>' class='btn btn-danger btn-block' style='color:#fff;'  title='Print'> 
          <i class='fa fa-list-ol' aria-hidden='true'></i> Statement</a>
        </div>

        <div class="col-xs-6 col-sm-4 col-md-2">
            <a href='../student/view-invoice.php?student_id=<?php echo $student_id; ?>' class='btn btn-danger btn-block ' style='color:#fff;'  data-toggle='tooltip' title='' data-original-title='Edit'> 
          <i class='fa fa-list-ol' aria-hidden='true'></i> View Invoice</a>
        </div>
          
        
          
        

        
     
  </div>

</div>

<div class="customClass" style="clear: both;">
<div class="col-md-12 container-expensestbl">

<form method="post" id='form' class="overflowScroll">
 <table class="table table-dark" >
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">SN</th>
      <th scope="col">Fees Category</th>

      <th scope="col"><?php if($payment_type==0) echo "Rate Per Month"; else echo "Rate Per Year";?></th>

      <th scope="col"><?php if($payment_type==0) echo "Due Month"; else echo "Due Year";?></th>
      
      <th scope="col">Balance</th>
      <th scope="col">Status</th>
    </tr>
  </thead>

  <tbody>


<?php
$sn=0;
if(isset($_GET['student_id'])){

  $all_balance = 0;
  foreach ($due_details as $key){
    if ($key->feetype_title=='Pre Discount') {
      $pre_discount = $key->total_balance;
      continue;
    }
    $rate = 0;
    $sn++;
    $all_balance = $all_balance + $key->total_balance;

    $rate = (($key->feetype_title=='Tution Fee')? $student_details->tution_fee : (($key->feetype_title=='Bus Fee')? $student_details->bus_fee : (($key->feetype_title=='Hostel Fee')? $student_details->hostel_fee : (($key->feetype_title=='Computer Fee')? $student_details->computer_fee : '') ) ) );
    ?>


    <tr>
     <td></td>
     <td><?php echo $sn; ?></td>
     <td><?php echo $key->feetype_title; ?></td>
     <td><?php echo $rate; ?></td>
     <td><?php echo $key->total_month; ?>&nbsp&nbsp<a class='viewFeeDetails' href='#viewFeeDetails' data-toggle='modal' data-whatever='<?php echo $key->feetype_id; ?>'><i class='glyphicon glyphicon-info-sign' style='color:black;' ></i></a></td>

     <td class='total'><?php echo $key->total_balance; ?></td>
     <td>Pending</td>
    </tr>

    <?php 
  } ?>
  <tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td style='padding-right:0'><span class='text-danger'>Total Balance:</span>

      <br><span class='text-success'>Advance Paid:</span>
      
      <?php if (!empty($pre_discount)) { ?>
        <br><span class='text-success'>Pre Discount:</span>
      <?php } ?>
      
      
      <hr><b class='text-info'>Total Payable:</b> </td>
    <td  > <span class='text-danger' id='total_balance'><?php echo $all_balance; ?></span>

      <br><span class='text-success' id='advPaid'><?php echo $advanceAmount; ?></span>

      <?php if (!empty($pre_discount)) { ?>
      <br><span class='text-success' id='preDiscount'><?php echo $pre_discount; ?></span>
      <?php } ?>
      
    <hr style='margin-left:-10px'>
    <b><span class='text-info' id='total_payable'><?php 
        $totalPayableAmount = ((float)$all_balance-(float)$pre_discount-(float)$advanceAmount);
        if( $totalPayableAmount < 0 ){ $totalPayableAmount = 0; }
        echo $totalPayableAmount; ?></span></b> </td>
    <td class='action'>
      <a class='btn btn-success btn-block submitModal' style='color:#fff;width:90%;' data-target='.bd-example-modal-lg' data-whatever='<?php echo $student_id; ?>'><i class='fas fa-money-bill-alt'></i> Pay</a>

      <!-- <a class='btn btn-info btn-block' style='color:#fff;width:90%;' data-target='#advancePayModal' data-whatever='<?php echo $student_id; ?>'> <i class='fas  fa-piggy-bank'></i> Advance Pay</a> -->
      </td>

    </tr>
    <?php 
}   ?>
 
  </tbody>
  
</table>
</form>
</div>
</div>
        </section>
    </section>

</section>
<!-- <div id="viewModal" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
          
        </div>
    </div>
</div>
 -->
<div id="submitFee" class="modal fade bd-example-modal-lg" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog modal-lg w-50" style="width: 70%">
          <div class="modal-content-submitFee" style='background-color: #fff;border-radius: 10px;'>
          </div>
    </div>
</div>


<div id="viewFeeDetails" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:40%;">
        <div class="modal-content-viewFeeDetails" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div>

<div id="addFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
        <div class="modal-content-addFee" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div>

<!-- <div id="editFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
        <div class="modal-content-editFee" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div> -->

<!-- <div id="addPartFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
  <div class="modal-dialog ">
      <div class="modal-content-addPartFee" style='background-color: #fff;border-radius: 10px;'>

      </div>
  </div>
</div> -->

<!-- <div id="editPartFee" class="modal fade " aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog ">
        <div class="modal-content-editPartFee" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div> -->
<?php include 'modals.php';?>

<?php require('../config/commonFooter.php'); ?>

     <link href="../assets/js/gudduJs/fSelect.css" rel="stylesheet">
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
    <script src="../assets/js/gudduJs/fSelect.js"></script>  

<script type="text/javascript">

  var classId = '<?php echo $class_id; ?>';
  var studentId = '<?php echo $student_id; ?>';
  var paymentType = '<?php echo $payment_type; ?>';
  //alert(paymentType);




$(window).load(function() {
  console.clear();
});
$(document).ready(function()
{ 
  $('.action a:not(.disabled)').click(function(e) {
    var modal = $(this).attr('data-target');
    $(modal).modal();
  });

  $('.checkBoxClass').change(function() {
    var balance = parseInt($(this).parent('td').siblings('.total').text());
    var el = $('#total_balance');
    if($(this).prop('checked')) {
      el.text(parseInt(el.text())+balance);
    } else {
      balance = parseInt(el.text())-balance;
      el.text(balance);
    }
    custom();
  });

  function custom() {
    total = parseInt($('#total_balance').text());
    if(total<=0 || total === 'NaN') {
      if(!($('.action a').hasClass('disabled'))) {
        $('.action a').addClass('disabled');
      }      
    } else {
      if($('.action a').hasClass('disabled')) {
        $('.action a').removeClass('disabled');
      }
    }
  }

  $('#ckbCheckAll').click();
    if($('#ckbCheckAll').prop('checked')==true)
    {
      $(".checkBoxClass").prop('checked', $(this).prop('checked'));
      var a=document.getElementsByClassName("checkBoxClass");
      var totalamount=0;
      var checkall=true;
      for(var i=0;i< <?php echo $sn; ?>;i++)
       {
         if(!(a[i]['checked'])){
          a[i]='checked';
         }

          totalamount=totalamount+parseInt(a[i]['value']);
          $('.checkBoxClass').prop('checked',true);
              }
       $('#ckbCheckAll').prop('checked', true);
       
       $('#total_balance').html('<p>'+totalamount+'</p>');
    }


  function calculate(){
    var a=document.getElementsByClassName("checkBoxClass");
    var totalamount=0;
    var checkall=true;
    for(var i=0;i< <?php echo $sn; ?>;i++)
     {
       if(a[i]['checked']==true)
       {

        totalamount=totalamount+parseInt(a[i]['value']);
       }
       else
       {
        checkall=false;

       }
     }
     $('#ckbCheckAll').prop('checked', checkall);
     
     $('#total_balance').html('<p>'+totalamount+'</p>');
  }

  // $(".checkBoxClass").click(function(){
  //   $('#ckbCheckAll').prop('checked', false);
  //   calculate();
  // });

  $("#ckbCheckAll").click(function () {
    $(".checkBoxClass").prop('checked', $(this).prop('checked'));
    calculate();     
  });

   $('.ItemID').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/student_payment_model.php?bill_id="+ItemID,cache:false,success:function(result){
            $(".modal-content").html(result);
        }});
    });

   $('.viewFeeDetails').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/showFeeDetails.php?feetype_id="+ItemID+"&student_id="+studentId+"&payment_type="+paymentType,cache:false,success:function(result){
            $(".modal-content-viewFeeDetails").html(result);
        }});
    });

   $('.addFeeItemId').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/addDeuFee.php?student_id="+ItemID,cache:false,success:function(result){
            $(".modal-content-addFee").html(result);
        }});
    });

   /*$('.editFee').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/editDeuFee.php?bill_id="+ItemID,cache:false,success:function(result){
            $(".modal-content-editFee").html(result);
        }});
    });*/
   /*$('.addPartiFeeItemId').click(function(){

        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/addPartiFeeItemId.php?bill_id="+ItemID+'&className='+classId,cache:false,success:function(result){
            $(".modal-content-addPartFee").html(result);
        }});
    });*/

   /*$('.editPartiFeeItemId').click(function(){

        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/editPartFeeDue.php?bill_id="+ItemID+'&className='+classId,cache:false,success:function(result){
            $(".modal-content-editPartFee").html(result);
        }});
    });*/
   
   $('.submitModal').click(function(){
    var ItemID=$(this).attr('data-whatever');
    $.ajax({url:"../student/submitfee.php?student_id="+ItemID+'&class_id='+classId,cache:false,success:function(result){
      $(".modal-content-submitFee").html(result);
      $('.multiSelectCheck').fSelect();
    }});
   });


});
  


</script> 

 
<script>
  
function printExternal(url) {
    var printWindow = window.open(url, 'Print', '');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}
 var printWindow="";
function create_due_receipt(url){
  
  if (printWindow!="") {
    if(confirm("Print preview tab is already opened.\n Would you like to replace now?")){
      printWindow.close();
      printWindow="";
      showReceipt(url);
      // return;
    }
    else{
      return;
    }
  }
  else{
      showReceipt(url);

  }
}
function showReceipt(url){
  setTimeout(function(){
  printWindow = window.open(url, 'Print', '');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
      printWindow="";

    }, true);
  },1);
}
$(document).mousemove(function(event){
  // $("span").text(event.pageX + ", " + event.pageY);
  // console.log(event.pageX + ", " + event.pageY);
  checkPrintTab();
});
function checkPrintTab(){
  if (printWindow!="") {
    if(confirm("Print preview tab is already opened.\n Would you like to close now?")){
      printWindow.close();
      printWindow="";
      // showReceipt(url);
      return;
    }
    else{
      return;
    }
  }
}


function deleteAddeDue(deleteId){
  if(confirm("Are you want to delete?")){

    $.ajax
    ({
          url: "../student/student_submit_management.php?deleteAddedDueRequest="+deleteId,
          type: "POST",
          contentType: false,
          cache: false,
          processData:false,

          beforeSend : function()
          {
            $("#deleteAddeDueBtn").hide();
          },
          success: function(data)
          {
                console.log(data);

                var result = JSON.parse(data);

                if (result.status == 200) {
                  alert("Due deleted successfully");
                  location.reload();

                }else{
                  alert(result.errormsg);
                  location.reload();
                }
          },
          error: function(data) 
          {
            alert('Sorry Try Again !!'+data);
            location.reload();
          }          
    });
  }
  
}
</script>

</body>
</html>
