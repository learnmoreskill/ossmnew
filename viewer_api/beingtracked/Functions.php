<?php

require_once 'DBOperations.php';

class Functions{

private $db;

public function __construct() {

      $this -> db = new DBOperations();

}

public function fetchData() {

$db = $this -> db;
$result =  $db -> fetchData();
$response["beingtracked"] = $result;
return json_encode($response);

}

}

?>
