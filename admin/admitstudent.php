<?php
include('session.php');

require("../important/backstage.php");
$backstage = new back_stage_class();


$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

$feeTypeList = $backstage->get_feetype_details_except_default();


$resultbus = $db->query("SELECT * FROM `bus_route`");

if (isset($_GET["token"])){ // ======== edit student token ======
            $longid1 = ($_GET["token"]);

            if ($longid1=="2ec9ys77bi8939") {
              if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);

            $sqlEdit = $db->query("SELECT `studentinfo`.* , `parents`.* , `section`.`section_name` ,`syearhistory`.`syear_id`
                FROM `studentinfo` 
                LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id`
                LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id` 

                LEFT JOIN `syearhistory` ON `studentinfo`.`sid`=`syearhistory`.`student_id` AND `studentinfo`.`batch_year_id`=`syearhistory`.`year_id`

                WHERE `sid`='$shortid' ");
            if($sqlEdit->num_rows)
            {
            $rowsEdit = $sqlEdit->fetch_assoc();
            extract($rowsEdit);

            $classListEdit= json_decode($backstage->get_class_list_by_year_id($batch_year_id));


            $action = "update";
            }else{ 
          $_GET['token']="";
          }
          }
}elseif ($longid1=="2ecpoij7bi8939") { // ==== edit parent token ====
              if (isset($_GET["key"])){
                  $longid = addslashes($_GET["key"]);
                  $shortid = substr($longid, 17);

                  $sqlEdit = $db->query("SELECT * FROM `parents` WHERE `parent_id`='$shortid' ");
                  if($sqlEdit->num_rows)
                  {
                    $rowsEdit = $sqlEdit->fetch_assoc();
                    extract($rowsEdit);
                  }else
                    {
                    $_GET['token']="";
                    }
              }
  }  
}

?>

    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <script type="text/javascript" src="../js/webcam.min.js"></script>
    <!-- get section list from database-->
    <script>
    function showUser(str) {
      if (str == "") {
          document.getElementById("txtHint").innerHTML = "";
      } else {
          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
              xmlhttp1 = new XMLHttpRequest();

          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
              xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
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



          xmlhttp1.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                var allfee = JSON.parse(this.responseText);

                document.getElementById("tution_fee").value = allfee.tution_fee;
                document.getElementById("hostel_fee").value = allfee.hostel_fee;
                document.getElementById("computer_fee").value = allfee.computer_fee;
                  
              }
          };
           xmlhttp1.open("GET","../important/getListById.php?classRateByClassId="+str,true);
          xmlhttp1.send();
      }
      chngeAccountDetails(str);
    }
    </script>


    <script>
      function onBusChange(str) {
        var busfeediv=document.getElementById("bus_discount_div");
        if (str == "") {
          document.getElementById("bus_fee").value = "";
          busfeediv.style.display = "none";
          return;
        } else {
          if (window.XMLHttpRequest) {
              xmlhttp = new XMLHttpRequest();
          } else {
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("bus_fee").value = this.responseText;                  
              }
          };
          xmlhttp.open("GET","../important/getBusFeeByBusRouteId.php?q="+str,true);
          xmlhttp.send();
          busfeediv.style.display = "block";
        }
      }
      function onTutionChange(str) {
        var tution_fee = document.getElementById("tution_fee");
        if (str) {
          tution_fee.style.background = "";
          tution_fee.removeAttribute("readonly");
        }else{
          tution_fee.value = "";
          tution_fee.style.background = "gray";
          tution_fee.setAttribute("readonly",true);
        }
      }
      function onHostelChange(str) {
        var hostel_fee = document.getElementById("hostel_fee");
        if (str) {
          hostel_fee.style.background = "";
          hostel_fee.removeAttribute("readonly");
        }else{
          hostel_fee.value = "";
          hostel_fee.style.background = "gray";
          hostel_fee.setAttribute("readonly",true);
        }
      }
      function onComputerChange(str) {
        var computer_fee = document.getElementById("computer_fee");
        if (str) {
          computer_fee.style.background = "";
          computer_fee.removeAttribute("readonly");
        }else{
          computer_fee.value = "";
          computer_fee.style.background = "gray";
          computer_fee.setAttribute("readonly",true);
        }
      }
    </script>

  <main>
    <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
    <div class="section no-pad-bot" id="index-banner">
      <?php include_once("../config/schoolname.php");?>
      <div class="row">
        <div class="col s12">
          <ul class="tabs github-commit">
            <?php if( (isset($_GET['token']) && @$_GET['token']=="2ec9ys77bi8939") ){ ?> 
            <div class="row center"><a class="white-text text-lighten-4" href="#">Edit Student Details</a></div>
            <?php }elseif ((isset($_GET['token']) && @$_GET['token']=="2ecpoij7bi8939")) { ?>
            <div class="row center"><a class="white-text text-lighten-4" href="#">Edit Parent Details</a></div>
            <?php  } else{ ?>
            <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#admit_student">Admit Student</a></li>
            <li class="tab col s3"><a class="white-text text-lighten-4" href="#add_parent">Add Parent</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>

<!-- ========================== Edit student div ==================================== -->
    <?php if(isset($_GET['token']) && @$_GET['token']=="2ec9ys77bi8939") { ?>
      

          <div class="row">
                <form class="col s12" id="update_student_form" action="updatescript.php" method="post">

                  <input type="hidden" name="syear_id" value="<?php echo $syear_id;?>">
                  <input type="hidden" name="stdid" value="<?php echo $sid;?>">
                  <input type="hidden" name="update_student" value="update_student">

                    <div class="row">
                        <div class="search-box test3 input-field col s12 m12">

                            <input id="searchname" autocomplete="off" name="searchname" type="text" class="validate" 
                            value="<?php if(!empty($sparent_id)){ 
                                echo ((!empty($spname))? $spname:''); 
                                echo (!empty($spname) && !empty($smname))? ' / ':''; 
                                echo $smname.((!empty($sp_address))? ' Address: '.$sp_address :'').((!empty($spnumber))? 'mobile: '.$spnumber:''); 
                              }?>" 
                              autofocus >
                            <div class="result resultStyle" style="max-height: 530px;"></div>
                            <label class="" for="searchname">Search Parent</label>


                            
                        </div>
                        
                        
                    </div>
                    <input type="hidden" id="spid" name="spid" value="<?php echo $sparent_id; ?>" >








                    <div class="row">
                        <div class="input-field col s6">
                          <input name="sname" id="sname" type="text" placeholder="Student Full Name" value="<?php echo $sname;?>" required="" aria-required="true">
                          <label for="sname">Student Full Name*</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="scaste" id="scaste" type="text" value="<?php echo $caste;?>" placeholder="eg:general/other default:General">
                          <label for="scaste">Caste</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                          <input name="saddress" id="saddress" type="text" value="<?php echo $saddress;?>" required="" aria-required="true">
                          <label for="saddress">Address*</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                          <input name="smobile" id="smobile" type="tel" value="<?php echo $smobile;?>">
                          <label for="smobile">Mobile number</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="semail" id="semail" type="email" class="validate" value="<?php echo $semail;?>">
                          <label for="semail" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                    </div>
                    <div class="row">
                      <div class="input-field col s6">
                            <select name="sclass" onchange="showUser(this.value)">

                              <option value="" >Select class</option>

                                <?php 
                                foreach ($classListEdit as $clist) {
                                    echo '<option value="'.$clist->class_id.'" '.(($sclass==$clist->class_id)?'selected="selected"':'').'> ' . $clist->class_name. ' </option>';
                                }
                                ?>
                            </select>
                            <label>Class:</label>
                        </div>                        
                        <div class="input-field col s6">
                          <select name="ssec" id="txtHint">
                            <option value="" >Select class first</option>
                            <?php if(!empty($ssec)){ echo "<option value=".$ssec." selected='selected'>".$section_name."</option>";} ?>
                          </select>
                          <label>Section:</label>
                        </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s6">
                            <input name="admissiondate" id="admissiondateedit" type="text" required placeholder="select date"  
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                          >
                          <label for="admissiondate">Admission date or Join date(B.S.)</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="sdob" id="dobedit" type="text" required placeholder="select date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"

                            >
                          <label for="sdob">Birth date(B.S.)</label>
                        </div> 
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="ssex" value="male" type="radio" id="Male" <?php if (strtolower($sex)=='male') {echo 'checked';
                          }?> />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="ssex" value="female" type="radio" id="Female" <?php if (strtolower($sex)=='female') {echo 'checked';
                          }?> />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="ssex" value="other" type="radio" id="Other" <?php if (strtolower($sex)=='other') {echo 'checked';
                          }?> />
                          <label for="Other">Other</label>
                        </div>
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

                    <h5>Account Details</h5>
                    <div class="divider"></div>


                      <div class="row">
                        <div class="input-field col s12">
                            <select name="payment_type">
                              <option value="" disabled>Choose payment option</option>
                              <option value="0" <?php echo (($payment_type=='0')?'selected="selected"':''); ?> >Monthly</option>
                              <option value="1" <?php echo (($payment_type=='1')?'selected="selected"':''); ?> >Yearly</option>
                            </select>
                            <label>Payment Type</label>
                        </div>
                      </div>
                      <div class="row">

                        <div class="col s2 switch">
                            <label style="font-size: 18px" class="black-text">Tution fee<br>
                            <input type="checkbox" name="tution_checked" onchange="onTutionChange(this.checked)" 
                            <?php echo $tution? 'checked':''; ?> >
                            <span class="lever"></span></label>
                        </div>

                        <div class="input-field col s10">
                              <input name="tution_fee" id="tution_fee" type="text" class="validate" placeholder="e.g. 4000" value="<?php echo $tution_fee;?>" <?php echo $tution? "":"readonly style='background: gray'"; ?>  >
                              <label for="tution_fee">Tuition Fee</label>
                        </div>
                      </div>                   

                      <div class="row">

                        <div class="col s2 switch">
                            <label style="font-size: 18px" class="black-text">Hostel fee<br>
                            <input type="checkbox" name="hostel_checked" onchange="onHostelChange(this.checked)" 
                            <?php echo $hostel? 'checked':''; ?> >
                            <span class="lever"></span></label>
                        </div>

                        <div class="input-field col s10">
                              <input name="hostel_fee"  id="hostel_fee" type="text" class="validate" placeholder="e.g. 4000" value="<?php echo $hostel_fee;?>" <?php echo $hostel? "":"readonly style='background: gray'"; ?> >
                              <label for="hostel_fee" >Hostel Fee</label>
                        </div>
                      </div>
                      <div class="row">

                        <div class="col s2 switch">
                            <label style="font-size: 18px" class="black-text">Computer fee<br>
                            <input type="checkbox" name="computer_checked" onchange="onComputerChange(this.checked)" 
                            <?php echo $computer? 'checked':''; ?> >
                            <span class="lever"></span></label>
                        </div>

                        <div class="input-field col s10">
                              <input name="computer_fee" id="computer_fee" type="text" class="validate" placeholder="e.g. 4000" value="<?php echo $computer_fee;?>" <?php echo $computer? "":"readonly style='background: gray'"; ?> >
                              <label for="computer_fee" >Computer Fee</label>
                        </div>
                      </div>
                      

                      <div class="row">
                        <div class="input-field col s6">
                            <select id="studentbusid" name="studentbusid" onchange="onBusChange(this.value)">
                              <option value="" >Select Bus</option>
                                <?php if ($resultbus->num_rows > 0) {
                                    while($rowbus = $resultbus->fetch_assoc()) { ?>

                                            <option value="<?php echo $rowbus['bus_route_id'];?>" <?php echo (($bus_id==$rowbus['bus_route_id'])?'selected="selected"':''); ?>  ><?php echo $rowbus['bus_stop'].'&nbsp &nbsp &nbsp &nbsp'.$rowbus['bus_route'].'&nbsp &nbsp &nbsp &nbsp Fee: '.$rowbus['bus_fee_rate'];?></option>
                                <?php 
                                }
                                }
                                ?>
                                
                            </select>
                            <label for="studentbusid">Select Bus:</label>
                        </div>

                        <div id="bus_discount_div" <?php if ($bus_id==0 || $bus_id==''){ echo 'style="display: none;"';  } ?>  >
                          <div class="input-field col s6">
                                <input name="bus_fee" id="bus_fee" type="text" class="validate" placeholder="e.g. 400 (leave empty or 0 For full discount)" value="<?php echo $bus_fee;?>">
                                <label for="bus_fee">Bus Fee</label>
                          </div>
                        </div>
                      </div>

                    <div class="row">
                        <div class="input-field col offset-m9">
                             <button id="editStudentSubmit" class="btn waves-effect waves-light" type="submit">Update<i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>
                </form>
            </div>
        

<!-- ========================== Edit Parent div ==================================== -->
    <?php } elseif(isset($_GET['token']) && @$_GET['token']=="2ecpoij7bi8939") { ?>

          <div class="row">
                <form class="col s12" id="update_parent_form" action="updatescript.php" method="post">

                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="spname" id="spname" type="text" value="<?php echo $spname;?>" >
                          <label for="spname">Father's Full Name</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="smname" id="smname" type="text" value="<?php echo $smname;?>" >
                          <label for="smname">Mother's Full Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="spprof" id="spprof" type="text" placeholder="father/mother profession" value="<?php echo $spprofession;?>" >
                          <label for="spprof">Parent's Profession*</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="spemail" id="spemail" type="email" class="validate" value="<?php echo $spemail;?>" >
                          <label for="spemail" data-error="wrong" data-success="right" >Parent's Email Id</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="spnumber" id="spnumber" type="tel" required="" aria-required="true" value="<?php echo $spnumber;?>">
                          <label for="spnumber">Parent's Mobile Number*</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="spnumber2" id="spnumber2" type="tel" value="<?php echo $spnumber_2;?>">
                          <label for="spnumber2">Parent's Mobile Number(alternate)</label>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                          <input name="spaddress" id="spaddress" type="text" required="" aria-required="true" value="<?php echo $sp_address;?>">
                          <label for="spaddress">Address*</label>
                        </div>
                    </div>
                    <div class="row">
                      <input type="hidden" name="parentid" value="<?php echo $parent_id;?>">
                      <input type="hidden" name="update_parent">
                        <div class="input-field col offset-m9">
                             <button id="editParentSubmit" class="btn waves-effect waves-light" type="submit">Update<i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>
                </form>
            </div>

        <?php 
      } else { 
      /*set active navbar session*/
      $_SESSION['navactive'] = 'admitstudent';  ?>

<!-- ================================= Add Student div ========================================== -->
             <div id="admit_student" class="row">
                <form class="col s12" id="admit_student_form" action="addscript.php" method="post" enctype="multipart/form-data"  >

                  <input type="hidden" name="student_form" value="student_form">
                  <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">

                    <div class="row">
                        <div class="search-box test3 input-field col s12 m12">

                            <input id="searchname" autocomplete="off" name="searchname" type="text" class="validate" autofocus >
                            <div class="result resultStyle" style="max-height: 530px;"></div>
                            <label class="" for="searchname">Search Parent</label>


                            
                        </div>
                        
                        
                    </div>
                    <input type="hidden" id="spid" name="spid" >


                    <div class="row">
                        <div class="input-field col s6">
                          <input name="sname" id="sname" type="text" placeholder="Student Full Name" required="" aria-required="true">
                          <label for="sname">Student Full Name*</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="scaste" id="scaste" type="text" placeholder="eg:general/other default:General">
                          <label for="scaste">Caste</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                          <input name="saddress" id="saddress" type="text" required="" aria-required="true">
                          <label for="saddress">Address*</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                          <input name="smobile" id="smobile" type="tel">
                          <label for="smobile">Mobile number(Optional)</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="semail" id="semail" type="email" class="validate" >
                          <label for="semail" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <select name="sclass" id="sclass" onchange="showUser(this.value)">

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
                          <select name="ssection" id="txtHint">
                            <option value="" >Select class first</option>
                          </select>
                          <label>Section:</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                            <input name="admissiondate" id="admissiondate"  type="text" placeholder="Select Date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                            >
                          <label for="admissiondate">Admission date or Join date(B.S.)</label>
                        </div>
                        <div class="input-field col s6">
                            <input name="sdob" id="sdob" type="text" placeholder="Select Date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"

                             >
                          <label for="sdob">Birth date(B.S.)*</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="ssex" value="male" type="radio" id="Male" checked />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="ssex" value="female" type="radio" id="Female" />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="ssex" value="other" type="radio" id="Other" />
                          <label for="Other">Other</label>
                        </div>
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
                        <div class="input-field col s6">

                              <input name="spassword1" id="spassword1" type="password">
                              <label for="spassword1" >Password(Optional)</label>

                             
                              
                          
                        </div>
                        <div class="input-field col s6">
                              <label for="spassword2" >Confirm password</label>

                             <input name="spassword2"  id="spassword2" type="password">
                          </div>                      

                          
                        </div>
            
                    <h5>Account Details</h5>
                    <div class="divider"></div>
                    <div class="row center" id="accountInfoDiv">
                      <h5 class="red-text">Please select class to add account details..</h3>
                    </div>
                    <div id="incrementalAccountDiv" style="display: none;" class="card grey lighten-3">
                      <div class="card-title center black-text grey lighten-1">Incremental fee</div>
                      <div class="row">
                        <div class="input-field col m12 s6">
                            <select name="payment_type">
                              <option value="" disabled>Choose payment option</option>
                              <option value="0">Monthly</option>
                              <option value="1">Yearly</option>
                            </select>
                            <label>Payment Type</label>
                        </div>
                      </div>
                      <div class="row">

                          <div class="col s2 switch">
                              <label style="font-size: 18px" class="black-text">Tution fee<br>
                              <input type="checkbox" name="tution_checked"  onchange="onTutionChange(this.checked)" >
                              <span class="lever"></span></label>
                          </div>

                          <div class="input-field col s10">
                                  <input name="tution_fee" id="tution_fee" type="text" class="validate" placeholder="e.g. 4000" 
                                  readonly style='background: gray' >
                                  <label for="tution_fee" >Tuition Fee</label>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col s2 switch">
                              <label style="font-size: 18px" class="black-text">Hostel fee<br>
                              <input type="checkbox" name="hostel_checked" onchange="onHostelChange(this.checked)" >
                              <span class="lever"></span></label>
                          </div>

                          <div class="input-field col s10">
                                <input name="hostel_fee" id="hostel_fee" type="text" class="validate" placeholder="e.g. 4000" 
                                readonly style='background: gray' >
                                <label for="hostel_fee" >Hostel Fee</label>
                          </div>
                      </div>
                      <div class="row">
                          <div class="col s2 switch">
                              <label style="font-size: 18px" class="black-text">Computer fee<br>
                              <input type="checkbox" name="computer_checked" onchange="onComputerChange(this.checked)" >
                              <span class="lever"></span></label>
                          </div>
                          <div class="input-field col s10">
                                <input name="computer_fee" id="computer_fee" type="text" class="validate" placeholder="e.g. 4000" 
                                readonly style='background: gray' >
                                <label for="computer_fee" >Computer Fee</label>
                          </div>
                      </div>

                      <div class="row">
                          <div class="input-field col s6">
                              <select id="studentbusid" name="studentbusid" onchange="onBusChange(this.value)">
                                <option value="" >Select Bus</option>
                                  <?php if ($resultbus->num_rows > 0) {
                                      while($rowbus = $resultbus->fetch_assoc()) { ?>

                                              <option value="<?php echo $rowbus['bus_route_id'];?>" ><?php echo $rowbus['bus_stop'].'&nbsp &nbsp &nbsp &nbsp'.$rowbus['bus_route'].'&nbsp &nbsp &nbsp &nbsp Fee: '.$rowbus['bus_fee_rate'];?></option>
                                  <?php 
                                  }
                                  }
                                  ?>
                                  
                              </select>
                              <label for="studentbusid">Select Bus:</label>
                          </div>

                          <div id="bus_discount_div" style="display: none;">
                            <div class="input-field col s6">
                                  <input name="bus_fee" id="bus_fee" type="text" class="validate" placeholder="e.g. 400" >
                                  <label for="bus_fee">Bus Fee</label>
                            </div>
                          </div>
                      </div>
                    </div>
                    <!-- Start Dynamic fee -->

                        <div id="otherFeeDiv" class="card  grey lighten-3">
                          <div id="otherFeeTitle" class="card-title center black-text grey lighten-1 mb-2" style="display: none;">Other fee</div>
                          <div id='TextBoxesGroup' >

                          </div>
                          
                        </div>

                        

                        <div class="row" id="addMoreFeeDiv" style="display: none;">
                          <button id='addButton' class="btn waves-effect waves-light" type="button" >Add other fee</button>
                        </div>
                      
                    
                    <!-- End Dyanmic fee -->

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
                                <span onClick="take_snapshot()" class="m-auto" id="takePicBtn">Take Picture</span>
                                <span onClick="openCamera()" class="m-auto" id="cameraBtn">Open camera</span>

                               
                               
                              </div>
                            </div>
                          </div>
                          <div class="file-field input-field col s6 m-0">
                            <div id="results" style="width: 200px;height: 200px;display: flex;">
                              <div class="m-auto center">Your captured image will appear here...</div>
                            </div>
                            <div class="btn">
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
                    <div class="row">
                        <div class="input-field col offset-m9">
                            <button id="addStudentSubmit" class="btn waves-effect waves-light" type="submit" >Submit<i class="material-icons right">send</i>
                            </button>
                        </div>

                    </div>
                </form>
            </div>



<!-- =================================Add parent div========================================== -->
            <div id="add_parent" class="row">
                <form class="col s12" id="parentform" action="addscript.php" method="post"  >

                    <div class="row">
                        <div class="input-field col s6">
                          <input name="spname" id="spname" type="text" >
                          <label for="spname">Father's Full Name</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="smname" id="smname" type="text" >
                          <label for="smname">Mother's Full Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                          <input name="spprof" id="spprof" type="text" placeholder="father/mother profession" >
                          <label for="spprof">Parent's Profession*</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="spemail" id="spemail" type="email" class="validate">
                          <label for="spemail" data-error="wrong" data-success="right" >Parent's Email Id</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                          <input name="spnumber" id="spnumber" type="tel" required="" aria-required="true" >
                          <label for="spnumber">Parent's Mobile Number*</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="spnumber2" id="spnumber2" type="tel">
                          <label for="spnumber2">Parent's Mobile Number(alternate)</label>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                          <input name="spaddress" id="spaddress" type="text" required="" aria-required="true" >
                          <label for="spaddress">Address*</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s6">
                              <input name="sppassword1" id="sppassword1" type="password"  >
                              <label for="sppassword1" >Password</label>

                              <input name="sppassword2" placeholder="confirm password" id="sppassword2" type="password" >
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="input-field col offset-m9">
                             <button id="addParentSubmit" class="btn waves-effect waves-light" type="submit" name="parent_form" >Submit<i class="material-icons right">send</i>
                              </button>
                        </div>
                    </div>

                </form>
            </div>
            <?php
      }
      ?>

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
      var divCreated = 0;
      var val1=[];
      var counter = 1;

      $(document).ready(function(){
        
        $("#addButton").click(function () {

          document.getElementById("otherFeeTitle").style.display = "block";
            
          if(divCreated>9){
            alert("Only 10 textboxes allow");
            return false;
          }   
            var feeTypeList=<?php echo $feeTypeList; ?>;
          var newTextBoxDiv = $(document.createElement('div')).attr("id", 'TextBoxDiv' + counter);
          newTextBoxDiv.attr( 'class', 'row');
                        var t="";
                         feeTypeList.forEach (function(item) {
                            t +='<option value="'+item.feetype_id+'" >'+item.feetype_title+'</option>';
                          });
          newTextBoxDiv.after().html('<div class="input-field col s5 noMargin">'+
                                        '<select name="otherFeeType['+counter+']" id="otherFee'+counter+'" onchange="addFee(this,'+counter+')">'+
                                            '<option value="" >Select fee type</option>'+t+

                                '</select><label>Fee type:</label></div>'+

                                '<div class="input-field col s5 noMargin"><input name="otherFeeValue['+counter+']" id="otherFeeValue'+counter+'" type="text" required placeholder="e.g. 500"> </div>'+

                                        '<a class="input-field col s1 offset-s1" href="javascript:void(0);" onclick="removeTag('+ counter + ')" id="removeButton" class="remove_button"><i class="material-icons red-text">delete</i></a>');
                    
          newTextBoxDiv.appendTo("#TextBoxesGroup");

          $('#otherFee'+counter).material_select();

                
          counter++;
          divCreated++;
         });
         
      });
      function removeTag(counter){
          $("#TextBoxDiv" + counter).remove();
          // counter--;
          divCreated--;
          if (val1['otherFee'+counter]) {
            delete val1['otherFee'+counter];

          }
          if (divCreated<1) {
            document.getElementById("otherFeeTitle").style.display = "none";
          }

      }

  
    function addFee(selected,lastId){
        var feetype = $("#"+selected.id+" option:selected").html();
        if (selected.value!="") {
          for (var i in val1)
          {
            if (val1[i]==selected.value) {
              alert("'"+feetype+"' Already added");
              $("#"+selected.id).val("");
              $("#"+selected.id).material_select();
              return;
            }
          }
        }
          val1[selected.id]=selected.value;
          addFeeValue(selected.value,feetype,lastId);

    }
    function addFeeValue(feetypeId,feetype,lastId){
      var classId = $("#sclass option:selected").val();

      console.log('feetypeId:'+feetypeId+', feetype:'+feetype+' , lastId:'+lastId);

        if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp5 = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp5 = new ActiveXObject("Microsoft.XMLHTTP");
        }

        xmlhttp5.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
              var result = JSON.parse(this.responseText);
              document.getElementById("otherFeeValue"+lastId).value = result.fee;                  
            }
        };
        xmlhttp5.open("GET","../important/getListById.php?getFeeByClassIdAndFeetype="+classId+"&feetype="+feetype,true);
        xmlhttp5.send();
    }


    function chngeAccountDetails(classId){
      if (classId == "") {

        document.getElementById("incrementalAccountDiv").style.display = "none";
        document.getElementById("addMoreFeeDiv").style.display = "none";
        document.getElementById("accountInfoDiv").style.display = "block";

        document.getElementById("TextBoxesGroup").innerHTML = "";
        var divCreated = 0;
        var val1=[];
        var counter = 1;
      }else{
        document.getElementById("accountInfoDiv").style.display = "none";
        document.getElementById("incrementalAccountDiv").style.display = "block";
        document.getElementById("addMoreFeeDiv").style.display = "block";


      }

    }
</script>


<script>
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
      document.getElementById('my_camera').innerHTML = '<img src="https://learnmoreskill.github.io/important/dummyprofile.jpg" style="height: 194px;width: 100%;"/>';
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

  $("#admit_student_form").on('submit',(function(e) 
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
            //$("#err").fadeOut();
            $("#overlayloading").show();
            $("#addStudentSubmit").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Student succesfully added'.trim()) {
             Materialize.toast(data, 4000, 'red rounded');
             $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                  //alert(data);
                }
              });

           } 
            else 
              if (data.trim() === 'Student succesfully added'.trim()) {

              window.location.reload();
            }

            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#addStudentSubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  }));



// for parent form
  $("#parentform").on('submit',(function(e) 
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
            // $("#err").fadeOut();
            $("#overlayloading").show();
            $("#addParentSubmit").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Parent succesfully added'.trim()) {
             Materialize.toast(data, 4000, 'rounded');
             $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                  //alert(data);
                }
              });
           } 
            else 
              if (data.trim() === 'Parent succesfully added'.trim()) {

              window.location.href = 'admitstudent.php';
            }

            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#addParentSubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  }));
$("#update_student_form").on('submit',(function(e) 
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
            // $("#err").fadeOut();
            $("#overlayloading").show();
            $("#editStudentSubmit").hide();
          },
          success: function(data)
          {
            if (data.trim() !== 'Student succesfully updated') {
              //alert(data);
              Materialize.toast(data, 4000, 'red rounded');
              $.ajax({
                  type: "post",
                  url: "../important/clearSuccess.php",
                  data: 'request=' + 'result_success',
                  success: function (data1) {
                    //alert(data);
                  }
                });
            }else{
               Materialize.toast(data, 4000, 'green rounded');
                $.ajax({
                  type: "post",
                  url: "../important/clearSuccess.php",
                  data: 'request=' + 'result_success',
                  success: function (data1) {
                    //alert(data);
                  }
                });
            }

            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#editStudentSubmit").show();
            
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  })); 
$("#update_parent_form").on('submit',(function(e) 
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
            // $("#err").fadeOut();
            $("#overlayloading").show();
            $("#editParentSubmit").hide();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Parent succesfully updated'.trim()) { Materialize.toast(data, 4000, 'rounded'); } 
            else 
              if (data.trim() === 'Parent succesfully updated'.trim()) { Materialize.toast(data, 4000, 'rounded');

              /*window.location.href = 'allstudent.php?resp=success';*/
            }
            setInterval(function() {$("#overlayloading").hide(); },500);
            $("#editParentSubmit").show();
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            $("#overlayloading").hide();
          }          
    });
  })); 
  
});

</script>

<script type="text/javascript">
        
  var admisiondate = "<?php echo (($login_date_type==2)? eToN($admission_date) : $admission_date);?>";
  if (admisiondate != '-00-00'){
    document.getElementById("admissiondateedit").value = admisiondate;
  }

  var dobdate = "<?php echo (($login_date_type==2)? eToN($dob) : $dob);?>";
  if (dobdate != '-00-00'){
    document.getElementById("dobedit").value = dobdate;
  }
</script>


<script type="text/javascript">
$(document).ready(function(){
  $("#searchname").keyup(function() {
      
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){ 
            $.get("backend-search.php", {active_parent: inputVal}).done(function(data){
                // Display the returned data in browser
                //debugger;
                data=JSON.parse(data);
                var temparr='';
                data.forEach(function(value){
                  temparr += "<p>"+value.spname+"&nbsp&nbsp&nbsp"+value.smname+"&nbsp&nbsp&nbsp"+value.spnumber+"&nbsp&nbsp&nbsp"+value.sp_address+"<span id='usrData' style='display:none;'>"+JSON.stringify(value)+"</span></P>"

                });
                  resultDropdown.html(temparr);
            });
        } else{
            resultDropdown.empty();
            $("#spid").val("");              
              }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){    

        var sName=$(this).parents(".search-box").find('input[type="text"]').val(this.innerText);

        //var sData=document.getElementById('usrData').innerHTML;  
        var sData = this.getElementsByTagName('span')[0].innerHTML;              
        sData=JSON.parse(sData);
        console.log("data received",sData.spname);
        //debugger;
        $(this).parent(".result").empty();
        
        $("#spid").val(sData.parent_id);
        
    });
});
</script>