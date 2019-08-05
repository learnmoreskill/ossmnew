<?php
   	include('session.php');
   	include('../config/sendbulksms.php');
   	require("../important/backstage.php");

   	$backstage = new back_stage_class();

   	if(isset($_REQUEST['student_attendance_submit_request']) && $_REQUEST['student_attendance_submit_request']=='student'){

      $errMsgArray  = array();

      $today_date = $login_today_date;

      $class_id=$_POST['class_id'];
      $section_id=$_POST['section_id'];

      $yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));
      $checkAttendaanceBulk= $backstage->check_attendance_bulk();

      $sc = 0;
      $pc = 0;

      $sqlalss1 = "SELECT * FROM `studentinfo` 
      LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
      WHERE `studentinfo`.`sclass`='$class_id' 
        AND `studentinfo`.`ssec`='$section_id' 
        AND `studentinfo`.`status`=0 
      ORDER BY `studentinfo`.`sroll` ASC";
      
      $resultalss1 = $db->query($sqlalss1);
     if ($resultalss1->num_rows > 0) { 


          // output data of each row
          while($row = $resultalss1->fetch_assoc()) { 
              $usid = $row["sid"];
              $myradio = mysqli_real_escape_string($db,$_POST["$usid"]);

              $sqlalss2 = "INSERT INTO `attendance` (`aid`, `asid`, `astatus`,  `aclass`, `asec`, `year_id`, `aclock`) VALUES (NULL, '$usid', '$myradio', '$class_id', '$section_id', '$yearId', CURRENT_TIMESTAMP)";
              if(mysqli_query($db, $sqlalss2)) {

                  /*if($myradio == 'P')
                  {
                      $pc = $pc +1;
                  } else {*/


                    if($myradio == 'P')//added
                  {//added
                      $pc++;//added
                  } else if($myradio == 'A') {//added
                    $sc++;//added
                  
                  if ($checkAttendaanceBulk==1) {
                    if (strlen($row["spnumber"])>=10) {
                      $bulknumber = substr($row["spnumber"],-10);
                      
                      $bulkmessage="Your child ".$row["sname"]." is absent today for the class. -".$login_session2.", ".$login_session_a; //enter Your Message

                      $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
                    }
                  }
                      

                  }
                      
                  
                  /*$sc = $sc + 1;*/
              } else{ 
                array_push($errMsgArray,'ERROR: Could not able to execute -'. mysqli_error($db));
              }
          }   //while close  
     } //if close

   /*if ($sc == $login_session11) {
       $ac = $login_session11 - $pc;*/
      if (empty($errMsgArray)) {

        $sql="INSERT INTO `abcheck` (`abid`, `abclass`, `absec`, `abdate`, `abbit`, `abpcount`, `abacount`, `teacher_id`, `teacher_role`, `year_id`) VALUES (NULL, '$class_id', '$section_id', CURRENT_TIMESTAMP, '1', '$pc', '$sc', '$login_session1', '$login_cat', '$yearId')";
        if(mysqli_query($db, $sql)) {

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

   }else if(isset($_REQUEST['staff_attendance_submit_request']) && $_REQUEST['staff_attendance_submit_request']=='teacher'){

   		$errMsgArray  = array();

   		$today_date = $login_today_date;

   		$yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));
   		//$checkAttendaanceBulk= $backstage->check_attendance_bulk();

   		$sc = 0;
     	$pc = 0;

     	$userList = json_decode($backstage->get_active_teacher_list());

          	foreach ($userList as $userRow) {
              $id = $userRow->id;
              $myradio = mysqli_real_escape_string($db,$_POST["$id"]);

              $sqlalss2 = "INSERT INTO `attendance_staff` (`id`,`staff`, `tid`, `status`, `year_id`, `date` ) VALUES (NULL, 2 , '$id', '$myradio', '$yearId',CURRENT_TIMESTAMP)";
              if(mysqli_query($db, $sqlalss2)) {

                  /*if($myradio == 'P')
                  {
                      $pc = $pc +1;
                  } else {*/


                    if($myradio == 'P' || $myradio == 'L')//added
                  	{//added
                     	$pc++;//added
                  	} else if($myradio == 'A') {//added
                    	$sc++;//added
                  
	                  /*if ($checkAttendaanceBulk==1) {
	                    if (strlen($row["spnumber"])>=10) {
	                      $bulknumber = substr($row["spnumber"],-10);
	                      
	                      $bulkmessage="Your child ".$row["sname"]." is absent today for the class. -".$login_session2.", ".$login_session_a; //enter Your Message

	                      $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
	                    }
	                  }*/
                    }
                      
                  
                  /*$sc = $sc + 1;*/
              } else{ 
                  array_push($errMsgArray,'ERROR: Could not able to execute -'. mysqli_error($db));
              }
          	}   //while close  
     

   /*if ($sc == $login_session11) {
       $ac = $login_session11 - $pc;*/

       	if (empty($errMsgArray)) {

	        $sql="INSERT INTO `attendance_staff_check` (`id`, `staff`, `abpcount`, `abacount`, `teacher_id`, `teacher_role`, `year_id`,`date`,`timestamp`) VALUES (NULL, 2, '$pc', '$sc', '$LOGIN_ID', '$LOGIN_CAT', '$yearId',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
	        if(mysqli_query($db, $sql)) {

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


   }else if(isset($_REQUEST['staff_attendance_submit_request']) && $_REQUEST['staff_attendance_submit_request']=='staff'){

   		$errMsgArray  = array();

   		$today_date = $login_today_date;

   		$yearId = json_decode($backstage->get_academic_year_id_by_year($cal['year']));
   		//$checkAttendaanceBulk= $backstage->check_attendance_bulk();

   		$sc = 0;
     	$pc = 0;

     	$userList = json_decode($backstage->get_active_staff_list());

          	foreach ($userList as $userRow) {
              $id = $userRow->id;
              $myradio = mysqli_real_escape_string($db,$_POST["$id"]);

              $sqlalss2 = "INSERT INTO `attendance_staff` (`id`,`staff`, `tid`, `status`, `year_id`, `date` ) VALUES (NULL, 5 , '$id', '$myradio', '$yearId',CURRENT_TIMESTAMP)";
              if(mysqli_query($db, $sqlalss2)) {

                  /*if($myradio == 'P')
                  {
                      $pc = $pc +1;
                  } else {*/


                    if($myradio == 'P' || $myradio == 'L')//added
                  	{//added
                     	$pc++;//added
                  	} else if($myradio == 'A') {//added
                    	$sc++;//added
                  
	                  /*if ($checkAttendaanceBulk==1) {
	                    if (strlen($row["spnumber"])>=10) {
	                      $bulknumber = substr($row["spnumber"],-10);
	                      
	                      $bulkmessage="Your child ".$row["sname"]." is absent today for the class. -".$login_session2.", ".$login_session_a; //enter Your Message

	                      $bulkresult= sendbulk($login_session_bulksmstoken,$bulknumber,$bulkmessage);
	                    }
	                  }*/
                    }
                      
                  
                  /*$sc = $sc + 1;*/
              } else{ 
                  array_push($errMsgArray,'ERROR: Could not able to execute -'. mysqli_error($db));
              }
          	}   //while close  
     

   /*if ($sc == $login_session11) {
       $ac = $login_session11 - $pc;*/

       	if (empty($errMsgArray)) {

	        $sql="INSERT INTO `attendance_staff_check` (`id`, `staff`, `abpcount`, `abacount`, `teacher_id`, `teacher_role`, `year_id`,`date`,`timestamp`) VALUES (NULL, 5, '$pc', '$sc', '$LOGIN_ID', '$LOGIN_CAT', '$yearId',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
	        if(mysqli_query($db, $sql)) {

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

   }else{
      $response["status"] = 203;
      $response["message"] = "Failed";
      $response["errormsg"] = "Sorry,Invalid Request";
   }


   echo json_encode($response);
   ?>