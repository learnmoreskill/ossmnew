<!DOCTYPE html>
<html>
<head>
	<title>Add New School</title>

	<?php include_once("common/css_linker.php"); ?>
	<style type="text/css">
		.loaderContainer{
		    position: absolute;
		    width: 100%;
		    height: 100%;
		    z-index: 9;
		}
		.loader{
		    height: 100%;
		    display: flex;
		    background: #2209;
		}
	</style>
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

	  	<main class="mdl-layout__content" style="position: relative;">
	  		<div id="overlayloading" class="loaderContainer" style="display: none">
	  			<div class="loader">
	  				<div style="margin: auto;text-align: center;">
	  					<img src="../images/loading.gif" width="64px" height="64px"  />
	  					<h3 style="color:#fff;margin-top: 10px">Please Wait we are creating new school manager</h3>
	  				</div>
		  		</div>
		  	</div>

    		<div class="page-content"><!-- BODY CONTENT START HERE -->



				<div id="addSchoolDiv" class="mdl-grid">
	    			<form onsubmit="startLoader(event)" action="<?php echo htmlspecialchars('addnewschoolscript.php');?>" method="POST" >
					  <div class="mdl-textfield mdl-js-textfield mdl-cell mdl-cell--8-col">
					    <textarea class="mdl-textfield__input" type="text" rows= "6" id="schoolName" name="schoolName" required placeholder="eg: Nirmal Ganga School" ></textarea>
					    <label class="mdl-textfield__label" for="schoolName">School Name...</label>
					  </div>

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="text" id="schoolAddress" name="schoolAddress" required placeholder="eg: Janakapur" >
					    <label class="mdl-textfield__label" for="schoolAddress">Address</label>
					  </div>


					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="text" id="dbName" name="dbName" required placeholder="eg: demomanager" >
					    <label class="mdl-textfield__label" for="dbName">DB Manager Name...</label>
					  </div>

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="text" id="schoolCode" maxlength="3" name="schoolCode" required placeholder="eg: NSK" >
					    <label class="mdl-textfield__label" for="schoolCode">School Code</label>
					  </div>

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="email" id="principalEmail" name="principalEmail" validate required placeholder="eg: principal@gmail.com" >
					    <label class="mdl-textfield__label" for="principalEmail">Admin/Principal email...</label>
					  </div>

					  <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label mdl-cell mdl-cell--8-col"">
					    <input class="mdl-textfield__input" type="password" id="principalPassword" name="principalPassword" minlength="6" required >
					    <label class="mdl-textfield__label" for="principalPassword">Password</label>
					  </div>


					  <input type="hidden" name="addNewSchool" value="addNewSchool" >

					  <input type="hidden" id="schoolList" name="schoolList">

					  <button disabled id="submitBtn" class="mdl-button mdl-js-button mdl-button--raised mdl-button--accent" >Wait</button>
					</form>					  
					  	
    			</div>
    	
    		</div><!-- BODY CONTENT END HERE -->
  		</main>
  		<footer class="mdl-mini-footer">
  			<?php include_once("common/footer.php"); ?>
  		</footer>

	</div>

	<?php include_once("common/js_linker.php"); ?>

	<script type="text/javascript">

		function startLoader(e){
            $("#overlayloading").show();

		}
			$(document).ready(function(){

				var urls = [];
				var rootRef = firebase.database().ref().child('SchoolList');
			

				var schoolList = document.getElementById("schoolList");
				var submitBtn = document.getElementById("submitBtn");

				rootRef.once('value', function(snapshot) {
					  snapshot.forEach(function(childSnapshot) {

					    var childData = childSnapshot.val();

					    urls.push(childData);

					  });

					  console.log(urls);
					  schoolList.value = JSON.stringify(urls);
					  submitBtn.innerHTML='Ready';
					  submitBtn.removeAttribute('disabled');
					  
					});
			});

		</script>


</body>
</html> 
