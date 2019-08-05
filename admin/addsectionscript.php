<?php
   include('session.php');
   $newdate = date("Y-m-d");

   if($_SERVER['REQUEST_METHOD']=='POST') {

   if (isset($_POST['add_section'])) {

    $classname=$_POST['classname'];

    $test=$_POST['test'];
    if ($test){
              foreach ($test as $t){
                $section_name=$t;


               $sqlcheck="SELECT `section_id` FROM `section` WHERE `section_name`='$section_name' AND `section_class`='$classname'";
               $resultcheck=mysqli_query($db, $sqlcheck);
               $count=mysqli_num_rows($resultcheck);
               if($count<1){


                 $sqlfnp1 = "INSERT INTO `section` (`section_id`, `section_name`, `section_class`) VALUES (NULL, '$section_name', '$classname')";
                  
                  if(mysqli_query($db, $sqlfnp1)) {  
                      //echo "inserted";
                      
                  } else { 
                 $succ = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
                  }

               }
               



              }
              ?> <script> alert('Command Executed'); window.location.href = 'allclasses.php?fail'; </script> <?php
            }else{

            ?> <script> alert('section is not selected'); window.location.href = 'addsection.php?fail'; </script> <?php    
          }

        }else {
      
      ?> <script> alert('invalid submission'); window.location.href = 'addsection.php?fail'; </script> <?php
    }

      }else{
        
        ?> <script> alert('invalid request'); window.location.href = 'addsection.php?fail'; </script> <?php
      }

?>