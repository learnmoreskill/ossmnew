<?php
require("../account_management.php");
$account = new account_management_classes();

$expenses_category_list = json_decode($account->getExpenses());
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
                                  <th scope="col">Category</th>
                                  <th scope="col">Name</th>
                                  <th scope="col">Quantity</th>
                                  <th scope="col">Filename</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Date</th>
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
                                      <td>".$key->ecat."</td>
                                      <td>".$key->name."</td>
                                      <td>".$key->quantity."</td>
                                      <td><a href='../download.php?file=".$key->expfile."'>".$key->expfile."</a></td>
                                      <td>".$key->expamount."</td>
                                      <td>".$key->expdesc."</td>
                                      <td>".$key->date."</td>
                                       </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>


                