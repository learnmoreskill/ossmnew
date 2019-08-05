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

$sqlstudent = "SELECT COUNT(*) FROM `studentinfo` INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id` WHERE `syearhistory`.`year_id` = '$current_year_session_id' AND `studentinfo`.`status`<>1";
    $student1 = $db->query($sqlstudent);
    $student2=$student1->fetch_row();
    $student3=$student2[0];

$sqlstaff = "SELECT COUNT(*) FROM `staff_tbl` WHERE `staff_status`=0";
    $staff1 = $db->query($sqlstaff);
    $staff2=$staff1->fetch_row();
    $staff3=$staff2[0];



$staffrarray = $teacherarray = array();

$result2 = $db->query("SELECT `id`,`abpcount` AS `present`,`abacount` AS `absent`
        FROM `attendance_staff_check` 
        WHERE `staff`=2 AND `date` = '$login_today_edate' ");
$row2 = $result2->fetch_assoc();


 $teacherarray =array("id" => ($row2['id'])? $row2['id'] : 0,
                     "present" => ($row2['present'])? $row2['present'] : 0,
                     "absent" => ($row2['absent'])? $row2['absent'] : 0,
                     );
 

$result5 = $db->query("SELECT `id`,`abpcount` AS `present`,`abacount` AS `absent`
        FROM `attendance_staff_check` 
        WHERE `staff`=5 AND `date` = '$login_today_edate' ");
$row5 = $result5  ->fetch_assoc();

  $staffarray = array("id" => ($row5['id'])? $row5['id'] : 0,
                     "present" => ($row5['present'])? $row5['present'] : 0,
                     "absent" => ($row5['absent'])? $row5['absent'] : 0,
                     );

$result3 = $db->query("SELECT `abid` AS `id`, SUM( `abpcount`) AS `present`, SUM(`abacount`) AS `absent` FROM `abcheck` WHERE `abdate` ='$login_today_edate'");
$row3 = $result3  ->fetch_assoc();

$studentarray = array("id" => ($row3['id'])? $row3['id'] : 0,
                     "present" => ($row3['present'])? $row3['present'] : 0,
                     "absent" => ($row3['absent'])? $row3['absent'] : 0,
                     );

$result3gender = $db->query("SELECT COUNT(CASE WHEN  sex = 'male' THEN sid END) AS males,
  COUNT(CASE WHEN sex = 'female' THEN sid END) AS females,
  COUNT(CASE WHEN sex != 'male' && sex != 'female'  THEN sid END) AS others,
  COUNT(*) AS total FROM `studentinfo` WHERE `status` = 0");
$row3g = $result3gender  ->fetch_assoc();

$studentGenderArray = array("total" => ($row3g['total'])? $row3g['total'] : 0,
                     "males" => ($row3g['males'])? $row3g['males'] : 0,
                     "females" => ($row3g['females'])? $row3g['females'] : 0,
                     "others" => ($row3g['others'])? $row3g['others'] : 0,
                     );


?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <script type="text/javascript" src="../js/chart.2.7.2.js"> </script>


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
                        <p><?php echo $lang['total_admin']; ?></p>
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
                        <p><?php echo $lang['total_teacher']; ?></p>
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
                        <p><?php echo $lang['total_student']; ?></p>
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
                        <p><?php echo $lang['other_staff']; ?></p>
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


            <div class="row">
                <!-- <div class="col s12 m6">
                        <div class="col s12 m12">
                            <div class="card">
                                <div class="card-content white-text">
                                    <canvas id="myChart1"></canvas>
                                    <script>
                                    var ctx = document.getElementById('myChart1').getContext('2d');

                                                                       
                                    var teacherarray = <?php echo json_encode($teacherarray); ?>;
                                    var staffarray = <?php echo json_encode($staffarray); ?>;

                                   
                                    var color=["red","green","pink","blue","yellow","orange","black"];
                                    var color1=["blue","pink","orange","yellow","green","red","black"];

                                    var objectList=[];

                                    var label=['Present','Absent'];

                                    var loop =['present','absent'];


                                    for(var j=0;j<2;j++){

                                        var data = [0,0];

                                        data = [teacherarray[loop[j]],staffarray[loop[j]]];

                                        console.log("Data",data);

                                        var ob={
                                            data: data,
                                            label:label[j],
                                            // backgroundColor: 'rgb(255, 99, 132)',
                                            backgroundColor: color1[j],
                                            borderColor: color[j],
                                            borderWidth: 1
                                            
                                        }
                                        console.log("OB",ob);
                                        objectList.push(ob);
                                    }

                                    var myPieChart = new Chart(ctx,{
                                    type: 'bar',
                                        // The data for our dataset
                                        data: {
                                            labels: ["Teacher", "Staff"],
                                            datasets: objectList
                                        },

                                        // Configuration options go here
                                        options: {}
                                    });
                                    </script>
                                </div>
                        </div>
                    </div>
                </div> -->
                 <!-- Student Attendance Doughnet Grabh -->
                <div class="col s12 m4">
                    <div class="card">
                                <div class="card-content white-text cPadding">
                                    <canvas id="myChart1"></canvas>
                                    <script>
                                    var ctx = document.getElementById('myChart1').getContext('2d');

                                                                       
                                    var studentarray = <?php echo json_encode($studentarray); ?>;

                                    console.log('studentarray',studentarray);
                                   
                                    var color=["#36a2eb","#ff6384","pink","blue","yellow","orange","black"];

                                    var label=['Present','Absent'];

                                    data = {
                                      datasets: [{
                                          data: [studentarray['present'], studentarray['absent']],
                                          backgroundColor: [ color[0],color[1] ]
                                      }],

                                      // These labels appear in the legend and in the tooltips when hovering different arcs
                                      labels: label
                                    };

                                    var myDoughnutChart = new Chart(ctx, {
                                          type: 'doughnut',
                                          data: data,
                                           
                                          options: {
                                              title: {
                                                display: true,
                                                text: 'Student Attendance'
                                              }
                                          }
                                      });
                                    </script>
                                </div>
                    </div>
                </div>
                <!-- Teacher and staff Bar Grabh -->
                <div class="col s12 m4">
                    <div class="card">
                                <div class="card-content white-text cPadding" >
                                    <canvas id="myChart2"></canvas>
                                    <script>
                                    var ctx = document.getElementById('myChart2').getContext('2d');

                                                                       
                                    var teacherarray = <?php echo json_encode($teacherarray); ?>;
                                    var staffarray = <?php echo json_encode($staffarray); ?>;

                                   
                                    var color=["#36a2eb","#ff6384","orange","yellow","green","red","black"];

                                    var objectList=[];

                                    var label=['Present','Absent'];

                                    var loop =['present','absent'];


                                    for(var j=0;j<2;j++){

                                        var data = [0,0];

                                        data = [teacherarray[loop[j]],staffarray[loop[j]]];

                                        console.log("Data",data);

                                        var ob={
                                            data: data,
                                            label:label[j],
                                            // backgroundColor: 'rgb(255, 99, 132)',
                                            backgroundColor: color[j]
                                            
                                        }
                                        console.log("OB",ob);
                                        objectList.push(ob);
                                    }

                                    var myPieChart = new Chart(ctx,{
                                    type: 'bar',
                                        // The data for our dataset
                                        data: {
                                            labels: ["Teacher", "Staff"],
                                            datasets: objectList
                                        },

                                        // Configuration options go here
                                        options: {
                                            title: {
                                                  display: true,
                                                  text: 'Teacher And Staff Attendance'
                                            }
                                              
                                        }
                                    });
                                    </script>
                                </div>
                    </div>
                </div>

                <!-- Student Male Female Grabh -->
                <div class="col s12 m4">
                    <div class="card">
                                <div class="card-content white-text cPadding">
                                    <canvas id="myChart3"></canvas>
                                    <script>
                                    var ctx = document.getElementById('myChart3').getContext('2d');

                                                                       
                                    var studentGenderArray = <?php echo json_encode($studentGenderArray); ?>;

                                    console.log('studentGenderArray',studentGenderArray);

                                    var color=["green","purple","orange","blue","yellow","pink","black"];

                                    var label=['Male','Female','Others'];

                                    data = {
                                      datasets: [{
                                          data: [studentGenderArray['males'], studentGenderArray['females'],studentGenderArray['others']],
                                          backgroundColor: [ color[0],color[1],color[2] ]
                                      }],

                                      // These labels appear in the legend and in the tooltips when hovering different arcs
                                      labels: label
                                    };

                                    var myPieChart = new Chart(ctx, {
                                          type: 'pie',
                                          data: data,
                                           
                                          options: {
                                              title: {
                                                display: true,
                                                text: 'Student Statistics'
                                              }
                                          }
                                      });
                                    </script>
                                </div>
                    </div>
                </div>
               
            </div>

            <!-- <div class="row">
              <h2>hello</h2>
            </div> -->







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

