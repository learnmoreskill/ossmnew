<?php
include('session.php');
require("../important/backstage.php");
$backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'generate_character';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>



    <!-- get section list from database-->
    <script>
        function showUser(str) {
          if (str == "") {
              document.getElementById("txtHint").innerHTML = "";
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
                      var selectDropdown =    $("#txtHint");
                      document.getElementById("txtHint").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp.open("GET","getstudent.php?classid="+str+"&year_id=<?php echo $year_id; ?>",true);
              xmlhttp.send();
              $('select').on('contentChanged', function() { 
              // re-initialize 
             $(this).material_select();
               });
          }
        }
    </script>

    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Generate character certificate</a></div>
                    </div>
                </div>
            </div>
            
            <div class="row">
              <div class="col s12 m12">
                
              
                <form target="_blank" action="printcharacter.php" method="post" >
                  <input type="hidden" name="year_id" value="<?php echo $year_id; ?>">

                  <div class="row">
                    <div class="input-field col s12">
                        <h5>Select Template</h5>

                      <input class="with-gap" name="template_id" value="99" type="radio" id="default" checked />
                      <label for="default">Default</label>

                      <input class="with-gap" name="template_id" value="1" type="radio" id="one" />
                      <label for="one">One</label>

                    </div>
                            
                  </div>

                  <!-- ======== -->
                  <div class="spliter">
                        <h5 class="center">For Multiple Student</h5>
                        <hr >
                  </div>


                  

                  <div class="card blue-grey">

                    <div class="row"><br>
                        <div class="input-field col s12 m2">
                                <select id="sclass" name="sclass" onchange="showUser(this.value)">

                              <option value="" >Select class</option>

                                <?php 
                                foreach ($classList as $clist) {
                                  echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                }
                                ?>
                            </select>
                            <label class="white-text">Class:</label>
                        </div>
                        <div class="input-field col s12 m8">
                            <select multiple name="multistudent[]" id="txtHint">
                            <option value="" disabled>Select class first</option>
                            </select>
                            <label class="white-text">Student</label>
                        </div>
                    
                        <div class="input-field col m2">
                             <button class="btn waves-effect waves-light" type="submit" name="generate_multiple_character" value="generate_multiple_character" >Submit
                                <i class="material-icons right">send</i>
                              </button>
                        </div>
                      <br>
                    </div>
                  </div>



                  <!-- ======================= -->
                  <div class="spliter">
                   <h5 class="center">For Particular Student</h5>
                    <hr >
                  </div>
                 
                  <div class="row">
                      <div class="col s12 m12">
                        <div class="card blue-grey">
                          <div class="row white-text">                                
                            <div class="row">
                              <div class="search-box test3 input-field col s12 m12">
                                  <input id="searchname" autocomplete="off" name="searchname" type="text" class="validate" autofocus>
                                  <div class="result resultStyle" style="max-height: 400px;"></div>
                                  <label class="white-text" for="searchname">Search Student</label>
                              </div>
                            </div>
                          </div>
                            
                        </div>
                          <ul class="test collapsible" data-collapsible="expandable">
                                  <li>
                                    <div style="display: none;" class="test2 collapsible-header"></div>
                                    <div class="collapsible-body">
                                      <div class="row">
                                        <div class="col s12 m3">
                                          <div class="stdimage"></div>
                                        </div>

                                        <div class="col s12 m4">
                                          <div class="name"></div>
                                          <div class="class"></div>
                                          <div class="address"></div>
                                        </div>                                 
                                        <div class="col s12 m5">
                                          <div class="sparent"></div>
                                          <div class="spnumber"></div>
                                        </div>
                                      </div>

                                      <div class="row">
                                        
                                          <input type="hidden" id="studentid" name="singlestudent[]" value="">
                                          <!-- <input type="hidden" id="sclass1" name="sclass" value=""> -->
                                          <div class="input-field col offset-m10">
                                            <button class="btn waves-effect waves-light" type="submit" name="generate_single_character" value="generate_single_character" >Submit<i class="material-icons right">send</i>
                                            </button>
                                          </div>                               
                                      </div>

                                    </div>
                                  </li>
                          </ul>
                      </div>
                  </div>

                </form>
              </div>
            </div>
          
    </main>
<?php include_once("../config/footer.php");?>

<script src="../jquery.materialize-autocomplete.js"></script>

<script type="text/javascript">
$(document).ready(function(){
  $("#searchname").keyup(function() {
    //$('.search-box input[type="text"]').on("keyup input", function(){

      $(".test2.collapsible-header").removeClass(function(){
    return "active";
  });
  $(".test").collapsible({accordion: true});
  $(".test").collapsible({accordion: false});
      
        /* Get input value on change */
        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if(inputVal.length){ 
            $.get("backend-search.php", {term: inputVal}).done(function(data){
                // Display the returned data in browser
                //debugger;
                data=JSON.parse(data);
                var temparr='';
                data.forEach(function(value){
                  temparr += "<p>"+value.sname+"&nbsp&nbsp Class: "+value.class_name+"-"+value.section_name+"&nbsp&nbsp Roll: "+value.sroll+"<span id='studData' style='display:none;'>"+JSON.stringify(value)+"</span></P>"

                });
                //debugger;
                  resultDropdown.html(temparr);


                 //alert(data);
                //resultDropdown.html(data);
            });
        } else{
            resultDropdown.empty();

                $(".test2.collapsible-header").removeClass(function(){
                  return "active";
                });
                $(".test").collapsible({accordion: true});
                $(".test").collapsible({accordion: false});
              
              }
    });
    
    // Set search input value on click of result item
    $(document).on("click", ".result p", function(){
        var sName=$(this).parents(".search-box").find('input[type="text"]').val(this.innerText);

        //var sData=document.getElementById('usrData').innerHTML;  
        var sData = this.getElementsByTagName('span')[0].innerHTML;                
        sData=JSON.parse(sData);
        console.log("data received",sData.sname);
        //debugger;
        $(this).parent(".result").empty();
        document.getElementById('studentid').value=sData.sid;
        //document.getElementById('sclass1').value=sData.sclass;

        if (sData.simage) {
          $(".stdimage").html("<div class='ccimage'><img  src='../uploads/<?php echo $fianlsubdomain; ?>/profile_pic/"+sData.simage+"' height='100%;' width='100%;'></div>").show();
        }else{
          $(".stdimage").html("<div class='ccimage'><p>Image not Available</p></div>").show();
        }
        
        $(".name").html("<p>Name: "+sData.sname+"</p>").show();
        $(".class").html("<p>Class: "+sData.class_name+" "+sData.section_name+"</p>").show();
        $(".address").html("<p>Address: "+sData.saddress+"</p>").show();

        $(".sparent").html("<p>Parent: "+sData.spname+"</p>").show();
        $(".spnumber").html("<p>Address: "+sData.spnumber+"</p>").show();
        
        //
        $(".test2.collapsible-header").addClass("active");
        $(".test").collapsible({accordion: false});
    });
});
</script>