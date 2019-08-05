<?php include_once("../printer/printheader.php");?>
  <?php
  error_reporting( ~E_NOTICE ); // avoid notice
  //require_once '../config/config.php';
  include('session.php');
 if (isset($_GET["token"])){
      $longid1 = ($_GET["token"]);

    if ($longid1=="3tyudg") {

      $studentid = $_GET["sid"];
      $class_id = $_GET["class_id"];
      $examid = $_GET["eid"];
      $month = $_GET["month"];

      $months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra'); 

    $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `studentinfo`.`sroll`, `studentinfo`.`dob`, `marksheet`.`month` , `class`.`class_name`, `section`.`section_name`  
      FROM `marksheet` 
      INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid` 
      LEFT JOIN `class` ON `marksheet`.`marksheet_class` = `class`.`class_id` 
      LEFT JOIN `section` ON `marksheet`.`marksheet_section` = `section`.`section_id` 
      WHERE `marksheet`.`mexam_id`='$examid' 
        AND `marksheet`.`mstudent_id`='$studentid' 
        AND `marksheet`.`marksheet_class`='$class_id' 
        AND `marksheet`.`month`='$month' 
      GROUP BY `marksheet`.`mstudent_id`";
    $resultstd = $db->query($sqlstd);
    $rowstd = $resultstd->fetch_assoc();



    $sqlexm = "SELECT * FROM `examtype` WHERE `examtype_id`='$examid'";
    $resultexm = $db->query($sqlexm);
    $rowexm = $resultexm->fetch_assoc();


      $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`pass_mark` 
        FROM `marksheet` 
        LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
        WHERE `marksheet`.`mexam_id`='$examid' 
          AND `marksheet`.`mstudent_id`='$studentid' 
          AND `marksheet`.`marksheet_class`='$class_id' 
          AND `marksheet`.`month`='$month'
        ORDER BY `subject`.`sort_order`");
        $rowCount = $queryvm->num_rows;
        if($rowCount > 0) { $found='1';} else{ $found='0';   }

    }
  }

?>
<div class="container">
<div class="col-md-12" align="right">
  <input type='button' id='btn' value='Print' onclick='printDiv();'>
</div>
        
  <div id="invoice_print">

    <?php include_once("../printer/printschlheader.php");?>

<?php if ($found == '1') { ?>
        <table width="100%" border="0">
            <tbody>
            <tr>
                <td align="left" valign="top">
                    Student Name: <?php echo $rowstd['sname']; ?><br>
                    Class : <?php echo $rowstd['class_name']; ?>, Section : <?php echo $rowstd['section_name'];?> <br>
                    Roll no : <?php echo $rowstd['sroll']; ?><br>
                </td>
                <td align="right" valign="top">
                    Admission Number: <?php echo $rowstd['sadmsnno']; ?><br>
                    Date Of Birth : <?php echo (($login_date_type==2)? eToN($rowstd['dob']) : $rowstd['dob']); ?>
                </td>

            </tr>

                
        </tbody></table>

      <!-- payment history -->
        <center><h4><?php echo $rowexm['examtype_name']; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; } ?></h4></center>
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
              <?php $sn=1; $gt=0; $go=0; while($row = $queryvm->fetch_assoc()){ ?>
                                      <tr>
                                          <td>
                                              <?php echo $sn++;?>
                                          </td>
                                          <td>
                                              <?php echo $row["subject_name"];?>
                                          </td>
                                          <td>
                                              <?php $t_mark=$row["total_mark"];
                                               $gt=$gt+$t_mark;
                                              echo $t_mark;?>
                                          </td>
                                          <td>
                                              <?php echo $row["pass_mark"];?>
                                          </td>
                                          <td>
                                              <?php if(!empty($row["m_theory"])){echo $row["m_theory"];}else{ echo "-"; } ?>
                                          </td>
                                          <td>
                                              <?php if(!empty($row["m_practical"])){echo $row["m_practical"];}else{ echo "-"; } ?>
                                          </td>
                                          <td>
                                              <?php if(!empty($row["m_obtained_mark"])){echo $row["m_obtained_mark"];}else{ echo "-"; }

                                                $go=$go+$row["m_obtained_mark"]; $ob=$row["m_obtained_mark"];
                                               ?>
                                          </td>
                                          <td>
                                              <?php 
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
                                              ?><br><br></strong>
          <!-- <strong align="left">Attendance :<br><br></strong> -->
          <P>
             <span style="float:left;"><u>_______________________</u><br>Class Teacher Signature</span>
             <span  style="float:right;"><u>_______________________</u><br>Principal Signature</span></span>​
          </P><br><br>
        
       
 <?php
   
}else{

    ?>

    <tr> 

        <div class="alert alert-warning" role="alert">
 <span><?php echo "There are no records available for";?></span><span><h4><?php echo $sname; ?></h4></span>
</div>

    </tr>
    <?php
   }

?>

  </div>
</div>
<?php include_once("../printer/printfooter.php");?>
