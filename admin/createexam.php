<?php
include('session.php');
include("../important/backstage.php");
$backstage = new back_stage_class();
$found = 0;

/*set active navbar session*/
$_SESSION['navactive'] = 'createexam';

    $school_details = json_decode($backstage->get_school_details_by_id());

    $year_id = $current_year_session_id;

    $classList= json_decode($backstage->get_class_list_by_year_id($year_id));

    $examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));


if($_SERVER["REQUEST_METHOD"] == "POST") {
    $class_id = mysqli_real_escape_string($db,$_POST['classid']);
    $exam_id = mysqli_real_escape_string($db,$_POST['examid']);
    $month_id = mysqli_real_escape_string($db,$_POST['m04x20']);

    $cal = $calendar->eng_to_nep(date('Y'), date('m'), date('d'));
    $cnyear = $cal['year'];
    $year_id = json_decode($backstage->get_academic_year_id_by_year($cnyear));

    if (empty($month_id)) { $month_id = 0; } 

        if($exam_id == 5 || $exam_id == 6) {
              if (empty($month_id)) {
               ?> <script> alert('Please select month.'); window.location.href = 'createexam.php'; </script> <?php
              }
        }else if(!($exam_id == 5 || $exam_id == 6)){
              $month_id = 0;
        }
      $sqlcheck="SELECT * FROM `examtable` WHERE `class_name`='$class_id' AND `exam_type` = '$exam_id' AND `year_id` = '$year_id' AND `month` = '$month_id' ";
       $resultcheck=mysqli_query($db, $sqlcheck);
       $count=mysqli_num_rows($resultcheck);
      if($count<1){

          $sqlsubj = $db->query("SELECT * FROM `subject` WHERE `subject`.`subject_class`='$class_id' AND status=0 ORDER BY `subject`.`subject_id` ASC");
          $rowsubj = $sqlsubj->num_rows;

          if($rowsubj > 0) {  $found = '1';  } else{  $found = 'nosubject';   }

          //for information to show
            $resultinfo = $db->query("SELECT `class`.`class_name`, `examtype`.`examtype_name` FROM `class`,`examtype` WHERE `class`.`class_id` = '$class_id' AND `examtype`.`examtype_id` = '$exam_id' ");
            $rowinfo = $resultinfo->fetch_assoc();

      }else{

            ?><script> if(confirm("Exam already created,Click ok to view exam")){

            window.location.href = 'createexam.php?token=558x558&c4x004=<?php echo $class_id; ?>&e4x004=<?php echo $exam_id; ?>&y4x004=<?php echo $year_id; ?>&m4x004=<?php echo $month_id; ?>';

             }else{
              window.location.href = 'createexam.php';
            } </script> <?php
      }
}
if (isset($_GET["token"]) && $_GET["token"] == "558x558"){ //Update or view GET method

        $class_id = $_GET["c4x004"];

        $exam_id = $_GET["e4x004"];

        $year_id = $_GET["y4x004"];

        $month_id = $_GET["m4x004"];

        if (empty($month_id)) { $month_id = 0; }


            $sqlsubj = $db->query("SELECT  `subject`.* , `examtable`.*
              FROM `subject`
              LEFT JOIN `examtable`
              ON `subject`.`subject_id` = `examtable`.`subject`
              AND `examtable`.`class_name`='$class_id' 
              AND `examtable`.`exam_type` = '$exam_id' 
              AND `examtable`.`year_id` = '$year_id' 
              AND `examtable`.`month` = '$month_id'
              
              WHERE `subject`.`subject_class` = '$class_id'
              AND `subject`.`status` = 0
              
              ORDER BY `subject`.`sort_order`,`subject`.`subject_id` ");

            $rowsubj = $sqlsubj->num_rows;

            if($rowsubj > 0) { $found = '1';} else{ $found = 'nosubject';   }

            $sqlextra = $db->query("SELECT  `examtable`.*
              FROM `examtable`
              WHERE `examtable`.`class_name`='$class_id' 
              AND `examtable`.`exam_type` = '$exam_id' 
              AND `examtable`.`year_id` = '$year_id' 
              AND `examtable`.`month` = '$month_id'
              GROUP BY `exam_type` ");

            $extramark = $sqlextra->fetch_assoc();


            //for information to show
            $resultinfo = $db->query("SELECT `class`.`class_name`, `examtype`.`examtype_name` FROM `class`,`examtype` WHERE `class`.`class_id` = '$class_id' AND `examtype`.`examtype_id` = '$exam_id' ");
            $rowinfo = $resultinfo->fetch_assoc();

           //$subjectRow= json_decode($backstage->get_subject_details_by_subject_id($subject_id));



}

?>
    <?php include_once("../config/header.php");?>
        <?php include_once("navbar.php");?>
        <script type="text/javascript">
          function showMonth(value) {
          var monthDiv=document.getElementById("monthDiv");

          if (value == "5" || value == "6" ) {
            monthDiv.style.display = 'block';
              return;
          } else {
            monthDiv.style.display = 'none';
            return;
          }
        }
        </script>
            <main>
              <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
                <div class="section no-pad-bot" id="index-banner">
                    <?php include_once("../config/schoolname.php");?>
                    <div class="github-commit">
                        <div class="container">
                            <div class="row center">
                              <a class="white-text text-lighten-4">
                                <?php echo ((isset($_GET["token"]) && $_GET["token"] == "558x558")? (($login_cat==1 || $pac['edit_exam'])? 'Update '.$rowinfo['examtype_name'].' Time table for class '.$rowinfo['class_name'] : $rowinfo['examtype_name'].' Time table for class '.$rowinfo['class_name']) : 'Create '.$rowinfo['examtype_name'].' Time table for class '.$rowinfo['class_name']); ?>
                              </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if($found == '1'){
                    ?>
                    <div class="row scrollable">
                      <div class="col s12" style="min-width: 900px;" >
                        <form id="create_exam_form"  action="createexamscript.php" method="post">
                        <div class="row">
                          <div class="col s12">
                              <div class="card teal col s6 center lighten-2">
                                  <span class="card-title white-text">Subject</span>
                              </div>
                              <div class="card teal col s2 center lighten-2">
                                  <span class="card-title white-text">Date</span>
                              </div>
                              <div class="card teal col s2 center lighten-2">
                                  <span class="card-title white-text">Time</span>
                              </div>
                              <div class="card teal col s2 center lighten-2">
                                  <span class="card-title white-text">Select</span>
                              </div>


                              <input name="create_exam"  type="hidden" value="<?php echo $rowsubj;?>">
                              <input name="class_id"  type="hidden" value="<?php echo $class_id;?>">
                              <input name="exam_id"  type="hidden" value="<?php echo $exam_id;?>">
                              <input name="month"  type="hidden" value="<?php echo $month_id;?>">


                              <?php $cid = 0;
                                while($row3 = $sqlsubj->fetch_assoc()) {
                                    ?>
                                    <div class="row" id="subjectRow<?php echo $cid; ?>" <?php echo ((isset($_GET["token"]) && $_GET["token"] == "558x558")? ((empty($row3["examtable_id"]))? 'style="color:  red;"':'style="color:  black;"' ) : 'style="color:  black;"');  ?>  >
                                      <div class="input-field col s6">
                                        <input name="examtable_id[<?php echo $cid; ?>]"  type="hidden" value="<?php echo $row3["examtable_id"];?>">
                                        <input name="sub[<?php echo $cid; ?>]"  type="hidden" value="<?php echo $row3["subject_id"];?>">
                                        <input  id="subjectName<?php echo $cid; ?>" type="text" value="<?php echo $row3["subject_name"];?>" class="validate" disabled 
                                        <?php echo ((isset($_GET["token"]) && $_GET["token"] == "558x558")? ((empty($row3["examtable_id"]))? 'style="color:  red;"':'style="color:  black;"' ) : 'style="color:  black;"');  ?>  >
                                        <label for="subjectName">Subject Name</label>
                                      </div>

                                      
                                      <div class="input-field col s2">
                                        <input name="examdate[<?php echo $cid; ?>]" type="text" required
                                          
                                          id="picker<?php echo $row3["subject_id"];?>" 
                                          class="<?php if($login_date_type==1){
                                            echo 'datepicker1';
                                          }else if($login_date_type==2){
                                            echo 'bod-picker1';
                                          }else{
                                            echo 'datepicker1';
                                          } ?>" onclick="mypicker(this.id)"   placeholder="Exam time" >
                                        
                                      </div>

                                      <div class="input-field col s2">
                                        <input name="examtime[<?php echo $cid; ?>]" 
                                          value="<?php echo ((!empty($row3['time']))? date("h:iA", strtotime($row3['time'])) : ''); ?>" id="examtime" 
                                          type="text" 
                                          class="timepicker" >
                                        <label for="examtime">Time</label>
                                      </div>
                                      <div class="input-field col s2">
                                        <div class="switch">
                                          <label>
                                            <input class="mrrorbot1" id="<?php echo $cid; ?>" onclick="disableSubject(this.id)" type="checkbox" name="selected[<?php echo $cid; ?>]" 
                                            <?php echo ((isset($_GET["token"]) && $_GET["token"] == "558x558")? ( ($row3["examtable_id"] )? 'checked' : '' ) : 'checked'); ?> >
                                            <span class="lever"></span>
                                          </label>
                                        </div>   
                                      </div>
                                    </div>
                                    <?php 
                                    $cid ++;
                                    }
                                    ?>
                                    </div>
                              </div>
                              <div class="row">
                              <div id="submit_div" class="input-field col offset-m10">
                                <?php if (isset($_GET["token"]) && $_GET["token"] == "558x558") {
                                      if ($login_cat==1 || $pac['edit_exam']){ ?>

                                    <input type="hidden" name="request" value="update_exam_table" >
                                    <button class="btn waves-effect waves-light blue lighten-2" type="submit" >Update
                                    <i class="material-icons right">send</i>

                                <?php } }else{ ?>
                                    <input type="hidden" name="request" value="add_exam_table" >
                                    <button class="btn waves-effect waves-light blue lighten-2" type="submit" >Submit
                                      <i class="material-icons right">send</i>
                                    </button>
                                <?php } ?>
                              </div>
                          </div>
                      </form>
                    </div>
                </div>




                <?php }else{ ?>
                <div class="row">
                  <form  class="col s12" action="" method="post">
                    <div class="row">
                        <div class="input-field col s6">
                          <select name="examid" id="examid" required onchange="showMonth(this.value)">
                              <option value="" disabled>Select Exam Type</option>

                                    <?php foreach ($examTypeList as $examlist) {
                                            echo '<option value="'.$examlist->examtype_id.'"> ' . $examlist->examtype_name. ' </option>';
                                          }   ?>

                          </select>
                            <label>Select Exam Type</label>

                        </div>
                          <div class="input-field col s6">
                              <select name="classid" id="classid" required>
                                  <option value="" >Select class</option>

                                        <?php 
                                        foreach ($classList as $clist) {
                                          echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                        }
                                        ?>
                              </select>
                                <label>Select Class</label> 
                          </div>
                          <div style="display: none;"  id="monthDiv" class="input-field col s12 m12">
                                          <select name="m04x20" id="month_id" >
                                              <option value="" >Select month</option>
                                              <option value="1">Baishakh</option>
                                              <option value="2">Jestha</option>
                                              <option value="3">Asar</option>
                                              <option value="4">Shrawan</option>
                                              <option value="5">Bhadau</option>
                                              <option value="6">Aswin</option>
                                              <option value="7">Kartik</option>
                                              <option value="8">Mansir</option>
                                              <option value="9">Poush</option>
                                              <option value="10">Magh</option>
                                              <option value="11">Falgun</option>
                                              <option value="12">Chaitra</option>
                                          </select>
                                          <label>select month</label>
                          </div>
                        </div>
                      <div class="col offset-m5">
                      <button class="btn waves-effect waves-light blue lighten-2" type="submit" name="action"><i class="material-icons right">send</i>Next</button>
                    </div>
                  </form>
                </div>
              <?php if ($found === 'nosubject') { ?>
              <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">Sorry, Subject list is empty for this class</span></span>
                            </div>
                        </div>
                    </div>
                </div>                
              <?php } ?>



              <?php } ?>
      </main>
        <!-- add footer.php here -->
<?php include_once("../config/footer.php");?>

<?php if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }
?>


<script>
$(document).ready(function (e) 
{
  $("#create_exam_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "createexamscript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            //$("#err").fadeOut();
            $("#overlayloading").show();
            $("#submit_div").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Exam table succesfully updated'.trim()) { 
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
              if (data.trim() === 'Exam table succesfully updated'.trim()) {

              window.location.href = window.location.href;
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#submit_div").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
            $("#submit_div").show();
          }          
    });
  }));  
});

</script>

<script type="text/javascript">
    function disableSubject(id)
    {

      var selectbtn=document.getElementById(id).checked;
      var subjectName=document.getElementById("subjectName"+id);
      var subjectRow=document.getElementById("subjectRow"+id);

      var th_fm = document.getElementById("th_fm"+id);
      var pr_fm = document.getElementById("pr_fm"+id);
      var th_pm = document.getElementById("th_pm"+id);
      var pr_pm = document.getElementById("pr_pm"+id);

        if (selectbtn) {
        subjectName.style.color = "black";
        subjectRow.style.color = "black";
        th_fm.removeAttribute("readonly");
        pr_fm.removeAttribute("readonly");
        th_pm.removeAttribute("readonly");
        pr_pm.removeAttribute("readonly");

        } else {
        subjectName.style.color = "red";
        subjectRow.style.color = "red";
        th_fm.setAttribute("readonly",true);
        pr_fm.setAttribute("readonly",true);
        th_pm.setAttribute("readonly",true);
        pr_pm.setAttribute("readonly",true);
        }
    }
</script>


<?php 
if (isset($_GET["token"]) && $_GET["token"] == "558x558") {
mysqli_data_seek($sqlsubj, 0);
while($row3 = $sqlsubj->fetch_assoc()) { ?> 
  <script type="text/javascript">
    var dbdate = "<?php echo ((!empty($row3['date']))? (($login_date_type==2)? eToN($row3['date']) : $row3['date']) : '');?>"
    document.getElementById("picker<?php echo $row3["subject_id"];?>").value = dbdate;
  </script>
<?php }} ?>