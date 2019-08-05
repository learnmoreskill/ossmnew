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

$year_id = $_POST['year_id'];

$nepali_conversion = $cal['year']+1 . '/' . $cal['month'] . '/' . $cal['date'];

  error_reporting( ~E_NOTICE ); // avoid notice
  
 if( isset( $_POST['generate_multiple_idcard'] ) ){

    $userarray = $_POST['studentmultiple'];

}
else if( isset( $_POST['generate_all_idcard'] ) ){   
  $classes = $_POST['allclass'];

    if (empty($classes)) {
      ?> <script> alert('Class is empty'); window.close(); </script> <?php 
      exit();
    }
    $userarray = array();
    foreach ($classes as $eachclass) 
    {
      $result = mysqli_query($db, "SELECT `sid` FROM `studentinfo` WHERE `sclass`='$eachclass' AND `status`='0' ORDER BY `ssec`,`sroll` ");
      while($row = mysqli_fetch_assoc($result))
      {
        array_push($userarray,$row['sid']);
      }
    }

}
else if( isset( $_POST['generate_single_idcard'] ) ){
    $userarray = $_POST['studentsingle'];

}
else if( isset( $_POST['generate_staff_idcard'] ) ){
    $userarray = $_POST['staffmultiple'];
    $stafftype = $_POST['stafftype'];

}
else{
  ?> <script> alert('Invalid request'); window.close(); </script> <?php
  exit();
}
    if (empty($userarray)) {
      ?> <script> alert('List is empty'); window.close(); </script> <?php 
      exit();
    }
    $school_details = json_decode($backstage->get_school_details_by_id());

    $idtemplate = $_POST['idtemplate'];



?>

<!-- ====================  Default Id Card     ==================== -->
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
        foreach ($userarray as $student_id) 
              {
                $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id , $year_id));
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
                      <div style="width: 50%;display:inline-block;"> Class : <?php echo $student_details->class_name; ?></div>  
                      <div style="width: 40%;display:inline-block;"> Sec : <?php echo $student_details->section_name; ?></div>
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

<!-- ==================== End Default id card ====================== -->

<!-- ==================== 1. Darpan id card ============================  -->
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
        foreach ($userarray as $student_id) 
              {
                $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id , $year_id));
                $string = $student_details->sadmsnno;
                //if pict is not available then no print
                if(isset( $_POST['generate_all_idcard'] ) && empty($student_details->simage)){
                }else{

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
<!-- ==================== End Darpan id card ====================== -->

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
        foreach ($userarray as $student_id) 
              {
                $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id , $year_id));
                $string = $student_details->sadmsnno;
                //if pict is not available then no print
                if(isset( $_POST['generate_all_idcard'] ) && empty($student_details->simage)){
                }else{

              ?>
      <!-- Dps School-->
      <div style="position: relative; float:left; width:54.5mm; height:86.5mm;background-color: white; margin-right: 9px; margin-bottom: 28px;">

        <div style="z-index: 1; text-align:center; border-radius: 0;position: relative;background-color: #fefeda;height: 100%;overflow: hidden;" class="backGreen">
        <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) 50%;
                background-size: 26%;
                background-repeat: space;
                position: absolute;
                top: 26%;
                width: inherit;
                height: 62%;
                opacity: .1;
                width: 100%;
                z-index: -1;">    
        </div>
        <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50%;
            background-size: 45%;
            z-index: -1;
            position: absolute;
            width: inherit;
            height: 100%;
            opacity: .1">   
        </div>
        
        <div style="display: inline-flex;background-color: #2F5526;width:100%;color: #ffffff;padding: 5px 0">
          <div style="width: 50px;height: 55px;text-align: center;margin: auto;">
            <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
          </div>
          <div style="text-align: center;position: relative;padding: 0 5px;margin: auto;">
                 <h4 style="font-weight: bolder;margin: 0;text-transform: capitalize;"><?php echo $school_details->school_name; ?>
                 </h4>
                 <div >
                    <p style="margin: 0;font-size: 7px; font-style:italic; text-align: right; font-family: happyEnding">Shaping Your Child's Career</p>
                    
                 </div> 
                 <div >
                    <p style="margin: 0;font-size: 11px;padding-top: 10px; font-family: happyEnding"><?php echo $school_details->school_address; ?></p>
                    
                 </div>           
          </div>
          
        </div>
          <!-- image of id -->

        <div>
          <h5 style="margin: 2px 0">2018-19</h5>
          <div style="width: 60px;height: 70px;text-align: center;margin: auto;border: 2px solid #000000;border-radius: 12px;">
            <img style="width: 100%;height: 100%;border-radius: 10px;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
          </div>
          <h5 style="margin: 2px 0;font-weight: bolder;"><?php echo $student_details->sname; ?></h5>

        </div>
        <!-- id details -->
        <div style="text-align: left;padding: 0 12px">
          <p style="font-size: 11px;white-space: nowrap;overflow: hidden;">  Class: <b><?php echo $student_details->class_name; ?></b><br>
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
          <h5 style="background:#2F5526;color: #ffffff;padding:3px 0;margin: 0 ">STUDENT</h5>
          
        </div>
      </div>
      </div>
      

        <?php  }
      } ?>
    </div>
<!-- ==================== End DPS id card ====================== -->

<!-- ==================== 3. Siddhartha id card ====================  -->
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
        foreach ($userarray as $student_id) 
              {
                $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id , $year_id));
                $string = $student_details->sadmsnno;
                //if pict is not available then no print
                if(isset( $_POST['generate_all_idcard'] ) && empty($student_details->simage)){
                }else{

              ?>
      <!-- siddhartha School-->
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
<!-- ==================== End Siddhartha id card ================ -->

<!-- ==================== 4. Everest id card ====================  -->
  <?php 
  }else if ($idtemplate == 4) { ?>
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
            @font-face {
              font-family: 'AvenirLTStd-Light';
              src: url(../fonts/Avenir/AvenirLTStd-Light.otf);
          }
        </style>
        <?php
        foreach ($userarray as $student_id) 
              {
                $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id , $year_id));
                $string = $student_details->sadmsnno;
                //if pict is not available then no print
                if(isset( $_POST['generate_all_idcard'] ) && empty($student_details->simage)){
                }else{

              ?>
      <!-- Everest School-->
      <div style="position: relative; float:left; width:54.5mm; height:86.5mm;background-color: white; margin-right: 9px; margin-bottom: 28px;">

        <div style="z-index: 1; text-align:center;position: relative;background-color: #ffffff;height: 100%;overflow: hidden;" class="backGreen">
        <div style="/*background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) 50%;*/
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
        <div style="display: inline-flex;
                      <?php 
                      if($student_details->buscolor==0){ echo "background-color: #2d1ba0;"; }
                      else if($student_details->buscolor==1){ echo "background-color: #e6b40b;"; }
                      else if($student_details->buscolor==2){ echo "background-color: #179bab;"; }
                      else if($student_details->buscolor==3){ echo "background-color: #209ebb;"; }
                      else{ echo "background-color: #29337B;"; } 
                      ?> 
          width:100%;color: #FFF; margin-bottom: 5px; padding-top: 4px;">
          <div style="height: 63px;text-align: center;margin: auto;margin-top: 1px">
            <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
          </div>
          <div style="text-align: center;position: relative;padding-left:6px;margin: auto;font-family:initial;    border-left: 2px solid white;">
                 <p style="font-weight: bolder;font-size:20px;margin: 0;text-transform: uppercase;font-family: sans-serif;"><?php echo $school_details->school_name; ?></p>
                 <p style="font-weight: bolder;font-size: 13px; margin-top: 1px; font-family:sans-serif;">Secondary School</p>
                 <div >
                    <p style="font-weight: bolder;margin-top: -10px; line-height: 1.7; font-size: 8px; font-family: sans-serif;letter-spacing: 0.5px;"><?php echo $school_details->school_address; ?><br>
                    Ph. <?php echo $school_details->phone_no; ?></p>
                    
                 </div>           
          </div>
          
        </div>
          <!-- image of id -->

        <div >
          <div >
            <div style="width: 95px;height: 95px;text-align: center;margin:auto;border: 2px solid black;    position: relative;">
              <img style="width: 100%;height: 100%;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
              <!-- signature of principal -->
              <div style="position: absolute;bottom: -17px;right: 13px;transform: rotateZ(13deg)">
                <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 42px;width: 65px;"><br>
                <!-- <p style="text-align: center;">.............<br>
                  principal
                </p> -->
                
              </div>
            </div>
          </div>
          <p style="text-align:center;margin: -6px;font-size: 11px;">.................<br>Principal</p>
         
         
           <!-- id details -->
          <div style="text-align: left;padding: 0 10px 0 15px;margin-top: -11px;">
            <p style="font-size: 11px;white-space: nowrap;overflow: hidden;margin-top: 15px;font-weight: bold;">  
              Name: <?php echo $student_details->sname; ?><br>
              Class: <?php echo $student_details->class_name.'('.$student_details->section_name.')'; ?><br>
              Roll: <?php echo $student_details->sroll; ?><br>
              DOB: <?php echo $student_details->dob; ?><br>             
              <!-- Father Name: <?php echo $student_details->spname; ?><br>
              Mother Name: <?php echo $student_details->smname; ?><br> -->
              Address: <?php echo $student_details->sp_address; ?><br> 
              Contact: <?php echo $student_details->spnumber; ?><br>          
            </p>

          </div>
          <p style="font-size:12px;margin-top: -7px;"><b>Valid Upto: 2076-12-30</b></p> 
        </div>
          
        <!-- id footer -->
        <div style="position: absolute;bottom: 0; width: 100%;
        <?php 
                      if($student_details->buscolor==0){ echo "background-color: #2d1ba0;"; }
                      else if($student_details->buscolor==1){ echo "background-color: #e6b40b;"; }
                      else if($student_details->buscolor==2){ echo "background-color: #179bab;"; }
                      else if($student_details->buscolor==3){ echo "background-color: #209ebb;"; }
                      else{ echo "background-color: #29337B;"; } 
                      ?>
        color: #FFF;">
          <p style="font-weight: bold; margin: 5px; letter-spacing: 1.5;font-family: sans-serif;"><b><?php 
                      if(!empty($student_details->buscolor) && $student_details->buscolor != 0){ echo "Student ID Card"; }
                      else{ echo "Student ID Card"; } 
                      ?> </b></p>
          <!-- <p style="font-weight: bold; margin: 1; font-size: 7px;letter-spacing: 1.5; padding-bottom: 4px;font-family: sans-serif;">If found please return back to school</p> -->
          
        </div>
      </div>
      </div>
      

        <?php  }
      } ?>
    </div>
<!-- ====================== End Everest id card ================ -->


<!-- ==================== 5. Satyanarayan id card ====================  -->
  <?php 
  }else if ($idtemplate == 5) { ?>
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
             @font-face {
              font-family: 'AvenirLTStd-Light';
              src: url(../fonts/Avenir/AvenirLTStd-Light.otf);
          }
        </style>
        <?php
        foreach ($userarray as $student_id) 
              {
                $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id , $year_id));
                $string = $student_details->sadmsnno;
                //if pict is not available then no print
                if(isset( $_POST['generate_all_idcard'] ) && empty($student_details->simage)){
                }else{

              ?>
      <!-- siddhartha School-->
      <div style="position: relative; float:left; width:54.5mm; height:86.5mm;background-color: white; margin-right: 9px; margin-bottom: 28px;">

        <div style="z-index: 1; text-align:center;position: relative;background-color: #ffffff;height: 100%;overflow: hidden;" class="backGreen">
        <div style="/*background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) 50%*/;
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
        <div style="display: inline-flex;background-color: #112596;width:100%;color: #FFF; margin-bottom: 8px; padding-top: 8px;">
          <div style="height: 60px;text-align: center;margin-left:6px;margin-top: 2px;">
            <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
          </div>
          <div style="text-align: center;position: relative;padding-left: 9px;">
                 <p style="margin: 0;font-family: fantasy;font-size: 18px;transform: scale(1, 1.5);letter-spacing: .5;"><?php echo $school_details->school_name; ?></p>
                 <p style="font-weight: bolder;font-size: 11px;margin: 4px;letter-spacing: 1.5px;font-style: italic;">Secondary School 
                 </p> 
                 <div >
                    <p style="font-weight: bolder;font-family: sans-serif; line-height: 1.5; font-size: 11px; margin: -2px;padding-bottom: 4px;"><?php echo $school_details->school_address; ?><br>
                    Ph. <?php echo $school_details->phone_no; ?></p>
                    
                 </div>           
          </div>
          
        </div>
          <!-- image of id -->

        <div >
          <div >
            <div style="width: 85px;height: 90px;text-align: center;margin:auto;border: 2px solid black;    position: relative;">
              <img style="width: 100%;height: 100%;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
              <!-- signature of principal -->
              <div style="position: absolute;bottom: -8px;right: 47px;transform: rotateZ(0deg);">
                <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 30px;width: 50px;"><br>
                
              </div>
            </div>
          </div>
          <!-- id details -->
          <div style="text-align: left;padding: 0 10px 0 20px">
            <p style="font-size: 11px;white-space: nowrap;overflow: hidden;">  
              Name: <?php echo $student_details->sname; ?><br>
              Class: <?php echo $student_details->class_name.'('.$student_details->section_name.')'; ?><br>
              Roll: <?php echo $student_details->sroll; ?><br>            
              Parent: <?php echo $student_details->spname; ?><br>
              Contact: <?php echo $student_details->spnumber; ?><br>   

            </p>

          </div>
            <p style="font-size:13px;margin-top: -1px;"><b>Valid Upto: 2076-12-30</b></p> 
        </div>
          
        <!-- id footer -->
        <div style="position: absolute;bottom: 0; width: 100%;background-color: #112596;color: #FFF;">
          <p style="    font-weight: bolder;margin: 0;letter-spacing: 1.5;font-family: sans-serif;padding-top: 4px;font-size: 19px;"><b>Student ID Card</b></p>
          <p style="font-weight: bold;margin: 0;font-size: 10px;letter-spacing: 1.3;padding-bottom: 6px;font-family: sans-serif;">www.pokhariyaschool.edu.np</p>
          
        </div>
      </div>
      </div>
      

        <?php  }
      } ?>
    </div>
<!-- ==================== End Satyanarayan id card ================ -->

<!-- ==================== 6. SIX id card ====================  -->
  <?php 
  }else if ($idtemplate == 6) { ?>
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
             @font-face {
              font-family: 'AvenirLTStd-Light';
              src: url(../fonts/Avenir/AvenirLTStd-Light.otf);
          }
        </style>
        <?php
        foreach ($userarray as $student_id) 
              {
                $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id , $year_id));
                $string = $student_details->sadmsnno;
                //if pict is not available then no print
                if(isset( $_POST['generate_all_idcard'] ) && empty($student_details->simage)){
                }else{

              ?>
      <!-- purwanchal School-->
      <div style="position: relative; float:left; width:54.5mm; height:86.5mm;background-color: white; margin-right: 9px; margin-bottom: 28px;">

        <div style="z-index: 1; text-align:center;position: relative;background-color: #ffffff;height: 100%;overflow: hidden;" class="backGreen">
        <div style="/*background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) 50%;*/
                background-size: 100%;
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
        <div style="display: inline-flex;background-color: #2b26c1;width:100%;color: #FFF; margin-bottom: 6px; padding-top: 9px;">
          <div style="height: 45px;text-align: center;margin-left: 6px;margin-top: 22px;padding-bottom: 4px;">
            <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
          </div>
          <div style="text-align: center;position: relative;">
                 <p style="margin: 0;font-family: fantasy;font-size: 16px;transform: scale(1, 1.5);letter-spacing: .5;margin-left: -45px;margin-top: -4px;;"><?php echo $school_details->school_name; ?></p>
                 <div >
                    <p style="font-weight: bolder;font-size: 15px;margin: 4px;letter-spacing: 1.5px;font-style: italic;">Sec. B. School 
                 </p> 
                 <!-- <p style="font-weight: bolder;font-size: 15px;margin: 2px;letter-spacing: 1.5px;font-style: italic;">English B. School 
                 </p>  -->
                 </div> 
                 <div >
                    <p style="font-weight: bolder;font-family: sans-serif; line-height: 1.5; font-size: 11px; margin: 2px;letter-spacing: .5;padding-top: 7px;"><?php echo $school_details->school_address; ?><br>
                    Ph. <?php echo $school_details->phone_no; ?></p>
                    
                 </div>           
          </div>
          
        </div>
          <!-- image of id -->

        <div >
          <div >
            <div style="width: 90px;height: 90px;text-align: center;filter:brightness(1.1);margin:auto;border: 2px solid black;    position: relative;">
              <img style="width: 100%;height: 100%;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
              <!-- signature of principal -->
              <div style="position: absolute;bottom: -4px;right: 50px;transform: rotateZ(-10deg);">
                <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 41px;width: 76px;"><br>
                
              </div>
            </div>
          </div>
          <!-- id details -->
          <div style="text-align: left;padding: 0 10px 0 15px;line-height: 1.5;">
            <p style="font-size: 11px;white-space: nowrap;overflow: hidden;margin-top: 15px;font-weight: bold;">  
              Name: <?php echo $student_details->sname; ?><br>
              Class: <?php echo $student_details->class_name.'('.$student_details->section_name.')'; ?><br>
              <!-- Roll No: <?php echo $student_details->sroll; ?><br>  -->           
              Parent: <?php echo $student_details->spname; ?><br>
              Contact: <?php echo $student_details->spnumber; ?><br>   

            </p>

          </div>
            <p style="font-size:13px;margin-top:-6px;"><b>Valid Upto: 2076-12-30</b></p> 
        </div>
          
        <!-- id footer -->
        <div style="position: absolute;bottom: 0; width: 100%;background-color: #2b26c1;color: #FFF;">
          <p style="    font-weight: bolder;margin: 0;letter-spacing: 1.5;font-family: sans-serif;padding: 4px;font-size: 19px;"><b>Student ID Card</b></p>
          <!-- <p style="font-weight: bold;margin: 0;font-size: 10px;letter-spacing: .8;padding-bottom: 6px;font-family: sans-serif;">www.mahendramemorial.edu.np</p> -->
          
        </div>
      </div>
      </div>
      

        <?php  }
      } ?>
    </div>
<!-- ==================== End SIX STUDENT id card ================ -->


<!-- ====================== Default staff id card ================ -->
<?php
  }else if($idtemplate == 999){ ?>

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
        foreach ($userarray as $staffid) 
              {
                if ($stafftype == 1) {
                  $staff = json_decode($backstage->get_teacher_full_details_by_tid($staffid));
                  $staffID = $staff->tid;
                  $staffName = $staff->tname;
                  $staffMail = $staff->temail;
                  $staffAddress = $staff->taddress;
                  $staffMobile = $staff->tmobile;
                  $staffSex = $staff->sex;
                  $staffDob = $staff->dob;

                  $staffImage = $staff->timage;

                }else if($stafftype == 2){
                  $staff = json_decode($backstage->get_staff_full_details_by_stid($staffid));
                  $staffID = $staff->staff_id;
                  $staffName = $staff->staff_name;
                  $staffMail = $staff->staff_email;
                  $staffAddress = $staff->staff_address;
                  $staffMobile = $staff->staff_mobile;
                  $staffSex = $staff->staff_sex;
                  $staffDob = $staff->staff_dob;

                  $staffImage = $staff->staff_image;

                }
                

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

                      <?php if ($staffImage) { ?>
                      <div>
                            <img style="height: 65px;
                        width: 65px;
                        border: 5px #eae5e5 solid;
                        border-radius: 50%;
                        margin-top: -40px;
                        background: white;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $staffImage; ?>">
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
                      <h5 style="color: rgb(214,110,63);margin: 0"><?php echo $staffName; ?></h5>
                      <!-- <p style="text-transform: uppercase;font-size: 70%;margin: 0"><?php echo $staffName; ?></p> -->
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
                    
                    <?php echo '<img style="padding-bottom: 5px;" class="barcode" alt="DPSBRT'.$staffID.'" src="../important/barcode.php?text=DPSBRT'.$staffID.'&codetype='.$type.'&orientation='.$orientation.'&size='.$size.'&print='.$print.'"/>'; ?>

                  <p style="margin: 0;line-height: 1"><?php echo $staffAddress; ?></p>
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
<!-- ==================== End default stff id ========================  -->

<!-- ====================== 101 staff id card ================ -->
<?php
  }else if($idtemplate == 101){ ?>

    <div class="col-md-12" align="right" onclick='printDiv();' style="z-index: 999; width: 40px;height: 40px;background: red;position: fixed; bottom: 20px;right: 40px;border-radius: 50%;padding: 10px">
          <img src="../images/printIcon.png" style="width: 90%;height: 90%;">
    </div>

    <div class="container">
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
        <?php
        foreach ($userarray as $staffid) 
              {
                if ($stafftype == 1) {
                  $staff = json_decode($backstage->get_teacher_full_details_by_tid($staffid));
                  $staffID = $staff->tid;
                  $staffName = $staff->tname;
                  $staffMail = $staff->temail;
                  $staffAddress = $staff->taddress;
                  $staffMobile = $staff->tmobile;
                  $staffSex = $staff->sex;
                  $staffDob = $staff->dob;
                  $staffBlood = $staff->blood_group;
                  $staffDesignation = $staff->designation;


                  $staffImage = $staff->timage;




                }else if($stafftype == 2){
                  $staff = json_decode($backstage->get_staff_full_details_by_stid($staffid));
                  $staffID = $staff->staff_id;
                  $staffName = $staff->staff_name;
                  $staffMail = $staff->staff_email;
                  $staffAddress = $staff->staff_address;
                  $staffMobile = $staff->staff_mobile;
                  $staffSex = $staff->staff_sex;
                  $staffDob = $staff->staff_dob;
                  $staffBlood = $staff->blood_group;
                  $staffDesignation = $staff->staff_position;

                  $staffImage = $staff->staff_image;

                  $license=$staff->staff_country;

                }


                $staffBlood = (($staffBlood==1)? 'O -ve' : (($staffBlood==2)? 'O +ve' : (($staffBlood==3)? 'A -ve' : (($staffBlood==4)? 'A +ve' : (($staffBlood==5)? 'B -ve' : (($staffBlood==6)? 'B +ve' : (($staffBlood==7)? 'AB -ve' : (($staffBlood==8)? 'AB +ve' : '' ) ) ) ) ) ) ) );
                

              ?>

              <div style="position: relative; float:left; width:54.5mm; height:86.5mm;background-color: white; margin-right: 9px; margin-bottom: 38px;">
            <!-- <div style="position: relative; border: 1px solid #a8adac; border-radius: 4px; width:30%; float:left; margin-left: 20px;margin-bottom:6px;height:33%;"> -->
            <!-- width:2.125in; height:3.375in; -->
           <div style="z-index: 1;position: relative;background-color: #ffffff;height: 100%;overflow: hidden;" class="backGreen">

              <!-- school header -->
              <div style="height: 30%;background-color: rgb(42, 58, 195);">
                <div style="    width: 25%;
                    height: inherit;
                    /* float: left; */
                    display: flex;
                    position: absolute;
                   ">
                              <img style="height: 55%;
                    width: 100%;
                    margin: auto; margin-top: 20px;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
                            </div>
                            <div style="width: 100%;
                    height: 100%;
                    float: left;
                    text-align: center;
                    display: flex;">
                  <div style="color: white;width: 100%;padding-left: 35px;">
                    <p style="margin: 10px 0 2;font-family: fantasy;font-size: 17px;letter-spacing: 1.1"><?php echo $school_details->school_name; ?></p>
                    <p style="margin: 0;font-size: 11px;font-family: sans-serif;padding-bottom: 4px;"><?php echo $school_details->school_address; ?></p>
                    <p style="margin: 0;font-size: 11px;font-family: sans-serif;"><?php echo $school_details->phone_no; ?></p>
              </div>
                </div>

              </div>
              <!-- seperator -->
              <div style="height: 3%;">
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>

              </div>
              <div style="height: 63.5%;background-color: white">
                <!-- student image -->
                <div style="width: 100%;height: 35%;">
                  <div style="height: 58px;
                      text-align: center;
                      border-radius: 50%;
                      position: relative;">

                      <?php if ($staffImage) { ?>
                      <div>
                            <img style="height: 65px;
                        width: 65px;
                        border: 5px #eae5e5 solid;
                        border-radius: 50%;
                        margin-top: -40px;
                        background: white;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $staffImage; ?>">
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
                      <h5 style="color: rgb(214,110,63);margin: 0"><?php echo $staffName; ?></h5>
                      <!-- <p style="text-transform: uppercase;font-size: 70%;margin: 0"><?php echo $staffName; ?></p> -->
                    </div>
                  </div>
                </div>

                <div style="width: 100%;background-color: white;height: 30%;position: relative;">
                  <!-- <div style="width: 100%;background-color: green;height: 20%;"></div>
                  <div style="width: 100%;background-color: blue;height: 20%;"></div>
                  <div style="width: 100%;background-color: yellow;height: 20%;"></div>
                  <div style="width: 100%;background-color: red;height: 20%;"></div>
                  <div style="width: 100%;background-color: green;height: 20%;"></div>
                  -->
                  <div style="
                      background-color: white;
                      height: 100%;
                      position: absolute;
                      top: 0;
                      margin: auto;
                      left: 9%;
                      font-size: 11px;
                      line-height: 1.4;
                      ">
                <div style="margin: auto 0;width: 100%">      <!-- <p style="margin: 0"></p> -->
                    <div style="margin: -9px;padding-left: 14px;">
                      <div> Designation : <?php echo $staffDesignation; ?></div>
                      <div> Blood Group : <?php echo $staffBlood; ?></div>
                      <div> License No : <?php echo $license; ?></div>
                      <div> DOB : <?php echo $staffDob; ?> </div>
                      <div> Contact No. : <?php echo $staffMobile; ?> </div>
                      <div> Address : <?php echo $staffAddress; ?></div>

                    </div>
                    
                    
                    </div>
                   
                    
                  </div>

                </div>
                <div style="width: 100%;height: 35%;text-align: center; display: flex;">
                  <div style="margin: 25px auto 0; font-size: 70%">
                  
                    
                    <?php echo '<img style="padding-bottom: 5px;" class="barcode" alt="DPSBRT'.$staffID.'" src="../important/barcode.php?text=DPSBRT'.$staffID.'&codetype='.$type.'&orientation='.$orientation.'&size='.$size.'&print='.$print.'"/>'; ?>
                     <div style="margin: 0;padding-left: 8px;">Issue Date :2075-01-10 </div>

                 
                  </div>
                  
                </div>
                  <div style="top: 121px;position: absolute;left: 35px; z-index: 999;">
                        <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 30px;width: 70px;margin-bottom: -7px;"><br>
                  </div>

              </div>
              <div style="width: 100%; height: 3%;background-color: white;">
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>
                <div style="width: 20%;background-color: white;height: 100%;float: left;"></div>

              </div>
            </div>
                     
          </div>

        <?php  } ?>
      </div>
    </div>
<!-- ==================== End 101 stff id ========================  -->

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

      
