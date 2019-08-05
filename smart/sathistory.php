<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'sathistory';
?>
    <!-- add header.php here -->
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
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Attendance History</a></div>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col s12 m12 scrollable pl-2 pr-2" id='info_table'>

                    <table id="attendance_history_grid" class="display" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>

                </div>
            </div>
      
        </main>


        <!-- add header.php here -->
    <?php include_once("../config/footer.php");?>

<script type="text/javascript">
$( document ).ready(function() {
$('#attendance_history_grid').DataTable({
                 "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"getContentSmart.php?attendance_history", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
              $("#attendance_history_grid_processing").css("display","none");
            }
          }
        }); 
});
</script>


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css"/>
     
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>