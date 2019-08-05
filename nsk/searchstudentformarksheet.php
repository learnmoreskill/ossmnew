<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'searchstudentformarksheet';

?>
    <?php  
		
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        
        $mysearch = mysqli_real_escape_string($db,$_GET['searchname']);
        
        if (!empty($mysearch)) {
        //or this query
        $query = $db->query("SELECT `studentinfo`.*, `class`.`class_name`, `section`.`section_name`, `parents`.`parent_id`, `parents`.`spname`, `parents`.`smname` 
            FROM `studentinfo` 
            LEFT JOIN `class` ON `studentinfo`.`sclass` = `class`.`class_id`
            LEFT JOIN `section` ON `studentinfo`.`ssec` = `section`.`section_id` 
            LEFT JOIN `parents` ON `studentinfo`.`sparent_id`=`parents`.`parent_id` 
            WHERE `studentinfo`.`sname` LIKE '$mysearch%' ORDER BY `studentinfo`.`sname` ASC LIMIT 20");
        $rowCount = $query->num_rows;
        if($rowCount > 0) { $found='1';} else{ $found='0';   } 
    }
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
                            <div class="row center"><a class="white-text text-lighten-4">Search student</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey darken-3">
                            <div class="card-content white-text">
                                <span class="card-title flow-text"><span style="color:#009fff;">Search</span></span>
                                <div class="row">
                                    <form class="col s12" action="" method="get">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="searchname" name="searchname" type="text" class="validate" autofocus required>
                                                <label for="searchname">Name</label>
                                            </div>
                                        </div>
                                        
                                        <button class="btn waves-effect waves-light blue lighten-2" type="submit"><i class="material-icons right">search</i>Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <?php
                        if($found == '1'){
                            ?>
                    <div class="row">
                        <div class="col s12 m12">
                                    <div class="container">
                                        <table class="centered bordered highlight z-depth-4">
                                            <thead>
                                                <tr><th>Admision No</th>
                                                    <th>Name</th>
                                                    <th>Class</th>
                                                    <th>Roll No.</th>
                                                    <th>Gender</th>
                                                    <th>DOB</th>
                                                    <th>Parent</th>
                                                    <th>View Marks</th>
                                                </tr>
                                            </thead>

                                            <?php while($row = $query->fetch_assoc()){ ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row["sadmsnno"];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["sname"];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["class_name"]."-".$row["section_name"];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["sroll"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["sex"]; ?>
                                                    </td>
                                                    <td>
                                                        <?php echo (($login_date_type==2)? eToN($row["dob"]) : $row["dob"]); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["spname"];?>
                                                    </td>
                                                    <td>
                                                       <a href="viewmarksheet.php?token=2ec9ys77bi89s9&key=<?php echo "ae25nj5s3fr596dg@".$row["sid"]; ?>"><div class="tooltipped" data-position="right" data-delay="50" data-tooltip="markshet of student" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons orange-text text-lighten-1">timeline</i></div></a>


                                                    </td>
                                                </tr>
                                                <?php } ?>
                                        </table>

                                    </div>
                                </div>
                            </div>
                    <?php
                                            } else if($found == '0') { ?>
                        <div class="row">
                            <div class="col s12 m12">
                                <div class="card grey center darken-3">
                                    <div class="card-content white-text">
                                        <span class="card-title"><span style="color:#80ceff;">No results found</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

            </main>


            <?php include_once("../config/footer.php");?>
