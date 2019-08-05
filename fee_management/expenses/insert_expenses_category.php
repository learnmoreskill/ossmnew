<?php

include('../session.php');
include('../load_backstage.php');

    if(isset($_REQUEST['edit_id'])){

        $edit_id =  $_REQUEST['edit_id'];
        $expenses_category = $account->getExpensesCategoryById($_REQUEST['edit_id']);  ?>
   
        <div class='form-w3layouts'>
            <div class='row'> 
                <div class='col-lg-12'>
                    <section class='panel'>
                        <header class='panel-heading' style='font-size:17px;'>
                        Update Category
                        </header>
                        <div class='panel-body'>
        
                            <form id='update_expenses_category_form' name='update_expenses_category_form' onsubmit="submitUpdateExpenses(event);">
                                <input type="hidden" name="update_expense_request" value="update_expense_request">
                                <input type="hidden" name="expense_cat_id" value="<?php echo $edit_id; ?>">
                                <input type="hidden" name="old_expenses_category" value="<?php echo $expenses_category; ?>">
                                <div class='form-group'>
                                    <label>Expenses Category </label>
                                        <input class='form-control' type='text' name='expenses_category' value="<?php echo $expenses_category; ?>" required >
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
            <div class='row'>
                <div class='col-lg-12'>
                    <section class='panel panel-default'>
                        <header class='panel-heading' style='font-size:17px;'>
                        Insert Category
                        </header>
                        <div class='panel-body'>
        
                            <form id="expenses_add_category_form" name='expenses_add_category_form' onsubmit="submitExpForm(event);">

                                <input type="hidden" name="add_expense_request" value="add_expense_request" >

                                <div class='form-group'>
                                    <label>Expenses Category </label>
                                        <input class='form-control' type='text' name='expenses_category' placeholder='Enter expense category title...' required>
                                </div>
                                <div class="text-danger" id="errCat"></div>
                                
                                <div class='form-group pull-right'>
                                    <input type="submit" id="submitBtn" style='width:100px;'  class='btn btn-primary'  value='Submit' />

                                    <div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
                                </div>
                            </form>


                        </div>
                    </section>
                </div>
            </div>
        </div>
        <?php
    }         
?>            