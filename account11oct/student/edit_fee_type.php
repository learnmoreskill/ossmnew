<?php
require("../account_management.php");
$account = new account_management_classes();
if(isset($_REQUEST['edit_id']))
{
   $feetype_title = $account->get_feetype_by_feetype_id($_REQUEST['edit_id']); 
   $edit_id = $_REQUEST['edit_id'];
}


?>

<div class='form-w3layouts'>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" style='font-size:17px;'>
                          Update Fee Type
                        </header>
                        <div class="panel-body">
        
                            <form id='form' name='feetypeForm'>
                                <div class='form-group'>
                                    <label>Fee Type </label>
                                    <?php
                                    echo "<input class='form-control' type='text' name='feetype_title' value='".$feetype_title."'>";
                                    ?>
                                        
                                </div>
                                
                                <div class="form-group">
                                    <?php
                                    echo"<input style='margin-bottom: 20px;width:100px;' readonly='true' class='btn btn-primary pull-right' onclick='update_fee_type(".$edit_id.")'  value='Submit' />";

                                    ?>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
            </div>