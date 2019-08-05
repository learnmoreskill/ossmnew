<?php
    include('session.php');
    
    require("../important/backstage.php");
    $backstage = new back_stage_class();

   /*set active navbar session*/
$_SESSION['navactive'] = 'subjects';


    $subjectlist = json_decode($backstage->get_subject_details_by_class_id($login_class_id));
    
    if (count((array)$subjectlist)){ $found='1';} else{ $found='0';   }

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Subjects</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12"> 
                    <div class="card teal center lighten-2">
                        <span class="card-title white-text">Subjects for class:<?php echo $login_session12;?></span>
                    </div>
                </div>
            </div>
            <?php 
            if($found == '1'){
            ?>

            <div class="row">
                <div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4">
                        <thead>
                            <tr><th>Subject Name</th>
                                <th>Theoretical Mark</th>
                                <th>Th Pass Mark</th>
                                <th>Practical Mark</th>
                                <th>Pr Pass Mark</th>
                                <th>Full Mark</th>
                                <th>Pass Mark</th>
                                <th>Subject's Teacher</th>
                            </tr>
                        </thead>
                        <tbody>


                                        <?php                               
                                        foreach ($subjectlist as $sublist) {
                                        ?>


                                        <tr>
                                            <td>
                                                <?php echo $sublist->subject_name; ?>
                                            </td>
                                            <td>
                                                <?php echo $sublist->subject_theory; ?>
                                            </td>
                                            <td>
                                                <?php echo $sublist->theory_passmark; ?>
                                            </td>
                                            <td>
                                                <?php echo $sublist->subject_practical; ?>
                                            </td>
                                            <td>
                                                <?php echo $sublist->practical_passmark; ?>
                                            </td>
                                            <td>
                                                <?php echo $sublist->total_mark; ?>
                                            </td>
                                            <td>
                                                <?php echo $sublist->pass_mark; ?>
                                            </td>
                                            <td>
                                                <?php echo $sublist->tname; ?>
                                            </td>
                                        </tr>

                                        <?php
                                        } ?>                                        
                                       
                                        </tbody>
                                        </table>
                                        </div>
                                        </div>
            <?php
            } else if($found == '0') { ?>
            <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">No Subjects Found !!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>

        </main>
<?php include_once("../config/footer.php");?>
