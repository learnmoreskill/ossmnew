<?php
include('session.php');

if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);
        
if (isset($_GET["token"])){
            $longid1 = ($_GET["token"]);
/*========================================= delete teacher ========================================================================*/
            if ($longid1=="8ferk6sfthcv4g") {
                

                $deleteteacher ="UPDATE `teachers` SET `status`='1' WHERE `tid`='$shortid'";
                  
                  if(mysqli_query($db, $deleteteacher)) {  
                      //echo deleted;
                    $response= "Teacher Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?fail'; </script> <?php
                  }


            }
/*========================================= reactive teacher ========================================================================*/
            elseif ($longid1=="6gyth457gh4esw") {
                
                $activeteacher ="UPDATE `teachers` SET `status`='0' WHERE `tid`='$shortid'";
                  
                  if(mysqli_query($db, $activeteacher)) {  
                      //echo deleted;
                    $response= "Teacher Re-active Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?fail'; </script> <?php
                  }



            }
/*========================================= delete elibrary file ========================================================================*/
            elseif ($longid1=="5ftoi6tygh4esw") {
               
                    $selsql = "SELECT * FROM `elibrary` WHERE `id`='$shortid'";
                    $result = mysqli_query($db, $selsql);
                    $r = mysqli_fetch_assoc($result);
                    $file2=$r['file_location'].$r['filename'];

                    if(unlink($file2)){

                      $deletefile ="DELETE FROM `elibrary` WHERE `id`='$shortid'";
                  
                  if(mysqli_query($db, $deletefile)) {
                    //echo deleted;
                    $response= "File Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'elibrary.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'elibrary.php?fail'; </script> <?php
                  }

                    }else{
                      ?> <script> alert('<?php echo "Some error occured.."; ?> '); window.location.href = 'elibrary.php?fail'; </script> <?php
                    }



            }
/*========================================= delete gallery image ========================================================================*/
            elseif ($longid1=="4r6y7utygh4esw") {
              
                    $selsql = "SELECT * FROM `gallery` WHERE `id`='$shortid'";
                    $result = mysqli_query($db, $selsql);
                    $r = mysqli_fetch_assoc($result);
                    $file2=$r['file_location'].$r['imagename'];

                    if(unlink($file2)){

                      $deletefile ="DELETE FROM `gallery` WHERE `id`='$shortid'";
                  
                  if(mysqli_query($db, $deletefile)) {
                    //echo deleted;
                    $response= "Image Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'gallery.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'gallery.php?fail'; </script> <?php
                  }

                    }else{
                      ?> <script> alert('<?php echo "Some error occured.."; ?> '); window.location.href = 'gallery.php?fail'; </script> <?php
                    }


            }

/*========================================= delete class script ========================================================================*/
            elseif ($longid1=="5class6fgh4esw") {

                $deleteclass ="DELETE FROM `class` WHERE `class`.`class_id`='$shortid'";
                  
                  if(mysqli_query($db, $deleteclass)) {  
                      //echo deleted;
                    $response= "Class Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allclasses.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allclasses.php?fail'; </script> <?php
                  }



            }
/*========================================= delete subject ========================================================================*/
            elseif ($longid1=="7subjectthcv4g") {
                
                $deletesubject ="UPDATE `subject` SET `status`='1' WHERE `subject`.`subject_id`='$shortid'";
                  
                  if(mysqli_query($db, $deletesubject)) {  
                      //echo deleted;
                    $response= "Subject Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allsubjects.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allsubjects.php?fail'; </script> <?php
                  }

            }
/*========================================= delete pricibroadcast ========================================================================*/
            elseif ($longid1=="5del1brridcv4g") {
          
          $deleteadminbroad ="DELETE FROM `princibroadcast` WHERE `princibroadcast`.`brdid`='$shortid'";
            
            if(mysqli_query($db, $deleteadminbroad)) {  
                //echo deleted;
              $response= "Broadcast Deleted Succesfully";
              
              ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'mybroadcasthistory.php?success';</script> <?php

            } else { 
           $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
           ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'mybroadcasthistory.php?fail'; </script> <?php
            }


            }
/*========================================= delete teacher broadcast ========================================================================*/
            elseif ($longid1=="5del1techbroad") {
            
            $deleteteacherbroadcast ="DELETE FROM `broadcasts` WHERE `broadcasts`.`bmid`='$shortid'";
              
              if(mysqli_query($db, $deleteteacherbroadcast)) {  
                  //echo deleted;
                $response= "Teacher Broadcast Deleted Succesfully";
                
                ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'bmsghistory.php?success';</script> <?php

              } else { 
             $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
             ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'bmsghistory.php?fail'; </script> <?php
            }


            }
/*========================================= delete student ========================================================================*/
            elseif ($longid1=="5ftgy76fgh4esw") {
                
                $deletestudent ="UPDATE `studentinfo` SET `status`='1' WHERE `sid`='$shortid'";
                  
                  if(mysqli_query($db, $deletestudent)) {  
                      //echo deleted;
                    $response= "Student Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?fail'; </script> <?php
                  }

            }
/*========================================= reactive student ========================================================================*/
            elseif ($longid1=="6yugyf67gh4esw") {
                
                $activestudent ="UPDATE `studentinfo` SET `status`='0' WHERE `sid`='$shortid'";
                  
                  if(mysqli_query($db, $activestudent)) {  
                      //echo deleted;
                    $response= "Student Re-active Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?fail'; </script> <?php
                  }



            }









            else{
                ?> <script> alert('wrong token'); window.location.href = 'allteacher.php?fail'; </script> <?php
            }




        }else{
            ?> <script> alert('sorry,request coud not procced'); window.location.href = 'allteacher.php?fail'; </script> <?php
        }
        }else{
        ?> <script> alert('sorry,invalid request'); window.location.href = 'allteacher.php?fail'; </script> <?php
    }
?>

