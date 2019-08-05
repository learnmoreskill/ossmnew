<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
require('../nepaliDate.php');
?>
<?php
include('../session.php');
$teacher_details = json_decode($account->get_teacher_details());
if(isset($_REQUEST['id']))
{
    $teacher_id = $_REQUEST['id'];
    $teacher_details =  json_decode($account->get_teacher_record_by_tid($teacher_id));
}

?>

<style>

/*.tt tbody {
    display:block;
    height:450px;
    overflow:auto;
}
.tt thead, tbody tr {
    display:table;
    width:100%;
    table-layout:fixed;
}
.tt thead {
    width: calc( 100% - 9em )
}
*/
</style>
<link rel="stylesheet" type="text/css" href="../assets/css/nepali.datepicker.v2.2.min.css" />
<body>
<?php include("../config/navbar.php"); ?>

<section id="main-content">
  <section class="wrapper">
    <div class="col-md-12"  style="height: auto; ">
      <div style="padding:20px;">
        <div  class='panel-heading' style="background: #ccc4c4;">
          Teacher Payment Record 
        </div>
        <div class="col-md-12 panel" style="padding:10px;">
          <div class="col-md-3">
              <div class="card">
                <div class="card-body text-center">
                  <img class="card-img-top" src="<?php  if($teacher_details->timage!=''){ echo "../../uploads/profile_pic/".$teacher_details->timage; } else { echo "https://learnmoreskill.github.io/important/dummystdmale.png";} ?>" alt="Card image cap" width="150px" height="150px">
                  <h5 class="card-title"><a class="btn btn-primary"><?php echo $teacher_details->tname; ?></a></h5>
                  <p class="card-text">Address : <?php echo $teacher_details->taddress; ?></p>
                </div>
              </div>
          </div>
          <div class="col-md-9">
            <table class="table table-hover table-bio" style="padding-top:6%;">
                <tbody>
                  <tr>
                    <th scope="row">Father Name :</th>
                    <td><?php echo  $teacher_details->t_father; ?></td>
                    <th scope="row">E-Mail:</th>
                    <td><?php echo $teacher_details->temail; ?></td>
                  </tr>
                  <tr>
                <th scope="row">Phone No :</th>
                    <td><?php echo $teacher_details->tmobile; ?></td>
                    <th scope="row">Class:</th>
                    <td><?php echo $teacher_details->tclass; ?></td>
                  </tr>
                  <tr>
                  <th scope="row">Date of Birth :</th>
                    <td><?php echo $teacher_details->dob; ?></td>
                    <th scope="row">Gender :</th>
                    <td><?php echo $teacher_details->sex; ?></td>
                  </tr>
                </tbody>
            </table>
          </div>
        </div>
        <div class="col-md-12 panel" style="padding:10px;">
          <div class="col-md-12" style="padding: 10px;">
            <form class="form-inline" name='single_date_form' style="margin-bottom:10px;margin-top: 10px;">
              <?php
              echo "<div class='form-group'>
                <label >Date</label>
                <input type='text' name='single_date' class='form-control'  placeholder='Example 2075' onkeydown='if(event.keyCode==13){ teacher_statement_by_id(".$teacher_id."); }'>
              </div>
         
              <input onclick='teacher_statement_by_id(".$teacher_id.")' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
              ?>
            </form>
          </div>
          <div class="col-md-12" style="padding: 10px;">
            <form class="form-inline" name='two_date_form'>
              <div class="form-group">
                <label >From</label>
                <input type="text" id="nepaliDate1" class="form-control nepali-calendar"  placeholder="YYYY-MM-DD" value="" name='first_date'>
              <!-- <input type="date" class="form-control"  placeholder="Exmple: 2018-01-01" name='first_date'> -->
              </div>
              <div class="form-group">
                <label >To</label>
                <input type="text" id="nepaliDate2" class="form-control nepali-calendar"  placeholder="YYYY-MM-DD" value="" name='second_date'>
              <!-- <input type="date" class="form-control"  placeholder="Example: 2018-05-01" name='second_date'> -->
              </div>
              <?php
              echo "<input onclick='teacher_statement_by_id_two_date(".$teacher_id.")' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>";
              ?>
            </form>
          </div>    
        </div>
                          
        <div id='load_statement_record' style="margin-bottom: 20px;height: 500px;">
                          
        </div>
      </div>        
    </div>
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
function teacher_statement_by_id(id)
{
    var date = single_date_form.single_date.value;
    $('#load_statement_record').load('../teacher/teacher_payment_record.php?teacher_id='+id+'&date='+date);
}

function teacher_statement_by_id_two_date(id)
{
     var first_date = two_date_form.first_date.value;
     var second_date = two_date_form.second_date.value;
    $('#load_statement_record').load('../teacher/teacher_payment_record.php?teacher_id_by_two_date='+id+'&first_date='+first_date+'&second_date='+second_date);

}
</script>
<?php
  $jsDate = explode('-', $nepaliDate->full);
  $jsDate[2] = $jsDate[2]<10?'0'.$jsDate[2]:$jsDate[2];
  $jsDate[1] = $jsDate[1]<10?'0'.$jsDate[1]:$jsDate[1];
  $jsDate = $jsDate[1].'/'.$jsDate[2].'/'.$jsDate[0];
?>
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
      npdYearCount: 10,
      // disableBefore: '12/08/2073',
      // disableAfter: '<?php echo $jsDate; ?>',
    });
  });
</script>


</body>
</html>
