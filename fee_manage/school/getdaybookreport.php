<?php
include('../session.php');
include('../load_backstage.php');

if(isset($_REQUEST['request_for_daybook_by_date'])){

  $selectedDate = $_REQUEST['request_for_daybook_by_date'];
  $incomeReportType = $_REQUEST['incomeReportType'];

  if ($incomeReportType == 'categorywise') {
    $studentCategoryCredit = json_decode($account->get_day_book_credit_with_category_group_by_date($selectedDate)); 
  }
  if ($incomeReportType == 'classwise') {
    $studentClassCredit = json_decode($account->get_day_book_credit_with_class_group_by_date($selectedDate)); 
  }

	

	?>


	<div class="panel panel-default">
        <div class="panel-body">
          <div class="row no-margin">
           <div class="col-md-6 no-padding">
              <h3>Income</h3>
              <table class="table table-hover table-bordered no-margin">
                <thead>
                  <tr>
                    <th>Particular</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  $totalIncome = 0;
                  $totalExpense = 0;
                  if ($incomeReportType == 'categorywise') {
                    foreach ($studentCategoryCredit as $scc){ ?>
                      <tr>
                        <td><?php if ($scc->bill_type==0) { echo "Advance payment"; }else{
                          echo $scc->feetype_title; } ?>
                        </td>
                        <td><?php echo (($scc->bill_type==0)? $scc->advance : $scc->payment ); ?></td>
                        <td><button class="btn btn-success">View</button></td>
                      </tr>
                      <?php 
                      $totalIncome += (($scc->bill_type==0)? $scc->advance : $scc->payment );

                    }

                  }

                  if ($incomeReportType == 'classwise') {
                    foreach ($studentClassCredit as $scc){ ?>
                      <tr>
                        <td>Student Collection From Class: <?php echo $scc->class_name; ?></td>
                        <td><?php echo $scc->income; ?></td>
                        <td><a href="../school/daybook_details.php?reuestForDaybookDetails=<?php echo $selectedDate; ?>&incomeReportType=<?php echo $selectedDate; ?>&classId=<?php echo $scc->class_id; ?>">
                              <button class="btn btn-success">View</button>
                          </a>
                        </td>
                      </tr>
                      <?php 
                      $totalIncome += $scc->income;

                    }
                  } ?>
                  
                </tbody>
                <tfoot>
                   <tr class="success">
                    <td >Total Income:</td>
                    <td colspan="2"><?php echo $totalIncome; ?></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <hr class="visible-sm visible-xs">
            <div class="col-md-6 " style="padding-right: 0">
              <h3>Expences</h3>
              <table class="table table-hover table-bordered no-margin">
                <thead>
                  <tr>
                    <th>Particular</th>
                    <th>Amount</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- <tr>
                    <td>Student fee(clss:1/A)</td>
                    <td>5000</td>
                    <td><button class="btn btn-success">View</button></td>
                  </tr> -->
                  
                </tbody>
                <tfoot>
                   <tr class="danger">
                    <td >Total Expences:</td>
                    <td colspan="2"></td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          </div>
      </div>
      <div class="row no-margin">
        <div class=" col-sm-6 col-sm-offset-6 panel panel-default no-padding">
          <div class="panel-body ">
            <table class="table table-hover table-bordered no-margin">
              <tbody>
                
                <tr class="success">
                  <td>Total Income:</td>
                  <td><?php echo $totalIncome; ?></td>
                </tr>
                 <tr class="danger">
                  <td >Total Expences:</td>
                  <td ><?php echo $totalExpense; ?></td>
                </tr>
              </tbody>
              <tfoot>
                <tr class="info">
                  <td >Grand Total:</td>
                  <td><?php echo $totalIncome-$totalExpense; ?></td>
                </tr>
              </tfoot>
            </table>
            
          </div>
        </div>
      </div>

<?php
}	?>
