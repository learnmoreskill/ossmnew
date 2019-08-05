<?php

require_once 'Functions.php';

$fun = new Functions();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

$data = json_decode(file_get_contents("php://input"));

if(isset($data -> operation)){

$operation = $data -> operation;

if(!empty($operation)){

if($operation == 'trackBusLive'){

if(isset($data -> beingtracked ) && !empty($data -> beingtracked) && isset($data -> beingtracked -> tracker_username) && isset($data -> beingtracked -> tracker_password)){

$beingtracked = $data -> beingtracked;

$tracker_username = $beingtracked -> tracker_username;
$tracker_password = $beingtracked -> tracker_password;


echo $fun -> fetchData($tracker_username,$tracker_password);

}
}
}
}

} else if ($_SERVER['REQUEST_METHOD'] == 'GET'){

echo "Hey bro";
	
}
?>
