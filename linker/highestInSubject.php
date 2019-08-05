<?php
// ======================== Start Of Getting Highest in subject ===========

          sort($student_array);


          //STUDENT LOOP
          foreach ($student_array as $student_id) {

            //echo $student_id.'==';

                $tempStudentMark = 0.0;


                //m_obtained_mark_student FIRST SUBJECT ID LOOP FOR EACH STTUDENT
                foreach (${'m_obtained_mark_student' . $student_id} as $subjectIDkey => $value) {
                  $tempSubjectMark=0.0;

                  //echo $subjectIDkey."=";
                  if (is_numeric(${'m_obtained_mark_student'.$student_id}[$subjectIDkey][$examid])) {
                    
                    $tempSubjectMark = ${'m_obtained_mark_student'.$student_id}[$subjectIDkey][$examid];
                    $tempStudentMark += ${'m_obtained_mark_student'.$student_id}[$subjectIDkey][$examid];
                  }

                  if ($examIncluded) {
                      foreach ($examIncludeList as $examinclude) {

                        if (is_numeric(${'m_obtained_mark_student'.$student_id}[$subjectIDkey][$examinclude->added_examtype_id])) {

                          $tempSubjectMark += (${'m_obtained_mark_student'.$student_id}[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
                          $tempStudentMark += (${'m_obtained_mark_student'.$student_id}[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
                        }
                      }
                  }

                  $total_mark_in_each_subject_each_student[$subjectIDkey][$student_id] = $tempSubjectMark;



                  //m_obtained_mark_student SECOND EXAM LOOP FOR EACH SUBJECT UNDER EACH STUDENT
                  // foreach (${'m_obtained_mark_student' . $student_id}[$subjectIDkey] as $examIdkey => $value) {

                  //   echo $examIdkey."-".$value."<br>";
                  // }

                //$sHighest[$subjectIDkey] = round($highestSub[$subjectIDkey][$examid], 2);

                // if ($examIncluded) {
                //   //exam added loop
                //   foreach ($examIncludeList as $examinclude) {

                //     $sHighest[$subjectIDkey] += ($highestSub[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
                //   }
                
                // }
              }

              $studentTotalMarkById[$student_id] = $tempStudentMark;
              $studentWithSectionTotalMarkById[$student_section[$student_id]][$student_id] = $tempStudentMark;




            // foreach ($subject_name as $subject_id) {
            //   echo $subject_id;
            // }

            //echo ${'m_obtained_mark_student' . $student_id}


            //echo "<br><br><br>";

                 // $sHighest[$subjectIDkey] += ($highestSub[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
          }

          //echo "mark of student";

          //print_r($total_mark_in_each_subject_each_student['128']);

          //echo "<br>";

          //arsort($total_mark_in_each_subject_each_student['128']);

          //print_r($total_mark_in_each_subject_each_student['128']);

          //echo reset($total_mark_in_each_subject_each_student['128']);
          //print_r($studentTotalMarkById);

















       

        // $queryHS = $db->query("SELECT `marksheet`.`msubject_id`,`marksheet`.`mexam_id`, MAX(CONVERT(`marksheet`.`m_obtained_mark`,decimal(5,2))) AS `msub`
        //         FROM `marksheet` 
        //         INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
        //         WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )
        //           AND `marksheet`.`marksheet_class`='$class_id' 
        //           AND `marksheet`.`year_id`='$year_id'
        //           AND `marksheet`.`month`='$month_id'                   
        //           AND `studentinfo`.`status`= 0
        //           GROUP BY `marksheet`.`msubject_id` , `marksheet`.`mexam_id`");

        //   while($rowHS = $queryHS->fetch_assoc()){

        //     $highestSub[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["msub"];
        //     //echo $rowHS["msub"];

        //   }


        //   echo $addedExamTemp;
        //   print_r($highestSub);
          

        //   //subject loop
        //   foreach ($highestSub as $subjectIDkey => $value) {

        //       echo $subjectIDkey."-".$value."=";
        //       foreach ($highestSub[$subjectIDkey] as $examIdkey => $value) {
        //         echo $examIdkey."-".$value."<br>";
        //       }

        //     $sHighest[$subjectIDkey] = round($highestSub[$subjectIDkey][$examid], 2);

        //     if ($examIncluded) {
        //       //exam added loop
        //       foreach ($examIncludeList as $examinclude) {

        //         $sHighest[$subjectIDkey] += ($highestSub[$subjectIDkey][$examinclude->added_examtype_id]*$examinclude->percent)/100;
        //       }
            
        //     }


            
            
        //   }

      // ======================== End Of Getting Highest in subject ===========

?>