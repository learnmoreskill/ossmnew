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

        // username and password sent from form     
        $myusername = mysqli_real_escape_string($db,$_POST['username']);
        $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
        $chk_remember = $_POST["chk_remember"];
        if (!empty($chk_remember)) { $chk_remember = 10;  }else{ $chk_remember = 5; }

        $sql_unique_login = "(SELECT `pid` AS id FROM principal WHERE pemail = '$myusername') 
                UNION
                (SELECT `tid` AS id FROM teachers WHERE temail = '$myusername') 
                UNION
                (SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$myusername') 
                UNION
                (SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$myusername')
                UNION
                (SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$myusername')";

        $result_unique_login = mysqli_query($db,$sql_unique_login);

        $count_unique_login = mysqli_num_rows($result_unique_login);

        if ($count_unique_login < 1){
            $msg="Your login name or password is invalid";
        }else if ($count_unique_login > 1){
            $msg="Multiple user found with same email,Please contact your school.";
        }else{

            function setCookieAttempt($chk_remember,$myusername,$mypassword){

                if($chk_remember==10) {
                        setcookie ("admin_username_hackster",$myusername,time()+ (10 * 365 * 24 * 60 * 60), "/");
                        setcookie ("admin_password_hackster",$mypassword,time()+ (10 * 365 * 24 * 60 * 60), "/");
                        setcookie ("remember_admin_login","admin_remember_saved",time()+ (10 * 365 * 24 * 60 * 60), "/");
                    } else {

                        if(isset($_COOKIE["admin_username_hackster"])) {
                            setcookie ("admin_username_hackster","", time() - 3600, "/");
                        }
                        if(isset($_COOKIE["admin_password_hackster"])) {
                            setcookie ("admin_password_hackster","", time() - 3600, "/");
                        }
                        if(isset($_COOKIE["remember_admin_login"])) {
                            setcookie ("remember_admin_login","", time() - 3600, "/");
                        }
                    } 
            }

            //CHECK FOR STUDENT
            $resultLogin = mysqli_query($db,"SELECT `sid`,`sname`,`semail`,`sgetter`,`status` FROM `studentinfo` WHERE `semail` = '$myusername'");
            $rowResult = mysqli_fetch_array($resultLogin,MYSQLI_ASSOC);
              
            $count = mysqli_num_rows($resultLogin);

            if ($count == 1) {

                if($rowResult['sgetter'] == $mypassword && $rowResult['status'] == 0 ) {
                     
                    $_SESSION['login_user_student'] = $myusername;
                    setCookieAttempt($chk_remember,$myusername,$mypassword);      
                    $msg="Login success as student";

                }else if ($rowResult['sgetter'] == $mypassword && $rowResult['status'] != 0){
                    $msg="Your account is disabled.";
                }else if (empty($rowResult['sgetter']) && $rowResult['status'] == 0){
                    $msg="Your password has been expired,Please contact your admin.";
                }else{ $msg="Your login name or password is invalid"; }
                  
            }else{

                //CHECK FOR PARENT
                $resultLogin = mysqli_query($db,"SELECT `parent_id`,`spname`,`smname`,`spemail`,`spphone`,`spstatus` FROM `parents` WHERE `spemail` = '$myusername'");
                $rowResult = mysqli_fetch_array($resultLogin,MYSQLI_ASSOC);
              
                $count = mysqli_num_rows($resultLogin);

                if ($count == 1) {

                    if($rowResult['spphone'] == $mypassword && $rowResult['spstatus'] == 0) {
                        
                        $_SESSION['login_user_parent'] = $myusername;
                        setCookieAttempt($chk_remember,$myusername,$mypassword);
                        $msg="Login success as parent";

                    }else if ($rowResult['spphone'] == $mypassword && $rowResult['spstatus'] != 0){
                        $msg="Your account is disabled.";
                    }else if (empty($rowResult['spphone']) && $rowResult['spstatus'] == 0){
                        $msg="Your password has been expired,Please contact your admin.";
                    }else{ $msg="Your login name or password is invalid"; }


                }else{
                    //CHECK FOR TEACHER
                    $resultLogin = mysqli_query($db,"SELECT `tid`,`tname`,`temail`,`tgetter`,`status` FROM `teachers` WHERE `temail` = '$myusername'");
                    $rowResult = mysqli_fetch_array($resultLogin,MYSQLI_ASSOC);
                  
                    $count = mysqli_num_rows($resultLogin);

                    if ($count == 1) {

                        if($rowResult['tgetter'] == $mypassword && $rowResult['status'] == 0 ) {

                            $_SESSION['login_user_teacher'] = $myusername;
                            setCookieAttempt($chk_remember,$myusername,$mypassword);
                            $msg="Login success as teacher";

                        }else if ($rowResult['tgetter'] == $mypassword && $rowResult['status'] != 0){
                            $msg="Your account is disabled.";
                        }else if (empty($rowResult['tgetter']) && $rowResult['status'] == 0){
                                $msg="Your password has been expired,Please contact your admin.";
                        }else{ $msg="Your login name or password is invalid"; }

                    }else{
                        //CHECK FOR STAFF
                        $resultLogin = mysqli_query($db,"SELECT `stid`,`staff_name`,`staff_type`,`staff_email`,`staff_getter`,`staff_status` FROM `staff_tbl` WHERE `staff_email` = '$myusername'");
                        $rowResult = mysqli_fetch_array($resultLogin,MYSQLI_ASSOC);
                      
                        $count = mysqli_num_rows($resultLogin);

                        if ($count == 1) {

                            if($rowResult['staff_getter'] == $mypassword && $rowResult['staff_status'] == 0 ) {
                                
                                $_SESSION['login_user_manager'] = $myusername;
                                setCookieAttempt($chk_remember,$myusername,$mypassword);
                                $msg="Login success as manager";

                            }else if ($rowResult['staff_getter'] == $mypassword && $rowResult['staff_status'] != 0){
                                $msg="Your account is disabled.";
                            }else if (empty($rowResult['staff_getter']) && $rowResult['staff_status'] == 0){
                                $msg="Your password has been expired,Please contact your admin.";
                            }else{ $msg="Your login name or password is invalid"; }


                        }else{
                             //CHECK FOR PRINCIPAL
                            $resultLogin = mysqli_query($db,"SELECT `pid`,`pname`,`pemail`,`ppassword`,`status` FROM `principal` WHERE `pemail` = '$myusername'");
                            $rowResult = mysqli_fetch_array($resultLogin,MYSQLI_ASSOC);
                      
                            $count = mysqli_num_rows($resultLogin);

                            if ($count == 1) {

                                if($rowResult['ppassword'] == $mypassword && $rowResult['status'] == 0 ) {
                                
                                    $_SESSION['login_user_admin'] = $myusername;
                                    setCookieAttempt($chk_remember,$myusername,$mypassword);
                                    $msg="Login success as admin";

                                }else if ($rowResult['ppassword'] == $mypassword && $rowResult['status'] != 0){
                                    $msg="Your account is disabled.";
                                }else if (empty($rowResult['ppassword']) && $rowResult['status'] == 0){
                                    $msg="Your password has been expired,Please contact your admin.";
                                }else{ $msg="Your login name or password is invalid"; }


                            }else{
                                $msg = 'Unable to validate your account.';
                            } 
                        }
                    }
                }

            }
            mysqli_close($db);        
         
        }
           
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
        <link href="http://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet" type="text/css">

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
        <meta name="theme-color" content="#009fff">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#009fff">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#009fff">
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
                    <div class="row center"><a class="white-text text-lighten-4" href="#"></a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#"></a></div>
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
