<?php
            // ======================== Start Of Getting Rank ===========
            $rankArray = array(); 

            // ================== Find rank classwise =============
            if (empty($rankselected) || $rankselected==1) {

              arsort($studentTotalMarkById);


              // print_r($studentTotalMarkById);
              // echo ;

              // // Getting Student list from marksheet
              // $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
              //           FROM `marksheet` 
              //           INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
              //           WHERE ( `marksheet`.`mexam_id`='$examid' ".$addedExamTemp." )  
              //             AND `studentinfo`.`sclass`='$class_id' 
              //             AND `marksheet`.`month`='$month_id' 
              //             AND `marksheet`.`year_id`='$year_id'
              //             AND `studentinfo`.`status`= 0
              //             GROUP BY `marksheet`.`mstudent_id`
              //           ORDER BY `obt` DESC");

              if(count($studentTotalMarkById) > 0){

                  $total_result = count($studentTotalMarkById); // GET TOTAL NO OF STUDENT WHO GIVEN EXAM
                  
                  $checkSameMark=0;
                  $rank = 0;

                  //STUDENT WHILE LOOP
                  foreach ($studentTotalMarkById as $studentid => $allMark) {

                    $failInRank = 0;

                    //$m_obtained_mark_student = $theory_mark_student = $rankSubjectType = $rankTHPM = $rankTRPM = array();
                    //$theory_mark_student = $rankSubjectType = $rankTHPM = $rankTRPM = array();

                    //echo "student_id:".$studentid."<br>";

                    // $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`,`marksheet`.`mexam_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`

                    //   ,`subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

                    //   ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm`

                    //   FROM `marksheet` 

                    //   LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id`
                    //         AND `subject`.`subject_class` = '$class_id'
                    //         AND `subject`.`year_id` = '$year_id'

                    //   LEFT JOIN `subject_mark` ON `marksheet`.`msubject_id` = `subject_mark`.`subject_id`
                    //         AND  `subject_mark`.`examtype_id` = '$examid'
                    //         AND `subject_mark`.`year_id` = '$year_id'

                    //   WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )
                    //     AND `marksheet`.`mstudent_id`='$studentid' 
                    //     AND `marksheet`.`marksheet_class`='$class_id'  
                    //     AND `marksheet`.`month`='$month_id' 
                    //     AND `marksheet`.`year_id`='$year_id'
                    //   ORDER BY `subject`.`sort_order`");


                    // while($rowRK = $queryvm->fetch_assoc()){

                    //   //$m_obtained_mark_student[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_obtained_mark"];
                    //   //$theory_mark_student[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_theory"];
                    //   //$rankSubjectType[$rowRK["subject_id"]]['subject_type'] = $rowRK["subject_type"];
                    //   //$rankTHPM[$rowRK["subject_id"]]['th_pm'] = $rowRK["th_pm"];
                    //   //$rankTRPM[$rowRK["subject_id"]]['pr_pm'] = $rowRK["pr_pm"];

                    // }

                    //Subject Loop
                    foreach (${'m_obtained_mark_student' . $studentid} as $subjectIDkey => $value_examArray) {
                      $rankTotalSubjectOBT=0.0;
                      $rankTheorySubjectOBT=0.0;

                      //Exam Loop
                      /*foreach ($m_obtained_mark_student[$subjectIDkey] as $examIdkey => $value_obt) {
                        echo "Exam Id:".$examIdkey.",Obtained:".$value_obt."<br>";
                        $rankTotalSubjectOBT +=$value_obt;
                      }*/

                      $rankTotalSubjectOBT = round(${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid], 2);

                      $rankTheorySubjectOBT = round(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid], 2);

                      if ($examIncluded) {
                        //exam added loop
                        foreach ($examIncludeList as $examinclude) {

                          $rankTotalSubjectOBT += (${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
                        }
                      
                      }



                      // echo $subjectIDkey."-".$value_examArray."=";
                      // echo "subject_type:".$rankSubjectType[$subjectIDkey]['subject_type']."<br>";
                      // echo "th_pm:".$rankTHPM[$subjectIDkey]['th_pm'];
                      // echo "pr_pm:".$rankTRPM[$subjectIDkey]['pr_pm'];
                      // echo "Total Obtained:".$rankTotalSubjectOBT."<br><br>";

                      //IF EXAM INCLUDED THEN PASS FAIL EVALUATED BY TOTAL OBTAINED IN EACH SUBJECT
                      if ($examIncluded) {

                          if($subject_type[$subjectIDkey] == 3) {
                          }else if($subject_type[$subjectIDkey] == 0 && (float)$rankTotalSubjectOBT >= (float)($subject_THPM[$subjectIDkey])) {
                          }else if($subject_type[$subjectIDkey] == 1 && (float)$rankTotalSubjectOBT >= (float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey])) {
                          }
                          else{
                            $failInRank = 1;
                          }
                      //IF EXAM NOT INCLUDED THEN PASS FAIL EVALUATED BY THEORY IN EACH SUBJECT
                      }else{

                          if($subject_type[$subjectIDkey] == 0 && (float)$rankTheorySubjectOBT >= (float)$subject_THPM[$subjectIDkey]) {
                          }else if($subject_type[$subjectIDkey] == 1 && (float)$rankTheorySubjectOBT >= (float)$subject_THPM[$subjectIDkey]) {
                          }else if($subject_type[$subjectIDkey] == 3) {
                          }else{
                            $failInRank = 1;
                          }

                      }


                    }
                    //echo "<br><br><br><br>";


                      if($failInRank == 1){ 
                        //add null rank with corresponding fail student
                        $rankArray[$studentid] = ''; 

                      }else{ 

                        if ($allMark!=$checkSameMark) {
                          $rank = $rank+1;
                          $checkSameMark = $allMark;
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

                arsort($studentWithSectionTotalMarkById[$seclist->section_id]);

                // print_r($studentWithSectionTotalMarkById[$seclist->section_id]);

                // $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
                //         FROM `marksheet` 
                //         INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                //         WHERE ( `marksheet`.`mexam_id`='$examid' ".$addedExamTemp." )  
                //           AND `studentinfo`.`sclass`='$class_id' 
                //           AND `studentinfo`.`ssec`='$seclist->section_id'
                //           AND `marksheet`.`month`='$month_id' 
                //           AND `marksheet`.`year_id`='$year_id'
                //           AND `studentinfo`.`status`= 0
                //           GROUP BY `marksheet`.`mstudent_id`
                //         ORDER BY `obt` DESC");

                if(count($studentWithSectionTotalMarkById[$seclist->section_id]) > 0){

                    $total_result = count($studentWithSectionTotalMarkById[$seclist->section_id]);
                    $checkSameMark=0;
                    $rank = 0;

                  foreach ($studentWithSectionTotalMarkById[$seclist->section_id] as $studentid => $allMark) {

                      $failInRank = 0;

                      //$m_obtained_mark_student = $theory_mark_student = $rankSubjectType = $rankTHPM = $rankTRPM = array();
                      //echo "student_id:".$studentid."<br>";

                    //   $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`,`marksheet`.`mexam_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`

                    //     ,`subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

                    //     ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm`

                    //     FROM `marksheet` 

                    //     LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id`
                    //           AND `subject`.`subject_class` = '$class_id'
                    //           AND `subject`.`year_id` = '$year_id'

                    //     LEFT JOIN `subject_mark` ON `marksheet`.`msubject_id` = `subject_mark`.`subject_id`
                    //           AND  `subject_mark`.`examtype_id` = '$examid'
                    //           AND `subject_mark`.`year_id` = '$year_id'

                    //     WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )
                    //       AND `marksheet`.`mstudent_id`='$studentid' 
                    //       AND `marksheet`.`marksheet_class`='$class_id'
                    //       AND `marksheet`.`marksheet_section`='$seclist->section_id'  
                    //       AND `marksheet`.`month`='$month_id' 
                    //       AND `marksheet`.`year_id`='$year_id'
                    //     ORDER BY `subject`.`sort_order`");
                    // while($rowRK = $queryvm->fetch_assoc()){

                    //   //$m_obtained_mark_student[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_obtained_mark"];
                    //   //$theory_mark_student[$rowRK["subject_id"]][$rowRK["mexam_id"]] = $rowRK["m_theory"];
                    //   //$rankSubjectType[$rowRK["subject_id"]]['subject_type'] = $rowRK["subject_type"];
                    //   //$rankTHPM[$rowRK["subject_id"]]['th_pm'] = $rowRK["th_pm"];
                    //   //$rankTRPM[$rowRK["subject_id"]]['pr_pm'] = $rowRK["pr_pm"];

                    // }

                    //Subject Loop
                    foreach (${'m_obtained_mark_student' . $studentid} as $subjectIDkey => $value_examArray) {
                      $rankTotalSubjectOBT=0.0;
                      $rankTheorySubjectOBT=0.0;

                      $rankTotalSubjectOBT = round(${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid], 2);
                      $rankTheorySubjectOBT = round(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid], 2);

                      if ($examIncluded) {
                        //exam added loop
                        foreach ($examIncludeList as $examinclude) {

                          $rankTotalSubjectOBT += (${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
                        }
                      
                      }

                      if ($examIncluded) {

                        if($subject_type[$subjectIDkey] == 3) {
                        }else if($subject_type[$subjectIDkey] == 0 && (float)$rankTotalSubjectOBT >= (float)($subject_THPM[$subjectIDkey])) {

                        }else if($subject_type[$subjectIDkey] == 1 && (float)$rankTotalSubjectOBT >= (float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey])) {
            

                        }else{
                          $failInRank = 1; 
                          //echo "--fail--";
                        }
                      }else{

                        if($subject_type[$subjectIDkey] == 3) {
                        }else if($subject_type[$subjectIDkey] == 0 && (float)$rankTheorySubjectOBT >= (float)($subject_THPM[$subjectIDkey])) {

                        }else if($subject_type[$subjectIDkey] == 1 && (float)$rankTheorySubjectOBT >= (float)($subject_THPM[$subjectIDkey])) {
            

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

                        if ($allMark!=$checkSameMark) {
                          $rank = $rank+1;
                          $checkSameMark = $allMark;
                        }
                        //add rank with corresponding pass student
                        $rankArray[$studentid] = $rank.' / '.$total_result; 
                      }
                      
                    }
                  }

              }
            }
?>