<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'mtpmsghistory';

    header('Content-Type: text/html; charset = utf-8');
    $db->query("SET NAMES utf8");
    
    $sqlch1 = "SELECT `complaint`.* , `studentinfo`.`sname`, `class`.`class_name`, `section`.`section_name` 
        FROM `complaint`
        LEFT JOIN `studentinfo` ON `complaint`.`csid` = `studentinfo`.`sid`
        LEFT JOIN `class` ON `complaint`.`csclass` = `class`.`class_id`
        LEFT JOIN `section` ON `complaint`.`cssec` = `section`.`section_id`
        WHERE `crole`='$login_cat' AND `ctid`='$login_session1'  
        ORDER BY `complaint`.`cclock` DESC ";
    $resultch1 = $db->query($sqlch1);
    if ($resultch1->num_rows > 0) { $found=1; }else{ $found=0; }
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Complaint History</a></div>
                    </div>
                </div>
            </div>
            <?php if ($found==1) {
                while($row = $resultch1->fetch_assoc()) { ?>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                    <div class="card-panel grey darken-3">
                        <span class="white-text">
                            <span class="card-title" style="font-size:14px;font-family:Roboto Condensed, sans-serif;"><?php echo $row["sname"].", ".$row["class_name"]." ".$row["section_name"]; ?> , on <?php echo date('M j Y g:i A', strtotime($row['cclock'])); ?></span>
                            <a class="btn-floating halfway-fab waves-effect waves-light blue lighten-2"><i class="material-icons">done</i></a>
                            <div class="card-content">
                                <blockquote class="flow-text"><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Message" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">message</i>&nbsp;<?php echo $row["cmsg"]; ?> </div> </blockquote>
                                </div>
                        </span>
                    </div>
                </div>
            </div>
                </div>
            <?php
            }
            } else { ?>
            <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">No previous complaint found</span></span>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>