<?php
include('../session.php');
include('../load_backstage.php');

if(isset($_REQUEST['edit_id'])){

    $edit_id = $_REQUEST['edit_id'];
    $feetype_title = $account->get_feetype_title_by_feetype_id($edit_id); 
   
    ?>

        <div class='form-w3layouts'>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" style='font-size:17px;'>
                          Update Fee Type
                        </header>
                        <div class="panel-body">
        
                            <form id='update_feetype_form' name='update_feetype_form' onsubmit="submitUpdateFeeType(event);">
                                <input type="hidden" name="feetype_id" value="<?php echo $edit_id; ?>">
                                <input type="hidden" name="old_feetype_title" value="<?php echo $feetype_title; ?>">
                                <div class='form-group'>
                                    <label>Fee Type </label>
                                    <input class='form-control' type='text' name='feetype_title' value='<?php echo $feetype_title; ?>' placeholder="Enter fee type name" required>
                                    
                                        
                                </div>
                                <div class="text-danger" id="errCat"></div>
                                
                                <div class='form-group pull-right'>

                                    <input type="submit" id="submitBtn" style='width:100px;'  class='btn btn-primary'  value='Update' />

                                    <div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div> 
<?php 
}else{ ?>
    <div class='form-w3layouts'>
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading" style='font-size:17px;'>
                      Insert Fee Type
                    </header>
                    <div class="panel-body">
    
                        <form id='add_feetype_form' name='add_feetype_form' onsubmit="submitAddFeeType(event);">
                            <div class='form-group'>
                                <label>Fee Type </label>
                                    <input class='form-control' type="text" name="feetype_title" placeholder="Enter fee type name" required>
                            </div>
                            <div class="text-danger" id="errCat"></div>

                            <div class='form-group pull-right'>

                                    <input type="submit" id="submitBtn" style='width:100px;'  class='btn btn-primary'  value='Add' />

                                    <div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
                            </div>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
    <?php } ?>