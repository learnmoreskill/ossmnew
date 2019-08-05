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
             <div class="col-md-4" id='load_insert_feetype'>
            Loading...
            </div>

            <div class="col-md-8" id='load_book_list_details'>
                <div class="table-agile-info" id='load_fee_type'>
                Loading...
            </div>
        
            </div>
           
        </section>
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

<script type="text/javascript">
    $('#load_fee_type').load('../student/feetype_list.php');
    $('#load_insert_feetype').load('../student/insert_fee_category.php');
    

    function submit_fee_type()
    { 
        var feetype = feetypeForm.feetype_title.value;
        var i = 0,
        strLength = feetype.length;
        if(strLength>0){

            for(i; i < strLength; i++) {
             
             feetype = feetype.replace(" ", "_");
             
            }
            
           $('#load_fee_type').load('../student/feetype_list.php?feetype='+feetype);
            feetypeForm.feetype_title.value = '';
        }else{
            confirm("please insert valid fee type");
        }
    }

    function delete_fee_type(id)
    { 
        if(confirm("Are you sure to delete fee category?")){
        $('#load_fee_type').load('../student/feetype_list.php?delete_id='+id);
    }
       
    }

    function edit_fee_type(id)
    {
        $('#load_insert_feetype').load('../student/edit_fee_type.php?edit_id='+id);
    }

    function update_fee_type(id)
    {
        var feetype = feetypeForm.feetype_title.value;
        var i = 0,
        strLength = feetype.length;
        for(i; i < strLength; i++) {
         
         feetype = feetype.replace(" ", "_");
         
        }
      // alert(feetype);
        //feetype = feetype.replace(' ', "_")
          $('#load_fee_type').load('../student/feetype_list.php?update_feetype='+feetype+'&update_id='+id);
         
          $('#load_insert_feetype').load('../student/insert_fee_category.php');
    }
</script>

</body>
</html>
