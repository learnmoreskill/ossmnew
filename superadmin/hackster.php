<!DOCTYPE html>
<html>
<head>

	<?php include_once("common/title.php"); ?>

	<?php include_once("common/css_linker.php"); ?>
	
</head>
<body>

	<!-- LOGIN DAILOG -->

	<?php include_once("common/loginAndLoading.php"); ?>


	<!-- MAIN PHASE CONTENT -->

	<div class="mdl-layout mdl-js-layout">
	  
    	<!-- INCLUDE NAVBAR -->
  		<?php include_once("common/header.php"); ?>
  

  		<!-- INCLUDE NAVBAR -->
  		<?php include_once("common/navbar.php"); ?>

	  	<main class="mdl-layout__content">
    		<div class="page-content"><!-- BODY CONTENT START HERE -->




    			<!-- SCHOOL LIST DETAILS HERE START -->
    			<div id="schoolListTableDiv">
    				<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
					  <thead>
					    <tr>
					      <th>SN</th>
					      <th>School Name</th>
					      <th>URL</th>
					      <th>Action</th>
					    </tr>
					  </thead>
					  <tbody id="table_body">
					</table>
    			</div>





    	
    		</div><!-- BODY CONTENT END HERE -->
  		</main>
  		<footer class="mdl-mini-footer">
  			<?php include_once("common/footer.php"); ?>
  		</footer>

	</div>

	<?php include_once("common/js_linker.php"); ?>
		

		<script src="js/dashboard.js"></script>

</body>
</html>