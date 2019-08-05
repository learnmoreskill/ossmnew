<html>
	<head>
		 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">

	</head>
	<body>
		<div id="attMonth">
			<h5 class="center">Monthly Attandence report</h5>
			<div class="row">
				<div class="col s4">
					Class: 1 (one) <br>
					section: b (laligurans)
				</div>
				<div class="col s4">
					month:Baishakh <br>
					Class teacher: Anil
					
				</div>
				<div class="col s4">
					Date:<?php echo date("F j, Y, g:i a"); ?> <br>
					
					
				</div>
			</div>
			<button onclick="printTable('attMonth')">Print</button>
			<hr>
			<table class="responsive-table striped">
		        <thead>
		          <tr>
		              <th>Name/Date</th>
		              <?php 
						for ($x = 1; $x <= 32; $x++) {
						    echo "<th>$x</th>";
						} 
						?>
		              <th>1remark</th>

		          </tr>
		        </thead>

		        <tbody>
		        	<?php 
		        	for ($y = 1; $y <= 10; $y++) {
		          echo "<tr><td>Student-$y</td>";
		            
						for ($x = 1; $x <= 32; $x++) {
						if($x % 4 == 0){

							    echo "<th class='red-text text-darken-2'>A</th>";
							}else{
								echo "<td>P</td>";
							}
						} 
		            
		            echo "<td class='blue-text text-darken-2'>10/25</td></tr>";
		        }
						?>

		        </tbody>
		    </table>
		</div>

		<!-- student wise -->
		<div class="attYear">
			<h5 class="center">Yearly student Attandence report</h5>
			<div class="row">
				
				<div class="col s4">
					Name:Guddu kumar <br>
					Roll: 1 (one) 
					
				</div>
				<div class="col s4">
					Class: 1 (one) <br>
					section: b (laligurans)
				</div>
				<div class="col s4">
					Registration no:1269445Add<br>
					Incharge: Krishna mandal
				</div>
			</div>
			<button onclick="printTable('attYear')">Print</button>
			<hr>
			<table class="responsive-table striped">
		        <thead>
		          <tr>
		              <th>month/Date</th>
		              <?php 
						for ($x = 1; $x <= 32; $x++) {
						    echo "<th>$x</th>";
						} 
						?>
		              <th>remark</th>

		          </tr>
		        </thead>

		        <tbody>
		        	<?php 
		        	for ($y = 1; $y <= 12; $y++) {
		          echo "<tr><td>Month-$y</td>";
		            
						for ($x = 1; $x <= 32; $x++) {
						if($x % 4 == 0){

							    echo "<th class='red-text text-darken-2'>A</th>";
							}else{
								echo "<td>P</td>";
							}
						} 
		            
		            echo "<td class='blue-text text-darken-2'>10/25</td></tr>";
		        }
						?>
				<tr style="font-weight: bolder;">
					<td colspan="33" >
						<span class="right" >Total : </span></td>
					<td class='blue-text text-darken-4'> 200/250</td>
				</tr>
		        </tbody>
		    </table>
		</div>
		<script type="text/javascript">
			function printTable(id){
				// var prtContent = document.getElementById(id);
				// var WinPrint = window.open('', '', '');
				// WinPrint.document.write(prtContent.innerHTML);
				// WinPrint.document.close();
				// WinPrint.focus();
				// WinPrint.print();
				// WinPrint.close();

				window.print();
			}
		</script>
	</body>
</html>