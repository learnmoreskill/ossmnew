<?php
    
	include('session.php');
    require("../important/backstage.php");

    $backstage = new back_stage_class(); 

	$class_id = $_GET['class'];
	$section_id = $_GET['section']; 
	$subjectID = $_GET['subjectID'];

    $planned_lession = json_decode($backstage->get_planned_lession_by_class_section_subject_id($class_id,$section_id,$subjectID));
    ?>
    
    <table id="tableName1" class="striped highlight centered responsive-table">
    	<thead>
            <tr>
        		<th>SN</th>
        		<th>Class</th>
        		<th>Section</th>
        		<th>Subject</th>
        		<th>Topic</th>
        		<th>Teacher</th>
        		<th>Start Date</th>
        		<th>End Date</th>
        		<th>Completion(%)</th>
        		<th>Assigned By</th>
            </tr>
    	</thead>
    	<tbody>
    	<?php
    	$index = 1;
	    	foreach ($planned_lession as $lession) {
    		?>
    		<tr>
    			<td><?php echo $index; ?></td>
	    		<td><?php echo $lession->class_name; ?></td>
	    		<td><?php echo $lession->section_name; ?></td>
	    		<td><?php echo $lession->subject_name; ?></td>
	    		<td><?php echo $lession->topic; ?></td>
	    		<td><?php echo $lession->tname; ?></td>
	    		<td><?php echo (($login_date_type==2)? eToN($lession->start_date) : $lession->start_date); ?></td>
	    		<td><?php echo (($login_date_type==2)? eToN($lession->end_date) : $lession->end_date); ?></td>
	    		<td><?php echo $lession->percentage; ?></td>
	    		<td><?php echo $lession->pname; ?></td>
    		</tr>
	  		<?php
	  		$index++;
			}
    	?>
    	</tbody>
    </table>

<?php
 exit;
 ?>
