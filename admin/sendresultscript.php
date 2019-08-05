<?php
include('session.php');
include('../config/sendbulksms.php');
require("../important/backstage.php");

$backstage = new back_stage_class();

if(isset($_REQUEST['send_result_message_request'])){

    $errMsgArray = $data  = array();

    $template = $_POST['template'];
    $class_id = $_POST['class_id'];
    $section_id = $_POST['section_id'];
    $group = $_POST["group"];
    $studentarray = $_POST['users'];

    $examid = $_POST['examtypeid'];
    $month_id = $_POST['m04x20'];
    $year_id = $_POST['year_id'];


    if (empty($group)) {
    	array_push($errMsgArray,'Please select any one receiver');
    }
    if (empty($studentarray)) {
    	array_push($errMsgArray,'Receiver list is empty');
    }

    if (empty($examid)) { 
      array_push($errMsgArray,'Please select exam');
    }
    if (empty($year_id)) {
      array_push($errMsgArray,'Please select year');
    }


    if (empty($month_id)) { 
      $month_id = 0; 
    }


    //check broadcast is on or off
    $checkBroadcastBulk= $backstage->check_broadcast_bulk();
    if ($checkBroadcastBulk != 1){
      array_push($errMsgArray,'Sorry, Please turn on bulk broadcast in sms setting!!');
    }

    $examtype_details = json_decode($backstage->get_examtype_details_by_examid($examid));

    $single_year = $backstage->get_academic_single_year_by_year_id($year_id);

    if (!($examid == 5 || $examid == 6)){
           $month_id = 0; 
    }

    if (empty($errMsgArray)) {

    	$examIncludeList = json_decode($backstage->get_examinclude_list_by_examtype_id($examid,$year_id));

      if (count((array)$examIncludeList)<1) { $examIncluded = false; }else{ $examIncluded = true;  }

      $addedExamTemp='';
      if ($examIncluded) {
        foreach ($examIncludeList as $examinclude) {
          $addedExamTemp .= "OR `marksheet`.`mexam_id`='".$examinclude->added_examtype_id."'";
        }
          
      }

      $queryvm1 = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`
          FROM `marksheet` 
          LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
          WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  ) 
          AND `marksheet`.`marksheet_class`='$class_id' 
          AND `marksheet`.`month`='$month_id' 
          AND `marksheet`.`year_id`='$year_id'");
        
      $rowCount1 = $queryvm1->num_rows;
      if($rowCount1 > 0) { 

        $mfound='1';

        require('../linker/reportForClassArray.php');

        if ($highestInSubTD) {       
              require('../linker/highestInSubject.php');
        }

        if ($rankTD) {
              require('../linker/rankmarkwise.php');
        } 

        require('../linker/attendanceArray.php');



      	foreach ($studentarray as $studentid){

          // START GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO
            $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`,`studentinfo`.`smobile`, `studentinfo`.`dob`
            , `syearhistory`.`roll_no`
            ,`parents`.`spname`,`parents`.`smname`,`parents`.`spnumber`
            , `class`.`class_name`, `section`.`section_name`
            
            FROM `studentinfo` 

            INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
              AND `syearhistory`.`year_id` = '$year_id'

            LEFT JOIN `parents` ON  `studentinfo`.`sparent_id` = `parents`.`parent_id` 

            LEFT JOIN `class` ON `syearhistory`.`class_id` = `class`.`class_id` 
            LEFT JOIN `section` ON `syearhistory`.`section_id` = `section`.`section_id` 

            WHERE `studentinfo`.`sid`='$studentid' ";

            $resultstd = $db->query($sqlstd);
            $rowstd = $resultstd->fetch_assoc();
          // END GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO


          $rowCount = count(${'m_obtained_mark_student' . $studentid});
          if($rowCount > 0) { $found='1'; } else{ $found='0';   }

          if ($found == '1') { //IF MARKSHEET FOUND PRINT OTHERWISE SKIP

              $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0.0; $gp=0.0; $fail = 0; $realCount = 0;
              $subjectmark = '';

              foreach (${'m_obtained_mark_student' . $studentid} as $subjectIDkey => $value) {

                $ob=0.0;
                if($subject_type[$subjectIDkey] != 3){ $realCount=$realCount+1; }//increement

                $subjectmark .= substr($subject_name[$subjectIDkey],0,3).':';

                if($subject_type[$subjectIDkey]==1){

                  $gt=$gt+($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);

                }else if($subject_type[$subjectIDkey]==0){ 
                  $gt=$gt+$subject_THFM[$subjectIDkey];
                }

                if($subject_type[$subjectIDkey]==1){ 
                  $pm=$pm+($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]);
                }else if($subject_type[$subjectIDkey]==0){ 
                  $pm=$pm+$subject_THPM[$subjectIDkey];
                }

                if ($examIncluded) {
                  foreach ($examIncludeList as $examinclude) {
                    $ob +=${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey];
                  }
                  
                }

                //total mark
                if ($examtype_details->self_include){
                  // GET TOTAL FOR EACH SUBJECT
                  $ob += ${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid];
                }

                $go=$go+$ob; 


                if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                  if ($examtype_details->self_include){

                    $subjectmark .= ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid].',';

                  }
                }else{

                  if(!empty($ob)){

                    $subjectmark .= $ob.',';

                  }else{ $subjectmark .= '-,'; }

                  // if ($examIncluded) {
                  //   echo (( (float)$ob<(float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]))? '*':'');
                  // }
                }//end total mark


                //Grade point of each subject
                if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                }else{

                  if($subject_type[$subjectIDkey] == 1){ 
                    $tm=$subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey];
                  }else if($subject_type[$subjectIDkey] == 0){
                    $tm = $subject_THFM[$subjectIDkey];
                  }

                    $avg=($ob/$tm)*100;
                    if(strtolower($ob)=='a'){
                      // echo 'Absent';
                    }elseif (strtolower($ob)=='s') {
                      // echo 'Suspend';
                    }


                    else{ if ($avg>=90) {
                      $gp = $gp+4.0;
                    }elseif ($avg>=80) {
                      $gp = $gp+3.6;
                    }elseif ($avg>=70) {
                      $gp = $gp+3.2;
                    }elseif ($avg>=60) {
                      $gp = $gp+2.8;
                    }elseif ($avg>=50) {
                      $gp = $gp+2.4;
                    }elseif ($avg>=40) {
                      $gp = $gp+2.0;
                    }elseif ($avg>=30) {
                      $gp = $gp+1.6;
                    }elseif ($avg>=20) {
                      $gp = $gp+1.2;
                    }elseif ($avg>=1) {
                      $gp = $gp+0.8;
                    }elseif ($avg==0) {
                      $gp = $gp+0.0;
                    }else{
                    }}
                }

                //checking fail pass in each subject
                //IF EXAM INCLUDED THEN PASS FAIL EVALUATED BY TOTAL OBTAINED IN EACH SUBJECT
                /*if ($examIncluded) {

                    if($subject_type[$subjectIDkey] == 3) {
                    }else if($subject_type[$subjectIDkey] == 0 && (float)$ob >= (float)($subject_THPM[$subjectIDkey])) {
                    }else if($subject_type[$subjectIDkey] == 1 && (float)$ob >= (float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey])) {
                    }
                    else{
                      $fail = 1;
                    }
                //IF EXAM NOT INCLUDED THEN PASS FAIL EVALUATED BY THEORY IN EACH SUBJECT
                }else{

                    if($subject_type[$subjectIDkey] == 0 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                    }else if($subject_type[$subjectIDkey] == 1 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                    }else if($subject_type[$subjectIDkey] == 3) {
                    }else{
                      $fail = 1;
                    }

                }*/

              }//end of subject loop

              $gpround = round(($gp/$realCount),2); //each student gp round

              if ($template == "gradePoint") {
                $fullmsg = "Dear Guardians Greeting! Please be informed that your ward has been able to obtain GPA:".$gpround." in ".substr($examtype_details->examtype_name,0,15)."-".$single_year.". Thank you,".substr($LOGIN_SCHOOL_NAME,0,33);
              }elseif ($template == "subjectMark") {
                $fullmsg = $rowstd['sname'].',Cls:'.$rowstd['class_name'].'-'.$rowstd['section_name'].', '.$subjectmark;
              }
              $fullmsg = rtrim($fullmsg,", ");

              if ($group == 4) {
                array_push($data, $rowstd['spname'].",".$rowstd['spnumber']." : ".$fullmsg."--".sendbulk($login_session_bulksmstoken,$rowstd['spnumber'],$fullmsg));
              }elseif ($group == 3) {
                array_push($data, $rowstd['sname'].",".$rowstd['smobile']." : ".$fullmsg."--".sendbulk($login_session_bulksmstoken,$rowstd['smobile'],$fullmsg));
              }

              
          }else{//No Marks Available in markesheet for this student
            array_push($data, "No Marks Aailable for student : ".$rowstd['sname']." Roll No: ".$rowstd['roll_no']);
                    
          }

        }



  	    if (empty($errMsgArray)) {
  	        $response["status"] = 200;
  	        $response["message"] = "Success";
            $response["data"] = $data;
  	    }else{
  	          $response["status"] = 201;
  	          $response["message"] = "Failed";
  	          $response["errormsg"] = $errMsgArray;
  	    } 
      }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = "Result not found";
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