<?php

class DBOperations{

    private $host = 'localhost';
    private $user = 'krishnagek';
    private $db = 'bustracker';
    private $pass = 'poopoo';
    private $conn;

public function __construct() {

   $this -> conn = new PDO("mysql:host=".$this -> host.";dbname=".$this -> db, $this -> user, $this -> pass);

}

 public function insertData($name,$email,$password){

   $unique_id = uniqid('', true);
    $hash = $this->getHash($password);
    $encrypted_password = $hash["encrypted"];
   $salt = $hash["salt"];

   $sql = 'INSERT INTO beingtracked SET unique_id =:unique_id,name =:name,
    email =:email,encrypted_password =:encrypted_password,salt =:salt,created_at = NOW()';

   $query = $this ->conn ->prepare($sql);
   $query->execute(array('unique_id' => $unique_id, ':name' => $name, ':email' => $email,
     ':encrypted_password' => $encrypted_password, ':salt' => $salt));

    if ($query) {

        return true;

    } else {

        return false;

    }
 }

 public function pushLocation($sno,$latitude,$longitude){


 	$sql = 'UPDATE beingtracked SET blat =:latitude,blong =:longitude,lastupdated_at = NOW() WHERE sno =:sno';

 	$query = $this ->conn ->prepare($sql);
 	$query->execute(array(':sno' => $sno, ':latitude' => $latitude,
     ':longitude' => $longitude));

    if ($query) {
        
        return true;

    } else {

        return false;

    }
 }

   public function passwordResetRequest($email){
        $random_string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 6)), 0, 6);
        $hash = $this->getHash($random_string);
        $encrypted_temp_password = $hash["encrypted"];
        $salt = $hash["salt"];
        $sql = 'SELECT COUNT(*) from tracker_password_reset_request WHERE email =:email';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array('email' => $email));
        if($query){
            $row_count = $query -> fetchColumn();
            if ($row_count == 0){
                $dateTime = new DateTime("now", new DateTimeZone('Asia/Kathmandu'));
                $add_date = $dateTime->format("Y-m-d H:i:s");
                $insert_sql = 'INSERT INTO tracker_password_reset_request SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                salt =:salt,created_at = :created_at';
                $insert_query = $this ->conn ->prepare($insert_sql);
                $insert_query->execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password,
                        ':salt' => $salt, ':created_at' => $add_date));
                if ($insert_query) {
                    $user["email"] = $email;
                    $user["temp_password"] = $random_string;
                    return $user;
                } else {
                    return false;
                }
            } else {
		$dateTime = new DateTime("now", new DateTimeZone('Asia/Kathmandu'));
                $add_date = $dateTime->format("Y-m-d H:i:s");
                $update_sql = 'UPDATE tracker_password_reset_request SET email =:email,encrypted_temp_password =:encrypted_temp_password,
                salt =:salt,created_at = :created_at';
                $update_query = $this -> conn -> prepare($update_sql);
                $update_query -> execute(array(':email' => $email, ':encrypted_temp_password' => $encrypted_temp_password,
                        ':salt' => $salt, ':created_at' => $add_date));
                if ($update_query) {
                    $user["email"] = $email;
                    $user["temp_password"] = $random_string;
                    return $user;
                } else {
                    return false;
                }
            }
        } else {
            return false;
        }
    }
    public function resetPassword($email,$code,$password){
        $sql = 'SELECT * FROM tracker_password_reset_request WHERE email = :email';
        $query = $this -> conn -> prepare($sql);
        $query -> execute(array(':email' => $email));
        $data = $query -> fetchObject();
        $salt = $data -> salt;
        $db_encrypted_temp_password = $data -> encrypted_temp_password;
        if ($this -> verifyHash($code.$salt,$db_encrypted_temp_password) ) {
            $old = new DateTime($data -> created_at,new DateTimeZone('Asia/Kathmandu'));
            $now = new DateTime(date("Y-m-d H:i:s"),new DateTimeZone('Asia/Kathmandu'));
            $diff = $now->getTimestamp() - $old->getTimestamp();
            if($diff < 120) {
                return $this -> changePassword($email, $password);
            } else {
               return false;
            }
        } else {
            return false;
        }
    }

 public function checkValidated($email) {
    $sql = 'SELECT * FROM beingtracked WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $status = $data -> status;
    if($status){
     return true;
    } else {
     return false;
    }
 }

 public function syncLocal($sno) {

    $sql = 'SELECT * FROM beingtracked WHERE sno = :sno';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':sno' => $sno));
    $data = $query -> fetchObject();

    if ($query) {


        $user["name"] = $data -> name;
        $user["email"] = $data -> email;
        $user["unique_id"] = $data -> unique_id;
	$user["latitude"] = $data -> blat;
	$user["longitude"] = $data -> blong;
        return $user;

    } else {

        return false;
    }

 }

 public function checkLogin($email, $password) {

    $sql = 'SELECT * FROM beingtracked WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email));
    $data = $query -> fetchObject();
    $salt = $data -> salt;
    $db_encrypted_password = $data -> encrypted_password;

    if ($this -> verifyHash($password.$salt,$db_encrypted_password) ) {

        $user["name"] = $data -> name;
        $user["email"] = $data -> email;
	$user["sno"] = $data -> sno;
        $user["unique_id"] = $data -> unique_id;
	$user["latitude"] = $data -> blat;
	$user["longitude"] = $data -> blong;
        return $user;

    } else {

        return false;
    }
 }

 public function changePassword($email, $password){

    $hash = $this -> getHash($password);
    $encrypted_password = $hash["encrypted"];
    $salt = $hash["salt"];

    $sql = 'UPDATE beingtracked SET encrypted_password = :encrypted_password, salt = :salt WHERE email = :email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array(':email' => $email, ':encrypted_password' => $encrypted_password, ':salt' => $salt));

    if ($query) {

        return true;

    } else {

        return false;

    }
 }

 public function checkUserExist($email){

    $sql = 'SELECT COUNT(*) from beingtracked WHERE email =:email';
    $query = $this -> conn -> prepare($sql);
    $query -> execute(array('email' => $email));

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

 public function getHash($password) {

     $salt = sha1(rand());
     $salt = substr($salt, 0, 10);
     $encrypted = password_hash($password.$salt, PASSWORD_DEFAULT);
     $hash = array("salt" => $salt, "encrypted" => $encrypted);

     return $hash;

}

public function verifyHash($password, $hash) {

    return password_verify ($password, $hash);
}
}
