<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'academicsetting';

$query = $db->query("SELECT * FROM `slider`");

?>

<!-- add adminheade.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

  <main>
    <div class="section no-pad-bot" id="index-banner">
      <?php include_once("../config/schoolname.php");?>
      <div class="row">
        <div class="col s12">
          <ul class="tabs github-commit "> 
            <li class="tab col s3"><a class="active white-text text-lighten-4" href="#update_academic_basic">Academic</a></li>
            <li class="tab col s3"><a class="white-text text-lighten-4" href="#update_slides">Slides</a></li>
          </ul>
        </div>
      </div>
    </div>
<!-- ================================= Academic update div ========================================== -->
            <div id="update_academic_basic" class="row">

                <div class="row col s12">
                  <div class="card col s6 m3" style="float: none; margin: auto;">
                          <div class="card-image">
                            <img src="<?php if(!empty($LOGIN_SCHOOL_LOGO)){ echo "../uploads/".$fianlsubdomain."/logo/".$LOGIN_SCHOOL_LOGO; }?>" alt="logo not avilable">

                            <form  id="delete_school_logo" action="updatescript.php" method="post" >
                                <input type="hidden" name="delete_school_logo" >
                                <input type="hidden" name="schoolid" value="<?php echo $LOGIN_SCHOOL_ID;?>">
                            <button class="btn-floating halfway-fab waves-effect waves-light grey lighten-4" type="submit"><i class="material-icons red-text text-darken-4">delete</i></button>
                            </form>
                          </div>

                          <div class="card-action">
                            <form  id="academic_form_logo" action="updatescript.php" method="post" >
                                <input id="ac_logo" type="file" name="ac_logo">
                                <input type="hidden" name="update_school_logo" >
                                <input type="hidden" name="schoolid" value="<?php echo $LOGIN_SCHOOL_ID;?>">
                            </form>                            
                          </div>
                  </div>
                </div>

                <form class="col s12" id="academic_form" action="updatescript.php" method="post"  >
                      <div class="row">
                        <div class="input-field col s12 m12">
                          <input name="schoolname" id="schoolname" type="text" value="<?php echo $LOGIN_SCHOOL_NAME;?>" required="" aria-required="true">
                          <label for="schoolname">School Name</label>
                        </div>                   
                        <div class="input-field col s12 m12">
                          <input name="schooladdress" id="schooladdress" type="text" value="<?php echo $LOGIN_SCHOOL_ADDRESS;?>" required="" aria-required="true">
                          <label for="schooladdress">School Address</label>
                        </div>
                        <div class="input-field col s12 m12">
                          <input name="slogan" id="slogan" type="text" value="<?php echo $LOGIN_SCHOOL_SLOGAN; ?>" >
                          <label for="slogan">School Slogan</label>
                        </div>
                      </div>
                      <div class="row">
                          <div class="input-field col s12 m6">
                            <input name="phone_no1" id="phone_no1" type="text" value="<?php echo $LOGIN_SCHOOL_PHONE_NO;?>" required="" aria-required="true">
                            <label for="phone_no1">Phone No.</label>
                          </div>
                          <div class="input-field col s12 m6">
                            <input name="phone_no2" id="phone_no2" type="text" value="<?php echo $LOGIN_SCHOOL_PHONE_2;?>" >
                            <label for="phone_no2">Phone No2.</label>
                          </div>
                      </div>
                      <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="email" id="email" type="text" value="<?php echo $LOGIN_SCHOOL_EMAIL;?>" >
                          <label for="email">Email id</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="estd" id="estd" type="text" value="<?php echo $LOGIN_SCHOOL_ESTD;?>" required="" aria-required="true">
                          <label for="estd">Estd</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="pan" id="pan" type="text" value="<?php echo $LOGIN_SCHOOL_PAN_NO;?>" required="" aria-required="true">
                          <label for="pan">Pan no</label>
                        </div>
                      </div>

                    <div class="row">
                        <div class="input-field col s6 m6">
                          <input name="facebook" id="facebook" type="text" value="<?php echo $LOGIN_SCHOOL_FACEBOOK;?>">
                          <label for="estd">Facebook</label>
                        </div>
                        <div class="input-field col s6 m6">
                          <input name="twitter" id="twitter" type="text" value="<?php echo $LOGIN_SCHOOL_TWITTER;?>" >
                          <label for="twitter">Twitter</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m6">
                          <input name="instagram" id="instagram" type="text" value="<?php echo $LOGIN_SCHOOL_INSTAGRAM;?>" >
                          <label for="instagram">Instagram</label>
                        </div>
                        <div class="input-field col s6 m6">
                          <input name="youtube" id="youtube" type="text" value="<?php echo $LOGIN_SCHOOL_YOUTUBE;?>" >
                          <label for="youtube">Youtube</label>
                        </div>
                    </div>

                    <div class="row">
                      <div class="col s8 m4">
                        <h6>Google Recaptcha on login:</h6>
                      </div>
                      <div class="switch col s4 m2">
                        <label>
                          Off
                          <input type="checkbox" id="recaptcha" name="recaptcha" <?php if($LOGIN_SCHOOL_RECAPTCHA==1){}elseif ($LOGIN_SCHOOL_RECAPTCHA==0){echo "checked='checked'"; }  ?> >
                          <span class="lever"></span>
                          On
                        </label>
                      </div>


                      <div class="col s12 m6">
                          <div class="input-field">
                              <select name="lang" id="lang" required>
                                  <option value="" disabled>Select language</option>  
                                  <option value="english" <?php echo (($LOGIN_SCHOOL_LANG == 'english')? 'selected' : '' ); ?> >English</option>
                                  <option value="nepali" <?php echo (($LOGIN_SCHOOL_LANG == 'nepali')? 'selected' : '' ); ?> >नेपाली</option>
                              </select>
                              <label>Language :</label>
                          </div>
                      </div>            
                    </div>

                    <div class="row">
                        <div class="input-field col offset-m5">
                          <input type="hidden" id="schoolid" name="schoolid" value="<?php echo $LOGIN_SCHOOL_ID;?>">
                            <button class="btn waves-effect waves-light" type="submit" >Submit<i class="material-icons right">send</i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>
<!-- ================================= Update slides div ========================================== -->
            <div id="update_slides" class="row">
                  <div class="col s12 m4 card">
                          <form id="upload_slider_form" action="addscript.php" method="post" enctype="multipart/form-data" >
                            <h4 class="center">Add Slide</h4>

                              <div class="row">
                                  <div class="input-field col s12">
                                    <input name="slider_name" id="slider_name" type="text" class="validate" placeholder="Write caption" autofocus required>
                                    <label for="slider_name">Caption</label>
                                  </div>
                              </div>
                              <div class="row">
                                <div class="input-field col s12">
                                  <textarea id="slider_desc" name="slider_desc" class="materialize-textarea" placeholder="write slogan" required></textarea>
                                  <label for="slider_desc">Slogan</label>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="file-field input-field col s12">
                                    <div class="btn">
                                      <span>Select Image</span>
                                      <input type="file" name="slider">
                                    </div> 
                                    <div class="file-path-wrapper">
                                      <input class="file-path validate" placeholder="File types:JPG, JPEG, PNG" type="text">
                                    </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="input-field col offset-m7">
                                      <input type="hidden" name="add_slider_image" value="upload">
                                       <button class="btn waves-effect waves-light" type="submit" name="upload_file">Upload
                                          <i class="material-icons right">send</i>
                                        </button>
                                  </div>

                              </div>

                          </form>
                  </div>
                  <!-- slide show in right side -->
                  <div class="col s12 m8 card">
                    <style type="text/css">
                      .card img { 
                          max-height: 400px;
                          object-fit: cover;
                      }
                      .card img.materialized.active {
                          max-height: none;
                          object-fit: none;
                      }
                    </style>
                      <div class="col s12">   
                        <?php  
                        while($row = $query->fetch_assoc()) { ?> 

                          <div class="col s6">
                              <div class="material-placeholder">
                                  <div class="card">
                                      <div class="card-image">

                                        <img class="materialboxed responsive-img intialized" src="<?php echo "../uploads/".$fianlsubdomain."/slides/".$row['slider_image'] ?>">

                                        <span class="card-title galleryfontsize"><?php echo $row['title']; ?></span>
                                        <a href="deleteuserscript.php?token=4ro908tyg85hyw&key=<?php echo "ae25nJ5s3fr596dg@".$row["slider_id"]; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }" class="btn-floating halfway-fab waves-effect waves-light grey lighten-4"><i class="material-icons red-text text-darken-4">delete</i></a>
                                      </div> 
                                  </div>
                              </div>
                          </div>
                          <?php 
                        }  ?>
                      </div>
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

<script>
$(document).ready(function (e) 
{
  $("#academic_form").on('submit',(function(e) 
  {
    e.preventDefault();
    var schoolname_a=document.getElementById( "schoolname" ).value;
    var schooladdress_a=document.getElementById( "schooladdress" ).value;
    var slogan_a=document.getElementById( "slogan" ).value;
    var phone_no1_a=document.getElementById( "phone_no1" ).value;
    var phone_no2_a=document.getElementById( "phone_no2" ).value;
    var email_a=document.getElementById( "email" ).value;
    var estd_a=document.getElementById( "estd" ).value;
    var panno_a=document.getElementById( "pan" ).value;
    var facebook_a=document.getElementById( "facebook" ).value;
    var twitter_a=document.getElementById( "twitter" ).value;
    var instagram_a=document.getElementById( "instagram" ).value;
    var youtube_a=document.getElementById( "youtube" ).value;
    var recaptcha_a=document.getElementById( "recaptcha" ).checked;
    var lang_a=document.getElementById( "lang" ).value;

    var schoolid_a=document.getElementById( "schoolid" ).value;

    if(!schoolname_a){  Materialize.toast('Please type school name', 4000, 'rounded'); }
    else if(!schooladdress_a){  Materialize.toast('Please type school address', 4000, 'rounded'); }
    else if(!phone_no1_a){  Materialize.toast('Please add school phone number', 4000, 'rounded'); }
    else if(!estd_a){  Materialize.toast('ESTD can not be empty', 4000, 'rounded'); }
    else if(!panno_a){  Materialize.toast('PAN nunmber can not be empty', 4000, 'rounded'); }
    else if(schoolname_a && schooladdress_a && phone_no1_a && estd_a && panno_a){ 

      $.ajax({
  type: 'post',
  url: 'updatescript.php',
  data: {
   schoolname:schoolname_a,
   schooladdress:schooladdress_a,
   slogan:slogan_a,
   phone_no1:phone_no1_a,
   phone_no2:phone_no2_a,
   email:email_a,
   estd:estd_a,
   panno:panno_a,
   facebook:facebook_a,
   twitter:twitter_a,
   instagram:instagram_a,
   youtube:youtube_a,
   recaptcha:recaptcha_a,
   lang:lang_a,
   school_id:schoolid_a,

  },
  success: function (response) {
   //alert(data);
            if (response.trim() !== 'Academic information succesfully updated'.trim()) { 
              Materialize.toast(response, 4000, 'rounded'); 

              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else if (response.trim() === 'Academic information succesfully updated'.trim()) {
                window.location.href = window.location.href; 
            }
  },
  error: function(e) 
          {
            alert('Sorry Try Again !!');
          }   
  });
 }
  
 else
 {
  alert('Error occured');
 }

  }));


  $("#exam_form").on('submit',(function(e) 
  {
    e.preventDefault();

    var examid=[];
    var percentage=[];

    var count=document.getElementById("count").value;

    for(var i=0; i<count; i++){
      examid.push(document.getElementById("examid"+i).value);
      percentage.push(document.getElementById("percentage"+i).value);
    }

    if(!percentage){  Materialize.toast('Please type percentage', 4000, 'rounded'); }
    else if(!examid){  Materialize.toast('Examtype is not selected', 4000, 'rounded'); }
    else if(examid && percentage){ 

  $.ajax({
  type: 'post',
  url: 'updatescript.php',
  data: {
   examid:examid,
   percentage:percentage,
   count:count,

  },
  success: function (response) {
   //alert(data);
            if (response.trim() !== 'Exam succesfully updated'.trim()) { 
              Materialize.toast(response, 4000, 'red rounded'); 

              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            } 
            else  if (response.trim() === 'Exam succesfully updated'.trim()) { 

                Materialize.toast(response, 4000, 'rounded'); 

                $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
              }
  },
  error: function(e) 
          {
            alert('Sorry Try Again !!');
          }   
  });
 }
  
 else
 {
  alert('Error occured');
 }

  }));
});

</script>
<script type="text/javascript">

  $(document).ready(function (e) 
{
  $("#academic_form_logo").on('change',(function(e) 
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
            if (data.trim()!=='School logo updated'.trim()) { 
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
              if (data.trim() === 'School logo updated'.trim()) {
             window.location.href = 'academicsetting.php';
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#delete_school_logo").on('submit',(function(e) 
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
            if (data.trim() !== 'School logo deleted'.trim()) {
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
              if (data.trim() === 'School logo deleted'.trim()) {
             window.location.href = 'academicsetting.php';
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
$("#upload_slider_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Slider uploaded succesfully'.trim()) { 
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
              if (data.trim() === 'Slider uploaded succesfully'.trim()) {
             window.location.href = 'academicsetting.php';

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


