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
                      <li class="tab col s3" ><a class="white-text text-lighten-4 active" href="#broadcast_div">Broadcast</a></li>
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
                            <th>Sender</th>
                            <th>Message</th>
                            <th>Receiver</th>
                            <?php if ($login_cat == 1 || $pac['edit_message']) { ?>
                            <th style="width: 110px;">Action</th>
                            <?php } ?>
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
                            <th>Sender</th>
                            <th>Message</th>
                            <th>Receiver</th>
                            <?php if ($login_cat == 1 || $pac['edit_message']) { ?>
                            <th style="width: 110px;">Action</th>
                            <?php } ?>
                          </tr>
                      </thead>
                  </table>
              </div>
            </div>


<script type="text/javascript">
    function look_b_receiver(obj)
    {
        if (window.XMLHttpRequest) { // code for IE7+,Firefox,Chrome,Opera,Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("receiver_details_id").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET","../important/getContent.php?broadcast_receiver="+obj,true);
        xmlhttp.send();
    }
    function look_bp_receiver(obj)
    {
        if (window.XMLHttpRequest) { // code for IE7+,Firefox,Chrome,Opera,Safari
            xmlhttp1 = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp1 = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp1.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("receiver_details_id").innerHTML = this.responseText;
            }
        };
        xmlhttp1.open("GET","../important/getContent.php?personal_receiver="+obj,true);
        xmlhttp1.send();
    }
</script>
<!-- Modal Structure -->
  <div id="receiver_details_model" class="modal" >
    <div class="modal-content">
        <h6 align="center">Receiver</h6>
        <div class="divider"></div>
        <div class="row">
        <div id="receiver_details_id" >
        </div>
      </div>

      <div class="modal-footer">
          <a href="#!" class="modal-close waves-effect waves-green btn-flat">Close</a>
      </div>
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
              url :"getContentAdmin.php?broadcast", // json datasource
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
              url :"getContentAdmin.php?personal", // json datasource
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
