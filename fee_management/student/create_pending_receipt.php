<?php
include('../session.php');
include('../load_backstage.php');

$date = $nepaliDate->full;
$pending_list = json_decode($account->get_pending_all_student_due_list());


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
foreach ($pending_list as $plist) 
{
    $student_id = $plist->std_id;

    include('../school/due_receipt.php');
 
}
?>
    
