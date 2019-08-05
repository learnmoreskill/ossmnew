<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<?php
include('session.php');
/*set active navbar session*/
require("../important/backstage.php");

$backstage = new back_stage_class();

if (isset($_GET["token"]) && $_GET["token"] == 'export_details' ){

  $page_name = '';

  $export_type = $_GET['export_type'];
  $sub_type = $_GET['sub_type'];

  $classId = $_GET['classId'];
  $sectionId = $_GET['sectionId'];


  if (!empty($export_type)) {
    if (!empty($sub_type)) {   

      $className = $backstage->get_class_name_by_id($classId);
      $sectionName = $backstage->get_section_name_by_id($sectionId);


      $page_name .= ((!empty($className))? 'Class : '.$className.'&nbsp&nbsp' : '').((!empty($sectionName))? '&nbsp&nbsp Section : '.$sectionName.'&nbsp&nbsp' : '');

      if ($export_type == "student_details") {

        $studentList= json_decode($backstage->get_all_active_student_details_by_class_section_id($classId,$sectionId));
        $page_name .= "Student Details";

      }elseif ($export_type == "transport_details") {

        $studentBusList= json_decode($backstage->get_all_active_student_details_with_bus_details_by_class_section_id($classId,$sectionId));

        $page_name .= "Transport Details";

      }elseif ($export_type == "hostel_details") {

      $studentList= json_decode($backstage->get_all_active_student_details_by_class_section_id($classId,$sectionId));

      $page_name .= "Hostel Details";
        
      }
      if ($sub_type == 'active_only') {
        $page_name .= '&nbsp&nbsp (Active only)';
      }else if ($sub_type == 'with_balance') {
        $page_name .= '&nbsp&nbsp (Active with balance)';
      }


    }else{ ?><script> alert('Please select details type'); window.location.href = 'export_student.php'; </script><?php  }
  }else{ ?><script> alert('Please select type'); window.location.href = 'export_student.php'; </script><?php }
}

?>


<!-- add adminheader.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

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

<main>

    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center">
                  <a class="white-text text-lighten-4" href="#"><?php echo $page_name; ?></a>
                </div>
            </div>
        </div>
    </div>              
        <div class="row">
          <div class="card">
              <div class="card-content">
                
              <div id="detailTable" class="scrollable" style="overflow: auto;">
            <table id="studentTable" class="display">

              <!-- ============== EXPORT TABLE FOR STUDENT DETAILS ======================-->
              <?php if( $export_type=="student_details" ){ ?>
              <thead>
              <tr>
                <th>S.N.</th>
                <th>Name</th>
                <th>Class</th>
                <th>Section</th>
                <th>Roll</th>
                <th>D.O.B</th>
                <th>Gender</th>
                <th>Email</th>
                <th>Address</th>
                <th>Parent</th>
                <th>Profession</th>
                <th>Number</th>
                <th>Admission Date</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $index = 1;
                            foreach ($studentList as $slist) {
              echo'<tr>
                  <td>' .$index. '</td>
                  <td>' . $slist->sname. '</td>
                  <td>' . $slist->class_name. '</td>
                  <td>' . $slist->section_name. '</td>
                  <td>' . $slist->sroll. '</td>
                  <td>' . (($login_date_type==2)? eToN($slist->dob) : $slist->dob). '</td>
                  <td>' . $slist->sex. '</td>
                  <td>' . $slist->semail. '</td>
                  <td>' . $slist->saddress. '</td>
                  <td>' . $slist->spname. '</td>
                  <td>' . $slist->spprofession. '</td>
                  <td>' . $slist->spnumber.(empty($slist->spnumber_2) ? "" :  ", ". $slist->spnumber_2).(empty($slist->smobile) ? "" :  ", ". $slist->smobile). '</td>
                  <td>' . (($login_date_type==2)? eToN($slist->admission_date) : $slist->admission_date). '</td>
                </tr>';
              $index++;
              }
                        ?>
            </tbody>



              <!-- ============== EXPORT TABLE FOR TRANSPORT DETAILS ======================-->
              <?php }else if( $export_type=="transport_details" ){ ?>
              <thead>
                <tr>
                  <th>S.N.</th>
                  <th>Name</th>
                  <th>Class</th>
                  <th>Roll No</th>
                  <th>Gender</th>
                  <th>Parent</th>
                  <th>Profession</th>
                  <th>Number</th>
                  <th>Address</th>
                  <th>Bus Status</th>
                  <th>Bus Number</th>
                  <th>Route/Stop</th>
                  <th>Fee rate</th>
                  <th>Balance</th>

                </tr>
              </thead>
              <tbody>
                <?php 
                  $index = 1;
                  foreach ($studentBusList as $sblist) { 

                    $balance = $backstage->get_pending_amount_by_feetype_title_sid("Bus Fee",$sblist->sid); 

                    if ($sub_type == 'active_only' && ( empty($sblist->bus_id ) || $sblist->bus_id == '0' ) ) {

                      continue;
                      
                    }else if ($sub_type == 'with_balance' && ( empty($sblist->bus_id ) || $sblist->bus_id == '0' || $balance < 1 ) ){
                      continue;
                    } ?>

                  <tr>
                    <td> <?php echo $index; ?> </td>
                    <td> <?php echo $sblist->sname; ?> </td>
                    <td> <?php echo $sblist->class_name.' - '.$sblist->section_name; ?> </td>
                    <td> <?php echo $sblist->sroll; ?> </td>
                    <td> <?php echo $sblist->sex; ?></td>
                    
                    <td> <?php echo (!empty($sblist->spname) ? $sblist->spname : "" ).((!empty($sblist->spname) && !empty($sblist->smname)) ? "," : "" ).(!empty($sblist->smname) ? $sblist->smname : ""); ?>
                    </td>
                    <td> <?php echo $sblist->spprofession; ?></td>
                    <td> <?php echo $sblist->spnumber.(empty($sblist->spnumber_2) ? "" :  ", ". $sblist->spnumber_2).(empty($sblist->smobile) ? "" :  ", ". $sblist->smobile); ?>
                    </td>
                    <td> <?php echo $sblist->saddress; ?> </td>

                    <td> <?php if ( empty($sblist->bus_id ) || $sblist->bus_id == '0' ) { echo "No"; }else{ echo "Yes"; }  ?> </td>
                    <td> <?php if ( empty($sblist->bus_number) ) { echo "-"; }else{ echo $sblist->bus_number; } ?> </td>
                    <td> <?php if ( empty($sblist->bus_route) ) { echo "-"; }else{ echo $sblist->bus_route; } if ( empty($sblist->bus_stop) ) { echo " -"; }else{ echo " : ".$sblist->bus_stop; } ?></td>
                    <td> <?php if ( empty($sblist->bus_fee_rate) ) { echo "-"; }else{ echo $sblist->bus_fee_rate; } ?>  </td>

                    <td> <?php if ( empty($balance) ) { echo "0"; }else{ echo $balance; } ?>  </td>
                  </tr>
                <?php $index++; } ?>
              </tbody>


              <!-- ============== EXPORT TABLE FOR HOSTEL DETAILS ======================-->
              <?php }else if($export_type=="hostel_details") { ?> 
                <thead>
                <tr>
                  <th>S.N.</th>
                  <th>Name</th>
                  <th>Class</th>
                  <th>Roll No</th>
                  <th>Gender</th>
                  <th>Parent</th>
                  <th>Profession</th>
                  <th>Number</th>
                  <th>Address</th>
                  <th>Hostel Status</th>
                  <th>Fee rate</th>
                  <th>Balance</th>

                </tr>
              </thead>
              <tbody>
                <?php 
                  $index = 1;
                  foreach ($studentList as $slist) { 
                  $balance = $backstage->get_pending_amount_by_feetype_title_sid("Hostel Fee",$slist->sid);

                    if ($sub_type == 'active_only' && ( empty($slist->hostel_fee ) || $slist->hostel_fee == '0' ) ) {

                      continue;
                      
                    }else if ($sub_type == 'with_balance' && ( empty($slist->hostel_fee ) || $slist->hostel_fee == '0' || $balance < 1 ) ){
                      continue;
                    } ?>

                  <tr>
                    <td> <?php echo $index; ?> </td>
                    <td> <?php echo $slist->sname; ?> </td>
                    <td> <?php echo $slist->class_name.' - '.$slist->section_name; ?> </td>
                    <td> <?php echo $slist->sroll; ?> </td>
                    <td> <?php echo $slist->sex; ?></td>
                    <td> <?php echo (!empty($slist->spname) ? $slist->spname : "" ).((!empty($slist->spname) && !empty($slist->smname)) ? "," : "" ).(!empty($slist->smname) ? $slist->smname : ""); ?>
                    </td>
                    <td> <?php echo $slist->spprofession; ?></td>
                    <td> <?php echo $slist->spnumber.(empty($slist->spnumber_2) ? "" :  ", ". $slist->spnumber_2).(empty($slist->smobile) ? "" :  ", ". $slist->smobile); ?>
                    <td> <?php echo $slist->saddress; ?></td>

                    <td> <?php if ( empty($slist->hostel_fee ) || $slist->hostel_fee == '0' ) { echo "No"; }else{ echo "Yes"; }  ?> </td>
                    <td> <?php if ( empty($slist->hostel_fee) ) { echo "-"; }else{ echo $slist->hostel_fee; } ?> </td>
                    

                    <td> <?php 

                     if ( empty($balance) ) { echo "0"; }else{ echo $balance; } ?>  </td>
                  </tr>
                <?php $index++; } ?>
              </tbody>
              <?php } ?>
            </table>
          </div>
        </div>
      </div>
        </div>
</main>


<?php include_once("../config/footer.php");?> 

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
