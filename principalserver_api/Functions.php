<?php

require_once 'DBOperations.php';

class Functions{

private $db;

public function __construct() {

      $this -> db = new DBOperations();

}

public function loginPrincipal($email, $password) {
  $db = $this -> db;
  if (!empty($email) && !empty($password)) {
    if ($db -> checkPrincipalExist($email)) {
       $result =  $db -> checkLogin($email, $password);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Invaild Login Credentials";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Login Sucessful";
        $response["principal"] = $result;
        return json_encode($response);
	}
    } else {
      $response["result"] = "failure";
      $response["message"] = "Invaild Login Credentials";
      return json_encode($response);
    }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchHomework($date,$standard,$sec,$fetchtype){
  $db = $this -> db;
  if (!empty($date)) {
	if($db -> isThereAnyHomework($date,$standard,$sec,$fetchtype)){
       $result =  $db -> fetchHomework($date,$standard,$sec,$fetchtype);
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

	        $response["result"] = "failure";
      		$response["message"] = "No Homework";
      		return json_encode($response);
	}


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function sendBroadcast($pname,$text){
  $db = $this -> db;
  if (!empty($pname) && !empty($text)) {
       $result =  $db -> sendBroadcast($pname,$text);
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

public function fetchMyBroadcast($date){
  $db = $this -> db;
  if (!empty($date)) {
       if($db -> isThereAnyBroadcastByMe($date)){
       $result =  $db -> fetchMyBroadcast($date);
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
      		$response["message"] = "No Broadcast";
      		return json_encode($response);
	}


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchAttendance1($date,$standard,$sec){
  $db = $this -> db;
  if (!empty($date) && !empty($standard) && !empty($sec)) {
	if($db -> isAttendanceDone($date,$standard,$sec)){
       $result =  $db -> fetchAttendance1($date,$standard,$sec);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Details fetched";
	$response["acount"] = $db -> getAcount($date,$standard,$sec);
	$response["pcount"] = $db -> getPcount($date,$standard,$sec);
        $response["attendance"] = $result;
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
    
    public function fetchAttendance2($standard,$sec){
  $db = $this -> db;
  if (!empty($standard) && !empty($sec)) {
	if($db -> isAttendanceByClass($standard,$sec)){
       $result =  $db -> fetchAttendance2($standard,$sec);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Attendance log fetched";
        $response["attendancelog"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "No attendance log for ".$standard." ".$sec;
      		return json_encode($response);
	}

  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

  public function fetchAttendance3($date){
  $db = $this -> db;
  if (!empty($date)) {
	if($db -> isAttendanceByDate($date)){
       $result =  $db -> fetchAttendance3($date);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Attendance log fetched";
        $response["attendancelog"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "No attendance taken on ".$date;
      		return json_encode($response);
	}

  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchStudentAttendance($sid){
  $db = $this -> db;
  if (!empty($sid)) {
	if($db -> isIrregular($sid)){
       $result =  $db -> fetchStudentAttendance($sid);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Details fetched";
        $response["attendance"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "Regular Student";
      		return json_encode($response);
	}

  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchStudentComplaint($sid){
  $db = $this -> db;
  if (!empty($sid)) {
        if($db -> isAnyComplaint($sid)){
       $result =  $db -> fetchStudentComplaint($sid);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Details fetched";
        $response["msg"] = $result;
        return json_encode($response);
        }

	} else {

                $response["result"] = "failure";
                $response["message"] = "No Complaints";
                return json_encode($response);
        }

  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchStudentHomework($sid){
  $db = $this -> db;
  if (!empty($sid)) {
        if($db -> isAnyUndoneHomework($sid)){
       $result =  $db -> fetchStudentHomework($sid);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Details fetched";
        $response["homeworknd"] = $result;
        return json_encode($response);
        }

        } else {

                $response["result"] = "failure";
                $response["message"] = "All Homeworks Done";
                return json_encode($response);
        }

  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchBroadcast($date,$standard,$sec,$fetchtype){
  $db = $this -> db;
  if (!empty($date)) {
	if($db -> isThereAnyBroadcast($date,$standard,$sec,$fetchtype)){
       $result =  $db -> fetchBroadcast($date,$standard,$sec,$fetchtype);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Broadcast fetched";
        $response["broadcast"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "No Broadcast";
      		return json_encode($response);
	}


  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function fetchMessage($date,$standard,$sec,$fetchtype){
  $db = $this -> db;
  if (!empty($date)) {
	if($db -> isThereAnyMessage($date,$standard,$sec,$fetchtype)){
       $result =  $db -> fetchMessage($date,$standard,$sec,$fetchtype);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Message fetched";
        $response["msg"] = $result;
        return json_encode($response);
        }

	} else {

	        $response["result"] = "failure";
      		$response["message"] = "No Message";
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

