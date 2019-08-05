<?php
include('../session.php');
include('../load_backstage.php'); 

if(isset($_REQUEST['student_id']))
 {
 $student_id = $_REQUEST['student_id'];

 $due_details = json_decode($account->get_total_student_due_by_student_id_status($student_id,1));

 //$pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$_GET['student_id']));
 $student_details = json_decode($account->get_student_details_by_sid($student_id));

 $advanceAmount = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);
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
      // alert("not a valid Number");
      // $(".discountclass").val("");
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
 <table class="table table-dark table-responsive no-margin" >
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">SN</th>
      <th scope="col">Fees Category</th>
      <th scope="col">Rate Per Month</th>
      <th scope="col">Due Month </th>
      <th scope="col">Amount</th>
      <th scope="col">Discount</th>
      <th scope="col">Fine</th>
      <th scope="col">Description</th>
    </tr>
  </thead>

  <tbody>


<?php
$sn=0;
if(isset($_GET['student_id']))
{
   $total_balance = 0;
   $all_balance = 0;
   foreach ($due_details as $key) 
   {

    $rate = 0;
    $sn++;
    $all_balance = $all_balance + $key->total_balance;

    $rate = (($key->feetype_title=='Tution Fee')? $student_details->tution_fee : (($key->feetype_title=='Bus Fee')? $student_details->bus_fee : (($key->feetype_title=='Hostel Fee')? $student_details->hostel_fee : (($key->feetype_title=='Computer Fee')? $student_details->computer_fee : '') ) ) );

    //=============================


        /*$feetype = $key->feetype_title;

        $last_payment_date='2074-05-05';
        $dateFnxn = new NepaliDate();
        $last_paid_month = explode('-',$last_payment_date)[1];
        
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
       
        $feetype = $key->feetype_title;
        $balance = $key->total_balance;
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
*/
    ?>

    <tr> 
     <td><input id='checkbox1<?php echo $key->id; ?>' class='checkBoxClass1' value='<?php echo $key->total_balance; ?>' type='checkbox' onchange="clearSelected(this,'<?php echo $key->feetype_id; ?>')" name='<?php echo $key->feetype_id; ?>' />
     </td>
     <td><?php echo $sn; ?></td>
     <td><?php echo $key->feetype_title; ?></td>
     <td><?php echo $rate; ?></td>
     <td style='width:80px;position:relative'>
     <div class='' id='<?php echo $key->feetype_id; ?>block'></div>
     <select class='multiSelectCheck' multiple='multiple' id='<?php echo $key->feetype_id; ?>'  name='<?php echo $key->feetype_id; ?>' onchange="multicheckBoxChanged(this,<?php echo $sn; ?>,<?php echo (!empty($rate)? $rate : 1);?>,'<?php echo $key->feetype_id?>','total<?php echo $key->feetype_id; ?>')">

      <?php $due_type_details = json_decode($account->get_due_type_details_by_feetype_id_student_id_status($key->feetype_id,$student_id,1)); 

        $total = 0;
        $yearMonth = '';

        foreach ($due_type_details as $key1){

          $total +=$key1->balance;

          list($bs_year, $bs_month, $bs_day) = explode('-', $key1->date);
          $dateFnxn = new NepaliDate();
          if ($payment_type) {
            $yearMonth  = $bs_year;
          }else{
            $yearMonth=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.")";
          } ?>

            <option value='<?php echo $key1->id; ?>' selected data-value='<?php echo $key1->balance; ?>'><?php echo $yearMonth; ?></option>

      <?php } ?>



    </select></td>
     
     <td class='totalCatBalance' id='total<?php echo $key->feetype_id; ?>' value='<?php echo $key->feetype_id; ?>' ></td>
    <td><input type='number' id='discount<?php echo $key->id; ?>' class='discountclass' name='discount<?php echo $key->feetype_id; ?>' onkeyup='discountCalculate()' min='0' value='0'></td>
     <td><input type='number' id='fine<?php echo $key->id; ?>' class='fineclass' name='fine<?php echo $key->feetype_id; ?>' onkeyup='discountCalculate()' min='0' value='0'></td>
     <td><input type='text' id='description<?php echo $key->id; ?>' class='descriptionclass' name='description<?php echo $key->feetype_id; ?>'></td>
    
    </tr>
    <?php } ?>
    <tr class='active '>
      <td colspan='3'><input type='checkbox' id='ckbCheckAll1'/>Check All</td>
      <th colspan='2'>Total </th>
      <td id='total_balance1' class=''>0</td>
      <td id='total_discount'>0</td>
      <td id='total_fine'>0</td>      
      <td></td>
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
              <div class=' row'>
                <label for='advance' class='col-sm-4 col-form-label' style='margin-top: 8px'>Amount to pay:</label>
                <div class='col-sm-6'>
                  <input type='number' class='form-control' id='grandPay' name='advance' disabled>
                </div>
              </div>
            </td>
            <td colspan='5'>
              <div class=' row'>
               <h4 class='text-info  col-sm-6'>Advance Deposited: <span id='advanceAmnt' class='font-weight-bold'><?php echo ((!empty($advanceAmount))? $advanceAmount : 0); ?></span></h4>
                <h4 class='text-danger  col-sm-6'>Due to be paid: <span id='payebalBalance' class='font-weight-bold'></span></h4>
               
              </div>
            </td>

          </tr>
          <tr>
            <td colspan='6'>
              <div class='row'>
               <label for='advance' class='col-sm-4 col-form-label' style='margin-top: 8px'>Received from:</label>
                <div class='col-sm-6'>
                  <input name='paidby' type='text' id='paidby' class='form-control' required autofocus />
                </div>
              </div>
            </td>
             <td colspan='5'>
              <div class=' row'>
                 <h4 class='col-sm-6 text-info'>Advance remains:<span class='font-weight-bold' id='advanceRemain'></span>
                </h4>
                <h4 class='col-sm-6 text-success'>Total payable:<span class='font-weight-bold' id='grandTotal'></span>
                </h4>
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
<!-- test -->
<!-- <div>
    <form name="testForm" id="testForm">
        <select class="multiSelectCheck" multiple="multiple" id="monthSelect" name="month">
            <optgroup label="Group A">
                <option value="1">Option 1</option>
                <option value="2" selected>Option 2</option>
                <option value="3">Option 3</option>
                <option value="4" disabled>Manège</option>
                <option value="5">Bête</option>
            </optgroup>
            <optgroup label="Group B">
                <option value="6" selected>Option 6</option>
                <option value="7">Option 7</option>
                <option value="8">Option 8</option>
                <option value="9">Mécanique</option>
            </optgroup>
        </select>
         <select class="multiSelectCheck" multiple="multiple"  name="program">
                <option value="c">c</option>
                <option value="c++" selected>c++</option>
                <option value="java">java</option>
                <option value="rProgram" disabled>rProgram</option>
                <option value="python">python</option>
        </select>
        <button type="submit">submit</button>
    </form>
    <button onclick="callTest()"> test now  </button>
</div> -->




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

  foreach ($due_details as $key) 
  {
    $sn++;
    $id = $key->id;
    $checkbox_id = "checkbox".$id;
    $a=$id;
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
    // var activeMonths=new Array();
    var activeMonths={};
    var advanceAmnt=parseInt(document.getElementById("advanceAmnt").innerHTML);
$(document).ready(function()
{
 
   if($('#ckbCheckAll1').prop('checked')==false){
      $('#ckbCheckAll1').click();
      // $('.checkBoxClass1').prop('checked',true);
   }
  

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
        // $("#"+a[i].id).trigger("change");
       }

        totalamount=totalamount+parseInt(a[i]['value']);
        finaltotal=totalamount;
        $('.checkBoxClass1').prop('checked',true);
            }
     $('#ckbCheckAll1').prop('checked', true);
     
     $('#total_balance1').html('<p>'+totalamount+'cl</p>');
    // check();

  }

  // $(".checkBoxClass1").click(function(e){
  //   $('#ckbCheckAll1').prop('checked', false);
  
  //   calculate();
  //   discountCalculate();
  //   // check();

  // });

  $("#ckbCheckAll1").click(function () {
    //alert("alert");
    $(".checkBoxClass1  ").prop('checked', 
      $(this).prop('checked'));
      clearCatTotal();
      calculate();
      discountCalculate();
    // check();
     
  });
});
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
     

     $('#ckbCheckAll1').prop('checked', checkall);
     
     $('#total_balance1').html('<p>'+totalamount+'</p>');
      $('#payebalBalance').html(totalamount);

      if (totalamount<0) {alert('Discount is more than payable fee, Please check!!');}
      
      updateGrandTotal(totalamount);
     // if (totalamount<=0) {
     //  disableBtn();
     // }
     // else{
     //  enableBtn();
     // }
     
     // check();
  }
  function updateGrandTotal(amnt){
    var gt=amnt - advanceAmnt;
    if(gt<=0){
      $('#advanceRemain').text(" "+advanceAmnt-amnt);
      $('#grandTotal').text("0");
      $("#grandPay").val(0);
    }
    else{
      $('#advanceRemain').text("0");
      $('#grandTotal').text(" "+amnt - advanceAmnt);
      $("#grandPay").val(amnt - advanceAmnt);
      
      }
    }
    function disableBtn() {
        document.getElementById("payBtn").disabled = true;
    }

    function enableBtn() {
        document.getElementById("payBtn").disabled = false;
    }
    function discountCalculate(){
      //alert(finaltotal);
      // var arraydiscount=parseInt(event.target.value);
      // if(!arraydiscount){
      //   return;
      // }
      // newtotal=newtotal-arraydiscount;

      var arraydiscount=document.getElementsByClassName('discountclass');
      var arraydescription=document.getElementsByClassName('descriptionclass');
      var arrayfine=document.getElementsByClassName('fineclass');

      var newtotal=finaltotal;
      var totalDis=0;
      var totalFine=0;
      //console.log(arraydiscount);
      for(var i=0;i< <?php echo $sn; ?> ;i++){
       if(a[i]['checked']==true)
       {
        var fine=parseInt(arrayfine[i]['value']==''?0:arrayfine[i]['value']);
         if(arraydiscount[i]['value']=='')
        {
        newtotal=newtotal+0;
        }
        else
        {
          newtotal=newtotal-parseInt(arraydiscount[i]['value'])+fine;
          totalDis += parseInt(arraydiscount[i]['value']);
          totalFine+=fine;
          //console.log(arraydescription[i]['value']);
          
        }
        
        }
       }
      $('#total_discount').html(totalDis);
      $('#total_fine').html(totalFine);

      // $('#total_balance1').html('<p>'+newtotal+'</p>');
      $('#payebalBalance').html(newtotal);

      if (newtotal<0) {alert('Discount is more than payable fee, Please check!!');}

      updateGrandTotal(newtotal);
      check();
      // if (newtotal<=0) {
      //   disableBtn();
      //  }
      //  else{
      //   enableBtn();
      //  }
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
</script>

<script>
  var student_id = <?php echo $student_id ?>;
$(document).ready(function (e) 
{  
  $("#form2").on('submit',(function(e) 
  {
    
    var bal=parseInt(document.getElementById('payebalBalance').innerHTML);

    if (bal<0) {alert('Discount is more than payable fee, Please check!!');
    e.preventDefault();
    return;}
     var a=document.getElementsByClassName("checkBoxClass1");
    var chkBoxStatus=[];
    
    var t='';
    for(var i=0;i< a.length;i++)
     {
       if(a[i]['checked']){
      
        chkBoxStatus.push(a[i].name);
      }
    }
    var formObj = {};
    var inputs = $('#form2').serializeArray();
    var gt=$('#grandTotal').text();
    $.each(inputs, function (i, input) {
      if(formObj.hasOwnProperty(input.name)){
        
        if (formObj[input.name] instanceof Array) {
          formObj[input.name].push(input.value);
        }
        else{
          formObj[input.name] = [formObj[input.name],input.value];
        }
      }
      else{
        formObj[input.name] = input.value;

      }
    });
    console.log(formObj);
    // return;
    e.preventDefault();
     var frmData=new FormData(this);

    frmData.append("activeFee",JSON.stringify(chkBoxStatus));
    frmData.append("activeMonths",JSON.stringify(activeMonths));
    frmData.append("payableAmount",gt);

    frmData.append("advanceBefore",parseInt(document.getElementById('advanceAmnt').innerHTML));
    frmData.append("advanceAfter",parseInt(document.getElementById('advanceRemain').innerHTML));
    frmData.append("totalBalance",parseInt(document.getElementById('total_balance').innerHTML));
    frmData.append("totalPaidBalance",parseInt(document.getElementById('total_balance1').childNodes[0].innerHTML));

    //formData.append("advanceBefore",parseInt(document.getElementById('advanceAmnt').innerHTML));
    //formData.append("advanceBefore",parseInt(document.getElementById('advanceAmnt').innerHTML));
//debugger;
    // console.log("form data",frmData);
    formObj['activeFee']=chkBoxStatus;
    

    $.ajax
    ({
          url: "../student/student_submit_management.php?submit_fee="+student_id,
          type: "POST",
          data:  frmData,
          // data:  JSON.stringify(formObj),

          contentType: false,
          cache: false,
          processData:false,

          beforeSend : function()
          {
          
            $("#err").fadeOut();
            $("#payBtn").hide();
            $("#loadingBtn").show();
          },
          success: function(data)
          {
            debugger;
                console.log(data);

                var result = JSON.parse(data);

                if (result.status == 200) {
                  
                
                  // var t=document.getElementById('advPaid');
                  // var tp = document.getElementById('total_payable');

                  // var total_payable=parseInt(tp.innerHTML);

                  // var aap=parseInt(t.innerHTML);
                  // var acp=parseInt(document.getElementById('advAmount').value);


                  // var pAmnt=parseInt(t.innerHTML);

                  // t.innerHTML=(aap+acp);

                  // tp.innerHTML = (parseInt(tp.innerHTML)-acp);


                  //$('#advancePayModal').modal('hide');
                  //document.getElementById("advPayForm").reset();
                  //$("#advPayment_ref").empty();


                  var a=confirm("Payment successfully done.\nDo you want to print the receipt as well?");
                  if(a){
                    //printExternal('../student/payment_bill.php?student_id=<?php echo $student_id; ?>&bill_id='+result.bill_id);
                    printExternal('../school/bill_print_format_student.php?type=student&student_id=<?php echo $student_id; ?>&bill_id='+result.bill_id);
                    location.reload();
                  }else{
                    location.reload();
                  }

                }else{
                  alert(result.errormsg);
                }
            //alert(data.trim());
            // if(data.trim() === 'Sucessfully Insert Payment Record !!'.trim());
            // {
            //   alert(data);
            //   var a=confirm("do you want to print the receipt as well?");
            //   if(a){
            //     printExternal('../student/payment_bill.php?student_id=<?php echo $student_id; ?>');
            //     location.reload();
            //   }
            //   else
            //   {
              
            //   location.reload();

            //   }
            // }
            $("#payBtn").show();
            $("#loadingBtn").hide();
          },
          error: function(e) 
          {
          	$("#payBtn").show();
            $("#loadingBtn").hide();
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

<script>
$(document).ready(function(){
    $('#monthSelect').on('change',function(){
        var optionValue = $(this).val();
        var optionText1 = $('#monthSelect option[value="'+optionValue+'"]').text();
        var optionText = $("#monthSelect option:selected").text();
        
        // alert("Selected Option Text: "+optionText);
    });
    // $( "#testForm" ).submit(function( event ) {
    //   console.log( $( this ).serializeArray() );
    
    //   event.preventDefault();
    // });
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
function clearCatTotal(){
      var a=document.getElementsByClassName("checkBoxClass1");
    var totalamount=0;
    var checkall=true;
    for(var i=0;i< <?php echo $sn; ?>;i++)
     {
        $("#"+a[i].id).trigger("change");

       // if(!(a[i]['checked'])){
       //  a[i]='checked';
       
       //  // $("#"+a[i].id).trigger("change");
       // }
    }
  }
  function multicheckBoxChanged(e,sn,rate,selId,balanceId){
        // var data=$('#testForm').serialize();
        // console.log(data);
         var optionValue = $(e).val();
          // var activeMonth=[];
          var actId=a[sn-1].name;
          // var obj={};
          // obj[actId]=optionValue;
            if(a[sn-1]['checked']==true)
          {

            // activeMonths[i]={};
            activeMonths['month'+actId]=optionValue;
          }
          
          sampleAmount = $('#'+selId+' option:selected').data("value");

          var selected = $(e).find('option:selected', e);
          var balance=0;
          selected.each(function() {
              balance +=$(this).data('value');
          });
          // var availble_text = selected.data('value');
        

         // var tb=rate*optionValue.length;
         var doc=document.getElementById(balanceId);
         doc.innerHTML=balance;
          a[sn-1].value=balance;
         // doc.val(balance);
         // for(var i=0;i< <?php echo $sn; ?>;i++)
         // {
          if(a[sn-1]['checked']==false)
          {
            doc.innerHTML=0;
          }
          
          

          calculate();
        // }
        // var optionText1 = $('#monthSelect option[value="'+optionValue+'"]').text();
        // var optionText = $("#monthSelect option:selected").text();
        
        // alert("Selected Option Text: "+optionText);
    }
 
  function blockDropDown(id){
      // alert("hi");
     var element = document.getElementById(id+'block');
      element.classList.toggle("blockedDropdown");
      // $('[id=`'+id+'block`]').toggleClass('blockedDropdown');

    }
  function clearSelected(e,id){
    var doc=document.getElementById('total'+id);
     if($(e).is(':checked')){
             // alert('checked');
           doc.innerHTML=e.value;
       }
    else
      {
        doc.innerHTML=0;
      }
    blockDropDown(id);
    calculate();
    discountCalculate();
  }


</script>