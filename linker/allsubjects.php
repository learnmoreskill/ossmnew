<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'allsubjects';

    require("../important/backstage.php");
    $backstage = new back_stage_class();

    $year_id = $current_year_session_id;
    $classList= json_decode($backstage->get_class_list_by_year_id($year_id));
    $classListCount = count((array)$classList);

    $subjectFound = 0;

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php"); ?>
    <?php include_once("navbar.php");   ?>

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
            if ($classListCount > 0) {
                foreach ($classList as $class) {

                    $subjectListDetails = json_decode($backstage->get_subject_list_details_by_class_id_year_id($class->class_id,$year_id));
                    $subjectListCount = count((array)$subjectListDetails);

                    
                    if ($subjectListCount > 0) { $subjectFound=1; ?>

                        <div class="row">
                            <div class="col s12"> 
                                <div class="card teal center lighten-2">
                                    <span class="card-title white-text">Subjects for class:
                                        <?php echo $class->class_name;?>
                                    </span>
                                </div>
                            </div>
                        </div>


                        <div class="row scrollable">
                            <div class="col s12 m12">
                                <table class="centered bordered striped highlight z-depth-4">
                                    <thead>
                                        <tr>
                                            <th>Subject Name</th>
                                            <th>Major/Minor</th>
                                            <th>Subject Type</th>
                                            <th>Subject's Teacher</th>

                                            <?php if ($login_cat ===1 || $login_cat ===2 || $pac['edit_subject']) { ?>
                                            <th>Sort Order</th>
                                                <?php } ?>
                                                <?php if ($login_cat ===1 || $pac['edit_subject']) { ?>
                                            <th>Action</th>
                                                <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($subjectListDetails as $subject) {  ?>

                                            <tr>
                                                <td>
                                                    <?php echo $subject->subject_name; ?>
                                                </td>
                                                <td>
                                                    <?php echo (($subject->major==1)? 'Major': (($subject->major==2)? 'Minor': '') ); ?>
                                                </td>
                                                <td>
                                                    <?php echo (($subject->subject_type==0)? 'Theory': (($subject->subject_type==1)? 'Theory+Practical': (($subject->subject_type==3)? 'Grade': '')) ); ?>
                                                </td>
                                                <td>
                                                <?php

                                                $teacherInfo = json_decode($backstage->get_teacher_name_by_teacher_id($subject->teacher_id));

                                                echo $teacherInfo->teacher_name;
                                                   
                                                if ($login_cat ===1 || $login_cat ===2  || $pac['edit_subject']) { ?>
                                                    <td><?php echo $subject->sort_order; ?></td>
                                                    <?php 
                                                } ?>


                                                </td>
                                                    <?php 
                                                if ($login_cat ===1  || $pac['edit_subject']) { ?>
                                                    <td>
                                                        <a href="addsubject.php?token=2ec9yStrw89s9&key=<?php echo "ae25nJ5s3fr596dge@".$subject->subject_id; ?>">
                                                        <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                                                                <i class="material-icons green-text text-lighten-1">edit</i></div></a>

                                                        <a href="deleteuserscript.php?token=7subjectthcv4g&key=<?php echo "ae25nJ5s3fr596dg@".$subject->subject_id; ?>" onclick = "if (! confirm('Are you sure want to delete?')) { return false; }"> 
                                                        <div class="tooltipped" data-position="left" data-delay="50" data-tooltip="delete" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;">
                                                                <i class="material-icons red-text text-darken-4">delete</i></div></a> 
                                                    </td>
                                                        <?php 
                                                } ?>
                                            </tr>
                                                <?php
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php
                    }
                }

                if (!$subjectFound) { ?>

                    <div class="row">
                        <div class="col s12"> 
                            <div class="card red center lighten-2">
                                <span class="card-title white-text">
                                    Subject list is empty
                                </span>
                            </div>
                        </div>
                    </div>
                <?php 
                }


            } else { ?>

                <div class="row">
                    <div class="col s12"> 
                        <div class="card red center lighten-2">
                            <span class="card-title white-text">
                                Class list is empty
                            </span>
                        </div>
                    </div>
                </div>
                <?php

            }   ?>

        </main>


<?php include_once("../config/footer.php");?>
