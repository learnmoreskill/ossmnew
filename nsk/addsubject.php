<?php
   include('session.php'); 
   require("../important/backstage.php");
   $backstage = new back_stage_class();

   /*set active navbar session*/
    $_SESSION['navactive'] = 'addsubject';

    $classList= json_decode($backstage->get_class_list());
    $teacher_list = json_decode($backstage->get_teacher_details());
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
<script>
function splitMarking() {
    var x = document.getElementById("splitmark");
    var y = document.getElementById("singlemark");
    if (x.style.display === "none") {
        x.style.display = "block";
        y.style.display = "none";
    } else {
        x.style.display = "none";
        y.style.display = "block";
    }
}
</script>
    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Add Subject</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                           
                            <div class="row">
                                <form class="col s12" id="add_subject_form" action="addsubjectscript.php" method="post" >
                                     <div class="row">
                                            <div class="col s12 m12">
                                                <div class="input-field col s12">
                                                    
                                                    <select name="classname1" id="rolls" required>
                                                        <option value="" disabled>Select class</option>
                                                              <?php 
                                                              foreach ($classList as $clist) {
                                                                    echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                                              }
                                                              ?>
                                                    </select>
                                                        <label>Select Class</label>
                                                </div>
                                            </div>
                                        </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                          <input name="subjectname" id="subjectname" type="text" class="validate" required>
                                          <label for="subjectname">Subject Name</label>
                                        </div>
                                    </div>
                                    <!-- Split -->
                                    <div class="row center switch">
                                      <label style="font-size: 20px">Split Subject into Theoretical and Practical<br>
                                        <input onclick="splitMarking()" type="checkbox" name="checkboxvalue">
                                        <span class="lever"></span></label>
                                    </div>

                                    
                                     

                                    <div id='singlemark' style="display: block;">
                                      <div class="row">
                                        <div class="input-field col s12">
                                          <input name="totalmark" id="totalmark" type="text" class="validate">
                                          <label for="totalmark">Total mark</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                          <input name="passmark" id="passmark" type="text" class="validate">
                                          <label for="passmark">Pass Mark</label>
                                        </div>
                                    </div>
                                  </div>

                                    <div id='splitmark' style="display: none;">
                                    <div class="row">
                                        <div class="input-field col s6">
                                          <input name="thfullmark" id="thfullmark" type="text" class="validate">
                                          <label for="thfullmark">Theory Full Mark</label>
                                        </div>
                                        <div class="input-field col s6">
                                          <input name="thpassmark" id="thpassmark" type="text" class="validate">
                                          <label for="thpassmark">Theory Pass Mark</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s6">
                                          <input name="prcfullmark" id="prcfullmark" type="text" class="validate">
                                          <label for="prcfullmark">Practical Full Mark</label>
                                        </div>
                                        <div class="input-field col s6">
                                          <input name="prcpassmark" id="prcpassmark" type="text" class="validate">
                                          <label for="prcpassmark">Practical Pass Mark</label>
                                        </div>
                                    </div>
                                  </div>
                                    <div class="row">
                                                <div class="input-field col s12">
                                                    <select name="teacherid" id="teacherid">
                                                        <option value="0" >Select Subject's Teacher</option>
                                                        <?php 
                                                          foreach ($teacher_list as $teacherList) {
                                                                echo '<option value="'.$teacherList->tid.'"> ' . $teacherList->tname. ' </option>';
                                                            }
                                                        ?>

                                                    </select>
                                                        <label>Select Teacher</label>
                                                </div>
                                        </div>


                                        <input type="hidden" name="add_subject">
                                    <div class="row">
                                      <input type="hidden" name="add_subject">
                                        <div class="input-field col offset-m10">
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


<?php if (isset($_REQUEST['resp'])) 
{
  if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }
  
} ?>


<script>
$(document).ready(function (e) 
{
  $("#add_subject_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "addsubjectscript.php",
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
            if (data!='Subject succesfully added') { Materialize.toast(data, 4000, 'rounded'); } 
            else 
              if (data=='Subject succesfully added') {

              window.location.href = 'addsubject.php?resp=success';
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

    