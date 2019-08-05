<?php
require("account_management.php");
$account = new account_management_classes();
//$data_tables = json_decode($account->get_data_from_table_by_table_name());

if(isset($_GET['table_name']) && !empty($_GET['table_name']))
 {
  $id = $_GET['table_name'];
  // echo $id;
  $d=mysqli_connect('localhost','root','root','accountant');
  

  	$qry = "SHOW COLUMNS FROM".' '.$id;
  	$qry1 = "SELECT * FROM `$id`";
  	// echo $qry1;

  $result=mysqli_query($d,$qry);
  $result1=mysqli_query($d,$qry1);
 }

?>
<script type="text/javascript">
    loadScript();
</script>

<div class="modal-header"> 
  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 
  <h4 class="modal-title">Export Table</h4> 
</div>
<div class="modal-body" style="background: #fff;">
	<div id="" class="scrollable" style="overflow: auto;">
	  	<table id='export_Table' class="table table-responsive b-t b-light display">
		    <thead>
		      <tr>
		    	<?php
		    	$a=array();
	  			while($row = mysqli_fetch_object($result)){
	  				array_push($a,$row->Field);
	  				echo '<th>'.$row->Field .'</th>';

	  			}
	  			echo " Table Name : $id ";
	  			?>    
		      </tr>
		    </thead>
		    <tbody>
		       	<?php
	  			while($row = mysqli_fetch_array($result1)){
		  		echo "<tr>";
	  			foreach ($a as $value){
		  		echo '<td>'.$row[$value] .'</td>';
		  		}
		  		echo "</tr>";
				}
	  			?>   
		    </tbody>
	  	</table>
  	</div>
</div>
<div class="modal-footer" style="background: #fff;"> 
  <button type="button" class="btn btn-danger" data-dismiss="modal" style="float:right; background-color:#d9534f;border-color: #d43f3a; color:#fff;">Close</button> 
</div>

