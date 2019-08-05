<?php
   include('session.php');

   $msg="";

   if($_SERVER['REQUEST_METHOD']=='POST') {


    $year_id=$_POST['year_id'];

   	$sun1=$_POST['sun1'];
   	$sun2=$_POST['sun2'];
   	$sun3=$_POST['sun3'];
   	$sun4=$_POST['sun4'];
   	$sun5=$_POST['sun5'];
   	$sun6=$_POST['sun6'];
   	$sun7=$_POST['sun7'];
   	$sun8=$_POST['sun8'];

   	$mon1=$_POST['mon1'];
   	$mon2=$_POST['mon2'];
   	$mon3=$_POST['mon3'];
   	$mon4=$_POST['mon4'];
   	$mon5=$_POST['mon5'];
   	$mon6=$_POST['mon6'];
   	$mon7=$_POST['mon7'];
   	$mon8=$_POST['mon8'];

   	$tue1=$_POST['tue1'];
   	$tue2=$_POST['tue2'];
   	$tue3=$_POST['tue3'];
   	$tue4=$_POST['tue4'];
   	$tue5=$_POST['tue5'];
   	$tue6=$_POST['tue6'];
   	$tue7=$_POST['tue7'];
   	$tue8=$_POST['tue8'];

   	$wed1=$_POST['wed1'];
   	$wed2=$_POST['wed2'];
   	$wed3=$_POST['wed3'];
   	$wed4=$_POST['wed4'];
   	$wed5=$_POST['wed5'];
   	$wed6=$_POST['wed6'];
   	$wed7=$_POST['wed7'];
   	$wed8=$_POST['wed8'];

   	$thu1=$_POST['thu1'];
   	$thu2=$_POST['thu2'];
   	$thu3=$_POST['thu3'];
   	$thu4=$_POST['thu4'];
   	$thu5=$_POST['thu5'];
   	$thu6=$_POST['thu6'];
   	$thu7=$_POST['thu7'];
   	$thu8=$_POST['thu8'];

   	$fri1=$_POST['fri1'];
   	$fri2=$_POST['fri2'];
   	$fri3=$_POST['fri3'];
   	$fri4=$_POST['fri4'];
   	$fri5=$_POST['fri5'];
   	$fri6=$_POST['fri6'];
   	$fri7=$_POST['fri7'];
   	$fri8=$_POST['fri8'];

    if (isset($_POST['create_studentroutine'])) {

      $srclass=$_POST['sclass1'];
      $srsec=$_POST['ssec1'];

   	$stdroutine = "INSERT INTO `studentroutine`( `year_id`, `srclass`, `srsec`, `sun1`, `sun2`, `sun3`, `sun4`, `sun5`, `sun6`, `sun7`, `sun8`, `mon1`, `mon2`, `mon3`, `mon4`, `mon5`, `mon6`, `mon7`, `mon8`, `tue1`, `tue2`, `tue3`, `tue4`, `tue5`, `tue6`, `tue7`, `tue8`, `wed1`, `wed2`, `wed3`, `wed4`, `wed5`, `wed6`, `wed7`, `wed8`, `thu1`, `thu2`, `thu3`, `thu4`, `thu5`, `thu6`, `thu7`, `thu8`, `fri1`, `fri2`, `fri3`, `fri4`, `fri5`, `fri6`, `fri7`, `fri8`) VALUES ('$year_id', '$srclass', '$srsec', '$sun1', '$sun2', '$sun3', '$sun4', '$sun5', '$sun6', '$sun7', '$sun8', '$mon1', '$mon2', '$mon3', '$mon4', '$mon5', '$mon6', '$mon7', '$mon8', '$tue1', '$tue2', '$tue3', '$tue4', '$tue5', '$tue6', '$tue7', '$tue8', '$wed1', '$wed2', '$wed3', '$wed4', '$wed5', '$wed6', '$wed7', '$wed8', '$thu1', '$thu2', '$thu3', '$thu4', '$thu5', '$thu6', '$thu7', '$thu8', '$fri1', '$fri2', '$fri3', '$fri4', '$fri5', '$fri6', '$fri7', '$fri8')";
                  
                  if(mysqli_query($db, $stdroutine)) {  
                      $msg= "Routine is succesfully created";
                  } else { $msg = 'Failed to create routine - '.mysqli_error($db); }

      $_SESSION['result_success']=$msg;
      echo $msg;


   	}else if (isset($_POST['update_studentroutine'])) {

      $srid=$_POST['update_studentroutine'];

    $updatequery = "UPDATE `studentroutine` SET `sun1`='$sun1', `sun2`='$sun2', `sun3`='$sun3', `sun4`='$sun4', `sun5`='$sun5', `sun6`='$sun6', `sun7`='$sun7', `sun8`='$sun8', `mon1`='$mon1', `mon2`='$mon2', `mon3`='$mon3', `mon4`='$mon4', `mon5`='$mon5', `mon6`='$mon6', `mon7`='$mon7', `mon8`='$mon8', `tue1`='$tue1', `tue2`='$tue2', `tue3`='$tue3', `tue4`='$tue4', `tue5`='$tue5', `tue6`='$tue6', `tue7`='$tue7', `tue8`='$tue8', `wed1`='$wed1', `wed2`='$wed2', `wed3`='$wed3', `wed4`='$wed4', `wed5`='$wed5', `wed6`='$wed6', `wed7`='$wed7', `wed8`='$wed8', `thu1`='$thu1', `thu2`='$thu2', `thu3`='$thu3', `thu4`='$thu4', `thu5`='$thu5', `thu6`='$thu6', `thu7`='$thu7', `thu8`='$thu8', `fri1`='$fri1', `fri2`='$fri2', `fri3`='$fri3', `fri4`='$fri4', `fri5`='$fri5', `fri6`='$fri6', `fri7`='$fri7', `fri8`='$fri8'  WHERE `srid`='$srid'";
                  
                  if(mysqli_query($db, $updatequery)) {  
                      //echo inserted
                      $msg = "Routine succesfully updated";                   

                  } else { $msg = 'Failed to create routine - '.mysqli_error($db); }

      echo $msg;

    }

    elseif (isset($_POST['create_teacherroutine'])) {


    $trtid=$_POST['teacherid'];

    $ttdroutine = "INSERT INTO `troutine`( `year_id`, `trtid`, `sun1`, `sun2`, `sun3`, `sun4`, `sun5`, `sun6`, `sun7`, `sun8`, `mon1`, `mon2`, `mon3`, `mon4`, `mon5`, `mon6`, `mon7`, `mon8`, `tue1`, `tue2`, `tue3`, `tue4`, `tue5`, `tue6`, `tue7`, `tue8`, `wed1`, `wed2`, `wed3`, `wed4`, `wed5`, `wed6`, `wed7`, `wed8`, `thu1`, `thu2`, `thu3`, `thu4`, `thu5`, `thu6`, `thu7`, `thu8`, `fri1`, `fri2`, `fri3`, `fri4`, `fri5`, `fri6`, `fri7`, `fri8`) VALUES ( '$year_id', '$trtid', '$sun1', '$sun2', '$sun3', '$sun4', '$sun5', '$sun6', '$sun7', '$sun8', '$mon1', '$mon2', '$mon3', '$mon4', '$mon5', '$mon6', '$mon7', '$mon8', '$tue1', '$tue2', '$tue3', '$tue4', '$tue5', '$tue6', '$tue7', '$tue8', '$wed1', '$wed2', '$wed3', '$wed4', '$wed5', '$wed6', '$wed7', '$wed8', '$thu1', '$thu2', '$thu3', '$thu4', '$thu5', '$thu6', '$thu7', '$thu8', '$fri1', '$fri2', '$fri3', '$fri4', '$fri5', '$fri6', '$fri7', '$fri8')";
                  
                  if(mysqli_query($db, $ttdroutine)) { $msg = "Teacher routine succesfully created";
                } else { $msg = 'Failed to create routine - '.mysqli_error($db); }

      $_SESSION['result_success']=$msg;
      echo $msg;


    }else if (isset($_POST['update_teacherroutine'])) {

      $trid=$_POST['update_teacherroutine'];

    $updatequery = "UPDATE `troutine` SET `sun1`='$sun1', `sun2`='$sun2', `sun3`='$sun3', `sun4`='$sun4', `sun5`='$sun5', `sun6`='$sun6', `sun7`='$sun7', `sun8`='$sun8', `mon1`='$mon1', `mon2`='$mon2', `mon3`='$mon3', `mon4`='$mon4', `mon5`='$mon5', `mon6`='$mon6', `mon7`='$mon7', `mon8`='$mon8', `tue1`='$tue1', `tue2`='$tue2', `tue3`='$tue3', `tue4`='$tue4', `tue5`='$tue5', `tue6`='$tue6', `tue7`='$tue7', `tue8`='$tue8', `wed1`='$wed1', `wed2`='$wed2', `wed3`='$wed3', `wed4`='$wed4', `wed5`='$wed5', `wed6`='$wed6', `wed7`='$wed7', `wed8`='$wed8', `thu1`='$thu1', `thu2`='$thu2', `thu3`='$thu3', `thu4`='$thu4', `thu5`='$thu5', `thu6`='$thu6', `thu7`='$thu7', `thu8`='$thu8', `fri1`='$fri1', `fri2`='$fri2', `fri3`='$fri3', `fri4`='$fri4', `fri5`='$fri5', `fri6`='$fri6', `fri7`='$fri7', `fri8`='$fri8'  WHERE `trid`='$trid'";
                  
                  if(mysqli_query($db, $updatequery)) {  
                      //echo inserted
                      $msg = "Routine succesfully updated";                   

                  } else { $msg = 'Failed to create routine - '.mysqli_error($db); }

      echo $msg;

    }

    else {
      
      ?> <script> alert('invalid submission'); window.location.href = 'welcome.php?fail'; </script> <?php
    }
      }else{
        
        ?> <script> alert('invalid request'); window.location.href = 'welcome.php?fail'; </script> <?php
      }

?>