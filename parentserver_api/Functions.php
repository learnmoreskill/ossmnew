<?php

require_once 'DBOperations.php';

class Functions{

private $db;

public function __construct() {

      $this -> db = new DBOperations();

}

public function loginParent($email, $password) {
  $db = $this -> db;
  if (!empty($email) && !empty($password)) {
    if ($db -> checkParentExist($email)) {
       $result =  $db -> checkLogin($email, $password);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Invaild Login Credentials";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Login Sucessful";
        $response["parent"] = $result;
        return json_encode($response);
	}
    } else {
      $response["result"] = "failure";
      $response["message"] = "Invaild Email Id";
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
	$response["acount"] = $db -> getAcount($sid);
	$response["pcount"] = $db -> getPcount($sid);
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

public function fetchClassBroadcast($standard,$sec){
  $db = $this -> db;
  if (!empty($standard) && !empty($sec)) {
	if($db -> isThereAnyClassBroadcast($standard,$sec)){
       $result =  $db -> fetchClassBroadcast($standard,$sec);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Broadcast fetched";
        $response["classBroadcast"] = $result;
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

public function fetchHomework($standard,$sec){
  $db = $this -> db;
  if (!empty($standard) && !empty($sec)) {
        if($db -> isThereAnyHomework($standard,$sec)){
       $result =  $db -> fetchHomework($standard,$sec);
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

public function fetchSchoolBroadcast(){
  $db = $this -> db;
       if($db -> isThereAnySchoolBroadcast()){
       $result =  $db -> fetchSchoolBroadcast();
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Broadcast fetched";
        $response["schoolBroadcast"] = $result;
        return json_encode($response);
        }
	} else {
	        $response["result"] = "failure";
      		$response["message"] = "No Broadcast";
      		return json_encode($response);
	}
}

/*public function fetchTrackbus(){
  $db = $this -> db;
       if($db -> isThereAnySchoolBus()){
       $result =  $db -> fetchTrackbus();
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "trackbus fetched";
        $response["schoolBroadcast"] = $result;
        return json_encode($response);
        }
  } else {
          $response["result"] = "failure";
          $response["message"] = "No School Bus Found";
          return json_encode($response);
  }
}*/

public function fetchStudent($parentid){
  $db = $this -> db;
  if (!empty($parentid)) {
        if($db -> isThereAnyStudent($parentid)){
       $result =  $db -> fetchStudent($parentid);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = "Student fetched";
        $response["student"] = $result;
        return json_encode($response);
        }
  } else {
                $response["result"] = "failure";
                $response["message"] = "No Student";
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
