<?php
include('session.php');
$sqlclass = "select * from class";
    $resultclass = $db->query($sqlclass);
?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>



<!-- <script type="text/javascript" async>
function fetch_select(val)
{
 $.ajax({
 type: 'post',
 url: 'getsection.php',
 data: {
  get_option:val
 },
 success: function (response) {
  document.getElementById("new_select").innerHTML=response; 
 }
 });
}

</script> -->
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Add Teacher</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form class="col s12" action="addteacherscript.php" method="post" >

                    
                    <div class="row">
                        <div class="input-field col s6">
                            <select name="class" onchange="showUser(this.value)">

                              <option value="" >Select class</option>

                                <?php if ($resultclass->num_rows > 0) {
                                    while($row = $resultclass->fetch_assoc()) { ?>
                                            <option value="<?php echo $row["class_name"];?>"><?php echo $row["class_name"];?></option>
                                <?php 
                                }
                                } 
                                ?>
                            </select>
                            <label>Class:</label>
                        </div>                        
                        <div class="input-field col s6">
                          <select name="section" id="txtHint">
                            <option value="" >Select class first</option>
                          </select>
                          <label>Section:</label>
                        </div>
                    </div> 




                        <div class="row">
                            <div class="input-field col offset-m10">
                                 <button class="btn waves-effect waves-light" type="submit" name="teacher_form">Submit
                                    <i class="material-icons right">send</i>
                                  </button>
                                </div>

                        </div>

                </form>
            </div>   
               

        </main>
<?php include_once("../config/footer.php");?>      
