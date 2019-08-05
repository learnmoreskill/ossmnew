<?php
   include('session.php');

      if($_SERVER["REQUEST_METHOD"] == "POST") {


        $newpassword = $_POST['newpassword'];
        $confirmnewpassword = $_POST['confirmnewpassword'];

        if (!(strlen($newpassword)<6)) {

        if ($newpassword==$confirmnewpassword) {

            if ($login_cat == 1) {

              $updatepassword = "UPDATE principal SET ppassword='$newpassword' WHERE pid='$login_session1'";

            }else if($login_cat == 5){

              $updatepassword = "UPDATE staff_tbl SET staff_getter='$newpassword' WHERE stid='$login_session1'";

            }
                  
                  if(mysqli_query($db, $updatepassword)) {  
                      //echo updated;
                    $response= "Password changed Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'logout.php';</script> <?php
                    

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'changepassword.php?fail'; </script> <?php
                  }

       
        }else{

          ?> <script> alert('Entered password does not match'); window.location.href = 'changepassword.php?fail'; </script> <?php
        }        
        }else{
        ?> <script> alert('Entered password is less than 6 charater'); window.location.href = 'changepassword.php?fail'; </script> <?php
      }
          
      }else{
        ?> <script> alert("invalid request"); window.location.href = 'changepassword.php?fail';  </script> <?php
      }

?>