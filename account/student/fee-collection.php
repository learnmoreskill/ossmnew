<?php include('../session.php'); ?>
<!DOCTYPE html>
<html lang="en">
<?php
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
 $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$_GET['student_id']));
 $student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));
 $student_id = $_GET['student_id'];
 $spname = $student_details->spname;
 $sadmsnno = $student_details->sadmsnno;
 $sclassid=$student_details->sclass;
 $sclass = $account->get_student_class_name_by_id($student_details->sclass);
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

<body>

<?php include('../config/navbar.php'); ?>
 
    <section id="main-content">
        <section class="wrapper panel panel-default" style="width:95%;margin:100px 25px 0px;">
             <div class="">

   
<div class="col-md-12">

<div class="col-md-3">

    <div class="card">
      <div class="card-body text-center">
        <img class="card-img-top" src="<?php  if($student_details->simage!=''){ echo "../../uploads/profile_pic/".$student_details->simage; } else { echo "https://learnmoreskill.github.io/important/dummystdmale.png";} ?>" alt="Card image cap" width="150px" height="150px">
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
              <td><?php echo $sclass; ?> &nbsp <?php echo $account->get_section_name_by_section_id($ssec); ?></td>
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
               <?php if($status==0) echo "<td style='color:green;'><b><u>ACTIVE<u><b></td>"; elseif($status==1) echo "<td style='color:red;'><b>IACTIVE<b></td>"; elseif($status==2) echo "<td style='color:gold;'><b>PASSED OUTt<b></td>"; ?>
            </tr>    
          </tbody>
      </table>
    </div>
  <div class="col-md-12">
        <?php
        $url = "./layouts/view_print.php";
        echo "<a href='../student/view-invoice.php?student_id=".$student_id."' class='btn btn-danger' style='color:#fff;float:right;'  data-toggle='tooltip' title='' data-original-title='Edit'> 
          <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>View Invoice</span></a>
          ";
          ?>

          <!-- <a onclick="printExternal('../student/payment_bill.php?student_id=<?php echo $student_id; ?>')" class='btn btn-danger' style='color:#fff;margin-right:10px;float: right;'  title='Print'> 
          <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>Print</span></a>
 -->
          <a href='../student/fee-statement.php?student_id=<?php echo $student_id; ?>' class='btn btn-danger' style='color:#fff;margin-right:10px;float: right;'  title='Print'> 
          <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>Statement</span></a>

          <a class='btn btn-danger addFeeItemId' style='color:#fff;margin-right:10px;float: right;' href='#addFee' data-toggle='modal' data-whatever='<?php echo $student_id; ?>'><i class='fa fa-list-ol' aria-hidden='true'></i></i> Add Old Due</a>

          <a onclick="create_due_receipt('../student/create_receipt_by_single_student.php?studentId=<?php echo $student_id; ?>')" class='btn btn-danger' style='color:#fff;margin-right:10px;float: right;'  title='Print'>
            Create Due Receipt
          </a> 
     
  </div>

</div>

<div class="customClass">
<div class="col-md-12 container-expensestbl">

<form method="post" id='form'>
 <table class="table table-dark" >
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">SN</th>
      <th scope="col">Fees Category</th>
      
      <th scope="col"><?php if($payment_type==0) echo "Month"; else echo "Year";?></th>
      <th scope="col"><?php if($payment_type==0) echo "Rate Per Month"; else echo "Rate Per Year";?></th>
      
      <th scope="col">Amount</th>
      <th scope="col">Due Date</th>
      <th scope="col">Status</th>
    </tr>
  </thead>

  <tbody>


<?php
$sn=0;
if(isset($_GET['student_id']))
{
   $total_balance = 0;
   foreach ($pending_details as $key) 
   {
    $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
    $last_payment_date=$key->last_payment_date;

    $dateFnxn = new NepaliDate();

    $last_paid_month = explode('-',$last_payment_date)[1];
    

    // $last_paid_month=date("$nepaliDate->nmonth",strtotime($testval1));
    //$testval1=$account->get_nepali_month($last_paid_month);


    $pending_month_start=substr($dateFnxn->get_nepali_month($last_paid_month+1),0,3);
    

    $this_month=$nepaliDate->nmonth;

    $pending_month_end=substr($dateFnxn->get_nepali_month($this_month), 0, 3);
    
    if($feetype=='Tution Fee' || $feetype=='Hostel Fee' || $feetype=='Bus Fee'|| $feetype=='Computer Fee')
    {
      if($this_month<$last_paid_month)
      {
        $this_month = $this_month+12;
        
        if($key->status=='Advance')
        {
          $due_month = ($last_paid_month+12)-$this_month;
        }
        else
        {
          $due_month = ($last_paid_month+12)-$this_month;
        }
        $due_month = $due_month ." Months";
      }
      else
      {
        $due_month = $this_month-$last_paid_month;
        $due_month = $due_month ." Months";
      }

    }
    else
    {
      $due_month = "Null";
    }
    $sn++;
   
    $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
    $balance = $key->balance;
    $balance = preg_replace("/[^0-9]/", "", $balance);
    $a=str_replace('_', ' ',$feetype);
    if(ucwords($a) =='Tution Fee' ||ucwords($a) =='Hostel Fee' ||ucwords($a) =='Computer Fee' ||ucwords($a) =='Bus Fee') {
      $a=str_replace(' ', '_',$feetype);
      // echo $sclass.$a.$student_id;
      $rate=$account->get_fee_rate_by_class_and_feetype_title($sclassid,$a,$student_id);
      // echo "class=".$sclass."feetype=".$a."student id=".$student_id;
    }
    else { 
      $rate=0;
      //$balance = $pending_details->;
    }

    if (($this_month-$last_paid_month)==0) { $monthdiff="clear"; }else{ $monthdiff=$pending_month_start."-".$pending_month_end; }
    //$balance = $rate * ($this_month-$last_paid_month + 1);
    $total_balance = $total_balance + $balance;
    $status=$key->status;
    if($payment_type!=0 && $monthdiff=="clear"){
      $status="paid";
    }
     echo "<tr>
     <td style='display:none'><input checked id='checkbox".$key->bill_id."' class='checkBoxClass' value='".$key->balance."' type='checkbox' name='checkbox".$key->bill_id."'/>
     </td>
     <td></td>
     <td>".$sn."</td>
     <td>".$feetype."</td>
     <td>".$monthdiff."</td>
     <td>".$rate."</td>
     <td class='total'>".$balance."</td>
     <td>".($due_month)."</td>
     <td>".$status." </td>
    </tr>";
    }
    echo "<tr>
    <td></td>
    <td style='display:none'><input checked type='checkbox' id='ckbCheckAll' /></td>
    <td></td>
    <td></td>
    <td></td>
    <td>Total Balance </td>
    <td id='total_balance'> $total_balance </td>
    <td></td>
    <td class='action'><a class='btn btn-danger submitModal' style='color:#fff;' data-target='.bd-example-modal-lg' data-whatever='".$student_id."'><i class='glyphicon glyphicon-eye-open' style='color:white;'></i> Pay</a></td>
    <td class='action'>
             <a class='btn btn-danger addPartiFeeItemId' style='color:#fff;' data-target='#addPartFee' data-whatever='".$key->bill_id."'><i class='glyphicon glyphicon-eye-open' style='color:white;'></i> Add Due</a>
            </td>

<td class='action'>
             <a class='btn btn-danger editPartiFeeItemId' style='color:#fff;' data-target='#editPartFee' data-whatever='".$key->bill_id."'><i class='glyphicon glyphicon-eye-open' style='color:white;'></i> Edit Due</a>
            </td>

    </tr>";

     
}   
?>
 
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
    <div class="modal-dialog modal-lg">
          <div class="modal-content-submitFee" style='background-color: #fff;border-radius: 10px;'>
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

   $('.addFeeItemId').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/addDeuFee.php?student_id="+ItemID,cache:false,success:function(result){
            $(".modal-content-addFee").html(result);
        }});
    });

   $('.editFee').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/editDeuFee.php?bill_id="+ItemID,cache:false,success:function(result){
            $(".modal-content-editFee").html(result);
        }});
    });
   $('.addPartiFeeItemId').click(function(){

        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/addPartiFeeItemId.php?bill_id="+ItemID+'&className='+className,cache:false,success:function(result){
            $(".modal-content-addPartFee").html(result);
        }});
    });

   $('.editPartiFeeItemId').click(function(){

        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../student/editPartFeeDue.php?bill_id="+ItemID+'&className='+className,cache:false,success:function(result){
            $(".modal-content-editPartFee").html(result);
        }});
    });
   
   $('.submitModal').click(function(){

    var ItemID=$(this).attr('data-whatever');
    $.ajax({url:"../student/submitfee.php?student_id="+ItemID+'&className='+className,cache:false,success:function(result){
      $(".modal-content-submitFee").html(result);
    }});
   });
});
  


</script>
 
<script>
  var className = '<?php echo $sclass ?>';
  //alert(className);
function printExternal(url) 
{
    var printWindow = window.open(url, 'Print', '');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}

function create_due_receipt(url)
{
  var printWindow = window.open(url, 'Print', '');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}
</script>
</body>
</html>
