<?php
include('session.php');

$sqltr1 = "select * from troutine where trtid='$login_session1'";
    $resulttr1 = $db->query($sqltr1);
?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">Red-Title-Here</a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Grey-Title-Here</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    
                            </div>
                        </div>   
            
        </main>


        <?php include_once("../config/footer.php");?>