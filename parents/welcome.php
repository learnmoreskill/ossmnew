<?php
include('session.php');
include("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'welcome';



$students = json_decode($backstage->get_student_details_by_parent_id($login_session1));

$resultbroadcast = $db->query("SELECT `brdid`, `brdpname`, `brdtext`, `pushed_at` 
        FROM `princibroadcast` 
        ORDER BY `pushed_at` DESC LIMIT 4");

$resultcomplaint = $db->query("SELECT `cid`, `ctid`,`csid`, `studentinfo`.`sname`, `cmsg`, `cdate`, `cclock` 
        FROM `parents` 
        LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
        INNER JOIN `complaint` ON `studentinfo`.`sid` = `complaint`.`csid` 
        WHERE `parents`.`parent_id`='$login_session1' 
        ORDER BY `complaint`.`cclock` DESC LIMIT 4");

$resulthomework = $db->query("SELECT `hid`, `htid`,`hsubject`,`htopic`,`hclass`,`hsec`,`studentinfo`.`sname`, `hdate`, `hclock` FROM `parents` 
        LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
        INNER JOIN `homework` ON `studentinfo`.`sclass` = `homework`.`hclass` AND `studentinfo`.`ssec` = `homework`.`hsec` 
        WHERE `parents`.`parent_id`='$login_session1' 
        ORDER BY `homework`.`hclock` DESC LIMIT 2");

$resultexam = $db->query("SELECT `examtable_id`, `class_name`, `exam_type`, `subject`, `date`, `time`, `exam_created_on`,`studentinfo`.`sname` ,`examtype`.`examtype_name`
        FROM `parents` 
        LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
        INNER JOIN `examtable` ON `studentinfo`.`sclass` = `examtable`.`class_name` 
        INNER JOIN `examtype` ON `examtable`.`exam_type` = `examtype`.`examtype_id` 
        WHERE `parents`.`parent_id`='$login_session1' 
        GROUP BY `examtable`.`exam_type`, `examtable`.`class_name` 
        ORDER BY `examtable`.`date` DESC LIMIT 4 ");

$response = array();
$result = $db->query("SELECT `sid`,`sname`, COUNT(asid) as total, COUNT(if(`astatus`='P',1,NULL)) as present,  MONTH(`aclock`) as month 
        FROM `parents` 
        LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
        INNER JOIN `attendance` ON `studentinfo`.`sid` = `attendance`.`asid` 
        WHERE `parents`.`parent_id`='$login_session1' AND YEAR(`aclock`)=2018 
        GROUP BY MONTH(`aclock`), `sid`");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

                    array_push($response,array(
                    "sid" => $row['sid'],
                    "sname" => $row['sname'],
                    "total" => $row['total'],
                    "present" => $row['present'],
                    "month" => $row['month'],
                    ));
    } }

$responseexam = array();
$result = $db->query("SELECT `sid`,`sname`,`marksheet`.`mexam_id`,  SUM(`marksheet`.`m_obtained_mark`) AS `obtained` 
        FROM `parents` 
        LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
        INNER JOIN `marksheet` ON `studentinfo`.`sid` = `marksheet`.`mstudent_id` AND `studentinfo`.`sclass` = `marksheet`.`marksheet_class`  
        WHERE `parents`.`parent_id`='$login_session1' 
        GROUP BY `marksheet`.`mexam_id`, `marksheet`.`mstudent_id` 
        ORDER BY `marksheet`.`mexam_id`");
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {

                    array_push($responseexam,array(
                    "sid" => $row['sid'],
                    "sname" => $row['sname'],
                    "mexam_id" => $row['mexam_id'],
                    "obtained" => $row['obtained'],
                    ));
    } }


?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <script type="text/javascript" src="../js/chart.2.7.2.js"> </script>

    <style type="text/css">
        .makelist{
            border-bottom: 1px solid rgba(160,160,160,0.2);
            padding-bottom: 4px;
        }
    </style>


        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center">
                             <script>
                                var welcome;
                                var date = new Date();
                                var hour = date.getHours();
                                if (hour < 12) {
                                    welcome = "Good morning !";
                                }
                                else if (hour < 17) {
                                    welcome = "Good afternoon !";
                                }
                                else {
                                    welcome = "Good evening !";
                                }
                                document.write("<p class='white-text text-lighten-4'>" + "<font color='white'>" + welcome + "</font>" + "<span style='padding-left:3px;'>Mr. <?php echo $login_session2; ?></span>");
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col s12 m6"> 
                    <div class="card">
                        <div class="col s12 m12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                  <span class="card-title"> <i class="small material-icons">event</i> Events / Circular Notices</span><br>

                                  <?php  if ($resultbroadcast->num_rows > 0) {
                                        while($row = $resultbroadcast->fetch_assoc()) { ?>

                                    <p class="makelist">&#10147; <?php echo $row["brdtext"]; ?></p>

                                  <?php } } else{ ?>

                                    <p class="makelist">&#10147; No any notices found !</p>

                                <?php } ?>

                                </div>
                                <!-- <div class="card-action">
                                  <a href="#">Read More</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card">
                        <div class="col s12 m12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                  <span class="card-title"> <i class="small material-icons">forum</i>Complaints</span><br>

                                  <?php  if ($resultcomplaint->num_rows > 0) {
                                        while($row1 = $resultcomplaint->fetch_assoc()) { ?>

                                    <p class="makelist">&#10147; <?php echo $row1["cmsg"].'('.$row1["sname"].')'; ?></p>

                                  <?php } } else{ ?>

                                    <p class="makelist">&#10147; No any complaints found !</p>

                                <?php } ?>

                                </div>
                                <!-- <div class="card-action">
                                  <a href="#">Read More</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m6">
                    <div class="card">
                        <div class="col s12 m12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                  <span class="card-title"> <i class="small material-icons">content_copy</i>Homeworks / Assignments</span><br>

                                  <?php  if ($resulthomework->num_rows > 0) { ?>

                                    <table class="centered responsive-table">
                                    <thead>
                                      <tr>
                                          <th>Student</th>
                                          <th>Date</th>
                                          <!-- <th>Action</th> -->
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr>

                                     <?php   while($row2 = $resulthomework->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $row2["sname"]; ?></td>
                                        <td><?php echo (($login_date_type==2)? eToN($row2["hdate"]) : $row2["hdate"]); ?></td>
                                       <!--  <td><a class="btn-floating pulse waves-effect waves-light tooltipped" data-position="right" data-delay="50" data-tooltip="View"><i class="material-icons">visibility</i></a></td> -->
                                    </tr>


                                  <?php } ?>
                                    </tbody>
                                  </table>
                                   <?php } else{ ?>

                                    <p class="makelist">&#10147; No any homeworks found !</p>

                                <?php } ?>


                                  
                                        
                                     
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                    <div class="card">
                        <div class="col s12 m12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                  <span class="card-title"> <i class="small material-icons">blur_on</i>Upcoming Exams</span><br>

                                  <?php  if ($resultexam->num_rows > 0) {
                                        while($row3 = $resultexam->fetch_assoc()) { ?>

                                    <p class="makelist">&#10147; <?php echo (($login_date_type==2)? eToN($row3["date"]) : $row3["date"]).'&nbsp&nbsp&nbsp&nbsp'.$row3["examtype_name"].'('.$row3["sname"].')'; ?></p>

                                  <?php } } else{ ?>

                                    <p class="makelist">&#10147; No any exams found !</p>

                                <?php } ?>

                                </div>
                                <!-- <div class="card-action">
                                  <a href="#">Read more</a>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div> 

            <div class="row">
                <div class="col s12 m6">
                        <div class="col s12 m12">
                            <div class="card">
                                <div class="card-content white-text">
                                    <canvas id="myChart"></canvas>
                                    <script>
                                    var ctx = document.getElementById('myChart').getContext('2d');

                                    var attendancelist = <?php echo json_encode($response); ?>;
                                    
                                    console.log("attendance",attendancelist);

                                    var i = 0, val, index,
                                        values = [], result = [];
                                    for (; i < attendancelist.length; i++) {
                                        val = attendancelist[i]["sid"];
                                        index = values.indexOf(val);
                                        if (index > -1)
                                            result[index].push(attendancelist[i]);
                                        else {
                                            values.push(val);
                                            result.push([attendancelist[i]]);
                                        }
                                    }
                                    console.log("GroupedElement",result);
                                    var color=["red","green","pink","blue","yellow","orange","black"];
                                    
                                    var objectList=[];

                                    for(var j=0;j<result.length;j++){
                                        var data = [0,0,0,0,0,0,0,0,0,0,0,0];

                                        for(var i=0;i<result[j].length;i++){

                                            data[result[j][i].month-1]=result[j][i].present;                                       
                                        }
                                        var ob={
                                            label: result[j][0].sname,
                                            // backgroundColor: 'rgb(255, 99, 132)',
                                            borderColor: color[j],
                                            data: data,
                                        }
                                        objectList.push(ob);
                                    }

                                        var datetype = '<?php echo $login_date_type; ?>';
                                        
                                        if (datetype==2) {
                                           var myLineChart = new Chart(ctx, {
                                            // The type of chart we want to create
                                            type: 'line',

                                            // The data for our dataset
                                            data: {
                                                labels: ["Baishakh", "Jestha", "Asar", "Shrawan", "Bhadau", "Aswin", "Kartik", "Mansir", "Poush", "Magh", "Falgun", "Chaitra"],
                                                datasets: objectList
                                            },
                                            // Configuration options go here
                                            options: {}
                                        });   
                                       }else{

                                        var myLineChart = new Chart(ctx, {
                                            // The type of chart we want to create
                                            type: 'line',

                                            // The data for our dataset
                                            data: {
                                                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                                                datasets: objectList
                                            },
                                            // Configuration options go here
                                            options: {}
                                        }); 
                                        }                                   
                                    </script>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m6">
                        <div class="col s12 m12">
                            <div class="card">
                                <div class="card-content white-text">
                                    <canvas id="myChart1"></canvas>
                                    <script>
                                    var ctx = document.getElementById('myChart1').getContext('2d');

                                    var examlist = <?php echo json_encode($responseexam); ?>;
                                    
                                    console.log("examlist",examlist);

                                    var i = 0, val, index,
                                        values = [], result = [];
                                    for (; i < examlist.length; i++) {
                                        val = examlist[i]["sid"];
                                        index = values.indexOf(val);
                                        if (index > -1)
                                            result[index].push(examlist[i]);
                                        else {
                                            values.push(val);
                                            result.push([examlist[i]]);
                                        }
                                    }

                                    console.log("GroupedElement",result);
                                    var color=["red","green","pink","blue","yellow","orange","black"];
                                    var color1=["orange","yellow","blue","pink","green","red","black"];

                                    var objectList=[];

                                    for(var j=0;j<result.length;j++){
                                        var data = [0,0,0];

                                        for(var i=0;i<result[j].length;i++){

                                            data[result[j][i].mexam_id-1]=result[j][i].obtained;                                       
                                        }
                                        var ob={
                                            data: data,
                                            label: result[j][0].sname,
                                            // backgroundColor: 'rgb(255, 99, 132)',
                                            backgroundColor: color1[j],
                                            borderColor: color[j],
                                            borderWidth: 1
                                            
                                        }
                                        objectList.push(ob);
                                    }

                                    var myPieChart = new Chart(ctx,{
                                    type: 'bar',
                                        // The data for our dataset
                                        data: {
                                            labels: ["First Terminal", "Second Terminal", "Third Terminal"],
                                            datasets: objectList
                                        },

                                        // Configuration options go here
                                        options: {}
                                    });
                                    </script>
                                </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>