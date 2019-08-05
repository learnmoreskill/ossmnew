 <?php
include('../session.php');
include('../load_backstage.php');

if(isset($_REQUEST['feetype_id']))
{
  $feetype_id = $_GET['feetype_id'];
  $student_id = $_GET['student_id'];
  $payment_type = $_GET['payment_type'];
  $feetype_title = $account->get_feetype_title_by_feetype_id($feetype_id);
  $due_type_details = json_decode($account->get_due_type_details_by_feetype_id_student_id_status($feetype_id,$student_id,1));

  $deletable = 1;
  if ($feetype_title == "Back Due") {
    $deletable = 0;
  } 
  ?>
  <div class="modal-body" style="padding: 0">
       	<div class="modal-header" style="padding: 10px;border: 0px;">  
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                 <h4 class="modal-title">
                 <i class="glyphicon glyphicon-user"></i> <?php echo $feetype_title; ?> fee details
                 </h4> 
          </div> 
        <div class="customClass">
         <div class="col-md-12 container-expensestbl overflowScroll">
          <table class="table table-dark table-responsive no-margin">
            <thead>
              <tr>
                <th><?php echo (($payment_type)? "Year" : "Month"); ?></th>
                <th>Amount</th>
                <th>Description</th>
                <th>Added by</th>
                <th>Added date</th>
                <?php if($deletable){ ?>
                  <th>Action</th>
                <?php } ?>
              </tr>
            </thead>
            <tbody>
              
              <?php 
              $total = 0;
              $yearMonth = '';

              foreach ($due_type_details as $key){

              	$total +=$key->balance;

              	list($bs_year, $bs_month, $bs_day) = explode('-', $key->date);
              	$dateFnxn = new NepaliDate();
              	if ($payment_type) {
               		$yearMonth  = $bs_year;
               	}else{
  					      $yearMonth=$dateFnxn->get_nepali_month($bs_month)." (".$bs_year.")";
               	}
              





             	?>
              <tr>
                <td><?php echo $yearMonth; ?></td>
                <td><?php echo $key->balance; ?></td>
                <td><?php echo $key->description; ?></td>
                <td><?php echo (($key->t_role==1)? $key->pname : (($key->t_role==5)? $key->staff_name : '' ) ); ?></td>
                <td><?php echo $key->date; ?></td>
                <?php if($deletable){ ?>
                <td>
                  <a id="deleteAddeDueBtn" href='#' data-toggle='modal' onclick="deleteAddeDue(<?php echo $key->id; ?>)">
                      <i class='glyphicon glyphicon-trash' style='color:red;' ></i>
                  </a>
                </td>
                <?php } ?>
              </tr>
              <?php } ?>
              
              <tr class="bg-primary">
                <th colspan="">Total</th>
                <th colspan="5"><?php echo $total; ?></th>
               
              </tr>
            </tbody>
          </table>
        </div>
      </div>

         
        
        
         <div class="modal-footer"> 
                  <button type="button" class="btn btn-danger pull-right" data-dismiss="modal" style="color: #fff;background-color: #009688;border-color: #46b8da;" >Close</button>
          </div> 
  </div>

   <?php 
}
?>