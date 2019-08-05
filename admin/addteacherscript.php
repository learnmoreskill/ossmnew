<?php
   include('session.php');

   if($_SERVER['REQUEST_METHOD']=='POST') {

   if (isset($_POST['teacher_form'])) {


          $tname=$_POST['name'];
          $temail=$_POST['email'];
          $tgetter=$_POST['password1'];
          $tgetter1=$_POST['password2'];
          $taddress=$_POST['address'];
          $tmobile=$_POST['mobile'];
          $tschoolname=$LOGIN_SCHOOL_NAME;
          $tclass=$_POST['class'];
          $tsec=$_POST['section'];
          $tsex=$_POST['sex'];
          $tdob=$_POST['dob'];

          $olddate = date_create_from_format('j F, Y', $tdob);
          $dob = date_format($olddate, 'Y-m-d');

          if (!empty($tname) && !empty($taddress) && !empty($temail) && !empty($tmobile) && !empty($tsex)) {

          if (!(strlen($tgetter)<6)) {
            if ($tgetter==$tgetter1) {
              

                  $insertintoteacher = "INSERT INTO `teachers`(`tid`, `tname`, `temail`, `tgetter`, `taddress`, `tmobile`, `tschoolname`, `tclass`, `tsec`, `tcount`, `tclock`, `sex`, `dob`) VALUES (null,'$tname','$temail','$tgetter','$taddress','$tmobile','$tschoolname','$tclass','$tsec','0',CURRENT_TIMESTAMP,'$tsex','$dob')";
                  
                  if(mysqli_query($db, $insertintoteacher)) {  
                      //echo inserted
                      $abc= $tname." succesfully added";
                    
                      ?> <script> alert('<?php echo $abc; ?> '); window.location.href = 'addteacher.php?success';</script> <?php
                   

                  } else { 
                          $abc = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                          ?> <script> alert('<?php echo $abc; ?> '); window.location.href = 'addteacher.php?fail'; </script> <?php
                        }

            }else{

                 ?> <script> alert('Entered password does not match'); window.location.href = 'addteacher.php?fail'; </script> <?php
                  }        
          }else{
                ?> <script> alert('Entered password is less than 6 charater'); window.location.href = 'addteacher.php?fail'; </script> <?php
                }
        }else{
                ?> <script> alert('required filled are missing'); window.location.href = 'addteacher.php?fail'; </script> <?php
                }

  
    }
    else {
      
      ?> <script> alert('invalid submission'); window.location.href = 'addteacher.php?fail'; </script> <?php
    }

      }else{
        
        ?> <script> alert('invalid request'); window.location.href = 'addteacher.php?fail'; </script> <?php
      }

?>