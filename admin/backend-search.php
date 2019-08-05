<?php
/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
//$link = mysqli_connect("localhost", "krishnagek", "poopoo", "ossmdb");
 require("../config/config.php");
// Check connection
if($db === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(isset($_REQUEST['term'])){
    // Prepare a select statement`studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
    $sql = "SELECT `studentinfo`.*,`parents`.*, `class`.`class_name`, `section`.`section_name` 
        FROM `studentinfo` 
        LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
        LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
        LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
        WHERE `studentinfo`.`status`= 0 AND `studentinfo`.`sname` LIKE ?";

    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = $_REQUEST['term'] . '%';

        $response = array();

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    //echo "<p>" . $row["sname"] . "</p>";
                    array_push($response,array(
                "sid" => $row['sid'],
                "sname" => $row['sname'],
                "simage" => $row['simage'],
                "sadmsnno" => $row['sadmsnno'],
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
                "tution_rate" => $row['tution_rate'],
                "bus_rate" => $row['bus_rate'],
                "hostel_rate" => $row['hostel_rate'],
                ));
                }
                 echo json_encode($response);
            } else{
                //echo "<p>No matches found</p>";
            }
           
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);

}else if(isset($_REQUEST['allStudent'])){
    // Prepare a select statement`studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
    $sql = "SELECT `studentinfo`.*,`parents`.*, `class`.`class_name`, `section`.`section_name` 
        FROM `studentinfo` 
        LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
        LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
        LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
        WHERE  `studentinfo`.`sname` LIKE ?";

    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = $_REQUEST['allStudent'] . '%';

        $response = array();

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    //echo "<p>" . $row["sname"] . "</p>";
                    array_push($response,array(
                "sid" => $row['sid'],
                "sname" => $row['sname'],
                "simage" => $row['simage'],
                "sadmsnno" => $row['sadmsnno'],
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
                "tution_rate" => $row['tution_rate'],
                "bus_rate" => $row['bus_rate'],
                "hostel_rate" => $row['hostel_rate'],
                "status" => $row['status'],
                ));
                }
                 echo json_encode($response);
            } else{
                //echo "<p>No matches found</p>";
            }
           
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);



}else if(isset($_REQUEST['active_parent'])){

    $sql = "SELECT * FROM `parents` WHERE `spstatus` = 0 AND ( `spname` LIKE ? OR `smname` LIKE ? ) ORDER BY `spname`, `smname` LIMIT 12 ";

    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_term,$param_term);

        // Set parameters
        $param_term = $_REQUEST['active_parent'] . '%';

        $response = array();

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    //echo "<p>" . $row["sname"] . "</p>";
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
                 echo json_encode($response);
            } else{
                //echo "<p>No matches found</p>";
            }
           
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
} if(isset($_REQUEST['parent'])){
    // Prepare a select statement`studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
    $sql = "SELECT * FROM `parents` WHERE `spname` LIKE ? ";

    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = $_REQUEST['parent'] . '%';

        $response = array();

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    //echo "<p>" . $row["sname"] . "</p>";
                    array_push($response,array(
                "parent_id" => $row['parent_id'],
                "spname" => $row['spname'],
                "spnumber" => $row['spnumber'],
                
                ));
                }
                 echo json_encode($response);
            } else{
                //echo "<p>No matches found</p>";
            }
           
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);


}else if(isset($_REQUEST['active_student'])){

    $sql = "SELECT * FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`status`= 0 AND `studentinfo`.`sname` LIKE ?";

    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = $_REQUEST['active_student'] . '%';

        $response = array();

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    //echo "<p>" . $row["sname"] . "</p>";
                    array_push($response,array(
                "sid" => $row['sid'],
                "sname" => $row['sname'],
                "simage" => $row['simage'],
                "sadmsnno" => $row['sadmsnno'],
                "sadmsnno" => $row['sadmsnno'],
                "dob" => $row['dob'],
                "spname" => $row['spname'],
                "spnumber" => $row['spnumber'],
                "smname" => $row['smname'],
                "sroll" => $row['sroll'],
                "saddress" => $row['saddress'],
                "sclass" => $row['sclass'],
                "ssec" => $row['ssec'],
                "tution_rate" => $row['tution_rate'],
                "bus_rate" => $row['bus_rate'],
                "hostel_rate" => $row['hostel_rate'],
                ));
                }
                 echo json_encode($response);
            } else{
                //echo "<p>No matches found</p>";
            }
           
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}else if(isset($_REQUEST['inactive_student'])){

    $sql = "SELECT * FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`status`<> 0 AND `studentinfo`.`sname` LIKE ?";

    if($stmt = mysqli_prepare($db, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "s", $param_term);

        // Set parameters
        $param_term = $_REQUEST['inactive_student'] . '%';

        $response = array();

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
            
            // Check number of rows in the result set
            if(mysqli_num_rows($result) > 0){
                
                // Fetch result rows as an associative array
                while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                    //echo "<p>" . $row["sname"] . "</p>";
                    array_push($response,array(
                "sid" => $row['sid'],
                "sname" => $row['sname'],
                "simage" => $row['simage'],
                "sadmsnno" => $row['sadmsnno'],
                "sadmsnno" => $row['sadmsnno'],
                "dob" => $row['dob'],
                "spname" => $row['spname'],
                "spnumber" => $row['spnumber'],
                "smname" => $row['smname'],
                "sroll" => $row['sroll'],
                "saddress" => $row['saddress'],
                "sclass" => $row['sclass'],
                "ssec" => $row['ssec'],
                "tution_rate" => $row['tution_rate'],
                "bus_rate" => $row['bus_rate'],
                "hostel_rate" => $row['hostel_rate'],
                ));
                }
                 echo json_encode($response);
            } else{
                //echo "<p>No matches found</p>";
            }
           
        } else{
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
}


 
// close connection
mysqli_close($db);
?>