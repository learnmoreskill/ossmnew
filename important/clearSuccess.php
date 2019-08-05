<?php
session_start();
$temp=$_POST['request'];
unset($_SESSION[$temp]);
echo "data cleared";
?>