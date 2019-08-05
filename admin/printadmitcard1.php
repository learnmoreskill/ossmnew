<?php
include("session.php");
require("../important/backstage.php");
$backstage = new back_stage_class();

$newdate = date("Y-m-d");

  error_reporting( ~E_NOTICE ); // avoid notice


 if( isset( $_POST['printadmitcard_request'] ) )
{
$classname = $_POST['sclass'];
$studentarray = $_POST['student'];
$examid = $_POST['examtypeid'];
$printmode = $_POST['printmode'];

if (empty($classname)) { 
  ?> <script> alert('Please select Class'); window.close(); </script> <?php 
}
if (empty($studentarray)) { 
  ?> <script> alert('Student list is empty'); window.close(); </script> <?php 
}
if (empty($examid)) { 
  ?> <script> alert('Please select exam'); window.close(); </script> <?php 
}

$school_details = json_decode($backstage->get_school_details_by_id());
$examtype_details = json_decode($backstage->get_examtype_details_by_examid($examid));

//$exam_created_date = $backstage->get_exam_created_date_by_class_examtype($classname,$examtype_details->examtype_id);

$examtable_details = json_decode($backstage->get_examtable($classname,$examtype_details->examtype_id));
if (empty($examtable_details)) { 
  ?> <script>var r= confirm('Exam routine not found!! \n Are you sure want to continue?'); 
  if (r) {

  }else {
    window.close();
  }


  </script> <?php 
}
}
?>
<?php if ($printmode=='0') { ?>
<div class="col-md-12" align="right" onclick='printDiv();' style="width: 40px;height: 40px;background: red;position: fixed; bottom: 20px;right: 40px;border-radius: 50%;padding: 10px">
      <img src="../images/printIcon.png" style="width: 90%;height: 90%;">
  </div>
 <div class="container" >


  




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

?>

<div style="position: relative; border: 1px solid red;border-radius: 10px;width:45%;float:left;margin-left: 20px;margin-top: 20px;height:48%;">
     
         <table width="100%" style="border-bottom: 1px solid #a8adac;">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
                        <td style="">
                         <p style="font-size: 20;font-style: bold;margin-top: -20px;margin-left:-20px; text-transform: capitalize;"><?php echo $school_details->school_name; ?></p>
                        <p style="margin-top: -20px;margin-left:-20px; text-transform: capitalize;"><?php echo $school_details->school_address; ?></p>
                        <p style="margin-top: -15px;margin-left:-20px;"><?php echo $school_details->phone_no; ?></p>
                        </td>
                      </tr>
                        
                    </td>

                </tr>
            </tbody>
        </table>
        <div style="text-align: center;font-size:16px; font-weight: bold;"><?php echo $examtype_details->examtype_name; ?> : Admit Card</div>
      
        <br>
        <table width="100%" border="0"  style="margin-top: -10px;padding-left: 20px;padding-right: 20px;">    
            <tbody>
                <tr>
                    <td  valign="top" style="width:80%; text-transform: capitalize;">
                        Name:<?php echo $student_details->sname; ?>
                       
                        <br>
                        Roll no: 
                        <?php echo $student_details->sroll; ?>
                        <br>
                        Class : 
                        <?php echo $student_details->class_name."&nbsp&nbsp&nbsp&nbsp&nbsp Section : ".$student_details->section_name ?>
                        <br>            
                    </td>
                    <td  valign="top" >

                      <div style=" overflow: hidden; border: 1px solid black;border-radius: 10px; height: 70px; width: 60px;">
                        <?php if ($student_details->simage) { ?>
                        <img style="height: inherit; width: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
                        <?php }else{ ?>
                        <p style="line-height: 40px; text-align: center;">Photo</p>

                        <?php }?>
                      </div>

                       
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
            <thead>
                <tr>
                    <td width="30%">Date</td>
                    <td width="40%">Subject</td>
                    <td width="30%">Time</td>
                </tr>
            </thead>
          </table>
          <table class="table table-bordered" width="100%"  style="padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;">
            <tbody>
                <?php
                foreach($examtable_details as $key1)
                {
                    echo "<tr>
                      <td style='font-size: 11;' width='30%'>".(($login_date_type==2)? eToN($key1->date) : $key1->date)."</td>
                      <td style='font-size: 11; text-transform: capitalize;' width='40%'>".substr($key1->subject_name,0,13).((strlen($key1->subject_name) > 13) ? '..':'')."</td>
                      <td style='font-size: 11;' width='30%'>".date("h:i A", strtotime($key1->time))."</td>
                      </tr>";
                  }

                ?>
            </tbody>
           
        </table>

        <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
        <tbody>
            <tr>
            </tr>
        </tbody>      
        </table>

            <div style="position: absolute; bottom: 10px;width: 100%; ">
              <P style="padding: 0 10px;">
               <span style="float:left; text-align: center;"><u>________________</u><br> Accountant</span>

              <?php if ($school_details->sign) { ?>
                  <div style="top: 0px;position: absolute;left: 220px; z-index: 999;">
                    <img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->sign; ?>" style="height: 30px;width: 70px;margin-bottom: -7px;">
                  </div>
              <?php } ?>               

               <span  style="float:right; text-align: center;"><u>________________</u><br> Principal</span></span>​
              </P>
            </div>
                    
            

</div>


<?php 
}
?>
</div>
</div>

<?php }elseif ($printmode=='1') { ?>


<div class="container">
  <div class="col-md-12" align="right" style="margin-right: 130px;">
    <input type='button' id='btn' value='Print' onclick='printDiv();'>
  </div>
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

?>

  <div style="position: relative; border: 1px solid red;border-radius: 10px;width:95%;float:left;margin-left: 20px; margin-bottom: 5px; height:33%;">
        
    <!-- <div id="invoice_print" style="margin-bottom: 20px;"> -->
         <table width="100%" style="border-bottom: 1px solid #a8adac;">
            <tbody>
                <tr>
                    <td align="center">
                      <tr align="center">
                        <td width="100px"><img src="../uploads/<?php echo $fianlsubdomain; ?>/logo/<?php echo $school_details->slogo; ?>" width="80px" height="80px"></td>
                        <td style="">
                         <p style="font-size: 20;font-style: bold;margin: 0;text-transform: capitalize;"><?php echo $school_details->school_name; ?></p>
                        <p style="margin: 0; text-transform: capitalize;"><?php echo $school_details->school_address; ?></p>
                        <!-- <p style="margin-top: -20px;margin-left:-20px;"><?php echo $school_details->phone_no; ?></p> -->
                        <p style="text-align: center;font-size:16px; font-weight: bold;margin: 0"><?php echo $examtype_details->examtype_name; ?> : Admit Card</p>
                        </td>
                        <td  valign="top" >

                          <div style=" overflow: hidden; border: 1px solid black;border-radius: 10px; height: 70px; width: 60px;">
                            <?php if ($student_details->simage) { ?>
                            <img style="height: inherit; width: inherit;" src="../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/<?php echo $student_details->simage; ?>">
                            <?php }else{ ?>
                            <p style="line-height: 40px; text-align: center;">Photo</p>

                            <?php }?>
                          </div>
                        </td>
                      </tr>
                        
                    </td>

                </tr>
            </tbody>
        </table>
        
        <!-- <div style="float: right;font-size: 12px;margin-top: -10px;margin-right: 10px;">PAN No:<?php echo $school_details->pan_no; ?></div> -->
        <!-- <br> -->
        <table width="100%" border="0"  style="padding
        :auto 20px;">    
            <tbody>
                <tr>
                    <td  valign="top" style="width:60%;text-transform: capitalize;">
                        Name:<?php echo $student_details->sname; ?>
                          
                    </td>
                    <td  valign="top" style="width:20%;">
                        Roll no: 
                        <?php echo $student_details->sroll; ?>
                    </td>
                    <td  valign="top" style="width:20%;">
                        Class : 
                        <?php echo $student_details->class_name." ".$student_details->section_name ?>
                    </td>
                   
                </tr>
            </tbody>
        </table>
        
      <!-- payment history -->
        <table class="table table-bordered" width="50%"  style="border-right: 1px solid #a8adac; padding:0 20px; border-top:1px solid #a8adac;float: left;">
            <thead>
                <tr>
                    <td width="40%">Subject</td>
                    <td width="30%">Date</td>
                    <td width="30%">Time</td>
                </tr>
            </thead>
        </table>
        <table class="table table-bordered" width="50%"  style=" padding:0 20px;border-top:1px solid #a8adac;float: left;">
            <thead>
                <tr>
                    <td width="40%">Subject</td>
                    <td width="30%">Date</td>
                    <td width="30%">Time</td>
                </tr>
            </thead>
        </table>
        <?php
          $index = 0;
          foreach($examtable_details as $key1) { ?>
            <table class="table table-bordered" width="50%"  style="<?php if ($index%2==0) { echo "border-right: 1px solid #a8adac;";} ?> padding-left: 20px;padding-right: 20px;border-top:1px solid #a8adac;float: left;">
                <tbody>
                    
                       <?php echo "<tr>
                        <td style='font-size: 11;text-transform: capitalize;' width='40%'>".substr($key1->subject_name,0,13).((strlen($key1->subject_name) > 13) ? '..':'')."</td>
                          <td style='font-size: 11;' width='30%'>".(($login_date_type==2)? eToN($key1->date) : $key1->date)."</td>
                          <td style='font-size: 11;' width='30%'>".date("h:i A", strtotime($key1->time))."</td>
                          </tr>";
                           ?>
                      
                    
                </tbody>
               
            </table>
        <?php $index++; } ?>

        <table style="border-top:1px solid #a8adac;width:100%;padding-left: 20px;">  
          <tbody>
              <tr>
              </tr>
          </tbody>      
        </table>

            <div style="position: absolute; bottom: 10px;width: 100%; ">
              <P style="padding: 0 10px;">
               <span style="float:left; text-align: center;"><u>________________</u><br> Accountant</span>
               <span  style="float:right; text-align: center;"><u>________________</u><br> Principal</span></span>​
              </P>
            </div>
                    
            

</div>


<?php 
}
?>
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