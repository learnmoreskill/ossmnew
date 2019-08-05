<?php
	include("session.php");
	require("account_management.php");
	$account=new account_management_classes();
	$tables=json_decode($account->get_list_of_tables_from_database());
?>


<!DOCTYPE html>
<html>
<head>
	<title>Export DataTables</title>
</head>
<body>
<b>Datatables</b>
	
<!-- <?php
foreach ($tables as $key)
 {
	echo $key->table_name."</br>";
 }

?> -->
<style type="text/css">
	table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
</style>
<table style="width:100%;border:2px solid black">
  <tr>
    <th>Table Name</th>
    <th>Export Options</th> 
  </tr>
  <?php
  	foreach ($tables as $key) {
  	echo "
  	<tr>
  		<td>".$key->table_name."</td>
  		";
  		?>
  		<td><a href="">PDF</a><a href=""> | Excel Sheet</a><a href=""> | XML</a> </td>
  	</tr>
  	<?php
  	}
  
  ?>
</table>


</body>
</html>