<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'bmsghistory';

    $cd = date("Y-m-d");
if (isset($_GET["requestdate"])) {
    $udate = addslashes($_GET["requestdate"]);

    header('Content-Type: text/html; charset = utf-8');
    $db->query("SET NAMES utf8");

    $sqlbmh1 = "SELECT * FROM broadcasts where `bmdate` = '$udate' ORDER BY `broadcasts`.`bmclock` DESC ";
    $resultbmh1 = $db->query($sqlbmh1);
    $rowCount = $resultbmh1->num_rows;
        if($rowCount > 0) { $found='1';} else{ $found='0';   } 
} else {

    header('Content-Type: text/html; charset = utf-8');
    $db->query("SET NAMES utf8");
    
    $sqlbmh1 = "SELECT * FROM broadcasts ORDER BY `broadcasts`.`bmclock` DESC ";
    $resultbmh1 = $db->query($sqlbmh1);
    $rowCount = $resultbmh1->num_rows;
        if($rowCount > 0) { $found='1';} else{ $found='0';   }
}

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Teacher's Broadcast History</a></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12">
                <div class="card grey darken-3">
                    <div class="card-content white-text">
                        <form method="post" action="returnsearchdate.php?redirectto=bmsghistory">
                            <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Enter Date" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                                <i class="material-icons">today</i> &emsp; 
                                <input type="date" class="datepicker" placeholder="Select Date" name="ugdate" id="ugdate" required/> &emsp;
                                <button type="submit" class="btn waves-effect waves-light blue lighten-2">Search</button>
                            </div>   
                        </form>
                     </div>
                </div>
            </div>


            <?php
            if($found == '1'){
                            ?>
            <div class="row">
                <div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4">
                        <thead>
                            <tr>
                                <th>Teacher</th>
                                <th>For Class</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Action</th>                               
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                while($row = $resultbmh1->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php echo $row["bmtname"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["bmclass"]."-".$row["bmsec"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["bmtext"]; ?>
                                </td>
                                <td>
                                    <?php echo date('d/m/Y g:i A', strtotime($row['bmclock'])); ?>
                                </td>
                                <td>
                                <a href="deleteuserscript.php?token=5del1techbroad&key=<?php echo "ae25nJ5s3fr596dg@".$row["bmid"]; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }"> 
                                    <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                                            <i class="material-icons red-text text-darken-4">delete</i></div></a> 

                                </td>
                                
                            </tr>
                            <?php 
            }
            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
                    } else if($found == '0') { ?>
                        <div class="row">
                            <div class="col s12 ">
                                <div class="card grey darken-3">
                                    <div class="card-content center white-text">
                                        <span class="card-title"><span style="color:#80ceff;">No broadcast found !!!</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
        </main>

<?php include_once("../config/footer.php");?>
