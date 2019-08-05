<?php
    include('session.php');
    require("../important/backstage.php");

    $backstage = new back_stage_class();


        global $id;
        $id=isset($_REQUEST['id']) ? $_REQUEST['id'] : null;

        $lesson_details = json_decode($backstage->get_planned_lession_by_lesson_id($id));
        

    
    ?>
        <!-- add adminheade.php here -->
        <?php include_once("../config/header.php");?>
        <?php include_once("navbar.php");?>

        <script>
       $(document).ready(function () {
           $('.slider').slider({full_width: true,height:500,});
       });
    </script>
            <main>
                <div class="section no-pad-bot" id="index-banner">
                    <?php include_once("../config/schoolname.php");?>
                    <div class="github-commit">
                        <div class="container">
                            <div class="row center"><a class="white-text text-lighten-4" href="#">Lesson plan detail</a></div>
                        </div>
                    </div>
                </div>
                <!-- guddu design -->               

                <section class = "container" style="width: 95%">              
                    <div class="col s12">
                        <div class="card">
                            <div class="card-content no-padding">
                                <span class="card-title cPadding no-margin grey lighten-4"><b>Planned Lesson</b></span>
                                <hr class="no-margin">                         
                                <div class = "row no-margin">
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Class:</div>
                                            <div class="col s6"><?php echo $lesson_details->class_name; ?></div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Section:</div>
                                            <div class="col s6"><?php echo $lesson_details->section_name; ?></div>
                                        </div>
                                    </div>
                                    <hr>
                                    
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Teacher:</div>
                                            <div class="col s6"><?php echo $lesson_details->tname; ?></div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Subject:</div>
                                            <div class="col s6"><?php echo $lesson_details->subject_name; ?></div>
                                        </div>
                                    </div>
                                    <hr> 
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Topic:</div>
                                            <div class="col s6"><?php echo $lesson_details->topic; ?></div>
                                        </div>
                                    </div>
                                    
                                    
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Assing Date:</div>
                                            <div class="col s6"><?php echo (($login_date_type==2)? eToN(date("Y-m-d", strtotime($lesson_details->assign_date))) : date("Y-m-d", strtotime($lesson_details->assign_date))); ?></div>
                                        </div>
                                    </div>
                                    <hr>

                                    
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Start Date:</div>
                                            <div class="col s6"><?php echo (($login_date_type==2)? eToN($lesson_details->start_date) : $lesson_details->start_date); ?></div>
                                        </div>
                                    </div>
                                    <div class="col s12 m6 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s6 grey-text lighten-5" >Last Date:</div>
                                            <div class="col s6"><?php echo (($login_date_type==2)? eToN($lesson_details->end_date) : $lesson_details->end_date); ?></div>
                                        </div>
                                    </div>
                                    <hr>

                                    <div class="col s12 m12 cPadding">
                                        <div class = "row no-margin">
                                            <div class="col s3 grey-text lighten-5" >Remark:</div>
                                            <div class="col s9"><?php echo $lesson_details->remark; ?></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>                      
                        </div>
                        <p>Topic progress till now<?php if ($lesson_details->percentage ==0) { echo ": Not started yet"; } ?> </p>
                        <div class="progress col s6" style="height: 20px" onload="progressUpdate()">
                            <div id="topicProgress" class="determinate center-align"  >
                                <span id="completedText" style="font-size:0.8em;color:#fff;"></span>
                            </div>
                        </div>
                        <!-- <button onclick="myTimer()">prog</button>
                        <button onclick="myStopFunction()">stop</button> -->

                    </div>
                </section>


                <!-- end guddu desing -->
                <script type="text/javascript">
                    // $(document).ready(function () {
                   var PB=document.getElementById("topicProgress");
                   var CPBText=document.getElementById("completedText");
                   var i=0;
                   var myVar ;
                    myTimer() ;
                   
                    function myTimer() {
                        myVar=setInterval(function(){ 
                            if(i<=<?php echo $lesson_details->percentage; ?>){
                                PB.style.width = (i++)+'%' ;
                                if (i<=15) {
                                    CPBText.innerHTML=PB.style.width;
                                }else{ 
                                CPBText.innerHTML='Completed '+ PB.style.width;
                            }
                                }

                           else if(<?php echo $lesson_details->percentage ?><=0 ){
                                CPBText.innerHTML='0%';
                                }

                            else{
                                myStopFunction();
                            }
                        }, 50);
                    }

                    function myStopFunction() {
                        clearInterval(myVar);
                    }
                </script>

            </main>

    <?php include_once("../config/footer.php");?>