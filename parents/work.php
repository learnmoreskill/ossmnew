<?php
include('session.php');
/*set active navbar session*/
$_SESSION['navactive'] = 'welcome';

include("../important/backstage.php");
$backstage = new back_stage_class();

$students = json_decode($backstage->get_student_details_by_parent_id($login_session1));

?>
    <!-- add header.php here -->
    <?php include_once("../config/header.php");?>
    <?php include_once("navbar.php");?>
    
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <?php include_once("../config/schoolname.php");?>
                <div class="github-commit">
                    <div class="container">
                        <div class="row">
                            <div class="col s12">
                              <ul class="tabs">
                               <li class='tab col s3'><a href='#test1'>Test1</a></li>
                              </ul>
                            </div>
                            <div id="test1" class="col s12" style="color:#000;">Test 1</div>
                            <div id="test2" class="col s12">Test 2</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card">
                        <div class="card-panel purple darken-3">
                            <div class="row">
                                    <div class="col s12 m6">
                            <span class="white-text center-align" style="font-size:30px;font-family:Roboto Condensed, sans-serif;"><?php echo $per_student->sname; ?></span>

                                <div class="card-content white-text flow-text">

                                    <?php if(!empty($per_student->sadmsnno)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Admission number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assignment</i>&nbsp;<?php echo $per_student->sadmsnno; ?></div>
                                        <br><?php } ?>

                                    <?php if(!empty($per_student->sclass)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Class" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">assessment</i>&nbsp; 
                                        <?php echo $per_student->sclass."-".$per_student->ssec;?>
                                    </div><br><?php } ?>

                                    <?php if(!empty($per_student->sroll)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Roll No." style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">list</i>&nbsp;<?php echo $per_student->sroll; ?></div>
                                    <br><?php } ?>

                                    <?php if(!empty($per_student->sex)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Gender" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">wc</i>&nbsp;<?php echo $per_student->sex; ?></div>
                                        <br> <?php } ?>

                                    <?php if(!empty($per_student->dob)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Date Of Birth" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">sentiment_dissatisfied</i>&nbsp;<?php echo $per_student->dob; ?></div>    <br> <?php } ?>

                                    <?php if(!empty($per_student->saddress)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Address" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">home</i>&nbsp;<?php echo $per_student->saddress; ?></div>
                                    <br>    <?php } ?>

                                    <?php if(!empty($per_student->semail)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Email" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">mail</i>&nbsp;<?php echo $per_student->semail; ?></div>
                                    <br>    <?php } ?>

                                    <?php if(!empty($per_student->smobile)){ ?>
                                    <div class="tooltipped" data-position="right" data-delay="50" data-tooltip="Phone Number" style="font-weight: 400;vertical-align:middle; display: inline-flex; padding-bottom: 3px;"><i class="material-icons">tablet_android</i>&nbsp;<?php echo $per_student->smobile; ?></div>
                                        <br>    <?php } ?>


                                        </div>
                                    </div>
                                <div class="col s12 m4 offset-m2">
                                <div class="card-content white-text flow-text">
                                    <div class="card grey darken-2 roundedImage">
                                        <div class="card-image profile-pic ">
                                            <img class="circle responsive-img" src="<?php if(!empty($per_student->simage)){ echo "../uploads/".$fianlsubdomain."/profile_pic/".$per_student->simage; }elseif($per_student->sex=='Male'){ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } elseif($per_student->sex=='Female'){ echo "https://learnmoreskill.github.io/important/dummyprofilefemale.jpg"; }else{ echo "https://learnmoreskill.github.io/important/dummyprofile.jpg"; } ?>" alt="image not avilable"   >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>
                            </div>
                                </div>
                            </div>
                        </div>
            <?php }?>
            
        </main>


        <!-- add footer.php here -->
    <?php include_once("../config/footer.php");?>