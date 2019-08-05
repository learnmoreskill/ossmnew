<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'resultview';

        $currentclass=$login_session12;
        $shortid=$login_session1;

        //class status not required to check
        $sqlclass1 = "SELECT * FROM `class` ORDER BY `class`.`class_id` DESC";
        $resultclass1 = $db->query($sqlclass1);
        $found='0';

        $months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra');

    ?>
  <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">View Self Report Card</a></div>
                    </div>
                </div>
            </div>
            <?php 
            if ($resultclass1->num_rows > 0) {
                while($rowclass1 = $resultclass1->fetch_assoc()) {

                $class_id=$rowclass1["class_id"];

                $sqlmark1 = "SELECT * FROM `marksheet` WHERE `mstudent_id`='$shortid' AND `marksheet_class`='$class_id' AND `marksheet_status` = 0";
                $resultmark1 = $db->query($sqlmark1);
                if ($resultmark1->num_rows > 0) {
                 ?>
                 <div class="row">
                    <div class="col s12"> 
                        <div class="card teal center lighten-2">
                            <span class="card-title white-text">Marksheet for class:<?php echo $rowclass1["class_name"];?> is available</span>                        
                        </div>

                    <?php
                    $sqlexam = "SELECT * FROM `examtype` ORDER BY `examtype_id` DESC";
                    $resultexam1 = $db->query($sqlexam);
                    if ($resultexam1->num_rows > 0) {
                        while($rowexam1 = $resultexam1->fetch_assoc()) {

                            $examid=$rowexam1["examtype_id"];
                            $examname=$rowexam1["examtype_name"];

                            $sqlmark2 = "SELECT `marksheet`.`mstudent_id`,`marksheet`.`year_id`,`marksheet`.`month`,`marksheet`.`marksheet_class`,`academic_year`.`single_year` 
                                FROM `marksheet`
                                LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 
                                WHERE `mstudent_id`='$shortid' 
                                    AND `marksheet_class`='$class_id' 
                                    AND `mexam_id`='$examid' 
                                    AND `marksheet_status` = 0 
                                GROUP BY `year_id`,`month`,`mexam_id` 
                                ORDER BY `month` DESC ";
                            $resultmark2 = $db->query($sqlmark2);
                            if ($resultmark2->num_rows > 0) {


                                while($rowmark2 = $resultmark2->fetch_assoc()) { ?>
                                    <div class="row center mb-0">
                                        <a class="col s12 m6 offset-m3 btn waves-effect waves-light blue lighten-2" href="marksheet.php?token=3drtgy&sid=<?php echo $rowmark2["mstudent_id"]; ?>&eid=<?php echo $examid; ?>&year_id=<?php echo $rowmark2["year_id"]; ?>&month=<?php echo $rowmark2["month"]; ?>&class_id=<?php echo $rowmark2["marksheet_class"]; ?>">
                                            <?php echo $examname; if (!empty($rowmark2["month"]) || $rowmark2["month"]!=0) { echo ' ( '.$months[$rowmark2["month"]-1].' ) '; }  ?> Marksheet
                                        </a>
                                    </div><br>
                                <?php } ?>

                                    
                    <?php } 
                }
            }?>
                    </div>
                    </div>
                <?php
                $found='1';
            }
            }
        }
            ?>
            <?php if($found != '1') { ?>
                <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-panel grey darken-3">
                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;">Report Card</span>
                                <div class="card-content white-text flow-text">
                            All the best for exams, Results will soon be available to you for <?php echo $login_session12; ?> class.
                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php } ?>
        </main>
<?php include_once("../config/footer.php"); ?>