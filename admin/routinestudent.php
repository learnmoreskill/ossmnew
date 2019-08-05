<?php
include('session.php');
require("../important/backstage.php");

$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'routinestudent';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));
   

if (isset($_GET["token"]) && $_GET["token"]== "hgdsf6egrehwb"){

    $get_year_id = $_GET['year_id'];

    $sclass1 = $_GET['class'];
    $ssec1 = $_GET['section'];
    if (!empty($sclass1) && !empty($ssec1)) {

    $sqlsr1 = "SELECT * FROM `studentroutine` WHERE `year_id` = '$get_year_id' AND `srclass` = '$sclass1' AND `srsec` = '$ssec1'";
    $resultsr1 = $db->query($sqlsr1);
    $rowsubj = $resultsr1->num_rows;
    if($rowsubj > 0) { $found='1';} else{ $found='0';   }

    $csname= json_decode($backstage->get_class_section_name_by_id($sclass1,$ssec1));

}else{ ?> <script> alert('Please select both class and section'); window.location.href = 'routinestudent.php'; </script> <?php }
    
}   

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <!-- script for get section when select class -->
    <script>
      function showUser(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else { 
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var selectDropdown =    $("#txtHint");
                    document.getElementById("txtHint").innerHTML = this.responseText;
                    selectDropdown.trigger('contentChanged');
                }
            };
            xmlhttp.open("GET","../important/getListById.php?classforsection="+str,true);
            xmlhttp.send();
            $('select').on('contentChanged', function() { 
            // re-initialize 
           $(this).material_select();
             });
        }
      }
    </script>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <?php if (isset($_GET["token"]) && $_GET["token"]== "hgdsf6egrehwb"){ ?>
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Student Routine For Class:<?php echo $csname->class_name."-".$csname->section_name; ?></a></div>
                        <?php }else { ?>
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Select Class And Section</a></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="row">
                  <form class="col s12" action="" method="get">
                    <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">
                    <input type="hidden" name="token" value="hgdsf6egrehwb">
                  <div class="row">
                        <div class="input-field col s6">
                            <select name="class" onchange="showUser(this.value)">

                              <option value="" >Select class</option>
                                <?php 
                                foreach ($classList as $clist) {
                                      echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                }
                                ?>
                            </select>
                            <label>Class:</label>
                        </div>                        
                        <div class="input-field col s6">
                          <select name="section" id="txtHint">
                            <option value="" >Select class first</option>
                          </select>
                          <label>Section:</label>
                        </div>
                    </div>
                    <div class="row center">
                      <button class="btn waves-effect waves-light blue lighten-2" type="submit" ><i class="material-icons right">send</i>Next</button><?php if($found == '1'){ ?>

                        <?php if ($login_cat == 1 || $pac['edit_daily_routine']) { ?>
                        &nbsp&nbsp<a href="createstudentroutine.php?token=gr652323r26eygd&action=edit&class=<?php echo $sclass1; ?>&section=<?php echo $ssec1; ?>" class="btn waves-effect waves-light blue lighten-2">
                            <i class="material-icons right">edit</i>Edit</a>

                        <?php } ?>
                        
                        &nbsp&nbsp <button class="btn waves-effect waves-light blue lighten-2" id='btn' value='Print Ledger' onclick='printDiv();' ><i class="material-icons right">print</i>Print</button>
                  <?php } ?>
                        
                    </div>
                  </form>
              </div>

            <?php
            if($found == '1'){
            ?>

            <div id="schoolheader" style="display: none;">
            <?php include_once("../printer/printschlheader.php");?>            
                <div style="text-align: center;">
                    <span class="card-title white-text">Daily Class Routine For Class : <?php echo $csname->class_name."-".$csname->section_name; ?></span>
                </div><br>                                       
            </div>

            <div id="invoice_print" class="row scrollable">
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
                <div class="col s12 m12">
                                <?php while($row = $resultsr1->fetch_assoc()) { ?>
                            <table class="centered bordered striped highlight z-depth-4 table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                                    <thead>
                                        <tr>
                                            <th>.</th>
                                            <th>1st Period</th>
                                            <th>2nd Period</th>
                                            <th>3rd Period</th>
                                            <th>4th Period</th>
                                            <th>5th Period</th>
                                            <th>6th Period</th>
                                            <th>7th Period</th>
                                            <th>8th Period</th>
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        <tr>
                                            <th>Sunday</th>
                                            <td>
                                                <?php echo $row["sun1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sun2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sun3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sun4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sun5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sun6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sun7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["sun8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monday</th>
                                            <td>
                                                <?php echo $row["mon1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["mon8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tuesday</th>
                                            <td>
                                                <?php echo $row["tue1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["tue8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Wednesday</th>
                                            <td>
                                                <?php echo $row["wed1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["wed8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Thursday</th>
                                            <td>
                                                <?php echo $row["thu1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["thu8"]; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Friday</th>
                                            <td>
                                                <?php echo $row["fri1"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri2"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri3"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri4"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri5"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri6"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri7"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $row["fri8"]; ?>
                                            </td>
                                        </tr>
                                 </tbody>
                             </table>
                                    <?php }
                                    ?>
                            </div>
                        </div>
                        <?php
                }else if($found == '0') { ?>
            <div class="row">
                            <div class="col s6 offset-m3 ">
                                <div class="card darken-3">
                                    <div class="card-content center white-text">
                                        <span class="card-title"><span style="color:red;">No Class Routine scheduled !!!</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
            <?php } ?>
        </main>


<!-- add header.php here -->
<?php include_once("../config/footer.php");?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="../printer/js/datatables.responsive.js"></script>
<script src="../printer/js/lodash.min.js"></script>

<script>
  function printDiv() 
{
  var schoolheader=document.getElementById('schoolheader');
  var invoice_print=document.getElementById('invoice_print');  

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+schoolheader.innerHTML+invoice_print.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},100);

}
</script>
