<?php 

/*$dbs = array("demodb" , "nirmaldb", "darpandb", "dpsbrtdb", "easthorizondb","everestdb","motherlanddb","himalayadb", "himalayandb", "mahendradb", "navodayadb","orchiddb", "pokhariyadb", "publicdb","purwanchaldb","sunshinedb", "shreeramdb", "sunrisedb");*/

/*$dbs = array("purwanchaldb" , "satyanarayandb" , "everestdb" );*/

$dbs = array("purwanchaldb" );

for($x = 0; $x < count($dbs); $x++) {

	$db = mysqli_connect('localhost','krishnagek','poopoo',$dbs[$x]);




    $sql1=mysqli_query($db, "SELECT * FROM `section` ");
    
    while($row1 = $sql1->fetch_assoc()) {
        $classId = 0;
        $sectionId = 0;

        $classId = $row1["section_class"];
        $sectionId = $row1["section_id"];

        echo "Class : ".$row1["section_class"]."- Section : ".$row1["section_name"]."<br>";

        $sql2=mysqli_query($db, "SELECT * FROM `studentinfo` WHERE `sclass` = '$classId' AND `ssec` = '$sectionId' AND `status` = 0 ORDER BY `sname`");
        $newRoll = 1;
        while($row2 = $sql2->fetch_assoc()) {
            $sid = 0;

            $sid = $row2["sid"];
                

                echo "Student : ".$row2["sname"]." - Roll : ".$row2["sroll"]." - New Roll : ".$newRoll."<br>";
                
                $sql3=mysqli_query($db, "UPDATE `studentinfo` SET `sroll`= '$newRoll' WHERE `sid`= '$sid' ");

                    if($sql3) {

                            echo "id = ".$student_id." updated ";
                            echo "<br><br>";
                    } else {

                        echo "failed id = ".$student_id." - " . mysqli_error($db); echo "<br>"; 
                    }


                $newRoll++;
                

        }
    }
}
?>

