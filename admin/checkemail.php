<?php
include('../config/sendmailtemp.php');

$email1="krishnagek@gmail.com";
$messages1="multiple email service is passed";

$emailresult= sendemail($email1,$messages1);
echo $emailresult;

?>
