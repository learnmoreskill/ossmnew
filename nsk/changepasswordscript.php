<?php
   include('session.php');

      if($_SERVER["REQUEST_METHOD"] == "POST") {


        $newpassword = $_POST['newpassword'];
        $confirmnewpassword = $_POST['confirmnewpassword'];

        if (!(strlen($newpassword)<6)) {

        if ($newpassword==$confirmnewpassword) {



            $updatepassword = "UPDATE teachers SET tgetter='$newpassword' where temail='$login_session3'";
                  
                  if(mysqli_query($db, $updatepassword)) {  
                      //echo updated;
                    $response= "Password changed Succesfully";
                    if(session_destroy()) {
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = '../index.php#teacher?success';</script> <?php
                    }else{
                      ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'changepassword.php?success'; </script> <?php
                    }

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