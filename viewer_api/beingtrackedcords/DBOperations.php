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

public function getCords($sno) {



$sql = 'SELECT blat,blong FROM beingtracked WHERE sno = :sno';
$query = $this -> conn -> prepare($sql);
$query -> execute(array(':sno' => $sno));
$data = $query -> fetchObject();
if($query){


	

$beingtracked["latitude"] = $data -> blat;
$beingtracked["longitude"] = $data -> blong;
return $beingtracked;
} else {

return false;
}
}
}
?>
