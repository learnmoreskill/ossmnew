<?php
//for nsk and admin
   include('session.php');
   require("../important/backstage.php");

   $backstage = new back_stage_class();

   if (isset($_GET["today"])){

        $newdate = $login_today_edate;

        $setclass = $_GET['class_id'];
        $setsec = $_GET['section_id'];
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

    if (isset($_GET["extraudp"])) { 
        
        if (isset($_GET["extradate"])) {
            $newdate = addslashes($_GET["extradate"]);

            //convert nepali to english if nepali school and date
            if($login_date_type==2){    $newdate = nToE($newdate);    }

        } 
        if (isset($_GET["extraclass"])) {
            $setclass = addslashes($_GET["extraclass"]);
        }
        if (isset($_GET["extrasec"])) {
            $setsec = addslashes($_GET["extrasec"]);
        }
    }

    if (isset($_GET["atbyclass"])) { 
        
        if (isset($_GET["extradate"])) {
            $newdate = addslashes($_GET["extradate"]);

            //convert nepali to english if nepali school and date
            if($login_date_type==2){    $newdate = nToE($newdate);    }

        } 
        if (isset($_GET["extraclass"])) {
            $setclass = addslashes($_GET["extraclass"]);
        }
        if (isset($_GET["extrasec"])) {
            $setsec = addslashes($_GET["extrasec"]);
        }
    }

    $sqlalv1 = "SELECT * 
        FROM `attendance` 
        LEFT JOIN `studentinfo` ON `attendance`.`asid` = `studentinfo`.`sid` 
        WHERE `aclass`='$setclass' 
            AND `asec`='$setsec' 
            AND `aclock`='$newdate'  
        ORDER BY `studentinfo`.`sroll` ASC";
    $resultalv1 = $db->query($sqlalv1);

    $resultalv2 = $db->query("SELECT * FROM `abcheck` 
            LEFT JOIN `teachers` ON `abcheck`.`teacher_id`=`teachers`.`tid` 
            LEFT JOIN `principal` ON `abcheck`.`teacher_id`=`principal`.`pid` 
            WHERE `abclass`='$setclass' 
                AND `absec`='$setsec' 
                AND `abdate`='$newdate'");

    if($resultalv2->num_rows > 0)
    {   $found = "yes";
        $rowsABC = $resultalv2->fetch_assoc();
        extract($rowsABC);
    }else{ $found = "no"; }

    $csname= json_decode($backstage->get_class_section_name_by_id($setclass,$setsec));


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
                                <span class="card-title"><span style="color:red;"><?php echo "Attendance has not been taken for class ".$csname->class_name.":".$csname->section_name." on date ".(($login_date_type==2)? eToN($newdate) : $newdate); ?> </span></span>
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
                                <?php
                                        ?> Attendance details for <?php echo $csname->class_name." ".$csname->section_name;
                                        ?><br/><?php if($teacher_role==2){ if (!empty($tname)) { echo "Taken by : ".$tname."&nbsp&nbsp&nbsp&nbsp";
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
                                        if($row["astatus"] == 'A')
                                            $absentNameList .= $row["sname"].", ";
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
                            <th>Roll No.</th>
                            <th>Name</th>
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
                                <?php echo $row["sroll"];?>
                            </td>
                            <td>
                                <?php echo $row["sname"];?>
                            </td>
                            <td>
                                <?php 
                                if($row["astatus"] == 'P') { ?> <i class="material-icons">done</i>
                                <?php } else { ?> <i class="material-icons">clear</i>
                                <?php }
                                ?>
                            </td>
                            <?php
                                if ($allowedit == 1)
                                { if(($teacher_role == $login_cat && $teacher_id==$login_session1) || ($login_cat==1) ){
                                    ?>
                                <td>
                                    <a href="attendanceedit.php?aaid=<?php echo $row["aid"];?>&asid=<?php echo $row["asid"];?>&aastatus=<?php echo $row["astatus"];?>&class_id=<?php echo $setclass;?>&section_id=<?php echo $setsec;?>"><i class="material-icons blue-text text-lighten-2">mode_edit</i></a>
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