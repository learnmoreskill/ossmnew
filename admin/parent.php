<?php
include('session.php');


if (isset($_GET["token"])){
            $longid1 = ($_GET["token"]);

            if ($longid1=="2ec9ys77bi89s9") {
              if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);

            $sqlEdit = $db->query("SELECT * FROM `parents` WHERE `parent_id`='$shortid' ");
            if($sqlEdit->num_rows)
            {
            $rowsEdit = $sqlEdit->fetch_assoc();
            extract($rowsEdit);

            $studentlist = $db->query("SELECT `studentinfo`.* , `class`.`class_name`, `section`.`section_name` 
              FROM `studentinfo`
              LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
              LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id`
              WHERE `sparent_id`='$parent_id' ");
}else
{
$_GET['token']="";
}
}}}else{

/*set active navbar session*/
$_SESSION['navactive'] = 'parent';

}


?>

<!-- add adminheade.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

    <style type="text/css">
            #info_table select{
                display: inherit;
            }
            #info_table label{
                width: 100%;
                font-size: 20px;
                color:#000;
            }
            #examtypeTable_filter{
                width: 50%;
            }

            #examtypeTable_wrapper
            {
                margin-top: 20px;
            }

            .dataTables_length{
                width: 50%!important;
            }
            .dataTables_filter{
                width: 50%!important;
                text-align: left;
            }
            .dataTables_filter>label>input{
                min-width: 100px;
                max-width: 300px;
                padding: 0!important;

            }
            @media screen and (max-width: 720px) {
                .dataTables_length{
                    width: 100%!important;
                    text-align: left!important;


                }
                .dataTables_filter{
                    width: 100%!important;
                    text-align: left!important;


                }
            }
    </style>


  <main>
    <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>

    <div class="section no-pad-bot" id="index-banner">
      <?php include_once("../config/schoolname.php");?>
      <div class="row">
        <div class="col s12">
          <ul class="tabs github-commit"><?php
            if( (isset($_GET['token']) && @$_GET['token']=="2ec9ys77bi89s9") ){ ?>
            <div class="row center"><a class="white-text text-lighten-4" href="#">Parent Details</a></div>
            <?php }else{?>
            <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#active_parent_div">Active Parents</a></li>
            <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#inactive_parent_div">Inactive Parents</a></li>
            <li class="tab col s3"><a class="white-text text-lighten-4" href="#add_parent_div">Add Parent</a></li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
<!-- ========================== parent details div ==================================== -->
    <?php  if(isset($_GET['token']) && @$_GET['token']=="2ec9ys77bi89s9") { ?> 
            <div class="row">
              <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-panel purple darken-3">
                            <div class="row">
                                    <div class="col s12 m12">
                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Parent Info</span> 

                            <?php if ($login_cat == 1 || $pac['edit_student']) { ?>

                              &nbsp&nbsp <a  href="admitstudent.php?token=2ecpoij7bi8939&key=<?php echo "ae25nj53sfr596dg@".$parent_id; ?>"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>
                                
                                &nbsp&nbsp&nbsp&nbsp <a href="#modal_set_parent_password" class="modal-trigger"><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Update or Set login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons blue-text text-lighten-1">vpn_key</i></div></a>
                                
                                <form style="display: inline;"  id="disable_parent_login_form" action="updatescript.php" method="post" >
                                    <input type="hidden" name="disable_parent_login" value="<?php echo $parent_id;?>">
                                    <button class="disable_login_button" type="submit" onclick="return confirm('Do you really want to disable login?');" onclick="return confirm('Do you really want to disable login?');" ><div class="tooltipped" data-position="left" data-delay="50" data-tooltip="Disable login" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons red-text text-lighten-1"><?php echo ((empty($spphone))? 'no_encryption' : 'https'); ?></i></div></button>
                                </form>

                            <?php } ?>



                                <div class="card-content white-text flow-text">
                                <?php if(!empty($spname)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Father Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $spname; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($smname)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Mother Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">person</i>&nbsp;<?php echo $smname; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($spnumber)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Phone Number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">phone</i>&nbsp;<?php echo $spnumber; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($spnumber2)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Mobile Name" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">phone</i>&nbsp;<?php echo $spnumber2; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($spprofession)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Profession" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">work</i>&nbsp;<?php echo $spprofession; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($spemail)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email ID" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $spemail; ?>
                                </div>
                                <br><?php } ?>

                                <?php if(!empty($sp_address)){ ?>
                                <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Address" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">home</i>&nbsp;<?php echo $sp_address; ?>
                                </div>
                                <br><?php } ?>

                                <?php if ($row["spstatus"]==0) { ?>
                                    <div class="tooltipped green-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Active</div><br>
                                <?php }else if ($row["spstatus"]!=0) { ?>
                                    <div class="tooltipped red-text" data-position="right" data-delay="50" data-tooltip="Status" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 8px;"><i class="material-icons">adjust</i>&nbsp; Inactive</div><br>
                                <?php } ?>


                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
            </div>
            <div class="row">
              <div class="col s12 m12">

                <?php
                 $j=$studentlist->num_rows;
                 if($j > 0){  $i = 0;
                while($row1 = $studentlist->fetch_assoc()) { ?>


                  
                  <div class="col s12 <?php if (($j & 1) && ($i == $j - 1)){ echo "m12"; }else{ echo "m6"; } ?>">
                    <div class="card blue-grey" style="height: 240px">
                      <div class="card-content white-text">
                        <span class="card-title center">Child : <?php echo $row1["sname"]; ?></span>
                        <span class="white-text">Admission No : <?php echo $row1["sadmsnno"];
                         echo "<br/> Class : ".$row1["class_name"]." : ".$row1["section_name"];
                         echo "<br/> Roll Number : ".($row1["sroll"] ? $row1["sroll"] : 'Not set');
                         echo "<br/> Status : ".(($row1["status"] == 0) ? '<span class = "green-text">Active</span>' : (($row1["status"] != 0) ? '<span class = "red-text">Inactive</span>' : '' ) ); ?>
                           
                         </span><br>
                      </div>
                      <div class="card-action">
                        <a href="studentdetailsdescription.php?token=2ec9ys77bi89s9&key=ae25nj5s3fr596dg@<?php echo $row1["sid"]; ?>" class="tooltipped" data-position="top" data-tooltip="Student details">
                          <i class="small material-icons">info</i>
                        </a>
                      </div>
                      
                    </div>
                  </div>

                <?php $i++; } }else{ ?>
                  <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">No child added</span></span>
                            </div>
                        </div>
                    </div>
                  </div>
                  <?php } ?>

            </div>
          </div>
      </div>



  <!-- Modal Structure -->
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
              <input name="parent_email" id="parent_email" type="email" value="<?php echo $spemail; ?>" required >
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
        <input type="hidden" name="set_parent_login_id" value="<?php echo $parent_id; ?>">
    <div class="modal-footer">
      <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit" name="update_parent_login">Update<i class="material-icons right">send</i></button>
    </div>

    </form>
    </div>
  </div>

          <?php }else{ ?>
<!-- ========================== Active Parents div ==================================== -->
        <div id="active_parent_div">
              <div class="row scrollable pl-2 pr-2" id='info_table'>

                  <table id="active_parent_grid" class="display" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <th>Father name</th>
                            <th>Mother name</th>
                            <th>Mobile</th>
                            <th>Profession</th>
                            <th>Address</th>
                            <th style="width: 110px;">Action</th>
                          </tr>
                      </thead>
                  </table>

              </div>



            
        </div>
<!-- ========================== Inactive Parents div ==================================== -->
        <div id="inactive_parent_div">
              <div class="row scrollable pl-2 pr-2" id='info_table'>

                  <table id="inactive_parent_grid" class="display" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <th>Father name</th>
                            <th>Mother name</th>
                            <th>Mobile</th>
                            <th>Profession</th>
                            <th>Address</th>
                            <th style="width: 110px;">Action</th>
                          </tr>
                      </thead>
                  </table>

              </div>



            
        </div>
<!-- ================================= Add Parent div ========================================== -->
            <div id="add_parent_div" class="row" style="display: none;" >
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
                             <button class="btn waves-effect waves-light" type="submit" name="parent_form" >Submit<i class="material-icons right">send</i>
                              </button>
                        </div>
                    </div>

                </form>
            </div>
          <?php } ?>
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
                  $("#err").fadeOut();
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
                  //alert(data);
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
                  //alert(data);
                }
              }); 
            } 
            else 
              if (data.trim() === 'Parent Login Disabled'.trim()) { 
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


<script type="text/javascript">
$(document).ready(function() {
  $("ul.tabs > li > a").click(function (e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;});
    var hash = window.location.hash;
    $('ul.tabs').tabs('select_tab', hash);
});
function changeTab(id){
      $('ul.tabs').tabs('select_tab', id);  
}
</script>


<script type="text/javascript">
$( document ).ready(function() {
    $('#active_parent_grid').DataTable({
                 "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"getContentAdmin.php?parent", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
              $("#active_parent_grid_processing").css("display","none");
            }
          }
    }); 

    $('#inactive_parent_grid').DataTable({
                 "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"getContentAdmin.php?inactive_parent", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
              $("#inactive_parent_grid_processing").css("display","none");
            }
          }
    });   
});
</script>


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css"/>
     
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>