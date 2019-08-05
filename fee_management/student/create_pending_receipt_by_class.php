<?php
include("../session.php");
include('../load_backstage.php');

$date = $nepaliDate->full;

$active_std_list = json_decode($account->get_active_student_id_details_by_class_id($_REQUEST['classId']));

?>
<style type="text/css" media="print">
    @media print {
      body {-webkit-print-color-adjust: exact;}
    }
    @page {
        size:A4 portrait;
        -webkit-print-color-adjust: exact;
        color-adjust: exact;
        -webkit-filter:opacity(1);
    }
</style>

<?php
if(count($active_std_list)==0)
{
	echo "No due record!!";

}else{

    foreach ($active_std_list as $asclist) 
    {
       $student_id = $asclist->sid;

       include('../school/due_receipt.php');
    }
}
?>
    
