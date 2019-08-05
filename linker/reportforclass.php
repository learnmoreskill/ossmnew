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



    $months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra');

    $examtype_details = json_decode($backstage->get_examtype_details_by_examid($examid));

    if (empty($month_id)) { 
      $month_id = 0;
    }

    if (!$examtype_details->is_monthly){
           $month_id = 0;
    }


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

    if ($template == 5) {
      if ($mode == 'a4' || $mode == 'a5' || $mode == 'a5p') {
        $template = 5;
        $print_format = $mode;
      }
    }

    if ($template == 5) {
      if ($mode == 'a4l' || $mode == 'a5l') {
        $template = 10;
        $print_format = $mode;
      }
    }

    if ($template == 7){ // Grade, GPA Only
      if ($mode == 'a4' || $mode == 'a5' || $mode == 'a5p') {
        $template = 7;
        $print_format = $mode;
      }
    }

    if ($template == 7){ // Grade, GPA Only
      if ($mode == 'a4l' || $mode == 'a5l') {
        $template = 8;
        $print_format = $mode;
      }
    }



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
    if($rowCount1 > 0) { 

      $mfound='1';

      require('../linker/reportForClassArray.php');

      if ($highestInSubTD) {       
            require('../linker/highestInSubject.php');
      }

      if ($rankTD) {
            require('../linker/rankmarkwise.php');
      } 

      require('../linker/attendanceArray.php');


    } else{ $mfound='0';   }


      
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
                                                        echo 'Outstanding Performance';
                                                      }elseif ($avg>=80) {
                                                        echo 'Excellent Performance';
                                                      }elseif ($avg>=70) {
                                                        echo 'Very Good Performance';
                                                      }elseif ($avg>=60) {
                                                        echo 'Good Performance';
                                                      }elseif ($avg>=50) {
                                                        echo 'Above Average Performance';
                                                      }elseif ($avg>=40) {
                                                        echo 'Average Performance';
                                                      }elseif ($avg>=20) {
                                                        echo 'Below Average Performance';
                                                      }elseif ($avg>=1) {
                                                        echo 'Insufficient Performance';
                                                      }elseif ($avg==0) {
                                                        echo 'Very Insufficient Performance';
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
                                    echo 'Outstanding Performance';
                                  }elseif ($avg>=80) {
                                    echo 'Excellent Performance';
                                  }elseif ($avg>=70) {
                                    echo 'Very Good Performance';
                                  }elseif ($avg>=60) {
                                    echo 'Good Performance';
                                  }elseif ($avg>=50) {
                                    echo 'Above Average Performance';
                                  }elseif ($avg>=40) {
                                    echo 'Average Performance';
                                  }elseif ($avg>=20) {
                                    echo 'Below Average Performance';
                                  }elseif ($avg>=1) {
                                    echo 'Insufficient Performance';
                                  }elseif ($avg==0) {
                                    echo 'Very Insufficient Performance';
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
  }else if($template == 5 && $mfound==1){ // Running

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
                    size:<?php echo (($print_format == 'a5')? 'A4 landscape' : (($print_format == 'a4')? 'A4 portrait' : (($print_format == 'a5p')? 'A5 portrait' : '') ) ); ?>;
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
                        font-size: 12px;
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
                    <?php if ($print_format == 'a4'  || $print_format == 'a5p') { ?>

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
                        font-size: <?php echo (($print_format == 'a4')? '21px' : '15px') ?>;
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
                      
                    <?php } ?>

                    .page-break {
                        page-break-after: always;
                      }
            </style>

          <?php
          if ($studentarray){
            foreach ($studentarray as $studentid){

              // START GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO
                $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`dob`
                , `marksheet`.`month` 
                , `syearhistory`.`roll_no`
                , `class`.`class_name`, `section`.`section_name`
                ,`academic_year`.`single_year` 
                
                FROM `marksheet` 

                INNER JOIN `syearhistory` ON `marksheet`.`mstudent_id` = `syearhistory`.`student_id`
                  AND `syearhistory`.`year_id` = '$year_id'

                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                
                LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 

                LEFT JOIN `class` ON `syearhistory`.`class_id` = `class`.`class_id` 
                LEFT JOIN `section` ON `syearhistory`.`section_id` = `section`.`section_id` 

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
                               <h3 class="schoolName" style="font-weight: bolder;text-transform: uppercase;"><?php echo $login_session_a; ?></h3>
                               <div >
                                  <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Phone : <?php echo $LOGIN_SCHOOL_PHONE_NO; ?></p>
                                  
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
                          <h4 class="marksheetUpper" ><span class="marksheetInner" style="border: 1px solid #000; "><b>ACADEMIC PROGRESS REPORT</b></span></h4>
                        </div>
                        <!-- student detail -->
                        <table class="studentDetails">
                          <tr>
                            <td colspan="2">Name : <span><b><?php echo $rowstd['sname']; ?></b></span></td>
                            <td >Roll No. : <b><?php echo $rowstd['roll_no']; ?></b></td>
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

                              <th  style='font-size: 9px'>Marks<br>Obtained</th>
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
                              <td><?php echo $attendanceArray[$studentid]; ?></td>
                                 
                            </tr>
                            <?php if ($print_format == 'a4'  || $print_format == 'a5p') { ?>
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
                                <?php if ($print_format == 'a4'  || $print_format == 'a5p') { ?>
                                <tr>
                                  <td style="border-left: 0px; text-align: left;">Division</td>
                                  <td><?php 
                                          // if ($avg >= 70) {
                                          //   echo 'Distinction';
                                          // }elseif ($avg >= 60) {
                                          //   echo '1st Division';
                                          // }elseif ($gpround >= 50) {
                                          //   echo '2nd Division';
                                          // }elseif ($gpround >= 40) {
                                          //  echo '3rd Division';
                                          // }else{
                                          //   echo "Below Minimum";
                                          // } 
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
                                    echo 'Outstanding Performance';
                                  }elseif ($avg>=80) {
                                    echo 'Excellent Performance';
                                  }elseif ($avg>=70) {
                                    echo 'Very Good Performance';
                                  }elseif ($avg>=60) {
                                    echo 'Good Performance';
                                  }elseif ($avg>=50) {
                                    echo 'Above Average Performance';
                                  }elseif ($avg>=40) {
                                    echo 'Average Performance';
                                  }elseif ($avg>=20) {
                                    echo 'Below Average Performance';
                                  }elseif ($avg>=1) {
                                    echo 'Insufficient Performance';
                                  }elseif ($avg==0) {
                                    echo 'Very Insufficient Performance';
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
                  <div class="page-break"></div>
                  <?php 
                } //END OF MARKSHEET FOUND ?>
                     
              <?php 
            }
          } ?>


        </div>
      </div>

    <?php 
  }else if($template == 10 && $mfound==1){ // template 5 in landscape mode for a5 and a4 full Support = a4l,a5l

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
                    size:<?php echo (($print_format == 'a5l')? 'A5 landscape' : (($print_format == 'a4l')? ' A4 landscape' : '') ); ?>;
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

                    <?php if ($print_format == 'a4l') { ?>

                      .marksTable{
                        width:100%;height:440px;
                      }
                      .remarkContainer{
                        display: inline-flex;
                        width: 100%;
                        margin: 20px 0;
                        font-size: 11px;
                      }
                      .remarkContent{
                        border: 1px solid #000;
                        width: 100%;
                        text-align: left;
                        padding: 5px 10px;
                        margin: 0 5px;
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
                        font-size: 13px;
                      }
                      .schoolAddress{
                      	margin: 0;
                      	font-size: 12px;
                      	font-family: happyEnding;
                      }
                      .examNameBG{
                      	width: 35%;
                      	background: #000;
                      	margin: auto;
                      }
                      .examName{
                        padding: 3px;
                        font-size: 80%;
                        margin: 0;
                        color: #fff;
                        text-transform: uppercase;
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
                      

                  <?php }else if ($print_format == 'a5l') { ?>

                      .marksTable{
                        width:100%;
                        height:250px;
                      }
                      .remarkContainer{
                        display: inline-flex;
                        width: 100%;
                        margin: 5px 0;
                        font-size: 11px;
                      }
                       .remarkContent{
                        /*border: 1px solid #000;*/
                        width: 100%;
                        text-align: left;
                        padding: 2px;
                        margin: 0 5px;
                        font-weight: bold;
                        font-style: italic;
                        font-size: 12px;
                      }

                      table.marks , .marks>thead>tr>th,.marks>tfoot>tr>th,.marks>tbody.bodered>tr>td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        padding: 0px;
                        font-size: 10px;
                        text-align: center;
                      }
                      .marks>tfoot>tr>th{
                      	padding: 4px;
                      }
                      .marks>tbody>tr>td {
                          border-right: 1px solid black;
                          border-collapse: collapse;
                          padding: 0 4px;
                          font-size: 12px;
                          text-align: center;
                          border-bottom: 1px solid #6f6f6f;
                      }
                      .explanation{
                      	border-left: 0px solid;
                      	margin-bottom: 5px;
                      }
                      .hiddenBorderTop{
                      	border-top: hidden;
                      }
                      .OutcomeTD{
						padding: 4px 0px 4px 0px!important;
						font-weight: bold;
                      }
                      .OutcomeTDPD{
                      	padding: 4px 0px 4px 0px!important;
                      }
                      .schoolName{
                        margin:0px 0;
                        font-size: 14px;
                      }
                      .schoolAddress{
                      	color: #000;
                      	margin: 0;
                      	font-size: 13px;
                      	font-family: happyEnding;
                      }
                      .examNameBG{
                      	/*width: 35%;
                      	background: #000;
                      	margin: auto;*/
                      }
                      .examName{
                        padding: 3px;
                        font-size: 85%;
                        margin: -5px 0px 0px 0px;
                        color: #000;
                        text-transform: uppercase;
                      }
                      .marksheetUpper{
                      	margin: -5px 0px 0px 0px;
                        font-size: 80%;
                      }
                      .marksheetInner{
                        padding: 2px 10%;
                        /*border: 1px solid #000;*/
                      }
                      .studentDetails{
                        width:100%;
                        text-align: left; 
                        font-size: 10px;
                        margin: 0px 0;
                      }
                      .principalSign{
                        height: 30px;
                        width: 70px;
                        margin-bottom: -15px;
                        transform: rotate(15deg);
                      }
                      .principalSignOther{
                        height: 30px;
                        width: 70px;
                        margin-bottom: -20px;
                      }
                      <?php } ?>

                      .page-break {
                        page-break-after: always;
                      }
                  </style>

          <?php
          if ($studentarray){
            foreach ($studentarray as $studentid){

              // START GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO
                $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`dob`
                , `marksheet`.`month` 
                , `syearhistory`.`roll_no`
                , `class`.`class_name`, `section`.`section_name`
                ,`academic_year`.`single_year` 
                
                FROM `marksheet` 

                INNER JOIN `syearhistory` ON `marksheet`.`mstudent_id` = `syearhistory`.`student_id`
                  AND `syearhistory`.`year_id` = '$year_id'

                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                
                LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 

                LEFT JOIN `class` ON `syearhistory`.`class_id` = `class`.`class_id` 
                LEFT JOIN `section` ON `syearhistory`.`section_id` = `section`.`section_id` 

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

                    <div style="position: relative; height:94%;  padding: 18px 10px 18px 22px;" class="page">

                    <div style="z-index: 1; text-align:center; border: 2px solid #787878;position: relative;height: 100%;overflow: hidden;" class="backGreen subpage">
                  
                      




                      <div style="display: inline-flex;width:100%;padding-top: 5px;padding-right: 0px;padding-bottom: 0px;padding-left: 0px;">
                        <div style="width: 50px;height: 60px;text-align: center;margin: auto; position: absolute;">
                          <img style="height: inherit; margin: 3px 0 0 10px;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                        </div>
                        <div  style="width: inherit; text-align: center;position: relative;padding: 0 20px;margin: auto 60px; ">
                               <h3 class="schoolName" style="font-weight: bolder;text-transform: uppercase;"><?php echo $login_session_a; ?></h3>
                               <div style="line-height: 11px">
                                  <span class="schoolAddress"> <?php echo $login_session_c; ?></span><br><span style="font-size: 10px;">PHONE NO :  <?php echo $LOGIN_SCHOOL_PHONE_NO; ?></span>
                                  
                               </div>           
                        </div>
                        
                      </div>
                      <div style="padding: 0 10px">
                        <div style="margin: 0px auto">
                          <div class="examNameBG">
                            <h4 class="examName"><b><?php echo $examtype_details->examtype_name; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
                              echo ' - '.$rowstd["single_year"];
                             ?></b>
                            </h4>
                          </div>
                          <h4 class="marksheetUpper" ><span class="marksheetInner"><b>ACADEMIC PROGRESS REPORT</b></span></h4>
                          <hr style="margin: 0;">
                        </div>
                        <!-- student detail -->
                        <table class="studentDetails">
                          <tr>
                            <td colspan="2">NAME : <span><b><?php echo $rowstd['sname']; ?></b></span></td>
                            <td >ROLL NO. : <b><?php echo $rowstd['roll_no']; ?></b></td>
                          </tr>
                          <tr>
                            <!-- <td >DOB : <span><b></b></span></td> -->
                            <td colspan="2">CLASS : <span><b><?php echo $rowstd['class_name']; ?></b></span></td>
                            <td >SECTION : <span><b><?php echo $rowstd['section_name'];?></b></span></td>
                          </tr>
                        </table>
                        <!-- Marks table -->
                        <table class="marks marksTable">
                          <thead style="background: lightgray;">          
                            <tr style="text-align: center;">
                              <th>S.N.</th>
                              <th>SUBJECTS</th>
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

                              <th style='font-size: 9px'>MARKS<br>OBTAINED</th>
                              <th>GRADE</th>
                              <th style='font-size: 9px'>GRADE<br>POINT</th>
                              <?php 
                                echo (  ($highestInSubTD)? "<th style='font-size: 9px'>HIGHEST<br>MARKS</th>" : "" ); 
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
                              <td>
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
                              <td>
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

                                echo (  ($testMarkRow->mt)? ((!empty(${'mMT' . $studentid}[$subjectIDkey][$examid]))? "<td>".${'mMT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" )  : "" );

                                echo (  ($testMarkRow->ot)? ((!empty(${'mOT' . $studentid}[$subjectIDkey][$examid]))? "<td>".${'mOT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->eca)? ((!empty(${'mECA' . $studentid}[$subjectIDkey][$examid]))? "<td>".${'mECA' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->lp)? ((!empty(${'mLP' . $studentid}[$subjectIDkey][$examid]))? "<td>".${'mLP' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->nb)? ((!empty(${'mNB' . $studentid}[$subjectIDkey][$examid]))? "<td>".${'mNB' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                echo (  ($testMarkRow->se)? ((!empty(${'mSE' . $studentid}[$subjectIDkey][$examid]))? "<td>".${'mSE' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td></td>" ) : "" );

                                ?>

                                <!-- ================= T.H. td ========================= -->
                                <td> 
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
                                <td>
                                  <?php if ($subject_type[$subjectIDkey]==3){ //for subject type 3
                                        }else if(!empty(  ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]  )){
                                          $pr = $pr+${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                          echo ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                        }else{ echo "-"; } ?>
                                </td>

                              <?php } ?>
                              <!-- ================= Total td ========================= -->
                              <td>
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

                                  // Tempororay for everest
                                  if (!$examIncluded) {
                                    echo (( (float)${'theory_mark_student' . $studentid}[$subjectIDkey][$examid]<(float)$subject_THPM[$subjectIDkey])? '*':'');
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
                                      $gradePT = 4;
                                      $gp = $gp+4.0;
                                    }elseif ($avg>=80) {
                                      echo 'A';
                                      $gradePT = 3.6;
                                      $gp = $gp+3.6;
                                    }elseif ($avg>=70) {
                                      echo 'B+';
                                      $gradePT = 3.2;
                                      $gp = $gp+3.2;
                                    }elseif ($avg>=60) {
                                      echo 'B';
                                      $gradePT = 2.8;
                                      $gp = $gp+2.8;
                                    }elseif ($avg>=50) {
                                      echo 'C+';
                                      $gradePT = 2.4;
                                      $gp = $gp+2.4;
                                    }elseif ($avg>=40) {
                                      echo 'C';
                                      $gradePT = 2;
                                      $gp = $gp+2.0;
                                    }elseif ($avg>=30) {
                                      echo 'D+';
                                      $gradePT = 1.6;
                                      $gp = $gp+1.6;
                                    }elseif ($avg>=20) {
                                      echo 'D';
                                      $gradePT = 1.2;
                                      $gp = $gp+1.2;
                                    }elseif ($avg>=1) {
                                      echo 'E';
                                      $gradePT = 0.8;
                                      $gp = $gp+0.8;
                                    }elseif ($avg==0) {
                                      echo 'N';
                                      $gradePT = 0;
                                      $gp = $gp+0.0;
                                    }else{
                                      $gradePT = '';
                                      echo "";
                                    }}
                                } ?>
                              </td>



                              <td style="text-align: center;"><?php if ($subject_type[$subjectIDkey] != 3){ //for subject type 3
                                echo $gradePT; } ?></td>
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
                                <td></td>
                                <td></td>
                                <td></td>
                              <?php } ?>
                              <td></td>
                              <td></td>
                              <?php 
                                echo (  ($highestInSubTD)? "<td style='text-align: right;'></td>" : "" ); 
                              ?>
                            </tr>

                            <tfoot>
                              <tr>
                              <th style="text-align: right;"></th>
                              <th style="text-align: center;">TOTAL</th>
                              <th style="text-align: center;"><?php echo $gt; ?></th>
                              <th style="text-align: center;"><?php echo $pm; ?></th>
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
                              <th style="text-align: center;"><?php echo $th; ?></th>
                              <th style="text-align: center;"><?php echo $pr; ?></th>
                              <?php } ?>
                              <th style="text-align: center;"><?php echo $go; ?></th>
                              <th></th>
                              <th style="text-align: center;"><?php 
                              
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
                        <!-- <h6 style="margin: 10px;"><span><b>Outcomes</b></span></h6> -->
                        
                        <table style="width:100%;border-left: 0px solid;" class="marks">
                        	<tbody class="bodered hiddenBorderTop">
                              <tr>
                                <?php if ($gpaTD) { ?>
                                  <td class="OutcomeTDPD"><b>GPA :</b> <?php echo $gpround; ?></td>
                                <?php } ?>

                                <?php if ($gradeTD) { ?>
                                  <td class="OutcomeTDPD"><b>GRADE :</b> <?php if ($gpround>=3.6) {
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
                                    } ?>
                                  </td>
                                <?php } ?>

                                  <td class="OutcomeTDPD"><b>PERCENTAGE :</b> <?php 
                                    $avg=($go/$gt)*100;
                                    echo round($avg, 2)."%";
                                    ?>
                                  </td>
                                  <td class="OutcomeTDPD"><b>ATTENDANCE :</b> <?php echo $attendanceArray[$studentid]; ?></td>

                                <?php if ($resultTD) { ?>
                                  <td class="OutcomeTDPD"><b>RESULT :</b> <?php if($fail == 1){ echo "FAILED"; }else{ echo "PASSED"; } ?>
                                  </td>
                                <?php } ?>

                                <?php if ($rankTD) { ?>
                                  <td class="OutcomeTDPD"><b>RANK :</b> <?php if($fail != 1){ echo $rankArray[$studentid]; }else{   echo "--";   } ?>
                                  </td>
                                <?php } ?>
                              </tr>
                            </tbody>
                        </table>
                        

                        <!-- ================  Remarking =============  -->
                        <div class="remarkContainer">
                          <div style="margin: auto; font-weight: bold;">REMARKS: </div>
                          <div class="remarkContent"> 
                                  <?php 
                                  if ($avg>=90) {
                                    echo 'Outstanding Performance';
                                  }elseif ($avg>=80) {
                                    echo 'Excellent Performance';
                                  }elseif ($avg>=70) {
                                    echo 'Very Good Performance';
                                  }elseif ($avg>=60) {
                                    echo 'Good Performance';
                                  }elseif ($avg>=50) {
                                    echo 'Above Average Performance';
                                  }elseif ($avg>=40) {
                                    echo 'Average Performance';
                                  }elseif ($avg>=20) {
                                    echo 'Below Average Performance';
                                  }elseif ($avg>=1) {
                                    echo 'Insufficient Performance';
                                  }elseif ($avg==0) {
                                    echo 'Very Insufficient Performance';
                                  }else{
                                    echo "";
                                  }
                                  ?>
                          </div>
                        </div>
                       <!--  <div style="display: inline-flex;width: 100%;font-size: 11px;">
                          <div >Issue Date:</div>
                          <div style="text-align: left; margin: 0 5px;"> 
                              <?php echo $login_today_date; ?>
                          </div>
                        </div> -->
                        <!-- Sign and seal -->
                        <div style="width: 100%;left: 0;">
                          <div style="display: inline-flex;width: 100%;font-size: 11px;position: relative;">
                             <div style="margin: auto;">
                               <div class="principalSignOther" style="height: 14px"> 
                                  <?php echo $login_today_date; ?>
                              </div>
                              <br>_____________<br>
                              <span style=" ">ISSUE DATE</span>
                              
                            </div>
                            <div style="margin: auto;">
                             <!--  <?php if (!empty($school_details->sign)){?>
                              <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?> -->
                              <br>_______________<br>
                              <span style=" ">CLASS TEACHER</span>
                              
                            </div>
                            
                          
                            <div style="margin: auto;">
                              <?php if (!empty($school_details->school_stamp)){?>
                              <img class="principalSignOther" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->school_stamp; ?>" > <?php } ?>
                              <br>_____________<br>
                              <span style=" ">SCHOOL'S SEAL</span>
                              
                            </div>
                            <div style="margin: auto;">
                              <?php if (!empty($school_details->sign)){?>
                              <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?>
                              <br>_____________<br>
                              <span style=" ">PRINCIPAL</span>
                              
                            </div>
                          </div>
                        </div>
                        <hr style="margin: 0 0 4px 0;">

                        <div style="width: 100%; display: inline-flex;">
                        	<div style="width: 79%;">
                        		<h6 style="margin: 0;">EXPLANATION OF GRADE</h6>
                        		<table class="marks explanation" style="width: 100%" >
		                        	<tbody class="bodered">
		                              	<tr>
		                                  	<td class="OutcomeTD">90%-100%</td>
		                                  	<td class="OutcomeTD">80%-<90%</td>
		                                  	<td class="OutcomeTD">70%-<80%</td>
		                                  	<td class="OutcomeTD">60%-<70%</td>
		                                  	<td class="OutcomeTD">50%-<60%</td>
		                                  	<td class="OutcomeTD">40%-<50%</td>
		                                  	<td class="OutcomeTD">30%-<40%</td>
		                                  	<td class="OutcomeTD">20%-<30%</td>
		                                  	<td class="OutcomeTD">BELOW 20%</td>
		                              	</tr>
		                              	<tr>
		                                  	<td class="OutcomeTD">A+</td>
		                                  	<td class="OutcomeTD">A</td>
		                                  	<td class="OutcomeTD">B+</td>
		                                  	<td class="OutcomeTD">B</td>
		                                  	<td class="OutcomeTD">C+</td>
		                                  	<td class="OutcomeTD">C</td>
		                                  	<td class="OutcomeTD">D+</td>
		                                  	<td class="OutcomeTD">D</td>
		                                  	<td class="OutcomeTD">E</td>
		                              	</tr>
		                            </tbody>
		                        </table>
                        	</div>
                        	<div style="width: 20%; margin-left: 1%">
                        		<h6 style="margin: 0;">KEYS</h6>
                        		<table class="marks explanation"  style="width: 100%">
		                        	<tbody class="bodered">
		                              	<tr>
		                                  	<td class="OutcomeTD">*</td>
		                                  	<td class="OutcomeTD">Ab</td>
		                              	</tr>
		                              	<tr>
		                                  	<td class="OutcomeTD">FAIL</td>
		                                  	<td class="OutcomeTD">ABSENT</td>
		                              	</tr>
		                            </tbody>
		                        </table>
                        	</div>
                        	
	                        
                        </div>

                        



                      </div>
                    </div>
                  <!-- </div>  -->       
                  
                  </div>

                  <div class="page-break"></div>
                  <?php 
                } //END OF MARKSHEET FOUND ?>
                     
              <?php 
            }
          } ?>


        </div>
      </div>

    <?php 
  }else if($template == 7 && $mfound==1){ // everest school template

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
                    size: <?php echo (($print_format == 'a5')? 'A4 landscape' : (($print_format == 'a4')? 'A4 portrait' : (($print_format == 'a5p')? 'A5 portrait' : '') ) ); ?>;
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
                      .gradeRulesTable>tbody>tr>td,.gradeRulesTable>tbody>tr>th{
                        /*padding: 5px!important;*/
                        font-size: 8px!important;
                      }
                      .schoolName{
                        margin:0px 0;
                        font-size: 12px;
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
                    <?php if ($print_format == 'a4' || $print_format == 'a5p') { ?>

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
                      .boldT{
                        font-weight: bold;
                      }
                      .marks>tbody>tr>td {
                          border-right: 1px solid black;
                          border-collapse: collapse;
                          padding: 5px;
                          font-size: 14px;
                          text-align: center;
                      }
                      .gradeRulesTable>tbody>tr>td,.gradeRulesTable>tbody>tr>th{
                        padding: 6px 4px!important;
                        font-size: 12px!important;
                      }
                      .schoolName{
                        margin:10px 0;
                        font-size: <?php echo (($print_format == 'a4')? '22px' : '15px') ?>;
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
                            padding-bottom: 0px;
                            height: 59px;
                            width: 100px;
                            margin-bottom: -45px;
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

                    <?php } ?>

                    .page-break {
                        page-break-after: always;
                      }
                  </style>

          <?php
          if ($studentarray){
            foreach ($studentarray as $studentid){

              // START GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO
                $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`dob`
                , `marksheet`.`month` 
                , `syearhistory`.`roll_no`
                , `class`.`class_name`, `section`.`section_name`
                ,`academic_year`.`single_year` 
                
                FROM `marksheet` 

                INNER JOIN `syearhistory` ON `marksheet`.`mstudent_id` = `syearhistory`.`student_id`
                  AND `syearhistory`.`year_id` = '$year_id'

                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                
                LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 

                LEFT JOIN `class` ON `syearhistory`.`class_id` = `class`.`class_id` 
                LEFT JOIN `section` ON `syearhistory`.`section_id` = `section`.`section_id` 

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
                        <div style="width: 50px;height: 100px;text-align: center;margin: auto; position: absolute;">
                          <img style="height: inherit; margin: 20px 0 0 30px;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                        </div>
                        <div  style="width: inherit; text-align: center;position: relative;padding: 0 20px;margin: auto 60px; ">
                               <P class="schoolName" style="font-weight: bolder;font-size: 30px; text-transform: uppercase;"><?php echo $login_session_a; ?></P>
                               <div >
                                  <p style="margin: 0;font-size: 18px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>PHONE NO. : <?php echo $LOGIN_SCHOOL_PHONE_NO; ?></p>
                                  
                               </div>           
                        </div>
                        
                      </div>
                      <div style="padding: 0 10px">
                        <div style="margin: 5px auto">
                          <div style="width: 55%;margin: auto;">
                            <h4 class="examName" style="margin: 0;text-transform: uppercase;font-size: 20px;"><b><?php echo $examtype_details->examtype_name; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
                              echo '&nbsp'.$rowstd["single_year"];
                             ?></b>
                            </h4>
                          </div>
                          <h4 class="marksheetUpper" style="font-size: 20px;" ><span class="marksheetInner" style="border: 1px solid #000; "><b>ACADEMIC PROGRESS REPORT</b></span></h4>
                        </div>
                        <hr style="margin-top: 20px;margin-bottom: 20px;border: 0;border-top: 1px solid #7d7777;">
                        <!-- student detail -->
                        <table class="studentDetails" style="font-size: 18px;">
                          <tr>
                            <td colspan="2">NAME : <span><b><?php echo $rowstd['sname']; ?></b></span></td>
                            <td >ROLL NO. : <b><?php echo $rowstd['roll_no']; ?></b></td>
                          </tr>
                          <tr>
                            <!-- <td >DOB : <span><b></b></span></td> -->
                            <td colspan="2">CLASS : <span><b><?php echo $rowstd['class_name']; ?></b></span></td>
                            <td >SECTION : <span><b><?php echo $rowstd['section_name'];?></b></span></td>
                          </tr>
                        </table>
                        <!-- Marks table -->
                        <table class="marks marksTable">
                          <thead style="background: lightgray;">          
                            <tr style="text-align: center;">
                              <th>S.N.</th>
                              <th>SUBJECTS</th>
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
                                  
                                  echo (  ($testMarkRow->mt)? "<th style='display: none;'>MT</th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th style='display: none;'>OT</th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th style='display: none;'>ECA</th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th style='display: none;'>LP</th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th style='display: none;'>NB</th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th style='display: none;'>SE</th>" : "" );   ?>                          
                              <th style='display: none;'>TH.</th>
                              <th style='display: none;'>PR.</th>
                              <?php } ?>

                              <th style='display: none;'>Total</th>
                              
                              <th>GRADE</th>
                              <th>GRADE POINT</th>
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
                              <td style="text-align: center;">
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
                              <td style="text-align: center;">
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

                                    echo "<td style='display: none;'>".${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey]."</td>";
                                  }
                                  
                                }
                              /* ================= TEST MARK td ========================= */

                              if ($examtype_details->self_include){

                                echo (  ($testMarkRow->mt)? ((!empty(${'mMT' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mMT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" )  : "" );

                                echo (  ($testMarkRow->ot)? ((!empty(${'mOT' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mOT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->eca)? ((!empty(${'mECA' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mECA' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->lp)? ((!empty(${'mLP' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mLP' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->nb)? ((!empty(${'mNB' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mNB' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->se)? ((!empty(${'mSE' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mSE' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                ?>

                                <!-- ================= T.H. td ========================= -->
                                <td style="display: none; text-align: right;"> 
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
                                <td style="display: none; text-align: right;">
                                  <?php if ($subject_type[$subjectIDkey]==3){ //for subject type 3
                                        }else if(!empty(  ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]  )){
                                          $pr = $pr+${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                          echo ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                        }else{ echo "-"; } ?>
                                </td>

                              <?php } ?>
                              <!-- ================= Total td ========================= -->
                              <td style="display: none; text-align: right;">
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
                                      $gradePT = 4;
                                      $gp = $gp+4.0;
                                    }elseif ($avg>=80) {
                                      echo 'A';
                                      $gradePT = 3.6;
                                      $gp = $gp+3.6;
                                    }elseif ($avg>=70) {
                                      echo 'B+';
                                      $gradePT = 3.2;
                                      $gp = $gp+3.2;
                                    }elseif ($avg>=60) {
                                      echo 'B';
                                      $gradePT = 2.8;
                                      $gp = $gp+2.8;
                                    }elseif ($avg>=50) {
                                      echo 'C+';
                                      $gradePT = 2.4;
                                      $gp = $gp+2.4;
                                    }elseif ($avg>=40) {
                                      echo 'C';
                                      $gradePT = 2;
                                      $gp = $gp+2.0;
                                    }elseif ($avg>=30) {
                                      echo 'D+';
                                      $gradePT = 1.6;
                                      $gp = $gp+1.6;
                                    }elseif ($avg>=20) {
                                      echo 'D';
                                      $gradePT = 1.2;
                                      $gp = $gp+1.2;
                                    }elseif ($avg>=1) {
                                      echo 'E';
                                      $gradePT = 0.8;
                                      $gp = $gp+0.8;
                                    }elseif ($avg==0) {
                                      echo 'N';
                                      $gradePT = 0;
                                      $gp = $gp+0.0;
                                    }else{
                                      echo "";
                                      $gradePT = '';
                                    }}
                                } ?>
                              </td>


                              <td style="text-align: center;"><?php if ($subject_type[$subjectIDkey] != 3){ //for subject type 3
                                echo $gradePT;
                                } ?></td>
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
                                    echo "<td style='display: none;'></td>";
                                  }
                                  
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->ot)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->eca)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->lp)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->nb)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->se)? "<td style='display: none;'></td>" : "" );
                                  ?>
                                <td style="display: none;text-align: right;"></td>
                                <td style="display: none;text-align: right;"></td>
                              <?php } ?>
                              <td style="text-align: right;"></td>
                              <td style="text-align: right;"></td>
                              <?php 
                                echo (  ($highestInSubTD)? "<td style='text-align: right;'></td>" : "" ); 
                              ?>
                            </tr>

                            <tfoot>
                              <tr>
                              <th style="display: none;text-align: right;"></th>
                              <th style="display: none;text-align: center;">Total</th>
                              <th style="display: none;text-align: right;"><?php echo $gt; ?></th>
                              <th style="display: none;text-align: right;"><?php echo $pm; ?></th>
                              <?php 
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {
                                    echo "<th style='display: none;'></th>";
                                  }
                                  
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th  style='display: none;'></th>" : "" );
                                  ?>
                              <th style="display: none; text-align: right;"><?php echo $th; ?></th>
                              <th style="display: none; text-align: right;"><?php echo $pr; ?></th>
                              <?php } ?>
                              <th style="display: none; text-align: right;"><?php echo $go; ?></th>
                              <th style="display: none; text-align: right;"><?php 
                              
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


                                <th colspan="6">
                                  <span class="boldT" style="float: left;">GRADE POINT AVERAGE :</span><span style="float: left;"> <?php echo $gpround; ?></span>
                                  <span class="boldT">Grade :</span><span>  <?php if ($gpround>=3.6) {
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
                                ?></span>
                                <span  style="float: right;">
                                  <span class="boldT" >ATTENDANCE :</span><span > <?php echo $attendanceArray[$studentid]; ?></span>
                                </span>
                                  
                                </th>

                              </tr>
                            </tfoot>
                          </tbody>
                        </table>


                        
                        <!-- outcome Table -->
                        <!-- <h6 style="margin: 10px;"><span><b>Outcomes</b></span></h6> -->

                        <div style="display: inline-flex;width: 100%;">
                          <!-- <div style=""> -->

                            <table style="width:100%;border-top: 0" class="marks gradeRulesTable">
                              <tbody class="bodered">
                                <tr>                           
                                  <td style="text-align: center;border-top: 0" colspan="4" width="50%"><p style="font-size: 16px;padding: 10px;font-weight: bold;">GRADING / GPA SYSTEM</p></td>
                                  <td rowspan="11" width="50%" style="border-top: 0;text-align: left;vertical-align: top;position: relative;">
                                    <h3 style="text-align: center;margin-top: 25px;">REMARKS : <?php 
                                        if ($avg>=90) {
                                          echo 'Outstanding Performance';
                                        }elseif ($avg>=80) {
                                          echo 'Excellent Performance';
                                        }elseif ($avg>=70) {
                                          echo 'Very Good Performance';
                                        }elseif ($avg>=60) {
                                          echo 'Good Performance';
                                        }elseif ($avg>=50) {
                                          echo 'Above Average Performance';
                                        }elseif ($avg>=40) {
                                          echo 'Average Performance';
                                        }elseif ($avg>=20) {
                                          echo 'Below Average Performance';
                                        }elseif ($avg>=1) {
                                          echo 'Insufficient Performance';
                                        }elseif ($avg==0) {
                                          echo 'Very Insufficient Performance';
                                        }else{
                                          echo "";
                                        }
                                        ?></h3>
                                     <!-- Sign and seal -->
                                      <div style="position: absolute;bottom: 5px;width: 100%;left: 0;">
                                        <div style="display: inline-flex;margin-top: 10px; width: 100%;font-size: 11px;position: relative;text-align: center;height: 80px;">
                                          <div style="margin: auto;">
                                           <!--  <?php if (!empty($school_details->sign)){?>
                                            <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?> -->
                                            <br>________________<br>
                                            <span style=" ">CLASS TEACHER</span>
                                            
                                          </div>
                                          
                                        
                                          <div style="margin: auto;">
                                            <!-- <?php if (!empty($school_details->school_stamp)){?>
                                            <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->school_stamp; ?>" > <?php } ?> -->
                                            <br>________________<br>
                                            <span style=" ">SCHOOL'S SEAL</span>
                                            
                                          </div>
                                          <div style="margin: auto;">
                                            
                                            <?php if (!empty($school_details->sign)){?>
                                            <div style="margin-top: -18px; transform: rotate(22deg);"> 
                                            <img  class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?>
                                            </div>
                                            <br>_______________<br>
                                            <span style=" ">PRINCIPAL</span>
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </td>
                                </tr>
                                
                                <tr >
                                  <th style="text-align: center;">INTERVAL</th>
                                  <th style="text-align: center;">GRADE POINT</th>
                                  <th style="text-align: center;">GRADE</th>
                                  <th style="text-align: center;">REMARKS</th>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">90% to 100%</td>
                                  <td style="text-align: center;">4.0</td>
                                  <td style="text-align: center;">A+</td>
                                  <td style="text-align: center;">Outstanding</td>                                 
                                </tr>
                                <tr >
                                  <td style="text-align: center;">80% to Below 90%</td>
                                  <td style="text-align: center;">3.6</td>
                                  <td style="text-align: center;">A</td>
                                  <td style="text-align: center;">Excellent</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">70% to Below 80%</td>
                                  <td style="text-align: center;">3.2</td>
                                  <td style="text-align: center;">B+</td>
                                  <td style="text-align: center;">Very Good</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">60% to Below 70%</td>
                                  <td style="text-align: center;">2.8</td>
                                  <td style="text-align: center;">B</td>
                                  <td style="text-align: center;">Good</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">50% to Below 60%</td>
                                  <td style="text-align: center;">2.4</td>
                                  <td style="text-align: center;">C+</td>
                                  <td style="text-align: center;">Satisfactory</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">40% to Below 50%</td>
                                  <td style="text-align: center;">2.0</td>
                                  <td style="text-align: center;">C</td>
                                  <td style="text-align: center;">Acceptable</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">30% to Below 40%</td>
                                  <td style="text-align: center;">1.6</td>
                                  <td style="text-align: center;">D+</td>
                                  <td style="text-align: center;">Partially Acceptable</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">20% to Below 30%</td>
                                  <td style="text-align: center;">1.2</td>
                                  <td style="text-align: center;">D</td>
                                  <td style="text-align: center;">Insufficient</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">0 to Below 20%</td>
                                  <td style="text-align: center;">0.8</td>
                                  <td style="text-align: center;">E</td>
                                  <td style="text-align: center;">Very Insufficient</td>                                 
                                </tr> 
                               
                               
                              </tbody>
                            </table>
                        </div>

                        <div style="display: inline-flex;width: 100%;font-size: 15px;padding-top: 15px;">
                          <div><b>ISSUE DATE:</b></div>
                          <div style="text-align: left; margin: 0 5px;"> 
                              <?php echo $login_today_date; ?>
                          </div>
                        </div>
                       
                      </div>
                    </div>
                  <!-- </div>  -->       
                    

                    
                  
                  
                  </div>


                  <div class="page-break"></div>
                  <?php 
                } //END OF MARKSHEET FOUND ?>
                     
              <?php 
            }
          } ?>


        </div>
      </div>

    <?php 
  }else if($template == 8 && $mfound==1){ // template 7 in landscape mode for a5 and a4 full Support = a4l,a5l

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
                    size:<?php echo (($print_format == 'a5l')? 'A5 landscape' : (($print_format == 'a4l')? ' A4 landscape' : '') ); ?>;
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

                    <?php if ($print_format == 'a4l') { ?>

                      .marksTable{
                        width:100%;height:350px;
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
                      .gradeRulesTable>tbody>tr>td,.gradeRulesTable>tbody>tr>th{
                        /*padding: 5px!important;*/
                        font-size: 8px!important;
                      }
                      .schoolName{
                        margin:0px 0;
                        font-size: 12px;
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
                      

                    <?php }else if ($print_format == 'a5l') { ?>

                      .marksTable{
                        width:100%;
                        height:240px;
                      }
                      table.marks , .marks>thead>tr>th,.marks>tfoot>tr>th,.marks>tbody.bodered>tr>td {
                        border: 1px solid black;
                        border-collapse: collapse;
                        padding: 0px;
                        font-size: 10px;
                        text-align: center;
                      }
                      .marks>tbody>tr>td {
                          border-right: 1px solid black;
                          border-collapse: collapse;
                          padding: 0 4px;
                          font-size: 10px;
                          text-align: center;
                      }
                      .gradeRulesTable>tbody>tr>td,.gradeRulesTable>tbody>tr>th{
                        /*padding: 5px!important;*/
                        font-size: 8px!important;
                      }
                     .schoolName{
                        margin:0px 0;
                        font-size: 12px;
                      }
                      .examName{
                        padding: 3px;
                        font-size: 80%;
                      }
                      .marksheetUpper{
                        margin: 6px 0;
                        font-size: 80%;
                      }
                      .marksheetInner{
                        padding: 2px 10%;
                      }
                      .studentDetails{
                        width:100%;
                        text-align: left; 
                        font-size: 10px;
                        margin: 0px 0;
                      }
                      .principalSign{
                        height: 30px;
                        width: 70px;
                        margin-bottom: -20px;
                      }
                    <?php } ?>

                    .page-break {
                        page-break-after: always;
                      }
                  </style>

          <?php
          if ($studentarray){
            foreach ($studentarray as $studentid){

              // START GETTING STUDENT, CLASS, SECTION, ACADEMIC YEAR INFO
                $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`dob`
                , `marksheet`.`month` 
                , `syearhistory`.`roll_no`
                , `class`.`class_name`, `section`.`section_name`
                ,`academic_year`.`single_year` 
                
                FROM `marksheet` 

                INNER JOIN `syearhistory` ON `marksheet`.`mstudent_id` = `syearhistory`.`student_id`
                  AND `syearhistory`.`year_id` = '$year_id'

                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                
                LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 

                LEFT JOIN `class` ON `syearhistory`.`class_id` = `class`.`class_id` 
                LEFT JOIN `section` ON `syearhistory`.`section_id` = `section`.`section_id` 

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
                  
                  

                    <div style="position: relative; height:96%; padding: 16px 20px 10px 20px" class="page">

                    <!-- <div style="width:146mm; height:208mm;"> -->
                    <div style="z-index: 1; text-align:center; border: 2px solid #787878;position: relative;overflow: hidden;" class="backGreen subpage">




                      <div style="display: inline-flex;width:100%;padding: 5px 0">
                        <div style="width: 50px;height: 60px;text-align: center;margin: auto; position: absolute;">
                          <img style="height: inherit; margin: 20px 0 0 10px;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                        </div>
                        <div  style="width: inherit; text-align: center;position: relative;padding: 0 20px;margin: auto 60px; ">
                               <h3 class="schoolName" style="font-weight: bolder;text-transform: uppercase;"><?php echo $login_session_a; ?></h3>
                               <div >
                                  <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Phone : <?php echo $LOGIN_SCHOOL_PHONE_NO; ?></p>
                                  
                               </div>           
                        </div>
                        
                      </div>
                      <div style="padding: 0 10px">
                        <div style="margin: 5px auto">
                          <div style="width: 35%;background: #000;margin: auto;">
                            <h4 class="examName" style="margin: 0;color: #fff;text-transform: uppercase;"><b><?php echo $examtype_details->examtype_name; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
                              echo '&nbsp'.$rowstd["single_year"];
                             ?></b>
                            </h4>
                          </div>
                          <h4 class="marksheetUpper" ><span class="marksheetInner" style="border: 1px solid #000; "><b>ACADEMIC PROGRESS REPORT</b></span></h4>
                        </div>
                        <!-- student detail -->
                        <table class="studentDetails">
                          <tr>
                            <td colspan="2">Name : <span><b><?php echo $rowstd['sname']; ?></b></span></td>
                            <td >Roll No. : <b><?php echo $rowstd['roll_no']; ?></b></td>
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
                                  
                                  echo (  ($testMarkRow->mt)? "<th style='display: none;'>MT</th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th style='display: none;'>OT</th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th style='display: none;'>ECA</th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th style='display: none;'>LP</th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th style='display: none;'>NB</th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th style='display: none;'>SE</th>" : "" );   ?>                          
                              <th style='display: none;'>TH.</th>
                              <th style='display: none;'>PR.</th>
                              <?php } ?>

                              <th style='display: none;'>Total</th>
                              <th>Grade Point</th>
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

                                    echo "<td style='display: none;'>".${'includeMark' . $studentid}[$examinclude->added_examtype_id][$subjectIDkey]."</td>";
                                  }
                                  
                                }
                              /* ================= TEST MARK td ========================= */

                              if ($examtype_details->self_include){

                                echo (  ($testMarkRow->mt)? ((!empty(${'mMT' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mMT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" )  : "" );

                                echo (  ($testMarkRow->ot)? ((!empty(${'mOT' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mOT' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->eca)? ((!empty(${'mECA' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mECA' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->lp)? ((!empty(${'mLP' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mLP' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->nb)? ((!empty(${'mNB' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mNB' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                echo (  ($testMarkRow->se)? ((!empty(${'mSE' . $studentid}[$subjectIDkey][$examid]))? "<td style='display: none; text-align: right;'>".${'mSE' . $studentid}[$subjectIDkey][$examid]."</td>" : "<td style='display: none;'></td>" ) : "" );

                                ?>

                                <!-- ================= T.H. td ========================= -->
                                <td style="display: none; text-align: right;"> 
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
                                <td style="display: none; text-align: right;">
                                  <?php if ($subject_type[$subjectIDkey]==3){ //for subject type 3
                                        }else if(!empty(  ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]  )){
                                          $pr = $pr+${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                          echo ${'practical_mark_student' . $studentid}[$subjectIDkey][$examid]; 
                                        }else{ echo "-"; } ?>
                                </td>

                              <?php } ?>
                              <!-- ================= Total td ========================= -->
                              <td style="display: none; text-align: right;">
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
                              <td style="text-align: center;">4</td>
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
                                    echo "<td style='display: none;'></td>";
                                  }
                                  
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->ot)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->eca)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->lp)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->nb)? "<td style='display: none;'></td>" : "" );
                                  echo (  ($testMarkRow->se)? "<td style='display: none;'></td>" : "" );
                                  ?>
                                <td style="display: none;text-align: right;"></td>
                                <td style="display: none;text-align: right;"></td>
                              <?php } ?>
                              <td style="text-align: right;"></td>
                              <td style="text-align: right;"></td>
                              <?php 
                                echo (  ($highestInSubTD)? "<td style='text-align: right;'></td>" : "" ); 
                              ?>
                            </tr>

                            <tfoot>
                              <tr>
                              <th style="display: none;text-align: right;"></th>
                              <th style="display: none;text-align: center;">Total</th>
                              <th style="display: none;text-align: right;"><?php echo $gt; ?></th>
                              <th style="display: none;text-align: right;"><?php echo $pm; ?></th>
                              <?php 
                                if ($examIncluded) {
                                  foreach ($examIncludeList as $examinclude) {
                                    echo "<th style='display: none;'></th>";
                                  }
                                  
                                }

                                if ($examtype_details->self_include){

                                  echo (  ($testMarkRow->mt)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->ot)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->eca)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->lp)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->nb)? "<th  style='display: none;'></th>" : "" );
                                  echo (  ($testMarkRow->se)? "<th  style='display: none;'></th>" : "" );
                                  ?>
                              <th style="display: none; text-align: right;"><?php echo $th; ?></th>
                              <th style="display: none; text-align: right;"><?php echo $pr; ?></th>
                              <?php } ?>
                              <th style="display: none; text-align: right;"><?php echo $go; ?></th>
                              <th style="display: none; text-align: right;"><?php 
                              
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


                                <th colspan="6">
                                  <span style="float: left;">Grade Point Average : <?php echo $gpround; ?></span>
                                  <span>Grade:  <?php if ($gpround>=3.6) {
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
                                ?></span>
                                  <span style="float: right;">Attendance : <?php echo $attendanceArray[$studentid]; ?></span>
                                </th>

                              </tr>
                            </tfoot>
                          </tbody>
                        </table>


                        
                        <!-- outcome Table -->
                        <!-- <h6 style="margin: 10px;"><span><b>Outcomes</b></span></h6> -->

                        <div style="display: inline-flex;width: 100%;">
                          <!-- <div style=""> -->

                            <table style="width:100%;border-top: 0" class="marks gradeRulesTable">
                              <tbody class="bodered">
                                <tr>                           
                                  <td style="text-align: center;border-top: 0" colspan="4" width="50%"><h4>Grading/ GPA System</h4></td>
                                  <td rowspan="11" width="50%" style="border-top: 0;text-align: center;vertical-align: top;position: relative;">
                                    <h3>Remarks : <?php 
                                        if ($avg>=90) {
                                          echo 'Outstanding Performance';
                                        }elseif ($avg>=80) {
                                          echo 'Excellent Performance';
                                        }elseif ($avg>=70) {
                                          echo 'Very Good Performance';
                                        }elseif ($avg>=60) {
                                          echo 'Good Performance';
                                        }elseif ($avg>=50) {
                                          echo 'Above Average Performance';
                                        }elseif ($avg>=40) {
                                          echo 'Average Performance';
                                        }elseif ($avg>=20) {
                                          echo 'Below Average Performance';
                                        }elseif ($avg>=1) {
                                          echo 'Insufficient Performance';
                                        }elseif ($avg==0) {
                                          echo 'Very Insufficient Performance';
                                        }else{
                                          echo "";
                                        }
                                        ?></h3>
                                     <!-- Sign and seal -->
                                      <div style="position: absolute;bottom: 5px;width: 100%;left: 0;">
                                        <div style="display: inline-flex;margin-top: 10px; width: 100%;font-size: 11px;position: relative;text-align: center;">
                                          <div style="margin: auto;">
                                           <!--  <?php if (!empty($school_details->sign)){?>
                                            <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?> -->
                                            <br>_____________<br>
                                            <span style=" ">Class Teacher</span>
                                            
                                          </div>
                                          
                                        
                                          <div style="margin: auto;">
                                            <!-- <?php if (!empty($school_details->school_stamp)){?>
                                            <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->school_stamp; ?>" > <?php } ?> -->
                                            <br>_____________<br>
                                            <span style=" ">School Seal</span>
                                            
                                          </div>
                                          <div style="margin: auto;">
                                            <?php if (!empty($school_details->sign)){?>
                                            <img class="principalSign" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" > <?php } ?>
                                            <br>_____________<br>
                                            <span style=" ">Principal</span>
                                            
                                          </div>
                                        </div>
                                      </div>
                                  </td>
                                </tr>
                                
                                <tr >
                                  <th style="text-align: center;">Interval</th>
                                  <th style="text-align: center;">Grade Point</th>
                                  <th style="text-align: center;">Grade</th>
                                  <th style="text-align: center;">Remarks</th>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">90% to 100%</td>
                                  <td style="text-align: center;">4.0</td>
                                  <td style="text-align: center;">A+</td>
                                  <td style="text-align: center;">Outstanding</td>                                 
                                </tr>
                                <tr >
                                  <td style="text-align: center;">80% to Below 90%</td>
                                  <td style="text-align: center;">3.6</td>
                                  <td style="text-align: center;">A</td>
                                  <td style="text-align: center;">Excellent</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">70% to Below 80%</td>
                                  <td style="text-align: center;">3.2</td>
                                  <td style="text-align: center;">B+</td>
                                  <td style="text-align: center;">Very Good</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">60% to Below 70%</td>
                                  <td style="text-align: center;">2.8</td>
                                  <td style="text-align: center;">B</td>
                                  <td style="text-align: center;">Good</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">50% to Below 60%</td>
                                  <td style="text-align: center;">2.4</td>
                                  <td style="text-align: center;">C+</td>
                                  <td style="text-align: center;">Satisfactory</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">40% to Below 50%</td>
                                  <td style="text-align: center;">2.0</td>
                                  <td style="text-align: center;">C</td>
                                  <td style="text-align: center;">Acceptable</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">30% to Below 40%</td>
                                  <td style="text-align: center;">1.6</td>
                                  <td style="text-align: center;">D+</td>
                                  <td style="text-align: center;">Partially Acceptable</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">20% to Below 30%</td>
                                  <td style="text-align: center;">1.2</td>
                                  <td style="text-align: center;">D</td>
                                  <td style="text-align: center;">Insufficient</td>                                 
                                </tr> 
                                <tr >
                                  <td style="text-align: center;">0 to Below 20%</td>
                                  <td style="text-align: center;">0.8</td>
                                  <td style="text-align: center;">E</td>
                                  <td style="text-align: center;">Very Insufficient</td>                                 
                                </tr> 
                               
                               
                              </tbody>
                            </table>
                        </div>

                        <div style="display: inline-flex;width: 100%;font-size: 11px;">
                          <div >Issue Date:</div>
                          <div style="text-align: left; margin: 0 5px;"> 
                              <?php echo $login_today_date; ?>
                          </div>
                        </div>
                       
                      </div>
                    </div>
                  <!-- </div>  -->       
                    

                    
                  
                  
                  </div>
                  <div class="page-break"></div>
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
