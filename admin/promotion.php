<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

$_SESSION['navactive'] = 'promotion';



$year_id = $current_year_session_id;


$oldClassList= json_decode($backstage->get_class_list_by_year_id(6));
$newClassList= json_decode($backstage->get_class_list_by_year_id(7));

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <script type="text/javascript">
        function showOldSection(str) {

            document.getElementById("old_student_div").innerHTML = "";

          if (str == "") {
              document.getElementById("old_section_id").innerHTML = "";
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
                      var selectDropdown =    $("#old_section_id");
                      document.getElementById("old_section_id").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp.open("GET","../important/getListById.php?classforsection="+str,true);
              xmlhttp.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });
          }
        }
        function showNewSection(str) {

            document.getElementById("new_student_div").innerHTML = "";

          if (str == "") {
              document.getElementById("new_section_id").innerHTML = "";
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
                      var selectDropdown =    $("#new_section_id");
                      document.getElementById("new_section_id").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp.open("GET","../important/getListById.php?classforsection="+str,true);
              xmlhttp.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });
          }
        }
        function showOldStudent(section_id) {
            year_id = document.getElementById("old_batch_id").value;

          if (section_id == "") {
              document.getElementById("old_student_div").innerHTML = "";
              return;
          } else { 

            $('#old_student_div').load("../important/getContent.php?oldStudentPromotion="+year_id+"&section_id="+section_id);

          }
        }
        function showNewStudent(section_id) {
            year_id = document.getElementById("new_batch_id").value;

          if (section_id == "") {
              document.getElementById("new_student_div").innerHTML = "";
              return;
          } else { 

            $('#new_student_div').load("../important/getContent.php?newStudentPromotion="+year_id+"&section_id="+section_id);

          }
        }
        function changePromotionType(str) {

            var x = document.getElementById("newPromotionDetailDiv");
            //var y = document.getElementsByClassName("theoryDiv");

            if (str == 'upgrade') {

              x.style.display = 'block';

            }else if(str == 'passout'){
              
              x.style.display = 'none';
            }
        }
    </script>    
        <main>
            <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Student Promotion</a></div>
                    </div>
                </div>
            </div><br>

            <div class="row">            
                <form class="col s12" id="promote_student_form" action="" method="post" >
                    <input type="hidden" name="request_for_student_promotion" value="request_for_student_promotion">
                    <div class="row">

                        <!-- Old Batch  -->
                        <div class="col s6">
                            <div class="input-field">
                                <select name="old_batch_id" id="old_batch_id">
                                   
                                        <option value="6" selected>2075</option>
                                    
                                </select>
                                <label>Select Old Batch</label>
                            </div>


                            <div class="input-field">
                                <select name="old_class_id" id="old_class_id" onchange="showOldSection(this.value)">

                                    <option value="" >Select old class</option>

                                    <?php 
                                    foreach ($oldClassList as $clist) {
                                        echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                    } ?>

                                </select>
                                <label>Select Old Class:</label>
                            </div>
                            <div class="input-field">
                                <select name="old_section_id" onchange="showOldStudent(this.value)" id="old_section_id">
                                    <option value="" >Select class first</option>
                                </select>
                                <label>Section:</label>
                            </div>

                        </div>


                        <!-- New Batch  -->
                        <div class="col s6">
                            <div class="row center">
                                <input class="with-gap" name="promotion_type" value="upgrade" type="radio" id="upgrade"  
                                checked onchange="changePromotionType(this.value)" />
                                <label for="upgrade">Upgrade</label>

                                <input class="with-gap" name="promotion_type" value="passout" type="radio" id="passout" 
                                onchange="changePromotionType(this.value)" />
                                <label for="passout">Paas out(leave)</label>
                            </div>

                            <div id="newPromotionDetailDiv">

                                <div class="input-field">
                                    <select name="new_batch_id" id="new_batch_id">

                                            <option value="7" selected>2076</option>
                                        
                                    </select>
                                    <label>Select New Batch</label>
                                </div>


                                <div class="input-field">
                                    <select name="new_class_id" onchange="showNewSection(this.value)">

                                        <option value="" >Select new class</option>

                                        <?php 
                                        foreach ($newClassList as $clist) {
                                            echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                        } ?>

                                    </select>
                                    <label>Select New Class:</label>
                                </div>

                                <div class="input-field">
                                    <select name="new_section_id" onchange="showNewStudent(this.value)" id="new_section_id">
                                        <option value="" >Select class first</option>
                                    </select>
                                    <label>Section:</label>
                                </div>
                                    
                            </div>
                            

                            

                        </div>
                        
                    </div>
                    <div class="row">
                        
                        <div class="input-field right">
                             <button class="btn waves-effect waves-light" id="submitBtn" type="submit" name="promote_class">Promote
                                <i class="material-icons right">send</i>
                              </button>
                        </div>  
                    </div>
                    <div >
                        <p class="red-text ">NOTE:<br>
                            >> Please cross check all students and their marks for eligibility to promote them.<br>
                            >> Confirm first selected old / new class and section before click to proceed ahead.<br>
                            >> Student Tution fee, Hostel fee and Computer fee will change with respect to new class.
                        </p>
                    </div>

                    <hr style="border-color: red">                      

                    <div class="row">
                        <div id="old_student_div" class="col s6">
                            
                        </div>

                        <div id="new_student_div" class="col s6">
                            
                        </div>                        
                    </div>

                </form>
            </div>
        </main>

<?php include_once("../config/footer.php");?>
<script type="text/javascript">
    function disableStudent(id)
    {
      var selectbtn=document.getElementById(id).checked;
      var sname=document.getElementById("sname"+id);

      var roll_no = document.getElementById("roll_no"+id);

        if (selectbtn) {
        sname.style.color = "black";
        roll_no.removeAttribute("readonly");

        } else {
        sname.style.color = "red";
        roll_no.setAttribute("readonly",true);
        roll_no.value = "";
        }  
    }



    $(document).ready(function (e){
        $("#promote_student_form").on('submit',(function(e) 
          {
            e.preventDefault(); 
            var r = confirm("Before click ok, Be sure to confirm all details are correct");
            if (r) {
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
                        //$("#err").fadeOut();
                        $("#overlayloading").show();
                        $("#submitBtn").hide();
                      },
                      success: function(data)
                      {
                        var result = JSON.parse(data);

                        if (result.status == 200) {

                            alert('Promotion Successfully done');
                            location.reload();

                        }else{
                            Materialize.toast(result.errormsg, 4000, 'red rounded');
                            
                        }
                        $("#submitBtn").show();
                        $("#overlayloading").hide();
                         
                        
                      },
                      error: function(e) 
                      {
                        Materialize.toast('Sorry Try Again !!', 4000, 'red rounded');
                        $("#submitBtn").show();
                        $("#overlayloading").hide();
                      }          
                });
            }
        }));
    });
</script>
