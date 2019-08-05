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


    if ($template == 999) {
      
      $template = 999;

    }else if ($template == 1) {

      $template = 5;

      $highestInSubTD=false;
      $gradeTDUpper = false;
      $gpaTD = false;
      $gradeTD = true;
      $resultTD = false;
      $rankTD = false;
    }else if ($template == 2) {

      $template = 5;

      $highestInSubTD = false;
      $gradeTDUpper = true;
      $gpaTD = true;
      $gradeTD = false;
      $resultTD = false;
      $rankTD = false;
    }else if ($template == 3) {

      $template = 5;

      $highestInSubTD = false;
      $gradeTDUpper = false;
      $gpaTD = true;
      $gradeTD = false;
      $resultTD = true;
      $rankTD = true;
    }else if ($template == 4) {

      $template = 5;

      $highestInSubTD = true;
      $gradeTDUpper = false;
      $gpaTD = true;
      $gradeTD = true;
      $resultTD = true;
      $rankTD = true;

    }else if ($template == 5) {

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


            if ($examIncluded) {

              foreach ($examIncludeList as $examinclude) {

                ${'includeMark' . $examinclude->added_examtype_id} = array();

                $queryincmark = $db->query("SELECT `subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

                ,`marksheet`.`marksheet_id`, `marksheet`.`m_obtained_mark`,`marksheet`.`marksheet_status`

                FROM `subject`

                INNER JOIN `marksheet` ON `subject`.`subject_id` = `marksheet`.`msubject_id`
                            AND `marksheet`.`mstudent_id`='$studentid'
                            AND `marksheet`.`mexam_id`='$examinclude->added_examtype_id'
                            AND `marksheet`.`marksheet_class`='$class_id'
                            AND `marksheet`.`month`='$month_id'
                            AND `marksheet`.`year_id`='$year_id'

                WHERE `subject`.`subject_class` = '$class_id'
                            AND `subject`.`year_id` = '$year_id'
                            AND `subject`.`status` = 0 
                ORDER BY `subject`.`sort_order` ");

                while($rowincmark = $queryincmark->fetch_assoc()){

                  ${'includeMark' . $examinclude->added_examtype_id}[$rowincmark["subject_id"]] = (($rowincmark["subject_type"]==3)?$rowincmark["m_obtained_mark"] : ($rowincmark["m_obtained_mark"]*$examinclude->percent)/100 );

                }
              }
              
            }


            $queryvm = $db->query("SELECT `subject`.`subject_id`, `subject`.`subject_name`,`subject`.`subject_type`

              ,`subject_mark`.`th_fm`, `subject_mark`.`th_pm`,`subject_mark`.`pr_fm`, `subject_mark`.`pr_pm`

              ,`subject_mark`.`mt`, `subject_mark`.`ot`,`subject_mark`.`eca`, `subject_mark`.`lp`,`subject_mark`.`nb`, `subject_mark`.`se`

              ,`marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_mt`, `marksheet`.`m_ot`, `marksheet`.`m_eca`, `marksheet`.`m_lp`, `marksheet`.`m_nb`, `marksheet`.`m_se`, `marksheet`.`m_obtained_mark`,`marksheet`.`marksheet_status`

              FROM `subject`

              LEFT JOIN `subject_mark` ON `subject`.`subject_id` = `subject_mark`.`subject_id`
                            AND  `subject_mark`.`examtype_id` = '$examid'
                            AND `subject_mark`.`year_id` = '$year_id'

              INNER JOIN `marksheet` ON `subject`.`subject_id` = `marksheet`.`msubject_id`
                          AND `marksheet`.`mstudent_id`='$studentid'
                          AND (`marksheet`.`mexam_id`='$examid' ".$addedExamTemp."  )
                          AND `marksheet`.`marksheet_class`='$class_id'
                          AND `marksheet`.`month`='$month_id'
                          AND `marksheet`.`year_id`='$year_id'

              WHERE `subject`.`subject_class` = '$class_id'
                          AND `subject`.`year_id` = '$year_id'
                          AND `subject`.`status` = 0 
              GROUP BY `subject`.`subject_id`
              ORDER BY `subject`.`sort_order` ");

              $rowCount = $queryvm->num_rows;
              if($rowCount > 0) { $found='1'; } else{ $found='0';   } ?>
          

              <?php 
              if ($found == '1') { ?>
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
                        mysqli_data_seek($queryvm, 0);
                        while($row = $queryvm->fetch_assoc()){ 
                          $ob=0.0;




                          ?>
                          <tr style="height: 20px">
                            <td style="text-align: right;">
                              <?php echo $sn++;
                              if($row["subject_type"]!=3){$realCount=$realCount+1;}//increement
                              ?>
                            </td>
                            <td style="text-align: left;">
                              <?php echo substr($row["subject_name"],0,25).((strlen($row["subject_name"]) > 25) ? '..':'');?>
                            </td>
                            <!-- ================= FULL MARK td ========================= -->
                            <td style="text-align: right;">
                              <?php if($row["subject_type"]==1){ 
                                $gt=$gt+($row["th_fm"]+$row["pr_fm"]);
                                echo ($row["th_fm"]+$row["pr_fm"]);
                              }else if($row["subject_type"]==0){ 
                                $gt=$gt+$row["th_fm"];
                                echo $row["th_fm"];
                              }else{
                              }
                              ?>
                            </td>
                            <!-- ================= PASS MARK td ========================= -->
                            <td style="text-align: right;">
                              <?php if($row["subject_type"]==1){ 
                                $pm=$pm+($row["th_pm"]+$row["pr_pm"]);
                                echo ($row["th_pm"]+$row["pr_pm"]);
                              }else if($row["subject_type"]==0){ 
                                $pm=$pm+$row["th_pm"];
                                echo $row["th_pm"];
                              }else{
                              }

                              ?>
                            </td>
                            <?php

                              if ($examIncluded) {
                                foreach ($examIncludeList as $examinclude) {

                                  $ob +=${'includeMark' . $examinclude->added_examtype_id}[$row["subject_id"]];

                                  echo "<td>".${'includeMark' . $examinclude->added_examtype_id}[$row["subject_id"]]."</td>";
                                }
                                
                              }

                            if ($examtype_details->self_include){

                              echo (  ($testMarkRow->mt)? ((!empty($row["m_mt"]))? "<td style='text-align: right;'>".$row["m_mt"]."</td>" : "<td></td>" )  : "" );

                              echo (  ($testMarkRow->ot)? ((!empty($row["m_ot"]))? "<td style='text-align: right;'>".$row["m_ot"]."</td>" : "<td></td>" ) : "" );

                              echo (  ($testMarkRow->eca)? ((!empty($row["m_eca"]))? "<td style='text-align: right;'>".$row["m_eca"]."</td>" : "<td></td>" ) : "" );

                              echo (  ($testMarkRow->lp)? ((!empty($row["m_lp"]))? "<td style='text-align: right;'>".$row["m_lp"]."</td>" : "<td></td>" ) : "" );

                              echo (  ($testMarkRow->nb)? ((!empty($row["m_nb"]))? "<td style='text-align: right;'>".$row["m_nb"]."</td>" : "<td></td>" ) : "" );

                              echo (  ($testMarkRow->se)? ((!empty($row["m_se"]))? "<td style='text-align: right;'>".$row["m_se"]."</td>" : "<td></td>" ) : "" );

                              ?>

                              <!-- ================= T.H. td ========================= -->
                              <td style="text-align: right;"> 
                                <?php if ($row["subject_type"]==3){ //for subject type 3
                                      }else if ($row["subject_type"]==0) {
                                        if(!empty($row["m_theory"])){
                                          $th = $th+$row["m_theory"];
                                          echo $row["m_theory"];
                                          
                                          if (!$examIncluded) {
                                            echo (( is_numeric($row["m_theory"]) && (float)$row["m_theory"]<(float)$row["th_pm"])? '*':'');
                                          }
                                          
                                        }else{ echo "-"; }
                                      }else if ($row["subject_type"]==1){
                                        if(!empty($row["m_theory"])){
                                          $th = $th+$row["m_theory"];
                                          echo $row["m_theory"];

                                          if (!$examIncluded) {
                                            echo (( is_numeric($row["m_theory"]) && (float)$row["m_theory"]<(float)$row["th_pm"])? '*':'');
                                          }
                              
                                        }else{ echo "-"; }

                                      }
                                       ?>

                              </td>
                              <!-- ================= P.R. td ========================= -->
                              <td style="text-align: right;">
                                <?php if ($row["subject_type"]==3){ //for subject type 3
                                      }else if(!empty($row["m_practical"])){
                                        $pr = $pr+$row["m_practical"]; 
                                        echo $row["m_practical"]; 
                                      }else{ echo "-"; } ?>
                              </td>

                            <?php } ?>
                            <!-- ================= Total td ========================= -->
                            <td style="text-align: right;">
                              <?php 

                              if ($examtype_details->self_include){
                                // GET TOTAL FOR EACH SUBJECT
                                $ob +=$row["m_obtained_mark"];
                              }

                              $go=$go+$ob; 


                              if ($row["subject_type"]==3){ //for subject type 3
                                if ($examtype_details->self_include){
                                  echo $row["m_theory"];
                                }
                              }else{

                                if(!empty($ob)){

                                  echo $ob;

                                }else{ echo "-"; }

                                if ($examIncluded) {
                                  echo (( is_numeric($ob) && (float)$ob<(float)($row["th_pm"]+$row["pr_pm"]))? '*':'');
                                }

                                
                                
                              }
                              ?>
                            </td>
                            <!-- ================= Grade td ========================= -->
                            <td style="text-align: center;">
                              <?php 
                              if ($row["subject_type"]==3){ //for subject type 3
                              }else{

                                if($row["subject_type"]==1){ 
                                  $tm=$row["th_fm"]+$row["pr_fm"];
                                }else if($row["subject_type"]==0){
                                  $tm=$row["th_fm"];
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
                                if ($row["subject_type"]==3){ //for subject type 3
                                }else{
                                  //  echo $sHighest[$row["subject_id"]]['1']+$highestSub[$row["subject_id"]]['2'];
                                    echo $sHighest[$row["subject_id"]];
                                } ?>
                              </td>
                            <?php } ?>
                          </tr>
                          <?php 
                          //checking fail pass in each subject

                          //IF EXAM INCLUDED THEN PASS FAIL EVALUATED BY TOTAL OBTAINED IN EACH SUBJECT
                          if ($examIncluded) {

                              if($row["subject_type"]==3) {
                              }else if($row["subject_type"]==0 && (float)$ob >= (float)($row["th_pm"])) {
                              }else if($row["subject_type"]==1 && (float)$ob >= (float)($row["th_pm"]+$row["pr_pm"])) {
                              }
                              else{
                                $fail = 1;
                              }
                          //IF EXAM NOT INCLUDED THEN PASS FAIL EVALUATED BY THEORY IN EACH SUBJECT
                          }else{

                            if($row["subject_type"]==0 && (float)$row["m_theory"] >= (float)$row["th_pm"]) {
                              }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["th_pm"]) {
                              }else if($row["subject_type"]==3) {
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
                                  <?php if($fail != 1){

                                          echo $rankArray[$studentid];
                                          
                                        }else{ 
                                          echo "--"; 
                                        } ?>
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
              }else{} ?>
                   
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
