<?php
   include('session.php');
   include("../important/backstage.php");
  $backstage = new back_stage_class();

   /*set active navbar session*/
$_SESSION['navactive'] = 'allstudent';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    <style type="text/css">
        #info_table select{
            display: inherit;
        }
        #info_table label{
            width: 100%;
            font-size: 20px;
            color:#000;
        }
        #examtypeTable_filter{
            width: 50%;
        }

        #examtypeTable_wrapper
        {
            margin-top: 20px;
        }

        .dataTables_length{
            width: 50%!important;
        }
        .dataTables_filter{
            width: 50%!important;
            text-align: left;
        }
        .dataTables_filter>label>input{
            min-width: 100px;
            max-width: 300px;
            padding: 0!important;

        }
        @media screen and (max-width: 720px) {
            .dataTables_length{
                width: 100%!important;
                text-align: left!important;


            }
            .dataTables_filter{
                width: 100%!important;
                text-align: left!important;


            }
        }
    </style>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                  <div class="row">
                    <div class="col s12">
                      <ul class="tabs github-commit">            
                        <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#active_student_div">Active Student</a></li>
                        <li class="tab col s3"><a class="white-text text-lighten-4" href="#inactive_student_div">Inactive Student</a></li>
                      </ul>
                    </div>
                  </div>
            </div>
<!----------- Start Active Student List---------------------------------------- -->
            <div id="active_student_div" class="mt-20px">

                    <div class="row no-margin">
                        <div class="col s12 m6 right-align mt-15px mb-15px" >
                            <!-- <input type="checkbox" id="showAll" />
                                <label for="showAll">Show All</label> -->

                             <div class="input-field col s6 m3">
                                <select id="class_id" name="class_id" onchange="showSection(this.value)" >

                                  <option value="" >Select class</option>
                                    <?php
                                      foreach ($classList as $clist) {
                                        echo '<option value="'.$clist->class_id.'"> ' . $clist->class_name. ' </option>';
                                      }
                                    ?>
                                </select>
                            </div>
                            <div class="input-field col s6 m3" id="sectionDiv">
                                <select name="section_id" id="section_id" onchange="refreshContent()">
                                  <option value="" >Select class first</option>
                                </select>
                            </div> 


                        </div>
                    </div>
                        
                <div class="row scrollable pl-2 pr-2" id='info_table'>

                    

                    <table id="active_student_grid" class="display" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Admit no</th>
                                <th>Roll no</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Class</th>
                                <th>Address</th>
                                <th>Parent</th>
                                <th>Running Batch</th>
                                <th>Status</th>
                                <th style="width: 110px;">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
<!----------- End Active Student List---------------------------------------- -->

<!----------- Start Inactive Student List---------------------------------------- -->
            <div id="inactive_student_div">
                <div class="row scrollable pl-2 pr-2" id='info_table'>

                    <table id="inactive_student_grid" class="display" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Admit no</th>
                                <th>Roll no</th>
                                <th>Name</th>
                                <th>Gender</th>
                                <th>Class</th>
                                <th>Address</th>
                                <th>Parent</th>
                                <th>Current Batch</th>
                                <th>Status</th>
                                <th style="width: 110px;">Action</th>
                            </tr>
                        </thead>
                    </table>

                </div>

            </div>
<!----------- End Inactive Student List---------------------------------------- -->
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


<script type="text/javascript">
    
    $( document ).ready(function() { 

        $('#active_student_grid').DataTable({
         "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"getContentAdmin.php?activestudent", // json datasource
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


        $('#inactive_student_grid').DataTable({
            "bProcessing": true,
             "serverSide": true,
             "ajax":{
                url :"getContentAdmin.php?inactivestudent", // json datasource
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
        xmlhttp.open("GET","../important/getListById.php?classforsection="+str,true);
        xmlhttp.send();
        $('select').on('contentChanged', function() {  // re-initialize 
       $(this).material_select();
         });
    }

    refreshContent();

  } 
</script>


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css"/>
     
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>