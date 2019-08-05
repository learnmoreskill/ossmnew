<?php
require("../account_management.php");
require("../nepaliDate.php");
$account = new account_management_classes();
$date = $nepalidate->full;
$school_details = json_decode($account->get_school_details_by_id());
if(isset($_REQUEST['student_id']))
{
	$student_statement_record = json_decode($account->get_statement_by_student_id_single_date($_REQUEST['student_id'],$_REQUEST['date']));
	$student_details = json_decode($account->get_student_details_by_sid($_REQUEST['student_id']));	
}

if(isset($_REQUEST['two_date_student_id']))
{
	$student_id =  $_REQUEST['two_date_student_id'];
	$first_date =  date('Y-m-d',strtotime($_REQUEST['first_date']));
	$second_date =  date('Y-m-d',strtotime($_REQUEST['second_date']));
	$student_statement_record = json_decode($account->get_student_statement_by_student_id_and_twodate($student_id,$first_date,$second_date));
	$student_details = json_decode($account->get_student_details_by_sid($_REQUEST['two_date_student_id']));
}

if(isset($_REQUEST['student_id']) || isset($_REQUEST['two_date_student_id']))
{

echo "
<div class='table-agile-info' >
                <div class='panel panel-default'>
                    <div class='panel-heading' >
                      Student Account Details
                    </div>
                    <div style='width:100%;margin:10px;'>
                    <input onclick='printPage()' class='btn btn-primary' value='print' readonly='true' style='float:right;width:100px;margin-right:30px;'/>
                    </div>

                    <div class='table-responsive' style='padding: 10px;margin-top:50px;' id='load_edit_teacher_record'>
             
        <div style='display:none;' id='student_details'>            
        <table width='100%' style='border-bottom: 1px solid #a8adac;'>
            <tbody>
                <tr>
                    <td align='center'>
                      <tr align='center'>
                        <td width='100px'><img src='../../../uploads/logo/".$school_details->slogo."' width='80px' height='80px'></td>
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
		                 <div>Class:" .$account->get_student_class_name_by_id($student_details->sclass)."-".$account->get_section_name_by_section_id($student_details->ssec)."</div>
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
                                  <th scope='col'>Fee Head</th>
                                  <th scope='col'>Balance</th>
                                  <th scope='col'>Discount</th>
                                  <th scope='col'>Fine</th>
                                  <th scope='col'>Paid</th>
                                  <th scope='col'>Date</th>
                                  <th scope='col'>Status</th>
                                </tr>
                            </thead>
                            <tbody>";
                            	$sn=0;
                            	foreach ($student_statement_record as $key) 
                            	{
                            		$sn++;
	                            	echo "
	                            	<tr>
	                                  <td>".$sn."</td>
	                                  <td style='width:30%'>".$account->get_feetype_by_feetype_id($key->feetype_id)."</td>
	                                  <td>".$key->balance."</td>
	                                  <td>".$key->discount."</td>
	                                  <td>".$key->fine."</td>
	                                  <td>".$key->paid."</td>
	                                  <td>".$key->last_payment_date."</td>
	                                  <td>".$key->status."</td>
	                                  
	                                </tr>
	                            	";
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