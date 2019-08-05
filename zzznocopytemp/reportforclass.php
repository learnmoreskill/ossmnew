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
    $studentarray = $_POST['student'];
    $examid = $_POST['examtypeid'];
    $template = $_POST['template'];
    $mode = $_POST['mode'];
    $month_id = $_POST['m04x20'];
    $year_id = $_POST['y04x20'];

    $rankselected = $_POST['rankselected'];

    $months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra');

    if (empty($month_id)) { 
      $month_id = 0; 
    }

    if (!($examid == 5 || $examid == 6)){
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


      $queryvm1 = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`pass_mark` 
        FROM `marksheet` 
        LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
        WHERE `marksheet`.`mexam_id`='$examid'  
        AND `marksheet`.`marksheet_class`='$class_id' 
        AND `marksheet`.`month`='$month_id' 
        AND `marksheet`.`year_id`='$year_id'");
      
            $rowCount1 = $queryvm1->num_rows;
            if($rowCount1 > 0) { $mfound='1';} else{ $mfound='0';   }
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

<!-- ====================  Grade Marksheet     ==================== -->
<?php
}else if($template == 1 && $mfound==1){ ?>

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


            $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
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
                      <div style="width: 50px;height: 60px;text-align: center;margin: auto;">
                        <img style="height: inherit;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                      </div>
                      <div style="text-align: center;position: relative;padding: 0 45px;margin: auto; margin-left:-60px;">
                             <h4 style="font-weight: bolder;margin: 0;text-transform: uppercase;"><?php echo $login_session_a; ?></h4>
                             <div >
                                <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Estd: <?php echo $login_session_g; ?></p>
                                
                             </div>           
                      </div>
                      
                    </div>
                    <div style="padding: 0 10px">
                      <div style="margin: 5px auto">
                        <div style="width: 55%;background: #000;margin: auto;">
                          <h4 style="margin: 0;padding: 3px;color: #fff;text-transform: uppercase;"><b><?php echo $rowexm['examtype_name']; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
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
                          <td >Section : <span><b><?php echo $rowstd['section_name']; ?></b></span></td>
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
                            <th>TH.</th>
                            <th>PR.</th>
                            <th>Total</th>
                            <th>Grade</th>
                          </tr>
                        </thead>
                        <tbody>
                        
              
                        <?php $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0; $gp=0.0; $fail = 0; $realCount = 0;
                        while($row = $queryvm->fetch_assoc()){ ?>
                          <tr style="height: 20px">
                            <td style="text-align: right;">
                              <?php echo $sn++;
                              if($row["subject_type"]!=3){$realCount=$realCount+1; }//increement
                              ?>
                            </td>
                            <td style="text-align: left;">
                              <?php echo substr($row["subject_name"],0,25).((strlen($row["subject_name"]) > 25) ? '..':''); ?>
                            </td>
                            <!-- ================= F.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $gt=$gt+$row["total_mark"];
                                echo $row["total_mark"];
                              }
                              ?>
                            </td>
                            <!-- ================= P.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $pm = $pm+$row["pass_mark"];
                                echo $row["pass_mark"];
                              }

                              ?>
                            </td>
                            <!-- ================= T.H. td ========================= -->
                            <td style="text-align: right;"> 
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                    }else if ($row["subject_type"]==0) {
                                      if(!empty($row["m_obtained_mark"])){
                                        $th = $th+$row["m_obtained_mark"];
                                        echo $row["m_obtained_mark"];
                                        
                                        echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        
                                      }else{ echo "-"; }
                                    }else if ($row["subject_type"]==1){
                                      if(!empty($row["m_theory"])){
                                        $th = $th+$row["m_theory"];
                                        echo $row["m_theory"];

                                        echo (( is_numeric($row["m_theory"]) && (float)$row["m_theory"]<(float)$row["theory_passmark"])? '*':'');
                            
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
                            <!-- ================= Total td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                      echo $row["m_obtained_mark"];
                                    }else{
                                      if(!empty($row["m_obtained_mark"])){ 
                                        echo $row["m_obtained_mark"];
                                        if($row["subject_type"]==0){
                                          echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        }
                                      }else{ echo "-"; }
                                      $go=$go+$row["m_obtained_mark"]; 
                                      $ob=$row["m_obtained_mark"];
                                    }
                              ?>
                            </td>
                            <!-- ================= Grade td ========================= -->
                            <td style="text-align: right;">
                              <?php 
                              if ($row["subject_type"]==3){ //for subject type 3
                              }else{
                                  $tm=$row["total_mark"];
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
                                  }elseif ($avg>=20) {
                                    echo 'D';
                                    $gp = $gp+1.6;
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
                          </tr>
                          <?php // checking pass or fail in each subject
                              if($row["subject_type"]==3) {
                              }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
                              }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {
                              }else{
                                $fail = 1;
                              }
                        } ?>
            
                          <tr class="">
                            <td style="text-align: right;"></td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                          </tr>

                          <tfoot>
                            <tr>
                                <th style="text-align: right;"></th>
                            <th style="text-align: center;">Total</th>
                            <th style="text-align: right;"><?php echo $gt; ?></th>
                            <th style="text-align: right;"><?php echo $pm; ?></th>
                            <th style="text-align: right;"><?php echo $th; ?></th>
                            <th style="text-align: right;"><?php echo $pr; ?></th>
                            <th style="text-align: right;"><?php echo $go; ?></th>
                            <th style="text-align: right;"></th>
                            </tr>
                        </tfoot>
                        </tbody>
                      </table>
                      <!-- outcome Table -->
                      <table style="width:40%;" class="marks">
                         <caption style="text-align: center;color: black;"><h4 style="margin: 10px;"><b>Outcomes</b></h4></caption>
                          <tbody class="bodered">
                          <tr >
                            <td style="text-align: left;">Grade</td>
                            <td><?php 
                                  $gpround = round(($gp/$realCount),2);
                                  
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

<!-- ====================  Grade, GPA Marksheet    ==================== -->
<?php
}else if($template == 2 && $mfound==1){ ?>

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


            $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
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
                      <div style="width: 50px;height: 60px;text-align: center;margin: auto;">
                        <img style="height: inherit;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                      </div>
                      <div style="text-align: center;position: relative;padding: 0 45px;margin: auto; margin-left:-60px;">
                             <h4 style="font-weight: bolder;margin: 0;text-transform: uppercase;"><?php echo $login_session_a; ?></h4>
                             <div >
                                <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Estd: <?php echo $login_session_g; ?></p>
                                
                             </div>           
                      </div>
                      
                    </div>
                    <div style="padding: 0 10px">
                      <div style="margin: 5px auto">
                        <div style="width: 55%;background: #000;margin: auto;">
                          <h4 style="margin: 0;padding: 3px;color: #fff;text-transform: uppercase;"><b><?php echo $rowexm['examtype_name']; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
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
                            <th>TH.</th>
                            <th>PR.</th>
                            <th>Total</th>
                            <th>Grade</th>
                          </tr>
                        </thead>
                        <tbody>
                        
              
                        <?php $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0; $gp=0.0; $fail = 0; $realCount = 0;
                        while($row = $queryvm->fetch_assoc()){ ?>
                          <tr style="height: 20px">
                            <td style="text-align: right;">
                              <?php echo $sn++;
                              if($row["subject_type"]!=3){$realCount=$realCount+1;}//increement
                              ?>
                            </td>
                            <td style="text-align: left;">
                              <?php echo substr($row["subject_name"],0,25).((strlen($row["subject_name"]) > 25) ? '..':'');?>
                            </td>
                            <!-- ================= F.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $gt=$gt+$row["total_mark"];
                                echo $row["total_mark"];
                              }
                              ?>
                            </td>
                            <!-- ================= P.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $pm = $pm+$row["pass_mark"];
                                echo $row["pass_mark"];
                              }

                              ?>
                            </td>
                            <!-- ================= T.H. td ========================= -->
                            <td style="text-align: right;"> 
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                    }else if ($row["subject_type"]==0) {
                                      if(!empty($row["m_obtained_mark"])){
                                        $th = $th+$row["m_obtained_mark"];
                                        echo $row["m_obtained_mark"];
                                        
                                        echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        
                                      }else{ echo "-"; }
                                    }else if ($row["subject_type"]==1){
                                      if(!empty($row["m_theory"])){
                                        $th = $th+$row["m_theory"];
                                        echo $row["m_theory"];

                                        echo (( is_numeric($row["m_theory"]) && (float)$row["m_theory"]<(float)$row["theory_passmark"])? '*':'');
                            
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
                            <!-- ================= Total td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                      echo $row["m_obtained_mark"];
                                    }else{
                                      if(!empty($row["m_obtained_mark"])){ 
                                        echo $row["m_obtained_mark"];
                                        if($row["subject_type"]==0){
                                          echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        }
                                      }else{ echo "-"; }
                                      $go=$go+$row["m_obtained_mark"]; 
                                      $ob=$row["m_obtained_mark"];
                                    }
                              ?>
                            </td>
                            <!-- ================= Grade td ========================= -->
                            <td style="text-align: right;">
                              <?php 
                              if ($row["subject_type"]==3){ //for subject type 3
                              }else{
                                  $tm=$row["total_mark"];
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
                                  }elseif ($avg>=20) {
                                    echo 'D';
                                    $gp = $gp+1.6;
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
                          </tr>
                          <?php // checking pass or fail in each subject
                              if($row["subject_type"]==3) {
                              }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
                              }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {
                              }else{
                                $fail = 1;
                              }
                        } ?>
            
                          <tr class="">
                            <td style="text-align: right;"></td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                          </tr>

                          <tfoot>
                            <tr>
                                <th style="text-align: right;"></th>
                            <th style="text-align: center;">Total</th>
                            <th style="text-align: right;"><?php echo $gt; ?></th>
                            <th style="text-align: right;"><?php echo $pm; ?></th>
                            <th style="text-align: right;"><?php echo $th; ?></th>
                            <th style="text-align: right;"><?php echo $pr; ?></th>
                            <th style="text-align: right;"><?php echo $go; ?></th>
                            <th style="text-align: right;"><?php 
                            
                                  $gpround = round(($gp/$realCount),2);
                                  
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
                                  }elseif ($gpround>=0.8) {
                                    echo 'D';
                                  }elseif ($gpround>0) {
                                    echo 'E';
                                  }elseif ($gpround==0) {
                                    echo 'N';
                                  }else{
                                    echo "";
                                  }
                                  ?></th>
                            </tr>
                        </tfoot>
                        </tbody>
                      </table>
                      <!-- outcome Table -->
                      <table style="width:40%;" class="marks">
                         <caption style="text-align: center;color: black;"><h4 style="margin: 10px;"><b>Outcomes</b></h4></caption>
                          <tbody class="bodered">
                          <tr >
                            <td style="text-align: left;">GPA</td>
                            <td><?php 
                                  
                                  echo $gpround;
                                  
                                  ?>
                            </td>
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


<!-- ====================  Grade, GPA, Rank Marksheet     ==================== -->
<?php
}else if($template == 3 && $mfound==1){ 


    // ======================== Start Of Getting Rank ===========
      $rankArray = array(); 

      if (empty($rankselected) || $rankselected==1) {

          // ================== Find rank classwise =============
        $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
                  FROM `marksheet` 
                  INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                  WHERE `marksheet`.`mexam_id`='$examid'  
                    AND `studentinfo`.`sclass`='$class_id' 
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

              $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
                FROM `marksheet` 
                LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
                WHERE `marksheet`.`mexam_id`='$examid' 
                  AND `marksheet`.`mstudent_id`='$studentid' 
                  AND `marksheet`.`marksheet_class`='$class_id'  
                  AND `marksheet`.`month`='$month_id' 
                  AND `marksheet`.`year_id`='$year_id'
                ORDER BY `subject`.`sort_order`");
                while($row = $queryvm->fetch_assoc()){

                  if($row["subject_type"]==3) {
                  }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
      
                  }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {

                  }else{
                    $failInRank = 1;
                  }

                } // end of while loop check fail pass


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
      }else if ($rankselected==2) {

        // =========== Find rank Sectionwise ===============
        $sectionList= json_decode($backstage->get_section_list_by_class_id($class_id));

        foreach ($sectionList as $seclist) {

          $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
                FROM `marksheet` 
                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                WHERE `marksheet`.`mexam_id`='$examid'  
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

                $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
                  FROM `marksheet` 
                  LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
                  WHERE `marksheet`.`mexam_id`='$examid' 
                    AND `marksheet`.`mstudent_id`='$studentid' 
                    AND `marksheet`.`marksheet_class`='$class_id' 
                    AND `marksheet`.`marksheet_section`='$seclist->section_id' 
                    AND `marksheet`.`month`='$month_id' 
                    AND `marksheet`.`year_id`='$year_id'
                  ORDER BY `subject`.`sort_order`");
                  while($row = $queryvm->fetch_assoc()){

                    if($row["subject_type"]==3) {
                    }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
        
                    }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {

                    }else{
                      $failInRank = 1;
                    }

                  } // end of while loop check fail pass


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




    /*$queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
    FROM `marksheet` 
    WHERE `marksheet`.`mexam_id`='$examid'  
      AND `marksheet`.`marksheet_class`='$class_id' 
      AND `marksheet`.`month`='$month_id' 
      AND `marksheet`.`year_id`='$year_id'
      GROUP BY `marksheet`.`mstudent_id`
    ORDER BY `obt` DESC");*/

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
          foreach ($studentarray as $student_id){

            $studentid=$student_id;


        /*if($queryRank->num_rows > 0){
          $total_result = $queryRank->num_rows;
          
          $checkSameMark = 0;
          $rank = 0;

          while($rowRank = $queryRank->fetch_assoc()){

            $studentid=$rowRank["mstudent_id"];*/

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


            $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
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
                      <div style="width: 50px;height: 60px;text-align: center;margin: auto;">
                        <img style="height: inherit;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                      </div>
                      <div style="text-align: center;position: relative;padding: 0 45px;margin: auto; margin-left:-60px;">
                             <h4 style="font-weight: bolder;margin: 0;text-transform: uppercase;"><?php echo $login_session_a; ?></h4>
                             <div >
                                <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Estd: <?php echo $login_session_g; ?></p>
                                
                             </div>           
                      </div>
                      
                    </div>
                    <div style="padding: 0 10px">
                      <div style="margin: 5px auto">
                        <div style="width: 55%;background: #000;margin: auto;">
                          <h4 style="margin: 0;padding: 3px;color: #fff;text-transform: uppercase;"><b><?php echo $rowexm['examtype_name']; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
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
                            <th>TH.</th>
                            <th>PR.</th>
                            <th>Total</th>
                            <th>Grade</th>
                          </tr>
                        </thead>
                        <tbody>
                        
              
                        <?php $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0; $gp=0.0; $fail = 0; $realCount = 0;
                        while($row = $queryvm->fetch_assoc()){ ?>
                          <tr style="height: 20px">
                            <td style="text-align: right;">
                              <?php echo $sn++;
                              if($row["subject_type"]!=3){$realCount=$realCount+1;}//increement
                              ?>
                            </td>
                            <td style="text-align: left;">
                              <?php echo substr($row["subject_name"],0,25).((strlen($row["subject_name"]) > 25) ? '..':'');?>
                            </td>
                            <!-- ================= F.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $gt=$gt+$row["total_mark"];
                                echo $row["total_mark"];
                              }
                              ?>
                            </td>
                            <!-- ================= P.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $pm = $pm+$row["pass_mark"];
                                echo $row["pass_mark"];
                              }

                              ?>
                            </td>
                            <!-- ================= T.H. td ========================= -->
                            <td style="text-align: right;"> 
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                    }else if ($row["subject_type"]==0) {
                                      if(!empty($row["m_obtained_mark"])){
                                        $th = $th+$row["m_obtained_mark"];
                                        echo $row["m_obtained_mark"];
                                        
                                        echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        
                                      }else{ echo "-"; }
                                    }else if ($row["subject_type"]==1){
                                      if(!empty($row["m_theory"])){
                                        $th = $th+$row["m_theory"];
                                        echo $row["m_theory"];

                                        echo (( is_numeric($row["m_theory"]) && (float)$row["m_theory"]<(float)$row["theory_passmark"])? '*':'');
                            
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
                            <!-- ================= Total td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                      echo $row["m_obtained_mark"];
                                    }else{
                                      if(!empty($row["m_obtained_mark"])){ 
                                        echo $row["m_obtained_mark"];
                                        if($row["subject_type"]==0){
                                          echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        }
                                      }else{ echo "-"; }
                                      $go=$go+$row["m_obtained_mark"]; 
                                      $ob=$row["m_obtained_mark"];
                                    }
                              ?>
                            </td>
                            <!-- ================= Grade td ========================= -->
                            <td style="text-align: right;">
                              <?php 
                              if ($row["subject_type"]==3){ //for subject type 3
                              }else{
                                  $tm=$row["total_mark"];
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
                                  }elseif ($avg>=20) {
                                    echo 'D';
                                    $gp = $gp+1.6;
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
                          </tr>
                          <?php // checking pass or fail in each subject
                              if($row["subject_type"]==3) {
                              }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
                              }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {
                              }else{
                                $fail = 1;
                              }
                        } ?>
            
                          <tr class="">
                            <td style="text-align: right;"></td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                          </tr>

                          <tfoot>
                            <tr>
                                <th style="text-align: right;"></th>
                            <th style="text-align: center;">Total</th>
                            <th style="text-align: right;"><?php echo $gt; ?></th>
                            <th style="text-align: right;"><?php echo $pm; ?></th>
                            <th style="text-align: right;"><?php echo $th; ?></th>
                            <th style="text-align: right;"><?php echo $pr; ?></th>
                            <th style="text-align: right;"><?php echo $go; ?></th>
                            <th style="text-align: right;"><?php 
                            
                                  $gpround = round(($gp/$realCount),2);
                                  
                                  /*if ($gpround>=3.6) {
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
                                  }elseif ($gpround>=0.8) {
                                    echo 'D';
                                  }elseif ($gpround>0) {
                                    echo 'E';
                                  }elseif ($gpround==0) {
                                    echo 'N';
                                  }else{
                                    echo "";
                                  }*/
                                  ?></th>
                            </tr>
                        </tfoot>
                        </tbody>
                      </table>
                      <!-- outcome Table -->
                      <table style="width:100%;" class="marks">
                         <caption style="text-align: center;color: black;"><h4 style="margin: 10px;"><b>Outcomes</b></h4></caption>
                          <tbody class="bodered">
                          <tr >
                            <td style="text-align: left;">GPA</td>
                            <td><?php 
                                  
                                  echo $gpround;
                                  
                                  ?>
                            </td>
                            <td style="text-align: left;">Result</td>
                            <td>
                              <?php if($fail == 1){ echo "Fail"; }else{
                                      echo "Pass";
                                    } 
                              ?>
                            </td>   
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
                            <td style="text-align: left;">Rank</td>
                            <td>
                              <?php if($fail != 1){

                                      echo $rankArray[$studentid];
                                      
                                    }else{ 
                                      echo "--"; 
                                    } ?>
                            </td>     
                          </tr>
                          <tr >
                            <td style="text-align: left;">Attendance</td>
                            <td></td>     
                          </tr>
                          
                        </tbody>
                      </table>
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


<!-- ====================  Grade, GPA, Rank, HS Marksheet     ==================== -->
<?php
}else if($template == 4 && $mfound==1){ 


    // ======================== Start Of Getting Rank ===========
      $rankArray = array(); 

      if (empty($rankselected) || $rankselected==1) {

          // ================== Find rank classwise =============
        $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
                  FROM `marksheet` 
                  INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                  WHERE `marksheet`.`mexam_id`='$examid'  
                    AND `studentinfo`.`sclass`='$class_id' 
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

              $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
                FROM `marksheet` 
                LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
                WHERE `marksheet`.`mexam_id`='$examid' 
                  AND `marksheet`.`mstudent_id`='$studentid' 
                  AND `marksheet`.`marksheet_class`='$class_id'  
                  AND `marksheet`.`month`='$month_id' 
                  AND `marksheet`.`year_id`='$year_id'
                ORDER BY `subject`.`sort_order`");
                while($row = $queryvm->fetch_assoc()){

                  if($row["subject_type"]==3) {
                  }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
      
                  }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {

                  }else{
                    $failInRank = 1;
                  }

                } // end of while loop check fail pass


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
      }else if ($rankselected==2) {

        // =========== Find rank Sectionwise ===============
        $sectionList= json_decode($backstage->get_section_list_by_class_id($class_id));

        foreach ($sectionList as $seclist) {

          $queryRank = $db->query("SELECT `marksheet`.`mstudent_id`, SUM(`marksheet`.`m_obtained_mark`) AS `obt`
                FROM `marksheet` 
                INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
                WHERE `marksheet`.`mexam_id`='$examid'  
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

                $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
                  FROM `marksheet` 
                  LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
                  WHERE `marksheet`.`mexam_id`='$examid' 
                    AND `marksheet`.`mstudent_id`='$studentid' 
                    AND `marksheet`.`marksheet_class`='$class_id' 
                    AND `marksheet`.`marksheet_section`='$seclist->section_id' 
                    AND `marksheet`.`month`='$month_id' 
                    AND `marksheet`.`year_id`='$year_id'
                  ORDER BY `subject`.`sort_order`");
                  while($row = $queryvm->fetch_assoc()){

                    if($row["subject_type"]==3) {
                    }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
        
                    }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {

                    }else{
                      $failInRank = 1;
                    }

                  } // end of while loop check fail pass


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

      
    // ======================== Start Of Getting Highest in subject ===========
      $highestSub = array(); 

      $queryHS = $db->query("SELECT `marksheet`.`msubject_id`, MAX(CONVERT(`marksheet`.`m_obtained_mark`,UNSIGNED)) AS `msub`
              FROM `marksheet` 
              INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
              WHERE `marksheet`.`mexam_id`='$examid'  
                AND `marksheet`.`marksheet_class`='$class_id' 
                AND `marksheet`.`month`='$month_id' 
                AND `marksheet`.`year_id`='$year_id'
                AND `studentinfo`.`status`= 0
                GROUP BY `marksheet`.`msubject_id`");

        while($rowHS = $queryHS->fetch_assoc()){

          $highestSub[$rowHS["msubject_id"]] = $rowHS["msub"];

        }

      // ======================== End Of Getting Highest in subject ===========




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


            $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`,`marksheet`.`msubject_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`theory_passmark`,`subject`.`pass_mark`,`subject`.`subject_type` 
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
                      <div style="width: 50px;height: 60px;text-align: center;margin: auto;">
                        <img style="height: inherit;" src="<?php echo "../uploads/".$fianlsubdomain."/logo/".$login_session_d; ?>">
                      </div>
                      <div style="text-align: center;position: relative;padding: 0 120px;margin: auto; margin-left:-60px;">
                             <h4 style="font-weight: bolder;margin: 0;text-transform: uppercase;"><?php echo $login_session_a; ?></h4>
                             <div >
                                <p style="margin: 0;font-size: 11px;font-family: happyEnding"> <?php echo $login_session_c; ?><br>Estd: <?php echo $login_session_g; ?></p>
                                
                             </div>           
                      </div>
                      
                    </div>
                    <div style="padding: 0 10px">
                      <div style="margin: 5px auto">
                        <div style="width: 55%;background: #000;margin: auto;">
                          <h4 style="margin: 0;padding: 3px;color: #fff;text-transform: uppercase;"><b><?php echo $rowexm['examtype_name']; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } 
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
                            <th>TH.</th>
                            <th>PR.</th>
                            <th>Total</th>
                            <th>Grade</th>
                            <th style="font-size: 9px">Highest<br>in subject</th>
                          </tr>
                        </thead>
                        <tbody>
                        
              
                        <?php $sn=1; $gt=0; $pm=0; $th=0; $pr=0; $go=0; $gp=0.0; $fail = 0; $realCount = 0;
                        while($row = $queryvm->fetch_assoc()){ ?>
                          <tr style="height: 20px">
                            <td style="text-align: right;">
                              <?php echo $sn++;
                              if($row["subject_type"]!=3){$realCount=$realCount+1;}//increement
                              ?>
                            </td>
                            <td style="text-align: left;">
                              <?php echo substr($row["subject_name"],0,25).((strlen($row["subject_name"]) > 25) ? '..':'');?>
                            </td>
                            <!-- ================= F.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $gt=$gt+$row["total_mark"];
                                echo $row["total_mark"];
                              }
                              ?>
                            </td>
                            <!-- ================= P.M. td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                              }else{ 
                                $pm = $pm+$row["pass_mark"];
                                echo $row["pass_mark"];
                              }

                              ?>
                            </td>
                            <!-- ================= T.H. td ========================= -->
                            <td style="text-align: right;"> 
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                    }else if ($row["subject_type"]==0) {
                                      if(!empty($row["m_obtained_mark"])){
                                        $th = $th+$row["m_obtained_mark"];
                                        echo $row["m_obtained_mark"];
                                        
                                        echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        
                                      }else{ echo "-"; }
                                    }else if ($row["subject_type"]==1){
                                      if(!empty($row["m_theory"])){
                                        $th = $th+$row["m_theory"];
                                        echo $row["m_theory"];

                                        echo (( is_numeric($row["m_theory"]) && (float)$row["m_theory"]<(float)$row["theory_passmark"])? '*':'');
                            
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
                            <!-- ================= Total td ========================= -->
                            <td style="text-align: right;">
                              <?php if ($row["subject_type"]==3){ //for subject type 3
                                      echo $row["m_obtained_mark"];
                                    }else{
                                      if(!empty($row["m_obtained_mark"])){ 
                                        echo $row["m_obtained_mark"];
                                        if($row["subject_type"]==0){
                                          echo (( is_numeric($row["m_obtained_mark"]) && (float)$row["m_obtained_mark"]<(float)$row["pass_mark"])? '*':'');
                                        }
                                      }else{ echo "-"; }
                                      $go=$go+$row["m_obtained_mark"]; 
                                      $ob=$row["m_obtained_mark"];
                                    }
                              ?>
                            </td>
                            <!-- ================= Grade td ========================= -->
                            <td style="text-align: right;">
                              <?php 
                              if ($row["subject_type"]==3){ //for subject type 3
                              }else{
                                  $tm=$row["total_mark"];
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
                                  }elseif ($avg>=20) {
                                    echo 'D';
                                    $gp = $gp+1.6;
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
                            <td style="text-align: right;">
                              <?php 
                              if ($row["subject_type"]==3){ //for subject type 3
                              }else{
                                  echo $highestSub[$row["msubject_id"]];
                              } ?>
                            </td>
                          </tr>
                          <?php // checking pass or fail in each subject
                              if($row["subject_type"]==3) {
                              }else if($row["subject_type"]==0 && (float)$row["m_obtained_mark"] >= (float)$row["pass_mark"]) {
                              }else if($row["subject_type"]==1 && (float)$row["m_theory"] >= (float)$row["theory_passmark"]) {
                              }else{
                                $fail = 1;
                              }
                        } ?>
            
                          <tr class="">
                            <td style="text-align: right;"></td>
                            <td style="text-align: left;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                            <td style="text-align: right;"></td>
                          </tr>

                          <tfoot>
                            <tr>
                                <th style="text-align: right;"></th>
                            <th style="text-align: center;">Total</th>
                            <th style="text-align: right;"><?php echo $gt; ?></th>
                            <th style="text-align: right;"><?php echo $pm; ?></th>
                            <th style="text-align: right;"><?php echo $th; ?></th>
                            <th style="text-align: right;"><?php echo $pr; ?></th>
                            <th style="text-align: right;"><?php echo $go; ?></th>
                            <th style="text-align: right;"><?php 
                            
                                  $gpround = round(($gp/$realCount),2);
                                  
                                  /*if ($gpround>=3.6) {
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
                                  }elseif ($gpround>=0.8) {
                                    echo 'D';
                                  }elseif ($gpround>0) {
                                    echo 'E';
                                  }elseif ($gpround==0) {
                                    echo 'N';
                                  }else{
                                    echo "";
                                  }*/
                                  ?></th>
                            <th style="text-align: right;"></th>
                            </tr>
                        </tfoot>
                        </tbody>
                      </table>
                      <!-- outcome Table -->
                      <table style="width:100%;" class="marks">
                         <caption style="text-align: center;color: black;"><h4 style="margin: 10px;"><b>Outcomes</b></h4></caption>
                          <tbody class="bodered">
                          <tr >
                            <td style="text-align: left;">GPA</td>
                            <td><?php 
                                  
                                  echo $gpround;
                                  
                                  ?>
                            </td>
                            <td style="text-align: left;">Result</td>
                            <td>
                              <?php if($fail == 1){ echo "Fail"; }else{
                                      echo "Pass";
                                    } 
                              ?>
                            </td>   
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
                            <td style="text-align: left;">Rank</td>
                            <td>
                              <?php if($fail != 1){

                                      echo $rankArray[$studentid];
                                      
                                    }else{ 
                                      echo "--"; 
                                    } ?>
                            </td>     
                          </tr>
                          <tr >
                            <td style="text-align: left;">Attendance</td>
                            <td></td>     
                          </tr>
                          
                        </tbody>
                      </table>
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
                        <div style="position: absolute;bottom: 10px;right: 28px;">
                          <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 150px;width: 240px;margin-bottom: -57px;margin-right: -62px;"><br>
                        </div>
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
