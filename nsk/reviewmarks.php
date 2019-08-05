    <?php
    include('session.php');

    $sqlallclass = "SELECT * FROM class ORDER BY `class`.`class_id` ASC ";
    $resultallclass1 = $db->query($sqlallclass);

    $sqlexam = "SELECT * FROM `examtype`";
    $resultexam = $db->query($sqlexam);

    $sqlstudent = "SELECT * FROM `studentinfo` LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` WHERE `studentinfo`.`sclass`='$login_session9' AND `studentinfo`.`ssec`='$login_session10' AND `studentinfo`.`status`=0";
    $resultstudent = $db->query($sqlstudent);

    ?>
    <?php  
        
    if($_SERVER["REQUEST_METHOD"] == "POST") { 
        
        $vmexamid = mysqli_real_escape_string($db,$_POST['examid']);
        $vmstudid = mysqli_real_escape_string($db,$_POST['studentid']);
        $vmclass = $login_session9;
        $vmsec = $login_session10;


       
        $queryvm = $db->query("SELECT * FROM marksheet WHERE mexam_id='$vmexamid' AND mstudent_id='$vmstudid' AND marksheet_class='$vmclass' AND marksheet_section='$vmsec'");
        $rowCount = $queryvm->num_rows;
        if($rowCount > 0) { $found='1';} else{ $found='0';   } 
        }
    ?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    <main>
        <div class="section no-pad-bot" id="index-banner">
            <?php include_once("../config/schoolname.php");?>
            <div class="github-commit">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">Student Marks for Class:<?php echo $login_session9." sec:".$login_session10;?></a></div>
                </div>
            </div>
        </div>
        <div class="row">
            <form class="col s12" action="" method="post" >
                <div class="row">
                        <div class="col s12">
                            <div class="input-field col s12">
                                <select name="examid" id="examid" required>
                                    <option value="" disabled>Select exam</option>
                                          <?php if ($resultexam->num_rows > 0) {
                                              while($row1 = $resultexam->fetch_assoc()) { ?>
                                                      <option value="<?php echo $row1["examtype_id"];?>"><?php echo $row1["examtype_name"];?></option>
                                                      <?php 
                                                      }
                                                      }
                                                      ?>

                                </select>
                                    <label>Select Exam</label>
                            </div>
                        </div>
                </div>
                <div class="row">
                        <div class="col s12 m12">
                            <div class="input-field col s12">
                                <select name="studentid" id="studentid" required>
                                    <option value="" disabled>Select student</option>
                                          <?php if ($resultstudent->num_rows > 0) {
                                              while($row2 = $resultstudent->fetch_assoc()) { ?>
                                                      <option value="<?php echo $row2["sid"];?>">Roll no:<?php echo $row2["sroll"]."&nbsp &nbsp &nbsp Name:".$row2["sname"]."&nbsp &nbsp &nbsp Parent:".$row2["spname"];?></option>
                                                          <?php 
                                                          }
                                                          } 
                                                          ?>

                                </select>
                                    <label>Select Student</label>
                            </div>
                        </div>
                </div>

                <div class="row">
                    <div class="input-field col offset-m10">
                         <button class="btn waves-effect waves-light blue lighten-2" type="submit" name="action">Submit
                            <i class="material-icons right">send</i>
                          </button>
                        </div>

                </div>
            </form>
        </div>

        <?php
            if($found == '1'){
        ?>
        <div class="row">
            <div class="col s12 m12">
                        <div class="container">
                            <table class="centered bordered highlight z-depth-4">
                                <thead>
                                    <tr><th>Subject Name</th>
                                        <th>Total Mark</th>
                                        <th>Obtained Mark</th>
                                        <th>Edit</th>
                                    </tr>
                                </thead>
                                <?php while($row = $queryvm->fetch_assoc()){ ?>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $subjectid1=$row["msubject_id"];
                                                        $sqlsubject1 = "select * from subject where subject_id='$subjectid1'";
                                                        $resultsubject = $db->query($sqlsubject1);
                                                        if ($resultsubject->num_rows > 0) {
                                                            while($row3 = $resultsubject->fetch_assoc()) {
                                                                echo $row3["subject_name"];
                                                            }
                                                        }?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["total_mark"];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["obtained_mark"];?>
                                                    </td>
                                                    <td>
                                                        <a href="editmark.php?token=2ec9ys77bi89s9&key=<?php echo "ae25nj5s3fr596dg@".$row["marksheet_id"]; ?>"><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="edit" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons green-text text-lighten-1">edit</i></div></a>
                                                    </td>
                                                    <td>
                                                </tr>
                                                <?php } ?>
                                        </table>

                                    </div>
                                </div>
                            </div>
                    <?php
                    } else if($found == '0') { 
                    ?>
                        <div class="row">
                            <div class="col s12 m6">
                                <div class="card grey darken-3">
                                    <div class="card-content white-text">
                                        <span class="card-title"><span style="color:#80ceff;">No Marks Details Found!!</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

          
</main>


<?php include_once("../config/footer.php");?>
