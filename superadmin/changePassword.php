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



    			<div id="currentEmail"></div>
    			<div id="changeEmailDiv" class="mdl-grid">

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="text" id="newemail" name="newemail" placeholder="eg: example@gmail.com" >
					    <label class="mdl-textfield__label" for="newemail">Email id...</label>
					  </div>

					  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="updateEmail();" >Update</button>
		
    			</div>

    			<div id="changePasswordDiv" class="mdl-grid">

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="password" id="newpw" name="newpw" placeholder="eg: ******" >
					    <label class="mdl-textfield__label" for="newpw">Password...</label>
					  </div>

					  <button class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" onclick="updatePassword();" >Update</button>
		
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

				    var user = firebase.auth().currentUser;

				    if(user != null){

				      var email_id = user.email;
				      document.getElementById("currentEmail").innerHTML = email_id;



				    }

				  }
				});

				function updateEmail(){

					var newemail = document.getElementById("newemail").value;

					var user = firebase.auth().currentUser;

					user.updateEmail(newemail).then(function() {
					  window.alert('Email updated');
					  firebase.auth().signOut();
					}).catch(function(error) {
					  window.alert(error);
					});

				}
				function updatePassword(){

					var newpw = document.getElementById("newpw").value;

					var user = firebase.auth().currentUser;

					user.updatePassword(newpw).then(function() {
					  window.alert('Password updated');
					  firebase.auth().signOut();
					}).catch(function(error) {
					  window.alert(error);
					});

				}
				
	</script>
		
</body>
</html>