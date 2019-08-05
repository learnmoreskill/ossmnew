<?php
require("../account_management.php"); 
$account = new account_management_classes();


if(isset($_REQUEST['delete_id']))
{
	$account->deleteExpensesCategory($_REQUEST['delete_id']);
  
}




$expenses_category_list = json_decode($account->get_expenses_category_list());
?>

<style>

</style>

<div class="panel panel-default">
  <div class="panel-heading" style="font-size: 17px">Expenses Category Record</div>
  <div class="table-responsive" style='padding: 10px;'>
    <table id='expenseTable' class="table table-striped b-t b-light">
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
          { $sn++; ?>

            <tr>
              <td><?php echo $sn; ?></td>
              <td><?php echo $key->exp_cat; ?></td>
              <td>
                <button style='padding:0px 5px;' onclick='edit_expenses_category(<?php echo $key->ecat_id; ?>)' type='button' class='btn btn-success' title='Edit'><i class='fa fa-pencil'></i> Edit</button>

                <!-- <button style='padding:0px 5px;' onclick='delete_expenses_category(<?php echo $key->ecat_id; ?>)' type='button' class='btn btn-danger' title='Delete'><i class='fa fa-remove'></i> Delete</button> -->

              </td> 
                    
            </tr> 
            <?php 
          }
          ?>
        </tbody>
    </table>
  </div>
</div>
