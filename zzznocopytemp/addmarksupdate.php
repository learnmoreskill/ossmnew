<?php
include('session.php');
require("../important/backstage.php");

   $backstage = new back_stage_class();

if (isset($_GET["token"])){
    $longid1 = ($_GET["token"]);

    if ($longid1=="amu8x008") {

        $class_id = $_GET["c4x004"];
        $section_id = $_GET["s4x004"];
        $exam_id = $_GET["e4x004"];
        
        $subject_id = $_GET["s5x005"];

        $year_id = $_GET["y4x004"];
        $month_id = $_GET["m4x004"];
        if (empty($month_id)) { $month_id=0; }

            $resultaddedmark = $db->query("SELECT `subject`.`subject_type`, `marksheet`.`marksheet_id`,`studentinfo`.`sid`,`studentinfo`.`sroll`,`studentinfo`.`sname`,`marksheet`.`m_theory`,`marksheet`.`m_practical`,`marksheet`.`m_obtained_mark` 
            FROM `studentinfo`
            LEFT JOIN `marksheet` ON `studentinfo`.`sid` = `marksheet`.`mstudent_id` 
            INNER JOIN `subject` ON `marksheet`.`msubject_id` = `subject`.`subject_id`
            WHERE `studentinfo`.`sclass`='$class_id'
                AND `studentinfo`.`ssec`='$section_id' 
                AND `marksheet`.`mexam_id` ='$exam_id'
                AND `marksheet`.`msubject_id` ='$subject_id'
                AND `marksheet`.`year_id` ='$year_id' 
                AND `marksheet`.`month` ='$month_id' 
            ORDER BY `studentinfo`.`sroll`");




            $resultinfo = $db->query("SELECT `class`.`class_name` ,`section`.`section_name`,`examtype_name`,`subject_name`  FROM `examtype`, `class`, `section`,`subject` WHERE `class`.`class_id` = '$class_id' AND `section`.`section_id`='$section_id' AND `examtype`.`examtype_id` = '$exam_id' AND `subject`.`subject_id`='$subject_id' ");
           $rowinfo = $resultinfo->fetch_assoc();

           $subjectRow= json_decode($backstage->get_subject_details_by_subject_id($subject_id));

    }else{
      $_GET['token'] = "";
    }
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Update Marks</a></div>
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
                <input type="hidden" name="subject_id" value="<?php echo $subject_id; ?>" >
                <input type="hidden" name="year_id" value="<?php echo $year_id; ?>" >
                <input type="hidden" name="month_id"  value="<?php echo $month_id;?>" >

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
                          <th>Delete</th>
                      </thead>
                      <tbody>
                         <input name="rowno"  type="hidden" value="<?php echo $resultaddedmark->num_rows;?>">
                         <input   name="marksheet_id[]"  type="hidden" value="<?php echo $row3["marksheet_id"];?>">
                         <?php $count = 1; while($row3 = $resultaddedmark->fetch_assoc()) { ?>

                            <tr>   
                            <td>
                                <?php echo $row3["sroll"]; ?>
                                
                            </td>
                            <td>
                              <?php echo $row3["sname"]; ?>
                            </td>

                            <?php if ($row3["subject_type"] == 0) { ?>
                              <td class="cPaddingLR" style="width: 40%">
                                <input class="no-margin" name="obtained[]" type="text" placeholder="eg. 85 (type ab for absent/s for suspend)" value="<?php echo $row3['m_obtained_mark']; ?>" required  >                          
                              </td>
                            <?php }else if ($row3["subject_type"] == 3) { ?>
                              <td class="cPaddingLR" style="width: 40%">
                                <input class="no-margin" name="obtained[]" type="text" placeholder="eg. A+ (type ab for absent/s for suspend)" value="<?php echo $row3['m_obtained_mark']; ?>" required  >                          
                              </td>
                            <?php }else if ($row3["subject_type"] == 1) { ?>

                              <td class="cPaddingLR" style="width: 20%">
                                  <input class="no-margin" name="theoretical[]" type="text" placeholder="eg. 65 (type ab for absent/s for suspend)" value="<?php echo $row3['m_theory']; ?>" required >                          
                              </td>

                              <td class="cPaddingLR" style="width: 20%">
                                  <input class="no-margin" name="practical[]" type="text" placeholder="eg. 15 (type ab for absent/s for suspend)" value="<?php echo $row3['m_practical']; ?>" required >                          
                              </td>
                            <?php } ?>
                              <!-- Select/deselect -->
                              <td>
                                <div class="switch">
                                  <label>
                                    <input class="mrrorbot1" id="<?php echo $idcount; ?>" onclick="disableStudent(this.id)" type="checkbox" name="selectstd[]" checked >
                                    <span class="lever"></span>
                                  </label>
                                </div>                          
                              </td>

                            </tr>
                        <?php $count++;  } ?>
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
              if (data.trim() === 'Marks succesfully updated'.trim()) {

              window.location.href = window.location.href;
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#formsubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));  
});

</script>