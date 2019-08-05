<?php
include ('conf.php');

if (isset($_GET["bid"])) {

	$id = addslashes($_GET["bid"]);
	    $sqlget = "select * from tracker where `bid`=$id";

   if( $res=(mysqli_query($db, $sqlget))){
     $row = mysqli_fetch_array($res,MYSQLI_ASSOC);
$latitude=$row['blat'];
$longitude=$row['blong'];
} else {
$latitude='0.0';
$longitude='0.0';
}
        $data = [ 'latitude' => $latitude,'longitude' => $longitude  ];

header('Content-type: application/json');
echo json_encode( $data );
    
}
