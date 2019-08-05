<?php

include('../config/sendbulksms.php');

class DBOperations{

    private $conn;

    public function __construct() {

        require('../config/config.php');

        $this -> conn = new PDO("mysql:host=$db_server;dbname=$db_database", $db_username, $db_password);
    }

 public function checkLogin($email, $password) {
    $sql = 'SELECT * FROM principal LEFT JOIN `schooldetails` ON `principal`.`pschoolcode`=`schooldetails`.`school_code` WHERE pemail = :email AND status = 0';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $pass = $data -> ppassword;
    if ($password == $pass ) {
	$principal["id"] = $data -> pid;
        $principal["name"] = $data -> pname;
        $principal["email"] = $data -> pemail;
        $principal["school"] = $data -> school_name;
        return $principal;
    } else {
        return false;
    }
 }

public function fetchHomework($date,$standard,$sec,$fetchtype) {
if($fetchtype == 1) {
if($standard == 0 && $sec == 0){
$sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE hdate = :date ORDER BY hdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date));
$data = $query -> fetchAll();
} else {
$sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE hdate = :date and hclass = :standard and hsec = :sec ORDER BY hdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
}
} else {
if($standard == 0 && $sec == 0){
$sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework ORDER BY hdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute();
$data = $query -> fetchAll();
} else {
$sql = 'SELECT htname,hsubject,htopic,hclass,hsec,hdate,hclock FROM homework WHERE hclass = :standard and hsec = :sec ORDER BY hdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
}
}
return $data;
}

public function fetchMyBroadcast($date) {

header('Content-Type: text/html; charset = utf-8');
$query1 = $this -> conn -> prepare("SET NAMES utf8");
$query1 -> execute();


$sql = 'SELECT brdpname,brdtext,pushed_at FROM princibroadcast WHERE pushed_at LIKE :date';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date.'%'));
$data = $query -> fetchAll();
return $data;
}

public function isAttendanceDone($date,$standard,$sec){
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

public function sendBroadcast($pname,$text) {
$sql = 'INSERT INTO princibroadcast SET brdpname = :pname,brdtext = :text,pushed_at = NOW()';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':pname' => $pname, ':text' => $text));
if($query) {
$sql = 'SELECT * from studentinfo LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `status`=0 GROUP BY `parents`.`spnumber`';
$query = $this -> conn -> prepare($sql);
$query -> execute();
$num_rows = $query -> fetchColumn();
if ($num_rows > 0) {
while($data = $query -> fetchObject()) {

    if (strlen($data -> spnumber)>=10) {
        $list = $list.substr($data -> spnumber,-10).",";
    }
}
}

    $querybulk = $this -> conn -> prepare('SELECT `sms_broadcast`,`sms_token`  FROM `schooldetails`');
    $querybulk -> execute();
    $checkBulk = $querybulk -> fetchObject();
    if ($checkBulk -> sms_broadcast == 1) {
        $sms_token = $checkBulk -> sms_token;

        /*Bulk Sms Service*/
        $bulknumber=$list; //enter Mobile numbers comma seperated
        $bulkmessage="Notice : ".$text." Thank you"; //enter Your Message

        $bulkresult= sendbulk($sms_token,$bulknumber,$bulkmessage);
    }

/*return $bulkresult;*/
return true;



} else {

 return false;

}
}

public function fetchAttendance1($date,$standard,$sec) {
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
    
    public function isAttendanceByClass($standard,$sec){
    $sql = 'SELECT COUNT(*) from abcheck WHERE abclass = :standard and absec = :sec';
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

public function fetchAttendance2($standard,$sec) {
$sql = 'SELECT abdate,abclass,absec,abpcount,abacount from abcheck WHERE abclass = :standard and absec = :sec ORDER BY abdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
return $data;
}

    public function isAttendanceByDate($date){
    $sql = 'SELECT COUNT(*) from abcheck WHERE abdate = :date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date));
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

public function fetchAttendance3($date) {
$sql = 'SELECT abdate,abclass,absec,abpcount,abacount from abcheck WHERE abdate = :date ORDER BY abclass ASC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date));
$data = $query -> fetchAll();
return $data;
}

public function fetchBroadcast($date,$standard,$sec,$fetchtype) {
if($fetchtype == 1) {
if($standard == 0 && $sec == 0){
$sql = 'SELECT bmtname,bmtext,bmclass,bmsec,bmdate,bmclock FROM broadcasts WHERE bmdate = :date ORDER BY bmdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date));
$data = $query -> fetchAll();
} else {
$sql = 'SELECT bmtname,bmtext,bmclass,bmsec,bmdate,bmclock FROM broadcasts WHERE bmdate = :date and bmclass = :standard and bmsec = :sec ORDER BY bmdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
}
} else {
if($standard == 0 && $sec == 0){
$sql = 'SELECT bmtname,bmtext,bmclass,bmsec,bmdate,bmclock FROM broadcasts ORDER BY bmdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute();
$data = $query -> fetchAll();
} else {
$sql = 'SELECT bmtname,bmtext,bmclass,bmsec,bmdate,bmclock FROM broadcasts WHERE bmclass = :standard and bmsec = :sec ORDER BY bmdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
}
}
return $data;
}

public function fetchMessage($date,$standard,$sec,$fetchtype) {
if($fetchtype == 1) {
if($standard == 0 && $sec == 0){
$sql = 'SELECT ctname,csname,csclass,cssec,cmsg,cdate,cclock FROM complaint WHERE cdate = :date ORDER BY cdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date));
$data = $query -> fetchAll();
} else {
$sql = 'SELECT ctname,csname,csclass,cssec,cmsg,cdate,cclock FROM complaint WHERE cdate = :date and csclass = :standard and cssec = :sec ORDER BY cdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
}
} else {
if($standard == 0 && $sec == 0){
$sql = 'SELECT ctname,csname,csclass,cssec,cmsg,cdate,cclock FROM complaint ORDER BY cdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute();
$data = $query -> fetchAll();
} else {
$sql = 'SELECT ctname,csname,csclass,cssec,cmsg,cdate,cclock FROM complaint WHERE csclass = :standard and cssec = :sec ORDER BY cdate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':standard' => $standard, ':sec' => $sec));
$data = $query -> fetchAll();
}
}
return $data;
}

public function searchStudent($name) {
$sql = 'SELECT sid,sroll,sname,sclass,ssec,saddress,semail,spname,spnumber,spphone,spemail FROM studentinfo LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE sname LIKE :name  OR sroll LIKE :name OR sclass LIKE :name ORDER BY sname ASC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':name' => $name.'%'));
$data = $query -> fetchAll();
return $data;
}

public function fetchStudentAttendance($sid) {
$sql = 'SELECT aclock from attendance WHERE asid =:sid and astatus = "A" ORDER BY aclock DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':sid' => $sid));
$data = $query -> fetchAll();
return $data;
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

public function fetchStudentHomework($sid) {
$sql = 'SELECT hwndsub,hwnddate from hwnotdone WHERE hwndsid =:sid ORDER BY hwnddate DESC';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':sid' => $sid));
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

public function isAnyUndoneHomework($sid){
    $sql = 'SELECT COUNT(*) from hwnotdone WHERE hwndsid =:sid';
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

 public function isThereAnyHomework($date,$standard,$sec,$fetchtype){
 if($fetchtype == 1){
if($standard == 0 && $sec == 0){
    $sql = 'SELECT COUNT(*) from homework WHERE hdate =:date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date));
} else {
    $sql = 'SELECT COUNT(*) from homework WHERE hdate =:date and hclass =:standard and hsec =:sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
}
} else {
if($standard == 0 && $sec == 0){
    $sql = 'SELECT COUNT(*) from homework';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
} else {
    $sql = 'SELECT COUNT(*) from homework WHERE hclass =:standard and hsec =:sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':standard' => $standard, ':sec' => $sec));
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

public function isThereAnyBroadcastByMe($date){
    $sql = 'SELECT COUNT(*) from princibroadcast WHERE pushed_at LIKE :date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date.'%'));
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

public function isThereAnyBroadcast($date,$standard,$sec,$fetchtype){
if($fetchtype == 1) {
if($standard == 0 && $sec == 0){
    $sql = 'SELECT COUNT(*) from broadcasts WHERE bmdate =:date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date));
} else {
    $sql = 'SELECT COUNT(*) from broadcasts WHERE bmdate =:date and bmclass =:standard and bmsec =:sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
}
} else {
if($standard == 0 && $sec == 0){
    $sql = 'SELECT COUNT(*) from broadcasts';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
} else {
    $sql = 'SELECT COUNT(*) from broadcasts WHERE bmclass =:standard and bmsec =:sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':standard' => $standard, ':sec' => $sec));
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

public function isThereAnyMessage($date,$standard,$sec,$fetchtype){
if($fetchtype == 1) {
if($standard == 0 && $sec == 0){
    $sql = 'SELECT COUNT(*) from complaint WHERE cdate =:date';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date));
} else {
    $sql = 'SELECT COUNT(*) from complaint WHERE cdate =:date and csclass =:standard and cssec =:sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':date' => $date, ':standard' => $standard, ':sec' => $sec));
}
} else {
if($standard == 0 && $sec == 0){
    $sql = 'SELECT COUNT(*) from complaint';
    $query = $this -> conn -> prepare($sql);
    $query -> execute();
} else {
    $sql = 'SELECT COUNT(*) from complaint WHERE csclass =:standard and cssec =:sec';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':standard' => $standard, ':sec' => $sec));
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

}

?>
