<?php
include('session.php');

if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);
        }
$sqlsdd1 = "SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.* 
        FROM `studentinfo` 
        LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
        LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
        LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
        WHERE `studentinfo`.`sid`='$shortid'";
    $resultsdd1 = $db->query($sqlsdd1);

    $localemail=''; 
    $localid='';
?>
     <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <script type="text/javascript" src="../js/webcam.min.js"></script>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Students Details</a></div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col s12 m12">
                    <?php 
            if ($resultsdd1->num_rows > 0) {
                while($row = $resultsdd1->fetch_assoc()) { 
                    $localemail=$row["semail"];
                  $localid=$row["sid"];

                  $localparentemail=$row["spemail"];
                  $localparentid=$row["sparent_id"];
                    ?>
                        <div class="card">
                            
                            <div class="card-panel grey darken-3">
                            <div class="row ">
                                <div class="col s12 m5">
                                <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Student Info</span>

                                <?php if ($login_cat == 1 || $pac['edit_student']) { ?>

                                &nbsp&nbsp&nbsp&nbsp<a  href="admitstudent.php?token=2ec9ys77bi8939&key=<?php echo "ae25nj53sfr596dg@".$row["sid"]; ?>"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>


                                &nbsp&nbsp<a href="#modal_set_password" class="modal-trigger"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Update or Set login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons blue-text text-lighten-1">vpn_key</i></div></a>
                                
                                <form style="display: inline;"  id="disable_student_login_form" action="updatescript.php" method="post" >
                                    <input type="hidden" name="disable_student_login" value="<?php echo $row["sid"];?>">
                                    <button class="disable_login_button" type="submit" onclick="return confirm('Do you really want to disable login?');" ><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Disable login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons red-text text-lighten-1"><?php echo ((empty($row["sgetter"]))? 'no_encryption' : 'https'); ?></i></div></button>
                                </form>

                                <?php } ?>


                                <div class="card-content white-text flow-text">
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $row["sname"]; ?></div>
                                        <br>

                                    <?php if(!empty($row["caste"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Caste" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo ucfirst($row["caste"]); ?></div>
                                        <br> <?php } ?>

                                    <?php if(!empty($row["sadmsnno"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Admission number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assignment</i>&nbsp;<?php echo $row["sadmsnno"]; ?></div>
                                        <br><?php } ?>

                                    <?php if(!empty($row["class_name"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Class" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assessment</i>&nbsp; 
                                        <?php echo $row["class_name"]."-".$row["section_name"];?>
                                    </div><br><?php } ?>

                                    <?php if(!empty($row["sroll"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Roll No." style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">list</i>&nbsp;<?php echo $row["sroll"]; ?></div>
                                    <br><?php } ?>

                                    <?php if(!empty($row["sex"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Gender" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">wc</i>&nbsp;<?php echo ucfirst($row["sex"]); ?></div>
                                        <br> <?php } ?>

                                    <?php if(!empty($row["dob"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date Of Birth" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">sentiment_dissatisfied</i>&nbsp;<?php echo (($login_date_type==2)? eToN($row["dob"]) : $row["dob"]); ?></div>    <br> <?php } ?>

                                    <?php if(!empty($row["saddress"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Address" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">home</i>&nbsp;<?php echo $row["saddress"]; ?></div>
                                    <br>    <?php } ?>

                                    <?php if(!empty($row["semail"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $row["semail"]; ?></div>
                                    <br>    <?php } ?>

                                    <?php if(!empty($row["smobile"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Phone Number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">tablet_android</i>&nbsp;<?php echo $row["smobile"]; ?></div>
                                        <br>
                                    <?php } ?>

                                    <?php if ($row["status"]==0) { ?>
                                        <div class="tooltipped green-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Active</div><br>
                                    <?php }else if ($row["status"]!=0) { ?>
                                        <div class="tooltipped red-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Inactive</div><br>
                                    <?php } ?>


                                     <br/>
                                </div>
                                </div>
                            <div class="col s12 m4 offset-m2">
                                <div class="card-content white-text flow-text " >
                                    <div class="card grey darken-2 roundedImage " >
                                        <div class="card-image profile-pic customCardImage">
                                            <img class="circle responsive-img " src="<?php $image=$row["simage"]; if(!empty($image)){ echo "../uploads/".$fianlsubdomain."/profile_pic/".$image; }elseif($row["sex"]=='male'){ echo "https://learnmoreskill.github.io/important/dummystdmale.png"; } elseif($row["sex"]=='female'){ echo "https://learnmoreskill.github.io/important/dummystdfemale.png"; }else{echo "https://learnmoreskill.github.io/important/dummystdmale.png";} ?>" alt="image not avilable"   >

                                            <?php if ($login_cat == 1 || $pac['edit_student']) { ?>

                                            <form  id="delete_student_profile" action="updatescript.php" method="post" >
                                                <input type="hidden" name="delete_student_profile" >
                                                <input type="hidden" name="studentid" value="<?php echo $row["sid"];?>">
                                            <button class="btn-floating halfway-fab waves-effect waves-light grey lighten-4" type="submit"><i class="material-icons red-text text-darken-4">delete</i></button>
                                            </form>
                                        </div>

                                        
                                        <div class="card-action cPadding center">
                                            <a href="#modal_update_profile_picture" class="modal-trigger white-text" > 
                                                <i class="material-icons white-text text-darken-4">edit</i> Change 
                                            </a>                                            
                                        </div>

                                        <?php }?>

                                        
                                    </div>
                                </div>
                            </div>
                            </div>

                        </div>
                        </div>
                        <div class="card">
                            <div class="card-panel grey darken-3">
                                <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Guardian's Info </span>

                                <?php if ($login_cat == 1 || $pac['edit_student']) { ?>

                                &nbsp&nbsp <a  href="parent.php?token=2ec9ys77bi89s9&key=<?php echo "ae25nj5s3fr596dg@".$row["parent_id"]; ?>"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Parent details" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons blue-text text-lighten-1">info</i></div></a>

                                &nbsp&nbsp <a  href="admitstudent.php?token=2ecpoij7bi8939&key=<?php echo "ae25nj53sfr596dg@".$row["parent_id"]; ?>"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>
                                
                                &nbsp&nbsp&nbsp&nbsp <a href="#modal_set_parent_password" class="modal-trigger"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Update or Set login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons blue-text text-lighten-1">vpn_key</i></div></a>
                                
                                <form style="display: inline;"  id="disable_parent_login_form" action="updatescript.php" method="post" >
                                    <input type="hidden" name="disable_parent_login" value="<?php echo $row["sparent_id"];?>">
                                    <button class="disable_login_button" type="submit" onclick="return confirm('Do you really want to disable login?');" ><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Disable login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons red-text text-lighten-1"><?php echo ((empty($row["spphone"]))? 'no_encryption' : 'https'); ?></i></div></button>
                                </form>

                                <?php } ?>



                                <div class="card-content white-text flow-text">
                                    <?php if(!empty($row["spname"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Father name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $row["spname"]; ?></div>
                                        <br>    <?php } ?>

                                    <?php if(!empty($row["smname"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Mother name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $row["smname"]; ?></div>
                                        <br>   <?php } ?>
                                    <?php if(!empty($row["spemail"])){ ?>
                                     <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $row["spemail"]; ?></div>
                                                <br>    <?php } ?>

                                    <?php if(!empty($row["spnumber"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Contact No." style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">tablet_android</i>&nbsp;
                                        <?php echo $row["spnumber"]; ?></div>
                                            <br>    <?php } ?>

                                    <?php if(!empty($row["spnumber_2"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Contact number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">contact_phone</i>&nbsp;<?php echo $row["spnumber_2"]; ?></div>
                                        <br>
                                     <?php } ?>
                                    <?php if(!empty($row["spprofession"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Parent Profession" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">perm_identity</i>&nbsp;<?php echo $row["spprofession"]; ?></div>
                                        <br>
                                     <?php } ?>

                                    <?php if ($row["spstatus"]==0) { ?>
                                        <div class="tooltipped green-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Active</div><br>
                                    <?php }else if ($row["spstatus"]!=0) { ?>
                                        <div class="tooltipped red-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Inactive</div><br>
                                    <?php } ?>
                                    
                                    
                                    <br/>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-panel grey darken-3">
                                <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Attendance Info</span>
                                <div class="card-content white-text flow-text">
                                    <div class="row">
                                        <div class="col s12 m12">
                                            <?php 
                               $sqlsdd2 = "SELECT * FROM attendance WHERE asid='$shortid' and astatus='A' ORDER BY `attendance`.`aclock` DESC";
                                $resultsdd2 = $db->query($sqlsdd2);
                                if ($resultsdd2->num_rows > 0) { ?>

                                            <div style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><?php echo $row["sname"]." "; ?> was absent on the following dates :</div>
                                                    <br/>

                                                    <?php while($rowsdd2 = $resultsdd2->fetch_assoc()) { ?>

                                            &emsp; <span class=""><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">date_range</i>&nbsp;<?php 
                                            echo (($login_date_type==2)? eToN(date('Y-m-d', strtotime($rowsdd2['aclock']))) : date('Y-m-d', strtotime($rowsdd2['aclock'])) ); ?></div></span>
                                                        <br/>
                                                        <?php 
                                                                                           }
                                                               } else {
                                    echo "Regular Student";
                                }
                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-panel grey darken-3">
                                <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Complaint Info</span>
                                <div class="card-content white-text flow-text">
                                    <div class="row">
                                        <div class="col s12 m12">
                                            <?php 
                               $sqlsdd3 = "SELECT * FROM complaint WHERE csid='$shortid' ORDER BY `complaint`.`cclock` DESC LIMIT 5";
                                $resultsdd3 = $db->query($sqlsdd3);
                                if ($resultsdd3->num_rows > 0) { ?>

                                                Complaints found  :
                                                    <br/>

                                                    <?php while($rowsdd3 = $resultsdd3->fetch_assoc()) { ?>

                                                        &emsp; <span class=""><?php 
                                                        echo (($login_date_type==2)? eToN(date('Y-m-d', strtotime($rowsdd3['cclock']))) : date('Y-m-d', strtotime($rowsdd3['cclock']))); ?></span> &emsp;
                                                        <?php echo $rowsdd3["cmsg"]." "; ?>
                                                            <br/>
                                                            <?php 
                                                                                           }
                                                               } else {
                                    echo "No previous complaint found.";
                                }
                            ?>
                                        </div>
                                    </div>
                                    <?php  } } else { } ?>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-panel grey darken-3">
                                <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Homework Info</span>
                                <div class="card-content white-text flow-text">
                                    <div class="row">
                                        <div class="col s12 m12">
                                            <?php 
                               $sqlsdd4 = "SELECT * FROM hwnotdone WHERE hwndsid='$shortid' ORDER BY `hwnotdone`.`hwndclock` DESC";
                                $resultsdd4 = $db->query($sqlsdd4);
                                if ($resultsdd4->num_rows > 0) { ?>

                                            <div style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">Not done following homeworks :</div>
                                                    <br/>

                                                    <?php while($rowsdd4 = $resultsdd4->fetch_assoc()) { ?>

                                            &emsp; <span class=""><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">date_range</i>&nbsp;<?php
                                             echo (($login_date_type==2)? eToN(date('Y-m-d', strtotime($rowsdd4['hwnddate']))) : date('Y-m-d', strtotime($rowsdd4['hwnddate']))); ?> &emsp; <?php echo $rowsdd4["hwndsub"]; ?><br/></div></span>
                                                        <br/>
                                                        <?php 
                                                                                           }
                                                               } else {
                                    echo "All homeworks done.";
                                }
                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                </div>
            </div>
    <!-- Modal For Update Profile Picture -->
    <div id="modal_update_profile_picture" class="modal">
        <div class="modal-content cPadding">
            <form id="update_profile_picture_form" >
                <input type="hidden" name="update_student_profile" value="update_student_profile" >
                <input type="hidden" name="studentid" value="<?php echo $localid;?>">
                <h6 align="center">Update Profile Picture</h6>
                <div class="divider"></div>
                     <div class="row">
                        <div class="col s12">
                          <br/>
                          <div class="col s6 " style="text-align:center">
                            <div class="right">
                              <div id="my_camera" class="m-auto">
                                <img src="https://learnmoreskill.github.io/important/dummyprofile.jpg" style="height: 194px;width: 200px;"/>
                              </div>

                              <div class="btn waves-effect waves-light center " style="height: 45px;display: inline-flex;">
                                <span onClick="take_snapshot()" class="m-auto cBtn" id="takePicBtn">Take Picture</span>
                                <span onClick="openCamera()" class="m-auto cBtn" id="cameraBtn">Open camera</span>

                               
                               
                              </div>
                            </div>
                          </div>
                          <div class="file-field input-field col s6 m-0">
                            <div id="results" style="width: 200px;height: 200px;display: flex;">
                              <div class="m-auto center">Your captured image will appear here...</div>
                            </div>
                            <div class="btn cBtn">
                              <span>Browse Picture</span>
                              <input type="file" name="file1" id="file1">

                            </div>
                            <div class="file-path-wrapper col s2">
                              <input class="file-path validate" placeholder="file type JPG, JPEG, PNG & GIF files are allowed." type="text">
                            </div>
                          </div>
                          <input type="hidden" name="file2" id="file2" class="image-tag">
                        </div>
                      </div>

                      <div class="modal-footer">
                        <div class="right">
                            <button id="submitBtn" class="waves-effect waves-green btn-flat blue lighten-2 right" type="submit">
                            Update<i class="material-icons right">send</i>
                            </button>
                            <div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
                        </div>
                        
                        <a href="#" class="modal-close waves-effect waves-green btn-flat grey lighten-2 left">
                            Close
                        </a>
                        
                      </div>
            </form>
        </div>
    </div>

    <!-- MODAL FOR UPDATE LOGIN-->
    <div id="modal_set_password" class="modal">
        <div class="modal-content">
            <form id="set_student_login_form" action="updatescript.php" method="post" >
                <h6 align="center">Set Student Login Details</h6>
                <div class="divider"></div>
                <div class="row">
                    <div class="col s2 offset-m1">
                        <h6 style="padding-top: 20px">Email</h6>
                    </div>
                    <div class="input-field col s6">
                      <input name="student_email" id="student_email" type="email" value="<?php echo $localemail; ?>" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col s2 offset-m1">
                        <h6 style="padding-top: 20px">New Password</h6>
                    </div>
                    <div class="input-field col s6">
                      <input name="student_password" id="student_password" type="password" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col s2 offset-m1">
                        <h6 style="padding-top: 20px">Confirm Password</h6>
                    </div>
                    <div class="input-field col s6">
                      <input name="student_confirm_password" id="student_confirm_password" type="password" required="">
                    </div>
                </div>
                <input type="hidden" name="set_student_login_id" value="<?php echo $localid; ?>">
                <div class="modal-footer">
                  <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit" name="update_student_login">Update<i class="material-icons right">send</i></button>
                </div>

            </form>
        </div>
    </div>  

    <!-- Modal For Update Login -->
    <div id="modal_set_parent_password" class="modal">
        <div class="modal-content">
            <form id="set_parent_login_form" action="updatescript.php" method="post" >
                <h6 align="center">Set Parent Login Details</h6>
                <div class="divider"></div>
                <div class="row">
                    <div class="col s2 offset-m1">
                        <h6 style="padding-top: 20px">Email</h6>
                    </div>
                    <div class="input-field col s6">
                      <input name="parent_email" id="parent_email" type="email" value="<?php echo $localparentemail; ?>" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col s2 offset-m1">
                        <h6 style="padding-top: 20px">New Password</h6>
                    </div>
                    <div class="input-field col s6">
                      <input name="parent_password" id="parent_password" type="password" required >
                    </div>
                </div>
                <div class="row">
                    <div class="col s2 offset-m1">
                        <h6 style="padding-top: 20px">Confirm Password</h6>
                    </div>
                    <div class="input-field col s6">
                      <input name="parent_confirm_password" id="Parent_confirm_password" type="password" required="">
                    </div>
                </div>
                <input type="hidden" name="set_parent_login_id" value="<?php echo $localparentid; ?>">
                <div class="modal-footer">
                  <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit" name="update_parent_login">Update<i class="material-icons right">send</i></button>
                </div>

            </form>
        </div>
    </div>

</main>

<?php include_once("../config/footer.php");?>

<?php  
 if (isset($_SESSION['result_success'])) 
  {
      $result1=$_SESSION['result_success'];
      echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
    unset($_SESSION['result_success']);
    }  

?>

<script type="text/javascript">

    // take Picture
   $("#takePicBtn").hide();
  function openCamera() {
      Webcam.set({
        width: 200,
        height: 200,
        image_format: 'jpeg',
        jpeg_quality: 90
    });
  
    Webcam.attach( '#my_camera' );
     $("#cameraBtn").hide();
     $("#takePicBtn").show();

  }
  function closeCamera(){
    Webcam.reset();
      $("#cameraBtn").show();
      $("#takePicBtn").hide();
      document.getElementById('my_camera').innerHTML = '<img src="https://learnmoreskill.github.io/important/dummyprofile.jpg" style="height: 194px;width: 200px;"/>';
  }
    function take_snapshot() {
        Webcam.snap( function(data_uri) {
            $(".image-tag").val(data_uri);     
            document.getElementById('results').innerHTML = '<img src="'+data_uri+'" style="height: 160px;width: 100%;margin-top: 20px;"/>';
            document.getElementById('file1').value = '';
        } );
    }
  // end take picture


  $(document).ready(function (e) 
{

    function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        document.getElementById('results').innerHTML = '<img src="'+e.target.result+'" style="height: 160px;width: 100%;margin-top: 20px;"/>';
            document.getElementById('file2').value = '';

      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#file1").change(function() {
            closeCamera();

    readURL(this);
  });


   $("#update_profile_picture_form").on('submit',(function(e) 
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
            $("#submitBtn").hide();
            $("#loadingBtn").show();
          },
          success: function(data)
          {
            var result = JSON.parse(data);

            if (result.status == 200) {

                alert('Picture Updated Successfully');
                $('#modal_update_profile_picture').modal('close');
                location.reload();
            }else{
                Materialize.toast(result.errormsg, 4000, 'red rounded');
            }
            
             
            $("#submitBtn").show();
            $("#loadingBtn").hide();
          },
          error: function(e) 
          {
            Materialize.toast('Sorry Try Again !!', 4000, 'red rounded');
            $("#submitBtn").show();
            $("#loadingBtn").hide();
          }          
    });
  }));
  $("#delete_student_profile").on('submit',(function(e) 
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
           
             window.location.href = window.location.href;
            
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  $("#set_student_login_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Login details updated'.trim()) { 
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
              if (data.trim() === 'Login details updated'.trim()) {
                $('#modal_set_password').modal('close');
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#disable_student_login_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Student Login Disabled'.trim()) { 
                $.ajax({
                    type: "post",
                    url: "../important/clearSuccess.php",
                    data: 'request=' + 'result_success',
                    success: function (data1) {
                    }
                });
            } 
            else 
              if (data.trim() === 'Student Login Disabled'.trim()) { 
                window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));


$("#set_parent_login_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Parent login details updated'.trim()) { 
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
              if (data.trim() === 'Parent login details updated'.trim()) {
                $('#modal_set_parent_password').modal('close');
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#disable_parent_login_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Parent Login Disabled'.trim()) { 
                Materialize.toast(data, 4000, 'rounded');
                $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } else if (data.trim() === 'Parent Login Disabled'.trim()) { 
                
                window.location.href = window.location.href;
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
