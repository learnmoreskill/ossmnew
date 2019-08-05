<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'generate_idcard';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>



    <!-- get section list from database-->
    <script>
          function showSection(str) {
            
            if (str == "") {
                document.getElementById("section").innerHTML = "<option value='' >Select class first</option>";
                var selectDropdown =    $("#section");
              selectDropdown.trigger('contentChanged');
              
                document.getElementById("studentmultiple").innerHTML = "<option value='' disabled>Select section first</option>";
              var selectDropdown1 =    $("#studentmultiple");
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
              document.getElementById("studentmultiple").innerHTML = "<option value='' disabled>Select section first</option>";
              var selectDropdown =    $("#studentmultiple");
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
                      var selectDropdown =    $("#studentmultiple");
                      document.getElementById("studentmultiple").innerHTML = this.responseText;
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
                  xmlhttp7 = new XMLHttpRequest();
              } else {
                  // code for IE6, IE5
                  xmlhttp7 = new ActiveXObject("Microsoft.XMLHTTP");
              }
              xmlhttp7.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var selectDropdown =    $("#studentmultiple");
                      document.getElementById("studentmultiple").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp7.open("GET","../important/getContent.php?studentByClassSelected="+str+"&year_id=<?php echo $year_id; ?>",true);
              xmlhttp7.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });
        }

        function getAllStudent(str) {
          if (str) { 
              if (window.XMLHttpRequest) {
                  // code for IE7+, Firefox, Chrome, Opera, Safari
                  xmlhttp2 = new XMLHttpRequest();
              } else {
                  // code for IE6, IE5
                  xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
              }
              xmlhttp2.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var selectDropdown =    $("#allstudent");
                      document.getElementById("allstudent").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp2.open("GET","getstudent.php?allstudent=allstudent&year_id=<?php echo $year_id; ?>",true);
              xmlhttp2.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });

          }else{
            document.getElementById("allstudent").innerHTML = "<option value='' disabled selected >Select section first</option>";

            var selectDropdown =    $("#allstudent");
            selectDropdown.trigger('contentChanged');
            $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
            });
            
              return;
          }
        }
        function showStaff(str) {
          if (str) { 
              if (window.XMLHttpRequest) {
                  // code for IE7+, Firefox, Chrome, Opera, Safari
                  xmlhttp3 = new XMLHttpRequest();
              } else {
                  // code for IE6, IE5
                  xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
              }
              xmlhttp3.onreadystatechange = function() {
                  if (this.readyState == 4 && this.status == 200) {
                      var selectDropdown =    $("#staffmultiple");
                      document.getElementById("staffmultiple").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              if (str == 1) {
                xmlhttp3.open("GET","getstudent.php?allteacher=allteacher",true);
              }else if(str == 2){
                xmlhttp3.open("GET","getstudent.php?allstaff=allstaff",true);
              }
              
              xmlhttp3.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });

          }else{
            document.getElementById("staffmultiple").innerHTML = "<option value='' disabled selected >Select staff type first</option>";

            var selectDropdown =    $("#staffmultiple");
            selectDropdown.trigger('contentChanged');
            $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
            });
            
              return;
          }
        }
    </script>

    
        <main>
            <div class="section no-pad-bot" id="index-banner">
              <?php include_once("../config/schoolname.php");?>
              <div class="row">
                <div class="col s12">
                  <ul class="tabs github-commit">
                    <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#student_id_card">Student Id</a></li>
                    <li class="tab col s3"><a class="white-text text-lighten-4" href="#staff_id_card">Staff Id</a></li>
                  </ul>
                </div>
              </div>
            </div>


            <div id="student_id_card">
              <form target="_blank" action="printidcard.php" method="post">
                <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">
                <div class="row">
                  <div class="input-field col s12">
                      <h5>Select Template</h5>

                    <input class="with-gap" name="idtemplate" value="99" type="radio" id="default" checked />
                    <label for="default">Default</label>

                    <input class="with-gap" name="idtemplate" value="1" type="radio" id="one" />
                    <label for="one">One</label>

                    <input class="with-gap" name="idtemplate" value="2" type="radio" id="two" />
                    <label for="two">Two</label>

                    <input class="with-gap" name="idtemplate" value="3" type="radio" id="three" />
                    <label for="three">Three</label>

                    <input class="with-gap" name="idtemplate" value="4" type="radio" id="four" />
                    <label for="four">Four</label>

                    <input class="with-gap" name="idtemplate" value="5" type="radio" id="five" />
                    <label for="five">Five</label>

                    <input class="with-gap" name="idtemplate" value="6" type="radio" id="six" />
                    <label for="six">six</label>
                  </div>
                          
                </div>

  <!-- ====================== For Multiple Student ======================== -->
              <div class="spliter">
                    <h5 class="center">For Multiple Student</h5>
                    <hr >
              </div>
              <div class="row">
                <div class="col s12 m12">
                  <div class="card blue-grey">

                      <div class="row"><br>
                          <div class="input-field col s12 m2">
                                  <select id="sclass" name="sclass" onchange="showSection(this.value)" >

                                <option value="" >Select class</option>

                                  <?php
                                  foreach ($classList as $clist) {
                                    echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                  }
                                  ?>
                              </select>
                              <label class="white-text">Class:</label>
                          </div>
                          <div class="input-field col s12 m2">
                            <select name="section" id="section" onchange="showStudentBySection(this.value)">
                              <option value="" >Select class first</option>
                            </select>
                            <label class="white-text">Section:</label>
                          </div>

                          <div class="input-field col s12 m6">
                              <select multiple name="studentmultiple[]" id="studentmultiple">
                              <option value="" disabled>Select section first</option>
                              </select>
                              <label class="white-text">Student</label>
                          </div>
                      
                          <div class="input-field col m2">
                            <!-- <input type="hidden" name="generate_idcard_for_class"> -->
                            <input type="submit" name='generate_multiple_idcard' class="btn waves-effect waves-light" value="Submit">

                               <!-- <button class="btn waves-effect waves-light" type="submit">Submit
                                  <i class="material-icons right">send</i>
                                </button> -->
                          </div>
                        <br>
                      </div>
                  </div>
                </div>
              </div>
  <!-- ================================== all student ======================== -->
            
             <div class="spliter">
                    <h5 class="center">All Active Student</h5>
                    <hr >
              </div>
              <div class="row mt-2">
                <div class="col s12 m12">
                  <div class="card blue-grey">

                    <!-- checkbox -->
                    <!-- <div class="row center switch pt-2">
                      <label>
                        <input onclick="getAllStudent(this.checked)" type="checkbox" name="checkboxvalue" >
                        <span class="lever"></span></label>
                    </div> -->

                      <div class="row" style="margin-top: -34px"><br>

                          <!-- <div class="input-field col s12 m10">
                            <select multiple name="studentall[]" id="allstudent">
                              <option value="" disabled selected >Select student</option>
                            </select>
                            <label class="white-text">Select Student:</label>
                          </div> -->
                          <div class="input-field col s12 m10">
                            <select multiple name="allclass[]" >

                                <option value="" disabled>Select class</option>

                                  <?php
                                  foreach ($classList as $clist) {
                                    echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                  }
                                  ?>
                              </select>
                            <label class="white-text">Select Class:</label>
                          </div>
                      
                          <div class="input-field col m2">
                            <input type="submit" name='generate_all_idcard' class="btn waves-effect waves-light" value="Submit">
                          </div>
                        <br>
                      </div>
                </div>
              </div>
            </div>

  <!-- ============================== end all student ===================================== -->
              <div class="spliter">
               <h5 class="center">For Particular Student</h5>
                <hr >
              </div>
             
              <div class="row">
                  <div class="col s12 m12">
                      <div class="card blue-grey">
                              <div class="row white-text">                                
                                      <div class="row">
                                          <div class="search-box test3 input-field col s12 m12">

                                              <input id="searchname" autocomplete="off" name="searchname" type="text" class="validate" >
                                              <div class="result resultStyle" style="max-height: 400px;"></div>
                                              <label class="white-text" for="searchname">Search Student</label>
                                              
                                          </div>                                      
                                          
                                      </div>
                              </div>
                          
                      </div>
                      <ul class="test collapsible" data-collapsible="expandable">
                              <li>
                                <div style="display: none;" class="test2 collapsible-header"></div>
                                <div class="collapsible-body">
                                  <div class="row">
                                    <div class="col s12 m3">
                                      <div class="stdimage"></div>
                                    </div>

                                    <div class="col s12 m4">
                                      <div class="name"></div>
                                      <div class="class"></div>
                                      <div class="address"></div>
                                    </div>                                 
                                    <div class="col s12 m5">
                                      <div class="sparent"></div>
                                      <div class="spnumber"></div>
                                    </div>
                                  </div>

                                  <div class="row">
                                      <input type="hidden" id="studentid" name="studentsingle[]" value="">
                                      <input type="hidden" id="sclass1" name="sclass" value="">

                                      <div class="input-field col offset-m10">
                                        <input type="submit" name='generate_single_idcard' class="btn waves-effect waves-light" value="Submit">
                                      </div>
                                  </div>

                                </div>
                              </li>
                      </ul>
                  </div>
              </div>


            </form>
          </div>


<!-- ======================= Staff IdCard ================================= -->
          <div id="staff_id_card">
              <form target="_blank" action="printidcard.php" method="post">
                <div class="row">
                  <div class="input-field col s12">
                      <h5>Select Template</h5>

                    <input class="with-gap" name="idtemplate" value="999" type="radio" id="default1" checked />
                    <label for="default1">Default</label>

                    <input class="with-gap" name="idtemplate" value="101" type="radio" id="one1" />
                    <label for="one1">One</label>

                  </div>
                          
                </div>

  <!-- ====================== For Multiple Staff ======================== -->
              <!-- <div class="spliter">
                    <h5 class="center">For Multiple Staff</h5>
                    <hr >
              </div> -->
              <div class="row">
                <div class="col s12 m12">
                  <div class="card blue-grey">

                      <div class="row"><br>
                          <div class="input-field col s12 m2">
                                  <select id="stafftype" name="stafftype" onchange="showStaff(this.value)" >
                                <option value="" selected >Select staff type</option>
                                <option value="1">Teacher</option>
                                <option value="2">Staff</option>                                 
                              </select>
                              <label class="white-text">Staff type</label>
                          </div>

                          <div class="input-field col s12 m8">
                              <select multiple name="staffmultiple[]" id="staffmultiple">
                              <option value="" disabled>Select staff type first</option>
                              </select>
                              <label class="white-text">Staff</label>
                          </div>
                      
                          <div class="input-field col m2">
                            <input type="submit" name='generate_staff_idcard' class="btn waves-effect waves-light" value="Submit">

                          </div>
                        <br>
                      </div>
                  </div>
                </div>
              </div>
 



            </form>
          </div>


        </main>

<?php include_once("../config/footer.php");?>

<script src="../jquery.materialize-autocomplete.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#searchname").keyup(function() {
    //$('.search-box input[type="text"]').on("keyup input", function(){

      $(".test2.collapsible-header").removeClass(function(){
    return "active";
  });
  $(".test").collapsible({accordion: true});
  $(".test").collapsible({accordion: false});
      
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){ 
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                //debugger;
                data=JSON.parse(data);
                var temparr='';
                data.forEach(function(value){
                  temparr += "<p>"+value.sname+"&nbsp&nbsp Class: "+value.class_name+"-"+value.section_name+"&nbsp&nbsp Roll: "+value.sroll+"<span id='studData' style='display:none;'>"+JSON.stringify(value)+"</span></P>"

                });
                //debugger;
                  resultDropdown.html(temparr);


                 //alert(data);
                //resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();

                $(".test2.collapsible-header").removeClass(function(){
                  return "active";
                });
                $(".test").collapsible({accordion: true});
                $(".test").collapsible({accordion: false});
              
              }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        var sName=$(this).parents(".search-box").find('input[type="text"]').val(this.innerText);

        //var sData=document.getElementById('usrData').innerHTML;  
        var sData = this.getElementsByTagName('span')[0].innerHTML;                
        sData=JSON.parse(sData);
        console.log("data received",sData.sname);
        //debugger;
        $(this).parent(".result").empty();
        document.getElementById('studentid').value=sData.sid;
        document.getElementById('sclass1').value=sData.sclass;

        if (sData.simage) {
          $(".stdimage").html("<div class='ccimage'><img  src='../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/"+sData.simage+"' height='100%;' width='100%;'></div>").show();
        }else{
          $(".stdimage").html("<div class='ccimage'><p>Image not Available</p></div>").show();
        }
        
        $(".name").html("<p>Name: "+sData.sname+"</p>").show();
        $(".class").html("<p>Class: "+sData.class_name+" "+sData.section_name+"</p>").show();
        $(".address").html("<p>Address: "+sData.saddress+"</p>").show();

        $(".sparent").html("<p>Parent: "+sData.spname+"</p>").show();
        $(".spnumber").html("<p>Address: "+sData.spnumber+"</p>").show();
        
        //
        $(".test2.collapsible-header").addClass("active");
        $(".test").collapsible({accordion: false});
    });
});
</script>