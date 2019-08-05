<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 

  echo $account->add_activity_log(1, 1, 'likes', 'santosh pict', 'account', $_SERVER['REQUEST_URI']);
echo "hello";