<?php
    include('session.php');

   /*set active navbar session*/
$_SESSION['navactive'] = 'saplvhistory';

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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Leave History</a></div>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col s12 m12 scrollable pl-2 pr-2" id='info_table'>

                    <table id="leave_grid" class="display" width="100%" cellspacing="0">
                        <thead>
                          <tr>
                            <th>Posted on</th>
                            <th>Request</th>
                            <th>From->To</th>
                            <th>Updated by</th>
                            <th>Status</th>
                          </tr>
                      </thead>
                    </table>

                </div>
            </div>

            <!-- Modal Structure -->
        <div id="modal" class="modal">
            <div class="modal-content modal-fixed-footer" id="model_div">
            </div>
            <div class="modal-footer">
                <a class="modal-action modal-close waves-effect waves-green btn-flat">Close</a>
            </div>
        </div>

        <!-- Edit Modal Structure -->
        <div id="editModel" class="modal">
            <div class="modal-content">
              <form id="update_leave_form" action="requestscript.php" method="post" >
                <h6 align="center">Edit Leave Request</h6>
                <div class="divider"></div>
                <div class="row">
                    <div class="col s2">
                        <h6 style="padding-top: 20px">Start date</h6>
                    </div>
                    <div class="input-field col s3">
                      <input type="text" id="sdate" 
                                  class="<?php if($login_date_type==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" 
                                      onclick="mypicker(this.id)"
                                  name="sdate" 
                                  placeholder="Enter Start Date" >
                    </div>
                    <div class="col s2">
                        <h6 style="padding-top: 20px">End date</h6>
                    </div>
                    <div class="input-field col s3">
                      <input type="text" id="edate" 
                                  class="<?php if($login_date_typee==1){
                                        echo 'datepicker1';
                                      }else if($login_date_type==2){
                                        echo 'bod-picker1';
                                      }else{
                                        echo 'datepicker1';
                                      } ?>" onclick="mypicker(this.id)"
                                  name="edate"
                                  placeholder="Enter End Date" >
                    </div>
                </div>
                <div class="row">
                    <div class="col s2">
                        <h6 style="padding-top: 20px">Mention the reason</h6>
                    </div>
                    <div class="input-field col s8">
                      <textarea id="lvreason" name="lvreason" class="materialize-textarea" length="3000" maxlength="3000" required></textarea>
                    </div>
                </div>
                
                
                <input type="hidden" id="update_leave_request_id" name="update_leave_request_id" value="">
                <div class="modal-footer">
                  <button class="modal-action  waves-effect waves-green btn-flat blue lighten-2" type="submit">Update<i class="material-icons right">send</i></button>
                </div>

              </form>
            </div>
        </div>




<script type="text/javascript">
    function details_model(obj)
        { 

            if (obj == 50){
                var h4 = "Pending...";
                var p = "Please wait until teacher reviews your leave request.";
            }else if (obj == 51){
                var h4 = "Date exceeded...";
                var p = "Sorry ! Your leave request has not been identified by any teachers.";
            }else if (obj == 100){
                var h4 = "Leave Approved";
                var p = "Congratulations ! Your leave request has been approved. Please make sure to attend the classes after your leave period ends.";
            }else if (obj == 0){
                var h4 = "Leave Rejected";
                var p = "Sorry ! Unfortunately your leave request has been rejected.";
            }else{

            }

            document.getElementById("model_div").innerHTML = "<h4>"+h4+"</h4><p class='flow-text'>"+p+"</p>";
               
        }
    function edit_model(obj)
        {
            document.getElementById("update_leave_request_id").value=obj;

            var lsdate=document.getElementById("lsdate"+obj).value;
            var ledate=document.getElementById("ledate"+obj).value;
            var lreason=document.getElementById("lreason"+obj).value;


            document.getElementById("sdate").value = lsdate;
            document.getElementById("edate").value = ledate;
            document.getElementById("lvreason").value = lreason;
        }
</script>
        
        </main>


        <!-- add header.php here -->
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
  $(document).ready(function (e) 
{

  $("#update_leave_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "requestscript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#err").fadeOut();
          },
          success: function(data)
          {
            //alert(data);
            if (data.trim() !== 'Leave request updated successfully'.trim()) { 
              Materialize.toast(data, 4000, 'rounded');
              $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            }else if (data.trim() === 'Leave request updated successfully'.trim()) {
                $('#modal_edit_class').modal('close');
             window.location.href = window.location.href;
            }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
});

</script>

<script type="text/javascript">
$( document ).ready(function() {
$('#leave_grid').DataTable({
                 "bProcessing": true,
         "serverSide": true,
         "ajax":{
            url :"getContentSmart.php?leavehistory", // json datasource
            type: "post",  // type of method  ,GET/POST/DELETE
            error: function(){
              $("#leave_grid_processing").css("display","none");
            }
          }
        }); 
});
</script>


<link rel="stylesheet" type="text/css" href="../css/jquery.dataTables.min.css"/>
     
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>