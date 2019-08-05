<?php
include('../load_backstage.php');

if(isset($_REQUEST['get_class_fee']))
{
	$classId = $_REQUEST['get_class_fee'];
	$feetype = $_REQUEST['fee_type'];
	$feetype = str_replace(' ', '_', $feetype);
	$feetype = strtolower($feetype);
	
	echo  $account->get_fee_by_class_id_and_feetype($classId,$feetype);

}else if ($_REQUEST['get_student_fee']) {
	$student_id = $_REQUEST['get_student_fee'];
	$feetype_id = $_REQUEST['feetype_id'];
	$feetype_title = $_REQUEST['feetype_title'];


	 if($feetype_title=='Pre Discount'){
	 	
	 	$response['fee'] = $account->get_student_due_balance_if_exist_by_student_id_feetype_id($student_id,$feetype_id);
		$response['message'] = "Additional Discount";

	 }else if($feetype_title=='Tution Fee' || $feetype_title=='Hostel Fee' || $feetype_title=='Bus Fee' || $feetype_title=='Computer Fee'){
	 	
	 	$response['fee'] = $account->get_fee_by_feetype_student_id($student_id,$feetype_title);
		$response['message'] = "fee from student details";

	 }else{
	 	$response['fee'] = '';
	 	$response['message'] = "";

	 }
	
	echo json_encode($response);
}


?>