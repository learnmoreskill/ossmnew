<?php
include('session.php');

$sqlclass = "select * from class";
    $resultclass = $db->query($sqlclass);


?>
    <!-- add adminheade.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>

    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Add Section</a></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <form class="col s12" action="addsectionscript.php" method="post" >


                    <div class="row">
                        <div class="col s12 m12">
                            <div class="input-field col s12">
                                <!-- <form method="post" action="feereportscript.php?e5s8cvd5sd5=<?php echo $subject; ?>&q7v7s1xv5=<?php echo $clockon;?>&q7v7mdmd5=<?php echo $mydatemy;?>"> -->
                                <select name="classname" id="rolls" required>
                                    <option value="" disabled>Select class</option>

                                          <?php if ($resultclass->num_rows > 0) {
                                              while($row = $resultclass->fetch_assoc()) { ?>
                                                      <option value="<?php echo $row["class_name"];?>"><?php echo $row["class_name"];?></option>
                                          <?php 
                                          }
                                          } 
                                          ?>

                                </select>
                                    <label>Select Class</label>
                            </div>
                        </div>
                    </div>
                <div class="row">
                       <div class="col s12 m12">
                        Select one or multiple section for this class:<br/>
                      </div>
                  </div>

                    <div class="row">
                <div class="col s12 m12">
                    <div class="input-field col s12">
                        <!-- <form method="post" action="feereportscript.php?e5s8cvd5sd5=<?php echo $subject; ?>&q7v7s1xv5=<?php echo $clockon;?>&q7v7mdmd5=<?php echo $mydatemy;?>"> -->
                        <select multiple name="test[]" id="rolls" required>
                            <option value="" disabled>Select Section</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                            <option value="D">D</option>
                            <option value="E">E</option>
                            <option value="F">F</option>
                            <option value="G">G</option>
                            <option value="H">H</option>
                            <option value="I">I</option>
                            <option value="J">J</option>
                            <option value="K">K</option>
                            <option value="L">L</option>
                            <option value="M">M</option>
                            <option value="N">N</option>
                            <option value="O">O</option>

                        </select>
                            <label>Add Section</label>
                    </div>
                </div>
            </div>
                    
                    <div class="row">
                        <div class="input-field col offset-m10">
                             <button class="btn waves-effect waves-light" type="submit" name="add_section">Submit
                                <i class="material-icons right">send</i>
                              </button>
                            </div>

                    </div>

                </form>
            </div>        

        </main>
        


<?php include_once("../config/footer.php");?>      
