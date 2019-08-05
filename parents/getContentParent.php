<?php
	//include connection file 
	include_once("session.php");


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
		$sql = "SELECT `studentinfo`.`sid`,  `b_receiver`.`id` ,`b_receiver`.`broadcast_id` ,`b_receiver`.`all_type`  , `b_receiver`.`class_id` , `broadcast`.* ,`teachers`.`tname`, `principal`.`pname`

			FROM `parents`

			INNER JOIN `studentinfo` 
				ON `studentinfo`.`sparent_id` = `parents`.`parent_id`
				AND `studentinfo`.`status`=0

			INNER JOIN `b_receiver` 
				ON `b_receiver`.`class_id` = `studentinfo`.`sclass`
				AND `b_receiver`.`all_type` IN (1,2,5,6,7,8,9,11,12,13,14,15)

			INNER JOIN `broadcast` 
				ON `b_receiver`.`broadcast_id` = `broadcast`.`id`
				AND `broadcast`.`message_type`= 1 
				AND `broadcast`.`status`= 0 

			LEFT JOIN `teachers` ON `broadcast`.`t_id` = `teachers`.`tid`
			LEFT JOIN `principal` ON `broadcast`.`t_id` = `principal`.`pid`

			WHERE `parents`.`parent_id` = '$login_session1'				 
				
			GROUP BY `broadcast`.`id` ";

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

					$row['message'],

					(($row['t_role']==2) ? $row['tname'] : '').(($row['t_role']==1) ? $row['pname'] : ''),
					
					
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
		$sql = "SELECT `bp_receiver`.`id` ,`bp_receiver`.`broadcast_id` ,`bp_receiver`.`r_role`  , `bp_receiver`.`r_id` , `broadcast`.* ,`teachers`.`tname`, `principal`.`pname`

			FROM bp_receiver

			INNER JOIN `broadcast` 
				ON `bp_receiver`.`broadcast_id` = `broadcast`.`id`
				AND `broadcast`.`message_type`= 2 
				AND `broadcast`.`status`= 0 

			LEFT JOIN `teachers` ON `broadcast`.`t_id` = `teachers`.`tid`
			LEFT JOIN `principal` ON `broadcast`.`t_id` = `principal`.`pid`

			WHERE `bp_receiver`.`r_role` = 4 
				AND `bp_receiver`.`r_id` = '$login_session1'				 
				
			GROUP BY `broadcast`.`id` ";

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

					$row['message'],

					(($row['t_role']==2) ? $row['tname'] : '').(($row['t_role']==1) ? $row['pname'] : ''),
					
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format

/* =============================== Homework History for Parent =================== */
	}else if (isset($_GET["homeworkhistory"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'hclock',
			1 =>'sname', 
			2 => 'subject_name',
			3 => 'htopic',
			4 => 'hrole',
			5 => 'hdate'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sname LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR subject_name LIKE '%".$params['search']['value']."%' ";
			$where .=" OR htopic LIKE '%".$params['search']['value']."%' ";
			$where .=" OR tname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR pname LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `studentinfo`.`sname`, `subject`.`subject_name`, `homework`.`htopic`, `homework`.`hclock`, `homework`.`hdate`, `homework`.`hrole`, `teachers`.`tname`, `principal`.`pname` 
					FROM `parents` 
				    LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
				    INNER JOIN `homework` ON `studentinfo`.`sclass` = `homework`.`hclass` AND `studentinfo`.`ssec` = `homework`.`hsec`
				    LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
				    LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid`
				    LEFT JOIN `principal` ON `homework`.`htid` = `principal`.`pid`
					WHERE `parents`.`parent_id`='$login_session1' AND `homework`.`hstatus` = 0 ";
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
					$row['sname'],
					$row['subject_name'],
					$row['htopic'],
					(($row['hrole']==2)? $row['tname'] : (($row['hrole']==1)? $row['pname'] : '')),
					(($login_date_type==2)? eToN($row['hdate']) : $row['hdate']),
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format



/* =============================== Homework Complaint for Parent =================== */
	}else if (isset($_GET["homeworkcomplaint"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'hwndclock',
			1 =>'sname'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( sname LIKE '%".$params['search']['value']."%' ";    
			$where .=" OR subject_name LIKE '%".$params['search']['value']."%' ) ";
		}

		// getting total number records without any search
		$sql = "SELECT `studentinfo`.`sname`,`subject`.`subject_name`, `hwnotdone`.`hwndclock`,`homework`.`hclock` 
				FROM `parents` 
			    LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
			    INNER JOIN `hwnotdone` ON `studentinfo`.`sid` = `hwnotdone`.`hwndsid`
			    INNER JOIN `homework` ON `hwnotdone`.`hwndhid` = `homework`.`hid` 
			    LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
				WHERE `parents`.`parent_id`='$login_session1'  ";
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
					(($login_date_type==2)? eToN(date('Y-m-d', strtotime($row['hwndclock']))) : date('Y-m-d', strtotime($row['hwndclock'])))." ".date('g:i A', strtotime($row['hwndclock'])),

					$row['sname']." did not complete the homework of subject: ".$row["subject_name"]." on date: ".(($login_date_type==2)? eToN($row['hclock']) : $row['hclock']),
					
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