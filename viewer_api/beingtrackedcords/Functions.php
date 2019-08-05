<?php

require_once 'DBOperations.php';

class Functions{

private $db;

public function __construct() {

      $this -> db = new DBOperations();

}

public function getCords($sno) {

$db = $this -> db;
$result =  $db -> getCords($sno);
if($result){
$response["result"] = "success";
$response["beingtracked"] = $result;
return json_encode($response);
} else {
$response["result"] = "failure";
return json_encode($response);
}
}

}

?>
