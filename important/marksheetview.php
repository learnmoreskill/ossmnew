<?php
  include('session.php');

  if (isset($_GET["token"])){
      $longid1 = ($_GET["token"]);

    if ($longid1=="3drtgy") {

      $studentid = $_GET["sid"];
      $class_id = $_GET["class_id"];
      $examid = $_GET["eid"];

      $year_id = $_GET["year_id"];
      $month = $_GET["month"];

      $months = array('Baishakh','Jestha','Asar','Shrawan','Bhadau','Aswin','Kartik ','Mansir','Poush','Magh','Falgun','Chaitra'); 

      $sqlstd = "SELECT `studentinfo`.`sname`, `studentinfo`.`sadmsnno`, `marksheet`.`month` , `class`.`class_name`, `section`.`section_name`,`academic_year`.`single_year`  
        FROM `marksheet` 
        INNER JOIN `studentinfo` ON `marksheet`.`mstudent_id` = `studentinfo`.`sid`
        LEFT JOIN `academic_year` ON `marksheet`.`year_id` = `academic_year`.`id` 
        LEFT JOIN `class` ON `marksheet`.`marksheet_class` = `class`.`class_id` 
        LEFT JOIN `section` ON `marksheet`.`marksheet_section` = `section`.`section_id` 
        WHERE `marksheet`.`mexam_id`='$examid' 
          AND `marksheet`.`mstudent_id`='$studentid' 
          AND `marksheet`.`marksheet_class`='$class_id'
          AND `marksheet`.`year_id`='$year_id' 
          AND `marksheet`.`month`='$month' 
        GROUP BY `marksheet`.`mstudent_id` ";
      $resulstd = $db->query($sqlstd);
      $rowstd = $resulstd->fetch_assoc();

      $sqlexm = "SELECT * FROM `examtype` WHERE `examtype_id`='$examid'";
      $resultexm = $db->query($sqlexm);
      $rowexm = $resultexm->fetch_assoc();

      $queryvm = $db->query("SELECT `marksheet`.`marksheet_id`, `marksheet`.`m_theory`, `marksheet`.`m_practical`, `marksheet`.`m_obtained_mark`, `marksheet`.`marksheet_status`, `subject`.`subject_name`, `subject`.`total_mark`, `subject`.`pass_mark`, `subject`.`subject_type` 
        FROM `marksheet` 
        LEFT JOIN `subject` ON `marksheet`.`msubject_id`=`subject`.`subject_id` 
        WHERE `marksheet`.`mexam_id`='$examid' 
          AND `marksheet`.`mstudent_id`='$studentid' 
          AND `marksheet`.`marksheet_class`='$class_id'
          AND `marksheet`.`year_id`='$year_id' 
          AND `marksheet`.`month`='$month'
        ORDER BY `subject`.`sort_order`");
        $rowCount = $queryvm->num_rows;
        if($rowCount > 0) { $found='1';} else{ $found='0';   }

    }
  }
?>
    <!-- add adminheader.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Marksheet</a></div>
                    </div>
                </div>
            </div>

            <?php
            if($found == '1'){
        ?>
        <div id="invoice_print" class="row">
            <div class="col s12 m12">
                          <table class="mb-1 mt-1 highlight z-depth-4">
                                <thead>
                                    <tr><td class="pb-0 pl-3"><strong>Name : </strong><?php echo $rowstd['sname']; ?></td>
                                        <td class="pb-0"><strong>Admission No : </strong><?php echo $rowstd['sadmsnno']; ?></td>
                                    </tr>
                                    <tr>
                                      <td class="pl-3"><strong>Class : </strong><?php echo $rowstd['class_name']." - ".$rowstd['section_name']; ?></td>
                                        <td><strong>Exam : </strong><?php echo $rowexm['examtype_name']; if (!empty($rowstd["month"]) || $rowstd["month"]!=0) { echo ' ( '.$months[$rowstd["month"]-1].' ) '; }
                                          echo '&nbsp'.$rowstd["single_year"];
                                          ?>
                                        </td>
                                    </tr>
                                </thead>
                          </table>
                            <table class="centered bordered highlight z-depth-4">
                                <thead>
                                    <tr><th>Subject Name</th>
                                        <th>Full Mark</th>
                                        <th>Pass Mark</th>
                                        <th>Th. mark</th>
                                        <th>Prc. mark</th>
                                        <th>Total Obtained</th>

                                        <?php if ($login_cat ==1 || $login_cat ==2 || $pac['edit_mark']){ ?>
                                        <th>Status</th>
                                        <?php } if ($login_cat ==1 || $pac['edit_mark']){ ?>
                                        <th>Edit</th>
                                        <?php }?>

                                        

                                    </tr>
                                </thead>
                                <?php while($row = $queryvm->fetch_assoc()){ ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row["subject_name"];?>
                                                        <input type="hidden" id="<?php echo $row["marksheet_id"];?>" value="<?php echo $row["subject_name"];?>">
                                                    </td>
                                                    <td>
                                                        <?php //for subject type 3
                                                        if ($row["subject_type"]==3){
                                                        }else{
                                                          echo $row["total_mark"]; 
                                                        } ?>
                                                    </td>
                                                    <td>
                                                        <?php //for subject type 3
                                                        if ($row["subject_type"]==3){
                                                        }else{
                                                         echo $row["pass_mark"]; 
                                                        } ?>
                                                    </td>

                                                    <td>
                                                        <?php //for subject type 3 
                                                        if ($row["subject_type"]==3){ 
                                                        }else if(!empty($row["m_theory"])){echo $row["m_theory"];}else{ echo "-"; } ?>
                                                        <input type="hidden" id="c<?php echo $row["marksheet_id"];?>" value="<?php echo $row["m_theory"]; ?>">
                                                    </td>
                                                    <td>
                                                        <?php //for subject type 3 
                                                        if ($row["subject_type"]==3){ 
                                                        }else if(!empty($row["m_practical"])){echo $row["m_practical"];}else{ echo "-"; } ?>
                                                        <input type="hidden" id="d<?php echo $row["marksheet_id"];?>" value="<?php echo $row["m_practical"];  ?>">
                                                    </td>
                                                    <td>
                                                        <?php //for subject type 3
                                                        if ($row["subject_type"]==3){ 
                                                          echo $row["m_obtained_mark"];
                                                        }else{
                                                          if(!empty($row["m_obtained_mark"])){echo $row["m_obtained_mark"];}else{ echo "-"; } 
                                                        } ?>

                                                          <input type="hidden" id="e<?php echo $row["marksheet_id"];?>" value="<?php echo $row["m_obtained_mark"]; ?>" >
                                                          
                                                          <input type="hidden" id="f<?php echo $row["marksheet_id"];?>" value="<?php echo $row["subject_type"];?>">

                                                    
                                                    </td>

                                                    <?php if ($login_cat ==1 || $login_cat ==2 || $pac['edit_mark']){ ?>

                                                    <td <?php echo (($row["marksheet_status"] == 0)? "class='green-text'" : (($row["marksheet_status"] == 1)? "class='red-text'" : "" ) ); ?> >

                                                      <?php echo (($row["marksheet_status"] == 0)? "published" : (($row["marksheet_status"] == 1)? "not yet published" : "" ) ); ?>
                                                    </td>

                                                      <?php } if ($login_cat ==1 || $pac['edit_mark']){ ?>
                                                    <td>

                                                      <a class="modal-trigger" id="<?php echo $row["marksheet_id"];?>" onClick="set_variable(this.id)" href="#modal1"><i class="material-icons green-text text-lighten-1">edit</i></a>
                                                    </td>
                                                    <?php } ?>
                                                </tr>
                                                <?php } ?>
                                        </table>  
                                        <?php if ($login_cat ==1  || $pac['view_mark'] || $pac['edit_mark']){ ?>
                                          <br>
                                          <div class="center">
                                            <form action="reportforclass.php" method="post">
                                              <input type="hidden" name="template" value="999">
                                              <input type="hidden" name="student[]" value="<?php echo $studentid; ?>">
                                              <input type="hidden" name="class_id" value="<?php echo $class_id; ?>">
                                              <input type="hidden" name="examtypeid" value="<?php echo $examid; ?>">
                                              <input type="hidden" name="m04x20" value="<?php echo $month; ?>">
                                              <input type="hidden" name="y04x20" value="<?php echo $year_id; ?>">
                                              <button class="btn waves-effect waves-light pink lighten-2" type="submit" >Generate Report Card
                                                  <i class="material-icons right">send</i>
                                              </button>
                                            </form>
                                          </div><br>
                                    <?php } ?>
                                </div>
                            </div>
                    <?php
                    } else if($found == '0') { 
                    ?>
                        <div class="row">
                            <div class="col s12 m12">
                                <div class="card grey darken-3">
                                    <div class="card-content white-text center">
                                        <span class="card-title"><span style="color:#80ceff;">No Marks Details Found!!</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>




</main>
<?php include_once("../config/footer.php");?>