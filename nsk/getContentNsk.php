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
			1 =>'message', 
			2 => 't_id'
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
		$sql = "SELECT `b_receiver`.`id` ,`b_receiver`.`broadcast_id` ,`b_receiver`.`all_type`  , `b_receiver`.`class_id` , `broadcast`.* ,`teachers`.`tname`, `principal`.`pname`
			FROM `b_receiver`
			INNER JOIN `broadcast` 
				ON `b_receiver`.`broadcast_id` = `broadcast`.`id`
				AND `broadcast`.`message_type`= 1 
				AND `broadcast`.`status`= 0 
			LEFT JOIN `teachers` ON `broadcast`.`t_id` = `teachers`.`tid`
			LEFT JOIN `principal` ON `broadcast`.`t_id` = `principal`.`pid`

			WHERE `b_receiver`.`all_type` IN (3,6,8,10,11,13,14,15) OR 	(`broadcast`.`t_role`= 2 AND `broadcast`.`t_id`= '$login_session1')
				
			GROUP BY `b_receiver`.`broadcast_id` ";
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


					(($row['t_role']==2) ? $row['tname'] : '').(($row['t_role']==1) ? $row['pname'] : ''),

					$row['message'],
					
					"<a class='modal-trigger' id='".$row["id"]."' href='#receiver_details_model' onClick='look_b_receiver(this.id)' >
		                <div title='Receiver details' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'> 
		                    <i class='material-icons blue-text text-darken-4'>
		                        info
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
			1 =>'message', 
			2 => 't_id'
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
		$sql = "SELECT `bp_receiver`.`id`,`bp_receiver`.`r_role`,`bp_receiver`.`r_id`,`broadcast`.* ,`teachers`.`tname`, `principal`.`pname`

			FROM `broadcast`

			INNER JOIN `bp_receiver` ON `broadcast`.`id` = `bp_receiver`.`broadcast_id`

			LEFT JOIN `teachers` ON `broadcast`.`t_id` = `teachers`.`tid`
			LEFT JOIN `principal` ON `broadcast`.`t_id` = `principal`.`pid`

			WHERE (	(`broadcast`.`t_role`= 2 AND `broadcast`.`t_id`= '$login_session1')  OR (	`bp_receiver`.`r_role`=2 AND `bp_receiver`.`r_id`='$login_session1'	)	) AND `broadcast`.`message_type`= 2 AND `broadcast`.`status`= 0 
			GROUP BY `broadcast`.`id`	";
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

					(($row['t_role']==2 && $row['t_id'] ==$login_session1)? 'Self': (($row['t_role']==2) ? $row['tname'] : '').(($row['t_role']==1) ? $row['pname'] : '')	)   ,

					$row['message'],

					"<a class='modal-trigger' id='".$row["id"]."' href='#receiver_details_model' onClick='look_bp_receiver(this.id)' >
		                <div title='Receiver details' style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'> 
		                    <i class='material-icons blue-text text-darken-4'>
		                        info
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

/* =============================== Homework History for NSK =================== */
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
			4 => 'hdate'
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
		$sql = "SELECT `homework`.*, `class`.`class_name`, `section`.`section_name`, `subject`.`subject_name` 
					FROM `homework` 
					LEFT JOIN `class` ON `homework`.`hclass` = `class`.`class_id`
					LEFT JOIN `section` ON `homework`.`hsec` = `section`.`section_id`
					LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
					WHERE `homework`.`hrole` = 2 AND `homework`.`htid` = '$login_session1' AND `homework`.`hstatus` = 0   AND `homework`.`year_id` = '$year_id'";
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
					"<td><a href='".(($row['hreported']==0) ? "hwreport.php?h5w9g64fft=".$row['hid']."&cweg2ts8=".$row['hclass']."&u395rd0d=".$row['hsec'] :"#")."' >
                                        <span ".(($row['hreported']==0)? "class= 'red-text text-lighten-2' title='Not reported yet'" :"").(($row['hreported']==1) ? "class='blue-text text-lighten-2' title='Reported'":"")." 
                                            style='font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;'>
                                            <i class='material-icons'>
                                                message
                                            </i>&nbsp;
                                        </span>
                                    </a>
                                </td>",
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format

/* =============================== Leave History for NSK =================== */
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
			LEFT JOIN `teachers` ON `leavetable`.`lvtid` = `teachers`.`tid`
			LEFT JOIN `principal` ON `leavetable`.`lvtid` = `principal`.`pid`
			LEFT JOIN `studentinfo` ON `leavetable`.`lvsid` = `studentinfo`.`sid`
            INNER JOIN `section` ON `leavetable`.`lvsec` = `section`.`section_id`
			WHERE `section`.`teacher_id` = '$login_session1'
				AND `leavetable`.`status` = 0 ";
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

						(($row['lvsdate']< $login_today_edate)? "Date exceeded" : 

						(($row['lvstatus']!='100')? "<a class='btn-floating waves-effect waves-light green lighten-2' href='leavereview.php?setid=".$row['lvid']."&setstatus=100'><i class='material-icons'>done</i>
                                                    </a>" : "" )
						." ".
						(($row['lvstatus']=='100' || $row['lvstatus']=='50')? "<a class='btn-floating waves-effect waves-light blue lighten-2' href='leavereview.php?setid=".$row['lvid']."&setstatus=0'><i class='material-icons'>clear</i>
                                                    </a>" : "" )
					),

					
					
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