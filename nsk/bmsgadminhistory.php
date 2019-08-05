<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'bmsgadminhistory';

    $cd = date("Y-m-d");

    header('Content-Type: text/html; charset = utf-8');
    $db->query("SET NAMES utf8");
    
    $sqlbmh1 = "SELECT * FROM princibroadcast ORDER BY `princibroadcast`.`pushed_at` DESC ";
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Admin's Broadcast History</a></div>
                    </div>
                </div>
            </div>
            <?php if ($found==1) { ?>
            <div class="row">
                <div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Admin Name</th>
                                <th>Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            while($row = $resultbmh1->fetch_assoc()) { ?>
                            <tr>
                                <td>
                                    <?php echo date('d/m/Y g:i A', strtotime($row['pushed_at'])); ?>
                                   <!--  <?php $date = date_create($row['pushed_at']);
                                     echo date_format($date, 'd/m/Y g:i A'); ?>-->
                                </td> 
                                <td>
                                    <?php echo $row["brdpname"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["brdtext"]; ?>
                                </td>
                            </tr>
                            <?php  } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
            } else { ?>
            <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">No admin's broadcast history found</span></span>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } ?>
        </main>


        <?php include_once("../config/footer.php");?>