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
                            <li><a href="changepassword.php" class="sideMenuColor"><?php echo $lang['manage_login']; ?></a></li>
                            <li><a href="slogout.php" class="sideMenuColor"><?php echo $lang['sign_out']; ?></a></a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <hr>
        <li><a href="swelcome.php" class="<?php if($_SESSION['navactive']=='swelcome'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">home</i>
            <?php echo $lang['dashboard']; ?></a></li>
        <li><a href="sathistory.php" class="<?php if($_SESSION['navactive']=='sathistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">poll</i>
            <?php echo $lang['attendance_history']; ?></a></li>
        <li><a href="gallery.php" class="<?php if($_SESSION['navactive']=='gallery'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">insert_photo</i>
            <?php echo $lang['school_gallery']; ?></a></li>
        <li><a href="subjects.php" class="<?php if($_SESSION['navactive']=='subjects'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">library_books</i>
            <?php echo $lang['all_subjects']; ?></a></li>
        <li><a href="allteacher.php" class="<?php if($_SESSION['navactive']=='allteacher'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">person</i>
            <?php echo $lang['all_teachers']; ?></a></li>

        <li><a href="broadcasthistory.php" class="<?php if($_SESSION['navactive']=='broadcasthistory'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">textsms</i>
            <?php echo $lang['message_history']; ?></a></li>


        <li><a href="homework.php" class="<?php if($_SESSION['navactive']=='homework'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">assignment</i>
            <?php echo $lang['homework']; ?></a></li>
        <li><a href="exam.php" class="<?php if($_SESSION['navactive']=='exam'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">event</i>
            <?php echo $lang['exam_date']; ?></a></li>
        <li><a href="elibrary.php" class="<?php if($_SESSION['navactive']=='elibrary'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">local_library</i>
            <?php echo $lang['e_library']; ?></a></li>
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
                <li><a class="<?php if($_SESSION['navactive']=='saplv' || $_SESSION['navactive']=='saplvhistory'){echo "active ";} ?> collapsible-header  waves-effect waves-red lighten-2 sideMenuColor">

                    <i class="material-icons white-text navMenuIcon">rate_review</i>
                    <?php echo $lang['manage_leave']; ?><i class="material-icons right removemargindropdown">arrow_drop_down</i></a>
                    <div class="collapsible-body">
                        <ul class="sideMenuBack">
                            <li <?php if($_SESSION['navactive']=='saplv'){echo "class='active'";} ?> >
                                <a href="saplv.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['apply_for_leave']; ?></a>
                            </li>
                            <li <?php if($_SESSION['navactive']=='saplvhistory'){echo "class='active'";} ?> >
                                <a href="saplvhistory.php" class="sideMenuColor">

                                    <i class=" fa fa-angle-double-right menuSubIcon" style="margin: 0"></i>
                                    <?php echo $lang['leave_history']; ?></a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <li><a href="resultview.php" class="<?php if($_SESSION['navactive']=='resultview'){echo "active ";} ?> waves-effect waves-red lighten-2 sideMenuColor">

            <i class="material-icons white-text navMenuIcon">timeline</i>
            <?php echo $lang['report_card']; ?></a></li>
    </ul>
</header>
