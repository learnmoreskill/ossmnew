<?php
include('session.php');
$token=$_GET["token"];
?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Gallery</a></div>
                    </div>
                </div>
            </div>

            <?php include_once("../gallery/detail2.php");?>
        </main>

<?php include_once("../config/footer.php");?>      
