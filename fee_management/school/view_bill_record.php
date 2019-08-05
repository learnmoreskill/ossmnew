<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php');
include('../load_backstage.php');
require('../head.php');
require('../header.php');
?>
<body>
    
<?php include('../config/navbar.php'); ?>

<section id="main-content">
    <section class="wrapper" style="width:95%;margin:100px 25px 0px;">
    	<div class=" panel panel-default">
    <div class="panel-heading"> 
   		Generate Bill
    </div>
	<div style="padding: 15px;width:50%;">
		<form name='bill_print_form'><!-- 
            <div class="form-group">
                <label >Select</label>
                <select class="form-control" name='type'>
                	<option value="student">Student</option>
                	<option value="teacher">Teacher</option>
                	
                </select>
            </div> -->
            <div class="form-group">
                <label >Bill Number</label>
             <input type="text" class="form-control"  placeholder="Example; GB-49" style="color:black;" name='bill_number'>
            </div>

                <div class="form-group">
              
                <input onclick="create_bill()" readonly="true" class="btn btn-primary" value="Create" style="width:100px   ;">
                </div>
            
            </form>
	       </div>
        </div>    
    </section>
</section>
<script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/jquery-1.8.3.min.js"></script>
    <script src="../assets/js/jquery.cookie.js"></script>

    <script src="../assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="../assets/js/jquery.scrollTo.min.js"></script>
    <script src="../assets/js/common-scripts.js"></script>
    <script type="text/javascript">
    	function create_bill()
    	{
    		//var type = bill_print_form.type.value;
    		var bill_number = bill_print_form.bill_number.value;
           var url = 'bill_print_format.php?bill_number='+bill_number;
           var printWindow = window.open(url, 'Print', '');
            printWindow.addEventListener('load', function(){
                printWindow.print();
                printWindow.close();
            }, true);
    		
    	}
    </script>
</body>
</html>
