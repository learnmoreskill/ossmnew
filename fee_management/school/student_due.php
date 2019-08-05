<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php');
require('../head.php');
require('../header.php');

$year_id = $current_year_session_id;
$class_details= json_decode($account->get_class_list_by_year_id($year_id));

?>
<body>
    
<?php include('../config/navbar.php'); ?>

<section id="main-content">
    <section class="wrapper" style="width:95%;margin:100px 25px 0px;">
    	<div class=" panel panel-default">
        <div class="panel-heading"> 
       		Student Due Ledger
        </div>
    	<div style="padding: 15px;width:100%;">
    		<form name='bill_print_form' action="student_due_export.php" method="GET">
                <input type="hidden" name="generate_student_due_ledger" value="student">
                <div class="form-group">
                    <label >Select student type*</label>
                    <select class="form-control" name='export_type'>
                        <option value="student">All Student</option>
                    	<option value="general">General</option>
                        <option value="transport">Using transport</option>
                    	<option value="hostel">Using hostel</option>
                    	
                    </select>
                </div>
                <div class="form-group">
                    <label >Class (Optional)</label>
                    <select class="form-control" id="classId" name="classId" onchange="showSection(this.value)">
                        <option value="" >Select class</option>
                        <?php
                          foreach ($class_details as $clist) {
                            echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                          }
                        ?>
                        
                    </select>
                </div>
                <div class="form-group">
                    <label >Section (Optional)</label>
                    <select class="form-control" name='sectionId' id="sectionId" >
                          <option value="" >Select class first</option>
                    </select>

                </div>

                    <div class="form-group">
                  
                    <input type="submit" readonly="true" class="btn btn-primary" value="Create" style="width:100px   ;">
                    </div>
                
            </form>
	       </div>
        </div>    
    </section>
</section>

<?php require('../config/commonFooter.php'); ?>
<script type="text/javascript">
      function showSection(str) {
    
    if (str == "") {
        document.getElementById("sectionId").innerHTML = "<option value='' >Select Class first</option>";
        var selectDropdown =    $("#sectionId");
        selectDropdown.trigger('contentChanged');
    } else{
        classId = str; 
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {        // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var selectDropdown =    $("#sectionId");
                document.getElementById("sectionId").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            }
        };
        xmlhttp.open("GET","../../important/getListById.php?classforsection="+str,true);
        xmlhttp.send();
        $('select').on('contentChanged', function() {  // re-initialize 
       $(this).material_select();
         });
    }

  } 
</script>
</body>
</html>
