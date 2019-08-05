<?php 

/*$dbs = array("demodb" , "nirmaldb", "darpandb", "dpsbrtdb", "easthorizondb","everestdb","motherlanddb","himalayadb", "himalayandb", "mahendradb", "navodayadb","orchiddb", "pokhariyadb", "publicdb","purwanchaldb","sunshinedb", "shreeramdb", "sunrisedb");*/

/*$dbs = array("purwanchaldb" , "satyanarayandb" , "everestdb" );*/

$dbs = array("dpsbrtdb" );

for($x = 0; $x < count($dbs); $x++) {

	$db = mysqli_connect('localhost','krishnagek','poopoo',$dbs[$x]);



    $sql1=mysqli_query($db, "SELECT `student_due`.* , `studentinfo`.`tution_fee`,`studentinfo`.`computer_fee`,`studentinfo`.`hostel_fee`,`studentinfo`.`bus_fee`,`fee_types`.`feetype_title` FROM `student_due` 
    	INNER JOIN `studentinfo` ON `student_due`.`std_id` = `studentinfo`.`sid` 
    	INNER JOIN `fee_types` ON `student_due`.`feetype_id` = `fee_types`.`feetype_id` AND `fee_types`.`feetype_title` = 'Tution Fee' 
    	WHERE `student_due`.`status` = 1 AND `student_due`.`live_status` =1 ");

    $tution_fee = 0;
    
    while($row1 = $sql1->fetch_assoc()) {

    	$id = $row1["id"];
    	$std_id = $row1["std_id"];
        $tution_fee = $row1["tution_fee"];
        $computer_fee = $row1["computer_fee"];
        $hostel_fee = $row1["hostel_fee"];
        $bus_fee = $row1["bus_fee"];
        $feetype_title = $row1["feetype_title"];


        if ($feetype_title=="Tution Fee") {

        echo "student To Be updated".$id."-".$std_id."-for-".$feetype_title."-".$tution_fee."-".$computer_fee."-".$hostel_fee."-".$bus_fee."<br>";

            if (!empty($tution_fee)) {
                $sql3=mysqli_query($db, "UPDATE `student_due` SET  `balance`= '$tution_fee' WHERE `id`= '$id' ");
                if($sql3) {
                        echo "Student due : ".$id." - TutionFee : ".$tution_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }else{

                $sql3=mysqli_query($db, "DELETE FROM `student_due` WHERE `id`= '$id' ");

                if($sql3) {
                        echo "Student due : ".$id." - Deleted because tution fee : ".$tution_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }
        }
        if ($feetype_title=="Computer Fee") {

        echo "student To Be updated".$id."-".$std_id."-for-".$feetype_title."-".$tution_fee."-".$computer_fee."-".$hostel_fee."-".$bus_fee."<br>";
            
            if (!empty($computer_fee)) {
                $sql3=mysqli_query($db, "UPDATE `student_due` SET  `balance`= '$computer_fee' WHERE `id`= '$id' ");
                if($sql3) {
                        echo "Student due : ".$id." - computer_fee : ".$computer_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }else{

                $sql3=mysqli_query($db, "DELETE FROM `student_due` WHERE `id`= '$id' ");

                if($sql3) {
                        echo "Student due : ".$id." - Deleted because Computer fee : ".$computer_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }
        }
        if ($feetype_title=="Hostel Fee") {

        echo "student To Be updated".$id."-".$std_id."-for-".$feetype_title."-".$tution_fee."-".$computer_fee."-".$hostel_fee."-".$bus_fee."<br>";
            
            if (!empty($hostel_fee)) {
                $sql3=mysqli_query($db, "UPDATE `student_due` SET  `balance`= '$hostel_fee' WHERE `id`= '$id' ");
                if($sql3) {
                        echo "Student due : ".$id." - Hostel Fee : ".$hostel_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }else{

                $sql3=mysqli_query($db, "DELETE FROM `student_due` WHERE `id`= '$id' ");

                if($sql3) {
                        echo "Student due : ".$id." - Deleted because Hostel fee : ".$hostel_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }
        }
        if ($feetype_title=="Bus Fee") {

        echo "student To Be updated".$id."-".$std_id."-for-".$feetype_title."-".$tution_fee."-".$computer_fee."-".$hostel_fee."-".$bus_fee."<br>";
            
            if (!empty($bus_fee)) {
                $sql3=mysqli_query($db, "UPDATE `student_due` SET  `balance`= '$bus_fee' WHERE `id`= '$id' ");
                if($sql3) {
                        echo "Student due : ".$id." - Bus Fee : ".$bus_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }else{

                $sql3=mysqli_query($db, "DELETE FROM `student_due` WHERE `id`= '$id' ");

                if($sql3) {
                        echo "Student due : ".$id." - Deleted because Bus fee : ".$bus_fee;
                        echo "<br>";
                } else {
                    echo "failed id = ".$id." - " . mysqli_error($db); echo "<br>"; 
                }
            }
        }

        
   

        
    }
}
?>

