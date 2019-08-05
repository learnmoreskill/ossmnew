<?php

include('session.php');
include("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'markstabulation';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

$examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>


    <!-- For csv excel script -->
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/tableexport@5.2.0/dist/css/tableexport.css">
    <!-- <script  src="https://code.jquery.com/jquery-3.4.1.js"></script> -->
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/file-saver@2.0.2/dist/FileSaver.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.14.4/xlsx.core.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/tableexport@5.2.0/dist/js/tableexport.js"></script>

    <!-- for pdf -->
    <script src="https://unpkg.com/jspdf@1.5.3/dist/jspdf.min.js"></script>
    <script src="https://unpkg.com/jspdf-autotable@3.1.3/dist/jspdf.plugin.autotable.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.js"></script> 
    <!-- end csv excel script -->

    <!-- get section list from database-->
    <script>
        function showUser(str) {
          if (str == "") {
              document.getElementById("section_id").innerHTML = "";
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
                      var selectDropdown =    $("#section_id");
                      document.getElementById("section_id").innerHTML = this.responseText;
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
    </script>

    
        <main>
          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Tabulation sheet</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form id="marks_form" action="markstabulationscript.php" method="post" class="col s12" >

                  <input type="hidden" name="y04x20" id="yearid" value="<?php echo $year_id; ?>">


                    <div class="row">
                        <div class="input-field col s6 m3">
                                <select id="class_id" name="class_id" onchange="showUser(this.value)">

                              <option value="" >Select class</option>

                                <?php 
                                foreach ($classList as $clist) {
                                  echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                }
                                ?>
                            </select>
                            <label>Class:</label>
                        </div>
                        <div class="input-field col s6 m3">
                            <select name="section_id" id="section_id">
                            <option value="" >Select class first</option>
                            </select>
                            <label>Section:</label>
                        </div>

                        <div class="input-field col s12 m2">
                          <select name="examtypeid" id="examtypeid" onchange="showMonth(this.value)">
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
                    
                        

                    </div>
                    <div class="row">
                      <div class="input-field col m2">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                              </button>
                        </div>
                    </div>

                </form>
            </div>

            <div  id="display_markstable" >
            </div>

            
        </main>
        


<?php include_once("../config/footer.php");?>      

<script>/*function validate(form) {
          var e = form.elements, m = '';

              if(!e['class_id'].value) {m += '- Select class name.\n';}
              if(!e['examtypeid'].value) {m += '- Select exam type.\n';}
              if(!e['y04x20'].value) {m += '- Select year.\n';}

              if(e['examtypeid'].value =="5" || e['examtypeid'].value =="6") {
                if(!e['m04x20'].value) {m += '- Select month.\n';}
              }
              
              if(m) {
                alert('The following error(s) occurred:\n\n' + m);
                return false;
              }else
              return true;
            }*/


$(document).ready(function (e) 
{
  $("#marks_form").on('submit',(function(e) 
  { 

    var x = document.getElementById("overlayloading");
        

    e.preventDefault();
    var class_id=document.getElementById( "class_id" ).value;
    var section_id=document.getElementById( "section_id" ).value;
    var examtypeid=document.getElementById( "examtypeid" ).value;
    var month_id=document.getElementById( "month_id" ).value;
    var yearid=document.getElementById( "yearid" ).value;
    var rankselected=document.getElementById( "rankselected" ).value;

    if(!class_id){  Materialize.toast('Please select class', 4000, 'rounded'); }
    else if(!examtypeid){  Materialize.toast('Please select exam', 4000, 'rounded'); }
    else if(!yearid){  Materialize.toast('Please select year', 4000, 'rounded'); }
    else if((examtypeid =="5" || examtypeid =="6") && !month_id) { Materialize.toast('Please select month', 4000, 'rounded'); }
    else if(class_id && examtypeid && yearid){

      x.style.display = "block";

      $.ajax({
      type: 'post',
      url: 'markstabulationscript.php',
      data: {
       markstoken:'marksledger',
       class_id:class_id,
       section_id:section_id,
       examtypeid:examtypeid,
       month_id:month_id,
       yearid:yearid,
       rankselected:rankselected,
      },
      success: function (response) {
       // We get the element having id of display_info and put the response inside it
       $( '#display_markstable' ).html(response);
       x.style.display = "none";
      }
      });
    }
  
 else
 {
  $( '#display_markstable' ).html("");
  x.style.display = "none";
 }

  }));
});

</script>