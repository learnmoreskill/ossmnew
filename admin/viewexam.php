<?php
include('session.php');
require("../important/backstage.php");

   $backstage = new back_stage_class();

if (isset($_GET["token"]) && $_GET["token"] == "558x558"){

        $class_id = $_GET["c4x004"];

        $exam_id = $_GET["e4x004"];

        $year_id = $_GET["y4x004"];

        $month_id = $_GET["m4x004"];

        if (empty($month_id)) { $month_id=0; }


            $resultaddedmark = $db->query("SELECT `examtable`.*, `subject`.* 
              FROM `examtable`
              RIGHT JOIN `subject`
              ON `examtable`.`subject` = `subject`.`subject_id`
              WHERE `examtable`.`class_name`='$class_id' 
              AND `examtable`.`exam_type` = '$exam_id' 
              AND `examtable`.`year_id` = '$year_id' 
              AND `examtable`.`month` = '$month_id'
              ORDER BY `subject`.`sort_order`,`subject`.`subject_id`");



            //for information to show
            $resultinfo = $db->query("SELECT `class`.`class_name` ,`section`.`section_name`,`examtype_name`,`subject_name`  FROM `examtype`, `class`, `section`,`subject` WHERE `class`.`class_id` = '$class_id' AND `section`.`section_id`='$section_id' AND `examtype`.`examtype_id` = '$exam_id' AND `subject`.`subject_id`='$subject_id' ");
           $rowinfo = $resultinfo->fetch_assoc();

           $subjectRow= json_decode($backstage->get_subject_details_by_subject_id($subject_id));



}

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        
        <main>
            <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Update Exam</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12"> 
                    <div class="card teal center lighten-2">
                        <span class="card-title white-text">Class:<?php echo $rowinfo["class_name"]; ?> , Sec:<?php echo $rowinfo["section_name"]; ?> , Exam:<?php echo $rowinfo["examtype_name"]; ?> , Subject:<?php echo $rowinfo["subject_name"]; ?> 

                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
              <form class="col s12" id="update_marks_subjectwise_form" action="addmarkscript.php" method="post" >

                <input type="hidden" name="update_marks_subjectwise"  value="update_marks_subjectwise" >
                <input type="hidden" name="class_id"  value="<?php echo $class_id;?>" >
                <input type="hidden" name="section_id"  value="<?php echo $section_id;?>" >
                <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" >
                <input type="hidden" name="year_id" value="<?php echo $year_id; ?>" >
                <input type="hidden" name="month_id"  value="<?php echo $month_id;?>" >
                <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>" >
                <input type="hidden" name="subject_type" id="subject_type" value="<?php echo $subjectRow->subject_type; ?>" >

                <div class="card teal col s6 center lighten-2">
                    <span class="card-title white-text">Subject</span>
                </div>
                <div class="card teal col s3 center lighten-2">
                    <span class="card-title white-text">Date</span>
                </div>
                <div class="card teal col s3 center lighten-2">
                    <span class="card-title white-text">Time</span>
                </div>

                <div class="row">
                  <div class="col s12">
                    <table class="centered bordered striped highlight z-depth-4">
                      <thead>
                          <th>Roll</th>
                          <th>Student Name</th>
                          <?php if ($subjectRow->subject_type == 0 || $subjectRow->subject_type == 3) {
                                    echo "<th>Obtained Mark</th>";
                                  }elseif ($subjectRow->subject_type == 1) {
                                    echo "<th>Th. obtained Mark</th><th>Pr. obtained Mark</th>";
                                  } ?>
                          <th>Remove/Selected</th>
                      </thead>
                      <tbody>
                         <input type="hidden" name="rowno" value="<?php echo $resultaddedmark->num_rows;?>">
                         
                         <?php $idcount = 0; while($row3 = $resultaddedmark->fetch_assoc()) { ?>

                            <input type="hidden" name="marksheet_id[<?php echo $idcount; ?>]" value="<?php echo $row3["marksheet_id"];?>" >
                            <input type="hidden" name="sid[<?php echo $idcount; ?>]" value="<?php echo $row3["sid"];?>" >
                            <tr>   
                            <td id="sroll<?php echo $idcount; ?>" >
                                <?php echo $row3["sroll"]; ?>
                                
                            </td>
                            <td id="sname<?php echo $idcount; ?>" >
                              <?php echo $row3["sname"]; ?>
                            </td>

                            <?php if ($subjectRow->subject_type == 0) { ?>
                              <td class="cPaddingLR" style="width: 40%">
                                <input class="no-margin" name="theoretical[<?php echo $idcount; ?>]" id="o<?php echo $idcount; ?>" type="text" placeholder="eg. 85 (type ab for absent/s for suspend)" value="<?php echo $row3['m_theory']; ?>" <?php echo ((empty($row3["marksheet_id"]))? 'readonly':'' ) ?> required  >                          
                              </td>
                            <?php }else if ($subjectRow->subject_type == 3) { ?>
                              <td class="cPaddingLR" style="width: 40%">
                                <input class="no-margin" name="theoretical[<?php echo $idcount; ?>]" id="o<?php echo $idcount; ?>" type="text" placeholder="eg. A+ (type ab for absent/s for suspend)" value="<?php echo $row3['m_theory']; ?>" <?php echo ((empty($row3["marksheet_id"]))? 'readonly':'' ) ?> required  >                          
                              </td>
                            <?php }else if ($subjectRow->subject_type == 1) { ?>

                              <td class="cPaddingLR" style="width: 20%">
                                  <input class="no-margin" name="theoretical[<?php echo $idcount; ?>]" id="t<?php echo $idcount; ?>" type="text" placeholder="eg. 65 (type ab for absent/s for suspend)" value="<?php echo $row3['m_theory']; ?>" <?php echo ((empty($row3["marksheet_id"]))? 'readonly':'' ) ?> required >                          
                              </td>

                              <td class="cPaddingLR" style="width: 20%">
                                  <input class="no-margin" name="practical[<?php echo $idcount; ?>]" id="p<?php echo $idcount; ?>" type="text" placeholder="eg. 15 (type ab for absent/s for suspend)" value="<?php echo $row3['m_practical']; ?>" <?php echo ((empty($row3["marksheet_id"]))? 'readonly':'' ) ?> required >                          
                              </td>
                            <?php } ?>
                              <!-- Select/deselect for delete -->
                              <td>
                                <div class="switch">
                                  <label>
                                    <input class="mrrorbot1" id="<?php echo $idcount; ?>" onclick="disableStudent(this.id)" type="checkbox" name="selectstd[<?php echo $idcount; ?>]" <?php echo ((empty($row3["marksheet_id"]))? '':'checked' ) ?> >
                                    <span class="lever"></span>
                                  </label>
                                </div>                          
                              </td>

                            </tr>
                        <?php $idcount++;  } ?>
                        </tbody>
                      </table>
                  </div>
                </div>
                <div class="row">
                    <div class="input-field col offset-m9">
                         <button class="btn waves-effect waves-light blue lighten-2" type="submit">Update
                            <i class="material-icons right">send</i>
                          </button>
                    </div>
                </div>
              </form>
        </div>
        
        </main>

<?php include_once("../config/footer.php");?>
<?php
    if (isset($_SESSION['result_success'])) 
    {
        $result1=$_SESSION['result_success'];
        echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
        unset($_SESSION['result_success']);
    }
?> 
<script type="text/javascript">
    function disableStudent(id)
    {

      var selectbtn=document.getElementById(id).checked;
      var sname=document.getElementById("sname"+id);
      var stype=document.getElementById("subject_type").value;

      var th = document.getElementById("t"+id);
      var pr = document.getElementById("p"+id);
      var ob = document.getElementById("o"+id);

      if (stype==0 || stype==3) {
        if (selectbtn) {
        sname.style.color = "black";
        ob.removeAttribute("readonly");

        } else {
        sname.style.color = "red";
        ob.setAttribute("readonly",true);
        }

      }else if (stype==1){

        if (selectbtn) {
        sname.style.color = "black";
        th.removeAttribute("readonly");
        pr.removeAttribute("readonly");

        } else {
        sname.style.color = "red";
        th.setAttribute("readonly",true);
        pr.setAttribute("readonly",true);

        }

      }     
    }
</script>

<script>
$(document).ready(function (e) 
{
  $("#update_marks_subjectwise_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "addmarkscript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#err").fadeOut();
            $("#overlayloading").show();
            $("#formsubmit").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Marks succesfully updated'.trim()) { 
              Materialize.toast(data, 4000, 'red rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else 
              if (data.trim() === 'Marks succesfully updated'.trim()) {

              window.location.href = window.location.href;
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#formsubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  }));  
});

</script>