<div id="advancePayModal" class="modal fade " aria-hidden="true" tabindex="-1" role="dialog" aria-labelledby="viewModalLabel">
    <div class="modal-dialog ">
        <div class="modal-content" >
              <!-- header -->
              <div class="modal-header" style="padding: 10px">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> <i class="fas fa-piggy-bank"></i> Advance pay</h4>
              </div>
              <!-- body -->
            <form role="form" id="advPayForm" name="advPayForm" class="form-horizontal"  method="post" onsubmit ="submitAdvance(event,this)">

              	<div class="modal-body" >
                  <div class="form-group col-sm-12">
                  	<label class='radio-inline'><input type='radio' name='advPaymentMode' checked value='cash'>Cash</label>
			        <label class='radio-inline'><input type='radio' name='advPaymentMode' value='cheque'>Cheque</label>
			        <label class='radio-inline'><input type='radio' name='advPaymentMode' value='bank'>Bank</label>
		        </div>
		        <span id='advPayment_ref'>
			   </span>
		     	<div class="form-group">
			      	<label class="control-label col-sm-3" for="advAmount">Advance amount:</label>
			      	<div class="col-sm-9">
				        <input type="number" class="form-control" id="advAmount" placeholder="Enter amount" name="advAmount" required min="0">
			      	</div>
			    </div>
          <div class="form-group">
              <label class="control-label col-sm-3" for="advReceivedFrom">Received from:</label>
              <div class="col-sm-9">
                <input type="text" class="form-control" id="advReceivedFrom" placeholder="Enter name" name="advReceivedFrom" required>
              </div>
          </div>
              </div>
              <!-- footer -->
              <div class="modal-footer">
                <button class="btn btn-primary  pull-right" id="submitBtn" type="submit" > Pay Advance</button>

                <div id="loadingBtn" style="display: none; margin-right: 20px;"><img src="../images/loading.gif" width="30px" height="30px"/></div>
              </div>
            </form>
              
        </div>

    </div>
</div>
<script type="text/javascript">
	function submitAdvance(e,data){
		var advData= $( data ).serializeArray() ;
		var formData = new FormData(data);
		//console.log("form data",formData);
		formData.append("dueBefore",parseInt(document.getElementById('total_balance').innerHTML));
		formData.append("advanceBefore",parseInt(document.getElementById('advPaid').innerHTML));
		e.preventDefault();
		//debugger;

		$.ajax
		    ({
		          url: "../student/student_submit_management.php?advancePaymentForStudent=<?php echo $student_id; ?>",
		          type: "POST",
		          data:  formData,
		          contentType: false,
		          cache: false,
		          processData:false,

		          beforeSend : function()
		          {
		          
		            $("#err").fadeOut();
		            $("#submitBtn").hide();
            		$("#loadingBtn").show();
		          },
		          success: function(data)
		          {
		            //debugger;
		            console.log(data);

		            var result = JSON.parse(data);

		            if (result.status == 200) {

		            	
		            
		            	var t=document.getElementById('advPaid');
		            	var tp = document.getElementById('total_payable');

		            	var aap=parseInt(t.innerHTML);
		            	var acp=parseInt(document.getElementById('advAmount').value);


		            	var pAmnt=parseInt(t.innerHTML);

		            	t.innerHTML=(aap+acp);

		            	tp.innerHTML = (parseInt(tp.innerHTML)-acp);


		            	//debugger;
		            	$('#advancePayModal').modal('hide');
		            	document.getElementById("advPayForm").reset();
		            	$("#advPayment_ref").empty();


		            	var a=confirm("Payment successfully done.\nDo you want to print the receipt as well?");
			              if(a){
			                printExternal('../school/cashReceipt.php?advance_pay_receipt=<?php echo $student_id; ?>&bill_id='+result.bill_id);
			                //debugger;
			                //location.reload();
			              }

		            	//debugger;
		            }else{
		            	alert(result.errormsg);
		            }

		            $("#submitBtn").show();
            		$("#loadingBtn").hide();
		            
		          },
		          error: function(e) 
		          {
		            alert('Sorry Try Again !!');
		            $("#submitBtn").show();
            		$("#loadingBtn").hide();
		          }          
		    });



	}
	$('input[type=radio][name=advPaymentMode]').change(function() {
        var payDiv=document.getElementById('advPayment_ref');
        if (this.value != 'cash') {
           // payDiv.style.display = 'inline-flex';
           $("#advPayment_ref").empty();
            var txt1 = "<div class='form-group'><label class='control-label col-sm-3' for='advanceRef'>Refrence No:</label><div class='col-sm-9'><input type='text' class='form-control' id='advanceRef' placeholder='Enter refrence no...' name='advanceRef' required></div></div>"+
            "<div class='form-group'><label class='control-label col-sm-3' for='advBank'>Bank Name:</label><div class='col-sm-9'><input type='text' class='form-control' id='advBank' placeholder='Enter bank name...' name='advBank' required></div></div>";    
            $("#advPayment_ref").append(txt1);
        }
        else {
           // payDiv.style.display = 'none';
           $("#advPayment_ref").empty();

        }
    });
</script>