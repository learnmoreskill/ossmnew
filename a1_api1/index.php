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

        if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'principal')){

          if(isset($data -> data -> email) && isset($data -> data -> password)){

              $principal = $data -> data;
              $email = $principal -> email;
              $password = $principal -> password;

              echo $fun -> loginPrincipal($email, $password);

          }else {
            echo $fun -> getMsgInvalidParam();
          }
        }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'teacher')){

            if(isset($data -> data -> email) && isset($data -> data -> password)){

                $teacher = $data -> data;
                $email = $teacher -> email;
                $password = $teacher -> password;

                echo $fun -> loginTeacher($email, $password);

              }
           else {
            echo $fun -> getMsgInvalidParam();
          }
        }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'student')){

            if(isset($data -> data -> email) && isset($data -> data -> password)){

                $student = $data -> data;
                $email = $student -> email;
                $password = $student -> password;

                echo $fun -> loginStudent($email, $password);

              }
           else {
            echo $fun -> getMsgInvalidParam();
          }
        }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'parent')){

            if(isset($data -> data -> email) && isset($data -> data -> password)){

                $parent = $data -> data;
                $email = $parent -> email;
                $password = $parent -> password;

                echo $fun -> loginParent($email, $password);

              }
           else {
            echo $fun -> getMsgInvalidParam();
          }
        }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'accountant')){

            if(isset($data -> data -> email) && isset($data -> data -> password)){

                $accountant = $data -> data;
                $email = $accountant -> email;
                $password = $accountant -> password;

                echo $fun -> loginAccountant($email, $password);

              }
           else {
            echo $fun -> getMsgInvalidParam();
          }
        }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'librarian')){

            if(isset($data -> data -> email) && isset($data -> data -> password)){

                $librarian = $data -> data;
                $email = $librarian -> email;
                $password = $librarian -> password;

                echo $fun -> loginLibrarian($email, $password);

              }
           else {
            echo $fun -> getMsgInvalidParam();
          }
        }else {
            echo $fun -> getMsgInvalidParam();
          }

    	}else if($operation == '5h6ck573ru53rd376115') {

            if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'schooldetails')){

                echo $fun -> schoolDetails();
                
            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'studentdetails')){

                echo $fun -> studentDetails();
                
            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'parentdetails')){

                echo $fun -> parentDetails();

            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'teacherdetails')){

                echo $fun -> teacherDetails();

            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'staffdetails')){

                echo $fun -> staffDetails();

            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'classdetails')){

                echo $fun -> classDetails();

            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'sectiondetails')){

                echo $fun -> sectionDetails();

            } else {
              echo $fun -> getMsgInvalidParam();
            }

      }else if($operation == '55361ch') {

            if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'student')){

                echo $fun -> searchStudent($data -> key);
                
            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'studentWithClassIdSectionId')){

                echo $fun -> studentWithClassIdSectionId($data -> key, $data -> classId, $data -> sectionId);

            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'parent')){

                echo $fun -> searchParent($data -> key);

            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'teacher')){

                echo $fun -> searchTeacher($data -> key);

            }else if(isset($data -> role ) && !empty($data -> role) && ($data -> role == 'staff')){

                echo $fun -> searchStaff($data -> key);

            } else {
              echo $fun -> getMsgInvalidParam();
            }

      } else if($operation == 'getschooldetails') {
            if(isset($data -> schooldetails ) && !empty($data -> schooldetails)) {
              $schooldetails = $data -> schooldetails;
              echo $fun -> getschooldetails($schooldetails);
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

      }
  	}else{

  		echo $fun -> getMsgParamNotEmpty();
  	}

  } else {
  		echo $fun -> getMsgInvalidRequest();
  }

} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){

  echo "Sorry";

}

?>
