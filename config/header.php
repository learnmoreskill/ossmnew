<!DOCTYPE html>
    <html>

    <head>
        <title><?php echo ((!empty($login_session_a))? $login_session_a : 'School Management'); ?></title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:700' rel='stylesheet' type='text/css'>

        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="../css/custom.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="../css/helper.css" media="screen,projection" />

        <link type="text/css" rel="stylesheet" href="../css/gradient.css" media="screen,projection" />

        <link type="text/css" rel="stylesheet" href="../css/hackster.css" media="screen,projection" />

        <link type="text/css" rel="stylesheet" href="../css/materialize.clockpicker.css" media="screen,projection" />

        <link  href="../css/new_css/datatables.min.css" rel='stylesheet' type='text/css' />
        
        <link  href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel='stylesheet' type='text/css' />
        
        
        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="An advance digital school management system. ">
        <meta name="author" content="Krishna hackster(krishnam.com.np)">
        <meta name="keyword" content="A1Pathshala, SchoolManagementTool, SchoolManager, schoolApp, manageSchool, onlineSchool, Schoolmanagement, completeSchool">
        <!--  Android 5 Chrome Color -->
        <meta name="theme-color" content="#009FFF">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#009FFF">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#009FFF">

        <!-- favicons ============================================= -->
        <link rel="icon" type="image/png" href="../images/favicon.png">


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
        <!-- disable back button of browser -->
       <!--  <script>
            history.pushState({
                page: 1
            }, "title 1", "#nbb");
            window.onhashchange = function(event) {
                window.location.hash = "nbb";
            };
        </script> -->
    </head>

    <body>