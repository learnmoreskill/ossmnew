<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'bmsghistory';

    $cd = date("Y-m-d");
    
    header('Content-Type: text/html; charset = utf-8');
    $db->query("SET NAMES utf8");

    $sqlbmh1 = "SELECT * FROM broadcasts WHERE bmtid='$login_session1'  ORDER BY `broadcasts`.`bmclock` DESC ";
    $resultbmh1 = $db->query($sqlbmh1);
    if ($resultbmh1->num_rows > 0) { $found=1; }else{ $found=0; }
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Broadcast History</a></div>
                    </div>
                </div>
            </div>
            <?php if ($found==1) {
                while($row = $resultbmh1->fetch_assoc()) { ?>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                    <div class="card-panel grey darken-3">
                        <span class="white-text">
                            <span class="card-title" style="font-size:14px;font-family:Roboto Condensed, sans-serif;"> For <?php echo $row["bmclass"]." ".$row["bmsec"]; ?> , on <?php echo date('M j Y g:i A', strtotime($row['bmclock'])); ?></span>
                            
                            <div class="card-content">
                                <blockquote class="flow-text"><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Message" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">message</i>&nbsp;<?php echo $row["bmtext"]; ?> </div> </blockquote>
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
                                <span class="card-title"><span style="color:#80ceff;">No broadcast history found</span></span>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </main>


       <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>