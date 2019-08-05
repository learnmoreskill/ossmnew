<?php
include('ssession.php');
if($_SERVER["REQUEST_METHOD"] == "POST") {

    $upsdate = mysqli_real_escape_string($db,$_POST['sdate']);
    $oldsdate = date_create_from_format('j F, Y', $upsdate);
    $newsdate = date_format($oldsdate, 'Y-m-d');
                                  
    $upedate = mysqli_real_escape_string($db,$_POST['sdate']);
    $oldedate = date_create_from_format('j F, Y', $upedate);
    $newedate = date_format($oldedate, 'Y-m-d');
                                          
    $lvreason = mysqli_real_escape_string($db,$_POST['lvreason']);
    
    $sqlsls1 = "INSERT INTO `leavetable` (`lvid`, `lvschoolcode`, `lvclass`, `lvsec`, `lvsid`, `lvsroll`, `lvsname`, `lvpname`, `lvpnumber`, `lvsdate`, `lvedate`, `lvreason`, `lvstatus`, `lvclock`) VALUES (NULL, '$login_session10', '$login_session12', '$login_session13', '$login_session1', '$login_session2', '$login_session3', '$login_session7', '$login_session8', '$newsdate', '$newedate', '$lvreason', '50', CURRENT_TIMESTAMP)";
    
     if(mysqli_query($db, $sqlsls1)) {
         ?> <script> alert('Message Sent'); window.location.href = 'saplvhistory.php?success'; </script> <?php     
     } else{ 
         $sucmsg = "\n\n\nERROR: Could not able to execute - " . mysqli_error($db);
         ?> <script> alert('<?php echo $sucmsg; ?> '); window.location.href = 'saplvhistory.php?fail'; </script> <?php
     }
}
?>