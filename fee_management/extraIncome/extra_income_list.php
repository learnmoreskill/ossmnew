<?php
include('../session.php');
include('../load_backstage.php');

if(isset($_REQUEST['income_delete_id']))
{
  $income_id = $_REQUEST['income_delete_id'];  

  $details = json_decode($account->getIncomeById($income_id));

  $account->delete_income_by_id($income_id);
  $account->delete_bill_by_id($details->bill_print_id);

  $account->add_activity_log($LOGIN_ID, $LOGIN_CAT, 'Deleted', 'income id:'.$income_id.', as: '.$details->income_type.', amount:'.$details->income_amount, 'account', 'url');
}
$income_list = json_decode($account->getExtraIncome());
?>
<div class="panel panel-default">
                     <div class="panel-heading"  style='font-size:17px;'>
                          Income Record 
                          <span class="pull-right"><input type="checkbox" name="showall" onchange="showHideDeleted(this)"> Show All</span>
                        </div>
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable' class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                  <th scope="col">B.N.</th>
                                  <th scope="col">Income Type</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Date</th>
                                  <th scope="col">Print Count</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($income_list as $key){ ?>
                                    <tr <?php echo (($key->status==0)?"class='deletedClass' style='display:none'":""); ?> >
                                        <td><?php echo $key->bill_number; ?></td>
                                        <td><?php echo $key->income_type; ?></td>
                                        <td><?php echo $key->income_amount; ?></td>
                                        <td><?php echo $key->income_description; ?></td>
                                        <td><?php echo $key->date; ?></td>
                                        <td><?php echo $key->print_count; ?></td>
                                        <td>
                                          <?php if ($key->status==1) { ?>

                                            <button style='padding:0px 5px;' onclick='edit_extra_income(<?php echo $key->income_id; ?>)' type='button' class='btn btn-success' title='Edit'><i class='fa fa-pencil'></i> Edit</button>

                                            <button style='padding:0px 5px;' onclick='delete_extra_income(<?php echo $key->income_id; ?>)' type='button' class='btn btn-danger' title='Delete'><i class='fa fa-remove'></i> Delete</button>
                                            
                                          <?php }else{ ?>

                                                <button disabled style='padding:0px 5px;' type='button' class='btn btn-danger' title='Deleted'><i class='fa fa-remove'></i> Deleted</button>

                                          <?php } ?>
                                        </td>
                                      
                                    </tr> <?php 
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <script type="text/javascript">
                  function showHideDeleted(sel){
                    var doc=document.getElementsByClassName('deletedClass');
                    if (sel.checked) {
                      for(var i=0;i<doc.length;i++)
                      {
                        doc[i].style.display='table-row';
                      }
                    }
                    else{
                      for(var i=0;i<doc.length;i++)
                      {
                        doc[i].style.display='none';
                      }
                    }
                  }
                </script>