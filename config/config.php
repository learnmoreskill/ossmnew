<?php
   /*define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'krishnagek');
   define('DB_PASSWORD', 'poopoo');
   define('DB_DATABASE', 'ossmdb');
   $db1 = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
   */

Global $schoolFolderName;

$fullurl = $_SERVER['HTTP_HOST'];

$fullurl = strtolower($fullurl);

if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $fullurl, $matches))
       {
           $domain1 = $matches['domain'];
       } else {
           $domain1 = $domain;
       }

$subdomainname = rtrim(strstr($fullurl, $domain1, true), '.');


/*
$subdomainname = extract_subdomains($fullurl);

   function extract_domain($domain)
   {
       if(preg_match("/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i", $domain, $matches))
       {
           return $matches['domain'];
       } else {
           return $domain;
       }
   }

   function extract_subdomains($domain)
   {
       $subdomains = $domain;
       $domain = extract_domain($subdomains);

       $subdomains = rtrim(strstr($subdomains, $domain, true), '.');

       return $subdomains;
   }
   */

   $fianlsubdomain = str_replace("manager", "", $subdomainname);
   if(!empty($fianlsubdomain)){
     $schoolFolderName = $fianlsubdomain;
     $finaldbname = $fianlsubdomain."db";
     
   }else{
     $redirect = 'https://a1pathshala.com';
     //header('HTTP/1.1 301 Moved Permanently');
     header('Location: ' . $redirect);
     exit();
   }



   $db_server = 'localhost';
   $db_username = 'hackster';
   $db_password = 'krishna$12345';
   //$db_database = 'newossmdb';
   $db_database = $finaldbname;

   // Create connection
   $db = mysqli_connect($db_server,$db_username,$db_password,$db_database);
?>

