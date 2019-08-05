<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<?php
include('../session.php');
 //$bill_id=0;
 $spname = "";
 $sadmsnno = "";
 $sclass = "";
 $ssec = "";
 $dob = "";
 $sroll = "";
 $sname = "";
 $saddress = "";

if(isset($_GET['student_id']))
{
   $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$_GET['student_id']));
   $student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));
   $student_id = $_GET['student_id'];
   $spname = $student_details->spname;
   $sadmsnno = $student_details->sadmsnno;
   $sclass = $student_details->class_name;
   $ssec = $student_details->section_name;
   $dob = $student_details->dob;
   $sroll = $student_details->sroll;
   $sname = $student_details->sname;
   $saddress = $student_details->saddress;
   $spnumber = $student_details->spnumber;
   $payment_type=$student_details->payment_type;
}
?>
<body>
<aside>
    <div id="sidebar" class="nav-collapse">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
               <p class="centered"><a href="../index.php"><img src="../../uploads<?php echo "/".$fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" class="img-circle" width="60"></a></p>
                  <h5 class="centered">
                  <!-- Marcel Newman -->
                </h5>
              <?php if(isset($_SESSION['login_user_admin'])){ ?>
                <li><a  href="../../admin/welcome.php" >Admin Home</a></li>
                <?php } ?>
                <li>
                    <a href="../index.php">
                        <i class="fa fa-dashboard"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                
                <li class="sub-menu">
                    <a href="javascript:;" >
                        <i class="fa fa-book"></i>
                        <span>Expenses</span>
                    </a>
                    <ul class="sub">
                        <li><a href="../expenses/expenses-category.php">Category</a></li>
                        <li><a href="../expenses/expenses-details.php">Expenses</a></li>
                        
                    </ul>
                </li>
                <li class="sub-menu">
                    <a href="javascript:;" >
                        <i class="fa fa-book"></i>
                        <span>Extra-Income</span>
                    </a>
                    <ul class="sub">
                        <li ><a href="../extraIncome/income_details.php">Income</a></li>
                        
                    </ul>
                </li>
                
                <li class="sub-menu dcjq-parent-li" >
                    <a href="javascript:;" class="dcjq-parent active">
                        <i class="fa fa-th"></i>
                        <span>Student</span>
                    </a>
                    <ul class="sub dcjq-parent-li">
                        <li ><a href="../student/fee-type.php">Fee Type</a></li>
                        <li><a href="../student/extra-fee-collection.php">Extra Fee</a></li>
                        <li class="active"><a href="../student/student-record.php">Fee Collection</a></li>
                    </ul>
                </li>
                <li class="sub-menu ">
                    <a href="javascript:;">
                        <i class="fa fa-tasks"></i>
                        <span>Teacher</span>
                    </a>
                    <ul class="sub">
                        <li class="active"><a href="../teacher/payment.php">Payment</a></li>
                    </ul>
                </li>
                <?php if(isset($_SESSION['login_user_admin'])){  }
                elseif (isset($_SESSION['login_user_accountant'])) { ?>
                <li><a  href="../logout.php">Logout</a></li>
                 <?php } else{} ?>
              
               </ul>
           </div>
     
</aside>


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
              <td><?php echo $sclass; ?> &nbsp <?php echo $ssec; ?></td>
            </tr>
            <tr>
            <th scope="row">Date of Birth :</th>
              <td><?php echo $dob; ?></td>
              <th scope="row">Roll No :</th>
              <td><?php echo $sroll; ?></td>
            </tr>
            <tr>
              <th scope="row">Payment Mode :</th>
              <th><?php if($payment_type==1){echo "Annual";} else echo "Monthly"; ?></th>
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

          <a onclick="printExternal('../student/payment_bill.php?student_id=<?php echo $student_id; ?>')" class='btn btn-danger' style='color:#fff;margin-right:10px;float: right;'  title='Print'> 
          <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>Print</span></a>

          <a href='../student/fee-statement.php?student_id=<?php echo $student_id; ?>' class='btn btn-danger' style='color:#fff;margin-right:10px;float: right;'  title='Print'> 
          <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>Statement</span></a>

          <a class='btn btn-danger addFeeItemId' style='color:#fff;margin-right:10px;float: right;' href='#addFee' data-toggle='modal' data-whatever='<?php echo $student_id; ?>'><i class='fa fa-list-ol' aria-hidden='true'></i></i> Add Old Due</a>

          <a onclick="create_due_receipt('../student/create_receipt_by_single_student.php?studentId=<?php echo $student_id; ?>')" class='btn btn-danger' style='color:#fff;margin-right:10px;float: right;'  title='Print'>
            Create Due Receipt
          </a> 
     
  </div>

</div>


<div class="col-md-12 container-expensestbl">

<form method="post" id='form'>
 <table class="table table-dark" >
  <thead>
    <tr>
      <th scope="col"></th>
      <th scope="col">SN</th>
      <th scope="col">Fees Category</th>
      <th scope="col">Amount</th>
      <th scope="col">Due Date</th>
      <th scope="col">Status</th>

      <th scope="col">Action </th>
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
    $balance = $key->balance;
    $total_balance = $total_balance + $balance;
    if($feetype=='Tution Fee' || $feetype=='Hostel Fee' || $feetype=='Bus Fee'|| $feetype=='Computer Fee')
    {
      $last_payment_date = $key->last_payment_date;
      $last_month = date("m",strtotime($last_payment_date));
      $month = date('m');
      if($month<$last_month)
      {
        $month = $month+12;
        
        if($key->status=='Advance')
        {
          $new_month = ($last_month+12)-$month;
        }
        else
        {
          $new_month = ($last_month+12)-$month;
        }
        $new_month = $new_month ." Months";
      }
      else
      {
        $new_month = $month-$last_month;
        $new_month = $new_month ." Months";
      }
      
    }
    else
    {
      $new_month = "Null";
    }
    $sn++;
   
    $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
    $balance = $key->balance;
    $balance = preg_replace("/[^0-9]/", "", $balance);
     echo "<tr> 
     <td><input id='checkbox".$key->bill_id."' class='checkBoxClass' value='".$key->balance."' type='checkbox' name='checkbox".$key->bill_id."'/>
     </td>
     <td>".$sn."</td>
     <td>".$feetype."</td>
     <td>".$balance."</td>
     <td>".$new_month."</td>
     <td>".$key->status." </td>
     <td><a class='btn btn-primary ItemID' style='color:#fff;' href='#viewModal' data-toggle='modal' data-whatever='".$key->bill_id."'><i class='glyphicon glyphicon-eye-open' style='color:white;'></i> Entry fee</a></td>
      ";
    if($feetype=='Old Deu')
    {
      echo "<td><a class='btn btn-danger editFee' style='color:#fff;' href='#editFee' data-toggle='modal' data-whatever='".$key->bill_id."'><i class='glyphicon glyphicon-eye-open' aria-hidden='true'></i> Edit Old Deu</a></td>";
    }
    else
    {
      echo "<td>
             <a class='btn btn-danger addPartiFeeItemId' style='color:#fff;' href='#addPartFee' data-toggle='modal' data-whatever='".$key->bill_id."'><i class='glyphicon glyphicon-eye-open' style='color:white;'></i> Add Due</a>
            </td>";
            echo "<td>
             <a class='btn btn-danger editPartiFeeItemId' style='color:#fff;' href='#editPartFee' data-toggle='modal' data-whatever='".$key->bill_id."'><i class='glyphicon glyphicon-eye-open' style='color:white;'></i> Edit Due</a>
            </td>";
    }

     echo "
    </tr>";
    }
    echo "<tr>
    <td><input type='checkbox' id='ckbCheckAll' />Check All</td>
    <td></td>
    <td>Total Balance </td>
    <td id='total_balance'>0</td>
    <td></td>
    <td></td>
    <td><input class='btn btn-primary' type='submit' value='Submit' readyonly='true'/></td>
   
    </tr>";
     
}   
?>
 
  </tbody>
  
</table>
</form>
</div>
        </section>
    </section>

</section>
<div id="viewModal" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
          
        </div>
    </div>
</div>


<div id="addFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
        <div class="modal-content-addFee" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div>

<div id="editFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
        <div class="modal-content-editFee" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div>
<div id="addPartFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
        <div class="modal-content-addPartFee" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div>

<div id="editPartFee" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
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
        $('#total_balance').html('<p>'+total_balance+'</p>');
      }
      else
      {
        total_balance = total_balance - balance;
        $('#total_balance').html('<p>'+total_balance+'</p>');
      } 
      ";

   echo "});
  ";
  }
  echo"});
</script>";
?>


<script type="text/javascript">
  
$(document).ready(function()
{
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

  $(".checkBoxClass").click(function(){
    $('#ckbCheckAll').prop('checked', false);
    calculate();
  });

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



});
  


</script>
 
<script>
  var className = <?php echo $sclass ?>;
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


<script>
  var student_id = <?php echo $student_id ?>;
$(document).ready(function (e) 
{
  $("#form").on('submit',(function(e) 
  {
    e.preventDefault();
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
              location.reload();
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
</body>
</html>
