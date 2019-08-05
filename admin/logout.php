<?php
   session_start();
   
   if(session_destroy()) {
   	?> <script> 
     sessionStorage.removeItem("modalShown");

   	 window.location.href = '../index.php?success'; </script> <?php
      //header("Location: ../index.php");
  }

?>
