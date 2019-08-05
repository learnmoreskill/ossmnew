<?php
include("session.php");
require("../important/backstage.php");

$backstage = new back_stage_class();


$newdate = $login_today_edate;
//date('Y', strtotime('2010-06-15'))

$type='code128';
$orientation='horizontal';
$size='30';
$print='false';

$nepali_conversion = $cal['year']+1 . '/' . $cal['month'] . '/' . $cal['date'];
  

  error_reporting( ~E_NOTICE ); // avoid notice
  
 if( isset( $_POST['generate_multiple_idcard'] ) )
{
    $studentarray = $_POST['studentmultiple'];

}else if( isset( $_POST['generate_all_idcard'] ) )
{
    $studentarray = $_POST['studentall'];

}else if( isset( $_POST['generate_single_idcard'] ) )
{
    $studentarray = $_POST['studentsingle'];

}else{
  ?> <script> alert('Invalid request'); window.close(); </script> <?php
  exit();
}

    if (empty($studentarray)) { 
      ?> <script> alert('Student list is empty'); window.close(); </script> <?php 
      exit();
    }
    $school_details = json_decode($backstage->get_school_details_by_id());

    $idtemplate = $_POST['idtemplate'];



?>

<!-- =====================  Default Id Card     ==================== -->
<?php
if($idtemplate == 99){ ?>

  <div class="col-md-12" align="right" onclick='printDiv();' style="width: 40px;height: 40px;background: red;position: fixed; bottom: 20px;right: 40px;border-radius: 50%;padding: 10px">
      <img src="../images/printIcon.png" style="width: 90%;height: 90%;">
  </div>

  <div class="container">
    <div id="invoice_print">
    <style type="text/css" media="print">
          @media print {
            body {-webkit-print-color-adjust: exact;}
          }
          @page {
              size:A4 portrait;
              -webkit-print-color-adjust: exact;
              color-adjust: exact;
              -webkit-filter:opacity(1);
          }
      </style>
      <?php
      foreach ($studentarray as $student_id) 
            {
              $student_details = json_decode($backstage->get_student_full_details_by_sid($student_id));
              $string = $student_details->sadmsnno;

            ?>

            <div style="position: relative; border: 1px solid #a8adac; border-radius: 4px; width:2.125in; height:3.375in;float:left; margin-left: 20px;margin-bottom:22px;">
          <!-- <div style="position: relative; border: 1px solid #a8adac; border-radius: 4px; width:30%; float:left; margin-left: 20px;margin-bottom:6px;height:33%;"> -->
          <!-- width:2.125in; height:3.375in; -->
          <div style="height: inherit;position: relative;">
            <!-- school header -->
            <div style="height: 30%;background-color: rgb(42,59,77)">
              <div style="    width: 25%;
                  height: inherit;
                  /* float: left; */
                  display: flex;
                  position: absolute;
                  padding: 10px;">
                            <img style="height: 55%;
                  width: 100%;
                  margin: auto; margin-top: 26px;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
                          </div>
                          <div style="width: 100%;
                  height: 100%;
                  float: left;
                  text-align: center;
                  display: flex;">
                <div style="color: white;width: 100%">
                  <h5 style="line-height: 1;margin: 10px 0 0"><?php echo $school_details->school_name; ?></h5>
                  <p style="margin: 0;font-size: 70%"><?php echo $school_details->school_address; ?></p>
                  <p style="margin: 0;font-size: 70%"><?php echo $school_details->phone_no; ?></p>
            </div>
              </div>

            </div>
            <!-- seperator -->
            <div style="height: 3%;">
              <div style="width: 20%;background-color: green;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: blue;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: yellow;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: red;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: pink;height: 100%;float: left;"></div>

            </div>
            <div style="height: 63.5%;background-color: white">
              <!-- student image -->
              <div style="width: 100%;height: 35%;">
                <div style="height: 65px;
                    text-align: center;
                    border-radius: 50%;
                    position: relative;">

                    <?php if ($student_details->simage) { ?>
                    <div>
                          <img style="height: 65px;
                      width: 65px;
                      border: 5px #eae5e5 solid;
                      border-radius: 50%;
                      margin-top: -40px;
                      background: white;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
                    </div>

                          <?php }else{ ?>
                          <div style="position: relative;">
                            <div style="height: 65px;
                                        width: 65px;
                                        border: 5px #eae5e5 solid;
                                        border-radius: 50%;
                                        /* margin-top: -40px; */
                                        background: white;
                                        margin: auto;
                                        /* margin-top: -50px; */
                                        position: absolute;
                                        top: -40px;
                                        left: calc(50% - 37px);
                                        display: flex;">
                                  <span style="margin: auto;">Photo</span>
                                </div>
                              </div>
                          <?php }?>
                  <div style="position: absolute;
                              bottom: 0;
                              width: 100%;" >
                    <h5 style="color: rgb(214,110,63);margin: 0"><?php echo $student_details->sname; ?></h5>
                    <p style="text-transform: uppercase;font-size: 70%;margin: 0"><?php echo $student_details->sadmsnno; ?></p>
                  </div>
                </div>
              </div>

              <div style="width: 100%;background-color: blue;height: 30%;position: relative;">
                <div style="width: 100%;background-color: green;height: 20%;"></div>
                <div style="width: 100%;background-color: blue;height: 20%;"></div>
                <div style="width: 100%;background-color: yellow;height: 20%;"></div>
                <div style="width: 100%;background-color: red;height: 20%;"></div>
                <div style="width: 100%;background-color: green;height: 20%;"></div>
                <div style="width: 86%;
                    background-color: white;
                    height: 100%;
                    position: absolute;
                    top: 0;
                    margin: auto;
                    left: 7%;
                    font-size: 70%;
                    font-weight: 500;
                    display: flex;
                    ">
              <div style="margin: auto 0;width: 100%">      <!-- <p style="margin: 0"></p> -->
                  <div style="margin: 0;padding-left: 8px;">
                    <div style="width: 39%;display:inline-block;"> Roll No : <?php echo $student_details->sroll; ?></div>  
                    <div style="width: 59%;display:inline-block;"> DOB : <?php echo $student_details->dob; ?> </div>
                  </div>
                  <div style="margin: 0;padding-left: 8px;">
                    <div style="width: 39%;display:inline-block;"> Class : <?php echo $student_details->sclass; ?></div>  
                    <div style="width: 59%;display:inline-block;"> Sec : <?php echo $student_details->ssec; ?></div>
                  </div>
                  <div style="margin: 0;padding-left: 8px;">Parent : <?php echo $student_details->spname; ?></div>
                  <div style="margin: 0;padding-left: 8px;">Expiry Date : <?php echo $nepali_conversion; ?></div>
                  </div>
                  
                </div>

              </div>
              <div style="width: 100%;height: 35%;text-align: center; display: flex;">
                <div style="margin: 10px auto 0; font-size: 70%">
                 <!--  <img style="max-height: 20px;
                      max-width: 200px;
                      border: 1px solid red;
                      padding: 5px;" src="https://upload.wikimedia.org/wikipedia/commons/6/65/Code11_barcode.png"> -->
                  
                  <?php echo '<img style="padding-bottom: 5px;" class="barcode" alt="'.$string.'" src="../important/barcode.php?text='.$string.'&codetype='.$type.'&orientation='.$orientation.'&size='.$size.'&print='.$print.'"/>'; ?>

                <p style="margin: 0;line-height: 1"><?php echo $student_details->saddress; ?></p>
              <p style="margin: 0;line-height: 1"> Nepal</p>
                </div>
                
              </div>

            </div>
            <div style="width: 100%; height: 3%;background-color: red;">
              <div style="width: 20%;background-color: green;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: blue;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: yellow;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: red;height: 100%;float: left;"></div>
              <div style="width: 20%;background-color: pink;height: 100%;float: left;"></div>

            </div>
          </div>
                   
        </div>

      <?php  } ?>
    </div>
  </div>


<!-- ========================= End Default id card ====================== -->

<!-- ================== 1. Darpan id card ============================  -->
<?php 
}else if ($idtemplate == 1) { ?>
  <div class="col-md-12" align="right" onclick='printDiv();' style="z-index: 999; width: 40px;height: 40px;background: red;position: fixed; bottom: 20px;right: 40px;border-radius: 50%;padding: 10px">
        <img src="../images/printIcon.png" style="width: 90%;height: 90%;">
  </div>

  <div id="invoice_print">
      <style type="text/css" media="print">
          @media print {
            body {-webkit-print-color-adjust: exact;}
          }
          @page {
              size:A4 portrait;
              margin-left: 28px;
              margin-right: 0;
              margin-top: 14px;
              margin-bottom: 14px;
              /*margin: 0;*/
              -webkit-print-color-adjust: exact;
              color-adjust: exact;
              -webkit-filter:opacity(1);
          }
          
      </style>
      <style type="text/css">
        @font-face {
              font-family: 'AlgerianRegular';
              src: url(../fonts/AlgerianRegular.ttf);
          }
      </style>
      <?php
      foreach ($studentarray as $student_id) 
            {
              $student_details = json_decode($backstage->get_student_full_details_by_sid($student_id));
              $string = $student_details->sadmsnno;
              //if pict is not available then no print
              if(!empty($student_details->simage)){

            ?>
    <!-- Darpan School 86.5 54.5 -->
    <div style="position: relative; float:left; width:86.5mm; height:54.5mm;background-color: white; margin-right: 28px; margin-bottom: 9px;">

      <div style="z-index: 1; text-align:center; border-radius: 0px;position: relative;background-color: #ffffff;height: 100%;overflow: hidden;" >

          <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50% 6px;
              background-size: 18%;
              z-index: 0;
              position: absolute;
              width: inherit;
              height: 100%;
              opacity: .4">   
          </div>
          <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) ;
              background-size: 15%;
              z-index: -1;
              position: absolute;
              height: 100%;
              width: 100%;
              background-repeat: space;
              opacity: .1">   
          </div>
          <div style="display: inline-flex;background-color: #56813A;width:100%;color: #ffffff;padding: 4px 0">
            <div style="width: 50px;height: 53px; text-align: center; margin: auto;">
              <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
            </div>
            <div style="text-align: center;position: relative;padding: 0 5px;margin: auto;">
                   <p style="font-size:18px;font-weight: bolder;margin: 0;margin-top:6px;text-transform: uppercase;font-family: AlgerianRegular;"><?php echo $school_details->school_name; ?></p>
                   <div >
                      <p style="margin: 0;font-size: 8px"> 
                        <?php echo $school_details->school_address; ?><br>
                        Email:<?php echo $school_details->email_id; ?> Contact:<?php echo $school_details->phone_no; ?>
                      </p>
                      
                   </div>           
            </div>
            
          </div>
          <div style="margin: 5px auto">
            <div style="width: 50%;background: #9C6A15;margin: auto;border-radius: 5px;border: 1px solid #9C6A15;box-shadow: 0px 0px 5px 0px green;">
              <h5 style="margin: 0;padding: 0;color: #ffffff;">STUDENT ID CARD</h5>
            </div>
          </div>
        
        <!-- id details -->
          <div>
            
            <div style="text-align: left;padding: 5px 15px;width: 60%;float: left; line-height: 1;">
              <p style="white-space: nowrap;overflow: hidden;margin: 0">  Name: <?php echo $student_details->sname; ?><br>
                Class: <?php echo $student_details->class_name; ?> (<span style="text-transform: uppercase;"><?php echo $student_details->section_name; ?></span>)<br>          
                Roll No: <?php echo $student_details->sroll; ?><br>          
                Address: <?php echo $student_details->saddress; ?><br>         
              </p>

            </div>
            <!-- image of id -->

            <div style="width: 20%;display: inline-block;">
              <div style="width: 60px;height: 70px;text-align: center;margin: auto;border: 2px solid #636060;position: relative;">
                <img style="width: 100%;height: 100%;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
                <div style="position: absolute;bottom: 10px;right: 28px;">
                  <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 30px;width: 70px;margin-bottom: -7px;"><br>
                </div>  
              </div>  
                  
            </div>
          </div>
          <div style="position: absolute;bottom: 0;width: 100%">
            <p style="text-align: center;margin: 1px;font-size: 11px">Valid Upto 2076-03-31</p>

            <h5 style="background:#56813A;color: #ffffff;padding-bottom:8px; padding-top:2px; margin: 0 "><i><b><?php echo $school_details->slogan; ?></b></i></h5>
            
          </div>
      </div>
    </div>
    

      <?php  }
    } ?>
  </div>
<!-- ========================= End Darpan id card ====================== -->

<!-- ==================== 2. DPS id card ============================  -->
<?php 
}else if ($idtemplate == 2) { ?>
  <div class="col-md-12" align="right" onclick='printDiv();' style="z-index: 999; width: 40px;height: 40px;background: red;position: fixed; bottom: 20px;right: 40px;border-radius: 50%;padding: 10px">
        <img src="../images/printIcon.png" style="width: 90%;height: 90%;">
  </div>

  <div id="invoice_print">
      <style type="text/css" media="print">
          @media print {
            body {-webkit-print-color-adjust: exact;}
          }
          @page {
              size:A4 landscape;
              margin-left: 14px;
              margin-right: 14px;
              margin-top: 28px;  /*increased*/
              margin-bottom: 28px;
              /*margin: 0;*/
              -webkit-print-color-adjust: exact;
              color-adjust: exact;
              -webkit-filter:opacity(1);
          }
          
      </style>
      <style type="text/css">
        @font-face {
              font-family: 'AlgerianRegular';
              src: url(../fonts/AlgerianRegular.ttf);
          }
      </style>
      <?php
      foreach ($studentarray as $student_id) 
            {
              $student_details = json_decode($backstage->get_student_full_details_by_sid($student_id));
              $string = $student_details->sadmsnno;
              //if pict is not available then no print
              if(!empty($student_details->simage)){

            ?>
    <!-- Dps School-->
    <div style="position: relative; float:left; width:54.5mm; height:86.5mm;background-color: white; margin-right: 9px; margin-bottom: 28px;">

      <div style="z-index: 1; text-align:center; border: 2px solid #787878;border-radius: 0;position: relative;background-color: #fefeda;height: 100%;overflow: hidden;" class="backGreen">
      <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) 50%;
              background-size: 26%;
              background-repeat: space;
              position: absolute;
              top: 26%;
              width: inherit;
              height: 62%;
              opacity: .1;
              width: 100%;">    
      </div>
      <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50%;
          background-size: 45%;
          z-index: -1;
          position: absolute;
          width: inherit;
          height: 100%;
          opacity: .1">   
      </div>
      
      <div style="display: inline-flex;background-color: #2F5526;width:100%;color: #fefeda;padding: 5px 0">
        <div style="width: 50px;height: 40px;text-align: center;margin: auto;">
          <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
        </div>
        <div style="text-align: center;position: relative;padding: 0 5px;margin: auto;">
               <h4 style="font-weight: bolder;margin: 0;text-transform: capitalize;"><?php echo $school_details->school_name; ?></h4>
               <div >
                  <p style="margin: 0;font-size: 11px;font-family: happyEnding"><?php echo $school_details->school_address; ?></p>
                  
               </div>           
        </div>
        
      </div>
        <!-- image of id -->

      <div>
        <h5 style="margin: 2px 0">2018-19</h5>
        <div style="width: 60px;height: 70px;text-align: center;margin: auto;border: 2px solid red">
          <img style="width: 100%;height: 100%;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
        </div>
        <h5 style="margin: 2px 0;font-weight: bolder;"><?php echo $student_details->sname; ?></h5>

      </div>
      <!-- id details -->
      <div style="text-align: left;padding: 0 5px">
        <p style="font-size: 12px;white-space: nowrap;overflow: hidden;">  Class: <b><?php echo $student_details->class_name; ?></b><br>
          Sec: <b><?php echo $student_details->section_name; ?></b><br>
          Roll: <b><?php echo $student_details->sroll; ?></b><br>
          DOB: <b><?php echo $student_details->dob; ?></b><br>
          Address: <b><?php echo $student_details->saddress; ?></b><br>
          Guardian: <b><?php echo $student_details->spname; ?></b><br>
          Contact: <b><?php echo $student_details->spnumber; ?></b><br>
          <!-- Bus No.: <b></b> -->
        </p>

      </div>
      <div style="position: absolute;bottom: 20px;right: 5px">
        <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 30px;width: 70px;margin-bottom: -7px;"><br>
        <span style=" ">Principal</span>
        
      </div>
      <div style="position: absolute;bottom: 0;width: 100%">
        <h5 style="background:#2F5526;color: #fefeda;padding:3px 0;margin: 0 ">STUDENT</h5>
        
      </div>
    </div>
    </div>
    

      <?php  }
    } ?>
  </div>
<!-- ========================= End DPS id card ====================== -->

<!-- ================== 3. East horizon id card ====================  -->
<?php 
}else if ($idtemplate == 3) { ?>
  <div class="col-md-12" align="right" onclick='printDiv();' style="z-index: 999; width: 40px;height: 40px;background: red;position: fixed; bottom: 20px;right: 40px;border-radius: 50%;padding: 10px">
        <img src="../images/printIcon.png" style="width: 90%;height: 90%;">
  </div>

  <div id="invoice_print">
      <style type="text/css" media="print">
          @media print {
            body {-webkit-print-color-adjust: exact;}
          }
          @page {
              size:A4 landscape;
              margin-left: 14px;
              margin-right: 14px;
              margin-top: 28px;  /*increased*/
              margin-bottom: 28px;
              /*margin: 0;*/
              -webkit-print-color-adjust: exact;
              color-adjust: exact;
              -webkit-filter:opacity(1);
          }
          
      </style>
      <style type="text/css">
        @font-face {
              font-family: 'AlgerianRegular';
              src: url(../fonts/AlgerianRegular.ttf);
          }
      </style>
      <?php
      foreach ($studentarray as $student_id) 
            {
              $student_details = json_decode($backstage->get_student_full_details_by_sid($student_id));
              $string = $student_details->sadmsnno;
              //if pict is not available then no print
              if(!empty($student_details->simage)){

            ?>
    <!-- East horizon School-->
    <div style="position: relative; float:left; width:54.5mm; height:86.5mm;background-color: white; margin-right: 9px; margin-bottom: 28px;">

      <div style="z-index: 1; text-align:center;position: relative;background-color: #ffffff;height: 100%;overflow: hidden;" class="backGreen">
      <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) 50%;
              background-size: 26%;
              background-repeat: space;
              position: absolute;
              top: 26%;
              width: inherit;
              height: 62%;
              opacity: .1;
              width: 100%;">    
      </div>
      <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50%;
          background-size: 45%;
          z-index: -1;
          position: absolute;
          width: inherit;
          height: 100%;
          opacity: .1">   
      </div>
      <!-- id header -->
      <div style="display: inline-flex;background-color: #29337B;width:100%;color: #FFF; margin-bottom: 11px; padding-top: 10px;">
        <div style="height: 66px;text-align: center;margin: auto;">
          <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
        </div>
        <div style="text-align: center;position: relative;padding-left:3px;margin: auto;font-family: initial;    border-left: 2px solid white;">
               <h4 style="font-weight: bolder;margin: 0;text-transform: uppercase;letter-spacing: 1.5px;"><?php echo $school_details->school_name; ?></h4>
               <p style="font-weight: bolder;font-size: 15px; text-transform: uppercase;margin-top: 2px;">Shishu Sadan</p>
               <div >
                  <p style="font-weight: bolder; margin-top: -9px; line-height: 1.7; font-size: 9px; letter-spacing: 1.5;"><?php echo $school_details->school_address; ?><br>
                  Ph. <?php echo $school_details->phone_no; ?></p>
                  
               </div>           
        </div>
        
      </div>
        <!-- image of id -->

      <div >
        <div >
          <div style="width: 60px;height: 70px;text-align: center;margin:auto;border: 2px solid black;    position: relative;">
            <img style="width: 100%;height: 100%;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
            <!-- signature of principal -->
            <div style="position: absolute;bottom: -8px;right: 24px;transform: rotateZ(0deg);">
              <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 40px;width: 60px;"><br>
              
            </div>
          </div>
        </div>
        <!-- id details -->
        <div style="text-align: left;padding: 0 10px 0 15px">
          <p style="font-size: 13px;white-space: nowrap;overflow: hidden;">  
            Name: <?php echo $student_details->sname; ?><br>
            Class: <?php echo $student_details->class_name.'('.$student_details->section_name.')'; ?><br>
            Roll: <?php echo $student_details->sroll; ?><br>            
            Parent: <?php echo $student_details->spname; ?><br>
            Contact: <?php echo $student_details->spnumber; ?><br>          
          </p>

        </div>
        <p style="font-size:12px;"><b>Valid Upto 2075-12-31</b></p> 
      </div>
        
      <!-- id footer -->
      <div style="position: absolute;bottom: 0; width: 100%;background-color: #29337B;color: #FFF;">
        <p style="font-weight: bold; margin: 0; letter-spacing: 1.5;"><b>Student ID Card</b></p>
        <p style="font-weight: bold; margin: 0; font-size: 7px;letter-spacing: 1.5; padding-bottom: 3px;">If found please return back to school</p>
        
      </div>
    </div>
    </div>
    

      <?php  }
    } ?>
  </div>
<!-- ====================== End East Horizon id card ================ -->
<?php } ?>








    
<script>
  function printDiv() 
  {

    var invoice_print=document.getElementById('invoice_print');

    var newWin=window.open('','Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">'+invoice_print.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},100);

  }
</script>

      
