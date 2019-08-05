

<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<?php
include('../session.php');

$class_details = json_decode($account->get_class_details());
$feetype_details = json_decode($account->get_feetype_details());
$extra_fee_details = json_decode($account->get_extra_fee_type_list());
?>
<body>
  
<?php include('../config/sidebar.php'); ?>


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
        
                         

<form id='form' method="post" name="extra_fee_collection_form">
  <div class="form-row">
    <div class="form-group">
      <label for="inputState">Class Name</label>
      <select id="inputState" class="form-control" name="class_name">
          <option selected>Choose...</option>
        <?php
            foreach ($class_details as $key) 
            {
                echo"<option>".$key->class_name."</option>";
            }
        ?>
      </select>
    </div>

     <div class="form-group">
      <label for="inputState">Fee Category</label>
      <select onchange='OnSelectionChange (this)' id="inputState" class="form-control" name="fee_category">
          <option selected>Choose...</option>
            <?php
            foreach ($feetype_details as $key) 
            {
                if($key->feetype_title=='Tution Fee' || $key->feetype_title=='Hostel Fee' || $key->feetype_title=='Bus Fee' || $key->feetype_title=='Computer Fee')
                  {}
                else
                {
                  echo"<option>".$key->feetype_title."</option>";
                }

            }


        ?>
      </select>
    </div>
    
    
    <div class="form-group">
      <label for="inputCity">Amount</label>
      <input id='amount' type="text" class="form-control"  name="fee_amount" placeholder="Example :2000"  >
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
                                <td>".$key->className."</td>
                                <td>".$account->get_feetype_by_feetype_id($key->feeTypeId)."</td>
                                <td>".$key->amount."</td>
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
<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
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
  
  $("#form").on('submit',(function(e) 
  {
     
     
    e.preventDefault();
    $.ajax
    ({
          url: "../student/student_submit_management.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#err").fadeOut(1000);
            //$('.loader').attr('hidden', false);
          },
          success: function(data)
          {
            //alert('Sucessfully Add To Student Account !!');
            alert(data);
            location.reload();

            

          },
          error: function(e) 
          {
            $("#err").html(e).fadeIn(1000);
          }          
    });
  }));
  
});

</script>
<script type="text/javascript">
function OnSelectionChange (select)
{
  var selectedOption = select.options[select.selectedIndex].value;
  var className = extra_fee_collection_form.class_name.value;
 
  $.ajax({
    method: "get",
    url: '../student/get_class_fee.php?className='+className+'&fee_type='+selectedOption,
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
<style>
.loader {
  display: none;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid blue;
  border-right: 16px solid green;
  border-bottom: 16px solid red;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
</body>
</html>
