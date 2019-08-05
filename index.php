<?php
   session_start();

   if(isset($_SESSION['login_user_admin']) || isset($_SESSION['login_user_manager'])){
      header("location:admin/welcome.php");
   }
   elseif (isset($_SESSION['login_user_teacher'])) {
       header("location:nsk/welcome.php");
   }
   elseif (isset($_SESSION['login_user_student'])) {
       header("location:smart/swelcome.php");
   }
   elseif (isset($_SESSION['login_user_parent'])) {
       header("location:parents/welcome.php");
   }
   // elseif (isset($_SESSION['login_user_accountant'])) {
   //     header("location:account/index.php");
   // }
   // elseif (isset($_SESSION['login_user_librarian'])) {
   //     header("location:library/index.php");
   // }
  


  require("config/config.php");

    $check_subdomain = mysqli_query($db,"SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_database'");
    $countrow = mysqli_num_rows($check_subdomain);

    if($countrow == 1) {

      $schl_query = mysqli_query($db,"SELECT `school_name`, `school_code`, `school_address`, `slogo`, `slogan`, `recaptcha` FROM `schooldetails` ");
      $schl = mysqli_fetch_array($schl_query,MYSQLI_ASSOC);

    }else{

          ?><script> alert('<?php echo "School sub-domain is not valid!!!!"; ?>'); window.location.href = 'https://a1pathshala.com'; </script><?php
    }







?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="login_assets/custom css/style.css">
<link rel="stylesheet" href="login_assets/custom css/stl.css"/>

<!-- favicons ============================================= -->
  <link rel="icon" type="image/png" href="images/favicon.png">



 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
 <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
   <link rel="stylesheet" href="login_assets/custom css/responsive.css"/>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

   <script type="text/javascript" src="login_assets/jquery/js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="login_assets/jquery/js/script.js"></script>
     <script src="login_assets/jquery/js/jquery-3.3.1.min.js"></script>
  <script src="login_assets/jquery/js/bootstrap.min.js"></script>
<body style="background-color: rgba(0,159,255,0.15);">
    <div class="container">
        <h2 style="text-align: center;margin-bottom: 80px;margin-top: 20px; text-transform: capitalize; "><?php echo $schl['school_name']; ?></h2> 
        <div class="row no-margin">
            <div class="col-sm-6 offset-sm-3">
                <div class="card">
                <div class="card-body">
                    
                      <div class="imgcontainer">
                        <img src="<?php $image=$schl["slogo"]; if(!empty($image)){ echo "uploads/".$fianlsubdomain."/logo/".$image; }else{ echo "login_assets/images/a1pathshala.png"; } ?>"  alt="A1 pathshala" class="avatar">
                        <?php if(!empty($schl["slogan"])){ ?>
                         <h6 text-center style="margin-top: 10px; text-transform: capitalize;"><?php echo $schl["slogan"]; ?></h6>
                       <?php } ?>
                      </div>
                      <div id="schoolname_id" style="text-align: center;"></div>

                        <div class="container text-center" style="margin-bottom: 50px;margin-top: 100px;">
                           <!--  <button type="submit" style="margin-top: 20px;">Login </button> -->

                          
                           <button id="login_button_id" class="btn btn-primary sys_show_popup_login_admin" type="button" style="margin-top: 20px;">Login
                            </button>

                            
                           <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#registerModal" style="margin-top: 20px;">Register New School
                          </button>

                        </div>
                         </div>
                        
                        <div class="card-footer ">
                            <div class="float-right">
                              Powered by &nbsp;<a href="http://grabinfotech.com"><img src="login_assets/images/grablogo.png" alt="Grab Infotech" class="avatar2"></a>
                            </div>
                            

                        </div>
                        </div>


                            <div class="modal fade" id="registerModal">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                
                                  <!-- Modal Header -->
                                  <div class="modal-header">
                                    <h4 class="modal-title">Register School</h4>
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                  </div>
                                  
                                  <!-- Modal body -->
                                  <div class="modal-body">
                                    <form id="register_school_form" action="login_assets/login_action.php" method="post">
                                    <div class="form-group">
                                        <label for="nameofschool">Name of School</label>
                                        <input type="text" class="form-control" id="nameofschool" placeholder="Enter School Name" name="nameofschool">
                                      </div>
                                      <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" placeholder="Enter Full Address" name="address">
                                      </div>
                                      <div class="form-group">
                                        <label for="name">Full Name</label>
                                        <input type="text" class="form-control" id="name" placeholder="Enter Full Name" name="name">
                                      </div>
                                      <div class="form-group">
                                        <label for="contact">Contact Number</label>
                                        <input type="text" class="form-control" id="contact" placeholder="Enter Contact Number" name="contact">
                                      </div>
                                      <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                      </div>
                                      
                                      <button type="submit" class="btn btn-danger">Submit</button>
                                    </form>
                                  </div>
                                  
                                  <!-- Modal footer -->
                                  <!-- <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                  </div> -->
                                  
                                </div>
                              </div>
                            </div>



                         <div class="popup-common" id="sys_popup_common_admin">
                             <div class="overlay-bl-bg"></div>
                             <div class="container_12 pop-content">
                                 <div class="grid_4 wrap-btn-close ta-r">
                                     <i class="icon iBigX closePopup"></i>
                                 </div>
                                 <div class="grid_4">
                                     <div class="form login-form">
                                         <form id="admin_login" action="linker/login.php" method="post">
                                             <h3 class="rs title-form">Login</h3>
                                             <div class="box-white">
                                                 <h4 class="rs title-box">Login</h4>
                                                 <div class="form-action">
                                                     <label for="txt_email_login">
                                                         <input name="username" id="txt_email_login" class="txt fill-width" type="email" placeholder="Enter your e-mail address" class="validate" onclick="hideErrMsgAdmin()" value="<?php if(isset($_COOKIE["admin_username_hackster"])) { echo $_COOKIE["admin_username_hackster"]; } ?>" required />
                                                     </label>
                                                     <label for="admin_password_login">
                                                         <input name="password" id="admin_password_login" class="txt fill-width" type="password" placeholder="Enter password" class="validate" onclick="hideErrMsgAdmin()" value="<?php if(isset($_COOKIE["admin_password_hackster"])) { echo $_COOKIE["admin_password_hackster"]; } ?>" required />
                                                     </label>

                                                     <div style="color: red;" id='admin_login_failed'></div>

                                                     <label for="chk_remember" class="rs pb20 clearfix">
                                                         <input name="chk_remember" id="chk_remember" type="checkbox" class="chk-remember" <?php if($_COOKIE["remember_admin_login"]=="admin_remember_saved") { echo "checked"; } ?> />
                                                         <span class="lbl-remember">Remember me</span>
                                                     </label>

                                                     <?php if($schl["recaptcha"] != 1 ){ ?>

                                                     <label class="rs pb20 clearfix">
                                                         <div id="admin1"></div>
                                                     </label>

                                                     <?php } ?>

                                                     <div style="color: red;" id='admin_recaptcha_failed'></div>


                                                     <p class="rs ta-c pb10">
                                                         <button class="btn btn-red btn-submit" type="submit" id="submitBtn" name="action">Login</button>
                                                         <span id="loadingBtn" style="display: none; margin-right: 20px;"><img src="images/loading.gif" width="30px" height="30px"/></span>
                                                     </p>
                                                     <p class="rs ta-c">
                                                         <!-- <a href="#" class="fc-orange">I forgot my password</a> -->
                                                     </p>
                                                 </div>
                                             </div>
                                         </form>
                                     </div>
                                 </div>
                                 <div class="clear"></div>
                             </div>
                         </div>

               
            </div>
       </div>
    </div>

<!--js-->
<?php if($schl["recaptcha"] != 1 ){ ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
<?php } ?>
</body>

</html>
<script src='login_assets/l_hackster.js'></script>
<?php if($schl["recaptcha"] != 1 ){ ?>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
        async defer>
</script>
<?php } ?>
