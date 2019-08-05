<?php

require_once 'DBOperations.php';

class Functions{

private $db;

public function __construct() {

      $this -> db = new DBOperations();

}

public function loginTeacher($email, $password) {
  $db = $this -> db;
  if (!empty($email) && !empty($password)) {
    if ($db -> checkTeacherExist($email)) {
       $result =  $db -> checkLogin($email, $password);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Invaild Login Credentials";
        return json_encode($response);
       } else {
        $classlist =  $db -> getClassList();
        $sectionlist =  $db -> getSectionList();


        $response["result"] = "success";
        $response["message"] = "Login Sucessful";
        $response["teacher"] = $result;
        $response["classlist"] = $classlist;
        $response["sectionlist"] = json_decode($sectionlist);
        return json_encode($response);
	}
    } else {
      $response["result"] = "failure";
      $response["message"] = "Invaild Account";
      return json_encode($response);
    }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}


public function fetchsectionbyclass($class) {
  $db = $this -> db;
  if (!empty($class)) {
       $result =  $db -> fetchsectionbyclass($class);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Section Found";
        $response["section"] = $result;
        return json_encode($response);
  }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}
public function searchStudent($name){
  $db = $this -> db;
  if (!empty($name)) {
	if($db -> isThereAnyStudent($name)){
       $result =  $db -> searchStudent($name);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Search results fetched";
        $response["students"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "No results found";
      		return json_encode($response);
	}


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchHomework($tid,$date,$standard,$sec,$fetchtype){
  $db = $this -> db;
  if (!empty($date)) {
	if($db -> isThereAnyHomework($tid,$date,$standard,$sec,$fetchtype)){
       $result =  $db -> fetchHomework($tid,$date,$standard,$sec,$fetchtype);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Homework fetched";
        $response["homework"] = $result;
        return json_encode($response);
        }
	} else {
               if($date == "-") {
                $response["result"] = "failure";
                $response["message"] = "No Homework for $standard - $sec";
                return json_encode($response);
                } else if($standard == "0" && $sec =="0") {
                $response["result"] = "failure";
                $response["message"] = "No Homework on $date";
                return json_encode($response);
                } else if( !($date == '-' && $standard == "0" && $sec =="0")) {
                $response["result"] = "failure";
                $response["message"] = "No Homework for $standard - $sec on $date";
                return json_encode($response);
                } else {
	        $response["result"] = "failure";
      		$response["message"] = "No Homework";
      		return json_encode($response);
                }
	}
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function FetchAttendanceList($standard,$sec){
  $db = $this -> db;
  if (!empty($standard) && !empty($sec)) {
        if($db -> isThereAnyStudentInClass($standard,$sec)){
       $result =  $db -> FetchAttendanceList($standard,$sec);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Student list fetched";
        $response["students"] = $result;
        return json_encode($response);
        }

	} else {

                $response["result"] = "failure";
                $response["message"] = "No students found";
                return json_encode($response);
        }


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function FetchAttendanceEditList($standard,$sec){
  $db = $this -> db;
  if (!empty($standard) && !empty($sec)) {
       $result =  $db -> FetchAttendanceEditList($standard,$sec);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Attendance list fetched";
        $response["attendanceedit"] = $result;
        return json_encode($response);
        }

  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchAttendanceView($date,$standard,$sec){
  $db = $this -> db;
  if (!empty($date) && !empty($standard) && !empty($sec)) {
	if($db -> isAttendanceDoneOnDate($date,$standard,$sec)){
       $result =  $db -> fetchAttendanceView($date,$standard,$sec);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Details fetched";
	$response["acount"] = $db -> getAcount($date,$standard,$sec);
	$response["pcount"] = $db -> getPcount($date,$standard,$sec);
        $response["attendanceview"] = $result;
        return json_encode($response);
        }
	} else {
	        $response["result"] = "failure";
      		$response["message"] = "Attendance not taken";
      		return json_encode($response);
	}
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function AttendanceCheck($standard,$section){
  $db = $this -> db;
  if (!empty($standard) && !empty($section)) {
        if($db -> isAttendanceDone($standard,$section)){
        $result =  $db -> gettecheridofattendance($standard, $section);
        if($result) {
            $response["result"] = "yes";
            $response["message"] = "attendance done";
            $response["attendanceteacher"] = $result;
            return json_encode($response);
          }else{
            $attendanceteacher["id"] = 0;
            $attendanceteacher["name"] = "";
            $attendanceteacher["role"] = "";
            $attendanceteacher["pname"] = "";
            $response["result"] = "yes";
            $response["message"] = "attendance done";
            $response["attendanceteacher"] = $attendanceteacher;
            return json_encode($response);
          }
       } else {
        $response["result"] = "no";
        $response["message"] = "attendance not done";
        return json_encode($response);
        }


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}


public function sendComplaint($tid,$tname,$schoolCode,$sid,$sname,$standard,$sec,$text,$pnumber){
  $db = $this -> db;
  if (!empty($tid) && !empty($text)  && !empty($tname)  && !empty($standard)  && !empty($sec) && !empty($sid) && !empty($sname) && !empty($pnumber)) {
       $result =  $db -> sendComplaint($tid,$tname,$schoolCode,$sid,$sname,$standard,$sec,$text,$pnumber);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Complaint Sent";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function sendHomework($tid,$tname,$schoolcode,$schoolname,$subject,$topic,$standard,$sec){
  $db = $this -> db;
  if (!empty($tid) && !empty($tname)  && !empty($schoolcode)  && !empty($standard)  && !empty($sec) && !empty($schoolname) && !empty($subject) && !empty($topic)) {
       $result =  $db -> sendHomework($tid,$tname,$schoolcode,$schoolname,$subject,$topic,$standard,$sec);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Homework added";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function submitAttendance($standard,$sec,$id,$schoolcode,$attendanceData){
  $db = $this -> db;
  if (!empty($attendanceData) && !empty($standard) && !empty($sec) && !empty($id) && !empty($schoolcode)) {
       $result =  $db -> submitAttendance($standard,$sec,$id,$schoolcode,$attendanceData);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Attendance Done";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function submitAttendanceEdit($standard,$sec,$attendanceEditData){
  $db = $this -> db;
  if (!empty($attendanceEditData) && !empty($standard) && !empty($sec)) {
       $result =  $db -> submitAttendanceEdit($standard,$sec,$attendanceEditData);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Attendance Updated";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function SubmitHwnd($hwnd){
  $db = $this -> db;
  if (!empty($hwnd)) {
       $result =  $db -> submitHwnd($hwnd);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Undone Homework Reported";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function SubmitFeenp($feenp){
  $db = $this -> db;
  if (!empty($feenp)) {
       $result =  $db -> submitFeenp($feenp);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Fee Due Reported";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function SubmitGroupComplaint($grpc){
  $db = $this -> db;
  if (!empty($grpc)) {
       $result =  $db -> SubmitGroupComplaint($grpc);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Message Sent";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function sendBroadcast($tid,$tname,$standard,$sec,$schoolName,$schoolCode,$text){
  $db = $this -> db;
  if (!empty($tid) && !empty($text)  && !empty($tname)  && !empty($standard)  && !empty($sec)) {
       $result =  $db -> sendBroadcast($tid,$tname,$standard,$sec,$schoolName,$schoolCode,$text);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Broadcast Pushed";
        return json_encode($response);
        }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}


public function fetchMyComplaint($tid,$date){
  $db = $this -> db;
  if (!empty($date) && !empty($tid)) {
       if($db -> isThereAnyComplaintByMe($tid,$date)){
       $result =  $db -> fetchMyComplaint($tid,$date);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Message fetched";
        $response["complaint"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "No Message on $date";
      		return json_encode($response);
	}


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchMyBroadcast($tid,$date){
  $db = $this -> db;
  if (!empty($date) && !empty($tid)) {
       if($db -> isThereAnyBroadcastByMe($tid,$date)){
       $result =  $db -> fetchMyBroadcast($tid,$date);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Broadcast fetched";
        $response["broadcastMessage"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "No Broadcast on $date";
      		return json_encode($response);
	}


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function getMsgParamNotEmpty(){
  $response["result"] = "failure";
  $response["message"] = "Parameters should not be empty !";
  return json_encode($response);
}

public function getMsgInvalidParam(){
  $response["result"] = "failure";
  $response["message"] = "Invalid Parameters";
  return json_encode($response);
}

public function getMsgInvalidEmail(){
  $response["result"] = "failure";
  $response["message"] = "Invalid Email";
  return json_encode($response);
}

}

?>

