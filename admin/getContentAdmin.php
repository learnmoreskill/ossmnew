<?php
	//include connection file 
	include_once("session.php");
	$year_id = $current_year_session_id;


/* =============================== Broadcast Message History for admin =================== */
	if (isset($_GET["broadcast"])){

		header('Content-Type: text/html; charset = utf-8');
    	$db->query("SET NAMES utf8");


		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'clock',
			1 =>'t_id', 
			2 => 'message'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( message LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR clock LIKE '".$params['search']['value']."%' ";

			$where .=" OR pname LIKE '%".$params['search']['value']."%' ";

			$where .=" OR tname LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `broadcast`.* ,`teachers`.`tname`, `principal`.`pname`
			FROM `broadcast`
			LEFT JOIN `teachers` ON `broadcast`.`t_id` = `teachers`.`tid`
			LEFT JOIN `principal` ON `broadcast`.`t_id` = `principal`.`pid`
			WHERE `broadcast`.`message_type`= 1 AND `broadcast`.`status`= 0 AND `broadcast`.`year_id` = '$year_id' ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}

	 		$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".(($params['order'][0]['dir']=='asc')? 'desc':'asc')."  LIMIT ".$params['start']." ,".$params['length']."  ";

		$queryTot = mysqli_query($db, $sqlTot) or die("database error:". mysqli_error($db));


		$totalRecords = mysqli_num_rows($queryTot);

		$queryRecords = mysqli_query($db, $sqlRec) or die("error to fetch list". mysqli_error($db));

		//iterate on results row and create new index array of data
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			//$data[] = $row;

			array_push($response,array(
					(($login_date_type==2)? eToN(date('Y-m-d', strtotime($row['clock']))) : date('Y-m-d', strtotime($row['clock'])))." ".date('g:i A', strtotime($row['clock'])),

					(($row['t_role']==1 && $row['t_id'] ==$login_session1)? 'Self': (($row['t_role']==2) ? $row['tname'] : '').(($row['t_role']==1) ? $row['pname'] : '')	),

					$row['message'],

					"<a class='modal-trigger' id='".$row["id"]."' href='#receiver_details_model' onClick='look_b_receiver(this.id)' >
		                <div title='Receiver details' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'> 
		                    <i class='material-icons blue-text text-darken-4'>
		                        info
		                    </i>
		                </div>
		            </a>",

					"".(($login_cat == 1 || $pac['edit_message'])? "<a href='deleteuserscript.php?token=5del1brridcv4g&key=ae25nJ5s3fr596dg@".$row["id"]."' onclick = 'return confirm(\"Are you sure want to delete?\")' >
		                <div title='Delete' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'> 
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


/* =============================== Personal Message History for admin =================== */
	}else if (isset($_GET["personal"])){

		header('Content-Type: text/html; charset = utf-8');
    	$db->query("SET NAMES utf8");


		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'clock',
			1 =>'t_id', 
			2 => 'message'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( message LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR clock LIKE '".$params['search']['value']."%' ";

			$where .=" OR pname LIKE '%".$params['search']['value']."%' ";

			$where .=" OR tname LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `broadcast`.* ,`teachers`.`tname`, `principal`.`pname`
			FROM `broadcast`
			LEFT JOIN `teachers` ON `broadcast`.`t_id` = `teachers`.`tid`
			LEFT JOIN `principal` ON `broadcast`.`t_id` = `principal`.`pid`
			WHERE `broadcast`.`message_type`= 2 AND `broadcast`.`status`= 0 AND `broadcast`.`year_id` = '$year_id' ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}

	 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".(($params['order'][0]['dir']=='asc')? 'desc':'asc')."  LIMIT ".$params['start']." ,".$params['length']."  ";

		$queryTot = mysqli_query($db, $sqlTot) or die("database error:". mysqli_error($db));


		$totalRecords = mysqli_num_rows($queryTot);

		$queryRecords = mysqli_query($db, $sqlRec) or die("error to fetch list". mysqli_error($db));

		//iterate on results row and create new index array of data
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			//$data[] = $row;

			array_push($response,array(
					(($login_date_type==2)? eToN(date('Y-m-d', strtotime($row['clock']))) : date('Y-m-d', strtotime($row['clock'])))." ".date('g:i A', strtotime($row['clock'])),

					(($row['t_role']==1 && $row['t_id'] ==$login_session1)? 'Self': (($row['t_role']==2) ? $row['tname'] : '').(($row['t_role']==1) ? $row['pname'] : '')	),

					$row['message'],

					"<a class='modal-trigger' id='".$row["id"]."' href='#receiver_details_model' onClick='look_bp_receiver(this.id)' >
		                <div title='receiver details' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'> 
		                    <i class='material-icons blue-text text-darken-4'>
		                        info
		                    </i>
		                </div>
		            </a>",

					"".(($login_cat == 1 || $pac['edit_message'])? "<a href='deleteuserscript.php?token=5del1brridcv4g&key=ae25nJ5s3fr596dg@".$row["id"]."' onclick = 'return confirm(\"Are you sure want to delete?\")' >
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

/* ======================================= Parents active =================== */
	}else if (isset($_GET["parent"])){
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
			3 => 'sex',
			4 => 'sclass',
			5 => 'saddress',
			6 => 'spname',
			7 => 'single_year'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sadmsnno LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR sname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR semail LIKE '%".$params['search']['value']."%' ";

			$where .=" OR spname LIKE '%".$params['search']['value']."%' ";

			$where .=" OR single_year LIKE '".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `studentinfo`.* , `parents`.* , `class`.`class_name`, `section`.`section_name`,`academic_year`.`single_year` 
			FROM `studentinfo` 
			LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
			LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
			LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id`
			LEFT JOIN `academic_year` ON `studentinfo`.`batch_year_id`=`academic_year`.`id` 
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
					ucfirst($row['sex']),
					$row['class_name']." ".$row["section_name"],
					$row['saddress'],
					$row['spname'],
					$row['single_year'],
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


	                ".(($login_cat == 1 || $pac['edit_student'])? "<a href='admitstudent.php?token=2ec9ys77bi8939&key=ae25nj53sfr596dg@".$row["sid"]."'>
	                	<div title='edit' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
	                		<i class='material-icons green-text text-lighten-1'>
	                			edit
	                		</i>
	                	</div>
	                </a>":"")."
	                ".(($login_cat == 1 || $pac['edit_student'])? "<a href='deleteuserscript.php?token=5ftgy76fgh4esw&key=ae25nJ5s3fr596dg@".$row["sid"]."' onclick = 'return confirm(\"Are you sure want to delete?\")' >
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
			3 => 'sex',
			4 => 'sclass',
			5 => 'saddress',
			6 => 'spname',
			7 => 'single_year'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sadmsnno LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR sname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR semail LIKE '%".$params['search']['value']."%' ";

			$where .=" OR spname LIKE '%".$params['search']['value']."%' ";

			$where .=" OR single_year LIKE '".$params['search']['value']."%' )";

		}

		// getting total number records without any search
		$sql = "SELECT `studentinfo`.* , `parents`.* , `class`.`class_name`, `section`.`section_name` ,`academic_year`.`single_year` 
		FROM `studentinfo` 
		LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
		LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
		LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` 
		LEFT JOIN `academic_year` ON `studentinfo`.`batch_year_id`=`academic_year`.`id`
		WHERE `studentinfo`.`status`<> 0 ";
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
					ucfirst($row['sex']),
					$row['class_name']." ".$row["section_name"],
					$row['saddress'],
					$row['spname'],
					$row['single_year'],
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


	                ".(($login_cat == 1 || $pac['edit_student'])? "<a href='admitstudent.php?token=2ec9ys77bi8939&key=ae25nj53sfr596dg@".$row["sid"]."'>
	                	<div title='edit' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
	                		<i class='material-icons green-text text-lighten-1'>
	                			edit
	                		</i>
	                	</div>
	                </a>":"")."
	                ".(($login_cat == 1 || $pac['edit_student'])? "<a href='deleteuserscript.php?token=6yugyf67gh4esw&key=ae25nJ5s3fr596dg@".$row["sid"]."' onclick = 'return confirm(\"Are you sure want to re-active?\")' >
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




/* =============================== Homework History for admin =================== */
	}else if (isset($_GET["homeworkhistory"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'hclock',
			1 =>'class_name', 
			2 => 'subject_name',
			3 => 'htopic',
			4 => 'hdate',
			5 => 'hrole'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( class_name LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR subject_name LIKE '%".$params['search']['value']."%' ";
			$where .=" OR pname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR tname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR htopic LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `homework`.*, `class`.`class_name`, `section`.`section_name`, `subject`.`subject_name`, `teachers`.`tname`, `principal`.`pname` 
					FROM `homework` 
					LEFT JOIN `class` ON `homework`.`hclass` = `class`.`class_id`
					LEFT JOIN `section` ON `homework`.`hsec` = `section`.`section_id`
					LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
					LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid`
					LEFT JOIN `principal` ON `homework`.`htid` = `principal`.`pid`
					WHERE `homework`.`hstatus` = 0  AND `homework`.`year_id` = '$year_id'";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}

	 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".(($params['order'][0]['dir']=='asc')? 'desc':'asc')."  LIMIT ".$params['start']." ,".$params['length']."  ";

		$queryTot = mysqli_query($db, $sqlTot) or die("database error:". mysqli_error($db));


		$totalRecords = mysqli_num_rows($queryTot);

		$queryRecords = mysqli_query($db, $sqlRec) or die("error to fetch list". mysqli_error($db));

		//iterate on results row and create new index array of data
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			//$data[] = $row;

			array_push($response,array(
					(($login_date_type==2)? eToN(date('Y-m-d', strtotime($row['hclock']))) : date('Y-m-d', strtotime($row['hclock']))),
					$row['class_name']." ".$row["section_name"],
					$row['subject_name'],
					$row['htopic'],
					(($login_date_type==2)? eToN($row['hdate']) : $row['hdate']),
					(($row['hrole']==2) ? $row['tname'] : '').(($row['hrole']==1) ? $row['pname'].'(Principal)' : ''),					
					"".(($login_cat == 1 || $pac['edit_homework'])? "<td><a href='".(($row['hreported']==0) ? "hwreport.php?h5w9g64fft=".$row['hid']."&cweg2ts8=".$row['hclass']."&u395rd0d=".$row['hsec'] :"#")."' >
                                        <span ".(($row['hreported']==0)? "class= 'red-text text-lighten-2' title='Not reported yet'" :"").(($row['hreported']==1) ? "class='blue-text text-lighten-2' title='Reported'":"")." 
                                            style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
                                            <i class='material-icons'>
                                                message
                                            </i>&nbsp;
                                        </span>
                                    </a>
                                </td>":"")."",
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format


/* =============================== Leave History for admin =================== */
	}else if (isset($_GET["leavehistory"])){

		header('Content-Type: text/html; charset = utf-8');
    	$db->query("SET NAMES utf8");


		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'lvclock',
			1 =>'class_name', 
			2 => 'sroll',
			3 => 'sname',
			4 => 'lvreason',
			5 => 'lvsdate',
			6 => 'lvstatus'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( message LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR clock LIKE '".$params['search']['value']."%' ";

			$where .=" OR pname LIKE '%".$params['search']['value']."%' ";

			$where .=" OR tname LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `leavetable`.*, `class`.`class_name`, `section`.`section_name`, `teachers`.`tname`, `principal`.`pname`, `studentinfo`.`sname`, `studentinfo`.`sroll`
			FROM `leavetable`
			LEFT JOIN `class` ON `leavetable`.`lvclass` = `class`.`class_id`
			LEFT JOIN `section` ON `leavetable`.`lvsec` = `section`.`section_id`
			LEFT JOIN `teachers` ON `leavetable`.`lvtid` = `teachers`.`tid`
			LEFT JOIN `principal` ON `leavetable`.`lvtid` = `principal`.`pid`
			LEFT JOIN `studentinfo` ON `leavetable`.`lvsid` = `studentinfo`.`sid`
			WHERE `leavetable`.`status` = 0 ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}

	 		$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".(($params['order'][0]['dir']=='asc')? 'desc':'asc')."  LIMIT ".$params['start']." ,".$params['length']."  ";

		$queryTot = mysqli_query($db, $sqlTot) or die("database error:". mysqli_error($db));


		$totalRecords = mysqli_num_rows($queryTot);

		$queryRecords = mysqli_query($db, $sqlRec) or die("error to fetch list". mysqli_error($db));

		//iterate on results row and create new index array of data
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			//$data[] = $row;

			array_push($response,array(
					(($login_date_type==2)? eToN(date('Y-m-d', strtotime($row['lvclock']))) : date('Y-m-d', strtotime($row['lvclock'])))." ".date('g:i A', strtotime($row['lvclock'])),

					$row['class_name'].' - '.$row['section_name'],
					$row['sroll'],
					$row['sname'],
					$row['lvreason'],

					(($login_date_type==2)? eToN($row['lvsdate']) : $row['lvsdate'])." to ".(($login_date_type==2)? eToN($row['lvedate']) : $row['lvedate']),

					
					(($row['lvstatus']=='50')? "<span class='blue-text text-lighten-2'>Pending</span>" :  
                        (($row['lvstatus']=='100')? "<span class='green-text text-lighten-2'>Approved</span>" :
                        	(($row['lvstatus']=='0')? "<span class='red-text text-lighten-1'>Rejected</span>" : ""))).
					(($row['lvrole']==2) ? " updated by ".$row['tname'] : '').(($row['lvrole']==1) ? " updated by ".$row['pname'] : ''),

						(($login_cat == 1 || $pac['add_leave'])? 
							(($row['lvsdate']< $login_today_edate)? "Date exceeded" : 

						(($row['lvstatus']!='100')? "<a class='btn-floating waves-effect waves-light green lighten-2' href='leavereview.php?setid=".$row['lvid']."&setstatus=100'><i class='material-icons'>done</i>
                                                    </a>" : "" )
						." ".
						(($row['lvstatus']=='100' || $row['lvstatus']=='50')? "<a class='btn-floating waves-effect waves-light blue lighten-2' href='leavereview.php?setid=".$row['lvid']."&setstatus=0'><i class='material-icons'>clear</i>
                                                    </a>" : "" )
					)
							:""),

					
					
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