<?php
//for nsk and admin
include('session.php');

include("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'addmarks';


if (isset($_GET["token"])){
    $longid1 = ($_GET["token"]);

    if ($longid1=="potgadd5m7y3ww") {

        $class_id = $_GET["c03x20"];
        $section_id = $_GET["s03x20"];
        $insert_type = $_GET["i04x20"];
        $examid = $_GET["e04x20"];
        
        $subject_id = $_GET["s04x20"];
        $month_id = $_GET["m04x20"];

        $yearid = $_GET["y04x20"];

        if (empty($class_id)) {
          ?> <script> alert('Please select class.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($section_id)) {
          ?> <script> alert('Please select section.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($examid)) {
          ?> <script> alert('Please select exam type.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($insert_type)) {
          ?> <script> alert('Please select insert type.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($yearid)) {
          ?> <script> alert('Please select year.'); window.location.href = 'addmarks.php'; </script> <?php
        }

        if ($insert_type == "subjectwise") {
          if (empty($subject_id)) {
           ?> <script> alert('Please select subject.'); window.location.href = 'addmarks.php'; </script> <?php
          }
        }

        if ($examid == 5 || $examid == 6) {
          if (empty($month_id)) {
           ?> <script> alert('Please select month.'); window.location.href = 'addmarks.php'; </script> <?php
          }
        }

        if ($insert_type == "studentwise") {
          
          $sqlstudent = "SELECT * FROM `studentinfo` 
            LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
            LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
            LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` 
            WHERE `class`.`class_id`='$class_id' AND `section`.`section_id`='$section_id' AND `studentinfo`.`status`=0 
            ORDER BY `studentinfo`.`sroll`";
          //change the class and sec to id
          $resultstudent = $db->query($sqlstudent);
          if ($resultstudent->num_rows > 0) {
          $studentfound=1; }else{ $studentfound=0; }
                                          

          $sqlsubject = "SELECT * FROM subject WHERE subject_class='$class_id' AND status=0 ORDER BY `subject`.`sort_order`";

          $resultsubject = $db->query($sqlsubject);
          if ($resultsubject->num_rows > 0) {
          $subjectfound=1; } else { $subjectfound=0; }

          $sqlinfo = "SELECT `examtype_name`,`class`.`class_name` ,`section`.`section_name`  FROM `examtype`, `class`, `section` WHERE `examtype`.`examtype_id` = '$examid' AND `class`.`class_id` = '$class_id' AND`section`.`section_id`='$section_id' ";
          $resultinfo = $db->query($sqlinfo);

        }elseif ($insert_type == "subjectwise"){

          // check marks already added

          $sqlcheck77="SELECT `marksheet_id` FROM `marksheet` 
               WHERE `mexam_id`='$examid' 
                AND `year_id`='$yearid' 
                AND `month` = '$month_id'
                AND `marksheet_class`='$class_id'
                AND `marksheet_section`='$section_id' 
                AND `msubject_id`='$subject_id'";

              $resultcheck77=mysqli_query($db, $sqlcheck77);
              $count77=mysqli_num_rows($resultcheck77);
            if($count77<1){

                //if marks not added yet proceed to add
                $sqlstudent = "SELECT * FROM `studentinfo` 
                LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
                LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` 
                WHERE `class`.`class_id`='$class_id' 
                  AND `section`.`section_id`='$section_id' 
                  AND `studentinfo`.`status`=0 
                ORDER BY `studentinfo`.`sroll`";
              //change the class and sec to id
              $resultstudent = $db->query($sqlstudent);
              if ($resultstudent->num_rows > 0) {
              $studentfound=1; }else{ $studentfound=0; }

              $sqlsubject = "SELECT `examtype_name`,`subject_id`,`subject_name`,`subject_type`, `class`.`class_name` ,`section`.`section_name`  
              FROM `examtype`,`subject`, `class`, `section` 
              WHERE `examtype`.`examtype_id` = '$examid' 
                AND `subject`.`subject_id` = '$subject_id' 
                AND `class`.`class_id` = '$class_id' 
                AND`section`.`section_id`='$section_id' ";
              $resultsubject = $db->query($sqlsubject);


              //if marks already added go to edit
            }else{ if($login_cat==1){

              ?><script> if(confirm("Marks already added,Click ok to edit mark")){ 
                window.location.href = 'addmarksupdate.php?token=amu8x008&c4x004=<?php echo $class_id; ?>&s4x004=<?php echo $section_id; ?>&e4x004=<?php echo $examid; ?>&s5x005=<?php echo $subject_id; ?>&y4x004=<?php echo $yearid; ?>&m4x004=<?php echo $month_id; ?>';
                 }else{
                  window.location.href = 'addmarks.php';
                } </script> <?php

              }else if($login_cat==2){ $msg = "Mark already added, Please contact admin for any modification."; }
            }

          


        }else{
          $_GET['token'] = "";
        }
    }
}else{

  $classList= json_decode($backstage->get_class_list());

  $resultexam = $db->query("SELECT * FROM `examtype`");

  

  $year_list = json_decode($backstage->get_academic_year_list());

  
  $cnyear = $cal['year'];

}

?>
    <!-- add header.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>
    <script>
        function showSection(str) {
          if (str == "") {
              document.getElementById("section").innerHTML = "";
              document.getElementById("subject_id").innerHTML = "";
              return;
          } else { 
              if (window.XMLHttpRequest) {
                  // code for IE7+, Firefox, Chrome, Opera, Safari
                  xmlhttp = new XMLHttpRequest();
                  xmlhttp1 = new XMLHttpRequest();
              } else {
                  // code for IE6, IE5
                  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                  xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
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


              xmlhttp1.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var selectDropdown =    $("#subject_id");
                      document.getElementById("subject_id").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp1.open("GET","../important/getListById.php?classforsubject="+str,true);
              xmlhttp1.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });


             
          }
        }


        function showSubject(value) {
          var subjectDiv=document.getElementById("subjectDiv");

          if (value == "subjectwise") {
            subjectDiv.style.display = 'block';
              return;
          } else {
            subjectDiv.style.display = 'none';
            return;
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
              if(!e['i04x20'].value) {m += '- Selecet insert type.\n';}
              if(!e['e04x20'].value) {m += '- Select exam type.\n';}
              if(!e['y04x20'].value) {m += '- Select year.\n';}

              if(e['i04x20'].value == "subjectwise") {
                if(!e['s04x20'].value) {m += '- Select subject.\n';}
              }
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
    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center"><a class="white-text text-lighten-4" href="#">Add Marks</a></div>
            </div>
        </div>
    </div>

      <?php 
    if(isset($_GET['token']) && @$_GET['token']=="potgadd5m7y3ww" && @$_GET["i04x20"]=="studentwise") {
            $rowinfo = $resultinfo->fetch_assoc(); ?>

            <div class="row">
                <div class="col s12"> 
                    <div class="card teal center lighten-2">
                        <span class="card-title white-text">Class : <?php echo $rowinfo["class_name"];?> , Sec : <?php echo $rowinfo["section_name"];?> , Exam : <?php echo $rowinfo["examtype_name"];?>
                        </span>
                    </div>
                </div>
            </div>
<!-- --------------- Add mark studentwise --------------------   -->
        <?php if ($studentfound==1  && $subjectfound==1) { ?>
        <div class="row">
            <form class="col s12" id="add_mark_form" action="addmarkscript.php" method="post" >

              <input type="hidden" name="examid" value="<?php echo $examid; ?>" >
              <input type="hidden" name="class_id"  value="<?php echo $class_id;?>" >
              <input type="hidden" name="section_id"  value="<?php echo $section_id;?>" >
              <input type="hidden" name="yearid" value="<?php echo $yearid; ?>" >
              <input type="hidden" name="month_id"  value="<?php echo $month_id;?>" >

                <div class="row">
                        <div class="col s12 m12">
                            <div class="input-field col s12">
                                <select name="studentid" id="studentid" required>
                                    <option value="" disabled>Select student</option>
                                          <?php while($row2 = $resultstudent->fetch_assoc()) { ?>
                                                      <option value="<?php echo $row2["sid"];?>">Roll no:<?php echo $row2["sroll"]."&nbsp &nbsp &nbsp Name:".$row2["sname"]."&nbsp &nbsp &nbsp Parent:".$row2["spname"];?></option>
                                                          <?php 
                                                          }
                                                          ?>

                                </select>
                                    <label>Select Student</label>
                            </div>
                        </div>
                </div><br>
              <table class="centered bordered striped highlight z-depth-4">
                <thead>
                  <tr>
                    <th rowspan="2">Subject Name</th>
                    <th rowspan="2">Obtained Mark</th>
                    <th colspan="2">Obtained Mark</th>
                    <th rowspan="2">Select/Deselect</th>
                  </tr>
                  <tr>
                    <th>Theoretical</th>
                    <th>Practical</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    ?> <input type="hidden" name="rowno" value="<?php echo $resultsubject->num_rows;?>"> <?php
                        $idcount = 0;
                        while($row3 = $resultsubject->fetch_assoc()) {
                            ?>
                            <tr>
                            <td>
                                  <input type="hidden" name="sub[<?php echo $idcount; ?>]"   value="<?php echo $row3["subject_id"];?>">
                                  <input id="ty<?php echo $idcount; ?>"  name="subject_type[]"  type="hidden" value="<?php echo $row3["subject_type"];?>">

                                <input  id="s<?php echo $idcount; ?>" type="text" value="<?php echo $row3["subject_name"];?>"  readonly >
                                
                            </td>
                            <td>
                                <input name="obtained[<?php echo $idcount; ?>]" id="o<?php echo $idcount; ?>" type="text" 

                                  <?php 
                                  echo (($row3["subject_type"]==1)? "readonly" 
                                    : (($row3["subject_type"]==3)? "placeholder='eg. A+ (type ab for absent/s for suspend)' style='border-bottom-color: #303f9f;'" 
                                      : "placeholder='eg. 25 (type ab for absent/s for suspend)' style='border-bottom-color: #303f9f;'") );
                                  ?>

                                  type="text"  class="validate" required >
                                
                            </td>
                            <td>
                                <input name="theoretical[<?php echo $idcount; ?>]" id="t<?php echo $idcount; ?>" type="text" 

                                  <?php 

                                  echo (($row3["subject_type"]==0 || $row3["subject_type"]==3)? "readonly" 
                                    : "placeholder='eg. 25 (type ab for absent/s for suspend)' style='border-bottom-color: #303f9f;'" );
                                  ?>

                                  type="text" class="validate" required >
                                
                            </td>
                            <td>
                                <input name="practical[<?php echo $idcount; ?>]" id="p<?php echo $idcount; ?>" 
                                  <?php echo (($row3["subject_type"]==0 || $row3["subject_type"]==3)? "readonly" 
                                    : "placeholder='eg. 15 (type ab for absent/s for suspend)' style='border-bottom-color: #303f9f;'" ); 
                                    ?> 
                                  type="text" class="validate" required >
                                
                            </td>
                            <td>
                              <!-- Select/deselect -->
                              <div class="switch">
                                <label>
                                  <input class="mrrorbot1" id="<?php echo $idcount; ?>" onclick="disablesubject(this.id)" type="checkbox" name="selectsub[<?php echo $idcount; ?>]" checked >
                                  <span class="lever"></span>
                                </label>
                              </div>                          
                            </td>
                            </tr>
                            <?php 
                            $idcount++;
                        } ?>
                  </tbody>
                </table>

                <div class="row">

                  <input type="hidden" name="add_mark_studentwise" value="add_mark_studentwise">

                    <div class="input-field col offset-m9">
                         <button class="btn waves-effect waves-light blue lighten-2" type="submit">Submit
                            <i class="material-icons right">send</i>
                          </button>
                        </div>

                </div>
            </form>
        </div>
        <?php } else { ?>
                <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;"><?php if ($studentfound==0) { echo "Student list "; }elseif ($subjectfound==0) { echo "Subject list "; } ?>is empty!!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
<!-- --------------- Add mark Subjectwise ---------------------- -->
        <?php } 
    }elseif(isset($_GET['token']) && @$_GET['token']=="potgadd5m7y3ww" && @$_GET['i04x20']=="subjectwise") {
        if ($studentfound==1) { 
          $rowsubj = $resultsubject->fetch_assoc(); ?>

          <div class="row">
                <div class="col s12"> 
                    <div class="card teal center lighten-2">
                        <span class="card-title white-text">Class : <?php echo $rowsubj["class_name"];?> , Sec : <?php echo $rowsubj["section_name"];?> , Exam : <?php echo $rowsubj["examtype_name"];?> , Subject : <?php echo $rowsubj["subject_name"];?>
                        </span>
                    </div>
                </div>
          </div>

          <div class="row">
            <form class="col s12" id="add_mark_form_subjectwise" action="addmarkscript.php" method="post" >

              <input type="hidden" name="examid" value="<?php echo $examid; ?>" >
              <input type="hidden" name="class_id"  value="<?php echo $class_id; ?>" >
              <input type="hidden" name="section_id"  value="<?php echo $section_id; ?>" >
              <input type="hidden" name="yearid" value="<?php echo $yearid; ?>" >
              <input type="hidden" name="month_id"  value="<?php echo $month_id; ?>" >
              <input type="hidden" name="subject_id"  value="<?php echo $rowsubj["subject_id"]; ?>" >
              <input type="hidden" name="subject_type"  value="<?php echo $rowsubj["subject_type"]; ?>" >

              <input type="hidden" name="rowno" value="<?php echo $resultstudent->num_rows;?>">


              <div class="row">
                  <div class="col s12">
                    <table class="bordered striped highlight z-depth-4">
                      <thead>
                          <th>Roll No.</th>
                          <th>Student Name</th>
                          <?php if ($rowsubj["subject_type"] == 0 || $rowsubj["subject_type"] == 3) {
                                    echo "<th>Obtained Mark</th>";
                                  }elseif ($rowsubj["subject_type"] == 1) {
                                    echo "<th>Th. obtained Mark</th><th>Pr. obtained Mark</th>";
                                  } ?>
                          <th>Select/Deselect</th>
                          
                      </thead>
                      <tbody>
                        <?php 
                        $idcount = 0;
                        while($row = $resultstudent->fetch_assoc()) { ?>

                            <tr>
                            <td class="cPaddingLR" style="width: 15%">
                                <input   name="sid[]"  type="hidden" value="<?php echo $row["sid"];?>">
                                <?php echo $row["sroll"]; ?>
                                
                            </td>
                            <td class="cPaddingLR" style="width: 45%">
                                <?php echo $row["sname"]; ?>
                                
                            </td>

                            <?php if ($rowsubj["subject_type"] == 0) { ?>
                              <td class="cPaddingLR" style="width: 40%">
                                <input class="no-margin" name="obtained[]" type="text" placeholder="eg. 85 (type ab for absent/s for suspend)" required  >                          
                              </td>
                            <?php }else if ($rowsubj["subject_type"] == 3) { ?>
                              <td class="cPaddingLR" style="width: 40%">
                                <input class="no-margin" name="obtained[]" type="text" placeholder="eg. A+ (type ab for absent/s for suspend)" required  >                          
                              </td>
                            <?php }else if ($rowsubj["subject_type"] == 1) { ?>

                              <td class="cPaddingLR" style="width: 20%">
                                  <input class="no-margin" name="theoretical[]" type="text" placeholder="eg. 65 (type ab for absent/s for suspend)" required >                          
                              </td>

                              <td class="cPaddingLR" style="width: 20%">
                                  <input class="no-margin" name="practical[]" type="text" placeholder="eg. 15 (type ab for absent/s for suspend)" required >                          
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
                            <?php 
                          $idcount++;
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="row">

                  <input type="hidden" name="add_mark_subjectwise" value="add_mark_subjectwise">

                    <div class="input-field col offset-m9">
                         <button class="btn waves-effect waves-light blue lighten-2" type="submit">Submit
                            <i class="material-icons right">send</i>
                          </button>
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
    }else{ ?>
                <div class="row">
                  <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Please select all the fields</span></span>


                            <form  method="get" action="" onsubmit="return validate(this);" >
                              <input type="hidden" name="token" value="potgadd5m7y3ww">
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
                                          <select name="i04x20" id="insert_type" onchange="showSubject(this.value)" >
                                              <option value="" >Insert type</option>
                                              <option value="studentwise">Student Wise</option>
                                              <option value="subjectwise">Subject Wise</option>
                                          </select>
                                              <label>Insert Type</label>
                                </div>
                                <div class="input-field col s12 m6">
                                          <select name="e04x20" id="examid" onchange="showMonth(this.value)" >
                                              <option value="" disabled>Select exam</option>
                                                    <?php if ($resultexam->num_rows > 0) {
                                                      while($row1 = $resultexam->fetch_assoc()) { ?>
                                                                <option value="<?php echo $row1["examtype_id"];?>"><?php echo $row1["examtype_name"];?></option>
                                                    <?php } } ?>

                                          </select>
                                              <label>Select Exam</label>
                                  </div>

                                  <div style="display: none;"  id="subjectDiv" class="input-field col s12 m6">
                                    <select name="s04x20" id="subject_id" >
                                        <option value="" >Select class first</option>
                                    </select>
                                    <label>Subject:</label>
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
                                  <div class="input-field col s12 m6">
                                      <select name="y04x20" id="yearid" >
                                          <option value="">Select year</option>
                                          <?php foreach ($year_list as $yearlist) { ?>
                                              <option value="<?php echo $yearlist->id; ?>" <?php echo (($yearlist->single_year==$cnyear)?'selected="selected"':''); ?> > <?php echo $yearlist->year; ?> </option>
                                          <?php } ?>
                                      </select>
                                          <label>Select year</label>
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
    function disablesubject(id)
    {

      var subject=document.getElementById("s"+id);
      var stype=document.getElementById("ty"+id).value;

      var th = document.getElementById("t"+id);
      var pr = document.getElementById("p"+id);
      var ob = document.getElementById("o"+id);

      if (stype==0 || stype==3) {
        if (subject.style.color === "red") {
        subject.style.color = "black";
        ob.removeAttribute("readonly");

        } else {
        subject.style.color = "red";
        ob.setAttribute("readonly",true);
        ob.value = "";
        }

      }else if (stype==1){

        if (subject.style.color === "red") {
        subject.style.color = "black";
        th.removeAttribute("readonly");
        pr.removeAttribute("readonly");

        } else {
        subject.style.color = "red";
        th.setAttribute("readonly",true);
        pr.setAttribute("readonly",true);
        th.value = "";
        pr.value = "";

        }

      }     
    }
    function disableStudent(id)
    {

      /*var subject=document.getElementById("s"+id);
      var stype=document.getElementById("ty"+id).value;

      var th = document.getElementById("t"+id);
      var pr = document.getElementById("p"+id);
      var ob = document.getElementById("o"+id);

      if (stype==0 || stype==3) {
        if (subject.style.color === "red") {
        subject.style.color = "black";
        ob.removeAttribute("readonly");

        } else {
        subject.style.color = "red";
        ob.setAttribute("readonly",true);
        ob.value = "";
        }

      }else if (stype==1){

        if (subject.style.color === "red") {
        subject.style.color = "black";
        th.removeAttribute("readonly");
        pr.removeAttribute("readonly");

        } else {
        subject.style.color = "red";
        th.setAttribute("readonly",true);
        pr.setAttribute("readonly",true);
        th.value = "";
        pr.value = "";

        }

      }     */
    }
</script>


<script>
  $(document).ready(function (e) 
  {
    $("#add_mark_form").on('submit',(function(e) 
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
            },
            success: function(data)
            {
              //alert(data);
              if (data.trim() !== 'Mark succesfully added'.trim()) {

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
                if (data.trim() === 'Mark succesfully added'.trim()) {

                window.location.href =  window.location.href;
              }
            },
            error: function(e) 
            {
              alert('Sorry Try Again !!');
            }          
      });
    }));

    $("#add_mark_form_subjectwise").on('submit',(function(e) 
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
            },
            success: function(data)
            {
              //alert(data);
              if (data.trim() !== 'Mark succesfully added'.trim()) { 
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
                if (data.trim() === 'Mark succesfully added'.trim()) {

                window.location.href = 'addmarks.php';
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