<?php
include('session.php');

if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);
        
if (isset($_GET["token"])){
            $longid1 = ($_GET["token"]);

            if ($longid1=="8ferk6sfthcv4g") {
                # delete teacher

                $deleteteacher ="UPDATE `teachers` SET `status`='1' WHERE `tid`='$shortid'";
                  
                  if(mysqli_query($db, $deleteteacher)) {  
                      //echo deleted;
                    $response= "Teacher Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?fail'; </script> <?php
                  }


            }elseif ($longid1=="6gyth457gh4esw") {
                # reactive teacher
                $activeteacher ="UPDATE `teachers` SET `status`='0' WHERE `tid`='$shortid'";
                  
                  if(mysqli_query($db, $activeteacher)) {  
                      //echo deleted;
                    $response= "Teacher Re-active Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allteacher.php?fail'; </script> <?php
                  }



            }elseif ($longid1=="5ftoi6tygh4esw") {
                # delete elibrary file
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



            }elseif ($longid1=="4r6y7utygh4esw") {
                # delete gallery image
                    $selsql = "SELECT * FROM `gallery` WHERE `id`='$shortid'";
                    $result = mysqli_query($db, $selsql);
                    $r = mysqli_fetch_assoc($result);
                    $file2=$r['file_location'].$r['imagename'];

                    if (@getimagesize($file2)) {
                        if(unlink($file2)){

                        }else{ 
                          ?> <script> alert('<?php echo "Some error occured.."; ?> '); window.location.href = 'gallery.php?fail'; </script> <?php
                          exit;
                         }
                      }


                      $deletefile ="DELETE FROM `gallery` WHERE `id`='$shortid'";
                  
                      if(mysqli_query($db, $deletefile)) {
                          //echo deleted;
                          $response= "Image Deleted Succesfully";
                          
                          ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'gallery.php?success';</script> <?php

                      } else {
                              $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                              ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'gallery.php?fail'; </script> <?php
                      }



            }elseif ($longid1=="5class6fgh4esw") {
                # delete class
                $deleteclass ="DELETE FROM `class` WHERE `class`.`class_id`='$shortid'";
                  
                  if(mysqli_query($db, $deleteclass)) {  
                      //echo deleted;
                    $response= "Class Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allclasses.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allclasses.php?fail'; </script> <?php
                  }



            }elseif ($longid1=="7subjectthcv4g") {
                # delete subject
                $deletesubject ="UPDATE `subject` SET `status`='1' WHERE `subject_id`='$shortid'";
                  
                  if(mysqli_query($db, $deletesubject)) {  
                      //echo deleted;
                    $response= "Subject Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allsubjects.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allsubjects.php?fail'; </script> <?php
                  }


            }elseif ($longid1=="7examinclude4g") {
                # delete exam include
                $deletesqlrequest ="DELETE FROM `exam_include` WHERE `exam_include`.`exam_include_id`='$shortid' ";
                  
                  if(mysqli_query($db, $deletesqlrequest)) {
                      //echo deleted;
                    $response= "Exam Include Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'examsetting.php?success';</script> <?php

                  } else { 
                    $response = "ERROR: Could not able to execute - " . mysqli_error($db);
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'examsetting.php?fail'; </script> <?php
                  }


            }elseif ($longid1=="5del1brridcv4g") {
          # delete broadcast
          $deletebroad ="UPDATE `broadcast` SET `status`= 1 WHERE `id` = '$shortid'";
            
            if(mysqli_query($db, $deletebroad)) {  
                //echo deleted;
              $response= "Broadcast Deleted Succesfully";
              
              ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'broadcasthistory.php?success';</script> <?php

            } else { 
           $response = "Failed to delete - " . mysqli_error($db);
           ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'broadcasthistory.php?fail'; </script> <?php
            }


            }elseif ($longid1=="5del1techbroad") {
            # delete teacher broadcast
            $deleteteacherbroadcast ="DELETE FROM `broadcasts` WHERE `broadcasts`.`bmid`='$shortid'";
              
              if(mysqli_query($db, $deleteteacherbroadcast)) {  
                  //echo deleted;
                $response= "Teacher Broadcast Deleted Succesfully";
                
                ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'bmsghistory.php?success';</script> <?php

              } else { 
             $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
             ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'bmsghistory.php?fail'; </script> <?php
            }


            }elseif ($longid1=="5ftgy76fgh4esw") {
                # delete student
                $deletestudent ="UPDATE `studentinfo` SET `status`='1' WHERE `sid`='$shortid'";
                  
                  if(mysqli_query($db, $deletestudent)) {  
                      //echo deleted;
                    $response= "Student Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?fail'; </script> <?php
                  }



            }elseif ($longid1=="6yugyf67gh4esw") {
                # reactive student
                $activestudent ="UPDATE `studentinfo` SET `status`='0' WHERE `sid`='$shortid'";
                  
                  if(mysqli_query($db, $activestudent)) {  
                      //echo deleted;
                    $response= "Student Re-active Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?success';</script> <?php

                  } else { 
                 $response = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'allstudent.php?fail'; </script> <?php
                  }



            }elseif ($longid1=="potgy765t7y3ww") {
                # delete Staff
                $deletestaff ="UPDATE `staff_tbl` SET `staff_status`=1 WHERE `stid`='$shortid'";
                  
                  if(mysqli_query($db, $deletestaff)) {
                      //echo deleted;
                    $response= "Staff Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'staff.php?success';</script> <?php

                  } else { 
                 $response = "ERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'staff.php?fail'; </script> <?php
                  }



            }elseif ($longid1=="4ro908tyg85hyw") {
                # delete slider image
                    $selsql = "SELECT * FROM `slider` WHERE `slider_id`='$shortid'";
                    $result = mysqli_query($db, $selsql);
                    $r = mysqli_fetch_assoc($result);
                    $file2=$r['slider_location'].$r['slider_image'];

                    if(unlink($file2)){

                      $deletefile ="DELETE FROM `slider` WHERE `slider_id`='$shortid'";
                  
                  if(mysqli_query($db, $deletefile)) {
                    //echo deleted;
                    $response= "Slider Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'academicsetting.php#update_slides';</script> <?php

                  } else { 
                 $response = "ERROR: Could not able to execute - " . mysqli_error($db);
                 ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'academicsetting.php?fail'; </script> <?php
                  }

                    }else{
                      ?> <script> alert('<?php echo "Some error occured.."; ?> '); window.location.href = 'academicsetting.php?fail'; </script> <?php
                    }



            }elseif ($longid1=="fd5576t7ygr56") {
                # delete parent

                $sql ="UPDATE `parents` SET `spstatus`= 1 WHERE `parent_id`='$shortid'";
                  
                  if(mysqli_query($db, $sql)) { 
                      //echo deleted;
                    $response= "Parent Deleted Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'parent.php';</script> <?php

                  } else { 
                    $response = "Sorry, Failed to delete - " . mysqli_error($db);
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'parent.php'; </script> <?php
                  }


            }elseif ($longid1=="2ecpoactivebi8939") {
                # active parent

                $sql ="UPDATE `parents` SET `spstatus`= 0 WHERE `parent_id`='$shortid'";
                  
                  if(mysqli_query($db, $sql)) { 
                      //echo deleted;
                    $response= "Parent Activated Succesfully";
                    
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'parent.php';</script> <?php

                  } else { 
                    $response = "Sorry, Failed to active - " . mysqli_error($db);
                    ?> <script> alert('<?php echo $response; ?> '); window.location.href = 'parent.php'; </script> <?php
                  }


            }else{
                ?> <script> alert('wrong token'); window.location.href = 'welcome.php?fail'; </script> <?php
            }




        }else{
            ?> <script> alert('sorry,request coud not procced'); window.location.href = 'welcome.php?fail'; </script> <?php
        }
        }else{
        ?> <script> alert('sorry,invalid request'); window.location.href = 'welcome.php?fail'; </script> <?php
    }
?>

