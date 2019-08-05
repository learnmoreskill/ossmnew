<?php
include('session.php');

require("../important/backstage.php");

   $backstage = new back_stage_class();


if (isset($_GET["token"]) && $_GET["token"]== "53t137m1510n"){

  $t_role = $_GET['t_role'];
  $t_id = $_GET['t_id'];

  if (!empty($t_role) && !empty($t_id)) {

    $permission = json_decode($backstage->get_permission_by_t_role_and_t_id($t_role,$t_id));


  }else{ ?> <script> window.location.href = 'welcome.php'; </script> <?php }
    
} else{ ?> <script> window.location.href = 'welcome.php'; </script> <?php }

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php"); ?>
    <?php include_once("navbar.php"); ?>

        
        <main>
          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Manage Permission for <?php echo ucwords($_GET['name']); ?></a></div>
                    </div>
                </div>
            </div>
            <div class="row">

                <form class="col s12" id="update_permission_form" action="addscript.php" method="post" >

                  <input type="hidden" name="updtae_permission_id" value="<?php echo $permission->id; ?>" >
                  <input type="hidden" name="updtae_permission_t_role" value="<?php echo $t_role; ?>" >
                  <input type="hidden" name="updtae_permission_t_id" value="<?php echo $t_id; ?>" >



                  <div class="row">

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Attendance</h5></div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="a1" name="view_attendance"  <?php if($permission->view_attendance==1){echo "checked='checked'"; }  ?> /><label for="a1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="a2" name="take_attendance" <?php if($permission->take_attendance==1){echo "checked='checked'"; }  ?> /><label for="a2">Take</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="a3" name="edit_attendance" <?php if($permission->edit_attendance==1){echo "checked='checked'"; }  ?> /><label for="a3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Gallery</h5></div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="c1" name="view_gallery" <?php if($permission->view_gallery==1){echo "checked='checked'"; }  ?> /><label for="c1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="c2" name="add_gallery" <?php if($permission->add_gallery==1){echo "checked='checked'"; }  ?> /><label for="c2">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="c3" name="edit_gallery" <?php if($permission->edit_gallery==1){echo "checked='checked'"; }  ?> /><label for="c3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Student</h5></div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="b1" name="view_student" <?php if($permission->view_student==1){echo "checked='checked'"; }  ?> /><label for="b1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="b2" name="add_student" <?php if($permission->add_student==1){echo "checked='checked'"; }  ?> /><label for="b2">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="b3" name="edit_student" <?php if($permission->edit_student==1){echo "checked='checked'"; }  ?> /><label for="b3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Elibrary</h5></div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="d1" name="view_elibrary" <?php if($permission->view_elibrary==1){echo "checked='checked'"; }  ?> /><label for="d1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="d2" name="add_elibrary" <?php if($permission->add_elibrary==1){echo "checked='checked'"; }  ?> /><label for="d2">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="d3" name="edit_elibrary" <?php if($permission->edit_elibrary==1){echo "checked='checked'"; }  ?> /><label for="d3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Daily Routine</h5></div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="e1" name="view_daily_routine" <?php if($permission->view_daily_routine==1){echo "checked='checked'"; }  ?> /><label for="e1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="e2" name="add_daily_routine" <?php if($permission->add_daily_routine==1){echo "checked='checked'"; }  ?> /><label for="e2">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="e3" name="edit_daily_routine" <?php if($permission->edit_daily_routine==1){echo "checked='checked'"; }  ?> /><label for="e3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Teacher</h5></div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="f1" name="view_teacher" <?php if($permission->view_teacher==1){echo "checked='checked'"; }  ?> /><label for="f1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="f2" name="add_teacher" <?php if($permission->add_teacher==1){echo "checked='checked'"; }  ?> /><label for="f2">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="f3" name="edit_teacher" <?php if($permission->edit_teacher==1){echo "checked='checked'"; }  ?> /><label for="f3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Class</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="g1" name="view_class" <?php if($permission->view_class==1){echo "checked='checked'"; }  ?> /><label for="g1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="g2" name="add_class" <?php if($permission->add_class==1){echo "checked='checked'"; }  ?> /><label for="g2">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="g3" name="edit_class" <?php if($permission->edit_class==1){echo "checked='checked'"; }  ?> /><label for="g3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Subject</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="h1" name="view_subject" <?php if($permission->view_subject==1){echo "checked='checked'"; }  ?> /><label for="h1">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="h2" name="add_subject" <?php if($permission->add_subject==1){echo "checked='checked'"; }  ?> /><label for="h2">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="h3" name="edit_subject" <?php if($permission->edit_subject==1){echo "checked='checked'"; }  ?> /><label for="h3">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Exam</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_exam" name="view_exam" <?php if($permission->view_exam==1){echo "checked='checked'"; }  ?> /><label for="view_exam">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_exam" name="add_exam" <?php if($permission->add_exam==1){echo "checked='checked'"; }  ?> /><label for="add_exam">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="edit_exam" name="edit_exam" <?php if($permission->edit_exam==1){echo "checked='checked'"; }  ?> /><label for="edit_exam">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Mark</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_mark" name="view_mark" <?php if($permission->view_mark==1){echo "checked='checked'"; }  ?> /><label for="view_mark">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_mark" name="add_mark" <?php if($permission->add_mark==1){echo "checked='checked'"; }  ?> /><label for="add_mark">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="edit_mark" name="edit_mark" <?php if($permission->edit_mark==1){echo "checked='checked'"; }  ?> /><label for="edit_mark">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Lesson Plan</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_lesson" name="view_lesson" <?php if($permission->view_lesson==1){echo "checked='checked'"; }  ?> /><label for="view_lesson">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_lesson" name="add_lesson" <?php if($permission->add_lesson==1){echo "checked='checked'"; }  ?> /><label for="add_lesson">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="edit_lesson" name="edit_lesson" <?php if($permission->edit_lesson==1){echo "checked='checked'"; }  ?> /><label for="edit_lesson">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Fee Management</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="accountant" name="accountant" <?php if($permission->accountant==1){echo "checked='checked'"; }  ?> /><label for="accountant">Access</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Library</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="librarian" name="librarian" <?php if($permission->librarian==1){echo "checked='checked'"; }  ?> /><label for="librarian">Access</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Homework</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_homework" name="view_homework" <?php if($permission->view_homework==1){echo "checked='checked'"; }  ?> /><label for="view_homework">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_homework" name="add_homework" <?php if($permission->add_homework==1){echo "checked='checked'"; }  ?> /><label for="add_homework">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="edit_homework" name="edit_homework" <?php if($permission->edit_homework==1){echo "checked='checked'"; }  ?> /><label for="edit_homework">Review</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Message</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_message" name="view_message" <?php if($permission->view_message==1){echo "checked='checked'"; }  ?> /><label for="view_message">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_message" name="add_message" <?php if($permission->add_message==1){echo "checked='checked'"; }  ?> /><label for="add_message">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="edit_message" name="edit_message" <?php if($permission->edit_message==1){echo "checked='checked'"; }  ?> /><label for="edit_message">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Staff</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_staff" name="view_staff" <?php if($permission->view_staff==1){echo "checked='checked'"; }  ?> /><label for="view_staff">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_staff" name="add_staff" <?php if($permission->add_staff==1){echo "checked='checked'"; }  ?> /><label for="add_staff">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="edit_staff" name="edit_staff" <?php if($permission->edit_staff==1){echo "checked='checked'"; }  ?> /><label for="edit_staff">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Leave</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_leave" name="view_leave" <?php if($permission->view_leave==1){echo "checked='checked'"; }  ?> /><label for="view_leave">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_leave" name="add_leave" <?php if($permission->add_leave==1){echo "checked='checked'"; }  ?> /><label for="add_leave">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Transport</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="view_transport" name="view_transport" <?php if($permission->view_transport==1){echo "checked='checked'"; }  ?> /><label for="view_transport">View</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="add_transport" name="add_transport" <?php if($permission->add_transport==1){echo "checked='checked'"; }  ?> /><label for="add_transport">Add</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="edit_transport" name="edit_transport" <?php if($permission->edit_transport==1){echo "checked='checked'"; }  ?> /><label for="edit_transport">Edit</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>

                    <ul class="collapsible col s12 m6">
                      <li>
                        <div class="collapsible-header center"><h5>Print</div>
                        <div class="collapsible-body">
                          <div class="col s4">
                            <h5><input type="checkbox" id="generate" name="generate" <?php if($permission->generate==1){echo "checked='checked'"; }  ?> /><label for="generate">Generate</label></h5>
                          </div>
                          <div class="col s4">
                            <h5><input type="checkbox" id="export" name="export" <?php if($permission->export==1){echo "checked='checked'"; }  ?> /><label for="export">Export</label></h5>
                          </div>
                        </div>
                      </li>
                    </ul>
                    
                  </div>



                  <div class="row">
                      <div class="input-field col offset-m9">
                           <button id="formsubmit" class="btn waves-effect waves-light blue lighten-2" type="submit">Update
                              <i class="material-icons right">send</i>
                            </button>
                      </div>
                  </div>
                </form>
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
$(document).ready(function (e) 
{
  $("#update_permission_form").on('submit',(function(e) 
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
            $("#overlayloading").show();
            $("#formsubmit").hide();
          },
          success: function(data)
          { 
            //alert(data);
            if (data.trim() !== 'Permission succesfully updated'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else 
              if (data.trim() === 'Permission succesfully updated'.trim()) {

              window.location.href = window.location.href;
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
});

</script>
