<?php
include("../config/config.php");
// grab recaptcha library
require_once "../config/recaptchalib.php";
// your secret key
$secret = "6LfF2UUUAAAAAOkPgKVnHgv_hPyAQrlYAEDOV5JB";

//for localhost
//$secret = "6Ldu2kUUAAAAAJhhzz1iUd_YB3ZjTM-ZwI54tyDn";
 
// empty response
$response = null;
 
// check secret key
$reCaptcha = new ReCaptcha($secret);

   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 

     // if submitted check response
    if ($_POST["g-recaptcha-response"]) {
        $response = $reCaptcha->verifyResponse(
            $_SERVER["REMOTE_ADDR"],
            $_POST["g-recaptcha-response"]
        );
    }

    $schl_query = mysqli_query($db,"SELECT `recaptcha` FROM `schooldetails` ");
    $schl = mysqli_fetch_array($schl_query,MYSQLI_ASSOC);    

    if ($response == null && !$response->success && $schl["recaptcha"] != 1) {
        echo "Incorrect reCaptcha";
        exit();
    }
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      
      $resultLogin = mysqli_query($db,"SELECT `stid`,`staff_name`,`staff_email`,`staff_getter`,`staff_status` FROM `staff_tbl` WHERE `staff_email` = '$myusername' AND staff_type = 'Accountant'");
      $rowResult = mysqli_fetch_array($resultLogin,MYSQLI_ASSOC);
      
      $active = $rowResult['active'];
      
      $count = mysqli_num_rows($resultLogin);
      mysqli_close($db);


      if($count == 1 && $rowResult['staff_getter'] == $mypassword && $rowResult['staff_status'] == 0) {
         //session_register("myusername");
         $_SESSION['login_user_accountant'] = $myusername;


         if(!empty($_POST["chk_remember"])) {
                setcookie ("accountant_username_hackster",$myusername,time()+ (10 * 365 * 24 * 60 * 60), "/");
                setcookie ("accountant_password_hackster",$mypassword,time()+ (10 * 365 * 24 * 60 * 60), "/");
                setcookie ("remember_accountant_login","accountant_remember_saved",time()+ (10 * 365 * 24 * 60 * 60), "/");
            } else {
                if(isset($_COOKIE["accountant_username_hackster"])) {
                    setcookie ("accountant_username_hackster","");
                }
                if(isset($_COOKIE["accountant_password_hackster"])) {
                    setcookie ("accountant_password_hackster","");
                }
            } 
         
         $msg="Login success as accountant";

      }else if ($count == 1 && $rowResult['staff_getter'] == $mypassword && $rowResult['staff_status'] != 0){
        $msg="Your account is disabled.";
      }else if ($count == 1 && empty($rowResult['staff_getter']) && $rowResult['staff_status'] == 0){
        $msg="Your password has been expired,Please contact your admin.";
      }else if ($count > 1){
        $msg="Multiple user found with same email,Please contact your admin.";
      }else{ $msg="Your login name or password is invalid"; }
           
            echo $msg;
            exit;
}
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Session Expired</title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet" type="text/css">

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
                padding-left: 0px;
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
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    <div class="row center"><a class="red-text text-lighten-4" href="#"></a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="red-text text-lighten-4" href="#"></a></div>
                    </div>
                </div> 
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title"></span>
                            <p class="flow-text center-align">
                                Session Expired. Click Below to Login Again
                            </p>
                        </div>
                        <div class="card-action white-text flow-text center-align">
                            <a href="../index.php">Login Again</a>
                        </div>
                    </div>
                </div>
            </div>            
        </main>


        <footer class="page-footer fixed">
            <!-- Detailed Footer starts -->

            <!-- Detailed Footer Ends-->

            <!-- Simple Footer starts -->
            <div class="footer-copyright">
                <div class="container">
                    <!--  © A1 Pathshala, All rights reserved. -->
                    
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
