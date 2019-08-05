<?php
require("../account_management.php");
$account = new account_management_classes();

if(isset($_REQUEST['edit_id']))
{
   $edit_id =  $_REQUEST['edit_id'];
   $expenses_category = $account->getExpensesCategoryById($_REQUEST['edit_id']);
   
}

        

if(isset($_REQUEST['edit_id']))
{
       echo "<div class='form-w3layouts'>
            <div class='row'>
                <div class='col-lg-12'>
                    <section class='panel'>
                        <header class='panel-heading' style='font-size:17px;'>
                        Update Category
                        </header>
                        <div class='panel-body'>
        
                            <form id='form' name='update_expenses_category_form'>
                                <div class='form-group'>
                                    <label>Expenses Category </label>
                                        <input class='form-control' type='text' name='expenses_category' value='".$expenses_category."'>
                                </div>
                                
                                <div class='form-group'>
                                    <input style='margin-bottom: 20px;width:100px;' readonly='true' class='btn btn-primary pull-right' onclick='update_category_form(".$edit_id.")'  value='Update' />
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>";
  } 
  else
  {
        echo "<div class='form-w3layouts'>
            <div class='row'>
                <div class='col-lg-12'>
                    <section class='panel'>
                        <header class='panel-heading' style='font-size:17px;'>
                        Insert Category
                        </header>
                        <div class='panel-body'>
        
                            <form id='form' name='expenses_category_form'>
                                <div class='form-group'>
                                    <label>Expenses Category </label>
                                        <input class='form-control' type='text' name='expenses_category'>
                                </div>
                                
                                <div class='form-group'>
                                    <input style='margin-bottom: 20px;width:100px;' readonly='true' class='btn btn-primary pull-right' onclick='submit_form()'  value='Submit' />
                                </div>
                            </form>
                        </div>
                    </section>
                </div>
            </div>
        </div>";
  }         
?>            