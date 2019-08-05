<?php
	//include connection file 
	include_once("session.php");


/* =============================== Broadcast Message History for student =================== */
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

			WHERE `b_receiver`.`class_id` = '$login_class_id' 
				AND `b_receiver`.`all_type` IN (1,5,6,7,11,12,13,15) 
				
			GROUP BY `b_receiver`.`broadcast_id`";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}

	 		$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".(($params['order'][0]['dir']=='asc')? 'desc':'asc')."  LIMIT ".$params['start']." ,".$params['length']."   ";

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
			FROM `bp_receiver`
			INNER JOIN `broadcast` 
				ON `bp_receiver`.`broadcast_id` = `broadcast`.`id`
				AND `broadcast`.`message_type`= 2 
				AND `broadcast`.`status`= 0 
			LEFT JOIN `teachers` ON `broadcast`.`t_id` = `teachers`.`tid`
			LEFT JOIN `principal` ON `broadcast`.`t_id` = `principal`.`pid`

			WHERE `bp_receiver`.`r_role` = 3 
				AND `bp_receiver`.`r_id` = '$login_session1'
				
			GROUP BY `bp_receiver`.`broadcast_id`	";

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

/* =============================== Homework History for Smart =================== */
	}else if (isset($_GET["homeworkhistory"])){

		// header('Content-Type: text/html; charset = utf-8');
  //   	$db->query("SET NAMES utf8");

		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'hclock',
			1 => 'subject_name',
			2 => 'htopic',
			3 => 'hrole',
			4 => 'hdate'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" ( subject_name LIKE '%".$params['search']['value']."%' ";
			$where .=" OR htopic LIKE '%".$params['search']['value']."%' ";
			$where .=" OR tname LIKE '%".$params['search']['value']."%' ";
			$where .=" OR pname LIKE '%".$params['search']['value']."%' )";
		}

		// getting total number records without any search
		$sql = "SELECT `subject`.`subject_name`, `homework`.`htopic`, `homework`.`hclock`, `homework`.`hdate`, `homework`.`hrole`, `teachers`.`tname`, `principal`.`pname` 
					FROM `homework`
				    LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
				    LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid`
				    LEFT JOIN `principal` ON `homework`.`htid` = `principal`.`pid`
					WHERE `homework`.`hclass` = '$login_class_id' AND `homework`.`hsec` = '$login_section_id' AND `homework`.`hstatus` = 0 ";
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

/* =============================== Attendance History for Smart =================== */
	}else if (isset($_GET["attendance_history"])){
		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'aclock',
			1 => 'astatus'
		);

		$where = $sqlTot = $sqlRec = "";

		// check search value exist
		if( !empty($params['search']['value']) ) {   
			$where .=" AND ";
			$where .=" astatus LIKE '%".$params['search']['value']."%' ";
		}

		// getting total number records without any search
		$sql = "SELECT * 
					FROM `attendance` 
					WHERE `asid` ='$login_session1' ";
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
					(($login_date_type==2)? eToN(date('Y-m-d', strtotime($row['aclock']))) : date('Y-m-d', strtotime($row['aclock']))),

					(($row['astatus']=='P')? "<a class='btn-floating btn-small waves-effect waves-light green lighten-2'  title='Present'><i class='material-icons'>done</i></a>" : (($row['astatus']=='A')? "<a class='btn-floating btn-small waves-effect waves-light red lighten-2'  title='Absent'><i class='material-icons'>clear</i></a>" : '')),
					
					));
		}	

		$json_data = array(
				"draw"            => intval( $params['draw'] ),   
				"recordsTotal"    => intval( $totalRecords ),  
				"recordsFiltered" => intval($totalRecords),
				"data"            => $response   // total data array
				);

		echo json_encode($json_data);  // send data as json format


/* =============================== Leave History for Student =================== */
	}else if (isset($_GET["leavehistory"])){

		header('Content-Type: text/html; charset = utf-8');
    	$db->query("SET NAMES utf8");


		// initilize all variable
		$params = $columns = $totalRecords = $data = $response = array();

		$params = $_REQUEST;

		//define index of column for sorting
		$columns = array( 
			0 =>'lvclock',
			1 =>'lvreason', 
			2 => 'lvsdate',
			3 => 'lvtid',
			4 => 'lvstatus'
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
		$sql = "SELECT `leavetable`.*, `teachers`.`tname`, `principal`.`pname`, `studentinfo`.`sname`, `studentinfo`.`sroll`
			FROM `leavetable` 
			LEFT JOIN `teachers` ON `leavetable`.`lvtid` = `teachers`.`tid`
			LEFT JOIN `principal` ON `leavetable`.`lvtid` = `principal`.`pid`
			INNER JOIN `studentinfo` ON `leavetable`.`lvsid` = `studentinfo`.`sid`
			WHERE `studentinfo`.`sid` = '$login_session1'
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

					$row['lvreason'],

					(($login_date_type==2)? eToN($row['lvsdate']) : $row['lvsdate'])." to ".(($login_date_type==2)? eToN($row['lvedate']) : $row['lvedate']),

					(($row['lvrole']==2) ? $row['tname'] : '').(($row['lvrole']==1) ? $row['pname'] : ''),


					(($row['lvsdate']>=$login_today_edate && $row['lvstatus']=='50')? "

						<input type='hidden' id='lsdate".$row['lvid']."' value='".(($login_date_type==2)? eToN($row['lvsdate']) : $row['lvsdate'])."'>
						<input type='hidden' id='ledate".$row['lvid']."' value='".(($login_date_type==2)? eToN($row['lvedate']) : $row['lvedate'])."'>
						<input type='hidden' id='lreason".$row['lvid']."' value='".$row['lvreason']."'>

						<a class='modal-trigger btn-floating  waves-effect waves-light blue lighten-2' title='Edit' href='#editModel' onClick='edit_model(".$row['lvid'].")'><i class='material-icons'>edit</i></a>" : "" )." "

					.(	($row['lvstatus']=='50')?

						(($row['lvsdate']<$login_today_edate)? "<a class='modal-trigger btn-floating  waves-effect waves-light blue lighten-2' href='#modal' title='Details' onClick='details_model(51)'><i class='material-icons'>more_horiz</i></a>" : "<a class='modal-trigger btn-floating  waves-effect waves-light green lighten-2' href='#modal' title='Details' onClick='details_model(50)'><i class='material-icons'>more_horiz</i></a>" ) 

						:  (($row['lvstatus']=='100')? "<a class='modal-trigger btn-floating waves-effect waves-light green lighten-2' href='#modal' title='Details' onClick='details_model(100)' ><i class='material-icons'>done</i></a>" 
						:	(($row['lvstatus']=='0')? "<a class='modal-trigger btn-floating waves-effect waves-light red lighten-2' href='#modal' title='Details'onClick='details_model(0)' ><i class='material-icons'>clear</i></a>" : ""))
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