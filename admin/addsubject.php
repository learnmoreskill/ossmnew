<?php
   include('session.php');
   require("../important/backstage.php");
   $backstage = new back_stage_class();

   $year_id = $current_year_session_id;

if(isset($_GET['token']) && @$_GET['token']=="2ec9yStrw89s9") { 

  if (isset($_GET["key"])){
      $longid = addslashes($_GET["key"]);
      $shortid = substr($longid, 18);


      $subjectList = json_decode($backstage->get_subject_details_by_subject_id($shortid));
       
  }
 
} else {
  //set active navbar session
  $_SESSION['navactive'] = 'addsubject';

}


  $classList= json_decode($backstage->get_class_list_by_year_id($year_id));
  $teacher_list = json_decode($backstage->get_teacher_details());
  $examTypeList= json_decode($backstage->get_examtype_list_details_by_date_id($year_id));

?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
<script>
  function splitMarking(str) {

    var x = document.getElementsByClassName("practicalDiv");
    var y = document.getElementsByClassName("theoryDiv");

    if (str == 101) {

      for(var i = 0, length = x.length; i < length; i++) {
           x[i].style.display = 'none';
           y[i].style.display = "block";
      } 
    }else if(str == 202){
      for(var i = 0, length = x.length; i < length; i++) {
           x[i].style.display = 'block';
           y[i].style.display = "block";
      }
    }else if(str == 303){
      for(var i = 0, length = x.length; i < length; i++) {
           x[i].style.display = 'none';
           y[i].style.display = "none";
      }
    }
  }
</script>
    
        <main>
          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                      <?php if( (isset($_GET['token']) && @$_GET['token']=="2ec9yStrw89s9") ){ ?>
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Edit Subject</a></div>
                        <?php }else{?>
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Add Subject</a></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
   
<!-- ================================= Add/Edit subject div ========================================== -->
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                           
                            <div class="row">
                                <form class="col s12" id="add_subject_form" action="" method="post" >


                                  <input name="add_subject_request"  type="hidden" value="add_subject_request">
                                  <input name="subjectId" type="hidden" value="<?php echo $subjectList->subject_id; ?>">
                                  <input name="year_id" type="hidden" value="<?php echo $year_id; ?>">

                                     <div class="row">
                                            <div class="col s12 m12">
                                                <div class="input-field col s12">
                                                    
                                                    <select name="classId" required>
                                                        <option value="" disabled>Select class</option>
                                                             <?php 
                                                              foreach ($classList as $clist) {
                                                                    echo '<option value="'.$clist->class_id.'" '.(($clist->class_id==$subjectList->subject_class)? 'selected' : '' ).' > ' . $clist->class_name. ' </option>';
                                                              }
                                                              ?>
                                                    </select>
                                                        <label>Select Class</label>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                          <input name="subjectname" id="subjectname" type="text" value="<?php echo $subjectList->subject_name; ?>" class="validate" required>
                                          <label for="subjectname">Subject Name</label>
                                        </div>

                                        <div class="input-field col s6">
                                            <select name="major" >
                                                <option value=0 <?php echo ((0==$subjectList->major)? 'selected':'' ); ?> >Select category</option>
                                                <option value=1 <?php echo ((1==$subjectList->major)? 'selected':'' ); ?> >Major</option>
                                                <option value=2 <?php echo ((3==$subjectList->major)? 'selected':'' ); ?> >Minor</option>
                                            </select>
                                                <label>Subject category</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="input-field col s6">
                                            <select name="teacherId">
                                                <option value="0" >Select Subject's Teacher</option>
                                                <?php 
                                                  foreach ($teacher_list as $teacherList) {
                                                        echo '<option value="'.$teacherList->tid.'" '.(($teacherList->tid==$subjectList->teacher_id)? 'selected' : '' ).' > ' . $teacherList->tname. ' </option>';
                                                    }
                                                ?>
                                            </select>
                                                <label>Select Teacher</label>
                                        </div>

                                        <div class="input-field col s6">
                                          <input name="sortOrder" id="sortOrder" type="number" class="validate" value="<?php echo ((!empty($subjectList->sort_order))? $subjectList->sort_order:0 ); ?>" min="0" max="99" >
                                          <label for="sortOrder">Sort Order</label>
                                        </div>
                                    </div>
                                    
                                        

                                    <!-- ---------- Split -------------- -->
                                    <div class="row center">
                                      <div class="input-field col s12 ">
                                          <h5>Select subject type</h5>

                                        <input class="with-gap" name="subType" value="101" type="radio" id="default" 
                                        <?php if (isset($subjectList->subject_type)) { 
                                          if($subjectList->subject_type==0){ echo "checked='checked'"; }
                                        }else{
                                          echo "checked='checked'";
                                        }   ?> 
                                        checked onchange="splitMarking(this.value)" />
                                        <label for="default">Theory only</label>

                                        <input class="with-gap" name="subType" value="202" type="radio" id="one" 
                                        <?php if($subjectList->subject_type==1){ echo "checked='checked'"; }  ?>
                                        onchange="splitMarking(this.value)" />
                                        <label for="one">With practical</label>

                                        <input class="with-gap" name="subType" value="303" type="radio" id="two" 
                                        <?php if($subjectList->subject_type==3){ echo "checked='checked'"; }  ?>
                                        onchange="splitMarking(this.value)" />
                                        <label for="two">Grade</label>
                                      </div>
                                              
                                    </div>

                                    <?php 
                                    if (count((array)$examTypeList)>0) { ?>

                                      <input name="examCount"  type="hidden" value="<?php echo count((array)$examTypeList);?>">

                                        <div class="row scrollable">
                                          <div style="min-width: 1000px;" >



                                            <table class="centered bordered striped highlight z-depth-4">
                                              <thead>
                                                  <tr>
                                                    <?php 
                                                      foreach ($examTypeList as $examtype_list) { 
                                                        echo "<th>".$examtype_list->examtype_name."</th>";
                                                      }
                                                    ?>
                                                      
                                                  </tr>
                                              </thead>
                                                <tbody>
                                                <tr>

                                                    <?php $cid = 0;
                                                      foreach ($examTypeList as $examtype_list) { 

                                                        $subj_mark = json_decode($backstage->get_subject_mark_by_examtype_id_subject_id_year_id($examtype_list->examtype_id, $shortid, $year_id));

                                                        ?>

                                                        <input name="examtype_id[<?php echo $cid; ?>]"  type="hidden" value="<?php echo $examtype_list->examtype_id; ?>">

                                                        <input name="subject_mark_id[<?php echo $cid; ?>]"  type="hidden" value="<?php echo $subj_mark->id; ?>">


                                                        <td class='grey darken-3'>
                                                          <div class='splitmark'  >
                                                            <div class="row theoryDiv"
                                                              <?php 
                                                                if($subjectList->subject_type==3){ echo "style='display: none;'"; }
                                                              ?>  >
                                                                <div class="input-field col s6">
                                                                  <input name="tfm[<?php echo $cid; ?>]" id="tfm" step="any" type="number" value="<?php echo $subj_mark->th_fm; ?>" class="validate">
                                                                  <label for="tfm">T. Full Mark</label>
                                                                </div>
                                                                <div class="input-field col s6">
                                                                  <input name="tpm[<?php echo $cid; ?>]" id="tpm" step="any" type="number" value="<?php echo $subj_mark->th_pm; ?>" class="validate">
                                                                  <label for="tpm">T. Pass Mark</label>
                                                                </div>
                                                            </div>
                                                            <div class="row practicalDiv" 
                                                            <?php 
                                                              if (isset($subjectList->subject_id)) { 
                                                                if($subjectList->subject_type==0 || $subjectList->subject_type==3){ echo "style='display: none;'"; }
                                                              }else{  echo "style='display: none;'";
                                                              }  ?> >
                                                                <div class="input-field col s6">
                                                                  <input name="pfm[<?php echo $cid; ?>]" id="pfm" step="any" type="number" value="<?php echo $subj_mark->pr_fm; ?>" class="validate">
                                                                  <label for="pfm">P. Full Mark</label>
                                                                </div>
                                                                <div class="input-field col s6">
                                                                  <input name="ppm[<?php echo $cid; ?>]" id="ppm" step="any" type="number" value="<?php echo $subj_mark->pr_pm; ?>" class="validate">
                                                                  <label for="ppm">P. Pass Mark</label>
                                                                </div>
                                                            </div>
                                                          </div>

                                                          <div class="row center">
                                                            <div class="col s12">
                                                              <div class="col s4 switch">
                                                                <label style="font-size: 20px" class="white-text">MT<br>
                                                                  <input type="checkbox" name="mt[<?php echo $cid; ?>]" 
                                                                  <?php echo (($subj_mark->mt)? 'checked' : ''); ?> >
                                                                  <span class="lever"></span></label>
                                                              </div>

                                                              <div class="col s4 switch">
                                                                  <label style="font-size: 20px" class="white-text">OT<br>
                                                                  <input type="checkbox" name="ot[<?php echo $cid; ?>]" 
                                                                  <?php echo (($subj_mark->ot)? 'checked' : ''); ?> >
                                                                  <span class="lever"></span></label>
                                                              </div>

                                                              <div class="col s4 switch">
                                                                  <label style="font-size: 20px" class="white-text">ECA<br>
                                                                  <input   type="checkbox" name="eca[<?php echo $cid; ?>]" 
                                                                  <?php echo (($subj_mark->eca)? 'checked' : ''); ?> >
                                                                  <span class="lever"></span></label>
                                                              </div>

                                                              <div class="col s4 switch">
                                                                  <label style="font-size: 20px" class="white-text">LP<br>
                                                                  <input   type="checkbox" name="lp[<?php echo $cid; ?>]" 
                                                                  <?php echo (($subj_mark->lp)? 'checked' : ''); ?> >
                                                                  <span class="lever"></span></label>
                                                              </div>

                                                              <div class="col s4 switch">
                                                                  <label style="font-size: 20px" class="white-text">NB<br>
                                                                  <input   type="checkbox" name="nb[<?php echo $cid; ?>]" <?php echo (($subj_mark->nb)? 'checked' : ''); ?> >
                                                                  <span class="lever"></span></label>
                                                              </div>

                                                              <div class="col s4 switch">
                                                                  <label style="font-size: 20px" class="white-text">SE<br>
                                                                  <input   type="checkbox" name="se[<?php echo $cid; ?>]" <?php echo (($subj_mark->se)? 'checked' : ''); ?> >
                                                                  <span class="lever"></span></label>
                                                              </div>
                                                            </div>

                                                          </div>


                                                        </td>
                                                    <?php $cid ++; } ?>

                                                </tr>
                                                </tbody>
                                                           
                                            </table>
                                          
                                

                                          </div>
                                        </div>
                                    <?php }

                                    //hacksterCode
                                    /*else{ ?>

                                      <br><br>
                                      <div class="row center">
                                          <h5 class="red-text">Note: Please add all the exam types before you add subject to entry full mark and pass mark...</h5>
                                      </div>


                                    <?php } */


                                    ?>
                                    

                                    <div class="row">
                                        <div id="submit_div" class="input-field col offset-m10">
                                             <button class="btn waves-effect waves-light blue lighten-2" type="submit">Submit
                                                <i class="material-icons right">send</i>
                                              </button>
                                        </div>

                                    </div>
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
  $("#add_subject_form").on('submit',(function(e) 
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
            $("#submit_div").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Subject succesfully added'.trim()) { 

              window.location.href = window.location.href;

            }else if (data.trim() === 'Subject succesfully added'.trim()) {

              window.location.href = 'addsubject.php';
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#submit_div").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
            $("#submit_div").show();
          }          
    });
  }));
});
</script>

    