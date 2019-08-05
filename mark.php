<?php 

$dbs = array("demodb" , "nirmaldb", "darpandb", "dpsbrtdb", "easthorizondb","everestdb","motherlanddb","himalayadb", "himalayandb", "mahendradb", "navodayadb","orchiddb", "pokhariyadb", "publicdb","purwanchaldb","sunshinedb", "shreeramdb", "sunrisedb");

for($x = 0; $x < count($dbs); $x++) {

	$db = mysqli_connect('localhost','krishnagek','poopoo',$dbs[$x]);

	$sql=mysqli_query($db, "SELECT * FROM `marksheet` ");
    $count78=mysqli_num_rows($sql);

    while($row = $sql->fetch_assoc()) {

    	/*if (empty($row["m_theory"])) {*/



            $m_theory = ((is_numeric($row["m_theory"]))? $row["m_theory"] : 0 );
            $m_practical = ((is_numeric($row["m_practical"]))? $row["m_practical"] : 0 );
            $m_mt = ((is_numeric($row["m_mt"]))? $row["m_mt"] : 0 );
            $m_ot = ((is_numeric($row["m_ot"]))? $row["m_ot"] : 0 );
            $m_eca = ((is_numeric($row["m_eca"]))? $row["m_eca"] : 0 );
            $m_lp = ((is_numeric($row["m_lp"]))? $row["m_lp"] : 0 );
            $m_nb = ((is_numeric($row["m_nb"]))? $row["m_nb"] : 0 );
            $m_se = ((is_numeric($row["m_se"]))? $row["m_se"] : 0 );

    		$total = $m_theory+$m_practical+$m_mt+$m_ot+$m_eca+$m_lp+$m_nb+$m_se;
    		$id = $row["marksheet_id"]; 

    		$sql1=mysqli_query($db, "UPDATE `marksheet` SET `m_obtained_mark` = '$total' WHERE `marksheet_id` = '$id'  ");

    		if($sql1) {

    			echo "id = ".$id." updated = ".$total;
    			echo "<br><br>";
            } else {

              echo "failed id = ".$id." - " . mysqli_error($db); echo "<br><br>"; }

    		
    	/*}*/
    	
    }

    echo "Count=".$count78;
    echo "<br><br>";
}
?>

