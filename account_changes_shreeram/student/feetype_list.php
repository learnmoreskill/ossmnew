<?php
require("../account_management.php");
$account = new account_management_classes();
if(isset($_REQUEST['feetype']))
{
  $account->insert_feetype($_REQUEST['feetype']);
}

if(isset($_REQUEST['delete_id']))
{
  $account->delete_feetype($_REQUEST['delete_id']);
}

if(isset($_REQUEST['update_feetype']))
{
  
  $feetype_id = $_REQUEST['update_id'];
  $account->update_feetype($feetype_id,$_REQUEST['update_feetype']);
  //header('Location: ../student/fee-type.php');
  //exit;
}



$feetype_details = json_decode($account->get_feetype_details());

?>

<div class="panel panel-default">
                    <div class="panel-heading" >
                      <h4><i class="fa fa-angle-right"></i> Fee Type Record</h4><hr><table class="table table-hover">
                    </div>
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable' class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                  <th scope="col">S.N.</th>
                                  <th scope="col">Fee Type</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn=0;
                                foreach($feetype_details as $key)
                                {
                                  if($key->feetype_title=='Tution Fee' || $key->feetype_title=='Hostel Fee' || $key->feetype_title=='Bus Fee' || $key->feetype_title=='Computer Fee' || $key->feetype_title=='Admission Charge' || $key->feetype_title=='Annual Fee' || $key->feetype_title=='Exam Fee' || $key->feetype_title=='Uniform Fee' || $key->feetype_title=='Book Fee')
                                    {}
                                  
                                  else{
                                    $sn++;
                                    echo "<tr>
                                      <td>".$sn."</td>
                                      <td>".$key->feetype_title."</td>
                                      <td>
                                        <button style='padding:0px 5px;' onclick='edit_fee_type(".$key->feetype_id.")' type='button' class='btn btn-success' title='Edit'><i class='fa fa-pencil'></i> Edit</button>
                                        </td>
                                        <td>
                                            <button style='padding:0px 5px;' onclick='delete_fee_type(".$key->feetype_id.")' type='button' class='btn btn-danger' title='Delete'><i class='fa fa-remove'></i> Delete</button>
                                        </td>
                                           
                                    </tr>";
                                    }
                                }
                                ?>

                                
                            </tbody>
                        </table>
                    </div>
                </div>