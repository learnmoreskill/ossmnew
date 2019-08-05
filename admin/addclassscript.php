<?php
   include('session.php');

   if($_SERVER['REQUEST_METHOD']=='POST') {

   if (isset($_POST['add_class'])) {
      $classname = mysqli_real_escape_string($db,$_POST['classname']);


          if (!empty($classname)) {


            $sqlcheck="SELECT * FROM `class` WHERE `class_name`='$classname'";
               $resultcheck=mysqli_query($db, $sqlcheck);
               $count=mysqli_num_rows($resultcheck);
               if($count<1){


                  $insertintoclass = "INSERT INTO `class`(`class_id`, `class_name`) VALUES (null,'$classname')";
                  
                  if(mysqli_query($db, $insertintoclass)) {  
                      //echo inserted
                      $abc= $classname." is succesfully added";
                    
                      ?> <script> window.location.href = 'addclass.php?status=class:<?php echo $abc; ?>';</script> <?php
                   

                  } else { 
                          $abc = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                          ?> <script> alert('<?php echo $abc; ?> '); window.location.href = 'addclass.php?fail'; </script> <?php
                        }
                }else{
                  ?> <script> alert('class is already exist!!'); window.location.href = 'addclass.php?fail'; </script> <?php
                }


          	}else{
                ?> <script> alert('required filled are missing'); window.location.href = 'addclass.php?fail'; </script> <?php
                }

  
    }
    else {
      
      ?> <script> alert('invalid submission'); window.location.href = 'addclass.php?fail'; </script> <?php
    }

      }else{
        
        ?> <script> alert('invalid request'); window.location.href = 'addclass.php?fail'; </script> <?php
      }

?>