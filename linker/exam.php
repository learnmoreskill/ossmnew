<?php
//for all
   include('session.php');
   require("../important/backstage.php");
   $backstage = new back_stage_class();

/*set active navbar session*/
$_SESSION['navactive'] = 'exam';

$year_id = $current_year_session_id;

$classList= json_decode($backstage->get_class_list_by_year_id($year_id));


$found='0';
$months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra');

?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Exam Details</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m12">
                    <table class="centered bordered striped highlight z-depth-4">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Exam Name</th>
                            <th>Exam Start Date</th>
                            <th>View</th>
                        </tr>
                    </thead>                                            
                                    <?php
                                    foreach ($classList as $clist) {

                                        $examtypelist2 = "SELECT * FROM `examtype` ORDER BY `examtype`.`examtype_id` ASC ";
                                        $result2 = $db->query($examtypelist2);

                                        if ($result2->num_rows > 0) {
                                        while($examtyperow2 = $result2->fetch_assoc()) {


                                    $class_id=$clist->class_id;
                                    $exam_id=$examtyperow2["examtype_id"];

                                    $examlist1 = "SELECT MIN(`examtable`.`date`) AS `date`,`class`.`class_id`, `class`.`class_name`, `examtype`.`examtype_id`, `examtype`.`examtype_name`,`examtable`.`year_id`,`examtable`.`month`
                                        FROM `examtable` 
                                        LEFT JOIN `class` ON `examtable`.`class_name` = `class`.`class_id` 
                                        LEFT JOIN `examtype` ON `examtable`.`exam_type` = `examtype`.`examtype_id` 
                                        WHERE `examtable`.`class_name`='$class_id' AND `examtable`.`exam_type`='$exam_id'
                                          GROUP BY `examtable`.`year_id`,`examtable`.`month`
                                        ";

                                    $resultexam1 = $db->query($examlist1);
                                    if ($resultexam1->num_rows > 0) {
                                        while($examrow1 = $resultexam1->fetch_assoc()) {
                                        ?>
                                        <tbody>
                                        <tr>
                                            <td>
                                                <?php echo $examrow1["class_name"]; ?>
                                            </td>
                                            <td>
                                                <?php echo $examrow1["examtype_name"];
                                                if (!empty($examrow1["month"]) || $examrow1["month"]!=0) { echo ' ( '.$months[$examrow1["month"]-1].' ) '; } ?>
                                            </td>
                                            <td>
                                                <?php echo (($login_date_type==2)? eToN($examrow1["date"]) : $examrow1["date"]); ?>
                                            </td>
                                            <td>
                                                <form action="examtable.php" method="get" >
                                                    <input name="postcname_id"  type="hidden" value="<?php echo $examrow1["class_id"];?>">
                                                    <input name="postetype_id"  type="hidden" value="<?php echo $examrow1["examtype_id"];?>">
                                                    <input name="year_id"  type="hidden" value="<?php echo $examrow1["year_id"];?>">
                                                    <input name="month"  type="hidden" value="<?php echo $examrow1["month"];?>">
                                                    <button class="btn waves-effect waves-light blue lighten-2" type="submit" name="view_examtable" value="viewNSK">view
                                                    <i class="material-icons left">view_list</i>
                                                  </button>
                                              </form>
                                            </td>

                                        </tr>
                                        </tbody>
                                        <?php
                                        }
                                        $found='1';
                                        }
                            }
                        }
                    }
                
                                        ?>
                        </table>
                        </div>
                        </div>



                        <?php if($found != '1') { ?>
                <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">Exam schedule is not published yet !!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>







        </main>

<?php include_once("../config/footer.php");?>

<?php 
  if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }

?>
