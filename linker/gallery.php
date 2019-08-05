<?php
// for all
    require('session.php');
    require("../important/backstage.php");
    $backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'gallery';

    $gallery_details= json_decode($backstage->get_gallery_details());
    if (count((array)$gallery_details)) {
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
                    <div class="row center">
                        <!-- <a class="white-text back-btn left" href="javascript:history.back()" style="display: inline-flex;"><i class="material-icons">arrow_back</i><span style="margin-top: -5px">Back</span></a> -->
                        <a class="white-text text-lighten-4" href="#">Gallery</a></div>
                </div>
            </div>
        </div>

        <?php   if($found == '1'){  ?>

        <!-- <div class="row">
            <div class="col s12">   
            <?php foreach ($gallery_details as $gallery) { ?>

                <div class="col s4">
                    <div class="material-placeholder">
                        <div class="card">
                            <div class="card-image">

                            <img class="materialboxed responsive-img intialized" data-caption="<?php echo "Desc: ".$gallery->desc."\tUploaded by: ".

                            (($gallery->role===1) ? $gallery->pname:'' ).(($gallery->role===2) ? $gallery->tname:'' )

                            ."\t("
                            .(($login_date_type==2)? eToN(date('Y-m-d', strtotime($gallery->date))) : date('Y-m-d', strtotime($gallery->date)))
                            ." ".date('g:i A', strtotime($gallery->date)).")"; ?>" src="<?php echo $gallery->file_location.$gallery->imagename ?>">

                            <span class="card-title galleryfontsize"><?php echo $gallery->title; ?></span>
                            <?php if ($login_cat === 1  || $pac['edit_gallery'] == 1) { ?>
                            <a href="deleteuserscript.php?token=4r6y7utygh4esw&key=<?php echo "ae25nJ5s3fr596dg@".$gallery->id; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }" class="btn-floating halfway-fab waves-effect waves-light grey lighten-4"><i class="material-icons red-text text-darken-4">delete</i></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php }  ?>
                        
            </div>
        </div> -->
        <section id="card-lists" class="row">
            <?php foreach ($gallery_details as $gallery) { ?>
          <div class="card col s12 m4 l3 gaImageCard">
            <figure >
              <img class="materialboxed responsive-img intialized" width="100%" height="100%!important" src="<?php echo "../uploads/".$fianlsubdomain."/gallery/".$gallery->imagename ?>" data-caption="<?php echo "Desc: ".$gallery->desc."\tUploaded by: ".

                            (($gallery->role===1) ? $gallery->pname:'' ).(($gallery->role===2) ? $gallery->tname:'' )

                            ."\t("
                            .(($login_date_type==2)? eToN(date('Y-m-d', strtotime($gallery->date))) : date('Y-m-d', strtotime($gallery->date)))
                            ." ".date('g:i A', strtotime($gallery->date)).")"; ?>">  
                         
            </figure>
            <div class="gaImageCardDel">
                     <span class="card-title galleryfontsize"><?php echo $gallery->title; ?></span>
                    <?php if ($login_cat === 1  || $pac['edit_gallery'] == 1) { ?>
                    <a href="deleteuserscript.php?token=4r6y7utygh4esw&key=<?php echo "ae25nJ5s3fr596dg@".$gallery->id; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }" class="btn-floating halfway-fab waves-effect waves-light grey lighten-4" style="top:-18px"><i class="material-icons red-text text-darken-4">delete</i></a>
                    <?php } ?>
                </div>   
          </div>
            <?php }  ?>

        </section>
        <?php
        } else if($found == '0') { ?>
        <div class="row">
            <div class="col s12">
                <div class="card grey darken-3">
                    <div class="card-content white-text">
                        <span class="card-title center"><span style="color:#80ceff;">No Images Found!!!</span></span>
                    </div>
                </div>
            </div>
        </div>
        <?php }

    if ($login_cat === 1  || $pac['add_gallery'] == 1) {  ?>
        
    <div class="fixed-action-btn">
        <a href="gupload.php" class="btn-floating btn-large red">
          <i class="large material-icons">add</i>
        </a>
    </div>
    <?php } ?>
    </main>
    


<?php include_once("../config/footer.php");?>
 
