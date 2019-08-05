<?php 
  include('session.php');
  include("../important/backstage.php");
  $backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'marksheetforclass';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

$examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));

$dbtemplate = json_decode($backstage->get_template_id());

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>



    <!-- get section list from database-->
    <script>
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

              if(!e['class_id'].value) {m += '- Select class name.\n';}
              if(!e['studentselect'].value && e['template'].value!=3) {m += '- Select student.\n';}
              if(!e['examtype'].value) {m += '- Select exam type.\n';}
              if(!e['y04x20'].value) {m += '- Select year.\n';}

              if(e['examtype'].value =="5" || e['examtype'].value =="6") {
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Generate marks card</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form class="col s12" id="markshetforclass" target="_blank" action="reportforclass.php" method="post" onsubmit="return validate(this);" novalidate >

                  <input type="hidden" name="y04x20" value="<?php echo $year_id; ?>" >

                    <div class="row">
                        <?php if (!empty($dbtemplate->template_marksheet)){  ?>
                          <input type="hidden" name="template" value="<?php echo $dbtemplate->template_marksheet; ?>">

                        <?php }else{ ?>
                          <div class="input-field col s6 m6" >
                              <select name="template" id="template">
                                <!-- <option value="999" selected>Default</option> -->
                                <option value="1">Grade</option>
                                <option value="2">Grade,GPA</option>
                                <option value="3">Grade,GPA,Rank</option>
                                <option value="4" selected>Grade,GPA,Rank,HS</option>
                                <option value="5">Grade,GPA,Rank,HS,Test</option>
                                <option value="7">Grade,GPA Only</option>
                              </select>
                              <label>Select Template</label>
                          </div>

                          <div class="input-field col s6 m6" id="mode">
                            <select name="mode">
                              <option value="a5" selected>2 A5 size in A4 landscape</option>
                              <option value="a4">A4 Portrait Full</option>
                              <option value="a4l">A4 Landscape Full</option>
                              <option value="a5p">A5 Portrait Full</option>
                              <option value="a5l">A5 Landscape Full</option>
                            </select>
                            <label>Select Print Size</label>
                        </div>                        
                        <?php } ?>
                        

                        <div class="input-field col s12 m6">
                                <select id="class_id" name="class_id" onchange="showSection(this.value)" >

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
                            <select name="section_id" id="section" onchange="showStudentBySection(this.value)">
                              <option value="" >Select class first</option>
                            </select>
                            <label class="white-text">Section:</label>
                        </div>
                        <div class="input-field col s12 m12" id="studentDiv">
                            <select multiple name="student[]" id="studentselect">
                            <option value="" disabled>Select class first</option>
                            </select>
                            <label>Student</label>
                        </div>
                      </div>

                      <div class="row">
                        <div class="input-field col s12 m2">
                          <select name="examtypeid" id="examtype" onchange="showMonth(this.value)" >
                              <option value="" >Select Exam Type</option>

                                <?php foreach ($examTypeList as $examlist) {
                                        echo '<option value="'.$examlist->examtype_id.'"> ' . $examlist->examtype_name. ' </option>';
                                      }   ?>

                          </select>
                            <label>Select Exam Type</label>

                        </div>
                        <div style="display: none;"  id="monthDiv" class="input-field col s12 m2">
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

                        <div class="input-field col s12 m2">
                            <select name="rankselected" id="rankselected" >
                                <option value="" disabled>Select rank type</option>
                                  <option value="1" selected="">Class-wise</option>
                                  <option value="2">Section-wise</option>
                            </select>
                                <label>Select rank type</label>
                        </div>  
                        
                         <div class="right input-field col m2">
                          <button class="btn waves-effect waves-light" type="submit">Submit
                            <i class="material-icons right">send</i>
                          </button>
                      </div>

                    </div>
                    
                     

                </form>
            </div>            
        
  </main>
        


<?php include_once("../config/footer.php");?>

<script type="text/javascript">
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