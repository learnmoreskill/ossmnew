  <?php
  error_reporting( ~E_NOTICE ); // avoid notice
  require_once '../../config/config.php';
  //include('../session.php');
 if (isset($_GET["token"])){
      $longid1 = ($_GET["token"]);

    if ($longid1=="3tyudg") {

      $studentid = $_GET["sid"];
      $classname = $_GET["cname"];
      $examid = $_GET["eid"];

    $sqlstd = "SELECT * FROM `studentinfo` WHERE `sid`='$studentid'";
    $resultstd = $db->query($sqlstd);
    $rowstd = $resultstd->fetch_assoc();

    $sqlexm = "SELECT * FROM `examtype` WHERE `examtype_id`='$examid'";
    $resultexm = $db->query($sqlexm);
    $rowexm = $resultexm->fetch_assoc();


      $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`total_mark`, `marksheet`.`pass_mark`,`marksheet`.`obtained_mark`, `subject`.`subject_name`  FROM `marksheet` LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` WHERE `marksheet`.`mexam_id`='$examid' AND `marksheet`.`mstudent_id`='$studentid' AND `marksheet`.`marksheet_class`='$classname'");
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
        <table width="100%" border="0">
            <tbody><tr>
                <td align="center">
                  <tr align="center">
                    <!-- <td width="100px"><img src="../../images/dope.png" width="100px" height="100px"></td> -->
                    <td width="100px"><img src="http://www.mountcarmel.edu.in/wp-content/uploads/2015/03/mount-carmel-logo.png" width="100px" height="100px"></td>
                    <td>
                      <h3>Balmiki Education Foundation</h3></span>
                    <h5>Santinagar,Kathmandu,Nepal</h5>
                    </td>
                  </tr>
                    
                </td>
            </tr>
        </tbody></table>
        <hr><?php
if ($found == '1') {
    
    ?>
        <table width="100%" border="0">    
            <tbody>
            <tr>
                <td align="left" valign="top">
                    Student Name: <?php echo $rowstd['sname']; ?><br>
                    Class : <?php echo $rowstd['sclass']; ?> Section : <?php echo $rowstd['ssec'];?> <br>
                    Roll no : <?php echo $rowstd['sroll']; ?><br>
                </td>
                <td align="right" valign="top">
                    Admission Number: <?php echo $rowstd['sadmsnno']; ?><br>
                    Date Of Birth : <?php echo $rowstd['dob']; ?>
                </td>

            </tr>

                
        </tbody></table>

      <!-- payment history -->
        <center><h4><?php echo $rowexm['examtype_name']; ?></h4></center>
        <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
            <thead>
                <tr>
                    <th width="10%">S.No</th>
                    <th width="25%">Subject Name</th>
                    <th width="15%">Full Mark</th>
                    <th width="15%">Pass Mark</th>
                    <th width="15%">Obtained Mark</th>
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
                                              <?php $gt=$gt+$row["total_mark"];
                                              echo $row["total_mark"];?>
                                          </td>
                                          <td>
                                              <?php echo $row["pass_mark"];?>
                                          </td>
                                          <td>
                                              <?php $go=$go+$row["obtained_mark"];
                                               echo $row["obtained_mark"];?>
                                          </td>
                                          <td>
                                              <?php 
                                              $tm=$row["total_mark"];
                                              $ob=$row["obtained_mark"];
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
