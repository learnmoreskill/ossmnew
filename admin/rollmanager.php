<?php
include('session.php');
$_SESSION['navactive'] = 'rollmanager';
require("../important/backstage.php");

$backstage = new back_stage_class();

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));


if (isset($_GET["token"]) && $_GET["token"]== "sjd54tew7hjs"){

    $class_id = $_GET['class'];
    $section_id = $_GET['section'];
    if (!empty($class_id) && !empty($section_id)) {

    $sqlstd = "SELECT `sid`,`sadmsnno`,`sname`,`sroll` ,`syearhistory`.`syear_id`
    FROM `studentinfo` 
    LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
    LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` 

    INNER JOIN `syearhistory` ON `studentinfo`.`sid`=`syearhistory`.`student_id` AND `studentinfo`.`batch_year_id`=`syearhistory`.`year_id`

    WHERE `class`.`class_id`='$class_id' AND `section`.`section_id`='$section_id' AND `studentinfo`.`status`='0' ORDER BY `sroll` ";
    $resultstd = $db->query($sqlstd);
    $rowsubj = $resultstd->num_rows;
    if($rowsubj > 0) { $found='1';} else{ $found='0';   }

    $csname= json_decode($backstage->get_class_section_name_by_id($class_id,$section_id));

}else{ ?> <script> alert('Please select both class and section'); window.location.href = 'rollmanager.php'; </script> <?php }
    
}  

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>


<!-- script for get section when select class -->
   <script>
      function showUser(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var selectDropdown =    $("#txtHint");
                    document.getElementById("txtHint").innerHTML = this.responseText;
                    selectDropdown.trigger('contentChanged');
                }
            };
            xmlhttp.open("GET","../important/getListById.php?classforsection="+str,true);
            xmlhttp.send();
            $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
             });
        }
      }
    </script>
        
        <main>
          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Manage Roll Number</a></div>
                    </div>
                </div>
            </div>
        <?php  if(isset($_GET['token']) && @$_GET['token']=="sjd54tew7hjs") {  
          if ($found =='1') {
          ?>
          <div class="row">
                <div class="col s12"> 
                    <div class="card teal center lighten-2">
                        <span class="card-title white-text">Class:<?php echo $csname->class_name;?> , Sec:<?php echo $csname->section_name;?>

                        </span>
                    </div>
                </div>
          </div>
          <div class="row">
              <form class="col s12" id="update_roll_form" action="addscript.php" method="post" >

                <input type="hidden" name="updtae_roll_number" value="updtae_roll_number">

                <input name="class"  type="hidden" value="<?php echo $class;?>">
                <input name="section"  type="hidden" value="<?php echo $section;?>">
                <input name="rowno"  type="hidden" value="<?php echo $resultstd->num_rows;?>">

                <div class="row">
                  <div class="col s12">
                    <table class="centered bordered striped highlight z-depth-4">
                      <thead>
                          <th>No.</th>
                          <th>Admission No.</th>
                          <th>Student Name</th>
                          <th>Roll No.</th>
                      </thead>
                      <tbody>
                        
                         <?php $count = 1; while($row3 = $resultstd->fetch_assoc()) { ?>

                          <input type="hidden" name="syear_id[]" value="<?php echo $row3["syear_id"];  ?>">

                            <tr>
                            <td >
                                <input   name="sid[]"  type="hidden" value="<?php echo $row3["sid"];?>">
                                <?php echo $count; ?>
                                
                            </td>
                            <td>
                                <?php echo $row3["sadmsnno"]; ?>
                                
                            </td>
                            <td>
                              <?php echo $row3["sname"]; ?>
                            </td>
                            <td class="cPaddingLR" style="width: 200px">
                                <input class="no-margin" name="roll[]" type="text"  required  value="<?php echo $row3['sroll']; ?>" >                          
                            </td>
                            </tr>
                        <?php $count++;  } ?>
                        </tbody>
                      </table>
                  </div>
                </div>
                <div class="row">
                    <div class="input-field col offset-m9">
                         <button id="formsubmit" class="btn waves-effect waves-light blue lighten-2" type="submit">Submit
                            <i class="material-icons right">send</i>
                          </button>
                    </div>
                </div>
              </form>
        </div>




        <?php }elseif ($found=='0') { ?>
           <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text center">
                            <span class="card-title"><span style="color:#80ceff;">No student(s) found</span></span>
                        </div>
                    </div>
                </div>
            </div>
         
        <?php }  } else { ?>
            <div class="row">
                <form class="col s12" id="managerollbyclass"  action="" method="get" >
                  <input type="hidden" name="token" value="sjd54tew7hjs">
                    <div class="row">
                      <div class="input-field col s12 m5">
                            <select name="class" onchange="showUser(this.value)">

                              <option value="" >Select class</option>

                                <?php 
                                foreach ($classList as $clist) {
                                  echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                }
                                ?>
                            </select>
                            <label>Class:</label>
                        </div>                        
                        <div class="input-field col s12 m5">
                          <select name="section" id="txtHint">
                            <option value="" >Select class first</option>
                          </select>
                          <label>Section:</label>
                        </div>

                        <div class="input-field col s12 m2">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                              </button>
                        </div>
                    </div>
                </form>
            </div>
          <?php } ?>
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
  $("#update_roll_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "addscript.php",
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
            if (data.trim() !== 'Roll number succesfully updated'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else if (data.trim() === 'Roll number succesfully updated'.trim()) {

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
