<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'staff';

if (isset($_GET["token"])){
            $longid1 = ($_GET["token"]);

            if ($longid1=="potgy765t7y3ww") {
              if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);

            $sqlEdit = $db->query("SELECT * FROM `staff_tbl` WHERE `stid`='$shortid' ");
            if($sqlEdit->num_rows)
            {
            $rowsEdit = $sqlEdit->fetch_assoc();
            extract($rowsEdit);
}else
{
$_GET['token']="";
}
}}}else{

    $resultstaff = $db->query("SELECT * FROM `staff_tbl` WHERE `staff_status` = 0 ORDER BY `staff_tbl`.`stid` ASC");
    $rowCount = $resultstaff->num_rows;
if($rowCount > 0) { $found='1'; } else{ $found='0';   }
}


?>

<!-- add adminheade.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>
<style type="text/css">
        #staffalllist_length select{
            display: inherit;
        }
        #staffalllist_filter{
            width: 50%;
        }

        #staffalllist_wrapper
        {
            margin-top: 20px;
        }

        #staffalllist_wrapper label{
            width: 100%;
            font-size: 20px;
            color:#000;
        }

</style>
<script>
function onStaffType(str) {
    var y = document.getElementById("otherdiv");
    if(str=='Other') {
        y.style.display = "block";
    }else{
      y.style.display = "none";
    }
}
</script>

  <main>
    <div class="section no-pad-bot" id="index-banner">
      <?php include_once("../config/schoolname.php");?>
      <div class="row">
        <div class="col s12">
          <ul class="tabs github-commit"><?php
            if( (isset($_GET['token']) && @$_GET['token']=="potgy765t7y3ww") ){ ?>
            <div class="row center"><a class="white-text text-lighten-4" href="#">Edit Staff Details</a></div>
            <?php }else{?>
            <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#all_staff_div">All Staff</a></li>
            <li class="tab col s3"><a class="white-text text-lighten-4" href="#add_staff_div">Add Staff</a></li>
            <?php } ?>
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
                               <option value="Principal" <?php echo (('Principal'==$staff_type)?'selected="selected"':''); ?> >Principal</option>
                              <option value="Asst. Principal" <?php echo (('Asst. Principal'==$staff_type)?'selected="selected"':''); ?> >Asst. Principal</option>
                              <option value="Administrator" <?php echo (('Administrator'==$staff_type)?'selected="selected"':''); ?>>Administrator</option>
                              <option value="Coordinator" <?php echo (('Coordinator'==$staff_type)?'selected="selected"':''); ?>>Coordinator</option>
                              <option value="Exam Controller" <?php echo (('Exam Controller'==$staff_type)?'selected="selected"':''); ?>>Exam Controller</option>
                              <option value="Accountant" <?php echo (('Accountant'==$staff_type)?'selected="selected"':''); ?>>Accountant</option>
                              <option value="Librarian" <?php echo (('Librarian'==$staff_type)?'selected="selected"':''); ?>>Librarian</option>
                              <option value="Store Keeper" <?php echo (('Store Keeper'==$staff_type)?'selected="selected"':''); ?>>Store Keeper</option>
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
                          <input name="stemail" id="stemail" type="email" class="validate" value="<?php echo $staff_email;?>">
                          <label for="stemail" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stcountry" id="stcountry" type="text" required="" aria-required="true" value="<?php echo $staff_country;?>">
                          <label for="stcountry" >Nationality*</label>
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
                            <select name="blood_group">
                              <option value="0" <?php echo (($blood_group==0)?'selected="selected"':''); ?> >Select Blood Group</option>
                              <option value="1" <?php echo (($blood_group==1)?'selected="selected"':''); ?> >0 -ve</option>
                              <option value="2" <?php echo (($blood_group==2)?'selected="selected"':''); ?> >0 +ve</option>
                              <option value="3" <?php echo (($blood_group==3)?'selected="selected"':''); ?> >A -ve</option>
                              <option value="4" <?php echo (($blood_group==4)?'selected="selected"':''); ?> >A +ve</option>
                              <option value="5" <?php echo (($blood_group==5)?'selected="selected"':''); ?> >B -ve</option>
                              <option value="6" <?php echo (($blood_group==6)?'selected="selected"':''); ?> >B +ve</option>
                              <option value="7" <?php echo (($blood_group==7)?'selected="selected"':''); ?> >AB -ve</option>
                              <option value="8" <?php echo (($blood_group==8)?'selected="selected"':''); ?> >AB +ve</option>
                              </select>
                            <label>Blood Group:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="stsex" value="male" type="radio" <?php echo (('male'==strtolower($staff_sex))?'checked="checked"':''); ?> id="Male" />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="stsex" value="female" type="radio" <?php echo (('female'==strtolower($staff_sex))?'checked="checked"':''); ?> id="Female" />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="stsex" value="other" type="radio" <?php echo (('other'==strtolower($staff_sex))?'checked="checked"':''); ?> id="Otherg" />
                          <label for="Otherg">Female</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <h6>Marital status*</h6>
                          <input class="with-gap" name="stmstatus" value="single" type="radio" <?php echo (('single'==strtolower($staff_marital))?'checked="checked"':''); ?> id="Single" />
                          <label for="Single">Single</label>
                          <input class="with-gap" name="stmstatus" value="married" type="radio" <?php echo (('married'==strtolower($staff_marital))?'checked="checked"':''); ?> id="Married" />
                          <label for="Married">Married</label>
                          <input class="with-gap" name="stmstatus" value="other" type="radio" <?php echo (('other'==strtolower($staff_marital))?'checked="checked"':''); ?> id="Otherm" />
                          <label for="Otherm">Other</label>
                        </div>
                        
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                            <input name="stdoj" id="stdojedit" type="text" placeholder="select date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                             >
                          <label for="stdojedit">Date Of Join</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="stdob" id="stdobedit" type="text" placeholder="select date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                            >
                          <label for="stdobedit">Birth date</label>
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
<!-- ========================== All staff div ==================================== -->
        <div id="all_staff_div">
              <?php  if($found == '1'){  ?>
              <div class="row scrollable" style="overflow: auto;">
                <div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4" id="staffalllist">
                        <thead>
                            <tr>
                                <th>Staff name</th>
                                <th>Type</th>
                                <th>Position</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Salary</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                          while($row = $resultstaff->fetch_assoc()) { ?>
                            <tr <?php if ($row["staff_status"]==1) {?> style="background-color: pink" <?php } else {} ?>>
                                <td>
                                    <?php echo $row["staff_name"]; ?>
                                </td>
                                <td>
                                    <?php if($row["staff_type"]=="Other"){ echo $row["staff_typedesc"]; }else{ echo $row["staff_type"]; }  ?>
                                </td>
                                <td>
                                    <?php echo $row["staff_position"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["staff_mobile"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["staff_address"]; ?>
                                </td>
                                <td>
                                    <?php echo $row["staff_salary"]; ?>
                                </td>
                                <td>
                                    <?php if ($staff_status==0) { echo "Active";}elseif ($staff_status==1) { echo "Deleted"; }else { echo "";} ?>
                                </td>
                                <td>
                                    <a href="staffdetails.php?token=2ec9ys77bi89s9&key=<?php echo "ae25nj5s3fr596dg@".$row["stid"]; ?>"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="information" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"> <i class="material-icons">info_outline</i></div></a>

                                    <?php if ($login_cat == 1 || $pac['edit_staff']) { ?>

                                    <a  href="staff.php?token=potgy765t7y3ww&key=<?php echo "ae25nJ5s3fr596dg@".$row["stid"]; ?>"> <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>
                                    
                                    <a href="deleteuserscript.php?token=potgy765t7y3ww&key=<?php echo "ae25nJ5s3fr596dg@".$row["stid"]; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"> <i class="material-icons red-text text-darken-4">delete</i></div></a>
                                    
                                    <?php } ?>


                                </td>
                            </tr>
                            <?php 
            }
            
            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php } else if($found == '0') { ?>
            <div class="row">
                <div class="col s12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title center"><span style="color:#80ceff;">No Staff Added yet...</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php }else {} ?>
        </div>
<!-- ================================= Add staff div ========================================== -->
            <div id="add_staff_div" class="row" style="display: none;" >
                <form class="col s12" id="add_staff_form" action="addscript.php" method="post" enctype="multipart/form-data" >

                    <div class="row">
                        <div class="input-field col s12 m6">
                            <select name="sttype" onchange="onStaffType(this.value)">
                              <option value="" >Select staff type</option>
                              <option value="Principal">Principal</option>
                              <option value="Asst. Principal">Asst. Principal</option>
                              <option value="Administrator" >Administrator</option>
                              <option value="Coordinator" >Coordinator</option>
                              <option value="Exam Controller" >Exam Controller</option>
                              <option value="Accountant">Accountant</option>
                              <option value="Librarian">Librarian</option>
                              <option value="Store Keeper">Store Keeper</option>
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
                          <input name="stemail" id="stemail" type="email" class="validate">
                          <label for="stemail" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="stcountry" id="stcountry" type="text" required="" aria-required="true">
                          <label for="stcountry" >Nationality*</label>
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
                            <select name="blood_group">
                              <option value="0" selected >Select Blood Group</option>
                              <option value="1">0 -ve</option>
                              <option value="2">0 +ve</option>
                              <option value="3">A -ve</option>
                              <option value="4">A +ve</option>
                              <option value="5">B -ve</option>
                              <option value="6">B +ve</option>
                              <option value="7">AB -ve</option>
                              <option value="8">AB +ve</option>
                              </select>
                            <label>Blood Group:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="stsex" value="male" type="radio" checked="checked" id="Male" />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="stsex" value="female" type="radio" id="Female" />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="stsex" value="other" type="radio" id="Other" />
                          <label for="Otherg">Female</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <h6>Marital status*</h6>
                          <input class="with-gap" name="stmstatus" value="single" type="radio" checked="checked" id="Single" />
                          <label for="Single">Single</label>
                          <input class="with-gap" name="stmstatus" value="married" type="radio" id="Married" />
                          <label for="Married">Married</label>
                          <input class="with-gap" name="stmstatus" value="other" type="radio" id="Otherm" />
                          <label for="Otherm">Other</label>
                        </div>
                        
                    </div>
                    <div class="row">
                      <div class="input-field col s12 m6">
                            <input name="stdoj" id="stdoj" type="text" placeholder="Select Date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                            >
                          <label for="stdoj">Date Of Join</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="stdob" id="stdob" type="text" placeholder="Select Date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                            >
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
                    <div id="stpassword" class="row">
                        <div class="input-field col s12 m6">

                              <input name="stpassword1" id="stpassword1" type="password" class="validate" >
                              <label for="password1" >Password</label>

                              <input name="stpassword2" placeholder="confirm password" id="stpassword2" type="password" class="validate" >
                          
                        </div>
                    </div>
                    <div class="row">
                      <input type="hidden" name="add_staff_request" value="add_staff_request">
                        <div class="input-field col offset-m10">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>

                </form>
            </div>
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
                    if (data.trim() !== 'Staff succesfully added'.trim()) { 
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
                      if (data.trim() === 'Staff succesfully added'.trim()) {

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
                Materialize.toast(data, 4000, 'rounded');
                $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
                //alert(data);
                /*if (data!='Staff succesfully updated') { Materialize.toast(data, 4000, 'rounded'); } 
                else 
                  if (data=='Staff succesfully updated') {

                  window.location.href = 'staff.php?resp=success';
                }*/
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


<script type="text/javascript">
        
  var joindate = "<?php echo (($login_date_type==2)? eToN($staff_joindate) : $staff_joindate);?>"
  document.getElementById("stdojedit").value = joindate;

  var dobdate = "<?php echo (($login_date_type==2)? eToN($staff_dob) : $staff_dob);?>"
  document.getElementById("stdobedit").value = dobdate;
  
</script>