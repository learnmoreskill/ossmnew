<?php
include('session.php');
include_once("../printer/printheader.php");
require("../important/backstage.php");

$backstage = new back_stage_class();

$school_details = json_decode($backstage->get_school_details_by_id());

  error_reporting( ~E_NOTICE ); // avoid notice

  if( isset( $_POST['class_id'] ) )
  {
    $class_id = $_POST['class_id'];
    $section_id = $_POST['section_id'];
    $studentarray = $_POST['student'];
    $examid = $_POST['examtypeid'];
    $template = $_POST['template'];
    $mode = $_POST['mode'];
    $month_id = $_POST['m04x20'];
    $year_id = $_POST['y04x20'];

    $rankselected = $_POST['rankselected'];


    if ($template == 999) { //Default
      
      $template = 999;

    }else if ($template == 1) { //Grade

      $template = 5;

      $highestInSubTD=false;
      $gradeTDUpper = false;
      $gpaTD = false;
      $gradeTD = true;
      $resultTD = false;
      $rankTD = false;
    }else if ($template == 2) { //Grade,GPA

      $template = 5;

      $highestInSubTD = false;
      $gradeTDUpper = true;
      $gpaTD = true;
      $gradeTD = false;
      $resultTD = false;
      $rankTD = false;
    }else if ($template == 3) { //Grade,GPA,Rank

      $template = 5;

      $highestInSubTD = false;
      $gradeTDUpper = false;
      $gpaTD = true;
      $gradeTD = false;
      $resultTD = true;
      $rankTD = true;
    }else if ($template == 4) { //Grade,GPA,Rank,HS

      $template = 5;

      $highestInSubTD = true;
      $gradeTDUpper = false;
      $gpaTD = true;
      $gradeTD = true;
      $resultTD = true;
      $rankTD = true;

    }else if ($template == 5) { //Grade,GPA,Rank,HS,Test

      $template = 5;

      $highestInSubTD = true;
      $gradeTDUpper = false;
      $gpaTD = true;
      $gradeTD = true;
      $resultTD = true;
      $rankTD = true;
    }

    

    $months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra');

    $examtype_details = json_decode($backstage->get_examtype_details_by_examid($examid));

    if (empty($month_id)) { 
      $month_id = 0;
    }

    if (!$examtype_details->is_monthly){
           $month_id = 0;
    }

    $print_format = $examtype_details->print_format;


    if (empty($class_id)) { 
      ?> <script> alert('Please select Class'); window.location.href = 'marksheetforclass.php?fail'; </script> <?php 
    }
    if (empty($studentarray)) { 
      ?> <script> alert('Student list is empty'); window.location.href = 'marksheetforclass.php?fail'; </script> <?php 
    }
    if (empty($examid)) { 
      ?> <script> alert('Please select exam'); window.location.href = 'marksheetforclass.php?fail'; </script> <?php 
    }
    if (empty($year_id)) {
      ?> <script> alert('Please select year'); window.location.href = 'marksheetforclass.php?fail'; </script> <?php 
    }

    //can be replace by reportForClassArray
    $testMarkRow = json_decode($backstage->get_subject_mark_test_details_by_class_id_examtype_id_year_id($class_id,$examid,$year_id));



    $examIncludeList = json_decode($backstage->get_examinclude_list_by_examtype_id($examid,$year_id));

    if (count((array)$examIncludeList)<1) { $examIncluded = false; }else{ $examIncluded = true;  }

    $addedExamTemp='';
    if ($examIncluded) {
      foreach ($examIncludeList as $examinclude) {
        $addedExamTemp .= "OR `marksheet`.`mexam_id`='".$examinclude->added_examtype_id."'";
      }
        
    }

    $queryvm1 = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`
        FROM `marksheet` 
        LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
        WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  ) 
        AND `marksheet`.`marksheet_class`='$class_id' 
        AND `marksheet`.`month`='$month_id' 
        AND `marksheet`.`year_id`='$year_id'");
      
    $rowCount1 = $queryvm1->num_rows;
    if($rowCount1 > 0) { $mfound='1';} else{ $mfound='0';   }


      require('../linker/reportForClassArray.php');

      if ($highestInSubTD) {       
            require('../linker/highestInSubject.php');
      }

      if ($rankTD) {
            require('../linker/rankmarkwise.php');
      } 
  }
?>

<!-- ====================  Default Marksheet     ==================== -->
  <?php
  if($template == 999 && $mfound==1){ ?>

    <div class="container">
      <div class="col-md-12" align="right">
        <input type='button' id='btn' value='Print' onclick='printDiv();'>
      </div>
      <div id="invoice_print">

        <style type="text/css" media="print">
              @media print {
                body {-webkit-print-color-adjust: exact;}
              }
              @page {
                  size:A4 <?php if($mode==0){ echo "portrait";}elseif ($mode==1) { echo "landscape"; } ?>;
                  -webkit-print-color-adjust: exact;
                  color-adjust: exact;
                  -webkit-filter:opacity(1);
              }
          </style>

        <?php 
        if ($studentarray){
          foreach ($studentarray as $student_id){

            $studentid=$student_id;

            $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`sroll`, `studentinfo`.`dob`, `marksheet`.`month` , `class`.`class_name`, `section`.`section_name`,`academic_year`.`single_year` 
              FROM `marksheet` 

              INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
              LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 
              LEFT JOIN `class` ON `marksheet`.`marksheet_class` = `class`.`class_id` 
              LEFT JOIN `section` ON `marksheet`.`marksheet_section` = `section`.`section_id` 

              WHERE `marksheet`.`mexam_id`='$examid' 
                AND `marksheet`.`mstudent_id`='$studentid' 
                AND `marksheet`.`marksheet_class`='$class_id' 
                AND `marksheet`.`month`='$month_id' 
                AND `marksheet`.`year_id`='$year_id' 
              GROUP BY `marksheet`.`mstudent_id`";
            $resultstd = $db->query($sqlstd);
            $rowstd = $resultstd->fetch_assoc();

            $sqlexm = "SELECT * FROM `examtype` WHERE `examtype_id`='$examid'";
            $resultexm = $db->query($sqlexm);
            $rowexm = $resultexm->fetch_assoc();


            $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`pass_mark`,`subject`.`subject_type` 
              FROM `marksheet` 
              LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
              WHERE `marksheet`.`mexam_id`='$examid' 
                AND `marksheet`.`mstudent_id`='$studentid' 
                AND `marksheet`.`marksheet_class`='$class_id'  
                AND `marksheet`.`month`='$month_id' 
                AND `marksheet`.`year_id`='$year_id'
              ORDER BY `subject`.`sort_order`");
              $rowCount = $queryvm->num_rows;
              if($rowCount > 0) { $found='1';} else{ $found='0';   } ?>
          

              <?php 
              if ($found == '1') { ?>
                <div <?php if($mode==0){ echo "style='height: 1030px;'";}elseif ($mode==1) { echo "style='height: 700px;'"; } ?> >
                  <?php include("../printer/printschlheader.php");?>
                  <table width="100%" border="0">    
                      <tbody>
                        <tr>
                            <td align="left" valign="top">
                                Student Name: <?php echo $rowstd['sname']; ?><br>
                                Class : <?php echo $rowstd['class_name']; ?> Section : <?php echo $rowstd['section_name'];?> <br>
                                Roll no : <?php echo $rowstd['sroll']; ?><br>
                            </td>
                            <td align="right" valign="top">
                                Admission Number: <?php echo $rowstd['sadmsnno']; ?><br>
                                Date Of Birth : <?php echo (($login_date_type==2)? eToN($rowstd['dob']) : $rowstd['dob']); ?>
                            </td>

                        </tr>

                          
                      </tbody>
                  </table>

                  <!-- body -->
                  <center><h4><?php echo $rowexm['examtype_name']; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
                      echo '&nbsp'.$rowstd["single_year"];
                  ?></h4></center>
                  <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                      <thead>
                          <tr>
                              <th width="10%">S.No</th>
                              <th width="25%">Subject Name</th>
                              <th width="15%">Full Mark</th>
                              <th width="15%">Pass Mark</th>
                              <th width="15%">Theory Mark</th>
                              <th width="15%">Practical Mark</th>
                              <th width="15%">Total Obtained</th>
                              <th width="10%">Remark</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php $sn=1; $gt=0; $go=0;$realCount = 0; 
                        while($row = $queryvm->fetch_assoc()){ ?>
                                  <tr>
                                      <td>
                                          <?php echo $sn++;
                                          if($row["subject_type"]!=3){$realCount=$realCount+1;}//increement?>
                                      </td>
                                      <td style="text-transform: capitalize;">
                                          <?php echo $row["subject_name"];?>
                                      </td>
                                      <td>
                                          <?php if ($row["subject_type"]==3){ //for subject type 3
                                            }else{
                                              $gt=$gt+$row["total_mark"];
                                              echo $row["total_mark"];
                                            } ?>
                                      </td>
                                      <td>
                                          <?php if ($row["subject_type"]==3){ //for subject type 3
                                                }else{ 
                                                  echo $row["pass_mark"];
                                                }?>
                                      </td>
                                      <td>
                                          <?php if ($row["subject_type"]==3){ //for subject type 3
                                              }else if(!empty($row["m_theory"])){echo $row["m_theory"];}else{ echo "-"; } ?>
                                      </td>
                                      <td>
                                          <?php if ($row["subject_type"]==3){ //for subject type 3
                                              }else if(!empty($row["m_practical"])){echo $row["m_practical"];}else{ echo "-"; } ?>
                                      </td>
                                      <td>
                                          <?php if ($row["subject_type"]==3){ //for subject type 3
                                            echo $row["m_obtained_mark"];
                                          }else{ if(!empty($row["m_obtained_mark"])){echo $row["m_obtained_mark"];}else{ echo "-"; }
                                            $go=$go+$row["m_obtained_mark"]; 
                                            $ob=$row["m_obtained_mark"];
                                          }?>
                                      </td>
                                      <td>
                                          <?php
                                          if ($row["subject_type"]==3){ //for subject type 3
                                          }else{ 
                                            $tm=$t_mark;
                                            $avg=($ob/$tm)*100;
                                            if(strtolower($ob)=='a'){
                                              echo 'Absent';
                                            }elseif (strtolower($ob)=='s') {
                                              echo 'Suspend';
                                            }


                                            else{if ($avg>=90) {
                                              echo 'A+';
                                            }elseif ($avg>=80) {
                                              echo 'A';
                                            }elseif ($avg>=70) {
                                              echo 'B+';
                                            }elseif ($avg>=60) {
                                              echo 'B';
                                            }elseif ($avg>=50) {
                                              echo 'C+';
                                            }elseif ($avg>=40) {
                                              echo 'C';
                                            }elseif ($avg>=20) {
                                              echo 'D';
                                            }elseif ($avg>=1) {
                                              echo 'E';
                                            }elseif ($avg==0) {
                                              echo 'N';
                                            }else{
                                              echo "";
                                            }}
                                          }
                                          ?>
                                      </td>
                                  </tr>
                                  <?php } ?>
                          <tr><td class="active"></td>
                            <td class="active"><strong>Grand Total</strong></td><td class="active"><strong>  <?php echo $gt; ?> </strong></td>
                            <td class="active"><strong>   </strong></td>
                            <td class="active"><strong>   </strong></td>
                            <td class="active"><strong>   </strong></td>
                            <td class="active"><strong>  <?php echo $go; ?> </strong></td>
                            <td class="active"><strong>   </strong></td></tr>
                          </tbody>
                  </table>
                  <br>
                  <strong align="left">Grade :<?php 
                                                      $tm=$gt;
                                                      $ob=$go;
                                                      $avg=($ob/$tm)*100;
                                                      if ($avg>=90) {
                                                        echo 'A+';
                                                      }elseif ($avg>=80) {
                                                        echo 'A';
                                                      }elseif ($avg>=70) {
                                                        echo 'B+';
                                                      }elseif ($avg>=60) {
                                                        echo 'B';
                                                      }elseif ($avg>=50) {
                                                        echo 'C+';
                                                      }elseif ($avg>=40) {
                                                        echo 'C';
                                                      }elseif ($avg>=20) {
                                                        echo 'D';
                                                      }elseif ($avg>=1) {
                                                        echo 'E';
                                                      }elseif ($avg==0) {
                                                        echo 'N';
                                                      }else{
                                                        echo "";
                                                      }
                                                      ?><br><br></strong>
                  <strong align="left">Remark :<?php 
                                                      $tm=$gt;
                                                      $ob=$go;
                                                      $avg=($ob/$tm)*100;
                                                      if ($avg>=90) {
                                                        echo 'OUTSTANDING';
                                                      }elseif ($avg>=80) {
                                                        echo 'EXCELLENT';
                                                      }elseif ($avg>=70) {
                                                        echo 'VERY GOOD';
                                                      }elseif ($avg>=60) {
                                                        echo 'GOOD';
                                                      }elseif ($avg>=50) {
                                                        echo 'ABOVE AVERAGE';
                                                      }elseif ($avg>=40) {
                                                        echo 'AVERAGE';
                                                      }elseif ($avg>=20) {
                                                        echo 'BELOW AVERAGE';
                                                      }elseif ($avg>=1) {
                                                        echo 'INSUFFICIENT';
                                                      }elseif ($avg==0) {
                                                        echo 'VERY INSUFFICIENT';
                                                      }else{
                                                        echo "";
                                                      }
                                                      ?><br><br>
                  </strong>
                  <!-- <strong align="left">Attendance :<br><br></strong> -->
                  <P>
                     <span style="float:left;"><u>_______________________</u><br>Class Teacher Signature</span>
                     <span  style="float:right;"><u>_______________________</u><br>Principal Signature</span></span>​
                  </P><br><br>

                </div>

                <?php 
              }else{} ?>
                   
            <?php 
          }
        } ?>


      </div>
    </div>


<!-- ====================  Grade, GPA, Rank, HS , Test Marksheet     ==================== -->
    <?php
  }else if($template == 6 && $mfound==1){

      ?>

      <div class="container">
        <div class="col-md-12" align="right">
          <input type='button' id='btn' value='Print' onclick='printDiv();'>
        </div>
        <div id="invoice_print">

          <style type="text/css" media="print">
                @media print {
                  body {-webkit-print-color-adjust: exact;}
                }
                @page {
                    size:A4 landscape;
                    -webkit-print-color-adjust: exact;
                    margin: 0;
                    color-adjust: exact;
                    -webkit-filter:opacity(1);
                }
            </style>

          <?php
          if ($studentarray){
            foreach ($studentarray as $studentid){

              // START GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO
                $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`sroll`, `studentinfo`.`dob`, `marksheet`.`month` , `class`.`class_name`, `section`.`section_name`,`academic_year`.`single_year` 
                FROM `marksheet` 

                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 
                LEFT JOIN `class` ON `marksheet`.`marksheet_class` = `class`.`class_id` 
                LEFT JOIN `section` ON `marksheet`.`marksheet_section` = `section`.`section_id` 

                WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  ) 
                  AND `marksheet`.`mstudent_id`='$studentid' 
                  AND `marksheet`.`marksheet_class`='$class_id' 
                  AND `marksheet`.`month`='$month_id' 
                  AND `marksheet`.`year_id`='$year_id' 
                GROUP BY `marksheet`.`mstudent_id`";
                $resultstd = $db->query($sqlstd);
                $rowstd = $resultstd->fetch_assoc();
              // END GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO






                $rowCount = count(${'m_obtained_mark_student' . $studentid});
                if($rowCount > 0) { $found='1'; } else{ $found='0';   } ?>
            

                <?php 
                if ($found == '1') { //IF MARKSHEET FOUND PRINT OTHERWISE SKIP
                 ?>
                  <!-- marksheet -->
                  <style type="text/css">
                    @font-face {
                      font-family: happyEnding;
                      src: url(../assets/HappyEnding.ttf);
                    }
                    table.marks , .marks>thead>tr>th,.marks>tfoot>tr>th,.marks>tbody.bodered>tr>td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        padding: 5px;
                        font-size: 11px;
                        text-align: center;
                    }
                    .marks>tbody>tr>td {
                        border-right: 1px solid black;
                        border-collapse: collapse;
                        padding: 5px;
                        font-size: 11px;
                        text-align: center;
                    }
                  </style>

                  <div style="position: relative; height:96%; width:48%;float:left;margin-top: 10px;margin-bottom: 10px; padding-left: 10px;margin-left: 6px;">


                  <!-- <div style="width:146mm; height:208mm;"> -->
                    <div style="z-index: 1; text-align:center; border: 2px solid #787878;position: relative;height: 100%;overflow: hidden;" class="backGreen">
                      
                      <div style="display: inline-flex;width:100%;padding: 5px 0">
                        <div style="width: 50px;height: 60px;text-align: center;margin: auto; position: absolute;">
                          <img style="height: inherit; margin: 20px 0 0 10px;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                        </div>
                        <div style="text-align: center;position: relative;padding: 0 20px;margin: auto; ">
                               <h4 style="font-weight: bolder;margin: 0;text-transform: uppercase;"><?php echo $login_session_a; ?></h4>
                               <div >
                                  <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Estd: <?php echo $login_session_g; ?></p>
                                  
                               </div>           
                        </div>
                        
                      </div>
                      <div style="padding: 0 10px">
                        <div style="margin: 5px auto">
                          <div style="width: 55%;background: #000;margin: auto;">
                            <h4 style="margin: 0;padding: 3px;color: #fff;text-transform: uppercase;"><b><?php echo $examtype_details->examtype_name; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
                              echo '&nbsp'.$rowstd["single_year"];
                             ?></b>
                            </h4>
                          </div>
                          <h4 style="margin: 8px 0"><span style="border: 1px solid #000; padding: 2px 10%;"><b>MARK-SHEET</b></span></h4>
                        </div>
                        <!-- student detail -->
                        <table style="width:100%;text-align: left; font-size:10px;">
                          <tr>
                            <td colspan="2">Name : <span><b><?php echo $rowstd['sname']; ?></b></span></td>
                            <td >Roll No. : <b><?php echo $rowstd['sroll']; ?></b></td>
                          </tr>
                          <tr>
                            <!-- <td >DOB : <span><b></b></span></td> -->
                            <td colspan="2">Class : <span><b><?php echo $rowstd['class_name']; ?></b></span></td>
                            <td >Section : <span><b><?php echo $rowstd['section_name'];?></b></span></td>
                          </tr>
                        </table>
                        <!-- Marks table -->
                        <table style="width:100%;height: 350px" class="marks">
                          <thead style="background: lightgray;">          
                            <tr style="text-align: center;">
                              <th>S.N.</th>
                              <th>Subject</th>
                              <th>F.M.</th>
                              <th>P.M.</th>
                              <?php 
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) { ?>
                                    <th style='font-size: 10px'><?php

                                    echo substr($examinclude->examtype_name,0,3);
                                    echo '<br>'.$examinclude->percent.'%';

                                    ?></th><?php
                                  }
                                  
                                }

                                if ($examtype_details->self_include){
                                  
                                  echo (  ($testMarkRow->mt)? "<th>MT</th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th>OT</th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th>ECA</th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th>LP</th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th>NB</th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th>SE</th>" : "" );   ?>                          
                              <th>TH.</th>
                              <th>PR.</th>
                              <?php } ?>

                              <th>Total</th>
                              <th>Grade</th>
                              <?php 
                                echo (  ($highestInSubTD)? "<th style='font-size: 9px'>Highest<br>Marks</th>" : "" ); 
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                          
                
                          <?php $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0.0; $gp=0.0; $fail = 0; $realCount = 0;

                          foreach (${'m_obtained_mark_student' . $studentid} as $subjectIDkey => $value) {

                            $ob=0.0;


                            ?>
                            <tr style="height: 20px">
                              <td style="text-align: right;">
                                <?php echo $sn++;
                                if($subject_type[$subjectIDkey] != 3){$realCount=$realCount+1;}//increement
                                ?>
                              </td>
                              <td style="text-align: left;">
                                <?php echo substr($subject_name[$subjectIDkey],0,25).((strlen($subject_name[$subjectIDkey]) > 25) ? '..':'');?>
                              </td>
                              <!-- ================= FULL MARK td ========================= -->
                              <td style="text-align: right;">
                                <?php if($subject_type[$subjectIDkey]==1){

                                  $gt=$gt+($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);
                                  echo ($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);

                                }else if($subject_type[$subjectIDkey]==0){ 

                                  $gt=$gt+$subject_THFM[$subjectIDkey];
                                  echo $subject_THFM[$subjectIDkey];

                                }else{
                                }
                                ?>
                              </td>
                              <!-- ================= PASS MARK td ========================= -->
                              <td style="text-align: right;">
                                <?php if($subject_type[$subjectIDkey]==1){ 
                                  $pm=$pm+($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]);
                                  echo ($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]);
                                }else if($subject_type[$subjectIDkey]==0){ 
                                  $pm=$pm+$subject_THPM[$subjectIDkey];
                                  echo $subject_THPM[$subjectIDkey];
                                }else{
                                }

                                ?>
                              </td>
                              <!-- ================= INCLUDED EXAM MARK td ========================= -->
                              <?php
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {

                                    $ob +=${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey];

                                    echo "<td>".${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey]."</td>";
                                  }
                                  
                                }
                              /* ================= TEST MARK td ========================= */

                              if ($examtype_details->self_include){

                                echo (  ($testMarkRow->mt)? ((!empty(${'mMT' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mMT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" )  : "" );

                                echo (  ($testMarkRow->ot)? ((!empty(${'mOT' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mOT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->eca)? ((!empty(${'mECA' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mECA' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->lp)? ((!empty(${'mLP' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mLP' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->nb)? ((!empty(${'mNB' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mNB' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->se)? ((!empty(${'mSE' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mSE' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                ?>

                                <!-- ================= T.H. td ========================= -->
                                <td style="text-align: right;"> 
                                  <?php if ($subject_type[$subjectIDkey]==3){ //for subject type 3
                                        }else if ($subject_type[$subjectIDkey]==0) {
                                          if(!empty(  ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] )){
                                            $th = $th+${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                            echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                            
                                            if (!$examIncluded) {
                                              echo (( is_numeric( ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] ) && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]<(float)$subject_THPM[$subjectIDkey])? '*':'');
                                            }
                                            
                                          }else{ echo "-"; }
                                        }else if ($subject_type[$subjectIDkey]==1){
                                          if(!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid])){
                                            $th = $th+${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                            echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];

                                            if (!$examIncluded) {
                                              echo (( is_numeric(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]) && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]<(float)$subject_THPM[$subjectIDkey])? '*':'');
                                            }
                                
                                          }else{ echo "-"; }

                                        }
                                         ?>

                                </td>
                                <!-- ================= P.R. td ========================= -->
                                <td style="text-align: right;">
                                  <?php if ($subject_type[$subjectIDkey]==3){ //for subject type 3
                                        }else if(!empty(  ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]  )){
                                          $pr = $pr+${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                          echo ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                        }else{ echo "-"; } ?>
                                </td>

                              <?php } ?>
                              <!-- ================= Total td ========================= -->
                              <td style="text-align: right;">
                                <?php 

                                if ($examtype_details->self_include){
                                  // GET TOTAL FOR EACH SUBJECT
                                  $ob += ${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid];
                                }

                                $go=$go+$ob; 


                                if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                                  if ($examtype_details->self_include){
                                    echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                  }
                                }else{

                                  if(!empty($ob)){

                                    echo $ob;

                                  }else{ echo "-"; }

                                  if ($examIncluded) {
                                    echo (( is_numeric($ob) && (float)$ob<(float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]))? '*':'');
                                  }

                                  
                                  
                                }
                                ?>
                              </td>
                              <!-- ================= Grade td ========================= -->
                              <td style="text-align: center;">
                                <?php 
                                if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                                }else{

                                  if($subject_type[$subjectIDkey] == 1){ 
                                    $tm=$subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey];
                                  }else if($subject_type[$subjectIDkey] == 0){
                                    $tm = $subject_THFM[$subjectIDkey];
                                  }

                                    $avg=($ob/$tm)*100;
                                    if(strtolower($ob)=='a'){
                                      echo 'Absent';
                                    }elseif (strtolower($ob)=='s') {
                                      echo 'Suspend';
                                    }


                                    else{ if ($avg>=90) {
                                      echo 'A+';
                                      $gp = $gp+4.0;
                                    }elseif ($avg>=80) {
                                      echo 'A';
                                      $gp = $gp+3.6;
                                    }elseif ($avg>=70) {
                                      echo 'B+';
                                      $gp = $gp+3.2;
                                    }elseif ($avg>=60) {
                                      echo 'B';
                                      $gp = $gp+2.8;
                                    }elseif ($avg>=50) {
                                      echo 'C+';
                                      $gp = $gp+2.4;
                                    }elseif ($avg>=40) {
                                      echo 'C';
                                      $gp = $gp+2.0;
                                    }elseif ($avg>=30) {
                                      echo 'D+';
                                      $gp = $gp+1.6;
                                    }elseif ($avg>=20) {
                                      echo 'D';
                                      $gp = $gp+1.2;
                                    }elseif ($avg>=1) {
                                      echo 'E';
                                      $gp = $gp+0.8;
                                    }elseif ($avg==0) {
                                      echo 'N';
                                      $gp = $gp+0.0;
                                    }else{
                                      echo "";
                                    }}
                                } ?>
                              </td>
                              <!-- ================= Highest subject td ========================= -->
                              <?php if ($highestInSubTD){ ?>
                                <td style="text-align: center;">
                                  <?php 
                                  if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                                  }else{

                                    arsort($total_mark_in_each_subject_each_student[$subjectIDkey]);

                                    echo reset($total_mark_in_each_subject_each_student[$subjectIDkey]);

                                    //  echo $sHighest[$row["subject_id"]]['1']+$highestSub[$row["subject_id"]]['2'];
                                    // echo $sHighest[$row["subject_id"]];
                                  } ?>
                                </td>
                              <?php } ?>
                            </tr>
                            <?php 
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

                                if($subject_type[$subjectIDkey] == 0 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                                }else if($subject_type[$subjectIDkey] == 1 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                                }else if($subject_type[$subjectIDkey] == 3) {
                                }else{
                                  $fail = 1;
                                }

                            }
                          } ?>
              
                            <tr class="">
                              <td style="text-align: right;"></td>
                              <td style="text-align: left;"></td>
                              <td style="text-align: right;"></td>
                              <td style="text-align: right;"></td>
                              <?php 

                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {
                                    echo "<td></td>";
                                  }
                                  
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->ot)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->eca)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->lp)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->nb)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->se)? "<td></td>" : "" );
                                  ?>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;"></td>
                              <?php } ?>
                              <td style="text-align: right;"></td>
                              <td style="text-align: right;"></td>
                              <?php 
                                echo (  ($highestInSubTD)? "<td style='text-align: right;'></td>" : "" ); 
                              ?>
                            </tr>

                            <tfoot>
                              <tr>
                              <th style="text-align: right;"></th>
                              <th style="text-align: center;">Total</th>
                              <th style="text-align: right;"><?php echo $gt; ?></th>
                              <th style="text-align: right;"><?php echo $pm; ?></th>
                              <?php 
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {
                                    echo "<th></th>";
                                  }
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th></th>" : "" );
                                  ?>
                              <th style="text-align: right;"><?php echo $th; ?></th>
                              <th style="text-align: right;"><?php echo $pr; ?></th>
                              <?php } ?>
                              <th style="text-align: right;"><?php echo $go; ?></th>
                              <th style="text-align: right;"><?php 
                              
                                    $gpround = round(($gp/$realCount),2);

                                    if ($gradeTDUpper) {
                                      
                                      if ($gpround>=3.6) {
                                        echo 'A+';
                                      }elseif ($gpround>=3.2) {
                                        echo 'A';
                                      }elseif ($gpround>=2.8) {
                                        echo 'B+';
                                      }elseif ($gpround>=2.4) {
                                        echo 'B';
                                      }elseif ($gpround>=2.0) {
                                        echo 'C+';
                                      }elseif ($gpround>=1.6) {
                                        echo 'C';
                                      }elseif ($gpround>=1.2) {
                                        echo 'D+';
                                      }elseif ($gpround>=0.8) {
                                        echo 'D';
                                      }elseif ($gpround>0) {
                                        echo 'E';
                                      }elseif ($gpround==0) {
                                        echo 'N';
                                      }else{
                                        echo "";
                                      }
                                    }
                                    ?>
                              </th>
                              <?php 
                                echo (  ($highestInSubTD)? "<th></th>" : "" ); 
                              ?>

                              </tr>
                          </tfoot>
                          </tbody>
                        </table>


                        
                        <!-- outcome Table -->
                        <h6 style="margin: 10px;"><span><b>Outcomes</b></span></h6>

                        <div style="display: inline-flex;width: 100%;">
                          <div style="width: 50%;">

                            <table style="width:100%;" class="marks">
                          <tbody class="bodered">
                            <tr>
                              <?php if ($gpaTD) { ?>                              
                              <td style="text-align: left;">GPA</td>
                              <td><?php 
                                    
                                    echo $gpround;
                                    
                                    ?>
                              <?php } else if ($gradeTD) { ?>
                              </td>
                              <td style="text-align: left;">Grade</td>
                              <td>
                                <?php if ($gpround>=3.6) {
                                      echo 'A+';
                                    }elseif ($gpround>=3.2) {
                                      echo 'A';
                                    }elseif ($gpround>=2.8) {
                                      echo 'B+';
                                    }elseif ($gpround>=2.4) {
                                      echo 'B';
                                    }elseif ($gpround>=2.0) {
                                      echo 'C+';
                                    }elseif ($gpround>=1.6) {
                                      echo 'C';
                                    }elseif ($gpround>=1.2) {
                                      echo 'D+';
                                    }elseif ($gpround>=0.8) {
                                      echo 'D';
                                    }elseif ($gpround>0) {
                                      echo 'E';
                                    }elseif ($gpround==0) {
                                      echo 'N';
                                    }else{
                                      echo "";
                                    } 
                                ?>
                              </td>
                              <?php } ?>
                            </tr>
                            <tr >
                              <td style="text-align: left;">Percentage</td>
                              <td><?php 
                                    $tm=$gt;
                                    $ob=$go;
                                    $avg=($ob/$tm)*100;
                                    echo round($avg, 2)."%";
                                    ?>
                              </td>
                                 
                            </tr>
                            <tr >
                              <td style="text-align: left;">Attendance</td>
                              <td></td>
                                 
                            </tr>
                            
                          </tbody>
                        </table>

                          </div>
                          <div style="width: 50%;">

                            <table style="width:100%;border-left: 0px solid;" class="marks">
                              <tbody class="bodered">
                                <tr>
                                  <?php if ($gpaTD && $gradeTD) { ?>
                                  </td>
                                  <td style="text-align: left;border-left: 0px solid;">Grade</td>
                                  <td>
                                    <?php if ($gpround>=3.6) {
                                          echo 'A+';
                                        }elseif ($gpround>=3.2) {
                                          echo 'A';
                                        }elseif ($gpround>=2.8) {
                                          echo 'B+';
                                        }elseif ($gpround>=2.4) {
                                          echo 'B';
                                        }elseif ($gpround>=2.0) {
                                          echo 'C+';
                                        }elseif ($gpround>=1.6) {
                                          echo 'C';
                                        }elseif ($gpround>=1.2) {
                                          echo 'D+';
                                        }elseif ($gpround>=0.8) {
                                          echo 'D';
                                        }elseif ($gpround>0) {
                                          echo 'E';
                                        }elseif ($gpround==0) {
                                          echo 'N';
                                        }else{
                                          echo "";
                                        } 
                                    ?>
                                  </td>
                                  <?php } ?>
                                </tr>
                                <tr >
                                  
                                  <?php if($resultTD){ ?>
                                  <td style="text-align: left;border-left: 0px solid;">Result</td>
                                  <td>
                                    <?php if($fail == 1){ echo "Fail"; }else{
                                            echo "Pass";
                                          } 
                                    ?>
                                  </td> 
                                  <?php } ?>   
                                </tr>
                                <tr >
                                  
                                  <?php if ($rankTD){ ?>
                                  <td style="text-align: left;border-left: 0px solid;">Rank</td>
                                  <td>
                                    <?php //echo $studentTotalMarkById[$studentid].'=';
                                          if($fail != 1){

                                            echo $rankArray[$studentid];
                                            
                                          }else{ 
                                            echo "--"; 
                                          } 
                                          ?>
                                  </td>
                                  <?php } ?>    
                                </tr>
                                
                              </tbody>
                            </table>

                          </div>
                        </div>




                        

                        

                        <!-- ================  Remarking =============  -->
                        <div style="display: inline-flex;width: 100%;margin: 20px 0;font-size: 11px;">
                          <div style="margin: auto;">Remark:</div>
                          <div style="border: 1px solid #000;
                                  width: 100%;
                                  text-align: left;
                                  padding: 5px 10px;
                                  margin: 0 5px;"> 
                                  <?php 
                                  if ($avg>=90) {
                                    echo 'OUTSTANDING';
                                  }elseif ($avg>=80) {
                                    echo 'EXCELLENT';
                                  }elseif ($avg>=70) {
                                    echo 'VERY GOOD';
                                  }elseif ($avg>=60) {
                                    echo 'GOOD';
                                  }elseif ($avg>=50) {
                                    echo 'ABOVE AVERAGE';
                                  }elseif ($avg>=40) {
                                    echo 'AVERAGE';
                                  }elseif ($avg>=20) {
                                    echo 'BELOW AVERAGE';
                                  }elseif ($avg>=1) {
                                    echo 'INSUFFICIENT';
                                  }elseif ($avg==0) {
                                    echo 'VERY INSUFFICIENT';
                                  }else{
                                    echo "";
                                  }
                                  ?>
                          </div>
                        </div>
                        <div style="display: inline-flex;width: 100%;font-size: 11px;">
                          <div >Issue Date:</div>
                          <div style="text-align: left; margin: 0 5px;"> 
                              <?php echo $login_today_date; ?>
                          </div>
                        </div>
                        <!-- Sign and seal -->
                        <div style="display: inline-flex;margin-top: 10px; width: 100%;font-size: 11px;">
                          <div style="margin: auto;">
                            <!-- <img src="../assets/dsign.png" style="height: 30px;width: 70px;margin-bottom: -20px;"> -->
                            <br>_____________<br>
                            <span style=" ">Class Teacher</span>
                            
                          </div>
                          <?php if (!empty($school_details->sign)){?>
                          <div style="position: absolute;bottom: 10px;right: 28px;">
                            <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 76px;width: 93px;
                            margin-bottom: 7px;margin-right: 8px;"><br>
                          </div>
                          <?php } ?>
                          <div style="margin: auto;">
                            <!-- <img src="../assets/dsign.png" style="height: 30px;width: 70px;margin-bottom: -20px;"> -->
                            <br>_____________<br>
                            <span style=" ">School seal</span>
                            
                          </div>
                          <div style="margin: auto;">
                            <!-- <img src="../assets/dsign.png" style="height: 30px;width: 70px;margin-bottom: -20px;"> -->
                            <br>_____________<br>
                            <span style=" ">Principal</span>
                            
                          </div>
                        </div>
                        
                      </div>
                    </div>
                  <!-- </div>  -->       
                    

                    
                  
                  
                  </div>

                  <?php 
                } //END OF MARKSHEET FOUND ?>
                     
              <?php 
            }
          } ?>


        </div>
      </div>

    <?php 
  }else if($template == 5 && $mfound==1){

      ?>

      <div class="container">
        <div class="col-md-12" align="right">
          <input type='button' id='btn' value='Print' onclick='printDiv();'>
        </div>
        <div id="invoice_print">

          <style type="text/css" media="print">
                @media print {
                  body {-webkit-print-color-adjust: exact;}
                }
                @page {
                    size:A4 <?php echo (($print_format == 'a5')? 'landscape' : (($print_format == 'a4')? 'portrait' : '') ); ?>;
                    -webkit-print-color-adjust: exact;
                    margin: 0;
                    color-adjust: exact;
                    -webkit-filter:opacity(1);
                }
            </style>
            <style type="text/css">
                    @font-face {
                      font-family: happyEnding;
                      src: url(../assets/HappyEnding.ttf);
                    }

                    <?php if ($print_format == 'a5') { ?>

                      .marksTable{
                        width:100%;height: 350px;
                      }

                      table.marks , .marks>thead>tr>th,.marks>tfoot>tr>th,.marks>tbody.bodered>tr>td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        padding: 5px;
                        font-size: 11px;
                        text-align: center;
                      }
                      .marks>tbody>tr>td {
                          border-right: 1px solid black;
                          border-collapse: collapse;
                          padding: 5px;
                          font-size: 11px;
                          text-align: center;
                      }
                      .schoolName{
                        margin:0px 0;
                      }
                      .examName{
                        padding: 3px;
                      }
                      .marksheetUpper{
                        margin: 8px 0;
                      }
                      .marksheetInner{
                        padding: 2px 10%;
                      }
                      .studentDetails{
                        width:100%;
                        text-align: left; 
                        font-size: 11px;
                        margin: 0px 0;
                      }
                      .principalSign{
                        height: 30px;
                        width: 70px;
                        margin-bottom: -20px;
                      }
                      

                    <?php } ?>
                    <?php if ($print_format == 'a4') { ?>

                      .marksTable{
                        width:100%;height: 400px;
                      }

                      table.marks , .marks>thead>tr>th,.marks>tfoot>tr>th,.marks>tbody.bodered>tr>td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        padding: 5px;
                        font-size: 14px;
                        text-align: center;
                      }
                      .marks>tbody>tr>td {
                          border-right: 1px solid black;
                          border-collapse: collapse;
                          padding: 5px;
                          font-size: 14px;
                          text-align: center;
                      }
                      .schoolName{
                        margin:10px 0;
                      }
                      .examName{
                        padding: 10px;
                      }
                      .marksheetUpper{
                        margin: 15px 0;
                      }
                      .marksheetInner{
                        padding: 5px 10%;
                      }
                      .studentDetails{
                        width:100%;
                        text-align: left; 
                        font-size: 13px;
                        margin: 10px 0;
                      }
                      .principalSign{
                        height: 50px;
                        width: 100px;
                        margin-bottom: -20px;
                      }
                      


                       .page {
                          width: 21cm;
                          height: 29.7cm; 
                          border-radius: 5px;
                          background: white;
                      }
                      .subpage {
                        width: -webkit-fill-available;
                        height: -webkit-fill-available;
                        padding: 15px;
                        border: 5px red solid;
                      }
                      .page-break {
                        page-break-after: always;
                      }

                    <?php } ?>
                  </style>

          <?php
          if ($studentarray){
            foreach ($studentarray as $studentid){

              // START GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO
                $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`sroll`, `studentinfo`.`dob`, `marksheet`.`month` , `class`.`class_name`, `section`.`section_name`,`academic_year`.`single_year` 
                FROM `marksheet` 

                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 
                LEFT JOIN `class` ON `marksheet`.`marksheet_class` = `class`.`class_id` 
                LEFT JOIN `section` ON `marksheet`.`marksheet_section` = `section`.`section_id` 

                WHERE (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  ) 
                  AND `marksheet`.`mstudent_id`='$studentid' 
                  AND `marksheet`.`marksheet_class`='$class_id' 
                  AND `marksheet`.`month`='$month_id' 
                  AND `marksheet`.`year_id`='$year_id' 
                GROUP BY `marksheet`.`mstudent_id`";

                $resultstd = $db->query($sqlstd);
                $rowstd = $resultstd->fetch_assoc();
              // END GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO


                $rowCount = count(${'m_obtained_mark_student' . $studentid});
                if($rowCount > 0) { $found='1'; } else{ $found='0';   } ?>
            

                <?php 
                if ($found == '1') { //IF MARKSHEET FOUND PRINT OTHERWISE SKIP
                 ?>
                  <!-- marksheet -->
                  
                  <?php if ($print_format == 'a5') { ?>

                  <div style="position: relative; height:96%; width:48%;float:left;margin-top: 10px;margin-bottom: 10px; padding-left: 10px;margin-left: 6px;">

                    <!-- <div style="width:146mm; height:208mm;"> -->
                    <div style="z-index: 1; text-align:center; border: 2px solid #787878;position: relative;height: 100%;overflow: hidden;" class="backGreen">
  
                  <?php }else{ ?>

                    <div style="position: relative;  padding: 20px" class="page">

                  <!-- <div style="width:146mm; height:208mm;"> -->
                    <div style="z-index: 1; text-align:center; border: 2px solid #787878;position: relative;overflow: hidden;" class="backGreen subpage">

  

                  <?php } ?>
                  
                      




                      <div style="display: inline-flex;width:100%;padding: 5px 0">
                        <div style="width: 50px;height: 60px;text-align: center;margin: auto; position: absolute;">
                          <img style="height: inherit; margin: 20px 0 0 10px;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                        </div>
                        <div  style="width: inherit; text-align: center;position: relative;padding: 0 20px;margin: auto 60px; ">
                               <h3 class="schoolName" style="font-weight: bolder;text-transform: uppercase; font-size: <?php echo (($print_format == 'a5')? '15px' : (($print_format == 'a4')? '21px' : '12px') ); ?>;"><?php echo $login_session_a; ?></h3>
                               <div >
                                  <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Estd: <?php echo $login_session_g; ?></p>
                                  
                               </div>           
                        </div>
                        
                      </div>
                      <div style="padding: 0 10px">
                        <div style="margin: 5px auto">
                          <div style="width: 55%;background: #000;margin: auto;">
                            <h4 class="examName" style="margin: 0;color: #fff;text-transform: uppercase;"><b><?php echo $examtype_details->examtype_name; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
                              echo '&nbsp'.$rowstd["single_year"];
                             ?></b>
                            </h4>
                          </div>
                          <h4 class="marksheetUpper" ><span class="marksheetInner" style="border: 1px solid #000; "><b>MARK-SHEET</b></span></h4>
                        </div>
                        <!-- student detail -->
                        <table class="studentDetails">
                          <tr>
                            <td colspan="2">Name : <span><b><?php echo $rowstd['sname']; ?></b></span></td>
                            <td >Roll No. : <b><?php echo $rowstd['sroll']; ?></b></td>
                          </tr>
                          <tr>
                            <!-- <td >DOB : <span><b></b></span></td> -->
                            <td colspan="2">Class : <span><b><?php echo $rowstd['class_name']; ?></b></span></td>
                            <td >Section : <span><b><?php echo $rowstd['section_name'];?></b></span></td>
                          </tr>
                        </table>
                        <!-- Marks table -->
                        <table class="marks marksTable">
                          <thead style="background: lightgray;">          
                            <tr style="text-align: center;">
                              <th>S.N.</th>
                              <th>Subject</th>
                              <th>F.M.</th>
                              <th>P.M.</th>
                              <?php 
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) { ?>
                                    <th style='font-size: 10px'><?php

                                    echo substr($examinclude->examtype_name,0,3);
                                    echo '<br>'.$examinclude->percent.'%';

                                    ?></th><?php
                                  }
                                  
                                }

                                if ($examtype_details->self_include){
                                  
                                  echo (  ($testMarkRow->mt)? "<th>MT</th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th>OT</th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th>ECA</th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th>LP</th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th>NB</th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th>SE</th>" : "" );   ?>                          
                              <th>TH.</th>
                              <th>PR.</th>
                              <?php } ?>

                              <th>Total</th>
                              <th>Grade</th>
                              <?php 
                                echo (  ($highestInSubTD)? "<th style='font-size: 9px'>Highest<br>Marks</th>" : "" ); 
                              ?>
                            </tr>
                          </thead>
                          <tbody>
                          
                
                          <?php $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0.0; $gp=0.0; $fail = 0; $realCount = 0;

                          foreach (${'m_obtained_mark_student' . $studentid} as $subjectIDkey => $value) {

                            $ob=0.0;


                            ?>
                            <tr style="height: 20px">
                              <td style="text-align: right;">
                                <?php echo $sn++;
                                if($subject_type[$subjectIDkey] != 3){$realCount=$realCount+1;}//increement
                                ?>
                              </td>
                              <td style="text-align: left;">
                                <?php echo substr($subject_name[$subjectIDkey],0,25).((strlen($subject_name[$subjectIDkey]) > 25) ? '..':'');?>
                              </td>
                              <!-- ================= FULL MARK td ========================= -->
                              <td style="text-align: right;">
                                <?php if($subject_type[$subjectIDkey]==1){

                                  $gt=$gt+($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);
                                  echo ($subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey]);

                                }else if($subject_type[$subjectIDkey]==0){ 

                                  $gt=$gt+$subject_THFM[$subjectIDkey];
                                  echo $subject_THFM[$subjectIDkey];

                                }else{
                                }
                                ?>
                              </td>
                              <!-- ================= PASS MARK td ========================= -->
                              <td style="text-align: right;">
                                <?php if($subject_type[$subjectIDkey]==1){ 
                                  $pm=$pm+($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]);
                                  echo ($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]);
                                }else if($subject_type[$subjectIDkey]==0){ 
                                  $pm=$pm+$subject_THPM[$subjectIDkey];
                                  echo $subject_THPM[$subjectIDkey];
                                }else{
                                }

                                ?>
                              </td>
                              <!-- ================= INCLUDED EXAM MARK td ========================= -->
                              <?php
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {

                                    $ob +=${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey];

                                    echo "<td>".${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey]."</td>";
                                  }
                                  
                                }
                              /* ================= TEST MARK td ========================= */

                              if ($examtype_details->self_include){

                                echo (  ($testMarkRow->mt)? ((!empty(${'mMT' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mMT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" )  : "" );

                                echo (  ($testMarkRow->ot)? ((!empty(${'mOT' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mOT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->eca)? ((!empty(${'mECA' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mECA' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->lp)? ((!empty(${'mLP' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mLP' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->nb)? ((!empty(${'mNB' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mNB' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->se)? ((!empty(${'mSE' . $studentid}[$subjectIDkey][$examid]))? "<td style='text-align: right;'>".${'mSE' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                ?>

                                <!-- ================= T.H. td ========================= -->
                                <td style="text-align: right;"> 
                                  <?php if ($subject_type[$subjectIDkey]==3){ //for subject type 3
                                        }else if ($subject_type[$subjectIDkey]==0) {
                                          if(!empty(  ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] )){
                                            $th = $th+${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                            echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                            
                                            if (!$examIncluded) {
                                              echo (( (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]<(float)$subject_THPM[$subjectIDkey])? '*':'');
                                            }
                                            
                                          }else{ echo "-"; }
                                        }else if ($subject_type[$subjectIDkey]==1){
                                          if(!empty(${'theory_mark_student' . $studentid}[$subjectIDkey][$examid])){
                                            $th = $th+${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                            echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];

                                            if (!$examIncluded) {
                                              echo (( (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]<(float)$subject_THPM[$subjectIDkey])? '*':'');
                                            }
                                
                                          }else{ echo "-"; }

                                        }
                                         ?>

                                </td>
                                <!-- ================= P.R. td ========================= -->
                                <td style="text-align: right;">
                                  <?php if ($subject_type[$subjectIDkey]==3){ //for subject type 3
                                        }else if(!empty(  ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]  )){
                                          $pr = $pr+${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                          echo ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                        }else{ echo "-"; } ?>
                                </td>

                              <?php } ?>
                              <!-- ================= Total td ========================= -->
                              <td style="text-align: right;">
                                <?php 

                                if ($examtype_details->self_include){
                                  // GET TOTAL FOR EACH SUBJECT
                                  $ob += ${'m_obtained_mark_student' . $studentid}[$subjectIDkey][$examid];
                                }

                                $go=$go+$ob; 


                                if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                                  if ($examtype_details->self_include){
                                    echo ${'theory_mark_student' . $studentid}[$subjectIDkey][$examid];
                                  }
                                }else{

                                  if(!empty($ob)){

                                    echo $ob;

                                  }else{ echo "-"; }

                                  if ($examIncluded) {
                                    echo (( (float)$ob<(float)($subject_THPM[$subjectIDkey]+$subject_PRPM[$subjectIDkey]))? '*':'');
                                  }

                                  
                                  
                                }
                                ?>
                              </td>
                              <!-- ================= Grade td ========================= -->
                              <td style="text-align: center;">
                                <?php 
                                if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                                }else{

                                  if($subject_type[$subjectIDkey] == 1){ 
                                    $tm=$subject_THFM[$subjectIDkey]+$subject_PRFM[$subjectIDkey];
                                  }else if($subject_type[$subjectIDkey] == 0){
                                    $tm = $subject_THFM[$subjectIDkey];
                                  }

                                    $avg=($ob/$tm)*100;
                                    if(strtolower($ob)=='a'){
                                      echo 'Absent';
                                    }elseif (strtolower($ob)=='s') {
                                      echo 'Suspend';
                                    }


                                    else{ if ($avg>=90) {
                                      echo 'A+';
                                      $gp = $gp+4.0;
                                    }elseif ($avg>=80) {
                                      echo 'A';
                                      $gp = $gp+3.6;
                                    }elseif ($avg>=70) {
                                      echo 'B+';
                                      $gp = $gp+3.2;
                                    }elseif ($avg>=60) {
                                      echo 'B';
                                      $gp = $gp+2.8;
                                    }elseif ($avg>=50) {
                                      echo 'C+';
                                      $gp = $gp+2.4;
                                    }elseif ($avg>=40) {
                                      echo 'C';
                                      $gp = $gp+2.0;
                                    }elseif ($avg>=30) {
                                      echo 'D+';
                                      $gp = $gp+1.6;
                                    }elseif ($avg>=20) {
                                      echo 'D';
                                      $gp = $gp+1.2;
                                    }elseif ($avg>=1) {
                                      echo 'E';
                                      $gp = $gp+0.8;
                                    }elseif ($avg==0) {
                                      echo 'N';
                                      $gp = $gp+0.0;
                                    }else{
                                      echo "";
                                    }}
                                } ?>
                              </td>
                              <!-- ================= Highest subject td ========================= -->
                              <?php if ($highestInSubTD){ ?>
                                <td style="text-align: center;">
                                  <?php 
                                  if ($subject_type[$subjectIDkey] == 3){ //for subject type 3
                                  }else{

                                    arsort($total_mark_in_each_subject_each_student[$subjectIDkey]);

                                    echo reset($total_mark_in_each_subject_each_student[$subjectIDkey]);

                                    //  echo $sHighest[$row["subject_id"]]['1']+$highestSub[$row["subject_id"]]['2'];
                                    // echo $sHighest[$row["subject_id"]];
                                  } ?>
                                </td>
                              <?php } ?>
                            </tr>
                            <?php 
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

                                if($subject_type[$subjectIDkey] == 0 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                                }else if($subject_type[$subjectIDkey] == 1 && (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid] >= (float)$subject_THPM[$subjectIDkey]) {
                                }else if($subject_type[$subjectIDkey] == 3) {
                                }else{
                                  $fail = 1;
                                }

                            }
                          } ?>
              
                            <tr class="">
                              <td style="text-align: right;"></td>
                              <td style="text-align: left;"></td>
                              <td style="text-align: right;"></td>
                              <td style="text-align: right;"></td>
                              <?php 

                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {
                                    echo "<td></td>";
                                  }
                                  
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->ot)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->eca)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->lp)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->nb)? "<td></td>" : "" );
                                  echo (  ($testMarkRow->se)? "<td></td>" : "" );
                                  ?>
                                <td style="text-align: right;"></td>
                                <td style="text-align: right;"></td>
                              <?php } ?>
                              <td style="text-align: right;"></td>
                              <td style="text-align: right;"></td>
                              <?php 
                                echo (  ($highestInSubTD)? "<td style='text-align: right;'></td>" : "" ); 
                              ?>
                            </tr>

                            <tfoot>
                              <tr>
                              <th style="text-align: right;"></th>
                              <th style="text-align: center;">Total</th>
                              <th style="text-align: right;"><?php echo $gt; ?></th>
                              <th style="text-align: right;"><?php echo $pm; ?></th>
                              <?php 
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {
                                    echo "<th></th>";
                                  }
                                  
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th></th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th></th>" : "" );
                                  ?>
                              <th style="text-align: right;"><?php echo $th; ?></th>
                              <th style="text-align: right;"><?php echo $pr; ?></th>
                              <?php } ?>
                              <th style="text-align: right;"><?php echo $go; ?></th>
                              <th style="text-align: right;"><?php 
                              
                                    $gpround = round(($gp/$realCount),2);

                                    if ($gradeTDUpper) {
                                      
                                      if ($gpround>=3.6) {
                                        echo 'A+';
                                      }elseif ($gpround>=3.2) {
                                        echo 'A';
                                      }elseif ($gpround>=2.8) {
                                        echo 'B+';
                                      }elseif ($gpround>=2.4) {
                                        echo 'B';
                                      }elseif ($gpround>=2.0) {
                                        echo 'C+';
                                      }elseif ($gpround>=1.6) {
                                        echo 'C';
                                      }elseif ($gpround>=1.2) {
                                        echo 'D+';
                                      }elseif ($gpround>=0.8) {
                                        echo 'D';
                                      }elseif ($gpround>0) {
                                        echo 'E';
                                      }elseif ($gpround==0) {
                                        echo 'N';
                                      }else{
                                        echo "";
                                      }
                                    }
                                    ?>
                              </th>
                              <?php 
                                echo (  ($highestInSubTD)? "<th></th>" : "" ); 
                              ?>

                              </tr>
                          </tfoot>
                          </tbody>
                        </table>


                        
                        <!-- outcome Table -->
                        <h6 style="margin: 10px;"><span><b>Outcomes</b></span></h6>

                        <div style="display: inline-flex;width: 100%;">
                          <div style="width: 50%;">

                            <table style="width:100%;" class="marks">
                          <tbody class="bodered">
                            <tr>
                              <?php if ($gpaTD) { ?>                              
                              <td style="text-align: left;">GPA</td>
                              <td><?php 
                                    
                                    echo $gpround;
                                    
                                    ?>
                              <?php } else if ($gradeTD) { ?>
                              </td>
                              <td style="text-align: left;">Grade</td>
                              <td>
                                <?php if ($gpround>=3.6) {
                                      echo 'A+';
                                    }elseif ($gpround>=3.2) {
                                      echo 'A';
                                    }elseif ($gpround>=2.8) {
                                      echo 'B+';
                                    }elseif ($gpround>=2.4) {
                                      echo 'B';
                                    }elseif ($gpround>=2.0) {
                                      echo 'C+';
                                    }elseif ($gpround>=1.6) {
                                      echo 'C';
                                    }elseif ($gpround>=1.2) {
                                      echo 'D+';
                                    }elseif ($gpround>=0.8) {
                                      echo 'D';
                                    }elseif ($gpround>0) {
                                      echo 'E';
                                    }elseif ($gpround==0) {
                                      echo 'N';
                                    }else{
                                      echo "";
                                    } 
                                ?>
                              </td>
                              <?php } ?>
                            </tr>
                            <tr >
                              <td style="text-align: left;">Percentage</td>
                              <td><?php 
                                    // $tm=$gt;
                                    // $ob=$go;
                                    // $avg=($ob/$tm)*100;
                                    $avg=($go/$gt)*100;
                                    echo round($avg, 2)."%";
                                    ?>
                              </td>
                                 
                            </tr>
                            <tr >
                              <td style="text-align: left;">Attendance</td>
                              <td></td>
                                 
                            </tr>
                            <?php if ($print_format == 'a4') { ?>
                            <tr >
                              <td style="text-align: left;">Discipline</td>
                              <td></td>
                                 
                            </tr>
                            <tr >
                              <td style="text-align: left;">Neatness</td>
                              <td></td>
                                 
                            </tr>
                            <tr >
                              <td style="text-align: left;">Homework</td>
                              <td></td>
                                 
                            </tr>
                          <?php } ?>
                            
                          </tbody>
                        </table>

                          </div>
                          <div style="width: 50%;">

                            <table style="width:100%;border-left: 0px solid;" class="marks">
                              <tbody class="bodered">
                                <tr>
                                  <?php if ($gpaTD && $gradeTD) { ?>
                                  </td>
                                  <td style="text-align: left;border-left: 0px solid;">Grade</td>
                                  <td>
                                    <?php if ($gpround>=3.6) {
                                          echo 'A+';
                                        }elseif ($gpround>=3.2) {
                                          echo 'A';
                                        }elseif ($gpround>=2.8) {
                                          echo 'B+';
                                        }elseif ($gpround>=2.4) {
                                          echo 'B';
                                        }elseif ($gpround>=2.0) {
                                          echo 'C+';
                                        }elseif ($gpround>=1.6) {
                                          echo 'C';
                                        }elseif ($gpround>=1.2) {
                                          echo 'D+';
                                        }elseif ($gpround>=0.8) {
                                          echo 'D';
                                        }elseif ($gpround>0) {
                                          echo 'E';
                                        }elseif ($gpround==0) {
                                          echo 'N';
                                        }else{
                                          echo "";
                                        } 
                                    ?>
                                  </td>
                                  <?php } ?>
                                </tr>
                                <tr >
                                  
                                  <?php if($resultTD){ ?>
                                  <td style="text-align: left;border-left: 0px solid;">Result</td>
                                  <td>
                                    <?php if($fail == 1){ echo "Fail"; }else{
                                            echo "Pass";
                                          } 
                                    ?>
                                  </td> 
                                  <?php } ?>   
                                </tr>
                                <tr >
                                  
                                  <?php if ($rankTD){ ?>
                                  <td style="text-align: left;border-left: 0px solid;">Rank</td>
                                  <td>
                                    <?php //echo $studentTotalMarkById[$studentid];
                                          if($fail != 1){

                                            echo $rankArray[$studentid];
                                            
                                          }else{ 
                                            echo "--"; 
                                          } 
                                          ?>
                                  </td>
                                  <?php } ?>    
                                </tr>
                                <?php if ($print_format == 'a4') { ?>
                                <tr>
                                  <td style="border-left: 0px; text-align: left;">Division</td>
                                  <td><?php 
                                          if ($avg >= 70) {
                                            echo 'Distinction';
                                          }elseif ($avg >= 60) {
                                            echo '1st Division';
                                          }elseif ($gpround >= 50) {
                                            echo '2nd Division';
                                          }elseif ($gpround >= 40) {
                                           echo '3rd Division';
                                          }else{
                                            echo "Below Minimum";
                                          } 
                                    ?></td>
                                </tr>
                                <tr>
                                  <td style="border-left: 0px; text-align: left;">Intrest in study</td>
                                  <td></td>
                                </tr>
                                <tr>
                                  <td style="border-left: 0px; text-align: left;">Handwriting</td>
                                  <td></td>
                                </tr>
                                <?php } ?>
                                
                              </tbody>
                            </table>

                          </div>
                        </div>




                        

                        

                        <!-- ================  Remarking =============  -->
                        <div style="display: inline-flex;width: 100%;margin: 20px 0;font-size: 11px;">
                          <div style="margin: auto;">Remark:</div>
                          <div style="border: 1px solid #000;
                                  width: 100%;
                                  text-align: left;
                                  padding: 5px 10px;
                                  margin: 0 5px;"> 
                                  <?php 
                                  if ($avg>=90) {
                                    echo 'OUTSTANDING';
                                  }elseif ($avg>=80) {
                                    echo 'EXCELLENT';
                                  }elseif ($avg>=70) {
                                    echo 'VERY GOOD';
                                  }elseif ($avg>=60) {
                                    echo 'GOOD';
                                  }elseif ($avg>=50) {
                                    echo 'ABOVE AVERAGE';
                                  }elseif ($avg>=40) {
                                    echo 'AVERAGE';
                                  }elseif ($avg>=20) {
                                    echo 'BELOW AVERAGE';
                                  }elseif ($avg>=1) {
                                    echo 'INSUFFICIENT';
                                  }elseif ($avg==0) {
                                    echo 'VERY INSUFFICIENT';
                                  }else{
                                    echo "";
                                  }
                                  ?>
                          </div>
                        </div>
                        <div style="display: inline-flex;width: 100%;font-size: 11px;">
                          <div >Issue Date:</div>
                          <div style="text-align: left; margin: 0 5px;"> 
                              <?php echo $login_today_date; ?>
                          </div>
                        </div>
                        <!-- Sign and seal -->
                        <div style="position: absolute;bottom: 10px;width: 100%;left: 0;">
                          <div style="display: inline-flex;margin-top: 10px; width: 100%;font-size: 11px;position: relative;">
                            <div style="margin: auto;">
                             <!--  <?php if (!empty($school_details->sign)){?>
                              <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?> -->
                              <br>_____________<br>
                              <span style=" ">Class Teacher</span>
                              
                            </div>
                            
                          
                            <div style="margin: auto;">
                              <?php if (!empty($school_details->school_stamp)){?>
                              <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->school_stamp; ?>" > <?php } ?>
                              <br>_____________<br>
                              <span style=" ">School seal</span>
                              
                            </div>
                            <div style="margin: auto;">
                              <?php if (!empty($school_details->sign)){?>
                              <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?>
                              <br>_____________<br>
                              <span style=" ">Principal</span>
                              
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  <!-- </div>  -->       
                    

                    
                  
                  
                  </div>
                  <?php if ($print_format == 'a4') { ?>
                  <div class="page-break"></div>
                  <?php } ?>
                  <?php 
                } //END OF MARKSHEET FOUND ?>
                     
              <?php 
            }
          } ?>


        </div>
      </div>

    <?php 
  }elseif ($found==0) { ?>

    <center><h2>No Report Cards available !!!<br><br><button><a href="marksheetforclass.php">go back</a></button></h2></center>

<?php } ?>
<?php include_once("../printer/printfooter.php");?>
