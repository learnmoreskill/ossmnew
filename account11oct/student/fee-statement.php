
<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<?php
include('../session.php');
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
  $student_id = $_GET['student_id'];
  $pending_details = json_decode($account->get_pending_amount_by_status_sid('Paid',$_GET['student_id']));
  $student_details = json_decode($account->get_student_details_by_sid($_GET['student_id']));
 $student_id = $_GET['student_id'];
 $spname = $student_details->spname;
 $sadmsnno = $student_details->sadmsnno;
 $sclass = $student_details->sclass;
 $ssec = $student_details->ssec;
 $dob = $student_details->dob;
 $sroll = $student_details->sroll;
 $sname = $student_details->sname;
 $saddress = $student_details->saddress;
 $spnumber = $student_details->spnumber;
}
?>
<link rel="stylesheet" type="text/css" href="../assets/css/nepali.datepicker.v2.2.min.css" />
<body>

<?php include('../config/navbar.php'); ?>


    <section id="main-content">
      <section class="wrapper">
        <div class="col-md-12"  style="height: auto;">
          <div  class='panel-heading' style="background: #ccc4c4;">
              Student Account Record
          </div>
          <div class="col-md-12 panel" style="padding:10px;">
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
                      <td><?php echo $account->get_student_class_name_by_id($sclass); ?> &nbsp <?php echo $account->get_section_name_by_section_id($ssec); ?></td>
                    </tr>
                    <tr>
                    <th scope="row">Date of Birth :</th>
                      <td><?php echo $dob; ?></td>
                      <th scope="row">Roll No :</th>
                      <td><?php echo $sroll; ?></td>
                    </tr>

                  </tbody>
              </table>
            </div>
          </div>
          <div class="col-md-12 panel" style="padding:10px;">
              <div class="col-md-12" style="padding: 10px;">
                <form class="form-inline" name='single_date_form'>
                   <?php
                    echo "<div class='form-group'>
                      <label >Date</label>
                      <input type='text' name='single_date' class='form-control'  placeholder='Example: 2075' style='color:black;' onkeydown='if(event.keyCode==13){ student_statement_by_single_date(".$student_id."); }'>
                    </div>
                   
                    <input onclick='student_statement_by_single_date(".$student_id.")' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
                    ?>
                </form>
              </div>

              <div class="col-md-12" style="padding: 10px;">
                <form class="form-inline" name='two_date_form'>
                    <div class="form-group">
                      <label >From</label>
                      <!-- <input type="date" class="form-control"  placeholder="Exmple: 2018-01-01" style="color:black;" name='first_date'> -->
                      <input type="text" id="nepaliDate1" class="form-control nepali-calendar"  placeholder="YYYY-MM-DD" value="" name='first_date'>
                    </div>
                    <div class="form-group">
                      <label >To</label>
                      <!-- <input type="date" class="form-control"  placeholder="Example; 2018-05-01" style="color:black;" name='second_date'> -->
                      <input type="text" id="nepaliDate2" class="form-control nepali-calendar"  placeholder="YYYY-MM-DD" value="" name='second_date'>
                    </div>
                    <?php
                    echo "<input onclick='student_statement_by_two_date(".$student_id.")' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
                    ?>
                </form>
              </div>
          </div>
          <div class="col-md-12" id='load_statement_record' style="height: 500px;">
          </div>
        </div> 
      </section>
    </section>

</section>
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
    <script type="text/javascript" src="../assets/js/nepali.datepicker.v2.2.min.js"></script>
<script type="text/javascript">
  
  function student_statement_by_single_date(id)
  {
   var date = single_date_form.single_date.value;
    $('#load_statement_record').load('../student/load_statement_record.php?student_id='+id+'&date='+date);
  }

  function student_statement_by_two_date(id)
  {
    var first_date = two_date_form.first_date.value;
    var second_date = two_date_form.second_date.value;
    $('#load_statement_record').load('../student/load_statement_record.php?two_date_student_id='+id+'&first_date='+first_date+'&second_date='+second_date);
    
  }

  
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
</script>

<script>
  $(document).ready(function(){
    $('#nepaliDate1').nepaliDatePicker({
      npdMonth: true,
      npdYear: true,
      npdYearCount: 10
    });
  });
  $(document).ready(function(){
    $('#nepaliDate2').nepaliDatePicker({
      npdMonth: true,
      npdYear: true,
      npdYearCount: 10
    });
  });
</script>

</body>
</html>
