<?php
include('../session.php');
require("../../important/backstage.php");

$backstage = new back_stage_class();

if($_SERVER['REQUEST_METHOD']=='POST') {

	if (isset($_POST['update_current_session_year'])) {


      $selected_session_year_id = $_POST['selected_session_year_id'];
      $year =  $backstage->get_academic_year_by_year_id($selected_session_year_id);

      $_SESSION['current_year_session_id'] = $selected_session_year_id;

      $_SESSION['current_year_session'] = $year;

      if ($_SESSION['current_year_session_id'] == $selected_session_year_id && $_SESSION['current_year_session'] == $year) {

          $response["status"] = 200;
          $response["message"] = "Success";
      }else{
          $response["status"] = 201;
          $response["message"] = "Failed";
          $response["errormsg"] = "Failed to update current session";
      }
                    
     echo json_encode($response);
    }





}

?>