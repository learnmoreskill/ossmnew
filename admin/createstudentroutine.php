<?php
include('session.php');
require("../important/backstage.php");

$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'createstudentroutine';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

$found='2';

if (isset($_GET["token"])){
    $longid1 = ($_GET["token"]);

    if ($longid1=="gr652323r26eygd") {

        $get_year_id = $_GET['year_id'];

        $sclass1 = $_GET['class'];
        $ssec1 = $_GET['section'];
        $action = $_GET['action'];

        if ($action == "create") {
           if (!empty($sclass1) && !empty($ssec1)) {

            $sqlsr1 = "SELECT * FROM `studentroutine` WHERE `year_id` = '$get_year_id' AND `srclass`='$sclass1' AND `srsec`='$ssec1'";
            $resultsr1 = $db->query($sqlsr1);
            $rowsubj = $resultsr1->num_rows;
            if($rowsubj > 0) { $found='1';} else{ $found='0'; }
           }else{ ?> <script> alert('Please select both class and section'); window.location.href = 'createstudentroutine.php'; </script> <?php }
        }elseif ($action == "edit") {
           $resultsr2 = $db->query("SELECT * FROM `studentroutine` WHERE `year_id` = '$get_year_id' AND  `srclass`='$sclass1' AND `srsec`='$ssec1'");
           
            $rowsEdit = $resultsr2->fetch_assoc();
            extract($rowsEdit);

           $found = '0';
        }

        $csname= json_decode($backstage->get_class_section_name_by_id($sclass1,$ssec1));

        

    }
}

?>
<!-- add header.php here -->
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
                <div class="row center"><a class="white-text text-lighten-4" href="#">Create Routine for class:<?php echo $csname->class_name."-".$csname->section_name; ?></a></div>
            </div>
        </div>
    </div>

    <?php if($found=='2'){ ?>
    	<div class="row">
	      <form class="col s12" action="" method="get" >
            <input type="hidden" name="token" value="gr652323r26eygd" >
            <input type="hidden" name="year_id" value="<?php echo $year_id; ?>" >
            <input type="hidden" name="action" value="create" >
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
	        <div class="col offset-m5">
	          <button class="btn waves-effect waves-light blue lighten-2" type="submit"><i class="material-icons right">send</i>Next</button>
	        </div>
	      </form>
	  </div>
	  <?php  }elseif ($found=='1') {
	  ?>

		<div class="row">
	        <div class="col s12 ">
	            <div class="card grey darken-3">
	                <div class="card-content center white-text">
	                    <div class="card-title" >
                            <span style="color:#80ceff;">Routine already exist !!!</span>

                            <?php if ($login_cat == 1 || $pac['edit_daily_routine'] == 1) { ?>
                                <br><a class="white-text" href="createstudentroutine.php?token=gr652323r26eygd&year_id=<?php echo $get_year_id; ?>&action=edit&class=<?php echo $sclass1; ?>&section=<?php echo $ssec1; ?>">Click here to edit</a>
                            <?php } ?>
                        </div>
	                </div>
	            </div>
	        </div>
	    </div>
	  <?php
	  }elseif ($found=='0') {
	  ?>

	<div class="row">
        <form id="create_student_routine" class="col s12" action="createroutinescript.php" method="post" >

            <input name="year_id" type="hidden" value="<?php echo $get_year_id; ?>"  >
            
        	<input name="sclass1" type="hidden" value="<?php echo $sclass1; ?>"  >
        	<input name="ssec1" type="hidden" value="<?php echo $ssec1; ?>"  >

            <input type="hidden" <?php if ($action == 'create') { echo 'name="create_studentroutine"'; }elseif ($action == 'edit') { echo 'name="update_studentroutine" value="'.$srid.'"'; } ?> >

        	<table class="responsive-table centered striped bordered highlight z-depth-4">
            <thead><tr>
                    <th>.</th>
                    <th>1st Period</th>
                    <th>2nd Period</th>
                    <th>3rd Period</th>
                    <th>4th Period</th>
                    <th>5th Period</th>
                    <th>6th Period</th>
                    <th>7th Period</th>
                    <th>8th Period</th>
            </tr></thead>
          	<tbody><tr>
                    <th>Sunday</th>
                    <td>
                    	<input name="sun1" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun1; } ?>" >
                    </td>
                    <td>
                        <input name="sun2" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun2; } ?>" >
                    </td>
                    <td>
                        <input name="sun3" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun3; } ?>" >
                    </td>
                    <td>
                        <input name="sun4" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun4; } ?>" >
                    </td>
                    <td>
                        <input name="sun5" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun5; } ?>" >
                    </td>
                    <td>
                        <input name="sun6" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun6; } ?>" >
                    </td>
                    <td>
                        <input name="sun7" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun7; } ?>" >
                    </td>
                    <td>
                        <input name="sun8" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $sun8; } ?>" >
                    </td>
                </tr>
                <tr>
                    <th>Monday</th>
                    <td>
                        <input name="mon1" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon1; } ?>" >
                    </td>
                    <td>
                        <input name="mon2" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon2; } ?>" >
                    </td>
                    <td>
                        <input name="mon3" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon3; } ?>" >
                    </td>
                    <td>
                        <input name="mon4" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon4; } ?>" >
                    </td>
                    <td>
                        <input name="mon5" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon5; } ?>" >
                    </td>
                    <td>
                        <input name="mon6" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon6; } ?>" >
                    </td>
                    <td>
                        <input name="mon7" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon7; } ?>" >
                    </td>
                    <td>
                        <input name="mon8" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $mon8; } ?>" >
                    </td>
                </tr>
                <tr>
                    <th>Tuesday</th>
                    <td>
                        <input name="tue1" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue1; } ?>" >
                    </td>
                    <td>
                        <input name="tue2" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue2; } ?>" >
                    </td>
                    <td>
                        <input name="tue3" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue3; } ?>" >
                    </td>
                    <td>
                        <input name="tue4" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue4; } ?>" >
                    </td>
                    <td>
                        <input name="tue5" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue5; } ?>" >
                    </td>
                    <td>
                        <input name="tue6" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue6; } ?>" >
                    </td>
                    <td>
                        <input name="tue7" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue7; } ?>" >
                    </td>
                    <td>
                        <input name="tue8" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $tue8; } ?>" >
                    </td>
                </tr>
                <tr>
                    <th>Wednesday</th>
                    <td>
                        <input name="wed1" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed1; } ?>" >
                    </td>
                    <td>
                        <input name="wed2" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed2; } ?>" >
                    </td>
                    <td>
                        <input name="wed3" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed3; } ?>" >
                    </td>
                    <td>
                        <input name="wed4" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed4; } ?>" >
                    </td>
                    <td>
                        <input name="wed5" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed5; } ?>" >
                    </td>
                    <td>
                        <input name="wed6" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed6; } ?>" >
                    </td>
                    <td>
                        <input name="wed7" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed7; } ?>" >
                    </td>
                    <td>
                        <input name="wed8" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $wed8; } ?>" >
                    </td>
                </tr>
                <tr>
                    <th>Thursday</th>
                    <td>
                        <input name="thu1" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu1; } ?>" >
                    </td>
                    <td>
                        <input name="thu2" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu2; } ?>" >
                    </td>
                    <td>
                        <input name="thu3" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu3; } ?>" >
                    </td>
                    <td>
                        <input name="thu4" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu4; } ?>" >
                    </td>
                    <td>
                        <input name="thu5" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu5; } ?>" >
                    </td>
                    <td>
                        <input name="thu6" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu6; } ?>" >
                    </td>
                    <td>
                        <input name="thu7" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu7; } ?>" >
                    </td>
                    <td>
                        <input name="thu8" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $thu8; } ?>" >
                    </td>
                </tr>
                <tr>
                    <th>Friday</th>
                    <td>
                        <input name="fri1" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri1; } ?>" >
                    </td>
                    <td>
                        <input name="fri2" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri2; } ?>" >
                    </td>
                    <td>
                        <input name="fri3" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri3; } ?>" >
                    </td>
                    <td>
                        <input name="fri4" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri4; } ?>" >
                    </td>
                    <td>
                        <input name="fri5" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri5; } ?>" >
                    </td>
                    <td>
                        <input name="fri6" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri6; } ?>" >
                    </td>
                    <td>
                        <input name="fri7" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri7; } ?>" >
                    </td>
                    <td>
                        <input name="fri8" type="text" class="validate" placeholder="subject/teacher name" value="<?php if($action == "edit"){ echo $fri8; } ?>" >
                    </td>
                </tr></tbody>
            </table>


			<div class="row">
                <div class="input-field col offset-m10">
                    <button class="btn waves-effect waves-light blue lighten-2" type="submit"> <?php if ($action == "create") { echo "Create"; } elseif ($action == "edit") { echo "Update"; } ?> <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
	  <?php } ?>

   	</main>
        <!-- add footer.php here -->
<?php include_once("../config/footer.php");?>

<?php
if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }
?> 

<script>
$(document).ready(function (e) 
{
  $("#create_student_routine").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "createroutinescript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#err").fadeOut();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Routine is succesfully created'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else 
              if (data.trim() === 'Routine is succesfully created'.trim()) {

              window.location.href = 'createstudentroutine.php';
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));  
});

</script>
