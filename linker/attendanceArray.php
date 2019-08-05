<?php
        $queryAA = $db->query("SELECT `attendance_manual`.`id`,`studentinfo`.`sid`,`attendance_manual`.`count` 
            FROM `studentinfo`
            LEFT JOIN `attendance_manual` 
              ON `studentinfo`.`sid` = `attendance_manual`.`student_id`
              AND `attendance_manual`.`exam_id` ='$examid'
              AND `attendance_manual`.`year_id` ='$year_id' 
              AND `attendance_manual`.`month_id` ='$month_id' 

            INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
                        AND `syearhistory`.`year_id` = '$year_id'
                        AND `syearhistory`.`class_id` = '$class_id' 
                        ". (empty($section_id) ? "" : "AND `syearhistory`.`section_id`='$section_id' ") . "
            WHERE `studentinfo`.`status` = 0 ");

        while($rowAA = $queryAA->fetch_assoc()){

            $attendanceArray[$rowAA["sid"]] = $rowAA["count"];
            
        }

?>