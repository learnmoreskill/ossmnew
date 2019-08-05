<?php
   include_once('../config/config.php');
   session_start();
   //Dont remove below line
   include_once("nepaliDate.php");
   date_default_timezone_get('Asia/Kathmandu');

   if(isset($_SESSION['login_user_admin'])){
   
       $user_check = $_SESSION['login_user_admin'];
       
       $ses_sql = mysqli_query($db,"SELECT * FROM `principal` WHERE `pemail` = '$user_check' and `status` = 0 ");
       
       $pac = mysqli_fetch_array($ses_sql,MYSQLI_ASSOC);

       $countrow = mysqli_num_rows($ses_sql);
       if($countrow != 1) {
       session_destroy();
       unset($_SESSION['login_user_admin']);
       header("Location: ../index.php");
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



// COMMON SESSION CODE START
   $ses_sql1 = mysqli_query($db,"SELECT * FROM `schooldetails` ");
   
   $row1 = mysqli_fetch_array($ses_sql1,MYSQLI_ASSOC); 
   //mysqli_close($db);  

   $LOGIN_SCHOOL_ID = $row1['school_id'];
   $LOGIN_SCHOOL_NAME = $row1['school_name'];
   $LOGIN_SCHOOL_CODE = $row1['school_code'];
   $LOGIN_SCHOOL_ADDRESS = $row1['school_address'];
   $LOGIN_SCHOOL_SLOGAN = $row1['slogan'];
   $LOGIN_SCHOOL_LOGO = $row1['slogo'];
   $LOGIN_SCHOOL_PAN_NO = $row1['pan_no'];
   $LOGIN_SCHOOL_PHONE_NO = $row1['phone_no'];
   $LOGIN_SCHOOL_PHONE_2 = $row1['phone_2'];
   $LOGIN_SCHOOL_EMAIL_ID = $row1['email_id'];
   $LOGIN_SCHOOL_ESTD = $row1['estd'];
   $LOGIN_SCHOOL_RESERVED_DATE = $row1['reserved_date'];

   $LOGIN_SCHOOL_FACEBOOK = $row1['facebook'];
   $LOGIN_SCHOOL_TWITTER = $row1['twitter'];
   $LOGIN_SCHOOL_INSTAGRAM = $row1['instagram'];
   $LOGIN_SCHOOL_YOUTUBE = $row1['youtube'];

   $LOGIN_SCHOOL_RECAPTCHA = $row1['recaptcha'];
   $LOGIN_SCHOOL_LANG = $row1['lang'];

   $LOGIN_SCHOOL_ACCOUNT = $row1['account_folder'];

   $LOGIN_BULKSMSTOKEN = $row1['sms_token'];

   $login_session_a = $row1['school_name'];
   $login_session_b = $row1['school_code'];
   $login_session_c = $row1['school_address'];
   $login_session_d = $row1['slogo'];
   $login_session_e = $row1['pan_no'];
   $login_session_f = $row1['phone_no'];
   $login_session_g = $row1['estd'];
   $login_session_h = $row1['reserved_date'];

   $login_date_type = $row1['date_type'];


   $login_session_bulksmstoken = $row1['sms_token'];  

   if ($row1['lang'] == "english") {
    require_once("../../languages/english.php");
   }else if ($row1['lang'] == "nepali") {
    require_once("../../languages/nepali.php");
   }else{
    require_once("../../languages/english.php");
   }


    //get current nepali date
    require_once("../../important/nepali_calendar.php");

   
      $calendar = new Nepali_Calendar();
      $cal = $calendar->eng_to_nep(date('Y'), date('m'), date('d'));

         if($login_date_type==2){
            $login_today_date = $cal['year'] . '-' . sprintf("%02d", $cal['month']) . '-' . sprintf("%02d", $cal['date']);
         }else{
            $login_today_date = date("Y-m-d");
         }
         
    $login_today_edate = date("Y-m-d");

    function nToE($nDate){
     list($n_year, $n_month, $n_day) = explode('-', $nDate);
     
     $calendar = new Nepali_Calendar();
     $cal = $calendar->nep_to_eng($n_year, sprintf("%02d", $n_month), sprintf("%02d", $n_day));
     $edate = $cal['year'] . '-' . sprintf("%02d", $cal['month']) . '-' . sprintf("%02d", $cal['date']);

     return $edate;
   }

   function eToN($eDate){
     list($e_year, $e_month, $e_day) = explode('-', $eDate);

     $calendar = new Nepali_Calendar();
     $cal = $calendar->eng_to_nep($e_year, sprintf("%02d", $e_month), sprintf("%02d", $e_day));
     $ndate = $cal['year'] . '-' . sprintf("%02d", $cal['month']) . '-' . sprintf("%02d", $cal['date'])  ;

     return $ndate;
   }



    if (isset($_SESSION['current_year_session_id']) && isset($_SESSION['current_year_session']) ) {
      $current_year_session_id = $_SESSION['current_year_session_id'];
      $current_year_session = $_SESSION['current_year_session'];
    }else{

      $c_n_year = $cal['year'];

      $ses_sql_date = mysqli_query($db,"SELECT `id`,`year` FROM `academic_year` WHERE `single_year` = '$c_n_year'");

      $row_seesion_date = mysqli_fetch_array($ses_sql_date,MYSQLI_ASSOC);

      if (!empty($row_seesion_date['id'])) {
        $current_year_session_id = $row_seesion_date['id'];
        $current_year_session = $row_seesion_date['year'];
      }else{

        $ses_sql_date_max = mysqli_query($db,"SELECT `id`,`year` FROM `academic_year` ORDER BY `id` DESC LIMIT 1");

        $row_seesion_date_max = mysqli_fetch_array($ses_sql_date_max,MYSQLI_ASSOC);

        $current_year_session_id = $row_seesion_date_max['id'];
        $current_year_session = $row_seesion_date_max['year'];

      }
    }

// COMMON SESSION CODE END

   if ($row1['account_folder'] != 'fee_manage') {
          header("location:login.php");
      }	
   
  if(isset($_SESSION['login_user_admin']) OR isset($_SESSION['login_user_accountant']) OR isset($_SESSION['login_user_manager'])){
   }else{
      header("location:login.php");
   }
?>