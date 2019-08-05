<?php
include('session.php');
require("../important/backstage.php");

$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'routineteacher';

$year_id = $current_year_session_id;

$found='2';

$teacherList= json_decode($backstage->get_active_teacher_list());

if (isset($_GET["token"]) && $_GET["token"]== "hgdsfty78rehwb"){

    $teacher_id = $_GET['teacher'];
    if (!empty($teacher_id)) {

    $sqlsr1 = "SELECT * FROM `troutine` WHERE `trtid`='$teacher_id'";
    $resulttr1 = $db->query($sqlsr1);
    $rowsubj = $resulttr1->num_rows;
    $rowsEdit = $resulttr1->fetch_assoc();
    extract($rowsEdit);
    if($rowsubj > 0) { $found='1';} else{ $found='0';   }

    }else{ ?> <script> alert('Please select teacher'); window.location.href = 'routineteacher.php'; </script> <?php }
    
}   

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <!-- script for get section when select class -->
    

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Teacher Routine</a></div>
                    </div>
                </div>
            </div>

            <?php if($found=='2'){ ?>

            <div class="row">
                  <form class="col s12" action="" method="get">
                    <input type="hidden" name="token" value="hgdsfty78rehwb">
                  <div class="row">
                        <div class="input-field col s12">
                            <select name="teacher">

                              <option value="" >Select Teacher</option>

                                <?php foreach ($teacherList as $tlist) { ?>
                                            <option value="<?php echo $tlist->id; ?>"><?php echo $tlist->name."\tAddress:".$tlist->address; ?></option>
                                <?php 
                                }
                                ?>
                            </select>
                            <label>Teacher:</label>
                        </div>
                    </div>
                    <div class="col offset-m5">
                      <button class="btn waves-effect waves-light blue lighten-2" type="submit" ><i class="material-icons right">send</i>Next</button>
                    </div>
                  </form>
              </div>

            <?php
            }elseif($found == '1'){
            ?>
            <div class="row center"><br>
                <?php if($found == '1'){ ?>


                        <?php if ($login_cat == 1 || $pac['edit_daily_routine']) { ?>

                        &nbsp&nbsp<a href="createteacherroutine.php?token=gr652t6y7u26eygd&action=edit&teacher=<?php echo $teacher_id; ?>" class="btn waves-effect waves-light blue lighten-2"><i class="material-icons right">edit</i>Edit</a>

                        <?php } ?>


                        &nbsp&nbsp <button class="btn waves-effect waves-light blue lighten-2" id='btn' value='Print Ledger' onclick='printDiv();' ><i class="material-icons right">print</i>Print</button>
                  <?php } ?>
                  <br>
            </div>

            <div id="schoolheader" style="display: none;">
            <?php include_once("../printer/printschlheader.php");?>            
                <div style="text-align: center;">
                    <span class="card-title white-text">Daily Class Routine For Teacher : <?php echo $tname; ?></span>
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
                                <tbody>    <tr>
                                            <th>Sunday</th>
                                            <td>
                                                <?php echo $sun1; ?>
                                            </td>
                                            <td>
                                                <?php echo $sun2; ?>
                                            </td>
                                            <td>
                                                <?php echo $sun3; ?>
                                            </td>
                                            <td>
                                                <?php echo $sun4; ?>
                                            </td>
                                            <td>
                                                <?php echo $sun5; ?>
                                            </td>
                                            <td>
                                                <?php echo $sun6; ?>
                                            </td>
                                            <td>
                                                <?php echo $sun7; ?>
                                            </td>
                                            <td>
                                                <?php echo $sun8; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Monday</th>
                                            <td>
                                                <?php echo $mon1; ?>
                                            </td>
                                            <td>
                                                <?php echo $mon2; ?>
                                            </td>
                                            <td>
                                                <?php echo $mon3; ?>
                                            </td>
                                            <td>
                                                <?php echo $mon4; ?>
                                            </td>
                                            <td>
                                                <?php echo $mon5; ?>
                                            </td>
                                            <td>
                                                <?php echo $mon6; ?>
                                            </td>
                                            <td>
                                                <?php echo $mon7; ?>
                                            </td>
                                            <td>
                                                <?php echo $mon8; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Tuesday</th>
                                            <td>
                                                <?php echo $tue1; ?>
                                            </td>
                                            <td>
                                                <?php echo $tue2; ?>
                                            </td>
                                            <td>
                                                <?php echo $tue3; ?>
                                            </td>
                                            <td>
                                                <?php echo $tue4; ?>
                                            </td>
                                            <td>
                                                <?php echo $tue5; ?>
                                            </td>
                                            <td>
                                                <?php echo $tue6; ?>
                                            </td>
                                            <td>
                                                <?php echo $tue7; ?>
                                            </td>
                                            <td>
                                                <?php echo $tue8; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Wednesday</th>
                                            <td>
                                                <?php echo $wed1; ?>
                                            </td>
                                            <td>
                                                <?php echo $wed2; ?>
                                            </td>
                                            <td>
                                                <?php echo $wed3; ?>
                                            </td>
                                            <td>
                                                <?php echo $wed4; ?>
                                            </td>
                                            <td>
                                                <?php echo $wed5; ?>
                                            </td>
                                            <td>
                                                <?php echo $wed6; ?>
                                            </td>
                                            <td>
                                                <?php echo $wed7; ?>
                                            </td>
                                            <td>
                                                <?php echo $wed8; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Thursday</th>
                                            <td>
                                                <?php echo $thu1; ?>
                                            </td>
                                            <td>
                                                <?php echo $thu2; ?>
                                            </td>
                                            <td>
                                                <?php echo $thu3; ?>
                                            </td>
                                            <td>
                                                <?php echo $thu4; ?>
                                            </td>
                                            <td>
                                                <?php echo $thu5; ?>
                                            </td>
                                            <td>
                                                <?php echo $thu6; ?>
                                            </td>
                                            <td>
                                                <?php echo $thu7; ?>
                                            </td>
                                            <td>
                                                <?php echo $thu8; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Friday</th>
                                            <td>
                                                <?php echo $fri1; ?>
                                            </td>
                                            <td>
                                                <?php echo $fri2; ?>
                                            </td>
                                            <td>
                                                <?php echo $fri3; ?>
                                            </td>
                                            <td>
                                                <?php echo $fri4; ?>
                                            </td>
                                            <td>
                                                <?php echo $fri5; ?>
                                            </td>
                                            <td>
                                                <?php echo $fri6; ?>
                                            </td>
                                            <td>
                                                <?php echo $fri7; ?>
                                            </td>
                                            <td>
                                                <?php echo $fri8; ?>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                                    
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
