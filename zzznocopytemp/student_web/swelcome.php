<?php

include('ssession.php');

$sqlsr1 = "select * from studentroutine where srclass='$login_session12' and srsec='$login_session13'";
    $resultsr1 = $db->query($sqlsr1);
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("../smart/navbarstudent.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">School Management</a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Welcome</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-panel grey darken-3">
                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Dashboard</span>
                                <div class="card-content white-text flow-text">
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $login_session3; ?>
                                </div>
                                <br>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Roll no." style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">list</i>&nbsp;<?php echo $login_session2; ?></div><br>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email ID" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $login_session5; ?>
                                        </div><br>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="School" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">school</i>&nbsp;<?php echo $login_session11; ?>
                                            </div>
                                            <br>
                                                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Class" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assessment</i>&nbsp;<?php echo $login_session12." - ".$login_session13; ?>
                                            </div>
                                            <br>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s12 m12">
                                <?php if ($resultsr1->num_rows > 0) { 
                    // output data of each row
                    while($row = $resultsr1->fetch_assoc()) { ?>
                                    <table class="responsive-table centered striped bordered highlight z-depth-4">
                                        <thead>
                                        <tr>
                                            <th>.</th>
                                            <th>1st Period</th>
                                            <th>2nd Period</th>
                                            <th>3rd Period</th>
                                            <th>4th Period</th>
                                            <th>5th Period</th>
                                            <th>6th Period</th>
                                            <th>7th Period</th>
                                            <th>8th Period</th>
                                        </tr></thead>
                                  <tbody>    <tr>
                                            <th>Monday</th>
                                            <td>
                                                <?php echo $row["mon1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tuesday</th>
                                            <td>
                                                <?php echo $row["tue1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Wednesday</th>
                                            <td>
                                                <?php echo $row["wed1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Thursday</th>
                                            <td>
                                                <?php echo $row["thu1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Friday</th>
                                            <td>
                                                <?php echo $row["fri1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Saturday</th>
                                            <td>
                                                <?php echo $row["sat1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sat2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sat3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sat4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sat5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sat6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sat7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sat8"]; ?>
                                            </td>
                                        </tr>
                                 </tbody>     </table>
                                    <?php }
}
        ?>
                            </div>
                        </div>
        </main>


         <!-- add header.php here -->
    <?php include_once("../config/footer.php");?>