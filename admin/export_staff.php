<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'export_staff';

if (isset($_GET["token"]) && $_GET["token"] == 'export_staff_details' ){ ?>

  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">

  <?php

  $page_name = '';

  $export_type = $_GET['export_type'];
  $status = $_GET['status'];

  if (!empty($export_type)) {

    $staffList= json_decode($backstage->get_staff_details_by_staff_type_and_status($export_type,$status));

      $page_name = "Staff Details for ".$export_type;

      if ($status == '0') {
        $page_name .= '&nbsp&nbsp (Active only)';
      }else if ($status == '1') {
        $page_name .= '&nbsp&nbsp (Inactive only)';
      }


  }else{ ?><script> alert('Please select staff type'); window.location.href = 'export_staff.php'; </script><?php }
}

?>


<!-- add adminheader.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

<?php if (isset($_GET["token"]) && $_GET["token"] == 'export_staff_details' ){ ?>

  <script>
    function loadScript() {

      $('#detailTableId').DataTable( {
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
      $('#detailTableId').css({'max-width':$('#detailTable').width()+'px'})
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

<?php } ?>

<main>

    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center">
                  <a class="white-text text-lighten-4" href="#"><?php if (isset($_GET["token"]) && $_GET["token"] == 'export_staff_details' ){ echo $page_name; }else{ echo "Staff Details"; } ?>
                  </a>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_GET["token"]) && $_GET["token"] == 'export_staff_details' ){ ?>
      <div class="row">
        <div class="card">
          <div class="card-content">

            <?php if (count((array)$staffList)>0) { ?>
            
                  
            <div id="detailTable" class="scrollable" style="overflow: auto;">
              <table id="detailTableId" class="display">

                <!-- ============== EXPORT TABLE FOR STAFF DETAILS ======================-->
                <thead>
                  <tr>
                    <th>S.N.</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Position</th>
                    <th>Mobile</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Nationality</th>
                    <th>Salary</th>
                    <th>Status</th>

                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $index = 1;
                    foreach ($staffList as $slist) { 

                      
                      /*if ($sub_type == 'active_only' && ( empty($sblist->bus_id ) || $sblist->bus_id == '0' ) ) {

                        continue;
                        
                      }else if ($sub_type == 'with_balance' && ( empty($sblist->bus_id ) || $sblist->bus_id == '0' || $balance < 1 ) ){
                        continue;
                      }*/ ?>

                    <tr>
                      <td> <?php echo $index; ?> </td>
                      <td> <?php echo $slist->staff_name; ?> </td>
                      <td> <?php echo $slist->staff_type; ?> </td>
                      <td> <?php echo $slist->staff_position; ?></td>
                      
                      <td> <?php echo (!empty($slist->staff_mobile) ? $slist->staff_mobile : "" ).((!empty($slist->staff_mobile) && !empty($slist->staff_phone)) ? "," : "" ).(!empty($slist->staff_phone) ? $slist->staff_phone : ""); ?>
                      </td>
                      <td> <?php echo $slist->staff_email; ?></td>
                      <td> <?php echo $slist->staff_address; ?></td>
                      <td> <?php echo $slist->staff_country; ?></td>
                      <td> <?php echo $slist->staff_salary; ?></td>
                      
                      <td> <?php if ($slist->staff_status == 0 ) { echo "Active"; }else if($slist->staff_status == 1){ echo "Inactive"; } ?> </td>
                    </tr>
                  <?php $index++; } ?>
                </tbody>

              </table>
            </div>
            <?php }else{ ?>
              <div class="center">
                Sorry, Not found any details..
              </div>

            <?php } ?>
          </div>
        </div>
      </div>




    <?php }else{ ?>
      <div class="row">
        <form action="export_staff.php" method="GET" class="col s12" >
            <div class="row">
                <div class="input-field col s8 m8">
                    <select id="export_type" name="export_type">

                      <option value="all" >All</option>

                      <option value="Principal">Principal</option>
                      <option value="Asst. Principal">Asst. Principal</option>
                      <option value="Administrator" >Administrator</option>
                      <option value="Coordinator" >Coordinator</option>
                      <option value="Exam Controller" >Exam Controller</option>
                      <option value="Accountant">Accountant</option>
                      <option value="Librarian">Librarian</option>
                      <option value="Store Keeper">Store Keeper</option>
                      <option value="Driver">Driver</option>
                      <option value="Lab boy">Lab boy</option>
                      <option value="Reception">Reception</option>
                      <option value="Peon">Peon</option>
                      <option value="Canteen">Canteen</option>
                      <option value="Guard">Guard</option>
                      <option value="Other">Other</option>

                    </select>
                    <label>Select staff type:</label>
                </div>

                <div class="input-field col s4 m4">
                    <select id="status" name="status">

                      <option value="all" >All</option>
                      <option value="0" selected >Active Only</option>
                      <option value="1" >Inactive Only</option>

                    </select>
                    <label>Select Active/Inactive:</label>
                </div>
            </div>
            
            <div class="row">
              <div class="input-field col m2">
                <input type="hidden" name="token" value="export_staff_details">
                <button class="btn waves-effect waves-light" type="submit">Submit
                        <i class="material-icons right">send</i>
                </button>
              </div>
            </div>

        </form>
      </div>
  <?php } ?>
</main>


<?php include_once("../config/footer.php");?> 

<?php if (isset($_GET["token"]) && $_GET["token"] == 'export_staff_details' ){ ?>

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
<?php }  ?>
