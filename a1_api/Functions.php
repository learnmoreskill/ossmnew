<?php

date_default_timezone_set('Asia/Kathmandu');

require_once 'DBOperations.php';

class Functions{

private $db;

public function __construct() {

      $this -> db = new DBOperations();

}


public function loginUser($email, $password) {
  $db = $this -> db;
  if (!empty($email) && !empty($password)) {

    $checkUser = $db -> checkUserExist($email);

    if ($checkUser < 1) {

      $response["status"] = 202;
      $response["message"] = "Your login name or password is invalid";
      return json_encode($response);

    }else if ($checkUser > 1) {

      $response["status"] = 202;
      $response["message"] = "Multiple user found with same email,Please contact your school.";
      return json_encode($response);
      
    }else {

       $result =  $db -> checkUserLogin($email, $password);

       return $result;

    } 
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function userDetails($role, $id) {
  $db = $this -> db;
  if (!empty($role) && !empty($id)) {

    if ($role=='admin' || $role=='student' || $role=='parent' || $role=='teacher' || $role=='manager') {

      $userExist = $db -> checkSpecificUserExist($role,$id);

      if ($userExist) {

        if ($role=='admin') {
      
          $data = $db -> adminDetails($id);

        }else if ($role=='student') {
          
          $data = $db -> studentDetails($id);

        }else if ($role=='parent') {

          $data = $db -> parentDetails($id);
          
        }else if ($role=='teacher') {

          $data = $db -> teacherDetails($id);
          
        }else if ($role=='manager') {

          $data = $db -> managerDetails($id);
          
        }

        $response["status"] = 200;
        $response["message"] = "success";
        $response["data"] = $data;
        return json_encode($response);

      }else{
        $response["status"] = 202;
        $response["message"] = "User not exist";
        return json_encode($response);
      }


    }else{
      return $this -> getMsgInvalidParam();
    }

  } else {
      return $this -> getMsgParamNotEmpty();
  }
}

public function getSchoolDetails($year_id , $type){
  $db = $this -> db;
  if (!empty($type)) {

    if ($type == 'schooldetails') {

        $result =  $db -> getSchoolDetails();
       if(!$result) {
        $response["status"] = "202";
        $response["message"] = "Something went wrong";
        return json_encode($response);
       } else {
        $response["status"] = "200";
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
        }
    }else if ($type == 'schoolstatic') {

      $data["school"] =  $db -> getSchoolDetails();
      $data["teacher"] =  $db -> getTeacherStatic(date("Y-m-d"));
      $data["student"] =  $db -> getStudentStatic(date("Y-m-d"));


      if(!$data) {
        $response["status"] = "202";
        $response["message"] = "Something went wrong";
        return json_encode($response);
      } else {
        $response["status"] = "200";
        $response["message"] = "success";
        $response["data"] = $data;
        return json_encode($response);
      }

    }else if ($type == 'teacherdetailstatic') {

      $data =  $db -> getTeacherDetailStatic($year_id,date("Y-m-d"));

      if(!$data) {
        $response["status"] = "201";
        $response["message"] = "Attendance has not been taken";
        return json_encode($response);
      } else {
        $response["status"] = "200";
        $response["message"] = "success";
        $response["data"] = $data;
        return json_encode($response);
      }



    }else if ($type == 'classsdetailstatic') {

      $data["class"] =  $db -> getClassDetailStatic($year_id,date("Y-m-d"));

      if(!$data) {
        $response["status"] = "202";
        $response["message"] = "Something went wrong";
        return json_encode($response);
      } else {
        $response["status"] = "200";
        $response["message"] = "success";
        $response["data"] = $data;
        return json_encode($response);
      }



    }else{
      return $this -> getMsgInvalidParam();
    }
       
  } else {
      return $this -> getMsgParamNotEmpty();
    }
}

public function getAllActiveStaffDetails(){
  $db = $this -> db;
      $result =  $db -> getAllActiveStaffDetails();
      
      if(!$result) {
        $response["status"] = "202";
        $response["message"] = "Something went wrong,Plese try again later";
        return json_encode($response);
      } else {
        $response["status"] = "200";
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }
  
}

public function getAllActiveStudentDetails(){
  $db = $this -> db;
      $result =  $db -> getAllActiveStudentDetails();
      
      if(!$result) {
        $response["status"] = "202";
        $response["message"] = "Something went wrong,Plese try again later";
        return json_encode($response);
      } else {
        $response["status"] = "200";
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }
  
}

public function getGallery(){
  $db = $this -> db;
      $result =  $db -> getGallery();
      
      if(!$result) {
        $response["status"] = "202";
        $response["message"] = "Something went wrong,Plese try again later";
        return json_encode($response);
      } else {
        $response["status"] = "200";
        $response["message"] = "success";
        $response["data"] = $result;
        return json_encode($response);
      }
  
}

public function roleDetails(){

      $result = array();

      array_push($result,array( "role" => 'admin', "role_code" => 1,  ));
      array_push($result,array( "role" => 'teacher', "role_code" => 2,  ));
      array_push($result,array( "role" => 'student', "role_code" => 3,  ));
      array_push($result,array( "role" => 'parent', "role_code" => 4,  ));
      array_push($result,array( "role" => 'manager', "role_code" => 5,  )); 
      
     
      $response["status"] = "200";
      $response["message"] = "success";
      $response["data"] = $result;
      return json_encode($response);
      
  
}

public function getYearIdByYear($c_n_year){
  $db = $this -> db;
  $year_id = $db -> getYearIdByYear($c_n_year);
  return $year_id;
}




public function getInvalidOperation(){
  $response["status"] = "203";
  $response["message"] = "Invalid Call !";
  return json_encode($response);
}


public function getMsgParamNotEmpty(){
  $response["status"] = "203";
  $response["message"] = "Parameters should not be empty !";
  return json_encode($response);
}

public function getMsgInvalidParam(){
  $response["status"] = "203";
  $response["message"] = "Invalid Parameters";
  return json_encode($response);
}

public function getMsgInvalidEmail(){
  $response["status"] = "203";
  $response["message"] = "Invalid Email";
  return json_encode($response);
}

}

?>

