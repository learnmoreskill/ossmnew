<?php

class account_management_classes
{
//=========================== class section ===================================

	//hackster 2019 feb
	function get_class_details(){
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `class_id`,`class_name` 
				FROM `class` 
				WHERE `status` = 0 
				ORDER BY `class_name`+0 ASC ");

			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"class_id" => $row['class_id'],
					"class_name" => $row['class_name'],						
				));
			}
			mysqli_close($db);
			return json_encode($response);
		
	}
	//hackster New April 2019
	function get_class_list_by_year_id($year_id){
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `class_id`,`class_name` 
					FROM `class` 
					WHERE `year_id` = '$year_id' AND `status` = 0 
					ORDER BY `class_name`+0 ASC ");

				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"class_id" => $row['class_id'],
						"class_name" => $row['class_name'],						
					));
				}
				mysqli_close($db);
				return json_encode($response);
			
	}


	//should be by class id check it , change
	function get_fee_by_class_id_and_feetype($class_id,$feetype)
	{
		require("../config/config.php");
		$result = mysqli_query($db,"SHOW COLUMNS FROM `class` LIKE '$feetype'");
		$exists = (mysqli_num_rows($result))?TRUE:FALSE;
		if($exists) {
  			 // do your stuff
			$result = mysqli_query($db, "SELECT $feetype FROM `class` WHERE `class_id` = '$class_id'");
			$count=mysqli_num_rows($result);
			$value = mysqli_fetch_object($result);
			mysqli_close($db);

			if($count>0){ return $value->$feetype; }else{ return 0;}

		}else{
			return 0;
		}
	}
	
	//krishna
	function get_class_name_by_class_id($class_id){
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `class_name` FROM `class` WHERE `class_id` = '$class_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->class_name;
	}

	function get_classId_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT class_id FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->class_id;
	}

	function get_computer_fee_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT computer_fee FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->computer_fee;
	}

	function get_hostel_fee_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT hostel_fee FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->hostel_fee;
	}

	function get_admission_charge_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT admission_charge FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->admission_charge;
	}

	function get_annual_fee_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT annual_fee FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->annual_fee;
	}

	function get_exam_fee_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT exam_fee FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->exam_fee;
	}

	
	function get_book_fee_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT book_fee FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->book_fee;
	}

	function get_monthly_testfee_by_class_name($class_name)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT monthly_testfee FROM `class` WHERE class_name='$class_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->monthly_testfee;
	}

	function get_bus_fee_rate_by_bus_id($bus_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT bus_fee_rate FROM `transportation` WHERE bus_id='$bus_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->bus_fee_rate;
	}

//============================== End class section ============================
//============================== student record section =======================
	function get_fee_by_feetype_student_id($sid,$feetype)
	{
		//require("../config/config.php");
		if($feetype=='Tution Fee')
		{
			
		// $result = mysqli_query($db, "SELECT tution_discount_percent,sclass FROM `studentinfo` where sid='$student_id'");
		// $value = mysqli_fetch_object($result);
		// mysqli_close($db);
		// $tution_discount_percent = $value->tution_discount_percent;
		// $sclass = $value->sclass;
		$tution_fee = $this->get_tution_rate_by_sid($sid);
		// $new_tution_fee = $tution_fee-($tution_fee*$tution_discount_percent)/100;
		return $tution_fee;
		}

		else if($feetype=='Hostel Fee')
		{
		// $result = mysqli_query($db, "SELECT hostel_discount_percent,sclass FROM `studentinfo` where sid='$student_id'");
		// $value = mysqli_fetch_object($result);
		// mysqli_close($db);
		// $hostel_discount_percent = $value->hostel_discount_percent;
		// $sclass = $value->sclass;
		 $hostel_fee = $this->get_hostel_rate_by_sid($sid);
		// $hostel_fee = $hostel_fee-($hostel_fee*$hostel_discount_percent)/100;
		return $hostel_fee;
		}

		else if($feetype=='Bus Fee')
		{
		// $result = mysqli_query($db, "SELECT bus_discount_percent,sclass,bus_id FROM `studentinfo` where sid='$student_id'");
		// $value = mysqli_fetch_object($result);
		// mysqli_close($db);
		// $bus_discount_percent = $value->bus_discount_percent;
		// $bus_id = $value->bus_id;
		$bus_fee_rate = $this->get_bus_rate_by_sid($sid);
		// $new_bus_fee_rate = $bus_fee_rate - ($bus_fee_rate*$bus_discount_percent)/100;
		return $bus_fee_rate;
		}

		else if($feetype=='Computer Fee')
		{
		// $result = mysqli_query($db, "SELECT computer_discount_percent,sclass FROM `studentinfo` where sid='$student_id'");
		// $value = mysqli_fetch_object($result);
		// mysqli_close($db);
		// $computer_discount_percent = $value->computer_discount_percent;
		// $sclass = $value->sclass;
		 $computer_fee = $this->get_computer_fee_by_sid($sid);
		//$new_computer_fee = $computer_fee-($computer_fee*$computer_discount_percent)/100;
		return $computer_fee;
		}


		
	}


	
	function get_tution_rate_by_sid($sid)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT  tution_fee FROM `studentinfo` where sid='$sid'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->tution_fee;
	}
	function get_bus_rate_by_sid($sid)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT  bus_fee FROM `studentinfo` where sid='$sid'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->bus_fee;
	}

	function get_hostel_rate_by_sid($sid)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT  hostel_fee FROM `studentinfo` where sid='$sid'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->hostel_fee;
	}

	function get_computer_fee_by_sid($sid)
	{
		require ("../config/config.php");
		$result=mysqli_query($db,"SELECT computer_fee FROM `studentinfo` WHERE sid='$sid'");
		$value=mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->computer_fee;
	}


	function get_max_student_id()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT max(sid) as 'sid'  FROM `studentinfo`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sid;
		}

		function search($search_term)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM studentinfo WHERE sname LIKE '%$search_term%' or sadmsnno LIKE '%$search_term%' or sroll LIKE '%$search_term%' or spname LIKE '%$search_term%'or ssec LIKE '%$search_term%'or saddress LIKE '%$search_term%'");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sname" => $row['sname'],
					"sadmsnno" => $row['sadmsnno'],
					"dob" => $row['dob'],
					"spname" => $row['spname'],
					"spnumber" => $row['spnumber'],
					"sname" => $row['sname'],
					"sroll" => $row['sroll'],
					"saddress" => $row['saddress'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"tution_rate" => $row['tution_rate'],
					"bus_rate" => $row['bus_rate'],
					"hostel_rate" => $row['hostel_rate'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
		}
	//updated
	function get_student_details()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `studentinfo`.* , `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `class`.`class_name`, `section`.`section_name` 
			FROM `studentinfo` 
			LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
			LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
			LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 

			WHERE `studentinfo`.`status`=0");

		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				"sname" => $row['sname'],
				"sadmsnno" => $row['sadmsnno'],
				"dob" => $row['dob'],

				"spname" => $row['spname'],
				"spnumber" => $row['spnumber'],
				"smname" => $row['smname'],
				
				"sroll" => $row['sroll'],
				"saddress" => $row['saddress'],
				"sclass" => $row['sclass'],
				"ssec" => $row['ssec'],

				"class_name" => $row['class_name'],
				"section_name" => $row['section_name'],

				"bus_id" => $row['bus_id'],				
				"tution_fee" => $row['tution_fee'], 
				"computer_fee" => $row['computer_fee'],
				"bus_fee" => $row['bus_fee'],
				"hostel_fee" => $row['hostel_fee'],
				"payment_type"=>$row['payment_type'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}




	//updated
	function get_inactive_student_details()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `studentinfo`.* , `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `class`.`class_name`, `section`.`section_name` 
			FROM studentinfo 
			LEFT JOIN parents ON studentinfo.`sparent_id`=`parents`.`parent_id` 
			LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
			LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
			WHERE `studentinfo`.`status`<>0 
			ORDER BY `studentinfo`.`sclass`, `studentinfo`.`ssec`, `studentinfo`.`sroll`");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				"sname" => $row['sname'],
				"sadmsnno" => $row['sadmsnno'],
				"sadmsnno" => $row['sadmsnno'],
				"dob" => $row['dob'],
				"spname" => $row['spname'],
				"spnumber" => $row['spnumber'],
				"sname" => $row['sname'],
				"sroll" => $row['sroll'],
				"saddress" => $row['saddress'],
				"sclass" => $row['sclass'],
				"ssec" => $row['ssec'],

				"class_name" => $row['class_name'],
				"section_name" => $row['section_name'],

				"bus_id" => $row['bus_id'],				
				"tution_fee" => $row['tution_fee'], 
				"computer_fee" => $row['computer_fee'],
				"bus_fee" => $row['bus_fee'],
				"hostel_fee" => $row['hostel_fee'],
				"payment_type"=>$row['payment_type'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}


	//function get_student_details_by_className($className)

	//hackster
	function get_active_student_details_by_class_id($class_id)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `studentinfo`.* , `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `class`.`class_name`, `section`.`section_name` 
			FROM  studentinfo 
			LEFT JOIN parents ON studentinfo.`sparent_id`=`parents`.`parent_id`
			INNER JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
			INNER JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
			WHERE `studentinfo`.`sclass` = '$class_id' AND `studentinfo`.`status` = 0 
			ORDER BY `studentinfo`.`sclass`, `studentinfo`.`ssec`, `studentinfo`.`sroll` ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				"sname" => $row['sname'],
				"sadmsnno" => $row['sadmsnno'],
				"sadmsnno" => $row['sadmsnno'],
				"dob" => $row['dob'],
				"spname" => $row['spname'],
				"spnumber" => $row['spnumber'],
				"sname" => $row['sname'],
				"sroll" => $row['sroll'],
				"saddress" => $row['saddress'],
				"sclass" => $row['sclass'],
				"ssec" => $row['ssec'],

				"class_name" => $row['class_name'],
				"section_name" => $row['section_name'],

				"bus_id" => $row['bus_id'],				
				"tution_fee" => $row['tution_fee'], 
				"computer_fee" => $row['computer_fee'],
				"bus_fee" => $row['bus_fee'],
				"hostel_fee" => $row['hostel_fee'],
				"payment_type"=>$row['payment_type'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
	//hackster
	function get_active_student_id_details_by_class_id($class_id)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `studentinfo`.`sid`
			FROM  studentinfo  
			WHERE `studentinfo`.`sclass` = '$class_id' AND `studentinfo`.`status` = 0 
			ORDER BY `studentinfo`.`sclass`, `studentinfo`.`ssec`, `studentinfo`.`sroll` ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
//updated
	function get_student_details_by_studentId($sid)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `studentinfo`.* , `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `class`.`class_name`, `section`.`section_name` 
			FROM  studentinfo 
			LEFT JOIN parents ON studentinfo.`sparent_id`=`parents`.`parent_id`
			INNER JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
			INNER JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
			WHERE `studentinfo`.`sid` = '$sid'
			ORDER BY `studentinfo`.`sclass`, `studentinfo`.`ssec`, `studentinfo`.`sroll` ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				"sname" => $row['sname'],
				"sadmsnno" => $row['sadmsnno'],
				"sadmsnno" => $row['sadmsnno'],
				"dob" => $row['dob'],
				"spname" => $row['spname'],
				"spnumber" => $row['spnumber'],
				"sname" => $row['sname'],
				"sroll" => $row['sroll'],
				"saddress" => $row['saddress'],
				"sclass" => $row['sclass'],
				"ssec" => $row['ssec'],

				"class_name" => $row['class_name'],
				"section_name" => $row['section_name'],


				"bus_id" => $row['bus_id'],
				"payment_type"=>$row['payment_type'],
				"tution_fee" => $row['tution_fee'], 
				"computer_fee" => $row['computer_fee'],
				"bus_fee" => $row['bus_fee'],
				"hostel_fee" => $row['hostel_fee'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//updated
	function get_student_details_by_sid($sid)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `studentinfo`.* , `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `class`.`class_name`, `section`.`section_name` 
			FROM studentinfo 
			LEFT JOIN parents ON studentinfo.`sparent_id`=`parents`.`parent_id`
			LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
			LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
			WHERE studentinfo.`sid`= '$sid' 
			ORDER BY `studentinfo`.`sclass`, `studentinfo`.`ssec`, `studentinfo`.`sroll` ");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);
	}
	//FOR CLASS ID,SECTION ID, ROLL NO,BATCH TO BE ADDED
	function get_student_batch_details_by_sid($sid)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `studentinfo`.`sclass`, `studentinfo`.`ssec`,`studentinfo`.`sroll`
			FROM `studentinfo` 
			WHERE `studentinfo`.`sid`= '$sid' ");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);
	}

	// function get_student_id_by_className($className)
	// {
	// 	require("../config/config.php");
	// 	$className = $this->get_student_class_id_by_name($className);
	// 	$response = array();
	// 	$result = mysqli_query($db, "SELECT * FROM `studentinfo` where sclass='$className'");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		array_push($response,array(
	// 			"sid" => $row['sid'],
	// 			"sname" => $row['sname'],
	// 		));
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);
	// }

	//hackster krishna magh 2075
	function get_active_student_id_by_class_id($class_id)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `sid`,`sname` FROM `studentinfo` WHERE `sclass` = '$class_id' AND `status` = 0");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				"sname" => $row['sname'],
			));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	function get_bus_id_by_student_id($student_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT bus_id FROM transportation where`stid`= '$student_id' ");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->bus_id;
	}	

	function get_student_name_by_student_id($student_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT sname FROM studentinfo where`sid`= '$student_id' ");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->sname;
	}	
//============================== end student record section ===================
	
//================== Student transaction =======================================
	//hackster 24/jan/2019
	function insert_into_student_transaction($type , $bill_print_id , $std_id , $student_due_id , $credit , $debit , $advance , $discount , $fine , $payment_mode , $payment_number , $payment_source , $payment_by , $date , $description){
		require("../config/config.php");
		$qry = "INSERT INTO `student_transaction` (`type` , `bill_print_id`, `std_id`, `student_due_id`, `credit`, `debit`, `advance`, `discount`, `fine`, `payment_mode`, `payment_number`, `payment_source`, `payment_by`, `date`, `description`) VALUES ('$type', '$bill_print_id', '$std_id', '$student_due_id', '$credit', '$debit', '$advance', '$discount', '$fine', '$payment_mode', '$payment_number', '$payment_source', '$payment_by', '$date','$description')";
        $result = mysqli_query($db,$qry);
        mysqli_close($db);
        
        return $result;
        //$this->createlog($qry);
	}
	//hackster 24/jan/2019
	function get_advance_amount_from_student_transaction_by_student_id($std_id){
		require("../config/config.php");

        $result = mysqli_query($db,	"SELECT `advance` FROM `student_transaction` WHERE `std_id` = '$std_id' ORDER BY `id` DESC LIMIT 1");

        $count=mysqli_num_rows($result);
        $value = mysqli_fetch_object($result);
		mysqli_close($db);
		if($count>0){ return $value->advance; }else{ return 0;}
		
	}
	//Krishna mandal 25-01-2019
	function get_debit_student_transaction_list_by_bill_id($bill_print_id){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `student_transaction`.* ,`student_due`.`feetype_id`, `student_due`.`balance` , `student_due`.`date` AS `balance_date` ,`fee_types`.`feetype_title`  
			FROM `student_transaction` 
			INNER JOIN `student_due` ON `student_transaction`.`student_due_id` = `student_due`.`id`
			LEFT JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` 
			WHERE bill_print_id='$bill_print_id' AND type=0");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"id" => $row['id'],
				"bill_print_id" => $row['bill_print_id'],
				"std_id" => $row['std_id'],
				"student_due_id" => $row['student_due_id'],
				"feetype_id" => $row['feetype_id'],
				"balance" => $row['balance'],
				"balance_date" => $row['balance_date'],
				"debit" => $row['debit'],
				"advance" => $row['advance'],
				"discount" => $row['discount'],
				"fine" => $row['fine'],
				"date" => $row['date'],
				"description" => $row['description'],
				"feetype_title" => $row['feetype_title'],
				
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//Krishna mandal 25-01-2019
	function get_debit_student_transaction_list_group_by_feetype_by_bill_id($bill_print_id){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT 
						SUM(`student_transaction`.`debit`) as debit, 
						SUM(`student_transaction`.`discount`) AS discount, 
						SUM(`student_transaction`.`fine`) AS fine ,
						`student_transaction`.`date` ,
						`student_transaction`.`description` ,

						`student_due`.`feetype_id`, 
						SUM(`student_due`.`balance`) AS `balance` , 
						GROUP_CONCAT(`student_due`.`date`) AS `balance_date`,
						COUNT(`student_due`.`date`) AS `total_month` ,

						`fee_types`.`feetype_title`  

			FROM `student_transaction` 
			INNER JOIN `student_due` ON `student_transaction`.`student_due_id` = `student_due`.`id`
			LEFT JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` 
			WHERE `student_transaction`.`bill_print_id` = '$bill_print_id' AND `student_transaction`.`type` = 0 GROUP BY `student_due`.`feetype_id` ORDER BY `student_due`.`feetype_id`, `student_due`.`date`	");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"debit" => $row['debit'],
				"discount" => $row['discount'],
				"fine" => $row['fine'],
				"date" => $row['date'],
				"description" => $row['description'],

				"feetype_id" => $row['feetype_id'],
				"balance" => $row['balance'],
				"balance_date" => $row['balance_date'],
				"total_month" => $row['total_month'],

				"feetype_title" => $row['feetype_title'],
				
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//Krishna mandal 25-01-2019
	function get_credit_student_transaction_list_by_bill_id($bill_print_id){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `student_transaction` WHERE bill_print_id='$bill_print_id' AND type=1");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"id" => $row['id'],
				"bill_print_id" => $row['bill_print_id'],
				"std_id" => $row['std_id'],
				"credit" => $row['credit'],
				"advance" => $row['advance'],
				"payment_mode" => $row['payment_mode'],
				"payment_source" => $row['payment_source'],
				"payment_number" => $row['payment_number'],
				"payment_by" => $row['payment_by'],
				"date" => $row['date'],
				"description" => $row['description'],
				
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}


	//Krishna mandal 25-01-2019
	function get_statement_by_student_id_single_date($student_id,$date){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `student_transaction`.* ,`student_due`.`feetype_id`, `student_due`.`balance` , `student_due`.`date` AS `balance_date` , `fee_types`.`feetype_title` 
			FROM `student_transaction` 
			LEFT JOIN `student_due` ON `student_transaction`.`student_due_id` = `student_due`.`id`
			LEFT JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` 
			WHERE `student_transaction`.`std_id` = '$student_id' AND `student_transaction`.`date` LIKE '%$date%'
			ORDER BY `student_transaction`.`timestamp` DESC,`student_transaction`.`id` DESC ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(

				"id" => $row['id'],
				"type" => $row['type'],
				"bill_print_id" => $row['bill_print_id'],
				"std_id" => $row['std_id'],
				"student_due_id" => $row['student_due_id'],
				"feetype_id" => $row['feetype_id'],
				"feetype_title" => $row['feetype_title'],
				"balance" => $row['balance'],
				"balance_date" => $row['balance_date'],
				"credit" => $row['credit'],
				"debit" => $row['debit'],
				"advance" => $row['advance'],
				"discount" => $row['discount'],
				"fine" => $row['fine'],
				"payment_mode" => $row['payment_mode'],
				"payment_source" => $row['payment_source'],
				"payment_number" => $row['payment_number'],
				"payment_by" => $row['payment_by'],
				"date" => $row['date'],
				"description" => $row['description'],
				
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//kkm 27 -january -2019
	function get_student_statement_by_student_id_and_twodate($student_id,$first_date,$second_date)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `student_transaction`.* ,`student_due`.`feetype_id`, `student_due`.`balance` , `student_due`.`date` AS `balance_date` , `fee_types`.`feetype_title` 
			FROM `student_transaction` 
			LEFT JOIN `student_due` ON `student_transaction`.`student_due_id` = `student_due`.`id`
			LEFT JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` 
			WHERE `student_transaction`.`std_id` = '$student_id' AND `student_transaction`.`date` >= '$first_date' and `student_transaction`.`date` <='$second_date'
			ORDER BY `student_transaction`.`timestamp` DESC ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"id" => $row['id'],
				"type" => $row['type'],
				"bill_print_id" => $row['bill_print_id'],
				"std_id" => $row['std_id'],
				"student_due_id" => $row['student_due_id'],
				"feetype_id" => $row['feetype_id'],
				"feetype_title" => $row['feetype_title'],
				"balance" => $row['balance'],
				"balance_date" => $row['balance_date'],
				"credit" => $row['credit'],
				"debit" => $row['debit'],
				"advance" => $row['advance'],
				"discount" => $row['discount'],
				"fine" => $row['fine'],
				"payment_mode" => $row['payment_mode'],
				"payment_source" => $row['payment_source'],
				"payment_number" => $row['payment_number'],
				"payment_by" => $row['payment_by'],
				"date" => $row['date'],
				"description" => $row['description'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//Krishna mandal 25-01-2019
	function get_credit_student_transaction_by_bill_id($bill_print_id){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `student_transaction` WHERE bill_print_id='$bill_print_id' AND type=1");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);
	}

	//Krishna mandal 27-03-2019
	function get_day_book_credit_with_class_group_by_date($date){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `class`.`class_id`, `class`.`class_name`, SUM(`student_transaction`.`credit`) AS `income`
				FROM `student_transaction` 
				INNER JOIN `bill_tables` ON `student_transaction`.`bill_print_id` = `bill_tables`.`id`
				INNER JOIN `class` ON `bill_tables`.`class_id` = `class`.`class_id`
				WHERE `student_transaction`.`type` =1 AND `student_transaction`.`date` = '$date'
				GROUP BY `class`.`class_id`");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"class_id" => $row['class_id'],
				"class_name" => $row['class_name'],
				"income" => $row['income'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
	//Krishna mandal 28-03-2019
	function get_day_book_credit_details_by_class_date($class_id,$date){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `studentinfo`.`sid`,`studentinfo`.`sroll`,`studentinfo`.`sname`, `student_transaction`.`credit` AS `income`,`student_transaction`.`bill_print_id`,`bill_tables`.`bill_type`,`bill_tables`.`bill_number`
			, `class`.`class_id`, `class`.`class_name`,`section`.`section_name`
				FROM `student_transaction` 
				INNER JOIN `bill_tables` ON `student_transaction`.`bill_print_id` = `bill_tables`.`id`
				INNER JOIN `studentinfo` ON `student_transaction`.`std_id` = `studentinfo`.`sid`
				INNER JOIN `class` ON `bill_tables`.`class_id` = `class`.`class_id`
				LEFT JOIN `section` ON `bill_tables`.`section_id` = `section`.`section_id`
				WHERE `student_transaction`.`type` =1 AND `student_transaction`.`date` = '$date' AND `class`.`class_id` = '$class_id'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				"sroll" => $row['sroll'],
				"sname" => $row['sname'],
				"class_id" => $row['class_id'],
				"class_name" => $row['class_name'],
				"section_name" => $row['section_name'],
				"income" => $row['income'],
				"bill_print_id" => $row['bill_print_id'],
				"bill_type" => $row['bill_type'],
				"bill_number" => $row['bill_number'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
	//Krishna mandal 27-03-2019
	function get_day_book_credit_with_category_group_by_date($date){
		// require("../config/config.php");
		// $response = array();
		// $result = mysqli_query($db, "SELECT `bill_tables`.`id` AS `bill_id`,`bill_tables`.`bill_type`,`fee_types`.`feetype_id`, `fee_types`.`feetype_title`, SUM(`student_transaction`.`credit`) AS `advance`, SUM(`student_transaction`.`debit`) AS `payment` 
		// 	FROM `student_transaction` 
		// 	INNER JOIN `bill_tables` ON `student_transaction`.`bill_print_id` = `bill_tables`.`id` 
		// 	LEFT JOIN `student_due` ON `student_transaction`.`student_due_id` = `student_due`.`id` 
		// 	LEFT JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` 
		// 	WHERE `student_transaction`.`date` = '$date' 
		// 	AND ((`bill_tables`.`bill_type`=0 AND `student_transaction`.`type`=1) OR (`bill_tables`.`bill_type`=1 AND `student_transaction`.`type`=0)) 
		// 	GROUP BY `fee_types`.`feetype_id`");
		// while($row = mysqli_fetch_assoc($result))
		// {
		// 	array_push($response,array(
		// 		"bill_id" => $row['bill_id'],
		// 		"bill_type" => $row['bill_type'],
		// 		"feetype_id" => $row['feetype_id'],
		// 		"feetype_title" => $row['feetype_title'],
		// 		"advance" => $row['advance'],
		// 		"payment" => $row['payment'],
		// 		));
		// }
		// mysqli_close($db);
		// return json_encode($response);
	}

//================== End Student transaction ===================================

//================== Bill Tables =======================================

	//nsk february 2019
	function generate_new_bill_number($schoolCode)
	{
		$max_bill_table_id = $this->get_max_bill_table_id();
    	$new_bill_table_id = $max_bill_table_id+1;
    	$bill_number = strtolower($schoolCode).'-'.$new_bill_table_id;
		return $bill_number;
	}

	//nsk 29January2019
	function get_max_bill_table_id()
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT  max(id) as 'id' FROM `bill_tables`");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->id;
	}


	//hackster 24/jan/2019
	function add_into_bill_tables($bill_number, $bill_type, $due_before, $advance_before, $advance_paid, $due_after, $advance_after,$class_id,$section_id,$student_roll_no, $date, $print_count , $t_role , $t_id){
		require("../config/config.php");

        $result = mysqli_query($db,"INSERT INTO `bill_tables` (`bill_number`, `bill_type`, `due_before`, `advance_before`, `advance_paid`, `due_after`, `advance_after`, `class_id`, `section_id`, `student_roll_no`, `date`, `print_count`, `t_role`, `t_id`) VALUES ('$bill_number', '$bill_type', '$due_before', '$advance_before', '$advance_paid', '$due_after', '$advance_after','$class_id','$section_id','$student_roll_no', '$date', '$print_count' , '$t_role' , '$t_id')");

        $id = mysqli_insert_id($db);
        mysqli_close($db);
        if ($result) {
        	return $id;
        }else{
        	return false;
        }
        //$this->createlog($qry);
	}
	//krishna kumar 24/01/2019
	function get_last_bill_print_id_by_student_id($std_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT MAX(`bill_print_id`) AS `id` FROM `student_transaction` 
			WHERE `student_transaction`.`std_id` = '$std_id' ");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->id;
	}
	//hackster 24/jan/2019
	function get_bill_list_by_std_id($std_id){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `bill_tables`.* 
			FROM `student_transaction` 
			INNER JOIN `bill_tables` ON `student_transaction`.`bill_print_id` = `bill_tables`.`id`
			WHERE `student_transaction`.`std_id` = '$std_id' GROUP BY `student_transaction`.`bill_print_id`
			ORDER BY `bill_tables`.`id` DESC");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"id" => $row['id'],
				"bill_number" => $row['bill_number'],
				"bill_type" => $row['bill_type'],
				"date" => $row['date'],
				"print_count" => $row['print_count'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
	//hackster 24/jan/2019
	function get_bill_details_by_bill_id($bill_id){
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `bill_tables`.* , `principal`.`pname` , `staff_tbl`.`staff_name`, `class`.`class_name`, `section`.`section_name`
			FROM `bill_tables` 
			LEFT JOIN `principal` ON `bill_tables`.`t_id` = `principal`.`pid`
			LEFT JOIN `staff_tbl` ON `bill_tables`.`t_id` = `staff_tbl`.`stid`
			LEFT JOIN `class` ON `bill_tables`.`class_id` = `class`.`class_id`
			LEFT JOIN `section` ON `bill_tables`.`section_id` = `section`.`section_id`
			WHERE `bill_tables`.`id` = '$bill_id'");

		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);	
	}

	//hackster 24/jan/2019
	function get_advance_bill_details_by_bill_id($bill_id){
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `bill_tables`.* ,`student_transaction`.`credit`, `student_transaction`.`advance`, `student_transaction`.`payment_mode`, `student_transaction`.`payment_source`, `student_transaction`.`payment_number`, `student_transaction`.`payment_by`, `student_transaction`.`payment_by`

			, `principal`.`pname` , `staff_tbl`.`staff_name`, `class`.`class_name`, `section`.`section_name`

			FROM `bill_tables` 
			INNER JOIN `student_transaction` ON `bill_tables`.`id` = `student_transaction`.`bill_print_id` 
			LEFT JOIN `principal` ON `bill_tables`.`t_id` = `principal`.`pid`
			LEFT JOIN `staff_tbl` ON `bill_tables`.`t_id` = `staff_tbl`.`stid`
			LEFT JOIN `class` ON `bill_tables`.`class_id` = `class`.`class_id`
			LEFT JOIN `section` ON `bill_tables`.`section_id` = `section`.`section_id`
			WHERE `bill_tables`.`id` = '$bill_id'");

		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);	
	}


	//hackster 24/jan/2019
	function get_bill_details_by_bill_number($bill_number){
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `bill_tables`.* , `principal`.`pname` , `staff_tbl`.`staff_name`
			FROM `bill_tables` 
			LEFT JOIN `principal` ON `bill_tables`.`t_id` = `principal`.`pid`
			LEFT JOIN `staff_tbl` ON `bill_tables`.`t_id` = `staff_tbl`.`stid`
			WHERE `bill_tables`.`bill_number` = '$bill_number'");

		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);	
	}

	//hackster 24/jan/2019
	function update_bill_tables_increment_print_count_by_bill_id($bill_id){
		require("../config/config.php");

        $result = mysqli_query($db,"UPDATE `bill_tables` SET print_count = print_count+1 WHERE `id` = '$bill_id'");

        mysqli_close($db);
        
        return $result;
	}

//================== End Bill Tables ===================================

//================== Student Due =======================================

	//hackster 21/jan/2019
	function add_fee_into_student_due($std_id, $feetype_id, $balance, $description, $date, $t_role, $t_id, $status)
	{
		require("../config/config.php");
		$qry="INSERT INTO `student_due` (`id`, `std_id`, `feetype_id`, `balance`,  `description`, `date`, `t_role`, `t_id`, `status`) VALUES (null,'$std_id', '$feetype_id', '$balance', '$description', '$date', '$t_role', '$t_id', '$status')";
		$result = mysqli_query($db,$qry );
		mysqli_close($db);
		//$this->createlog($qry);
	}

	//hacksterkrishna 3/feb/2019
	function update_student_due_to_paid_by_id($id){
		require("../config/config.php");
		$result = mysqli_query($db, "UPDATE `student_due` SET status= 0  WHERE `id`='$id'");

		mysqli_close($db);
		if ($result) {
        	return true;
        }else{
        	return false;
        }
	}

	//hacksterkrishna 3/feb/2019
	function get_student_due_balance_by_id($id){
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `balance`
			FROM `student_due`
			WHERE `student_due`.`id` = '$id'");

		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->balance;	
	}


	//hacksterkrishna 3/feb/2019
	function get_student_due_full_details_by_id($id){
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `student_due`.`id` ,`student_due`.`feetype_id`, `student_due`.`balance`, `student_due`.`description`, `student_due`.`date`, `student_due`.`status`, `student_due`.`timestamp`
			, `fee_types`.`feetype_title`

			, `principal`.`pname` , `staff_tbl`.`staff_name`
			FROM `student_due` 
			INNER JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` 
			LEFT JOIN `principal` ON `student_due`.`t_id` = `principal`.`pid`
			LEFT JOIN `staff_tbl` ON `student_due`.`t_id` = `staff_tbl`.`stid`
			WHERE `student_due`.`id` = '$id'");

		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);	
	}

	//hackster 21/jan/2019
	function get_pending_active_student_due_list()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `student_due`.`std_id`
			FROM `student_due` 
			INNER JOIN `studentinfo` ON `student_due`.`std_id` = `studentinfo`.`sid` 
			WHERE  `studentinfo`.`status` = 0 AND `student_due`.`status` = 1 GROUP BY `student_due`.`std_id` ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"std_id" => $row['std_id'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//hackster 21/jan/2019
	function get_pending_all_student_due_list()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `student_due`.`std_id`
			FROM `student_due`  
			WHERE  `student_due`.`status` = 1 GROUP BY `student_due`.`std_id` ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"std_id" => $row['std_id'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//hacksterkrishna feb/2019
	function get_total_balance_from_student_due_by_std_id($std_id){
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT SUM(`balance`) AS `total_balance`
			FROM `student_due`
			WHERE `student_due`.`std_id` = '$std_id' AND `student_due`.`status` = 1 
			GROUP BY `student_due`.`std_id` ");

		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->total_balance;	
	}

	/*function insert_data_into_student_bill($std_id, $feetype_id, $balance, $payment, $discount, $paid, $fine, $update_date, $last_payment_date, $status)
	{
		require("../config/config.php");
		$qry="INSERT INTO `student_bill` (`bill_id`, `bill_print_id`, `std_id`, `feetype_id`, `balance`, `payment`, `discount`, `paid`, `fine`, `update_date`, `last_payment_date`, `description`, `user_name`, `status`) VALUES (null,0,'$std_id', '$feetype_id', '$balance', '$payment', '$discount', '$paid', '$fine', '$update_date', '$last_payment_date','','', '$status')";
		$result = mysqli_query($db,$qry );
		mysqli_close($db);
		$this->createlog($qry);
	}*/

	// function update_student_bill($bill_id,$bill_print_id,$payment,$discount,$paid,$fine,$last_payment_date,$description,$user_name, $status,$paidby)
	// {
	// 	require("../config/config.php");
	// 	$qry="UPDATE `student_bill` SET `bill_print_id`='$bill_print_id', `payment`='$payment',`discount`='$discount',`paid`= '$paid',`fine`= '$fine',`last_payment_date`='$last_payment_date',`description`='$description',`user_name`='$user_name',`status`='$status' WHERE bill_id='$bill_id'";
 //        mysqli_query($db, $qry);
 //        mysqli_close($db);
	// 	$this->createlog($qry);


	// }

	// function update_student_bill_add_deu($bill_id,$balance,$date,$description,$status)
	// {
	// 	require("../config/config.php");
	// 	$qry = "UPDATE `student_bill` SET balance='$balance', `description`='$description',`status`='$status'  WHERE bill_id='$bill_id'";
 //        mysqli_query($db, $qry);
 //        mysqli_close($db);
	// 	$this->createlog($qry);

       
	// }
	
	// function update_balance_by_bill_id($balance,$bill_id,$date)
	// {
	// 	//$date = date('Y-m-d');
	// 	require("../config/config.php");
	// 	$qry="UPDATE `student_bill` SET balance='$balance',update_date='$date' WHERE bill_id='$bill_id'";
	// 	$result = mysqli_query($db, $qry);
	// 	mysqli_close($db);
	// 	$this->createlog($qry);

		
	// }

	

	//hackster 21/jan/2019
	function check_fee_exist_by_feetypeid_sid_year_month($feetype_id,$sid,$year,$month)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `id`  FROM `student_due` WHERE `std_id` = '$sid' AND `feetype_id` = '$feetype_id' AND YEAR(`date`) = '$year'  AND MONTH(`date`) = '$month'");

		$count=mysqli_num_rows($result);
		mysqli_close($db);
		if($count>0){ return true; }else{ return false;}
	}

	//hackster 21/jan/2019
	function check_fee_exist_by_feetypeid_sid_year($feetype_id,$sid,$year)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `id`  FROM `student_due` WHERE `std_id` = '$sid' AND `feetype_id` = '$feetype_id' AND YEAR(`date`) = '$year'");

		$count=mysqli_num_rows($result);
		mysqli_close($db);
		if($count>0){ return true; }else{ return false;}
	}


	// function get_max_bill_id_by_feetype_id_sid($feetype_id,$sid)
	// {
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT max(bill_id) as 'bill_id'  FROM `student_bill` where std_id='$sid' and feetype_id='$feetype_id'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	return $value->bill_id;
	// }

	// function get_update_date_by_bill_id($bill_id)
	// {
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT update_date  FROM `student_bill` where bill_id='$bill_id'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	if($value->update_date=='')
	// 	{
	// 		return 'null';
	// 	}
	// 	else
	// 	{
	// 		return $value->update_date;
	// 	} 
		
	// }
	
	// function get_student_bill_details_by_bill_id($bill_id)
	// 	{
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT balance,update_date,status  FROM `student_bill` where bill_id='$bill_id'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	return json_encode($value);		
	// 	}

	//hackster 21/jan/2019
	function get_total_student_due_by_student_id_status($student_id,$status)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `student_due`.`id` , `student_due`.`std_id`, `student_due`.`feetype_id`, `fee_types`.`feetype_title` , SUM(`balance`) AS total_balance , COUNT(date) AS total_month 
			FROM `student_due` 
			LEFT JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` WHERE  std_id='$student_id' AND `status` = '$status' GROUP BY `student_due`.`feetype_id` ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"id" => $row['id'],
				"std_id" => $row['std_id'],
				"feetype_id" => $row['feetype_id'],
				"feetype_title" => $row['feetype_title'],
				"total_balance" => $row['total_balance'],
				"total_month" => $row['total_month'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	//hackster 21/jan/2019
	function get_due_type_details_by_feetype_id_student_id_status($feetype_id,$student_id,$status)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `student_due`.`id`, `student_due`.`std_id`, `student_due`.`feetype_id` , `balance` , `student_due`.`description` , `student_due`.`date` , `student_due`.`t_role`, `student_due`.`t_id` , `principal`.`pname` , `staff_tbl`.`staff_name`
			FROM `student_due`
			LEFT JOIN `principal` ON `student_due`.`t_id` = `principal`.`pid`
			LEFT JOIN `staff_tbl` ON `student_due`.`t_id` = `staff_tbl`.`stid` 
			WHERE `student_due`.`feetype_id` = '$feetype_id' AND  `student_due`.`std_id` = '$student_id' AND `student_due`.`status` = '$status' ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"id" => $row['id'],
				"std_id" => $row['std_id'],
				"feetype_id" => $row['feetype_id'],
				"balance" => $row['balance'],
				"description" => $row['description'],
				"date" => $row['date'],
				"t_role" => $row['t_role'],
				"t_id" => $row['t_id'],
				"pname" => $row['pname'],
				"staff_name" => $row['staff_name'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}


	// function get_pending_amount_by_status_sid($status,$sid)
	// {
	// 	require("../config/config.php");
	// 	$response = array();
	// 	$result = mysqli_query($db, "SELECT * FROM `student_bill` where status!='$status' and std_id='$sid'");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		array_push($response,array(
	// 			"bill_id" => $row['bill_id'],
	// 			"std_id" => $row['std_id'],
	// 			"feetype_id" => $row['feetype_id'],
	// 			"balance" => $row['balance'],
	// 			"payment" => $row['payment'],
	// 			"discount" => $row['discount'],
	// 			"paid" => $row['paid'],
	// 			"fine" => $row['fine'],
	// 			"update_date" => $row['update_date'],
	// 			"last_payment_date" => $row['last_payment_date'],
	// 			"status" => $row['status'],
				
	// 			));
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);
	// }

	// function get_pending_list_by_sid($sid)
	// {
	// 	require("../config/config.php");
	// 	$response = array();
	// 	$result = mysqli_query($db, "SELECT * FROM `student_bill` where status='Pending' and std_id='$sid'");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		array_push($response,array(
	// 			"bill_id" => $row['bill_id'],
	// 			"std_id" => $row['std_id'],
	// 			"feetype_id" => $row['feetype_id'],
	// 			"balance" => $row['balance'],
	// 			"payment" => $row['payment'],
	// 			"discount" => $row['discount'],
	// 			"paid" => $row['paid'],
	// 			"fine" => $row['fine'],
	// 			"update_date" => $row['update_date'],
	// 			"last_payment_date" => $row['last_payment_date'],
	// 			"status" => $row['status'],
				
	// 			));
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);
	// }

	// function get_balance_by_bill_id($bill_id)
	// {
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT  balance FROM `student_bill` where bill_id='$bill_id'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	if($value->balance == 0)
	// 	{
	// 		return 0;
	// 	}
	// 	else
	// 	{
	// 		return $value->balance;
	// 	}
	// }

	// function get_student_bill_deatails_by_bill_id($bill_id)
	// {
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT  * FROM `student_bill` where bill_id='$bill_id'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	if(empty($value))
	// 	{
	// 		return "null";
	// 	}
	// 	else
	// 	{
	// 		return $value;
	// 	}
		
	// }


	// function get_status_by_bill_id($bill_id)
	// {
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT  status FROM `student_bill` where bill_id='$bill_id'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	return $value->status;
	// }

	// function get_stdent_bill_record_by_current_date()
	// {
	// 	require("../config/config.php");
	// 	global $nepaliDate;
	// 	$current_date = $nepaliDate->full;
	// 	$response = array();
	// 	$result = mysqli_query($db, "SELECT  * FROM `student_bill` where last_payment_date='$current_date' and status='Paid'");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		array_push($response,array(
	// 			"bill_id" => $row['bill_id'],
	// 			"std_id" => $row['std_id'],
	// 			"feetype_id" => $row['feetype_id'],
	// 			"balance" => $row['balance'],
	// 			"payment" => $row['payment'],
	// 			"discount" => $row['discount'],
	// 			"paid" => $row['paid'],
	// 			"fine" => $row['fine'],
	// 			"update_date" => $row['update_date'],
	// 			"last_payment_date" => $row['last_payment_date'],
	// 			"status" => $row['status'],
				
	// 			));
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);
	// }
	

//================== End student bill section =======================================		
//=================== extra fee list tables ===================
	//Krishna Kumar mandal feb 2019
	function insert_into_extra_fee_collection_tables($class_id,$feetype_id,$amount,$description,$date){
		require("../config/config.php");
		$qry="INSERT INTO `extra_fee_list` (`extra_fee_id`, `classId`, `feeTypeId`, `amount`, `description`, `date`) VALUES (null,'$class_id','$feetype_id','$amount','$description','$date')";
		$result = mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);
		return $result;
	}
	
	//Krishna Kumar mandal feb 2019
	function get_extra_fee_type_list(){
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `extra_fee_list`.`extra_fee_id`,`extra_fee_list`.`amount`,`extra_fee_list`.`description`,`extra_fee_list`.`date`,`class`.`class_name`,`fee_types`.`feetype_title` 
			FROM `extra_fee_list`
			LEFT JOIN `class` ON `extra_fee_list`.`classId` = `class`.`class_id`
			LEFT JOIN `fee_types` ON `extra_fee_list`.`feeTypeId` = `fee_types`.`feetype_id`
			 ORDER BY `extra_fee_list`.`extra_fee_id` DESC");
		while($row=mysqli_fetch_assoc($result))
		{
			array_push($response, array(
				'extra_fee_id'=>$row['extra_fee_id'],
				'amount'=>$row['amount'],
				'description'=>$row['description'],
				'date'=>$row['date'],
				'class_name'=>$row['class_name'],
				'feetype_title'=>$row['feetype_title'],
			));
		}
		mysqli_close($db);
		return json_encode($response);
	}
//=================== end extra fee list tables ===================		
	
//================== Fee type section ================================================
	function insert_feetype($feetype)
	{
		$feetype = str_replace('_', ' ', $feetype);
		
		require("../config/config.php");
		$qry="INSERT INTO `fee_types` (`feetype_title`) VALUES ('$feetype')";
		$result = mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);
		return $result;
	}

	function delete_feetype($id)
	{
		require("../config/config.php");
		$qry="DELETE FROM `fee_types` WHERE feetype_id='$id'";
		mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);
	}

	function update_feetype($id,$feetype)
	{
		$feetype = str_replace('_', ' ', $feetype);
		require("../config/config.php");
		$qry="UPDATE `fee_types` SET `feetype_title`='$feetype' WHERE feetype_id='$id'";
		mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);

	}

	//check and remove
	function get_feetype_by_feetype_id($feetype_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT  feetype_title FROM `fee_types` where feetype_id='$feetype_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->feetype_title;
	}

	function get_feetype_title_by_feetype_id($feetype_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT  feetype_title FROM `fee_types` where feetype_id='$feetype_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->feetype_title;
	}

	function get_feetype_id_by_feetype_title($feetype_title)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT feetype_id FROM `fee_types` WHERE feetype_title='$feetype_title'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->feetype_id;
	}	
	//krishna hackster 6 feb 2019
	function get_feetype_details()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `fee_types`");
		while($row = mysqli_fetch_assoc($result))

		{
			array_push($response,array(
				"feetype_id" => $row['feetype_id'],
				"feetype_title" => $row['feetype_title'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
//================== End Fee type section ============================================	
//================== bill print tables ===============================================
	// function get_max_bill_print_id()
	// {
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT  max(bill_print_id) as 'bill_print_id' FROM `bill_tables`");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	return $value->bill_print_id;
	// }

	/*function get_max_bill_print_id_by_student_id($std_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT max(bill_print_id) as 'bill_print_id' FROM `bill_tables` WHERE  std_id='$std_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->bill_print_id;
	}*/

	function get_bill_status_by_max_id($bill_print_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT status FROM `bill_tables` WHERE  bill_print_id='$bill_print_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->status;
	}


	function get_bill_number_by_max_id($bill_print_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT bill_number FROM `bill_tables` WHERE  bill_print_id='$bill_print_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->bill_number;
	}

	function update_bill_print_status($bill_print_id)
	{
		require("../config/config.php");
		$qry="UPDATE `bill_tables` SET `status`='true' WHERE  bill_print_id='$bill_print_id'";
		mysqli_query($db, $qry);
		mysqli_close($db);
		$this->createlog($qry);

	}
	function insert_insert_bill_print_tables($std_id,$bill_number,$status,$date)
	{
		require("../config/config.php");
        
        $qry="INSERT INTO `bill_tables` (`bill_print_id`, `std_id`, `bill_number`, `status`,`date`,`number_of_copies`) VALUES (null,'$std_id','$bill_number','$status','$date',0)";
		mysqli_query($db, $qry);
        mysqli_close($db);
        $this->createlog($qry);    
	}

//================== end bill print tables ===========================================	


//================== teacher tables =================================================
	
	function get_employee_salary($tid)
         {
         	require("../config/config.php");
			$result = mysqli_query($db, "SELECT tsalary FROM `teachers` WHERE tid='$tid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->tsalary;
        }
	function get_employee_details_by_empId($empId)
	        {
	        	require("../config/config.php");
				$result = mysqli_query($db, "SELECT * FROM `teachers` WHERE tid='$empId'");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
	        }
	function get_teacher_details()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM `teachers` WHERE status = 0 ");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"tid" => $row['tid'],
					"tname" => $row['tname'],
					"temail" => $row['temail'],
					"tgetter" => $row['tgetter'],
					"taddress" => $row['taddress'],
					"tmobile" => $row['tmobile'],
					"tclock" => $row['tclock'],
					"tcount" => $row['tcount'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"t_father" => $row['t_father'],
					"t_mother" => $row['t_mother'],
					"timage" => $row['timage'],
					"tsalary" => $row['tsalary'],
					"status" => $row['status'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
		}

		function get_teacher_record_by_tid($tid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `teachers` where tid='$tid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}

		function get_teacher_salary_by_tid($tid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT tsalary  FROM `teachers` where tid='$tid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->tsalary;
		}

		function get_teacher_name_by_teacherId($tid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT tname  FROM `teachers` where tid='$tid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->tname;
		}

 

//================== end teacher tables =============================================	
//================== teacher account tables =========================================
        function get_employee_account_details_by_empId($empId)
        {
        	require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `teacher_account_tables` WHERE tid='$empId'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
        }

	 function update_employee_balance_by_empId($teacher_account_id,$balance,$withdrowal_balance,$last_payment_date)
	        {
	        	require("../config/config.php");
	        	$qry="UPDATE `teacher_account_tables` SET `current_balance`='$balance',`total_withdrawal`='$withdrowal_balance',`withdrawal_date`= '$last_payment_date' WHERE teacher_account_id='$teacher_account_id'";
				$result = mysqli_query($db, $qry);
				mysqli_close($db);
			$this->createlog($qry);

				
				
			}

			
	function create_teacher_account($tid, $current_balance, $total_withdrawal, $current_update_date, $withdrawal_date)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "INSERT INTO `teacher_account_tables` (`tid`, `current_balance`, `total_withdrawal`, `current_update_date`, `withdrawal_date`) VALUES ('$tid', '$current_balance', '$total_withdrawal', '$current_update_date', '$withdrawal_date')");
			mysqli_close($db);
		}

		function get_teacher_account_id_by_tid($tid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT teacher_account_id  FROM `teacher_account_tables` where tid='$tid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->teacher_account_id;
		}

		function get_current_balance_by_teacher_account_id($teacher_account_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT current_balance  FROM `teacher_account_tables` where teacher_account_id='$teacher_account_id'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->current_balance;
		}

		function get_current_update_date_by_teacher_account_id($teacher_account_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT current_update_date  FROM `teacher_account_tables` where teacher_account_id='$teacher_account_id'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->current_update_date;
		}

		
		function update_teacher_balance($tid,$current_balance,$current_update_date)
		{
			require("../config/config.php");
			$qry="UPDATE `teacher_account_tables` SET `current_balance`='$current_balance',`current_update_date`='$current_update_date' WHERE tid='$tid'";
			$result = mysqli_query($db, $qry);
			mysqli_close($db);
			$this->createlog($qry);

			
		}

	function get_last_payment_to_employee_date($tid)
	         {
	         	require("../config/config.php");
				$result = mysqli_query($db, "SELECT withdrawal_date FROM `teacher_account_tables` WHERE tid='$tid'");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return $value->withdrawal_date;
	         }
         
		function get_teacher_account_details_by_teacher_account_id($tid)
        {
        	require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM teacher_account_tables WHERE tid='$tid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
			
		}

		function get_last_update_date_from_teacher_account_tables()
        {
        	require("../config/config.php");
			$result = mysqli_query($db, "SELECT current_update_date FROM teacher_account_tables");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->current_update_date;
        }

        
//================== end teacher account tables =====================================

//================= pay me tables ===================================================
		function get_max_id_pay_me()
        {
        	require("../config/config.php");
			$result = mysqli_query($db, "SELECT max(pme_id) as 'pme_id' FROM `pay_me`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->pme_id;
        }

        function get_pme_details_by_id($pme_id)
        {
        	require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `pay_me` where pme_id = '$pme_id'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
        }

        
		
        

		function get_teacher_advance_by_teacher_id_status($tid)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT advance FROM `pay_me` where teacher_id='$tid' and status='Pending'");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"advance" => $row['advance'],
				));
			}
			mysqli_close($db);
			return json_encode($response);
		}

		
	function update_advance_status($tid)
	{
		require("../config/config.php");
		$qry="UPDATE `pay_me` SET `status`='Paid' WHERE teacher_id='$tid'";
		$result = mysqli_query($db, $qry);
		mysqli_close($db);
		$this->createlog($qry);

		
	}

	function insert_teacher_payment($tid,$staff_id,$bonus,$advance,$deduction,$net_pay,$last_payment_date,$description,$user_name,$status)
	{
		require("../config/config.php");
		$qry="INSERT INTO pay_me (`teacher_id`, `staff_id`, `bonus`, `advance`, `deduction`, `net_pay`, `paid_date`, `description`, `user_name`, `status`)VALUES('$tid','$staff_id','$bonus','$advance','$deduction','$net_pay','$last_payment_date','$description','$user_name','$status')";
	    mysqli_query($db, $qry);
	    mysqli_close($db);
	    $this->createlog($qry);
  
	}

	function get_teacher_payment_record_by_teacher_id_date($teacher_id,$date)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `pay_me` where teacher_id='$teacher_id' and paid_date like '%$date%' ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"pme_id" => $row['pme_id'],
				"teacher_id" => $row['teacher_id'],
				"bonus" => $row['bonus'],
				"advance" => $row['advance'],
				"deduction" => $row['deduction'],
				"net_pay" => $row['net_pay'],
				"paid_date" => $row['paid_date'],
				"description" => $row['description'],
				"user_name" => $row['user_name'],
				"status" => $row['status'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	function get_teacher_payment_record_by_current_date()
	{
		global $nepaliDate;


		$current_date = $nepaliDate->full;
		require("../config/config.php");
		//require("nepaliDate.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `pay_me` where paid_date='$current_date' ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"pme_id" => $row['pme_id'],
				"teacher_id" => $row['teacher_id'],
				"bonus" => $row['bonus'],
				"advance" => $row['advance'],
				"deduction" => $row['deduction'],
				"net_pay" => $row['net_pay'],
				"paid_date" => $row['paid_date'],
				"description" => $row['description'],
				"user_name" => $row['user_name'],
				"status" => $row['status'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	function get_teacher_payment_record_by_teacher_id_two_date($teacher_id,$first_date,$second_date)
	{
		require("../config/config.php");		
		$first_date = date('Y-m-d',strtotime($first_date));
		$second_date = date('Y-m-d',strtotime($second_date));
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `pay_me` where teacher_id='$teacher_id' and paid_date>= '$first_date' and paid_date<='$second_date' ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"pme_id"=>$row['pme_id'],
				"teacher_id" => $row['teacher_id'],
				"bonus" => $row['bonus'],
				"advance" => $row['advance'],
				"deduction" => $row['deduction'],
				"net_pay" => $row['net_pay'],
				"paid_date" => $row['paid_date'],
				"description" => $row['description'],
				"user_name" => $row['user_name'],
				"status" => $row['status'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}


//================= end pay me tables ===============================================

//================= expenses tables =================================================
	//============================= expenses section ==============================

	//hackster krishna feb 2019
	function get_expenses_category_list()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `expenses_cat`");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"ecat_id" => $row['ecat_id'],
				"exp_cat" => $row['exp_cat'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	

	function insertExpensesCategory($category)
	{
		$category = str_replace('_', ' ', $category);
		require("../config/config.php");
		$qry="INSERT INTO `expenses_cat` (`exp_cat`) VALUES ('$category');";
		mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);
	}

	function deleteExpensesCategory($deleteId)
	{
		require("../config/config.php");
		$qry="DELETE FROM `expenses_cat` WHERE ecat_id='$deleteId'";
		mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);
	}

	function updateExpensesCategory($ecat_id,$category)
	{
		$category = str_replace('_', ' ', $category);
		require("../config/config.php");
		$qry="UPDATE `expenses_cat` SET `exp_cat`='$category' WHERE ecat_id = '$ecat_id'";
		mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);

		
	}

	function getExpensesCategoryById($ecat_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT exp_cat FROM `expenses_cat` WHERE ecat_id='$ecat_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->exp_cat;
	}

	//hacksterkrishna feb 2019
	function insertExpenses($bill_print_id, $ecat_id, $expenses_title , $quantity, $rate, $amount, $file, $description, $date)
	{
		require("../config/config.php");
		$qry="INSERT INTO `expenses_add`(`bill_print_id`, `ecat_id`, `expenses_title`, `quantity`, `rate`, `amount`, `file`, `description`, `date`, `status`) VALUES ('$bill_print_id','$ecat_id','$expenses_title', '$quantity', '$rate', '$amount', '$file', '$description', '$date', 1)";
		$result = mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);
		return $result;
		
	}

	function getExpenses()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `expenses_add`.* , `bill_tables`.`bill_number` ,`expenses_cat`.`exp_cat`
			FROM `expenses_add`
			LEFT JOIN `bill_tables` ON `expenses_add`.`bill_print_id` = `bill_tables`.`id`
			LEFT JOIN `expenses_cat` ON `expenses_add`.`ecat_id` = `expenses_cat`.`ecat_id`
			ORDER BY `expenses_add`.`exp_id` ASC");

		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"exp_id" => $row['exp_id'],
				"bill_print_id" => $row['bill_print_id'],
				"bill_number" => $row['bill_number'],
				"ecat_id" => $row['ecat_id'],
				"exp_cat" => $row['exp_cat'],
				"expenses_title" => $row['expenses_title'],
				"quantity" => $row['quantity'],
				"rate" => $row['rate'],
				"amount" => $row['amount'],
				"file" => $row['file'],
				"description" => $row['description'],
				"date" => $row['date'],
				"status" => $row['status'],
				"timestamp" => $row['timestamp'],				
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	function getExpenses_by_current_date()
	{
		global $nepaliDate;

		$current_date = $nepaliDate->full;
		require("../config/config.php");
		//require("nepaliDate.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `expenses_add` where date='$current_date'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"exp_id" => $row['exp_id'],
				"ecat" => $row['ecat'],
				"name" => $row['name'],
				"quantity" => $row['quantity'],
				"expfile" => $row['expfile'],
				"expamount" => $row['expamount'],
				"expdesc" => $row['expdesc'],
				"date" => $row['date'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}


//================= end expenses tables =============================================	

//================ income tables ====================================================
	function getExtraIncome()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `incometables`.* , `bill_tables`.`bill_number` FROM `incometables` 
			LEFT JOIN `bill_tables` ON `incometables`.`bill_print_id` = `bill_tables`.`id` 
			ORDER BY `incometables`.`income_id` DESC  ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"income_id" => $row['income_id'],
				"income_type" => $row['income_type'],
				"income_amount" => $row['income_amount'],
				"income_description" => $row['income_description'],
				"payment_mode" => $row['payment_mode'],
				"payment_source" => $row['payment_source'],
				"payment_number" => $row['payment_number'],
				"payment_by" => $row['payment_by'],
				"date" => $row['date'],
				"status" => $row['status'],
				"bill_number" => $row['bill_number'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	function getExtraIncome_by_current_date()
	{
		global $nepaliDate;

		$current_date = $nepaliDate->full;
		require("../config/config.php");
		//require("nepaliDate.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `incometables` where date='$current_date'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"incomeId" => $row['incomeId'],
				"schoolAccountId" => $row['schoolAccountId'],
				"incomeType" => $row['incomeType'],
				"incomeAmount" => $row['incomeAmount'],
				"incomedescription" => $row['incomedescription'],
				"date" => $row['date'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
	//hackster krishna feb 2019
	function insertIncome($bill_print_id, $income_type, $amount, $description, $payment_mode, $payment_source, $payment_number, $payment_by, $date)
	{
		require("../config/config.php");
		$qry="INSERT INTO `incometables` (`bill_print_id`, `income_type`, `income_amount`, `income_description`, `payment_mode`, `payment_source`, `payment_number`, `payment_by`, `date`, `status` ) VALUES ('$bill_print_id', '$income_type', '$amount', '$description', '$payment_mode', '$payment_source', '$payment_number', '$payment_by', '$date', 1 )";
		$result = mysqli_query($db,$qry);
		mysqli_close($db);
		//$this->createlog($qry);
		return $result;
	}

	//hackster krishna feb 2019
	function deleteIncome($deleteId)
	{
		require("../config/config.php");
		$qry="UPDATE `incometables` SET `status`=0 WHERE income_Id='$deleteId'";
		$result = mysqli_query($db, $qry);
		mysqli_close($db);
		//$this->createlog($qry);
		return $result;
	}
	//hackster updated feb 2019
	function getIncomeById($income_id)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT * FROM `incometables` where income_id='$income_id' ");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);
	}
	//updated by krishna feb 2019 remove update amount
	function updateIncome($incomeId, $income_type, $description,$payment_by, $date)
	{
		require("../config/config.php");
		$qry="UPDATE `incometables` SET `income_type`='$income_type',`income_description`='$description',`payment_by`='$payment_by',`date`='$date' WHERE income_id='$incomeId'";
		$result = mysqli_query($db, $qry);
		mysqli_close($db);
		return $result;
		//$this->createlog($qry);

	}

//================ end income tables ================================================
//===================== school details tables ==========================
	function get_school_details_by_id()
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT * FROM `schooldetails`");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return json_encode($value);
		
	}
	function update_account_date($newdate)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "UPDATE `schooldetails` SET `account_date`= '$newdate' ");
		mysqli_close($db);
		
	}
//========================== end school details tables ==========================

//========================= school account tables ===================================

	function insertSchoolAccount($incomeFrom, $expensesTo, $schoolIncome, $schoolExpenses, $date)
	{
		require("../config/config.php");
		$qry="INSERT INTO `school_account_tables`(`incomeFrom`, `expensesTo`, `schoolIncome`, `schoolExpenses`, `date`) VALUES ('$incomeFrom', '$expensesTo', '$schoolIncome', '$schoolExpenses', '$date')";
		mysqli_query($db, $qry);
		mysqli_close($db);
		$this->createlog($qry);
	}

	function updateSchoolAccount($schoolAccountId,$incomeFrom, $expensesTo, $schoolIncome, $schoolExpenses, $date)
	{
		require("../config/config.php");
		$qry="UPDATE `school_account_tables` SET `incomeFrom`='$incomeFrom',`expensesTo`='$expensesTo',`schoolIncome`='$schoolIncome',`schoolExpenses`='$schoolExpenses',`date`='$date' WHERE schoolAccountId='$schoolAccountId'";
		mysqli_query($db, $qry);
		mysqli_close($db);
		$this->createlog($qry);
	}

	// function get_school_expenses_record()
	// {
	// 	require("../config/config.php");
	// 	$response = array();
	// 	$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where schoolIncome=0 and expensesTo!='Teacher'");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		array_push($response,array(
	// 			"schoolAccountId" => $row['schoolAccountId'],
	// 			"expensesTo" => $row['expensesTo'],
	// 			"schoolExpenses" => $row['schoolExpenses'],
	// 			"date" => $row['date'],
	// 			));
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);
	// }

	function get_school_expenses_record_by_single_date($date)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date like '%$date%' and schoolIncome=0 and expensesTo!='Teacher'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"schoolAccountId" => $row['schoolAccountId'],
				"expensesTo" => $row['expensesTo'],
				"schoolExpenses" => $row['schoolExpenses'],
				"date" => $row['date'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	function get_school_expenses_record_by_two_date($first_date,$second_date)
	{
		require("../config/config.php");
		$first_date = date('Y-m-d',strtotime($first_date));
		$second_date = date('Y-m-d',strtotime($second_date));
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date>='$first_date' and date<='$second_date' and schoolIncome=0 and expensesTo!='Teacher'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"schoolAccountId" => $row['schoolAccountId'],
				"expensesTo" => $row['expensesTo'],
				"schoolExpenses" => $row['schoolExpenses'],
				"date" => $row['date'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}


	// function get_school_expenses_to_teacher()
	// {
	// 	require("../config/config.php");
	// 	$teacher_expenses = 0;
	// 	$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where schoolIncome=0 and expensesTo='Teacher'");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		$teacher_expenses = $teacher_expenses + $row['schoolExpenses'];
			
	// 	}
	// 	mysqli_close($db);
	// 	return $teacher_expenses;
	// }

	function get_school_expenses_to_teacher_by_date($date)
	{
		require("../config/config.php");
		$teacher_expenses = 0;
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date like '%$date%' and schoolIncome=0 and expensesTo='Teacher'");
		while($row = mysqli_fetch_assoc($result))
		{
			$teacher_expenses = $teacher_expenses + $row['schoolExpenses'];
			
		}
		mysqli_close($db);
		return $teacher_expenses;
	}

	function get_school_expenses_to_teacher_by_two_date($first_date,$second_date)
	{
		require("../config/config.php");
		$first_date = date('Y-m-d',strtotime($first_date));
		$second_date = date('Y-m-d',strtotime($second_date));
		$teacher_expenses = 0;
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date>='$first_date' and date<='$second_date' and schoolIncome=0 and expensesTo='Teacher'");
		while($row = mysqli_fetch_assoc($result))
		{
			$teacher_expenses = $teacher_expenses + $row['schoolExpenses'];
			
		}
		mysqli_close($db);
		return $teacher_expenses;
	}


	// function get_school_income_record()
	// {
	// 	require("../config/config.php");
	// 	$response = array();
	// 	$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where schoolExpenses=0 and incomeFrom !='Student'");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		array_push($response,array(
	// 			"schoolAccountId" => $row['schoolAccountId'],
	// 			"incomeFrom" => $row['incomeFrom'],
	// 			"schoolIncome" => $row['schoolIncome'],
	// 			"date" => $row['date'],
	// 			));
			
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);
	// }

	function get_school_income_record_by_date($date)
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date like '%$date%' and schoolExpenses=0 and incomeFrom !='Student'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"schoolAccountId" => $row['schoolAccountId'],
				"incomeFrom" => $row['incomeFrom'],
				"schoolIncome" => $row['schoolIncome'],
				"date" => $row['date'],
				));
			
		}
		mysqli_close($db);
		return json_encode($response);
	}

	function get_school_income_record_by_two_date($first_date,$second_date)
	{
		require("../config/config.php");
		$first_date = date('Y-m-d',strtotime($first_date));
		$second_date = date('Y-m-d',strtotime($second_date));
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date>='$first_date' and date<='$second_date' and schoolExpenses=0 and incomeFrom !='Student'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"schoolAccountId" => $row['schoolAccountId'],
				"incomeFrom" => $row['incomeFrom'],
				"schoolIncome" => $row['schoolIncome'],
				"date" => $row['date'],
			));		
		}
		mysqli_close($db);
		return json_encode($response);
	}

	// function get_school_income_record_from_student()
	// {
	// 	require("../config/config.php");
	// 	$student_amount = 0;
	// 	$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where schoolExpenses=0 and incomeFrom='Student' ");
	// 	while($row = mysqli_fetch_assoc($result))
	// 	{
	// 		$student_amount = $student_amount + $row['schoolIncome'];
	// 	}
	// 	mysqli_close($db);
	// 	return $student_amount;
	// }

	function get_school_income_record_from_student_by_date($date)
	{
		require("../config/config.php");
		$student_amount = 0;
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date like '%$date%' and schoolExpenses=0 and incomeFrom='Student' ");
		while($row = mysqli_fetch_assoc($result))
		{
			$student_amount = $student_amount + $row['schoolIncome'];
		}
		mysqli_close($db);
		return $student_amount;
	}

	function get_school_income_record_from_student_by_two_date($first_date,$second_date)
	{
		require("../config/config.php");
		$first_date = date('Y-m-d',strtotime($first_date));
		$second_date = date('Y-m-d',strtotime($second_date));
		$student_amount = 0;
		$result = mysqli_query($db, "SELECT * FROM `school_account_tables` where date>='$first_date' and date<='$second_date' and schoolExpenses=0 and incomeFrom='Student' ");
		while($row = mysqli_fetch_assoc($result))
		{
			$student_amount = $student_amount + $row['schoolIncome'];
		}
		mysqli_close($db);
		return $student_amount;
	}


	function getMaxSchoolAccountId()
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT max(schoolAccountId) as 'schoolAccountId'  FROM `school_account_tables`");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->schoolAccountId;
	}
//now===================================
	//hackster feb 2019
	function get_incomeType_list()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `incometables`");
		while($row = mysqli_fetch_assoc($result))

		{
			array_push($response,array(
				"income_id" => $row['income_id'],
				"income_type" => $row['income_type'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

	

	function total_income()
	{
		require("../config/config.php");
		$schoolIncome = 0;
		$result = mysqli_query($db, "SELECT schoolIncome FROM `school_account_tables`");
		while($row = mysqli_fetch_assoc($result))
		{
			$schoolIncome = $schoolIncome + $row['schoolIncome'];
		}
		mysqli_close($db);
		return $schoolIncome;
	}

	function total_expenses()
	{
		require("../config/config.php");
		$schoolExpenses = 0;
		$result = mysqli_query($db, "SELECT schoolExpenses FROM `school_account_tables`");
		while($row = mysqli_fetch_assoc($result))
		{
			$schoolExpenses = $schoolExpenses + $row['schoolExpenses'];
		}
		mysqli_close($db);
		return $schoolExpenses;
	}

	function get_total_income_current_date()
	{
		global $nepaliDate;
		
		$current_date = $nepaliDate->full;
		require("../config/config.php");
		//require("nepaliDate.php");
		$schoolIncome = 0;
		$result = mysqli_query($db, "SELECT schoolIncome FROM `school_account_tables` where date='$current_date' ");
		while($row = mysqli_fetch_assoc($result))
		{
			$schoolIncome = $schoolIncome + $row['schoolIncome'];
		}
		mysqli_close($db);
		return $schoolIncome;
	}

	function get_total_expenses_current_date()
	{
		global $nepaliDate;
		
		$current_date = $nepaliDate->full;
		require("../config/config.php");
		//require("nepaliDate.php");
		$schoolExpenses = 0;
		$result = mysqli_query($db, "SELECT schoolExpenses FROM `school_account_tables` where date='$current_date'");
		while($row = mysqli_fetch_assoc($result))
		{
			$schoolExpenses = $schoolExpenses + $row['schoolExpenses'];
		}
		mysqli_close($db);
		return $schoolExpenses;
	}
//========================== end school account tables ==========================
//========================== extra function ==========================
    function get_number_in_word($num)
    {
    	if ($num==0 || $num=='0') {
    		return 'Zero rupees only';
    	}

       $number = $num;
	   $no = round($number);
	   $point = round($number - $no, 2) * 100;
	   $hundred = null;
	   $digits_1 = strlen($no);
	   $i = 0;
	   $str = array();
	   $words = array('0' => 'zero', '1' => 'one', '2' => 'two',
	    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
	    '7' => 'seven', '8' => 'eight', '9' => 'nine',
	    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
	    '13' => 'thirteen', '14' => 'fourteen',
	    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
	    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
	    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
	    '60' => 'sixty', '70' => 'seventy',
	    '80' => 'eighty', '90' => 'ninety');
	   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
	   while ($i < $digits_1) {
	     $divider = ($i == 2) ? 10 : 100;
	     $number = floor($no % $divider);
	     $no = floor($no / $divider);
	     $i += ($divider == 10) ? 1 : 2;
	     if ($number) {
	        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
	        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
	        $str [] = ($number < 21) ? $words[$number] .
	            " " . $digits[$counter] . $plural . " " . $hundred
	            :
	            $words[floor($number / 10) * 10]
	            . " " . $words[$number % 10] . " "
	            . $digits[$counter] . $plural . " " . $hundred;
	     } else $str[] = null;
	  }
	  $str = array_reverse($str);
	  $result = implode('', $str);
	  $points = ($point && $point>0) ?
	    "." . $words[$point / 10] . " " . 
	          $words[$point = $point % 10]. " paise" : '';
	   $res=$result . "rupees  " . $points . "only" ;
	   	return ucfirst($res);    
    }

    function get_nepali_month($m)
    {
             $eMonth = false;
             switch($m){
                 case 1:
                     $eMonth = "Baishak";
                     break;
                 case 2:
                     $eMonth = "Jestha";
                     break;
                 case 3:
                     $eMonth = "Ashar";
                     break;
                 case 4:
                     $eMonth = "Shrawan";
                     break;
                 case 5:
                     $eMonth = "Bhadra";
                     break;
                 case 6:
                     $eMonth = "Ashoj";
                     break;
                 case 7:
                     $eMonth = "Kartik";
                     break;
                 case 8:
                     $eMonth = "Mangsir";
                     break;
                 case 9:
                     $eMonth = "Poush";
                     break;
                 case 10:
                     $eMonth = "Magh";
                     break;
                 case 11:
                     $eMonth = "Falgun";
                     break;
                 case 12:
                     $eMonth = "Chaitra";
             }
             return $eMonth;
         }


         public function get_nepali_month_num($month)
         {
             $n_month = false;
                 
             switch($month){
                 case "Baishak":
                     $n_month = 1;
                     break;
                         
                 case "Jestha":
                     $n_month = 2;
                     break;
                         
                 case "Ashar":
                     $n_month = 3;
                     break;
                         
                 case "Shrawan":
                     $n_month = 4;
                     break;
                         
                 case "Bhadra":
                     $n_month = 5;
                     break;

                 case "Ashoj":
                     $n_month = 6;
                     break;
 
                 case "Kartik":
                     $n_month = 7;
                     break;

                 case "Mangsir":
                     $n_month = 8;
                     break;

                 case "Poush":
                     $n_month = 9;
                     break;

                 case "Magh":
                     $n_month = 10;
                     break;

                 case "Falgun":
                     $n_month = 11;
                     break;

                 case "Chaitra":
                     $n_month = 12;
                     break;
             }
             return  $n_month;
            //return $month;
         }

//========================== end extra function ==========================	
//========================= start my function ========================	

   function get_student_class_name_by_id($sid)
   {
   	require("../config/config.php");
		$result = mysqli_query($db, "SELECT class_name FROM class WHERE class_id='$sid'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->class_name;

   }

   function get_student_class_id_by_name($sclass)
   {
   	require("../config/config.php");
		$result = mysqli_query($db, "SELECT class_id FROM class WHERE class_name='$sclass'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->class_id;

   }
   function get_section_name_by_section_id($sec_id)
   {
   	require("../config/config.php");
		$result = mysqli_query($db, "SELECT section_name FROM section WHERE section_id='$sec_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->section_name;	
   }

   function get_section_id_by_name($sec_name)
   {
   	require("../config/config.php");
		$result = mysqli_query($db, "SELECT section_id FROM section WHERE section_class='$sec_name'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value;   		
   }

 //   function update_student_bill_edit_deu($bill_id,$balance,$status)
	// {
	// 	require("../config/config.php");
	// 	$qry = "UPDATE `student_bill` SET balance='$balance',`status`='$status'  WHERE bill_id='$bill_id'";
 //        mysqli_query($db, $qry);
 //        mysqli_close($db);
	// 	$this->createlog($qry);       
	// }

     function createlog($qry)
     {
     	$index=0;
     	require("../config/config.php");
     	$action = 'wertwe';
     	if(strpos(strtoupper($qry),'INSERT')>-1) {
     		$action = 'Insert';
     		//$index = strpos(strtoupper($qry),'INTO');
     		$index=2;
     	} else if(strpos(strtoupper($qry),'UPDATE')>-1) {
     		$action = 'Edit';
     		//$index = strpos(strtoupper($qry),'UPDATE');
     		$index=1;
     	} else if(strpos(strtoupper($qry),'DELETE')>-1) {
     		$action = 'Delete';
     		//$index = strpos(strtoupper($qry),'FROM');
     		$index=2;
     	} else {
     		$action = '';
     	}
     	$qry = mysqli_real_escape_string($db,$qry);
     	$tableArray = explode(' ', strtoupper($qry));
     	$table= $tableArray[$index];
     	$user = 1; //change this to currently logged in user id;
     	$result = mysqli_query($db,"INSERT INTO account_log(user_id,user_type,`table_name`,`action`,`query`) VALUES('$user','accountant','$table','$action','$qry')");
     	mysqli_close($db);
     }

    function get_fee_rate_by_class_and_feetype_title($class,$a,$student_id)
    {
        require("../config/config.php");
        //$class=$this->get_student_class_name_by_id($class);
		$result = mysqli_query($db, "SELECT $a as a FROM studentinfo WHERE sclass='$class' and sid='$student_id'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->a;
    }


    function get_student_discount_by_student_id($sid)
    {
		require("../config/config.php");
		$response=array();
		$result = mysqli_query($db, "SELECT tution_discount_percent,bus_discount_percent,hostel_discount_percent,computer_discount_percent FROM `studentinfo` WHERE sid='$sid'");
		
		while($row = mysqli_fetch_assoc($result))
		{	

			array_push($response,array(
				"tution_discount_percent"=>$row['tution_discount_percent'],
				"bus_discount_percent"=>$row['bus_discount_percent'],
				"hostel_discount_percent"=>$row['hostel_discount_percent'],
				"computer_discount_percent"=>$row['computer_discount_percent'],
			));
		}
		mysqli_close($db);
		return json_encode($response);
    }

 //    function get_student_bill_details($sclass)
	// 	{
	// 	$sclass=$this->get_student_class_id_by_name($sclass);
	// 	require("../config/config.php");
	// 	$response=array();
	// 	$result=mysqli_query($db,"SELECT * FROM studentinfo WHERE `sclass`='$sclass' AND `status` = 0  ORDER BY `studentinfo`.`ssec`");
	// 	while ($row=mysqli_fetch_assoc($result)) 
	// 	{
	// 		array_push($response,array(
	// 			"sid"=>$row['sid'],
	// 			"sname"=>$row['sname'],
	// 			"ssec"=>$row['ssec'],
	// 			"sroll"=>$row['sroll'],

	// 		));
			
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);

	// }
	// function get_student_balance($sid)
	// 	{
	// 	require("../config/config.php");
	// 	$response=array();
	// 	$result=mysqli_query($db,"SELECT `student_bill`.`balance`, `fee_types`.`feetype_title` FROM student_bill LEFT JOIN `fee_types` ON `student_bill`.`feetype_id`=`fee_types`.`feetype_id` WHERE `std_id`='$sid' and `status`='pending' ORDER BY `student_bill`.`feetype_id` ASC");
	// 	while ($row=mysqli_fetch_assoc($result)) 
	// 	{
	// 		array_push($response,array(
	// 			"balance"=>$row['balance'],
	// 			"feetype_title"=>$row['feetype_title'],
	// 		));
			
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);

	// }

	// function get_fee_from_student_bill_with_studentinfo($sclass)
	// {
	// 	$sclass = $this->get_student_class_id_by_name($sclass);
	// 	require("../config/config.php");
	// 	$response=array();
	// 	$result=mysqli_query($db,"SELECT `fee_types`.`feetype_title` 
	// 		FROM student_bill 
	// 		INNER JOIN studentinfo ON `student_bill`.`std_id` = `studentinfo`.`sid` 
	// 		INNER JOIN fee_types ON `student_bill`.`feetype_id`=`fee_types`.`feetype_id`  
	// 		WHERE `studentinfo`.`sclass`='$sclass' AND `studentinfo`.`status` = 0 
	// 		GROUP BY `student_bill`.`feetype_id` 
	// 		ORDER BY `student_bill`.`feetype_id` ASC");
	// 	while ($row=mysqli_fetch_assoc($result)) 
	// 	{
	// 		array_push($response,array(
	// 			"feetype_title"=>$row['feetype_title'],			

	// 		));
			
	// 	}
	// 	mysqli_close($db);
	// 	return json_encode($response);
	// }
//-----------------------------------




//To find transportation charge
	// function get_transportation_fee_by_sid($sid)
	// {

	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT bus_fee_rate FROM `transportation` WHERE stid='$sid'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	return $value->bus_fee_rate;

	// }

	// function get_extra_fee_by_class_name($sclass)
	// {
	// 	require("../config/config.php");
	// 	$result = mysqli_query($db, "SELECT amount FROM `transportation` WHERE classname='$sclass'");
	// 	$value = mysqli_fetch_object($result);
	// 	mysqli_close($db);
	// 	return $value->amount;		
	// }

//========================== end my function ==========================	

function english_to_nepali_date_converter($date)
{
	
}

function nepali_to_english_converter($date)
{

}

//To get school code for bill and currently use in student submit management
function get_school_code_by_student_id($sid)
{
	require("../config/config.php");
	$result=mysqli_query($db,"SELECT `school_code` FROM schooldetails");
	$value=mysqli_fetch_object($result);
	mysqli_close($db);
	return $value->school_code;
}


//to get student id from bill id for school code.Used in student submit management
// function get_student_id_by_bill_id($bill_id)
// {
// 	require("../config/config.php");
// 	$result=mysqli_query($db,"SELECT std_id FROM student_bill WHERE bill_id='$bill_id'");
// 	$value=mysqli_fetch_object($result);
// 	mysqli_close($db);
// 	return $value->std_id;
// }
//this function takes all the tables from accountant database 
function get_list_of_tables_from_database()
{
	require("../config/config.php");
	$response=array();
	$result=mysqli_query($db,"SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema='accountant'");
	while ($row=mysqli_fetch_assoc($result)) {
		array_push($response,array(
				"table_name"=>$row['TABLE_NAME'],			
			));
	}
	mysqli_close($db);
	return json_encode($response);
}

//get list of all bills of a student for the invoice section in fee collectob
function get_bills_list_by_student_id($sid)
{
	require("../config/config.php");
	$response=array();
	$result=mysqli_query($db,"SELECT * FROM bill_tables WHERE std_id='$sid'");
	while ($row=mysqli_fetch_assoc($result)) {
		array_push($response,array(
			"bill_print_id"=>$row['bill_print_id'],
			"std_id"=>$row['std_id'],
			"bill_number"=>$row['bill_number'],
			"status"=>$row['status'],			
			));
	}
	mysqli_close($db);
	return json_encode($response);
}

// manish-15-may-2018

	function get_list_of_table_from_database()
	{
		require("config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema='accountant'");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"table_name" => $row['TABLE_NAME']
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}
	function get_data_from_table_by_table_name($table_name)
	{
		require("config/config.php");
		$result = mysqli_query($db, "SELECT * FROM '$table_name' ");
		$value = mysqli_fetch_assoc($result);
		mysqli_close($db);
		return $value;
	}

	function get_student_bus_fee_details()
	{
		require("config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT `studentinfo`.* ,`class`.`class_name`, `section`.`section_name`, `transportation`.`bus_number`,`bus_route`.`bus_route`, `bus_route`.`bus_fee_rate`
			FROM studentinfo  
			LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
			LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
			LEFT JOIN `bus_route` ON `studentinfo`.`bus_id` = `bus_route`.`bus_route_id` 
			LEFT JOIN `transportation` ON `bus_route`.`transportation_id` = `transportation`.`bus_id` ");
		while($row = mysqli_fetch_assoc($result))
		{
			array_push($response,array(
				"sid" => $row['sid'],
				"sname" => $row['sname'],
				"saddress" => $row['saddress'],
				"sclass" => $row['sclass'],
				"ssec" => $row['ssec'],

				"class_name" => $row['class_name'],
				"section_name" => $row['section_name'],

				"bus_id" => $row['bus_id'],
				"bus_number" => $row['bus_number'],
				"bus_route" => $row['bus_route'],
				"bus_fee_rate" => $row['bus_fee_rate'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

//end of class account management
}
?>