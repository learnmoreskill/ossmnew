<?php
   include('ssession.php');
    $sqlslh1 = "SELECT * FROM leavetable WHERE lvsid='$login_session1' ORDER BY `leavetable`.`lvclock` DESC";
    $resultslh1 = $db->query($sqlslh1);
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("../smart/navbarstudent.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    <div class="row center"><a class="red-text text-lighten-4" href="#">School Management</a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="red-text text-lighten-4" href="#">Leave History</a></div>
                    </div>
                </div>
            </div>
            <?php 
            if ($resultslh1->num_rows > 0) {
                $count=0;
                while($row = $resultslh1->fetch_assoc()) { ?>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card">
                            <div class="card-panel grey darken-3">
                                <span class="card-title flow-text white-text" style="font-size:14px;font-family:Roboto Condensed, sans-serif;">
                               <?php echo "Posted on: ".date('M j Y g:i A', strtotime($row['lvclock'])); ?>
                                                            <?php if($row["lvstatus"]=='50') { echo '<a class="modal-trigger btn-floating halfway-fab waves-effect waves-light blue lighten-2 right" href="#modal'.$count.'"><i class="material-icons">more_horiz</i></a>'; } else if($row["lvstatus"]=='100'){ echo '<a class="modal-trigger btn-floating halfway-fab waves-effect waves-light green lighten-2 right" href="#modal'.$count.'"><i class="material-icons">done</i></a>'; } else if($row["lvstatus"]=='0'){ echo '<a class="modal-trigger btn-floating halfway-fab waves-effect waves-light red lighten-2 right" href="#modal'.$count.'"><i class="material-icons">clear</i></a>'; }?>
                            </span>
                                <div class="card-content white-text flow-text">
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Leave Period" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">date_range</i>&nbsp;<?php echo date('M j Y', strtotime($row["lvsdate"]))." to ".date('M j Y', strtotime($row["lvedate"])) ; ?></div>
                                    <blockquote class="flow-text">
                                        <span style="text-align: justify;text-transform:uppercase;font-family:Roboto Condensed, sans-serif;"><?php echo $row["lvreason"]; ?></span>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Structure -->
                <div id="modal<?php echo $count; ?>" class="modal">
                    <div class="modal-content modal-fixed-footer">
                        <h4><?php if($row["lvstatus"]=='100'){ echo 'Leave Approved'; } else if($row["lvstatus"]=='50'){ echo 'Pending...'; } else if($row["lvstatus"]=='0'){ echo 'Leave Rejected'; } ?></h4>
                        <p class="flow-text">
                            <?php if($row["lvstatus"]=='100'){ echo 'Congratulations ! Your leave request has been approved. Please make sure to attend the classes after your leave period ends.'; } else if($row["lvstatus"]=='50'){ echo 'Please wait until teacher reviews your leave request.'; } else if($row["lvstatus"]=='0'){ echo 'Sorry ! Unfortunately your leave request has been rejected.'; } ?>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <a class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
                    </div>
                </div>
                <?php
             $count=$count+1;                                             
            }
            } else {
            echo "No leave applied";
            }
            ?>
        </main>


        <!-- add header.php here -->
    <?php include_once("../config/footer.php");?>