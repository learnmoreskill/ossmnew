<?php

require_once 'DBOperations.php';

class Functions{

private $db;

public function __construct() {

      $this -> db = new DBOperations();

}

public function schoolDetails() {
  $db = $this -> db;

       $result =  $db -> schoolDetails();
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
  }
    
}

public function studentDetails() {
  $db = $this -> db;

       $result =  $db -> studentDetails();
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Student Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
  }
    
}

public function parentDetails() {
  $db = $this -> db;

       $result =  $db -> parentDetails();
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Parent Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
  }
    
}

public function teacherDetails() {
  $db = $this -> db;

       $result =  $db -> teacherDetails();
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Teacher Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
  }
    
}

public function staffDetails() {
  $db = $this -> db;

       $result =  $db -> staffDetails();
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Staff Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
  }
    
}

public function classDetails() {
  $db = $this -> db;

       $result =  $db -> classDetails();
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Class Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
  }
}

public function sectionDetails() {
  $db = $this -> db;

       $result =  $db -> sectionDetails();;
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Section Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = json_decode($result);
        return json_encode($response);
  }
}

public function searchStudent($key) {
  $db = $this -> db;

  if (!empty($key)) {

       $result =  $db -> searchStudent($key);
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Student Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
    
}

public function studentWithClassIdSectionId($key,$classId,$sectionId) {
  $db = $this -> db;

  if (!empty($key)) {

    if (!empty($classId)) {

      if (!empty($sectionId)) {

        $result =  $db -> studentWithClassIdSectionId($key,$classId,$sectionId);
         if(!$result) {
          $response["result"] = 201;
          $response["message"] = "No Student Details Found";
          return json_encode($response);
         } else {
          $response["status"] = 200;
          $response["message"] = "success";
          $response["data"] = $result;
          return json_encode($response);
        }

      }else{

        $result =  $db -> studentWithClassId($key,$classId);
         if(!$result) {
          $response["result"] = 201;
          $response["message"] = "No Student Details Found";
          return json_encode($response);
         } else {
          $response["status"] = 200;
          $response["message"] = "success";
          $response["data"] = $result;
          return json_encode($response);
        }

      }
    }else{

      $result =  $db -> searchStudent($key);
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Student Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }

  }

       
  } else {
      return $this -> getMsgParamNotEmpty();
    }
    
}

public function searchParent($key) {
  $db = $this -> db;

  if (!empty($key)) {

       $result =  $db -> searchParent($key);
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Parent Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function searchTeacher($key) {
  $db = $this -> db;

  if (!empty($key)) {

       $result =  $db -> searchTeacher($key);
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Teacher Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
    
}

public function searchStaff($key) {
  $db = $this -> db;

  if (!empty($key)) {

       $result =  $db -> searchStaff($key);
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "No Staff Details Found";
        return json_encode($response);
       } else {
        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
    
}

public function loginPrincipal($email, $password) {
  $db = $this -> db;
  if (!empty($email) && !empty($password)) {
    if ($db -> checkPrincipalExist($email)) {
       $result =  $db -> checkPrincipalLogin($email, $password);
       if(!$result) {
        $response["status"] = 201;
        $response["message"] = "Invaild Login Credentials";
        return json_encode($response);
       } else {
        //$classlist =  $db -> getClassList();
        //$sectionlist =  $db -> getSectionList();


        $response["status"] = 200;
        $response["message"] = "Login Sucessful";
        $response["data"] = $result;
        //$response["classlist"] = $classlist;
        //$response["sectionlist"] = json_decode($sectionlist);
        return json_encode($response);
  }
    } else {
      $response["status"] = 202;
      $response["message"] = "Invaild Account";
      return json_encode($response);
    }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}


public function loginTeacher($email, $password) {
  $db = $this -> db;
  if (!empty($email) && !empty($password)) {
    if ($db -> checkTeacherExist($email)) {
       $result =  $db -> checTeacherkLogin($email, $password);
       if(!$result) {
        $response["result"] = 201;
        $response["message"] = "Invaild Login Credentials";
        return json_encode($response);
       } else {
        //$classlist =  $db -> getClassList();
        //$sectionlist =  $db -> getSectionList();


        $response["status"] = 200;
        $response["message"] = "Login Sucessful";
        $response["data"] = $result;
        //$response["classlist"] = $classlist;
        //$response["sectionlist"] = json_decode($sectionlist);
        return json_encode($response);
	}
    } else {
      $response["status"] = 202;
      $response["message"] = "Invaild Account";
      return json_encode($response);
    }
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}



public function getschooldetails($schooldetails){
  $db = $this -> db;
  if (!empty($schooldetails)) {
       $result =  $db -> getschooldetails($schooldetails);
       if(!$result) {
        $response["result"] = "failure";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["result"] = "success";
        $response["message"] = $result;
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

public function getMsgInvalidRequest(){
  $response["result"] = "failure";
  $response["message"] = "Invalid Request";
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

