<?php
include('session.php');

if( isset( $_POST['markstoken'] ) )
{
  $class_id = $_POST['class_id'];
  $section_id = $_POST['section_id'];
  $examtypeid = $_POST['examtypeid'];

  $month_id = $_POST['month_id'];
  $yearid = $_POST['yearid'];

  if (empty($month_id)) {
    $month_id = 0; 
  }
  if (!($examtypeid == 5 || $examtypeid == 6)){
       $month_id = 0; 
  }

  if(!empty($section_id) || empty($section_id)){

    $queryvm = $db->query("SELECT *  FROM `marksheet` LEFT JOIN `studentinfo` ON `marksheet`.`mstudent_id`=`studentinfo`.`sid` WHERE `marksheet`.`marksheet_class`='$class_id' " . (empty($section_id) ? "" : "AND `marksheet`.`marksheet_section`='$section_id' ") . "  AND `marksheet`.`mexam_id`='$examtypeid' AND `marksheet`.`month`='$month_id' AND `marksheet`.`year_id`='$yearid' ");
    $rowCount = $queryvm->num_rows;

    if($rowCount > 0) {
      $found='1';
    } 
    else{ 
      $found='0'; 
    }


    $querystatus = $db->query("SELECT `marksheet_status` FROM `marksheet` WHERE `marksheet_class` = '$class_id' AND `marksheet`.`mexam_id`='$examtypeid' AND `marksheet`.`month`='$month_id' AND `marksheet`.`year_id`='$yearid' GROUP BY `marksheet_status` ");
    $rowCountStatus = $querystatus->num_rows;
    $statusCheck = $querystatus->fetch_assoc();





    ?>

    <?php 
    if($found == '1'){ ?>

      
      <?php 
      if($_POST['markstoken'] =='reviewledger' ) { ?>

        <div class="center purple lighten-3 white-text" style="border-radius: 4px; height: 30px; ">
          <?php
          if ($rowCountStatus>= 2) { echo "partially published";
          }else{
            if ($statusCheck['marksheet_status'] == 0){ echo "Published";
            }elseif ($statusCheck['marksheet_status'] == 1){ echo "Not yet published"; }
          } ?>
        </div><br>


          <div class="center"><span class="red-text">Note: Please make sure all the marks of the students are entered correctly.</span>
          </div>
          <br> 
        <?php 
      } ?>

      <style type="text/css">
        th, td {
          border-right: 1px solid #e1e1e1;
        }
      </style>
        
      <div id="invoice_print" class="row scrollable">
          
        <div class="col s12 m12">
          
          
            <table class="centered bordered striped highlight z-depth-4 table-bordered" width="100%" border="1" style="border-collapse:collapse;">
              <thead>
                <tr>
                  <th rowspan="2">Roll no.</th>
                  <th rowspan="2">Student Name</th>
                    <?php
                    $resultsubject1 = $db->query("SELECT * FROM `subject` WHERE `subject_class` = '$class_id' AND `status` = 0 ORDER BY `subject`.`subject_id` ASC");

                    /*$resultsubject1 = $db->query("SELECT `subject_id` , `subject_name`,`subject_type` FROM `marksheet` INNER JOIN `subject` ON `marksheet`.`msubject_id` = `subject`.`subject_id`  WHERE `marksheet`.`marksheet_class` = '$class_id' AND `marksheet`.`mexam_id` = '$examtypeid' AND `marksheet`.`year_id`='$yearid' GROUP BY `msubject_id` ORDER BY `subject_id`");*/
                    if ($resultsubject1->num_rows > 0) {
                      while($subjectrow1 = $resultsubject1->fetch_assoc()) { ?>
                        <th <?php if($subjectrow1["subject_type"]==1){echo "colspan='3'";} ?> ><?php echo $subjectrow1["subject_name"]; ?>
                        </th>
                        <?php 
                      } ?>
                      <?php 
                    } ?>
                  <th rowspan="2">Total</th>
                </tr>
                <tr>

                  <?php
                  mysqli_data_seek($resultsubject1, 0);
                  while($subjectrow2 = $resultsubject1->fetch_assoc()) {
                    if($subjectrow2["subject_type"]=='0'){ ?>
                      <th>

                      </th>
                      <?php 
                    }
                    elseif($subjectrow2["subject_type"]=='1'){?>

                      <th>TH</th>
                      <th>PR</th>
                      <th>Total</th>
                                    
                      <?php 
                    }else{} 
                  }  ?>
                </tr>
              </thead>
              <?php
                                
              $resultstudmt = $db->query("SELECT * FROM `studentinfo` 
                INNER JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_name` " . (empty($section_id) ? "" : "INNER JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_name` ") . "  WHERE `class`.`class_id`='$class_id' " . (empty($section_id) ? "" : "AND `section`.`section_id`='$section_id' ") . "");
              if ($resultstudmt->num_rows > 0) {
                while($studentrow1 = $resultstudmt->fetch_assoc()) { ?>
                  <tr>
                    <td>
                        <?php echo $studentrow1["sroll"];?>
                    </td>
                    <td>
                        <?php echo $studentrow1["sname"];?>
                    </td>
                    <?php

                    $stdid=$studentrow1["sid"];
                    $avg1=0;
                    $countavg=0;

                  mysqli_data_seek($resultsubject1, 0);
                  while($subjectrow2 = $resultsubject1->fetch_assoc()) {
                  $subid = $subjectrow2["subject_id"];
                  $subtype = $subjectrow2["subject_type"];

                    $resultmark = $db->query("SELECT `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`,`marksheet`.`marksheet_status`, `subject`.`subject_type` FROM `marksheet` INNER JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` WHERE `marksheet`.`marksheet_class`='$class_id' " . (empty($section_id) ? "" : "AND `marksheet`.`marksheet_section`='$section_id' ") . "  AND `marksheet`.`mexam_id`='$examtypeid' AND `marksheet`.`mstudent_id`='$stdid' AND `marksheet`.`msubject_id`='$subid' AND `marksheet`.`month`='$month_id' AND `marksheet`.`year_id`='$yearid'  ");

                    if ($resultmark->num_rows > 0) {
                      while($submark1 = $resultmark->fetch_assoc()) { ?>
                                  
                        <?php 
                        if($submark1["subject_type"]==1){ ?>

                          <td <?php if ($submark1["marksheet_status"] == 1) { echo 'class="red lighten-4"';  }
                          elseif ($submark1["marksheet_status"] == 0) { echo 'class="green lighten-4"';  } ?> >
                            <?php if(!empty($submark1["m_theory"])){ echo $submark1["m_theory"]; }else{echo "-";} ?> 
                          </td>
                          <td <?php if ($submark1["marksheet_status"] == 1) { echo 'class="red lighten-4"';  }
                          elseif ($submark1["marksheet_status"] == 0) { echo 'class="green lighten-4"';  } ?>>
                           <?php if(!empty($submark1["m_practical"])){ echo $submark1["m_practical"]; }else{echo "-";} ?> 
                          </td>
                          <td <?php if ($submark1["marksheet_status"] == 1) { echo 'class="red lighten-4"';  }
                          elseif ($submark1["marksheet_status"] == 0) { echo 'class="green lighten-4"';  } ?>>
                            <?php $avg1=$avg1+$submark1["m_obtained_mark"];
                                  $countavg=++$countavg;

                                  if(!empty($submark1["m_obtained_mark"])){ echo $submark1["m_obtained_mark"]; }else{echo "-";}
                              ?> 
                          </td>

                          <?php 
                        }
                        elseif($submark1["subject_type"]==0){ ?>
                          <td <?php if ($submark1["marksheet_status"] == 1) { echo 'class="red lighten-4"';  }
                          elseif ($submark1["marksheet_status"] == 0) { echo 'class="green lighten-4"';  } ?> >
                               <?php $avg1=$avg1+$submark1["m_obtained_mark"];
                                $countavg=++$countavg;
                            if(!empty($submark1["m_obtained_mark"])){ echo $submark1["m_obtained_mark"]; }else{echo "-";} ?> 
                          </td>
                          <?php 
                        } ?>
                                                    
                        <?php 
                      }





                    }else{
                      if($subtype==1){ ?>

                          <td class="brown lighten-4">
                          </td>
                          <td class="brown lighten-4">
                          </td>
                          <td class="brown lighten-4">
                          </td>
                          
                          <?php 
                        }
                        elseif($subtype==0){ ?>
                          <td class="brown lighten-4"></td>
                          <?php 
                        }



                    }











                  } ?>

                      <td class="brown lighten-3">
                        <?php if($avg1==0){ echo "";}else{ echo $avg1;}?>
                      </td>
                                                   
                  </tr>
                  <?php 
                } 
              } ?>
                                                
                                                
            </table>

          
        </div>
      </div>

      <?php 
      if($_POST['markstoken'] =='reviewledger' ) { ?>
          <div class="center">
            <form id="publish_marksheet_form" method="post">
              <input type="hidden" name="publish_marksheet" >
              <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
              <input type="hidden" name="exam_id" value="<?php echo $examtypeid; ?>">
              <input type="hidden" name="month_id" value="<?php echo $month_id; ?>">
              <input type="hidden" name="year_id" value="<?php echo $yearid; ?>">
              <button class="btn waves-effect waves-light" type="submit" onclick = "return confirm('Are you sure you want to publish the result?')" >Publish marksheet
                  <i class="material-icons right">send</i>
              </button>
            </form>
          </div><br>
      <?php } ?>
        
      <?php
    }
    else if($found == '0') { ?>
      <div class="row">
        <div class="col s8 offset-m2">
          <div class="card grey darken-3">
            <div class="card-content white-text center">
              <span class="card-title">
                <span style="color:#80ceff;">
                  No Marks Details Found!!
                </span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <?php 
    } 

  }
   
} ?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="../printer/js/datatables.responsive.js"></script>
<script src="../printer/js/lodash.min.js"></script>

<script>
  function printDiv()
  {
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
  $("#publish_marksheet_form").on('submit',(function(e) 
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
            if ((data.indexOf("Mark successfully published"))<0) {

              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            }else if ((data.indexOf("Mark successfully published"))>=0) {

                window.location.href = 'publish.php';
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
