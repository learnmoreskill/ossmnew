<?php
        $queryHS = $db->query("SELECT `subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

                ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm`,`subject_mark`.`examtype_id` AS `subject_mark_exam_id`

                ,`marksheet`.*

                FROM `subject`

                INNER JOIN `marksheet` ON `subject`.`subject_id` = `marksheet`.`msubject_id`

                        AND (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )
                        AND `marksheet`.`marksheet_class`='$class_id' 
                        AND `marksheet`.`year_id`='$year_id'
                        AND `marksheet`.`month`='$month_id'

                INNER JOIN `syearhistory` ON `marksheet`.`mstudent_id` = `syearhistory`.`student_id`
                        AND `syearhistory`.`year_id` = '$year_id'

                LEFT JOIN `subject_mark` ON `subject`.`subject_id` = `subject_mark`.`subject_id`
                            AND  `subject_mark`.`examtype_id` = '$examid'
                            AND `subject_mark`.`year_id` = '$year_id'
                            

                WHERE `subject`.`subject_class` = '$class_id' 
                            AND `subject`.`year_id` = '$year_id'
                            AND `subject`.`status` = 0
                ORDER BY `subject`.`sort_order` ");

        while($rowHS = $queryHS->fetch_assoc()){

            $student_array[$rowHS["mstudent_id"]] = $rowHS["mstudent_id"];
            $student_section[$rowHS["mstudent_id"]] = $rowHS["marksheet_section"];

            ${'m_obtained_mark_student' . $rowHS["mstudent_id"]}[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["m_obtained_mark"];

            ${'theory_mark_student' . $rowHS["mstudent_id"]}[$rowHS["subject_id"]][$rowHS["mexam_id"]] = $rowHS["m_theory"];

            ${'practical_mark_student' . $rowHS["mstudent_id"]}[$rowHS["subject_id"]][$rowHS["mexam_id"]] = $rowHS["m_practical"];


            ${'mMT' . $rowHS["mstudent_id"]}[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["m_mt"];
            ${'mOT' . $rowHS["mstudent_id"]}[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["m_ot"];
            ${'mECA' . $rowHS["mstudent_id"]}[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["m_eca"];
            ${'mLP' . $rowHS["mstudent_id"]}[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["m_lp"];
            ${'mNB' . $rowHS["mstudent_id"]}[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["m_nb"];
            ${'mSE' . $rowHS["mstudent_id"]}[$rowHS["msubject_id"]][$rowHS["mexam_id"]] = $rowHS["m_se"];

            $subject_name[$rowHS["msubject_id"]] = $rowHS["subject_name"];
            $subject_type[$rowHS["msubject_id"]] = $rowHS["subject_type"];

            if ($rowHS["subject_mark_exam_id"]==$examid) {

                $subject_THFM[$rowHS["subject_id"]] = $rowHS["th_fm"];
                $subject_PRFM[$rowHS["subject_id"]] = $rowHS["pr_fm"];

                $subject_THPM[$rowHS["subject_id"]] = $rowHS["th_pm"];
                $subject_PRPM[$rowHS["subject_id"]] = $rowHS["pr_pm"];

            }

            

            // print_r($subject_name);

            // print_r($subject_type);

            // print_r($student_array);

             

        }



        /* START GETTING EAM INCLUDED MARK AND PUTTING IN ARRAY */
        if ($examIncluded) {

          foreach ($examIncludeList as $examinclude) {

            //${'includeMark' . $examinclude->added_examtype_id} = array();

            $queryincmark = $db->query("SELECT `subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

            ,`marksheet`.`mstudent_id`,`marksheet`.`marksheet_id`, `marksheet`.`m_obtained_mark`,`marksheet`.`marksheet_status`

            FROM `subject`

            INNER JOIN `marksheet` ON `subject`.`subject_id` = `marksheet`.`msubject_id`
                        AND `marksheet`.`mexam_id`='$examinclude->added_examtype_id'
                        AND `marksheet`.`marksheet_class`='$class_id'
                        AND `marksheet`.`month`='$month_id'
                        AND `marksheet`.`year_id`='$year_id'
                        
            INNER JOIN `syearhistory` ON `marksheet`.`mstudent_id` = `syearhistory`.`student_id`
                        AND `syearhistory`.`year_id` = '$year_id'

            WHERE `subject`.`subject_class` = '$class_id'
                        AND `subject`.`year_id` = '$year_id'
                        AND `subject`.`status` = 0 
            ORDER BY `subject`.`sort_order` ");

            while($rowincmark = $queryincmark->fetch_assoc()){

              ${'includeMark' . $rowincmark["mstudent_id"]}[$examinclude->added_examtype_id][$rowincmark["subject_id"]] = (($rowincmark["subject_type"]==3)?$rowincmark["m_obtained_mark"] : ($rowincmark["m_obtained_mark"]*$examinclude->percent)/100 );

            }
          }
        }
        /* END GETTING EAM INCLUDED MARK AND PUTTING IN ARRAY */
?>