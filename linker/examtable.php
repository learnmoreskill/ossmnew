<?php
//for all
include('session.php');

require("../important/backstage.php");
$backstage = new back_stage_class();

//$school_details = json_decode($backstage->get_school_details_by_id());

if($_SERVER['REQUEST_METHOD']=='GET') {

   if (isset($_GET['view_examtable'])) {
    $cname_id=$_GET['postcname_id'];
    $etype_id=$_GET['postetype_id'];
    $year_id=$_GET['year_id'];
    $month=$_GET['month'];

    $examlist1 = "SELECT `examtable`.* , `subject`.`subject_name` FROM `examtable` 
      LEFT JOIN `subject` ON `examtable`.`subject` = `subject`.`subject_id` 
      WHERE `examtable`.`class_name`='$cname_id' 
        AND `examtable`.`exam_type`='$etype_id' 
        AND `examtable`.`year_id`='$year_id' 
        AND `examtable`.`month`='$month'  
      ORDER BY `date` ASC";
    $resultexam1 = $db->query($examlist1);

     $sqlinfo = "SELECT `class`.`class_name` FROM `class`, `examtype` 
      WHERE `class`.`class_id` = '$cname_id' 
        AND `examtype`.`examtype_id` = '$etype_id' ";
    $resultinfo = $db->query($sqlinfo);
    $rowinfo = $resultinfo->fetch_assoc();

?>
<?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Time Table For class:<?php echo $rowinfo["class_name"];?></a></div>
                    </div>
                </div>
            </div>
            <?php
            if ($resultexam1->num_rows > 0) {
                ?>
                <div id="schoolheader" style="display: none;">
                <?php include_once("../printer/printschlheader.php");?>            
                    <div style="text-align: center;">
                        <span class="card-title white-text">Time Table For class:<?php echo $rowinfo["class_name"];?></span>
                    </div><br>                                       
                </div>

                <div id="invoice_print" class="row">
                    <style type="text/css" media="print">
                        @media print {
                          body {-webkit-print-color-adjust: exact;}
                        }
                        @page {
                            size:A4 landscape;
                            -webkit-print-color-adjust: exact;
                            color-adjust: exact;
                            -webkit-filter:opacity(1);
                        }
                    </style>
                  <div class="row">
                    <div class="col s12 m12">
                      <table class="centered bordered striped highlight z-depth-4 table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Subject</th>
                                <th>Time</th>
                                <?php if ($login_cat === 1 || $pac['edit_exam']) {
                                  echo "<th class='hideInPrint'>Edit</th>";
                                }?>
                            </tr>
                        </thead>
                        <?php
                        while($examrow1 = $resultexam1->fetch_assoc()) { ?>
                        <tbody>
                          <tr>
                              <td>
                                  <?php echo ((!empty($examrow1["date"]))? (($login_date_type==2)? eToN($examrow1["date"]) : $examrow1["date"]) : ''); ?>
                                  <input type="hidden" id="date<?php echo $examrow1["examtable_id"];?>" value="<?php echo ((!empty($examrow1["date"]))? (($login_date_type==2)? eToN($examrow1["date"]) : $examrow1["date"]) : ''); ?>">
                              </td>
                              <td>
                                  <?php echo $examrow1["subject_name"]; ?>
                                  <input type="hidden" id="subname<?php echo $examrow1["examtable_id"];?>" value="<?php echo $examrow1["subject_name"]; ?>">
                              </td>                            
                              <td>
                                  <?php echo date("h:i A", strtotime($examrow1["time"])); ?>
                                  <input type="hidden" id="time<?php echo $examrow1["examtable_id"];?>" value="<?php echo date("h:i A", strtotime($examrow1["time"])); ?>">
                              </td>
                              <?php if ($login_cat === 1 || $pac['edit_exam']) { ?>
                              <td class='hideInPrint'>
                                <div style="display: inline-flex;">
                                  <a class="modal-trigger" id="<?php echo $examrow1["examtable_id"];?>" onClick="set_variable(this.id)" href="#modal">
                                    <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>


                                <a href="#" id="<?php echo $examrow1["examtable_id"];?>" onClick="deleteFromExamTable(this.id)" > 
                                    <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                                    <i class="material-icons red-text text-darken-4">delete</i></div>
                                </a> 
                                </div>
                                

                              </td>
                            <?php } ?>
                          </tr>
                        </tbody>
                          <?php
                          }?>
                      </table>
                    </div>
                  </div>
                </div>
                        <?php
                        }?>

<?php
    }else {
      
      ?> <script> alert('invalid submission'); window.location.href = 'exam.php?fail'; </script> <?php
    }

      }else{
        
        ?> <script> window.location.href = 'exam.php'; </script> <?php
      }

?>


<!-- Modal Structure -->
  <div id="modal" class="modal">
    <div class="modal-content">
      <form id="update_timetable_form" action="" method="post" >
        <h6 align="center">Edit time table</h6>
        <div class="divider"></div>

        <input type="hidden" name="update_timetable" id="update_timetable" value="">

        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Subject Name</h6>
            </div>
            <div class="input-field col s6">
              <input name="subname2" id="subname2" type="text" class="validate" value="" required readonly >
            </div>
        </div>

        <div id="datediv" class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Exam date</h6>
            </div>
            <div class="input-field col s6">
              <input name="date2" id="date2" type="text" 
                class="<?php if($login_date_type==1){
                        echo 'datepicker1';
                      }else if($login_date_type==2){
                        echo 'bod-picker';
                      }else{
                        echo 'datepicker1';
                      } ?>" 
                required="" aria-required="true">
            </div>
        </div>

        <div id="timediv" class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Time</h6>
            </div>
            <div class="input-field col s6">
              <input name="time2" id="time2" type="text" class="timepicker">
            </div>
        </div>

    <div class="modal-footer">
      <button class="modal-action waves-effect waves-green btn-flat blue lighten-2" type="submit" >Update<i class="material-icons right">send</i></button>
    </div>

    </form>
    </div>
  </div>


    <div class="fixed-action-btn">
        <a href="gupload.php" class="btn-floating btn-large red" onclick='printDiv();'>
          <i class="large material-icons">print</i>
        </a>
    </div>
</main>
<script type="text/javascript">

    function deleteFromExamTable(obj){

      if (! confirm('Are you sure want to delete?')) { return false; }

      $.ajax
      ({
          url: "updatescript.php",
          type: "POST",
          data:  'deleteExamTableRequest='+obj,
          cache: false,
          processData:false,
          beforeSend : function()
          {
          },
          success: function(data)
          {
            debugger;
            //alert(data);
            if (data.trim() === 'Exam Deleted Succesfully'.trim()) {

              location.reload();

            }else{
              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              }); 
             
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
      });
      
      
    }
    function set_variable(obj){
      document.getElementById("update_timetable").value=obj;

      var subname=document.getElementById("subname"+obj).value;
      var date=document.getElementById("date"+obj).value;
      var time=document.getElementById("time"+obj).value;


      document.getElementById("subname2").value = subname;
      document.getElementById("date2").value = date;
      document.getElementById("time2").value = time;
      
      
    }
</script>

<?php include_once("../config/footer.php");?>

<?php 
  if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }

?>

<script>
  function printDiv() 
{

  var divsToHide = document.getElementsByClassName("hideInPrint"); //divsToHide is an array
    for(var i = 0; i < divsToHide.length; i++){
        // divsToHide[i].style.visibility = "hidden"; // or
        divsToHide[i].style.display = "none"; // depending on what you're doing
    }
  var schoolheader=document.getElementById('schoolheader');
  var invoice_print=document.getElementById('invoice_print');  

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+schoolheader.innerHTML+invoice_print.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},100);

}
</script>


<script>
$(document).ready(function (e) 
{
  $("#update_timetable_form").on('submit',(function(e) 
  { 
    e.preventDefault();
    $.ajax
    ({
          url: "updatescript.php",
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
            //alert(data);
            if (data.trim() !== 'Time table successfully updated'.trim()) {
              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              }); 
             } 
            else 
              if (data.trim() === 'Time table successfully updated'.trim()) {
                $('#modal').modal('close');
              window.location.href =  window.location.href;
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
