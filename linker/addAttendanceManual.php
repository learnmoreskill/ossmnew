<?php
//for nsk and admin
include('session.php');

include("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'addAttendanceManual';

  //=========== ADD NEW MARKS( MARKS NOT ADDED YET ) ===========================
if (isset($_GET["token"]) && $_GET["token"] == "potgadd5m7y3ww"){

        $class_id = $_GET["c03x20"];
        $section_id = $_GET["s03x20"];
        $exam_id = $_GET["e04x20"];

        $year_id = $_GET["y04x20"];
        $month_id = $_GET["m04x20"];

        

        if (empty($class_id)) {
          ?> <script> alert('Please select class.'); window.location.href = 'addAttendanceManual.php'; </script> <?php
        }elseif (empty($section_id)) {
          ?> <script> alert('Please select section.'); window.location.href = 'addAttendanceManual.php'; </script> <?php
        }elseif (empty($exam_id)) {
          ?> <script> alert('Please select exam type.'); window.location.href = 'addAttendanceManual.php'; </script> <?php
        }elseif (empty($year_id)) {
          ?> <script> alert('Please select year.'); window.location.href = 'addAttendanceManual.php'; </script> <?php
        }

        if ($exam_id == 5 || $exam_id == 6) {
          if (empty($month_id)) {
           ?> <script> alert('Please select month.'); window.location.href = 'addAttendanceManual.php'; </script> <?php
          }
        }

            

              // check marks already added
              $resultcheck77=mysqli_query($db, "SELECT `id` FROM `attendance_manual` 
               WHERE `exam_id`='$exam_id' 
                AND `year_id`='$year_id' 
                AND `month_id` = '$month_id'
                AND `class_id`='$class_id'
                AND `section_id`='$section_id' ");
              $count77=mysqli_num_rows($resultcheck77);

            if($count77<1){

              //IF ATTENDANCE NOT ADDED YET PROCEED TO ADD
               
              $resultstudent = $db->query("SELECT `studentinfo`.* FROM `studentinfo` 
                INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
                        AND `syearhistory`.`year_id` = '$year_id'
                        AND `syearhistory`.`class_id` = '$class_id'
                        AND `syearhistory`.`section_id` = '$section_id'
                WHERE `studentinfo`.`status` = 0 
                ORDER BY `syearhistory`.`roll_no`");

              if ($resultstudent->num_rows > 0) {
              $studentfound=1; }else{ $studentfound=0; }

              //FOR INFORMATION TO SHOW
              $resultinfo = $db->query("SELECT `class`.`class_name` ,`section`.`section_name`,`examtype_name` FROM `examtype`, `class`, `section` WHERE `class`.`class_id` = '$class_id' AND `section`.`section_id`='$section_id' AND `examtype`.`examtype_id` = '$exam_id' ");
              $rowinfo = $resultinfo->fetch_assoc();

            //IF ATTENDANCE ALREADY ADDED GO TO EDIT / VIEW
            }else{

              if($login_cat==1 || $pac['edit_attendance']){ $confirmMsg = "Attendance already added,Click ok to edit attendance";
              }else{  $confirmMsg = "Attendance already added,Click ok to view attendance";  }

              ?><script> 
                  if(confirm("<?php echo $confirmMsg; ?>")){
                    window.location.href = 'addAttendanceManual.php?token=amu8x008&c4x004=<?php echo $class_id; ?>&s4x004=<?php echo $section_id; ?>&e4x004=<?php echo $exam_id; ?>&y4x004=<?php echo $year_id; ?>&m4x004=<?php echo $month_id; ?>';
                  }else{
                    window.location.href = 'addAttendanceManual.php';
                  } 
                </script> <?php
            }

  //Attendance ALREADY ADDED AND EDIT ADDED Attendance
}else if (isset($_GET["token"]) && $_GET["token"] == "amu8x008"){

        $class_id = $_GET["c4x004"];
        $section_id = $_GET["s4x004"];
        $exam_id = $_GET["e4x004"];
        

        $year_id = $_GET["y4x004"];
        $month_id = $_GET["m4x004"];
        if (empty($month_id)) { $month_id=0; }


            $resultstudent = $db->query("SELECT `attendance_manual`.`id`,`studentinfo`.`sid`,`studentinfo`.`sroll`,`studentinfo`.`sname`,`attendance_manual`.`count` 
            FROM `studentinfo`
            LEFT JOIN `attendance_manual` 
              ON `studentinfo`.`sid` = `attendance_manual`.`student_id`
              AND `attendance_manual`.`exam_id` ='$exam_id'
              AND `attendance_manual`.`year_id` ='$year_id' 
              AND `attendance_manual`.`month_id` ='$month_id' 

            INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
                        AND `syearhistory`.`year_id` = '$year_id'
                        AND `syearhistory`.`class_id` = '$class_id'
                        AND `syearhistory`.`section_id` = '$section_id'
            WHERE `studentinfo`.`status` = 0
                 
            ORDER BY `syearhistory`.`roll_no`");

              if ($resultstudent->num_rows > 0) {
              $studentfound=1; }else{ $studentfound=0; }



            //FOR INFORMATION TO SHOW
            $resultinfo = $db->query("SELECT `class`.`class_name` ,`section`.`section_name`,`examtype_name`  FROM `examtype`, `class`, `section` WHERE `class`.`class_id` = '$class_id' AND `section`.`section_id`='$section_id' AND `examtype`.`examtype_id` = '$exam_id' ");
           $rowinfo = $resultinfo->fetch_assoc();

  //By default add marks page (FIRST PAGE)
}else{

  $year_id = $current_year_session_id;

  $classList= json_decode($backstage->get_class_list_by_year_id($year_id));

  $examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));

}

?>
    <!-- add header.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>
    <script>
        function showSection(str) {
          if (str == "") {
              document.getElementById("section").innerHTML = "";
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
                      var selectDropdown =    $("#section");
                      document.getElementById("section").innerHTML = this.responseText;
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
        function validate(form) {
          var e = form.elements, m = '';

              if(!e['c03x20'].value) {m += '- Select class name.\n';}
              if(!e['s03x20'].value) {m += '- Select section.\n';}
              if(!e['e04x20'].value) {m += '- Select exam type.\n';}
              if(!e['y04x20'].value) {m += '- Select year.\n';}

              if(e['e04x20'].value =="5" || e['e04x20'].value =="6") {
                if(!e['m04x20'].value) {m += '- Select month.\n';}
              }
              
              if(m) {
                alert('The following error(s) occurred:\n\n' + m);
                return false;
              }else
              return true;
            }
    </script>
    
  <main>
    <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center"><a class="white-text text-lighten-4" href="#"><?php 
                          echo  (  (isset($_GET["token"]) && $_GET["token"] == "potgadd5m7y3ww")? 
                                  'Add Attendance'
                                  : ( (isset($_GET["token"]) && $_GET["token"] == "amu8x008")? 

                                      ( ($login_cat==1 || $pac['edit_attendance'])? 
                                        'Update attendance'
                                        : 'View attendance'
                                      ) 
                                      : 'Add attendance' 
                                    ) 
                                );

                          ?></a>
                </div>
            </div>
        </div>
    </div>

      <?php
    if(isset($_GET['token']) && (@$_GET['token']=="potgadd5m7y3ww" || @$_GET['token']=="amu8x008" )  ) {
        if ($studentfound==1) {  ?>

          <div class="row">
                <div class="col s12"> 
                    <div class="card teal center lighten-2">
                        <span class="card-title white-text">
                          <?php 
                          echo  (  (isset($_GET["token"]) && $_GET["token"] == "potgadd5m7y3ww")? 
                                  'Add Attendance of class '.$rowinfo['class_name']. ' sec '.$rowinfo["section_name"].' for '.$rowinfo['examtype_name']
                                  : ( (isset($_GET["token"]) && $_GET["token"] == "amu8x008")? 

                                      ( ($login_cat==1 || $pac['edit_mark'])? 
                                        'Update the attendance of the class '.$rowinfo['class_name']. ' sec '.$rowinfo["section_name"].' for '.$rowinfo['examtype_name']
                                        : 'Attendance of the class '.$rowinfo['class_name']. ' sec '.$rowinfo["section_name"].' for '.$rowinfo['examtype_name']
                                      ) 
                                      : '' 
                                    ) 
                                );

                          ?>
                        </span>
                    </div>
                </div>
          </div>
          <!-- FOR ADD AND EDIT -->
          <div class="row">
            <form class="col s12" id="add_attendance_form" action="addAttendanceManualscript.php" method="post" >

              <input type="hidden" name="update_attendance_hackster"  value="update_attendance_hackster" >

              <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" >
              <input type="hidden" name="class_id"  value="<?php echo $class_id; ?>" >
              <input type="hidden" name="section_id"  value="<?php echo $section_id; ?>" >
              <input type="hidden" name="year_id" value="<?php echo $year_id; ?>" >
              <input type="hidden" name="month_id"  value="<?php echo $month_id; ?>" >

              <input type="hidden" name="rowno" value="<?php echo $resultstudent->num_rows;?>">

              <div class="row"><h6>Total Attendance Count</h6><input class="col s2" type="text" id="total_attendance" name="total_attendance" placeholder="eg. 100" required></div>


              <div class="row">
                  <div class="col s12">
                    <table class="bordered striped highlight z-depth-4">
                      <thead>
                          <th>Roll No.</th>
                          <th>Student Name</th>
                
                          <th>Present Count</th>
                          <th>Remove/Select</th>
                          
                      </thead>
                      <tbody>
                        <?php 
                        $idcount = 0;
                        while($row = $resultstudent->fetch_assoc()) { 

                          list($pCOunt, $totalCount) = explode('/', $row['count']);
                          if ($totalCount) {
                            $total_attendance = $totalCount;
                          }

                          ?>

                          <input type="hidden" name="attendance_id[<?php echo $idcount; ?>]" value="<?php echo $row["id"];?>" >
                          <input type="hidden" name="sid[<?php echo $idcount; ?>]" value="<?php echo $row["sid"];?>" >

                            <tr>
                            <td class="cPaddingLR" >
                                <?php echo $row["sroll"]; ?>
                                
                            </td>
                            <td id="sname<?php echo $idcount; ?>" class="cPaddingLR" >
                                <?php echo $row["sname"]; ?>
                                
                            </td>

                              <td class="cPaddingLR" >
                                <input class="no-margin" name="count[<?php echo $idcount; ?>]" 
                                id="count<?php echo $idcount; ?>" type="number" required class="validate"
                                placeholder="eg. 85" 
                                value="<?php  echo $pCOunt; ?>" <?php echo ((isset($_GET["token"]) && $_GET["token"] == "amu8x008")? ((empty($row["id"]))? 'readonly':'' ) : ''); ?>  >                          
                              </td>

                              <!-- Select/deselect -->
                              <td>
                                <div class="switch">
                                  <label>
                                    <input class="mrrorbot1" id="<?php echo $idcount; ?>" onclick="disableStudent(this.id)" type="checkbox" name="selectstd[<?php echo $idcount; ?>]" 
                                    <?php echo (  (isset($_GET["token"]) && $_GET["token"] == "amu8x008")? 
                                                    ( ($row["id"] )?  'checked' : '' ) 
                                                    : 'checked');  ?> 

                                    >
                                    <span class="lever"></span>
                                  </label>
                                </div>                          
                              </td>

                            </tr>
                            <?php 
                          $idcount++;
                        } 
                        ?>
                        <script type="text/javascript">
                          var total_attendance=document.getElementById("total_attendance");
                          total_attendance.value = <?php echo $total_attendance; ?>;
                        </script>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="row">
                  <div id="submit_div" class="input-field col offset-m10">
                    <?php if (isset($_GET["token"]) && $_GET["token"] == "amu8x008") {
                          if ($login_cat==1 || $pac['edit_attendance']){ ?>

                        <input type="hidden" name="request" value="update_attendance_table" >
                        <button class="btn waves-effect waves-light blue lighten-2" type="submit" >Update
                        <i class="material-icons right">send</i>

                    <?php } }else{ ?>
                        <input type="hidden" name="request" value="add_attendance_table" >
                        <button class="btn waves-effect waves-light blue lighten-2" type="submit" >Submit
                          <i class="material-icons right">send</i>
                        </button>
                    <?php } ?>
                  </div>

                </div>
            </form>
          </div>
          <?php 
        } else { ?>
                <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;"><?php if ($studentfound==0) { echo "Student list "; } ?>is empty!!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
          <?php 
        }

      //========= By default select Attendance page ===============
    }else{ ?>
                <div class="row">
                  <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Please select all the fields</span></span>


                            <form  method="get" action="" onsubmit="return validate(this);" >
                              <input type="hidden" name="token" value="potgadd5m7y3ww">

                              <input type="hidden" name="y04x20" id="year_id"  value="<?php echo $year_id; ?>" >


                              <div class="row">
                                <div class="input-field col s12 m6">
                                    <select id="classname" name="c03x20" onchange="showSection(this.value)">
                                            <option value="" >Select class</option>
                                            <?php foreach ($classList as $clist) {
                                                    echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                              }
                                            ?>
                                      </select>
                                      <label>Select Class</label>
                                </div>
                                <div class="input-field col s12 m6">
                                    <select name="s03x20" id="section">
                                        <option value="" >Select class first</option>
                                    </select>
                                    <label>Section:</label>
                                </div>




                                  <div class="input-field col s12 m6">
                                          <select name="e04x20" id="exam_id" onchange="showMonth(this.value)" >
                                              <option value="" disabled>Select exam</option>
                                                    <?php foreach ($examTypeList as $examlist) {
                                                            echo '<option value="'.$examlist->examtype_id.'"> ' . $examlist->examtype_name. ' </option>';
                                                          }   ?>

                                          </select>
                                              <label>Select Exam</label>
                                  </div>

                            
                                  <div style="display: none;"  id="monthDiv" class="input-field col s12 m6">
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
                              
                                <button id="btnSubmit" class="btn waves-effect waves-light blue lighten-2" type="submit">Next</button>
                            </form>
                        </div>
                        <div class="card-action">

                        </div>
                    </div>
                  </div>
                </div>
        <?php 
    } ?>

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

<script type="text/javascript">
    function disableStudent(id)
    {

      var selectbtn=document.getElementById(id).checked;
      var sname=document.getElementById("sname"+id);
     
      var count = document.getElementById("count"+id);
      
        if (selectbtn) {
        sname.style.color = "black";
        count.removeAttribute("readonly");

        } else {
        sname.style.color = "red";
        count.setAttribute("readonly",true);
        count.value = "";
        }
    }
</script>


<script>
  $(document).ready(function (e) 
  {
    $("#add_attendance_form").on('submit',(function(e) 
    {
      e.preventDefault();
      $.ajax
      ({
            url: "addAttendanceManualScript.php",
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
              if (data.trim() !== 'Attendance succesfully updated'.trim()) { 
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
                if (data.trim() === 'Attendance succesfully updated'.trim()) {

                window.location.href = 'addAttendanceManual.php';
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