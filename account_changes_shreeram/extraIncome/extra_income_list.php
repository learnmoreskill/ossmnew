<?php
require("../account_management.php");
$account = new account_management_classes();
if(isset($_REQUEST['delete_id']))
{
  $account->deleteIncome($_REQUEST['delete_id']);
}
$income_list = json_decode($account->getExtraIncome());
?>
<div class="panel panel-default">
                    <div class="panel-heading" >
                      Income Record
                    </div>
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable' class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                  <th scope="col">S.N.</th>
                                  <th scope="col">Income Type</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Date</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn=0;
                                foreach($income_list as $key)
                                {
                                    $sn++;
                                    echo "<tr>
                                        <td>".$sn."</td>
                                        <td>".$key->incomeType."</td>
                                        <td>".$key->incomeAmount."</td>
                                        <td>".$key->incomedescription."</td>
                                        <td>".$key->date."</td>
                                        <td>
                                        <button style='padding:0px 5px;' onclick='edit_extra_income(".$key->incomeId.")' type='button' class='btn btn-success' title='Edit'><i class='fa fa-pencil'></i> Edit</button>
                                        </td>
                                        <td>
                                            <button style='padding:0px 5px;' onclick='delete_extra_income(".$key->incomeId.")' type='button' class='btn btn-danger' title='Delete'><i class='fa fa-remove'></i> Delete</button>
                                        </td>
                                      
                                       </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>