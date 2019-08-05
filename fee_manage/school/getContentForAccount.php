<?php
	//include connection file 
	include_once("../session.php");



/* ======================================= Parents active =================== */
	if (isset($_GET["parent"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'spname',
			1 =>'smname', 
			2 => 'spnumber',
			3 => 'spprofession',
			4 => 'sp_address'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( spname LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR smname LIKE '%".$params['search']['value']."%' ";

			$where .=" OR spnumber LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT * FROM `parents` WHERE `spstatus` = 0 ";
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
					$row['spname'],
					$row['smname'],
					$row['spnumber'],
					$row['spprofession'],
					$row['sp_address'],
					"<a href='parent.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@".$row["parent_id"]."'>
		                <div title='information' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
		                    <i class='material-icons'>
		                        info_outline
		                    </i>
		                </div>
		            </a>
		            ".(($login_cat == 1 || $pac['edit_student'])? "<a  href='admitstudent.php?token=2ecpoij7bi8939&key=ae25nj53sfr596dg@".$row["parent_id"]."'> 
		                <div title='edit' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
		                    <i class='material-icons green-text text-lighten-1'>
		                        edit
		                    </i>
		                </div>
		            </a>":"")."

		            ".(($login_cat == 1 || $pac['edit_student'])? "<a href='deleteuserscript.php?token=fd5576t7ygr56&key=ae25nJ5s3fr596dg@".$row["parent_id"]."' onclick = 'return confirm(\"Are you sure want to delete?\")' >
		                <div title='delete' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'> 
		                    <i class='material-icons red-text text-darken-4'>
		                        delete
		                    </i>
		                </div>
		            </a>":"")."",
							
					
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format

/* ======================================= Inactive Parents active =================== */
	}else if (isset($_GET["inactive_parent"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'spname',
			1 =>'smname', 
			2 => 'spnumber',
			3 => 'spprofession',
			4 => 'sp_address'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( spname LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR smname LIKE '%".$params['search']['value']."%' ";

			$where .=" OR spnumber LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT * FROM `parents` WHERE `spstatus` <> 0 ";
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
					$row['spname'],
					$row['smname'],
					$row['spnumber'],
					$row['spprofession'],
					$row['sp_address'],
					"<a href='parent.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@".$row["parent_id"]."'>
		                <div title='information' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
		                    <i class='material-icons'>
		                        info_outline
		                    </i>
		                </div>
		            </a>
		            ".(($login_cat == 1 || $pac['edit_student'])? "<a  href='admitstudent.php?token=2ecpoij7bi8939&key=ae25nj53sfr596dg@".$row["parent_id"]."'> 
		                <div title='edit' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
		                    <i class='material-icons green-text text-lighten-1'>
		                        edit
		                    </i>
		                </div>
		            </a>":"")."

		            ".(($login_cat == 1 || $pac['edit_student'])? "<a href='deleteuserscript.php?token=2ecpoactivebi8939&key=ae25nj53sfr596dg@".$row["parent_id"]."' onclick = 'return confirm(\"Are you sure want to re-active?\")' >
                		<div title='re-active' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
                    		<i class='material-icons teal-text text-darken-4'>
                        		autorenew
                    		</i>
                		</div>
            		</a>":"")."",
							
					
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format

/* =============================== Active all student for admin =================== */
	}else if (isset($_GET["activestudent"])){
		// initilize all variable
		$class_id = $_POST['class_id'];
		$section_id = $_POST['section_id'];


		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'sadmsnno',
			1 =>'sroll', 
			2 => 'sname',
			3 => 'sclass',
			4 => 'sex',
			5 => 'saddress',
			6 => 'spname',
			7 => 'spnumber'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sadmsnno LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR sname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR semail LIKE '%".$params['search']['value']."%' ";

			$where .=" OR spname LIKE '%".$params['search']['value']."%' )";
			$where .=" OR spnumber LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `studentinfo`.* , `parents`.* , `class`.`class_name`, `section`.`section_name` FROM `studentinfo` 
			LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
			LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
			LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` 
			WHERE `studentinfo`.`status`= 0 " . (empty($class_id) ? "" : "AND `studentinfo`.`sclass`='$class_id' ") . (empty($section_id) ? "" : "AND `studentinfo`.`ssec`='$section_id' ") . " ";
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
					$row['class_name']." ".$row["section_name"],
					ucfirst($row['sex']),
					$row['saddress'],
					$row['spname'],
					$row['spnumber'],
					"<a href='../student/fee-collection.php?student_id=".$row["sid"]."' class='btn btn-primary'  data-toggle='tooltip' title='' data-original-title='Edit'> <i class='fa  fa-usd'></i> collect</a>
					",
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format


/* =============================== Inactive student for admin =================== */
	}else if (isset($_GET["inactivestudent"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'sadmsnno',
			1 =>'sroll', 
			2 => 'sname',
			3 => 'sclass',
			4 => 'sex',
			5 => 'saddress',
			6 => 'spname',
			7 => 'spnumber'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sadmsnno LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR sname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR semail LIKE '%".$params['search']['value']."%' ";

			$where .=" OR spname LIKE '%".$params['search']['value']."%' )";
			$where .=" OR spnumber LIKE '%".$params['search']['value']."%' )";
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
					$row['class_name']." ".$row["section_name"],
					ucfirst($row['sex']),
					$row['saddress'],
					$row['spname'],
					$row['spnumber'],
					(($row['status']==1) ? 'Left' : '').(($row['status']==2) ? 'Passed out' : ''),
					"<a href='../student/fee-collection.php?student_id=".$row["sid"]."' class='btn btn-primary'  data-toggle='tooltip' title='' data-original-title='Edit'> <i class='fa  fa-usd'></i> collect</a>
					",
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

	exit;
?>