<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<?php
include('../session.php');
$student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));

$max_bill_print_id_by_std_id = $account->get_max_bill_print_id_by_student_id($_GET['student_id']);
echo $max_bill_print_id_by_std_id;
$bill_details = json_decode($account->get_bill_details_by_bill_id_std_id($max_bill_print_id_by_std_id,$_GET['student_id']));

?>

<body>
<aside>
    <div id="sidebar"  class="nav-collapse ">

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
        <section class="wrapper">
             <div class="table-agile-info" id='load_edit_teacher_record'>
                <div class="panel panel-default">
                    <div class="panel-heading" >
                      Student Record Details
                    </div>
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable' class="table table-striped b-t b-light">
                         



 <div class="alert alert-warning" role="alert">
  <?php
    if(empty($bill_details))
    {
      echo "<span>There are no records available for</span><span><h4> ".$student_details->sname ."</h4></span>";
    }
    else
    {
      echo "<span><h4> ".$student_details->sname ."</h4></span>";
    }

  ?>
    
  </div>

  <br>

  
  <thead>
    <tr>
      <th scope="col">S.N.</th>
      <th scope="col">Fees type</th>
      <th scope="col">Discount</th>
      <th scope="col">Fine</th>
      <th scope="col">Till Date</th>
      <th scope="col">Paid Amount</th>
    </tr>
  </thead>
  <tbody>

<?php
$sn=0;
$total = 0;
foreach ($bill_details as $key) 
{
  $n_month = $last_month = date("m",strtotime($key->last_payment_date));
  $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
  if($feetype=='Tution Fee' || $feetype=='Bus Fee' || $feetype=='Hostel Fee')
  {
    $month = $account->get_english_month($n_month);
  }
  else
  {
    $month = '';
  }
  
  $total = $total + $key->paid;
  $sn++;
  echo "
    <tr> 
      <td>".$sn."</td>
      <td>".$feetype."</td>
      <td>".$key->discount."</td>
      <td>".$key->fine."</td>
      <td>".$month."</td>
      <td>".$key->paid."</td>
    </tr>
   ";
}

    
   
    echo"<tr> 
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Total:</td>
      <td>".$total."</td>
</tr>";
 ?>  

  </tbody>
</table>
                    </div>
                </div>
            </div>
        
    </section>

</section>
<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
    <script src="../assets/js/sparkline-chart.js"></script>    
    <script src="../assets/js/zabuto_calendar.js"></script>    

</body>
</html>
