<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
require('../nepaliDate.php');
?>
<?php
include('../session.php');
$student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));
$student_id=$_GET['student_id'];
$max_bill_print_id_by_std_id = $account->get_max_bill_print_id_by_student_id($_GET['student_id']);
//echo "hello".$max_bill_print_id_by_std_id;
$bill_details = json_decode($account->get_bill_details_by_bill_id_std_id($max_bill_print_id_by_std_id,$_GET['student_id']));
?>

<body>
<?php include('../config/navbar.php'); ?>


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
  $n_month = $last_month = date("$nepaliDate->nmonth",strtotime($key->last_payment_date));
  $feetype = $account->get_feetype_by_feetype_id($key->feetype_id);
  if($feetype=='Tution Fee' || $feetype=='Bus Fee' || $feetype=='Hostel Fee' || $feetype=='Computer Fee')
  {
    $month = $account->get_nepali_month($n_month);
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


            <div class="alert alert-warning" role="alert">
              <table id='studentDetailsTable' class="table table-striped b-t b-light">
                <thead>
                <tr>
                  <th scope="col">S.N.</th>
                  <th scope="col">Bill Number</th>
                  <th scope="col">Bill ID</th>
                  <td scope="col">Action</td>
                </tr>
  </thead>
  <tbody>
    <?php
      $bills=json_decode($account->get_bills_list_by_student_id($student_id));
        // if($bills)
        //   {
        //     echo "nope";
        //   }
        // else
          //echo "string";
      $sn=1;
      foreach ($bills as $key) {
        //$a=array();
        //array_push($a,$key->bill_number);
        ?>
        <tr>
        <td><?php echo $sn; ?></td>
        <td><?php echo $key->bill_print_id; ?></td>
        <td><?php echo $key->bill_number; ?></td>
        <td><input id='<?php echo $key->bill_number; ?>' onclick='create_bill(this.id)' readonly='true' class='btn btn-primary' value='Create' style='width:100px';></td>
        </tr>
        <?php
        $sn=$sn+1;
      }
    ?>
  </tbody>

              </table>
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
 <script type="text/javascript">
      function create_bill(bill_number)
      {
        var type = 'Student';
        //var bill_number = '<?php echo $key->bill_number; ?>';
           var url = '../school/bill_print_format.php?type='+type+'&bill_number='+bill_number;
           var printWindow = window.open(url, 'Print', '');
            printWindow.addEventListener('load', function(){
                printWindow.print();
                printWindow.close();
                bill_print_form.type.value = 'Student';
                bill_print_form.bill_number.value ='';
            }, true);
        
      }
    </script>
</body>
</html>
