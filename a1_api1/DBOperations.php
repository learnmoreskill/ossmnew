<?php
include('../config/sendbulksms.php');

class DBOperations{

    private $conn;

    public function __construct() {

        require('../config/config.php');

        $this -> conn = new PDO("mysql:host=$db_server;dbname=$db_database", $db_username, $db_password);
    }



public function schoolDetails() {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM `schooldetails` ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "school_name" => $data -> school_name,
            "school_code" => $data -> school_code,
            "school_address" => $data -> school_address,
            "school_logo" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> slogo,
            "estd" => $data -> estd,
            "pan_no" => $data -> pan_no,
            "phone_no" => $data -> phone_no,
            "phone_2" => $data -> phone_2,
            "email_id" => $data -> email_id,
            "facebook" => $data -> facebook,
            "twitter" => $data -> twitter,
            "instagram" => $data -> instagram,
            "youtube" => $data -> youtube,

            "date_type" => $data -> date_type,

            "slogan" => $data -> slogan,

            "cbms_username" => $data -> cbms_username,
            "cbms_password" => $data -> cbms_password,
            
        ));
    }
    return $response;
}


public function studentDetails() {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM studentinfo 
            LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
            LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
            LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
            ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "sid" => $data -> sid,
            "roll" => $data -> sroll,
            "admission" => $data -> sadmsnno,
            "name" => $data -> sname,
            "address" => $data -> saddress,
            "email" => $data -> semail,
            "class" => $data -> sclass,
            "sec" => $data -> ssec,
            "class_name" => $data -> class_name,
            "section_name" => $data -> section_name,
            "gender" => $data -> sex,
            "dob" => $data -> dob,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> simage,
            "mobile" => $data -> smobile,

            "payment_type" => $data -> payment_type,
            "tution_fee" => $data -> tution_fee,
            "bus_id" => $data -> bus_id,
            "bus_fee" => $data -> bus_fee,
            "hostel_fee" => $data -> hostel_fee,
            "computer_fee" => $data -> computer_fee,

            "parent_id" => $data -> sparent_id,
            "father_name" => $data -> spname,
            "mother_name" => $data -> smname,
            "parent_number" => $data -> spnumber,
            "parent_number_2" => $data -> spnumber_2,
            "status" => $data -> status,
        ));
    }
    return $response;
}

public function parentDetails() {

    $response = array();
    $sql = 'SELECT * FROM parents ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "parent_id" => $data -> parent_id,
            "father_name" => $data -> spname,
            "mother_name" => $data -> smname,
            "parent_email" => $data -> spemail,
            "parent_number" => $data -> spnumber,
            "parent_number_2" => $data -> spnumber_2,
            "profession" => $data -> spprofession,
            "address" => $data -> sp_address,
            "status" => $data -> spstatus,
        ));
    }
    return $response;
}

public function teacherDetails() {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM teachers ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "id" => $data -> tid,
            "name" => $data -> tname,
            "email" => $data -> temail,
            "address" => $data -> taddress,
            "mobile" => $data -> tmobile,
            "gender" => $data -> sex,
            "dob" => $data -> dob,
            "designation" => $data -> designation,
            "father" => $data -> t_father,
            "mother" => $data -> t_mother,
            "country" => $data -> t_country,
            "phone" => $data -> t_phone,
            "marital" => $data -> t_marital,
            "jod" => $data -> t_join_date,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> timage,
            "salary" => $data -> t_salary,
            "jobtype" => $data -> t_jobtype,
            "status" => $data -> status,
        ));
    }
    return $response;
}


public function staffDetails() {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM staff_tbl ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "id" => $data -> stid,
            "name" => $data -> staff_name,
            "address" => $data -> staff_address,
            "mobile" => $data -> staff_mobile,
            "staff_type" => $data -> staff_type,
            "salary" => $data -> staff_salary,
            "email" => $data -> staff_email,
            "phone" => $data -> staff_phone,
            "gender" => $data -> staff_sex,
            "position" => $data -> staff_position,
            "marital" => $data -> staff_marital,
            "dob" => $data -> staff_dob,
            "father" => $data -> staff_father,
            "mother" => $data -> staff_mother,
            "country" => $data -> staff_country,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> staff_image,
            "jod" => $data -> staff_joindate,
            "status" => $data -> staff_status,
        ));
    }
    return $response;
}

public function classDetails() {

    $response = array();
    $sql = 'SELECT * FROM class WHERE status = 0 ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "id" => $data -> class_id,
            "name" => $data -> class_name,
            "tution_fee" => $data -> tution_fee,
            "computer_fee" => $data -> computer_fee,
            "hostel_fee" => $data -> hostel_fee,
            "admission_charge" => $data -> admission_charge,
            "annual_fee" => $data -> annual_fee,
            "exam_fee" => $data -> exam_fee,
            "uniform_fee" => $data -> uniform_fee,
            "book_fee" => $data -> book_fee,
            "monthly_testfee" => $data -> monthly_testfee,
            "registration_fee" => $data -> registration_fee,
            "security_fee" => $data -> security_fee,
        ));
    }
    return $response;
}

public function sectionDetails() {

$sqlallclass = "SELECT * FROM class WHERE status = 0 ORDER BY `class`.`class_id` ASC ";
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

    $sqlsectionlist = "SELECT section_name FROM `section` WHERE `section_class`='$classname1' AND `status`= 0 ORDER BY `section`.`section_name` ASC ";

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

public function searchStudent($key) {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM studentinfo 
            LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
            LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
            LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
            WHERE sadmsnno LIKE :key OR sname LIKE :key OR sroll LIKE :key OR spname LIKE :key OR smname LIKE :key
            ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':key' => $key.'%'));
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "sid" => $data -> sid,
            "roll" => $data -> sroll,
            "admission" => $data -> sadmsnno,
            "name" => $data -> sname,
            "address" => $data -> saddress,
            "email" => $data -> semail,
            "class" => $data -> sclass,
            "sec" => $data -> ssec,
            "class_name" => $data -> class_name,
            "section_name" => $data -> section_name,
            "gender" => $data -> sex,
            "dob" => $data -> dob,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> simage,
            "mobile" => $data -> smobile,

            "payment_type" => $data -> payment_type,
            "tution_fee" => $data -> tution_fee,
            "bus_id" => $data -> bus_id,
            "bus_fee" => $data -> bus_fee,
            "hostel_fee" => $data -> hostel_fee,
            "computer_fee" => $data -> computer_fee,

            "parent_id" => $data -> sparent_id,
            "father_name" => $data -> spname,
            "mother_name" => $data -> smname,
            "parent_number" => $data -> spnumber,
            "parent_number_2" => $data -> spnumber_2,
            "status" => $data -> status,
        ));
    }
    return $response;
}

public function studentWithClassIdSectionId($key,$classId,$sectionId) {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM studentinfo 
            LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
            LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
            LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
            WHERE sname LIKE :key AND sclass = :classId AND ssec = :sectionId
            ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':key' => '%'.$key.'%', ':classId' => $classId, ':sectionId' => $sectionId));
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "sid" => $data -> sid,
            "roll" => $data -> sroll,
            "admission" => $data -> sadmsnno,
            "name" => $data -> sname,
            "address" => $data -> saddress,
            "email" => $data -> semail,
            "class" => $data -> sclass,
            "sec" => $data -> ssec,
            "class_name" => $data -> class_name,
            "section_name" => $data -> section_name,
            "gender" => $data -> sex,
            "dob" => $data -> dob,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> simage,
            "mobile" => $data -> smobile,

            "payment_type" => $data -> payment_type,
            "tution_fee" => $data -> tution_fee,
            "bus_id" => $data -> bus_id,
            "bus_fee" => $data -> bus_fee,
            "hostel_fee" => $data -> hostel_fee,
            "computer_fee" => $data -> computer_fee,

            "parent_id" => $data -> sparent_id,
            "father_name" => $data -> spname,
            "mother_name" => $data -> smname,
            "parent_number" => $data -> spnumber,
            "parent_number_2" => $data -> spnumber_2,
            "status" => $data -> status,
        ));
    }
    return $response;
}


public function studentWithClassId($key,$classId) {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM studentinfo 
            LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
            LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
            LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
            WHERE sname LIKE :key AND sclass = :classId
            ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':key' => '%'.$key.'%', ':classId' => $classId));
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "sid" => $data -> sid,
            "roll" => $data -> sroll,
            "admission" => $data -> sadmsnno,
            "name" => $data -> sname,
            "address" => $data -> saddress,
            "email" => $data -> semail,
            "class" => $data -> sclass,
            "sec" => $data -> ssec,
            "class_name" => $data -> class_name,
            "section_name" => $data -> section_name,
            "gender" => $data -> sex,
            "dob" => $data -> dob,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> simage,
            "mobile" => $data -> smobile,

            "payment_type" => $data -> payment_type,
            "tution_fee" => $data -> tution_fee,
            "bus_id" => $data -> bus_id,
            "bus_fee" => $data -> bus_fee,
            "hostel_fee" => $data -> hostel_fee,
            "computer_fee" => $data -> computer_fee,

            "parent_id" => $data -> sparent_id,
            "father_name" => $data -> spname,
            "mother_name" => $data -> smname,
            "parent_number" => $data -> spnumber,
            "parent_number_2" => $data -> spnumber_2,
            "status" => $data -> status,
        ));
    }
    return $response;
}


public function searchParent() {

    $response = array();
    $sql = 'SELECT * FROM parents WHERE spname LIKE :key OR smname LIKE :key OR spemail LIKE :key OR spnumber LIKE :key ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':key' => $key.'%'));
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "parent_id" => $data -> parent_id,
            "father_name" => $data -> spname,
            "mother_name" => $data -> smname,
            "parent_email" => $data -> spemail,
            "parent_number" => $data -> spnumber,
            "parent_number_2" => $data -> spnumber_2,
            "profession" => $data -> spprofession,
            "address" => $data -> sp_address,
            "status" => $data -> spstatus,
        ));
    }
    return $response;
}

public function searchTeacher() {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM teachers WHERE tname LIKE :key OR temail LIKE :key OR tmobile LIKE :key ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':key' => $key.'%'));
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "id" => $data -> tid,
            "name" => $data -> tname,
            "email" => $data -> temail,
            "address" => $data -> taddress,
            "mobile" => $data -> tmobile,
            "gender" => $data -> sex,
            "dob" => $data -> dob,
            "designation" => $data -> designation,
            "father" => $data -> t_father,
            "mother" => $data -> t_mother,
            "country" => $data -> t_country,
            "phone" => $data -> t_phone,
            "marital" => $data -> t_marital,
            "jod" => $data -> t_join_date,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> timage,
            "salary" => $data -> t_salary,
            "jobtype" => $data -> t_jobtype,
            "status" => $data -> status,
        ));
    }
    return $response;
}


public function searchStaff() {

    Global $schoolFolderName;
    $response = array();
    $sql = 'SELECT * FROM staff_tbl WHERE staff_name LIKE :key OR staff_mobile LIKE :key OR staff_email LIKE :key  ';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':key' => $key.'%'));
    while($data = $query -> fetchObject()) {

        array_push($response,array(
            "id" => $data -> stid,
            "name" => $data -> staff_name,
            "address" => $data -> staff_address,
            "mobile" => $data -> staff_mobile,
            "staff_type" => $data -> staff_type,
            "salary" => $data -> staff_salary,
            "email" => $data -> staff_email,
            "phone" => $data -> staff_phone,
            "gender" => $data -> staff_sex,
            "position" => $data -> staff_position,
            "marital" => $data -> staff_marital,
            "dob" => $data -> staff_dob,
            "father" => $data -> staff_father,
            "mother" => $data -> staff_mother,
            "country" => $data -> staff_country,
            "image" => 'https://a1pathshala.com/manager/'.$schoolFolderName.'/profile_pic/'.$data -> staff_image,
            "jod" => $data -> staff_joindate,
            "status" => $data -> staff_status,
        ));
    }
    return $response;
}


public function checkPrincipalLogin($email, $password) {
    $sql = 'SELECT * FROM principal LEFT JOIN `schooldetails` ON `principal`.`pschoolcode`=`schooldetails`.`school_code` WHERE pemail = :email AND status = 0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $pass = $data -> ppassword;
    if ($password == $pass ) {
    $principal["id"] = $data -> pid;
    $principal["name"] = $data -> pname;
    $principal["gender"] = $data -> p_gender;
    $principal["email"] = $data -> pemail;
    $principal["mobile"] = $data -> p_mobile;
    $principal["image"] = $data -> aimage;

    $principal["school_code"] = $data -> pschoolcode;
    $principal["school_name"] = $data -> school_name;
    $principal["school_address"] = $data -> school_address;
    $principal["logo"] = $data -> slogo;
    $principal["estd"] = $data -> estd;
    $principal["pan_no"] = $data -> pan_no;
    $principal["phone_no1"] = $data -> phone_no;
    $principal["phone_no2"] = $data -> phone_2;
    $principal["email_id"] = $data -> email_id;
    $principal["facebook"] = $data -> facebook;
    $principal["twitter"] = $data -> twitter;
    $principal["instagram"] = $data -> instagram;
    $principal["youtube"] = $data -> youtube;
    $principal["tracker_username"] = $data -> tracker_username;
    $principal["tracker_password"] = $data -> tracker_password;
    //$principal["sms_token"] = $data -> sms_token;
        return $principal;
    } else {
        return false;
    }
 }

 public function checTeacherkLogin($email, $password) {
    $sql = 'SELECT * FROM teachers JOIN `schooldetails` WHERE temail = :email AND status = 0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $pass = $data -> tgetter;
    if ($password == $pass ) {
	    $teacher["id"] = $data -> tid;
        $teacher["name"] = $data -> tname;
        $teacher["email"] = $data -> temail;
        $teacher["address"] = $data -> taddress;
        $teacher["mobile"] = $data -> tmobile;
        $teacher["phone"] = $data -> t_phone;

        //$teacher["standard"] = $data -> tclass;
        //$teacher["sec"] = $data -> tsec;

        $teacher["sex"] = $data -> sex;
        $teacher["dob"] = $data -> dob;
        $teacher["father"] = $data -> t_father;
        $teacher["mother"] = $data -> t_mother;
        $teacher["country"] = $data -> t_country;
        $teacher["marital"] = $data -> t_marital;
        $teacher["idproof"] = $data -> t_id_proof;
        $teacher["doc2"] = $data -> t_doc2;
        $teacher["doc3"] = $data -> t_doc3;
        $teacher["joindate"] = $data -> t_join_date;
        $teacher["image"] = $data -> timage;
        $teacher["salary"] = $data -> tsalary;
        $teacher["jobtype"] = $data -> t_jobtype;

        $principal["school_code"] = $data -> school_code;
        $principal["school_name"] = $data -> school_name;
        $principal["school_address"] = $data -> school_address;
        $principal["logo"] = $data -> slogo;
        $principal["estd"] = $data -> estd;
        $principal["pan_no"] = $data -> pan_no;
        $principal["phone_no1"] = $data -> phone_no;
        $principal["phone_no2"] = $data -> phone_2;
        $principal["email_id"] = $data -> email_id;
        $principal["facebook"] = $data -> facebook;
        $principal["twitter"] = $data -> twitter;
        $principal["instagram"] = $data -> instagram;
        $principal["youtube"] = $data -> youtube;
        $principal["tracker_username"] = $data -> tracker_username;
        $principal["tracker_password"] = $data -> tracker_password;
        //$teacher["sms_token"] = $data -> sms_token;

        return $teacher;
    } else {
        return false;
    }
 }

 public function getschooldetails($schooldetails) {
    $sql = 'SELECT * FROM `schooldetails`';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
    $data = $query -> fetchObject();

        $school["schoolcode"] = $data -> school_code;
        $school["school"] = $data -> school_name;
        $school["school_address"] = $data -> school_address;
        $school["slogo"] = $data -> slogo;
        $school["phone_no"] = $data -> phone_no;
        $school["phone_no2"] = $data -> phone_2;
        $school["email_id"] = $data -> email_id;
        $school["facebook"] = $data -> facebook;
        $school["twitter"] = $data -> twitter;
        $school["instagram"] = $data -> instagram;
        $school["youtube"] = $data -> youtube;

        return $school;    
 }

public function getClassList() {
$sql = 'SELECT class_name FROM class';
$query = $this -> conn -> prepare($sql);
$query -> execute(array());
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

public function searchStudent1($name) {
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
$query -> execute(array(':sid' => $value->asid, ':sroll' => $value->asroll, ':sname' => $value->asname, ':status' => $value->astatus, ':astandard' => $value->aclass, ':asec' => $value->asec, ':today' => $today));

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

public function checkPrincipalExist($email){
    $sql = 'SELECT COUNT(*) from principal WHERE pemail =:email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
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


 public function checkTeacherExist($email){
    $sql = 'SELECT COUNT(*) from teachers WHERE temail =:email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
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

}

?>
