<?php
include('session.php');

include("../important/backstage.php");
$backstage = new back_stage_class();

if( isset( $_POST['markstoken'] ) )
{
  $class_id = $_POST['class_id'];
  $section_id = $_POST['section_id'];
  $examid = $_POST['examtypeid'];

  $month_id = $_POST['month_id'];
  $year_id = $_POST['yearid'];

  $rankselected = $_POST['rankselected'];



    $examtype_details = json_decode($backstage->get_examtype_details_by_examid($examid));

    if (empty($month_id)) { 
      $month_id = 0;
    }

    if (!$examtype_details->is_monthly){
           $month_id = 0;
    }

    $examIncludeList = json_decode($backstage->get_examinclude_list_by_examtype_id($examid,$year_id));

    if (count((array)$examIncludeList)<1) { $examIncluded = false; }else{ $examIncluded = true;  }

    $addedExamTemp='';
    if ($examIncluded) {
      foreach ($examIncludeList as $examinclude) {
        $addedExamTemp .= "OR `marksheet`.`mexam_id`='".$examinclude->added_examtype_id."'";
      }
        
    }


    //check found or empty query
    $queryvm = $db->query("SELECT *  
      FROM `marksheet` 
      INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id`=`studentinfo`.`sid` 
      WHERE `marksheet`.`marksheet_class`='$class_id' " . (empty($section_id) ? "" : "AND `marksheet`.`marksheet_section`='$section_id' ") . "  
      AND (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )  
      AND `marksheet`.`month`='$month_id' 
      AND `marksheet`.`year_id`='$year_id' 
      AND `studentinfo`.`status`=0 ");
    $rowCount = $queryvm->num_rows;

    if($rowCount > 0) {
      $found='1';


      

      //check published or unpublished query
      $querystatus = $db->query("SELECT `marksheet_status` 
        FROM `marksheet` 
        WHERE `marksheet_class` = '$class_id' 
          " . (empty($section_id) ? "" : "AND `marksheet`.`marksheet_section`='$section_id' ") . "
          AND `marksheet`.`mexam_id`='$examid' 
          AND `marksheet`.`month`='$month_id' 
          AND `marksheet`.`year_id`='$year_id' 
        GROUP BY `marksheet_status` ");
      $rowCountStatus = $querystatus->num_rows;
      $statusCheck = $querystatus->fetch_assoc();


    } 
    else{ 
      $found='0'; 
    }

    ?>

    <?php 
    if($found == '1'){


      require('../linker/reportForClassArray.php');
      require('../linker/highestInSubject.php');
      require('../linker/rankmarkwise.php');

      require('../linker/attendanceArray.php');


      if($_POST['markstoken'] =='marksledger' ) { ?> <div class="container" align="right"> 
        <input type='button' id='btn' value='Print Ledger' onclick='printDiv();'>
        <input type='button' id='btn' value='Download PDF' onclick='Export("markstabulationTable");'></div><br>
        <?php 
      }?>

      <style type="text/css">
        th, td {
          border-right: 1px solid #e1e1e1;
        }
      </style>

      <div id="schoolheader" style="display: none;">
        <?php include_once("../printer/printschlheader.php");?>
            <div style="text-align: center;">
                <span class="card-title white-text">Marks Ledger<?php echo (($class_id)? " for class ".$backstage->get_class_name_by_id($class_id):" ").(($section_id)? " : ".$backstage->get_section_name_by_id($section_id):" "); ?></span>
            </div><br>                                       
      </div>
        
      <div id="invoice_print" >
        <div class="row scrollable" >          
          <div class="col s12 m12">
          
          
            <table class="centered bordered striped highlight z-depth-4 table-bordered" id="markstabulationTable" width="100%" border="1" style="border-collapse:collapse;">
              <thead>
                <tr>
                  <th rowspan="3">Roll no.</th>
                  <th rowspan="3">Student Name</th>
                    <?php


                    /*$resultsubject1 = $db->query("SELECT * FROM `subject` WHERE `subject_class` = '$class_id' AND `status` = 0 ORDER BY `subject`.`subject_id` ASC");*/

                    $resultsubject1 = $db->query("SELECT `subject`.`subject_id` , `subject`.`subject_name` ,`subject`.`subject_type`
                      ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm`   
                      FROM `marksheet` 

                        INNER JOIN `subject` ON `marksheet`.`msubject_id` = `subject`.`subject_id`

                        LEFT JOIN `subject_mark` ON `marksheet`.`msubject_id` = `subject_mark`.`subject_id`
                            AND  `subject_mark`.`examtype_id` = '$examid'

                        WHERE `marksheet`.`marksheet_class` = '$class_id' 
                          AND (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  ) 
                          AND `marksheet`.`year_id`='$year_id' 
                        GROUP BY `msubject_id` 
                        ORDER BY `subject`.`sort_order`");


                    if ($resultsubject1->num_rows > 0) {

                      while($subjectrow1 = $resultsubject1->fetch_assoc()) {

                        $colspan = 0;

                        if ($examIncluded) {
                          foreach ($examIncludeList as $examinclude) {
                            $colspan+=1;
                          }
                          
                        }

                        if ($examtype_details->self_include){

                          $subjectMarkTableRow = json_decode($backstage->get_subject_mark_details_by_examtype_id_subject_id_year_id($examid,$subjectrow1["subject_id"],$year_id));

                          $colspan+=( ($subjectMarkTableRow->mt)? 1 : 0 );
                          $colspan+=( ($subjectMarkTableRow->ot)? 1 : 0 );
                          $colspan+=( ($subjectMarkTableRow->eca)? 1 : 0 );
                          $colspan+=( ($subjectMarkTableRow->lp)? 1 : 0 );
                          $colspan+=( ($subjectMarkTableRow->nb)? 1 : 0 );
                          $colspan+=( ($subjectMarkTableRow->se)? 1 : 0 );

                          if($subjectrow1["subject_type"]==1){ $colspan+=3; }else if($subjectrow1["subject_type"]==0){ $colspan+=2; }else if($subjectrow1["subject_type"]==3){ $colspan+=1; }
                        }else{
                            if ($subjectrow1["subject_type"] == 0 || $subjectrow1["subject_type"] == 1)  { 
                              $colspan+=1;
                            }else if ($subjectrow1["subject_type"] == 3) {
                              //IN ANNUAL TYPE IF SUBJECT IS GRADE SYTEM THEN NEGLATE TOTAL
                            }
                        }

                        ?>

                        <th <?php echo "colspan='".$colspan."'"; ?> ><?php echo $subjectrow1["subject_name"]; ?>
                        </th>

                        <?php 
                      } ?>
                      <?php 
                    } ?>
                  <th rowspan="2">Total</th>
                  <th rowspan="3">%</th>
                  <th rowspan="3" style="font-size: 9px;">Remark</th>
                  <th rowspan="3">Attnd</th>
                  <th rowspan="3">Rank</th>
                </tr>
                <!-- ================ TH,PR,TOTAL =================== -->
                <tr>

                  <?php
                  mysqli_data_seek($resultsubject1, 0);
                  while($subjectrow2 = $resultsubject1->fetch_assoc()) {


                    if ($examIncluded) {
                      foreach ($examIncludeList as $examinclude) {
                        echo "<th rowspan='2'>".substr($examinclude->examtype_name,0,3)."</th>";
                      }
                      
                    }

                    if ($examtype_details->self_include){

                      $subjectMarkTableRow = json_decode($backstage->get_subject_mark_details_by_examtype_id_subject_id_year_id($examid,$subjectrow2["subject_id"],$year_id));
                      

                        echo (  ($subjectMarkTableRow->mt)? "<th rowspan='2'>M.T.</th>" : "" );
                        echo (  ($subjectMarkTableRow->ot)? "<th rowspan='2'>O.T.</th>" : "" );
                        echo (  ($subjectMarkTableRow->eca)? "<th rowspan='2'>E.C.A.</th>" : "" );
                        echo (  ($subjectMarkTableRow->lp)? "<th rowspan='2'>L.P.</th>" : "" );
                        echo (  ($subjectMarkTableRow->nb)? "<th rowspan='2'>N.B.</th>" : "" );
                        echo (  ($subjectMarkTableRow->se)? "<th rowspan='2'>S.E.</th>" : "" );


                      if($subjectrow2["subject_type"]=='0'){ ?>
                        <th rowspan="2">TH</th>
                        <th>Total</th>
                        <?php 
                      }else if($subjectrow2["subject_type"]=='3'){ ?>
                        <th rowspan='2'>GR</th>
                        <?php 
                      }else if($subjectrow2["subject_type"]=='1'){ ?>

                        <th>TH</th>
                        <th>PR</th>
                        <th>Total</th>
                                      
                        <?php 
                      }else{} 

                    }else{ 
                            if ($subjectrow2["subject_type"] == 0 || $subjectrow2["subject_type"] == 1)  { ?>
                              <th>Total</th> <?php
                            }else if ($subjectrow2["subject_type"] == 3) {
                              //IN ANNUAL TYPE IF SUBJECT IS GRADE SYTEM THEN NEGLATE TOTAL
                            }
                    }
                  }  ?>
                </tr>
                <!-- ================ END OF TH,PR,TOTAL =================== -->

                <!-- ================ PRINT FULL MARK, PASS MARK AND TOTAL =================== -->
                <tr>

                  <?php
                  $allSubjectTotal=0;

                  mysqli_data_seek($resultsubject1, 0);
                  while($subjectrow2 = $resultsubject1->fetch_assoc()) {

                    $subjectIDkey = $subjectrow2["subject_id"];

                    if ($examtype_details->self_include){

                      if($subject_type[$subjectIDkey]=='0'){ ?>
                        
                        <td>
                          <?php echo "FM:".$subject_THFM[$subjectIDkey]."<br> PM:".$subject_THPM[$subjectIDkey]; ?>
                        </td>
                        <?php 
                      $allSubjectTotal = $allSubjectTotal+$subject_THFM[$subjectIDkey];
                      }else if($subject_type[$subjectIDkey]=='3'){ ?>
                        <?php 
                      }else if($subject_type[$subjectIDkey]=='1'){ ?>

                        <td><?php echo "FM:".$subject_THFM[$subjectIDkey]."<br> PM:".$subject_THPM[$subjectIDkey]; ?></td>
                        <td><?php echo "FM:".$subject_PRFM[$subjectIDkey]."<br> PM:".$subject_PRPM[$subjectIDkey]; ?></td>
                        <td><?php echo "FM:".($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey])."<br>"."PM:".($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]); ?></td>
                                      
                        <?php 
                        $allSubjectTotal = $allSubjectTotal+($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);
                      }

                    }else{

                          if ($subject_type[$subjectIDkey] == 0 || $subject_type[$subjectIDkey] == 1)  { ?>
                              <td>
                      
                                <?php echo "FM:".($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey])."<br>"."PM:".($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]); 
                                $allSubjectTotal = $allSubjectTotal+($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]); ?>
                                
                              </td> <?php
                          }else if ($subject_type[$subjectIDkey] == 3) {
                            //IN ANNUAL TYPE IF SUBJECT IS GRADE SYTEM THEN NEGLATE TOTAL
                          }
                    } 
                  } ?>
                  

                  <td><?php echo $allSubjectTotal; ?></td>
                </tr>
                <!-- ================ END OF PRINT FULL MARK, PASS MARK AND TOTAL =================== -->
              </thead>
              <?php
              // Student query for student list
              $resultstudmt = $db->query("SELECT `studentinfo`.`sid`, `studentinfo`.`sname`, `syearhistory`.`roll_no`

                FROM `studentinfo` 

                INNER JOIN `syearhistory` ON `studentinfo`.`sid` = `syearhistory`.`student_id`
                
                WHERE `syearhistory`.`year_id` = '$year_id' 
                  AND `syearhistory`.`class_id`='$class_id' 
                  AND `studentinfo`.`status`= 0 
                  " . (empty($section_id) ? "" : "AND `syearhistory`.`section_id`='$section_id' ") . " 
                ORDER BY CAST(`syearhistory`.`section_id` AS UNSIGNED INTEGER) ,`syearhistory`.`roll_no`");

              if ($resultstudmt->num_rows > 0) {
                while($studentrow1 = $resultstudmt->fetch_assoc()) { ?>
                  <tr>

                    <!-- START STUDENT DETAILS LOOP -->
                    <td> 
                        <?php 
                          echo $studentrow1["roll_no"];
                        ?>
                    </td>
                    <td>
                        <?php 
                          echo $studentrow1["sname"];
                        ?>
                    </td>

                    <!-- END STUDENT DETAILS LOOP -->

                    <?php

                    $studentid=$studentrow1["sid"];
                    
                    $getTotalSubjectMark = 0.0;
                    $countavg = 0;
                    //$fail = 0;
                    $getTotalSubjectFullMark = 0.0;


                  // START SUBJECT LOOP TO DISPLAY MARK
                  mysqli_data_seek($resultsubject1, 0);
                  while($subjectrow2 = $resultsubject1->fetch_assoc()) {

                    $ob1=0.0;
                    $subjectIDkey = $subjectrow2["subject_id"];
                    $subtype = $subjectrow2["subject_type"];

                    // DISPLAY INCLUDED MARK
                    if ($examIncluded) {

                      foreach ($examIncludeList as $examinclude) { 

                        $ob1 +=${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey];
                        $getTotalSubjectMark += ${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey];

                        echo "<td>".${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey]."</td>";
                      }
                      
                    }

                    if ($examtype_details->self_include){

                      
                      $resultmark = $db->query("SELECT `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_mt`, `marksheet`.`m_ot`, `marksheet`.`m_eca`, `marksheet`.`m_lp`, `marksheet`.`m_nb`, `marksheet`.`m_se`, `marksheet`.`m_obtained_mark`,`marksheet`.`marksheet_status`

                        ,`subject`.`subject_type`

                        ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm` 
                         
                        FROM `marksheet`

                        LEFT JOIN `subject` ON `marksheet`.`msubject_id` = `subject`.`subject_id`
                            AND `subject`.`subject_class` = '$class_id'
                            AND `subject`.`year_id` = '$year_id'                            

                        LEFT JOIN `subject_mark` ON `marksheet`.`msubject_id` = `subject_mark`.`subject_id`
                              AND  `subject_mark`.`examtype_id` = '$examid'
                              AND `subject_mark`.`year_id` = '$year_id'

                        WHERE `marksheet`.`msubject_id` = '$subjectIDkey' 
                            AND `marksheet`.`mstudent_id`='$studentid' 
                            AND `marksheet`.`mexam_id`='$examid'                           
                            AND `marksheet`.`marksheet_class`='$class_id'                          
                            " . (empty($section_id) ? "" : "AND `marksheet`.`marksheet_section`='$section_id' ") . " 
                            AND `marksheet`.`month`='$month_id'
                            AND `marksheet`.`year_id`='$year_id' ");

                      if ($resultmark->num_rows > 0) {
                        while($submark1 = $resultmark->fetch_assoc()) { 

                            $subjectMarkTableRow = json_decode($backstage->get_subject_mark_details_by_examtype_id_subject_id_year_id($examid,$subjectrow2["subject_id"],$year_id));
                        

                            echo (  ($subjectMarkTableRow->mt)? ((!empty(${'mMT' . $studentid}[$subjectIDkey][$examid]))? "<td ".$colorClass.">".${'mMT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td class='brown lighten-4'></td>" )  : "" );

                            echo (  ($subjectMarkTableRow->ot)? ((!empty(${'mOT' . $studentid}[$subjectIDkey][$examid]))? "<td ".$colorClass.">".${'mOT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td class='brown lighten-4'></td>" ) : "" );

                            echo (  ($subjectMarkTableRow->eca)? ((!empty(${'mECA' . $studentid}[$subjectIDkey][$examid]))? "<td ".$colorClass.">".${'mECA' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td class='brown lighten-4'></td>" ) : "" );

                            echo (  ($subjectMarkTableRow->lp)? ((!empty(${'mLP' . $studentid}[$subjectIDkey][$examid]))? "<td ".$colorClass.">".${'mLP' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td class='brown lighten-4'></td>" ) : "" );

                            echo (  ($subjectMarkTableRow->nb)? ((!empty(${'mNB' . $studentid}[$subjectIDkey][$examid]))? "<td ".$colorClass.">".${'mNB' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td class='brown lighten-4'></td>" ) : "" );

                            echo (  ($subjectMarkTableRow->se)? ((!empty(${'mSE' . $studentid}[$subjectIDkey][$examid]))? "<td ".$colorClass.">".${'mSE' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td class='brown lighten-4'></td>" ) : "" );

                            ?>



                            <!-- ========================= SUBJECT TYPE 1 TH+PR ==================================== -->
                            <?php
                            if($subject_type[$subjectIDkey]==1){ ?>

                              <td <?php echo ((!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]))? $colorClass : '' ); ?> >

                                <?php 
                                  //Print Theory mark for subject type 1(theory+practical)
                                  if(!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid])){ 
                                    echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                  } 

                                  //IF BY THEORY FAIL
                                  if (!$examIncluded) {
                                    echo (((float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]<(float)$subject_THPM[$subjectIDkey])? '*':'');
                                  }

                                ?> 

                              </td>
                              <td <?php echo ((!empty(${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]))? $colorClass : ''); ?> >

                                <?php 
                                  //Print Practical mark for subject type 1(theory+practical)
                                  if(!empty(${'practical_mark_student' . $studentid}[$subjectIDkey][$examid])){ echo ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; } 
                                ?> 

                              </td>

                              <!-- ================= Total td ========================= -->
                              <td <?php echo ((!empty(${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid]))? $colorClass : ''); ?> >

                                <?php 

                                // GET TOTAL FOR EACH SUBJECT
                                $ob1 += ${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid];

                                // GET TOTAL FOR ALL SUBJECT
                                $getTotalSubjectMark += ${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid];

                                $countavg = ++$countavg;

                                //get total subject mark
                                $getTotalSubjectFullMark += ($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);



                                //Print Total mark for subject type 1(theory+practical)
                                if(!empty($ob1)){  echo $ob1; }else{ echo "-"; }

                                //IF BY TOTAL FAIL
                                if ($examIncluded) {
                                  echo (((float)$ob1<(float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]))? '*':'');
                                }


                                ?>

                              </td>
                            <!-- ========================= SUBJECT TYPE 0 THEORY ==================================== -->
                              <?php 
                            }else if($subject_type[$subjectIDkey]==0){ ?>
                              <td <?php echo ((!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]))? $colorClass : ''); ?> >
                                  
                                  <?php 
                        
                                //Print Theory mark for subject type 0 (theory)
                                if(!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid])){ echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]; }

                                //IF BY THEORY FAIL
                                if (!$examIncluded) {
                                  echo (((float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]<(float)$subject_THPM[$subjectIDkey] )? '*':'');
                                }


                                ?> 
                              </td>
                              <!-- ================= Total td ========================= -->
                              <td <?php echo ((!empty(${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid]))? $colorClass : ''); ?>>
                                <?php

                                // GET TOTAL FOR EACH SUBJECT
                                $ob1 +=${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid];

                                //Print Total mark for subject type 0(theory)
                                if(!empty($ob1)){  echo $ob1; }else{ echo "-"; }

                                //IF BY TOTAL FAIL
                                if ($examIncluded) {
                                  echo (((float)$ob1<(float)($subject_THPM[$subjectIDkey]))? '*':'');
                                }


                                $getTotalSubjectMark=$getTotalSubjectMark+$ob1;
                                $countavg=++$countavg;

                                //get total subject mark
                                $getTotalSubjectFullMark += ($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);

                                 ?>
                              </td>
                            <!-- ========================= SUBJECT TYPE 3 GRADE ==================================== -->
                              <?php 
                            }else if($subject_type[$subjectIDkey]==3){ ?>
                              <td <?php echo ((!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]))? $colorClass : ''); ?> >
                                   <?php 

                                //Print Theory mark for subject type 3 (Grade)
                                if(!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid])){ echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]; }

                                ?> 
                              </td>
                              <?php 
                            }

















                        } // end of while loop mark

                      }else{ //else mark is not there


                          $subjectMarkTableRow = json_decode($backstage->get_subject_mark_details_by_examtype_id_subject_id_year_id($examid,$subjectrow2["subject_id"],$year_id));
                        

                          echo (  ($subjectMarkTableRow->mt)? "<td class='brown lighten-4'></td>" : "" );
                          echo (  ($subjectMarkTableRow->ot)? "<td class='brown lighten-4'></td>" : "" );
                          echo (  ($subjectMarkTableRow->eca)? "<td class='brown lighten-4'></td>" : "" );
                          echo (  ($subjectMarkTableRow->lp)? "<td class='brown lighten-4'></td>" : "" );
                          echo (  ($subjectMarkTableRow->nb)? "<td class='brown lighten-4'></td>" : "" );
                          echo (  ($subjectMarkTableRow->se)? "<td class='brown lighten-4'></td>" : "" );

                          if($subject_type[$subjectIDkey] == 1){ ?>

                              <td class="brown lighten-4"></td>
                              <td class="brown lighten-4"></td>
                              <td class="brown lighten-4">
                                <?php 
                                if ($examIncluded) {
                                  if(!empty($ob1)){  
                                    echo $ob1;
                                    echo (((float)$ob1<(float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]))? '*':'');
                                  }                              
                                } ?>                                
                              </td>
                              
                              <?php 
                            }elseif($subject_type[$subjectIDkey] == 0){ ?>

                              <td class="brown lighten-4"></td>
                              <td class="brown lighten-4">
                                <?php 
                                if ($examIncluded) {
                                  if(!empty($ob1)){  
                                    echo $ob1; 
                                    echo (( (float)$ob1<(float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]))? '*':'');
                                  }
                                } ?>
                              </td>
                              <?php 
                            }elseif($subject_type[$subjectIDkey] == 3){ ?>
                              <td class="brown lighten-4">
                              </td>
                              <?php 
                            }
                      }

                    }else{

                      // ANNUAL TOTAL FOR EACH SUBJECT
                      if ($subject_type[$subjectIDkey] == 0 || $subject_type[$subjectIDkey] == 1)  { ?>

                        <td><?php echo $ob1;
                          
                          if ($examIncluded) {
                            echo (((float)$ob1<(float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]))? '*':'');
                          } ?>
                        </td>

                        <?php
                      }else if ($subject_type[$subjectIDkey] == 3) {
                        //IN ANNUAL TYPE IF SUBJECT IS GRADE SYTEM THEN NEGLATE TOTAL
                      }
                    }

                  } // END OF SUBJECT WHILE LOOP
                  ?>












                  <!-- ====================================================================================================================== -->
                  <?php
                    $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0.0; $gp=0.0; $fail = 0; $realCount = 0;

                    foreach (${'m_obtained_mark_student' . $studentid} as $subjectIDkey => $value) {

                      $ob=0.0;

                      if($subject_type[$subjectIDkey] != 3){$realCount=$realCount+1;}//increement

                      // ================= FULL MARK td =========================
                      if($subject_type[$subjectIDkey]==1){

                        $gt=$gt+($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);

                      }else if($subject_type[$subjectIDkey]==0){ 

                        $gt=$gt+$subject_THFM[$subjectIDkey];

                      }else{
                      }

                      // ================= INCLUDED EXAM MARK td =========================
                      if ($examIncluded) {
                        foreach ($examIncludeList as $examinclude) {

                          $ob +=${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey];
                        }
                        
                      }

                      // ================= Total td ========================= 
                          if ($examtype_details->self_include){
                            // GET TOTAL FOR EACH SUBJECT
                            $ob += ${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid];
                          }

                          $go=$go+$ob; 
                      //================= Grade td ========================= 
                             
                          if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                          }else{

                            if($subject_type[$subjectIDkey] == 1){ 
                              $tm=$subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey];
                            }else if($subject_type[$subjectIDkey] == 0){
                              $tm = $subject_THFM[$subjectIDkey];
                            }
                              $avg=($ob/$tm)*100;
                                                                  
                          } 

                          //checking fail pass in each subject

                          //IF EXAM INCLUDED THEN PASS FAIL EVALUATED BY TOTAL OBTAINED IN EACH SUBJECT

                           if ($examIncluded) {

                                if($subject_type[$subjectIDkey] == 3) {
                                }else if($subject_type[$subjectIDkey] == 0 && (float)$ob >= (float)($subject_THPM[$subjectIDkey])) {
                                }else if($subject_type[$subjectIDkey] == 1 && (float)$ob >= (float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey])) {
                                }
                                else{
                                  $fail = 1;
                                }
                            //IF EXAM NOT INCLUDED THEN PASS FAIL EVALUATED BY THEORY IN EACH SUBJECT
                            }else{

                                if($subject_type[$subjectIDkey] == 3) {
                                }else if($subject_type[$subjectIDkey] == 0 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                                }else if($subject_type[$subjectIDkey] == 1 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                                }else{
                                  $fail = 1;
                                }

                            }
                    } // END OF FOREACH LOOP







                      ?>
                      <td class="brown lighten-3">
                        <?php echo $go.'/'; echo '<br>'.$gt;
                          // Total mark of each student
                          //if($getTotalSubjectMark==0){ echo "";  }else{ echo $getTotalSubjectMark;  }
                        ?>
                      </td>

                      <td class="brown lighten-3">
                        <?php 
                                    $avg=($go/$gt)*100;
                                    echo round($avg, 2)."%";
                          // Percentage of each student 
                          //echo $getTotalSubjectMark.'='.$getTotalSubjectFullMark;
                          //echo (($getTotalSubjectMark==0)? '' : round(($getTotalSubjectMark/$getTotalSubjectFullMark)*100, 2) );
                        ?>
                      </td>
                      <td class="brown lighten-3">
                        <?php
                        if($fail == 1 || $go == 0){ echo "Fail"; }else{ echo "Pass";  } 
                        ?>
                      </td>
                      <td class="brown lighten-3">
                        <?php 
                          echo $attendanceArray[$studentid];                 
                        ?>
                      </td>
                      <td class="brown lighten-3">
                        <?php 
                          // Rank of each student
                          if($fail != 1 && $go != 0){   echo $rankArray[$studentid];                 
                          }else{  echo "--";  }
                        ?>
                      </td>
                                                   
                  </tr>
                  <?php 
                } // End of Student while loop
              } // End of Student if loop
              ?>
                                                
                                                
            </table>

          </div>
        </div>
      </div>
        
      <?php
    }
    else if($found == '0') { ?>
      <div class="row">
        <div class="col s8 offset-m2">
          <div class="card grey darken-3">
            <div class="card-content white-text center">
              <span class="card-title">
                <span style="color:#80ceff;">
                  No Marks Details Found!!
                </span>
              </span>
            </div>
          </div>
        </div>
      </div>
      <?php 
    } 

  
   
} 
?>




<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="../printer/js/datatables.responsive.js"></script>
<script src="../printer/js/lodash.min.js"></script>

<script>
  function printDiv()
  {
    var printBtn = document.getElementById("markstabulationTable");
    printBtn.caption.hidden=true;
    var schoolheader=document.getElementById('schoolheader');
    var invoice_print=document.getElementById('invoice_print');  

    var newWin=window.open('','Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">'+schoolheader.innerHTML+invoice_print.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},100);

    printBtn.caption.hidden=false;


  }
</script>
<script>
  $(document).ready(function (e) 
  {
    $("#publish_marksheet_form").on('submit',(function(e) 
    {
      e.preventDefault();
      $.ajax
      ({
            url: "updatescript.php",
            type: "POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend : function()
            {
              $("#err").fadeOut();
            },
            success: function(data)
            {
              if ((data.indexOf("Mark successfully published"))<0) {

                Materialize.toast(data, 4000, 'rounded');
                 $.ajax({
                  type: "post",
                  url: "../important/clearSuccess.php",
                  data: 'request=' + 'result_success',
                  success: function (data1) {
                  }
                });
              }else if ((data.indexOf("Mark successfully published"))>=0) {

                  window.location.href = 'publish.php';
              }
            },
            error: function(e) 
            {
              alert('Sorry Try Again !!');
            }          
      });
    }));
    
  });


</script>

<?php if($_POST['markstoken'] =='marksledger' ) { ?>
  
  <script type="text/javascript">
     $(document).ready(function (e){

        TableExport(document.getElementById("markstabulationTable"),{
          formats: ["xlsx", "csv", "txt",'xls'],
          bootstrap: true,
          filename: 'ledger',
          position: 'top',

        });
      });

    function Export(id){
        var doc = new jsPDF('landscape');
        doc.autoTable({html: '#'+id,margin:{top:2,bottom:2,right:2,left:2}});
       
        doc.save('marks-ledger.pdf');
    }
  </script>

<?php } ?>
