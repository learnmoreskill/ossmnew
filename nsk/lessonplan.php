<?php
include('session.php');
   /*set active navbar session*/
$_SESSION['navactive'] = 'lessonplan';

include("../important/backstage.php");
   $backstage = new back_stage_class();

   $planned_lession = json_decode($backstage->get_planned_lession_by_teacher_id($login_session1));
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
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Lesson plan</a></div>
                    </div>
                </div>
            </div>
            <?php if (count((array)$planned_lession)) { ?>

            <div class = "row">              
              <div class="col s12">

                    <div class="card">
                      <div class="card-content no-padding">
                        <div class="card-title no-margin grey lighten-4">
                        	<b class="col m12 center"> Update your progress</b>
                        	<!-- <div class="row no-margin">
                        		<div class="col m3 right-align">
	                    			<input type="checkbox" id="showAll" />
						      		      <label for="showAll">Show All</label>
	                    		</div>
                        	</div> -->
                    		
                        </div>
                            <div class = "row scrollable">
                              <div class="col s12">
                              <table class="striped">
                                <thead>
                                  <tr>
                                      <th>class/sec</th>
                                      <th>Sub</th>
                                      <th>Topic</th>
                                      <th>Assigned by</th>
                                      <th>Assigned date</th>
                                      <th>Finish by</th>
                                      <th>Remark</th>
                                      <th style="min-width: 63px">Update progress</th>

                                  </tr>
                                </thead>

                                <tbody>
                                   
                                  <?php foreach ($planned_lession as $lession) { ?>
                                    <form id="update_lesson_planning_form<?php echo $lession->id;?>"  method="POST" >
                                        <tr id="LP<?php echo $lession->id; ?>">
                                                <td><?php echo $lession->class_name."-".$lession->section_name; ?></td>
                                                <td><?php echo $lession->subject_name; ?></td>
                                                <td><?php echo $lession->topic; ?></td>
                                                <td><?php echo $lession->pname; ?></td>
                                                <td><?php echo (($login_date_type==2)? eToN(date('Y-m-d', strtotime($lession->assign_date))) : date('Y-m-d', strtotime($lession->assign_date))); ?></td>
                                                <td><?php echo (($login_date_type==2)? eToN(date('Y-m-d', strtotime($lession->end_date))) : date('Y-m-d', strtotime($lession->end_date))); ?>
                                                </td>
                                                <td>
                                                  <input type="text" name="remark" value="<?php echo $lession->remark; ?>" />                  
                                                </td>
                                                <td >
                                                    <input type="number" min="0" max="100" name="percentage" id="progressTillData<?php echo $lession->id;?>" value="<?php echo $lession->percentage; ?>" style="width: 50%;margin: 0;vertical-align: text-bottom;height: 30px;"/>

                                                    <input type="hidden" name="update_lessonplan_id" value="<?php echo $lession->id; ?>" />

                                                    <i class="material-icons prefix red-text text-darken-3" type="Submit" onclick="updateNow(progressTillData<?php echo $lession->id; ?>, topicProgress<?php echo $lession->id; ?>, completedText<?php echo $lession->id; ?>,update_lesson_planning_form<?php echo $lession->id;?>,event)" style="cursor:pointer;">send</i>
                                                 
                                                </td>
                                              </tr>
                                              <tr >
                                                <td colspan="8">
              	                                    <p>Topic progress till now</p>
                    				                         <div class="progress col " style="height: 20px" >
                                                        <div id="topicProgress<?php echo $lession->id; ?>" class="determinate center-align" style="width:<?php echo $lession->percentage;?>%" >
                                                            <span id="completedText<?php echo $lession->id; ?>" style="color:#fff;"> <?php echo $lession->percentage; ?>%</span>
                                                        </div>
                    				                        </div>
              			                            </td>
                                              </tr>

                                    </form>
                                              <?php 
                                    } 
                                    ?>
                                </tbody>
                              </table>
                            </div>
                          </div>


                      </div>
                    </div>
                  
              </div>
              


            </div>
            <?php }else{ ?>
              <div class="row">
                    <div class="col s12 ">
                        <div class="card grey darken-3">
                            <div class="card-content center white-text">
                                <span class="card-title"><span style="color:#80ceff;">No lesson plan schedule for you!!!</span></span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>


            <!-- end guddu desing -->


        </main>

<?php include_once("../config/footer.php");?>
<script>
  var PBV;
  var PB;
  var CPBText;
  function updateNow(inId,proId,txtId,formId,e){
               
        PBV= inId.value;
        
        PB= proId;
        CPBText=txtId;
        //debugger;
        requestforupdate(formId.id,e);
    }
    function updateProgress(){

      if(PBV>=0){
        PB.style.width = PBV+'%' ;
        CPBText.innerHTML= PB.style.width;
      }
        else{CPBText.innerHTML='0% '; }
    }
            
function requestforupdate(formId,e){
  //debugger;
  // $("#"+formId.id).on((function(e) 
  // {
    var data1=document.getElementById(formId);
    e.preventDefault();
    $.ajax
    ({
          url: "updatescript.php",
          type: "POST",
          data:  new FormData(data1),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#err").fadeOut();
          },
          success: function(data)
          { 

            if (data.trim() !== 'Lesson plan updated successfully'.trim()) { 
              Materialize.toast(data, 4000, 'red rounded'); 
            } 

            else if (data.trim() === 'Lesson plan updated successfully'.trim()) {
                Materialize.toast(data, 4000, 'rounded');
                updateProgress();
            }
 
              
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
}

</script>    
