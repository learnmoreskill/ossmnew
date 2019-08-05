<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');
?>
<body>

<?php include('../config/navbar.php'); ?>

    <section id="main-content">
        <section class="wrapper">
             <div class="table-agile-info" id='load_edit_teacher_record'>

                <div class="panel panel-default">
                    <div class="panel-heading" >
                      Inactive Student Record Details
                    </div>

        <!----------- Start Inactive Student List---------------------------------------- -->
            <div id="inactive_student_div" class="mt-20px">
                        
                <div class="row scrollable pl-2 pr-2 cMargin" id='info_table'>

                    <table id="inactive_student_grid" class="display" width="100%" cellspacing="0">
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
                                <th>Status</th>
                                <th style="width: 110px;">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>

        <!----------- End Inactive Student List---------------------------------------- -->


                </div>
            </div>
        
    </section>


</section>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>
    
    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/jquery.sparkline.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
    <script src="../assets/js/sparkline-chart.js"></script>    
    <script src="../assets/js/zabuto_calendar.js"></script>    
    
 <?php require('../modelprint.php'); ?> 

<script type="text/javascript">
    
    $( document ).ready(function() {

        $('#inactive_student_grid').DataTable({
            "bProcessing": true,
             "serverSide": true,
             "ajax":{
                url :"../school/getContentForAccount.php?inactivestudent", // json datasource
                type: "post",  // type of method  ,GET/POST/DELETE
                error: function(){
                  $("#inactive_student_grid_processing").css("display","none");
                }
              }
        });   
    });


   function refreshContent() {
        $('#active_student_grid').DataTable().ajax.reload();
  } 

  
</script>
<link rel="stylesheet" type="text/css" href="../../css/jquery.dataTables.min.css"/>
     
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
</body>
</html>
