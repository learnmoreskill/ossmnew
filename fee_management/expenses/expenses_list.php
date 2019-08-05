<?php
include('../session.php');
include('../load_backstage.php');

$expenses_category_list = json_decode($account->getExpenses());
?>

<div class="panel panel-default">
    <div class="panel-heading"  style='font-size:17px;'>
      Expenses Record
    </div>
    <div class="table-responsive" style='padding: 10px;'>
        <table id='studentDetailsTable' class="table table-striped b-t b-light">
            <thead>
                <tr>
                  <th scope="col">S.N.</th>
                  <th scope="col">Category</th>
                  <th scope="col">Title</th>
                  <th scope="col">Quantity</th>
                  <th scope="col">Rate</th>
                  <th scope="col">Amount</th>
                  <th scope="col">File</th>
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
                      <td>".$key->exp_cat."</td>
                      <td>".$key->expenses_title."</td>
                      <td>".$key->quantity."</td>
                      <td>".$key->rate."</td>
                      <td>".$key->amount."</td>
                      <td><a href='../download.php?file=".$fianlsubdomain."/expenses_file/".$key->file."'>".$key->file."</a></td>
                      <td>".$key->description."</td>
                      <td>".$key->date."</td>
                       </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>


                