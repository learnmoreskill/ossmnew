<?php
include('session.php'); 
/*set active navbar session*/
$_SESSION['navactive'] = 'examsetting';

  require("../important/backstage.php");
  $backstage = new back_stage_class();

  //$yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));
  $yearId = $current_year_session_id;


  $examTypeListDetails = json_decode($backstage->get_examtype_list_details_by_date_id($current_year_session_id));


?>

<!-- add adminheade.php here -->
<?php include_once("../config/header.php"); ?>
<?php include_once("navbar.php"); ?>

  <main>
    <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>

    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
          <div class="row">
            <div class="col s12">
              <ul class="tabs github-commit">            
                <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#update_exam_type">Exam Format</a></li>
                <li class="tab col s3"><a class="white-text text-lighten-4" href="#exam_type_list">Exam List</a></li>
              </ul>
            </div>
          </div>
    </div>

<!-- ================================= Exam format div ========================================== -->
      <div id="update_exam_type">

            <?php $i=0;
            $rowcount = count((array)$examTypeListDetails);
            foreach ($examTypeListDetails as $examtype) {
            ?>

            <div class="row">
                <div class="col s12"> 
                  <div class="card teal center lighten-2">
                    <div style="padding: 5px;">

                      <span class="card-title white-text" style="margin-top: 6px; font-size: 30px">
                        <?php echo $examtype->examtype_name;?>
                      </span>

                      <span class="right" style="padding-right: 20px;">

                        <a class="modal-trigger tooltipped" data-position="left" data-delay="50" data-tooltip="add" 
                        id="<?php echo $examtype->examtype_id; ?>" href="#modalId" onClick="set_variable_for_add(this.id)" ><i class="material-icons  medium black-text" style="font-size: 3rem;"  >add</i>
                        </a>
                        
                      </span>

                    </div>
                    
                  </div>
                </div>
            </div>
            <?php



            $examIncludeList = json_decode($backstage->get_examinclude_list_by_examtype_id($examtype->examtype_id,$yearId));

            if (count((array)$examIncludeList)<1) {

            }else{

            ?>
            <div class="row scrollable">
              <div class="col s12 m12">
                  <table class="centered bordered striped highlight z-depth-4">
                  <thead>
                      <tr>
                          <th>Exam Name</th>
                          <th>Included percent</th>

                          <?php if ($login_cat ===1 || $login_cat ===2 || $pac['edit_examsetting']) { ?>

                          <th>Sort Order</th>

                          <?php } ?>
                          <?php if ($login_cat ===1 || $pac['edit_examsetting']) { ?>

                          <th>Action</th>

                          <?php } ?>
                      </tr>
                  </thead>
                  <tbody>

              <?php

              foreach ($examIncludeList as $examinclude) {
              ?>


              <tr>
                  <td>
                      <?php echo $examinclude->examtype_name; ?>
                  </td>
                  <td>
                      <?php echo $examinclude->percent; ?>
                  </td>

                  <?php if ($login_cat ===1 || $login_cat ===2  || $pac['edit_examsetting']) { ?>

                  <td>
                      <?php echo $examinclude->sort_order;  ?>
                  </td>

                  <?php } ?>
                  <?php if ($login_cat ===1 || $pac['edit_examsetting']) { ?>

                  <td>


                  <input type="hidden" id="eid<?php echo $examinclude->exam_include_id; ?>" value="<?php echo $examtype->examtype_id; ?>" >

                  <input type="hidden" id="aeid<?php echo $examinclude->exam_include_id; ?>" value="<?php echo $examinclude->added_examtype_id; ?>" >
                  <input type="hidden" id="per<?php echo $examinclude->exam_include_id; ?>" value="<?php echo $examinclude->percent; ?>" >
                  <input type="hidden" id="so<?php echo $examinclude->exam_include_id; ?>" value="<?php echo $examinclude->sort_order; ?>" >

                  <a class="modal-trigger" id="<?php echo $examinclude->exam_include_id; ?>" href="#modalId" onClick="set_variable(this.id)" >
                      <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                              <i class="material-icons green-text text-lighten-1">edit</i></div></a>


                  <a href="deleteuserscript.php?token=7examinclude4g&key=<?php echo "ae25nJ5s3fr596dg@".$examinclude->exam_include_id; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }"> 
                      <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                              <i class="material-icons red-text text-darken-4">delete</i></div></a> 


                  </td>

                  <?php } ?>
              </tr>
              <?php
              } ?>

              </tbody>
              </table>
              </div>
              </div>

            <?php } ?>

            <?php }?>
                    
      </div>

      <!-- ================================= Exam list div ========================================== -->
      <div id="exam_type_list">

        <div class="row scrollable">
              <div class="col s12 m12">
                  <table class="centered bordered striped highlight z-depth-4">
                  <thead>
                      <tr>
                          <th>Exam Name</th>

                          <th>Self Include</th>

                          <th>Exam Type</th>

                          <?php if ($login_cat ===1 || $pac['edit_examsetting']) { ?>

                          <th>Action</th>

                          <?php } ?>
                      </tr>
                  </thead>
                  <tbody>

              <?php

              foreach ($examTypeListDetails as $examincludelist) {
              ?>


              <tr>
                  <td>
                      <?php echo $examincludelist->examtype_name; ?>
                  </td>
                  <td>
                      <?php echo (($examincludelist->self_include)? 'Included' : 'Not included'); ?>
                  </td>

                  <td>
                      <?php echo (($examincludelist->is_monthly)? 'Monthly' : 'Yearly');  ?>
                  </td>

                  <?php if ($login_cat ===1 || $pac['edit_examsetting']) { ?>

                  <td>


                  <input type="hidden" id="examtype_name<?php echo $examincludelist->examtype_id; ?>" value="<?php echo $examincludelist->examtype_name; ?>" >

                  <input type="hidden" id="self_include<?php echo $examincludelist->examtype_id; ?>" value="<?php echo $examincludelist->self_include; ?>" >
                  <input type="hidden" id="is_monthly<?php echo $examincludelist->examtype_id; ?>" value="<?php echo $examincludelist->is_monthly; ?>" >
                  <a class="modal-trigger" id="<?php echo $examincludelist->examtype_id; ?>" href="#modal_edit_examtype" onClick="set_variable_for_examtype_list(this.id)" >
                      <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                              <i class="material-icons green-text text-lighten-1">edit</i></div></a>


                  </td>

                  <?php } ?>
              </tr>
              <?php
              } ?>

              </tbody>
              </table>
              </div>
              </div>



        <!-- <div class="row">
          <div class="col s12"> 
            <form id="exam_form" action="updatescript.php" method="post"  >

              <?php $i=0; if ($sqlexamdetails->num_rows) {
                $rowcount=mysqli_num_rows($sqlexamdetails);
              while($examrows = $sqlexamdetails->fetch_assoc()) {
                ?>
                <div class="row">
                  <div class="input-field col s4">

                    <input name="count" id="count" type="hidden" value="<?php echo $rowcount;?>">

                      <input name="examname[<?php echo $i; ?>]"  id="examname" type="text" value="<?php echo $examrows["examtype_name"];?>" class="validate" >
                      <label for="examname">Exam Name</label>
                    </div>

                    <div class="input-field col s2">
                          <select name="exam_type[<?php echo $i; ?>]">
                            <option value="" disabled>Choose exam type</option>
                            <option value="0" <?php echo (($payment_type=='0')?'selected="selected"':''); ?> >Monthly wise</option>
                            <option value="1" <?php echo (($payment_type=='1')?'selected="selected"':''); ?> >Yearly </option>
                          </select>
                          <label>Exam Type</label>
                    </div>

                    <div class="input-field col s2">
                          <select name="exam_type[<?php echo $i; ?>]">
                            <option value="" disabled>Choose exam type</option>
                            <option value="0" <?php echo (($payment_type=='0')?'selected="selected"':''); ?> >Monthly wise</option>
                            <option value="1" <?php echo (($payment_type=='1')?'selected="selected"':''); ?> >Yearly </option>
                          </select>
                          <label>Exam Type</label>
                    </div>

                    <div class="input-field col s2">
                        <select name="print_format[<?php echo $i; ?>]">
                          <option value="" disabled>Choose print type</option>
                          <option value="a5" <?php echo (($examrows["print_format"]=='a5')?'selected="selected"':''); ?> >A5 Size</option>
                          <option value="a4" <?php echo (($examrows["print_format"]=='a4')?'selected="selected"':''); ?> >A4 Size</option>
                        </select>
                        <label>Print Format</label>
                    </div>

                   


                </div>
              
                <?php $i++; }}?>

                <div class="row">
                    <div class="input-field col offset-m5">
                         <button class="btn waves-effect waves-light" type="submit" >Submit<i class="material-icons right">send</i>
                          </button>
                    </div>
                </div>

            </form>
          </div>
        </div> -->

        <!-- =============== Modal Exam Type ==================================== -->
          <div id="modal_edit_examtype" class="modal">
            <div class="modal-content">
              <form id="update_examtype_form">
                <h6 align="center" id="examtype_title"></h6>
                <div class="divider"></div>

                <input type="hidden" name="update_examtype_request" value="update_examtype_request">

                <input type="hidden" name="update_examtype_id" id="update_examtype_id" value="">
                <input type="hidden" name="year_id" id="year_id" value="<?php echo $yearId; ?>">

                <div class="row">

                    <div class="input-field col s12">
                      <input name="examtype_name" id="examtype_name" type="text" class="validate"  required value="" >
                      <label for="examtype_name">Examtype Name</label>
                    </div>

                    <div class="col s6 switch">
                      <label style="font-size: 20px" >Self Include<br>
                        <input type="checkbox" name="self_include" id="self_include" >
                        <span class="lever"></span></label>
                    </div>
                    <div class="col s6 switch">
                      <label style="font-size: 20px" >Monthly Wise<br>
                        <input type="checkbox" name="is_monthly" id="is_monthly" 
                        >
                        <span class="lever"></span></label>
                    </div>
                    
                </div>

            <div class="modal-footer" id="formsubmit">

              <button class="modal-action waves-effect waves-green btn-flat blue lighten-2" type="submit" id="examtype_submit" ><i class="material-icons right">send</i></button>

              <div id="examtype_loadingBtn" class="right" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>

            </div>

            </form>
            </div>
          </div>
        <!-- ============== End Model =========================== -->


        <?php if($login_cat ===1 || $pac['edit_examsetting']){ ?>
        <div class="fixed-action-btn">
            <a href="#modal_edit_examtype" class="modal-trigger btn-floating btn-large red" onClick="set_variable_for_examtype_list()">
              <i class="large material-icons">add</i>
            </a>
        </div>
        <?php } ?> 
      </div>


  </main>

<?php include_once("../config/footer.php");?> 

<!-- =============== Modal Structure ==================================== -->
  <div id="modalId" class="modal">
    <div class="modal-content">
      <form id="update_exam_include_form" action="" method="post"  >
        <h6 align="center" id="title">Update Exam Include</h6>
        <div class="divider"></div>

        <input type="hidden" name="update_exam_include_request"  value="update_exam_include_request">

        <input type="hidden" name="update_id" id="update_id" value="">

        <input type="hidden" name="examtype_id" id="examtype_id" value="">

        <input type="hidden" name="year_id" id="year_id" value="<?php echo $yearId; ?>">

        <div class="row">

          <div class="input-field col s12">
              <select name="selected_exam" id="selected_exam">
                  <option value=''>Select Exam Type</option>
              </select>
                  <label>Select Exam Type</label>
            </div>

        </div>

        <div class="row">

            <div class="input-field col s6">
              <input name="percent" id="percent" type="number" min="1" max="100" class="validate" value="" placeholder="eg. 20" required>
              <label for="percent">Percent</label>
            </div>
        
            
            <div class="input-field col s6">
              <input type="number" min="0" max="99" name="sort_order" id="sort_order" class="validate" placeholder="eg. 2" value="" >
              <label for="sort_order">Sort Order</label>
            </div>
        </div>

    <div class="modal-footer" id="formsubmit">
      <button class="modal-action waves-effect waves-green btn-flat blue lighten-2" type="submit" >Update<i class="material-icons right">send</i></button>
    </div>

    </form>
    </div>
  </div>
<!-- ============== End Model =========================== -->
<?php 
 if (isset($_SESSION['result_success'])) 
  {
      $result1=$_SESSION['result_success'];
      echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
    unset($_SESSION['result_success']);
    }
?>
<script type="text/javascript">
    function set_variable(obj){

      document.getElementById("update_id").value=obj;

      var eid=document.getElementById("eid"+obj).value;
      var aeid=document.getElementById("aeid"+obj).value;
      var per=document.getElementById("per"+obj).value;
      var so=document.getElementById("so"+obj).value;

      document.getElementById("examtype_id").value = eid;
      document.getElementById("percent").value = per;
      document.getElementById("sort_order").value = so;



          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();

          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var selectDropdown =    $("#selected_exam");
                  document.getElementById("selected_exam").innerHTML = this.responseText;
                  selectDropdown.trigger('contentChanged');
              }
          };
          xmlhttp.open("GET","../important/getListById.php?examTypeListSelectedWithExcept="+aeid+"&except_exam_id="+eid,true);
          xmlhttp.send();
          $('select').on('contentChanged', function() { 
          // re-initialize 
         $(this).material_select();
           }); 
    }

    function set_variable_for_add(obj){

      document.getElementById("examtype_id").value = obj;

      document.getElementById("update_id").value = '';
      document.getElementById("percent").value = '';
      document.getElementById("sort_order").value = '';

          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();

          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  var selectDropdown =    $("#selected_exam");
                  document.getElementById("selected_exam").innerHTML = this.responseText;
                  selectDropdown.trigger('contentChanged');
              }
          };
          xmlhttp.open("GET","../important/getListById.php?examTypeListSelectedWithExcept=&except_exam_id="+obj,true);
          xmlhttp.send();
          $('select').on('contentChanged', function() { 
          // re-initialize 
         $(this).material_select();
           });
    }

    function set_variable_for_examtype_list(obj){

      var title = document.getElementById("examtype_title");
      var examtype_submit = document.getElementById("examtype_submit");

      if (obj) {

        document.getElementById("update_examtype_form").reset();

        title.innerHTML= "Update Exam Type";
        examtype_submit.innerHTML = "Update";


       document.getElementById("update_examtype_id").value=obj;

       var examtype_name = document.getElementById("examtype_name"+obj).value;
       var self_include = parseInt(document.getElementById("self_include"+obj).value);
       var is_monthly = parseInt(document.getElementById("is_monthly"+obj).value);

       document.getElementById("examtype_name").value = examtype_name;

       if (self_include) { document.getElementById("self_include").setAttribute("checked", "checked"); }
       if (is_monthly) { document.getElementById("is_monthly").setAttribute("checked", "checked"); }
       
      }else{

        document.getElementById("update_examtype_id").value='';

        document.getElementById("update_examtype_form").reset();

        document.getElementById("self_include").setAttribute("checked", "checked");

        title.innerHTML= "Add Exam Type";
        examtype_submit.innerHTML = "Add";
        
      }
    }
</script>

<script>
$(document).ready(function (e) 
{
  $("#update_exam_include_form").on('submit',(function(e) 
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
            //$("#err").fadeOut();
            $("#overlayloading").show();
            $("#formsubmit").hide();
          },
          success: function(data)
          { 
            //alert(data);
            if (data.trim() !== 'Exam setting successfully updated'.trim()) {
              Materialize.toast(data, 4000, 'red rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              }); 
            } 
            else if (data.trim() === 'Exam setting successfully updated'.trim()) {
                $('#modalId').modal('close');
              window.location.reload();
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#formsubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  }));

  $("#update_examtype_form").on('submit',(function(e) { 
    e.preventDefault();
    $.ajax
    ({
          url: "updatescript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#examtype_submit").hide();
            $("#examtype_loadingBtn").show();
          },
          success: function(data)
          {
            var result = JSON.parse(data);

            if (result.status == 200) {

              alert('Examtype successfully updated');   debugger;
              $('#modal_edit_examtype').modal('close');
              window.location.reload();

            }else{
              alert(result.errormsg);
            }

            $("#examtype_submit").show();
            $("#examtype_loadingBtn").hide();

          },
          error: function(e) 
          {
            $("#examtype_submit").show();
            $("#examtype_loadingBtn").hide();
            alert('Try Again !!');
          }
    });
  }));



  $("ul.tabs > li > a").click(function (e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;});
    var hash = window.location.hash;
    $('ul.tabs').tabs('select_tab', hash);

  });
</script>