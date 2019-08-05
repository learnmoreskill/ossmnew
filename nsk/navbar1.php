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
                <li class="bold">
                    <a class="collapsible-header waves-effect waves-red lighten-2">
                    <p class="namelength sideMenuColor capFirstAll"> <?php echo "Welcome, ".$login_session2; ?></p> <i class="material-icons right removemargindropdown">arrow_drop_down</i>
                    </a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li><a href="changepassword.php" class="sideMenuColor">Manage Login</a></li>
                            <li><a href="logout.php" class="sideMenuColor">Sign Out</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <hr>
        <li><a href="welcome.php" class="<?php if($_SESSION['navactive']=='welcome'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Dashboard</a></li>
        <li><a href="attendance.php" class=" <?php if($_SESSION['navactive']=='attendance'){echo "active ";} ?>waves-effect waves-red lighten-2 sideMenuColor">Attendance</a></li>
        <li><a href="gallery.php" class=" <?php if($_SESSION['navactive']=='gallery'){echo "active ";} ?>waves-effect waves-red lighten-2 sideMenuColor">School Gallery</a></li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='allsubjects' || $_SESSION['navactive']=='addsubject'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Subjects <i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='allsubjects'){echo "class='active'";} ?> >
                                <a href="allsubjects.php" class="sideMenuColor">All Subjects</a>
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
                <li><a class="<?php if($_SESSION['navactive']=='allclasses'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Classes <i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='allclasses'){echo "class='active'";} ?> >
                                <a href="allclasses.php" class="sideMenuColor">Classes Details</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='exam' || $_SESSION['navactive']=='addmarks' || $_SESSION['navactive']=='searchstudentformarksheet'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Exam & Results <i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='exam'){echo "class='active'";} ?> >
                                <a href="exam.php" class="sideMenuColor">Exam Timetable</a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='addmarks'){echo "class='active'";} ?> >
                                <a href="addmarks.php" class="sideMenuColor">Add Marks</a>
                            </li>
                            <!-- <li><a href="reviewmarks.php" class="sideMenuColor">Review Marks</a></li> -->
                            <li <?php if($_SESSION['navactive']=='searchstudentformarksheet'){echo "class='active'";} ?> >
                                <a href="searchstudentformarksheet.php" class="sideMenuColor">View Marksheet</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='hwmsg' || $_SESSION['navactive']=='hwhistory'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Home Works <i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='hwmsg'){echo "class='active'";} ?> >
                                <a href="hwmsg.php" class="sideMenuColor">Add Entry</a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='hwhistory'){echo "class='active'";} ?> >
                                <a href="hwhistory.php" class="sideMenuColor">Home Work History</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='sendbroadcast' || $_SESSION['navactive']=='broadcasthistory' || $_SESSION['navactive']=='sendpersonal'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Message<i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='sendbroadcast'){echo "class='active'";} ?> >
                                <a href="sendbroadcast.php" class="sideMenuColor">Send Broadcast</a>
                            </li>
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
        </li>
        <li><a href="lessonplan.php" class="<?php if($_SESSION['navactive']=='lessonplan'){echo "active";} ?> waves-effect waves-red lighten-2 sideMenuColor">Lesson Plan</a></li>
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='elibrary' || $_SESSION['navactive']=='eupload'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">E-Library<i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='elibrary'){echo "class='active'";} ?> ><a href="elibrary.php" class="sideMenuColor">E-Library</a></li>
                            <li <?php if($_SESSION['navactive']=='eupload'){echo "class='active'";} ?> ><a href="eupload.php" class="sideMenuColor">Upload File</a></li>
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
        <li><a href="http://202.52.240.149:8082/" class=" waves-effect waves-red lighten-2 sideMenuColor">Track Bus</a></li>
        <li><a href="grantleave.php" class="<?php if($_SESSION['navactive']=='grantleave'){echo "active";} ?> waves-effect waves-red lighten-2 sideMenuColor">Review Leave requests</a></li>
    </ul>
</header>
