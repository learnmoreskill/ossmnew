<?php
include("session.php");
require("../important/backstage.php");

$backstage = new back_stage_class();


  error_reporting( ~E_NOTICE ); // avoid notice

  if( isset( $_POST['generate_multiple_transfer'] ) ){

    $studentarray = $_POST['multistudent'];

  }
  else if( isset( $_POST['generate_single_transfer'] ) ){

    $studentarray = $_POST['singlestudent'];

  }
  else{
    ?> <script> alert('Invalid request'); window.close(); </script> <?php
    exit();
  }

    $template_id = $_POST['template_id'];
    
    if (empty($studentarray)) { 
      ?> <script> alert('Student list is empty'); window.close(); </script> <?php 
    }

    $school_details = json_decode($backstage->get_school_details_by_id());

?>

<!-- ====================  Default Id Card     ==================== -->
  <?php
  if($template_id == 99){ ?>

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
                size:A4 landscape;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                -webkit-filter:opacity(1);
            }
        </style>

        <?php
        foreach ($studentarray as $student_id) 
        {
          $student_details = json_decode($backstage->get_student_full_details_by_sid($student_id));

        ?>
        <div style="position: relative; width:45%;float:left;margin-left: 20px;margin-top: 20px;height:97%;">
            <div style="z-index: 1; margin: 0; width:421px; height:595px; padding:10px; text-align:center; border: 5px solid #787878;border-radius: 10px;text-transform: capitalize;">
                <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50% 6px;
                    background-size: 18%;
                    z-index: 0;
                    position: absolute;
                    width: inherit;
                    height: 100%;
                    opacity: .4">   
                </div>
                <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50%;
                    background-size: 45%;
                    z-index: -1;
                    position: absolute;
                    width: inherit;
                    height: 100%;
                    opacity: .1">   
                </div>
                <div style="text-align: center;position: relative;">
                       <p style="color: #c31616; margin: 0;font-size:23px; font-weight:bold"><?php echo $school_details->school_name; ?></p>
                       <p style="color: #363ac7; margin: 0;font-size:15px;text-transform: uppercase;"><?php echo $school_details->school_address; ?></p>         
                       <p style="color: #363ac7;margin: 0;font-size:15px;text-transform: uppercase;">(estd. <?php echo $school_details->estd; ?>)</p>
                       <div style="border: 1px solid black;border-radius: 3px;position: absolute;height: 70px;width: 60px;top: 33px;right: 3px;">
                          <?php if ($student_details->simage) { ?>
                            <img style="width: 100%;height: 100%" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
                            <?php }else{ ?>
                            <p style="line-height: 40px; text-align: center;">Photo</p>

                            <?php }?>
                       </div>       
                </div>
                
                <div style="margin-top: 5px">
                  <div >
                      <h2 style="margin: 5px;border:2px solid #c31616;margin: auto;width: max-content;padding: 0 30px;box-shadow: 5px 6px 2px -1px #c31616;">Transfer certificate</h2>
                      <div style="position: relative; ">
                        
                        
                        <p style="padding-top: 5px;">
                          <span style="float: left;">No.:_______</span>
                          <span style="float: right;">Date of Issue:______________</span>
                        </p>
                        <p style="position: absolute;top: -14px;left: 10%;font-style: normal;"></p>
                        <p style="position: absolute;top: -14px;left: 74%;font-style: normal;"><?php echo $login_today_date.(($login_date_type==2)? " B.S." : " A.D."); ?></p>
                      </div>
                  </div>
                </div>
                <div style="clear: both;text-align: left;">
                  <ol style="padding: 10px 0 0px 15px;font-style: italic;font-size: 15px;margin-bottom: 8px;">
                    <li style="padding: 3px 0;position: relative;">Name of the student ........................................................................
                      <p style="position: absolute;top: -14px;left: 40%;font-style: normal;"><?php echo $student_details->sname; ?></p>
                    </li>
                    <li style="padding: 3px 0;position: relative;"><?php if($student_details->spname){ echo "Father's Name "; }elseif($student_details->smname){ echo $student_details->smname; }else{ echo "Father's Name "; }; ?> ...................................................................................
                      <p style="position: absolute;top: -14px;left: 30%;font-style: normal;"><?php if($student_details->spname){ echo $student_details->spname; }else{ echo $student_details->smname; }; ?></p>

                    </li>
                    <li style="padding: 3px 0;position: relative;">Address ..............................................................................................
                      <p style="position: absolute;top: -14px;left: 25%;font-style: normal;"><?php echo $student_details->saddress; ?></p>
                    </li>
                    <li style="padding: 3px 0;position: relative;">Date of Addmission ..........................................................................
                      <p style="position: absolute;top: -14px;left: 40%;font-style: normal;"><?php echo (($login_date_type==2)? eToN($student_details->admission_date) : $student_details->admission_date); ?>
                      </p>
                    </li >
                    <li style="padding: 3px 0;position: relative;">Addmission No. .................................................................................
                      <p style="position: absolute;top: -14px;left: 30%;font-style: normal;"><?php echo $student_details->sadmsnno; ?></p>
                    </li>
                    <li style="padding: 3px 0;position: relative;">Date of birth as recorded in the admission register.</li>
                    <div  style="width: 70%;float: right;position: relative;">
                      <p style="margin: 3px 0;">Bikram Sambat(B.S.) ........................................

                      </p>
                        <p style="position: absolute;top: -14px;left: 50%;font-style: normal;"><?php  echo (($login_date_type==2)? eToN($student_details->dob) : $student_details->dob); ?></p>

                      <p style="margin: 3px 0;position: relative;">Anno domini(A.D) ............................................
                      </p>
                        <p style="position: absolute;top: 8px;left: 50%;font-style: normal;"><?php echo $student_details->dob; ?></p>

                    </div>
                    
                    <li style="padding: 3px 0;position: relative;clear: both;">Date on which He/She left school ..................................................
                      <p style="position: absolute;top: -14px;left: 60%;font-style: normal;"><?php  echo (($login_date_type==2)? eToN($student_details->left_date) : $student_details->left_date); ?>
                    </li>
                    <li style="padding: 3px 0;position: relative;">S.L.C registration No. ......................................................................
                      <p style="position: absolute;top: -14px;left: 50%;font-style: normal;"></p>
                    </li>
                    <li style="padding: 3px 0;position: relative;line-height: 22px">Passed/Failed S.L.C. Examination of Geverment of Nepal as a Regular/Exampted student was placed in ....................................... Division with symbol No. ........................... in 20........... / 20...........
                      <p style="position: absolute;top: 8px;left: 70%;font-style: normal;"></p>
                      <p style="position: absolute;top: 30px;left: 40%;font-style: normal;"></p>
                      <p style="position: absolute;top: 30px;left: 75%;font-style: normal;"></p>
                      <p style="position: absolute;top: 30px;left: 90%;font-style: normal;"></p>
                    </li>
                    <li style="padding: 3px 0;position: relative;">He/She passed class .............. is/was  reading in class ..................
                      <p style="position: absolute;top: -14px;left: 35%;font-style: normal;"></p>
                      <p style="position: absolute;top: -14px;left: 85%;font-style: normal;"></p>
                    </li>
                    <li style="padding: 3px 0;position: relative;">Reason for leaving the school .......................................................
                      <p style="position: absolute;top: -14px;left: 55%;font-style: normal;">For Higher Study</p>
                    </li>
                    <p style="text-align: center;margin: 5px 0;">All sums deu by him/her to the school have been paid.<br>i know nothing against his/her moral character.</p>
                  </ol>
                </div>
                <div style="text-align: center;">
                  <div style="width: 50%;float: left;">
                    _____________<br>
                    Checked By
                  </div>
                  <div style="width: 50%;float: left;">
                    _____________<br>
                    Principal
                  </div>
                </div>
              </div>
        </div>

        <?php } ?>
      </div>
    </div>


<?php }
else if($template_id == 1) { ?>

    <div class="col-md-12" align="right" onclick='printDiv();' style="width: 40px;height: 40px; z-index:99; background: red;position: fixed; bottom: 20px;right: 40px;border-radius: 50%;padding: 10px">
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
            /*margin-left: 0px;
            margin-right: 0px;
            margin-top: 0px;
            margin-bottom: 0px;
            margin: 0;*/
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
            -webkit-filter:opacity(1);
        }
    </style>

    <?php
    foreach ($studentarray as $student_id) 
    {
      $student_details = json_decode($backstage->get_student_full_details_by_sid($student_id));

    ?>
    <div style="z-index: 1; margin: 0; width:18cm; height:98%;  text-align:center; border: 5px solid #787878;border-radius: 10px;text-transform: capitalize;position: relative;float: right;">
      <!-- <div style="background: url(../assets/slogo.png) no-repeat 50% 6px;
          background-size: 18%;
          z-index: 0;
          position: absolute;
          width: inherit;
          height: 100%;
          opacity: .4">   
      </div> -->
      <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50%;
          background-size: 45%;
          z-index: -1;
          position: absolute;
          width: inherit;
          height: 100%;
          opacity: .1">   
      </div>
      <!-- headder -->
      <div style="padding:10px;">
        <div style="width: 150px;height: 90px;float: left;">
          <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
        </div>
        <div style="text-align: center;position: relative;padding: 0 5px;">
               <h2 style="font-weight: bolder;margin: 0;">Delhi Public School Biratnagar</h2>
               <div >
                  <p style="margin: 0;font-size: 11px;"> Affiliated to the CBSE india for All India Secondary/Senior School Certificate Examination</p>
                  <p style="margin: 0;font-size: 11px;">Ph - +977-21-462074/75 Fax +977-21-462012 Email - biratnagardps@gmail.com</p>        
                  <p style="margin: 0;font-size: 11px;">Website: www.dpsbiratnagar.com</p>
                  <p style="margin: 0;font-size: 11px;">Affiliation No: 6230012</p>
               </div>           
        </div>
      </div>
      <!-- body -->
      <div style="padding: 10px">
        <div style="position: relative; font-size: 12px;height: 50px">            
          <p style="padding-top: 5px;">
            <span style="float: left;">S No.:_______</span>
            <span style="float: right;">Admission No:_____________________</span><br>
          </p>
          <p>
            <span style="float: right;">CBSE Registration No:_____________________</span>
            
          </p>
          <p style="position: absolute;top: -10px;left: 6%;font-style: normal;">2065</p>
          <p style="position: absolute;top: -10px;left: 82%;font-style: normal;">2065/01/01</p>
          <p style="position: absolute;top: 15px;left: 82%;font-style: normal;">2018CBSE123</p>
        </div>

        <div style="margin-top: 25px;clear: both;">
          <div >
              <h2 style="text-decoration: underline;text-transform: uppercase;"><b>Transfer certificate</b></h2>
          </div>
        </div>
        <!-- <br> -->
        <div style="clear: both;text-align: left;">
          <div style="padding: 5px;font-style: italic;font-size: 16px;margin-bottom: 8px;line-height: 32px;">
            <div style="padding: 3px 0;position: relative;">This is to certify that Master/Miss...............................................................<br> 
            Mother's Name............................................................................. <br>
            Father's Name..............................................................................<br>
            Admitted to this school on ............................... on a Transfer certificate from...............................
            School and left on ............................................ with a ...................................... Character
            He/she was studying in class ................................... All dues** to the school on his/her account have been setteled. His/her date of birth accorting to the Admission Register is ..................................

            (in figure)...................................................................................
              <p style="position: absolute;top: -16px;left: 37%;font-style: normal;"><?php echo $student_details->sname; ?></p>
              <p style="position: absolute;top: 15px;left: 20%;font-style: normal;"><?php  echo $student_details->smname; ?></p>
              <p style="position: absolute;top: 46px;left: 20%;font-style: normal;"><?php echo $student_details->spname; ?></p>
              <p style="position: absolute;top: 77px;left: 30%;font-style: normal;">2010-11-20</p>
              <p style="position: absolute;top: 77px;right: 5%;font-style: normal;">2013-12-20</p>
              <p style="position: absolute;top: 110px;left: 20%;font-style: normal;">2065/02/20</p>
              <p style="position: absolute;top: 110px;left: 60%;font-style: normal;">good</p>
              <p style="position: absolute;top: 143px;left: 25%;font-style: normal;">
              11 (ELEVEN)</p>
              <p style="position: absolute;top: 176px;right: 10%;font-style: normal;">2010-10-10</p>
              <p style="position: absolute;top: 209px;left: 15%;font-style: normal;">Nine june 1995</p>
            </div>
            <div style="position: relative;">
              <p style="text-align: left;margin: 5px 0;">Additional information ............................................................................................................</p>
              <p style="text-align: left;margin: 5px 0;">Promotion has been granted to class.......................................</p>
              
              <p style="position: absolute;top: -20px;left: 30%;font-style: normal;">Got scholorship in all class</p>

              <p style="position: absolute;top: 15px;left: 45%;font-style: normal;">11(Eleven)</p>

            </div>
            
          </div>
        </div>
        <!-- <div style="text-align: center;position: absolute;bottom: 10px;width: 100%">
          <div style="width: 50%;float: left;">
            _____________<br>
            Checked By
          </div>
          <div style="width: 50%;float: left;">
            _____________<br>
            Principal
          </div>
        </div> -->
        <div style="position: relative; font-size: 14px;">            
          <p style="padding: 5px 10px;margin: 10px 0 0 0 ">
            <span style="float: left;">Dated:_________________</span>
            <span style="float: right;padding-right: 50px">Principal</span><br>
          </p>
          <p style="position: absolute;top: -10px;left: 10%;font-style: normal;">2075/10/10</p>
          <!-- <p style="position: absolute;top: -20px;left: 82%;font-style: normal;">principal sign</p> -->
            <img src="../assets/dsign.png" style="position: absolute;top: -20px;left: 82%;height: 30px;width: 70px;margin-bottom: -7px;"><br>

        </div>
      </div>
      <!-- footer -->
      <div style="position: absolute; bottom: 0;width: 100%;">
      <hr style="margin: 0">

        <ul style="text-align: left;margin: 0;font-size: 12px;">
          <li>To be given in words</li>
          <li>Due to school include all payment for for which provision is made in rules supplied to the parents or guardian when the student was admitted to the school</li>
        </ul>
        <hr style="margin: 0">
        <p style="padding: 5px 10px;text-align: left;margin:5px 0;position: relative;">
          <span >Verified:____________________</span>
          <span style="position: absolute;left: 15%;font-style: normal;">Guddu patel</span>

        </p>
      </div>
    </div>
    <div style="z-index: 1; margin: 0; width:10cm; height:98%;  text-align:center; border: 5px solid #787878;border-radius: 10px;text-transform: capitalize;position: relative;float: left;">
      <!-- <div style="background: url(../assets/slogo.png) no-repeat 50% 6px;
          background-size: 18%;
          z-index: 0;
          position: absolute;
          width: inherit;
          height: 100%;
          opacity: .4">   
      </div> -->
      <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50%;
          background-size: 45%;
          z-index: -1;
          position: absolute;
          width: inherit;
          height: 100%;
          opacity: .1">   
      </div>
      <!-- headder -->
      <div style="height: 80px;padding:10px;">
        <div style="width: 90px;height: 60px;float: left;">
          <img style="height: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>">
        </div>
        <div style="text-align: center;position: relative;padding: 0 5px;">
               <h3 style="font-weight: bolder;margin: 0;">Delhi Public School Biratnagar</h3>
               <div >
                  <p style="margin: 0;font-size: 14px;"> Bishal Chowk, Biratnagar-6</p>
                  
               </div>           
        </div>
      </div>
      <!-- body -->
      <div style="padding: 10px">
        <div style="position: relative; font-size: 12px;height: 50px">            
          <p style="padding-top: 5px;">
            <span style="float: left;">S No.:_______</span>
            <span style="float: right;">Admission No:_________________</span><br>
          </p>
          <p>
            <span style="float: right;">CBSE Registration No:_________________</span>
            
          </p>
          <p style="position: absolute;top: -10px;left: 10%;font-style: normal;">2065</p>
          <p style="position: absolute;top: -10px;left: 75%;font-style: normal;">2065/01/01</p>
          <p style="position: absolute;top: 15px;left: 75%;font-style: normal;">2018CBSE123</p>
        </div>

        <div style="margin: 25px 0;clear: both;">
          <div >
              <h3 style="text-decoration: underline;text-transform: uppercase;"><b>Transfer certificate</b></h3>
          </div>
        </div>
        <!-- <br> -->
        <div style="clear: both;text-align: left;">
          <div style="padding: 5px;font-style: italic;font-size: 16px;margin-bottom: 8px;line-height: 32px;">
            <div style="padding: 3px 0;position: relative;overflow-x: hidden;">Student name................................................................ <br>
            Mother's Name.............................................................. <br>
            Father's Name...............................................................<br>
            is/was studying / passed / in class..............................<br>
            Admited on...................................................................<br>
            Previous school............................................................
            ......................................................................................<br>
            Date of birth................................................................<br>
            Issued by.......................................................................<br>
            Received by...................................................................<br>
            Signature...............................................................................<br>
            Date........................................................................................<br>
            Verified by.....................................................................<br>
            Principal........................................................................<br>
            
              <p style="position: absolute;top: -18px;left: 33%;font-style: normal;"><?php echo $student_details->sname; ?></p>
              <p style="position: absolute;top: 15px;left: 35%;font-style: normal;"><?php echo $student_details->smname; ?></p>
              <p style="position: absolute;top: 48px;left: 35%;font-style: normal;"><?php echo $student_details->spname; ?></p>
              <p style="position: absolute;top: 80px;left: 70%;font-style: normal;">Eight</p>
              <p style="position: absolute;top: 113px;left: 30%;font-style: normal;">20665/05/01</p>
              <p style="position: absolute;top: 144px;text-indent: 35%;font-style: normal;">Shree nepal rastriya secondary school </p>
              <!-- <p style="position: absolute;top: 177px;left: 35%;font-style: normal;">2065/02/20</p> -->
              <p style="position: absolute;top: 207px;left: 33%;font-style: normal;">2055/05/25</p>
              <p style="position: absolute;top: 240px;left: 30%;font-style: normal;">Anil </p>
              <p style="position: absolute;top: 270px;left: 25%;font-style: normal;">receiver person</p>
              <p style="position: absolute;top: 303px;left: 22%;font-style: normal;">receiver sign</p>
              <p style="position: absolute;top: 333px;left: 20%;font-style: normal;"> Nine june 1995</p>
              <p style="position: absolute;top: 366px;left: 23%;font-style: normal;">Dr. anurudh</p>
              <!-- <p style="position: absolute;top: 399px;left: 21%;font-style: normal;">principal sign</p> -->
            <img src="../assets/dsign.png" style="position: absolute;top: 419px;left: 21%;height: 30px;width: 70px;margin-bottom: -7px;"><br>


            </div>
            
            
          </div>
        </div>
      </div>
    </div>

    <?php } ?>
  </div>
</div>




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