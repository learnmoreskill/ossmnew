<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php'); 
require('../head.php');
require('../header.php');
?>
<?php

$class_details = json_decode($account->get_class_details());
$feetype_details = json_decode($account->get_feetype_details());
$extra_fee_details = json_decode($account->get_extra_fee_type_list());

?>
<body>
  <style>
  #preventer {
    width: 100%;
    height: 100%;
    position: fixed;
    background: rgba(12,25,56,0.6);
    color: red;
    line-height: 600px;
    vertical-align: middle;
    text-align: center;
    font-size: 22px;
    font-weight: 700;
    z-index: +9999999;
    display: none;
  }
</style>
  
<?php include('../config/navbar.php'); ?>
<div id="preventer">
  Please Wait
</div>

    <section id="main-content">
    	<section class="wrapper">
             <div class="col-md-4" id='insert_exam_type_details'>
            <div class='form-w3layouts'>
            <div class="row">
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading" style='font-size:17px;'>
                          Add Extra Fee
                        </header>
                        <div class="panel-body">
        
                         

<form id='Form1' method="post" name="extra_fee_collection_form">
  <div class="form-row">
    <div class="form-group">
      <label for="inputState">Class Name</label>
      <select id="inputState" class="form-control" name="class_id">
          <option value="" selected>Choose...</option>
        <?php
            foreach ($class_details as $key) {
                echo"<option value='".$key->class_id."' >".$key->class_name."</option>";
            }
        ?>
      </select>
    </div>

     <div class="form-group">
      <label for="inputState">Fee Category</label>
      <select onchange='OnSelectionChange (this)' id="inputState" class="form-control" name="feetype_id">
          <option value="" selected >Choose...</option>
            <?php
            foreach ($feetype_details as $key) 
            {
                if($key->feetype_title=='Tution Fee' || $key->feetype_title=='Hostel Fee' || $key->feetype_title=='Bus Fee' || $key->feetype_title=='Computer Fee'){

                }else{
                  echo "<option value='".$key->feetype_id."' >".$key->feetype_title."</option>";
                }

            }


        ?>
      </select>
    </div>
    
    
    <div class="form-group">
      <label for="inputCity">Amount</label>
      <input id='inputCity' type="number" class="form-control"  name="fee_amount" min="0" required placeholder="Example :2000"  >
    </div>

    <div class="form-group">
      <label for="description">Description</label>
      <textarea id='description' class="form-control" rows="5"  name="description"  ></textarea>
    </div>
    
    <div class="form-group col-md-12">
       <button type="submit" name="addexpenses" class="btn btn-primary" style="float: right;">Add</button>
    </div>
    <!-- <div class="loader" id="loader">Loading</div> -->
    
</form>


                        </div>
                    </section>
                </div>
            </div>
            </div>
            </div>

            <div class="col-md-8" id='load_book_list_details'>
              <div class="panel panel-default">
                    <div class="panel-heading" >
                      Fee Type Record
                    </div>
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable' class="table table-striped b-t b-light">
                            <thead>
                                
                                  <th scope="col">S.N.</th>
                                  <th scope="col">Class Name</th>
                                  <th scope="col">Fee Type</th>
                                  <th scope="col">Amount</th>
                                  <th scope="col">Description</th>
                                  <th scope="col">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                              <?php 
                              $sn = 0;
                              foreach ($extra_fee_details as $key) 
                              {
                                $sn++;
                                echo "<tr>
                                <td>".$sn."</td>
                                <td>".$key->class_name."</td>
                                <td>".$key->feetype_title."</td>
                                <td>".$key->amount."</td>
                                <td>".$key->description."</td>
                                <td>".$key->date."</td>
                                </tr>
                                ";
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>

      
                
            </div>
           
    	</section>
    </section>

</section>


<?php require('../modelprint.php'); ?>


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

<script>
$(document).ready(function (e) 
{
  
  $("#Form1").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "../student/student_submit_management.php?add_extra_fee=add_extra_fee",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            //$("#err").fadeOut(1000);
            $('#preventer').show();
          },
          success: function(data)
          {
            if (data.trim()=='Extra fee added successfully'.trim()) {
              alert(data);
            location.reload();
          }else{
            alert(data);
            $("#err").html(e).fadeIn(500);$('#preventer').hide();
          }

          },
          error: function(e) 
          {
            $("#err").html(e).fadeIn(1000);$('#preventer').hide();

          }          
    });
  }));
  
});

</script>
<script type="text/javascript">
function OnSelectionChange (select)
{
  var selectedOption = select.options[select.selectedIndex].innerHTML;
  var classId = extra_fee_collection_form.class_id.value;
 debugger;
  $.ajax({
    method: "get",
    url: '../student/get_class_fee.php?classId='+classId+'&fee_type='+selectedOption,
    contentType: false,
    cache: false,
    processData:false,
  })
    .done(function( msg ) 
    {
     // alert(msg);
      $('#amount').val(msg);
      //$('#amount').prop('readonly', true);
    });   
}

</script>
<script type="text/javascript">
  $(document).ready(function() {
   
    $('#amount').on('input', function() {

      var row = $(this).closest("extra_fee_collection_form");
      var amount = $('#amount').val();
    if(isNaN(amount))
    {
      alert(amount + " is not a number ");
      $('#amount').val('')
    }
    
    });
  });
</script> 
</body>
</html>
