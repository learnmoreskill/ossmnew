<?php
include('session.php');


$msg="";
    $sqlclass = "select * from class";
    $resultclass = $db->query($sqlclass);

        if (isset($_GET["token"])){
            $longid1 = ($_GET["token"]);

            if ($longid1=="2ec9yS77bte9s9") {
              if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);

            $sqlEdit = $db->query("SELECT * FROM `teachers` where `tid`='$shortid' ");
            if($sqlEdit->num_rows)
            {
            $rowsEdit = $sqlEdit->fetch_assoc();
            extract($rowsEdit);
            $action = "update";
}else
{
$_GET['token']="";
}
}}}

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <script type="text/javascript">
        function validate(form) {
          var e = form.elements, m = '';
          var pass=e['password1'].value;
          var passlength=pass.length;

              if(!e['name'].value) {m += '- Full name is required.\n';}
              if(!e['address'].value) {m += '- Address is required.\n';}
              if(!e['mobile'].value) {m += '- Mobile number is required.\n';}
              if(!e['sex'].value) {m += '- Gender is required.\n';}
              if(!/.+@[^.]+(\.[^.]+)+/.test(e['email'].value)) {
                m += '- E-mail requires a valid e-mail address.\n';
              }
              
              if(!e['password1'].value) {m += '- Password is required.\n';}else if(passlength<6) {m += '- password length shoud be minimum 6 character.\n';}
              if(e['password1'].value != e['password2'].value) {
                m += '- Your password and confirmation password do not match.\n';
              }
              if(m) {
                alert('The following error(s) occurred:\n\n' + m);
                return false;
              }else{
                return true;
              }
            }
    </script>

    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#"><?php
            echo (isset($_GET['token']) && @$_GET['token']=="2ec9yS77bte9s9")?
            'Edit Teacher Info':'Add Teacher';
            ?></a></div>
                    </div>
                </div>
            </div>

             <?php
           if(isset($_GET['token']) && @$_GET['token']=="2ec9yS77bte9s9")
           {
          ?>
          <!-- ======================== Edit Teacher div ========================================== -->
              <div class="row">
                <form class="col s12" id="update_teacher_form" action="updatescript.php" method="post" >

                    <div class="row">
                        <div class="input-field col s12">
                          <input name="name" id="name" type="text" class="validate" value="<?php echo $tname;?>" autofocus>
                          <label for="name">Full Name*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                          <input name="address" id="address" type="text" class="validate" value="<?php echo $taddress;?>">
                          <label for="address">Address*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                          <input name="mobile" id="mobile" type="tel" class="validate" required="" aria-required="true" value="<?php echo $tmobile;?>">
                          <label for="mobile">Mobile number*</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="phone" id="phone" type="tel" class="validate" value="<?php echo $t_phone;?>">
                          <label for="phone" data-error="wrong" data-success="right" >Phone(optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="email" id="email" type="email" class="validate" value="<?php echo $temail;?>">
                          <label for="email" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="tcountry" id="tcountry" type="text" required="" aria-required="true" value="<?php echo $t_country;?>">
                          <label for="tcountry" >Nationality*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="tfather" id="tfather" type="text" value="<?php echo $t_father;?>">
                          <label for="tfather" >Father Name</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="tmother" id="tmother" type="text" value="<?php echo $t_mother;?>" >
                          <label for="tmother" >Mother Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="designation" id="designation" type="text" maxlength="80" value="<?php echo $designation;?>" >
                          <label for="designation">Designation</label>
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
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="sex" value="male" type="radio" <?php echo (('male'==strtolower($sex))?'checked="checked"':''); ?> id="Male" />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="sex" value="female" type="radio" <?php echo (('female'==strtolower($sex))?'checked="checked"':''); ?> id="Female" />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="sex" value="other" type="radio" <?php echo (('other'==strtolower($sex))?'checked="checked"':''); ?> id="Other" />
                          <label for="Other">Other</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <h6>Marital status*</h6>
                          <input class="with-gap" name="m_status" value="single" type="radio" <?php echo (('single'==strtolower($t_marital))?'checked="checked"':''); ?> id="Single" />
                          <label for="Single">Single</label>
                          <input class="with-gap" name="m_status" value="married" type="radio" <?php echo (('married'==strtolower($t_marital))?'checked="checked"':''); ?> id="Married" />
                          <label for="Married">Married</label>
                          <input class="with-gap" name="m_status" value="other" type="radio" <?php echo (('other'==strtolower($t_marital))?'checked="checked"':''); ?> id="Otherm" />
                          <label for="Otherm">Other</label>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input name="doj" id="dojedit" type="text" required placeholder="select date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                           >
                          <label for="doj">Date Of Join(B.S.)</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="dob" id="dobedit" type="text" required placeholder="select date"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)" 
                            >
                          <label for="dob">Birth date(B.S.)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <select name="tjobtype">
                              <option value="Full Time" <?php echo (('Full Time'==$t_jobtype)?'selected="selected"':''); ?>>Full Time</option>
                              <option value="Half Time" <?php echo (('Half Time'==$t_jobtype)?'selected="selected"':''); ?>>Part Time</option>
                              <option value="Contract Basis" <?php echo (('Contract Basis'==$t_jobtype)?'selected="selected"':''); ?> >Contract Basis</option>
                              </select>
                            <label>Job type:</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="tsalary" id="tsalary" type="text" class="validate" value="<?php echo $tsalary;?>">
                          <label for="tsalary">Teacher salary</label>
                        </div>
                    </div>
                    <div class="row">
                      <input type="hidden" name="update_teacher">
                      <input type="hidden" name="teacher_id" value="<?php echo $tid;?>">
                        <div class="input-field col offset-m10">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>

                </form>
            </div>

          <?php
      }
      else
      {
        /*set active navbar session*/
        $_SESSION['navactive'] = 'addteacher';
      ?>
<!-- ================================= Add Teacher div ========================================== -->
            <div class="row">
                <form class="col s12" id="add_teacher_form" action="addscript.php" method="post" enctype="multipart/form-data" >

                    <div class="row">
                        <div class="input-field col s12">
                          <input name="name" id="name" type="text" class="validate" autofocus required="" aria-required="true">
                          <label for="name">Full Name*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                          <input name="address" id="address" type="text" class="validate" required="" aria-required="true">
                          <label for="address">Address*</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6">
                          <input name="mobile" id="mobile" type="tel" class="validate" required="" aria-required="true">
                          <label for="mobile">Mobile number*</label>
                        </div>
                        <div class="input-field col s6">
                          <input name="phone" id="phone" type="tel" class="validate">
                          <label for="phone" data-error="wrong" data-success="right" >Phone(optional)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="email" id="email" type="email" class="validate">
                          <label for="email" data-error="wrong" data-success="right" >Email id</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="tcountry" id="tcountry" type="text" required="" aria-required="true">
                          <label for="tcountry" >Nationality</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="tfather" id="tfather" type="text">
                          <label for="tfather" >Father Name</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="tmother" id="tmother" type="text" >
                          <label for="tmother" >Mother Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <input name="designation" id="designation" type="text" maxlength="80" >
                          <label for="designation">Designation</label>
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
                        <div class="input-field col s12 m6">
                            <h6>Gender*</h6>
                          <input class="with-gap" name="sex" value="male" type="radio" checked="checked" id="Male" />
                          <label for="Male">Male</label>
                          <input class="with-gap" name="sex" value="female" type="radio" id="Female" />
                          <label for="Female">Female</label>
                          <input class="with-gap" name="sex" value="other" type="radio" id="Other" />
                          <label for="Other">Other</label>
                        </div>

                        <div class="input-field col s12 m6">
                            <h6>Marital status*</h6>
                          <input class="with-gap" name="m_status" value="single" type="radio" checked="checked" id="Single" />
                          <label for="Single">Single</label>
                          <input class="with-gap" name="m_status" value="married" type="radio" id="Married" />
                          <label for="Married">Married</label>
                          <input class="with-gap" name="m_status" value="other" type="radio" id="Otherm" />
                          <label for="Otherm">Other</label>
                        </div>
                        
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input name="doj" id="doj" type="text" 
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)" placeholder="Select date" >
                          <label for="doj">Date Of Join</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <input name="dob" id="dob" type="text"
                            class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)" placeholder="Select date" >
                          <label for="dob">Birth date</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                          <div class="file-field input-field">
                            <div class="btn">
                              <span>Teacher Picture</span>
                              <input type="file" name="tpic">
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
                              <input type="file" name="tdoc1">
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
                              <span>Teacher CV</span>
                              <input type="file" name="tdoc2">
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
                              <input type="file" name="tdoc3">
                            </div>
                            <div class="file-path-wrapper">
                              <input class="file-path validate" placeholder="file type JPG,JPEG,PNG,PDF,TXT,DOC,DOCX files are allowed." type="text">
                            </div>
                          </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="input-field col s12 m6">

                              <input name="password1" id="password1" type="password" >
                              <label for="password1" >Password</label>

                              <input name="password2" placeholder="confirm password" id="password2" type="password">
                          
                        </div>
                        <div class="input-field col s12 m6">
                            <select name="tjobtype">
                              <option value="Full Time">Full Time</option>
                              <option value="Half Time">Part Time</option>
                              <option value="Half Time">Contract Basis</option>
                              </select>
                            <label>Job type:</label>
                        </div>
                        <div class="input-field col s12 m6">
                          <input name="tsalary" id="tsalary" type="text" class="validate">
                          <label for="tsalary">Teacher salary</label>
                        </div>
                    </div>
                    <div class="row">
                      <input type="hidden" name="add_teacher_request" value="add_teacher_request">
                        <div class="input-field col offset-m10">
                             <button class="btn waves-effect waves-light" type="submit">Submit
                                <i class="material-icons right">send</i>
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

<script>
$(document).ready(function (e) 
{
  $("#add_teacher_form").on('submit',(function(e) 
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
            if (data.trim() !== 'Teacher succesfully added'.trim()) { 
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
              if (data.trim() === 'Teacher succesfully added'.trim()) {

              window.location.href = 'addteacher.php?resp=success';
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  $("#update_teacher_form").on('submit',(function(e) 
  {
      e.preventDefault();

      var k = e.currentTarget.elements, m = '';

      if(!k['name'].value) {m += '- Full name is required.\n';}
      if(!k['address'].value) {m += '- Address is required.\n';}
      if(!k['mobile'].value) {m += '- Mobile number is required.\n';}
      if(!k['sex'].value) {m += '- Gender is required.\n';}
      
      if(k['email'].value){ //if not empty validate

        if(!/.+@[^.]+(\.[^.]+)+/.test(k['email'].value)) {
          m += '- E-mail requires a valid e-mail address.\n';
        }

      }
      
      
      if(m) {
        alert('The following error(s) occurred:\n\n' + m);
        return false;
      }else{
    
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
            
            /*if (data!='Teacher succesfully updated') { Materialize.toast(data, 4000, 'rounded'); } 
            else 
              if (data=='Teacher succesfully updated') {

              window.location.href = 'allteacher.php?resp=success';
            }*/
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
        });
      }
  }));    
});

</script>
<script type="text/javascript">
        
  var dojedit = "<?php echo (($login_date_type==2)? eToN($t_join_date) : $t_join_date);?>"
  document.getElementById("dojedit").value = dojedit;

  var dobedit = "<?php echo (($login_date_type==2)? eToN($dob) : $dob);?>"
  document.getElementById("dobedit").value = dobedit;
</script>