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
        <hr>
        <li><a href="welcome.php" class="<?php if($_SESSION['navactive']=='welcome'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">
            
            <i class="material-icons white-text navMenuIcon">home</i>
            <?php echo $lang['dashboard']; ?></a></li>
        <li><a href="attendance.php" class=" <?php if($_SESSION['navactive']=='attendance'){echo "active ";} ?>waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">poll</i>
            <?php echo $lang['attendance']; ?></a></li>
        <li><a href="gallery.php" class=" <?php if($_SESSION['navactive']=='gallery'){echo "active ";} ?>waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">insert_photo</i>
            <?php echo $lang['school_gallery']; ?></a></li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='allsubjects' || $_SESSION['navactive']=='addsubject'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">library_books</i>
                    <?php echo $lang['subjects']; ?> <i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='allsubjects'){echo "class='active'";} ?> >
                                <a href="allsubjects.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['all_subjects']; ?></a>
                            </li>
                            <!-- <li <?php if($_SESSION['navactive']=='addsubject'){echo "class='active'";} ?> >
                                <a href="addsubject.php" class="sideMenuColor">Add Subjects</a>
                            </li> -->
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='allclasses'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">class</i>
                    <?php echo $lang['classes']; ?> <i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='allclasses'){echo "class='active'";} ?> >
                                <a href="allclasses.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['all_classes']; ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='exam' || $_SESSION['navactive']=='addmarks' || $_SESSION['navactive']=='searchstudentformarksheet'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">timeline</i>
                    <?php echo $lang['exam_and_results']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='exam'){echo "class='active'";} ?> >
                                <a href="exam.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['exam_timetable']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='addmarks'){echo "class='active'";} ?> >
                                <a href="addmarks.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['add_marks']; ?></a>
                            </li>
                            <!-- <li><a href="reviewmarks.php" class="sideMenuColor">Review Marks</a></li> -->
                            <li <?php if($_SESSION['navactive']=='searchstudentformarksheet'){echo "class='active'";} ?> >
                                <a href="searchstudentformarksheet.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['view_marksheet']; ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='hwmsg' || $_SESSION['navactive']=='hwhistory'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">assignment</i>
                    <?php echo $lang['homework']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='hwmsg'){echo "class='active'";} ?> >
                                <a href="hwmsg.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['add_homework']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='hwhistory'){echo "class='active'";} ?> >
                                <a href="hwhistory.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['homework_history']; ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='sendbroadcast' || $_SESSION['navactive']=='broadcasthistory' || $_SESSION['navactive']=='sendpersonal'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">textsms</i>
                    <?php echo $lang['message']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
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
                            <li <?php if($_SESSION['navactive']=='broadcasthistory'){echo "class='active'";} ?> >
                                <a href="broadcasthistory.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['message_history']; ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li><a href="lessonplan.php" class="<?php if($_SESSION['navactive']=='lessonplan'){echo "active";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">event_available</i>
            <?php echo $lang['lesson_plan']; ?></a></li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='elibrary' || $_SESSION['navactive']=='eupload'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">local_library</i>
                    <?php echo $lang['e_library']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='elibrary'){echo "class='active'";} ?> ><a href="elibrary.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['e_library']; ?></a></li>
                            <li <?php if($_SESSION['navactive']=='eupload'){echo "class='active'";} ?> ><a href="eupload.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['upload_file']; ?></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <!-- <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='sendpersonal' || $_SESSION['navactive']=='broadcasthistory'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Message<i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='sendpersonal'){echo "class='active'";} ?> >
                                <a href="sendpersonal.php" class="sideMenuColor">Send Personal</a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='broadcasthistory'){echo "class='active'";} ?> >
                                <a href="broadcasthistory.php" class="sideMenuColor">Message History</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li> -->
        <li><a href="http://202.52.240.149:8082/" class=" waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">directions_bus</i>
            <?php echo $lang['track_school_buses']; ?></a></li>
        <li><a href="grantleave.php" class="<?php if($_SESSION['navactive']=='grantleave'){echo "active";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">rate_review</i>
            <?php echo $lang['review_leave_request']; ?></a></li>
    </ul>
</header>
