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

public function fetchData() {

$sql = 'SELECT sno,name,lastupdated_at FROM beingtracked WHERE status = :status';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':status' => '1'));
$data = $query -> fetchAll();
//$beingtracked["sno"] = $data -> sno;
//$beingtracked["name"] = $data -> name;
//$beingtracked["lastupdate"] = $data -> lastupdated_at;
return $data;

}
}
?>
