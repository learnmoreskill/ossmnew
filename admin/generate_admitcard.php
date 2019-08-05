<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'generate_admitcard';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

$examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));
 
?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>





    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Generate admit card</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form class="col s12" id="markshetforclass" target="_blank" action="printadmitcard.php" method="post" >
                  <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">


                    <div class="row">
                        <div class="input-field col s12 m6">
                                <select id="sclass" name="sclass" onchange="showSection(this.value)">

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
                            <select name="section" id="section" onchange="showStudentBySection(this.value)">
                              <option value="" >Select class first</option>
                            </select>
                            <label >Section:</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <select multiple name="student[]" id="studentselect">
                            <option value="" disabled>Select class first</option>
                            </select>
                            <label>Student</label>
                        </div>

                        <div class="input-field col s12 m2">
                          <select name="examtypeid" id="examtypeid">
                              <option value="" >Select Exam Type</option>

                                    <?php 
                                    foreach ($examTypeList as $examlist) {
                                        echo '<option value="'.$examlist->examtype_id.'"> ' . $examlist->examtype_name. ' </option>';
                                    }   ?>

                          </select>
                            <label>Select Exam Type</label>
                        </div>
                        <div class="input-field col s6 m2">
                            <select name="printmode">
                              <option value="0" selected>Vertical</option>
                              <option value="1">Horizontal</option>
                            </select>
                            <label>Select card mode</label>
                        </div>
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

        showStudentByClass(str);
    }
  }
  function showStudentBySection(str) {
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
          xmlhttp1.open("GET","../important/getContent.php?studentBySectionSelected="+str+"&year_id=<?php echo $year_id; ?>",true);
          xmlhttp1.send();
          $('select').on('contentChanged', function() { 
          // re-initialize 
         $(this).material_select();
           });
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
        xmlhttp2.open("GET","../important/getContent.php?studentByClassSelected="+str+"&year_id=<?php echo $year_id; ?>",true);
        xmlhttp2.send();
        $('select').on('contentChanged', function() { 
        // re-initialize 
       $(this).material_select();
         });
  }
    </script>