<?php
include('../session.php');
include('../load_backstage.php');

$date = $nepaliDate->full;

if(isset($_REQUEST['statement_by_year'])){

  $type = 1;
  $student_id = $_REQUEST['statement_by_year'];
  $year = $_REQUEST['year'];

  $c_year = $account->get_academic_single_year_by_year_id($current_year_session_id);

	$student_statement = json_decode($account->get_statement_by_student_id_single_date($student_id,$year));

	$student_details = json_decode($account->get_student_details_by_sid($student_id));	

  if ($year == $c_year) {
    $due_details = json_decode($account->get_total_student_due_details_by_student_id_status($student_id,1));
  }
}

if(isset($_REQUEST['statement_by_two_date'])){

  $type = 2;
	$student_id =  $_REQUEST['statement_by_two_date'];
	// $first_date =  date('Y-m-d',strtotime($_REQUEST['first_date']));
	// $second_date =  date('Y-m-d',strtotime($_REQUEST['second_date']));

  list($first_date_year, $first_date_month, $first_date_day) = explode('-', $_REQUEST['first_date']);
  $first_date = $first_date_year . '-' . ltrim($first_date_month, '0') . '-' . ltrim($first_date_day, '0');

  list($second_date_year, $second_date_month, $second_date_day) = explode('-', $_REQUEST['second_date']);
  $second_date = $second_date_year . '-' . ltrim($second_date_month, '0') . '-' . ltrim($second_date_day, '0');


	$student_statement = json_decode($account->get_student_statement_by_student_id_and_twodate($student_id,$first_date,$second_date));
	$student_details = json_decode($account->get_student_details_by_sid($student_id));
} ?>


      <div class='table-agile-info' >
        
            <input onclick='printPage()' class='btn btn-primary' value='print' readonly='true' style='float:right;width:100px;padding: 3px;    margin: 5px;'/>

        <div class='table-responsive' id='load_edit_teacher_record'>
          <div class='panel panel-default'>

            <div style='display:none;' id='student_details'>            
              <table width='100%' style='border-bottom: 1px solid #a8adac;'>
                <tbody>
                  <tr>
                    <td align='center'>
                      <tr align='center'>
                        <td width='100px'><img src='../../uploads/<?php echo $fianlsubdomain."/logo/".$school_details->slogo; ?>' width='80px' height='80px'></td>
                        <td style=''>
                         <p style='font-size: 20;font-style: bold;margin-top: -20px;margin-left:-20px;'><?php echo $school_details->school_name; ?></p>
                        <p style='margin-top: -20px;margin-left:-20px;'><?php echo $school_details->school_address; ?></p>
                        <p style='margin-top: -20px;margin-left:-20px;'><?php echo $school_details->phone_no; ?></p>
                        </td>
                      </tr>
                        
                    </td>
                  </tr>
                </tbody>
              </table>

              <div style='background: #d4cdcd;padding: 10px;border-radius: 10px;margin-top:10px;margin-bottom:10px;height:80px;'>
                <div class='col-md-6' style='float:left'>
                  <div>Name: <?php echo $student_details->sname; ?></div>
                  <div>Class: <?php echo $student_details->class_name."-".$student_details->section_name; ?></div>
                  <div>Addmission No: <?php echo $student_details->sadmsnno; ?></div>
                  <div>Address: <?php echo $student_details->saddress; ?></div>
	              </div>
                <div class='col-md-6' style='float:right;'>
                  <div>Father's Name: <?php echo $student_details->spname; ?></div>
                  <div>Gender: <?php echo $student_details->sex; ?></div>
                  <div>Date:" <?php echo $date; ?></div>
                </div>
	            </div>
            </div>

            <div class='panel-heading' >
            Student Account Details<?php echo (($type == 1)? ' of '.$year : ' from '.$first_date.' to '.$second_date ); ?>
            </div>
            
            <hr>
                   
            <table width='100%' id='studentDetailsTable' class='table-border table table-striped b-t b-light'>
                <thead>
                    <tr style='background:#ddede0;'>
                      <th scope='col'>S.N.</th>
                      <th scope='col'>Date</th>
                      <th scope='col'>Fee Type</th>
                      <th scope='col'>Balance</th>
                      <th scope='col'>Paid</th>
                      <th scope='col'>Discount</th>
                      <th scope='col'>Fine</th>
                      <th scope='col'>Desc</th>
                    </tr>
                </thead>
                <tbody>

                <?php
                	$sn=0;
                  $grand_balance = 0;
                  $grand_paid = 0;
                  $grand_discount = 0;
                  $grand_fine = 0;

                	foreach ($student_statement as $key){
                    if ($key->feetype_title == "Back Due") {
                      continue;
                    }
                		$sn++; 

                    if ($key->type == '1') {
                      //CREDIT
                      ?>

                    
                      <tr>
                          <td><?php echo $sn; ?></td>
                          <td><?php echo $key->date; ?></td>
                          <td>Deposit</td>
                          <td></td>
                          <td><?php echo $key->credit; $grand_paid += $key->credit; ?></td>
                          <td><?php echo $key->discount? $key->discount:''; $grand_discount += $key->discount; ?></td>
                          <td><?php echo $key->fine? $key->fine :''; $grand_fine += $key->fine; ?></td>
                          <td><?php echo $key->description; ?></td>
                          
                        </tr>

                        <?php                    
                      
                    }else if ($key->type == '0') {

                      if ($key->feetype_title == 'Pre Discount') { ?>
                        <tr>
                          <td><?php echo $sn; ?></td>
                          <td><?php echo $key->date; ?></td>
                          <td>Pre Discount</td>
                          <td></td>
                          <td></td>
                          <td><?php echo $key->balance; $grand_discount += $key->balance; ?></td>
                          <td></td>
                          <td><?php echo $key->description; ?></td>
                          
                        </tr> <?php
                        continue;
                        
                      }
                      //DEBIT 
                      ?>
                      <tr>
                          <td><?php echo $sn; ?></td>
                          <td><?php echo $key->date; ?></td>
                          <td><?php echo $key->feetype_title; ?></td>
                          <td><?php echo $key->balance; $grand_balance += $key->balance; ?></td>
                          <td></td>
                          <td><?php echo $key->discount? $key->discount:''; $grand_discount += $key->discount; ?></td>
                          <td><?php echo $key->fine? $key->fine:''; $grand_fine += $key->fine; ?></td>
                          <td><?php echo $key->description; ?></td>
                          
                        </tr>
                      <?php                             
                    }
                  	
                	} 



                  if ($year == $c_year) {
                      foreach ($due_details as $key){
                        if ($key->feetype_title == "Back Due") {
                        continue;
                      }
                      

                      $sn++;


                      if ($key->feetype_title == 'Pre Discount') { ?>
                        <tr>
                          <td><?php echo $sn; ?></td>
                          <td><?php echo $key->date; ?></td>
                          <td>Pre Discount</td>
                          <td></td>
                          <td></td>
                          <td><?php echo $key->balance; $grand_discount += $key->balance; ?></td>
                          <td></td>
                          <td><?php echo $key->description; ?></td>
                          
                        </tr> <?php
                        continue;
                        
                      }




                              
                      ?>


                      <tr>
                       <td><?php echo $sn; ?></td>
                       <td><?php echo $key->date; ?></td>
                       <td><?php echo $key->feetype_title; ?></td>
                       <td><?php echo $key->balance; $grand_balance += $key->balance; ?></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td width="25%"><?php echo $key->description; ?></td>
                      </tr>

                      <?php 
                    }
                  }






                  ?>
                            	
                </tbody>
                <tfoot style='background:#ffdbdb;'>
                    <th></th>
                    <th></th>
                    <th>Total</th>
                    <th><?php echo $grand_balance; ?></th>
                    <th><?php echo $grand_paid; ?></th>
                    <th><?php echo $grand_discount; ?></th>
                    <th><?php echo $grand_fine; ?></th>
                    <th></th>
                </tfoot>
            </table>
          </div>


            

            <?php if ($type == 1) { ?>

            <br>
            <div class='panel panel-default'>
              <div class='panel-heading' >
                Summary of <?php echo $year; ?>
              </div>
                     
              <table width='100%' class='table-border table table-striped b-t b-light'>
                  <!-- <thead>
                      <tr style='background:#ddede0;'>
                        <th scope='col'>Forwarded Balance :</th>
                        <th scope='col'><?php echo 'back balance'; ?></th>
                        <th scope='col'></th>
                        <th scope='col'></th>
                        <th scope='col'></th>
                        <th scope='col'></th>
                      </tr>
                  </thead> -->
                  <thead>
                      <tr style='background:#ddede0;'>
                        <th scope='col'>Total Balance :</th>
                        <th scope='col'><?php echo $grand_balance; ?></th>
                        <th scope='col'>Total Discount :</th>
                        <th scope='col'><?php echo $grand_discount; ?></th>
                        <th scope='col'>Total Fine :</th>
                        <th scope='col'><?php echo $grand_fine; ?></th>
                      </tr>
                  </thead>
                  <thead>
                      <tr style='background:#ddede0;'>
                        <th scope='col'>Total Paid :</th>
                        <th scope='col'><?php echo $grand_paid; ?></th>
                        <th scope='col'>Due Left :</th>
                        <th scope='col'><?php $due_left = $grand_balance + $grand_fine -$grand_discount - $grand_paid;
                                              echo (($due_left > 0)? $due_left : 0); ?></th>
                        <th scope='col'>Advance Left :</th>
                        <th scope='col'><?php $advance_left = $grand_paid + $grand_discount - $grand_balance - $grand_fine;
                                              echo (($advance_left > 0)? $advance_left : 0); ?></th>
                      </tr>
                  </thead>
              </table>
            </div>

              <?php
             
            } ?>


           
        </div>
      </div>
             
<script type="text/javascript">
function printPage()
{
	$('#student_details').show();
   var html="<html>";
   html+= document.getElementById('load_edit_teacher_record').innerHTML;

   html+="</html>";

   var printWin = window.open();
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
    setTimeout(function(){printWin.close();},100);
   $('#student_details').hide();
}
</script>