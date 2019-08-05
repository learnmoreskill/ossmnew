<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'sathistory';

    $sqlsah1 = "SELECT * FROM attendance WHERE asid='$login_session1' ORDER BY `attendance`.`aclock` DESC";
    $resultsah1 = $db->query($sqlsah1);
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Attendance History</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m18">
                    <table>
        <thead>
          <tr>
              <th><span class="left">Date</span></th>
              <th><span class="right">Status</span></th>
          </tr>
        </thead>

        <tbody>
            <?php 
            if ($resultsah1->num_rows > 0) {
                while($row = $resultsah1->fetch_assoc()) { ?>
          <tr>
            <td><span class="left"><?php echo date('M j Y', strtotime($row['aclock'])); ?></span> </td>
            <td>
                <?php if($row["astatus"] == 'P') { ?>
                        <span style="color:blue" class="right"><?php echo '<a class="modal-trigger btn-floating btn-small waves-effect waves-light green lighten-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Present"><i class="material-icons">done</i></a>' ; ?></span>
                <?php } else if($row["astatus"] == 'A') { ?>
                        <span style="color:red" class="right"><?php echo '<a class="modal-trigger btn-floating btn-small waves-effect waves-light red lighten-2 tooltipped" data-position="left" data-delay="50" data-tooltip="Absent"><i class="material-icons">clear</i></a>' ; ?></span>
                <?php } ?>
            </td>
          </tr>
            <?php
            }
            } else {
            echo "Attendance Not Available.";
            }
            ?>
        </tbody>
      </table>
                </div>
            </div>            
        </main>


        <!-- add header.php here -->
    <?php include_once("../config/footer.php");?>