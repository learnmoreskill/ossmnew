<?php
//for nsk and admin
include('session.php');

if (isset($_GET["setid"]) && is_numeric($_GET["setstatus"])){
$lid = addslashes($_GET["setid"]);
$returnid = addslashes($_GET["cardid"]);
$lstatus = addslashes($_GET["setstatus"]);

    
    $sql="UPDATE `leavetable` SET `lvstatus` = '$lstatus', `lvrole` = '$login_cat', `lvtid` = '$login_session1' WHERE `lvid` = '$lid'";
    		if(mysqli_query($db, $sql)){
            ?>
                <script>
                    alert('Successfully Updated');
                    window.location.href = 'grantleave.php#<?php echo $returnid ; ?>';
                </script>
            <?php 
            } else{
                $success = "Sorry,Unable to update your request" . mysqli_error($db);
                            ?>
                <script>
                    alert('Sorry,Unable to update your request');
                    window.location.href = 'grantleave.php#<?php echo $returnid ; ?>';
                </script>
            <?php 
            }
}

?>