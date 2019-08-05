<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'children';

include("../important/backstage.php");
$backstage = new back_stage_class();

$students = json_decode($backstage->get_student_details_by_parent_id($login_session1));

?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="row">
                    <div class="col s12">
                        <ul class="tabs github-commit">
                        <?php foreach ($students as $per_student) { ?>
                            <li class='tab col s3'><a class="white-text text-lighten-4" href='#<?php echo $per_student->sid; ?>'><?php echo $per_student->sname; ?></a></li>
                                <?php 
                                }
                                ?>
                        </ul>
                    </div>
                </div>
            </div>
                    <?php foreach ($students as $per_student) { ?>
                    <div id="<?php echo $per_student->sid; ?>">
                        <div class="row">
                            <div class="col s12">
                                <div class="card">
                                    <div class="card-panel purple darken-3">
                                        <div class="row">
                                            <div class="col s12 m6">
                                                <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;"><?php echo $per_student->sname; ?></span>

                                                <div class="card-content white-text flow-text">

                                                    <?php if(!empty($per_student->sadmsnno)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Admission number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assignment</i>&nbsp;<?php echo $per_student->sadmsnno; ?></div>
                                                        <br><?php } ?>

                                                    <?php if(!empty($per_student->class_name)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Class" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assessment</i>&nbsp; 
                                                        <?php echo $per_student->class_name."-".$per_student->section_name;?>
                                                    </div><br><?php } ?>

                                                    <?php if(!empty($per_student->sroll)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Roll No." style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">list</i>&nbsp;<?php echo $per_student->sroll; ?></div>
                                                    <br><?php } ?>

                                                    <?php if(!empty($per_student->sex)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Gender" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">wc</i>&nbsp;<?php echo ucfirst($per_student->sex); ?></div>
                                                        <br> <?php } ?>

                                                    <?php if(!empty($per_student->dob)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date Of Birth" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">sentiment_dissatisfied</i>&nbsp;<?php echo (($login_date_type==2)? eToN($per_student->dob) : $per_student->dob); ?></div>    <br> <?php } ?>

                                                    <?php if(!empty($per_student->saddress)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Address" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">home</i>&nbsp;<?php echo $per_student->saddress; ?></div>
                                                    <br>    <?php } ?>

                                                    <?php if(!empty($per_student->semail)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $per_student->semail; ?></div>
                                                    <br>    <?php } ?>

                                                    <?php if(!empty($per_student->smobile)){ ?>
                                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Phone Number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">tablet_android</i>&nbsp;<?php echo $per_student->smobile; ?></div>
                                                        <br>    <?php } ?>

                                                </div>
                                            </div>
                                            <div class="col s12 m4 offset-m2">
                                                <div class="card-content white-text flow-text">
                                                    <div class="card grey darken-2 roundedImage">
                                                        <div class="card-image profile-pic ">
                                                            <img class="circle responsive-img" src="<?php if(!empty($per_student->simage)){ echo "../uploads/".$fianlsubdomain."/profile_pic/".$per_student->simage; }elseif(strtolower($per_student->sex)=='male'){ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } elseif(strtolower($per_student->sex)=='female'){ echo "https://learnmoreskill.github.io/important/dummyprofilefemale.jpg"; }else{ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } ?>" alt="image not avilable"   >
                                                        </div>
                                                    </div>

                                                    <!-- <div style="text-align:center;">    
                                                        <a class="waves-effect waves-light btn" style="font-size:14px;"><i class="material-icons left">visibility</i>Progress</a>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    

                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-panel purple darken-3">
                                    <div class="row">
                                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Attendance Info</span>
                                            <div class="card-content white-text flow-text">
                                                <div class="row">
                                                    <div class="col s12 m12">
                                                        <?php 

                                                    $attendanceList= json_decode($backstage->get_attendance_absent_list_by_student_id_with_limit($per_student->sid));
                                                       
                                                    if (count((array)$attendanceList)) {  ?>
                                                             <div style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><?php echo $per_student->sname." "; ?> was absent on the following dates :</div>
                                                            <br/>
                                                            <?php foreach ($attendanceList as $attdnlist) { ?>

                                                            &emsp; <span class=""><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">date_range</i>&nbsp;<?php echo (($login_date_type==2)? eToN($attdnlist->aclock) : $attdnlist->aclock); ?></div></span>
                                                            <br/>
                                                            <?php   }  
                                                        } else {
                                                            echo "Regular Student";
                                                        }
                                                    ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="card-action">
                                                <a href="leavehistory.php">More info..</a>
                                            </div>        --> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-panel purple darken-3">
                                    <div class="row">
                                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Leave Info</span>
                                            <div class="card-content white-text flow-text">
                                                <div class="row">
                                                    <div class="col s12 m12">
                                                        <?php 
                                                        $leaveList= json_decode($backstage->get_leave_list_by_student_id_with_limit($per_student->sid));
                                                       
                                                        if (count((array)$leaveList)) { ?>

                                                                <?php foreach ($leaveList as $lvlist) { ?>

                                                                &emsp; <span class=""><?php echo (($login_date_type==2)? eToN($lvlist->lvsdate) : $lvlist->lvsdate)." to ".(($login_date_type==2)? eToN($lvlist->lvedate) : $lvlist->lvedate)."&nbsp&nbsp--".$lvlist->lvreason."--&nbsp&nbsp"; ?>
                                                                Status:<?php if($lvlist->lvstatus=='100'){ echo 'Leave Approved'; } else if($lvlist->lvstatus=='50'){ echo 'Pending'; } else if($lvlist->lvstatus=='0'){ echo 'Leave Rejected'; } ?>
                                                                </span> &emsp;
                                                                    <br/>
                                                                    <?php  }   
                                                                } else {
                                                                    echo "No previous leave found.";
                                                                }
                                                            ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-action">
                                                <a href="leavehistory.php">More info..</a>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-panel purple darken-3">
                                    <div class="row">
                                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Complaint Info</span>
                                            <div class="card-content white-text flow-text">
                                                <div class="row">
                                                    <div class="col s12 m12">
                                                        <?php 
                                                           $complaintList= json_decode($backstage->get_complaint_list_by_student_id_with_limit($per_student->sid));
                                                       
                                                        if (count((array)$complaintList)) { ?>

                                                            Complaints found  :
                                                                <br/>

                                                                <?php foreach ($complaintList as $cmplist) { ?>

                                                                &emsp; <span class=""><?php echo (($login_date_type==2)? eToN($cmplist->cdate) : $cmplist->cdate); ?></span> &emsp;
                                                                <?php echo $cmplist->cmsg." "; ?>
                                                                    <br/>
                                                                    <?php  }   
                                                                } else { echo "No previous complaint found."; } ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-action">
                                                <a href="message.php">More info..</a>
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                     <div class="row">
                        <div class="col s12">
                            <div class="card">
                                <div class="card-panel purple darken-3">
                                    <div class="row">
                                        <div class="col s12 m6">
                                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Homework Info</span>
                                            <div class="card-content white-text flow-text">
                                                <div class="row">
                                                    <div class="col s12 m12">
                                                        <?php 
                                                $homeworkList= json_decode($backstage->get_homework_list_by_student_id_with_limit($per_student->sid));
                                                       
                                                    if (count((array)$homeworkList)) { ?>

                                                        <div style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">Not done following homeworks :
                                                        </div><br/>

                                                        <?php 
                                                        foreach ($homeworkList as $hwlist) { ?>

                                                        &emsp; <span class=""><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">date_range</i>&nbsp;<?php echo (($login_date_type==2)? eToN($hwlist->hwnddate) : $hwlist->hwnddate); ?> &emsp; <?php echo $hwlist->subject_name; ?><br/></div></span>
                                                                    <br/>
                                                        <?php } 
                                                    } else { echo "All homeworks done.";  } ?>
                                                    </div>

                                                </div>
                                            </div>
                                            <div class="card-action">
                                                <a href="homeworkcomplaint.php">More info..</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php } ?>


        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>