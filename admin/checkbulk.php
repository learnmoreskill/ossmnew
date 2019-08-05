<?php
include('../config/sendbulksms.php');

$token="";
$bulknumber="";
$bulkmessage="";

$bulkresult= sendbulk($token,$bulknumber,$bulkmessage);
echo $bulkresult;



 

?>