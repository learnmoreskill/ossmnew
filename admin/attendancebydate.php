<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'attendancebydate';

    
if (isset($_GET["requestdate"])) {
    $udate = addslashes($_GET["requestdate"]);
    if($login_date_type==2){
        $udate = nToE($udate);
    }
} else {
    $udate = $login_today_edate;
}

    $sqlasr1 = "SELECT * FROM `abcheck` LEFT JOIN `class` ON `abcheck`.`abclass` = `class`.`class_id` LEFT JOIN `section` ON `abcheck`.`absec` = `section`.`section_id` WHERE `abdate` = '$udate' ORDER BY `abcheck`.`abclass` DESC ";
    $resultasr1 = $db->query($sqlasr1); 
?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Attendance Report</a></div>
                    </div>
                </div>
            </div>
            <br/>
            <div class="col s12 m12">
                <div class="card grey darken-3">
                    <div class="card-content white-text">
                        <form method="post" action="returnsearchdate.php?redirectto=attendancebydate">
                            <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Enter Date" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                                <i class="material-icons">today</i> &emsp; 
                                <input type="text" 
                                class="<?php if($login_date_type==1){
                                      echo 'datepicker1';
                                    }else if($login_date_type==2){
                                      echo 'bod-picker';
                                    }else{
                                      echo 'datepicker1';
                                    } ?>" 
                                placeholder="Select Date" name="ugdate" id="ugdate" required/> &emsp;
                                <button type="submit" class="btn waves-effect waves-light blue lighten-2">Search</button>
                            </div>   
                        </form>
                     </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4">
                        <thead>
                            <tr>
                            <th><?php echo (($login_date_type==2)? eToN($udate) : $udate);?></th>
                            </tr>
                            <tr>
                                <th>Class</th>
                                <th>Sec</th>
                                <th>Present</th>
                                <th>Absent</th>
                                <th>Info.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if ($resultasr1->num_rows > 0) {
                                while($row = $resultasr1->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php echo $row["class_name"];?>
                                </td>
                                <td>
                                    <?php echo $row["section_name"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["abpcount"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["abacount"]; ?>
                                </td>
                                <td><a href="alistview.php?extraudp&extraclass=<?php echo $row["abclass"];?>&extrasec=<?php echo $row["absec"];?>&extradate=<?php echo (($login_date_type==2)? eToN($udate) : $udate);  ?>"><span class="red-text text-lighten-2" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">info_outline</i>&nbsp;</span></a>
                                </td>
                            </tr>
                            <?php 
            }
            } else {
            
            }
            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
        </main>


        <?php include_once("../config/footer.php");?>