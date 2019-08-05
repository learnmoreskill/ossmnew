<?php
require("../nepaliDate.php");
require("../account_management.php");
$account = new account_management_classes();
$date = $nepaliDate->full;
$school_details = json_decode($account->get_school_details_by_id());
//$teacher_details =  json_decode($account->get_teacher_record_by_tid());
if(isset($_REQUEST['teacher_id']))
{
  $teacher_account_details= json_decode($account->get_teacher_payment_record_by_teacher_id_date($_REQUEST['teacher_id'],$_REQUEST['date']));
  $teacher_details = json_decode($account->get_teacher_record_by_tid($_REQUEST['teacher_id']));
  
}
if(isset($_REQUEST['teacher_id_by_two_date']))
{
	$teacher_id = $_REQUEST['teacher_id_by_two_date'];
	$first_date = $_REQUEST['first_date'];
	$second_date = $_REQUEST['second_date'];
	$teacher_account_details = json_decode($account->get_teacher_payment_record_by_teacher_id_two_date($teacher_id,$first_date,$second_date));
  $teacher_details =  json_decode($account->get_teacher_record_by_tid($_REQUEST['teacher_id_by_two_date']));
  // var_dump($_REQUEST['teacher_id_by_two_date']);
  // echo $teacher_id."=".$first_date."=".$second_date;
  // var_dump($teacher_account_details);

}


if(isset($_REQUEST['teacher_id']) || isset($_REQUEST['teacher_id_by_two_date']))
{

echo "
<div class='col-md-12' style='width: 98%;
    margin: 0px;
    background: #d6d0d0;
    padding: 10px;
    margin-left: 10px;'>
    <input onclick='printPage()' class='btn btn-primary' value='print' readonly='true' style='float:right;width:100px;margin-right:30px;'/>
</div>

<div  style='padding: 10px;margin-top:50px;' id='print_record'>
             
    <div style='display:none;' id='teacher_payment_details'>            
        <table width='100%' >
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
       <hr>
        <div style='background: #d4cdcd;padding: 10px;border-radius: 10px;width:40%;margin-top:10px;margin-bottom:10px;height:60px;'>
	                    <div class='col-md-6' style='float:left'>
		                     <div>Name:" .$teacher_details->tname."</div>
			                 <div>Address:" .$teacher_details->taddress."</div>
			                 <div>Gender:" .$teacher_details->sex."</div>
			                 
		                 </div>
	    </div>
        <hr>            
                   
    </div>


                        <table id='studentDetailsTable' class='table tt table-border table-striped b-t b-light' style='background:white;'>
                            <thead>
                                <tr>
                                  <th>S.N.</th>
                                  <th>Type</th>
                                  <th>Bonus</th>
                                  <th>Deduction</th>
                                  <th>Amount</th>
                                  <th>Date</th>
                                  <th>Purpose</th>
                                  <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>";
                            	$sn=0;
                            	foreach ($teacher_account_details as $key) 
                            	{
                               
                            		if($key->advance != 0)
                            		{
                            			$payment_head = 'Advance';
                            			$amount = $key->advance;
                            		}
                            		else
                            		{
                            			$payment_head = 'Salary';
                            			$amount = $key->net_pay;
                            		}
                            		$sn++;
	                            	echo "
	                            	<tr>
	                                  <td>".$sn."</td>
	                                  <td>".$payment_head."</td>
	                                  <td>".$key->bonus."</td>
	                                  <td>".$key->deduction."</td>
	                                  <td>".$amount."</td>
	                                  <td>".$key->paid_date."</td>
	                                  <td>".$key->description."</td>
	                                  <td>".$key->status."</td>
                                    <td class='action_id'>
	                                  <input onclick='privious_bill_print(".$key->pme_id.")' class='btn btn-primary' style='width:100px;color:#fff;' readonly='true'  value='Bill Print'>
                                         </td>
	                                </tr>
	                            	";
                            	}

                            	
                            	
                           echo " </tbody>
                        </table>
                   
        </div>  ";
        }         
?>


<script type="text/javascript">
function printPage()
{
	$('#teacher_payment_details').show();
  $('.action_id').hide();
  
   var html="<html>";
   html+= document.getElementById('print_record').innerHTML;

   html+="</html>";

   var printWin = window.open();
   printWin.document.write(html);
   printWin.document.close();
   printWin.focus();
   printWin.print();
    setTimeout(function(){printWin.close();},100);
   $('#teacher_payment_details').hide();
   $('.action_id').show();
}
</script>

<script>
function privious_bill_print(id) 
{
  
   url = "../teacher/privious_bill.php?bill_id="+id;
   
    var printWindow = window.open(url, 'Print', '');
    printWindow.addEventListener('load', function(){
        printWindow.print();
        printWindow.close();
    }, true);
}
</script>
