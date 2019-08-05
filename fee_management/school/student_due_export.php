<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php');
require('../head.php');
require('../header.php');


require("../../important/backstage.php");

$backstage = new back_stage_class();


if (isset($_GET["generate_student_due_ledger"]) == 'student' ){


  $export_type = $_GET['export_type'];

  $classId = $_GET['classId'];
  $sectionId = $_GET['sectionId'];


  if (!empty($export_type)) {  

    $studentList= json_decode($backstage->get_all_active_student_details_with__hostel_bus_details_by_class_section_id($classId,$sectionId));

  }else{ ?><script> alert('Please select type'); window.location.href = 'student_due.php'; </script><?php }
}

?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<script>

    function loadScript() {

      $('#studentTable').DataTable( {
          dom: 'Bfrtip',
          responsive: true,
          
          buttons: [
                { extend: 'copy',messageTop: '<?php echo $page_name; ?>' },
                { extend: 'csv',messageTop: '<?php echo $page_name; ?>' },
                { extend: 'excel',messageTop: '<?php echo $page_name; ?>' },
                { extend: 'pdf',messageTop: '<?php echo $page_name; ?>' },
                { extend: 'print',
                  messageTop: '<?php echo $page_name; ?>',
                  exportOptions: {
                        columns: ':visible'
                    }
                },
                'colvis'
              ],
            columnDefs: [ {
                visible: false
            } ]
      } );
      $('#studentTable').css({'max-width':$('#detailTable').width()+'px'})
      }
      
    xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("detailTable").innerHTML = this.responseText;
                  process.nextTick(loadScript());
                  //selectDropdown.trigger('contentChanged');
              }
          };



        function filterOn(dat){
          console.log("data selected",dat.value);         
        }
</script>
<body>
    
<?php include('../config/navbar.php'); ?>

<section id="main-content">
    <section class="wrapper" style="width:95%;margin:100px 25px 0px;">
        <div id="detailTable">
    	 <table id="studentTable"  class="table table-striped table-bordered">

              <thead>
              <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Class</th>
                <th>Roll</th>
                <th>Address</th>
                <th>Parent</th>
                <th>Number</th>
                <?php if ($export_type=='transport') { ?>

                    <th>Bus No</th>
                    <th>Route</th>
                    <th>Bus Fee</th>
                   
                <?php } ?>
                <?php if ($export_type=='hostel') { ?>

                    <th>Hostel Fee</th>
                   
                <?php } ?>
                <th>Total Balance</th>
                <th>Advance Paid</th>
                <th>Total Payable</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $index = 1;
                foreach ($studentList as $slist) {

                    if ($export_type=='general' && (!empty($slist->hostel_fee) || !empty($slist->bus_id)) ) {
                        continue;
                    }else if ($export_type=='hostel' && ( empty($slist->hostel_fee ) || $slist->hostel_fee == '0')) {
                        continue;
                    }else if ($export_type =='transport' && ( empty($slist->bus_id ) || $slist->bus_id == '0' )){
                        continue;
                    }

                    $student_id = $slist->sid; 

                    $balance = 0;
                    $advance = 0;
                    $payable = 0;
                    $balance = $account->get_total_balance_from_student_due_by_std_id($student_id);
                    $advance = $account->get_advance_amount_from_student_transaction_by_student_id($student_id);
                    $payable = (float)$balance-(float)$advance; 
                    ?>

                    <tr>
                      <td><?php echo $index; ?></td>
                      <td><?php echo $slist->sname; ?></td>
                      <td><?php echo $slist->class_name.' - '.$slist->section_name; ?></td>
                      <td><?php echo $slist->sroll; ?></td>
                      <td><?php echo $slist->saddress; ?></td>
                      <td><?php echo $slist->spname; ?></td>
                      <td><?php echo $slist->spnumber.(empty($slist->spnumber_2) ? "" :  ", ". $slist->spnumber_2).(empty($slist->smobile) ? "" :  ", ". $slist->smobile); ?></td>

                        <?php if ($export_type=='transport') { ?>

                            <td> <?php echo $slist->bus_number; ?> </td>
                            <td> <?php echo $slist->bus_route; 
                                if ( empty($slist->bus_stop) ) { echo ""; }else{ echo " : ".$slist->bus_stop; } ?>
                            </td>
                            <td> <?php echo $slist->bus_fee_rate; ?></td>
                           
                        <?php } ?>
                        <?php if ($export_type=='hostel') { ?>

                            <td><?php echo $slist->hostel_fee; ?></td>
                           
                        <?php } ?>


                      <td><?php echo $balance; ?></td>
                      <td><?php echo $advance; ?></td>
                      <td><?php echo $payable; ?></td>
                    </tr>
                    <?php 
                    $index++;
                } ?>
            </tbody>
    
          </table>
    	  
    </section>
</section>
<?php require('../config/commonFooter.php'); ?>

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
 <script src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.colVis.min.js"></script>
 <script>
  loadScript();
 </script>

</body>
</html>
