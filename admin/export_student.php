<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'export_student';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <script>
          function showSection(str) {
            
            if (str == "") {
                document.getElementById("sectionId").innerHTML = "<option value='' >Select class first</option>";
                var selectDropdown =    $("#sectionId");
                selectDropdown.trigger('contentChanged');

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
                        var selectDropdown =    $("#sectionId");
                        document.getElementById("sectionId").innerHTML = this.responseText;
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
          function showSubType(str) {

            var subDiv=document.getElementById("sub_type_div");
            
            if (str.trim()==='student_details'.trim()) {
              subDiv.style.display = 'none';
              return;
            }else{
              subDiv.style.display = 'block';
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Export</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form action="export_details.php" method="GET" class="col s12" >


                    <div class="row">
                        <div class="input-field col s12 m6">
                            <select id="export_type" name="export_type" onchange="showSubType(this.value)">

                              <option value="" disabled >Select type</option>
                              <option value="student_details" >Student details</option>
                              <option value="transport_details" >Transport details</option>
                              <option value="hostel_details" >Hostel details</option>

                            </select>
                            <label>Select type*:</label>
                        </div>

                        <div id="sub_type_div" style="display: none;" class="input-field col s12 m6">
                            <select name="sub_type" id="sub_type">
                              <option value="" disabled >Select details type</option>
                              <option value="all" >All</option>
                              <option value="active_only" >Active Only</option>
                              <option value="with_balance" >Active With Balance</option>
                            </select>
                            <label>Select details type*:</label>
                        </div>

                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                              <select id="classId" name="classId" onchange="showSection(this.value)" >

                            <option value="" >Select class</option>

                              <?php
                              foreach ($classList as $clist) {
                                echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                              }
                              ?>
                          </select>
                          <label >Class(Optional):</label>
                      </div>
                      <div class="input-field col s12 m6">
                        <select name="sectionId" id="sectionId" >
                          <option value="" >Select class first</option>
                        </select>
                        <label >Section(Optional):</label>
                      </div>
                    </div>
                    <div class="row">
                      <div class="input-field col m2">
                        <input type="hidden" name="token" value="export_details">
                        <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                        </button>
                      </div>
                    </div>

                </form>
            </div>
        </main>
        


<?php include_once("../config/footer.php");?>