<?php
include('session.php');
require("../important/backstage.php");
require("../important/compress.php");
$msg="";
$errMsg = "";

$backstage = new back_stage_class();
$compress = new compress_class();

$yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));

$newdate = date("Y-m-d");

$nepaliDate = eToNepaliWithoutZero($newdate);



if($_SERVER['REQUEST_METHOD']=='POST') {
/*=================================Add Student script==========================================*/
    if (isset($_POST['student_form'])) {

            $errMSG='';

            $year_id=$_POST['year_id'];

            $sname=$_POST['sname'];
            $scaste=$_POST['scaste'];
            $saddress=$_POST['saddress'];
            $semail=$_POST['semail'];
            $sgetter=$_POST['spassword1'];
            $sgetter1=$_POST['spassword2'];
            $spid=$_POST['spid'];
            $sclass=$_POST['sclass'];
            $ssec=$_POST['ssection'];
            $ssex=$_POST['ssex'];
            $admission_date=$_POST['admissiondate'];
            $dob=$_POST['sdob'];
            $smobile=$_POST['smobile'];
            $blood_group=$_POST['blood_group'];

            $otherFeeType=$_POST['otherFeeType'];
            $otherFeeValue=$_POST['otherFeeValue'];

            $payment_type = $_POST['payment_type'];

            $studentbusid = $_POST['studentbusid'];

            $tution_checked = $_POST['tution_checked'];
            $hostel_checked = $_POST['hostel_checked'];
            $computer_checked = $_POST['computer_checked'];

            if ($tution_checked == "on") {
              $tution = 1;
              $tution_fee = $_POST['tution_fee'];
              if (empty($tution_fee) || $tution_fee=='0') { $tution_fee=0.0; }
            }else{
              $tution = 0;
              $tution_fee = 0;
            }
            if ($hostel_checked == "on") {
              $hostel = 1;
              $hostel_fee = $_POST['hostel_fee']; 
              if (empty($hostel_fee) || $hostel_fee=='0') { $hostel_fee=0.0; }
            }else{
              $hostel = 0;
              $hostel_fee = 0;
            }
            if ($computer_checked == "on") {
              $computer = 1;
              $computer_fee = $_POST['computer_fee'];
              if (empty($computer_fee) || $computer_fee=='0') { $computer_fee=0.0; }
            }else{
              $computer = 0;
              $computer_fee = 0;
            }
            if (!empty($studentbusid)) { 
              $bus_fee = $_POST['bus_fee'];
              if (empty($bus_fee) || $bus_fee=='0') { $bus_fee=0.0; }
            }else{
              $studentbusid=0; 
              $bus_fee=0.0;
            }
          

            $getsid = $backstage->get_max_student_id();

            if($login_date_type==2){ $year4 = $cal['year']; }else{ $year4 = date("Y"); }
            
            $yr2 = substr($year4, -2);
            $sadmsnno='';

            if(!empty($getsid)){

              $admissionno1 = $backstage->get_max_student_admission_number($getsid);
              $checkyr=substr($admissionno1, 3,2);
              $getidinstring=substr($admissionno1,5);

              if ($yr2==$checkyr) {
                $tobe_studentd_id=(int)$getidinstring;
                $added_student_id=$tobe_studentd_id+1;
                $added_student_id4=sprintf("%04d", $added_student_id);
                $sadmsnno=strtoupper($LOGIN_SCHOOL_CODE).$yr2.$added_student_id4;
              }else{

                $sadmsnno=strtoupper($LOGIN_SCHOOL_CODE).$yr2.'0001';
              }
            }else{
              $sadmsnno=strtoupper($LOGIN_SCHOOL_CODE).$yr2.'0001';
            }


            $img1 = $_FILES['file1'];
            $img2 = $_POST['file2'];
            $image = '';



                 // if (!empty($spid)){
                  if (!empty($sname)){
                  // if(!empty($saddress)){
                  if(!empty($sclass)){
                  if(!empty($ssec)){
                  if (!empty($ssex)){
                  // if (!empty($dob)){
                  if (isset($payment_type)){


                  if($login_date_type==2){
                    if(!empty($admission_date)){
                      $admission_date = nToE($admission_date);
                    }
                      $dob = nToE($dob);
                  }

                      if (empty($spid)) { $spid=0; }
                      
                      if (empty($dob)) { $dob=''; }
                      if (empty($admission_date)) { $admission_date=$newdate; }
                      if (empty($scaste)) { $scaste='General'; }

                      if (empty($blood_group)) { $blood_group=0; }


                      if (is_numeric($tution_fee) || $tution_fee>=0 ) {
                      if (is_numeric($hostel_fee) || $hostel_fee>=0 ) {
                      if (is_numeric($computer_fee) || $computer_fee>=0 ) {
                      if (is_numeric($bus_fee) || $bus_fee>=0 ) {

                              
                      if(!empty($sgetter) || !empty($sgetter1)){
                        if (strlen($sgetter)<6) { $errMSG="Student password is less than 6 charater"; }
                                elseif ($sgetter!=$sgetter1) { $errMSG="Student password does not match"; }else{}
                        }else{ $sgetter=""; }

                      if(!empty($smobile)){
                        if (strlen($smobile)!=10) { $errMSG="Mobile number should be 10 digit long"; }
                        }else{ $smobile=""; }

                      if(!empty($semail)){ //check email exist
                        if (!filter_var($semail, FILTER_VALIDATE_EMAIL)) {
                          $errMSG = "Invalid email format"; 
                        }else{
                          $checkexist = $backstage->check_student_email_exist($semail);
                          if ($checkexist) { 
                            $errMSG="Email id already exist with another account";
                          }
                        }
                      }else{ $semail=""; }

                      $maxroll = $backstage->get_max_student_roll_number_from_class_sec($sclass,$ssec);
                      $sroll=(int)$maxroll+1;

                      $maxidnew = (int)$backstage->get_max_student_id()+1;

                      $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/'; // upload directory
                      //$ufile1 = "student".rand(1000,100000000).".".$fileExt;
                      $imageName = "student".$maxidnew;
                      


            if(!empty($img1['name']) && empty($errMSG)){
            

             $imgupload= $compress->compress_image($img1,$upload_dir ,$imageName , 75);

             if($imgupload['code'] == 200){
                $image = $imgupload['image'];

              }else{
                $errMSG = $imgupload['message'];
              }
            
           /*  // Check if file already exists
             $target_file=$upload_dir.basename($_FILES["file1"]["name"]);
              if (file_exists($target_file)) {
                  $msg="Image already exist";
              }else{*/
             // allow valid image file formats
             
          }else if (!empty($img2) && empty($errMSG)) {

              $imgupload= $compress->upload_base64($img2,$upload_dir ,$imageName);

             if($imgupload['code'] == 200){
              $image = $imgupload['image'];

              }else{
                $errMSG = $imgupload['message'];
              }


          }
                // if no error occured, continue ....
                if(empty($errMSG))
                { 
                  
                    $insertintostudent = "INSERT INTO `studentinfo` (`sroll`, `sadmsnno`, `sname`, `saddress`, `semail`, `sgetter`, `sclass`, `ssec`, `admission_date`, `sex`, `dob`,`blood_group`, `caste`, `simage`, `smobile`, `payment_type`, `tution` , `tution_fee`, `bus_id`, `bus_fee`, `hostel` , `hostel_fee`, `computer` , `computer_fee`, `left_date`, `description`, `sparent_id`, `batch_year_id`, `status`) VALUES ('$sroll', '$sadmsnno', '$sname', '$saddress', '$semail', '$sgetter', '$sclass', '$ssec', '$admission_date', '$ssex', '$dob', '$blood_group', '$scaste', '$image', '$smobile', '$payment_type', '$tution', '$tution_fee', '$studentbusid', '$bus_fee', '$hostel', '$hostel_fee', '$computer', '$computer_fee', '', '', '$spid','$year_id', 0)"; 

                  if(mysqli_query($db, $insertintostudent)) {

                    //get the last added id
                    $std_id = mysqli_insert_id($db);

                  if (!empty($tution) && !empty($tution_fee)) {
                    $feetype_id = $backstage->get_feetype_id_by_feetype_title("Tution Fee");
                    $backstage->add_fee_into_student_due($std_id, $feetype_id, $tution_fee, 'Added on admission time', $nepaliDate, $LOGIN_CAT, $LOGIN_ID, 1); 
                  }
                  if (!empty($studentbusid) && !empty($bus_fee)) {
                    $feetype_id = $backstage->get_feetype_id_by_feetype_title("Bus Fee");
                    $backstage->add_fee_into_student_due($std_id, $feetype_id, $bus_fee, 'Added on admission time', $nepaliDate, $LOGIN_CAT, $LOGIN_ID, 1); 
                  }
                  if (!empty($hostel) && !empty($hostel_fee)) {
                    $feetype_id = $backstage->get_feetype_id_by_feetype_title("Hostel Fee");
                    $backstage->add_fee_into_student_due($std_id, $feetype_id, $hostel_fee, 'Added on admission time', $nepaliDate, $LOGIN_CAT, $LOGIN_ID, 1); 
                  }
                  if (!empty($computer) && !empty($computer_fee)) {
                    $feetype_id = $backstage->get_feetype_id_by_feetype_title("Computer Fee");
                    $backstage->add_fee_into_student_due($std_id, $feetype_id, $computer_fee, 'Added on admission time', $nepaliDate, $LOGIN_CAT, $LOGIN_ID, 1); 
                  }

                  // insert student year history into syearhistory
                  $backstage->insert_year_into_student_history($std_id,$sclass,$ssec,$sroll,$payment_type,$tution,$tution_fee,$studentbusid,$bus_fee,$hostel,$hostel_fee,$computer,$computer_fee,$year_id,$newdate);

                    // Add Other fee to student due
                    if(count($otherFeeType)>0){
                      $feetype_id = 0;
                      foreach ($otherFeeType as $index => $feetypeId){
                        if( !empty($feetypeId) && !empty($otherFeeValue[$index]) ){
                          $feetype_id = $feetypeId;
                          $balance = $otherFeeValue[$index];

                          $backstage->add_fee_into_student_due($std_id, $feetype_id, $balance, 'Added on admission time', $nepaliDate, $LOGIN_CAT, $LOGIN_ID, 1);
                        }
                        
                      }
                    }

                      //echo inserted
                      $msg= "Student succesfully added";

                    }else{
                      $msg= "ERROR: Could not able to execute - " . mysqli_error($db);
                    }

                      } else{ $msg = $errMSG; }

                    

            }else{ $msg="Bus fee is not in valid format";  }
            }else{ $msg="Computer fee is not in valid format";  }
            }else{ $msg="Hostel fee is not in valid format";  }
            }else{ $msg="Tution fee is not in valid format";  }

            }else{ $msg="Please select payment method";  }
            // }else{ $msg="Please select student date of birth";  }
            }else{ $msg="Please select gender..";  }
            }else{ $msg="Please select section";  }
            }else{ $msg="Please select class";  }
            // }else{ $msg="Please enter student address";  }
            }else{ $msg="Please enter student name";  }
            // }else{ $msg="Select parent first";  }
                
      $_SESSION['result_success'] = $msg;
      echo $msg;
    }
/*=================================Add parent script==========================================*/
    else if (isset($_POST['spname'])) {
      $errMSG='';

            $msg='';
            $spname=$_POST['spname'];
            $smname=$_POST['smname'];
            $spphone=$_POST['sppassword1'];
            $spphone2=$_POST['sppassword2'];
            $spnumber=$_POST['spnumber'];
            $spnumber_2=$_POST['spnumber2'];
            $spemail=$_POST['spemail'];
            $spprof=$_POST['spprof'];
            $sp_address=$_POST['spaddress'];

              if (!empty($spname) || !empty($smname)){
                // if (!empty($spprof)){
                  // if(!empty($spnumber)){
                    // if(!empty($sp_address)){

                  if(!empty($spphone) || !empty($spphone2)){
                  if (strlen($spphone)<6) { $errMSG="Password is less than 6 charater"; }
                          elseif ($spphone!=$spphone2) { $errMSG="Password does not match"; }else{}
                  }else{ $spphone=""; }

                    if(!empty($spnumber)){
                      if (strlen($spnumber)!=10) { $errMSG="Mobile number should be 10 digit long"; }
                      }

                        if(!empty($spemail)){
                          if (!filter_var($spemail, FILTER_VALIDATE_EMAIL)) {
                              $errMSG = "Invalid email format"; 
                          }else{
                            $checkexist = $backstage->check_parent_email_exist($spemail);
                            if ($checkexist) {
                              $errMSG="Email id already exist with another account";
                            }
                          }
                        }else{$spemail=''; }

                          if (empty($spname)) { $spname=''; }
                          if (empty($smname)) { $smname=''; }
                          if (empty($spnumber_2)) { $spnumber_2=''; }
                          if (empty($spprof)) { $spprof=''; }

                        if(empty($errMSG)){
                        $insertintoparent = "INSERT INTO `parents` (`spname`, `smname`, `spemail`, `spphone`, `spnumber`, `spnumber_2`, `spprofession`, `sp_address`) VALUES ('$spname', '$smname', '$spemail', '$spphone', '$spnumber', '$spnumber_2', '$spprof', '$sp_address')";

                          if(mysqli_query($db, $insertintoparent)) { $msg= "Parent succesfully added";
                          }else{ $msg= "ERROR: Could not able to execute - " . mysqli_error($db); } 
                        }else{ $msg=$errMSG;}                                
                    
                  // }else{ $msg="Please enter parent's address";  }
                // }else{ $msg="Please enter parent's number";  }
              // }else{ $msg="Please enter parent's Profession";  }
            }else{ $msg="Please enter father's name or mother's name or both";  }
                
      $_SESSION['result_success']=$msg;
      echo $msg;
    }
/*=================================Add Teacher script==========================================*/
  elseif (isset($_POST['add_teacher_request'])) {

          $errMSG='';
          $tname=$_POST['name'];
          $temail=$_POST['email'];
          $tgetter=$_POST['password1'];
          $tgetter1=$_POST['password2'];
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

          $uFile = $_FILES['tpic']['name'];
          $tmp_dir = $_FILES['tpic']['tmp_name'];
          $fileSize = $_FILES['tpic']['size'];
          $fileType = $_FILES['tpic']['type'];

          $uFile1 = $_FILES['tdoc1']['name'];
          $tmp_dir1 = $_FILES['tdoc1']['tmp_name'];
          $fileSize1 = $_FILES['tdoc1']['size'];
          $fileType1 = $_FILES['tdoc1']['type'];

          $uFile2 = $_FILES['tdoc2']['name'];
          $tmp_dir2 = $_FILES['tdoc2']['tmp_name'];
          $fileSize2 = $_FILES['tdoc2']['size'];
          $fileType2 = $_FILES['tdoc2']['type'];

          $uFile3 = $_FILES['tdoc3']['name'];
          $tmp_dir3 = $_FILES['tdoc3']['tmp_name'];
          $fileSize3 = $_FILES['tdoc3']['size'];
          $fileType3 = $_FILES['tdoc3']['type'];
          

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

                if(!empty($tgetter) || !empty($tgetter1)){
                  if (strlen($tgetter)<6) { $errMSG="Student password is less than 6 charater"; }
                          elseif ($tgetter!=$tgetter1) { $errMSG="Student password does not match"; }else{}
                  }else{ $tgetter=""; }

                if(!empty($tmobile)){
                  if (strlen($tmobile)!=10) { $errMSG="Mobile number should be 10 digit long"; }
                  }

                  if(!empty($temail)){
                    if (!filter_var($temail, FILTER_VALIDATE_EMAIL)) {
                      $errMSG = "Invalid email format"; 
                    }else{
                      $checkexist = $backstage->check_teacher_email_exist($temail);
                      if ($checkexist) {
                        $errMSG="Email id already exist with another account";
                      }
                    }
                  }else{ $temail=""; }

                  $maxidnew = (int)$backstage->get_max_teacher_id()+1;

                  if(!empty($uFile) && empty($errMSG))
                    { $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/';
                   $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION));
                   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
                   $ufile1 = "teacher".$maxidnew.".".$fileExt;
                   if(in_array($fileExt, $valid_extensions)){ 
                    if($fileSize < 5000000)    {
                     if(move_uploaded_file($tmp_dir,$upload_dir.$ufile1)){
                     }else{ $errMSG="failed to upload picture"; } }
                    else{ $errMSG = "Sorry, picture size is more than 2 MB"; } }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , GIF files are allowed."; } }

                if(!empty($uFile1) && empty($errMSG))
                  { $upload_dir1 = '../uploads/'.$fianlsubdomain.'/docs/';
                   $fileExt1 = strtolower(pathinfo($uFile1,PATHINFO_EXTENSION)); 
                   $valid_extensions1 = array('jpeg', 'jpg', 'png', 'pdf', 'txt', 'doc', 'docx');
                   $ufile11 = "teacher".$maxidnew.".".$fileExt1; 
                   if(in_array($fileExt1, $valid_extensions1)){  
                    if($fileSize1 < 5000000)   { 
                     if(move_uploaded_file($tmp_dir1,$upload_dir1.$ufile11)){
                     }else{$errMSG="failed to upload Citizenship"; } }
                    else{ $errMSG = "Sorry, Citizenship size is more than 2 MB"; }  }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , PDF, TXT, DOC, DOCX files are allowed for Citizenship"; } }

                   if(!empty($uFile2) && empty($errMSG))
                    { $upload_dir2 = '../uploads/'.$fianlsubdomain.'/docs/';
                   $fileExt2 = strtolower(pathinfo($uFile2,PATHINFO_EXTENSION)); 
                   $valid_extensions2 = array('jpeg', 'jpg', 'png', 'pdf', 'txt', 'doc', 'docx');
                   $ufile12 = "teacher".$maxidnew.".".$fileExt2; 
                   if(in_array($fileExt2, $valid_extensions2)){  
                    if($fileSize2 < 5000000)   { 
                     if(move_uploaded_file($tmp_dir2,$upload_dir2.$ufile12)){
                     }else{$errMSG="failed to upload CV"; } }
                    else{ $errMSG = "Sorry, CV size is more than 2 MB"; }  }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , PDF, TXT, DOC, DOCX files are allowed for CV"; } }

                   if(!empty($uFile3) && empty($errMSG))
                    { $upload_dir3 = '../uploads/'.$fianlsubdomain.'/docs/';
                   $fileExt3 = strtolower(pathinfo($uFile3,PATHINFO_EXTENSION)); 
                   $valid_extensions3 = array('jpeg', 'jpg', 'png', 'pdf', 'txt', 'doc', 'docx');
                   $ufile13 = "teacher".$maxidnew.".".$fileExt3; 
                   if(in_array($fileExt3, $valid_extensions3)){  
                    if($fileSize3 < 5000000)   { 
                     if(move_uploaded_file($tmp_dir3,$upload_dir3.$ufile13)){
                     }else{$errMSG="failed to upload other document"; } }
                    else{ $errMSG = "Sorry, Other document size is more than 2 MB"; }  }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , PDF, TXT, DOC, DOCX files are allowed for other document"; } }

                      // if no error occured, continue ....
                      if(empty($errMSG))
                      { if (empty($ufile1)) { $ufile1=''; } 
                        if (empty($ufile11)) { $ufile11=''; } 
                        if (empty($ufile12)) { $ufile12=''; }
                        if (empty($ufile13)) { $ufile13=''; }

                      $insertintoteacher = "INSERT INTO `teachers`(`tname`, `temail`, `tgetter`, `taddress`, `tmobile`, `tcount`, `tclock`, `sex`, `dob`, `designation`, `blood_group`, `t_father`, `t_mother`, `t_country`, `t_phone`, `t_marital`, `t_id_proof`, `t_doc2`, `t_doc3`, `t_join_date`, `timage`, `tsalary`, `t_jobtype`, `status`) VALUES ('$tname','$temail','$tgetter','$taddress','$tmobile',0,CURRENT_TIMESTAMP,'$tsex','$dob','$designation','$blood_group','$tfather','$tmother','$tcountry','$tphone','$m_status','$ufile11','$ufile12','$ufile13','$doj','$ufile1','$tsalary','$tjobtype',0)";
                          
                          if(mysqli_query($db, $insertintoteacher)) { 

                              //echo inserted
                              $msg= "Teacher succesfully added";                  

                          } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db); }

                        } else{ $msg=$errMSG; }


                  }else{ $msg = "please select marital status.."; }
                }else{ $msg = "please select gender.."; }
              }else{ $msg = "please enter nationality name.."; }
            }else{ $msg = "please enter mobile number.."; }
          }else{ $msg = "Please enter teacher address.."; }
        }else{ $msg = "Please enter teacher name.."; }
                
      $_SESSION['result_success']=$msg;
      echo $msg;
    }
/*=================================Add Staff script==========================================*/
  elseif (isset($_POST['add_staff_request'])) {

          $stname=$_POST['stname'];
          $stemail=$_POST['stemail'];
          $stgetter=$_POST['stpassword1'];
          $stgetter1=$_POST['stpassword2'];
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


          $uFile = $_FILES['stpic']['name'];
          $tmp_dir = $_FILES['stpic']['tmp_name'];
          $fileSize = $_FILES['stpic']['size'];
          $fileType = $_FILES['stpic']['type'];

          $uFile1 = $_FILES['stdoc1']['name'];
          $tmp_dir1 = $_FILES['stdoc1']['tmp_name'];
          $fileSize1 = $_FILES['stdoc1']['size'];
          $fileType1 = $_FILES['stdoc1']['type'];

          $uFile2 = $_FILES['stdoc2']['name'];
          $tmp_dir2 = $_FILES['stdoc2']['tmp_name'];
          $fileSize2 = $_FILES['stdoc2']['size'];
          $fileType2 = $_FILES['stdoc2']['type'];

          $uFile3 = $_FILES['stdoc3']['name'];
          $tmp_dir3 = $_FILES['stdoc3']['tmp_name'];
          $fileSize3 = $_FILES['stdoc3']['size'];
          $fileType3 = $_FILES['stdoc3']['type'];

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
                    if (empty($doj)) { $doj="0000-00-00"; }
                    if (empty($stphone)) { $stphone=''; }
                    if (empty($stfather)) { $stfather=''; }
                    if (empty($stmother)) { $stmother=''; }
                    if (empty($stpos)) { $stpos=''; }
                    if (empty($blood_group)) { $blood_group=0; }

                    

                    if(!empty($stgetter) || !empty($stgetter1)){
                        if (strlen($stgetter)<6) { $errMSG="Password is less than 6 charater"; 
                        }else if ($stgetter!=$stgetter1) { $errMSG="Student password does not match"; }
                    }else{ $stgetter=""; }

                    if($sttype!='Other') { $stother='';}


                    if(!empty($stemail)){ //check email exist
                      if (!filter_var($stemail, FILTER_VALIDATE_EMAIL)) {
                              $errMSG = "Invalid email format"; 
                        }else{
                          $checkexist = $backstage->check_staff_email_exist($stemail);
                          if ($checkexist) {
                            $errMSG="Email id already exist with another account";
                          }
                        }
                    }else{ $stemail=''; }

                   
                   $maxidnew = (int)$backstage->get_max_staff_id()+1;

                  if(!empty($uFile) && empty($errMSG))
                    { $upload_dir = '../uploads/'.$fianlsubdomain.'/profile_pic/';
                   $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION));
                   $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');
                   $ufile1 = "staff".$maxidnew.".".$fileExt;
                   if(in_array($fileExt, $valid_extensions)){ 
                    if($fileSize < 5000000)    {
                     if(move_uploaded_file($tmp_dir,$upload_dir.$ufile1)){
                     }else{ $errMSG="failed to upload picture"; } }
                    else{ $errMSG = "Sorry, picture size is more than 2 MB"; } }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , GIF files are allowed."; } }

                if(!empty($uFile1) && empty($errMSG))
                  { $upload_dir1 = '../uploads/'.$fianlsubdomain.'/docs/';
                   $fileExt1 = strtolower(pathinfo($uFile1,PATHINFO_EXTENSION)); 
                   $valid_extensions1 = array('jpeg', 'jpg', 'png', 'pdf', 'txt', 'doc', 'docx');
                   $ufile11 = "staff".$maxidnew.".".$fileExt1; 
                   if(in_array($fileExt1, $valid_extensions1)){  
                    if($fileSize1 < 5000000)   { 
                     if(move_uploaded_file($tmp_dir1,$upload_dir1.$ufile11)){
                     }else{$errMSG="failed to upload Citizenship"; } }
                    else{ $errMSG = "Sorry, Citizenship size is more than 2 MB"; }  }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , PDF, TXT, DOC, DOCX files are allowed for Citizenship"; } }

                   if(!empty($uFile2) && empty($errMSG))
                    { $upload_dir2 = '../uploads/'.$fianlsubdomain.'/docs/';
                   $fileExt2 = strtolower(pathinfo($uFile2,PATHINFO_EXTENSION)); 
                   $valid_extensions2 = array('jpeg', 'jpg', 'png', 'pdf', 'txt', 'doc', 'docx');
                   $ufile12 = "staff".$maxidnew.".".$fileExt2; 
                   if(in_array($fileExt2, $valid_extensions2)){  
                    if($fileSize2 < 5000000)   { 
                     if(move_uploaded_file($tmp_dir2,$upload_dir2.$ufile12)){
                     }else{$errMSG="failed to upload CV"; } }
                    else{ $errMSG = "Sorry, CV size is more than 2 MB"; }  }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , PDF, TXT, DOC, DOCX files are allowed for CV"; } }

                   if(!empty($uFile3) && empty($errMSG))
                    { $upload_dir3 = '../uploads/'.$fianlsubdomain.'/docs/';
                   $fileExt3 = strtolower(pathinfo($uFile3,PATHINFO_EXTENSION)); 
                   $valid_extensions3 = array('jpeg', 'jpg', 'png', 'pdf', 'txt', 'doc', 'docx');
                   $ufile13 = "staff".$maxidnew.".".$fileExt3; 
                   if(in_array($fileExt3, $valid_extensions3)){  
                    if($fileSize3 < 5000000)   { 
                     if(move_uploaded_file($tmp_dir3,$upload_dir3.$ufile13)){
                     }else{$errMSG="failed to upload other document"; } }
                    else{ $errMSG = "Sorry, Other document size is more than 2 MB"; }  }
                   else{ $errMSG = "Sorry, only JPG, JPEG, PNG , PDF, TXT, DOC, DOCX files are allowed for other document"; } }

                      // if no error occured, continue ....
                      if(!isset($errMSG))
                      { if (empty($ufile1)) { $ufile1=''; } 
                        if (empty($ufile11)) { $ufile11=''; } 
                        if (empty($ufile12)) { $ufile12=''; }
                        if (empty($ufile13)) { $ufile13=''; }

                      $insertintostaff = "INSERT INTO `staff_tbl`( `staff_name`, `staff_address`, `staff_mobile`, `staff_type`, `staff_typedesc`, `staff_salary`, `staff_email`, `staff_phone`, `staff_getter`, `staff_sex`, `staff_position`, `staff_marital`, `staff_dob`,`blood_group`, `staff_father`, `staff_mother`, `staff_country`, `staff_image`, `staff_doc`, `staff_doc2`, `staff_doc3`, `staff_joindate`,`staff_status`) VALUES ('$stname','$staddress','$stmobile','$sttype','$stother','$stsalary','$stemail','$stphone','$stgetter','$stsex','$stpos','$stmstatus','$dob','$blood_group','$stfather','$stmother','$stcountry','$ufile1','$ufile11','$ufile12','$ufile13','$doj',0)";
                          
                          if(mysqli_query($db, $insertintostaff)) {  
                              //echo inserted
                              $msg= "Staff succesfully added";                  

                          } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db); }

                        } else{ $msg=$errMSG; }

                  
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
/*=================================Add Class script==========================================*/
    else if (isset($_POST['add_class_request'])) {

      $classname = mysqli_real_escape_string($db,$_POST['classname']);
      $classsymbolic = mysqli_real_escape_string($db,$_POST['classsymbolic']);
      $sort_order = $_POST['sort_order'];
      $classadmission = mysqli_real_escape_string($db,$_POST['classadmission']);
      $monthy_tution_fee = mysqli_real_escape_string($db,$_POST['monthy_tution_fee']);
      $annual_fee = mysqli_real_escape_string($db,$_POST['annual_fee']);
      $computer_fee = mysqli_real_escape_string($db,$_POST['computer_fee']);
      $hostel_fee = mysqli_real_escape_string($db,$_POST['hostel_fee']);
      $exam_fee = mysqli_real_escape_string($db,$_POST['exam_fee']);
      $monthly_test_fee = mysqli_real_escape_string($db,$_POST['monthly_test_fee']);
      $uniform_fee = mysqli_real_escape_string($db,$_POST['uniform_fee']);
      $book_fee = mysqli_real_escape_string($db,$_POST['book_fee']);
      $registrationfee = mysqli_real_escape_string($db,$_POST['registrationfee']);
      $securityfee = mysqli_real_escape_string($db,$_POST['securityfee']);

      $year_id = mysqli_real_escape_string($db,$_POST['year_id']);


      if (!empty($classname)) {
        if (!empty($classsymbolic)) {
          if (!empty($year_id)) {
          /*if (!empty($monthy_tution_fee)) {*/

            if (empty($classadmission) || $classadmission=='0' ) { $classadmission=0.0; }
            if (empty($monthy_tution_fee) || $monthy_tution_fee=='0') { $monthy_tution_fee=0.0; }
            if (empty($annual_fee) || $annual_fee=='0') { $annual_fee=0.0; }
            if (empty($computer_fee) || $computer_fee=='0') { $computer_fee=0.0; }
            if (empty($hostel_fee) || $hostel_fee=='0') { $hostel_fee=0.0; }
            if (empty($exam_fee) || $exam_fee=='0') { $exam_fee=0.0; }
            if (empty($monthly_test_fee) || $monthly_test_fee=='0') { $monthly_test_fee=0.0; }
            if (empty($uniform_fee) || $uniform_fee=='0') { $uniform_fee=0.0; }
            if (empty($book_fee) || $book_fee=='0') { $book_fee=0.0; }
            if (empty($registrationfee) || $registrationfee=='0') { $registrationfee=0.0; }
            if (empty($securityfee) || $securityfee=='0') { $securityfee=0.0; }

            if ($sort_order<0 || $sort_order >99) {
              $sort_order = 0;
            }

            $class_name1=strtolower($classname);
            $class_name2=ucwords($classname);
            $class_name3=strtoupper($classname); 

            $sqlcheck="SELECT * FROM `class` WHERE (`class_name`='$classname' OR `class_name`='$class_name1' OR `class_name`='$class_name2' OR `class_name`='$class_name3') AND `year_id` = '$year_id' ";
              $resultcheck=mysqli_query($db, $sqlcheck);
              $count=mysqli_num_rows($resultcheck);
              if($count<1){

            $sqlcheck1="SELECT * FROM `class` WHERE `class_symbolic` = '$classsymbolic'  AND `year_id` = '$year_id' ";
              $resultcheck1=mysqli_query($db, $sqlcheck1);
              $count1=mysqli_num_rows($resultcheck1);
              if($count1<1){

                $insertintoclass = "INSERT INTO `class`(`class_name` , `class_symbolic` , `tution_fee`, `computer_fee`, `hostel_fee`, `admission_charge`, `annual_fee`, `exam_fee`, `uniform_fee`, `book_fee`, `monthly_test_fee`, `registration_fee`, `security_fee`, `year_id`, `sort_order`) VALUES ('$classname', '$classsymbolic', '$monthy_tution_fee', '$computer_fee', '$hostel_fee', '$classadmission', '$annual_fee', '$exam_fee', '$uniform_fee', '$book_fee', '$monthly_test_fee', '$registrationfee', '$securityfee', '$year_id', '$sort_order' )";
                  
                  if(mysqli_query($db, $insertintoclass)) {

                    //get the last added id
                    $class_id = mysqli_insert_id($db);

                      //echo inserted
                      $msg = "Class added successfully";                   

                  } else { $msg = "ERROR: Could not able to execute - " . mysqli_error($db);
                        }
                }else{ $msg = "Numeric class name is already exist!!"; }
                }else{ $msg = "class name is already exist!!"; }

         /* }else{ $msg = "Monthly tution fee is missing!!"; }*/

          }else{ $msg = "Academic year id is missing"; }

        }else{ $msg = "Numeric class name is missing"; }
      }else{ $msg = "Class name is missing"; }
      
                
      $_SESSION['result_success']=$msg;
      echo $msg;
    }
/*=================================Add Subject script==========================================*/
    else if (isset($_POST['add_subject_request'])) {

    $errMsg = "";

    $subjectId = $_POST['subjectId'];

    $examCount = $_POST['examCount'];

    $subType = $_POST['subType'];

    $subjectname = $_POST['subjectname'];
    $major = $_POST['major'];
    
    $classId = $_POST['classId'];
    $sortOrder = $_POST['sortOrder'];
    $teacherId = $_POST['teacherId'];

    $subject_mark_id = $_POST['subject_mark_id'];

    $examtype_id = $_POST['examtype_id'];

    $year_id = $_POST['year_id'];

    $tfm = $_POST['tfm'];
    $tpm = $_POST['tpm'];
    $pfm = $_POST['pfm'];
    $ppm = $_POST['ppm'];

    $mt = $_POST['mt'];
    $ot = $_POST['ot'];
    $eca = $_POST['eca'];
    $lp = $_POST['lp'];
    $nb = $_POST['nb'];
    $se = $_POST['se'];

        if (!empty($year_id)) {
          if (!empty($subjectname)) {
            if (!empty($classId)) {

              if ($sortOrder <0 || $sortOrder >99) {
                $sortOrder=0;
              }

              if ($subType==101){                
                $subject_type=0;
              }elseif($subType==202){
                $subject_type=1;
              }elseif($subType==303){
                $subject_type=3;
              }

              $subject_name=strtolower($subjectname);
              $subject_name1=ucwords($subjectname);
              $subject_name2=strtoupper($subjectname);

              if (!empty($subjectId)) {

                $sqlcheck="SELECT * FROM `subject` WHERE  (`subject_name`='$subjectname' OR `subject_name`='$subject_name' OR `subject_name`='$subject_name1' OR `subject_name`='$subject_name2') AND `subject_id`<>'$subjectId' AND `subject_class`='$classId' AND `year_id`='$year_id'";
                 $resultcheck=mysqli_query($db, $sqlcheck);
                 $countexist=mysqli_num_rows($resultcheck);

                 if($countexist<1){

                  $insertintosubject = "UPDATE `subject` SET `subject_name`='$subjectname', `major`='$major', `teacher_id`='$teacherId', `sort_order` = '$sortOrder', `subject_type`='$subject_type' WHERE `subject_id`='$subjectId'";

                 }else{  $errMsg = "Subject Name already exists"; }

              }else{
                
                $sqlcheck="SELECT * FROM `subject` WHERE `subject_class`='$classId'  AND `year_id`='$year_id' AND (`subject_name`='$subjectname' OR `subject_name`='$subject_name' OR `subject_name`='$subject_name1' OR `subject_name`='$subject_name2')";
                 $resultcheck=mysqli_query($db, $sqlcheck);
                 $count=mysqli_num_rows($resultcheck);

                if($count<1){

                  $insertintosubject = "INSERT INTO `subject`(`subject_name`, `major`, `subject_class`, `teacher_id`, `sort_order`, `subject_type`, `year_id`) VALUES ('$subjectname','$major','$classId','$teacherId','$sortOrder','$subject_type' ,'$year_id')";


                }else{

                  $rowchecksubject = mysqli_fetch_assoc($resultcheck);
                  $substatus=$rowchecksubject["status"];
                  $subjectid2=$rowchecksubject["subject_id"];
                  if($substatus=='1'){

                    $insertintosubject = "UPDATE `subject` SET `subject_name`='$subjectname', `major`='$major', `teacher_id`='$teacherId', `sort_order` = '$sortOrder', `subject_type`='$subject_type', `status`= 0 WHERE `subject_id`='$subjectid2'";

                
                    }else{  $errMsg = "Subject Name already exists"; }

                }

              }

              


              if (empty($errMsg)) {                
                  
                if(mysqli_query($db, $insertintosubject)) {

                  if (!empty($subjectId)) {
                    $subject_id = $subjectId;
                    $msg = "Subject succesfully updated";
                  }else{
                    //get the last added id
                    $subject_id = mysqli_insert_id($db); 
                    $msg = "Subject succesfully added";
                  }

                  $markValue = $tfm_final = $tpm_final = $pfm_final = $ppm_final = 0;

                  for ($i=0; $i < $examCount ; $i++) {


                    if ($subType==101){
                      $tfm_final=$tfm[$i];
                      $tpm_final=$tpm[$i];
                      $pfm_final="";
                      $ppm_final="";
                    }elseif($subType==202){
                      $tfm_final=$tfm[$i];
                      $tpm_final=$tpm[$i];
                      $pfm_final=$pfm[$i];
                      $ppm_final=$ppm[$i];
                    }elseif($subType==303){
                      $tfm_final="";
                      $tpm_final="";
                      $pfm_final="";
                      $ppm_final="";
                    }


                    if (  !empty($tfm[$i]) || !empty($tpm[$i])  || !empty($pfm[$i])  || !empty($ppm[$i])  || !empty($mt[$i])  || !empty($ot[$i])  || !empty($eca[$i])  || !empty($lp[$i])  || !empty($nb[$i])  || !empty($se[$i]) ) {

                      $markValue = 1; 

                    }else{ $markValue = 0; }

                    if (  !empty($mt[$i]) )   { $mt_final = 1;  }else{  $mt_final = 0;  }
                    if (  !empty($ot[$i]) )   { $ot_final = 1;  }else{  $ot_final = 0;  }
                    if (  !empty($eca[$i])  ) { $eca_final = 1; }else{  $eca_final = 0;  }
                    if (  !empty($lp[$i]) )   { $lp_final = 1;  }else{  $lp_final = 0;  }
                    if (  !empty($nb[$i]) )   { $nb_final = 1;  }else{  $nb_final = 0;  }
                    if (  !empty($se[$i]) )   { $se_final = 1;  }else{  $se_final = 0;  }


                    // ADD SUBJECT MARK IF SUBJECT MARK_ID IS NOT AVAILABLE 
                    if ($markValue == 1 && empty($subject_mark_id[$i])) {    
                    

                      $sql = "INSERT INTO `subject_mark` (`examtype_id`, `subject_id`, `th_fm`, `th_pm`, `pr_fm`, `pr_pm`, `mt`, `ot`, `eca`, `lp`, `nb`, `se`, `year_id`) VALUES ('$examtype_id[$i]', '$subject_id', '$tfm_final', '$tpm_final', '$pfm_final', '$ppm_final', '$mt_final', '$ot_final', '$eca_final', '$lp_final', '$nb_final', '$se_final', '$year_id')";
                        
                        if(mysqli_query($db, $sql)) {

                            $errMsg .= "Subject mark succesfully added";

                        } else { $errMsg .= "Sorry, Could not able to create mark - " . mysqli_error($db);  }

                    // UPDATE EXAM TABLE IF SUBJECT MARK ID IS AVAILABLE
                    }else if($markValue == 1 && !empty($subject_mark_id[$i])){ 


                      $sql = "UPDATE `subject_mark` SET `th_fm` = '$tfm_final' , `th_pm` = '$tpm_final' , `pr_fm` = '$pfm_final' , `pr_pm` = '$ppm_final' , `mt` = '$mt_final' , `ot` = '$ot_final' , `eca` = '$eca_final' , `lp` = '$lp_final' , `nb` = '$nb_final' , `se` = '$se_final' WHERE `id` = '$subject_mark_id[$i]' ";
                        
                        if(mysqli_query($db, $sql)) {

                            $errMsg .= "Subject mark succesfully updated";

                        } else { $errMsg .= "Sorry, Could not able to create mark - " . mysqli_error($db);  }
                    
                    // DELETE EXAM TABLE IF SUBJECT MARK ID IS AVAILABLE AND EMPTY
                    }else if($markValue == 0 && !empty($subject_mark_id[$i])){


                      $sqldelete = "DELETE FROM `subject_mark` WHERE `id` ='$subject_mark_id[$i]' ";
                          
                          if(mysqli_query($db, $sqldelete)) {

                            $errMsg .= "Subject mark succesfully deleted";

                          }else {  $errMsg .= "Sorry, Failed to delete marks - " . mysqli_error($db); }
                    }

                  }

                }else { $msg = "Sorry!, Failed to add- " . mysqli_error($db); }
                  
              }else { $msg = $errMsg; }
              
            }else{ $msg = "Class Name is missing"; }
            }else{ $msg = "Subject  Name is missing"; }
          }else{ $msg = "Year id is missing"; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }
/*================================= Add/UPDATE EXAM INCLUDE script==========================================*/
    else if (isset($_POST['update_exam_include_request'])) {

      $errMsg = "";

      $update_id = $_POST['update_id'];

      $examtype_id = $_POST['examtype_id'];

      $selected_exam = $_POST['selected_exam'];

      $year_id = $_POST['year_id'];

      $percent = $_POST['percent'];

      $sort_order = $_POST['sort_order'];



      // ADD EXAM INCLUDE IF UDATE ID IS EMPTY
      if (empty($update_id)) {


        // Check to prevent add same exam name repeation
        $sqlcheck="SELECT * FROM `exam_include` WHERE `examtype_id`='$examtype_id' AND `added_examtype_id`='$selected_exam' AND `year_id` = '$year_id' ";
          $resultcheck=mysqli_query($db, $sqlcheck);
          $count=mysqli_num_rows($resultcheck);

          if($count<1){

            $sqltoberun = "INSERT INTO `exam_include`(`examtype_id`, `added_examtype_id`, `percent`, `sort_order`, `year_id`) VALUES ('$examtype_id','$selected_exam','$percent','$sort_order','$year_id')";


          }else{

              $errMsg = "Sorry, Selected exam already exist..";
          }


      // UPDATE EXAM INCLUDE IF UDATE ID IS NOT EMPTY
      }else{

        // Check to prevent add same exam name repeation
        $sqlcheck="SELECT * FROM `exam_include` WHERE  `examtype_id`='$examtype_id' AND `added_examtype_id`='$selected_exam' AND `exam_include_id`<>'$update_id' AND `year_id`='$year_id'";
                 $resultcheck=mysqli_query($db, $sqlcheck);
                 $countexist=mysqli_num_rows($resultcheck);

        if($countexist<1){

          $sqltoberun = "UPDATE `exam_include` SET `added_examtype_id`='$selected_exam', `percent` = '$percent', `sort_order`='$sort_order' WHERE `exam_include_id`='$update_id'";

        }else{  $errMsg = "Sorry, Selected exam already exist.."; }

      }

      if (empty($errMsg)) {                
                  
        if(mysqli_query($db, $sqltoberun)) {

          $msg = "Exam setting successfully updated";

        }else { $msg = "Sorry!, Failed to update- " . mysqli_error($db); }
                  
      }else { $msg = $errMsg; }
          



      $_SESSION['result_success']=$msg;
      echo $msg;
    }
/*=================================Add Slider Image script==========================================*/
    else if (isset($_POST['add_slider_image'])) {

    $slider_name=$_POST['slider_name'];
    $slider_desc=$_POST['slider_desc'];
    
    $uFile = $_FILES['slider']['name'];
    $tmp_dir = $_FILES['slider']['tmp_name'];
    $fileSize = $_FILES['slider']['size'];
    $fileType = $_FILES['slider']['type'];

          if (!empty($slider_name)) {
            if (!empty($slider_desc)) {

              if(empty($uFile)){
                 $msg = "Please Add Image.";
                }
                else 
                {
                 $upload_dir = '../uploads/'.$fianlsubdomain.'/slides/'; // upload directory
               
                 $fileExt = strtolower(pathinfo($uFile,PATHINFO_EXTENSION)); // get file extension
                
                 // valid image extensions
                 $valid_extensions = array('jpeg', 'jpg', 'png', 'gif'); // valid extensions
                
                 // rename uploading image
                 $ufile = "slide".rand(1000,1000000).".".$fileExt;
                 //$ufile = $fname.".".$fileExt;

                  // check image storage limit
                  $sqlcheck = "SELECT * FROM `slider`";
                  $result2 = $db->query($sqlcheck);
                  $rowCount = $result2->num_rows;
                  if($rowCount > 5) {
                    $msg="Sorry, Can't upload more than 6 slide....";
                  } else{
                  
                 // allow valid image file formats
                 if(in_array($fileExt, $valid_extensions)){ 

                  // Check file size '5MB'
                  if($fileSize < 5000000)    {

                   if(move_uploaded_file($tmp_dir,$upload_dir.$ufile)){
                    $msg="file moved";


                   }else{ $msg="failed to upload"; }
                  } else{ $msg = "Sorry, your file is too large."; }
                 } else{ $msg = "Sorry, only JPG, JPEG, PNG , GIF files are allowed."; }
                }
              }
                
                // if no error occured, continue ....
                if($msg=='file moved')
                {
              $insertslide = "INSERT INTO `slider`(`slider_location`, `slider_image`, `slider_title`, `slider_desc`) VALUES ('$upload_dir','$ufile','$slider_name','$slider_desc')";
                                
                                if(mysqli_query($db, $insertslide)) {  
                                //echo inserted
                                  $msg = "Slider uploaded succesfully";
                 }
                 else { $msg = "Failed to upload,Please try again!!";}
                }
              }else{ $msg = "Please write short description"; }
            }else{ $msg = "Please type title first.."; }

      $_SESSION['result_success']=$msg;
      echo $msg;
    }
/*=================================Add Lession plan script==========================================*/
    else if (isset($_POST['add_lession_planning'])) {
          $class = $_POST['class'];
          $section = $_POST['section'];
          $subject_id = $_POST['subject_id'];
          $teacher_id = $_POST['teacher_id'];
          $topic = $_POST['topic'];
          $start_date = $_POST['start_date'];
          $end_date = $_POST['end_date'];
          $assigned_by= $login_session1;

          if (!empty($class)) {
          if (!empty($section)){
          if (!empty($subject_id)){
          if (!empty($teacher_id)){
          if (!empty($topic)){
          if (!empty($start_date)){
          if (!empty($end_date)){          

              if ((strtotime($_POST['start_date'])) > (strtotime($_POST['end_date']))){
                $msg="Please select end date properly";   
              }else{ 


              $start_date_new = $start_date;
              $end_date_new =  $end_date;

              if($login_date_type==2){
                  $start_date_new = nToE($start_date_new);
                  $end_date_new = nToE($end_date_new);
              }
             
      
           $qry="INSERT INTO `lesson_planning`(`class`, `section`, `subject_id`, `teacher_id`, `topic`,`remark`, `assign_date`, `start_date`, `end_date`, `percentage`, `assigned_by`, `year_id`, `status`) VALUES ('$class','$section','$subject_id','$teacher_id','$topic' , NULL ,NOW(),'$start_date_new','$end_date_new',0.0,'$assigned_by', '$yearId', 0 )";
            $result=mysqli_query($db,$qry);
            
            if($result)
            { 
             $msg="Lesson plan succesfully added";
            }else{
              
              $msg="Failed to update:".mysqli_error($db);
            }
            }
            }else{ $msg="Please select end date"; }
            }else{ $msg="Please select start date"; }
            }else{ $msg="Please select topic"; }
            }else{ $msg="Please select teacher"; }
            }else{ $msg="Please select subject"; }
          }else{ $msg="Please select section"; }
          }else{ $msg="Please select class first"; }



          $_SESSION["result_success"] = $msg;
        echo $msg;
      }
/*=================================Add Bus Route And Stoppage script==========================================*/
    else if (isset($_POST['bus_route_action_and_request'])) {

          $bus_route_and_stoppage_action = $_POST['bus_route_action_and_request'];

          $bus_route = $_POST['bus_route'];
          $bus_stop = $_POST['bus_stop'];
          $bus_time = $_POST['bus_time'];
          $fee_rate = $_POST['fee_rate'];          
          

          if (!empty($bus_route)){
          if (!empty($bus_time)){
          if (!empty($fee_rate)){

            if (empty($bus_stop)) { $bus_stop=''; }

          $time24 = date("H:i:s", strtotime($bus_time));

          if ($bus_route_and_stoppage_action=="add") {

            $transportation_id = $_POST['transportation_id'];
      
           $qry="INSERT INTO `bus_route`(`transportation_id`, `bus_route`, `bus_stop`, `bus_time`, `bus_fee_rate`) VALUES ('$transportation_id','$bus_route','$bus_stop','$time24','$fee_rate')";
            $result=mysqli_query($db,$qry);
            
            if($result) {  $msg="Bus route succesfully added";
            }else{ $msg="Failed to add:".mysqli_error($db).$transportation_id; }

          }elseif($bus_route_and_stoppage_action=="update"){

            $bus_route_id = $_POST['bus_route_id'];

            $qry="UPDATE `bus_route` SET `bus_route`='$bus_route', `bus_stop`= '$bus_stop', `bus_time`='$time24', `bus_fee_rate`='$fee_rate' WHERE `bus_route_id` = '$bus_route_id'";
            $result=mysqli_query($db,$qry);
            
            if($result) {  $msg = "Bus route succesfully updated";
            }else{ $msg="Failed to add:".mysqli_error($db); }
          }

            }else{ $msg="Please enter fee rate"; }
            }else{ $msg="Please select estimated bus time"; }
            }else{ $msg="Please select bus route"; }

          $_SESSION["result_success"] = $msg;
        echo $msg;
      }
/*================================= Update roll number script==========================================*/
    else if (isset($_POST['updtae_roll_number'])) {


        $syear_id=$_POST['syear_id'];

         $rowno=$_POST['rowno'];
         $sid=$_POST['sid'];
         $roll=$_POST['roll'];
         $class=$_POST['class'];
         $section=$_POST['section'];

         if ($rowno) {
          for ($i=0; $i < $rowno ; $i++) {

            // $result = mysqli_query($db, "SELECT `sid`  FROM `studentinfo` WHERE `sroll`='$roll[$i]' AND `sclass` = '$class' AND `ssec` = '$section' AND `sid`<>'$sid[$i]'");
            // $count=mysqli_num_rows($result);
            // if($count>0){ 
            //   $msg = "Please correct roll number, it shoud be unique for each student";
            //   break;
            // }else{

                  $sqlroll = "UPDATE `studentinfo` SET `sroll`='$roll[$i]' WHERE `sid`='$sid[$i]'";
                  
                  if(mysqli_query($db, $sqlroll)) { 

                    $backstage->update_student_roll_no_in_student_history_by_syear_id($syear_id[$i],$roll[$i]);


                    $msg = "Roll number succesfully updated"; } 

                  else {  $msg = "Failed to update - " . mysqli_error($db); }
            // }

          }
        }

        $_SESSION["result_success"] = $msg;
        echo $msg;
      }
/*================================= Add And Update Permission of staff and teacher =======================================*/
    else if (isset($_POST['updtae_permission_t_role'])) {

          $id = $_POST['updtae_permission_id'];
          $t_role = $_POST['updtae_permission_t_role'];
          $t_id = $_POST['updtae_permission_t_id'];
          
          if ($_POST['view_attendance']) { $view_attendance = 1; }else{ $view_attendance = 0; }
          if ($_POST['take_attendance']) { $take_attendance = 1; }else{ $take_attendance = 0; }
          if ($_POST['edit_attendance']) { $edit_attendance = 1; }else{ $edit_attendance = 0; }
          if ($_POST['view_gallery']) { $view_gallery = 1; }else{ $view_gallery = 0; }
          if ($_POST['add_gallery']) { $add_gallery = 1; }else{ $add_gallery = 0; }
          if ($_POST['edit_gallery']) { $edit_gallery = 1; }else{ $edit_gallery = 0; }
          if ($_POST['view_elibrary']) { $view_elibrary = 1; }else{ $view_elibrary = 0; }
          if ($_POST['add_elibrary']) { $add_elibrary = 1; }else{ $add_elibrary = 0; }
          if ($_POST['edit_elibrary']) { $edit_elibrary = 1; }else{ $edit_elibrary = 0; }
          if ($_POST['view_daily_routine']) { $view_daily_routine = 1; }else{ $view_daily_routine = 0; }
          if ($_POST['add_daily_routine']) { $add_daily_routine = 1; }else{ $add_daily_routine = 0; }
          if ($_POST['edit_daily_routine']) { $edit_daily_routine = 1; }else{ $edit_daily_routine = 0; }
          if ($_POST['view_student']) { $view_student = 1; }else{ $view_student = 0; }
          if ($_POST['add_student']) { $add_student = 1; }else{ $add_student = 0; }
          if ($_POST['edit_student']) { $edit_student = 1; }else{ $edit_student = 0; }
          if ($_POST['view_teacher']) { $view_teacher = 1; }else{ $view_teacher = 0; }
          if ($_POST['add_teacher']) { $add_teacher = 1; }else{ $add_teacher = 0; }
          if ($_POST['edit_teacher']) { $edit_teacher = 1; }else{ $edit_teacher = 0; }
          if ($_POST['view_class']) { $view_class = 1; }else{ $view_class = 0; }
          if ($_POST['add_class']) { $add_class = 1; }else{ $add_class = 0; }
          if ($_POST['edit_class']) { $edit_class = 1; }else{ $edit_class = 0; }
          if ($_POST['view_subject']) { $view_subject = 1; }else{ $view_subject = 0; }
          if ($_POST['add_subject']) { $add_subject = 1; }else{ $add_subject = 0; }
          if ($_POST['edit_subject']) { $edit_subject = 1; }else{ $edit_subject = 0; }
          if ($_POST['view_exam']) { $view_exam = 1; }else{ $view_exam = 0; }
          if ($_POST['add_exam']) { $add_exam = 1; }else{ $add_exam = 0; }
          if ($_POST['edit_exam']) { $edit_exam = 1; }else{ $edit_exam = 0; }
          if ($_POST['view_mark']) { $view_mark = 1; }else{ $view_mark = 0; }
          if ($_POST['add_mark']) { $add_mark = 1; }else{ $add_mark = 0; }
          if ($_POST['edit_mark']) { $edit_mark = 1; }else{ $edit_mark = 0; }
          if ($_POST['view_lesson']) { $view_lesson = 1; }else{ $view_lesson = 0; }
          if ($_POST['add_lesson']) { $add_lesson = 1; }else{ $add_lesson = 0; }
          if ($_POST['edit_lesson']) { $edit_lesson = 1; }else{ $edit_lesson = 0; }
          if ($_POST['accountant']) { $accountant = 1; }else{ $accountant = 0; }
          if ($_POST['librarian']) { $librarian = 1; }else{ $librarian = 0; }
          if ($_POST['view_homework']) { $view_homework = 1; }else{ $view_homework = 0; }
          if ($_POST['add_homework']) { $add_homework = 1; }else{ $add_homework = 0; }
          if ($_POST['edit_homework']) { $edit_homework = 1; }else{ $edit_homework = 0; }
          if ($_POST['view_message']) { $view_message = 1; }else{ $view_message = 0; }
          if ($_POST['add_message']) { $add_message = 1; }else{ $add_message = 0; }
          if ($_POST['edit_message']) { $edit_message = 1; }else{ $edit_message = 0; }
          if ($_POST['view_staff']) { $view_staff = 1; }else{ $view_staff = 0; }
          if ($_POST['add_staff']) { $add_staff = 1; }else{ $add_staff = 0; }
          if ($_POST['edit_staff']) { $edit_staff = 1; }else{ $edit_staff = 0; }
          if ($_POST['view_leave']) { $view_leave = 1; }else{ $view_leave = 0; }
          if ($_POST['add_leave']) { $add_leave = 1; }else{ $add_leave = 0; }
          if ($_POST['view_transport']) { $view_transport = 1; }else{ $view_transport = 0; }
          if ($_POST['add_transport']) { $add_transport = 1; }else{ $add_transport = 0; }
          if ($_POST['edit_transport']) { $edit_transport = 1; }else{ $edit_transport = 0; }
          if ($_POST['generate']) { $generate = 1; }else{ $generate = 0; }
          if ($_POST['export']) { $export = 1; }else{ $export = 0; }
          if ($_POST['promotion']) { $promotion = 1; }else{ $promotion = 0; }



          if (empty($id)) { 
      
            $qry="INSERT INTO `permission`(`id`, `t_role`, `t_id`, `view_attendance`, `take_attendance`, `edit_attendance`, `view_gallery`, `add_gallery`, `edit_gallery`, `view_elibrary`, `add_elibrary`, `edit_elibrary`, `view_daily_routine`, `add_daily_routine`, `edit_daily_routine`, `view_student`, `add_student`, `edit_student`, `view_teacher`, `add_teacher`, `edit_teacher`, `view_class`, `add_class`, `edit_class`, `view_subject`, `add_subject`, `edit_subject`, `view_exam`, `add_exam`, `edit_exam`, `view_mark`, `add_mark`, `edit_mark`, `view_lesson`, `add_lesson`, `edit_lesson`, `accountant`, `librarian`, `view_homework`, `add_homework`, `edit_homework`, `view_message`, `add_message`, `edit_message`, `view_staff`, `add_staff`, `edit_staff`, `view_leave`, `add_leave`, `view_transport`, `add_transport`, `edit_transport`, `generate`, `export`, `promotion`) VALUES (NULL,'$t_role', '$t_id', '$view_attendance','$take_attendance','$edit_attendance','$view_gallery','$add_gallery','$edit_gallery','$view_elibrary','$add_elibrary','$edit_elibrary','$view_daily_routine','$add_daily_routine','$edit_daily_routine','$view_student','$add_student','$edit_student','$view_teacher','$add_teacher','$edit_teacher','$view_class','$add_class','$edit_class','$view_subject','$add_subject','$edit_subject','$view_exam','$add_exam','$edit_exam','$view_mark','$add_mark','$edit_mark','$view_lesson','$add_lesson','$edit_lesson','$accountant','$librarian','$view_homework','$add_homework','$edit_homework','$view_message','$add_message','$edit_message','$view_staff','$add_staff','$edit_staff','$view_leave','$add_leave','$view_transport','$add_transport','$edit_transport','$generate','$export','$promotion')";
            $result=mysqli_query($db,$qry);
            
            if($result) {  $msg="Permission succesfully updated";
            }else{ $msg="Failed to add:".mysqli_error($db); }

          }else{ 

            $qry="UPDATE `permission` SET `view_attendance`='$view_attendance',`take_attendance`='$take_attendance',`edit_attendance`='$edit_attendance',`view_gallery`='$view_gallery',`add_gallery`='$add_gallery',`edit_gallery`='$edit_gallery',`view_elibrary`='$view_elibrary',`add_elibrary`='$add_elibrary',`edit_elibrary`='$edit_elibrary',`view_daily_routine`='$view_daily_routine',`add_daily_routine`='$add_daily_routine',`edit_daily_routine`='$edit_daily_routine',`view_student`='$view_student',`add_student`='$add_student',`edit_student`='$edit_student',`view_teacher`='$view_teacher',`add_teacher`='$add_teacher',`edit_teacher`='$edit_teacher',`view_class`='$view_class',`add_class`='$add_class',`edit_class`='$edit_class',`view_subject`='$view_subject',`add_subject`='$add_subject',`edit_subject`='$edit_subject',`view_exam`='$view_exam',`add_exam`='$add_exam',`edit_exam`='$edit_exam',`view_mark`='$view_mark',`add_mark`='$add_mark',`edit_mark`='$edit_mark',`view_lesson`='$view_lesson',`add_lesson`='$add_lesson',`edit_lesson`='$edit_lesson',`accountant`='$accountant',`librarian`='$librarian',`view_homework`='$view_homework',`add_homework`='$add_homework',`edit_homework`='$edit_homework',`view_message`='$view_message',`add_message`='$add_message',`edit_message`='$edit_message',`view_staff`='$view_staff',`add_staff`='$add_staff',`edit_staff`='$edit_staff',`view_leave`='$view_leave',`add_leave`='$add_leave',`view_transport`='$view_transport',`add_transport`='$add_transport',`edit_transport`='$edit_transport',`generate`='$generate',`export`='$export',`promotion`='$promotion' WHERE `id`='$id'";
            $result=mysqli_query($db,$qry);
            
            if($result) {  $msg = "Permission succesfully updated";
            }else{ $msg="Failed to update:".mysqli_error($db); }
 
          }

         $_SESSION['result_success']=$msg;
        echo $msg;
      }


}
?>

