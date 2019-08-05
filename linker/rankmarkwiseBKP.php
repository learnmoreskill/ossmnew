<?php
            // ======================== Start Of Getting Rank ===========
            $rankArray = array(); 

            // ================== Find rank classwise =============
            if (empty($rankselected) || $rankselected==1) {

              // Getting Student list from marksheet
              $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
                        FROM `marksheet` 
                        INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                        WHERE ( `marksheet`.`mexam_id`='$examid' ".$addedExamTemp." )  
                          AND `studentinfo`.`sclass`='$class_id' 
                          AND `marksheet`.`month`='$month_id' 
                          AND `marksheet`.`year_id`='$year_id'
                          AND `studentinfo`.`status`= 0
                          GROUP BY `marksheet`.`mstudent_id`
                        ORDER BY `obt` DESC");

              if($queryRank->num_rows > 0){

                  $total_result = $queryRank->num_rows; // GET TOTAL NO OF STUDENT WHO GIVEN EXAM
                  
                  $checkSameMark=0;
                  $rank = 0;

                  //STUDENT WHILE LOOP
                  while($rowRank = $queryRank->fetch_assoc()){

                    $studentid = $rowRank["mstudent_id"];
                    $failInRank = 0;

                    $rankObtMark = $rankTheoryMark = $rankSubjectType = $rankTHPM = $rankTRPM = array();
                    //echo "student_id:".$studentid."<br>";

                    $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`,`marksheet`.`mexam_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`

                      ,`subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

                      ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm`

                      FROM `marksheet` 

                      LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id`
                            AND `subject`.`subject_class` = '$class_id'
                            AND `subject`.`year_id` = '$year_id'

                      LEFT JOIN `subject_mark` ON `marksheet`.`msubject_id` = `subject_mark`.`subject_id`
                            AND  `subject_mark`.`examtype_id` = '$examid'
                            AND `subject_mark`.`year_id` = '$year_id'

                      WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )
                        AND `marksheet`.`mstudent_id`='$studentid' 
                        AND `marksheet`.`marksheet_class`='$class_id'  
                        AND `marksheet`.`month`='$month_id' 
                        AND `marksheet`.`year_id`='$year_id'
                      ORDER BY `subject`.`sort_order`");


                    while($rowRK = $queryvm->fetch_assoc()){

                      $rankObtMark[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_obtained_mark"];
                      $rankTheoryMark[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_theory"];
                      $rankSubjectType[$rowRK["subject_id"]]['subject_type'] = $rowRK["subject_type"];
                      $rankTHPM[$rowRK["subject_id"]]['th_pm'] = $rowRK["th_pm"];
                      $rankTRPM[$rowRK["subject_id"]]['pr_pm'] = $rowRK["pr_pm"];

                    }

                    //Subject Loop
                    foreach ($rankObtMark as $subjectIDkey => $value_examArray) {
                      $rankTotalSubjectOBT=0.0;
                      $rankTheorySubjectOBT=0.0;

                      //Exam Loop
                      /*foreach ($rankObtMark[$subjectIDkey] as $examIdkey => $value_obt) {
                        echo "Exam Id:".$examIdkey.",Obtained:".$value_obt."<br>";
                        $rankTotalSubjectOBT +=$value_obt;
                      }*/

                      $rankTotalSubjectOBT = round($rankObtMark[$subjectIDkey][$examid], 2);
                      $rankTheorySubjectOBT = round($rankTheoryMark[$subjectIDkey][$examid], 2);

                      if ($examIncluded) {
                        //exam added loop
                        foreach ($examIncludeList as $examinclude) {

                          $rankTotalSubjectOBT += ($rankObtMark[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
                        }
                      
                      }

                      // echo $subjectIDkey."-".$value_examArray."=";
                      // echo "subject_type:".$rankSubjectType[$subjectIDkey]['subject_type']."<br>";
                      // echo "th_pm:".$rankTHPM[$subjectIDkey]['th_pm'];
                      // echo "pr_pm:".$rankTRPM[$subjectIDkey]['pr_pm'];
                      // echo "Total Obtained:".$rankTotalSubjectOBT."<br><br>";

                      if ($examIncluded) {

                        if($rankSubjectType[$subjectIDkey]['subject_type']==3) {
                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==0 && (float)$rankTotalSubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm'])) {

                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==1 && (float)$rankTotalSubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm']+$rankTRPM[$subjectIDkey]['pr_pm'])) {
            

                        }else{
                          $failInRank = 1; 
                          //echo "--fail--";
                        }
                      }else{

                        if($rankSubjectType[$subjectIDkey]['subject_type']==3) {
                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==0 && (float)$rankTheorySubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm'])) {

                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==1 && (float)$rankTheorySubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm']+$rankTRPM[$subjectIDkey]['pr_pm'])) {
            

                        }else{
                          $failInRank = 1; 
                          //echo "--fail--";
                        }

                      }



                    }
                    //echo "<br><br><br><br>";


                      if($failInRank == 1){ 
                        //add null rank with corresponding fail student
                        $rankArray[$studentid] = ''; 

                      }else{ 

                        if ($rowRank["obt"]!=$checkSameMark) {
                          $rank = $rank+1;
                          $checkSameMark = $rowRank["obt"];
                        }
                        //add rank with corresponding pass student
                        $rankArray[$studentid] = $rank.' / '.$total_result; 
                      }
                    
                  }//End of student while loop
              }

            // =========== Find rank Sectionwise ===============
            }else if ($rankselected==2) {

              
              $sectionList= json_decode($backstage->get_section_list_by_class_id($class_id));

              foreach ($sectionList as $seclist) {

                $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
                        FROM `marksheet` 
                        INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                        WHERE ( `marksheet`.`mexam_id`='$examid' ".$addedExamTemp." )  
                          AND `studentinfo`.`sclass`='$class_id' 
                          AND `studentinfo`.`ssec`='$seclist->section_id'
                          AND `marksheet`.`month`='$month_id' 
                          AND `marksheet`.`year_id`='$year_id'
                          AND `studentinfo`.`status`= 0
                          GROUP BY `marksheet`.`mstudent_id`
                        ORDER BY `obt` DESC");

                    if($queryRank->num_rows > 0){
                    $total_result = $queryRank->num_rows;
                    $checkSameMark=0;
                    $rank = 0;

                    while($rowRank = $queryRank->fetch_assoc()){

                      $studentid = $rowRank["mstudent_id"];
                      $failInRank = 0;

                      $rankObtMark = $rankTheoryMark = $rankSubjectType = $rankTHPM = $rankTRPM = array();
                      //echo "student_id:".$studentid."<br>";

                      $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`,`marksheet`.`mexam_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`

                        ,`subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

                        ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm`

                        FROM `marksheet` 

                        LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id`
                              AND `subject`.`subject_class` = '$class_id'
                              AND `subject`.`year_id` = '$year_id'

                        LEFT JOIN `subject_mark` ON `marksheet`.`msubject_id` = `subject_mark`.`subject_id`
                              AND  `subject_mark`.`examtype_id` = '$examid'
                              AND `subject_mark`.`year_id` = '$year_id'

                        WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )
                          AND `marksheet`.`mstudent_id`='$studentid' 
                          AND `marksheet`.`marksheet_class`='$class_id'
                          AND `marksheet`.`marksheet_section`='$seclist->section_id'  
                          AND `marksheet`.`month`='$month_id' 
                          AND `marksheet`.`year_id`='$year_id'
                        ORDER BY `subject`.`sort_order`");
                    while($rowRK = $queryvm->fetch_assoc()){

                      $rankObtMark[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_obtained_mark"];
                      $rankTheoryMark[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_theory"];
                      $rankSubjectType[$rowRK["subject_id"]]['subject_type'] = $rowRK["subject_type"];
                      $rankTHPM[$rowRK["subject_id"]]['th_pm'] = $rowRK["th_pm"];
                      $rankTRPM[$rowRK["subject_id"]]['pr_pm'] = $rowRK["pr_pm"];

                    }

                    //Subject Loop
                    foreach ($rankObtMark as $subjectIDkey => $value_examArray) {
                      $rankTotalSubjectOBT=0.0;
                      $rankTheorySubjectOBT=0.0;

                      $rankTotalSubjectOBT = round($rankObtMark[$subjectIDkey][$examid], 2);
                      $rankTheorySubjectOBT = round($rankTheoryMark[$subjectIDkey][$examid], 2);

                      if ($examIncluded) {
                        //exam added loop
                        foreach ($examIncludeList as $examinclude) {

                          $rankTotalSubjectOBT += ($rankObtMark[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
                        }
                      
                      }

                      if ($examIncluded) {

                        if($rankSubjectType[$subjectIDkey]['subject_type']==3) {
                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==0 && (float)$rankTotalSubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm']+$rankTRPM[$subjectIDkey]['pr_pm'])) {

                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==1 && (float)$rankTotalSubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm']+$rankTRPM[$subjectIDkey]['pr_pm'])) {
            

                        }else{
                          $failInRank = 1; 
                          //echo "--fail--";
                        }
                      }else{

                        if($rankSubjectType[$subjectIDkey]['subject_type']==3) {
                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==0 && (float)$rankTheorySubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm'])) {

                        }else if($rankSubjectType[$subjectIDkey]['subject_type']==1 && (float)$rankTheorySubjectOBT >= (float)($rankTHPM[$subjectIDkey]['th_pm'])) {
            

                        }else{
                          $failInRank = 1; 
                          //echo "--fail--";
                        }

                      }
                    }

                      if($failInRank == 1){ 
                        //add null rank with corresponding fail student
                        $rankArray[$studentid] = ''; 

                      }else{ 

                        if ($rowRank["obt"]!=$checkSameMark) {
                          $rank = $rank+1;
                          $checkSameMark = $rowRank["obt"];
                        }
                        //add rank with corresponding pass student
                        $rankArray[$studentid] = $rank.' / '.$total_result; 
                      }
                      
                    }
                  }

              }
            }
?>