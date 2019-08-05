<?php
include("session.php");
require("../important/backstage.php");

$backstage = new back_stage_class();


$year_id = $_POST['year_id'];

  error_reporting( ~E_NOTICE ); // avoid notice

  if( isset( $_POST['generate_multiple_character'] ) ){

    $studentarray = $_POST['multistudent'];

  }
  else if( isset( $_POST['generate_single_character'] ) ){

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
      $student_details = json_decode($backstage->get_student_full_details_by_student_id_year_id($student_id,$year_id));

    ?>
    <div style="position: relative; width:45%;float:left;margin-left: 20px;margin-top: 20px;height:97%;">
        <div style="z-index: 1; margin: 0; width:421px; height:595px; padding:10px; text-align:center; border: 5px solid #787878;border-radius: 10px;text-transform: capitalize;position: relative;">
            <div style="background: url(../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>) no-repeat 50% -2px;
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
                   <p style="color: #c31616; margin: 0;font-size:23px; font-weight:bold;"><?php echo $school_details->school_name; ?></p>
                   <p style="color: #363ac7; margin: 0;font-size:15px;text-transform: uppercase;"><?php echo $school_details->school_address; ?></p>         
                   <p style="color: #363ac7;margin: 0;font-size:15px;text-transform: uppercase;">(estd. <?php echo $school_details->estd; ?>)</p>
                   <!-- <div style="border: 1px solid black;border-radius: 3px;position: absolute;height: 70px;width: 60px;top: 33px;right: 3px;">
                      <img style="width: 100%;height: 100%" src="../assets/slogo.png"> -->
                      <!-- <p style="line-height: 32px">photo</p> -->
                   <!-- </div>         -->
            </div>
            
            <div style="margin-top: 5px">
              <div >
                  <h2 style="margin: 5px;border:2px solid #c31616;margin: auto;width: max-content;padding: 0 30px;box-shadow: -4px -4px 2px -1px #c31616;">Character certificate</h2>
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
            <br>
            <div style="clear: both;text-align: left;">
              <div style="padding: 10px 0 0px 15px;font-style: italic;font-size: 16px;margin-bottom: 8px;line-height: 30px;">
                <div style="padding: 3px 0;position: relative;"> &emsp;&emsp;This is to certify that ....................................................... son/Daughter of ............................................................. is/was a student of this school & had/has been studing in class .......................... passed/failed <?php if ($student_details->class_name=='10') { echo "S.L.C."; }else{ if (is_numeric($student_details->class_name)){echo "Class ".$student_details->class_name;}else{ echo $student_details->class_name;} } ?> exam in .................... division in academic year .......................... He/She is/was a disciplined student and his/her conduct is .......................... He/She bears/bore ..................................... character.
                  <p style="position: absolute;top: -14px;left: 47%;font-style: normal;"><?php echo $student_details->sname; ?></p>
                  <p style="position: absolute;top: 14px;left: 30%;font-style: normal;"><?php if($student_details->spname){ echo $student_details->spname; }else{ echo $student_details->smname; }; ?></p>
                  <p style="position: absolute;top: 75px;left: 4%;font-style: normal;"><?php echo $student_details->class_name; ?></p>
                  <!-- <p style="position: absolute;top: 75px;left: 77%;font-style: normal;">second</p> -->
                  <!-- <p style="position: absolute;top: 105px;left: 50%;font-style: normal;">2065</p> -->
                  <p style="position: absolute;top: 135px;left: 75%;font-style: normal;">good</p>
                  <p style="position: absolute;top: 165px;left: 35%;font-style: normal;">good moral</p>
                </div>
                
                <p style="text-align: center;margin: 5px 0;">I wish him/her a brilliant career and a presprous Life.</p>
              </div>
            </div>
            <div style="text-align: center;position: absolute;bottom: 10px;width: 100%">
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
            size:A4 portrait;
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
    <div style="z-index: 1; margin: 0; width:21cm; height:29.7cm;  text-align:center; border: 5px solid #787878;border-radius: 10px;text-transform: capitalize;position: relative;">
    
    <div style="background: url(../assets/dpsLogo.png) no-repeat 50%;
        background-size: 45%;
        z-index: -1;
        position: absolute;
        width: inherit;
        height: 100%;
        opacity: .1">   
    </div>
    <!-- header -->
    <div style="height: 150px;padding:10px;">
      <div style="width: 150px;height: 90px;float: left;">
        <img style="height: inherit;" src="../assets/dpsLogo.png">
      </div>
      <div style="text-align: center;position: relative;padding: 0 5px;">
                <p style="margin: 0;font-size: 11px;"> "Shaping your child career"</p>

             <h1 style="font-weight: bolder;margin: 0;text-transform: uppercase;text-decoration: underline;">Delhi Public School Biratnagar</h1>
             <!-- <div >
                <p style="margin: 0;font-size: 11px;"> Affiliated to the CBSE india for All India Secondary/Senior School Certificate Examination</p>
                <p style="margin: 0;font-size: 11px;">Ph - +977-21-462074/75 Fax +977-21-462012 Email - biratnagardps@gmail.com</p>        
                <p style="margin: 0;font-size: 11px;">Website: www.dpsbiratnagar.com</p>
                <p style="margin: 0;font-size: 11px;">Affiliation No: 6230012</p>
             </div>    -->        
      </div>
    </div>
    <!-- body -->
    <div style="padding:10px;">
      <div style="position: relative; font-size: 12px;">            
        <p style="padding: 20px;">
          <!-- <span style="float: left;">Chalan No.:_______</span> -->
          <span style="float: right;">Date:_______________________</span><br>
        </p>
        <!-- <p style="position: absolute;top: -10px;left: 15%;font-style: normal;">2065</p> -->
        <p style="position: absolute;top: 5px;left: 82%;font-style: normal;">2065/01/01</p>
      </div>

      <div style="margin: 25px 0;clear: both;">
        <div >
            <h2 style="text-decoration: underline;text-transform: uppercase;"><b>Character certificate</b></h2>
            
        </div>
      </div>
      <div style="clear: both;text-align: left;">
        <div style="padding: 0;font-style: italic;font-size: 16px;line-height: 30px;">
          <div style="padding: 3px 0;position: relative;">This is to certify that ........................................................ son/daugther of ............................................................. and 
          ...........................................................was a bonafide student of this institution from ................................... and has passed the Secondary Education Examination Conducted by the National Examination Board in ................................... His/Her registration no. is ................................................. and date of birth as recorded in our school register is ................................... The symbol no. of the last examination he/she appeared for is ..............................................
          <br>
          <br>
          The school has no objection if he/she wishes to pursue further studies anywhere else.<br>
          We have nothing against his moral character. <br>
          I wish him/her every success in his/her future endeavours.  
            <p style="position: absolute;top: -14px;left: 20%;font-style: normal;">mister guddu kumar patel</p>
            <p style="position: absolute;top: -14px;right: 13%;font-style: normal;">Bidhalal prasad kurmi</p>
            <p style="position: absolute;top: 15px;left: 3%;font-style: normal;">mises Champa devi kurmin</p>
            <p style="position: absolute;top: 15px;right: 15%;font-style: normal;">2064 B.S</p>
            <p style="position: absolute;top: 44px;right: 8%;font-style: normal;"> 2064 B.S.</p>
            <p style="position: absolute;top: 75px;left: 25%;font-style: normal;">0370391 U</p>
            <p style="position: absolute;top: 105px;left: 3%;font-style: normal;">2010/10/10 </p>
            <p style="position: absolute;top: 105px;right: 10%;font-style: normal;">DCOM-1284-008</p>
          </div>
          
          
        </div>
      </div>
      <div style="position: relative; font-size: 12px; margin-top: 100px">            
        <!-- <p style="padding: 5px 10px;margin: 10px 0 0 0 ">
          <span style="float: right;padding-right: 50px">Principal</span><br>
        </p> -->
        <div style="position: absolute;top: -16px;left: 82%;">
          <img src="../assets/dsign.png" style="height: 30px;width: 70px;margin-bottom: -7px;"><br>
          <span>____________________</span>
          <p style="font-size: 9px ">Principal</p>
          
        </div>
        <!-- <p style="position: absolute;top: -16px;left: 82%;font-style: normal;">principal sign</p> -->
      </div>
    </div>
    <!-- footer -->
    <div style="position: absolute; bottom: 0;width: 100%;">
        <div>
          <img style="height: 50px;width: 50px" src="../assets/dpsLogo.png">
        <img style="height: 50px;width: 50px" src="../assets/dpsLogo.png">
        <p style="margin: 0;">ISO 9001:2008</p>
        <p>Registered no. I/qsc-6601</p>
        </div>
        <div style="background: green;padding: 10px">
          <p style="margin: 0;font-size: 14px;">Bishal Chowk, Biratnagar-6, Morang,Nepal,Ph - +977-21-462074/75 Fax +977-21-462012 </p>
          <p style="margin: 0;font-size: 12px;"> Email - biratnagardps@gmail.com,     
               Website: www.dpsbiratnagar.com</p>              
        </div>
        
    </div>
    
  </div>

    <?php } ?>
  </div>
</div>




<?php } ?>








    
<script>
  function printDiv() {

    var invoice_print=document.getElementById('invoice_print');

    var newWin=window.open('','Print-Window');

    newWin.document.open();

    newWin.document.write('<html><body onload="window.print()">'+invoice_print.innerHTML+'</body></html>');

    newWin.document.close();

    setTimeout(function(){newWin.close();},100);

  }
</script>