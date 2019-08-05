<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<?php
include('../session.php');
$teacher_details = json_decode($account->get_teacher_details());

?>

<body>
<?php include('../config/navbar.php'); ?>

    <section id="main-content">
        <section class="wrapper">
            <div class="table-agile-info" id='load_edit_teacher_record'>
                <div class="panel panel-default">
                    <div class="panel-heading" >
                      Teacher Account Record Details
                    </div>
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='teacherDetailsTable' class="table table-striped b-t b-light">
                            <thead>
                                <tr>
                                    <th scope="col">S.N.</th>
                                    <th scope="col">Teacher Name</th>
                                    <th scope="col">Address</th>
                                    <th scope="col">Balance</th>
                                    <th scope="col">Withdraw</th>
                                    <th scope="col">Advance</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn=0;
                                foreach($teacher_details as $row) {
                                  $sn++;
                                  $account_details = json_decode($account->get_teacher_account_details_by_teacher_account_id($row->tid));
                                  $current_balance = $account_details->current_balance;
                                  $total_withdrawal = $account_details->total_withdrawal;
                                  $withdrawal_date = $account_details->withdrawal_date;
                                  $advance = json_decode($account->get_teacher_advance_by_teacher_id_status($row->tid));
                                  $total_advance = 0;
                                  foreach ($advance as $key) 
                                  {
                                    $advance = $key->advance;
                                    $total_advance = $total_advance + $advance;
                                  }

                                    
                                    echo "<tr>
                                      <td>".$sn."</td>
                                      <td>".$row->tname."</td>
                                      <td>". $row->taddress."</td>
                                      <td>".$current_balance."</td>
                                      <td>".$total_withdrawal."</td>
                                      <td>".$total_advance."</td>
                                      <td style='width:90px;'>".$withdrawal_date."</td>
                                       <td>
                                        <a href='../teacher/statement.php?id=".$row->tid."' class='btn btn-danger' style='color:#fff;margin-right:10px;float: right;'  title='Print'> 
                                            <span><i class='fa fa-list-ol' aria-hidden='true'></i> </span><span>Statement</span></a>
                                        
                                       </td>
                                    </tr>";
                                }
                                ?>

                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </section>

</section>
<div id="viewModal" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">

        </div>
    </div>
</div>


<div id="viewAdvanceModel" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="width:30%;">
        <div class="modal-content-advance" style='background-color: #fff;border-radius: 10px;'>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() 
    {
        $('#teacherDetailsTable').DataTable({
            // "processing": true,
            // "serverSide": true,
            // "ajax": "server_processing.php",
        });
    });
</script>


 <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>
    
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
    <script src="../assets/js/sparkline-chart.js"></script>    
    <script src="../assets/js/zabuto_calendar.js"></script>    
<script type="text/javascript">
$(document).ready(function()
{

   $('.ItemID').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../teacher/payment_model.php?edit_id="+ItemID,cache:false,success:function(result){
            $(".modal-content").html(result);
        }});
    });




     $('.advanceItem').click(function(){
        var ItemID=$(this).attr('data-whatever');
        $.ajax({url:"../teacher/advance_model.php?edit_id="+ItemID,cache:false,success:function(result){
            $(".modal-content-advance").html(result);
        }});
    });
});


</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
 <script>
  loadScript();
 </script>
</body>
</html>
