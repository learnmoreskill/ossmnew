<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class(); 

/*set active navbar session*/
$_SESSION['navactive'] = 'attendance_report';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

$examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));
 
?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

      <script>
        function showMonth(value) {
          var monthDiv=document.getElementById("monthDiv");

          if (value == "monthwise") {
            monthDiv.style.display = 'block';
              return;
          } else {
            monthDiv.style.display = 'none';
            return;
          }
        }

        function showStudent(value) {
          var studentDiv=document.getElementById("studentDiv");

          if (value == "studentwise") {
            studentDiv.style.display = 'block';
              return;
          } else {
            studentDiv.style.display = 'none';
            return;
          }
        }
      </script>





    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Attendance Report</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form class="col s12" target="_blank" action="attendanceReportPrint.php" method="post" >
                  <input type="hidden" name="generate_attendance_report" value="hackster" >
                  <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">


                    <div class="row">

                        <div class="input-field col s12 pb-4"> 
                            <h6>Attendance report for</h6>
                          <input class="with-gap" name="reportFor" value="student" type="radio" id="student" checked />
                          <label for="student">Student</label>

                          <!-- <input class="with-gap" name="reportFor" value="teacher" type="radio" id="teacher" />
                          <label for="teacher">Teacher</label>

                          <input class="with-gap" name="reportFor" value="staff" type="radio" id="staff" />
                          <label for="staff">Staff</label> -->
                        </div>



                        <div class="input-field col s12 m6">
                            <select id="monthwise" name="monthwise"  onchange="showMonth(this.value)" >

                              <option value="monthwise" >Month wise</option>
                              <option value="yearwise" >Year wise</option>

                            </select>
                            <label>Report type:</label>
                        </div>

                        <div  id="monthDiv" class="input-field col s12 m6">
                              <select name="month_id" id="month_id" >
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
                                  <label>Select month</label>
                        </div>

                        <input type="hidden" name="classwise" value="classwise">

                        <!-- <div class="input-field col s12 m6">
                            <select id="classwise" name="classwise" onchange="showStudent(this.value)" >

                              <option value="classwise" >Class wise</option>
                              <option value="studentwise" >Student wise</option>

                            </select>
                            <label>Report sub type:</label>
                        </div> -->

                        <div class="input-field col s12 m6">
                                <select id="sclass" name="class_id" onchange="showSection(this.value)">

                              <option value="" >Select class</option>

                                <?php 
                                foreach ($classList as $clist) {
                                  echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                }
                                ?>
                            </select>
                            <label>Class:</label>
                        </div>
                        <div class="input-field col s12 m6" id="sectionDiv">
                            <select name="section_id" id="section" onchange="showStudentBySection(this.value)" >
                              <option value="" >Select class first</option>
                            </select>
                            <label >Section:</label>
                        </div>


                        <div style="display: none;" id="studentDiv" class="input-field col s12 m6">
                            <select name="student_id" id="studentselect">
                            <option value="" disabled>Select class first</option>
                            </select>
                            <label>Student</label>
                        </div>

                    </div>
                    <div class="row">
                      <div class="input-field col s6 m2">
                          <input type="hidden" name="printadmitcard_request">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                              </button>
                        </div>
                      </div>

                </form>
            </div>
        </main>

<?php include_once("../config/footer.php");?>

<!-- get section list from database-->
<script>
  function showSection(str) {
    
    if (str == "") {
        document.getElementById("section").innerHTML = "<option value='' >Select Class first</option>";
        var selectDropdown =    $("#section");
        selectDropdown.trigger('contentChanged');
      
        document.getElementById("studentselect").innerHTML = "<option value='' disabled>Select Class</option>";
        var selectDropdown1 =    $("#studentselect");
        selectDropdown1.trigger('contentChanged');
        
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



        var classwise = document.getElementById('classwise').value;
        if (classwise.trim() == 'studentwise') {
          showStudentByClass(str);
        }

        
    }
  }
  function showStudentBySection(str) {

    var classwise = document.getElementById('classwise').value;
    if (classwise.trim() == 'studentwise') {
      
      if (str == "") {
        document.getElementById("studentselect").innerHTML = "<option value='' disabled>Select section first</option>";
        var selectDropdown =    $("#studentselect");
        selectDropdown.trigger('contentChanged');
        return;
      } else {
          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp1 = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp1.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var selectDropdown =    $("#studentselect");
                  document.getElementById("studentselect").innerHTML = this.responseText;
                  selectDropdown.trigger('contentChanged');
              }
          };
          xmlhttp1.open("GET","../important/getContent.php?studentBySectionUnselected="+str+"&year_id=<?php echo $year_id; ?>",true);
          xmlhttp1.send();
          $('select').on('contentChanged', function() { 
          // re-initialize 
         $(this).material_select();
           });
      }
    }
  }
  function showStudentByClass(str) {

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp2 = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp2.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#studentselect");
                document.getElementById("studentselect").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            }
        };
        xmlhttp2.open("GET","../important/getContent.php?studentByClassUnselected="+str+"&year_id=<?php echo $year_id; ?>",true);
        xmlhttp2.send();
        $('select').on('contentChanged', function() { 
        // re-initialize 
       $(this).material_select();
         });
  }
    </script>