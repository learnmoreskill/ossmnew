<?php
include('../session.php');
include('../load_backstage.php');

if(isset($_REQUEST['request_for_daybook_by_date'])){

  $selectedDate = $_REQUEST['request_for_daybook_by_date'];
  $incomeReportType = $_REQUEST['incomeReportType'];

list($selectedDate_year, $selectedDate_month, $selectedDate_day) = explode('-', $selectedDate);
$selectedDate = $selectedDate_year.'-'.(int)$selectedDate_month.'-'.(int)$selectedDate_day;


  if ($incomeReportType == 'detailwise') {
    $studentCredit = json_decode($account->get_day_book_credit_details_by_date($selectedDate)); 
  }
  // if ($incomeReportType == 'classwise') {
  //   $studentClassCredit = json_decode($account->get_day_book_credit_with_class_group_by_date($selectedDate)); 
  // }
  // if ($incomeReportType == 'categorywise') {
  //   $studentCategoryCredit = json_decode($account->get_day_book_credit_with_category_group_by_date($selectedDate)); 
  // }
  
  $incomeDetails = json_decode($account->get_day_book_income_details_by_date($selectedDate));
  $expensesDetails = json_decode($account->get_day_book_expenses_details_by_date($selectedDate)); 


	?>


	    <div class="panel panel-default">
        <div class="panel-body">
          <div class="row no-margin">
            <div  class="col-md-6 no-padding">

              <input onclick="printDiv('printIncome')" class='btn btn-primary' value='print' readonly='true' style='float:right;width:100px;padding: 3px;    margin-top: -5px;'/>
              <div id="printIncome">

                  <?php 
                  if ($incomeReportType == 'categorywise') { ?>
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

                      } ?>
                      </tbody>
                      <tfoot>
                         <tr class="success">
                          <td >Total Income:</td>
                          <td colspan="2"><?php echo $totalIncome; ?></td>
                        </tr>
                      </tfoot>
                    </table> <?php 
                  }

                  if ($incomeReportType == 'classwise') {?>
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

                    foreach ($studentClassCredit as $scc){ ?>
                      <tr>
                        <td>Student Collection From Class: <?php echo $scc->class_name; ?></td>
                        <td><?php echo $scc->income; ?></td>
                        <td><a href="../school/daybook_details.php?reuestForDaybookDetails=<?php echo $selectedDate; ?>&daybookReportType=studentPayment&classId=<?php echo $scc->class_id; ?>">
                              <button class="btn btn-success">View</button>
                          </a>
                        </td>
                      </tr>
                      <?php 
                      $totalIncome += $scc->income;

                    }?>
                      </tbody>
                      <tfoot>
                         <tr class="success">
                          <td >Total Income:</td>
                          <td colspan="2"><?php echo $totalIncome; ?></td>
                        </tr>
                      </tfoot>
                    </table> <?php 
                  } 

                  if ($incomeReportType == 'detailwise') { ?>
                    

                    <h3>Student Collection  <span class="printShow" style="display: none;">on date: <?php echo $selectedDate; ?></span></h3>
                    <table class="table table-hover table-bordered no-margin">
                      <thead>
                        <tr>
                          <th>Roll No</th>
                          <th>Student</th>
                          <th>Class</th>
                          <th>Type</th>
                          <th>Amount</th>
                          <th>Bill No</th>
                          <th class="printHide">View/Print Bill</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $studentIncome = 0;

                        foreach ($studentCredit as $key){ ?>
                          <tr>
                            <td><?php echo $key->sroll; ?></td>
                            <td>
                              <!-- hacksterCode -->
                              <!-- <a href="../student/fee-collection.php?student_id=<?php echo $key->sid; ?>">
                                <?php echo $key->sname; ?>
                              </a> -->

                              <?php echo $key->sname; ?>
                            </td>
                            <td><?php echo $key->class_name.' - '.$key->section_name; ?></td>
                            <td><?php echo (($key->bill_type==1)? ' Fee Payment' : 'Advance Payment'); ?></td>
                            <td><?php echo $key->income; ?></td>
                            <td><?php echo $key->bill_number; ?></td>
                            <td class="printHide">
                              <button class='btn btn-info'  onclick='view_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,<?php echo $key->sid; ?>)' ><i class="fa fa-eye"></i> View</button>

                        
                              <button class="btn btn-success" onclick='create_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,<?php echo $key->sid; ?>)' ><i class="fa fa-print"></i> Print</button>
                            </td>
                            
                          </tr>
                          <?php 
                          $studentIncome += $key->income;

                        }?>
                      </tbody>
                      <tfoot>
                        <tr class="success">
                          <td colspan="4" >Total Income:</td>
                          <td colspan="4"><?php echo $studentIncome; ?></td>
                        </tr>
                      </tfoot>
                    </table> <?php 
                  } 

                  $incomeDetailsCount = count((array)$incomeDetails);
                  if ($incomeDetailsCount > 0) { ?>
                    <h3 >Other Income</h3>
                    <table class="table table-hover table-bordered no-margin">
                      <thead>
                        <tr>
                          <th>S.N.</th>
                          <th>Income Title</th>
                          <th>Description</th>
                          <th>Received From</th>
                          <th>Amount</th>
                          <th>Bill No</th>
                          <th class="printHide">View/Print Bill</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $otherIncome = 0;
                        $sn = 1;

                        foreach ($incomeDetails as $key){ ?> 
                          <tr>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo $key->income_type; ?></td>
                            <td><?php echo $key->income_description; ?></td>
                            <td><?php echo $key->payment_by; ?></td>
                            <td><?php echo $key->income_amount; ?></td>
                            <td><?php echo $key->bill_number; ?></td>
                            <td class="printHide">

                              <button class='btn btn-info' onclick='view_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,0)' ><i class="fa fa-eye"></i> View</button>

                          
                              <button class="btn btn-success" onclick='create_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,0)' ><i class="fa fa-print"></i> Print</button>

                            </td>
                          </tr>
                          <?php 
                          $otherIncome += $key->income_amount;
                          $sn++;
                        } ?>
                      </tbody>
                      <tfoot>
                         <tr class="success">
                          <td colspan="4" >Total Income:</td>
                          <td colspan="4"><?php echo $otherIncome; ?></td>
                        </tr>
                      </tfoot>
                    </table> <?php
                  }  ?>


              </div>
            </div>


            <hr class="visible-sm visible-xs">
            <!-- Expenses Column Started -->
            <div class="col-md-6 " style="padding-right: 0">
              <input onclick="printDiv('printExpenses')" class='btn btn-primary' value='print' readonly='true' style='float:right;width:100px;padding: 3px;    margin-top: -5px;'/>
              <div id="printExpenses">
                <h3>Expenses <span class="printShow" style="display: none;">on date: <?php echo $selectedDate; ?></span></h3>
                <table class="table table-hover table-bordered no-margin">
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>Title</th>
                      <th>Amount</th>
                      <th>Bill No</th>
                      <!-- <th class="printHide">Action</th> -->
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                        $totalExpense = 0;

                        foreach ($expensesDetails as $key){ ?>
                          <tr>
                            <td><?php echo $key->exp_cat; ?></td>
                            <td><?php echo $key->expenses_title; ?></td>
                            <td><?php echo $key->amount; ?></td>
                            <!-- <td class="printHide">
                              <button class='btn btn-info'  onclick='view_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,<?php echo $key->sid; ?>)' ><i class="fa fa-eye"></i> View</button>

                        
                              <button class="btn btn-success" onclick='create_bill(<?php echo $key->bill_print_id; ?>,<?php echo $key->bill_type; ?>,<?php echo $key->sid; ?>)' ><i class="fa fa-print"></i> Print</button>
                            </td> -->
                            <td><?php echo $key->bill_number; ?></td>
                            
                          </tr>
                          <?php 
                          $totalExpense += $key->amount;

                        }?>
                    
                  </tbody>
                  <tfoot>
                     <tr class="danger">
                          <td colspan="2" >Total Expenses:</td>
                          <td colspan="2"><?php echo $totalExpense; ?></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>



          </div>
        </div>
      </div>
      <div class="row no-margin">
        <?php $totalIncome = $studentIncome+$otherIncome; ?>
        <div class=" col-sm-6 col-sm-offset-6 panel panel-default no-padding">
          <div class="panel-body ">
            <table class="table table-hover table-bordered no-margin">
              <tbody>
                
                <tr class="success">
                  <td>Total Income:</td>
                  <td><?php echo $totalIncome; ?></td>
                </tr>
                 <tr class="danger">
                  <td >Total Expenses:</td>
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
