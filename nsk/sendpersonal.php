<?php
   include('session.php');
   require("../important/backstage.php");
   $backstage = new back_stage_class();


   /*set active navbar session*/
$_SESSION['navactive'] = 'sendpersonal';


$classList= json_decode($backstage->get_class_list());

   ?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        <main>

          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>

            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Send Personal</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m12">
                <div class="card grey darken-3">
                  <div class="card-content white-text">
                      <span class="card-title">
                        <span style="color:#008ee6;"></span>
                      </span><br/>
                    <div class="row">
                      <form class="col s12" id="sendpersonalmessage" action="sendbroadcastscript.php" method="post">
                        <div class="row center">

                          <div class="col s6 m3">
                            <input class="with-gap" name="group" value="4" type="radio" id="parents" checked onchange="getUserList()" />
                            <label for="parents" style="font-size: 20px" class="white-text">Parents</label>
                          </div>

                          <div class="col s6 m3">
                            <input class="with-gap" name="group" value="3" type="radio" id="students"  onchange="getUserList()" />
                            <label for="students" style="font-size: 20px" class="white-text">Students</label>
                          </div>


                          <div class="col s6 m3">
                            <input class="with-gap" name="group" value="2" type="radio" id="teachers" onchange="getUserList()" />
                            <label for="teachers" style="font-size: 20px" class="white-text" >Teachers</label>
                          </div>

                          <div class="col s6 m3">
                            <input class="with-gap" name="group" value="5" type="radio" id="staff" onchange="getUserList()" />
                            <label for="staff" style="font-size: 20px" class="white-text">Staff</label>
                          </div>

                        </div>
                            


                        <div id="studentParentDiv">
                          <div class="input-field col s12 m6">
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
                          <div class="input-field col s12 m6">
                            <select name="section" id="section" onchange="showStudentBySection(this.value)">
                              <option value="" >Select class first</option>
                            </select>
                            <label class="white-text">Section:</label>
                          </div>
                        </div>


                        <div class="row">
                          <div class="input-field col s12">
                            <select multiple name="users[]" id="users">
                              <option value="" disabled selected>Select Class</option>
                            </select>
                            <label>Select User</label>
                          </div>
                        </div>


                        <div class="row">
                          <div class="input-field col s12">
                              <textarea id="topic" name="personalmessage" class="materialize-textarea"   length="500" ><?php echo "-".$login_session_a; ?></textarea>
                              <label>Type message</label>
                              <!-- <span>*Please do not use emoji, it may charge extra credit on SMS / Nepali font support 70 character only</span><br> -->
                              <span id="character" style="color: red"></span>
                          </div>
                        </div>

                        <button id="broadcastbtn" class="btn waves-effect waves-light blue lighten-2" type="submit" name="action">Send<i class="material-icons right">send</i></button>
                      </form>
                    </div>
                  </div>
                </div>
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
$("#topic").on("input", function() {
  //updateCount();
});

function updateCount() {
    //to remove emoji
    var ranges = [
      '\ud83c[\udf00-\udfff]', // U+1F300 to U+1F3FF
      '\ud83d[\udc00-\ude4f]', // U+1F400 to U+1F64F
      '\ud83d[\ude80-\udeff]'  // U+1F680 to U+1F6FF
    ];

    var str = $('#topic').val();
     
      str = str.replace(new RegExp(ranges.join('|'), 'g'), '');
      $("#topic").val(str);


    var character1 = document.getElementById("topic");
    var broadcastbtn = document.getElementById("broadcastbtn");

    var cs = character1.value.length;
    var uni=hasUnicode(character1.value);
    if(uni){
        console.log("Unicode","true");
        character1.setAttribute("length", "70");
        //character1.setAttribute("maxlength", "70"); //changed
        if (cs>70) { 
            broadcastbtn.disabled = false; //changed
            $('#character').text("Message with special character more than 70 may charge extra credit.");
        }else{
            broadcastbtn.disabled = false;
            $('#character').text("");
        }
    }else{
    console.log("Unicode","false");
    character1.setAttribute("length", "160");
    //character1.setAttribute("maxlength", "160"); //changed
    broadcastbtn.disabled = false;
    $('#character').text("");

    } 
}
function hasUnicode (str) {
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) > 127) return true;
    }
    return false;
}
</script>


<script>
    $(document).ready(function (e) 
    {
      $("#sendpersonalmessage").on('submit',(function(e) 
      {
        var x = document.getElementById("overlayloading");
        x.style.display = "block";

        e.preventDefault();
        $.ajax
        ({
              url: "sendbroadcastscript.php",
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
                if (data.trim() !== 'Message sent succesfully'.trim()) { 
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
                  if (data.trim() === 'Message sent succesfully'.trim()) {

                  window.location.href = 'sendpersonal.php';
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
      function getUserList(){
        var students = document.getElementById("students");
        var parents = document.getElementById("parents");
        var teachers = document.getElementById("teachers");
        var staff = document.getElementById("staff");

        var studentParentDiv = document.getElementById("studentParentDiv");

        if (students.checked) {
          studentParentDiv.style.display = "block";
          clearUser();
        }
        if (parents.checked) {
          studentParentDiv.style.display = "block";
          clearUser();
        }

        if (teachers.checked) {
          studentParentDiv.style.display = "none";
          showStaff(1); 
        }
        if (staff.checked) { 
          studentParentDiv.style.display = "none";
          showStaff(2); 
        }
         

        
      }
      function clearUser(){
        document.getElementById("users").innerHTML = "<option value='' disabled selected >Select Class</option>";

          var selectDropdown =    $("#users");
          selectDropdown.trigger('contentChanged');
          $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
          });          
          return;
      }
      
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
              xmlhttp1.open("GET","../important/getContent.php?studentBySectionUnselected="+str,true);
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
                    var selectDropdown =    $("#users");
                    document.getElementById("users").innerHTML = this.responseText;
                    selectDropdown.trigger('contentChanged');
                }
            };
            xmlhttp2.open("GET","../important/getContent.php?studentByClassUnselected="+str,true);
            xmlhttp2.send();
            $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
             });
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
                    var selectDropdown =    $("#users");
                    document.getElementById("users").innerHTML = this.responseText;
                    selectDropdown.trigger('contentChanged');
                }
            };
            if (str == 1) {
              xmlhttp3.open("GET","../important/getContent.php?allteacherUnselected=allteacher",true);
            }else if(str == 2){
              xmlhttp3.open("GET","../important/getContent.php?allstaffUnselected=allstaff",true);
            }
            
            xmlhttp3.send();
            $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
             });

        }else{
          document.getElementById("users").innerHTML = "<option value='' disabled selected >Select user</option>";

          var selectDropdown =    $("#users");
          selectDropdown.trigger('contentChanged');
          $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
          });
          
            return;
        }
      }
</script>