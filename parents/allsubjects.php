<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'allsubjects';

   $classlist1 = "SELECT * FROM `class` WHERE `status` = 0 ORDER BY `class`.`class_id` ASC";
    $result1 = $db->query($classlist1);

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Classwise Subject List</a></div>
                    </div>
                </div>
            </div>
            <?php
            if ($result1->num_rows > 0) {
                while($classrow1 = $result1->fetch_assoc()) {


                                    $classname2=$classrow1["class_id"];

                                    $subjectlist1 = "SELECT * FROM `subject` WHERE `subject`.`subject_class`='$classname2' AND `subject`.`status`=0 ORDER BY `subject`.`sort_order`";
                                    $resultsubject1 = $db->query($subjectlist1);
                                    if ($resultsubject1->num_rows > 0) {
                                        ?>

                                        <div class="row scrollable">
                                        <div class="col s12"> 
                                            <div class="card teal center lighten-2">
                                            <span class="card-title white-text">Subjects for class:

                                            <?php echo $classrow1["class_name"];?>

                                            </span>
                                        </div>
                                        </div>
                                        </div>


                                        <div class="row">
                                        <div class="col s12 m12">
                                            <table class="centered bordered striped highlight z-depth-4">
                                            <thead>
                                                <tr>
                                                    <th>Subject Name</th>
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
                                        while($subjectrow1 = $resultsubject1->fetch_assoc()) {
                                        ?>


                                        <tr>
                                            <td>
                                                <?php echo $subjectrow1["subject_name"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $subjectrow1["subject_theory"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $subjectrow1["theory_passmark"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $subjectrow1["subject_practical"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $subjectrow1["practical_passmark"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $subjectrow1["total_mark"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $subjectrow1["pass_mark"]; ?>
                                            </td>
                                            <td>
                                                <?php
                                    $subjectname2=$subjectrow1["teacher_id"];
                                    $sqlteachername = "SELECT * FROM `teachers` WHERE `tid`='$subjectname2'";
                                    $teachername2 = $db->query($sqlteachername);
                                    if ($teachername2->num_rows > 0) {
                                      while($rowtname = $teachername2->fetch_assoc()) {
                                        echo $rowtname["tname"];
                                        }
                                    }
                                    ?>
                                            </td>
                                        </tr>
                                        <?php
                                        } ?>

                                        </tbody>
                                        </table>
                                        </div>
                                        </div>
                                        <?php
                                    } else {


                                        
                                }
                            }
                        } else {
                        }
                        ?>

        </main>


        <?php include_once("../config/footer.php");?>
