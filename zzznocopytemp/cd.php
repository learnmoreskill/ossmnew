<?php
   include('nsk/config.php');
    
$cd = date("Y-m-d");

        $sqlcd1 = "DELETE FROM `attendance` WHERE `attendance`.`aclock` = '$cd'";

     if(mysqli_query($db, $sqlcd1)) {
         ?> <script> alert('Clear : Stage 1 : Pass');  </script> <?php   
         
         $sqlcd1 = "DELETE FROM `abcheck` WHERE `abcheck`.`abdate` = '$cd'";

        if(mysqli_query($db, $sqlcd1)) {
         ?> <script> alert('Clear : Stage 2 : Pass'); window.location.href = 'clear.html?done';  </script> <?php     
        } else{ 
         echo "\n\n\nERROR: Could not able to execute - " . mysqli_error($db); 
            ?> <script> window.location.href = 'clear.html?fail2';  </script> <?php     
        }
         
     } else{
         echo "\n\n\nERROR: Could not able to execute - " . mysqli_error($db); 
         ?> <script> window.location.href = 'clear.html?fail1';  </script> <?php  
     }

?>
