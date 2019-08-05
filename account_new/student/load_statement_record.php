<?php
include('../session.php');
include('../load_backstage.php');

$date = $nepaliDate->full;

if(isset($_REQUEST['student_id'])){
  $student_id = $_REQUEST['student_id'];

	$student_statement = json_decode($account->get_statement_by_student_id_single_date($student_id,$_REQUEST['date']));

	$student_details = json_decode($account->get_student_details_by_sid($student_id));	
}

if(isset($_REQUEST['two_date_student_id']))
{
	$student_id =  $_REQUEST['two_date_student_id'];
	// $first_date =  date('Y-m-d',strtotime($_REQUEST['first_date']));
	// $second_date =  date('Y-m-d',strtotime($_REQUEST['second_date']));
  $first_date =  $_REQUEST['first_date'];
  $second_date =  $_REQUEST['second_date'];

	$student_statement = json_decode($account->get_student_statement_by_student_id_and_twodate($student_id,$first_date,$second_date));
	$student_details = json_decode($account->get_student_details_by_sid($student_id));
}

if(isset($_REQUEST['student_id']) || isset($_REQUEST['two_date_student_id']))
{

echo "
<div class='table-agile-info' >
                <div class='panel panel-default'>
                    <div class='panel-heading' >
                      Student Account Details

                        <input onclick='printPage()' class='btn btn-primary' value='print' readonly='true' style='float:right;width:100px;padding: 3px;    margin-top: -5px;'/>
                      
                    </div>
                   

                    <div class='table-responsive' id='load_edit_teacher_record'>
             
        <div style='display:none;' id='student_details'>            
        <table width='100%' style='border-bottom: 1px solid #a8adac;'>
            <tbody>
                <tr>
                    <td align='center'>
                      <tr align='center'>
                        <td width='100px'><img src='../../uploads/".$fianlsubdomain."/logo/".$school_details->slogo."' width='80px' height='80px'></td>
                        <td style=''>
                         <p style='font-size: 20;font-style: bold;margin-top: -20px;margin-left:-20px;'>".$school_details->school_name."</p>
                        <p style='margin-top: -20px;margin-left:-20px;'>".$school_details->school_address."</p>
                        <p style='margin-top: -20px;margin-left:-20px;'>".$school_details->phone_no."</p>
                        </td>
                      </tr>
                        
                    </td>

                </tr>
            </tbody>
        </table>

                    <div style='background: #d4cdcd;padding: 10px;border-radius: 10px;width:90%;margin-top:10px;margin-bottom:10px;height:80px;'>
                    <div class='col-md-6' style='float:left'>
	                     <div>Name:" .$student_details->sname."</div>
		                 <div>Class:" .$student_details->class_name."-".$student_details->section_name."</div>
		                 <div>Addmission No:" .$student_details->sadmsnno."</div>
		                 <div>Address:".$student_details->saddress."</div>
	                 </div>
	                 <div class='col-md-6' style='float:right;'>
	                     <div>Father's Name:" .$student_details->spname."</div>
		                 <div>Gender:" .$student_details->sex."</div>
		                 <div>Date:" .$date."</div>
		                
	                 </div>
	                 </div>
                    
                   
        </div>


<hr>
                   
                        <table id='studentDetailsTable' class='table-border table table-striped b-t b-light'>
                            <thead>
                                <tr style='background:#ddede0;'>
                                  <th scope='col'>S.N.</th>
                                  <th scope='col'>Date</th>
                                  <th scope='col'>Fee Type</th>
                                  <th scope='col'>Balance</th>
                                  <th scope='col'>Discount</th>
                                  <th scope='col'>Fine</th>
                                  <th scope='col'>Paid Amount</th>
                                  <th scope='col'>Deposite Amount</th>
                                  <th scope='col'>Advance Balance</th>
                                </tr>
                            </thead>
                            <tbody>";
                            	$sn=0;
                            	foreach ($student_statement as $key) 
                            	{
                            		$sn++; 

                                if ($key->type == '1') {
                                  //CREDIT

                                  echo "
                                  <tr>
                                      <td>".$sn."</td>
                                      <td>".$key->date."</td>
                                      <td style='width:30%'>Deposit</td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td></td>
                                      <td style ='color:green'>".$key->credit."</td>
                                      <td>".$key->advance."</td>
                                      
                                    </tr>
                                  "; 
                                  
                                }else if ($key->type == '0') {
                                  echo "
                                  <tr>
                                      <td>".$sn."</td>
                                      <td>".$key->date."</td>
                                      <td style='width:30%'>".$key->feetype_title."</td>
                                      <td>".$key->balance."</td>
                                      <td>".$key->discount."</td>
                                      <td>".$key->fine."</td>
                                      <td style ='color:red'>".$key->debit."</td>
                                      <td></td>
                                      <td>".$key->advance."</td>
                                      
                                    </tr>
                                  ";                                  
                                }
	                            	
                            	}

                            	
                            	
                           echo " </tbody>
                        </table>
                    </div> 
                </div>
        </div>  ";
        }         
?>
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