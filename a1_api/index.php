<?php
require_once 'Functions.php';
$fun = new Functions();

require_once("../important/nepali_calendar.php");
$calendar = new Nepali_Calendar();
$cal = $calendar->eng_to_nep(date('Y'), date('m'), date('d'));
$c_n_year = $cal['year'];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
  
  $data = json_decode(file_get_contents("php://input"));
  if(isset($data -> operation)) {
  	$operation = $data -> operation;
  	if(!empty($operation)) {

  		if($operation == 'loginUser') { //tested

          if(isset($data -> data -> email) && isset($data -> data -> password)){

            $user = $data -> data;
            $email = $user -> email;
            $password = $user -> password;

            echo $fun -> loginUser($email, $password);

          }else {
          echo $fun -> getMsgInvalidParam();
        }
      

      } else if($operation == 'userDetails') {


          if(isset($data -> role) && isset($data -> data -> id)){

            $role = $data -> role;
            $id = $data -> data -> id;

            echo $fun -> UserDetails($role,$id);
          }else {
            echo $fun -> getMsgInvalidParam();
          }
      
      } else if($operation == 'getSchoolDetails') {
          if(isset($data -> type) && !empty($data -> type)) {
            $type = $data -> type;
            $year_id = $fun -> getYearIdByYear($c_n_year);

            echo $fun -> getSchoolDetails($year_id , $type);
          } else {
            echo $fun -> getMsgInvalidParam();
          }

      } else if($operation == 'details') {
        if(isset($data -> type ) && !empty($data -> type)) {

          if ($data -> type == 'allactivestaffdetails') {

            echo $fun -> getAllActiveStaffDetails();
            
          }else if ($data -> type == 'allactivestudentdetails') {

            echo $fun -> getAllActiveStudentDetails();
            
          }else if ($data -> type == 'gallery') {

            echo $fun -> getGallery();
            
          }else if ($data -> type == 'roleDetails') {

            echo $fun -> roleDetails();
            
          }else {
            echo $fun -> getMsgInvalidParam();
          }
        } else {
          echo $fun -> getMsgInvalidParam();
        }

      }  else if($operation == 'isAttendanceDone') {

        if(isset($data -> attendanceCheck ) && !empty($data -> attendanceCheck) && isset($data -> attendanceCheck -> abclass) && isset($data -> attendanceCheck -> absec)){

          $attendanceCheck = $data -> attendanceCheck;
          $standard = $attendanceCheck -> abclass;
          $section = $attendanceCheck -> absec;

          echo $fun -> AttendanceCheck($standard,$section);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	    }else if($operation == 'fetchsection') {

        if(isset($data -> teacher ) && !empty($data -> teacher)) {

          $teacher = $data -> teacher;
          $class = $teacher -> standard;

          echo $fun -> fetchsectionbyclass($class);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

      }else{

        echo $fun -> getInvalidOperation();
      }
  	}else{

  		echo $fun -> getMsgParamNotEmpty();
  	}

  } else {
  		echo $fun -> getMsgInvalidParam();
  }

} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){

  echo "Sorry";

}

?>
