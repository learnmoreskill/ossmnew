<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'bmsg';

    $resultclass = $db->query("select * from class");
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <script type="text/javascript">
        function showSection(str) {
          if (str == "") {
              document.getElementById("section").innerHTML = "";
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
                      var selectDropdown =    $("#section");
                      document.getElementById("section").innerHTML = this.responseText;
                      selectDropdown.trigger('contentChanged');
                  }
              };
              xmlhttp.open("GET","../important/getListById.php?q="+str,true);
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">New BroadCast</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title"><span style="color:#008ee6;">Send broadcast:</span></span>
                            <br/>
                            <div class="row">
                                <form id="teacher_broadcast_to_class_form" class="col s12" action="bmsgscript.php" method="post">
                                    <div class="input-field col s12">
                                    <select id="classname" name="classname" onchange="showSection(this.value)" >
                                            <option value="" >Select class</option>
                                            <?php if ($resultclass->num_rows > 0) {
                                                while($row = $resultclass->fetch_assoc()) { ?>
                                                        <option value="<?php echo $row["class_name"];?>"><?php echo $row["class_name"];?></option>
                                            <?php 
                                            }
                                            } 
                                            ?>
                                      </select>
                                      <label>Select Class</label>
                                </div>
                                <div class="input-field col s12">
                                    <select name="section" id="section">
                                        <option value="" >Select class first</option>
                                    </select>
                                    <label>Section:</label>
                                </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="topic" name="tbmsg" class="materialize-textarea" maxlength="160" length="160" required></textarea>
                                            <label>Type Message</label>
                                            <span>*Please do not use emoji, it may charge extra credit on SMS / Unicode support 70 character only</span><br>
                                            <span id="character" style="color: red"></span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="teacher_broadcast_to_class">
                                    <button id="submitbtn" class="btn waves-effect waves-light blue lighten-2" type="submit" name="action" >Send<i class="material-icons right">send</i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </main>
    <!-- add footer.php here -->
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
  updateCount();
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
    var broadcastbtn = document.getElementById("submitbtn");

    var cs = character1.value.length;
    var uni=hasUnicode(character1.value);
    if(uni){
        console.log("Unicode","true");
        character1.setAttribute("length", "70");
        character1.setAttribute("maxlength", "70");
        if (cs>70) { 
            broadcastbtn.disabled = true;
            $('#character').text("Message with special character can not be more than 70.");
        }else{
            broadcastbtn.disabled = false;
            $('#character').text("");
        }
    }else{
    console.log("Unicode","false");
    character1.setAttribute("length", "160");
    character1.setAttribute("maxlength", "160");
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
    var submitbtn=document.getElementById("submitbtn");

  $("#teacher_broadcast_to_class_form").on('submit',(function(e) 
  { 
    submitbtn.style.display = "none";
    e.preventDefault();
    $.ajax
    ({
          url: "bmsgscript.php",
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
            if (data!='Broadcast message succesfully pushed to selected class students') { Materialize.toast(data, 4000, 'rounded'); } 
            else 
              if (data=='Broadcast message succesfully pushed to selected class students') {

              window.location.href = 'bmsg.php';
            }
            submitbtn.style.display = "block";
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
            submitbtn.style.display = "block";
          }          
    });
  }));
});
</script>

    