<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'feereport';

$sqlfd1 = "SELECT * FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`sschoolcode`='$login_session7' AND `studentinfo`.`sclass`='$login_session9' AND `studentinfo`.`ssec`='$login_session10' AND `studentinfo`.`status`=0";
    $resultfd1 = $db->query($sqlfd1);
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Report Fee Due  </a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Send Fee Dues Messages <!-- For Class:<?php echo $login_session9."-".$login_session10; ?> --></span></span>
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    Select one or multiple students who have fee dues. <br/>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="input-field col s12">
                        <form method="post" action="feereportscript.php?e5s8cvd5sd5=<?php echo $subject; ?>&q7v7s1xv5=<?php echo $clockon;?>&q7v7mdmd5=<?php echo $mydatemy;?>">
                        <select multiple name="test[]" id="rolls" required>
                            <option value="" disabled>Select Students</option>
            <?php if ($resultfd1->num_rows > 0) {
                while($row = $resultfd1->fetch_assoc()) { ?>
                        <option value="<?php echo $row["spnumber"].$row["sid"];?>">Roll no:<?php echo $row["sroll"]."&nbsp &nbsp &nbsp Name:".$row["sname"]."&nbsp &nbsp &nbsp Parent:".$row["spname"];?></option>
            <?php 
            }
            } 
            ?>
                        </select>
                            <label>Select Roll Numbers</label>
                            <button class="btn waves-effect waves-light blue lighten-2" type="submit" name="action" onClick="function showWaitBox(){ alert('Press OK and WAIT for automatic reload'); } showWaitBox();">Submit</button>
                            </form>
                    </div>
                </div>
            </div>

        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>