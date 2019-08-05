<?php
//for nsk and admin
   include('session.php');
   require("../important/backstage.php");

   $backstage = new back_stage_class();

   if (isset($_GET["today"])){

        $newdate = $login_today_edate;

        $allowedit = 1;
    }

    if (isset($_GET["upd"])){
        if($_SERVER["REQUEST_METHOD"] == "POST") {
        $newdate = mysqli_real_escape_string($db,$_POST['updfield']);

        //convert nepali to english if nepali school and date
        if($login_date_type==2){    $newdate = nToE($newdate);    }

        $setclass = mysqli_real_escape_string($db,$_POST['upcfield']);
        $setsec = mysqli_real_escape_string($db,$_POST['upsfield']);
        }
    }

    if (isset($_GET["attendance_by_date"])){

        $newdate = mysqli_real_escape_string($db,$_GET['attendance_by_date']);

        //convert nepali to english if nepali school and date
        if($login_date_type==2){    $newdate = nToE($newdate);    }
        
    }


    if (isset($_GET["type"]) && $_GET["type"]=='teacher' ){

        $attendanceFor = 'teacher';

        $sqlalv1 = "SELECT `attendance_staff`.*, `teachers`.`tid` AS `staff_id`, `teachers`.`tname` AS `name` , `teachers`.`tmobile` AS `mobile` 
            FROM `attendance_staff` 
            LEFT JOIN `teachers` ON `attendance_staff`.`tid` = `teachers`.`tid` 
            WHERE `date`='$newdate' AND `staff` = 2   
            ORDER BY `teachers`.`tname` ASC";
        $resultalv1 = $db->query($sqlalv1);

        $resultalv2 = $db->query("SELECT * FROM `attendance_staff_check` 
                LEFT JOIN `teachers` ON `attendance_staff_check`.`teacher_id`=`teachers`.`tid` 
                LEFT JOIN `principal` ON `attendance_staff_check`.`teacher_id`=`principal`.`pid` 
                WHERE `date`='$newdate' AND `staff` = 2");
    
    }else if (isset($_GET["type"]) && $_GET["type"]=='staff' ){

        $attendanceFor = 'staff';

        $sqlalv1 = "SELECT `attendance_staff`.*, `staff_tbl`.`stid` AS `staff_id`, `staff_tbl`.`staff_name` AS `name` , `staff_tbl`.`staff_mobile` AS `mobile` 
            FROM `attendance_staff` 
            LEFT JOIN `staff_tbl` ON `attendance_staff`.`tid` = `staff_tbl`.`stid` 
            WHERE `attendance_staff`.`date`='$newdate' AND `attendance_staff`.`staff` = 5   
            ORDER BY `staff_tbl`.`staff_name` ASC";
        $resultalv1 = $db->query($sqlalv1);

        $resultalv2 = $db->query("SELECT * FROM `attendance_staff_check` 
                LEFT JOIN `teachers` ON `attendance_staff_check`.`teacher_id`=`teachers`.`tid` 
                LEFT JOIN `principal` ON `attendance_staff_check`.`teacher_id`=`principal`.`pid` 
                WHERE `attendance_staff_check`.`date`='$newdate' AND `attendance_staff_check`.`staff` = 5");
    }

    if($resultalv2->num_rows > 0)
    {   $found = "yes";
        $rowsABC = $resultalv2->fetch_assoc();
        extract($rowsABC);
    }else{ $found = "no"; }



?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Viewing Attendance</a></div>
                    </div>
                </div>
            </div>
            <?php if ($found == "no") { ?>
                <div class="row">
                    <div class="col s12 ">
                        <div class="card darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:red;"><?php echo "Attendance has not been taken for ".$attendanceFor."(s) on date ".(($login_date_type==2)? eToN($newdate) : $newdate); ?> </span></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }else{ ?>

            <div class="container"><br>

                <div class="row">
                    <div class="col s12 m12">
                        <div class="card-panel grey darken-3">
                            <span class="white-text flow-text">
                                Attendance details for <?php echo $attendanceFor; ?>(s) 
                                        <br/><?php if($teacher_role==2){ if (!empty($tname)) { echo "Taken by : ".$tname."&nbsp&nbsp&nbsp&nbsp";
                                        } }else if($teacher_role==1){ if (!empty($pname)) { echo "Taken by : ".$pname."&nbsp&nbsp&nbsp&nbsp";
                                        }} ?> Date  : <?php echo (($login_date_type==2)? eToN($newdate) : $newdate) ;
                                        $pcount =  $abpcount;
                                        $acount =  $abacount;
                                
                                ?>

                            </span>
                        </div>
                    </div>
                </div>
                <ul class="collapsible" data-collapsible="accordion">
                    <li>
                        <div class="collapsible-header">
                            <?php if($acount == 0) { ?>
                            <span class="badge"><?php echo $acount; ?></span>
                            <?php } else { ?>
                            <span class="new badge"><?php echo $acount; ?></span>
                            <?php } ?>
                            <i class="material-icons">filter_drama</i> Absent </div>
                        <div class="collapsible-body">
                            <p class="flow-text">
                                <?php
                                $absentNameList = '';
                                if ($resultalv1->num_rows > 0) {

                                    while($row = $resultalv1->fetch_assoc()) {
                                        if($row["status"] == 'A')
                                            $absentNameList .= $row["name"].", ";
                                    } 
                                } 
                                echo rtrim($absentNameList,", ");
                                ?>
                            </p>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><span class="badge"><?php echo $pcount; ?></span><i class="material-icons">place</i>Present</div>
                    </li>
                </ul>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card-panel grey darken-3">
                            <span class="white-text flow-text">
                                Detailed List Provided Below
                            </span>
                        </div>
                    </div>
                </div>

                <table class="centered bordered highlight z-depth-4">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Mobile</th>
                            <th>Status</th>
                            <?php  
                            if ($allowedit == 1){ 
                                if(($teacher_role == $login_cat && $teacher_id==$login_session1) || ($login_cat==1) ){  
                                    echo "<th>Change</th>"; 
                                }
                            } ?>

                        </tr>
                    </thead>
                    <tbody>
                        <?php mysqli_data_seek($resultalv1, 0);
                        if ($resultalv1->num_rows > 0) { 
                    // output data of each row
                    while($row = $resultalv1->fetch_assoc()) { ?>
                        <tr>
                            <td>
                                <?php echo $row["name"];?>
                            </td>
                            <td>
                                <?php echo $row["mobile"];?>
                            </td>
                            <td>
                                <?php 
                                if($row["status"] == 'P') { ?> 
                                    <i class="material-icons">done</i>
                                <?php } else if($row["status"] == 'A') { ?> 
                                    <i class="material-icons">clear</i>
                                <?php }else{ ?>
                                    <i class="material-icons">watch_later</i>
                                <?php } ?>
                            </td>
                            <?php
                                if ($allowedit == 1)
                                { if(($teacher_role == $login_cat && $teacher_id==$login_session1) || ($login_cat==1) ){
                                    ?>
                                <td>
                                    <a href="attendanceEditForStaff.php?edit_id=<?php echo $row["id"];?>&attendanceFor=<?php echo $attendanceFor; ?>&staff_id=<?php echo $row["staff_id"];?>&status=<?php echo $row["status"];?>"><i class="material-icons blue-text text-lighten-2">mode_edit</i></a>
                                </td>
                                    <?php  
                                    }
                                }
                            ?>
                        </tr>
                        <?php } //while end
                            }
                        ?>
                    </tbody>
                </table> <br>


            </div>
            <?php } ?>

        </main>
<?php include_once("../config/footer.php");?>