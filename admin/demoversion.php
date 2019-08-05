<?php
include('session.php');
?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Upgrade To Pro Version</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                            <div class="col s8 offset-m2 ">
                                <div class="card darken-3">
                                    <div class="card-content center white-text">
                                        <span class="card-title"><span style="color:red;">You are in demo version..</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>

        </main>

<?php include_once("../config/footer.php");?>      
