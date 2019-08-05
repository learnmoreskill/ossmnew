<?php
include('session.php');
require("../important/backstage.php");
require("../important/compress.php");
$msg="";
$errMsg = '';
$errMsgArray  = array();

$backstage = new back_stage_class();
$compress = new compress_class();

$newdate = date("Y-m-d");

if($_SERVER['REQUEST_METHOD']=='POST') {
/*================================= update academic info script==========================================*/
	if (isset($_POST['schoolname'])) {


            $schoolname=$_POST['schoolname'];
            $schooladdress=$_POST['schooladdress'];
            $slogan=$_POST['slogan'];
            $phone_no1=$_POST['phone_no1'];
            $phone_no2=$_POST['phone_no2'];
            $email=$_POST['email'];
            $estd=$_POST['estd'];
            $panno=$_POST['panno'];
            $facebook=$_POST['facebook'];
            $twitter=$_POST['twitter'];
            $instagram=$_POST['instagram'];
            $youtube=$_POST['youtube'];
            $school_id=$_POST['school_id'];

            $lang=$_POST['lang'];
            $recaptcha=$_POST['recaptcha'];
            

            if (!empty($schoolname)){
             if(!empty($schooladdress)){
              if(!empty($phone_no1)){
                if(!empty($estd)){
                 if(!empty($panno)){

                	if (empty($phone_no2)) { $phone_no2=''; }
                  if (empty($slogan)) { $slogan=''; }
                  if (empty($email)) { $email=''; }
                  if (empty($facebook)) { $facebook=''; }
                  if (empty($twitter)) { $twitter=''; }
                  if (empty($instagram)) { $instagram=''; }
                  if (empty($youtube)) { $youtube=''; }

                  if (trim($recaptcha)=='true') { $recaptcha=0; } else{ $recaptcha=1; }


                    $updateacademic = "UPDATE `schooldetails` SET `school_name`='$schoolname',`school_address`='$schooladdress',`estd`='$estd',`pan_no`='$panno',`phone_no`='$phone_no1',`phone_2`='$phone_no2',`email_id`='$email',`facebook`='$facebook',`twitter`='$twitter',`instagram`='$instagram',`youtube`='$youtube',`lang`='$lang',`slogan`='$slogan', `recaptcha`='$recaptcha' WHERE `school_id`='$school_id'";

                    if(mysqli_query($db, $updateacademic)) { 
                      $msg= "Academic information succesfully updated"; 
                    }else{ 
                      $msg= "Sorry, Failed to update..Please try again.." . mysqli_error($db); 
                    }

            }else{ $msg="Please type pan no";  }
            }else{ $msg="Please please type Estd.";  }
        	  }else{ $msg="Please type phone number";  }
            }else{ $msg="please type school address";  }
            }else{ $msg="Please type school name";  }              

        $_SESSION['result_success']=$msg;
        echo $msg;  
  }
/*================================= update academic exam script==========================================*/
	else if (isset($_POST['update_examtype_request'])) {

      $examtype_id = $_POST['update_examtype_id'];
      $examtype_name = $_POST['examtype_name'];
      $self_include = $_POST['self_include'];
      $is_monthly = $_POST['is_monthly'];
      $year_id = $_POST['year_id'];

      if (empty($examtype_name)) {
        array_push($errMsgArray,"Please type exam name");
      }
      if ($self_include) { $self_include = 1; }else{  $self_include=0;  }
      if ($is_monthly) { $is_monthly = 1; }else{  $is_monthly = 0;  }
      

      if (empty($errMsgArray)) {


        if ($examtype_id) {

          if(mysqli_query($db, "UPDATE `examtype` SET `examtype_name`='$examtype_name',`self_include`='$self_include',`is_monthly`='$is_monthly',`year_id`='$year_id' WHERE `examtype_id` = '$examtype_id'" )) {

            }else{
              array_push($errMsgArray,'ERROR: Could not able to execute -'. mysqli_error($db));
            }
          
        }else{

            if(mysqli_query($db, "INSERT INTO `examtype`(`examtype_name`, `self_include`, `is_monthly`, `year_id`) VALUES ('$examtype_name' , '$self_include' , '$is_monthly' ,'$year_id')" )) {

            }else{
              array_push($errMsgArray,'ERROR: Could not able to execute -'. mysqli_error($db));
            }

        }

        if (empty($errMsgArray)) {
          $response["status"] = 200;
          $response["message"] = "Success";
        }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = $errMsgArray;
        } 


      }else{

      $response["status"] = 202;
      $response["message"] = "Failed";
      $response["errormsg"] = $errMsgArray;

      }
                    
     echo json_encode($response);
    }
/*================================= update staff script==========================================*/
  else  if (isset($_POST['update_staff'])) {

          $stid=$_POST['stid'];
          $stname=$_POST['stname'];
          $stemail=$_POST['stemail'];
          $staddress=$_POST['staddress'];
          $stmobile=$_POST['stmobile'];
          $stphone=$_POST['stphone'];
          $stsex=$_POST['stsex'];
          $stmstatus=$_POST['stmstatus'];
          $stdoj=$_POST['stdoj'];
          $stdob=$_POST['stdob'];
          $stsalary=$_POST['stsalary'];
          $stcountry=$_POST['stcountry'];
          $stfather=$_POST['stfather'];
          $stmother=$_POST['stmother'];
          $sttype=$_POST['sttype'];
          $stpos=$_POST['stpos'];
          $stother=$_POST['stother'];
          $blood_group=$_POST['blood_group'];

          $dob = $stdob;
          $doj = $stdoj;
          
          if(!empty($sttype)) {
          if(($sttype=='Other') && empty($stother)) { $msg = "Please enter staff details for other type.."; }else{
          if (!empty($stname)) {
            if(!empty($staddress)) {
               if(!empty($stmobile)) {

                if(!empty($stcountry)) {
                  if(!empty($stsex)) {
                    if(!empty($stmstatus)) {

                      if($login_date_type==2){
                        if(!empty($dob)){ $dob = nToE($dob); }
                        if(!empty($doj)){ $doj = nToE($doj); }
                      }

                    if (empty($stsalary)) { $stsalary=0; }
                    if (empty($dob)) { $dob="0000-00-00"; }
                    if (empty($doj)) { $doj="0000"; }
                    if (empty($stphone)) { $stphone=''; }
                    if (empty($stfather)) { $stfather=''; }
                    if (empty($stmother)) { $stmother=''; }
                    if (empty($stpos)) { $stpos=''; }
                    if (empty($blood_group)) { $blood_group=0; }

                    if($sttype!='Other') { $stother='';}

                    if (strlen($stmobile)!=10) { $errMsg="Mobile number should be 10 digit long"; }

                    if(!empty($stemail)){
                      if (!filter_var($stemail, FILTER_VALIDATE_EMAIL)) {
                        $errMsg = "Invalid email format"; 
                      }else{
                        $checkexist = $backstage->check_staff_email_exist_except_id($stemail,$stid);
                        if ($checkexist) { 
                          $errMsg="Email id already exist with another account";
                        }
                      }
                    }else{ $stemail=''; }

                    if(empty($errMsg))
                    { 

                      $updatestaff = "UPDATE `staff_tbl` SET `staff_name`='$stname',`staff_address`='$staddress',`staff_mobile`='$stmobile',`staff_type`='$sttype',`staff_typedesc`='$stother',`staff_salary`='$stsalary',`staff_email`='$stemail',`staff_phone`='$stphone',`staff_sex`='$stsex',`staff_position`='$stpos',`staff_marital`='$stmstatus',`staff_dob`='$dob',`blood_group`='$blood_group',`staff_father`='$stfather',`staff_mother`='$stmother',`staff_country`='$stcountry',`staff_joindate`='$doj' WHERE `stid`='$stid'";
                          
                          if(mysqli_query($db, $updatestaff)) {  
                              //echo inserted
                              $msg= "Staff succesfully updated";                  

                          } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db); }
                          
                    }else{  $msg = $errMsg;  }
                  }else{ $msg = "please select marital status.."; }
                }else{ $msg = "please select gender.."; }
              }else{ $msg = "please enter nationality name.."; }
            }else{ $msg = "please enter mobile number.."; }
          }else{ $msg = "Please enter teacher address.."; }
        }else{ $msg = "Please enter teacher name.."; }
      }
        }else{ $msg = "please select staff type.."; }
                
      $_SESSION['result_success']=$msg;
      echo $msg;   
  }
/*================================= update teacher script==========================================*/
  else if (isset($_POST['update_teacher'])) {

          $tid=$_POST['teacher_id'];
          $tname=$_POST['name'];
          $temail=$_POST['email'];
          $taddress=$_POST['address'];
          $tmobile=$_POST['mobile'];
          $tphone=$_POST['phone'];
          $tsex=$_POST['sex'];
          $m_status=$_POST['m_status'];

          $designation=$_POST['designation'];
          $blood_group=$_POST['blood_group'];

          $doj=$_POST['doj'];
          $dob=$_POST['dob'];
          $tsalary=$_POST['tsalary'];
          $tcountry=$_POST['tcountry'];
          $tfather=$_POST['tfather'];
          $tmother=$_POST['tmother'];
          $tjobtype=$_POST['tjobtype'];

          if (!empty($tname)) {
            if(!empty($taddress)) {
               if(!empty($tmobile)) {
                if(!empty($tcountry)) {
                  if(!empty($tsex)) {
                    if(!empty($m_status)) {

                      if($login_date_type==2){
                        if(!empty($doj)){
                          $doj = nToE($doj);
                        }
                        if(!empty($dob)){
                          $dob = nToE($dob);
                        }
                      }

                    if (empty($tsalary)) { $tsalary=0; }
                    if (empty($tjobtype)) { $tjobtype='Full Time'; }
                    if (empty($dob)) { $dob="0000-00-00"; }
                    if (empty($doj)) { $doj="0000-00-00"; }
                    if (empty($tphone)) { $tphone=''; }
                    if (empty($tfather)) { $tfather=''; }
                    if (empty($tmother)) { $tmother=''; }
                    if (empty($designation)) { $designation=''; }
                    if (empty($blood_group)) { $blood_group=0; }

                    
                    if (strlen($tmobile)!=10) { $errMsg="Mobile number should be 10 digit long"; }

                    if(!empty($temail)){
                      if (!filter_var($temail, FILTER_VALIDATE_EMAIL)) {
                        $errMsg = "Invalid email format"; 
                      }else{
                        $checkexist = $backstage->check_teacher_email_exist_except_id($temail,$tid);
                        if ($checkexist) { 
                          $errMsg="Email id already exist with another account";
                        }
                      }
                    }else{ $temail=''; }

                    if(empty($errMsg))
                    { 

                      $updateteacher = "UPDATE `teachers` SET `tname`='$tname',`temail`='$temail',`taddress`='$taddress',`tmobile`='$tmobile',`sex`='$tsex',`dob`='$dob',`designation`='$designation',`blood_group`='$blood_group',`t_father`='$tfather',`t_mother`='$tmother',`t_country`='$tcountry',`t_phone`='$tphone',`t_marital`='$m_status',`t_join_date`='$doj',`tsalary`='$tsalary',`t_jobtype`='$tjobtype' WHERE `tid`='$tid'";
                          
                          if(mysqli_query($db, $updateteacher)) { $msg= "Teacher succesfully updated"; } 
                          else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db); }
                    }else{  $msg = $errMsg;  }
                  }else{ $msg = "please select marital status.."; }
                }else{ $msg = "please select gender.."; }
              }else{ $msg = "please enter nationality name.."; }
            }else{ $msg = "please enter mobile number.."; }
          }else{ $msg = "Please enter teacher address.."; }
        }else{ $msg = "Please enter teacher name.."; }
                
      //$_SESSION['result_success']=$msg;
      echo $msg; 
  }

/*================================= update student script==========================================*/
  else if (isset($_POST['update_student'])) {
      $errMSG='';

    $syear_id = mysqli_real_escape_string($db,$_POST['syear_id']);

    $spid = mysqli_real_escape_string($db,$_POST['spid']);
    $id = mysqli_real_escape_string($db,$_POST['stdid']);
    $sname = mysqli_real_escape_string($db,$_POST['sname']);
    $saddress = mysqli_real_escape_string($db,$_POST['saddress']);
    $smobile = mysqli_real_escape_string($db,$_POST['smobile']);
    $sclass = mysqli_real_escape_string($db,$_POST['sclass']);
    $ssec = mysqli_real_escape_string($db,$_POST['ssec']);
    $scaste = mysqli_real_escape_string($db,$_POST['scaste']);
    $semail = mysqli_real_escape_string($db,$_POST['semail']);
    $blood_group = mysqli_real_escape_string($db,$_POST['blood_group']);
    $ssex = mysqli_real_escape_string($db,$_POST['ssex']);
    $admission_date=mysqli_real_escape_string($db,$_POST['admissiondate']);
    $dob = mysqli_real_escape_string($db,$_POST['sdob']);
    $payment_type = $_POST['payment_type'];

    $studentbusid=mysqli_real_escape_string($db,$_POST['studentbusid']);

    $tution_checked = $_POST['tution_checked'];
    $hostel_checked = $_POST['hostel_checked'];
    $computer_checked = $_POST['computer_checked'];

    if ($tution_checked == "on") {
      $tution = 1;
      $tution_fee = mysqli_real_escape_string($db,$_POST['tution_fee']);
      if (empty($tution_fee) || $tution_fee=='0') { $tution_fee=0.0; }
    }else{
      $tution = 0;
      $tution_fee = 0;
    }
    if ($hostel_checked == "on") {
      $hostel = 1;
      $hostel_fee = mysqli_real_escape_string($db,$_POST['hostel_fee']);
      if (empty($hostel_fee) || $hostel_fee=='0') { $hostel_fee=0.0; }
    }else{
      $hostel = 0;
      $hostel_fee = 0;
    }
    if ($computer_checked == "on") {
      $computer = 1;
      $computer_fee = mysqli_real_escape_string($db,$_POST['computer_fee']);
      if (empty($computer_fee) || $computer_fee=='0') { $computer_fee=0.0; }
    }else{
      $computer = 0;
      $computer_fee = 0;
    }
    if (!empty($studentbusid)) { 
      $bus_fee = mysqli_real_escape_string($db,$_POST['bus_fee']);
      if (empty($bus_fee) || $bus_fee=='0') { $bus_fee=0.0; }
    }else{
      $studentbusid=0; 
      $bus_fee=0.0;
    }

    // if (!empty($spid)){
      if (!empty($id)){
        if (!empty($sname)){
          if(!empty($saddress)){
            if(!empty($sclass)){
              if(!empty($ssec)){ 
                  if (!empty($ssex)){
                    if (!empty($admission_date)){
                      if (!empty($dob)){
                        if (isset($payment_type)){

                          if($login_date_type==2){
                            if(!empty($admission_date)){
                              $admission_date = nToE($admission_date);
                            }
                              $dob = nToE($dob);
                          }

                          if (empty($spid)) { $spid=0; }
                          if (empty($scaste)) { $scaste='General'; }
                          if (empty($blood_group)) { $blood_group=0; }

                      if (is_numeric($tution_fee) || $tution_fee>=0 ) {
                      if (is_numeric($hostel_fee) || $hostel_fee>=0 ) {
                      if (is_numeric($computer_fee) || $computer_fee>=0 ) {
                      if (is_numeric($bus_fee) || $bus_fee>=0 ) {

                      if(!empty($smobile)){
                        if (strlen($smobile)!=10) { $errMSG="Mobile number should be 10 digit long"; }
                        }else{ $smobile=""; }

                      if(!empty($semail)){
                        if (!filter_var($semail, FILTER_VALIDATE_EMAIL)) {
                          $errMSG = "Invalid email format"; 
                        }else{
                          $checkexist = $backstage->check_student_email_exist_except_id($semail,$id);
                          if ($checkexist) { 
                            $errMSG="Email id already exist with another account";
                          }
                        }
                      }else{ $semail=""; }
          if(empty($errMSG))
                { 

     $sqlupdatestudent = $db->query("UPDATE `studentinfo` SET `sname`  = '$sname', `saddress`  = '$saddress', `semail`  = '$semail',`sclass`= '$sclass',`ssec`= '$ssec', `admission_date`='$admission_date', `sex`  = '$ssex', `dob`  = '$dob', `blood_group`  = '$blood_group',`caste`= '$scaste', `smobile`  = '$smobile', `payment_type` = '$payment_type', `tution` = '$tution', `tution_fee` = '$tution_fee', `bus_id`= '$studentbusid', `bus_fee` = '$bus_fee',`hostel` = '$hostel', `hostel_fee` = '$hostel_fee',`computer` = '$computer', `computer_fee` = '$computer_fee' , `sparent_id`= '$spid' WHERE `sid`  = '$id'");


   if($sqlupdatestudent){
   
    $backstage->update_student_details_in_student_history_by_syear_id($syear_id,$sclass,$ssec,$payment_type,$tution,$tution_fee,$studentbusid,$bus_fee,$hostel,$hostel_fee,$computer,$computer_fee);

    $msg= "Student succesfully updated";
   }else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db); }

   } else{ $msg=$errMSG; }

    }else{ $msg="Bus fee is not in valid format";  }
    }else{ $msg="Computer fee is not in valid format";  }
    }else{ $msg="Hostel fee is not in valid format";  }
    }else{ $msg="Tution fee is not in valid format";  }

    }else{ $msg="Please select payment type";  }
    }else{ $msg="Please enter date of birth";  }
    }else{ $msg="Please enter admission date";  }
    }else{ $msg="Please select gender..";  }
    }else{ $msg="Please select section";  }
    }else{ $msg="please select class";  }
    }else{ $msg="Please enter address";  }  
    }else{ $msg="Please enter student name";  }

    }else{ $msg="Student details is not passing";  }
    // }else{ $msg="Please select student's parent";  }  
                  
      $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= update Parent script==========================================*/
  else if (isset($_POST['update_parent'])) {

    $errMsg = '';

    $parentid = mysqli_real_escape_string($db,$_POST['parentid']);
    $spname = mysqli_real_escape_string($db,$_POST['spname']);
    $smname = mysqli_real_escape_string($db,$_POST['smname']);
    $spprof = mysqli_real_escape_string($db,$_POST['spprof']);
    $spemail = mysqli_real_escape_string($db,$_POST['spemail']);
    $spnumber = mysqli_real_escape_string($db,$_POST['spnumber']);
    $spnumber2 = mysqli_real_escape_string($db,$_POST['spnumber2']);
    $spaddress = mysqli_real_escape_string($db,$_POST['spaddress']);

      if (!empty($spname) || !empty($smname)){
        if (!empty($spprof)){
          if(!empty($spnumber)){
            if(!empty($spaddress)){

              if (empty($spname)) { $spname=''; }
              if (empty($smname)) { $smname=''; }
              if (empty($spprof)) { $spprof=''; }
              if (empty($spaddress)) { $spaddress=''; }

              if(!empty($spnumber)){
                if (strlen($spnumber)!=10) { $errMsg="Mobile number should be 10 digit long"; }
                }else{ $spnumber=''; }

              if(!empty($spnumber2)){
                if (strlen($spnumber2)!=10) { $errMsg="Mobile number should be 10 digit long"; }
                }else{ $spnumber2=''; }

              if(!empty($spemail)){
                if (!filter_var($spemail, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
                }else{
                  $checkexist = $backstage->check_parent_email_exist_except_id($spemail,$parentid);
                  if ($checkexist) { 
                    $errMsg="Email id already exist with another account";
                  }
                }
              }else{ $spemail=''; }

      if(empty($errMsg))
      { 

        $sqlupdateparent = $db->query("UPDATE `parents` SET `spname`='$spname',`smname`='$smname',`spemail`='$spemail',`spnumber`='$spnumber',`spnumber_2`='$spnumber2',`spprofession`='$spprof',`sp_address`='$spaddress' WHERE `parent_id`='$parentid'");


        if($sqlupdateparent){
          $msg= "Parent succesfully updated";
        }else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db); }

      }else{  $msg = $errMsg;  }

    }else{ $msg="Please enter address";  }
    }else{ $msg="Please enter mobile number";  }
    }else{ $msg="please enter profession";  }
    }else{ $msg="Please enter father's name or mother's name or both";  }  
                  
       /* $_SESSION['result_success']=$msg;*/
        echo $msg; 
  }
/*================================= update school logo script==========================================*/
  else if (isset($_POST['update_school_logo'])) {

      $errMsg='';

        $schoolid = mysqli_real_escape_string($db,$_POST['schoolid']);

        $uFile = $_FILES['ac_logo']['name'];
        $tmp_dir = $_FILES['ac_logo']['tmp_name'];
        $fileSize = $_FILES['ac_logo']['size'];

        $upload_dir = '../uploads/'.$fianlsubdomain.'/logo/'; // upload directory

        if(!empty($uFile)){

        $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION)); // get file extension
        $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions

        if(!in_array($fileExt, $valid_extensions)){ $errMsg="Sorry, only JPG, JPEG, PNG , GIF files are allowed."; }else{ 

          if($fileSize > 2000000) { $errMsg="Logo size is more than 2MB"; }else{ 
            $ufile="logo.".$fileExt; //rename logo name

                $schoollogosql = "SELECT `slogo` FROM `schooldetails` WHERE `school_id`='$schoolid'";
                      $resultschoollogo= mysqli_query($db, $schoollogosql);
                      $rowlogo = mysqli_fetch_assoc($resultschoollogo);

                      if ($rowlogo['slogo']) {
                        $imagepath=$upload_dir.$rowlogo['slogo'];


                        if (@getimagesize($imagepath)) {
                         if(unlink($imagepath)){
                          if(move_uploaded_file($tmp_dir,$upload_dir.$ufile)){

                          }else{$errMsg="Failed to store in server";}
                         }else{$errMsg="failed to write on server";}                        
                        } else {
                          if(move_uploaded_file($tmp_dir,$upload_dir.$ufile)){

                          }else{$errMsg="Failed to store in server";}
                        }


                      }else{
                        if(move_uploaded_file($tmp_dir,$upload_dir.$ufile)){

                              }else{$errMsg="Failed to store in server..";}
                        }
                      }
                    }

        }else{ $errMsg="Picture is not selected"; }

                        if(empty($errMsg)){
                        $sqlupdateprofile = $db->query("UPDATE `schooldetails` SET `slogo`='$ufile' WHERE `school_id`='$schoolid'");

                        if($sqlupdateprofile){
                          $msg="School logo updated";
                        }else{ $msg="Failed to save in database"; }
                      }else{$msg=$errMsg;}                   
                      
    
       $_SESSION['result_success']=$msg;
        echo $msg; 
  }
/*================================= delete school logo script==========================================*/
  else if (isset($_POST['delete_school_logo'])) {

      $errMsg='';
      $schoolid = mysqli_real_escape_string($db,$_POST['schoolid']);
      $upload_dir = '../uploads/'.$fianlsubdomain.'/logo/'; // upload directory

              $logosql = "SELECT * FROM `schooldetails` WHERE `school_id`='$schoolid'";
                    $resultlogo= mysqli_query($db, $logosql);
                    $rowlogo = mysqli_fetch_assoc($resultlogo);

                    if ($rowlogo['slogo']) {
                      $imagepath=$upload_dir.$rowlogo['slogo'];

                      if (@getimagesize($imagepath)) {
                        if(unlink($imagepath)){

                        }else{ $errMsg="failed to delete"; }
                      }

                      if(empty($errMsg)){
                        $sqlupdateprofile = $db->query("UPDATE `schooldetails` SET `slogo`='$ufile' WHERE `school_id`='$schoolid'");

                      if($sqlupdateprofile){
                        $msg="School logo deleted";
                      }else{ $msg="Failed delete.."; }

                      }else{  $msg=$errMsg; }
                    }else{  $msg="already deleted.."; }
     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= update admin profile picture script========================================*/
  else if (isset($_POST['update_admin_profile'])) {

      $errMsg='';

      $adminid = mysqli_real_escape_string($db,$_POST['adminid']);


      $img1 = $_FILES['file1'];
      $img2 = $_POST['file2'];
      $image = '';

      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory
                      
      $imageName = "principal".$adminid;

      $resultdp= mysqli_query($db, "SELECT `aimage` FROM `principal` WHERE `pid`='$adminid'");
      $rowimage = mysqli_fetch_assoc($resultdp);
      $oldimage = $rowimage['aimage']; //old image name without path


      if(!empty($img1['name'])){

        $imgupload= $compress->compress_image_update($img1,$upload_dir ,$imageName , 75, $oldimage);

          if($imgupload['code'] == 200){
            $image = $imgupload['image'];

          }else{
            array_push($errMsgArray,$imgupload['message']);
          }

      }else if (!empty($img2)) {

              $imgupload= $compress->upload_base64_update($img2,$upload_dir ,$imageName, $oldimage);

             if($imgupload['code'] == 200){
              $image = $imgupload['image'];

              }else{
                array_push($errMsgArray,$imgupload['message']);
              }


      }else{ 
        array_push($errMsgArray,"Picture is not selected");
      }

      if (empty($errMsgArray)) {

        $sqlupdateprofile = $db->query("UPDATE `principal` SET `aimage`='$image' WHERE `pid`='$adminid'");

        if($sqlupdateprofile){
        
        } else {
           array_push($errMsgArray,'ERROR: Incomplete Procedure -'. mysqli_error($db));
        }

        if (empty($errMsgArray)) {
          $response["status"] = 200;
          $response["message"] = "Success";
        }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = $errMsgArray;
        } 


      }else{

        $response["status"] = 201;
        $response["message"] = "Failed";
        $response["errormsg"] = $errMsgArray;

      }                   
                    
     echo json_encode($response);
    }

/*================================= delete admin profile picture script========================================*/
  else if (isset($_POST['delete_admin_profile'])) {

      $msg='';
      $errMsg='';
      $adminid = mysqli_real_escape_string($db,$_POST['adminid']);
      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory

              $admindpsql = "SELECT * FROM `principal` WHERE `pid`='$adminid'";
                    $resultadmindp= mysqli_query($db, $admindpsql);
                    $rowlogo = mysqli_fetch_assoc($resultadmindp);

                    if ($rowlogo['aimage']) {
                      $imagepath=$upload_dir.$rowlogo['aimage'];

                      if (@getimagesize($imagepath)) {
                        if(unlink($imagepath)){

                        }else{ $errMsg="failed to delete"; }
                      }

                      if(empty($errMsg)){
                        $sqlupdateprofile = $db->query("UPDATE `principal` SET `aimage`='$ufile' WHERE `pid`='$adminid'");

                      if($sqlupdateprofile){
                        $msg="Profile picture deleted";
                      }else{ $msg="Failed to delete.."; }

                      }else{$msg=$errMsg;}
                    }else{ $msg="already deleted.."; }
     $_SESSION['result_success']=$msg;
      echo $msg; 
    }
/*================================= update teacher profile picture script==================================*/
  else if (isset($_POST['update_teacher_profile'])) {

      $errMsg='';

      $teacherid = mysqli_real_escape_string($db,$_POST['teacherid']);


      $img1 = $_FILES['file1'];
      $img2 = $_POST['file2'];
      $image = '';

      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory
                      
      $imageName = "teacher".$teacherid;

      $resultdp= mysqli_query($db, "SELECT `timage` FROM `teachers` WHERE `pid`='$teacherid'");
      $rowimage = mysqli_fetch_assoc($resultdp);
      $oldimage = $rowimage['timage']; //old image name without path


      if(!empty($img1['name'])){

        $imgupload= $compress->compress_image_update($img1,$upload_dir ,$imageName , 75, $oldimage);

          if($imgupload['code'] == 200){
            $image = $imgupload['image'];

          }else{
            array_push($errMsgArray,$imgupload['message']);
          }

      }else if (!empty($img2)) {

              $imgupload= $compress->upload_base64_update($img2,$upload_dir ,$imageName, $oldimage);

             if($imgupload['code'] == 200){
              $image = $imgupload['image'];

              }else{
                array_push($errMsgArray,$imgupload['message']);
              }


      }else{ 
        array_push($errMsgArray,"Picture is not selected");
      }

      if (empty($errMsgArray)) {

        $sqlupdateprofile = $db->query("UPDATE `teachers` SET `timage`='$image' WHERE `tid`='$teacherid'");

        if($sqlupdateprofile){
        
        } else {
           array_push($errMsgArray,'ERROR: Incomplete Procedure -'. mysqli_error($db));
        }

        if (empty($errMsgArray)) {
          $response["status"] = 200;
          $response["message"] = "Success";
        }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = $errMsgArray;
        } 


      }else{

        $response["status"] = 201;
        $response["message"] = "Failed";
        $response["errormsg"] = $errMsgArray;

      }                   
                    
     echo json_encode($response);
    }

/*================================= delete teacher profile picture script====================================*/
  else if (isset($_POST['delete_teacher_profile'])) {

      $errMsg='';
      $teacherid = mysqli_real_escape_string($db,$_POST['teacherid']);
      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory

              $teacherdpsql = "SELECT * FROM `teachers` WHERE `tid`='$teacherid'";
                    $resultteacherdp= mysqli_query($db, $teacherdpsql);
                    $rowlogo = mysqli_fetch_assoc($resultteacherdp);

                    if ($rowlogo['timage']) {
                      $imagepath=$upload_dir.$rowlogo['timage'];

                      if (@getimagesize($imagepath)) {
                        if(unlink($imagepath)){

                        }else{ $errMsg="failed to delete"; }
                      }

                      if(empty($errMsg)){
                        $sqlupdateprofile = $db->query("UPDATE `teachers` SET `timage`='$ufile' WHERE `tid`='$teacherid'");

                      if($sqlupdateprofile){
                        $msg="Teacher profile picture deleted";
                      }else{ $msg="Failed delete.."; }

                      }else{$msg=$errMsg;}
                    }else{  $msg="already deleted.."; } 
     $_SESSION['result_success']=$msg;
      echo $msg; 
    }
/*================================= update staff profile picture script======================================*/
  else if (isset($_POST['update_staff_profile'])) {

      $errMsg='';

      $staffid = mysqli_real_escape_string($db,$_POST['staffid']);


      $img1 = $_FILES['file1'];
      $img2 = $_POST['file2'];
      $image = '';

      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory
                      
      $imageName = "teacher".$staffid;

      $resultdp= mysqli_query($db, "SELECT `staff_image` FROM `staff_tbl` WHERE `stid`='$staffid'");
      $rowimage = mysqli_fetch_assoc($resultdp);
      $oldimage = $rowimage['staff_image']; //old image name without path


      if(!empty($img1['name'])){

        $imgupload= $compress->compress_image_update($img1,$upload_dir ,$imageName , 75, $oldimage);

          if($imgupload['code'] == 200){
            $image = $imgupload['image'];

          }else{
            array_push($errMsgArray,$imgupload['message']);
          }

      }else if (!empty($img2)) {

              $imgupload= $compress->upload_base64_update($img2,$upload_dir ,$imageName, $oldimage);

             if($imgupload['code'] == 200){
              $image = $imgupload['image'];

              }else{
                array_push($errMsgArray,$imgupload['message']);
              }


      }else{ 
        array_push($errMsgArray,"Picture is not selected");
      }

      if (empty($errMsgArray)) {

        $sqlupdateprofile = $db->query("UPDATE `staff_tbl` SET `staff_image`='$image' WHERE `stid`='$staffid'");

        if($sqlupdateprofile){
        
        } else {
           array_push($errMsgArray,'ERROR: Incomplete Procedure -'. mysqli_error($db));
        }

        if (empty($errMsgArray)) {
          $response["status"] = 200;
          $response["message"] = "Success";
        }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = $errMsgArray;
        } 


      }else{

        $response["status"] = 201;
        $response["message"] = "Failed";
        $response["errormsg"] = $errMsgArray;

      }                   
                    
     echo json_encode($response);
    }      
/*================================= delete staff profile picture script=====================================*/
  else if (isset($_POST['delete_staff_profile'])) {

      $errMsg='';
      $staffid = mysqli_real_escape_string($db,$_POST['staffid']);
      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory

              $staffdpsql = "SELECT * FROM `staff_tbl` WHERE `stid`='$staffid'";
                    $resultstaffdp= mysqli_query($db, $staffdpsql);
                    $rowlogo = mysqli_fetch_assoc($resultstaffdp);

                    if ($rowlogo['staff_image']) {
                      $imagepath=$upload_dir.$rowlogo['staff_image'];

                      if (@getimagesize($imagepath)) {
                        if(unlink($imagepath)){

                        }else{ $errMsg="failed to delete"; }
                      }

                      if(empty($errMsg)){
                        $sqlupdateprofile = $db->query("UPDATE `staff_tbl` SET `staff_image`='$ufile' WHERE `stid`='$staffid'");

                      if($sqlupdateprofile){
                        $msg="Staff profile picture deleted";
                      }else{ $msg="Failed delete.."; }

                      }else{$msg=$errMsg;}
                    }else{  $msg="already deleted.."; } 
     $_SESSION['result_success']=$msg;
      echo $msg; 
    }
/*================================= update student profile picture script====================================*/
  else if (isset($_POST['update_student_profile'])) {

      $errMsg='';

      $studentid = mysqli_real_escape_string($db,$_POST['studentid']);


      $img1 = $_FILES['file1'];
      $img2 = $_POST['file2'];
      $image = '';

      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory
                      
      $imageName = "student".$studentid;

      $resultdp= mysqli_query($db, "SELECT `simage` FROM `studentinfo` WHERE `sid`='$studentid'");
      $rowimage = mysqli_fetch_assoc($resultdp);
      $oldimage = $rowimage['simage']; //old image name without path


      if(!empty($img1['name'])){

        $imgupload= $compress->compress_image_update($img1,$upload_dir ,$imageName , 75, $oldimage);

          if($imgupload['code'] == 200){
            $image = $imgupload['image'];

          }else{
            array_push($errMsgArray,$imgupload['message']);
          }

      }else if (!empty($img2)) {

              $imgupload= $compress->upload_base64_update($img2,$upload_dir ,$imageName, $oldimage);

             if($imgupload['code'] == 200){
              $image = $imgupload['image'];

              }else{
                array_push($errMsgArray,$imgupload['message']);
              }


      }else{ 
        array_push($errMsgArray,"Picture is not selected");
      }

      if (empty($errMsgArray)) {

        $sqlupdateprofile = $db->query("UPDATE `studentinfo` SET `simage`='$image' WHERE `sid`='$studentid'");

        if($sqlupdateprofile){
        
        } else {
           array_push($errMsgArray,'ERROR: Incomplete Procedure -'. mysqli_error($db));
        }

        if (empty($errMsgArray)) {
          $response["status"] = 200;
          $response["message"] = "Success";
        }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = $errMsgArray;
        } 


      }else{

        $response["status"] = 201;
        $response["message"] = "Failed";
        $response["errormsg"] = $errMsgArray;

      }                   
                    
     echo json_encode($response);
    }
/*================================= delete student profile picture script==================================*/
  else if (isset($_POST['delete_student_profile'])) {

      $errMsg='';
      $studentid = mysqli_real_escape_string($db,$_POST['studentid']);
      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory

              $teacherdpsql = "SELECT * FROM `studentinfo` WHERE `sid`='$studentid'";
                    $resultteacherdp= mysqli_query($db, $teacherdpsql);
                    $rowlogo = mysqli_fetch_assoc($resultteacherdp);

                    if ($rowlogo['simage']) {
                      $imagepath=$upload_dir.$rowlogo['simage'];

                      if (@getimagesize($imagepath)) {
                        if(unlink($imagepath)){

                        }else{ $errMsg="failed to delete"; }
                      }

                      if(empty($errMsg)){
                        $sqlupdateprofile = $db->query("UPDATE `studentinfo` SET `simage`='$ufile' WHERE `sid`='$studentid'");

                      if($sqlupdateprofile){
                        $msg="Student profile picture deleted";
                      }else{ $msg="Failed delete.."; }

                      }else{$msg=$errMsg;}
                    }else{  $msg="already deleted.."; } 
     $_SESSION['result_success']=$msg;
      echo $msg; 
    }
/*================================= update admin information script==========================================*/
  else if (isset($_POST['update_admin_info'])) {

      $adminname = mysqli_real_escape_string($db,$_POST['admin_name']);
      $adminemail = mysqli_real_escape_string($db,$_POST['admin_email']);
      $adminsex = mysqli_real_escape_string($db,$_POST['admin_sex']);
      $admin_mobile = mysqli_real_escape_string($db,$_POST['admin_mobile']);

      $pid=$login_session1;

      if (!empty($adminname)) {

      if (!preg_match('/[^A-Za-z0-9_ -]+/', $adminname)) // '/[^a-z\d]/i' should also work.
      {
          


        if (!empty($adminemail)) {
          if (!empty($admin_mobile)) {
          if (!empty($adminsex)) {

            $sqlupdateprofileinfo = $db->query("UPDATE `principal` SET `pname` = '$adminname', `p_gender` = '$adminsex', `pemail`='$adminemail', `p_mobile`= '$admin_mobile' WHERE `pid` ='$pid'");

            if($sqlupdateprofileinfo) {
                      //echo inserted
                      $msg = "Information updated Successfully";                   

                  } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db);
                        }
          }else{ $msg = "Please select your gender"; }
        }else{ $msg = "Please enter your mobile number"; }
        }else{ $msg = "Email field can't be empty"; }
      }else{ $msg = "Name should be in english format"; }
      }else{ $msg = "Please type your name"; }

     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Set Login details For teacher script=======================================*/
  else if (isset($_POST['set_teacher_login_id'])) {

      $teacher_email = mysqli_real_escape_string($db,$_POST['teacher_email']);
      $teacher_password = mysqli_real_escape_string($db,$_POST['teacher_password']);
      $teacher_confirm_password = mysqli_real_escape_string($db,$_POST['teacher_confirm_password']);
      $teacher_id = mysqli_real_escape_string($db,$_POST['set_teacher_login_id']);

      if (!empty($teacher_id)) {
        if (!empty($teacher_email)) {

          $checkexist = $backstage->check_teacher_email_exist_except_id($teacher_email,$teacher_id);
              if ($checkexist) {
                  $errMsg="Email id already exist with another account";
              }elseif (!filter_var($teacher_email, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
              }

              if(empty($errMsg))
              {

                if (!(strlen($teacher_password)<6)) {
                if ($teacher_password==$teacher_confirm_password) {


                  $sqlupdatepteacherlogin = $db->query("UPDATE `teachers` SET `temail` = '$teacher_email', `tgetter` = '$teacher_password' WHERE `tid` ='$teacher_id'");

                  if($sqlupdatepteacherlogin) {
                      //echo inserted
                      $msg = "Login details updated";                   

                  } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db);  }
                }else{ $msg = "Password does not match"; }
                }else{ $msg = "Password is less than 6 charater"; }
              } else{ $msg=$errMsg; }
        }else{ $msg = "Email field can't be empty"; }
      }else{ $msg = "Some error occurred in teacher details"; }

     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Disable teacher login script==========================================*/
  else if (isset($_POST['disable_teacher_login'])) {

      $teacherid = mysqli_real_escape_string($db,$_POST['disable_teacher_login']);

      if (!empty($teacherid)) {
        $teacher_password='';
        $sqlupdatepteacherlogin = $db->query("UPDATE `teachers` SET `tgetter` = '$teacher_password' WHERE `tid` ='$teacherid'");

            if($sqlupdatepteacherlogin) { $msg = "Teacher Login Disabled";  
          } else { $msg = "Sorry, Failed to disable login - " . mysqli_error($db); }
      }else{ $msg = "Some error occurred in teacher details"; }
     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Set Login details For Student script=======================================*/
  else if (isset($_POST['set_student_login_id'])) {

      $errMSG='';
      $student_email = mysqli_real_escape_string($db,$_POST['student_email']);
      $student_password = mysqli_real_escape_string($db,$_POST['student_password']);
      $student_confirm_password = mysqli_real_escape_string($db,$_POST['student_confirm_password']);
      $student_id = mysqli_real_escape_string($db,$_POST['set_student_login_id']);

      if (!empty($student_id)) {
        if (!empty($student_email)) {

              $checkexist = $backstage->check_student_email_exist_except_id($student_email,$student_id);
              if ($checkexist) {
                  $errMSG="Email id already exist with another account";
              }elseif (!filter_var($student_email, FILTER_VALIDATE_EMAIL)) {
                  $errMSG = "Invalid email format"; 
              }

              if(empty($errMSG))
              {

                if (!(strlen($student_password)<6)) {
                  if ($student_password==$student_confirm_password) {


                    $sqlstudentlogin = $db->query("UPDATE `studentinfo` SET `semail` = '$student_email', `sgetter` = '$student_password' WHERE `sid` ='$student_id'");

                    if($sqlstudentlogin) {
                      //echo inserted
                      $msg = "Login details updated";                   

                    } else { $msg = "Sorry, Failed to update- " . mysqli_error($db);
                        }
                  }else{ $msg = "Password does not match"; }
                }else{ $msg = "Password is less than 6 charater"; }

              } else{ $msg=$errMSG; }

        }else{ $msg = "Email field can't be empty"; }
      }else{ $msg = "Some error occurred in student details"; }

     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Disable student login script==========================================*/
  else if (isset($_POST['disable_student_login'])) {

      $studentid = mysqli_real_escape_string($db,$_POST['disable_student_login']);

      if (!empty($studentid)) {
        $student_password='';
        $sqlupdatepstudentlogin = $db->query("UPDATE `studentinfo` SET `sgetter` = '$student_password' WHERE `sid` ='$studentid'");

            if($sqlupdatepstudentlogin) { $msg = "Student Login Disabled";  
          } else { $msg = "Sorry, Failed to disable - " . mysqli_error($db); }
      }else{ $msg = "Some error occurred in student details"; }
     $_SESSION['result_success']=$msg;
      echo $msg; 
  }

/*================================= Set Login details For parent script====================================*/
  else if (isset($_POST['set_parent_login_id'])) {

      $errMsg='';

      $parent_email = mysqli_real_escape_string($db,$_POST['parent_email']);
      $parent_password = mysqli_real_escape_string($db,$_POST['parent_password']);
      $parent_confirm_password = mysqli_real_escape_string($db,$_POST['parent_confirm_password']);
      $parent_id = mysqli_real_escape_string($db,$_POST['set_parent_login_id']);

      if (!empty($parent_id)) {
        if (!empty($parent_email)) {

              $checkexist = $backstage->check_parent_email_exist_except_id($parent_email,$parent_id);
              if ($checkexist) {
                  $errMsg="Email id already exist with another account";
              }elseif (!filter_var($parent_email, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
              }

              if(empty($errMsg))
              {

                if (!(strlen($parent_password)<6)) {
                if ($parent_password==$parent_confirm_password) {


            $sqlparentlogin = $db->query("UPDATE `parents` SET `spemail` = '$parent_email', `spphone` = '$parent_password' WHERE `parent_id` ='$parent_id'");

            if($sqlparentlogin) {
                      //echo inserted
                      $msg = "Parent login details updated";                   

                  } else { $msg = "Sorry, Failed to update login details - " . mysqli_error($db);
                        }
          }else{ $msg = "Password does not match"; }
        }else{ $msg = "Password is less than 6 charater"; }
      } else{ $msg=$errMsg; }
        }else{ $msg = "Email field can't be empty"; }
      }else{ $msg = "Some error occurred in student details"; }

     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Disable parent login script==========================================*/
  else if (isset($_POST['disable_parent_login'])) {

      $parentid = mysqli_real_escape_string($db,$_POST['disable_parent_login']);

      if (!empty($parentid)) {
        $parent_password='';
        $sqlupdatepparentlogin = $db->query("UPDATE `parents` SET `spphone` = '$parent_password' WHERE `parent_id` ='$parentid'");

            if($sqlupdatepparentlogin) { $msg = "Parent Login Disabled";  
          } else { $msg = "Sorry, Failed to disable login - " . mysqli_error($db); }
      }else{ $msg = "Some error occurred in student details"; }
     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Set Login details For Staff script ======================================*/
  else if (isset($_POST['set_staff_login_id'])) {

      $staff_email = mysqli_real_escape_string($db,$_POST['staff_email']);
      $staff_password = mysqli_real_escape_string($db,$_POST['staff_password']);
      $staff_confirm_password = mysqli_real_escape_string($db,$_POST['staff_confirm_password']);
      $staff_id = mysqli_real_escape_string($db,$_POST['set_staff_login_id']);

      if (!empty($staff_id)) {
        if (!empty($staff_email)) {

          $checkexist = $backstage->check_staff_email_exist_except_id($staff_email,$staff_id);
              if ($checkexist) {
                  $errMsg="Email id already exist with another account";
              }elseif (!filter_var($staff_email, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
              }

              if(empty($errMsg))
              {

                if (!(strlen($staff_password)<6)) {
                  if ($staff_password==$staff_confirm_password) {


                    $sqlstafflogin = $db->query("UPDATE `staff_tbl` SET `staff_email` = '$staff_email', `staff_getter` = '$staff_password' WHERE `stid` ='$staff_id'");

                    if($sqlstafflogin) {
                      //echo inserted
                      $msg = "Login details updated";                   

                    } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db);  }
                  }else{ $msg = "Password does not match"; }
                }else{ $msg = "Password is less than 6 charater"; }
              } else{ $msg=$errMsg; }
        }else{ $msg = "Email field can't be empty"; }
      }else{ $msg = "Some error occurred in staff details"; }

     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Disable staff login script==========================================*/
  else if (isset($_POST['disable_staff_login'])) {

      $staffid = mysqli_real_escape_string($db,$_POST['disable_staff_login']);

      if (!empty($staffid)) {
        $staff_password='';
        $sqlupdatepstafflogin = $db->query("UPDATE `staff_tbl` SET `staff_getter` = '$staff_password' WHERE `stid` ='$staffid'");

            if($sqlupdatepstafflogin) { $msg = "Staff Login Disabled";  
          } else { $msg = "Sorry, Failed to disable login  - " . mysqli_error($db); }
      }else{ $msg = "Some error occurred in staff details"; }
     $_SESSION['result_success']=$msg;
      echo $msg; 
  }
/*================================= Update class script==========================================*/
    else if (isset($_POST['update_class_fee_id'])) { 

      $classname = mysqli_real_escape_string($db,$_POST['newclassname']);
      $classsymbolic = mysqli_real_escape_string($db,$_POST['numeric_name']);
      $sort_order = $_POST['sort_order'];
      $classid = mysqli_real_escape_string($db,$_POST['update_class_fee_id']);
      $classadmission = mysqli_real_escape_string($db,$_POST['classadmission']);
      $monthy_tution_fee = mysqli_real_escape_string($db,$_POST['monthy_tution_fee']);
      $annual_fee = mysqli_real_escape_string($db,$_POST['annual_fee']);
      $computer_fee = mysqli_real_escape_string($db,$_POST['computer_fee']);
      $hostel_fee = mysqli_real_escape_string($db,$_POST['hostel_fee']);
      $exam_fee = mysqli_real_escape_string($db,$_POST['exam_fee']);
      $monthly_test_fee = mysqli_real_escape_string($db,$_POST['monthly_test_fee']);
      $uniform_fee = mysqli_real_escape_string($db,$_POST['uniform_fee']);
      $book_fee = mysqli_real_escape_string($db,$_POST['book_fee']);
      $registration_fee = mysqli_real_escape_string($db,$_POST['registration_fee']);
      $security_fee = mysqli_real_escape_string($db,$_POST['security_fee']);

      $year_id = mysqli_real_escape_string($db,$_POST['year_id']);

      if (!empty($classname)) {
        if (!empty($classsymbolic)) {
        if (!empty($year_id)) {
          // if (!empty($monthy_tution_fee)) {

            if (empty($classadmission) || $classadmission=='0' ) { $classadmission=0.0; }
            if (empty($monthy_tution_fee) || $monthy_tution_fee=='0') { $monthy_tution_fee=0.0; }
            if (empty($annual_fee) || $annual_fee=='0') { $annual_fee=0.0; }
            if (empty($computer_fee) || $computer_fee=='0') { $computer_fee=0.0; }
            if (empty($hostel_fee) || $hostel_fee=='0') { $hostel_fee=0.0; }
            if (empty($exam_fee) || $exam_fee=='0') { $exam_fee=0.0; }
            if (empty($monthly_test_fee) || $monthly_test_fee=='0') { $monthly_test_fee=0.0; }
            if (empty($uniform_fee) || $uniform_fee=='0') { $uniform_fee=0.0; }
            if (empty($book_fee) || $book_fee=='0') { $book_fee=0.0; }
            if (empty($registration_fee) || $registration_fee=='0') { $registration_fee=0.0; }
            if (empty($security_fee) || $security_fee=='0') { $security_fee=0.0; }

            if ($sort_order<0 || $sort_order >99) {
              $sort_order = 0;
            }

            $class_name1=strtolower($classname);
            $class_name2=ucwords($classname);
            $class_name3=strtoupper($classname);

            $sqlcheck="SELECT * FROM `class` WHERE ( `class_name`='$classname' OR `class_name`='$class_name1' OR `class_name`='$class_name2' OR `class_name`='$class_name3' )  AND `year_id` = '$year_id' AND `class_id`<>'$classid' ";
              $resultcheck=mysqli_query($db, $sqlcheck);
              $count=mysqli_num_rows($resultcheck);
              if($count<1){

            $sqlcheck1="SELECT * FROM `class` WHERE `class_symbolic` = '$classsymbolic'  AND `year_id` = '$year_id' AND `class_id`<>'$classid' ";
              $resultcheck1=mysqli_query($db, $sqlcheck1);
              $count1=mysqli_num_rows($resultcheck1);
              if($count1<1){

                $updateclassfee = "UPDATE `class` SET `class_name` = '$classname', `class_symbolic` = '$classsymbolic', `tution_fee`='$monthy_tution_fee' , `computer_fee`='$computer_fee', `hostel_fee`='$hostel_fee', `admission_charge`='$classadmission', `annual_fee`='$annual_fee', `exam_fee`='$exam_fee', `uniform_fee`='$uniform_fee', `book_fee`='$book_fee', `monthly_test_fee`='$monthly_test_fee', `registration_fee`='$registration_fee', `security_fee`='$security_fee' , `sort_order`='$sort_order' WHERE `class_id`='$classid'";
                  
                  if(mysqli_query($db, $updateclassfee)) {
                      //echo inserted
                      $msg = "Class updated successfully";                   

                  } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db);
                        }

                  }else{ $msg = "Numeric class name is already exist!!"; }
                }else{ $msg = "class name is already exist!!"; }
                
          // }else{ $msg = "Monthly tution fee is missing!!"; }
        }else{ $msg = "Academic year is missing!!"; }
        }else{ $msg = "Numeric class name is missing"; }
      }else{ $msg = "Class name is missing"; }
                
      $_SESSION['result_success']=$msg;
      echo $msg;
    }
/*================================= Update class section script==========================================*/
    else if (isset($_POST['update_class_section'])) {

      $class_id = mysqli_real_escape_string($db,$_POST['update_class_section']);      
        $new_section=$_POST['new_section'];
        $addmedium=$_POST['addmedium'];
        $addblock=$_POST['addblock'];
        $new_room=$_POST['new_room'];
        $year_id=$_POST['year_id'];

        if (!empty($year_id)) {
          if (!empty($new_section)) {
            if (empty($addmedium)) { $addmedium = 0; }
            if (empty($addblock)) { $addblock = 0; }
            if (empty($new_room)) { $new_room = ""; }

            $new_section1=strtolower($new_section);
            $new_section2=ucwords($new_section);
            $new_section3=strtoupper($new_section);

               $sqlcheck="SELECT `section_id` 
                FROM `section` 
                WHERE (`section_name`='$new_section' 
                      OR `section_name`='$new_section1' 
                      OR `section_name`='$new_section2' 
                      OR `section_name`='$new_section3' )
                      AND `section_class`='$class_id' 
                      AND `year_id` = '$year_id'";
               $resultcheck=mysqli_query($db, $sqlcheck);
               $count=mysqli_num_rows($resultcheck);
               if($count<1){

                 $sqlfnp1 = "INSERT INTO `section` (`section_id`, `section_class`, `section_name`, `medium`, `block_id`, `room_no`, `teacher_id`, `student_id`, `year_id`, `status`) VALUES (NULL, '$class_id', '$new_section', '$addmedium', '$addblock', '$new_room', 0, 0, '$year_id', 0 )";
                  
                  if(mysqli_query($db, $sqlfnp1)) {
                      //echo "inserted";                   
                    $msg = "Section updated successfully";
                  } else { 
                 $msg = "ERROR: Could not able to execute - " . mysqli_error($db);
                  }
               }else{ $msg = "Section name already exist!!!"; }

          }else{ $msg = "Section name is empty!!!"; }
        }else{ $msg = "Academic year is missing.."; }

                
      $_SESSION['result_success'] = $msg;
      echo $msg;
    }

/*================================= Update Sms script==========================================*/
  else if (isset($_POST['update_sms_setting'])) {


  $sms_attendance=$_POST['sms_attendance'];
  $sms_feenotice=$_POST['sms_feenotice'];
  $sms_complaint=$_POST['sms_complaint'];
  $sms_nohomework=$_POST['sms_nohomework'];
  $sms_broadcast=$_POST['sms_broadcast'];

  if ($sms_attendance=='on') { $sms_attendance=1; } else{ $sms_attendance=0; }
  if ($sms_feenotice=='on') { $sms_feenotice=1; } else{ $sms_feenotice=0; }
  if ($sms_complaint=='on') { $sms_complaint=1; } else{ $sms_complaint=0; }
  if ($sms_nohomework=='on') { $sms_nohomework=1; } else{ $sms_nohomework=0; }
  if ($sms_broadcast=='on') { $sms_broadcast=1; } else{ $sms_broadcast=0; }

                $sqlupdatebulk = $db->query("UPDATE `schooldetails` SET `sms_attendance`='$sms_attendance', `sms_feenotice` = '$sms_feenotice', `sms_complaint` = '$sms_complaint', `sms_nohomework` = '$sms_nohomework', `sms_broadcast` = '$sms_broadcast' WHERE 1");
                if($sqlupdatebulk){
                        $msg="Bulk SMS setting updated succesfully";
                      }else{ $msg="Failed to updated sms setting"; }                
                
    echo $msg;
  }
/*================================= Update Mail From script==========================================*/
  else if (isset($_POST['update_mailfrom_setting'])) {


  $email=$_POST['email'];

  if (empty($email)) { $email=''; }

                $sqlupdatemailfrom = $db->query("UPDATE `schooldetails` SET `mailfrom`='$email' WHERE 1");
                if($sqlupdatemailfrom){
                        $msg="Mail setting updated succesfully";
                      }else{ $msg="Failed to updated mail setting"; }                
                
    echo $msg;
  }
/*================================= Add Bus Information script==========================================*/
  else if (isset($_POST['add_bus_information'])) {


    $bus_number = $_POST['bus_number'];
    $trackerType = $_POST['trackerType'];
    $staffId = $_POST['staffId'];

    if (!empty($bus_number)) {
      if (!empty($trackerType)) {
          if (empty($staffId)) { $staffId=0; }

                $sqlupdatebusinfo = $db->query("INSERT INTO `transportation`( `bus_number`, `tracker_type`, `stid`, `status`) VALUES ('$bus_number','$trackerType','$staffId',1)");
                if($sqlupdatebusinfo){
                        $msg="Bus Information succesfully updated";
                }else{ $msg="Failed to updated bus information". mysqli_error($db);; }  

      }else{ $msg="Please select tracker type"; }   
    }else{ $msg="Sorry, Bus number is empty"; } 
              
    $_SESSION['result_success']=$msg;    
    echo $msg;
  }
/*================================= Update Bus Information script==========================================*/
  else if (isset($_POST['update_bus_information'])) {


    $bus_id = $_POST['update_bus_information'];
    $bus_number = $_POST['bus_number'];
    $trackerType = $_POST['trackerType'];
    $staffId = $_POST['staffId'];

    if (!empty($bus_id)) {
      if (!empty($bus_number)) {
      if (!empty($trackerType)) {
          if (empty($staffId)) { $staffId=0; }

                $sqlupdatebusinfo = $db->query("UPDATE `transportation` SET `bus_number` = '$bus_number' ,  `tracker_type` = '$trackerType', `stid` = '$staffId' WHERE `bus_id` = '$bus_id'");
                if($sqlupdatebusinfo){
                        $msg="Bus Information succesfully updated";
                      }else{ $msg="Failed to updated bus information". mysqli_error($db);; }  

        }else{ $msg="Please select tracker type"; }   
      }else{ $msg="Sorry, Bus number is empty"; } 
    }else{ $msg="Please select bus"; } 
              
    $_SESSION['result_success']=$msg;    
    echo $msg;
  }
/*================================= Update Section teacher and student script =============================*/
  else if (isset($_POST['update_section_teacher_student'])) {

    $section_id = $_POST['update_section_teacher_student'];

    $teacher_id=$_POST['teacher_id'];
    $student_id=$_POST['student_id'];
    $medium_id = $_POST['medium_id'];
    $block_id = $_POST['block_id'];
    $section_nameNew=$_POST['section_nameNew'];
    $room_noNew=$_POST['room_noNew'];

    if (empty($teacher_id)) { $teacher_id=0; }
    if (empty($student_id)) { $student_id=0; }
    if (empty($medium_id)) { $medium_id=0; }
    if (empty($block_id)) { $block_id=0; }
    if (empty($room_noNew)) { $room_noNew=""; }
    if (!empty($section_nameNew)) {

          $sql = $db->query("UPDATE `section` SET  `section_name` = '$section_nameNew', `medium` = '$medium_id', `block_id` = '$block_id', `room_no` = '$room_noNew', `teacher_id` = '$teacher_id', `student_id` = '$student_id' WHERE `section_id` = '$section_id'");
          if($sql){
                  $msg="Updated successfully";
                }else{ $msg="Sorry, failed to update". mysqli_error($db); }  

    }else{ $msg="Section name is empty!!!"; }

    $_SESSION['result_success']=$msg;    
    echo $msg;
  }
/*================================= Update mark script==========================================*/
  elseif(isset($_POST['update_mark'])){

    $marksheet_id = mysqli_real_escape_string($db,$_POST['update_mark']);
    $subtype2 = mysqli_real_escape_string($db,$_POST['subtype2']);

    if ($subtype2==1) {

      $theory = mysqli_real_escape_string($db,$_POST['theory2']);
      $practical = mysqli_real_escape_string($db,$_POST['practical2']);

      $obtained = $theory+$practical;

    }elseif ($subtype2==0 || $subtype2==3) {

      $theory = mysqli_real_escape_string($db,$_POST['obtained2']);
      $practical = "";
      $obtained = mysqli_real_escape_string($db,$_POST['obtained2']);
     
    }

     $sql = $db->query("UPDATE  `marksheet`  SET `m_theory`  = '$theory', `m_practical`  = '$practical', `m_obtained_mark`  = '$obtained' WHERE  `marksheet_id`  = '$marksheet_id'");

     if($sql){ $msg = "Mark successfully updated";
     }else{ $msg = "Failed to update"; }

    $_SESSION['result_success']=$msg;
    echo $msg;
  }
/*================================= Update exam time table==========================================*/
  elseif(isset($_POST['update_timetable'])){

    $examtable_id = mysqli_real_escape_string($db,$_POST['update_timetable']);
    $date = $_POST['date2'];
    $time = $_POST['time2'];

    $exam_date = $date;
    if($login_date_type==2){
        $exam_date = nToE($exam_date);
    }

    $exam_time = date("H:i:s", strtotime($time));


     $sql = $db->query("UPDATE `examtable` SET `date`='$exam_date',`time`='$exam_time' WHERE `examtable_id` = '$examtable_id'");

     if($sql){ $msg = "Time table successfully updated";
     }else{ $msg = "Failed to update". mysqli_error($db); }

    $_SESSION['result_success']=$msg;
    echo $msg;
  }
  /*================================= publish mark result script==========================================*/
  elseif(isset($_POST['publish_marksheet'])){

    $class_id = $_POST['class_id'];
    $section_id = $_POST['section_id'];
    $exam_id = $_POST['exam_id'];

    $month_id = $_POST['month_id'];
    $year_id = $_POST['year_id'];

    //$msg = $class_id."-".$section_id."-".$exam_id."-".$month_id."-".$year_id;

     $sql = $db->query("UPDATE  `marksheet`  SET `marksheet_status`  = 0 WHERE  `marksheet_class`  = '$class_id' 
          " . (empty($section_id) ? "" : "AND `marksheet`.`marksheet_section`='$section_id' ") . "
         AND `mexam_id`  = '$exam_id' AND `month`  = '$month_id' AND `year_id`  = '$year_id'");

     if($sql){ $msg = "Mark successfully published";
     }else{ $msg = "Failed to update". mysqli_error($db); }

    $_SESSION['result_success']=$msg;
    echo $msg;
  }
/*================================= Update Email Id script ==========================================*/
    else if (isset($_POST['updateEmailId'])) {

      $id = $_POST['updateEmailId'];
      $userType = $_POST['loginCatKey'];
      $newEmail = $_POST['newEmailId'];

      if(!empty($newEmail)){

        //UPDATE FOR ADMIN
        if ($userType==1) {
          
                if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
                }else{
                  $checkexist = $backstage->check_admin_email_exist_except_id($newEmail,$id);
                  if ($checkexist) { 
                      $errMsg="Email id already exist with another account";
                  }
                }

                if(empty($errMsg))
                { 
                    $updateQuery = "UPDATE `principal` SET `pemail`='$newEmail' WHERE `pid`='$id'";
                          
                    if(mysqli_query($db, $updateQuery)) {  
                        //echo inserted
                        $msg= "Email id succesfully updated";                  

                    }else { $msg = "Failed to update - " . mysqli_error($db); }
                          
                }else{  $msg = $errMsg;  }
              
        }else if ($userType==5) {
          
                if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
                }else{
                  $checkexist = $backstage->check_staff_email_exist_except_id($newEmail,$id);
                  if ($checkexist) { 
                      $errMsg="Email id already exist with another account";
                  }
                }

                if(empty($errMsg))
                { 
                    $updateQuery = "UPDATE `staff_tbl` SET `staff_email`='$newEmail' WHERE `stid` = '$id'";
                          
                    if(mysqli_query($db, $updateQuery)) {  
                        //echo inserted
                        $msg= "Email id succesfully updated";                  

                    }else { $msg = "Failed to update - " . mysqli_error($db); }
                          
                }else{  $msg = $errMsg;  }
              
        }else if ($userType==2) {
          
                if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
                }else{
                  $checkexist = $backstage->check_teacher_email_exist_except_id($newEmail,$id);
                  if ($checkexist) { 
                      $errMsg="Email id already exist with another account";
                  }
                }

                if(empty($errMsg))
                { 
                    $updateQuery = "UPDATE `teachers` SET `temail`='$newEmail' WHERE `tid`='$id'";
                          
                    if(mysqli_query($db, $updateQuery)) {  
                        //echo inserted
                        $msg= "Email id succesfully updated";                  

                    }else { $msg = "Failed to update - " . mysqli_error($db); }
                          
                }else{  $msg = $errMsg;  }
              
        }else if ($userType==3) {
          
                if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
                }else{
                  $checkexist = $backstage->check_student_email_exist_except_id($newEmail,$id);
                  if ($checkexist) { 
                      $errMsg="Email id already exist with another account";
                  }
                }

                if(empty($errMsg))
                { 
                    $updateQuery = "UPDATE `studentinfo` SET `semail`='$newEmail' WHERE `sid`='$id'";
                          
                    if(mysqli_query($db, $updateQuery)) {  
                        //echo inserted
                        $msg= "Email id succesfully updated";                  

                    }else { $msg = "Failed to update - " . mysqli_error($db); }
                          
                }else{  $msg = $errMsg;  }
              
        }else if ($userType==4) {
          
                if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)) {
                  $errMsg = "Invalid email format"; 
                }else{
                  $checkexist = $backstage->check_parent_email_exist_except_id($newEmail,$id);
                  if ($checkexist) { 
                      $errMsg="Email id already exist with another account";
                  }
                }

                if(empty($errMsg))
                { 
                    $updateQuery = "UPDATE `parents` SET `spemail`='$newEmail' WHERE `parent_id`='$id'";
                          
                    if(mysqli_query($db, $updateQuery)) {  
                        //echo inserted
                        $msg= "Email id succesfully updated";                  

                    }else { $msg = "Failed to update - " . mysqli_error($db); }
                          
                }else{  $msg = $errMsg;  }
              
        }

      }else{
        $msg = "Please enter email id";
      }

      $_SESSION['result_success'] = $msg;
      echo $msg;
    }
/*================================= Update Password script ==========================================*/
    else if (isset($_POST['updatePassword'])) {

      $id = $_POST['updatePassword'];
      $userType = $_POST['loginCatKey'];

      $newpassword = $_POST['newpassword'];
      $confirmnewpassword = $_POST['confirmnewpassword'];

      if (!(strlen($newpassword)<6)) {
      if ($newpassword==$confirmnewpassword) {

        //UPDATE FOR ADMIN
        if ($userType==1) {

            $updateQuery = "UPDATE principal SET ppassword='$newpassword' WHERE `pid` = '$id'";
                  
            if(mysqli_query($db, $updateQuery)) {
                $msg= "Password succesfully updated";
            }else { $msg = "Failed to update - " . mysqli_error($db); } 

        }else if($userType==5){

          $updateQuery = "UPDATE `staff_tbl` SET `staff_getter` = '$newpassword' WHERE `stid`= '$id'";
                  
            if(mysqli_query($db, $updateQuery)) {
                $msg= "Password succesfully updated";
            }else { $msg = "Failed to update - " . mysqli_error($db); }

        }else if($userType==2){

          $updateQuery = "UPDATE `teachers` SET `tgetter` = '$newpassword' WHERE `tid` = '$id'";
                  
            if(mysqli_query($db, $updateQuery)) {
                $msg= "Password succesfully updated";
            }else { $msg = "Failed to update - " . mysqli_error($db); }

        }else if($userType==3){

          $updateQuery = "UPDATE `studentinfo` SET `sgetter` = '$newpassword' WHERE `sid` = '$id'";
                  
            if(mysqli_query($db, $updateQuery)) {
                $msg= "Password succesfully updated";
            }else { $msg = "Failed to update - " . mysqli_error($db); }

        }else if($userType==4){

          $updateQuery = "UPDATE `parents` SET `spphone` = '$newpassword' WHERE `parent_id` = '$id'";
                  
            if(mysqli_query($db, $updateQuery)) {
                $msg= "Password succesfully updated";
            }else { $msg = "Failed to update - " . mysqli_error($db); }

        }

      }else{  $msg = "Entered password does not match"; }
      }else{  $msg = "Entered password is less than 6 charater"; }

      $_SESSION['result_success'] = $msg;
      echo $msg;
    }
/*================================= Update lesson plan for nsk script ========================================*/
    else if(isset($_POST['update_lessonplan_id'])){
       $id=$_POST['update_lessonplan_id'];
       $percentage=$_POST['percentage'];
       $remark=$_POST['remark'];

        if ($percentage<=100 && $percentage>=0) {     

              $qry = "UPDATE lesson_planning SET `percentage` = '$percentage', `remark` = '$remark'  WHERE id='$id'";
           
              $result = mysqli_query($db, $qry);
          
           if($result){ 

              $msg="Lesson plan updated successfully"; 
            }

           else{ 

              $msg ="Failed to update lesson plan:".mysqli_error($db);   
            }

        }else{ $msg="Percentage should be between 0 to 100"; }
      echo $msg;
    }

/*================================= DELETE EXAM TABLE ==========================================*/
    else if (isset($_POST['deleteExamTableRequest'])) {

      $id = $_POST['deleteExamTableRequest'];

      $deletesqlrequest ="DELETE FROM `examtable` WHERE `examtable`.`examtable_id`='$id' ";
                  
        if(mysqli_query($db, $deletesqlrequest)) {

          $msg = "Exam Deleted Succesfully";
        
        } else { 
          $msg = "Sorry:Failed to delete - " . mysqli_error($db);
          
        }

      $_SESSION['result_success'] = $msg;
      echo $msg;
    }
/*================================= update SESSION script====================================*/
  else if (isset($_POST['update_current_session_year'])) {

      $errMsg='';

      $selected_session_year_id = mysqli_real_escape_string($db,$_POST['selected_session_year_id']);
      $year =  $backstage->get_academic_year_by_year_id($selected_session_year_id);

      $_SESSION['current_year_session_id'] = $selected_session_year_id;

      $_SESSION['current_year_session'] = $year;

      if ($_SESSION['current_year_session_id'] == $selected_session_year_id && $_SESSION['current_year_session'] == $year) {

          $response["status"] = 200;
          $response["message"] = "Success";
      }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = "Failed to update current session";
      }
                    
     echo json_encode($response);
    }
/*================================= Promotion of student script====================================*/
  else if (isset($_POST['request_for_student_promotion'])) {

      $errMsgArray  = array();

      $old_batch_id = mysqli_real_escape_string($db,$_POST['old_batch_id']);
      $old_class_id = mysqli_real_escape_string($db,$_POST['old_class_id']);
      $old_section_id = mysqli_real_escape_string($db,$_POST['old_section_id']);

      $studentCount = mysqli_real_escape_string($db,$_POST['rowno']);

      $studentList = $_POST['sid'];
      $rollList = $_POST['roll_no'];
      $selectstd = $_POST['selectstd'];


      $promotion_type = mysqli_real_escape_string($db,$_POST['promotion_type']);


      if (empty($old_batch_id)) { array_push($errMsgArray,"Please select old batch"); }
      if (empty($old_class_id)) { array_push($errMsgArray,"Please select old class"); }
      if (empty($old_section_id)) { array_push($errMsgArray,"Please select old section"); }
      

      if ($promotion_type == 'upgrade') {
        $new_batch_id = mysqli_real_escape_string($db,$_POST['new_batch_id']);
        $new_class_id = mysqli_real_escape_string($db,$_POST['new_class_id']);
        $new_section_id = mysqli_real_escape_string($db,$_POST['new_section_id']);

      if (empty($new_batch_id)) { array_push($errMsgArray,"Please select new batch"); }
      if (empty($new_class_id)) { array_push($errMsgArray,"Please select new class"); }
      if (empty($new_section_id)) { array_push($errMsgArray,"Please select new section"); }


      }else if($promotion_type == 'passout'){

      }

      if (empty($studentCount)) { array_push($errMsgArray,"Student list is empty"); }



      if (empty($errMsgArray)) {

        // Set autocommit to off
        mysqli_autocommit($db,FALSE);

        $sqlError = "";

        // if (mysqli_query($db,"UPDATE `studentinfowe` SET `batch_year_id` = '8' WHERE `sid` = '$studentList[$i]'")) {
                
        // }else{
        //   $sqlError = "SQL ERROR - ".mysqli_error($db);
        // }

        for ($i=1; $i <= $studentCount ; $i++) {
          if ($selectstd[$i] =="on") {

            if ($promotion_type == 'upgrade') { // Update to upgrade

              $tution_fee = 0;
              $hostel_fee = 0;
              $computer_fee = 0;

              $std = json_decode($backstage->get_student_details_by_sid($studentList[$i]));

              $class = json_decode($backstage->get_class_details_by_class_id($new_class_id));

              if ($std->payment_type==1) {
                $tution_fee = 12*$class->tution_fee;
                $hostel_fee = 12*$class->hostel_fee;
                $computer_fee = 12*$class->computer_fee;
              }else if($std->payment_type==0){
                $tution_fee = $class->tution_fee;
                $hostel_fee = $class->hostel_fee;
                $computer_fee = $class->computer_fee;
              }



              if (mysqli_query($db,"UPDATE `studentinfo` SET `sclass` = '$new_class_id', `ssec` = '$new_section_id' , `sroll` = '$rollList[$i]' , `tution_fee` = '$tution_fee' , `hostel_fee` = '$hostel_fee' , `computer_fee` = '$computer_fee' , `batch_year_id` = '$new_batch_id' WHERE `sid` = '$studentList[$i]'")) {

                if (mysqli_query($db,"INSERT INTO `syearhistory`( `student_id`, `class_id`, `section_id`, `roll_no`, `payment_type`, `tution_fee`, `bus_id`, `bus_fee`, `hostel_fee`, `computer_fee`, `year_id`, `updated_date`) VALUES ('$studentList[$i]', '$new_class_id', '$new_section_id', '$rollList[$i]', '$std->payment_type', '$tution_fee', '$std->bus_id', '$std->bus_fee', '$hostel_fee', '$computer_fee', '$new_batch_id', '$newdate')")) {
                
                }else{
                  $sqlError = "Failed to add in student history";
                }
                
              }else{
                $sqlError = "SQL ERROR - ".mysqli_error($db);
              }

            }else if($promotion_type == 'passout'){ // Update to pass out status = 2
              if (mysqli_query($db,"UPDATE `studentinfo` SET `left_date` = '$newdate' , `status` = 2 WHERE `sid` = '$studentList[$i]'")) {
              }else{
                $sqlError = "SQL ERROR - ".mysqli_error($db);
              }
            }

            

          }
        }

        

        
        if (empty($sqlError)) {
          // Commit transaction
          if (mysqli_commit($db)) {
            $response["status"] = 200;
            $response["message"] = "Success";
          }else{
            $response["status"] = 201;
            $response["message"] = "Failed";
            $response["errormsg"] = "Transaction Commit Failed!!!";
          }
        }else{
            $response["status"] = 201;
            $response["message"] = "Failed";
            $response["errormsg"] = $sqlError;
        }
        

        // Close connection
        mysqli_close($db);

      }else{

        $response["status"] = 202;
        $response["message"] = "Failed";
        $response["errormsg"] = $errMsgArray;

      }
                    
     echo json_encode($response);
    }







    else{
      //echo "Sorry,Unknown Request...";
    }




}

?>