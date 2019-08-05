<?php

   date_default_timezone_set('Asia/Kathmandu');

   require('../config/config.php');
   session_start();

    if(isset($_SESSION['login_user_admin'])){
   
       $user_check = $_SESSION['login_user_admin'];
       
       $ses_sql = mysqli_query($db,"SELECT * FROM `principal` WHERE `pemail` = '$user_check' and `status` = 0 ");
       
       $pac = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

       $countrow = mysqli_num_rows($ses_sql);
       if($countrow != 1) {
       session_destroy();
       unset($_SESSION['login_user_admin']);
       header("Location: ../index.php#admin");
       exit();
        }
       //mysqli_close($db);
       
       $LOGIN_CAT = $login_cat = 1;

       $LOGIN_ID = $login_session1 = $pac['pid'];
       $LOGIN_NAME = $login_session2 = $pac['pname'];
       $LOGIN_EMAIL = $login_session3 = $pac['pemail'];
       $LOGIN_NAME = $login_session5 = $pac['aimage'];
       $LOGIN_SEX = $login_session8 = $pac['p_gender'];
       $LOGIN_MOBILE = $login_session9 = $pac['p_mobile'];





    }else if(isset($_SESSION['login_user_manager'])){

      $user_check = $_SESSION['login_user_manager'];
       
       $ses_sql = mysqli_query($db,"SELECT * FROM `staff_tbl` 
                  LEFT JOIN `permission` ON `staff_tbl`.`stid` = `permission`.`t_id` 
                                        AND `permission`.`t_role` = 5
                  WHERE `staff_email` = '$user_check' and `staff_status` = 0 ");
       
       $pac = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

       $countrow = mysqli_num_rows($ses_sql);
       if($countrow != 1) {
       session_destroy();
       unset($_SESSION['login_user_manager']);
       header("Location: ../index.php#manager"); 
       exit();
        }
       //mysqli_close($db);
       
       $LOGIN_CAT = $login_cat = 5;

       $LOGIN_ID = $login_session1 = $pac['stid'];
       $LOGIN_NAME = $login_session2 = $pac['staff_name'];
       $LOGIN_EMAIL = $login_session3 = $pac['staff_email'];
       $LOGIN_IMAGE = $login_session5 = $pac['staff_image'];
       $LOGIN_SEX = $login_session8 = $pac['staff_sex'];
       $LOGIN_MOBILE = $login_session9 = $pac['staff_mobile'];

    }



  require('../linker/sessionCommon.php');


   
   /*if(!isset($_SESSION['login_user_admin'])){
      header("location:login.php");
   }*/

   if(isset($_SESSION['login_user_admin']) || isset($_SESSION['login_user_manager'])){
   }else{
      header("location:login.php");
   }

?>
