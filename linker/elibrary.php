<?php
// for all
   include('session.php');
   require("../important/backstage.php");
    $backstage = new back_stage_class();
   /*set active navbar session*/
$_SESSION['navactive'] = 'elibrary';


    $elibrary_details= json_decode($backstage->get_elibrary_details());
    if (count((array)$elibrary_details)) {
        $found='1';} else{ $found='0';   }
        
?>
<!-- add adminheader and navbar here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>
    <main>
        <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
            <div class="github-commit">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">E-Library</a></div>
                </div>
            </div>
        </div>

        <?php   if($found == '1'){  ?>

        <div class="row scrollable">
            <div class="col s12 m12">
                <table class="centered bordered striped highlight z-depth-4">
                    <thead>
                        <tr>
                            <th>File Type</th>
                            <th>Name</th>
                            <th>Uploaded by</th>
                            <th>Date</th>
                            <th>Size</th>
                            <th>View/Download</th>
                            <?php if ($login_cat === 1 || $login_cat === 2 || $pac['edit_elibrary']) { ?>
                            <th>Action</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                    <?php   foreach ($elibrary_details as $elibrary) { ?>
                            <tr>
                                <td>
                                    <?php echo $elibrary->type; ?>
                                </td>
                                <td>
                                    <?php echo $elibrary->filename; ?>
                                </td>
                                <td>
                                    <?php echo (($elibrary->role==1) ? $elibrary->pname:'' ).(($elibrary->role==2) ? $elibrary->tname:'' ); ?>
                                </td>
                                <td>
                                    <?php echo (($login_date_type==2)? eToN(date('Y-m-d', strtotime($elibrary->date))) : date('Y-m-d', strtotime($elibrary->date)))." ".date('g:i A', strtotime($elibrary->date)); ?>
                                </td>
                                <td>
                                    <?php $size1=$elibrary->size/1024; echo round($size1,2)." KiB"; ?>
                                </td>
                                <td>
                                    <a href="<?php echo $elibrary->file_location.$elibrary->filename; ?>" target="_blank">view file</a>
                                </td>
                                <?php if ($login_cat === 1 || $login_cat === 2 || $pac['edit_elibrary']) { ?>
                                <td>
                                    <a href="deleteuserscript.php?token=5ftoi6tygh4esw&key=<?php echo "ae25nJ5s3fr596dg@".$elibrary->id; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"> <i class="material-icons red-text text-darken-4">delete</i></div></a>

                                </td>
                                <?php } ?>
                            </tr>
                            <?php }  ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php
        } else if($found == '0') { ?>
        <div class="row">
            <div class="col s12">
                <div class="card grey darken-3">
                    <div class="card-content white-text">
                        <span class="card-title center"><span style="color:#80ceff;">No Books Or Notes Found</span></span>
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
    </main>


<?php include_once("../config/footer.php");?>