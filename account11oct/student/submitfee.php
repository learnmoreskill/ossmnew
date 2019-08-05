
<?php
require("../account_management.php");
require("../nepaliDate.php");
$account = new account_management_classes();
//$feetype_details = json_decode($account->get_feetype_details());
if(isset($_REQUEST['student_id']))
 {
 $student_id = $_REQUEST['student_id'];
 $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$_GET['student_id']));
 $student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));
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
<script type="text/javascript">
  $(document).ready(function() {
   
   $(".discountclass").on('input',function(){
      var a=$(this).val();
      if((a)<=0 || isNaN(a)){
      alert("not a valid Number");
      $(".discountclass").val("");
      }
     
   });
});
</script>
<div onload="check();" class="modal-body" style="padding: 0;">
       <form id='form2' method='post'  name="insert_fee_record" enctype="multipart/form-data">
        <div class="modal-header" style="padding: 10px;border: 0px;">  
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                 <h4 class="modal-title">
                 <i class="glyphicon glyphicon-user"></i>Submit Fee 
                 </h4> 
          </div> 


          <div class="customClass">
<div class="col-md-12 container-expensestbl">
 <table class="table table-dark table-responsive">
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">SN</th>
      <th scope="col">Fees Category</th>
      <th scope="col">Month </th>
      <th scope="col">Rate Per Month</th>
      <th scope="col">Amount</th>
      <th scope="col">Due Date</th>
      <th scope="col">Status</th>
      <th scope="col">Discount</th>
      <th scope="col">Discription</th>
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
      $rate=$account->get_fee_rate_by_class_and_feetype_title($sclass,$a,$student_id);
    }
    else { 
      $rate=0;
      //$balance = $pending_details->;
    }

    if (($this_month-$last_paid_month)==0) { $monthdiff="clear"; }else{ $monthdiff=$pending_month_start."-".$pending_month_end; }
    //$balance = $rate * ($this_month-$last_paid_month + 1);
    $total_balance = $total_balance + $balance;    

     echo "<tr> 
     <td><input id='checkbox1".$key->bill_id."' class='checkBoxClass1' value='".$key->balance."' type='checkbox' name='checkbox".$key->bill_id."'/>
     </td>
     <td>".$sn."</td>
     <td>".$feetype."</td>
     <td>".$monthdiff."</td>
     <td>".$rate."</td>
     <td>".$balance."</td>
     <td>".$new_month."</td>
     <td>".$key->status." </td>
     <td><input type='number' id='discount".$key->bill_id."' class='discountclass' name='discount".$key->bill_id."' onblur='discountCalculate()'></td>
     <td><input type='text' id='discription".$key->bill_id."' class='discriptionclass' name='discription".$key->bill_id."'></td>
     ";

     echo "
    </tr>";
    }
    echo "<tr>
    <td><input type='checkbox' id='ckbCheckAll1' />Check All</td>
    <td></td>
    <td>Total Balance </td>
    <td></td>
    <td></td>
    <td id='total_balance1' class='col-offset-5'>0</td>
    <td>Paid By:</td>
    <td><input name='paidby' type='text' id='paidby'/></td>
    <td></td>
    <td></td>
    <td></td>
    </tr>";

     
}   
?>
 
</tbody>  
</table>

</div>
</div>
        
<div class="modal-footer"> 
    <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:left; background-color:red;    border-color: #d43f3a; color:#fff;">Close</button>  
    <input type="submit" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;" value="Save">
</div> 
</form>
</div>




<!-- <script>
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

</script> -->

 <?php
echo"
<script type='text/javascript'>
  $(document).ready(function(){

    var total_balance = 0;
    ";
  $total_balance = 0;
  $sn =0;
  $a=0;

  foreach ($pending_details as $key) 
  {
    $sn++;
    $bill_id = $key->bill_id;
    $checkbox_id = "checkbox".$bill_id;
    $a=$bill_id;
    echo"
    var checkbox_id".$sn." ='#".$checkbox_id."';

     $(checkbox_id".$sn.").click(function() {
      var balance = $(checkbox_id".$sn.").val();
      balance = parseInt(balance);
      if($(checkbox_id".$sn.").is(':checked')) 
      {
        total_balance = total_balance + balance;
        $('#total_balance1').html('<p>'+total_balance+'</p>');
      }
      else
      {
        total_balance = total_balance - balance;
        $('#total_balance1').html('<p>'+total_balance+'</p>');
      } 
      ";

   echo "});
  ";
  }
  echo"});
</script>";
?>



<script type="text/javascript">
   

  var finaltotal=0;
    var a=document.getElementsByClassName("checkBoxClass1");
    
$(document).ready(function()
{
 
  
  $('#ckbCheckAll1').click();

  if($('#ckbCheckAll1').prop('checked')==true)
  {
    $(".checkBoxClass1").prop('checked', $(this).prop('checked'));
    var a=document.getElementsByClassName("checkBoxClass1");
    var totalamount=0;
    var checkall=true;
    for(var i=0;i< <?php echo $sn; ?>;i++)
     {
       if(!(a[i]['checked'])){
        a[i]='checked';
       }

        totalamount=totalamount+parseInt(a[i]['value']);
        finaltotal=totalamount;
        $('.checkBoxClass1').prop('checked',true);
            }
     $('#ckbCheckAll1').prop('checked', true);
     
     $('#total_balance1').html('<p>'+totalamount+'</p>');
    // check();

  }


  function calculate()
  {
    var totalamount=0;
    finaltotal=0;
    var checkall=true;
    for(var i=0;i< <?php echo $sn; ?>;i++)
     {
       if(a[i]['checked']==true)
       {
        totalamount=totalamount+parseInt(a[i]['value']);
        finaltotal=totalamount;
       }
       else
       {
        checkall=false;
       }
     }
     //debugger;

     $('#ckbCheckAll1').prop('checked', checkall);
     
     $('#total_balance1').html('<p>'+totalamount+'</p>');
     // check();
  }

  $(".checkBoxClass1").click(function(){
    $('#ckbCheckAll1').prop('checked', false);
    calculate();
    discountCalculate();
    // check();

  });

  $("#ckbCheckAll1").click(function () {
    //alert("alert");
    $(".checkBoxClass1  ").prop('checked', 
      $(this).prop('checked'));
    calculate();
    discountCalculate();
    // check();
     
  });
});


function discountCalculate(){
      //alert(finaltotal);
      // var arraydiscount=parseInt(event.target.value);
      // if(!arraydiscount){
      //   return;
      // }
      // newtotal=newtotal-arraydiscount;

      var arraydiscount=document.getElementsByClassName('discountclass');
      var arraydiscription=document.getElementsByClassName('discriptionclass');

      var newtotal=finaltotal;debugger;
      //console.log(arraydiscount);
      for(var i=0;i< <?php echo $sn; ?> ;i++){
       if(a[i]['checked']==true)
       {
         if(arraydiscount[i]['value']=='')
        {
        newtotal=newtotal+0;
        }
        else
        {
          newtotal=newtotal-parseInt(arraydiscount[i]['value']);
          
          //console.log(arraydiscription[i]['value']);
          // debugger;
        }
        
        }
       }
      $('#total_balance1').html('<p>'+newtotal+'</p>');
      check();
}
  

</script>
<!-- check value AND DISABLE SAVE BUTTON IN THE TOTAL AMOUNT IS INVALID-->
<script type="text/javascript">
  function check()
  {
    var a=$('#total_balance1').html();
    var a=a.replace(/^[\<p>]+|[\</p>]+$/g, "");
     // alert(a);
    if(a==0 || a<0)
    {
    $(':input[type="submit"]').prop('disabled', true); 
    }
    else
    {
    $(':input[type="submit"]').prop('disabled', false); 

    }
  }
</script>>

<script>
  var student_id = <?php echo $student_id ?>;
$(document).ready(function (e) 
{

  $("#form2").on('submit',(function(e) 
  {
    e.preventDefault();
    debugger;
    $.ajax
    ({
          url: "../student/student_submit_management.php?student_id="+student_id,
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
            if(data=='Sucessfully Insert Payment Record !!');
            {
              alert(data);
              var a=confirm("do you want to print the receipt as well?");
              if(a){
                printExternal('../student/payment_bill.php?student_id=<?php echo $student_id; ?>');
                location.reload();
              }
              else
              {
              
              location.reload();

              }
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  
});

</script>
<!-- ADDED TO CHECK WETHER THE TOTAL FEE IS VALID OR NOT IN THE LOADING OF THE MODAL -->
<script type="text/javascript">
  window.onload=check();
</script>