<?php
//for nsk and admin
   include('session.php');

   require("../important/backstage.php");
   $backstage = new back_stage_class();

   /*set active navbar session*/
$_SESSION['navactive'] = 'hwmsg';

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
                  xmlhttp1 = new XMLHttpRequest();
              } else {
                  // code for IE6, IE5
                  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                  xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
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
    </script>

        <main>
          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Add Homework</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title"><span style="color:#008ee6;">Add Homework</span></span>
                            <br/>
                            <div class="row">
                                <form class="col s12" id="add_homework_form" action="hwmsgscript.php" method="post">
                                  <div class="row">
                                        <div class="input-field col s12">
                                            <select id="class" name="tclass" onchange="showUser(this.value)" >
                                                <option value="" >Select class</option>
                                                <?php 
                                                foreach ($classList as $clist) {
                                                      echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                                }
                                                ?>
                                            </select>
                                            <label>Select Class</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select name="tsec" id="txtHint">
                                                <option value="" >Select class first</option>
                                              </select>
                                              <label>Section:</label>
                                        </div>
                                    </div>
                                    <div  class="input-field col s12">
                                      <select name="subject_id" id="subject_id" >
                                          <option value="" >Select class first</option>
                                      </select>
                                      <label>Subject:</label>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="topic" placeholder="Type topic or questions here.." name="ttopic" class="materialize-textarea" length="290" maxlength="290" required></textarea>
                                            <label for="topic">Enter Topic</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="input-field col s12">
                                        <input type="text" id="submitdate" name="submitdate" placeholder="Select submission date"  
                                          class="<?php if($login_date_type==1){
                                            echo 'datepicker1';
                                          }else if($login_date_type==2){
                                            echo 'bod-picker';
                                          }else{
                                            echo 'datepicker1';
                                          } ?>" 
                                           >
                                        <label for="submitdate">Enter submission date</label>
                                      </div>
                                    </div>
                                    
                                    <button id="submitBtn" class="btn waves-effect waves-light blue lighten-2" type="submit" >Submit</button>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>


<!-- add footer.php here -->
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
$(document).ready(function (e) 
{
  $("#add_homework_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "hwmsgscript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            // $("#err").fadeOut();
            $("#overlayloading").show();
            $("#submitBtn").hide();
          },
          success: function(data)
          {
            if ((data.indexOf("Homework added successfully"))<0) {

              Materialize.toast(data, 4000, 'red rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            }else if ((data.indexOf("Homework added successfully"))>=0) {

                window.location.href = 'hwmsg.php';
            }
            $("#overlayloading").hide();
            $("#submitBtn").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
            $("#submitBtn").show();
          }          
    });
  }));  
});

</script>
