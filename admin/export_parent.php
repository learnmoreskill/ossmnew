
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'export_parent';


$parentList= json_decode($backstage->get_all_active_parent_details());

?>


<!-- add adminheader.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

<script>

function loadScript() {

  $('#parentTable').DataTable( {
      dom: 'Bfrtip',
      // "initComplete": function(settings, json) {
      //     $('.buttons-excel').click();
      // },
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
  } );
  $('#parentTable').css({'max-width':$('#detailTable').width()+'px'})
  }
  
xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
              document.getElementById("detailTable").innerHTML = this.responseText;
              process.nextTick(loadScript());
              //selectDropdown.trigger('contentChanged');
          }
      };
</script>

<main>
    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center"><a class="white-text text-lighten-4" href="#">Student Details</a></div>
            </div>
        </div>
    </div>
    <section class = "container" style="width: 95%">              
            <div class="row"><br><br>
            	<div id="detailTable" class="scrollable" style="overflow: auto;">
				<table id="parentTable" class="striped highlight centered responsive-table">
					<thead>
						<tr>
							<th>S.N.</th>
							<th>Parent</th>
							<th>Mother</th>
							<th>Email</th>
							<th>Phone No.</th>
							<th>Address</th>
							<th>Profession</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$index = 1;
                            foreach ($parentList as $plist) {
						echo'<tr>
								<td>' .$index. '</td>
								<td>' . $plist->spname. '</td>
								<td>' . $plist->smname. '</td>
								<td>' . $plist->spemail. '</td>
								<td>' . $plist->spnumber.(empty($plist->spnumber_2) ? "" :  ", ". $plist->spnumber_2). '</td>
								<td>' . $plist->sp_address. '</td>
								<td>' . $plist->spprofession. '</td>
							</tr>';
						$index++;
						}
                        ?>
					</tbody>
				</table>
				</div>
            </div>

    </section>
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
 <script>
	loadScript();
 </script>

