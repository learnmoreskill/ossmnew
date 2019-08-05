<?php
class back_stage_class
{
	
    /*function get_number_in_word($grande_total)
    {
       $number =  $grande_total;
       $no = round($number);
       $point = round($number - $no, 2) * 100;
       $hundred = null;
       $digits_1 = strlen($no);
       $i = 0;
       $str = array();
       $words = array('0' => '', '1' => 'One', '2' => 'Two',
        '3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
        '7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
        '10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
        '13' => 'Thirteen', '14' => 'Fourteen',
        '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
        '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
        '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
        '60' => 'sixty', '70' => 'seventy',
        '80' => 'eighty', '90' => 'ninety');
       $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
       while ($i < $digits_1) 
       {
         $divider = ($i == 2) ? 10 : 100;
         $number = floor($no % $divider);
         $no = floor($no / $divider);
         $i += ($divider == 10) ? 1 : 2;
         if ($number) 
         {
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
      $points = ($point) ?
        "." . $words[$point / 10] . " " . 
              $words[$point = $point % 10] : '';
     return $result . "rupees  ";         
    }
*/
    /*function get_english_month($m)
    {
             $eMonth = false;
             switch($m){
                 case 1:
                     $eMonth = "January";
                     break;
                 case 2:
                     $eMonth = "February";
                     break;
                 case 3:
                     $eMonth = "March";
                     break;
                 case 4:
                     $eMonth = "April";
                     break;
                 case 5:
                     $eMonth = "May";
                     break;
                 case 6:
                     $eMonth = "June";
                     break;
                 case 7:
                     $eMonth = "July";
                     break;
                 case 8:
                     $eMonth = "August";
                     break;
                 case 9:
                     $eMonth = "September";
                     break;
                 case 10:
                     $eMonth = "October";
                     break;
                 case 11:
                     $eMonth = "November";
                     break;
                 case 12:
                     $eMonth = "December";
             }
             return $eMonth;
         }*/


         /*public function get_english_month_num($month)
         {
             $n_month = false;
                 
             switch($month){
                 case "January":
                     $n_month = 1;
                     break;
                         
                 case "February":
                     $n_month = 2;
                     break;
                         
                 case "March":
                     $n_month = 3;
                     break;
                         
                 case "April":
                     $n_month = 4;
                     break;
                         
                 case "May":
                     $n_month = 5;
                     break;

                 case "June":
                     $n_month = 6;
                     break;
 
                 case "July":
                     $n_month = 7;
                     break;

                 case "August":
                     $n_month = 8;
                     break;

                 case "September":
                     $n_month = 9;
                     break;

                 case "October":
                     $n_month = 10;
                     break;

                 case "November":
                     $n_month = 11;
                     break;

                 case "December":
                     $n_month = 12;
                     break;
             }
             return  $n_month;
            //return $month;
         }*/

    
		/*function search($search_term)
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
		}*/

	




	
//======================= SYEAR HISTORY ===================
	function insert_year_into_student_history($student_id,$class_id,$section_id,$roll_no,$payment_type,$tution,$tution_fee,$bus_id,$bus_fee,$hostel,$hostel_fee,$computer,$computer_fee,$year_id,$updated_date)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "INSERT INTO `syearhistory`( `student_id`, `class_id`, `section_id`, `roll_no`, `payment_type`, `tution`, `tution_fee`, `bus_id`, `bus_fee`, `hostel`, `hostel_fee`, `computer`, `computer_fee`, `year_id`, `updated_date`) VALUES ('$student_id', '$class_id', '$section_id', '$roll_no', '$payment_type', '$tution', '$tution_fee', '$bus_id', '$bus_fee', '$hostel', '$hostel_fee', '$computer', '$computer_fee', '$year_id', '$updated_date')");
			mysqli_close($db);
			if ($result) {
				return true;
			}else{
				return false;
			}
		}

	function update_student_details_in_student_history_by_syear_id($syear_id,$class_id,$section_id,$payment_type,$tution,$tution_fee,$bus_id,$bus_fee,$hostel,$hostel_fee,$computer,$computer_fee)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `syearhistory` SET `class_id`='$class_id',`section_id`='$section_id', `payment_type` = '$payment_type', `tution` = '$tution', `tution_fee` = '$tution_fee', `bus_id` = '$bus_id', `bus_fee` = '$bus_fee', `hostel` = '$hostel',`hostel_fee` = '$hostel_fee', `computer` = '$computer',`computer_fee` = '$computer_fee' WHERE `syear_id` = '$syear_id'");
			mysqli_close($db);
			if ($result) {
				return true;
			}else{
				return false;
			}
		}
	function update_student_roll_no_in_student_history_by_syear_id($syear_id,$roll_no)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "UPDATE `syearhistory` SET `roll_no`='$roll_no' WHERE `syear_id` = '$syear_id'");
			mysqli_close($db);
			if ($result) {
				return true;
			}else{
				return false;
			}
		}

	function get_syear_id_from_student_history_by_student_id_year_id($student_id,$year_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT 'syear_id'  FROM `syearhistory` WHERE `student_id`='$student_id' AND `year_id`='$year_id'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->syear_id;
		}
	
//===================== Attendance tables Start ===============================
	function get_present_count_in_class($class_name,$newdate)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT SUM(`abpcount`) AS 'presentcount' FROM `abcheck` WHERE `abclass`='$class_name' AND `abdate`='$newdate'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->presentcount;
		}
	function get_absent_count_in_class($class_name,$newdate)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT SUM(`abacount`) AS 'absentcount' FROM `abcheck` WHERE `abclass`='$class_name' AND `abdate`='$newdate'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->absentcount;
		}
	function get_present_count_in_class_section($class_name,$section,$newdate)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT SUM(`abpcount`) AS 'presentcount' FROM `abcheck` WHERE `abclass`='$class_name' AND `absec` = '$section' AND `abdate`='$newdate'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->presentcount;
		}
	function get_absent_count_in_class_section($class_name,$section,$newdate)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT SUM(`abacount`) AS 'absentcount' FROM `abcheck` WHERE `abclass`='$class_name' AND `absec` = '$section' AND `abdate`='$newdate'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->absentcount;
		}
	function get_check_attendance_taken($class_name,$section,$newdate)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `abid` FROM `abcheck` WHERE `abclass`='$class_name' AND `absec` = '$section' AND `abdate`='$newdate'");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function get_attendance_absent_list_by_student_id_with_limit($student_id)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM `attendance` WHERE `asid`='$student_id' and `astatus`='A' ORDER BY `attendance`.`aclock` DESC LIMIT 10");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"aid" => $row['aid'],
					"asid" => $row['asid'],
					"astatus" => $row['astatus'],
					"aclass" => $row['aclass'],
					"asec" => $row['asec'],
					"aclock" => $row['aclock'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
//===================== Attendance tables end =================================
	
//===================== school details tables Start ===========================
	function get_school_details_by_id()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `schooldetails`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
			
		}
	function check_complaint_bulk()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `sms_complaint`  FROM `schooldetails`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sms_complaint;

		}
	function check_attendance_bulk()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `sms_attendance`  FROM `schooldetails` ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sms_attendance;

		}
	function check_feenotice_bulk()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `sms_feenotice`  FROM `schooldetails`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sms_feenotice;

		}
	function check_nohomework_bulk()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `sms_nohomework`  FROM `schooldetails` ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sms_nohomework;

		}
	function check_broadcast_bulk()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `sms_broadcast`  FROM `schooldetails`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sms_broadcast;

		}
	function get_template_id()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `template_idcard`,`template_admit`,`template_marksheet`,`template_character`,`template_transfer` FROM `schooldetails` ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
			
		}
//===================== school details tables End =============================

//===================== transportaion details tables start ====================
	function get_transportation_details()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `transportation`.* , `staff_tbl`.`stid`, `staff_tbl`.`staff_name`, `staff_tbl`.`staff_mobile`
				FROM `transportation` 
				LEFT JOIN `staff_tbl` ON `transportation`.`stid`=`staff_tbl`.`stid` 
				WHERE `transportation`.`status` = 1");

			while($row = mysqli_fetch_assoc($result))
				{
				array_push($response,array(
					"bus_id" => $row['bus_id'],
					"bus_number" => $row['bus_number'],
					"tracker_type" => $row['tracker_type'],

					"stid" => $row['stid'],
					"staff_name" => $row['staff_name'],
					"staff_mobile" => $row['staff_mobile'],
					));
				}
			mysqli_close($db);
			return json_encode($response);			
		}
	function get_tracker_details_of_admin()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `schooldetails`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);

		}
	function get_transportaion_details_by_id($busid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `transportation` LEFT JOIN `staff_tbl` ON `transportation`.`stid`=`staff_tbl`.`stid` WHERE `bus_id` = '$busid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}
	function get_bus_route_by_transportaion_id($busid)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * FROM `bus_route` WHERE `transportation_id`='$busid' ORDER BY bus_fee_rate ASC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"bus_route_id" => $row['bus_route_id'],
						"bus_route" => $row['bus_route'],
						"bus_stop" => $row['bus_stop'],
						"bus_time" => $row['bus_time'],
						"bus_fee_rate" => $row['bus_fee_rate'],
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
//===================== transportaion details tables end ======================

//===================== examtype details tables start =========================
	//remove after check
	function get_examtype_list()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM `examtype`");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"examtype_id" => $row['examtype_id'],
					"examtype_name" => $row['examtype_name'],					
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
	function get_examtype_list_details_by_date_id($year_id)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM `examtype` WHERE `year_id` = '$year_id'");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"examtype_id" => $row['examtype_id'],
					"examtype_name" => $row['examtype_name'],
					"self_include" => $row['self_include'],					
					"is_monthly" => $row['is_monthly'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
	function get_examinclude_list_by_examtype_id($examtype_id,$year_id)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `exam_include`.* ,`examtype`.`examtype_name`  
				FROM `exam_include`
				LEFT JOIN `examtype` ON `exam_include`.`added_examtype_id` = `examtype`.`examtype_id` 
				WHERE `exam_include`.`examtype_id` = '$examtype_id' AND `exam_include`.`year_id` = '$year_id' ORDER BY `exam_include`.`sort_order` ");
			
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"exam_include_id" => $row['exam_include_id'],
					"added_examtype_id" => $row['added_examtype_id'],
					"examtype_name" => $row['examtype_name'],
					"percent" => $row['percent'],
					"sort_order" => $row['sort_order'],					
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
	function get_examtype_details_by_examid($examtype_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `examtype` WHERE `examtype_id`='$examtype_id'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
			
		}
	function get_exam_created_date_by_class_examtype($classname,$examtype)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT MAX(`exam_created_on`) AS exam_created_date FROM `examtable` WHERE `class_name`='$classname' AND `exam_type`='$examtype' GROUP BY 'exam_created_on'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->exam_created_date;
			
		}
	function get_examtable($classname,$examtype)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM `examtable` LEFT JOIN `subject` ON `examtable`.`subject` = `subject`.`subject_id` LEFT JOIN `class` ON `examtable`.`class_name` = `class`.`class_id` LEFT JOIN `examtype` ON `examtable`.`exam_type` = `examtype`.`examtype_id` WHERE `examtable`.`class_name`='$classname' AND `examtable`.`exam_type`='$examtype'   ORDER BY `date` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"subject_name" => $row['subject_name'],
					"class_name" => $row['class_name'],
					"date" => $row['date'],
					"time" => $row['time'],
					
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}

		//to be removed but first check
	function get_examtable_details_by_class_exam_subject_year_month_id($class_id,$exam_id,$subject_id,$year_id,$month_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `examtable`.*
				FROM `examtable`
				WHERE `examtable`.`class_name` = '$class_id' AND `examtable`.`exam_type` = '$exam_id' AND `examtable`.`subject` = '$subject_id' AND `examtable`.`year_id` = '$year_id' AND `examtable`.`month` = '$month_id' ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}
//===================== examtype details tables end ===========================
	
//===================== Student tables Start ==================================

	function get_all_active_student_details()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.`parent_id`, `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `parents`.`spnumber_2`,`parents`.`spprofession`
				
				FROM `studentinfo` 
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN `parents` ON `studentinfo`.`sparent_id` = `parents`.`parent_id` 
				WHERE `studentinfo`.`status` = 0  
				ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sroll" => $row['sroll'],
					"sadmsnno" => $row['sadmsnno'],
					"sname" => $row['sname'],
					"saddress" => $row['saddress'],
					"semail" => $row['semail'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"admission_date" => $row['admission_date'],
					"class_name" => $row['class_name'],
					"section_name" => $row['section_name'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"simage" => $row['simage'],
					"smobile" => $row['smobile'],

					"payment_type" => $row['payment_type'],
					"tution_fee" => $row['tution_fee'],
					"bus_id" => $row['bus_id'],
					"bus_fee" => $row['bus_fee'],
					"hostel_fee" => $row['hostel_fee'],
					"computer_fee" => $row['computer_fee'],

					"sparent_id" => $row['sparent_id'],
					"spname" => $row['spname'],
					"smname" => $row['smname'],
					"spnumber" => $row['spnumber'],
					"spnumber_2" => $row['spnumber_2'],
					"spprofession" => $row['spprofession'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}

	function get_all_student_details_by_class_section_id_year_id($classId,$sectionId,$year_id)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.`parent_id`, `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `parents`.`spnumber_2`,`parents`.`spprofession`
				
				FROM `studentinfo` 
				INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN `parents` ON `studentinfo`.`sparent_id` = `parents`.`parent_id` 
				WHERE `studentinfo`.`status` = 0 " . (empty($classId) ? "" : "AND `syearhistory`.`class_id`='$classId' ") . (empty($sectionId) ? "" : "AND `syearhistory`.`section_id`='$sectionId' ") . "  AND `syearhistory`.`year_id` = '$year_id'
				ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sroll" => $row['sroll'],
					"sadmsnno" => $row['sadmsnno'],
					"sname" => $row['sname'],
					"saddress" => $row['saddress'],
					"semail" => $row['semail'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"admission_date" => $row['admission_date'],
					"class_name" => $row['class_name'],
					"section_name" => $row['section_name'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"simage" => $row['simage'],
					"smobile" => $row['smobile'],

					"payment_type" => $row['payment_type'],
					"tution_fee" => $row['tution_fee'],
					"bus_id" => $row['bus_id'],
					"bus_fee" => $row['bus_fee'],
					"hostel_fee" => $row['hostel_fee'],
					"computer_fee" => $row['computer_fee'],

					"sparent_id" => $row['sparent_id'],
					"spname" => $row['spname'],
					"smname" => $row['smname'],
					"spnumber" => $row['spnumber'],
					"spnumber_2" => $row['spnumber_2'],
					"spprofession" => $row['spprofession'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
	function get_all_active_student_details_by_class_section_id($classId,$sectionId)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.`parent_id`, `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `parents`.`spnumber_2`,`parents`.`spprofession`
				
				FROM `studentinfo` 
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN `parents` ON `studentinfo`.`sparent_id` = `parents`.`parent_id` 
				WHERE `studentinfo`.`status` = 0 " . (empty($classId) ? "" : "AND `studentinfo`.`sclass`='$classId' ") . (empty($sectionId) ? "" : "AND `studentinfo`.`ssec`='$sectionId' ") . "  
				ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sroll" => $row['sroll'],
					"sadmsnno" => $row['sadmsnno'],
					"sname" => $row['sname'],
					"saddress" => $row['saddress'],
					"semail" => $row['semail'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"admission_date" => $row['admission_date'],
					"class_name" => $row['class_name'],
					"section_name" => $row['section_name'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"simage" => $row['simage'],
					"smobile" => $row['smobile'],

					"payment_type" => $row['payment_type'],
					"tution_fee" => $row['tution_fee'],
					"bus_id" => $row['bus_id'],
					"bus_fee" => $row['bus_fee'],
					"hostel_fee" => $row['hostel_fee'],
					"computer_fee" => $row['computer_fee'],

					"sparent_id" => $row['sparent_id'],
					"spname" => $row['spname'],
					"smname" => $row['smname'],
					"spnumber" => $row['spnumber'],
					"spnumber_2" => $row['spnumber_2'],
					"spprofession" => $row['spprofession'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
	function get_all_active_student_details_with_bus_details()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.`parent_id`, `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `parents`.`spnumber_2`,`parents`.`spprofession`, `bus_route`.`bus_route`, `bus_route`.`bus_stop`, `bus_route`.`bus_fee_rate`, `transportation`.`bus_number`
				
				FROM `studentinfo` 
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN `parents` ON `studentinfo`.`sparent_id` = `parents`.`parent_id`

				LEFT JOIN `bus_route` ON `studentinfo`.`bus_id` = `bus_route`.`bus_route_id` 
				LEFT JOIN `transportation` ON `bus_route`.`transportation_id` = `transportation`.`bus_id`

				WHERE `studentinfo`.`status` = 0
				ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sroll" => $row['sroll'],
					"sadmsnno" => $row['sadmsnno'],
					"sname" => $row['sname'],
					"saddress" => $row['saddress'],
					"semail" => $row['semail'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"admission_date" => $row['admission_date'],
					"class_name" => $row['class_name'],
					"section_name" => $row['section_name'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"simage" => $row['simage'],
					"smobile" => $row['smobile'],
					
					"payment_type" => $row['payment_type'],
					"bus_id" => $row['bus_id'],
					"bus_fee" => $row['bus_fee'],
					"bus_route" => $row['bus_route'],
					"bus_stop" => $row['bus_stop'],
					"bus_fee_rate" => $row['bus_fee_rate'],
					"bus_number" => $row['bus_number'],

					"sparent_id" => $row['sparent_id'],
					"spname" => $row['spname'],
					"smname" => $row['smname'],
					"spnumber" => $row['spnumber'],
					"spnumber_2" => $row['spnumber_2'],
					"spprofession" => $row['spprofession'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
	function get_all_active_student_details_with_bus_details_by_class_section_id($classId,$sectionId){
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.`parent_id`, `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `parents`.`spnumber_2`, `parents`.`spprofession`, `bus_route`.`bus_route`, `bus_route`.`bus_stop`, `bus_route`.`bus_fee_rate`, `transportation`.`bus_number`
				
				FROM `studentinfo` 
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN `parents` ON `studentinfo`.`sparent_id` = `parents`.`parent_id`

				LEFT JOIN `bus_route` ON `studentinfo`.`bus_id` = `bus_route`.`bus_route_id` 
				LEFT JOIN `transportation` ON `bus_route`.`transportation_id` = `transportation`.`bus_id`

				WHERE `studentinfo`.`status` = 0 " . (empty($classId) ? "" : "AND `studentinfo`.`sclass`='$classId' ") . (empty($sectionId) ? "" : "AND `studentinfo`.`ssec`='$sectionId' ") . "
				ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sroll" => $row['sroll'],
					"sadmsnno" => $row['sadmsnno'],
					"sname" => $row['sname'],
					"saddress" => $row['saddress'],
					"semail" => $row['semail'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"admission_date" => $row['admission_date'],
					"class_name" => $row['class_name'],
					"section_name" => $row['section_name'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"simage" => $row['simage'],
					"smobile" => $row['smobile'],
					
					"payment_type" => $row['payment_type'],
					"bus_id" => $row['bus_id'],
					"bus_fee" => $row['bus_fee'],
					"bus_route" => $row['bus_route'],
					"bus_stop" => $row['bus_stop'],
					"bus_fee_rate" => $row['bus_fee_rate'],
					"bus_number" => $row['bus_number'],

					"sparent_id" => $row['sparent_id'],
					"spname" => $row['spname'],
					"smname" => $row['smname'],
					"spnumber" => $row['spnumber'],
					"spnumber_2" => $row['spnumber_2'],
					"spprofession" => $row['spprofession'],
					));
			}
			mysqli_close($db);
			return json_encode($response);		
	}

	function get_all_active_student_details_with__hostel_bus_details_by_class_section_id($classId,$sectionId){
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.`parent_id`, `parents`.`spname`, `parents`.`smname`, `parents`.`spnumber`, `parents`.`spnumber_2`, `parents`.`spprofession`, `bus_route`.`bus_route`, `bus_route`.`bus_stop`, `bus_route`.`bus_fee_rate`, `transportation`.`bus_number`
				
				FROM `studentinfo` 
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN `parents` ON `studentinfo`.`sparent_id` = `parents`.`parent_id`

				LEFT JOIN `bus_route` ON `studentinfo`.`bus_id` = `bus_route`.`bus_route_id` 
				LEFT JOIN `transportation` ON `bus_route`.`transportation_id` = `transportation`.`bus_id`

				WHERE `studentinfo`.`status` = 0 " . (empty($classId) ? "" : "AND `studentinfo`.`sclass`='$classId' ") . (empty($sectionId) ? "" : "AND `studentinfo`.`ssec`='$sectionId' ") . "
				ORDER BY `class`.`class_name` ASC, `section`.`section_name` ASC, `studentinfo`.`sroll` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sroll" => $row['sroll'],
					"sadmsnno" => $row['sadmsnno'],
					"sname" => $row['sname'],
					"saddress" => $row['saddress'],
					"semail" => $row['semail'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"admission_date" => $row['admission_date'],
					"class_name" => $row['class_name'],
					"section_name" => $row['section_name'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"simage" => $row['simage'],
					"smobile" => $row['smobile'],


					"payment_type" => $row['payment_type'],
					"tution_fee" => $row['tution_fee'],
					"hostel_fee" => $row['hostel_fee'],
					"computer_fee" => $row['computer_fee'],


					
					"bus_id" => $row['bus_id'],
					"bus_fee" => $row['bus_fee'],
					"bus_route" => $row['bus_route'],
					"bus_stop" => $row['bus_stop'],
					"bus_fee_rate" => $row['bus_fee_rate'],
					"bus_number" => $row['bus_number'],

					"sparent_id" => $row['sparent_id'],
					"spname" => $row['spname'],
					"smname" => $row['smname'],
					"spnumber" => $row['spnumber'],
					"spnumber_2" => $row['spnumber_2'],
					"spprofession" => $row['spprofession'],
					));
			}
			mysqli_close($db);
			return json_encode($response);	
	}

	function get_student_full_details_by_sid($sid){
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `parents`.*, `class`.`class_name`, `section`.`section_name` 
				FROM `studentinfo`
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN parents ON studentinfo.`sparent_id`=`parents`.`parent_id` 
				WHERE studentinfo.`sid`= '$sid' ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
	}

	function get_student_full_details_by_student_id_year_id($student_id , $year_id){
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `parents`.*, `class`.`class_name`, `section`.`section_name` 
				FROM `syearhistory`
				INNER JOIN `studentinfo` ON `syearhistory`.`student_id` = `studentinfo`.`sid` 
				LEFT JOIN `class` ON `syearhistory`.`class_id` = `class`.`class_id`
				LEFT JOIN `section` ON `syearhistory`.`section_id` = `section`.`section_id`
				LEFT JOIN parents ON studentinfo.`sparent_id`=`parents`.`parent_id` 
				WHERE `syearhistory`.`year_id` = '$year_id' AND `syearhistory`.`student_id`= '$student_id' ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
	}

	function get_student_details_by_sid($sid){
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT *
				FROM `studentinfo`
				WHERE `studentinfo`.`sid`= '$sid' ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
	}

	function check_student_email_exist($email){
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
	}

	function check_student_email_exist_except_id($email,$sid){
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email' AND `sid`<>'$sid')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
	}

	function get_max_student_id(){
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT max(sid) as 'sid'  FROM `studentinfo`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sid;
	}

	function get_max_student_admission_number($sid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `sadmsnno`  FROM `studentinfo` WHERE `sid`='$sid'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sadmsnno;
		}
	function get_max_student_roll_number_from_class_sec($class,$sec)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT max(sroll) as 'sroll'  FROM `studentinfo` WHERE `sclass`='$class' AND `ssec`='$sec' AND `status`=0");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->sroll;
		}
	function get_student_count_in_class($class_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT COUNT(`sid`) AS 'stdcount' FROM `studentinfo` WHERE `sclass`='$class_id' AND `status`=0");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->stdcount;
		}
	function get_student_count_in_class_section($class,$section)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT COUNT(`sid`) AS 'stdcount' 
				FROM `studentinfo` 
				WHERE `sclass`='$class' AND `ssec`='$section' AND `status`=0");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->stdcount;
		}
	function get_student_details_by_parent_id($parent_id)
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name` 
				FROM `studentinfo` 
				LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
				LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
				LEFT JOIN `transportation` ON studentinfo.`bus_id`=`transportation`.`bus_id` 
				WHERE `sparent_id` = '$parent_id' AND `studentinfo`.`status` = 0 
				ORDER BY `studentinfo`.`sid`");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"sid" => $row['sid'],
					"sroll" => $row['sroll'],
					"sadmsnno" => $row['sadmsnno'],
					"sname" => $row['sname'],
					"saddress" => $row['saddress'],
					"semail" => $row['semail'],
					"sclass" => $row['sclass'],
					"ssec" => $row['ssec'],
					"class_name" => $row['class_name'],
					"section_name" => $row['section_name'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"simage" => $row['simage'],
					"smobile" => $row['smobile'],
					"tution_discount_percent" => $row['tution_discount_percent'],
					"bus_id" => $row['bus_id'],
					"bus_discount_percent" => $row['bus_discount_percent'],
					"hostel_discount_percent" => $row['hostel_discount_percent'],
					"computer_discount_percent" => $row['computer_discount_percent'],
					"bus_route" => $row['bus_route'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
//===================== Student tables end ====================================

//===================== Class & Section Start =================================
		function get_class_list()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `class_id`,`class_name` 
					FROM `class` 
					WHERE `status` = 0 
					ORDER BY `sort_order` ");

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
		function get_class_list_by_year_id($year_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `class_id`,`class_name` 
					FROM `class` 
					WHERE `year_id` = '$year_id' AND `status` = 0 
					ORDER BY `sort_order` ");

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
		function get_class_details_by_class_id($class_id){
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT *
					FROM `class`
					WHERE `class_id`= '$class_id' ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
		}
		//remove below function coz no year id ,first check
		function get_class_list_details()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * 
					FROM `class` 
					WHERE `status` = 0 
					ORDER BY `sort_order` ");

				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"class_id" => $row['class_id'],
						"class_name" => $row['class_name'],
						"class_symbolic" => $row['class_symbolic'],
						"sort_order" => $row['sort_order'],
						"tution_fee" => $row['tution_fee'],						
						"computer_fee" => $row['computer_fee'],
						"hostel_fee" => $row['hostel_fee'],
						"admission_charge" => $row['admission_charge'],
						"annual_fee" => $row['annual_fee'],
						"eaxm_fee" => $row['eaxm_fee'],
						"uniform_fee" => $row['uniform_fee'],
						"book_fee" => $row['book_fee'],
						"monthly_testfee" => $row['monthly_testfee'],
						"registration_fee" => $row['registration_fee'],
						"security_fee" => $row['security_fee'],

					));
				}
				mysqli_close($db);
				return json_encode($response);
			
			}
		function get_class_list_details_by_year_id($year_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * 
					FROM `class` 
					WHERE `year_id` = '$year_id' AND `status` = 0 
					ORDER BY  `sort_order` ");

				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"class_id" => $row['class_id'],
						"class_name" => $row['class_name'],
						"class_symbolic" => $row['class_symbolic'],
						"sort_order" => $row['sort_order'],
						"tution_fee" => $row['tution_fee'],						
						"computer_fee" => $row['computer_fee'],
						"hostel_fee" => $row['hostel_fee'],
						"admission_charge" => $row['admission_charge'],
						"annual_fee" => $row['annual_fee'],
						"eaxm_fee" => $row['eaxm_fee'],
						"uniform_fee" => $row['uniform_fee'],
						"book_fee" => $row['book_fee'],
						"monthly_testfee" => $row['monthly_testfee'],
						"registration_fee" => $row['registration_fee'],
						"security_fee" => $row['security_fee'],

					));
				}
				mysqli_close($db);
				return json_encode($response);
			
			}
		function get_class_section_by_teacher_id($tid)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `section`.`section_id`, `section`.`section_name`, `class`.`class_id`, `class`.`class_name` 
					FROM `section` 
					INNER JOIN `class` ON `section`.`section_class` = `class`.`class_id` 
					WHERE `teacher_id` = '$tid' 
					ORDER BY `section`.`section_name`");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"class_name" => $row['class_name'],
						"section_name" => $row['section_name'],
						"class_id" => $row['class_id'],
						"section_id" => $row['section_id'],						
					));
				}
				mysqli_close($db);
				return json_encode($response);
			
			}
		function get_class_section_by_teacher_id_year_id($teacher_id,$year_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `section`.`section_id`, `section`.`section_name`, `class`.`class_id`, `class`.`class_name` 
					FROM `section` 
					INNER JOIN `class` ON `section`.`section_class` = `class`.`class_id` 
					WHERE `teacher_id` = '$teacher_id' AND `section`.`year_id`= '$year_id'
					ORDER BY `section`.`section_name`");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"class_name" => $row['class_name'],
						"section_name" => $row['section_name'],
						"class_id" => $row['class_id'],
						"section_id" => $row['section_id'],						
					));
				}
				mysqli_close($db);
				return json_encode($response);
			
			}
		function get_class_section_name_by_id($class_id,$section_id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT `class`.`class_name`, `section`.`section_name` FROM `class`, `section` WHERE `class`.`class_id` = '$class_id' AND `section`.`section_id` = '$section_id'");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
			
			}
		function get_class_name_by_id($class_id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT `class_name` FROM `class` WHERE `class_id` = '$class_id' ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return $value->class_name;
			
			}
		function get_section_name_by_id($section_id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT `section_name` FROM `section` WHERE `section_id` = '$section_id' ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return $value->section_name;
			
			}

		function update_class_teacher_of_section($last_id,$tclass,$tsec)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "UPDATE `section` SET `teacher_id`='$last_id' WHERE `section_class` = '$tclass' AND `section_name`='$tsec'");
				mysqli_close($db);
			}
		function get_medium_list()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * FROM `medium` WHERE `medium_status` = 0 ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"medium_id" => $row['medium_id'],
						"medium_name" => $row['medium_name'],
						"medium_desc" => $row['medium_desc'],						
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_block_list()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * FROM `block` WHERE `block_status` = 0 ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"block_id" => $row['block_id'],
						"building_name" => $row['building_name'],
						"block_name" => $row['block_name'],
						"block_desc" => $row['block_desc'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_admission_charge_by_class_name($class_id)
		    {
		    	require("../config/config.php");
					$result = mysqli_query($db, "SELECT `admission_charge` FROM `class` WHERE `class_id`='$class_id'");
					$value = mysqli_fetch_object($result);
					mysqli_close($db);
					return $value->admission_charge;
		    }
		function get_section_list_by_class_id($class_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `section_id`,`section_name` FROM `section` WHERE `section_class` = '$class_id' AND `status` = 0 ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"section_id" => $row['section_id'],
						"section_name" => $row['section_name'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
//===================== Class & Section End ===================================

//===================== Lession Plan login Start ==============================
		//remove after check
		function get_planned_lession()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `lesson_planning`.* , `class`.`class_id`, `class`.`class_name`, `section`.`section_id`, `section`.`section_name`, `teachers`.`tname`, `subject`.`subject_name` 
					FROM `lesson_planning` 
					LEFT JOIN `subject` ON `lesson_planning`.`subject_id`=`subject`.`subject_id` 
					LEFT JOIN `class` ON `lesson_planning`.`class`=`class`.`class_id` 
					LEFT JOIN `section` ON `lesson_planning`.`section`=`section`.`section_id` 
					LEFT JOIN `teachers` ON `lesson_planning`.`teacher_id`=`teachers`.`tid`
					WHERE `lesson_planning`.`status` = 0
					ORDER BY `assign_date` DESC ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"id" => $row['id'],
						"tname" => $row['tname'],
						"class_id" => $row['class_id'],
						"class_name" => $row['class_name'],
						"section_id" => $row['section_id'],
						"section_name" => $row['section_name'],
						"subject_name" => $row['subject_name'],
						"topic" => $row['topic'],
						"percentage" => $row['percentage'],
						
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
		function get_planned_lession_year_id($year_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `lesson_planning`.* , `class`.`class_id`, `class`.`class_name`, `section`.`section_id`, `section`.`section_name`, `teachers`.`tname`, `subject`.`subject_name` 
					FROM `lesson_planning` 
					LEFT JOIN `subject` ON `lesson_planning`.`subject_id`=`subject`.`subject_id` 
					LEFT JOIN `class` ON `lesson_planning`.`class`=`class`.`class_id` 
					LEFT JOIN `section` ON `lesson_planning`.`section`=`section`.`section_id` 
					LEFT JOIN `teachers` ON `lesson_planning`.`teacher_id`=`teachers`.`tid`
					WHERE `lesson_planning`.`status` = 0 AND `lesson_planning`.`year_id` = '$year_id'
					ORDER BY `assign_date` DESC ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"id" => $row['id'],
						"tname" => $row['tname'],
						"class_id" => $row['class_id'],
						"class_name" => $row['class_name'],
						"section_id" => $row['section_id'],
						"section_name" => $row['section_name'],
						"subject_name" => $row['subject_name'],
						"topic" => $row['topic'],
						"percentage" => $row['percentage'],
						
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
		function get_planned_lession_by_teacher_id($tid)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `lesson_planning`.* , `class`.`class_id`, `class`.`class_name`, `section`.`section_id`, `section`.`section_name`, `teachers`.`tname`, `subject`.`subject_name`, `principal`.`pname` FROM `lesson_planning` LEFT JOIN `subject` ON `lesson_planning`.`subject_id`=`subject`.`subject_id` LEFT JOIN `teachers` ON `lesson_planning`.`teacher_id`=`teachers`.`tid` LEFT JOIN `class` ON `lesson_planning`.`class`=`class`.`class_id` LEFT JOIN `section` ON `lesson_planning`.`section`=`section`.`section_id` LEFT JOIN `principal` ON `lesson_planning`.`assigned_by`=`principal`.`pid` WHERE `lesson_planning`.`teacher_id`='$tid' AND `lesson_planning`.`status` = 0
					ORDER BY `assign_date` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"id" => $row['id'],
						"tname" => $row['tname'],
						"class_id" => $row['class_id'],
						"class_name" => $row['class_name'],
						"section_id" => $row['section_id'],
						"section_name" => $row['section_name'],
						"subject_name" => $row['subject_name'],
						"topic" => $row['topic'],
						"remark" => $row['remark'],
						"percentage" => $row['percentage'],
						"assign_date" => $row['assign_date'],
						"start_date" => $row['start_date'],
						"end_date" => $row['end_date'],
						"pname" => $row['pname'],
						
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
		function get_planned_lession_by_class_section_subject_id($class_id,$section_id,$subject_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `lesson_planning`.* , `class`.`class_id`, `class`.`class_name`, `section`.`section_id`, `section`.`section_name`, `teachers`.`tname`, `subject`.`subject_name`, `principal`.`pname` FROM `lesson_planning` 
					LEFT JOIN `subject` ON `lesson_planning`.`subject_id`=`subject`.`subject_id` 
					LEFT JOIN `teachers` ON `lesson_planning`.`teacher_id`=`teachers`.`tid` 
					LEFT JOIN `class` ON `lesson_planning`.`class`=`class`.`class_id` 
					LEFT JOIN `section` ON `lesson_planning`.`section`=`section`.`section_id` 
					LEFT JOIN `principal` ON `lesson_planning`.`assigned_by`=`principal`.`pid` 
					WHERE `lesson_planning`.`class`='$class_id' 
						AND `lesson_planning`.`section`='$section_id' 
						AND `lesson_planning`.`subject_id`='$subject_id' 
						AND `lesson_planning`.`status` = 0
					ORDER BY `assign_date` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"id" => $row['id'],
						"tname" => $row['tname'],
						"class_id" => $row['class_id'],
						"class_name" => $row['class_name'],
						"section_id" => $row['section_id'],
						"section_name" => $row['section_name'],
						"subject_name" => $row['subject_name'],
						"topic" => $row['topic'],
						"percentage" => $row['percentage'],
						"assign_date" => $row['assign_date'],
						"start_date" => $row['start_date'],
						"end_date" => $row['end_date'],
						"pname" => $row['pname'],
						
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
		function get_planned_lession_by_lesson_id($id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT `lesson_planning`.* , `class`.`class_id`, `class`.`class_name`, `section`.`section_id`, `section`.`section_name`, `teachers`.`tname`, `subject`.`subject_id`, `subject`.`subject_name`, `principal`.`pname` 
					FROM `lesson_planning` 
					LEFT JOIN `subject` ON `lesson_planning`.`subject_id`=`subject`.`subject_id` 
					LEFT JOIN `teachers` ON `lesson_planning`.`teacher_id`=`teachers`.`tid` 
					LEFT JOIN `class` ON `lesson_planning`.`class`=`class`.`class_id` 
					LEFT JOIN `section` ON `lesson_planning`.`section`=`section`.`section_id` 
					LEFT JOIN `principal` ON `lesson_planning`.`assigned_by`=`principal`.`pid` 
					WHERE `id`='$id' AND `lesson_planning`.`status` = 0");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
				
			}
//===================== Lession Plan login End ================================

//===================== Subject details Start =================================
		function get_subject_details_by_class_id($class_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `subject`.* , `class`.`class_name`, `teachers`.`tname`  
					FROM `subject` 
					LEFT JOIN `teachers` ON `subject`.`teacher_id`=`teachers`.`tid` 
					LEFT JOIN `class` ON `subject`.`subject_class`=`class`.`class_id` 
					WHERE `subject`.`subject_class`='$class_id'  AND `subject`.`status` = 0
					ORDER BY `subject`.`sort_order` ASC");

				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"subject_id" => $row['subject_id'],
						"subject_name" => $row['subject_name'],
						"total_mark" => $row['total_mark'],
						"subject_theory" => $row['subject_theory'],
						"subject_practical" => $row['subject_practical'],
						"theory_passmark" => $row['theory_passmark'],
						"practical_passmark" => $row['practical_passmark'],
						"pass_mark" => $row['pass_mark'],
						"subject_class" => $row['subject_class'],
						"teacher_id" => $row['teacher_id'],
						"subject_type" => $row['subject_type'],
						"class_name" => $row['class_name'],
						"tname" => $row['tname'],
						"status" => $row['status'],
						
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
		function get_subject_list_details_by_class_id_year_id($class_id,$year_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `subject`.* , `teachers`.`tname`  
					FROM `subject` 
					LEFT JOIN `teachers` ON `subject`.`teacher_id`=`teachers`.`tid` 
					WHERE `subject`.`subject_class`='$class_id'  AND `subject`.`status` = 0
					ORDER BY `subject`.`sort_order` ASC");

				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"subject_id" => $row['subject_id'],
						"subject_name" => $row['subject_name'],
						"major" => $row['major'],
						"subject_class" => $row['subject_class'],
						"teacher_id" => $row['teacher_id'],
						"subject_type" => $row['subject_type'],
						"teacher_name" => $row['tname'],
						"sort_order" => $row['sort_order'],
						"status" => $row['status'],
						
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
		function get_subject_details_by_subject_id($subject_id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT * FROM `subject` WHERE `subject_id` = '$subject_id' ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
			
			}
		function get_subject_mark_details_by_examtype_id_subject_id_year_id($examtype_id , $subject_id , $year_id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT `subject_mark`.* 
					FROM `subject_mark` 
					WHERE `subject_mark`.`examtype_id` = '$examtype_id' 
						AND `subject_mark`.`subject_id` = '$subject_id' 
						AND `subject_mark`.`year_id` = '$year_id' ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
				
			}
		function get_subject_mark_test_details_by_class_id_examtype_id_year_id($class_id , $examtype_id , $year_id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT MAX(`subject_mark`.`mt`) AS `mt`, MAX(`subject_mark`.`ot`) AS `ot`,MAX(`subject_mark`.`eca`) AS `eca`,MAX( `subject_mark`.`lp`) AS `lp`,MAX(`subject_mark`.`nb`) AS `nb`,MAX( `subject_mark`.`se`) AS `se`

              FROM `subject`
              LEFT JOIN `subject_mark` ON `subject`.`subject_id` = `subject_mark`.`subject_id`
                            AND  `subject_mark`.`examtype_id` = '$examtype_id'
                            AND `subject_mark`.`year_id` = '$year_id'
              WHERE `subject`.`subject_class` = '$class_id'
                          AND `subject`.`year_id` = '$year_id'
                          AND `subject`.`status` = 0 
              ORDER BY `subject`.`sort_order` ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
				
			}
		function get_subject_mark_by_examtype_id_subject_id_year_id($examtype_id,$subject_id,$year_id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT * FROM `subject_mark` WHERE `examtype_id` = '$examtype_id' AND `subject_id` = '$subject_id' AND `subject_mark`.`year_id` = '$year_id' ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
			
			}
//===================== subject details End ===================================

//===================== Attendance  details Start ================================
	function check_teacher_attendance_done_by_date($date){
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `attendance_staff_check` WHERE `staff` = 2 AND `date` = '$date' ");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
	}

	function check_staff_attendance_done_by_date($date){
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `attendance_staff_check` WHERE `staff` = 5 AND `date` = '$date' ");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
	}
	
//===================== Attendance  details End ==================================


//===================== Teacher  details Start ================================
	function check_teacher_email_exist($email)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function check_teacher_email_exist_except_id($email,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email' AND `tid`<>'$id') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function get_max_teacher_id()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT max(tid) as 'tid'  FROM `teachers`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->tid;
		}
	function get_teacher_details()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM `teachers` WHERE `status`= 0 ORDER BY `tname`");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"tid" => $row['tid'],
					"tname" => $row['tname'],
					"temail" => $row['temail'],
					"taddress" => $row['taddress'],
					"tmobile" => $row['tmobile'],
					"t_phone" => $row['t_phone'],
					"tcount" => $row['tcount'],
					"tclock" => $row['tclock'],
					"t_father" => $row['t_father'],
					"t_mother" => $row['t_mother'],
					"t_marital" => $row['t_marital'],
					"t_country" => $row['t_country'],
					"t_join_date" => $row['t_join_date'],
					"sex" => $row['sex'],
					"dob" => $row['dob'],
					"timage" => $row['timage'],
					"tsalary" => $row['tsalary'],
					"t_jobtype" => $row['t_jobtype'],
					"status" => $row['status'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
		}
	function get_teacher_full_details_by_tid($tid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `teachers`.*
				FROM `teachers` 
				WHERE teachers.`tid`= '$tid' ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}
	function get_teacher_name_by_teacher_id($id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `tid` AS `teacher_id`,`tname` AS `teacher_name`
				FROM `teachers` 
				WHERE teachers.`tid`= '$id' ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}

	function get_active_teacher_list(){
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `teachers`.`tid` , `teachers`.`tname` , `teachers`.`temail` , `teachers`.`taddress` , `teachers`.`tmobile` 
				FROM `teachers` 
				WHERE `status`= 0 
				ORDER BY `tname`");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"id" => $row['tid'],
					"name" => $row['tname'],
					"email" => $row['temail'],
					"address" => $row['taddress'],
					"mobile" => $row['tmobile'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
		}
//===================== Teacher  details End ==================================

//===================== Staff  details Start ==================================
	function check_staff_email_exist($email)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function check_staff_email_exist_except_id($email,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email' AND `stid`<>'$id')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function get_max_staff_id()
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT max(stid) as 'stid'  FROM `staff_tbl`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->stid;
		}
	function get_staff_details_by_staff_type($stafftype)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT * FROM `staff_tbl` WHERE `staff_type` = '$stafftype'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}
	function get_staff_details_by_staff_type_and_status($export_type,$status)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * FROM `staff_tbl` 
					WHERE 1 " . (($export_type == 'all') ? "" : "AND `staff_tbl`.`staff_type`='$export_type' ") . (($status == 'all') ? "" : "AND `staff_tbl`.`staff_status`='$status' "). "  
					ORDER BY `staff_tbl`.`staff_type` ASC");
				 
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"stid" => $row['stid'],
						"staff_name" => $row['staff_name'],
						"staff_address" => $row['staff_address'],
						"staff_mobile" => $row['staff_mobile'],
						"staff_type" => $row['staff_type'],
						"staff_typedesc" => $row['staff_typedesc'],
						"staff_salary" => $row['staff_salary'],
						"staff_email" => $row['staff_email'],
						"staff_phone" => $row['staff_phone'],
						"staff_sex" => $row['staff_sex'],
						"staff_position" => $row['staff_position'],
						"staff_marital" => $row['staff_marital'],
						"staff_dob" => $row['staff_dob'],
						"blood_group" => $row['blood_group'],
						"staff_father" => $row['staff_father'],
						"staff_mother" => $row['staff_mother'],
						"staff_country" => $row['staff_country'],
						"staff_image" => $row['staff_image'],
						"staff_joindate" => $row['staff_joindate'],
						"staff_status" => $row['staff_status'],

						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
	function get_staff_full_details_by_stid($stid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `staff_tbl`.*
				FROM `staff_tbl` 
				WHERE staff_tbl.`stid`= '$stid' ");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return json_encode($value);
		}

	function get_active_staff_list(){
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT `staff_tbl`.`stid` , `staff_tbl`.`staff_name` , `staff_tbl`.`staff_email` , `staff_tbl`.`staff_mobile` 
				FROM `staff_tbl` 
				WHERE `staff_status`= 0 
				ORDER BY `staff_name`");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"id" => $row['stid'],
					"name" => $row['staff_name'],
					"email" => $row['staff_email'],
					"mobile" => $row['staff_mobile'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
		}
//===================== Staff  details End ====================================

//===================== Admin  details Start ==================================
	function check_admin_email_exist_except_id($email,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email'  AND `pid`<>'$id') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
//===================== Admin  details End ====================================


//===================== Permission Start ======================================
		function get_permission_by_t_role_and_t_id($t_role,$t_id)
			{
				require("../config/config.php");

				if ($t_role == 2) {
					$permission_query = "SELECT *  
						FROM `permission` 
                        WHERE `permission`.`t_role` = 2 AND `permission`.`t_id` = '$t_id' ";
				}else if ($t_role == 5){
					$permission_query = "SELECT * 
						FROM `permission` 
                        WHERE `permission`.`t_role` = 5 AND `permission`.`t_id` = '$t_id' ";
				}
				
				$result = mysqli_query($db, $permission_query);
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);
			}
//===================== Permission End ========================================

//===================== Parent  details Start =================================
	function get_all_active_parent_details()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT *
				FROM `parents` 
				WHERE `parents`.`spstatus` = 0  
				ORDER BY `parents`.`spname` ASC");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"parent_id" => $row['parent_id'],
					"spname" => $row['spname'],
					"smname" => $row['smname'],
					"spemail" => $row['spemail'],
					"spnumber" => $row['spnumber'],
					"spnumber_2" => $row['spnumber_2'],
					"spprofession" => $row['spprofession'],
					"sp_address" => $row['sp_address'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
			
		}
	function check_parent_email_exist($email)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function check_parent_email_exist_except_id($email,$id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "(SELECT `pid` AS id FROM principal WHERE pemail = '$email') 
										UNION
										(SELECT `tid` AS id FROM teachers WHERE temail = '$email') 
										UNION
										(SELECT `parent_id` AS id FROM parents WHERE `spemail` = '$email' AND `parent_id`<>'$id') 
										UNION
										(SELECT `sid` AS id FROM studentinfo WHERE `semail` = '$email')
										UNION
										(SELECT `stid` AS id FROM staff_tbl WHERE `staff_email` = '$email')");
			$count=mysqli_num_rows($result);
			mysqli_close($db);
			if($count>0){ return true; }else{ return false;}
		}
	function get_parent_number_by_student_id($sid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `parents`.`spnumber` FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`sid` ='$sid' GROUP BY `parents`.`spnumber`");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->spnumber;
		}
//===================== parent  details End ===================================

//===================== Academic year details start ===========================
	function get_academic_year_list()
		{
			require("../config/config.php");
			$response = array();
			$result = mysqli_query($db, "SELECT * FROM `academic_year` WHERE `status`=0 ORDER BY `single_year` ");
			while($row = mysqli_fetch_assoc($result))
			{
				array_push($response,array(
					"id" => $row['id'],
					"year" => $row['year'],
					"single_year" => $row['single_year'],
					));
			}
			mysqli_close($db);
			return json_encode($response);
		}
	function get_academic_year_id_by_year($year)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `id` FROM `academic_year` WHERE `single_year`='$year'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->id;
		}
	function get_academic_single_year_by_year_id($year_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `single_year` FROM `academic_year` WHERE `id`='$year_id'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->single_year;
		}
	function get_academic_year_by_year_id($year_id)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT `year` FROM `academic_year` WHERE `id`='$year_id'");
			$value = mysqli_fetch_object($result);
			mysqli_close($db);
			return $value->year;
		}
//===================== Academic year details end =============================

//===================== Accountant start ======================================
	function get_pending_amount_by_feetype_title_sid($title,$sid)
		{
			require("../config/config.php");
			$result = mysqli_query($db, "SELECT  SUM(`balance`) AS `balance` FROM `student_bill` LEFT JOIN `fee_types` ON `student_bill`.`feetype_id` = `fee_types`.`feetype_id` where status!='paid' AND std_id='$sid' AND `fee_types`.`feetype_title` = '$title'");
			$value = mysqli_fetch_object($result); 
			mysqli_close($db);
			return $value->balance;
		}
	//krishna hackster 30-05-2019
	function get_feetype_details_except_default()
	{
		require("../config/config.php");
		$response = array();
		$result = mysqli_query($db, "SELECT * FROM `fee_types`");
		while($row = mysqli_fetch_assoc($result)){
			if ($row['feetype_title'] == 'Tution Fee' || $row['feetype_title'] == 'Hostel Fee' || $row['feetype_title'] == 'Computer Fee' || $row['feetype_title'] == 'Bus Fee') {
				continue;
			}
			array_push($response,array(
				"feetype_id" => $row['feetype_id'],
				"feetype_title" => $row['feetype_title'],
				));
		}
		mysqli_close($db);
		return json_encode($response);
	}

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

	function get_feetype_id_by_feetype_title($feetype_title)
	{
		require("../config/config.php");
		$result = mysqli_query($db, "SELECT `feetype_id` FROM `fee_types` WHERE `feetype_title` = '$feetype_title'");
		$value = mysqli_fetch_object($result);
		mysqli_close($db);
		return $value->feetype_id;
	}

	//hackster 21/jan/2019
	function add_fee_into_student_due($std_id, $feetype_id, $balance, $description, $date, $t_role, $t_id, $status)
	{
		require("../config/config.php");
		$qry="INSERT INTO `student_due` (`id`, `std_id`, `feetype_id`, `balance`,  `description`, `date`, `t_role`, `t_id`, `status`) VALUES (null,'$std_id', '$feetype_id', '$balance', '$description', '$date', '$t_role', '$t_id', '$status')";
		$result = mysqli_query($db,$qry );
		mysqli_close($db);
		if ($result) {
        	return true;
        }else{
        	return false;
        }
	}
//===================== Accountant end ========================================

//===================== Leave Details Start ===================================
		function get_leave_details_by_student_id($student_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `leavetable`.*, `class`.`class_name`, `section`.`section_name`, `teachers`.`tname`, `principal`.`pname` 
					FROM `leavetable` 
					LEFT JOIN `class` ON `leavetable`.`lvclass` = `class`.`class_id`
					LEFT JOIN `section` ON `leavetable`.`lvsec` = `section`.`section_id`
					LEFT JOIN `teachers` ON `leavetable`.`lvtid` = `teachers`.`tid`
					LEFT JOIN `principal` ON `leavetable`.`lvtid` = `principal`.`pid` 
					WHERE `leavetable`.`lvsid` = '$student_id' AND `leavetable`.`status` = 0
					ORDER BY `leavetable`.`lvclock` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"lvid" => $row['lvid'],
						"lvclass" => $row['lvclass'],
						"lvsec" => $row['lvsec'],
						"lvreason" => $row['lvreason'],
						"lvsdate" => $row['lvsdate'],
						"lvedate" => $row['lvedate'],
						"class_name" => $row['class_name'],
						"section_name" => $row['section_name'],
						"tname" => $row['tname'],
						"pname" => $row['pname'],
						"lvstatus" => $row['lvstatus'],
						"lvrole" => $row['lvrole'],
						"lvtid" => $row['lvtid'],
						"lvclock" => $row['lvclock'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_leave_details_by_class_section_id($class_id,$section_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `leavetable`.*, `class`.`class_name`, `section`.`section_name`, `teachers`.`tname`, `principal`.`pname`, `studentinfo`.`sname`, `studentinfo`.`sroll`
					FROM `leavetable` 
					LEFT JOIN `class` ON `leavetable`.`lvclass` = `class`.`class_id`
					LEFT JOIN `section` ON `leavetable`.`lvsec` = `section`.`section_id`
					LEFT JOIN `teachers` ON `leavetable`.`lvtid` = `teachers`.`tid`
					LEFT JOIN `principal` ON `leavetable`.`lvtid` = `principal`.`pid`
					LEFT JOIN `studentinfo` ON `leavetable`.`lvsid` = `studentinfo`.`sid`
					WHERE `leavetable`.`lvclass` = '$class_id' 
						AND `leavetable`.`lvsec` = '$section_id' 
						AND `leavetable`.`status` = 0
					ORDER BY `leavetable`.`lvclock` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"lvid" => $row['lvid'],
						"lvclass" => $row['lvclass'],
						"lvsec" => $row['lvsec'],
						"lvreason" => $row['lvreason'],
						"lvsdate" => $row['lvsdate'],
						"lvedate" => $row['lvedate'],
						"class_name" => $row['class_name'],
						"section_name" => $row['section_name'],
						"tname" => $row['tname'],
						"pname" => $row['pname'],
						"sname" => $row['sname'],
						"sroll" => $row['sroll'],
						"lvstatus" => $row['lvstatus'],
						"lvrole" => $row['lvrole'],
						"lvtid" => $row['lvtid'],
						"lvclock" => $row['lvclock'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_leave_list_by_student_id_with_limit($student_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * FROM `leavetable` 
					WHERE `lvsid`='$student_id' AND `status` = 0 
					ORDER BY `leavetable`.`lvclock` DESC LIMIT 5");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"lvid" => $row['lvid'],
						"lvclass" => $row['lvclass'],
						"lvsec" => $row['lvsec'],
						"lvsid" => $row['lvsid'],
						"lvreason" => $row['lvreason'],
						"lvsdate" => $row['lvsdate'],
						"lvedate" => $row['lvedate'],
						"lvstatus" => $row['lvstatus'],
						"lvclock" => $row['lvclock'],
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
		function get_leave_list_of_student_by_parent_id($parent_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `studentinfo`.`sname`, `leavetable`.`lvsdate`, `leavetable`.`lvedate`, `leavetable`.`lvreason`, `leavetable`.`lvclock`, `leavetable`.`lvstatus` 
			    FROM `parents` 
			    LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
			    INNER JOIN `leavetable` ON `studentinfo`.`sid` = `leavetable`.`lvsid` 
			    WHERE `parents`.`parent_id`='$parent_id' 
			    ORDER BY `leavetable`.`lvclock` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"sname" => $row['sname'],
						"lvreason" => $row['lvreason'],
						"lvsdate" => $row['lvsdate'],
						"lvedate" => $row['lvedate'],
						"lvstatus" => $row['lvstatus'],
						"lvclock" => $row['lvclock'],
						));
				}
				mysqli_close($db);
				return json_encode($response);
				
			}
//===================== Leave Details End =====================================

//===================== Homework Start ========================================
		
		function get_homework_details_by_teacher_id($teacher_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `homework`.*, `class`.`class_name`, `section`.`section_name`, `subject`.`subject_name`, `teachers`.`tname` 
					FROM `homework` 
					LEFT JOIN `class` ON `homework`.`hclass` = `class`.`class_id`
					LEFT JOIN `section` ON `homework`.`hsec` = `section`.`section_id`
					LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
					LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid` 
					WHERE `homework`.`hrole` = 2 AND `homework`.`htid` = '$teacher_id' AND `homework`.`hstatus` = 0
					ORDER BY `homework`.`hclock` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"hid" => $row['hid'],
						"hclass" => $row['hclass'],
						"hsec" => $row['hsec'],
						"hsubject" => $row['hsubject'],
						"htid" => $row['htid'],
						"class_name" => $row['class_name'],
						"section_name" => $row['section_name'],
						"subject_name" => $row['subject_name'],
						"tname" => $row['tname'],
						"htopic" => $row['htopic'],
						"hrole" => $row['hrole'],
						"hdate" => $row['hdate'],
						"hclock" => $row['hclock'],
						"hreported" => $row['hreported'],
						"hstatus" => $row['hstatus'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_homework_details_by_class_section_id($class_id,$section_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `homework`.*, `class`.`class_name`, `section`.`section_name`, `subject`.`subject_name`, `teachers`.`tname`, `principal`.`pname` 
					FROM `homework` 
					LEFT JOIN `class` ON `homework`.`hclass` = `class`.`class_id`
					LEFT JOIN `section` ON `homework`.`hsec` = `section`.`section_id`
					LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
					LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid`
					LEFT JOIN `principal` ON `homework`.`htid` = `principal`.`pid` 
					WHERE `homework`.`hclass` = '$class_id' AND `homework`.`hsec` = '$section_id' AND `homework`.`hstatus` = 0
					ORDER BY `homework`.`hclock` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"hid" => $row['hid'],
						"hclass" => $row['hclass'],
						"hsec" => $row['hsec'],
						"hsubject" => $row['hsubject'],
						"htid" => $row['htid'],
						"class_name" => $row['class_name'],
						"section_name" => $row['section_name'],
						"subject_name" => $row['subject_name'],
						"tname" => $row['tname'],
						"pname" => $row['pname'],
						"htopic" => $row['htopic'],
						"hrole" => $row['hrole'],
						"hdate" => $row['hdate'],
						"hclock" => $row['hclock'],
						"hreported" => $row['hreported'],
						"hstatus" => $row['hstatus'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_homework_details()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `homework`.*, `class`.`class_name`, `section`.`section_name`, `subject`.`subject_name`, `teachers`.`tname`, `principal`.`pname` 
					FROM `homework` 
					LEFT JOIN `class` ON `homework`.`hclass` = `class`.`class_id`
					LEFT JOIN `section` ON `homework`.`hsec` = `section`.`section_id`
					LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
					LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid`
					LEFT JOIN `principal` ON `homework`.`htid` = `principal`.`pid`
					WHERE `homework`.`hstatus` = 0
					ORDER BY `homework`.`hclock`");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"hid" => $row['hid'],
						"hclass" => $row['hclass'],
						"hsec" => $row['hsec'],
						"hsubject" => $row['hsubject'],
						"htid" => $row['htid'],
						"class_name" => $row['class_name'],
						"section_name" => $row['section_name'],
						"subject_name" => $row['subject_name'],
						"tname" => $row['tname'],
						"pname" => $row['pname'],
						"htopic" => $row['htopic'],
						"hrole" => $row['hrole'],
						"hdate" => $row['hdate'],
						"hclock" => $row['hclock'],
						"hreported" => $row['hreported'],
						"hstatus" => $row['hstatus'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_homework_details_by_id($id)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT `homework`.*, `class`.`class_name`, `section`.`section_name`, `subject`.`subject_name`, `teachers`.`tname` 
					FROM `homework` 
					LEFT JOIN `class` ON `homework`.`hclass` = `class`.`class_id`
					LEFT JOIN `section` ON `homework`.`hsec` = `section`.`section_id`
					LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
					LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid`
					LEFT JOIN `principal` ON `homework`.`htid` = `principal`.`pid`
					WHERE `homework`.`hid` = '$id' AND `homework`.`hstatus` = 0 ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return json_encode($value);			
			}
		function get_homework_list_by_student_id_with_limit($student_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `hwnotdone`.* ,`subject`.`subject_name`
					FROM `hwnotdone` 
                    INNER JOIN `homework` ON `hwnotdone`.`hwndhid` = `homework`.`hid`
                    INNER JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
					WHERE `hwndsid`='$student_id' 
					ORDER BY `hwnotdone`.`hwndclock` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"hwndid" => $row['hwndid'],
						"hwndhid" => $row['hwndhid'],
						"subject_name" => $row['subject_name'],
						"hwnddate" => $row['hwnddate'],
						"hwndclock" => $row['hwndclock'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_homework_complaint_of_student_by_parent_id($parent_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `studentinfo`.`sname`,`subject`.`subject_name`, `hwnotdone`.`hwndclock`,`homework`.`hclock`
			    FROM `parents` 
			    LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
			    INNER JOIN `hwnotdone` ON `studentinfo`.`sid` = `hwnotdone`.`hwndsid`
			    INNER JOIN `homework` ON `hwnotdone`.`hwndhid` = `homework`.`hid` 
			    LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
			    WHERE `parents`.`parent_id`='$parent_id' 
			    ORDER BY `hwnotdone`.`hwndclock` DESC ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"sname" => $row['sname'],
						"subject_name" => $row['subject_name'],
						"hclock" => $row['hclock'],
						"hwndclock" => $row['hwndclock'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function get_homework_list_of_student_by_parent_id($parent_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `studentinfo`.`sname`, `subject`.`subject_name`, `homework`.`htopic`, `homework`.`hclock`, `homework`.`hdate`, `homework`.`hrole`, `teachers`.`tname`, `principal`.`pname`
				    FROM `parents` 
				    LEFT JOIN `studentinfo` ON `parents`.`parent_id` = `studentinfo`.`sparent_id` 
				    INNER JOIN `homework` ON `studentinfo`.`sclass` = `homework`.`hclass` AND `studentinfo`.`ssec` = `homework`.`hsec`
				    LEFT JOIN `subject` ON `homework`.`hsubject` = `subject`.`subject_id`
				    LEFT JOIN `teachers` ON `homework`.`htid` = `teachers`.`tid`
				    LEFT JOIN `principal` ON `homework`.`htid` = `principal`.`pid`

				    WHERE `parents`.`parent_id`='$parent_id' 
				    ORDER BY `homework`.`hdate` DESC");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"sname" => $row['sname'],
						"subject_name" => $row['subject_name'],
						"htopic" => $row['htopic'],
						"hclock" => $row['hclock'],
						"hdate" => $row['hdate'],
						"hrole" => $row['hrole'],
						"tname" => $row['tname'],
						"pname" => $row['pname'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
		function update_homework_reported_by_id($hid)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "UPDATE `homework` SET `hreported`= 1  WHERE `hid`='$hid'");
				mysqli_close($db);
			}
		function check_homework_reported_by_id($hid)
			{
				require("../config/config.php");
				$result = mysqli_query($db, "SELECT `hreported`  FROM `homework` WHERE `hid` = '$hid' ");
				$value = mysqli_fetch_object($result);
				mysqli_close($db);
				return $value->hreported;

			}
//===================== Homework End ==========================================

//===================== Complaint Start =======================================
		function get_complaint_list_by_student_id_with_limit($student_id)
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT * 
					FROM `complaint` 
					WHERE `csid` = '$student_id' AND `cstatus` = 0
					ORDER BY `complaint`.`cclock` 
					DESC LIMIT 5");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"cid" => $row['cid'],
						"csclass" => $row['csclass'],
						"cssec" => $row['cssec'],
						"cmsg" => $row['cmsg'],
						"cdate" => $row['cdate'],
						"cclock" => $row['cclock'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
//===================== Complaint End =========================================

//===================== Gallery Start =========================================
		function get_gallery_details()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `gallery`.*, `teachers`.`tname`, `principal`.`pname`
					FROM `gallery` 
					LEFT JOIN `teachers` ON `gallery`.`uploader` = `teachers`.`tid`
					LEFT JOIN `principal` ON `gallery`.`uploader` = `principal`.`pid`
					WHERE `gallery`.`status` = 0 
					ORDER BY `gallery`.`date` DESC ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"id" => $row['id'],
						"title" => $row['title'],
						"imagename" => $row['imagename'],
						"file_location" => $row['file_location'],
						"desc" => $row['desc'],
						"role" => $row['role'],
						"tname" => $row['tname'],
						"pname" => $row['pname'],
						"date" => $row['date'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
//===================== End Gallery ===========================================

//===================== Elibrary Start ========================================
		function get_elibrary_details()
			{
				require("../config/config.php");
				$response = array();
				$result = mysqli_query($db, "SELECT `elibrary`.*, `teachers`.`tname`, `principal`.`pname`
					FROM `elibrary` 
					LEFT JOIN `teachers` ON `elibrary`.`uploader` = `teachers`.`tid`
					LEFT JOIN `principal` ON `elibrary`.`uploader` = `principal`.`pid`
					WHERE `elibrary`.`status` = 0 
					ORDER BY `elibrary`.`date` DESC ");
				while($row = mysqli_fetch_assoc($result))
				{
					array_push($response,array(
						"id" => $row['id'],
						"filename" => $row['filename'],
						"file_location" => $row['file_location'],
						"size" => $row['size'],
						"type" => $row['type'],
						"role" => $row['role'],
						"tname" => $row['tname'],
						"pname" => $row['pname'],
						"date" => $row['date'],
					));
				}
				mysqli_close($db);
				return json_encode($response);
			}
//===================== Elibrary End ==========================================



}
?>

