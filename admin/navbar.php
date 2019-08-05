<header>
    <div class="container">
        <a href="#" data-activates="nav-mobile" class="button-collapse top-nav waves-effect waves-light circle hide-on-large-only navmenuleft" >
            <i class="material-icons">menu</i>
        </a>
       
    </div>
    <ul id="nav-mobile" class="side-nav fixed sideMenuBack">
        <li class="custom-logo">
            <!-- <a  href="#" class="custom-brand-logo"> -->
                <object class="iconsize1" id="front-page-logo" type="image/png" data="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">Not found</object>
            <!-- </a> -->
        </li>
        <hr style="margin: 0">
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                
                <li><a href="#modal_change_current_session" class="modal-trigger waves-effect waves-red lighten-2 sideMenuColor" style="height: 30px"><?php echo $lang['current_session']; ?> : <?php  echo $current_year_session;   ?>
                </a></li>

                <li class="bold">
                    <a class="collapsible-header waves-effect waves-red lighten-2">
                    <p class="namelength sideMenuColor capFirstAll"> <?php echo $lang['welcome'].", ".$login_session2; ?></p> 
                    <i class="material-icons right removemargindropdown">arrow_drop_down</i>
                    </a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li><a href="changepassword.php" class="sideMenuColor"><?php echo $lang['manage_login']; ?></a></li>
                            <li><a href="logout.php" class="sideMenuColor"><?php echo $lang['sign_out']; ?></a></li>
                        </ul>
                    </div>
                </li>

            </ul>
        </li>
        
        <hr style="margin-top: 0">
        <li>
            <a href="welcome.php" class="<?php if($_SESSION['navactive']=='welcome'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">home</i>
            <?php echo $lang['dashboard']; ?></a></li>
        <li><a href="myprofile.php" class="<?php if($_SESSION['navactive']=='myprofile'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">person_pin</i>
            <?php echo $lang['my_profile']; ?></a></li>

        <?php if ($login_cat == 1 || $pac['view_attendance'] == 1 || $pac['take_attendance'] == 1 || $pac['edit_attendance'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='attendancebydate' || $_SESSION['navactive']=='attendancebyclass' || $_SESSION['navactive']=='attendance' || $_SESSION['navactive']=='addAttendanceManual' || $_SESSION['navactive']=='teacher_attendance' || $_SESSION['navactive']=='staff_attendance' || $_SESSION['navactive']=='attendance_report'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">poll</i>
                    <?php echo $lang['attendance']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <?php if ($login_cat == 1 || $pac['take_attendance'] == 1 || $pac['edit_attendance'] == 1) { ?>
                            <li <?php if($_SESSION['navactive']=='attendance'){echo "class='active'";} ?> ><a href="attendance.php" class="sideMenuColor">

                                <!-- <i class="material-icons white-text" style="margin: 0">keyboard_arrow_right</i> -->
                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['take_view_attendance']; ?></a>
                            </li>

                            <li <?php if($_SESSION['navactive']=='teacher_attendance'){echo "class='active'";} ?> ><a href="attendanceStaff.php?attendanceFor=teacher" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['take_view_attendance_for_teacher']; ?></a>
                            </li>

                            <li <?php if($_SESSION['navactive']=='staff_attendance'){echo "class='active'";} ?> ><a href="attendanceStaff.php?attendanceFor=staff" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['take_view_attendance_for_staff']; ?></a>
                            </li>
                            
                            <li <?php if($_SESSION['navactive']=='addAttendanceManual'){echo "class='active'";} ?> >
                                <a href="addAttendanceManual.php" class="sideMenuColor">
                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo 'Add Attendance Manually'; ?></a>
                            </li>
                            <?php } ?>

                            <?php if ($login_cat == 1 || $pac['view_attendance'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='attendance_report'){echo "class='active'";} ?> >
                                <a href="attendanceReport.php" class="sideMenuColor">
                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['attendance_report']; ?></a>
                            </li>


                            <li <?php if($_SESSION['navactive']=='attendancebydate'){echo "class='active'";} ?> >
                                <a href="attendancebydate.php" class="sideMenuColor">
                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['attendance_by_date']; ?></a>
                            </li>


                            <li <?php if($_SESSION['navactive']=='attendancebyclass'){echo "class='active'";} ?> >
                                <a href="attendancebyclass.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['attendance_by_class']; ?></a>
                            </li>
                            <?php } ?>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_gallery'] == 1 || $pac['add_gallery'] == 1 || $pac['edit_gallery'] == 1) { ?> 

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='gallery' || $_SESSION['navactive']=='gupload'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">insert_photo</i>
                    <?php echo $lang['gallery']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_gallery'] == 1 || $pac['edit_gallery'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='gallery'){echo "class='active'";} ?> >
                                <a href="gallery.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['school_gallery']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_gallery'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='gupload'){echo "class='active'";} ?> >
                                <a href="gupload.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['add_events_picture']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_student'] == 1 || $pac['add_student'] == 1 || $pac['edit_student'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='allstudent' || $_SESSION['navactive']=='studentdetails' || $_SESSION['navactive']=='admitstudent' || $_SESSION['navactive']=='rollmanager' || $_SESSION['navactive']=='parent'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">school</i>
                    <?php echo $lang['student']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_student'] == 1 || $pac['edit_student'] == 1 ) { ?>

                            <li <?php if($_SESSION['navactive']=='allstudent'){echo "class='active'";} ?> >
                                <a href="allstudent.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['all_student']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='studentdetails'){echo "class='active'";} ?> >
                                <a href="studentdetails.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['search_student']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_student'] == 1 ) { ?>

                            <li <?php if($_SESSION['navactive']=='admitstudent'){echo "class='active'";} ?> >
                                <a href="admitstudent.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['admit_student']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['edit_student'] == 1 ) { ?>

                            <li <?php if($_SESSION['navactive']=='rollmanager'){echo "class='active'";} ?> >
                                <a href="rollmanager.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['manage_roll_number']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_student'] == 1 ) { ?>

                            <li <?php if($_SESSION['navactive']=='parent'){echo "class='active'";} ?> >
                                <a href="parent.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['parents']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <?php if ($login_cat == 1 || $pac['view_teacher'] == 1 || $pac['add_teacher'] == 1 || $pac['edit_teacher'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='allteacher' || $_SESSION['navactive']=='addteacher'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">person</i>
                    <?php echo $lang['teacher']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_teacher'] == 1 || $pac['edit_teacher'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='allteacher'){echo "class='active'";} ?> >
                                <a href="allteacher.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['all_teachers']; ?></a>
                            </li>

                            <?php } ?>

                            <?php if ($login_cat == 1 || $pac['add_teacher'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='addteacher'){echo "class='active'";} ?> >
                                <a href="addteacher.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['add_teacher']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <?php if ($login_cat == 1 || $pac['view_daily_routine'] == 1 || $pac['add_daily_routine'] == 1 || $pac['edit_daily_routine'] == 1) { ?>


        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='routinestudent' || $_SESSION['navactive']=='createstudentroutine' || $_SESSION['navactive']=='routineteacher' || $_SESSION['navactive']=='createteacherroutine'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">developer_board</i>
                    <?php echo $lang['daily_class_routine']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_daily_routine'] == 1 || $pac['edit_daily_routine'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='routinestudent'){echo "class='active'";} ?> >
                                <a href="routinestudent.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['student_routine']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_daily_routine'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='createstudentroutine'){echo "class='active'";} ?> >
                                <a href="createstudentroutine.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['create_student_routine']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['view_daily_routine'] == 1 || $pac['edit_daily_routine'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='routineteacher'){echo "class='active'";} ?> >
                                <a href="routineteacher.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['teacher_routine']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_daily_routine'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='createteacherroutine'){echo "class='active'";} ?> ><a href="createteacherroutine.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['create_teacher_routine']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <?php if ($login_cat == 1 || $pac['view_class'] == 1 || $pac['add_class'] == 1 || $pac['edit_class'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='allclasses' || $_SESSION['navactive']=='addclass' || $_SESSION['navactive']=='promotion'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">class</i>
                    <?php echo $lang['classes']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_class'] == 1 || $pac['edit_class'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='allclasses'){echo "class='active'";} ?> >
                                <a href="allclasses.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['all_classes']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_class'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='addclass'){echo "class='active'";} ?> >
                                <a href="addclass.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['add_class']; ?></a>
                            </li>

                            <?php } ?>

                            <?php if ($login_cat == 1 ) { ?>

                            <li <?php if($_SESSION['navactive']=='promotion'){echo "class='active'";} ?> >
                                <a href="promotion.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo "Promotion"; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <?php if ($login_cat == 1 || $pac['view_subject'] == 1 || $pac['add_subject'] == 1 || $pac['edit_subject'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='allsubjects' || $_SESSION['navactive']=='addsubject'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">library_books</i>
                    <?php echo $lang['subjects']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_subject'] == 1 || $pac['edit_subject'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='allsubjects'){echo "class='active'";} ?> >
                                <a href="allsubjects.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['all_subjects']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_subject'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='addsubject'){echo "class='active'";} ?> >
                                <a href="addsubject.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['add_subject']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_exam'] == 1 || $pac['add_exam'] == 1 || $pac['edit_exam'] == 1 || $pac['view_mark'] == 1 || $pac['add_mark'] == 1 || $pac['edit_mark'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='exam' || $_SESSION['navactive']=='createexam' || $_SESSION['navactive']=='publish' || $_SESSION['navactive']=='addmarks'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">timeline</i>
                    <?php echo $lang['exam_and_results']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_exam'] == 1 || $pac['edit_exam'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='exam'){echo "class='active'";} ?> >
                                <a href="exam.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['exam_timetable']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_exam'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='createexam'){echo "class='active'";} ?> >
                                <a href="createexam.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['create_exam']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_mark'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='addmarks'){echo "class='active'";} ?> >
                                <a href="addmarks.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['add_marks']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['view_mark'] == 1 || $pac['edit_mark'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='publish'){echo "class='active'";} ?> >
                                <a href="publish.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['review_publish_mark']; ?></a>
                            </li>

                            <?php } ?>
                            
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_lesson'] == 1 || $pac['add_lesson'] == 1 || $pac['edit_lesson'] == 1) { ?>

        <li><a href="lessonplanning.php" class="<?php if($_SESSION['navactive']=='lessonplanning'){echo "active";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">event_available</i>
            <?php echo $lang['lesson_plan']; ?></a></li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_elibrary'] == 1 || $pac['add_elibrary'] == 1 || $pac['edit_elibrary'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='elibrary' || $_SESSION['navactive']=='eupload'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">local_library</i>
                    <?php echo $lang['e_library']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_elibrary'] == 1 || $pac['edit_elibrary'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='elibrary'){echo "class='active'";} ?> >
                                <a href="elibrary.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['e_library']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_elibrary'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='eupload'){echo "class='active'";} ?> >
                                <a href="eupload.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['upload_file']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <!-- <li><a href="promotion.php" class="waves-effect waves-red lighten-2">Student Promotion</a></li> -->

        <?php if ($login_cat == 1 || $pac['accountant'] == 1) { ?>

        <li><a href="../<?php echo $LOGIN_SCHOOL_ACCOUNT; ?>/index.php" class="waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">payment</i>
            <?php echo $lang['fee']; ?></a></li>

         <?php } ?>
        <?php if ($login_cat == 1 || $pac['librarian'] == 1) { ?>

        <li><a href="../library/index.php" class="waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">library_books</i>
            <?php echo $lang['library']; ?></a></li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_homework'] == 1 || $pac['add_homework'] == 1 || $pac['edit_homework'] == 1) { ?>
        
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='hwmsg' || $_SESSION['navactive']=='hwhistory'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">assignment</i>
                    <?php echo $lang['homework']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['add_homework'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='hwmsg'){echo "class='active'";} ?> >
                                <a href="hwmsg.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['add_homework']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['view_homework'] == 1 || $pac['edit_homework'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='hwhistory'){echo "class='active'";} ?> >
                                <a href="hwhistory.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['homework_history']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <?php if ($login_cat == 1 || $pac['view_message'] == 1  || $pac['add_message'] == 1 || $pac['edit_message'] == 1) { ?>
        
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='mtpmsghistory' || $_SESSION['navactive']=='sendbroadcast' || $_SESSION['navactive']=='broadcasthistory' || $_SESSION['navactive']=='sendpersonal' || $_SESSION['navactive']=='sendresult' || $_SESSION['navactive']=='bmsghistory' || $_SESSION['navactive']=='smsEmail'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">textsms</i>
                    <?php echo $lang['message']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['add_message'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='sendbroadcast'){echo "class='active'";} ?> >
                                <a href="sendbroadcast.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['send_broadcast']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='sendpersonal'){echo "class='active'";} ?> >
                                <a href="sendpersonal.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['send_personal']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='sendresult'){echo "class='active'";} ?> >
                                <a href="sendresult.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['send_result']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['view_message'] == 1 || $pac['edit_message'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='broadcasthistory'){echo "class='active'";} ?> >
                                <a href="broadcasthistory.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['message_history']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1) { ?>
                            
                            <li <?php if($_SESSION['navactive']=='smsEmail'){echo "class='active'";} ?> >
                                <a href="smsEmail.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['sms_email_setting']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_staff'] == 1 || $pac['add_staff'] == 1 || $pac['edit_staff'] == 1) { ?>

        <li><a href="staff.php" class="<?php if($_SESSION['navactive']=='staff'){echo "active";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">people</i>
            <?php echo $lang['staff']; ?></a></li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_leave'] == 1 || $pac['add_leave'] == 1) { ?>

        <li><a href="grantleave.php" class="<?php if($_SESSION['navactive']=='grantleave'){echo "active";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">rate_review</i>
            <?php echo $lang['review_leave_request']; ?></a></li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['view_transport'] == 1 || $pac['add_transport'] == 1 || $pac['edit_transport'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='trackbusedit' ){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">directions_bus</i>
                    <?php echo $lang['school_buses']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">

                            <?php if ($login_cat == 1 || $pac['view_transport'] == 1 || $pac['edit_transport'] == 1) { ?>

                            <!-- <li <?php if($_SESSION['navactive']=='trackbus'){echo "class='active'";} ?> >
                                <a href="trackbus.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['track_school_buses']; ?></a>
                            </li> -->
                            <li >
                                <a href="http://202.52.240.149:8082/" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['track_history']; ?></a>
                            </li>

                            <?php } ?>
                            <?php if ($login_cat == 1 || $pac['add_transport'] == 1) { ?>

                            <li <?php if($_SESSION['navactive']=='trackbusedit'){echo "class='active'";} ?> >
                                <a href="trackbusedit.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['update_buses']; ?></a>
                            </li>

                            <?php } ?>

                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>
        <?php if ($login_cat == 1 || $pac['generate'] == 1) { ?>
        
        
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='generate_character' || $_SESSION['navactive']=='generate_admitcard' || $_SESSION['navactive']=='generate_idcard' || $_SESSION['navactive']=='generate_transfer' || $_SESSION['navactive']=='markstabulation' || $_SESSION['navactive']=='marksheetforclass'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">filter_frames</i>
                    <?php echo $lang['generate']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">                            
                            <li <?php if($_SESSION['navactive']=='generate_admitcard'){echo "class='active'";} ?> >
                                <a href="generate_admitcard.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['admit_card']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='generate_idcard'){echo "class='active'";} ?> >
                                <a href="generate_idcard.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['id_card']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='markstabulation'){echo "class='active'";} ?> >
                                <a href="markstabulation.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['marks_ledger']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='marksheetforclass'){echo "class='active'";} ?> >
                                <a href="marksheetforclass.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['marksheet']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='generate_character'){echo "class='active'";} ?> >
                                <a href="generate_character.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['character_certificate']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='generate_transfer'){echo "class='active'";} ?> >
                                <a href="generate_transfer.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['transfer_certificate']; ?></a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <?php if ($login_cat == 1 || $pac['export'] == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='export_teacher' || $_SESSION['navactive']=='export_student' || $_SESSION['navactive']=='export_parent' || $_SESSION['navactive']=='export_transport' || $_SESSION['navactive']=='export_hostel'  || $_SESSION['navactive']=='export_staff'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">print</i>
                    <?php echo $lang['export']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">                            
                            <li <?php if($_SESSION['navactive']=='export_teacher'){echo "class='active'";} ?> >
                                <a href="export_teacher.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['teacher_details']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='export_student'){echo "class='active'";} ?> >
                                <a href="export_student.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['student_details']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='export_staff'){echo "class='active'";} ?> >
                                <a href="export_staff.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['staff_details']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='export_parent'){echo "class='active'";} ?> >
                                <a href="export_parent.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['parents']; ?></a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>

        <?php if ($login_cat == 1) { ?>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='academicsetting' || $_SESSION['navactive']=='examsetting' || $_SESSION['navactive']=='cms' ){ echo "active "; } ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">settings</i>
                    <?php echo $lang['setting']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>

                    <div class="collapsible-body">
                        <ul class="sideMenuBack">                            
                            <li <?php if($_SESSION['navactive']=='academicsetting'){    echo "class='active'";  } ?> >
                                <a href="academicsetting.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['academic']; ?></a>
                            </li>                        
                        </ul>
                    </div>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">                            
                            <li <?php if($_SESSION['navactive']=='examsetting'){    echo "class='active'";  } ?> >
                                <a href="examsetting.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['exam_format']; ?></a>
                            </li>                        
                        </ul>
                    </div>

                    <div class="collapsible-body">
                        <ul class="sideMenuBack">                            
                            <li <?php if($_SESSION['navactive']=='cms'){    echo "class='active'";  } ?> >
                                <a href="https://a1pathshala.com/cms/" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['cms']; ?></a>
                            </li>                        
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <?php } ?>
        
        <br>
    </ul>
</header>