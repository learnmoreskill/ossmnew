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
        <li><a href="myprofile.php" class="<?php if($_SESSION['navactive']=='myprofile'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">My Profile</a></li>

        <li><a href="children.php" class="<?php if($_SESSION['navactive']=='children'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Children</a></li>

        <li><a href="gallery.php" class="<?php if($_SESSION['navactive']=='gallery'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Gallery</a></li>
        <li><a href="allsubjects.php" class="<?php if($_SESSION['navactive']=='allsubjects'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Subjects</a></li>
        <li><a href="allteacher.php" class="<?php if($_SESSION['navactive']=='allteacher'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Teachers</a></li>

        <li><a href="broadcasthistory.php" class="<?php if($_SESSION['navactive']=='broadcasthistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Message History</a></li>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='homework' || $_SESSION['navactive']=='homeworkcomplaint'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Homework<i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='homework'){echo "class='active'";} ?> >
                                <a href="homework.php" class="sideMenuColor">Homework</a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='homeworkcomplaint'){echo "class='active'";} ?> >
                                <a href="homeworkcomplaint.php" class="sideMenuColor">Homework Complaint</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li><a href="exam.php" class="<?php if($_SESSION['navactive']=='exam'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Exam date</a></li>

        <!-- <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='announcementschool' || $_SESSION['navactive']=='announcementclass' || $_SESSION['navactive']=='message'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">Message<i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='message'){echo "class='active'";} ?> >
                                <a href="message.php" class="sideMenuColor">My Message</a>
                            </li>
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

        <li><a href="leavehistory.php" class="<?php if($_SESSION['navactive']=='leavehistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Leave History</a></li>

        <!-- <li><a href="trackbus.php" class="<?php if($_SESSION['navactive']=='trackbus'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Track Bus</a></li> -->


        <li><a href="resultview.php" class="<?php if($_SESSION['navactive']=='resultview'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Report Card</a></li>
    </ul>
</header>
