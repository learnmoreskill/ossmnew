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

        if(isset($data -> teacher ) && !empty($data -> teacher) && isset($data -> teacher -> email) && isset($data -> teacher -> password)){

          $teacher = $data -> teacher;
          $email = $teacher -> email;
          $password = $teacher -> password;

          echo $fun -> loginTeacher($email, $password);

        } else {

          echo $fun -> getMsgInvalidParam();

        }
	} else if($operation == 'sendBroadcast') {
        if(isset($data -> broadcastMessage ) && !empty($data -> broadcastMessage) && isset($data -> broadcastMessage -> bmtid) && isset($data -> broadcastMessage -> bmtname) && isset($data -> broadcastMessage -> bmclass) && isset($data -> broadcastMessage -> bmsec) && isset($data -> broadcastMessage -> bmschoolname) && isset($data -> broadcastMessage -> bmschoolcode) && isset($data -> broadcastMessage -> bmtext)) {
          $broadcastMessage = $data -> broadcastMessage;
          $tid = $broadcastMessage -> bmtid; 
          $text = $broadcastMessage -> bmtext;
          $tname = $broadcastMessage -> bmtname;
          $standard = $broadcastMessage -> bmclass;
          $sec = $broadcastMessage -> bmsec;
          $schoolName = $broadcastMessage -> bmschoolname;
          $schoolCode = $broadcastMessage -> bmschoolcode;
          echo $fun -> sendBroadcast($tid,$tname,$standard,$sec,$schoolName,$schoolCode,$text);
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

	} else if($operation == 'getAttendanceList') {

        if(isset($data -> teacher ) && !empty($data -> teacher) && isset($data -> teacher -> standard) && isset($data -> teacher -> sec)){

          $teacher = $data -> teacher;
          $standard = $teacher -> standard;
          $sec = $teacher -> sec;

          echo $fun -> FetchAttendanceList($standard,$sec);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	} else if($operation == 'submitAttendance') {

        if(isset($data -> attendance ) && !empty($data -> attendance) && isset($data -> attendance -> abclass)  && isset($data -> attendance -> absec) && isset($data -> attendance -> id)  && isset($data -> attendance -> attendanceData)){

          $attendance = $data -> attendance;
          $standard = $attendance -> abclass;
          $sec = $attendance -> absec;
          $id = $attendance -> id;
          $attendanceData = $attendance -> attendanceData;

          echo $fun -> SubmitAttendance($standard,$sec,$id,$attendanceData);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	} else if($operation == 'getAttendanceEditList') {

        if(isset($data -> teacher ) && !empty($data -> teacher) && isset($data -> teacher -> standard) && isset($data -> teacher -> sec)){

          $teacher = $data -> teacher;
          $standard = $teacher -> standard;
          $sec = $teacher -> sec;

          echo $fun -> FetchAttendanceEditList($standard,$sec);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	} else if($operation == 'submitAttendanceEdit') {

        if(isset($data -> attendance ) && !empty($data -> attendance) && isset($data -> attendance -> abclass)  && isset($data -> attendance -> absec)  && isset($data -> attendance -> attendanceEditData)){

          $attendance = $data -> attendance;
          $standard = $attendance -> abclass;
          $sec = $attendance -> absec;
          $attendanceEditData = $attendance -> attendanceEditData;

          echo $fun -> SubmitAttendanceEdit($standard,$sec,$attendanceEditData);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

        } else if($operation == 'submitHwnd') {

        if(isset($data -> hwnd ) && !empty($data -> hwnd)) {

          $hwnd = $data -> hwnd;

          echo $fun -> SubmitHwnd($hwnd);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	} else if($operation == 'submitFeenp') {

        if(isset($data -> feenp ) && !empty($data -> feenp)) {

          $feenp = $data -> feenp;

          echo $fun -> SubmitFeenp($feenp);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	} else if($operation == 'submitGroupComplaint') {

        if(isset($data -> grpc ) && !empty($data -> grpc)) {

          $grpc = $data -> grpc;

          echo $fun -> SubmitGroupComplaint($grpc);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	} else if($operation == 'attendanceView') {

        if(isset($data -> attendanceview ) && !empty($data -> attendanceview) && isset($data -> attendanceview -> aclock) && isset($data -> attendanceview -> aclass) && isset($data -> attendanceview -> asec)){

          $attendanceview = $data -> attendanceview;
          $date = $attendanceview -> aclock;
          $standard = $attendanceview -> aclass;
          $sec = $attendanceview -> asec;

          echo $fun -> fetchAttendanceView($date,$standard,$sec);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

	} else if($operation == 'sendComplaint') {
        if(isset($data -> complaint ) && !empty($data -> complaint) && isset($data -> complaint -> ctid) && isset($data -> complaint -> ctname) && isset($data -> complaint -> ctschoolcode) && isset($data -> complaint -> csid) && isset($data -> complaint -> csname) && isset($data -> complaint -> csclass) && isset($data -> complaint -> cssec) && isset($data -> complaint -> cmsg) && isset($data -> complaint -> spnumber)) {
          $complaint = $data -> complaint;
          $tid = $complaint -> ctid; 
          $text = $complaint -> cmsg;
          $tname = $complaint -> ctname;
          $schoolCode = $complaint -> ctschoolcode;
          $sid = $complaint -> csid;
          $sname = $complaint -> csname;
          $standard = $complaint -> csclass;
          $sec = $complaint -> cssec;
          $pnumber = $complaint -> spnumber;
          echo $fun -> sendComplaint($tid,$tname,$schoolCode,$sid,$sname,$standard,$sec,$text,$pnumber);
        } else {
          echo $fun -> getMsgInvalidParam();
        }

	} else if($operation == 'sendHomework') {
        if(isset($data -> homework ) && !empty($data -> homework) && isset($data -> homework -> htid) && isset($data -> homework -> htname) && isset($data -> homework -> hschoolcode) && isset($data -> homework -> hschoolname) && isset($data -> homework -> hsubject) && isset($data -> homework -> htopic) && isset($data -> homework -> hclass) && isset($data -> homework -> hsec)) {
          $homework = $data -> homework;
          $tid = $homework -> htid; 
          $tname = $homework -> htname;
          $schoolcode = $homework -> hschoolcode;
          $schoolname = $homework -> hschoolname;
          $subject = $homework -> hsubject;
          $topic = $homework -> htopic;
          $standard = $homework -> hclass;
          $sec = $homework -> hsec;
          echo $fun -> sendHomework($tid,$tname,$schoolcode,$schoolname,$subject,$topic,$standard,$sec);
        } else {
          echo $fun -> getMsgInvalidParam();
        } 

	} else if($operation == 'myBroadcast') {
        if(isset($data -> broadcastMessage ) && !empty($data -> broadcastMessage) && isset($data -> broadcastMessage -> bmtid) && isset($data -> broadcastMessage -> bmdate)){
          $myBroadcast = $data -> broadcastMessage;
          $tid =  $myBroadcast -> bmtid;
          $date = $myBroadcast -> bmdate;
          echo $fun -> fetchMyBroadcast($tid,$date);
        } else {
          echo $fun -> getMsgInvalidParam();
        }

	} else if($operation == 'homework') {
        if(isset($data -> homework ) && !empty($data -> homework) && isset($data -> fetchType) && isset($data -> homework -> htid) && isset($data -> homework -> hdate) && isset($data -> homework -> hclass) && isset($data -> homework -> hsec)){
	  $fetchtype = $data -> fetchType;
          $homework = $data -> homework;
          $tid = $homework -> htid;
          $date = $homework -> hdate;
          $standard = $homework -> hclass;
          $sec = $homework -> hsec;
          echo $fun -> fetchHomework($tid,$date,$standard,$sec,$fetchtype);
        } else {
          echo $fun -> getMsgInvalidParam();
        }

	} else if($operation == 'myComplaint') {
        if(isset($data -> complaint ) && !empty($data -> complaint) && isset($data -> complaint -> ctid) && isset($data -> complaint -> cdate)){
          $myComplaint = $data -> complaint;
          $tid =  $myComplaint -> ctid;
          $date = $myComplaint -> cdate;
          echo $fun -> fetchMyComplaint($tid,$date);
        } else {
          echo $fun -> getMsgInvalidParam();
        }

	} else if($operation == 'isAttendanceDone') {

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
