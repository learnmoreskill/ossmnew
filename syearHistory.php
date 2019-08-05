<?php 
// Run below line
// https://a1pathshala.com/manager/syearHistory.php

/*$dbs = array("demodb" , "nirmaldb", "darpandb", "dpsbrtdb", "easthorizondb","everestdb","motherlanddb","himalayadb", "himalayandb", "mahendradb", "navodayadb","orchiddb", "pokhariyadb", "publicdb","purwanchaldb","sunshinedb", "shreeramdb", "sunrisedb");*/

$dbs = array("pokhariyadb");

for($x = 0; $x < count($dbs); $x++) {

	$db = mysqli_connect('localhost','krishnagek','poopoo',$dbs[$x]);

	$sql=mysqli_query($db, "SELECT * FROM `studentinfo` WHERE `batch_year_id` = 7 ");
    $count78=mysqli_num_rows($sql);

    $date = "2019-06-07";
    $updatedCount = 0;

    echo "Count=".$count78."<br><br>";

    while($row = $sql->fetch_assoc()) {

        $student_id = $row["sid"];

        $sqlcheck=mysqli_query($db, "SELECT `syear_id` FROM `syearhistory` WHERE `student_id` ='$student_id' AND `year_id` = 7 ");
        $count77=mysqli_num_rows($sqlcheck);

    	if (empty($count77)) {

            


            $class_id = ((!empty($row["sclass"]))? $row["sclass"] : 0 );
            $section_id = ((!empty($row["ssec"]))? $row["ssec"] : 0 );
            $roll_no = ((!empty($row["sroll"]))? $row["sroll"] : 0 );

            $payment_type = ((!empty($row["payment_type"]))? $row["payment_type"] : 0 );
            $tution = ((!empty($row["tution"]))? $row["tution"] : 0 );
            $tution_fee = ((!empty($row["tution_fee"]))? $row["tution_fee"] : 0 );
            $bus_id = ((!empty($row["bus_id"]))? $row["bus_id"] : 0 );
            $bus_fee = ((!empty($row["bus_fee"]))? $row["bus_fee"] : 0 );
            $hostel = ((!empty($row["hostel"]))? $row["hostel"] : 0 );
            $hostel_fee = ((!empty($row["hostel_fee"]))? $row["hostel_fee"] : 0 );
            $computer = ((!empty($row["computer"]))? $row["computer"] : 0 );
            $computer_fee = ((!empty($row["computer_fee"]))? $row["computer_fee"] : 0 );


    		$sql1=mysqli_query($db, "INSERT INTO `syearhistory`( `student_id`, `class_id`, `section_id`, `roll_no`, `payment_type`, `tution`, `tution_fee`, `bus_id`, `bus_fee`, `hostel`, `hostel_fee`, `computer`, `computer_fee`, `year_id`, `updated_date`) VALUES ('$student_id', '$class_id', '$section_id', '$roll_no', '$payment_type', '$tution', '$tution_fee', '$bus_id', '$bus_fee', '$hostel', '$hostel_fee', '$computer', '$computer_fee', '7', '$date')");

    		if($sql1) {

    			echo "id = ".$student_id." updated <br>";
                $updatedCount++;

            } else {

              echo "failed id = ".$student_id." - " . mysqli_error($db)."<br>"; 
            }


    		
    	}else{
            echo "id = ".$student_id." already exist <br>";
        }
    	
    }
    echo "Total count = ".$updatedCount."<br><br>";
    
}
?>

