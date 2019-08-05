<?php
include_once('../load_backstage.php');

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
                                  
                                    $sn++; ?>
                                    <tr>
                                      <td><?php echo $sn; ?></td>
                                      <td><?php echo $key->feetype_title; ?></td>
                                      <td>
                                        
                                        

                                        <!-- Hackster Code -->

                                         <?php
                                      if ($key->fixed==0) { ?>

                                        <button style='padding:0px 5px;' onclick='edit_fee_type(<?php echo $key->feetype_id; ?>)' type='button' class='btn btn-success' title='Edit'><i class='fa fa-pencil'></i> Edit</button>
                                        

                                      <?php } ?>
                                      </td>


                                        <!-- <td>
                                            <button style='padding:0px 5px;' onclick='delete_fee_type(<?php echo $key->feetype_id; ?>)' type='button' class='btn btn-danger' title='Delete'><i class='fa fa-remove'></i> Delete</button>
                                        </td> -->
                                           
                                    </tr>
                                    <?php
                                }
                                ?>

                                
                            </tbody>
                        </table>
                    </div>
                </div>