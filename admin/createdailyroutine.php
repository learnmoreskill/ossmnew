<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'createdailyroutine';

$found='2';

$resultclass = $db->query("SELECT * FROM `class`");
$resultteacher = $db->query("SELECT * FROM `teachers`");


if (isset($_GET["class"])){

    $sclass1 = $_GET["class"];
    $ssec1 = $_GET["section"];
    if (!empty($sclass1) && !empty($ssec1)) {

    $sqlsr1 = "SELECT * FROM `routine` INNER JOIN `section` ON `routine`.`section_id` = `section`.`section_id` LEFT JOIN `section` ON `routine`.`section_id` = `section`.`section_id` WHERE srclass='$sclass1' and srsec='$ssec1'";
    $resultsr1 = $db->query($sqlsr1);
    $rowsubj = $resultsr1->num_rows;
    if($rowsubj > 0) { $found='1';} else{ $found='0'; }
}else{ ?> <script> alert('Please select both class and section'); window.location.href = 'createdailyroutine.php'; </script> <?php }

}else if(isset($_GET["teacher"])){

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
            xmlhttp.open("GET","../important/getListById.php.php?q="+str,true);
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
                <div class="row center"><a class="white-text text-lighten-4" href="#">Create Routine</a></div>
            </div>
        </div>
    </div>
    <?php if($found=='2'){ ?>
        <div class="row">
            <div class="col s12"> 
                <div class="card teal center lighten-2">
                    <span class="card-title white-text">Class wise routine</span>
                </div>
            </div>
        </div>
    	<div class="row">
	      <form class="col s12" action="" method="get">
	      <div class="row">
	            <div class="input-field col s6">
	                <select name="class" onchange="showUser(this.value)">

	                  <option value="" >Select class</option>

	                    <?php if ($resultclass->num_rows > 0) {
	                        while($row = $resultclass->fetch_assoc()) { ?>
	                                <option value="<?php echo $row["class_name"];?>"><?php echo $row["class_name"];?></option>
	                    <?php 
	                    }
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
	          <button class="btn waves-effect waves-light blue lighten-2" type="submit" ><i class="material-icons right">send</i>Next</button>
	        </div>
	      </form>
      </div>



          <!-- create routine teacher wise -->
          <div class="row">
            <div class="col s12"> 
                <div class="card teal center lighten-2">
                    <span class="card-title white-text">Teacher wise routine</span>
                </div>
            </div>
        </div>
        <div class="row">
          <form class="col s12" action="" method="get">
          <div class="row">
            <div class="input-field col s12">
                <select name="teacher">

                  <option value="" >Select Teacher</option>

                    <?php if ($resultteacher->num_rows > 0) {
                        while($row1 = $resultteacher->fetch_assoc()) { ?>
                                <option value="<?php echo $row1["tid"];?>"><?php echo $row1["tname"]."\tAddress:".$row1["taddress"];?></option>
                    <?php 
                    }
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



	  
	  <?php  }elseif ($found=='1') {
	  ?>

		<div class="row">
	        <div class="col s12 ">
	            <div class="card grey darken-3">
	                <div class="card-content center white-text">
	                    <span class="card-title"><span style="color:#80ceff;">Routine already exist !!!</span></span>
	                </div>
	            </div>
	        </div>
	    </div>
	  <?php
	  }elseif ($found=='0') {
	  ?>

	<div class="row">
        <form class="col s12" action="createroutinescript1.php" method="post" >
            
        	<input name="sclass1" type="hidden" value="<?php echo $sclass1; ?>" class="validate" >
        	<input name="ssec1" type="hidden" value="<?php echo $ssec1; ?>" class="validate" >

        	<table class="responsive-table centered striped bordered highlight z-depth-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th colspan="2">1st Period</th>
                    <th colspan="2">2nd Period</th>
                    <th colspan="2">3rd Period</th>
                    <th colspan="2">4th Period</th>
                    <th colspan="2">5th Period</th>
                    <th colspan="2">6th Period</th>
                    <th colspan="2">7th Period</th>
                    <th colspan="2">8th Period</th>
                </tr>
                <tr>
                    <th>Time</th>
                    <th><input name="starttime[1]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[1]" type="text" class="timepicker" placeholder="End Time" ></th>
                    <th><input name="starttime[2]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[2]" type="text" class="timepicker" placeholder="End Time" ></th>
                    <th><input name="starttime[3]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[3]" type="text" class="timepicker" placeholder="End Time" ></th>
                    <th><input name="starttime[4]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[4]" type="text" class="timepicker" placeholder="End Time" ></th>
                    <th><input name="starttime[5]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[5]" type="text" class="timepicker" placeholder="End Time" ></th>
                    <th><input name="starttime[6]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[6]" type="text" class="timepicker" placeholder="End Time" ></th>
                    <th><input name="starttime[7]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[7]" type="text" class="timepicker" placeholder="End Time" ></th>
                    <th><input name="starttime[8]" type="text" class="timepicker" placeholder="Start Time" ></th>
                    <th><input name="endtime[8]" type="text" class="timepicker" placeholder="End Time" ></th>
                </tr>
            </thead>
          	<tbody><tr>
                    <th>Sunday</th>
                    <td rowspan="2">
                    	<input name="sundaysub[1]" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[1]" type="text" class="validate" placeholder="teacher name">
                    </td>
                    <td rowspan="2">
                        <input name="sundaysub[2]" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[2]" type="text" class="validate" placeholder="teacher name">
                    </td>
                    <td>
                        <input name="sundaysub[3]" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[3]" type="text" class="validate" placeholder="teacher name">
                    </td>
                    <td>
                        <input name="sundaysub[4]" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[4]" type="text" class="validate" placeholder="teacher name">
                    </td>
                    <td>
                        <input name="sundaysub['5']" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[5]" type="text" class="validate" placeholder="teacher name">
                    </td>
                    <td>
                        <input name="sundaysub[6]" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[6]" type="text" class="validate" placeholder="teacher name">
                    </td>
                    <td>
                        <input name="sundaysub[7]" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[7]" type="text" class="validate" placeholder="teacher name">
                    </td>
                    <td>
                        <input name="sundaysub[8]" type="text" class="validate" placeholder="subject name">
                        <input name="sundayteacher[8]" type="text" class="validate" placeholder="teacher name">
                    </td>
                </tr>
                <tr>
                    <th>Monday</th>
                    <td>
                        <input name="mon1" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="mon2" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="mon3" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="mon4" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="mon5" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="mon6" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="mon7" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="mon8" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                </tr>
                <tr>
                    <th>Tuesday</th>
                    <td>
                        <input name="tue1" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="tue2" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="tue3" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="tue4" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="tue5" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="tue6" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="tue7" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="tue8" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                </tr>
                <tr>
                    <th>Wednesday</th>
                    <td>
                        <input name="wed1" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="wed2" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="wed3" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="wed4" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="wed5" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="wed6" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="wed7" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="wed8" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                </tr>
                <tr>
                    <th>Thursday</th>
                    <td>
                        <input name="thu1" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="thu2" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="thu3" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="thu4" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="thu5" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="thu6" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="thu7" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="thu8" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                </tr>
                <tr>
                    <th>Friday</th>
                    <td>
                        <input name="fri1" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="fri2" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="fri3" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="fri4" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="fri5" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="fri6" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="fri7" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                    <td>
                        <input name="fri8" type="text" class="validate" placeholder="subject/teacher name">
                    </td>
                </tr></tbody>
            </table>


			<div class="row">
                <input type="hidden" name="create_studentroutine">
                <div class="input-field col offset-m10">
                    <button class="btn waves-effect waves-light blue lighten-2" type="submit">Create
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </div>
        </form>
    </div>
	  <?php } ?>

   	</main>
        <!-- add footer.php here -->
<?php include_once("../config/footer.php");?>