<?php
include ('conf.php');

if (isset($_GET["lat"]) && isset($_GET["long"])) {
    
    $latitude = addslashes($_GET["lat"]);
    $longitude = addslashes($_GET["long"]);
    $date =rtrim(shell_exec('date +%d-%m-%Y'));
    $time =rtrim(shell_exec('date +%H:%M:%S'));
    
    $sqlup = "UPDATE `tracker` set `blat`='$latitude', `blong`='$longitude', `bdate`='$date', `btime`='$time' where `bid`='1'";
    
    if(mysqli_query($db, $sqlup)){
	$data = [ 'result' => 1 ];
}   else {
        $data = [ 'result' => 0 ];

}

header('Content-type: application/json');
echo json_encode( $data );
    
}
