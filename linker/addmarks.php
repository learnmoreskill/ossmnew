<?php
//for nsk and admin
include('session.php');

include("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'addmarks';

  //=========== ADD NEW MARKS( MARKS NOT ADDED YET ) ===========================
if (isset($_GET["token"]) && $_GET["token"] == "potgadd5m7y3ww"){

        $class_id = $_GET["c03x20"];
        $section_id = $_GET["s03x20"];
        $insert_type = $_GET["i04x20"];
        $exam_id = $_GET["e04x20"];
        
        $subject_id = $_GET["s04x20"];

        $year_id = $_GET["y04x20"];
        $month_id = $_GET["m04x20"];

        

        if (empty($class_id)) {
          ?> <script> alert('Please select class.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($section_id)) {
          ?> <script> alert('Please select section.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($exam_id)) {
          ?> <script> alert('Please select exam type.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($insert_type)) {
          ?> <script> alert('Please select insert type.'); window.location.href = 'addmarks.php'; </script> <?php
        }elseif (empty($year_id)) {
          ?> <script> alert('Please select year.'); window.location.href = 'addmarks.php'; </script> <?php
        }

        if ($insert_type == "subjectwise") {
          if (empty($subject_id)) {
           ?> <script> alert('Please select subject.'); window.location.href = 'addmarks.php'; </script> <?php
          }
        }

        if ($exam_id == 5 || $exam_id == 6) {
          if (empty($month_id)) {
           ?> <script> alert('Please select month.'); window.location.href = 'addmarks.php'; </script> <?php
          }
        }

            

            // check Exam table created or not
            $resultcheck78=mysqli_query($db, "SELECT `examtable_id` FROM `examtable` 
               WHERE `exam_type`='$exam_id' 
                AND `year_id`='$year_id' 
                AND `month` = '$month_id'
                AND `class_name`='$class_id' 
                AND `subject`='$subject_id'");
              $count78=mysqli_num_rows($resultcheck78);

              // EXAM TABLE CREATED THEN
            if($count78>0){

              // check marks already added
              $resultcheck77=mysqli_query($db, "SELECT `marksheet_id` FROM `marksheet` 
               WHERE `mexam_id`='$exam_id' 
                AND `year_id`='$year_id' 
                AND `month` = '$month_id'
                AND `marksheet_class`='$class_id'
                AND `marksheet_section`='$section_id' 
                AND `msubject_id`='$subject_id'");
              $count77=mysqli_num_rows($resultcheck77);

            if($count77<1){

              //IF MARKS NOT ADDED YET PROCEED TO ADD
               
              $resultstudent = $db->query("SELECT * FROM `studentinfo` 
                WHERE `sclass` = '$class_id' 
                  AND `ssec` = '$section_id' 
                  AND `studentinfo`.`status`= 0 
                ORDER BY `studentinfo`.`sroll`");

              if ($resultstudent->num_rows > 0) {
              $studentfound=1; }else{ $studentfound=0; }

              //FOR INFORMATION TO SHOW
              $resultinfo = $db->query("SELECT `class`.`class_name` ,`section`.`section_name`,`examtype_name`,`subject_name`  FROM `examtype`, `class`, `section`,`subject` WHERE `class`.`class_id` = '$class_id' AND `section`.`section_id`='$section_id' AND `examtype`.`examtype_id` = '$exam_id' AND `subject`.`subject_id`='$subject_id' ");
              $rowinfo = $resultinfo->fetch_assoc();

              $subjectRow = json_decode($backstage->get_subject_details_by_subject_id($subject_id));
              $subject_type = $subjectRow->subject_type;

              $subjectMarkTableRow = json_decode($backstage->get_subject_mark_details_by_examtype_id_subject_id_year_id($exam_id,$subject_id,$year_id));


              //IF MARKS ALREADY ADDED GO TO EDIT / VIEW
            }else{

              if($login_cat==1 || $pac['edit_mark']){ $confirmMsg = "Marks already added,Click ok to edit mark";
              }else{  $confirmMsg = "Marks already added,Click ok to view mark";  }

              ?><script> 
                  if(confirm("<?php echo $confirmMsg; ?>")){
                    window.location.href = 'addmarks.php?token=amu8x008&c4x004=<?php echo $class_id; ?>&s4x004=<?php echo $section_id; ?>&e4x004=<?php echo $exam_id; ?>&s5x005=<?php echo $subject_id; ?>&y4x004=<?php echo $year_id; ?>&m4x004=<?php echo $month_id; ?>';
                  }else{
                    window.location.href = 'addmarks.php';
                  } 
                </script> <?php
            }
            // EXAM TABLE NOT CREATED THEN
          }else{ ?><script type="text/javascript">
                    alert('Sorry, Exam time table is not available for this exam,Please check Exam time table.');
                    window.location.href = 'addmarks.php';            
                  </script><?php 
          }
  //MARKS ALREADY ADDED AND EDIT ADDED MARKS
}else if (isset($_GET["token"]) && $_GET["token"] == "amu8x008"){

        $class_id = $_GET["c4x004"];
        $section_id = $_GET["s4x004"];
        $exam_id = $_GET["e4x004"];
        
        $subject_id = $_GET["s5x005"];

        $year_id = $_GET["y4x004"];
        $month_id = $_GET["m4x004"];
        if (empty($month_id)) { $month_id=0; }


            $resultstudent = $db->query("SELECT `marksheet`.`marksheet_id`,`studentinfo`.`sid`,`studentinfo`.`sroll`,`studentinfo`.`sname`,`marksheet`.`m_theory`,`marksheet`.`m_practical`,`marksheet`.`m_mt`,`marksheet`.`m_ot`,`marksheet`.`m_eca`,`marksheet`.`m_lp`,`marksheet`.`m_nb`,`marksheet`.`m_se`,`marksheet`.`m_obtained_mark` 
            FROM `studentinfo`
            LEFT JOIN `marksheet` 
              ON `studentinfo`.`sid` = `marksheet`.`mstudent_id`
              AND `marksheet`.`mexam_id` ='$exam_id'
              AND `marksheet`.`msubject_id` ='$subject_id'
              AND `marksheet`.`year_id` ='$year_id' 
              AND `marksheet`.`month` ='$month_id' 

            INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
                        AND `syearhistory`.`year_id` = '$year_id'
                        AND `syearhistory`.`class_id` = '$class_id'
                        AND `syearhistory`.`section_id` = '$section_id'
            WHERE `studentinfo`.`status` = 0
                 
            ORDER BY `studentinfo`.`sroll`");

              if ($resultstudent->num_rows > 0) {
              $studentfound=1; }else{ $studentfound=0; }



            //FOR INFORMATION TO SHOW
            $resultinfo = $db->query("SELECT `class`.`class_name` ,`section`.`section_name`,`examtype_name`,`subject_name`  FROM `examtype`, `class`, `section`,`subject` WHERE `class`.`class_id` = '$class_id' AND `section`.`section_id`='$section_id' AND `examtype`.`examtype_id` = '$exam_id' AND `subject`.`subject_id`='$subject_id' ");
           $rowinfo = $resultinfo->fetch_assoc();

           $subjectRow = json_decode($backstage->get_subject_details_by_subject_id($subject_id));
           $subject_type = $subjectRow->subject_type;

           $subjectMarkTableRow = json_decode($backstage->get_subject_mark_details_by_examtype_id_subject_id_year_id($exam_id,$subject_id,$year_id));


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
    <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center"><a class="white-text text-lighten-4" href="#"><?php 
                          echo  (  (isset($_GET["token"]) && $_GET["token"] == "potgadd5m7y3ww")? 
                                  'Add marks'
                                  : ( (isset($_GET["token"]) && $_GET["token"] == "amu8x008")? 

                                      ( ($login_cat==1 || $pac['edit_mark'])? 
                                        'Update marks'
                                        : 'View marks'
                                      ) 
                                      : 'Add marks' 
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
                                  'Add marks for the class '.$rowinfo['class_name']. ' sec '.$rowinfo["section_name"].' of subject '.$rowinfo['subject_name'].' on '.$rowinfo['examtype_name']
                                  : ( (isset($_GET["token"]) && $_GET["token"] == "amu8x008")? 

                                      ( ($login_cat==1 || $pac['edit_mark'])? 
                                        'Update the marks obtained by the class '.$rowinfo['class_name']. ' sec '.$rowinfo["section_name"].' of subject '.$rowinfo['subject_name'].' on '.$rowinfo['examtype_name']
                                        : 'Marks obtained by the class '.$rowinfo['class_name']. ' sec '.$rowinfo["section_name"].' of subject '.$rowinfo['subject_name'].' on '.$rowinfo['examtype_name']
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
            <form class="col s12" id="add_mark_form" action="addmarkscript.php" method="post" >

              <input type="hidden" name="update_marks_hackster"  value="update_marks_hackster" >

              <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" >
              <input type="hidden" name="class_id"  value="<?php echo $class_id; ?>" >
              <input type="hidden" name="section_id"  value="<?php echo $section_id; ?>" >
              <input type="hidden" name="year_id" value="<?php echo $year_id; ?>" >
              <input type="hidden" name="month_id"  value="<?php echo $month_id; ?>" >
              <input type="hidden" name="subject_id"  value="<?php echo $subject_id; ?>" >
              <input type="hidden" name="subject_type" id="subject_type"  value="<?php echo $subject_type; ?>" >

              <input type="hidden" name="rowno" value="<?php echo $resultstudent->num_rows;?>">


              <div class="row">
                  <div class="col s12">
                    <table class="bordered striped highlight z-depth-4">
                      <thead>
                          <th>Roll No.</th>
                          <th>Student Name</th>
                          <?php if ($subject_type == 0 || $subject_type == 3) {
                                    echo "<th>Obtained Mark</th>";
                                  }elseif ($subject_type == 1) {
                                    echo "<th>Th. obtained Mark</th><th>Pr. obtained Mark</th>";
                                  } ?>


                          <?php echo (  ($subjectMarkTableRow->mt)? "<th>M.Test.</th>" : "" ); ?>
                          <?php echo (  ($subjectMarkTableRow->ot)? "<th>O.T.</th>" : "" ); ?>
                          <?php echo (  ($subjectMarkTableRow->eca)? "<th>E.C.A.</th>" : "" ); ?>
                          <?php echo (  ($subjectMarkTableRow->lp)? "<th>L.P.</th>" : "" ); ?>
                          <?php echo (  ($subjectMarkTableRow->nb)? "<th>N.B.</th>" : "" ); ?>
                          <?php echo (  ($subjectMarkTableRow->se)? "<th>S.E.</th>" : "" ); ?>



                          <th>Remove/Select</th>
                          
                      </thead>
                      <tbody>
                        <?php 
                        $idcount = 0;
                        while($row = $resultstudent->fetch_assoc()) { ?>

                          <input type="hidden" name="marksheet_id[<?php echo $idcount; ?>]" value="<?php echo $row["marksheet_id"];?>" >
                          <input type="hidden" name="sid[<?php echo $idcount; ?>]" value="<?php echo $row["sid"];?>" >

                            <tr>
                            <td class="cPaddingLR" >
                                <?php echo $row["sroll"]; ?>
                                
                            </td>
                            <td id="sname<?php echo $idcount; ?>" class="cPaddingLR" >
                                <?php echo $row["sname"]; ?>
                                
                            </td>


                            <?php if ($subject_type == 0) { ?>
                              <td class="cPaddingLR" >
                                <input class="no-margin" name="theoretical[<?php echo $idcount; ?>]" 
                                id="o<?php echo $idcount; ?>" type="text" required class="validate" max="2"
                                placeholder="eg. 85 (type ab for absent/s for suspend)" 
                                value="<?php echo $row['m_theory']; ?>" <?php echo ((isset($_GET["token"]) && $_GET["token"] == "amu8x008")? ((empty($row["marksheet_id"]))? 'readonly':'' ) : ''); ?>  >                          
                              </td>
                            <?php }else if ($subject_type == 3) { ?>
                              <td class="cPaddingLR" >
                                <input class="no-margin" name="theoretical[<?php echo $idcount; ?>]" 
                                id="o<?php echo $idcount; ?>" type="text" required
                                placeholder="eg. A+ (type ab for absent/s for suspend)" 
                                value="<?php echo $row['m_theory']; ?>" <?php echo ((isset($_GET["token"]) && $_GET["token"] == "amu8x008")? ((empty($row["marksheet_id"]))? 'readonly':'' ) : ''); ?>  >                          
                              </td>
                            <?php }else if ($subject_type == 1) { ?>

                              <td class="cPaddingLR" >
                                  <input class="no-margin" name="theoretical[<?php echo $idcount; ?>]" 
                                  id="t<?php echo $idcount; ?>" type="text" required 
                                  placeholder="eg. 65 (type ab for absent/s for suspend)" 
                                  value="<?php echo $row['m_theory']; ?>" <?php echo ((isset($_GET["token"]) && $_GET["token"] == "amu8x008")? ((empty($row["marksheet_id"]))? 'readonly':'' ) : ''); ?> >                          
                              </td>

                              <td class="cPaddingLR" >
                                  <input class="no-margin" name="practical[<?php echo $idcount; ?>]" 
                                  id="p<?php echo $idcount; ?>" type="text" required
                                  placeholder="eg. 15 (type ab for absent/s for suspend)" 
                                  value="<?php echo $row['m_practical']; ?>" <?php echo ((isset($_GET["token"]) && $_GET["token"] == "amu8x008")? ((empty($row["marksheet_id"]))? 'readonly':'' ) : ''); ?>  >                          
                              </td>

                              <?php } ?>

                              <?php  if ($subjectMarkTableRow->mt) { ?>
                                <td class="cPaddingLR" >
                                  <input class="no-margin" name="mt[<?php echo $idcount; ?>]" 
                                  type="text" id="mt<?php echo $idcount; ?>"
                                  placeholder="eg. 10 (leave empty for absent)" 
                                  value="<?php echo $row['m_mt']; ?>" 
                                   >
                                </td>
                                
                              <?php } ?>
                              <?php  if ($subjectMarkTableRow->ot) { ?>
                                <td class="cPaddingLR" >
                                  <input class="no-margin" name="ot[<?php echo $idcount; ?>]" 
                                  type="text" id="ot<?php echo $idcount; ?>"
                                  placeholder="eg. 10 (leave empty for absent)" 
                                  value="<?php echo $row['m_ot']; ?>" 
                                   >
                                </td>
                                
                              <?php } ?>
                              <?php  if ($subjectMarkTableRow->eca) { ?>
                                <td class="cPaddingLR" >
                                  <input class="no-margin" name="eca[<?php echo $idcount; ?>]" 
                                  type="text" id="eca<?php echo $idcount; ?>"
                                  placeholder="eg. 10 (leave empty for absent)" 
                                  value="<?php echo $row['m_eca']; ?>" 
                                   >
                                </td>
                                
                              <?php } ?>
                              <?php  if ($subjectMarkTableRow->lp) { ?>
                                <td class="cPaddingLR" >
                                  <input class="no-margin" name="lp[<?php echo $idcount; ?>]" 
                                  type="text" id="lp<?php echo $idcount; ?>"
                                  placeholder="eg. 10 (leave empty for absent)" 
                                  value="<?php echo $row['m_lp']; ?>" 
                                   >
                                </td>
                                
                              <?php } ?>
                              <?php  if ($subjectMarkTableRow->nb) { ?>
                                <td class="cPaddingLR" >
                                  <input class="no-margin" name="nb[<?php echo $idcount; ?>]" 
                                  type="text" id="nb<?php echo $idcount; ?>"
                                  placeholder="eg. 10 (leave empty for absent)" 
                                  value="<?php echo $row['m_nb']; ?>" 
                                   >
                                </td>
                                
                              <?php } ?>
                              <?php  if ($subjectMarkTableRow->se) { ?>
                                <td class="cPaddingLR" >
                                  <input class="no-margin" name="se[<?php echo $idcount; ?>]" 
                                  type="text" id="se<?php echo $idcount; ?>"
                                  placeholder="eg. 10 (leave empty for absent)" 
                                  value="<?php echo $row['m_se']; ?>" 
                                   >
                                </td>
                                
                              <?php } ?>


                              <!-- Select/deselect -->
                              <td>
                                <div class="switch">
                                  <label>
                                    <input class="mrrorbot1" id="<?php echo $idcount; ?>" onclick="disableStudent(this.id)" type="checkbox" name="selectstd[<?php echo $idcount; ?>]" 
                                    <?php echo (  (isset($_GET["token"]) && $_GET["token"] == "amu8x008")? 
                                                    ( ($row["marksheet_id"] )?  'checked' : '' ) 
                                                    : 'checked');  ?> 

                                    >
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
                  <div id="submit_div" class="input-field col offset-m10">
                    <?php if (isset($_GET["token"]) && $_GET["token"] == "amu8x008") {
                          if ($login_cat==1 || $pac['edit_mark']){ ?>

                        <input type="hidden" name="request" value="update_mark_table" >
                        <button class="btn waves-effect waves-light blue lighten-2" type="submit" >Update
                        <i class="material-icons right">send</i>

                    <?php } }else{ ?>
                        <input type="hidden" name="request" value="add_mark_table" >
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

      //========= By default add marks page ===============
    }else{ ?>
                <div class="row">
                  <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Please select all the fields</span></span>


                            <form  method="get" action="" onsubmit="return validate(this);" >
                              <input type="hidden" name="token" value="potgadd5m7y3ww">
                              <input type="hidden" name="i04x20" value="subjectwise">

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

                                  <div id="subjectDiv" class="input-field col s12 m6">
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
        ob.value = "";
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
        th.value = "";
        pr.value = "";
        }

      }     
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
              //$("#err").fadeOut();
              $("#overlayloading").show();
              $("#submit_div").hide();
            },
            success: function(data)
            {
              //alert(data);
              if (data.trim() !== 'Mark succesfully updated'.trim()) { 
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
                if (data.trim() === 'Mark succesfully updated'.trim()) {

                window.location.href = 'addmarks.php';
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