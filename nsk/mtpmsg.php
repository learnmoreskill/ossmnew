<?php
include('session.php');
if (isset($_GET["key"])){
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);
        }
if (isset($_GET["name"])){
            $sname = addslashes($_GET["name"]);
        }
if (isset($_GET["class"])){
            $sclass = addslashes($_GET["class"]);
        }
if (isset($_GET["roll"])){
            $sroll = addslashes($_GET["roll"]);
        }
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Complaint to parent</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text flow-text">
                            <span class="card-title flow-text"><span style="color:#008eef;">Send complaint for</span></span>
                            <p class="flow-text">
                                Name :
                                <?php echo $sname;?> <br/> Class :
                                <?php echo $sclass; ?> <br/> Roll No :
                                <?php echo $sroll; ?> <br/>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title"><span style="color:#008eef;">Type Complaint :</span></span>
                            <br/>
                            <div class="row">
                                <form class="col s12" action="mtpmsgscript.php?key=<?php echo $shortid; ?>" method="post">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="tcmsg" name="tcmsg" autofocus class="materialize-textarea" maxlength="160" length="160" required></textarea>
                                            <span>*Please do not use emoji, it may charge extra credit on SMS / Unicode support 70 character only</span><br>
                                            <span id="character" style="color: red"></span>
                                        </div>
                                    </div>
                                    <button id="broadcastbtn" class="btn waves-effect waves-light blue lighten-2" type="submit">Send<i class="material-icons right">send</i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>

<script>
$("#tcmsg").on("input", function() {
  updateCount();
});

function updateCount() {
    //to remove emoji
    var ranges = [
      '\ud83c[\udf00-\udfff]', // U+1F300 to U+1F3FF
      '\ud83d[\udc00-\ude4f]', // U+1F400 to U+1F64F
      '\ud83d[\ude80-\udeff]'  // U+1F680 to U+1F6FF
    ];

    var str = $('#tcmsg').val();
     
      str = str.replace(new RegExp(ranges.join('|'), 'g'), '');
      $("#tcmsg").val(str);


    var character1 = document.getElementById("tcmsg");
    var broadcastbtn = document.getElementById("broadcastbtn");

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