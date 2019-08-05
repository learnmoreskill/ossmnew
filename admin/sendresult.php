<?php
   include('session.php');
   require("../important/backstage.php");
   $backstage = new back_stage_class();


/*set active navbar session*/
$_SESSION['navactive'] = 'sendresult';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

$examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

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

          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>

            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Send Result</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m12">
                <div class="card grey darken-3">
                  <div class="card-content white-text">
                      <span class="card-title">
                        <span style="color:#fff;">Note: Be sure all the marks are correct in marksheet, it will directly send through sms</span>
                      </span><br/>
                    <div class="row">
                      <form class="col s12" id="send_result_message_form" action="sendbroadcastscript.php" method="post">
                        <input type="hidden" name="send_result_message_request" value="send_result_message_request">
                        <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">
                        <div class="row center">

                          <div class="col s6 m3">
                            <input class="with-gap" name="group" value="4" type="radio" id="parents" checked />
                            <label for="parents" style="font-size: 20px" class="white-text">Parents</label>
                          </div>

                          <div class="col s6 m3">
                            <input class="with-gap" name="group" value="3" type="radio" id="students"  />
                            <label for="students" style="font-size: 20px" class="white-text">Students</label>
                          </div>

                        </div>

                        <div class="row">
                          <div class="input-field col s12 m12">
                            <select name="template" id="template">
                                <option value="gradePoint" >Grade point only</option>
                                <option value="subjectMark" >With subject mark</option>
                            </select>
                              <label>Select Template</label>

                          </div>
                        </div>
                            


                        <div id="studentParentDiv">
                          <div class="input-field col s12 m6">
                                  <select id="class_id" name="class_id" onchange="showSection(this.value)" >

                                <option value="" >Select class</option>

                                  <?php
                                  foreach ($classList as $clist) {
                                    echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                  }
                                  ?>
                              </select>
                              <label class="white-text">Class:</label>
                          </div>
                          <div class="input-field col s12 m6">
                            <select name="section_id" id="section" onchange="showStudentBySection(this.value)">
                              <option value="" >Select class first</option>
                            </select>
                            <label class="white-text">Section:</label>
                          </div>
                        </div>


                        <div class="row">
                          <div class="input-field col s12">
                            <select multiple name="users[]" id="users">
                              <option value="" disabled selected>Select Class First</option>
                            </select>
                            <label>Select User</label>
                          </div>
                        </div>

                      <div class="row">
                        <div class="input-field col s12 m6">
                          <select name="examtypeid" id="examtype" onchange="showMonth(this.value)" >
                              <option value="" >Select Exam Type</option>

                                  <?php
                                  foreach ($examTypeList as $elist) {
                                    echo '<option value="'.$elist->examtype_id.'"> ' . $elist->examtype_name. ' </option>';
                                  }
                                  ?>
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
                      </div>

                        <button id="broadcastbtn" class="btn waves-effect waves-light blue lighten-2" type="submit" name="action">Send<i class="material-icons right">send</i></button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="sentListContainer" style="display: none;">
              <h4 class="center">Sent List
                <span class="right"  style="margin-right: 15px;">                  
                  <span onclick="clearList();" style="cursor: pointer;"><i class="material-icons right">clear</i></span>
                  <span onclick="fontControl('-1');" style="cursor: pointer;"><i class="material-icons right">zoom_out</i></span>
                  <span onclick="fontControl('1');" style="cursor: pointer;"><i class="material-icons right">zoom_in</i></span>
                </span>
              </h4>
              
              <div id="sentList" style="padding-left: 14px;font-size: 12px">
              </div>
            </div>

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
  function fontControl(val) {
  var el = document.getElementById('sentList');
  var style = window.getComputedStyle(el, null).getPropertyValue('font-size');
  var fontSize = parseFloat(style); 
// now you have a proper float for the font size (yes, it can be a float, not just an integer)
el.style.fontSize = (fontSize + parseInt(val)) + 'px';
  }
  function clearList(){
    $('#sentListContainer').hide();
    $('#sentList').empty();
  }

    $(document).ready(function (e) 
    {
      $("#send_result_message_form").on('submit',(function(e) 
      {
        var x = document.getElementById("overlayloading");
        
        

        e.preventDefault();
        $.ajax
        ({
              url: "sendresultscript.php",
              type: "POST",
              data:  new FormData(this),
              contentType: false,
              cache: false,
              processData:false,
              beforeSend : function()
              {
                x.style.display = "block";
              },
              success: function(data)
              {

                var result = JSON.parse(data);

                if (result.status == 200) {

                    var sentListContainer = document.getElementById("sentListContainer");
                    $('#sentListContainer').show();
                    var sentList = document.getElementById("sentList");
                    var t="";
                    $('#sentList').empty();
                    result.data.forEach(function(data){
                      // console.log(data);
                      t += "<p style='margin:2px'>"+data+"</p>";
                    });
                    sentList.innerHTML = t;

                    // location.reload();

                }else{
                  // debugger;
                    alert(result.errormsg);
                    
                }

                x.style.display = "none";
              },
              error: function(e) 
              {
                alert('Sorry Try Again !!');
                x.style.display = "none";
              }          
        });
      }));

      
    });

</script>
<script>
      
      function showSection(str) {
        
        if (str == "") {
            document.getElementById("section").innerHTML = "<option value='' >Select Class first</option>";
            var selectDropdown =    $("#section");
            selectDropdown.trigger('contentChanged');
          
            document.getElementById("users").innerHTML = "<option value='' disabled>Select Class</option>";
            var selectDropdown1 =    $("#users");
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

         var year_id = <?php echo $year_id; ?>;

          if (str == "") {
            document.getElementById("users").innerHTML = "<option value='' disabled>Select section first</option>";
            var selectDropdown =    $("#users");
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
                      var selectDropdown =    $("#users");
                      document.getElementById("users").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp1.open("GET","../important/getContent.php?studentBySectionSelected="+str+"&year_id="+year_id,true);
              xmlhttp1.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });
          }
      }
      function showStudentByClass(str) {

            var year_id = <?php echo $year_id; ?>;

            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp2 = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp2.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var selectDropdown =    $("#users");
                    document.getElementById("users").innerHTML = this.responseText;
                    selectDropdown.trigger('contentChanged');
                }
            };
            xmlhttp2.open("GET","../important/getContent.php?studentByClassSelected="+str+"&year_id="+year_id,true);
            xmlhttp2.send();
            $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
             });
      }
</script>