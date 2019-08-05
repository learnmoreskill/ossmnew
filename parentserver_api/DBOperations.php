<?php

class DBOperations{
    
    private $conn;

    public function __construct() {

        require('../config/config.php');

        $this -> conn = new PDO("mysql:host=$db_server;dbname=$db_database", $db_username, $db_password);
    }

 public function checkLogin($email, $password) {
    $sql = 'SELECT * FROM parents JOIN `schooldetails` LEFT JOIN `studentinfo` ON `parents`.`parent_id`=`studentinfo`.`sparent_id`  WHERE spemail = :email and spstatus = 0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $pass = $data -> spphone;
    if ($password == $pass ) {

        $parent["parent_id"] = $data -> parent_id;
	    $parent["spname"] = $data -> spname;
        $parent["smname"] = $data -> smname;
        $parent["spemail"] = $data -> spemail;
        $parent["spnumber"] = $data -> spnumber;
        $parent["spnumber2"] = $data -> spnumber_2;
        $parent["spprofession"] = $data -> spprofession;
        $parent["sp_address"] = $data -> sp_address;        

        $parent["sschoolcode"] = $data -> school_code;
        $parent["sschool"] = $data -> school_name;
        $parent["school_address"] = $data -> school_address;
        $parent["slogo"] = $data -> slogo;
        $parent["phone_no"] = $data -> phone_no;
        $parent["phone_no2"] = $data -> phone_2;
        $parent["email_id"] = $data -> email_id;
        $parent["facebook"] = $data -> facebook;
        $parent["twitter"] = $data -> twitter;
        $parent["instagram"] = $data -> instagram;
        $parent["youtube"] = $data -> youtube;
        $parent["tracker_username"] = $data -> tracker_username;
        $parent["tracker_password"] = $data -> tracker_password;
        

        return $parent;
    } else {
        return false;
    }
 }

public function fetchStudentAttendance($sid) {
$sql = 'SELECT aclock from attendance WHERE asid =:sid and astatus = "A" ORDER BY aclock DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':sid' => $sid));
$data = $query -> fetchAll();
return $data;
}

public function getAcount($sid) {
$sql = 'SELECT COUNT(*) from attendance WHERE asid = :sid and astatus = "A"';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':sid' => $sid));
$acount = $query -> fetchColumn();
return $acount;
}
public function getPcount($sid) {
$sql = 'SELECT COUNT(*) from attendance WHERE asid = :sid and astatus = "P"';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':sid' => $sid));
$pcount = $query -> fetchColumn();
return $pcount;
}

public function fetchStudentComplaint($sid) {

header('Content-Type: text/html; charset = utf-8');
$query1 = $this -> conn -> prepare("SET NAMES utf8");
$query1 -> execute();

$sql = 'SELECT cmsg,cclock,ctname from complaint WHERE csid =:sid ORDER BY cclock DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':sid' => $sid));
$data = $query -> fetchAll();
return $data;
}

public function fetchClassBroadcast($standard,$sec) {

header('Content-Type: text/html; charset = utf-8');
$query1 = $this -> conn -> prepare("SET NAMES utf8");
$query1 -> execute();

$sql = 'SELECT bmtname,bmtext,bmclass,bmsec,bmdate,bmclock FROM broadcasts WHERE bmclass = :standard and bmsec = :sec ORDER BY bmdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
return $data;
}

public function fetchHomework($standard,$sec) {
$sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE hclass = :standard and hsec = :sec ORDER BY hdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
return $data;
}

public function fetchSchoolBroadcast() {

header('Content-Type: text/html; charset = utf-8');
$query1 = $this -> conn -> prepare("SET NAMES utf8");
$query1 -> execute();

$sql = 'SELECT brdpname,brdtext,pushed_at FROM princibroadcast ORDER BY pushed_at DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute();
$data = $query -> fetchAll();
return $data;
}

public function fetchStudent($parentid) {
$sql = 'SELECT sid,sroll,sadmsnno,sname,saddress,semail,sclass,ssec,sex,dob,simage,smobile,payment_type,tution_fee,`studentinfo`.`bus_id`,bus_fee,hostel_fee,computer_fee,status,transportation_id,bus_route,bus_stop,bus_time,bus_fee_rate,bus_number,tracker_type,stid FROM studentinfo LEFT JOIN `bus_route` ON `studentinfo`.`bus_id`=`bus_route`.`bus_route_id` LEFT JOIN `transportation` ON `bus_route`.`transportation_id`=`transportation`.`bus_id` WHERE sparent_id = :parentid and status = :status';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':parentid' => $parentid, ':status' => 0));
$data = $query -> fetchAll();
return $data;
}

public function isIrregular($sid){
    $sql = 'SELECT COUNT(*) from attendance WHERE asid =:sid and astatus = "A"';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':sid' => $sid));
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

public function isAnyComplaint($sid){
    $sql = 'SELECT COUNT(*) from complaint WHERE csid =:sid';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':sid' => $sid));
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

public function isThereAnyClassBroadcast($standard,$sec){
    $sql = 'SELECT COUNT(*) from broadcasts WHERE bmclass =:standard and bmsec =:sec';
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

public function isThereAnyHomework($standard,$sec){
    $sql = 'SELECT COUNT(*) from homework WHERE hclass =:standard and hsec =:sec';
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

public function isThereAnyStudent($parentid){
    $sql = 'SELECT COUNT(*) from studentinfo WHERE  sparent_id = :parentid and status = :status';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':parentid' => $parentid, ':status' => 0));
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


public function isThereAnySchoolBroadcast(){
    $sql = 'SELECT COUNT(*) from princibroadcast';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
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

/*public function fetchTrackbus() {

$trackerlogin = json_decode($backstage->get_tracker_details_of_admin());
$md5pw=md5("qFtAQwsz".$trackerlogin->tracker_password);

$trackresult= json_decode(getTrackerDetails($trackerlogin->tracker_username, $md5pw));

return $trackresult;
}
*/

public function isThereAnySchoolBus(){
    $sql = 'SELECT COUNT(*) from tracker';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
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

 public function checkParentExist($email){
    $sql = 'SELECT COUNT(*) from parents WHERE spemail =:email';
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
