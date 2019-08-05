
<?php
	//include connection file 
	include_once("session.php");

	if (isset($_GET["activestudent"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'sadmsnno',
			1 =>'sroll', 
			2 => 'sname',
			3 => 'sex',
			4 => 'sclass',
			5 => 'saddress',
			6 => 'spname'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sadmsnno LIKE '".$params['search']['value']."%' ";    
			$where .=" OR sname LIKE '".$params['search']['value']."%' ";

			$where .=" OR spname LIKE '".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `studentinfo`.* , `parents`.* , `class`.`class_name`, `section`.`section_name` FROM `studentinfo` 
			LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
			LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
			LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` 
			WHERE `studentinfo`.`status`= 0 ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}

	 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']."  ";

		$queryTot = mysqli_query($db, $sqlTot) or die("database error:". mysqli_error($db));


		$totalRecords = mysqli_num_rows($queryTot);

		$queryRecords = mysqli_query($db, $sqlRec) or die("error to fetch list". mysqli_error($db));

		//iterate on results row and create new index array of data
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			//$data[] = $row;

			array_push($response,array(
					$row['sadmsnno'],
					$row['sroll'],
					$row['sname'],
					$row['sex'],
					$row['class_name']." ".$row["section_name"],
					$row['saddress'],
					$row['spname'],
					"Active",
					"<a href='studentdetailsdescription.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@".$row["sid"]."'>
						<div title='information' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
							<i class='material-icons'>
								info_outline
							</i>
						</div>
					</a>
					<a href='viewmarksheet.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@".$row["sid"]."'>
						<div title='markshet of student' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
							<i class='material-icons orange-text text-lighten-1'>
								timeline
							</i>
						</div>
					</a>


	                <a href='admitstudent.php?token=2ec9ys77bi8939&key=ae25nj53sfr596dg@".$row["sid"]."'>
	                	<div title='edit' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
	                		<i class='material-icons green-text text-lighten-1'>
	                			edit
	                		</i>
	                	</div>
	                </a>
	                <a href='deleteuserscript.php?token=5ftgy76fgh4esw&key=ae25nJ5s3fr596dg@".$row["sid"]."' onclick = 'return confirm(\"Are you sure want to delete?\")' >
	                	<div title='delete' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
	                		<i class='material-icons red-text text-darken-4'>
	                			delete
	                		</i>
	                	</div>
	                </a>",
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format
	}elseif (isset($_GET["inactivestudent"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'sadmsnno',
			1 =>'sroll', 
			2 => 'sname',
			3 => 'sex',
			4 => 'sclass',
			5 => 'saddress',
			6 => 'spname'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sadmsnno LIKE '".$params['search']['value']."%' ";    
			$where .=" OR sname LIKE '".$params['search']['value']."%' ";

			$where .=" OR spname LIKE '".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `studentinfo`.* , `parents`.* , `class`.`class_name`, `section`.`section_name` FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` WHERE `studentinfo`.`status`<> 0 ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}

	 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']."  ";

		$queryTot = mysqli_query($db, $sqlTot) or die("database error:". mysqli_error($db));


		$totalRecords = mysqli_num_rows($queryTot);

		$queryRecords = mysqli_query($db, $sqlRec) or die("error to fetch list". mysqli_error($db));

		//iterate on results row and create new index array of data
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			//$data[] = $row;

			array_push($response,array(
					$row['sadmsnno'],
					$row['sroll'],
					$row['sname'],
					$row['sex'],
					$row['class_name']." ".$row["section_name"],
					$row['saddress'],
					$row['spname'],
					(($row['status']==1) ? 'Left' : '').(($row['status']==2) ? 'Passed out' : ''),
					"<a href='studentdetailsdescription.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@".$row["sid"]."'>
						<div title='information' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
							<i class='material-icons'>
								info_outline
							</i>
						</div>
					</a>
					<a href='viewmarksheet.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@".$row["sid"]."'>
						<div title='markshet of student' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
							<i class='material-icons orange-text text-lighten-1'>
								timeline
							</i>
						</div>
					</a>


	                <a href='admitstudent.php?token=2ec9ys77bi8939&key=ae25nj53sfr596dg@".$row["sid"]."'>
	                	<div title='edit' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
	                		<i class='material-icons green-text text-lighten-1'>
	                			edit
	                		</i>
	                	</div>
	                </a>
	                <a href='deleteuserscript.php?token=6yugyf67gh4esw&key=ae25nJ5s3fr596dg@".$row["sid"]."' onclick = 'return confirm(\"Are you sure want to re-active?\")' >
                		<div title='re-active' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
                    		<i class='material-icons teal-text text-darken-4'>
                        		autorenew
                    		</i>
                		</div>
            		</a>",
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format


	}
?>
	