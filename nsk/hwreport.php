<?php
//p==t
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

$newdate = date("Y-m-d");

if (isset($_GET["cweg2ts8"])){
            $class = addslashes($_GET["cweg2ts8"]);
        }

if (isset($_GET["u395rd0d"])){
            $sec = addslashes($_GET["u395rd0d"]);
        }

if (isset($_GET["h5w9g64fft"])){
            $hid = addslashes($_GET["h5w9g64fft"]);
        }

if($backstage->check_homework_reported_by_id($hid)==1){
    header("location:hwhistory.php");
}


    $sqlrhw1 = "SELECT `studentinfo`.`sid`, `studentinfo`.`sroll`, `studentinfo`.`sname` 
            FROM `studentinfo`  
            WHERE  `sclass`='$class' AND `ssec`='$sec' AND `studentinfo`.`status`=0 
            ORDER BY `studentinfo`.`sroll`";
    $resultrhw1 = $db->query($sqlrhw1);

    $homework = json_decode($backstage->get_homework_details_by_id($hid));


?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Report Homework Not Done</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Home Work Details</span></span>
                            <p class="flow-text">
                                For class:
                                <?php echo $homework->class_name." ".$homework->section_name." on ".(($login_date_type==2)? eToN(date('Y-m-d', strtotime($homework->hclock))) : date('Y-m-d', strtotime($homework->hclock))); ?> <br/> Subject :
                                <?php echo $homework->subject_name; ?> <br/> Topic :
                                <?php echo $homework->htopic; ?> <br/> Submission date : 
                                <?php echo (($login_date_type==2)? eToN($homework->hdate) : $homework->hdate); ?> <br/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    Select students who have not done the homework. <br/>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="input-field col s12">
                        <form id="homework_report_form" method="post" action="hwreportscript.php">

                            <input type="hidden" name="e5s8cvd5sd5" value="<?php echo $hid; ?>">
                            <input type="hidden" name="s7g4bjge" value="<?php echo $homework->subject_name; ?>">
                            <input type="hidden" name="q7v7mdmd5" value="<?php echo $newdate;?>">
                            <input type="hidden" name="homework_not_done_request" value="<?php echo $newdate;?>">


                        <select multiple name="test[]" id="rolls">
                            <option value="" disabled>Select Students</option>
                            <?php if ($resultrhw1->num_rows > 0) {
                                while($row = $resultrhw1->fetch_assoc()) { ?>
                                <option value="<?php echo $row["sid"];?>"><?php echo $row["sroll"].'&nbsp&nbsp&nbsp'.$row["sname"];?></option>
                            <?php
                            }
                            }
                            ?>
                        </select>
                            <label>Select Students</label>
                            <button class="btn waves-effect waves-light blue lighten-2" type="submit" name="action" >Submit</button>
                            </form>
                    </div>
                </div>
            </div>

        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>

<script>
$(document).ready(function (e) 
{
  $("#homework_report_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "hwreportscript.php",
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
            if (data.trim() !== 'Homework report submitted'.trim()) { 
                Materialize.toast(data, 4000, 'red rounded'); 

            }else if (data.trim() === 'Homework report submitted'.trim()) {

              window.location.href = 'hwhistory.php';
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

