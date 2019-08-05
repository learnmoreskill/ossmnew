<!DOCTYPE html>
<html lang="en">
<?php
require('../head.php');
require('../header.php');
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<?php
include('../session.php');
$student_details = json_decode($account->get_inactive_student_details());
$class_details = json_decode($account->get_class_details());


?>
<body>

<?php include('../config/sidebar.php'); ?>

    <section id="main-content">
        <section class="wrapper">
             <div class="table-agile-info" id='load_edit_teacher_record'>

                <div class="panel panel-default">
                    <div class="panel-heading" >
                      Inactive Student Record Details
                    </div>
                    <!-- <div class="col-md-12" style="padding: 5px;float: right;">

                     <a onclick="printExternal('../student/create_pending_receipt.php')" class="btn btn-primary" style="float: right;"  >Create inactive student Receipt </a>

                    </div> -->
                    <div class="table-responsive" style='padding: 10px;'>
                        <table id='studentDetailsTable'   class="table table-striped b-t b-light display">
                            <thead>
                                <tr>
                                  <th scope="col">S.N.</th>
                                  <th scope="col">Student Name</th>
                                  <th scope="col">Admission No</th>
                                  <th scope="col">class</th>
                                 <th scope="col">Section</th>
                                  <th scope="col">Parent Name</th>
                                  <th scope="col">Phone number</th>
                                  <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn=0;

                                foreach($student_details as $key)
                                {
                                    $sn++;
                                    echo "<tr>
                                            <td>".$sn."</td>
                                            <td>".$key->sname."</td>
                                            <td>".$key->sadmsnno."</td>
                                            <td>".$key->class_name."</td>
                                            <td>".$key->section_name."</td>
                                            <td>".$key->spname."</td>
                                            <td>".$key->spnumber."</td>
                                            <td>  <a href='../student/fee-collection.php?student_id=".$key->sid."' class='btn btn-primary'  data-toggle='tooltip' title='' data-original-title='Edit'> <i class='fa  fa-usd'></i> collect</a></td>
                                    </tr>";
                                }
                                ?>

                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
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
    


<div id="viewModal" class="modal fade" aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog" style="margin-left:35%;margin-top: 10%;width:40%; ">
        <div class="modal-content">
          <div class="modal-body" style="padding: 0">
           <form id='form' method='post'  name="create_due_form">

              <div class="modal-header" style="">  
                     <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
                     <h4 class="modal-title">
                     <i class="glyphicon glyphicon-user"></i>Create student due receipt and ledger
                     </h4> 
              </div> 
              <div class="col-md-12" style="margin-top: 20px;">
                <div class="form-group">
                  <label>Class Name</label>
                  <select name="className" class="form-control">
                    <option>Select class name</option>
                  <?php
                  foreach ($class_details as $key) 
                  {
                    echo "<option>".$key->class_name."</option>";
                  }
                  ?>
                  </select>
                </div>
              </div>
              <div class="modal-footer"> 
                  <!-- <input readonly="true" onclick="create_receipt_by_class('../student/create_pending_receipt_by_class.php')" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;width:150px;" name="add_salary" value="Create Receipt"> -->
                  
                   <button type="button" onclick="create_receipt_by_class('../student/create_pending_receipt_by_class.php')" class="btn btn-success">Create Receipt</button>
                  <!-- <input readonly="true" onclick="create_receipt_by_class('../student/horizontal_ledger.php')" class="btn btn-info pull-right" style="color: #fff;background-color: #009688;border-color: #46b8da;width:150px;" name="add_salary" value="Create ladger"> -->
                  <button type="button" onclick="create_receipt_by_class('../student/horizontal_ledger.php')" class="btn btn-success">Create ladger</button>
                 <!--  <input readonly="true" onclick="create_ledger_by_class('../student/create_pending_ladger_by_class.php')" class="btn btn-info pull-right" style="width:150px;color: #fff;background-color: #009688;border-color: #46b8da;margin-right: 10px;" name="add_salary" value="Vertical ladger"> -->
                  <button type="button" onclick="create_ledger_by_class('../student/create_pending_ladger_by_class.php')" class="btn btn-success">Vertical ladger</button>
          </div> 
      </form>
   </div>
        </div>
    </div>
</div>
    

<script type="text/javascript">
    $(document).ready(function() 
    {
        $('#studentDetailsTable').DataTable({
             
        });
    });
</script>
<script>
function printExternal(url) 
{
    if(confirm('Are you sure to create due receipt?'))
    {
        var printWindow = window.open(url, 'Print', '');
         printWindow.addEventListener('load', function(){
             printWindow.print();
             printWindow.close();
         }, true);
    }
  
}
function create_receipt_by_class(url)
{
var className = create_due_form.className.value;
var url = url+'?className='+className;
    if(className=='Select class name')
    {
      alert('Please select class name')

    }
    else
    {
      var printWindow = window.open(url, 'Print', '');
      printWindow.addEventListener('load', function(){
             printWindow.print();
             printWindow.close();
         }, true);
    }
}

function create_ledger_by_class(url)
{
    var className = create_due_form.className.value;
    var url = url+'?className='+className;
    if(className=='Select class name')
    {
      alert('Please select class name')

    }
    else
    {
    var printWindow = window.open(url, 'Print', '');
             printWindow.addEventListener('load', function(){
                 printWindow.print();
                 printWindow.close();
             }, true);
    }
}

</script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script>
loadScript();
</script>

</body>
</html>
