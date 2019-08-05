<?php
   include('session.php');
date_default_timezone_set('Asia/Kathmandu');    
$cd = date("Y-m-d");

        $sqlcd1 = "DELETE FROM `attendance` WHERE `attendance`.`aclock` = '$cd' AND `attendance`.`aclass` = '$login_session9' AND `attendance`.`asec` = '$login_session10' ";

     if(mysqli_query($db, $sqlcd1)) {
         ?> <script> alert('Clear : Stage 1 : Pass');  </script> <?php   
         
         $sqlcd1 = "DELETE FROM `abcheck` WHERE `abcheck`.`abdate` = '$cd' AND `abcheck`.`abclass` = '$login_session9' AND `abcheck`.`absec` = '$login_session10'";

        if(mysqli_query($db, $sqlcd1)) {
         ?> <script> alert('Clear : Stage 2 : Pass'); window.location.href = 'attendance.php?done';  </script> <?php     
        } else{ 
         echo "\n\n\nERROR: Could not able to execute - " . mysqli_error($db); 
            ?> <script> window.location.href = 'attendance.php?fail2';  </script> <?php     
        }
         
     } else{
         echo "\n\n\nERROR: Could not able to execute - " . mysqli_error($db); 
         ?> <script> window.location.href = 'attendance.php?fail1';  </script> <?php  
     }

?>
