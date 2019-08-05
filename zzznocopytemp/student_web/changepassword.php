<?php
   include('ssession.php');
?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("../smart/navbarstudent.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">School Management</a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Change Password</a></div>
                    </div>
                </div>
            </div>  

 <div class="row">
<div class="col m6 offset-m3">
          <div class="card white darken-3 cardcenter" style="margin-top: 80px;">
            <div class="card-content black-text">
             <span class="card-title"><span style="color:#008ee6;">Change your password</span></span>
                <form name="frmChange" action="changepasswordscript.php" method="post" >
                  <div class="row">
                    <div class="input-field">
                      <input name="newpassword" type="password" class="validate" placeholder="New Password" >
                    </div>
                   </div>
                   <div class="row"> 
                    <div class="input-field">
                      <input name="confirmnewpassword" type="password" class="validate" placeholder="Confirm New Password" >
                    </div>
                    </div>
                    <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                  </button>
                </form>   
            </div>
        </div>
        </div>
    </div>             
        </main>


         <!-- add header.php here -->
    <?php include_once("../config/footer.php");?>