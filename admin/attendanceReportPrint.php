<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();


/* GET Request */

if($_SERVER['REQUEST_METHOD']=='POST') {

    if (isset($_POST['generate_attendance_report'])) {

    	$year_id = $_POST['year_id'];
    	$reportFor = $_POST['reportFor'];
    	$monthwise = $_POST['monthwise'];
    	$classwise = $_POST['classwise'];

    	if ($reportFor == 'student') {

    		$class_id = $_POST['class_id'];
    		$section_id = $_POST['section_id'];

    		$session_n_year = $backstage->get_academic_single_year_by_year_id($year_id);

    		$months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra');


    		if ($monthwise == 'monthwise') {

    			$month_id = $_POST['month_id'];

    			

    			$setEDate = nToE($session_n_year.'-'.$month_id.'-02');

    			include('../linker/getStartEndDate.php');
    			list($show_s_y, $show_s_m, $show_s_d) = explode('-', $snd);
    			list($show_e_y, $show_e_m, $show_e_d) = explode('-', $end);


    			if ($classwise == 'classwise') {

    				$className = $backstage->get_class_name_by_id($class_id);
    				if (!empty($section_id)) {
    					$sectionName = $backstage->get_section_name_by_id($section_id);
    				}
    		
    				$studentList = json_decode($backstage->get_all_student_details_by_class_section_id_year_id($class_id,$section_id,$year_id));

	    			$queryAR = $db->query("SELECT aid,asid,astatus,`aclock` 
	    				FROM `attendance` 
	    				INNER JOIN `syearhistory` ON `attendance`.`asid` = `syearhistory`.`student_id` 
	    				WHERE  (`aclock` BETWEEN '$sed' AND '$eed') AND `attendance`.`year_id` = '$year_id' " . (empty($class_id) ? "" : "AND `syearhistory`.`class_id`='$class_id' ") . (empty($section_id) ? "" : "AND `syearhistory`.`section_id`='$section_id' ") . " AND `syearhistory`.`year_id` = '$year_id' ");

		    		while($rowAR = $queryAR->fetch_assoc()){

		    			$ndate = eToN($rowAR['aclock']);
		    			list($ndateyear, $ndatemonth, $ndateday) = explode('-', $ndate);

				        $s_a_array[$rowAR["asid"]][$ndateday+0] = $rowAR["astatus"];
				    }
				}else if ($classwise == 'studentwise'){
					echo 'studentwise';

				}
    			
    		}elseif ($monthwise == 'yearwise') {

    			$className = $backstage->get_class_name_by_id($class_id);
				if (!empty($section_id)) {
					$sectionName = $backstage->get_section_name_by_id($section_id);
				}

				$studentList = json_decode($backstage->get_all_student_details_by_class_section_id_year_id($class_id,$section_id,$year_id));

				for ($x = 1; $x <= 12; $x++) {

					$setEDate = nToE($session_n_year.'-'.$x.'-02');

					include('../linker/getStartEndDate.php');
    				list($show_s_y, $show_s_m, $show_s_d) = explode('-', $snd);
    				list($show_e_y, $show_e_m, $show_e_d) = explode('-', $end);

    				$queryAR = $db->query("SELECT `asid`,`astatus`,`aclock`,COUNT(*) AS `count` 
	    				FROM `attendance` 
	    				INNER JOIN `syearhistory` ON `attendance`.`asid` = `syearhistory`.`student_id` 
	    				WHERE  (`aclock` BETWEEN '$sed' AND '$eed') AND `attendance`.`year_id` = '$year_id' " . (empty($class_id) ? "" : "AND `syearhistory`.`class_id`='$class_id' ") . (empty($section_id) ? "" : "AND `syearhistory`.`section_id`='$section_id' ") . " AND `syearhistory`.`year_id` = '$year_id'
	    				GROUP BY `asid` , `astatus` ");

		    		while($rowAR = $queryAR->fetch_assoc()){

		    			$ndate = eToN($rowAR['aclock']);
		    			list($ndateyear, $ndatemonth, $ndateday) = explode('-', $ndate);

				        if ($rowAR["astatus"] == 'A') {
				        	$s_a_a_array[$rowAR["asid"]][$ndatemonth+0] = $rowAR["count"];
				        }else{
				        	$s_a_p_array[$rowAR["asid"]][$ndatemonth+0] = $rowAR["count"];
				        }
				    }
					
				}


    		
    		}


    	}
	}
}



?>
<!DOCTYPE html>
<html>
	<head>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
		<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
		<style type="text/css">
			#printBtn{
					position: fixed;
					top: 10px;
					right: 10px;
				    padding: 0 5px;
				}
			@media print{
				#printBtn{
					display: none;
				}
				 @page {
			      size: A4; /* DIN A4 standard, Europe */
			      margin:0;
			      size: landscape;
			    }
			}
			.removeTdPad>td,.removeTdPad>th{
				padding: 3px;
			}
		</style>
	</head>
	<body>
		<div id="attMonth" style="padding: 5px 12px">
			<button onclick="printTable('attMonth')" id="printBtn" class="waves-effect waves-light btn"><i class="material-icons left " style="margin: 0">print </i> Print</button>
			<h5 class="center">
				<?php echo (($monthwise == 'monthwise')? 'Monthly Attendance report' : 'Yearly Attendance Report') ?>
			</h5>
			<div class="row " style="margin: 0">
				<div class="col s4">
					Class : <?php echo (($className)? $className : 'All classes'); ?> <br>
					<?php if(!empty($section_id)){
						echo 'Section : '.$sectionName;
					} ?>
				</div>
				<div class="col s4">
					<?php if($monthwise == 'monthwise'){ ?>
					Month : <?php echo $months[$month_id-1].' ('.$session_n_year.')'; ?>
					<?php }elseif ($monthwise == 'yearwise') { ?>
						Year : <?php echo $session_n_year; ?> 
					<?php } ?>

					<br>
				</div>
				<div class="col s4">
					Print Date : <?php  echo $login_today_date.' '.date("g:i A"); ?> <br>
					
					
				</div>
			</div>
			<hr style="margin: 0">
			<table class="responsive-table striped">
		        <thead>
		          <tr class="removeTdPad">
		          	  <th>Roll</th>
		              <th>Name/Date</th>
		              <?php 
		              	if ($monthwise == 'monthwise') {
		              	
							for ($x = $show_s_d+0; $x <= $show_e_d; $x++) {
						    	echo "<th>$x</th>";
							}

						}else if($monthwise == 'yearwise'){

							for ($x = 1; $x <= 12; $x++) {
						    	echo "<th>".$months[$x-1]."</th>";
							}

						}
						?>
		              <th>Remark</th>

		          </tr>
		        </thead>

		        <tbody>
		        	<?php
		        	if ($studentList){
           				foreach ($studentList as $key){
           					$pCount = 0;
           					$tCount = 0;

			          		echo "<tr class='removeTdPad'>
			          		<td>$key->sroll</td>
			          		<td>$key->sname</td>";


			          		if ($monthwise == 'monthwise') {

								for ($x = $show_s_d+0; $x <= $show_e_d; $x++) {

									if ($s_a_array[$key->sid][$x] == 'A') {
									 	$tCount++;
									 	echo "<th class='red-text text-darken-2'>A</th>";
									}else if($s_a_array[$key->sid][$x] == 'P'){
									 	$pCount++;
									 	$tCount++;
									 	echo "<td>P</td>";
									}else{
									 	echo "<td>-</td>";
									}
								} 
			            
			            		echo "<td class='blue-text text-darken-2'>".$pCount."/".$tCount."</td></tr>";

			            	}else if($monthwise =='yearwise'){

			            		for ($x = 1; $x <= 12; $x++) {

			            			$pDays = $s_a_p_array[$key->sid][$x];
			            			$pCount += $pDays;
			            			$monthDays = $s_a_a_array[$key->sid][$x] + $pDays;
			            			$tCount += $monthDays;



			            			echo "<td>".(($monthDays)? (($pDays)? $pDays."/".$monthDays: '-/'.$monthDays) : '-')."</td>";
								} 
			            
			            		echo "<td class='blue-text text-darken-2'>".$pCount."/".$tCount."</td></tr>";

			            	}
		        		}
		    		}
						?>

		        </tbody>
		    </table>
		</div>

		<script type="text/javascript">
			function printTable(id){
				// var prtContent = document.getElementById(id);
				// var WinPrint = window.open('', '', '');
				// WinPrint.document.write(prtContent.innerHTML);
				// WinPrint.document.close();
				// WinPrint.focus();
				// WinPrint.print();
				// WinPrint.close();

				window.print();
			}
		</script>
	</body>
</html>