<?php
include('session.php');
include("../important/backstage.php");
$backstage = new back_stage_class();

if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);
        }

$sqlteacher1 = "SELECT * FROM teachers WHERE tid='$shortid'";
    $resultteacher1 = $db->query($sqlteacher1);
    $localemail='';
    $localid='';
?>
     <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Teacher Details</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <?php 
            if ($resultteacher1->num_rows > 0) {
                while($row = $resultteacher1->fetch_assoc()) { 
                  $localemail=$row["temail"];
                  $localid=$row["tid"];

                  $sectionClass = json_decode($backstage->get_class_section_by_teacher_id($localid));

                ?>
                        <div class="card">
                            <div class="card-panel purple darken-3">
                                <div class="row">
                                    <div class="col s12 m6">
                                <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Teacher Info</span>

                                <?php if ($login_cat == 1 || $pac['edit_teacher']) { ?>

                                &nbsp&nbsp<a href="addteacher.php?token=2ec9yS77bte9s9&key=<?php echo "ae25nJs3fr596dge@".$row["tid"]; ?>"> <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>

                                &nbsp&nbsp <a href="#modal_set_password" class="modal-trigger"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Update or Set login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons blue-text text-lighten-1">vpn_key</i></div></a>

                                <form style="display: inline;"  id="disable_teacher_login_form" action="updatescript.php" method="post" >
                                    <input type="hidden" name="disable_teacher_login" value="<?php echo $row["tid"];?>">
                                    <button class="disable_login_button" type="submit" onclick="return confirm('Do you really want to disable login?');" ><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Disable login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons red-text text-lighten-1"><?php echo ((empty($row["tgetter"]))? 'no_encryption' : 'https'); ?></i></div></button>
                                </form>

                                <?php } ?>

                                <div class="card-content white-text flow-text">
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $row["tname"]; ?></div>
                                        <br>
                                    <?php if(!empty($row["sex"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Gender" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">wc</i>&nbsp;<?php echo ucfirst($row["sex"]); ?>
                                  </div><br><?php } ?>

                                  <?php if(!empty($row["dob"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date Of Birth" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">sentiment_dissatisfied</i>&nbsp;<?php echo (($login_date_type==2)? eToN($row["dob"]) : $row["dob"]); ?>
                                  </div><br><?php } ?>

                                    <?php if (count((array)$sectionClass)) { ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Class Teacher Of:" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assessment</i>&nbsp; <?php foreach ($sectionClass as $classTecher) {
                                      echo $classTecher->class.'-'.$classTecher->section."&nbsp&nbsp&nbsp&nbsp";
                                    } ?></div><br><?php } ?>

                                    <?php if(!empty($row["tmobile"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Mobile Number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">tablet_android</i>&nbsp;<?php echo $row["tmobile"]; ?>
                                  </div><br><?php } ?>
                                  
                                  <?php if(!empty($row["temail"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $row["temail"]; ?>
                                  </div><br><?php } ?>

                                  <?php if(!empty($row["taddress"])){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Address" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">home</i>&nbsp;<?php echo $row["taddress"]; ?></div><br><?php } ?>

                                    <?php if ($row["status"]==0) { ?>
                                        <div class="tooltipped green-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Active</div><br>
                                    <?php }else if ($row["status"]!=0) { ?>
                                        <div class="tooltipped red-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Inactive</div><br>
                                    <?php } ?>
                                    

                                      <br/> 
                                </div>
                            </div>


                            <div class="col s12 m4 offset-m2">
                                 <div class="card-content white-text flow-text" >
                                    <div class="card grey darken-2 roundedImage" >
                                        <div class="card-image profile-pic">
                                            <img class="circle responsive-img" src="<?php $image=$row["timage"]; if(!empty($image)){ echo "../uploads/".$fianlsubdomain."/profile_pic/".$image; }elseif($row["sex"]=='male'){ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } elseif($row["sex"]=='female'){ echo "https://learnmoreskill.github.io/important/dummyprofilefemale.jpg"; }else{echo "https://learnmoreskill.github.io/important/dummyprofile.jpg";} ?>" alt="image not avilable"   >

                                            <?php if ($login_cat == 1 || $pac['edit_teacher']) { ?>

                                            <form  id="delete_teacher_profile" action="updatescript.php" method="post" >
                                                <input type="hidden" name="delete_teacher_profile" >
                                                <input type="hidden" name="teacherid" value="<?php echo $row["tid"];?>">
                                            <button class="btn-floating halfway-fab waves-effect waves-light grey lighten-4" type="submit"><i class="material-icons red-text text-darken-4">delete</i></button>
                                            </form>
                                        </div>

                                        <div class="card-action">
                                            <form  id="teacher_profile" action="updatescript.php" method="post" >
                                                <input id="teacher_profilepic1" type="file" name="teacher_profilepic1">
                                                <input type="hidden" name="update_teacher_profile" >
                                                <input type="hidden" name="teacherid" value="<?php echo $row["tid"];?>">
                                            </form>

                                        <?php } ?>
                                        
                                        </div>

                                    </div>
                              </div>
                            </div>

                        </div>
                    </div>
                        </div>
                        <?php
                    }
                }
                        ?>
                        
                </div>
            </div>
<!-- Modal Structure -->
  <div id="modal_set_password" class="modal">
    <div class="modal-content">
      <form id="set_teacher_login_form" action="updatescript.php" method="post" >
        <h6 align="center">Set Login Details</h6>
        <div class="divider"></div>
        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Email</h6>
            </div>
            <div class="input-field col s6">
              <input name="teacher_email" id="teacher_email" type="email" value="<?php echo $localemail; ?>" required >
            </div>
        </div>
        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">New Password</h6>
            </div>
            <div class="input-field col s6">
              <input name="teacher_password" id="teacher_password" type="password" required >
            </div>
        </div>
        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Confirm Password</h6>
            </div>
            <div class="input-field col s6">
              <input name="teacher_confirm_password" id="teacher_confirm_password" type="password" required="">
            </div>
        </div>
        <input type="hidden" name="set_teacher_login_id" value="<?php echo $localid; ?>">
    <div class="modal-footer">
      <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit" name="update_mark">Update<i class="material-icons right">send</i></button>
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
  $(document).ready(function (e) 
{
  $("#teacher_profile").on('change',(function(e) 
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
  $("#delete_teacher_profile").on('submit',(function(e) 
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
            if (data.trim() !== 'Teacher profile picture deleted'.trim()) { 
              Materialize.toast(data, 4000, 'rounded'); 
              $.ajax({
                  type: "post",
                  url: "../important/clearSuccess.php",
                  data: 'request=' + 'result_success',
                  success: function (data1) { }
              });
            } else if (data.trim() === 'Teacher profile picture deleted'.trim()) {
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#set_teacher_login_form").on('submit',(function(e) 
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
                  success: function (data1) { }
              });
            } else if (data.trim() === 'Login details updated'.trim()) {
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
$("#disable_teacher_login_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Teacher Login Disabled'.trim()) { 
              Materialize.toast(data, 4000, 'rounded'); 
              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) { }
              });
            }else if (data.trim() === 'Teacher Login Disabled'.trim()) { 
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
