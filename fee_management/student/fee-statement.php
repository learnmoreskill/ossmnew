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

  $academic_year_list= json_decode($account->get_academic_year_list());
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
            <?php
              include('studDetailTmplt.php');
            ?>
          </div>
          <div class="col-md-12 panel" style="padding:10px;">
              <div class="col-md-12" style="padding: 10px;">
                <form class="form-inline" name='single_date_form'>

                  <div class="form-group">
                    <label>Select year</label>
                    <select name="single_date" class="form-control">
                      <option value="" disabled>Select year</option>
                        <?php  
                      foreach ($academic_year_list as $aYList) { ?>
                          <option value='<?php echo $aYList->single_year; ?>' 
                            <?php echo (($aYList->id == $current_year_session_id)?'selected="selected"':''); ?> ><?php echo $aYList->single_year; ?></option>
                            <?php 
                      } ?>
                          
                    </select>
                  </div>
                   
                  <input onclick='student_statement_by_single_date()' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>
                    
                </form>
              </div>

              <div class="col-md-12" style="padding: 10px;">
                <form class="form-inline" name='two_date_form'>
                    <div class="form-group">
                      <label >From</label>
                      <input type="text" id="nepaliDate1" class="form-control nepali-calendar"  placeholder="YYYY-MM-DD" value="" name='first_date'>
                    </div>
                    <div class="form-group">
                      <label >To</label>
                      <input type="text" id="nepaliDate2" class="form-control nepali-calendar"  placeholder="YYYY-MM-DD" value="" name='second_date'>
                    </div>
            
                    <input onclick='student_statement_by_two_date()' class='btn btn-primary' value='Submit' readonly='true' style='width:100px;'>

                </form>
              </div>
          </div>
          <div class="col-md-12" id='load_statement_record' style="height: 500px;">
          </div>
        </div> 
      </section>
    </section>

</section> 


<?php require('../config/commonFooter.php'); ?>   
    
<script type="text/javascript" src="../assets/js/nepali.datepicker.v2.2.min.js"></script>

<script type="text/javascript">

  var student_id = <?php echo $student_id; ?>;
  
  function student_statement_by_single_date(){

   var year = single_date_form.single_date.value;
    $('#load_statement_record').load('../student/load_statement_record.php?statement_by_year='+student_id+'&year='+year);
  }

  function student_statement_by_two_date()
  {
    var first_date = two_date_form.first_date.value;
    var second_date = two_date_form.second_date.value;
    $('#load_statement_record').load('../student/load_statement_record.php?statement_by_two_date='+student_id+'&first_date='+first_date+'&second_date='+second_date);
    
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
