<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'broadcasthistory';

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
                      <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#broadcast_div">Notice</a></li>
                      <li class="tab col s3"><a class="white-text text-lighten-4" href="#personal_div">Personal</a></li>
                    </ul>
                  </div>
                </div>
            </div>
            <div id="broadcast_div">
              <div class="row scrollable pl-2 pr-2" id='info_table'>

                  <table id="broadcast_grid" class="display" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <th>Date</th>
                            <th>Message</th>
                            <th>Sender</th>
                          </tr>
                      </thead>
                  </table>
              </div>
            </div>

            <div id="personal_div">
              <div class="row scrollable pl-2 pr-2" id='info_table'>

                  <table id="personal_grid" class="display" width="100%" cellspacing="0">
                      <thead>
                          <tr>
                            <th>Date</th>
                            <th>Message</th>
                            <th>Sender</th>
                          </tr>
                      </thead>
                  </table>
              </div>
            </div>

  </main>

<?php include_once("../config/footer.php");?>

<script type="text/javascript">
  $( document ).ready(function() {
  $('#broadcast_grid').DataTable({
                   "bProcessing": true,
           "serverSide": true,
           "ajax":{
              url :"getContentSmart.php?broadcast", // json datasource
              type: "post",  // type of method  ,GET/POST/DELETE
              error: function(){
                $("#broadcast_grid_processing").css("display","none");
              }
            }
    }); 
  });

  $( document ).ready(function() {
  $('#personal_grid').DataTable({
                   "bProcessing": true,
           "serverSide": true,
           "ajax":{
              url :"getContentSmart.php?personal", // json datasource
              type: "post",  // type of method  ,GET/POST/DELETE
              error: function(){
                $("#personal_grid_processing").css("display","none");
              }
            }
    }); 
  });


  $(document).ready(function() {
  $("ul.tabs > li > a").click(function (e) {
    var id = $(e.target).attr("href").substr(1);
    window.location.hash = id;});
    var hash = window.location.hash;
    $('ul.tabs').tabs('select_tab', hash);
  });
</script>


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css"/>
     
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
