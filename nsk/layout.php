<?php
include('session.php');

$sqltr1 = "select * from troutine where trtid='$login_session1'";
    $resulttr1 = $db->query($sqltr1);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Page-Title-Here</title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:700' rel='stylesheet' type='text/css'>

        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="../css/custom.css" media="screen,projection" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="An advance digital school management system. ">
        <!--  Android 5 Chrome Color -->
        <meta name="theme-color" content="#009FFF">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#009FFF">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#009FFF">
        <style>
            body {
                display: flex;
                min-height: 100vh;
                flex-direction: column;
            }

            main {
                flex: 1 0 auto;
            }
        </style>
        <script>
            history.pushState({
                page: 1
            }, "title 1", "#nbb");
            window.onhashchange = function(event) {
                window.location.hash = "nbb";
            };
        </script>
    </head>

    <body>
      <header>
            <div class="container"><a href="#" data-activates="nav-mobile" class="button-collapse top-nav waves-effect waves-light circle hide-on-large-only"><i class="material-icons">menu</i></a></div>
            <ul id="nav-mobile" class="side-nav fixed">
                <li class="logo">
                    <a id="logo-container" href="#" class="brand-logo">
                        <object id="front-page-logo" type="image/png" data="../images/dope.png">Not found</object></a>
                </li><br>
                <hr>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li class="bold">
                            <a class="collapsible-header waves-effect waves-red lighten-2">
                                <?php echo "Welcome, ".$login_session2; ?> <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="logout.php">Sign Out</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <hr>
                <li><a href="welcome.php" class="waves-effect waves-red lighten-2">Dashboard</a></li>
                <li><a href="attendance.php" class="waves-effect waves-red lighten-2">Attendance</a></li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li><a class="collapsible-header  waves-effect waves-red lighten-2">Home Works <i class="material-icons right">arrow_drop_down</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="hwmsg.php">Add Entry</a></li>
                                    <li><a href="hwhistory.php">Home Work History</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li><a class="collapsible-header  waves-effect waves-red lighten-2">Msg To Parents <i class="material-icons right">arrow_drop_down</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="mtpsearch.php">New Message</a></li>
                                    <li><a href="mtpmsghistory.php">Message History</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li><a class="collapsible-header  waves-effect waves-red lighten-2">Broadcast Message <i class="material-icons right">arrow_drop_down</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li><a href="bmsg.php">New Broadcast</a></li>
                                    <li><a href="bmsghistory.php">Broadcast History</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                <li><a href="feereport.php" class="waves-effect waves-red lighten-2">Fee Notification</a></li>
                <li><a href="grantleave.php" class="waves-effect waves-red lighten-2">Review Leave requests</a></li>
            </ul>
        </header>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    <div class="row center"><a class="red-text text-lighten-4" href="#">Red-Title-Here</a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="red-text text-lighten-4" href="#">Grey-Title-Here</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">

                            </div>
                        </div>

        </main>


        <footer class="page-footer fixed">
            <!-- Detailed Footer starts -->

            <!-- Detailed Footer Ends-->

            <!-- Simple Footer starts -->
            <div class="footer-copyright">
                <div class="container">
                    © Grab Technology Pvt. Ltd, All rights reserved.

                </div>
            </div>
            <!-- Simple Footer Ends-->
        </footer>
        <!--Import jQuery before materialize.js-->
        <!--  Scripts-->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../bin/materialize.js"></script>
        <script src="../bin/init.js"></script>
        <script src="../js/custom.js"></script>
    </body>

    </html>
