<?php
   include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'mtpsearch';

    if($_SERVER["REQUEST_METHOD"] == "GET") {

        $mysearch = mysqli_real_escape_string($db,$_GET['searchname']);
        //$searchclass = mysqli_real_escape_string($db,$_POST['classsearch']);
        //$searchsection = mysqli_real_escape_string($db,$_POST['sectionsearch']);
        if (!empty($mysearch)) {

            $query = $db->query("SELECT `studentinfo`.`sid`, `studentinfo`.`sname`, `studentinfo`.`sroll`, `class`.`class_name`, `section`.`section_name` 
                FROM `studentinfo`
                LEFT JOIN `class` ON `studentinfo`.`sclass`=`class`.`class_id` 
                LEFT JOIN `section` ON `studentinfo`.`ssec`=`section`.`section_id`
                WHERE `studentinfo`.`status`= 0 AND `studentinfo`.`sname` LIKE '$mysearch%' 
                ORDER BY `studentinfo`.`sroll` ASC");
            $rowCount = $query->num_rows;
            if($rowCount > 0) { $found='1';} else{ $found='0';   }
        }
    }
?>
        <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    
            <main>
                <div class="section no-pad-bot" id="index-banner">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Message To Parents</a></div>
                    </div>
                    <div class="github-commit">
                        <div class="container">
                            <div class="row center"><a class="white-text text-lighten-4">Search</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m12">
                        <div class="card grey darken-3">
                            <div class="card-content white-text flow-text">
                                <span class="card-title flow-text"><span style="color:#008eef;">Search Student</span></span>
                                <div class="row">
                                    <form class="col s12" action="" method="get">
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="searchname" name="searchname" type="text" autofocus class="validate" required>
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
                        <div class="col s12 m6">
                                    <div class="container">
                                        <table class="centered bordered highlight z-depth-4">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Class</th>
                                                    <th>Roll No.</th>                                                   
                                                    <th>Action</th>
                                                </tr>
                                            </thead>

                                            <?php while($row = $query->fetch_assoc()){ ?>
                                                <tr>
                                                    <td>
                                                        <?php echo $row["sname"];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["class_name"]."-".$row["section_name"];?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row["sroll"];?>
                                                    </td>
                                                    <td>
                                                       <a href="mtpmsg.php?token=2ec9ys77bi89s9&key=<?php echo "ae25nj5s3fr596dg@".$row["sid"]; ?>&name=<?php echo $row["sname"]; ?>&class=<?php echo $row["class_name"]."-".$row["section_name"]; ?>&roll=<?php echo $row["sroll"]; ?>"> <button class="btn waves-effect waves-light blue lighten-2"><i class="material-icons right">send</i></button></a>
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
                            <div class="col s12 m6">
                                <div class="card grey darken-3">
                                    <div class="card-content white-text">
                                        <span class="card-title"><span style="color:#ff8a65;">No results found</span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

            </main>


            <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>