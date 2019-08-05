<?php
    include('session.php');

    require("../important/backstage.php");
    $backstage = new back_stage_class();

   /*set active navbar session*/
$_SESSION['navactive'] = 'allteacher';

    $teacherlist = json_decode($backstage->get_teacher_details());
    
    if (count((array)$teacherlist)){ $found='1';    } else{ $found='0';   }

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">All teacher's info</a></div>
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
                            <tr>
                                <th>Teacher name</th>
                                <th>Class Teacher of:</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach ($teacherlist as $teachlist) {    ?>
                                <tr>
                                    <td>
                                        <?php echo $teachlist->tname; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $sectionClass = json_decode($backstage->get_class_section_by_teacher_id($teachlist->tid));
                                        foreach ($sectionClass as $classTecher) {
                                            echo $classTecher->class_name.'-'.$classTecher->section_name."&nbsp&nbsp&nbsp&nbsp";
                                        } ?>
                                    </td>
                                </tr>
                            <?php 
                            }   ?>
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
                                <span class="card-title"><span style="color:#80ceff;">Teachers List Is Empty !!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
        </main>

<?php include_once("../config/footer.php");?>
