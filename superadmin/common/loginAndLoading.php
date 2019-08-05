<dialog id="loginDailog" class="mdl-dialog">
	    <h4 class="mdl-dialog__title">Sign In</h4>
	    <div class="mdl-dialog__content">
	    	<p id="loginError"></p>
	    	<div class="mdl-textfield mdl-js-textfield 
	    		mdl-textfield--floating-label">
			    <input class="mdl-textfield__input" type="text" id="loginEmail">
			    <label class="mdl-textfield__label" for="sample3">Email...</label>
			</div>
			<div class="mdl-textfield mdl-js-textfield 
	    		mdl-textfield--floating-label">
			    <input class="mdl-textfield__input" type="password" id="loginPassword">
			    <label class="mdl-textfield__label" for="sample3">Password...</label>
			</div>
	    
	    </div>
	    <div class="mdl-dialog__actions">
	      	<!-- Colored raised button -->
			<button id="loginBtn" onclick="loginBtnClicked();" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect">Sign In</button>
			<div id="loginProgress" class="mdl-spinner mdl-js-spinner is-active"></div>
	    </div>
	</dialog>



	<div class="login-cover">

		<!-- MDL Spinner Component -->
		<div class="page-loader mdl-spinner mdl-js-spinner is-active"></div>

	</div> 
