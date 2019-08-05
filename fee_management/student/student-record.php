<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');
?> 
<?php

$year_id = $current_year_session_id;
$class_details= json_decode($account->get_class_list_by_year_id($year_id));
?>

<body>

<?php include('../config/navbar.php'); ?>

    <section id="main-content">
        <section class="wrapper">
             <div class="table-agile-info" id='load_edit_teacher_record'>

                <div class="panel panel-default">
                    <div class="panel-heading" >
                      Student Record Details
                    </div>




                    <div class="col-md-12" style="padding: 5px;float: right;">
                        <a onclick="printExternal('../student/create_pending_receipt.php')" class="btn btn-primary" style="float: right;"  >Create all student dues Receipt </a>

                       <a class='btn btn-primary btn-right ItemID' style='color:#fff;float: right;margin-right: 10px;' href='#viewModal' data-toggle='modal' data-whatever=''>Create dues receipt by class name</a>

                       <a href="inactive-student-record.php" class="btn btn-primary" style='color:#fff;float: right;margin-right: 10px;'  >Inactive student</a>
                       <div style="display: inline-flex;">
                          <select  id="class_id" name="class_id" onchange="showSection(this.value)" style="padding: 5px;margin-right: 5px">

                              <option value="" >Select class</option>
                                <?php
                                  foreach ($class_details as $clist) {
                                    echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                  }
                                ?>
                            </select>
                            <select name="section_id" id="section_id" onchange="refreshContent()" style="padding: 5px">
                                  <option value="" >Select class first</option>
                            </select>
                        </div>


                    </div>



        <!----------- Start Active Student List---------------------------------------- -->
            <div id="active_student_div" class="mt-20px">
                        
                <div class="row scrollable pl-2 pr-2 cMargin" id='info_table'>

                    <table id="active_student_grid" class="display" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Admit no</th>
                                <th>Roll no</th>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Parent</th>
                                <th>Parent Number</th>
                                <th style="width: 110px;">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>

        <!----------- End Active Student List---------------------------------------- -->


                </div>
            </div>
        
    </section>

</section>
<?php require('../config/commonFooter.php'); ?>
<?php require('../modelprint.php'); ?> 


<!-- <div id="Modal" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="newModalLabel"> -->
    <!-- <div class="modal-dialog" style="margin-left:35%;margin-top: 10%;width:40%; "> -->
        <!-- <div class="modal-content"> --><!--
          <div class="modal-body" style="padding: 0">
           <form id='form' method='post'  name="create_due_form">

              <div class="modal-header" style="">  
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                     <h4 class="modal-title">
                     <i class="glyphicon glyphicon-user"></i>Create student due receipt and ledger
                     </h4> 
              </div> 
              <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                  <label>Class Name</label>
                  <select name="className" class="form-control">
                    <option>Select class name</option>
                  <?php
                  //foreach ($class_details as $key) 
                 // {
                   // echo "<option>".$key->class_name."</option>";
                 // }
                  ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer"> 
                  <input readonly="true" onclick="create_receipt_by_class('../student/create_pending_receipt_by_class.php')" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;width:150px;" name="add_salary" value="Create Receipt">
                  
                   <button type="button" onclick="create_receipt_by_class('../student/create_pending_receipt_by_class.php')" class="btn btn-success">Create Receipt</button>
                  <input readonly="true" onclick="create_receipt_by_class('../student/horizontal_ledger.php')" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;width:150px;" name="add_salary" value="Create ladger">
                  <button type="button" onclick="create_receipt_by_class('../student/horizontal_ledger.php')" class="btn btn-success">Create ladger</button>
                 <input readonly="true" onclick="create_ledger_by_class('../student/create_pending_ladger_by_class.php')" class="btn btn-info pull-right" style="width:150px;color: #fff;background-color: #009688;border-color: #46b8da;margin-right: 10px;" name="add_salary" value="Vertical ladger"> 
                  <button type="button" onclick="create_ledger_by_class('../student/create_pending_ladger_by_class.php')" class="btn btn-success">Vertical ladger</button>
          </div> 
      </form>
   </div>
        </div>
    </div>
</div>
    -->

<script type="text/javascript">
    
    $( document ).ready(function() { 

        $('#active_student_grid').DataTable({
         "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"../school/getContentForAccount.php?activestudent", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            data: {
               class_id: function() { return $('#class_id').val() },
               section_id: function() { return $('#section_id').val() }
              },
            error: function(){
              $("#active_student_grid_processing").css("display","none");
            }
          }
        });


        // $('#inactive_student_grid').DataTable({
        //     "bProcessing": true,
        //      "serverSide": true,
        //      "ajax":{
        //         url :"getContentAdmin.php?inactivestudent", // json datasource
        //         type: "post",  // type of method  ,GET/POST/DELETE
        //         error: function(){
        //           $("#inactive_student_grid_processing").css("display","none");
        //         }
        //       }
        // });   
    });


   function refreshContent() {
        $('#active_student_grid').DataTable().ajax.reload();
  } 

  function showSection(str) {
    
    if (str == "") {
        document.getElementById("section_id").innerHTML = "<option value='' >Select Class first</option>";
        var selectDropdown =    $("#section_id");
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
                var selectDropdown =    $("#section_id");
                document.getElementById("section_id").innerHTML = this.responseText;
                selectDropdown.trigger('contentChanged');
            }
        };
        xmlhttp.open("GET","../../important/getListById.php?classforsection="+str,true);
        xmlhttp.send();
        $('select').on('contentChanged', function() {  // re-initialize 
       $(this).material_select();
         });
    }

    refreshContent();

  } 
</script>
<script>
function printExternal(url) 
{
    if(confirm('Are you sure to create due receipt?'))
    {
        var printWindow = window.open(url, 'Print', '');
         printWindow.addEventListener('load', function(){
             printWindow.print();
             printWindow.close();
         }, true);
    }
  
}

</script>
<link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css"/>
     
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
</body>
</html>
