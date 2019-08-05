<?php

require_once 'Functions.php';

$fun = new Functions();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

$data = json_decode(file_get_contents("php://input"));

if(isset($data -> operation)){

$operation = $data -> operation;

if(!empty($operation)){

if($operation == 'getCords'){

if(isset($data -> beingtracked ) && !empty($data -> beingtracked) && isset($data -> beingtracked -> sno)){

$beingtracked = $data -> beingtracked;
$sno = $beingtracked -> sno;

echo $fun -> getCords($sno);


}
}
}
}

} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){

echo "Hey bro";

}

?>
