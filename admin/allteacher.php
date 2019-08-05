<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'allteacher';

    $sqlallteacher = "SELECT * FROM teachers WHERE `status` = 0 ORDER BY `teachers`.`tid` ";
    $resultallteacher1 = $db->query($sqlallteacher);

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <style type="text/css">
        #teacherinfotable_length select{
            display: inherit;
        }
        #teacherinfotable_filter{
            width: 50%;
        }

        #teacherinfotable_wrapper
        {
            margin-top: 20px;
        }

        #teacherinfotable_wrapper label{
            width: 100%;
            font-size: 20px;
            color:#000;
        }

    </style>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">All teacher's info</a></div>
                    </div>
                </div>
            </div>
            <div class="row scrollable" style="overflow: auto;">
                <div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4" id="teacherinfotable">
                        <thead>
                            <tr>
                                <th>Teacher name</th>
                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
            if ($resultallteacher1->num_rows > 0) {
                while($row = $resultallteacher1->fetch_assoc()) { ?>
                            <tr <?php if ($row["status"]==1) {?> style="background-color: pink" <?php } else {} ?>>
                                <td>
                                    <?php echo $row["tname"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["sex"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["tmobile"]; ?>
                                </td>
                                <td>
                                    <?php if ($row["status"]==0) { echo "Active";}elseif ($row["status"]==1) { echo "Deleted"; }else { echo "";} ?>
                                </td>
                                <td>
                                    <a href="teacherdetailsdescription.php?token=2ec9ys77bi89s9&key=<?php echo "ae25nj5s3fr596dg@".$row["tid"]; ?>"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="information" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"> <i class="material-icons">info_outline</i></div></a>

                                    <?php if ($login_cat == 1 || $pac['edit_teacher']) { ?>

                                    <a href="addteacher.php?token=2ec9yS77bte9s9&key=<?php echo "ae25nJs3fr596dge@".$row["tid"]; ?>"> <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>

                                    <?php if ($row["status"]==0) { ?>
                                    <a href="deleteuserscript.php?token=8ferk6sfthcv4g&key=<?php echo "ae25nJ5s3fr596dg@".$row["tid"]; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"> <i class="material-icons red-text text-darken-4">delete</i></div></a>

                                    <?php }elseif ($row["status"]==1) { ?>
                                    <a href="deleteuserscript.php?token=6gyth457gh4esw&key=<?php echo "ae25nJ5s3fr596dg@".$row["tid"]; ?>" onclick = "if (! confirm('Are you sure want to re-active?')) { return false; }"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="re-active" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"> <i class="material-icons teal-text text-darken-4">autorenew</i></div></a>
                                    <?php } else { echo "";} ?>
                                    
                                    <?php } ?>
                                    
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
        </main>


<?php include_once("../config/footer.php");?>

<script type="text/javascript">
    $(document).ready(function() {
    $('#teacherinfotable').DataTable();
} );
</script>
<script src="../css/new_js/datatables.min.js"></script>
        <script src="../css/new_js/dataTables.buttons.js"></script>
        <script src="../css/new_js/dataTables.buttons.min.js">
</script>
<?php if (isset($_REQUEST['resp'])){ 
 if (isset($_SESSION['result_success'])) 
  {
      $result1=$_SESSION['result_success'];
      echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
    unset($_SESSION['result_success']);
    }  
  } 
?>