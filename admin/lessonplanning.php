<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'lessonplanning';
include("../important/backstage.php");
$backstage = new back_stage_class();
   
$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

   $planned_lession = json_decode($backstage->get_planned_lession());
   //hacksterCode
   // $planned_lession = json_decode($backstage->get_planned_lession_year_id($year_id));
   $teacher_list = json_decode($backstage->get_teacher_details());
?>

<!-- add adminheader.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>


<script>
   $(document).ready(function () {
       $('.slider').slider({full_width: true,height:500,});
   });
</script>
    <!-- guddu design -->
<script type="text/javascript">
  function loadScript() {

  $('#tableName').DataTable( {
      dom: 'Bfrtip',
      // "initComplete": function(settings, json) {
      //     $('.buttons-excel').click();
      // },
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
  } );
  $('#tableName').css({'max-width':$('#tableName').width()+'px'})
  }

  $('#tableName').DataTable( {
    paging: false
} );
 
$('#tableName').DataTable( {
    destroy: true,
    searching: false
} );

  function fillMe() {
      var className = document.getElementById('className').value;
      xmlhttp1 = window.XMLHttpRequest? new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");
      xmlhttp2 = window.XMLHttpRequest? new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");
      xmlhttp1.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#txtSection");
                document.getElementById("txtSection").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            }
          }
      };
      xmlhttp2.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#txtSubject");
                document.getElementById("txtSubject").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            }
          }
      };
      xmlhttp1.open("GET","../important/getListById.php?classforsection="+className,true);
      xmlhttp1.send();
      xmlhttp2.open("GET","../important/getListById.php?classforsubject="+className,true);
      xmlhttp2.send();

      $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
         });
  }

  function reportFormSubmit(){

   var className = document.getElementById('className').value;
    var section = document.getElementById('txtSection').value;
    var x = document.getElementById('txtSubject');
    var subjectID = x.value;
    var subject = x.options[x.selectedIndex].innerHTML;

    xmlhttp = window.XMLHttpRequest? new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");

    xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            document.getElementById("tableName").innerHTML = this.responseText;
            loadScript();
            //selectDropdown.trigger('contentChanged');
        }
    };
    xmlhttp.open("GET","getLessionPlan.php?class="+className+'&section='+section+'&subjectID='+subjectID,true);
    xmlhttp.send();


  }
  function navToDetail(){
     window.location.href ="lessonplanningdetail.php"
  }
  function removeNow(id){
    document.getElementById(id).remove();
  }
</script>

            <!-- get section list from database-->
<script>
    function showUser(str) {
      if (str == "") {
          document.getElementById("txtHint").innerHTML = "";
          document.getElementById("subjectList").innerHTML = "";

          return;
      } else { 
          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
              xmlhttp2 = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var selectDropdown =    $("#txtHint");
                  document.getElementById("txtHint").innerHTML = this.responseText;
                  selectDropdown.trigger('contentChanged');
              }
          };
          xmlhttp2.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var selectDropdown2 =    $("#subjectList");
                  document.getElementById("subjectList").innerHTML = this.responseText;
                  selectDropdown2.trigger('contentChanged');
              }
          };
          xmlhttp.open("GET","../important/getListById.php?classforsection="+str,true);
          xmlhttp.send();
          xmlhttp2.open("GET","../important/getListById.php?subjectListByClassIdUnselected="+str,true);
          xmlhttp2.send();
          $('select').on('contentChanged', function() { 
          // re-initialize 
         $(this).material_select();
           });
      }
    }

    function getLessionPlan() {
      var className = document.getElementById('classList').value;
      var section = document.getElementById('txtHint').value;
      var x = document.getElementById('subjectList');
      var subjectID = x.value;
      var subject = x.options[x.selectedIndex].innerHTML;

      xmlhttp = window.XMLHttpRequest? new XMLHttpRequest:new ActiveXObject("Microsoft.XMLHTTP");

      xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              document.getElementById("lessionPlanTable").innerHTML = this.responseText;
              process.nextTick(loadScript());
              //selectDropdown.trigger('contentChanged');
          }
      };
          xmlhttp.open("GET","getLessionPlan.php?class="+className+'&section='+section+'&subjectID='+subjectID+'&subject='+subject,true);
          xmlhttp.send();
      // $('select').on('contentChanged', function() { 
      //     // re-initialize 
      //    $(this).material_select();
      //  });
    }
</script>


    <main>
    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center"><a class="white-text text-lighten-4" href="#">Lesson planning</a></div>
            </div>
        </div>
    </div>


            <section class = "container" style="width: 95%">              
              <ul id="tabs-swipe-demo" class="tabs">
                <?php if ($login_cat == 1 || $pac['add_lesson']) { ?>
                <li class="tab col s3"><a class="active" href="#test-swipe-1">Planning</a></li>
                <?php } ?>
                <?php if ($login_cat == 1 || $pac['view_lesson']) { ?>
                <li class="tab col s3"><a  href="#test-swipe-2">Report</a></li>
                <?php } ?>
              </ul>

              <?php if ($login_cat == 1 || $pac['add_lesson']) { ?>

              <div id="test-swipe-1" class="col s12">

                <div class="row ">
                  <div class="col s12 m6">
                    <div class="card">
                      <div class="card-content no-padding">
                        <span class="card-title cPadding no-margin grey lighten-4"><b>Lesson planning</b></span>
                        <hr class="no-margin">
                          <form id="add_lesson_planning_form" class="cPadding" method="POST" action="addscript.php">
                            <div class = "row no-margin"><br>

                              <div class="input-field col s12">
                                <select onchange="showUser(this.value)" name="class">
                                   <option value="" disabled selected>Choose Class</option>
                                    <?php 
                                    foreach ($classList as $clist) {
                                          echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                    }
                                    ?>
                                </select>
                                
                                <label>Class <span>*</span></label>
                              </div>
                              <div class="input-field col s12">
                                <select name="section" id="txtHint">
                                  <option value="" >Select class first</option>
                                </select>
                                <label>Section:</label>
                              </div>

                              <div class="input-field col s12">
                                <select name="subject_id" id="subjectList">
                                  <option value="" >Select class first</option>
                                </select>
                                <label>Subject:</label>
                              </div>


                               <div class="input-field col s12">
                                <select name="teacher_id">
                                  <option value="" disabled selected>Choose Teacher</option>
                                  <?php 
                                    foreach ($teacher_list as $teacherList) {
                                          echo '<option value="'.$teacherList->tid.'"> ' . $teacherList->tname. ' </option>';
                                      }
                                  ?>
                                </select>
                                <label>Teacher <span>*</span></label>
                              </div>

                              <!--  <div class="input-field col s12">
                                <div class="chips input">
                                <input id="input_text" type="text" name="topic" class="custom-class">
                              </div> -->

                               <div class="input-field col s12">
                                <input id="input_text" type="text" name="topic" >
                                <label for="input_text">Topic<span>*</span></label>
                              </div>

                              <div class="input-field col s12 m6">
                                <input name="start_date" id="start_date" type="text" placeholder="Select Start Date"
                                class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                                >
                                <label for="input_text">Start date<span>*</span></label>
                              </div>

                              <div class="input-field col s12 m6">
                                <input name="end_date" id="end_date" type="text" placeholder="Select Till Date"
                                class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                                >
                                <label for="input_text">Till date<span>*</span></label>
                              </div>
                            </div>

                            <input type="hidden" name="add_lession_planning" value="save">

                            <div class=" center-align cPadding">
                              <button class="waves-effect waves-light btn" type="submit">Save</button>
                            </div><br>
                          
                      </div>
                      
                      </form>
                    </div>
                  </div>
                  <div class="col s12 m6">
                    <div class="card">
                      <div class="card-content no-padding">
                        <span class="card-title cPadding no-margin grey lighten-4"><b>Already planned Lesson</b></span>
                        <hr class="no-margin">
                          <table class="striped">
                            <thead>
                              <tr>
                                  <th>Teacher</th>
                                  <th>class/sec</th>
                                  <th>Sub</th>
                                  <th>Topic</th>
                                  <?php if ($login_cat == 1 || $pac['edit_lesson']) { ?>
                                  <th style="min-width: 63px">Action</th>
                                  <?php } ?>

                              </tr>
                            </thead>
                            <tbody>                                 
                            <?php  if (count((array)$planned_lession)) {                                        
                              foreach ($planned_lession as $lession) {
                
                                    echo "<tr>
                                      <td>" . $lession->tname. "</td>
                                      <td>" . $lession->class_name. " - " . $lession->section_name. "</td>
                                      <td>" . $lession->subject_name. "</td>
                                      <td>" . $lession->topic. "</td>
                                      ".(($login_cat == 1 || $pac['edit_lesson'])? "<td ><a href='lessonplanningdetail.php?id=".$lession->id."'> <i class='material-icons prefix green-text text-darken-3' title='View' > visibility</i></a>
                                         <a href='lessonplanning_delete.php?id=".$lession->id."'> <i class='material-icons prefix red-text text-darken-3' title='Delete' > delete</i></a>
                                      </td>":"")."
                                    </tr>";
                                    } }else{?>
                                    <tr>
                                        <td colspan="5" class="center">No lesson plan scheduled</td>
                                      </tr>
                                    <?php } ?>
                                </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
                </div><!-- End of Sign Up Card row -->
              </div>

            <?php } ?>
            <?php if ($login_cat == 1 || $pac['view_lesson']) { ?>

              <div id="test-swipe-2" class="col s12">
              
                  <div class="card">
                      <div class="card-content no-padding">
                        <span class="card-title cPadding no-margin grey lighten-4"><b>Planning Report</b></span>
                        <hr class="no-margin">
                          <form class=" cPadding" name="lessonReportForm" id="lessonReportForm" novalidate>
                            <div class = "row no-margin">
                              <div class="input-field col s12 l3">
                                <select name="class" required="" onchange="fillMe();" id="className" data-value-missing=”Translate(‘Required’)”>
                                <option value="" disabled selected>Choose Class</option>
                                 <?php 
                                    foreach ($classList as $clist) {
                                          echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                    }
                                    ?>
                                </select>
                                <label>Class <span>*</span></label>
                              </div>
                              <div class="input-field col s12 l3">
                                <select name="section_id" id="txtSection">
                                  <option value="" disabled selected>Select Section</option>
                                </select>
                                <label>Section <span>*</span></label>
                              </div>
                              <div class="input-field col s12 l3">
                                <select name="subject_id" id="txtSubject">
                                  <option value="" disabled selected>Select Subject</option>
                                </select>
                                <label>Subject <span>*</span></label>
                              </div>
                              <div class="input-field col s12 l3 center-align">
                                <a class="waves-effect waves-light btn" onclick="reportFormSubmit()">view</a>
                              </div>
                              
                            </div>
                          </form>
                      </div>                  
                    </div>
                    <div class="row">
                      <div id="lessionPlanTable" class="scrollable" style="overflow: auto;">
                        <table id="tableName">
                        </table>
                        <div id="tableName1" class="striped highlight centered responsive-table">
                        </div>
                      </div>
                    </div>
                         
              </div>
            <?php } ?>


            </section>


            <!-- end guddu desing -->


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
$(document).ready(function (e) 
{
  $("#add_lesson_planning_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "addscript.php",
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
            if ((data.indexOf("Lesson plan succesfully added"))<0) {
              Materialize.toast(data, 4000, 'rounded');
              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              }); 
            }else if ((data.indexOf("Lesson plan succesfully added"))>=0) {

              window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  
});

</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


