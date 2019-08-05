<?php
	include('../config/config.php');
/* ======================================= Broadcast receiver details for =================== */
	if(isset($_REQUEST['broadcast_receiver'])){

		$id = $_GET['broadcast_receiver'];

		$result ="";

	 	$sqlsection = "SELECT `b_receiver`.`all_type`, `class`.`class_name` 
	 	FROM `b_receiver`
	 	LEFT JOIN `class` ON `b_receiver`.`class_id` = `class`.`class_id` 
	 	WHERE `b_receiver`.`broadcast_id`='$id'
	 	ORDER BY `b_receiver`.`class_id`";

	    $resultsection = $db->query($sqlsection);
	    $result = "";
	    while($row = $resultsection->fetch_assoc()) {
	    	if($row['all_type'] == 2 || $row['all_type'] == 5 || $row['all_type'] == 8 || $row['all_type'] == 9 || $row['all_type'] == 11 || $row['all_type'] == 12 || $row['all_type'] == 14 || $row['all_type'] == 15){ $p = "Parents"; }

	    	if($row['all_type'] == 1 || $row['all_type'] == 5 || $row['all_type'] == 6 || $row['all_type'] == 7 || $row['all_type'] == 11 || $row['all_type'] == 12 || $row['all_type'] == 13 || $row['all_type'] == 15){ $s = "Students"; }

		  $result .= "<span>".(($row['all_type']==3)? 'All Teacher' : (($row['all_type']==4)? 'All Staff' : 'Class: '.$row['class_name'].'&nbsp&nbsp '.$s.' '.$p))."</span><br>";
		}
		echo $result;

/* ======================================= Personal receiver details for =================== */
	}else if(isset($_REQUEST['personal_receiver'])){

		$id = $_GET['personal_receiver'];

		$result ="";

	 	$sqlsection = "SELECT `bp_receiver`.`r_role`, `studentinfo`.`sname`, `teachers`.`tname`, `staff_tbl`.`staff_name`
	 	FROM `bp_receiver`
	 	LEFT JOIN `studentinfo` ON `bp_receiver`.`r_id` = `studentinfo`.`sid`
	 	LEFT JOIN `teachers` ON `bp_receiver`.`r_id` = `teachers`.`tid`
	 	LEFT JOIN `staff_tbl` ON `bp_receiver`.`r_id` = `staff_tbl`.`stid`
	 	WHERE `bp_receiver`.`broadcast_id`='$id' ";

	    $resultsection = $db->query($sqlsection);
	    $result = "";
	    $name = "";
	    while($row = $resultsection->fetch_assoc()) {

	    	if($row['r_role'] == 3){ $type = "Students"; }
	    	else if($row['r_role'] == 4){ $type = "Parents"; }
	    	else if($row['r_role'] == 2){ $type = "Teachers"; }
	    	else if($row['r_role'] == 5){ $type = "Staff"; }

	    	if($row['r_role'] == 3 || $row['r_role'] == 4){ $name .= "<span>".$row['sname']."</span><br>"; }
	    	else if($row['r_role'] == 2){ $name .= "<span>".$row['tname']."</span><br>"; }
	    	else if($row['r_role'] == 5){ $name .= "<span>".$row['staff_name']."</span><br>"; }

		  
		}
		$result = "<span style='font-size: 19px;'>".$type."</span><br><div class='divider'></div>".$name;
		echo $result;

/* ======================================= All Teacher Unselected =================== */
	}else if(isset($_REQUEST['allteacherUnselected'])){

		$result ="";

	 	$sql = "SELECT `teachers`.`tid`, `teachers`.`tname` 
	 	FROM `teachers`
	 	WHERE `teachers`.`status` = 0
	 	ORDER BY `teachers`.`tname`";

	    $resultsql = $db->query($sql);
	    $result = "<option value='' disabled>Select Teacher</option>";
	    while($row1 = $resultsql->fetch_assoc()) {

		  $result .= "<option value='".$row1['tid']."' >".$row1['tname']."</option>";
		}
		echo $result;

/* ======================================= All staff Unselected =================== */
	}else if(isset($_REQUEST['allstaffUnselected'])){

		$result ="";

	 	$sql = "SELECT `staff_tbl`.`stid`, `staff_tbl`.`staff_name` 
	 	FROM `staff_tbl`
	 	WHERE `staff_tbl`.`staff_status` = 0
	 	ORDER BY `staff_tbl`.`staff_name`";

	    $resultsql = $db->query($sql);
	    $result = "<option value='' disabled>Select Staff</option>";
	    while($row1 = $resultsql->fetch_assoc()) {

		  $result .= "<option value='".$row1['stid']."' >".$row1['staff_name']."</option>";
		}
		echo $result;

/* ============================ All student by section id unselected =================== */
	}else if(isset($_REQUEST['studentBySectionUnselected'])){

		$sectionid = $_GET['studentBySectionUnselected'];
		$year_id = $_GET['year_id'];

		$result ="";

	 	$sqlsection = "SELECT `studentinfo`.`sid`, `studentinfo`.`sroll`, `studentinfo`.`sname` 
	 	FROM `studentinfo`  
	 	INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
	 	WHERE  `syearhistory`.`year_id`='$year_id' AND `syearhistory`.`section_id`='$sectionid' AND `studentinfo`.`status` = 0
	 	ORDER BY `syearhistory`.`roll_no`";

	    $resultsection = $db->query($sqlsection);
	    $result = "<option value='' disabled>Select Student</option>";
	    while($row1 = $resultsection->fetch_assoc()) {

		  $result .= "<option value='".$row1['sid']."' >".$row1['sroll']."&nbsp&nbsp".$row1['sname']."</option>";
		}
		echo $result;
/* ============================ All student by section id Selected =================== */
	}else if(isset($_REQUEST['studentBySectionSelected'])){

		$sectionid = $_GET['studentBySectionSelected'];
		$year_id = $_GET['year_id'];

		$result ="";

	 	$sqlsection = "SELECT `studentinfo`.`sid`, `studentinfo`.`sroll`, `studentinfo`.`sname` 
	 	FROM `studentinfo`
	 	INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
	 	WHERE  `syearhistory`.`year_id`='$year_id' AND `syearhistory`.`section_id`='$sectionid' AND `studentinfo`.`status` = 0
	 	ORDER BY `syearhistory`.`roll_no`";

	    $resultsection = $db->query($sqlsection);
	    $result = "<option value='' disabled>Select Student</option>";
	    while($row1 = $resultsection->fetch_assoc()) {

		  $result .= "<option value='".$row1['sid']."' selected >".$row1['sroll']."&nbsp&nbsp".$row1['sname']."</option>";
		}
		echo $result;
/* =============================== All student by class id unselected =================== */
	}else if(isset($_REQUEST['studentByClassUnselected'])){

		$classid = $_GET['studentByClassUnselected'];
		$year_id = $_GET['year_id'];

		$result ="";

	 	$sqlsection = "SELECT `studentinfo`.`sid`, `studentinfo`.`sroll` , `studentinfo`.`sname` 
	 	FROM `studentinfo`  
	 	INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
	 	WHERE `syearhistory`.`year_id`='$year_id' AND `syearhistory`.`class_id`='$classid' AND `studentinfo`.`status` = 0
	 	ORDER BY `syearhistory`.`section_id`,`syearhistory`.`roll_no`";

	    $resultsection = $db->query($sqlsection);
	    $result = "<option value='' disabled>Select Student</option>";
	    while($row1 = $resultsection->fetch_assoc()) {

		  $result .= "<option value='".$row1['sid']."' >".$row1['sroll']."&nbsp&nbsp".$row1['sname']."</option>";
		}
		echo $result;

/* =============================== All student by class id Selected =================== */
	}else if(isset($_REQUEST['studentByClassSelected'])){

		$class_id = $_GET['studentByClassSelected'];
		$year_id = $_GET['year_id'];

		$result ="";

	 	$sqlsection = "SELECT `studentinfo`.`sid`, `studentinfo`.`sroll`, `studentinfo`.`sname` 
	 	FROM `studentinfo` 
	 	INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
	 	WHERE  `syearhistory`.`year_id`='$year_id' AND `syearhistory`.`class_id`='$class_id' AND `studentinfo`.`status` = 0
	 	ORDER BY `syearhistory`.`section_id`,`syearhistory`.`roll_no`";

	    $resultsection = $db->query($sqlsection);
	    $result = "<option value='' disabled>Select Student</option>";
	    while($row1 = $resultsection->fetch_assoc()) {

		  $result .= "<option value='".$row1['sid']."' selected >".$row1['sroll']."&nbsp&nbsp".$row1['sname']."</option>";
		}
		echo $result;

/* =============================== Promotion Old Student =================== */
	}else if(isset($_REQUEST['oldStudentPromotion'])){

		$year_id = $_GET['oldStudentPromotion'];
		$section_id = $_GET['section_id'];

    	$resultstd = $db->query("SELECT `sid`,`sname`,`sroll` ,`syearhistory`.`syear_id`
    			FROM `studentinfo` 

    			INNER JOIN `syearhistory` ON `studentinfo`.`sid`=`syearhistory`.`student_id` AND `studentinfo`.`batch_year_id`=`syearhistory`.`year_id`

    			WHERE `ssec` = '$section_id'  AND `batch_year_id` = '$year_id' AND `studentinfo`.`status`='0' ORDER BY `sroll` ");

    	$rowCount = mysqli_num_rows($resultstd); ?>

    	<input type="hidden" name="rowno" value="<?php echo $rowCount; ?>">

    	<?php 
    	if ($rowCount >=1) { ?>
			<h5 class="center">Student list to be promoted</h5>
	        <table class="centered bordered striped highlight z-depth-4">
	          <thead>
	              <th>No.</th>
	              <th>Roll No</th>
	              <th>Student Name</th>
	              <th>New Roll No(change)</th>
	              <th>Remove/Select</th>
	          </thead>
	          <tbody>
	            
	             <?php $count = 1; while($row3 = $resultstd->fetch_assoc()) { ?>

	                <tr>
	                <td >
	                    <input   name="sid[<?php echo $count; ?>]"  type="hidden" value="<?php echo $row3["sid"];?>">
	                    <?php echo $count; ?>
	                    
	                </td>
	                <td>
	                  <?php echo $row3["sroll"]; ?>
	                </td>
	                <td id="sname<?php echo $count; ?>" >
	                    <?php echo $row3["sname"]; ?>                      
	                </td>
	                <td class="cPaddingLR" style="width: 200px">
	                    <input class="no-margin" name="roll_no[<?php echo $count; ?>]" type="text" id="roll_no<?php echo $count; ?>"  required  value="<?php echo $row3['sroll']; ?>" >                          
	                </td>
	                <td>
	                    <div class="switch">
	                      <label>
	                        <input class="mrrorbot1" id="<?php echo $count; ?>" onclick="disableStudent(this.id)" type="checkbox" name="selectstd[<?php echo $count; ?>]" 
	                        <?php echo (  (isset($_GET["token"]) && $_GET["token"] == "amu8x008")? 
	                                        ( ($row["marksheet_id"] )?  'checked' : '' ) 
	                                        : 'checked');  ?> 

	                        >
	                        <span class="lever"></span>
	                      </label>
	                    </div>                          
	                </td>
	                </tr>
	            <?php $count++;  } ?>
	            </tbody>
	        </table> <?php
	    }else{ ?>

	    	<h5 class="center">Student list not found!! </h5>
			<?php 
	    }
/* =============================== Promotion New Student =================== */
	}else if(isset($_REQUEST['newStudentPromotion'])){

		$year_id = $_GET['newStudentPromotion'];
		$section_id = $_GET['section_id'];

    	$resultstd = $db->query("SELECT `sid`,`sname`,`sroll`
    			FROM `studentinfo`
    			WHERE `ssec` = '$section_id'  AND `batch_year_id` = '$year_id' AND `studentinfo`.`status`='0' ORDER BY `sroll` ");

    	$rowCount = mysqli_num_rows($resultstd);
    	if ($rowCount >=1) {
			?>
			<h5 class="center">Already promoted student(Student Count : <?php echo $rowCount; ?>)</h5>
	        <table class="centered bordered striped highlight z-depth-4">
	          <thead>
	              <th>No.</th>
	              <th>Roll No.</th>
	              <th>Student Name</th>
	          </thead>
	          <tbody>
	             <?php $count = 1; while($row3 = $resultstd->fetch_assoc()) { ?>

	                <tr>
	                <td >
	                    <?php echo $count; ?>
	                </td>
	                <td>
	                  <?php echo $row3["sroll"]; ?>
	                </td>
	                <td>
	                    <?php echo $row3["sname"]; ?>                      
	                </td>
	                </tr>
	            <?php $count++;  } ?>
	            </tbody>
	        </table>
			<?php

		}else{ ?>
			<h5 class="center">Currently student list is empty </h5>
			<?php 
		}


	}

	exit;
 

?>
