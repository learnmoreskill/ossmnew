<?php
require_once 'Functions.php';
$fun = new Functions();

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
  $data = json_decode(file_get_contents("php://input"));
  if(isset($data -> operation)) {
  	$operation = $data -> operation;
  	if(!empty($operation)) {

  		if($operation == 'login') {

        if(isset($data -> principal ) && !empty($data -> principal) && isset($data -> principal -> email) && isset($data -> principal -> password)){

          $principal = $data -> principal;
          $email = $principal -> email;
          $password = $principal -> password;

          echo $fun -> loginPrincipal($email, $password);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
	} else if($operation == 'homework') {

        if(isset($data -> homework ) && !empty($data -> homework) && isset($data -> fetchType) && isset($data -> homework -> hdate) && isset($data -> homework -> hclass) && isset($data -> homework -> hsec)){

	  $fetchtype = $data -> fetchType;
          $homework = $data -> homework;
          $date = $homework -> hdate;
          $standard = $homework -> hclass;
          $sec = $homework -> hsec;

          echo $fun -> fetchHomework($date,$standard,$sec,$fetchtype);

        } else {

          echo $fun -> getMsgInvalidParam();

        } 

	} else if($operation == 'broadcast') {

        if(isset($data -> broadcast ) && !empty($data -> broadcast) && isset($data -> fetchType) && isset($data -> broadcast -> bmdate) && isset($data -> broadcast -> bmclass) && isset($data -> broadcast -> bmsec)){

	  $fetchtype = $data -> fetchType;
          $broadcast = $data -> broadcast;
          $date = $broadcast -> bmdate;
          $standard = $broadcast -> bmclass;
          $sec = $broadcast -> bmsec;

          echo $fun -> fetchBroadcast($date,$standard,$sec,$fetchtype);

        } else {

          echo $fun -> getMsgInvalidParam();

        } 

	} else if($operation == 'myBroadcast') {
        if(isset($data -> broadcastMessage ) && !empty($data -> broadcastMessage) && isset($data -> broadcastMessage -> pushed_at)){
          $myBroadcast = $data -> broadcastMessage;
          $date = $myBroadcast -> pushed_at;
          echo $fun -> fetchMyBroadcast($date);
        } else {
          echo $fun -> getMsgInvalidParam();
        } 

	} else if($operation == 'sendBroadcast') {
        if(isset($data -> broadcastMessage ) && !empty($data -> broadcastMessage) && isset($data -> broadcastMessage -> brdpname) && isset($data -> broadcastMessage -> brdtext)) {
          $broadcastMessage = $data -> broadcastMessage;
          $text = $broadcastMessage -> brdtext;
          $pname = $broadcastMessage -> brdpname;
          echo $fun -> sendBroadcast($pname,$text);
        } else {
          echo $fun -> getMsgInvalidParam();
        }

	} else if($operation == 'message') {

        if(isset($data -> message ) && !empty($data -> message) && isset($data -> fetchType) && isset($data -> message -> cdate) && isset($data -> message -> csclass) && isset($data -> message -> cssec)){

          $fetchtype = $data -> fetchType;
          $message = $data -> message;
          $date = $message -> cdate;
          $standard = $message -> csclass;
          $sec = $message -> cssec;

          echo $fun -> fetchMessage($date,$standard,$sec,$fetchtype);

        } else {

          echo $fun -> getMsgInvalidParam();

        } 

	} else if($operation == 'student_search') {

        if(isset($data -> student ) && !empty($data -> student) && isset($data -> student -> sname)){

          $student = $data -> student;
          $name = $student -> sname;

          echo $fun -> searchStudent($name);

        } else {

          echo $fun -> getMsgInvalidParam();

        } 

	} else if($operation == 'student_detail_attendance') {

        if(isset($data -> student ) && !empty($data -> student) && isset($data -> student -> sid)){

          $student = $data -> student;
          $sid = $student -> sid;

          echo $fun -> fetchStudentAttendance($sid);

        } else {

          echo $fun -> getMsgInvalidParam();

        } 
	} else if($operation == 'student_detail_complaint') {

        if(isset($data -> student ) && !empty($data -> student) && isset($data -> student -> sid)){

          $student = $data -> student;
          $sid = $student -> sid;

          echo $fun -> fetchStudentComplaint($sid);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
	} else if($operation == 'student_detail_homework') {

        if(isset($data -> student ) && !empty($data -> student) && isset($data -> student -> sid)){

          $student = $data -> student;
          $sid = $student -> sid;

          echo $fun -> fetchStudentHomework($sid);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
	} else if($operation == 'attendance_1') {

        if(isset($data -> attendance ) && !empty($data -> attendance) && isset($data -> attendance -> aclock) && isset($data -> attendance -> aclass) && isset($data -> attendance -> asec)){

          $attendance = $data -> attendance;
          $date = $attendance -> aclock;
          $standard = $attendance -> aclass;
          $sec = $attendance -> asec;

          echo $fun -> fetchAttendance1($date,$standard,$sec);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
        } else if($operation == 'attendance_2') {

        if(isset($data -> attendancelog ) && !empty($data -> attendancelog) && isset($data -> attendancelog -> abclass) && isset($data -> attendancelog -> absec)){

          $attendancelog = $data -> attendancelog;
          $standard = $attendancelog -> abclass;
          $sec = $attendancelog -> absec;

          echo $fun -> fetchAttendance2($standard,$sec);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
	} else if($operation == 'attendance_3') {

        if(isset($data -> attendancelog ) && !empty($data -> attendancelog) && isset($data -> attendancelog -> abdate)){

          $attendancelog = $data -> attendancelog;
          $date = $attendancelog -> abdate;

          echo $fun -> fetchAttendance3($date);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
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
