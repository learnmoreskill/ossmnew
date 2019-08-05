<header>
    <div class="container">
        <a href="#" data-activates="nav-mobile" class="button-collapse top-nav waves-effect waves-light circle hide-on-large-only navmenuleft">
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
                        <p class="namelength sideMenuColor capFirstAll"><?php echo "Welcome, ".$login_session3; ?></p> <i class="material-icons right removemargindropdown">arrow_drop_down</i>
                    </a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li><a href="changepassword.php" class="sideMenuColor">Manage Login</a></li>
                            <li><a href="slogout.php" class="sideMenuColor">Sign Out</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <hr>
        <li><a href="swelcome.php" class="<?php if($_SESSION['navactive']=='swelcome'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Dashboard</a></li>
        <li><a href="sathistory.php" class="<?php if($_SESSION['navactive']=='sathistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Attendance History</a></li>
        <li><a href="gallery.php" class="<?php if($_SESSION['navactive']=='gallery'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Gallery</a></li>
        <li><a href="subjects.php" class="<?php if($_SESSION['navactive']=='subjects'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Subjects</a></li>
        <li><a href="allteacher.php" class="<?php if($_SESSION['navactive']=='allteacher'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Teachers</a></li>

        <li><a href="broadcasthistory.php" class="<?php if($_SESSION['navactive']=='broadcasthistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Message History</a></li>


        <li><a href="homework.php" class="<?php if($_SESSION['navactive']=='homework'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Homework</a></li>
        <li><a href="exam.php" class="<?php if($_SESSION['navactive']=='exam'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Exam date</a></li>
        <li><a href="elibrary.php" class="<?php if($_SESSION['navactive']=='elibrary'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">E-library</a></li>
        <!-- <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='announcementschool' || $_SESSION['navactive']=='announcementclass'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Message<i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='announcementschool'){echo "class='active'";} ?> >
                                <a href="announcementschool.php" class="sideMenuColor">School Announcement</a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='announcementclass'){echo "class='active'";} ?> >
                                <a href="announcementclass.php" class="sideMenuColor">Class Announcement</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li> -->
        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='saplv' || $_SESSION['navactive']=='saplvhistory'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Leave Manager <i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='saplv'){echo "class='active'";} ?> >
                                <a href="saplv.php" class="sideMenuColor">Apply for leave</a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='saplvhistory'){echo "class='active'";} ?> >
                                <a href="saplvhistory.php" class="sideMenuColor">Leave History</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li><a href="resultview.php" class="<?php if($_SESSION['navactive']=='resultview'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Report Card</a></li>
    </ul>
</header>
