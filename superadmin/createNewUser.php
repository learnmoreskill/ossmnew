<!DOCTYPE html>
<html>
<head>
	<title>Welcome to A1pathshala</title>

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



    			<div id="createNewUserDiv" class="mdl-grid">

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="text" id="newemail" name="newemail" placeholder="eg: example@gmail.com" >
					    <label class="mdl-textfield__label" for="newemail">Email id...</label>
					  </div>

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="password" id="newpw" name="newpw" placeholder="eg: ******" >
					    <label class="mdl-textfield__label" for="newpw">Password...</label>
					  </div>
					  

					  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="createNewUser();" >Create</button>
		
    			</div>





    	
    		</div><!-- BODY CONTENT END HERE -->
  		</main>

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

			function createNewUser(){

				var newemail = document.getElementById("newemail").value;
				var newpw = document.getElementById("newpw").value;

				  firebase.auth().createUserWithEmailAndPassword(newemail, newpw).catch(function(error) {
					  // Handle Errors here.
					  var errorCode = error.code;
					  var errorMessage = error.message;

					  window.alert("Error : " + errorMessage);
					  // ...
					});
			}			
		</script>

</body>
</html>