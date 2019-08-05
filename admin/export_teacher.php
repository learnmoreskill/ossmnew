
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'export_teacher';

$teacherList= json_decode($backstage->get_teacher_details());

?>



<!-- add adminheader.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

<script>

function loadScript() {

  $('#teacherTable').DataTable( {
      dom: 'Bfrtip',
      // "initComplete": function(settings, json) {
      //     $('.buttons-excel').click();
      // },
      buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
      ]
  } );
  $('#teacherTable').css({'max-width':$('#detailTable').width()+'px'})
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
                <div class="row center"><a class="white-text text-lighten-4" href="#">Teacher Details</a></div>
            </div>
        </div>
    </div>
    <section class = "container" style="width: 95%">              
            <div class="row">
            	<div class="card">
		            <div class="card-content">
		            	<div id="detailTable" class="scrollable" style="overflow: auto;">
							<table id="teacherTable" class="striped highlight centered responsive-table">
								<thead>
									<tr>
										<th>S.N.</th>
										<th>Teacher</th>
										<th>Email</th>
										<th>Address</th>
										<th>Phone</th>
										<th>D.O.B</th>
										<th>Gender</th>
										<th>Father Name</th>
										<th>Mother Name</th>
										<th>Marital Status</th>
										<th>Country</th>
										<th>Join Date</th>
										<th>Salary</th>
										<th>Job Type</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										$index = 1;
			                            foreach ($teacherList as $tlist) {
									echo'<tr>
											<td>' .$index. '</td>
											<td>' . $tlist->tname. '</td>
											<td>' . $tlist->temail. '</td>
											<td>' . $tlist->taddress. '</td>
											<td>' . $tlist->tmobile.((!empty($tlist->t_phone)) ? ",".$tlist->t_phone : ""). '</td>
											<td>' . (($login_date_type==2)? eToN($tlist->dob) : $tlist->dob). '</td>
											<td>' . $tlist->sex. '</td>
											<td>' . $tlist->t_father. '</td>
											<td>' . $tlist->t_mother. '</td>
											<td>' . $tlist->t_marital. '</td>
											<td>' . $tlist->t_country. '</td>
											<td>' . (($login_date_type==2)? eToN($tlist->t_join_date) : $tlist->t_join_date). '</td>
											<td>' . $tlist->tsalary. '</td>
											<td>' . $tlist->t_jobtype. '</td>
										</tr>';
									$index++;
									}
			                        ?>
								</tbody>
							</table>
						</div>
					</div>
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