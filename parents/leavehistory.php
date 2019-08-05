<?php
    include('session.php');
    /*set active navbar session*/
    $_SESSION['navactive'] = 'leavehistory';

    require("../important/backstage.php");
    $backstage = new back_stage_class();

    $leaveList= json_decode($backstage->get_leave_list_of_student_by_parent_id($login_session1));
    if (count((array)$leaveList)) {  $found=1; } else{ $found=0; }
    
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Leave History</a></div>
                    </div>
                </div>
            </div>
            <?php
            if ($found == 1) {
                foreach ($leaveList as $lvlist) { ?>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card">
                            <div class="card-panel grey darken-3">
                                <span class="card-title flow-text white-text" style="font-size:14px;font-family:Roboto Condensed, sans-serif;">
                               <?php echo "Posted on: ".(($login_date_type==2)? eToN(date('Y-m-d', strtotime($lvlist->lvclock))) : date('Y-m-d', strtotime($lvlist->lvclock)))." ".
                               date('g:i A', strtotime($lvlist->lvclock))." by ".$lvlist->sname; ?>
                                                            
                            </span>
                                <div class="card-content white-text flow-text">
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Leave Period" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">date_range</i>&nbsp;<?php echo (($login_date_type==2)? eToN($lvlist->lvsdate) : $lvlist->lvsdate)." to ".(($login_date_type==2)? eToN($lvlist->lvedate) : $lvlist->lvedate) ; ?></div>
                                    <blockquote class="flow-text">
                                        <span style="text-align: justify;text-transform:uppercase;font-family:Roboto Condensed, sans-serif;"><?php echo $lvlist->lvreason; ?></span>
                                    </blockquote>
                                    <span style="text-align: right;font-family:Roboto Condensed, sans-serif;"><?php if($lvlist->lvstatus=='100'){ echo 'Leave Approved'; } else if($lvlist->lvstatus=='50'){ echo 'Pending'; } else if($lvlist->lvstatus=='0'){ echo 'Leave Rejected'; } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php                                           
            }
            } else if ($found == 0) {?>
                        <div class="row">
                            <div class="col s12 m12">
                                <div class="card grey darken-3">
                                    <div class="card-content white-text center">
                                        <span class="card-title"><span style="color:#80ceff;">No Leave applied!!</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php   } ?>
        </main>


        <!-- add header.php here -->
    <?php include_once("../config/footer.php");?>