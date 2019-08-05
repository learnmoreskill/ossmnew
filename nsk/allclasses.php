<?php
   include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'allclasses';

   require("../important/backstage.php");
   $backstage = new back_stage_class();

   $year_id = $current_year_session_id;
   $classdetails= json_decode($backstage->get_class_list_details_by_year_id($year_id));


?>
    <!-- add adminheade.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

    <main>
        <div class="section no-pad-bot" id="index-banner">
            <?php include_once("../config/schoolname.php");?>
            <div class="github-commit">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">Classes List</a></div>
                </div>
            </div>
        </div>
        <div class="row">
                        
        <?php
            foreach ($classdetails as $cdetails) { ?>

            <div class="col s6 m4"><a href="classdetails.php?token=tyughjo56&class_id=<?php echo $cdetails->class_id; ?>&class_name=<?php echo $cdetails->class_name;?>">
              <div class="card blue-grey darken-1" style="height: 220px">
                <div class="card-content white-text">
                  <span class="card-title">Class: <?php echo $cdetails->class_name; ?></span>
                  <p>
                    <?php  $class_id=$cdetails->class_id;

                    $sqlsectionlist = "SELECT * FROM `section` WHERE `section_class`='$class_id' AND `section`.`status` = 0 ORDER BY `section`.`section_name` ASC ";


                    $list1 = $db->query($sqlsectionlist);
                    if ($list1->num_rows > 0) { echo "Section Available:";
                      while($row1 = $list1->fetch_assoc()) {
                        echo $row1["section_name"]."\t";
                        }
                    }else{ echo "<br>";}
                    ?></p>
                </div>
                <div class="card-action">
                  <a href="#">Total Student:
                    <?php $class_id=$cdetails->class_id;
                   $studentcountinclass = $backstage->get_student_count_in_class($class_id);
                   echo $studentcountinclass; ?>
                   </a>
                  <!-- <a href="#">Total Section:5</a> -->
                </div>
              </div></a>
            </div>
        <?php  }  ?>
               
    </div>
        
        </main>


<?php include_once("../config/footer.php");?>
