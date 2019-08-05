<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');
?>
<?php
 $spname = "";
 $sadmsnno = "";
 $sclass = "";
 $ssec = "";
 $dob = "";
 $sroll = "";
 $sname = "";
 $saddress = "";

 //print_r($nepaliDate);
if(isset($_GET['student_id']))
{
  $student_id = $_GET['student_id'];

  $due_details = json_decode($account->get_total_student_due_by_student_id_status($student_id,1));

  $student_details = json_decode($account->get_student_details_by_sid($student_id));

  $spname = $student_details->spname;
  $sadmsnno = $student_details->sadmsnno;
  $class_id=$student_details->sclass;
  $section_id = $student_details->ssec;
  $class_name = $student_details->class_name;
  $section_name = $student_details->section_name; 
  $dob = $student_details->dob;
  $sroll = $student_details->sroll;
  $sname = $student_details->sname;
  $saddress = $student_details->saddress;
  $spnumber = $student_details->spnumber;
  $payment_type=$student_details->payment_type;
  $status=$student_details->status;
}
?>

<body>

<?php include('../config/navbar.php'); ?>
 
    <section id="main-content">
        <section class="wrapper panel panel-default" style="width:95%;margin:100px 25px 0px;">
             <div class="">

   
<div class="col-md-12">

<div class="col-md-3">

    <div class="card">
      <div class="card-body text-center">
        <img class="card-img-top" src="<?php  if($student_details->simage!=''){ echo "../../uploads/".$fianlsubdomain."/profile_pic/".$student_details->simage; } else { echo "https://learnmoreskill.github.io/important/dummystdmale.png";} ?>" alt="Card image cap" width="150px" height="150px">
        <h5 class="card-title"><a class="btn btn-primary"><?php echo $sname; ?></a></h5>
        <p class="card-text">Address : <?php echo $saddress; ?></p>
      </div>
    </div>
</div>

    <div class="col-md-9">
      <table class="table table-hover table-bio" style="padding-top:6%;">
          <tbody>
            <tr>
              <th scope="row">Father Name :</th>
              <td><?php echo $spname; ?></td>
              <th scope="row">Admission No:</th>
              <td><?php echo $sadmsnno; ?></td>
            </tr>
            <tr>
          <th scope="row">Phone No :</th>
              <td><?php echo $spnumber; ?></td>
              <th scope="row">Class:</th>
              <td><?php echo $class_name; ?> &nbsp <?php echo $section_name; ?></td>
            </tr>
            <tr>
            <th scope="row">Date of Birth :</th>
              <td><?php echo $dob; ?></td>
              <th scope="row">Roll No :</th>
              <td><?php echo $sroll; ?></td>
            </tr>
            <tr>
            <th scope="row">Payment Mode</th>
              <td><?php if($payment_type==0)echo "Monthly"; else echo "Yearly";
               ?></td>
               <th scope="row">Status</th>
               <?php if($status==0) echo "<td style='color:green;'><b><u>ACTIVE<u><b></td>"; elseif($status==1) echo "<td style='color:red;'><b>INACTIVE<b></td>"; elseif($status==2) echo "<td style='color:gold;'><b>PASSED OUT<b></td>"; ?>
            </tr>    
          </tbody>
      </table>
    </div>
  

</div>

<div class="customClass" style="clear: both;">
<div class="col-md-12 container-expensestbl">

<form method="post" id='form'>
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
    $rate = 0;
    $sn++;
    $all_balance = $all_balance + $key->total_balance;

    $rate = (($key->feetype_title=='Tution Fee')? $student_details->tution_fee : (($key->feetype_title=='Bus Fee')? $student_details->bus_fee : (($key->feetype_title=='Hostel Fee')? $student_details->hostel_fee : (($key->feetype_title=='Computer Fee')? $student_details->computer_fee : '') ) ) );


    echo "<tr>
     <td></td>
     <td>".$sn."</td>
     <td>".$key->feetype_title."</td>
     <td>".$rate."</td>
     <td>".$key->total_month."&nbsp&nbsp<a class='viewFeeDetails' href='#viewFeeDetails' data-toggle='modal' data-whatever='".$key->feetype_id."'><i class='glyphicon glyphicon-info-sign' style='color:black;' ></i></a></td>

     <td class='total'>".$key->total_balance."</td>
     <td>Pending</td>
    </tr>";

  }
  echo "<tr>
    <td></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Total Balance </td>
    <td id='total_balance'> $all_balance </td>
    <td class='action'><a class='btn btn-success btn-block submitModal' style='color:#fff;' data-target='.bd-example-modal-lg' data-whatever='".$student_id."'><i class='glyphicon glyphicon-eye-open' style='color:white;'></i> Pay</a></td>

    </tr>";
}   
?>
 
  </tbody>
  
</table>
</form>
</div>

<?php 
//$bill_print_id = $account->add_into_bill_tables($bill_number, $date, $print_count, $t_role , $t_id);


//$addToTransactionCredit = $account->insert_into_student_transaction(1 , $bill_print_id , $std_id , 0 , $credit , 0 , $advance , 0 , 0 , $payment_mode , $payment_number , $payment_source , $payment_by , $date , $description);

//$addToTransactionDebit = $account->insert_into_student_transaction(0 , $bill_print_id , $std_id , $student_due_id , 0 , $debit , $advance , $discount , $fine , 0 , '' , '' , '' , $date , $description);

//$advanceAmount = $account->get_advance_amount_from_student_transaction_by_student_id(1);


//$updateCount = $account->update_bill_tables_increment_print_count_by_bill_id($bill_id);

//echo "Count:".$updateCount."<br>";


//$bill_details = json_decode($account->get_bill_details_by_bill_number('Gt-120'));
//echo $bill_details->bill_number;


//$debit_transaction_details = json_decode($account->get_debit_student_transaction_list_by_bill_id(2));

//$credit_transaction_details = json_decode($account->get_credit_student_transaction_list_by_bill_id(2));




  // foreach ($credit_transaction_details as $key) {
  //   echo $key->credit;
  // }















 ?>
</div>
        </section>
    </section>

</section>



<div id="submitFee" class="modal fade bd-example-modal-lg" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog modal-lg">
          <div class="modal-content-submitFee" style='background-color: #fff;border-radius: 10px;'>
          </div>
    </div>
</div>


<div id="viewFeeDetails" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
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

<div id="addPartFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
  <div class="modal-dialog ">
      <div class="modal-content-addPartFee" style='background-color: #fff;border-radius: 10px;'>

      </div>
  </div>
</div>

<div id="editPartFee" class="modal fade " aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog ">
        <div class="modal-content-editPartFee" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div>
<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>
    
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
    <script src="../assets/js/sparkline-chart.js"></script>    
    <script src="../assets/js/zabuto_calendar.js"></script>

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


  function calculate()
  {
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

   
   $('.submitModal').click(function(){
    var ItemID=$(this).attr('data-whatever');
    $.ajax({url:"../student/submitfee.php?student_id="+ItemID+'&class_id='+classId,cache:false,success:function(result){
      $(".modal-content-submitFee").html(result);
    }});
   });


});
  


</script>
 
<script>
  
function printExternal(url) 
{
    var printWindow = window.open(url, 'Print', '');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}
 var printWindow="";
function create_due_receipt(url)
{
  
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
</script>
</body>
</html>
