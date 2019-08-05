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
        <li><a href="myprofile.php" class="<?php if($_SESSION['navactive']=='myprofile'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">person_pin</i>
            <?php echo $lang['my_profile']; ?></a></li>
        <li><a href="children.php" class="<?php if($_SESSION['navactive']=='children'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">account_box</i>
            <?php echo $lang['children']; ?></a></li>

        <li><a href="gallery.php" class="<?php if($_SESSION['navactive']=='gallery'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">insert_photo</i>
            <?php echo $lang['school_gallery']; ?></a></li>

        <li><a href="allsubjects.php" class="<?php if($_SESSION['navactive']=='allsubjects'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">library_books</i>
            <?php echo $lang['all_subjects']; ?></a></li>

        <li><a href="allteacher.php" class="<?php if($_SESSION['navactive']=='allteacher'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">person</i>
            <?php echo $lang['all_teachers']; ?></a></li>

        <li><a href="broadcasthistory.php" class="<?php if($_SESSION['navactive']=='broadcasthistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">textsms</i>
            <?php echo $lang['message_history']; ?></a></li>

        <li class="no-padding">
            <ul class="collapsible collapsible-accordion sideMenuBack">
                <li><a class="<?php if($_SESSION['navactive']=='homework' || $_SESSION['navactive']=='homeworkcomplaint'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">assignment</i>
                    <?php echo $lang['homework']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='homework'){echo "class='active'";} ?> >
                                <a href="homework.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['homework']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='homeworkcomplaint'){echo "class='active'";} ?> >
                                <a href="homeworkcomplaint.php" class="sideMenuColor">

                                <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                <?php echo $lang['homework_complain']; ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>

        <li><a href="exam.php" class="<?php if($_SESSION['navactive']=='exam'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">event</i>
            <?php echo $lang['exam_date']; ?></a></li>

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

        <li><a href="leavehistory.php" class="<?php if($_SESSION['navactive']=='leavehistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">rate_review</i>
            <?php echo $lang['leave_history']; ?></a></li>

        <!-- <li><a href="trackbus.php" class="<?php if($_SESSION['navactive']=='trackbus'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">Track Bus</a></li> -->


        <li><a href="resultview.php" class="<?php if($_SESSION['navactive']=='resultview'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">timeline</i>
            <?php echo $lang['report_card']; ?></a></li>
    </ul>
</header>
