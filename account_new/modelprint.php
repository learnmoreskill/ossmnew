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
                    echo "<option value='".$key->class_id."' >".$key->class_name."</option>";
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

<script>
    function create_receipt_by_class(url)
{
// var className = create_due_form.className.value;
var className = $("[name='className']").val();

var url = url+'?classId='+className;
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
    // var className = create_due_form.className.value;
var className = $("[name='className']").val();
    //alert(className);
    var url = url+'?classId='+className;
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