<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'welcome';

$sqladmin = "SELECT COUNT(*) FROM `principal` WHERE `status`=0";
    $admin1 = $db->query($sqladmin);
    $admin2=$admin1->fetch_row();
    $admin3=$admin2[0];

$sqlteacher = "SELECT COUNT(*) FROM `teachers` WHERE `status`=0";
    $teacher1 = $db->query($sqlteacher);
    $teacher2=$teacher1->fetch_row();
    $teacher3=$teacher2[0];

$sqlstudent = "SELECT COUNT(*) FROM `studentinfo` WHERE `status`=0";
    $student1 = $db->query($sqlstudent);
    $student2=$student1->fetch_row();
    $student3=$student2[0];

$sqlstaff = "SELECT COUNT(*) FROM `staff_tbl` WHERE `staff_status`=0";
    $staff1 = $db->query($sqlstaff);
    $staff2=$staff1->fetch_row();
    $staff3=$staff2[0];



?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>


<!-- <script>
   $(document).ready(function () {
       $('.slider').slider({full_width: true,height:500,});
   });
</script> -->

<!-- MODEL FOR ANNIVERSARY -->
<!-- <?php if ($login_session_b == "PHS" && empty($_SESSION['onetime']) ) { ?>
<script type="text/javascript">
        function openModel() {
            $('#modal1').modal('open');
        }
        window.onload = openModel;
</script>
<?php } ?> -->


        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#"><?php echo $lang['dashboard']; ?></a></div>
                    </div>
                </div>
            </div>

            <div id="card-stats">
              <div class="row">
                <div class="col s12 m6 l3">
                  <div class="card gradient-45deg-light-blue-cyan gradient-shadow min-height-100 white-text">
                    <div class="padding-1 pl-5">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-2">school</i>
                        <p>Total Admin</p>
                      </div>
                      <div class="col s5 m5 right-align pt-6 pr-7">
                        <h5 class="mb-0"><?php echo $admin3; ?></h5>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col s12 m6 l3">
                  <a href="<?php echo (($login_cat == 1)? 'allteacher.php' : '#' ); ?>">
                  <div class="card gradient-45deg-red-pink gradient-shadow min-height-100 white-text">
                    <div class="padding-1 pl-5">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-2">perm_identity</i>
                        <p>Total teacher</p>
                      </div>
                      <div class="col s5 m5 right-align pt-6 pr-7">
                        <h5 class="mb-0"><?php echo $teacher3; ?></h5>
                      </div>
                    </div>
                  </div>
                </a>
                </div>
                <div class="col s12 m6 l3">
                  <a href="<?php echo (($login_cat == 1)? 'allstudent.php' : '#' ); ?>">
                  <div class="card gradient-45deg-amber-amber gradient-shadow min-height-100 white-text">
                    <div class="padding-1 pl-5">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-2">perm_identity</i>
                        <p>Total Student</p>
                      </div>
                      <div class="col s5 m5 right-align pt-6 pr-7">
                        <h5 class="mb-0"><?php echo $student3; ?></h5>
                      </div>
                    </div>
                  </div>
                  </a>
                </div>
                <div class="col s12 m6 l3">
                  <a href="<?php echo (($login_cat == 1)? 'staff.php' : '#' ); ?>">
                  <div class="card gradient-45deg-green-teal gradient-shadow min-height-100 white-text">
                    <div class="padding-1 pl-5">
                      <div class="col s7 m7">
                        <i class="material-icons background-round mt-2">people</i>
                        <p>Other Staff</p>
                      </div>
                      <div class="col s5 m5 right-align pt-6 pr-7">
                        <h5 class="mb-0"><?php echo $staff3; ?></h5>
                      </div>
                    </div>
                  </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="row">
                <div class="col s12 m6 l8">
                 <div class="slider">
                    <ul class="slides">
                    <?php
                    $resultslide = $db->query("SELECT * FROM `slider`"); 
                    if ($resultslide->num_rows > 0) {
                      $slidestyle = array('center-align','left-align','right-align');
                    while($rowslides = $resultslide->fetch_assoc()) {
                    ?> 
                      <li>
                        <img src="../uploads/<?php echo $fianlsubdomain; ?>/slides/<?php echo $rowslides["slider_image"]; ?>"> <!-- random image -->
                        <div class="caption <?php echo $slidestyle[array_rand($slidestyle)]; ?>">
                          <h3><?php echo $rowslides["slider_title"]; ?></h3>
                          <h5 class="light grey-text text-lighten-3"><?php echo $rowslides["slider_desc"]; ?></h5>
                        </div>
                      </li>

                      <?php }}?>
                    </ul>
                  </div>
                </div>
                <div class="col s12 m6 l4">
                 <!-- <ins style="width:380px;height:495px;" class="nepalipatro-wg" widget="month"/>
                 <p align="center">loading Calendar</p>
                 <script async src="//nepalipatro.com.np/widget/js"></script> -->

                 <!-- Start of nepali calendar widget -->
                  <script type="text/javascript"> 
                  var nc_width = 'responsive';
                  var nc_height = 400;
                  var nc_api_id = 45520180329437;
                  </script>
                  <script type="text/javascript" src="https://www.ashesh.com.np/calendarlink/nc.js"></script>
                  <!-- End of nepali calendar widget -->
                    
                </div>
            </div>

<!-- MODEL for Aniversary -->
<!-- <?php if ($login_session_b == "PHS" && empty($_SESSION['onetime'])) { ?>
  <div id="modal1" class="modal">
    <div class="modal-content">
      <div>
        <img src="../images/public anniversery copy.png" style="max-width:100%">
      </div>
    </div>
  </div>

<?php } ?> -->


        </main>

<?php include_once("../config/footer.php");?>


<!-- MODEL for Aniversary -->
<!-- <?php $_SESSION['onetime']="one"; ?> -->

