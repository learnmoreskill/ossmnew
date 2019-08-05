<?php
//for nsk and admin
    include('session.php');
    require("../important/backstage.php");
    $backstage = new back_stage_class();

    /*set active navbar session*/
    $_SESSION['navactive'] = 'attendance';

    $year_id = $current_year_session_id;

    $classList= json_decode($backstage->get_class_list_by_year_id($year_id));
   
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>        
    <?php include_once("navbar.php");?>

    <script>
        function showUser(str) {
          if (str == "") {
              document.getElementById("txtHint").innerHTML = "";
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
                      var selectDropdown =    $("#txtHint");
                      document.getElementById("txtHint").innerHTML = this.responseText;
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
        function showMessage(sec_id) {
          var class_id=document.getElementById("classname").value;
          var btnSubmit=document.getElementById("btnSubmit");
          var attendanceForm=document.getElementById("attendanceForm");

          if (sec_id == "" || class_id=="") {
              document.getElementById("attendance_message").innerHTML = "";
              
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
                      document.getElementById("attendance_message").innerHTML = this.responseText;
                      if (this.responseText.trim() === 'Hello, Ready for the attendance.'.trim()) {
                        btnSubmit.innerHTML='Start';
                        attendanceForm.action='alist.php'
                        btnSubmit.style.visibility = 'visible';
                      }else{
                        btnSubmit.innerHTML='View';
                        attendanceForm.action='alistview.php';
                        btnSubmit.style.visibility = 'visible';
                      }
                      
                  }
              };
              xmlhttp.open("GET","getAttendanceMessage.php?secId="+sec_id+"&classId="+class_id,true);
              xmlhttp.send();
          }
        }
    </script>
         <script type="text/javascript">
            function chkdate() {

                /*ustartDate = document.getElementById("adate").value; 
                
                var startDate = new Date(ustartDate);
                startDate.setHours(0,0,0,0);
                
                //var endDate = new Date();

                var tdate = "<?php echo $login_today_date; ?>"; 
                var todaysDate = new Date(tdate);
                todaysDate.setHours(0,0,0,0);

                //alert(ustartDate+"---------"+startDate+"---------"+todaysDate+"---------"+tdate);
               
              if(startDate>todaysDate)
                {
                    document.getElementById("adate").value="";
                    alert('Please enter a past or today date. Cannot predict the future.');
                    return false;
                }     */     

            }
        </script>
        <script type="text/javascript">
        function validate(form) {
          var e = form.elements, m = '';

              if(!e['adate'].value) {m += '- Date is required.\n';}
              if(!e['class'].value) {m += '- Select Class.\n';}
              if(!e['txtHint'].value) {m += '- Select section.\n';}
              
              if(m) {alert('The following error(s) occurred:\n\n' + m);
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Attendance Manager</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Today's Attendance</span></span>


                            <form id="attendanceForm" method="get" action="">
                                <div class="input-field col s12">
                                    <select id="classname" name="class_id" onchange="showSection(this.value)" required>
                                            <option value="" >Select class</option>
                                            <?php 
                                            foreach ($classList as $clist) {
                                                  echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                            }
                                            ?>
                                      </select>
                                      <label>Select Class</label>
                                </div>
                                <div class="input-field col s12">
                                    <select name="section_id" onchange="showMessage(this.value)" id="section">
                                        <option value="" >Select class first</option>
                                    </select>
                                    <label>Section:</label>
                                </div>
                                <input type="hidden" name="today" value="toady">
                                <div id="attendance_message"></div>
                                <button style="visibility: hidden;" id="btnSubmit" class="btn waves-effect waves-light blue lighten-2" type="submit">Start</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">View Previous Report</span></span>
                            <p class="flow-text">Select the date, class and section and get the current/previouss days attendance report.</p><br/>

                            <form method="post" action="alistview.php?upd" onsubmit="return validate(this);">
                                <div class="input-field col s12">
                                  <input type="text" id="adate" 
                                  class="<?php if($login_date_type==1){
                                      echo 'datepicker1';
                                    }else if($login_date_type==2){
                                      echo 'bod-picker';
                                    }else{
                                      echo 'datepicker1';
                                    } ?>" 
                                    name="updfield" placeholder="Select date" >
                                  <label>Enter Date</label>
                                </div>
                                <div class="input-field col s12">
                                    <select id="class" name="upcfield" onchange="showUser(this.value)">
                                            <option value="">Select class</option>
                                            <?php
                                             foreach ($classList as $clist) {
                                                  echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                            }
                                            ?>
                                      </select>
                                      <label>Select Class</label>
                                </div>
                                <div class="input-field col s12">
                                    <select name="upsfield" id="txtHint">
                                        <option value="" >Select class first</option>
                                    </select>
                                    <label>Section:</label>
                                </div>
                                <button class="btn waves-effect waves-light blue lighten-2" type="submit" onclick="return chkdate();" >Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <!-- add footer.php here -->
<?php include_once("../config/footer.php");?>