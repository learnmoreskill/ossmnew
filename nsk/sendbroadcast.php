<?php
   include('session.php');
   require("../important/backstage.php");
   $backstage = new back_stage_class();


   /*set active navbar session*/
$_SESSION['navactive'] = 'sendbroadcast';


$classList= json_decode($backstage->get_class_list());

   ?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <script>
      function studentscheck() {
        var x = document.getElementById("checkstudents").checked;
        var y = document.getElementById("checkparents").checked;
        var z = document.getElementById("classDiv");
        if (x == 0 && y == 0) {
          z.style.display = "none";
        }else if (x == 1 || y == 1) {
          z.style.display = "block";
        }  

      }
      function parentscheck(){
        var x = document.getElementById("checkstudents").checked;
        var y = document.getElementById("checkparents").checked;
        var z = document.getElementById("classDiv");
        if (x == 0 && y == 0) {
          z.style.display = "none";
        }else if (x == 1 || y == 1) {
          z.style.display = "block";
        }       
      }
      
    </script>
        <main>

          <div id="overlayloading"><div><img src="../images/loading.gif" width="64px" height="64px"/></div></div>

            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Send Broadcast</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
              <div class="col s12 m12">
                <div class="card grey darken-3">
                  <div class="card-content white-text">
                      <span class="card-title">
                        <span style="color:#008ee6;"></span>
                      </span><br/>
                    <div class="row">
                      <form class="col s12" id="sendbroadcastbyprincipal" action="sendbroadcastscript.php" method="post">
                        <div class="row center">

                          <div class="col s6 m3 switch">
                            <label style="font-size: 20px">Students<br>
                              <input onclick="studentscheck()"  type="checkbox" name="checkstudents" id="checkstudents">
                              <span class="lever"></span></label>
                          </div>

                          <div class="col s6 m3 switch">
                              <label style="font-size: 20px">Parents<br>
                              <input onclick="parentscheck()"  type="checkbox" name="checkparents" id="checkparents">
                              <span class="lever"></span></label>
                          </div>

                          <!-- <div class="col s6 m3 switch">
                              <label style="font-size: 20px">Teachers<br>
                              <input   type="checkbox" name="checkteachers">
                              <span class="lever"></span></label>
                          </div>

                          <div class="col s6 m3 switch">
                              <label style="font-size: 20px">Staff<br>
                              <input   type="checkbox" name="checkstaff">
                              <span class="lever"></span></label>
                          </div> -->

                        </div>

                        <div class="row" id="classDiv" >
                          <div class="input-field col s12">
                            <select multiple name="classes[]" id="classes">
                              <option value="" disabled selected>Select class</option>
                              <?php foreach ($classList as $clist) { ?>
                              <option value="<?php echo $clist->class_id; ?>" ><?php echo $clist->class_name; ?></option>
                              <?php } ?>
                            </select>
                            <label>Select Class</label>
                          </div>
                        </div>

                        <div class="row">
                          <div class="input-field col s12">
                              <textarea id="topic" name="broadcastmessage" class="materialize-textarea"  length="500" ><?php echo "-".$login_session_a; ?></textarea>
                              <label>Type message</label>
                              <!-- <span>*Please do not use emoji, it may charge extra credit on SMS / Nepali font support 70 character only</span><br> -->
                              <span id="character" style="color: red"></span>
                          </div>
                        </div>

                        <button id="broadcastbtn" class="btn waves-effect waves-light blue lighten-2" type="submit" name="action">Send<i class="material-icons right">send</i></button>
                      </form>
                    </div>
                  </div>
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
$("#topic").on("input", function() {
  //updateCount();
});

function updateCount() {
    //to remove emoji
    var ranges = [
      '\ud83c[\udf00-\udfff]', // U+1F300 to U+1F3FF
      '\ud83d[\udc00-\ude4f]', // U+1F400 to U+1F64F
      '\ud83d[\ude80-\udeff]'  // U+1F680 to U+1F6FF
    ];

    var str = $('#topic').val();
     
      str = str.replace(new RegExp(ranges.join('|'), 'g'), '');
      $("#topic").val(str);


    var character1 = document.getElementById("topic");
    var broadcastbtn = document.getElementById("broadcastbtn");

    var cs = character1.value.length;
    var uni=hasUnicode(character1.value);
    if(uni){
        console.log("Unicode","true");
        character1.setAttribute("length", "70");
        //character1.setAttribute("maxlength", "70"); //changed
        if (cs>70) { 
            broadcastbtn.disabled = false; //changed
            $('#character').text("Message with special character more than 70 may charge extra credit.");
        }else{
            broadcastbtn.disabled = false;
            $('#character').text("");
        }
    }else{
    console.log("Unicode","false");
    character1.setAttribute("length", "160");
    //character1.setAttribute("maxlength", "160"); //changed
    broadcastbtn.disabled = false;
    $('#character').text("");

    } 
}
function hasUnicode (str) {
    for (var i = 0; i < str.length; i++) {
        if (str.charCodeAt(i) > 127) return true;
    }
    return false;
}
</script>


<script>
    $(document).ready(function (e) 
    {
      $("#sendbroadcastbyprincipal").on('submit',(function(e) 
      {
        var x = document.getElementById("overlayloading");
        x.style.display = "block";

        e.preventDefault();
        $.ajax
        ({
              url: "sendbroadcastscript.php",
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
                if (data.trim() !== 'Broadcast sent succesfully'.trim()) { 
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
                  if (data.trim() === 'Broadcast sent succesfully'.trim()) {

                  window.location.href = 'sendbroadcast.php';
                }
                x.style.display = "none";
              },
              error: function(e) 
              {
                alert('Sorry Try Again !!');
                x.style.display = "none";
              }          
        });
      }));

      
    });

</script>
