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

        if(isset($data -> parent ) && !empty($data -> parent) && isset($data -> parent -> spemail) && isset($data -> parent -> password)){

          $parent = $data -> parent;
          $email = $parent -> spemail;
          $password = $parent -> password;

          echo $fun -> loginParent($email, $password);

        } else {

          echo $fun -> getMsgInvalidParam();

        }

  } else if($operation == 'fetchAttendance') {
        if(isset($data -> student ) && !empty($data -> student) && isset($data -> student -> sid)){
          $student = $data -> student;
          $sid = $student -> sid;
          echo $fun -> fetchStudentAttendance($sid);
        } else {
          echo $fun -> getMsgInvalidParam();
        } 

  } else if($operation == 'fetchComplaint') {
        if(isset($data -> parent ) && !empty($data -> parent) && isset($data -> parent -> sid)){
          $parent = $data -> parent;
          $sid = $parent -> sid;
          echo $fun -> fetchStudentComplaint($sid);
        } else {
          echo $fun -> getMsgInvalidParam();
        }

  } else if($operation == 'fetchClassBroadcast') {
        if(isset($data -> classBroadcast ) && !empty($data -> classBroadcast) && isset($data -> classBroadcast -> bmclass) && isset($data -> classBroadcast -> bmsec)){
          $classBroadcast = $data -> classBroadcast;
          $standard = $classBroadcast -> bmclass;
          $sec = $classBroadcast -> bmsec;
          echo $fun -> fetchClassBroadcast($standard,$sec);
        } else {
          echo $fun -> getMsgInvalidParam();
        } 

  } else if($operation == 'fetchHomework') {
        if(isset($data -> homework ) && !empty($data -> homework) && isset($data -> homework -> hclass) && isset($data -> homework -> hsec)) {
          $homework = $data -> homework;
          $standard = $homework -> hclass;
          $sec = $homework -> hsec;
          echo $fun -> fetchHomework($standard,$sec);
        } else {
          echo $fun -> getMsgInvalidParam();
        } 

  } else if($operation == 'fetchSchoolBroadcast') {
          echo $fun -> fetchSchoolBroadcast();

  }else if($operation == 'fetchStudent') {
        if(isset($data -> parent ) && !empty($data -> parent) && isset($data -> parent -> parent_id)){
          $parent = $data -> parent;
          $parentid = $parent -> parent_id;
          echo $fun -> fetchStudent($parentid);
        } else {
          echo $fun -> getMsgInvalidParam();
        }

    }

    } else {

      echo $fun -> getMsgParamNotEmpty();
    }


  } else {
      echo $fun -> getMsgInvalidParam();
  }

} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){

  echo "Sorry";

}

?>