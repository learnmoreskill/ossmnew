<?php
include('session.php');

require('../config/gettrackerinfo.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'trackbus';

$transportation_details = json_decode($backstage->get_transportation_details());

if (isset($_GET["token"])){
            $longid1 = ($_GET["token"]);

            if ($longid1=="2ec9ys77io89s9") {
              if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);

            $trackerlogin = json_decode($backstage->get_tracker_details_by_id($shortid));
            $md5pw=md5("qFtAQwsz".$trackerlogin->tracker_password);
            $trackresult= json_decode(getTrackerDetails($trackerlogin->tracker_username, $md5pw));

            $found='1';


}}
}else{

  $trackerlogin = json_decode($backstage->get_tracker_details_of_admin());
  $md5pw=md5("qFtAQwsz".$trackerlogin->tracker_password);

  $trackresult= json_decode(getTrackerDetails($trackerlogin->tracker_username, $md5pw));

 $found='1';
}


?>

<!-- add adminheade.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>
  <main>
    <div class="section no-pad-bot" id="index-banner">
      <?php include_once("../config/schoolname.php");?>
      <div class="row">
        <div class="col s12">
          <ul class="tabs github-commit">
            <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#all_busses_div">All Busses</a></li>
            <!-- <li class="tab col s3"><a class="white-text text-lighten-4" href="#add_staff_div">Add Buss</a></li> -->
          </ul>
        </div>
      </div>
    </div>
<!-- ========================== Edit staff div ==================================== -->
    <?php 
           if(isset($_GET['token']) && @$_GET['token']=="potgy765t7y3ww")
           {
          ?>
              <div class="row">
                <form class="col s12" id="update_staff_form" action="updatescript.php" method="post" enctype="multipart/form-data" >

                    <div class="row">
                        <div class="input-field col s12 m6">
                            <select name="sttype" onchange="onStaffType(this.value)">
                              <option value="" >Select staff type</option>
                              <option value="Accountant" <?php echo (('Accountant'==$staff_type)?'selected="selected"':''); ?>>Accountant</option>
                              <option value="Librarian" <?php echo (('Librarian'==$staff_type)?'selected="selected"':''); ?>>Librarian</option>
                              <option value="Driver" <?php echo (('Driver'==$staff_type)?'selected="selected"':''); ?>>Driver</option>
                              <option value="Lab boy" <?php echo (('Lab boy'==$staff_type)?'selected="selected"':''); ?>>Lab boy</option>
                              <option value="Reception" <?php echo (('Reception'==$staff_type)?'selected="selected"':''); ?>>Reception</option>
                              <option value="Peon" <?php echo (('Peon'==$staff_type)?'selected="selected"':''); ?>>Peon</option>
                              <option value="Canteen" <?php echo (('Canteen'==$staff_type)?'selected="selected"':''); ?>>Canteen</option>
                              <option value="Guard" <?php echo (('Guard'==$staff_type)?'selected="selected"':''); ?>>Guard</option>
                              <option value="Other" <?php echo (('Other'==$staff_type)?'selected="selected"':''); ?>>Other</option>

                            </select>
                            <label>Staff type:</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stpos" id="stpos" type="text" value="<?php echo $staff_position;?>">
                          <label for="stpos">Position</label>
                        </div>
                    </div>
                    <div id="otherdiv" class="row" <?php if($staff_type=='Other'){echo "style='display: block;'";}else{ echo "style='display: none;'"; } ?> >
                      <div class="input-field col s12 m6">
                          <input name="stother" id="stother" type="text" value="<?php echo $staff_typedesc;?>">
                          <label for="stother">Specify staff type</label>
                        </div>                      
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                          <input name="stname" id="stname" type="text" class="validate" autofocus required="" aria-required="true" value="<?php echo $staff_name;?>">
                          <label for="stname">Full Name*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                          <input name="staddress" id="staddress" type="text" class="validate" required="" aria-required="true" value="<?php echo $staff_address;?>">
                          <label for="staddress">Address*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="stmobile" id="stmobile" type="tel" class="validate" value="<?php echo $staff_mobile;?>">
                          <label for="stmobile" data-error="wrong" data-success="right">Mobile number*</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stphone" id="stphone" type="tel" class="validate" value="<?php echo $staff_phone;?>">
                          <label for="stphone" data-error="wrong" data-success="right" >Phone(optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="stemail" id="stemail" type="email" class="validate" placeholder="required for accountant, librarian and driver" value="<?php echo $staff_email;?>">
                          <label for="stemail" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stcountry" id="stcountry" type="text" required="" aria-required="true" value="<?php echo $staff_country;?>">
                          <label for="stcountry" >Nationality</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="stfather" id="stfather" type="text" value="<?php echo $staff_father;?>">
                          <label for="stfather" >Father Name</label>
                        </div>
                        <div class="input-field col s12 m6" >
                          <input name="stmother" id="stmother" type="text" value="<?php echo $staff_mother;?>" >
                          <label for="stmother" >Mother Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="stsex" value="male" type="radio" <?php echo (('male'==$staff_sex)?'checked="checked"':''); ?> id="Male" />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="stsex" value="female" type="radio" <?php echo (('female'==$staff_sex)?'checked="checked"':''); ?> id="Female" />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="stsex" value="other" type="radio" <?php echo (('other'==$staff_sex)?'checked="checked"':''); ?> id="Otherg" />
                          <label for="Otherg">Female</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <h6>Marital status*</h6>
                          <input class="with-gap" name="stmstatus" value="Single" type="radio" <?php echo (('Single'==$staff_marital)?'checked="checked"':''); ?> id="Single" />
                          <label for="Single">Single</label>
                          <input class="with-gap" name="stmstatus" value="Married" type="radio" <?php echo (('Married'==$staff_marital)?'checked="checked"':''); ?> id="Married" />
                          <label for="Married">Married</label>
                          <input class="with-gap" name="stmstatus" value="Other" type="radio" <?php echo (('Other'==$staff_marital)?'checked="checked"':''); ?> id="Otherm" />
                          <label for="Otherm">Other</label>
                        </div>
                        
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                            <input name="stdoj" id="stdoj" type="text" class="datepicker" value="<?php echo date('j F, Y',strtotime($staff_joindate));?>" >
                          <label for="stdoj">Date Of Join</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="stdob" id="stdob" type="text" class="datepicker" value="<?php echo date('j F, Y',strtotime($staff_dob));?>">
                          <label for="stdob">Birth date</label>
                        </div>
                    </div>
                 
                    <div class="row">
                      <div class="input-field col s12 m6">
                          <input name="stsalary" id="stsalary" type="text" class="validate" value="<?php echo $staff_salary;?>">
                          <label for="stsalary">Staff salary</label>
                      </div>
                    </div>                    
                    <div class="row">
                      <input type="hidden" name="stid" value="<?php echo $stid;?>">
                      <input type="hidden" name="update_staff">
                        <div class="input-field col offset-m10">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>
                </form>
            </div>

          <?php } ?>
<!-- ========================== All Busses div ==================================== -->
        <div id="all_busses_div">
              <?php  if($found == '1'){  ?>

              <div class="row">
                  <div class="col s12 m12">
                      <table class="centered bordered striped highlight z-depth-4">
                      <thead>
                          <tr>
                              <th>Bus Number</th>
                              <th>Bus Route</th>
                              <th>Driver Name</th>
                              <th>Driver Mobile</th>
                              <th>Tracker Type</th>
                              <th>Track</th>
                          </tr>
                      </thead>
                      <tbody>
                        <?php  foreach ($transportation_details as $trans) 
                          {
                          ?>
                  <tr>
                    
                      <td>
                          <?php echo $trans->bus_number; ?>
                      </td>
                      <td>
                          <?php echo $trans->bus_route; ?>
                      </td>
                      <td><a style="color: black;" href="staffdetails.php?token=2ec9ys77io89s9&key=<?php echo "ae25nj5s3fr596dg@".$trans->stid; ?>">
                        <?php echo $trans->staff_name; ?>
                        </a>
                          
                      </td>
                      <td>
                          <?php echo $trans->staff_mobile; ?>
                      </td>
                      <td>
                          <?php echo $trans->tracker_type; ?>
                      </td>
                      <td><a style="color: black;" href="trackbus.php?token=2ec9ys77io89s9&key=<?php echo "ae25nj5s3fr596dg@".$trans->tracker_id; ?>">
                          <i class="material-icons <?php if($shortid==$trans->tracker_id){echo 'green';} ?>">gps_fixed</i>
                          </a>
                      </td>
                      
                  </tr>
                  <?php } ?>

                  </tbody>
                  </table>
                  </div>
                  </div>

                  <div id="map" style="width:97%;height:400px; margin: 15px;"></div>

<!-- ============================================================= -->
              
            <?php } else if($found == '0') { ?>
            <div class="row">
                <div class="col s12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title center"><span style="color:#80ceff;">No Bus Details Found...</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else {} ?>
        </div>
<!-- ================================= Add staff div ========================================== -->
            <!-- <div id="add_staff_div" class="row" style="display: none;" >
                <form class="col s12" id="add_staff_form" action="addscript.php" method="post" enctype="multipart/form-data" >

                    <div class="row">
                        <div class="input-field col s12 m6">
                            <select name="sttype" onchange="onStaffType(this.value)">
                              <option value="" >Select staff type</option>
                              <option value="Accountant">Accountant</option>
                              <option value="Librarian">Librarian</option>
                              <option value="Driver">Driver</option>
                              <option value="Lab boy">Lab boy</option>
                              <option value="Reception">Reception</option>
                              <option value="Peon">Peon</option>
                              <option value="Canteen">Canteen</option>
                              <option value="Guard">Guard</option>
                              <option value="Other">Other</option>


                            </select>
                            <label>Staff type:</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stpos" id="stpos" type="text">
                          <label for="stpos">Position</label>
                        </div>
                    </div>
                    <div id="otherdiv" class="row" style="display: none;">
                      <div class="input-field col s12 m6">
                          <input name="stother" id="stother" type="text">
                          <label for="stother">Specify staff type</label>
                        </div>                      
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                          <input name="stname" id="stname" type="text" class="validate" autofocus required="" aria-required="true">
                          <label for="stname">Full Name*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                          <input name="staddress" id="staddress" type="text" class="validate" required="" aria-required="true">
                          <label for="staddress">Address*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="stmobile" id="stmobile" type="tel" class="validate">
                          <label for="stmobile" data-error="wrong" data-success="right">Mobile number*</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stphone" id="stphone" type="tel" class="validate">
                          <label for="stphone" data-error="wrong" data-success="right" >Phone(optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="stemail" id="stemail" type="email" class="validate" placeholder="required for accountant, librarian and driver">
                          <label for="stemail" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stcountry" id="stcountry" type="text" required="" aria-required="true">
                          <label for="stcountry" >Nationality</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="stfather" id="stfather" type="text">
                          <label for="stfather" >Father Name</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stmother" id="stmother" type="text" >
                          <label for="stmother" >Mother Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="stsex" value="Male" type="radio" checked="checked" id="Male" />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="stsex" value="Female" type="radio" id="Female" />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="stsex" value="Other" type="radio" id="Otherg" />
                          <label for="Otherg">Female</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <h6>Marital status*</h6>
                          <input class="with-gap" name="stmstatus" value="Single" type="radio" checked="checked" id="Single" />
                          <label for="Single">Single</label>
                          <input class="with-gap" name="stmstatus" value="Married" type="radio" id="Married" />
                          <label for="Married">Married</label>
                          <input class="with-gap" name="stmstatus" value="Other" type="radio" id="Otherm" />
                          <label for="Otherm">Other</label>
                        </div>
                        
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                            <input name="stdoj" id="stdoj" type="text" class="datepicker" >
                          <label for="stdoj">Date Of Join</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="stdob" id="stdob" type="text" class="datepicker" >
                          <label for="stdob">Birth date</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <div class="file-field input-field">
                            <div class="btn">
                              <span>Staff Picture</span>
                              <input type="file" name="stpic">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" placeholder="file type JPG, JPEG, PNG & GIF files are allowed." type="text">
                            </div>
                          </div>
                        </div>
                        <div class="input-field col s12 m6">
                          <div class="file-field input-field">
                            <div class="btn">
                              <span>Citizenship</span>
                              <input type="file" name="stdoc1">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" placeholder="file type JPG,JPEG,PNG,PDF,TXT,DOC,DOCX files are allowed." type="text">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <div class="file-field input-field">
                            <div class="btn">
                              <span>Staff CV</span>
                              <input type="file" name="stdoc2">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" placeholder="file type JPG,JPEG,PNG,PDF,TXT,DOC,DOCX files are allowed." type="text">
                            </div>
                          </div>
                        </div>
                        <div class="input-field col s12 m6">
                          <div class="file-field input-field">
                            <div class="btn">
                              <span>Others</span>
                              <input type="file" name="stdoc3">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" placeholder="file type JPG,JPEG,PNG,PDF,TXT,DOC,DOCX files are allowed." type="text">
                            </div>
                          </div>
                        </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                          <input name="stsalary" id="stsalary" type="text" class="validate">
                          <label for="stsalary">Staff salary</label>
                      </div>
                    </div>                    
                    <div id="stpassword" class="row" style="display: none;">
                        <div class="input-field col s12 m6">

                              <input name="stpassword1" id="stpassword1" type="password" class="validate" >
                              <label for="password1" >Password</label>

                              <input name="stpassword2" placeholder="confirm password" id="stpassword2" type="password" class="validate" >
                          
                        </div>
                    </div>
                    <div class="row">
                      <input type="hidden" name="add_staff">
                        <div class="input-field col offset-m10">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>

                </form>
            </div> -->
        </main>

<?php include_once("../config/footer.php");?> 

<?php if (isset($_REQUEST['resp'])) 
{
  if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }
  
} ?>

<!--  ================== Start Map ==================== -->

<script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
          
          var imagePerson='data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pgo8IS0tIEdlbmVyYXRvcjogQWRvYmUgSWxsdXN0cmF0b3IgMTYuMC4wLCBTVkcgRXhwb3J0IFBsdWctSW4gLiBTVkcgVmVyc2lvbjogNi4wMCBCdWlsZCAwKSAgLS0+CjwhRE9DVFlQRSBzdmcgUFVCTElDICItLy9XM0MvL0RURCBTVkcgMS4xLy9FTiIgImh0dHA6Ly93d3cudzMub3JnL0dyYXBoaWNzL1NWRy8xLjEvRFREL3N2ZzExLmR0ZCI+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayIgdmVyc2lvbj0iMS4xIiBpZD0iQ2FwYV8xIiB4PSIwcHgiIHk9IjBweCIgd2lkdGg9IjMycHgiIGhlaWdodD0iMzJweCIgdmlld0JveD0iMCAwIDQ4NS4yMTIgNDg1LjIxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNDg1LjIxMiA0ODUuMjEyOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxnPgoJPHBhdGggZD0iTTI4OC4wOTUsNDUuNDljMCwyNS4xMTQtMjAuMzc3LDQ1LjQ4OC00NS40OSw0NS40ODhjLTI1LjExNCwwLTQ1LjQ5LTIwLjM3NC00NS40OS00NS40ODggICBjMC0yNS4xMTMsMjAuMzc2LTQ1LjQ5LDQ1LjQ5LTQ1LjQ5QzI2Ny43MTgsMCwyODguMDk1LDIwLjM3NiwyODguMDk1LDQ1LjQ5eiBNMjcyLjkzMSwxMjEuMzA0aC02MC42NSAgIGMtMTYuNzY1LDAtMzAuMzI3LDEzLjU2Mi0zMC4zMjcsMzAuMzI0VjI3Mi45M2gzMC4zMjd2MTIxLjMwN2g2MC42NVYyNzIuOTNoMzAuMzIyVjE1MS42MjggICBDMzAzLjI1MywxMzQuODY3LDI4OS42OTEsMTIxLjMwNCwyNzIuOTMxLDEyMS4zMDR6IE0zMDMuMjUzLDMwNi40ODJ2MzAuNjI2YzcwLjYzMiw4LjM1NCwxMjEuMzA3LDMwLjczNywxMjEuMzA3LDU3LjEyOSAgIGMwLDMzLjQ5MS04MS40NzMsNjAuNjQ5LTE4MS45NTUsNjAuNjQ5UzYwLjY0OSw0MjcuNzI4LDYwLjY0OSwzOTQuMjM3YzAtMjYuMzkyLDUwLjcwMS00OC43NzUsMTIxLjMwNC01Ny4xMjl2LTMwLjYyNiAgIGMtODIuMjcxLDkuMDA4LTE1MS42MjgsMzcuMDg1LTE1MS42MjgsODcuNzU1YzAsNjIuODM4LDEwNi42MTUsOTAuOTc2LDIxMi4yOCw5MC45NzZjMTA1LjY2MiwwLDIxMi4yODItMjguMTM4LDIxMi4yODItOTAuOTc2ICAgQzQ1NC44ODcsMzQzLjU2NywzODUuNTMsMzE1LjQ5LDMwMy4yNTMsMzA2LjQ4MnoiIGZpbGw9IiMwMDZERjAiLz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8Zz4KPC9nPgo8L3N2Zz4K';
                  
          var imageBus='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAYAAABzenr0AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAA3QAAAN0BcFOiBwAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAN9SURBVFiF7ZZNbBtFFMd/M7vrXdtJjNNUCSWVYzhErYiQ0jZQ3PZSRFGFgBMITpzhhnIpQqCioiJAIuIAqBeQEEIqlyqIA+JDVUWIAhEgOKQfENOWpthpCc6uY3u/hsOW1CZ2ZXNIOORJK828ef/3/8+bjx2hlGIjTW4o+6aATQH/BwG6Pz12UFPieQVb1oNQKOZFGDzL/tmrALpU4oSCO9eDHEAJ7kE3YwIehmgJOifXEqCnGj8t0b4Ia+Aws4/mAPT6gQ8qhyiGaYqexd3aBYZMm2+9nfhKsOT6vNr7MQCi70Ho2tGY1ZlDFU4B8GltL2f9DE5gEA+v81DyHJ+7ewAohXFKf1liYuCTNzTY2yDgtDvKBf8OzpdWeKLHY0VzmKzu40q5Rlpch972Zjjr7uArd5R5u8KoeYlha5nJ6j4A5u0Ktucz3j8wlpk53LPmFBQqLit+cHNifkCx6rbHXGd/1jxKrt/gW/Z8Sq5PqOCFhZwMjdhrDRXIGT9ySe5kW1Kw2/yNId1miF/oSZrssi7fmtHqW23uis0xI1L0JTVy8V/Jald5xJpiOhzktm4DAF9JkOZTIpga6/h3KPofa9wDUkfJEM690goB8e1NN6ruXjQ65cdIusium31l9kBliZa5jDToOrB2KXX7m/aPzz/WnS5jDtzoaAboFmHVp2kuoYEAcJrm0rc8WepYgOhPRw1poOLRBSq7YqzJFdsKsVtfsHqrgfzlKlOzNgC53d1kt1uNAZqJiveCEE0UauQL3Ux9VwSK5O7bRjaTal/AmZlljr/9O34Q7c8PTy1y5JlBDtzbEwVYW1GJXm7UttGkyZnvJcffnMYPwgh/8ixHntvDgdzg2nAE5XpHGCom3lvADxQjwwlGhhP4QeQLw0iQsvqbkIdg3k5oZZh49yf8IKzDh0y888MqftVUiETxOrB6YxSuedhOgBBwbDzDsfEMQoDtBBSueU3LCEBQBiNFYbGC7bhN8C6FxZV6dpTvnNbl/TNH+Xr/W+h+CqBWUzEh+FkpYic++iMKVSAEbq2mRqSULuW5u6guRDvRtdPoSg9qpWXNW7poStcQgs+UwvgX3jOlc0h6bjSLgCuMTeZFs2f5A9nki0qIo/U+odRLX+TLL7cuwX/DNxUAcDDb9TSSxwEIOfll3nm/HfJO8S0FrJdt+JtwU8CmgA0X8DdENWuKnwB43gAAAABJRU5ErkJggg==';

          var map, infoWindow;
          var markerMyLocation;
          var newPos;
          var contentString = new Array();
          var Markers = {};

          

          function initMap() {

            var mylocation = {lat: 27.687835, lng: 85.343293};

            map = new google.maps.Map(document.getElementById('map'), {
              center: mylocation,
              zoom: 12,
              //disableDefaultUI: true
            });

            infoWindow = new google.maps.InfoWindow;

            // Try HTML5 geolocation
            //Get user current location
            //var pos = new google.maps.LatLng( (Math.random()*(85*2)-85), (Math.random()*(180*2)-180) );
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {

                  var pos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                  };
                  markerMyLocation = new google.maps.Marker({
                    position: pos,
                    map: map,
                    title:"Your Current Location",
                    icon: imagePerson
                  });
                  map.setCenter(pos);


                   //Msg of on click on current location
            var infowindowMsg = new google.maps.InfoWindow({
              content:"Your Current Location"
            });

            //click event Listner on markerMyLocation
            google.maps.event.addListener(markerMyLocation, 'mouseover', function() {
              infowindowMsg.open(map,markerMyLocation);
            });
            google.maps.event.addListener(markerMyLocation, 'mouseout', function() {
              infowindowMsg.close(map,markerMyLocation);
            });
            google.maps.event.addListener(markerMyLocation, 'dblclick', function() {
              //map.setCenter(markerMyLocation.getPosition());
              map.panTo(markerMyLocation.getPosition());
              map.setZoom(15);

            });

              }, function() {
                handleLocationError(true, infoWindow, map.getCenter());
              });
            } else {
              // Browser doesn't support Geolocation
              handleLocationError(false, infoWindow, map.getCenter());
            }
           



            //For multiple buses            
            var i=1;
            //debugger;
            var obj = <?php echo json_encode($trackresult); ?>;
            obj.forEach(function(element) {

                  //var latLng = new google.maps.LatLng(element.latitude,element.longitude);
                  var latLng = {lat: element.latitude, lng: element.longitude};

                  var marker = new google.maps.Marker({
                    position: latLng,
                    title:"Bus no:"+element.name,
                    map: map,
                    icon: imageBus
                  });

                 contentString[i] ='<h5>'+element.name+'</h5>'+
                  '<p><b>Speed:'+element.speed+' km/hr</b><p>' +
                  '<p>Desciption:'+element.description+'</p>'+
                  '<p>last updated:'+element.time+'</p>';

                  google.maps.event.addListener(marker, 'mouseover', (function(marker, i) {
                    return function() {
                      infoWindow.setContent(contentString[i]);
                      infoWindow.setOptions({maxWidth: 200});
                      infoWindow.open(map, marker);
                    }
                  }) (marker, i));
                  google.maps.event.addListener(marker, 'mouseout', (function(marker, i) {
                    return function() {
                      infoWindow.close(map, marker);
                    }
                  }) (marker, i));

                  Markers[i] = marker;

                    i++;
            });


          async function refreshbuses() {
              var j=1;
              
              var object=<?php echo getTrackerDetails($trackerlogin->tracker_username, $md5pw); ?>;
              object.forEach(function(element) {

                //var latLng = new google.maps.LatLng( (Math.random()*(85*2)-85), (Math.random()*(180*2)-180) );
                 //var latLng = new google.maps.LatLng(element.latitude,element.longitude);
                  var latLng = {lat: element.latitude, lng: element.longitude};

                  var myMarker = Markers[j];
                  //var markerPosition = myMarker.getPosition();
                  //map.setCenter(markerPosition);
                  //google.maps.event.trigger(myMarker, 'click');
                  myMarker.setPosition(latLng);
                  
                  contentString[i] ='<h5>'+element.name+'</h5>'+
                  '<p><b>Speed:'+element.speed+' km/hr</b><p>' +
                  '<p>Desciption:'+element.description+'</p>'+
                  '<p>last updated:'+element.time+'</p>';

                    j++;
              });

              y = 10;
               setTimeout(refreshbuses, y*1000);
            }

            refreshbuses();



             async function refreshLocation() {
              
              if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(function(position) {

                  newPos = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                  };


              markerMyLocation.setPosition(newPos);

                  }, function() {
                    handleLocationError(true, infoWindow, map.getCenter());
                  });
                } else {
                  // Browser doesn't support Geolocation
                  handleLocationError(false, infoWindow, map.getCenter());
                }

                x = 5;  
               //Materialize.toast('updated', 4000, 'rounded'); 
               setTimeout(refreshLocation, x*1000); 
            }

            refreshLocation();
          } //end of initMap



          function handleLocationError(browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos);
            infoWindow.setContent(browserHasGeolocation ?
                                  'Failed to load your current location' :
                                  'Error: Your browser doesn\'t support geolocation.');
            infoWindow.open(map);
          }

          google.maps.event.addDomListener(window, 'load', initMap);

    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_UTF6NCoUfYioglesA3UXqWXUOq4fWgo&callback=initMap">
    </script>

   <!--  ====================================== End Map ================================= -->
<script>
    $(document).ready(function (e) 
        {
          $("#add_staff_form").on('submit',(function(e) 
          {
            e.preventDefault();
            $.ajax
            ({
                  url: "addscript.php",
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
                    if (data!='Staff succesfully added') { Materialize.toast(data, 4000, 'rounded'); } 
                    else 
                      if (data=='Staff succesfully added') {

                      window.location.href = 'staff.php?resp=success';
                    }
                  },
                  error: function(e) 
                  {
                    alert('Sorry Try Again !!');
                  }          
            });
          }));
      $("#update_staff_form").on('submit',(function(e) 
      {
        e.preventDefault();
        $.ajax
        ({
              url: "updatescript.php",
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
                if (data!='Staff succesfully updated') { Materialize.toast(data, 4000, 'rounded'); } 
                else 
                  if (data=='Staff succesfully updated') {

                  window.location.href = 'staff.php?resp=success';
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
<script type="text/javascript">
    $(document).ready(function() {
    $('#staffalllist').DataTable();
    } );
</script>
<script src="../css/new_js/datatables.min.js"></script>
    <script src="../css/new_js/dataTables.buttons.js"></script>
    <script src="../css/new_js/dataTables.buttons.min.js">
</script>


<script type="text/javascript">
$(document).ready(function() {
/*  $('ul.tabs').tabs({
    onShow: onShow,//Function to be called on tab Show event
    swipeable: true,
    responsiveThreshold: Infinity // breakpoint for swipeable
  });*/
  $("ul.tabs > li > a").click(function (e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;});
    var hash = window.location.hash;
    $('ul.tabs').tabs('select_tab', hash);

/*$("#editid").click(function() {
    $('ul.tabs').tabs('select_tab', 'add_staff_div');
  });*/
});
function changeTab(id){
      $('ul.tabs').tabs('select_tab', id);
     
      
}
</script>
