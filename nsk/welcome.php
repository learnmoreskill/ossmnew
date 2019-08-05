<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'welcome';

include("../important/backstage.php");
$backstage = new back_stage_class();

$year_id = $current_year_session_id;

$sectionClass = json_decode($backstage->get_class_section_by_teacher_id_year_id($login_session1,$year_id));

$sqltr1 = "SELECT * FROM `troutine` WHERE `trtid`='$login_session1' AND `year_id` = '$year_id' ";
$resulttr1 = $db->query($sqltr1);
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Dashboard</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-panel grey darken-3">
                            <div class="row">
                            <div class="col s12 m6">

                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Dashboard</span>
                                <div class="card-content white-text flow-text">
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $login_session2; ?>
                                </div>
                                <br>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="School" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">domain</i>&nbsp;<?php echo $login_session_a; ?></div><br>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email ID" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $login_session3; ?>
                                        </div><br>
                                <?php if (count((array)$sectionClass)) { ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Class teacher of:" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assessment</i>&nbsp;
                                    <?php foreach ($sectionClass as $classTecher) {
                                      echo $classTecher->class_name.'-'.$classTecher->section_name."&nbsp&nbsp&nbsp&nbsp";
                                    } ?></div><br><?php } ?>


                                        </div>

                                    </div>
                                <div class="col s12 m4 offset-m2">
                                <div class="card-content white-text flow-text">
                                    <div class="card grey darken-2 roundedImage">
                                        <div class="card-image profile-pic ">
                                            <img class="circle responsive-img" src="<?php if(!empty($login_session12)){ echo "../uploads/".$fianlsubdomain."/profile_pic/".$login_session12; }elseif(strtolower($login_session13)=='male'){ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } elseif(strtolower($login_session13)=='female'){ echo "https://learnmoreskill.github.io/important/dummyprofilefemale.jpg"; }else{ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } ?>" alt="image not avilable"   >
                                            
                                            </div>

                                            

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<div class="row">
    <div class="col s12 m12">

    <?php if ($resulttr1->num_rows > 0) {
    // output data of each row
    while($row = $resulttr1->fetch_assoc()) { ?>
<table class="responsive-table centered striped bordered highlight z-depth-4">
    <thead>
<tr>
    <th>.</th>
    <th>1st Period</th>
    <th>2nd Period</th>
    <th>3rd Period</th>
    <th>4th Period</th>
    <th>5th Period</th>
    <th>6th Period</th>
    <th>7th Period</th>
    <th>8th Period</th>
</tr></thead>
<tbody><tr>
    <th>Sunday</th>
    <td><?php echo $row["sun1"]; ?></td>
    <td><?php echo $row["sun2"]; ?></td>
    <td><?php echo $row["sun3"]; ?></td>
    <td><?php echo $row["sun4"]; ?></td>
    <td><?php echo $row["sun5"]; ?></td>
    <td><?php echo $row["sun6"]; ?></td>
    <td><?php echo $row["sun7"]; ?></td>
    <td><?php echo $row["sun8"]; ?></td>
</tr>
<tr>
    <th>Monday</th>
    <td><?php echo $row["mon1"]; ?></td>
    <td><?php echo $row["mon2"]; ?></td>
    <td><?php echo $row["mon3"]; ?></td>
    <td><?php echo $row["mon4"]; ?></td>
    <td><?php echo $row["mon5"]; ?></td>
    <td><?php echo $row["mon6"]; ?></td>
    <td><?php echo $row["mon7"]; ?></td>
    <td><?php echo $row["mon8"]; ?></td>
</tr>
    <tr>
        <th>Tuesday</th>
        <td><?php echo $row["tue1"]; ?></td>
        <td><?php echo $row["tue2"]; ?></td>
        <td><?php echo $row["tue3"]; ?></td>
        <td><?php echo $row["tue4"]; ?></td>
        <td><?php echo $row["tue5"]; ?></td>
        <td><?php echo $row["tue6"]; ?></td>
        <td><?php echo $row["tue7"]; ?></td>
        <td><?php echo $row["tue8"]; ?></td>
    </tr>
    <tr>
        <th>Wednesday</th>
        <td><?php echo $row["wed1"]; ?></td>
        <td><?php echo $row["wed2"]; ?></td>
        <td><?php echo $row["wed3"]; ?></td>
        <td><?php echo $row["wed4"]; ?></td>
        <td><?php echo $row["wed5"]; ?></td>
        <td><?php echo $row["wed6"]; ?></td>
        <td><?php echo $row["wed7"]; ?></td>
        <td><?php echo $row["wed8"]; ?></td>
    </tr>
    <tr>
        <th>Thursday</th>
        <td><?php echo $row["thu1"]; ?></td>
        <td><?php echo $row["thu2"]; ?></td>
        <td><?php echo $row["thu3"]; ?></td>
        <td><?php echo $row["thu4"]; ?></td>
        <td><?php echo $row["thu5"]; ?></td>
        <td><?php echo $row["thu6"]; ?></td>
        <td><?php echo $row["thu7"]; ?></td>
        <td><?php echo $row["thu8"]; ?></td>
    </tr>
    <tr>
        <th>Friday</th>
        <td><?php echo $row["fri1"]; ?></td>
        <td><?php echo $row["fri2"]; ?></td>
        <td><?php echo $row["fri3"]; ?></td>
        <td><?php echo $row["fri4"]; ?></td>
        <td><?php echo $row["fri5"]; ?></td>
        <td><?php echo $row["fri6"]; ?></td>
        <td><?php echo $row["fri7"]; ?></td>
        <td><?php echo $row["fri8"]; ?></td>
    </tr>
                               </tbody> </table>
        <?php }
}
        ?>
                                </div></div>
        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>