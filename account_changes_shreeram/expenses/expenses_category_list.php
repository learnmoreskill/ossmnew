<?php
require("../account_management.php");
$account = new account_management_classes();
if(isset($_REQUEST['category']))
{
	$account->insertExpensesCategory($_REQUEST['category']);
}
if(isset($_REQUEST['delete_id']))
{
	$account->deleteExpensesCategory($_REQUEST['delete_id']);
}
if(isset($_REQUEST['category_id']))
{
	$category_id = $_REQUEST['category_id'];
	$category = $_REQUEST['update_category'];

	 $account->updateExpensesCategory($category_id,$category);
}


$expenses_category_list = json_decode($account->get_expenses_category_list());
?>

<div class="panel panel-default">
                    <div class="panel-heading" >
                      Expenses Category Record
                    </div>
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable' class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                  <th scope="col">S.N.</th>
                                  <th scope="col">Expenses Category</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn=0;
                                foreach($expenses_category_list as $key)
                                {
                                    $sn++;
                                    echo "<tr>
                                      <td>".$sn."</td>
                                      <td>".$key->exp_cat."</td>
                                      <td>
                                        <button style='padding:0px 5px;' onclick='edit_expenses_category(".$key->ecat_id.")' type='button' class='btn btn-success' title='Edit'><i class='fa fa-pencil'></i> Edit</button>
                                        </td>
                                        <td>
                                            <button style='padding:0px 5px;' onclick='delete_expenses_category(".$key->ecat_id.")' type='button' class='btn btn-danger' title='Delete'><i class='fa fa-remove'></i> Delete</button>
                                        </td>
                                           
                                    </tr>";
                                }
                                ?>

                                
                            </tbody>
                        </table>
                    </div>
                </div>