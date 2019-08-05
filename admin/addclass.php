<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'addclass';

  require("../important/backstage.php");
  $backstage = new back_stage_class();

  
  $classListDetails = json_decode($backstage->get_class_list_details_by_year_id($current_year_session_id));
  $rowCount = count((array)$classListDetails);
  if($rowCount > 0) { $found='1';} else{ $found='0'; }



?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Add Class</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form id="add_class_form" class="col s12" action="addscript.php" method="post" >

                    <div class="row">
                        <div class="input-field col s6 m6">
                          <input name="classname" id="classname" type="text" placeholder="e.g. Five" class="validate" autofocus required>
                          <label for="classname">Class Name</label>
                        </div>
                        

                        <div class="input-field col s3 m4">
                          <input name="classsymbolic" id="classsymbolic" type="number" placeholder="e.g. 5" class="validate" autofocus required>
                          <label for="classsymbolic">Class In Numeric</label>
                        </div>

                        <div class="input-field col s3 m2">
                          <input name="sort_order" id="sort_order" type="number" placeholder="e.g. 5" min="0" max="99" value="0" class="validate" autofocus required>
                          <label for="sort_order">Sort Order</label>
                        </div>
                        
                        <div class="input-field col s6 m6">
                          <input name="classadmission" id="classadmission" type="text" placeholder="e.g. 500" class="validate" autofocus>
                          <label for="classadmission">Admission Charge</label>
                        </div>

                        <div class="input-field col s6 m3">
                          <input name="registrationfee" id="registrationfee" type="text" placeholder="e.g. 500" class="validate">
                          <label for="registrationfee">Registration Fee</label>
                        </div>

                        <div class="input-field col s6 m3">
                          <input name="securityfee" id="securityfee" type="text" placeholder="e.g. 500" class="validate">
                          <label for="securityfee">Security Fee</label>
                        </div>

                    </div>
                    <div class="row">
                      <div class="input-field col s6 m3">
                          <input name="monthy_tution_fee" id="monthy_tution_fee" type="text" placeholder="e.g. 2000" class="validate">
                          <label for="monthy_tution_fee">Monthly Tution fee</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="annual_fee" id="annual_fee" type="text" placeholder="e.g. 1000" >
                          <label for="annual_fee">Annual fee</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="computer_fee" id="computer_fee" type="text" placeholder="e.g. 1000" >
                          <label for="computer_fee">Computer fee</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="hostel_fee" id="hostel_fee" type="text" placeholder="e.g. 1000" >
                          <label for="hostel_fee">Hostel fee</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s6 m3">
                          <input name="exam_fee" id="exam_fee" type="text" placeholder="e.g. 1000" >
                          <label for="exam_fee">Exam fee</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="monthly_test_fee" id="monthly_test_fee" type="text" placeholder="e.g. 1000" >
                          <label for="monthly_test_fee">Monthly test fee</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="uniform_fee" id="uniform_fee" type="text" placeholder="e.g. 1000" >
                          <label for="uniform_fee">Uniform fee</label>
                        </div>
                        <div class="input-field col s6 m3">
                          <input name="book_fee" id="book_fee" type="text" placeholder="e.g. 1000" >
                          <label for="book_fee">Book fee</label>
                        </div>
                    </div>
                

                    <div class="row">
                      <input type="hidden" name="add_class_request" value="add_class_request" >
                      <input type="hidden" name="year_id" value="<?php echo $current_year_session_id; ?>" >

                        <div class="input-field col offset-m10">
                             <button class="btn waves-effect waves-light" type="submit" name="add_class">Submit
                                <i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>

                </form>
            </div>


            <?php
            if($found == '1'){
                            ?>
            <div class="row">
                <div class="col s6 offset-m2">                    
                    <table class="centered bordered striped highlight z-depth-4">
                        <thead>
                            <tr>
                                <th>Already existing class name (<?php echo $current_year_session; ?>)</th>
                                <th>Numeric name</th>
                                <th>Sort order</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($classListDetails as $classList) { ?>
                                <tr>
                                    <td>
                                      <a href="classdetails.php?token=tyughjo56&class_id=<?php echo $classList->class_id; ?>&class_name=<?php echo $classList->class_name; ?>"><?php echo $classList->class_name; ?></a>
                                    </td>
                                    <td>
                                        <?php echo $classList->class_symbolic; ?>
                                    </td>
                                    <td>
                                        <?php echo $classList->sort_order; ?>
                                    </td>
                                </tr>
                            <?php 
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <?php
            } else if($found == '0') { ?>
            <div class="row">
                <div class="col s6 offset-m2 ">
                    <div class="card darken-3">
                        <div class="card-content center white-text">
                            <span class="card-title"><span style="color:red;">No Any Classes Added At</span></span>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>

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

<script>
$(document).ready(function (e) 
{
  $("#add_class_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "addscript.php",
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
            if ((data.indexOf("Class added successfully"))<0) {

              Materialize.toast(data, 4000, 'red rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              });
            }else if ((data.indexOf("Class added successfully"))>=0) {

                window.location.reload();
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
