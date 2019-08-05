<?php
include('../session.php');
include('../load_backstage.php');

$date = $nepaliDate->full;
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
$student_id = $_REQUEST['studentId'];

include('../school/due_receipt.php');