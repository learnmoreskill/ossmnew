<?php
include('../config/sendbulksms.php');

class DBOperations{

    private $conn;

    public function __construct() {

        require('../config/config.php');

        $this -> conn = new PDO("mysql:host=$db_server;dbname=$db_database", $db_username, $db_password);
    }

public function checkUserLogin($email, $password) {

    Global $schoolFolderName;

    //CHECK FOR PRINCIPAL
    $sql = 'SELECT `pid`,`pname`,`p_gender`,`ppassword`,`pemail`,`p_mobile`,`aimage`,`status` FROM `principal` WHERE `pemail` = :email';

    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));

    $rowCount = $query->rowCount();

    if ($rowCount == 1) {
        $data = $query ->fetchObject();

        if($data->ppassword == $password && $data->status == 0 ) {

            $details["id"] = $data -> pid;
            $details["name"] = $data -> pname;
            $details["gender"] = $data -> p_gender;
            $details["dob"] = '';
            $details["mobile"] = $data -> p_mobile;
            $details["address"] = '';
            $details["email"] = $data -> pemail;
            $details["image"] = ((!empty($data -> aimage))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> aimage : "");
                    

            $response["status"] = 200;
            $response["message"] = "Login Sucessful";
            $response["role"] = "admin";
            $response["data"] = $details;
            return json_encode($response);

        }else if ($data->ppassword == $password && $data->status != 0){

            $response["status"] = 201;
            $response["message"] = "Your account is disabled,Please contact your school.";
            return json_encode($response);

        }else if (empty($data->ppassword) && $data->status == 0){

            $response["status"] = 201;
            $response["message"] = "Your password has been expired,Please contact your school.";
            return json_encode($response);

        }else{ 

            $response["status"] = 201;
            $response["message"] = "Your login name or password is invalid";
            return json_encode($response);

        }

        
    }else{
        //CHECK FOR TEACHER
        $sql = 'SELECT `tid`,`tname`,`sex`,`dob`,`tgetter`,`temail`,`tmobile`,`taddress`,`timage`,`status` FROM `teachers` WHERE `temail` = :email';

        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));

        $rowCount = $query->rowCount();

        if ($rowCount == 1) {
            $data = $query ->fetchObject();

            if($data->tgetter == $password && $data->status == 0 ) {

                $details["id"] = $data -> tid;
                $details["name"] = $data -> tname;
                $details["gender"] = $data -> sex;
                $details["dob"] = $data -> dob;
                $details["mobile"] = $data -> tmobile;
                $details["address"] = $data -> taddress;
                $details["email"] = $data -> temail;
                $details["image"] = ((!empty($data -> timage))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> timage : "");
                        

                $response["status"] = 200;
                $response["message"] = "Login Sucessful";
                $response["role"] = "teacher";
                $response["data"] = $details;
                return json_encode($response);

            }else if ($data->tgetter == $password && $data->status != 0){

                $response["status"] = 201;
                $response["message"] = "Your account is disabled,Please contact your school.";
                return json_encode($response);

            }else if (empty($data->tgetter) && $data->status == 0){

                $response["status"] = 201;
                $response["message"] = "Your password has been expired,Please contact your school.";
                return json_encode($response);

            }else{ 

                $response["status"] = 201;
                $response["message"] = "Your login name or password is invalid";
                return json_encode($response);

            }

            
        }else{

        //CHECK FOR STAFF
        $sql = 'SELECT `stid`,`staff_name`,`staff_type`,`staff_sex`,`staff_dob`,`staff_getter`,`staff_email`,`staff_mobile`,`staff_address`,`staff_image`,`staff_status` FROM `staff_tbl` WHERE `staff_email` = :email';

        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));

        $rowCount = $query->rowCount();

        if ($rowCount == 1) {
            $data = $query ->fetchObject();

            if($data->staff_getter == $password && $data->staff_status == 0 ) {

                $details["id"] = $data -> stid;
                $details["name"] = $data -> staff_name;
                $details["gender"] = $data -> staff_sex;
                $details["dob"] = $data -> staff_dob;
                $details["mobile"] = $data -> staff_mobile;
                $details["address"] = $data -> staff_address;
                $details["email"] = $data -> staff_email;
                $details["image"] = ((!empty($data -> staff_image))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> staff_image : "");


                $details["staff_type"] = $data -> staff_type;
                        

                $response["status"] = 200;
                $response["message"] = "Login Sucessful";
                $response["role"] = "manager";
                $response["data"] = $details;
                return json_encode($response);

            }else if ($data->staff_getter == $password && $data->staff_status != 0){

                $response["status"] = 201;
                $response["message"] = "Your account is disabled,Please contact your school.";
                return json_encode($response);

            }else if (empty($data->staff_getter) && $data->staff_status == 0){

                $response["status"] = 201;
                $response["message"] = "Your password has been expired,Please contact your school.";
                return json_encode($response);

            }else{ 

                $response["status"] = 201;
                $response["message"] = "Your login name or password is invalid";
                return json_encode($response);

            }

            
        }else{

        //CHECK FOR STUDENT
        $sql = 'SELECT `sid`,`sname`,`saddress`,`semail`,`sgetter`,`sex`,`dob`,`simage`,`smobile`,`status` FROM `studentinfo` WHERE `semail` = :email';

        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));

        $rowCount = $query->rowCount();

        if ($rowCount == 1) {
            $data = $query ->fetchObject();

            if($data->sgetter == $password && $data->status == 0 ) {

                $details["id"] = $data -> sid;
                $details["name"] = $data -> sname;
                $details["gender"] = $data -> sex;
                $details["dob"] = $data -> dob;
                $details["mobile"] = $data -> smobile;
                $details["address"] = $data -> saddress;
                $details["email"] = $data -> semail;
                $details["image"] = ((!empty($data -> simage))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> simage : "");
                        

                $response["status"] = 200;
                $response["message"] = "Login Sucessful";
                $response["role"] = "student";
                $response["data"] = $details;
                return json_encode($response);

            }else if ($data->sgetter == $password && $data->status != 0){

                $response["status"] = 201;
                $response["message"] = "Your account is disabled,Please contact your school.";
                return json_encode($response);

            }else if (empty($data->sgetter) && $data->status == 0){

                $response["status"] = 201;
                $response["message"] = "Your password has been expired,Please contact your school.";
                return json_encode($response);

            }else{ 

                $response["status"] = 201;
                $response["message"] = "Your login name or password is invalid";
                return json_encode($response);

            }

            
        }else{

        //CHECK FOR PARENT

        $sql = 'SELECT `parent_id`,`spname`,`smname`,`spemail`,`spphone`,`spnumber`,`spprofession`,`sp_address`,`spstatus` FROM `parents` WHERE `spemail` = :email';

        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));

        $rowCount = $query->rowCount();

        if ($rowCount == 1) {
            $data = $query ->fetchObject();

            if($data->spphone == $password && $data->spstatus == 0 ) {

                $details["id"] = $data -> parent_id;
                $details["name"] = $data -> spname;

                $details["mother"] = $data -> smname;

                $details["mobile"] = $data -> spnumber;
                $details["address"] = $data -> sp_address;
                $details["email"] = $data -> spemail;

                $details["profession"] = $data -> spprofession;
                        

                $response["status"] = 200;
                $response["message"] = "Login Sucessful";
                $response["role"] = "parent";
                $response["data"] = $details;
                return json_encode($response);

            }else if ($data->spphone == $password && $data->spstatus != 0){

                $response["status"] = 201;
                $response["message"] = "Your account is disabled,Please contact your school.";
                return json_encode($response);

            }else if (empty($data->spphone) && $data->spstatus == 0){

                $response["status"] = 201;
                $response["message"] = "Your password has been expired,Please contact your school.";
                return json_encode($response);

            }else{ 

                $response["status"] = 201;
                $response["message"] = "Your login name or password is invalid";
                return json_encode($response);

            }

            
        }else{


            
        }
            
        }
            
        }
            
        }

    }

 }

public function getSchoolDetails() {
    Global $schoolFolderName;
    $sql = 'SELECT * FROM `schooldetails`';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    $data = $query -> fetchObject();

        $school["school_code"] = $data -> school_code;
        $school["school_name"] = $data -> school_name;
        $school["school_address"] = $data -> school_address;
        $school["logo"] = ((!empty($data -> slogo))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/logo/".$data -> slogo : "");
        $school["estd"] = $data -> estd;
        $school["phone_no"] = $data -> phone_no;
        $school["phone_no2"] = $data -> phone_2;
        $school["email_id"] = $data -> email_id;
        $school["facebook"] = $data -> facebook;
        $school["twitter"] = $data -> twitter;
        $school["instagram"] = $data -> instagram;
        $school["youtube"] = $data -> youtube;

        return $school;    
 }

public function getAllActiveStaffDetails() {
    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM `principal` WHERE `status` = 0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    $data = $query -> fetchAll();

    foreach($data as $row) {

        array_push($response,array(

            "id" => $row['pid'],
            "type" => 'admin',
            "role" => 'admin',
            "role_code" => 1,
            "name" => $row['pname'],
            "gender" => $row['p_gender'],
            "dob" => '',
            "mobile" => $row['p_mobile'],
            "phone" => '',
            "address" => '',
            "blood" => '',
            "email" => $row['pemail'],
            "marital" => '',
            "father" => '',
            "mother" => '',
            "country" => '',
            "image" => ((!empty($row['aimage']))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$row['aimage'] : ""),

        ));
    }

    $sql1 = 'SELECT * FROM `teachers` WHERE `status` = 0';
    $query1 = $this -> conn -> prepare($sql1);
    $query1 -> execute();
    $data1 = $query1 -> fetchAll();

    foreach($data1 as $row) {

        array_push($response,array(


            "id" => $row['tid'],
            "type" => 'teacher',
            "role" => 'teacher',
            "role_code" => 2,
            "name" => $row['tname'],
            "gender" => $row['sex'],
            "dob" => $row['dob'],
            "mobile" => $row['tmobile'],
            "phone" => $row['t_phone'],
            "address" => $row['taddress'],
            "blood" => $row['blood_group'],
            "email" => $row['temail'],
            "marital" => $row['t_marital'],
            "father" => $row['t_father'],
            "mother" => $row['t_mother'],
            "country" => $row['t_country'],
            "image" => ((!empty($row['timage']))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$row['timage'] : ""),

        ));
    }
    $sql2 = 'SELECT * FROM `staff_tbl` WHERE `staff_status` = 0';
    $query2 = $this -> conn -> prepare($sql2);
    $query2 -> execute();
    $data2 = $query2 -> fetchAll();

    foreach($data2 as $row) {

        array_push($response,array(


            "id" => $row['stid'],
            "type" => $row['staff_type'],
            "role" => 'manager',
            "role_code" => 5,
            "name" => $row['staff_name'],
            "gender" => $row['staff_sex'],
            "dob" => $row['staff_dob'],
            "mobile" => $row['staff_mobile'],
            "phone" => $row['staff_phone'],
            "address" => $row['staff_address'],
            "blood" => $row['blood_group'],
            "email" => $row['staff_email'],
            "marital" => $row['staff_marital'],
            "father" => $row['staff_father'],
            "mother" => $row['staff_mother'],
            "country" => $row['staff_country'],
            "image" => ((!empty($row['staff_image']))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$row['staff_image'] : ""),

        ));
    }

    return $response;  
}

public function getAllActiveStudentDetails() {
    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM `studentinfo` 
    LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
    LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` WHERE `studentinfo`.`status` = 0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    $data = $query -> fetchAll();

    foreach($data as $row) {

        array_push($response,array(

            "id" => $row['sid'],
            "type" => 'student',
            "role" => 'student',
            "role_code" => 3,
            "name" => $row['sname'],
            "gender" => $row['sex'],
            "dob" => $row['dob'],
            "mobile" => $row['smobile'],
            "address" => $row['saddress'],
            "blood" => $row['blood_group'],
            "email" => $row['semail'],
            "image" => ((!empty($row['simage']))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$row['simage'] : ""),

            "class_id" => $row['sclass'],
            "section_id" => $row['ssec'],

            "roll_no" => $row['sroll'],
            "admission" => $row['sadmsnno'],
            "class_name" => $row['class_name'],
            "section_name" => $row['section_name'],

            "payment_type" => $row['payment_type'],
            "tution_fee" => $row['tution_fee'],
            "bus_id" => $row['bus_id'],
            "bus_fee" => $row['bus_fee'],
            "hostel_fee" => $row['hostel_fee'],
            "computer_fee" => $row['computer_fee'],

        ));
    }

    return $response;  
}

public function getGallery() {
    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM `gallery`
    LEFT JOIN `teachers` ON `gallery`.`uploader` = `teachers`.`tid`
    LEFT JOIN `principal` ON `gallery`.`uploader` = `principal`.`pid`
    WHERE `gallery`.`status` =0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();

    $data = $query -> fetchAll();

    foreach($data as $row) {

        array_push($response,array(
            "id" => $row['id'],
            "title" => $row['title'],
            "image" => ((!empty($row['imagename']))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/gallery/".$row['imagename'] : ""),
            "desc" => $row['desc'],
            "uploaded_by" => (($row['role']==1)? $row['pname'] : (($row['role']==2)? $row['tname'] : '' ) ),
            "date" => $row['date'],
        ));

    }

    return $response;   
 }

public function adminDetails($id) {
    Global $schoolFolderName;
    $sql = 'SELECT * FROM `principal` WHERE `pid` = :id';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':id' => $id));
    $data = $query -> fetchObject();

        $details["id"] = $data -> pid;
        $details["type"] = 'admin';
        $details["role"] = 'admin';
        $details["role_code"] = 1;
        $details["name"] = $data -> pname;
        $details["gender"] = $data -> p_gender;
        $details["dob"] = '';
        $details["mobile"] = $data -> p_mobile;
        $details["phone"] = '';
        $details["address"] = '';
        $details["blood"] = '';
        $details["email"] = $data -> pemail;
        $details["marital"] = '';
        $details["father"] = '';
        $details["mother"] = '';
        $details["country"] = '';
        $details["image"] = ((!empty($data -> aimage))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> aimage : "");

        return $details;    
}
public function studentDetails($id) {
    Global $schoolFolderName;
    $sql = 'SELECT * FROM `studentinfo` 
    LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
    LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
    LEFT JOIN `parents` ON `studentinfo`.`sparent_id` = `parents`.`parent_id` 
        AND `parents`.`spstatus` = 0
    WHERE `sid` = :id';

    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':id' => $id));
    $data = $query -> fetchObject();

        $details["id"] = $data -> sid;
        $details["name"] = $data -> sname;
        $details["gender"] = $data -> sex;
        $details["dob"] = $data -> dob;
        $details["mobile"] = $data -> smobile;
        $details["address"] = $data -> saddress;
        $details["blood"] = $data -> blood_group;
        $details["email"] = $data -> semail;
        $details["image"] = ((!empty($data -> simage))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> simage : "");

        $details["class_id"] = $data -> sclass;
        $details["section_id"] = $data -> ssec;

        $details["roll_no"] = $data -> sroll;
        $details["admission"] = $data -> sadmsnno;
        $details["class_name"] = $data -> class_name;
        $details["section_name"] = $data -> section_name;

        $details["payment_type"] = $data -> payment_type;
        $details["tution_fee"] = $data -> tution_fee;
        $details["bus_id"] = $data -> bus_id;
        $details["bus_fee"] = $data -> bus_fee;
        $details["hostel_fee"] = $data -> hostel_fee;
        $details["computer_fee"] = $data -> computer_fee;

        $details["parent_id"] = $data -> sparent_id;
        $details["father_name"] = $data -> spname;
        $details["mother_name"] = $data -> smname;
        $details["parent_mobile"] = $data -> spnumber;
        $details["parent_phone"] = $data -> spnumber_2;
        $details["parent_profession"] = $data -> spprofession;

    return $details;    
}
public function parentDetails($id) {
    Global $schoolFolderName;
    $sql = 'SELECT * FROM `parents` WHERE `parent_id` = :id';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':id' => $id));
    $data = $query -> fetchObject();

        $details["id"] = $data -> parent_id;
        $details["name"] = $data -> spname;

        $details["mother"] = $data -> smname;

        $details["mobile"] = $data -> spnumber;
        $details["address"] = $data -> sp_address;
        $details["email"] = $data -> spemail;

        $details["profession"] = $data -> spprofession;

        return $details;    
}
public function teacherDetails($id) {
    Global $schoolFolderName;
    $sql = 'SELECT * FROM `teachers` WHERE `tid` = :id';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':id' => $id));
    $data = $query -> fetchObject();

        $details["id"] = $data -> tid;
        $details["type"] = 'teacher';
        $details["role"] = 'teacher';
        $details["role_code"] = 2;
        $details["name"] = $data -> tname;
        $details["gender"] = $data -> sex;
        $details["dob"] = $data -> dob;
        $details["mobile"] = $data -> tmobile;
        $details["phone"] = $data -> t_phone;
        $details["address"] = $data -> taddress;
        $details["blood"] = $data -> blood_group;
        $details["email"] = $data -> temail;
        $details["marital"] = $data -> t_marital;
        $details["father"] = $data -> t_father;
        $details["mother"] = $data -> t_mother;
        $details["country"] = $data -> t_country;
        $details["image"] = ((!empty($data -> timage))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> timage : "");

        return $details;    
}
public function managerDetails($id) {
    Global $schoolFolderName;
    $sql = 'SELECT * FROM `staff_tbl` WHERE `stid` = :id';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':id' => $id));
    $data = $query -> fetchObject();

        $details["id"] = $data -> stid;
        $details["type"] = $data -> staff_type;
        $details["role"] = 'manager';
        $details["role_code"] = 5;
        $details["name"] = $data -> staff_name;
        $details["gender"] = $data -> staff_sex;
        $details["dob"] = $data -> staff_dob;
        $details["mobile"] = $data -> staff_mobile;
        $details["phone"] = $data -> staff_phone;
        $details["address"] = $data -> staff_address;
        $details["blood"] = $data -> blood_group;
        $details["email"] = $data -> staff_email;
        $details["marital"] = $data -> staff_marital;
        $details["father"] = $data -> staff_father;
        $details["mother"] = $data -> staff_mother;
        $details["country"] = $data -> staff_country;
        $details["image"] = ((!empty($data -> staff_image))? "https://a1pathshala.com/manager/uploads/".$schoolFolderName."/profile_pic/".$data -> staff_image : "");

        return $details;    
}

public function getTeacherStatic($date) {
    Global $schoolFolderName;
    $sql = 'SELECT COUNT(*) AS count FROM `teachers` WHERE `status`=0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    $data = $query -> fetchObject();

    $response["count"] = $data->count;

    $sql = 'SELECT `id`,`abpcount` AS `present`,`abacount` AS `absent`
        FROM `attendance_staff_check` 
        WHERE `staff`=2 AND `date` = :date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date));
    $data = $query -> fetchObject();
    $response["id"] = $data->id;
    $response["present"] = $data->present;
    $response["absent"] = $data->absent;

    return $response;    
}

public function getStudentStatic($date) {
    Global $schoolFolderName;
    $sql = 'SELECT COUNT(*) AS count FROM `studentinfo` WHERE `status`=0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    $data = $query -> fetchObject();

    $response["count"] = $data->count;

    $sql = 'SELECT `abid` AS `id`, SUM( `abpcount`) AS `present`, SUM(`abacount`) AS `absent` FROM `abcheck` WHERE `abdate` = :date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date));
    $data = $query -> fetchObject();
    $response["id"] = $data->id;
    $response["present"] = $data->present;
    $response["absent"] = $data->absent;

    return $response;    
}

public function getTeacherDetailStatic($year_id,$date) {

    $response = array();
    $sql = 'SELECT `id`, `attendance_staff`.`tid`, `teachers`.`tname`,`teachers`.`taddress`, `teachers`.`tmobile` , `attendance_staff`.`status` 
    FROM `attendance_staff`
    LEFT JOIN `teachers` ON `attendance_staff`.`tid` = `teachers`.`tid` 
    WHERE `attendance_staff`.`staff` = 2 AND `attendance_staff`.`year_id` = :year_id AND `attendance_staff`.`date` = :date ';

    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':year_id' => $year_id , ':date' => $date));

    $num_rows = $query -> fetchColumn();
    if ($num_rows > 0) {

        $data = $query -> fetchAll();

        foreach($data as $row) {

            array_push($response,array(
                "id" => $row['id'],
                "teacher_id" => $row['tid'],
                "teacher_name" => $row['tname'],
                "teacher_address" => $row['taddress'],
                "teacher_mobile" => $row['tmobile'],
                "status" => $row['status'],

            ));

        }
        return $response; 
        
    }else{
        return false;
    }

    
}

public function getStudentDetailStatic($year_id,$date,$class_id) {

    $response = array();
    $sql = 'SELECT `aid`, `attendance`.`asid`, `studentinfo`.`sroll`,`studentinfo`.`sname`, `attendance`.`astatus` 
    FROM `attendance`
    LEFT JOIN `studentinfo` ON `attendance`.`asid` = `studentinfo`.`sid` 
    WHERE `attendance`.`aclass` = :class_id AND `attendance`.`year_id` = :year_id AND `attendance`.`aclock` = :date ';

    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':class_id' => $class_id , ':year_id' => $year_id , ':date' => $date ));

    $num_rows = $query -> fetchColumn();
    if ($num_rows > 0) {

        $data = $query -> fetchAll();

        foreach($data as $row) {

            array_push($response,array(
                "id" => $row['aid'],
                "student_id" => $row['asid'],
                "student_rollno" => $row['sroll'],
                "student_name" => $row['sname'],
                "status" => $row['astatus'],

            ));

        }
        return $response; 
    }else{
        return false;
    }

    
}

public function getClassDetailStatic($year_id,$date) {

    $response = array();
    $sql = 'SELECT `class`.`class_id`, `class`.`class_name`, SUM(`abcheck`.`abpcount`) AS `abpcount` , SUM(`abcheck`.`abacount`) AS `abacount` 
        FROM `class` 
        LEFT JOIN `abcheck` ON `class`.`class_id` = `abcheck`.`abclass` AND `abcheck`.`abdate` = :date 
        WHERE `class`.`year_id` = :year_id AND status = 0
        GROUP BY `class`.`class_id` ';

    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':year_id' => $year_id,':date' => $date));
    $data = $query -> fetchAll();

    foreach($data as $row) {

        $class_id = $row['class_id'];

        array_push($response,array(
            "class_id" => $row['class_id'],
            "class_name" => $row['class_name'],
            "present" => $row['abpcount'],
            "absent" => $row['abacount'],
            "attendance" => $this ->getStudentDetailStatic($year_id,$date,$row['class_id']),

        ));

    }

    return $response; 
}


public function getYearIdByYear($year) {

    $sql = 'SELECT `id` FROM `academic_year` WHERE `single_year`= :year';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':year' => $year));
        if ($query) {
            $data = $query -> fetchObject();
            return $data -> id;
        }else{
            return false;
        }
}



// OLD BELOW



public function getClassList() {
    $sql = 'SELECT class_name FROM class';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    $data = $query -> fetchAll();
    return $data;
}



public function fetchsectionbyclass($class) {
    $sql = 'SELECT section_name FROM section WHERE `section`.`section_class`= :class';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':class' => $class));
    $data = $query -> fetchAll();
    return $data;
}

public function getSectionList() {

    $sqlallclass = "SELECT * FROM class ORDER BY `class`.`class_id` ASC ";
    $query = $this -> conn -> prepare($sqlallclass);
    $query -> execute(array());
    $data = $query -> fetchAll();

     $list="";
     $number = $query->rowCount();
     if ($number > 0) {
      $list=$list."[";
    $i=1;
    foreach($data as $row) {
        $list = $list.'{'.'"'.$row["class_name"].'"'.':';
        $classname1=$row["class_name"];

        $sqlsectionlist = "SELECT section_name FROM `section` WHERE `section_class`='$classname1' ORDER BY `section`.`section_name` ASC ";

        $query2 = $this -> conn -> prepare($sqlsectionlist);
        $query2 -> execute(array());
        $data2 = $query2 -> fetchAll();

        $number = $query->rowCount();
        if ($number > 0) { 
            $rows = array();

            foreach($data2 as $row1) {
                array_push($rows, $row1["section_name"]);
            }
            $list = $list.json_encode($rows);
        }else{ $list = $list.'[]'; } 

        if ($i < $number)
        {
         $list = $list.'},';
       }else{ $list = $list."}"; }

       $i ++;

       }
        $list = $list."]";
    }else{ $list="[]"; }
    return $list;

}

public function sendComplaint($tid,$tname,$schoolCode,$sid,$sname,$standard,$sec,$text,$pnumber) {
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    $sql = 'INSERT INTO complaint SET ctid = :tid,ctname = :tname,csid = :sid,csname = :sname,csclass = :standard,cssec = :sec,cmsg = :text,cdate = :date,cclock = NOW()';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid, ':tname' => $tname, ':sid' => $sid, ':sname' => $sname, ':standard' => $standard, ':sec' => $sec, ':text' => $text, ':date' => $today));
    if($query) {


        $querybulk = $this -> conn -> prepare('SELECT `sms_complaint`,`sms_token`  FROM `schooldetails`');
        $querybulk -> execute();
        $checkBulk = $querybulk -> fetchObject();
        if ($checkBulk -> sms_complaint == 1) {
            $sms_token = $checkBulk -> sms_token;

            if (strlen($pnumber)>=10) {
                $pnumber = $pnumber.substr($pnumber,-10).",";
            }

            /*Bulk Sms Service*/        
            $bulknumber=$pnumber; //enter Mobile numbers comma seperated
            $bulkmessage="Complaint: ".$text." Thank you"; //enter Your Message 

            $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);

    }


    return true;



    } else {

     return false;

    }
}

public function sendHomework($tid,$tname,$schoolcode,$schoolname,$subject,$topic,$standard,$sec) {
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    $sql = 'INSERT INTO homework SET htid = :tid,htname = :tname,hschoolcode = :schoolcode,hschoolname = :schoolname,hsubject = :subject,htopic = :topic,hclass = :standard,hsec = :sec,hdate = :today,hclock = NOW()';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid, ':tname' => $tname, ':schoolcode' => $schoolcode, ':schoolname' => $schoolname, ':subject' => $subject, ':topic' => $topic, ':standard' => $standard, ':sec' => $sec, ':today' => $today));
    if($query) {
    return true;
    } else {
    return false;
    }
}

public function sendBroadcast($tid,$tname,$standard,$sec,$schoolName,$schoolCode,$text) {
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    $sql = 'INSERT INTO broadcasts SET bmtid = :tid,bmtname = :tname,bmtext = :text,bmschoolcode = :schoolCode,bmschoolname = :schoolName,bmclass = :standard,bmsec = :sec,bmdate = :date,bmclock = NOW()';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid, ':tname' => $tname, ':text' => $text, ':schoolCode' => $schoolCode, ':schoolName' => $schoolName, ':standard' => $standard, ':sec' => $sec, ':date' => $today));
    if($query) {

        $querybulk = $this -> conn -> prepare('SELECT `sms_broadcast`,`sms_token`  FROM `schooldetails`');
        $querybulk -> execute();
        $checkBulk = $querybulk -> fetchObject();
        if ($checkBulk -> sms_broadcast == 1) {

            $sms_token = $checkBulk -> sms_token;


                $sql1 = 'SELECT * from studentinfo LEFT JOIN parents ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE sclass = :standard AND ssec = :sec AND status = 0 GROUP BY `parents`.`spnumber`';
                $query1 = $this -> conn -> prepare($sql1);
                $query1 -> execute(array(':standard' => $standard, ':sec' => $sec));
                $num_rows = $query1 -> fetchColumn();
                if ($num_rows > 0) {
                while($data = $query1 -> fetchObject()) {

                if (strlen($data -> spnumber)>=10) {
                    $list = $list.substr($data -> spnumber,-10).",";
                }
                }
                }



            /*Bulk Sms Service*/
            $bulknumber=$list; //enter Mobile numbers comma seperated
            $bulkmessage="Notice : ".$text." Thank you"; //enter Your Message

            $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);
        }
    /*
    return $bulkresult;*/
    return true;



    } else {

     return false;

    }
}

public function fetchHomework($tid,$date,$standard,$sec,$fetchtype) {
    if($fetchtype == 1) {
    if($standard == 0 && $sec == 0){
    $sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE hdate = :date and htid = :tid ORDER BY hdate DESC';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date, ':tid' => $tid));
    $data = $query -> fetchAll();
    } else {
    $sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE hdate = :date and htid = :tid and hclass = :standard and hsec = :sec ORDER BY hdate DESC';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date, ':tid' => $tid, ':standard' => $standard, ':sec' => $sec));
    $data = $query -> fetchAll();
    }
    } else {
    if($standard == 0 && $sec == 0){
    $sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE  htid = :tid ORDER BY hdate DESC';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid));
    $data = $query -> fetchAll();
    } else {
    $sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE htid = :tid and hclass = :standard and hsec = :sec ORDER BY hdate DESC';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid, ':standard' => $standard, ':sec' => $sec));
    $data = $query -> fetchAll();
    }
    }
    return $data;
}

public function fetchMyBroadcast($tid,$date) {

    header('Content-Type: text/html; charset = utf-8');
    $query1 = $this -> conn -> prepare("SET NAMES utf8");
    $query1 -> execute();

    $sql = 'SELECT bmtname,bmtext,bmclass,bmsec,bmclock FROM broadcasts WHERE bmtid = :tid and bmdate = :date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid, ':date' => $date));
    $data = $query -> fetchAll();
    return $data;
}

public function searchStudent($name) {
    $sql = 'SELECT sid,sroll,sname,sclass,ssec,saddress,semail,spname,spnumber,spemail FROM studentinfo LEFT JOIN parents ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE sname LIKE :name OR sroll LIKE :name OR sclass LIKE :name';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':name' => $name.'%'));
    $data = $query -> fetchAll();
    return $data;
}

public function submitAttendance($standard,$sec,$id,$schoolcode,$attendanceData){
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    $bit=1;
    $acount=0;
    $pcount=0;
    foreach ($attendanceData as $key => $value) {
    $sql = 'INSERT INTO attendance SET asid = :sid,asroll = :sroll,asname = :sname,astatus = :status,aclass = :astandard,asec = :asec,aclock = :today';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':sid' => $value->asid, ':sroll' => $value->asroll, ':sname' => $value->asname, ':status' => $value->astatus,  ':astandard' => $value->aclass, ':asec' => $value->asec, ':today' => $today));

    if ($value->astatus == "P"){
    $pcount++;
    } else if ($value->astatus == "A"){
    $acount++;

        $list="";
        $querybulk = $this -> conn -> prepare('SELECT `sms_attendance`,`sms_token`  FROM `schooldetails`');
        $querybulk -> execute();
        $checkBulk = $querybulk -> fetchObject();
        if ($checkBulk -> sms_attendance == 1) {
            $sms_token = $checkBulk -> sms_token;

            if (strlen($value->spnumber)>=10) {
                $list = $list.substr($value->spnumber,-10).",";
            }

            /*Bulk Sms Service*/
            $bulknumber=$list; //enter Mobile numbers comma seperated
            $bulkmessage="Your child $value->asname is absent today for the class."; //enter Your Message 

            $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);

        }



    }//else

    }//foreach
    $sql = 'INSERT INTO abcheck SET abclass = :standard,absec = :sec,abdate = :today,abbit = :bit,abpcount = :pcount,abacount = :acount,teacher_id = :id';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':standard' => $standard, ':sec' => $sec, ':today' => $today, ':bit' => $bit, ':pcount' => $pcount, ':acount' => $acount, ':id' => $id));
    if($query) {
    return true;
    } else {
    return false;
    }
}

public function isThereAnyHomework($tid,$date,$standard,$sec,$fetchtype){
 if($fetchtype == 1){
    if($standard == 0 && $sec == 0){
        $sql = 'SELECT COUNT(*) from homework WHERE hdate =:date and htid = :tid';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':date' => $date, ':tid' => $tid));
    } else {
        $sql = 'SELECT COUNT(*) from homework WHERE hdate =:date and htid = :tid and hclass =:standard and hsec =:sec';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':date' => $date, ':tid' => $tid, ':standard' => $standard, ':sec' => $sec));
    }
    } else {
    if($standard == 0 && $sec == 0){
        $sql = 'SELECT COUNT(*) from homework WHERE htid = :tid';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':tid' => $tid));
    } else {
        $sql = 'SELECT COUNT(*) from homework WHERE htid = :tid and hclass =:standard and hsec =:sec';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':tid' => $tid, ':standard' => $standard, ':sec' => $sec));
    }
    }
        if($query){
            $row_count = $query -> fetchColumn();
            if ($row_count == 0){
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
}

public function SubmitHwnd($hwnd){
    foreach ($hwnd as $key => $value) {
    if ($value->hwndstatus == "ND"){
    $sql = 'INSERT INTO hwnotdone SET hwndsid = :sid,hwndsub = :subject,hwnddate = :date,hwndclock = NOW()';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':sid' => $value -> hwndsid, ':subject' => $value -> hwndsub, ':date' => $value -> hwnddate));
    if($query){

        $list = "";
        $querybulk = $this -> conn -> prepare('SELECT `sms_nohomework`,`sms_token`  FROM `schooldetails`');
        $querybulk -> execute();
        $checkBulk = $querybulk -> fetchObject();
        if ($checkBulk -> sms_nohomework == 1) {
            $sms_token = $checkBulk -> sms_token;

            if (strlen($value->spnumber)>=10) {
                $list = $list.substr($value->spnumber,-10).",";
            }

            /*Bulk Sms Service*/
            $bulknumber=$list; //enter Mobile numbers comma seperated
            $bulkmessage="Notice: Your child has not done ".$value->hwndsub." HW given on ".$value->hwnddate.". Thank you"; //enter Your Message 

            $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);

        }



    } //if
    } //if
    } //foreach
    return true;
}

public function SubmitFeenp($feenp){
    foreach ($feenp as $key => $value) {
    if ($value->feenpstatus == "NP"){
    $sql = 'INSERT INTO feenotpaid SET feenpsid = :sid,feenpclock = NOW()';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':sid' => $value -> feenpsid));
    if($query){

        $list = "";
        $querybulk = $this -> conn -> prepare('SELECT `sms_feenotice`,`sms_token`  FROM `schooldetails`');
        $querybulk -> execute();
        $checkBulk = $querybulk -> fetchObject();
        if ($checkBulk -> sms_feenotice == 1) {
            $sms_token = $checkBulk -> sms_token;

            if (strlen($value->spnumber)>=10) {
                $list = $list.substr($value->spnumber,-10).",";
            }

            /*Bulk Sms Service*/
            $bulknumber=$list; //enter Mobile numbers comma seperated
            $bulkmessage="Notice : Fee dues for your child.Kindly submit by 15th of each month.After 15th of running month 10% of total due will be charged as a late fine.Thank you"; //enter Your Message  

            $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);
        }

    } //if
    } //if
    } //foreach
    return true;
}

public function SubmitGroupComplaint($grpc){
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    foreach ($grpc as $key => $value) {
    if ($value->cstatus == "Y"){
    $sql = 'INSERT INTO complaint SET ctid = :tid,ctname = :tname,csid = :sid,csname = :sname,csclass = :standard,cssec = :sec,cmsg = :text,cdate = :date,cclock = NOW()';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $value->ctid, ':tname' => $value->ctname, ':sid' => $value->csid, ':sname' => $value->csname, ':standard' => $value->csclass, ':sec' => $value->cssec, ':text' => $value->cmsg, ':date' => $today));
    if($query){
        $list = "";
        $querybulk = $this -> conn -> prepare('SELECT `sms_complaint`,`sms_token`  FROM `schooldetails`');
        $querybulk -> execute();
        $checkBulk = $querybulk -> fetchObject();
        if ($checkBulk -> sms_complaint == 1) {
            $sms_token = $checkBulk -> sms_token;

            if (strlen($value->spnumber)>=10) {
                $list = $list.substr($value->spnumber,-10).",";
            }

            /*Bulk Sms Service*/
            $bulknumber=$list; //enter Mobile numbers comma seperated
            $bulkmessage="Notice : $value->cmsg Thank you"; //enter Your Message    

            $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);
        }



    } //if
    } //if
    } //foreach
    return true;
}

public function submitAttendanceEdit($standard,$sec,$attendanceEditData){
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    $acount=0;
    $pcount=0;
    foreach ($attendanceEditData as $key => $value) {
    if ($value->astatus == "P"){
    $pcount++;
    } else if ($value->astatus == "A"){
    $acount++;
    }
        $sql = 'SELECT * FROM attendance WHERE aid = :aid';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':aid' => $value -> aid));
        $data = $query -> fetchObject();
    if(!($data -> astatus == $value -> astatus)) { //check if attendance status changed
    $sql = 'UPDATE attendance SET astatus =:status WHERE aid =:aid';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':status' => $value -> astatus, ':aid' => $value -> aid));
    if($query) { //check if table update then send message
        $sql = 'SELECT * FROM studentinfo WHERE sid = :sid';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':sid' => $value -> asid));
        $data = $query -> fetchObject();
        $pnumber = $data -> spnumber; //get parent's number


        $querybulk = $this -> conn -> prepare('SELECT `sms_attendance`,`sms_token`  FROM `schooldetails`');
        $querybulk -> execute();
        $checkBulk = $querybulk -> fetchObject();
        if ($checkBulk -> sms_attendance == 1) {
            $sms_token = $checkBulk -> sms_token;

            if ($value -> astatus == "P") { //is present

                if (strlen($pnumber)>=10) {
                $pnumber = $pnumber.substr($pnumber,-10).",";
                }

            /*Bulk Sms Service*/
            $bulknumber=$pnumber; //enter Mobile numbers comma seperated
            $bulkmessage="Your child $value->asname is PRESENT today for the class.Sorry for inconvenience."; //enter Your Message  

            $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);


            } else if ($value -> astatus == "A") { //is absent

                if (strlen($pnumber)>=10) {
                $pnumber = $pnumber.substr($pnumber,-10).",";
                }
                /*Bulk Sms Service*/
                $bulknumber=$pnumber; //enter Mobile numbers comma seperated
                $bulkmessage="Your child $value->asname is absent today for the class."; //enter Your Message  

                $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);
            }
        }


    } //if

    } //if
    } //foreach

    $sql = 'UPDATE abcheck SET abpcount =:pcount,abacount =:acount WHERE abclass =:standard and absec =:sec and abdate =:today';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':acount' => $acount, ':pcount' => $pcount, ':standard' => $standard, ':sec' => $sec, ':today' => $today));
    if($query){
    return true;
    } else {
    return false;
    }
}

public function isAttendanceDoneOnDate($date,$standard,$sec){
    $sql = 'SELECT COUNT(*) from attendance WHERE aclock = :date and aclass = :standard and asec = :sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
    if($query){
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}
public function gettecheridofattendance($standard,$section) {
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    $sql = 'SELECT teacher_id,tname from abcheck left join teachers on `abcheck`.`teacher_id`=`teachers`.`tid` WHERE abdate = :today and abclass = :standard and absec = :sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':today' => $today, ':standard' => $standard, ':sec' => $section));
        if ($query) {
            $data = $query -> fetchObject();
            $attendanceteacher["id"] = $data -> teacher_id;
            $attendanceteacher["name"] = $data -> tname;
            return $attendanceteacher;
        }else{
            return false;
        }
}

public function fetchAttendanceView($date,$standard,$sec) {
$sql = 'SELECT aclock,asname,asroll,aclass,asec,astatus from attendance WHERE aclock = :date and aclass = :standard and asec = :sec';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
return $data;
}
public function getAcount($date,$standard,$sec) {
$sql = 'SELECT COUNT(*) from attendance WHERE aclock = :date and aclass = :standard and asec = :sec and astatus = "A"';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
$acount = $query -> fetchColumn();
return $acount;
}
public function getPcount($date,$standard,$sec) {
$sql = 'SELECT COUNT(*) from attendance WHERE aclock = :date and aclass = :standard and asec = :sec and astatus = "P"';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
$pcount = $query -> fetchColumn();
return $pcount;
}

public function FetchAttendanceList($standard,$sec) {
$sql = 'SELECT sid,sroll,sname,sclass,ssec,saddress,semail,spname,spnumber,spemail FROM studentinfo LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE sclass = :standard and ssec = :sec and status = 0';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
return $data;
}

public function FetchAttendanceEditList($standard,$sec) {
date_default_timezone_set('Asia/Kathmandu');
$today = date("Y-m-d");
$sql = 'SELECT * FROM attendance WHERE aclass = :standard and asec = :sec and aclock = :today';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec, ':today' => $today));
$data = $query -> fetchAll();
return $data;
}

public function fetchMyComplaint($tid,$date) {

header('Content-Type: text/html; charset = utf-8');
$query1 = $this -> conn -> prepare("SET NAMES utf8");
$query1 -> execute();

$sql = 'SELECT ctname,cmsg,csname,csclass,cssec,cclock FROM complaint WHERE ctid = :tid and cdate = :date';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':tid' => $tid, ':date' => $date));
$data = $query -> fetchAll();
return $data;
}

public function isThereAnyComplaintByMe($tid,$date){
    $sql = 'SELECT COUNT(*) from complaint WHERE ctid = :tid and cdate = :date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid, ':date' => $date));
    if($query){
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

public function isThereAnyBroadcastByMe($tid,$date){
    $sql = 'SELECT COUNT(*) from broadcasts WHERE bmtid = :tid and bmdate = :date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':tid' => $tid, ':date' => $date));
    if($query){
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

public function isThereAnyStudent($name){
    $sql = 'SELECT COUNT(*) from studentinfo WHERE sname LIKE :name OR sroll LIKE :name OR sclass LIKE :name';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':name' => $name.'%'));
    if($query){
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }
    } else {
        return false;
    }
}

public function isThereAnyStudentInClass($standard,$sec){
    $sql = 'SELECT COUNT(*) from studentinfo WHERE sclass = :standard and ssec = :sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':standard' => $standard, ':sec' => $sec));
    if($query){
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }
    } else {
	return false;
    }
}

public function isAttendanceDone($standard,$section){
    date_default_timezone_set('Asia/Kathmandu');
    $today = date("Y-m-d");
    $sql = 'SELECT COUNT(*) from abcheck WHERE abclass = :standard and absec = :section and abdate = :today';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':standard' => $standard, ':section' => $section, ':today' => $today));
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }
}

public function checkUserExist($email){

    $sql = '(SELECT `pid` AS id FROM principal WHERE pemail = :email) 
            UNION
            (SELECT `tid` AS id FROM teachers WHERE temail = :email) 
            UNION
            (SELECT `parent_id` AS id FROM parents WHERE `spemail` = :email) 
            UNION
            (SELECT `sid` AS id FROM studentinfo WHERE `semail` = :email)
            UNION
            (SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = :email)';

    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));

    $rowCount = $query->rowCount();

    return $rowCount;
    
 }

public function checkSpecificUserExist($role,$id){

    if ($role == 'admin') {

        $sql = 'SELECT COUNT(*) from principal WHERE pid = :id';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':id' => $id));
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }

    }else if ($role == 'student') {

        $sql = 'SELECT COUNT(*) from studentinfo WHERE sid = :id';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':id' => $id));
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }

    }else if ($role == 'teacher') {

        $sql = 'SELECT COUNT(*) from teachers WHERE tid = :id';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':id' => $id));
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }

    }else if ($role == 'parent') {

        $sql = 'SELECT COUNT(*) from parents WHERE parent_id = :id';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':id' => $id));
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }

    }else if ($role == 'manager') {

        $sql = 'SELECT COUNT(*) from staff_tbl WHERE stid = :id';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':id' => $id));
        $row_count = $query -> fetchColumn();
        if ($row_count == 0){
            return false;
        } else {
            return true;
        }

    }else{
        return false;
    }
    
    
}

}

?>
