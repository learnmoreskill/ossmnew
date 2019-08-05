<?php 
/* ADD NEW QUERY TO INSERT DATA IN TABLE */

$queryForTableInsertion = "UPDATE `schooldetails` SET `school_name`='$schoolName',`school_code`='$schoolCode',`school_address`='$schoolAddress' WHERE `school_id` = 1;

UPDATE `principal` SET `ppassword`='$principalPassword',`pemail`='$principalEmail'WHERE `pid` = 1";
?>