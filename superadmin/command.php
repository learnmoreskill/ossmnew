<?php

if ($_SERVER['REQUEST_METHOD']=='POST' && isset($_POST['query'])) {

	$query = $_POST['query'];
	if (!empty($query)) {

		$str = json_decode($_POST['schoolList'], true); 
		
		$db_server = 'localhost';
	   	$db_username = 'hackster';
	   	$db_password = 'krishna$12345';
	   	$resultQ = '';
	   	

		foreach ($str as &$fullurl) {

			$fullurl = strtolower($fullurl);

			$parsedUrl = parse_url($fullurl);

			$host = explode('.', $parsedUrl['host']);

			$subdomainname = $host[0];
	    		

	    	$fianlsubdomain = str_replace("manager", "", $subdomainname);
		   	if(!empty($fianlsubdomain)){
		     	$finaldbname = $fianlsubdomain."db";

		     	//$db_database = 'newossmdb';
	   			$db_database = $finaldbname;

	   			// Create connection
	   			$db = mysqli_connect($db_server,$db_username,$db_password,$db_database);

	   			$ses_sql = mysqli_multi_query($db,$query);

	   			if($ses_sql){
	   				$resultQ .= $db_database.':-success <br>';
	   			}else{
	   				$resultQ .= $db_database.':-'.mysqli_error($db).' <br>';
	   			}

	   			mysqli_close($db);
		     	
		   	}
		}

		echo $resultQ;
		echo "<br><br><a href='command.php' >Go Back</a>";


	}else{
		?> <script> alert('Query is empty'); window.location.href = 'command.php'; </script> <?php
	}


}else{

?>

<!DOCTYPE html>
<html>
<head>
	<title>Run SQL Command</title>

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



    			<div id="addSchoolDiv" class="mdl-grid">
    				<form  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST" >
	    				<!-- Textfield with Floating Label -->
						  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--10-col">
						    <input class="mdl-textfield__input" type="text" id="query" name="query">
						    <label class="mdl-textfield__label" for="query">Enter Query...</label>
						  </div>
						  <input type="hidden" id="schoolList" name="schoolList">

						  	<button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" >Submit</button>
					</form>
					<div class="mdl-cell mdl-cell--12-col">
						<table class="mdl-data-table mdl-js-data-table mdl-shadow--2dp">
						  <thead>
						    <tr>
						      <th>URL</th>
						    </tr>
						  </thead>
						  <tbody id="url_table_body">
						  </tbody>
						</table>
					</div>
    			</div>




    	
    		</div><!-- BODY CONTENT END HERE -->
  		</main>


  		<footer class="mdl-mini-footer">
  			<?php include_once("common/footer.php"); ?>
  		</footer>

	</div>

	<?php include_once("common/js_linker.php"); ?>
		
		<script type="text/javascript">

			firebase.auth().onAuthStateChanged(function(user) {
    			if (user) {
      				//check authority of admin
      				if (user.email.trim()!=='krishnagek@gmail.com'.trim()) {
        				window.location.href = 'hackster.php';
				     } 
				 }  
			}); 



			$(document).ready(function(){

				var urls = [];
				var rootRef = firebase.database().ref().child('SchoolList');
			/*
				rootRef.on("child_added",snap=> {

					var url = snap.val();
					urls.push(url);
					//$("#output").append(  urls );
					
				});
				console.log(urls);*/

				/*for (var i = 0; i < arr.length; i++) {
			    	console.log(arr[i]);
				}*/

				var schoolList = document.getElementById("schoolList");

				rootRef.once('value', function(snapshot) {
					  snapshot.forEach(function(childSnapshot) {

					    var childData = childSnapshot.val();

					    //console.log(childData);

					    urls.push(childData);

					    $("#url_table_body").append("<tr><td>" + childData + "</td></tr>");


					  });

					  console.log(urls);
					  schoolList.value = JSON.stringify(urls);
					  
					});
			});

		</script>
</body>
</html> 
<?php } ?>



