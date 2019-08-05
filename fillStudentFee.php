<?php 

/*$dbs = array("demodb" , "nirmaldb", "darpandb", "dpsbrtdb", "easthorizondb","everestdb","motherlanddb","himalayadb", "himalayandb", "mahendradb", "navodayadb","orchiddb", "pokhariyadb", "publicdb","purwanchaldb","sunshinedb", "shreeramdb", "sunrisedb");*/

/*$dbs = array("purwanchaldb" , "satyanarayandb" , "everestdb" );*/

$dbs = array("dpsbrtdb" );

for($x = 0; $x < count($dbs); $x++) {

	$db = mysqli_connect('localhost','krishnagek','poopoo',$dbs[$x]);




    $sql1=mysqli_query($db, "SELECT * FROM `class` WHERE `year_id` = 7 ");

    $tution_fee = 0;
    
    while($row1 = $sql1->fetch_assoc()) {
        $classId = 0;

        $tution_fee = $row1["tution_fee"];

        $classId = $row1["class_id"];

        echo "Class : ".$row1["class_name"]."<br>";

        $sql2=mysqli_query($db, "SELECT * FROM `studentinfo` WHERE `sclass` = '$classId' AND `status` = 0");

        while($row2 = $sql2->fetch_assoc()) {
            
            $sid = 0;

            $sid = $row2["sid"];
                

                
                
                $sql3=mysqli_query($db, "UPDATE `studentinfo` SET  `tution`= 1 , `tution_fee`= '$tution_fee' WHERE `sid`= '$sid' ");

                    if($sql3) {

                            echo "Student : ".$row2["sname"]." - class : ".$row1["class_name"]." - TutionFee : ".$tution_fee;
                            echo "<br><br>";
                    } else {

                        echo "failed id = ".$student_id." - " . mysqli_error($db); echo "<br>"; 
                    }
                

        }
    }
}
?>

