<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'mtpmsghistory';

if (isset($_GET["requestdate"])) {
    $udate = addslashes($_GET["requestdate"]);
    $sqlch1 = "SELECT * FROM complaint where `cdate` = '$udate' ORDER BY `complaint`.`cclock` DESC ";
    $resultch1 = $db->query($sqlch1);
    $rowCount1 = $resultch1->num_rows;
    if($rowCount1 > 0) { $found='1';} else{ $found='0';   }
} else {
    $sqlch1 = "SELECT * FROM complaint ORDER BY `complaint`.`cclock` DESC ";
    $resultch1 = $db->query($sqlch1);
    $rowCount2 = $resultch1->num_rows;
    if($rowCount2 > 0) { $found='1';} else{ $found='0';   }
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Msg to Parent History</a></div>
                    </div>
                </div>
            </div>
            <div class="col s12 m12">
                <div class="card grey darken-3">
                    <div class="card-content white-text">
                        <form method="post" action="returnsearchdate.php?redirectto=mtpmsghistory">
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
                                <th>Date</th>
                                <th>Class</th>
                                <th>Name</th>
                                <th>Complaint</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                while($row = $resultch1->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php echo date('d/m/Y', strtotime($row['cclock'])); ?>
                                </td>
                                <td>
                                    <?php echo $row["csclass"]." ".$row["cssec"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["csname"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["cmsg"]; ?>
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
                                <span class="card-title"><span style="color:#80ceff;">No Message(s) Found !!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            
        </main>


        <?php include_once("../config/footer.php");?>