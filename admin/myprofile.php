<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'myprofile';

    ?>
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <script type="text/javascript" src="../js/webcam.min.js"></script>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#"><?php echo $lang['welcome']." ".$login_session2; ?> </a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-panel purple darken-3">
                            <div class="row">
                                    <div class="col s12 m6">
                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;"><?php echo $lang['my_profile']; ?></span>&nbsp&nbsp  

                                <?php if ($login_cat == 1) { ?>
                                 <a class="modal-trigger"  href="#modaleditadmin" class="btn-floating btn-small waves-effect waves-light teal"><i class="material-icons">edit</i></a> 
                                <?php } ?>

                                

                                <div class="card-content white-text flow-text">
                                <div class="tooltipped capFirstAll" data-position="right" data-delay="50" data-tooltip="Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $login_session2; ?>
                                </div>
                                <br>
                                <div class="tooltipped capFirstAll" data-position="right" data-delay="50" data-tooltip="School" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">domain</i>&nbsp;<?php echo $login_session_a; ?></div><br>


                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email ID" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $login_session3; ?>
                                        </div><br>
                                        
                                <?php if(!empty($LOGIN_MOBILE)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Mobile no:" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">phone</i>&nbsp;<?php echo $LOGIN_MOBILE; ?>
                                        </div><br>
                                <?php } ?>

                                <?php if(!empty($LOGIN_SEX)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Gender" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">wc</i>&nbsp;<?php echo ucfirst($LOGIN_SEX); ?></div>
                                        <br> <?php } ?>



                                            <br>


                                        </div>
                                    </div>
                                <div class="col s12 m4 offset-m2">
                                <div class="card-content white-text flow-text" >
                                    <div class="card grey darken-2 roundedImage " >
                                        <div class="card-image profile-pic customCardImage">
                                            <img class="circle responsive-img" src="<?php if(!empty($login_session5)){ echo "../uploads/".$fianlsubdomain."/profile_pic/".$login_session5; }elseif(strtolower($login_session8)=='male'){ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } elseif(strtolower($login_session8)=='female'){ echo "https://learnmoreskill.github.io/important/dummyprofilefemale.jpg"; }else{ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } ?>" alt="image not avilable"   >


                                        <?php if ($login_cat == 1) { ?>

                                            <form  id="delete_admin_profile" action="updatescript.php" method="post" >
                                                <input type="hidden" name="delete_admin_profile" >
                                                <input type="hidden" name="adminid" value="<?php echo $login_session1;?>">
                                            <button class="btn-floating halfway-fab waves-effect waves-light grey lighten-4" type="submit"><i class="material-icons red-text text-darken-4">delete</i></button>
                                            </form>
                                            </div>
                                            
                                            <div class="card-action cPadding center">
                                                <a href="#modal_update_profile_picture" class="modal-trigger white-text" > 
                                                    <i class="material-icons white-text text-darken-4">edit</i> Change 
                                                </a>                                            
                                            </div>

                                          <?php } ?>

                                        </div>
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
                <input type="hidden" name="update_admin_profile" value="update_admin_profile" >
                <input type="hidden" name="adminid" value="<?php echo $login_session1;?>">
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
  <!-- Modal Structure -->
  <div id="modaleditadmin" class="modal">
    <div class="modal-content">
      <form id="update_admin_info" action="updatescript.php" method="post" >
        <h6 align="center">Update your details</h6>
        <div class="divider"></div>
        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Name</h6>
            </div>
            <div class="input-field col s6">
              <input name="admin_name" id="admin_name" type="text" class="validate" value="<?php echo $login_session2; ?>" required >
            </div>
        </div>
        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Email</h6>
            </div>
            <div class="input-field col s6">
              <input name="admin_email" id="admin_email" type="text" class="validate" value="<?php echo $login_session3; ?>" required readonly >
            </div>
        </div>
        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Mobile no:</h6>
            </div>
            <div class="input-field col s6">
              <input name="admin_mobile" id="admin_mobile" type="text" class="validate" value="<?php echo $login_session9; ?>" required>
            </div>
        </div>

        <div class="row">
          <div class="col s2 offset-m1">
              <h6 style="padding-top: 20px">Gender</h6>
          </div>
          <div class="input-field col s6">
                <input class="with-gap" name="admin_sex" value="male" type="radio" id="Male" <?php if (strtolower($login_session8)=='male') {echo 'checked';
                }?> />
                <label for="Male">Male</label>
                <input class="with-gap" name="admin_sex" value="female" type="radio" id="Female" <?php if (strtolower($login_session8)=='female') {echo 'checked';
                }?> />
                <label for="Female">Female</label>
                <input class="with-gap" name="admin_sex" value="other" type="radio" id="Other" <?php if (strtolower($login_session8)=='other') {echo 'checked';
                }?> />
                <label for="Other">Other</label>
          </div>
        </div>
        <input type="hidden" name="update_admin_info">
    <div class="modal-footer">
      <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit" >Update<i class="material-icons right">send</i></button>
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

$("#delete_admin_profile").on('submit',(function(e) 
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
            if (data.trim() !== 'Profile picture deleted'.trim()) { 
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
              if (data.trim() === 'Profile picture deleted'.trim()) {
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#update_admin_info").on('submit',(function(e) 
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
            if (data.trim() !== 'Information updated Successfully'.trim()) { 
              Materialize.toast(data, 4000, 'red rounded'); 
              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else 
              if (data.trim() === 'Information updated Successfully'.trim()) {
                $('#modaleditadmin').modal('close');
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
