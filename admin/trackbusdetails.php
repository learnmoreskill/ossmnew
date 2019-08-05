<?php
include('session.php');
include("../important/backstage.php");
   $backstage = new back_stage_class();

   if (isset($_GET["token"])){
            $longid1 = ($_GET["token"]);

            if ($longid1=="prf3s765tbusdw") {
              if (isset($_GET["key"])){
            $busNumber=addslashes($_GET["bn"]);
            $longid = addslashes($_GET["key"]);
            $shortid = substr($longid, 17);

            $bus_details = json_decode($backstage->get_bus_route_by_transportaion_id($shortid));
            
}
}else if (1==2) {


}}

?>
<!-- add adminheader.php here -->
<?php include_once("../config/header.php");?>
<?php include_once("navbar.php");?>

    <main>
    <div class="section no-pad-bot" id="index-banner">
        <?php include_once("../config/schoolname.php");?>
        <div class="github-commit">
            <div class="container">
                <div class="row center"><a class="white-text text-lighten-4" href="#">Bus route and stoppage</a></div>
            </div>
        </div>
    </div>

            <section class = "container" style="width: 95%">
                <div class="row ">
                  <div class="col s12 m4">
                    <div class="card">
                      <div class="card-content no-padding">
                        <span class="card-title cPadding no-margin grey lighten-4"><b>Add route and stoppage</b></span>
                        <hr class="no-margin">
                          <form id="add_bus_route_and_stoppage_form" class="cPadding" method="POST" action="addscript.php">
                            <div class = "row no-margin"><br>

                            
                              <div class="input-field col s12">
                                <input id="bus_route" type="text" name="bus_route" placeholder="Eg. Gaushala" >
                                <label for="bus_route">Bus Route<span>*</span></label>
                              </div>

                              <div class="input-field col s12">
                                <input id="bus_stop" type="text" name="bus_stop" placeholder="Eg. Shantinagar" >
                                <label for="bus_stop">Bus Stop</label>
                              </div>

                              <div class="input-field col s12">
                                <input id="bus_time" type="text" name="bus_time" class="timepicker" placeholder="Eg. 09:15AM">
                                <label for="bus_time">Estimated time<span>*</span></label>
                              </div>

                              <div class="input-field col s12">
                                <input id="fee_rate" type="text" name="fee_rate" placeholder="Eg. 500">
                                <label for="fee_rate">Fee rate<span>*</span></label>
                              </div>
                              
                            </div>

                            <input type="hidden" id="transportation_id" name="transportation_id" value="<?php echo $shortid; ?>">

                            <input type="hidden" id="bus_route_id" name="bus_route_id" value="">

                            <input type="hidden" id="bus_route_action_and_request" name="bus_route_action_and_request" value="<?php echo "add"; ?>">

                            <div class=" center-align cPadding">
                              <button id="submit_btn" class="waves-effect waves-light btn" type="submit">Add</button>
                            </div><br>
                          
                      </div>
                      
                      </form>
                    </div>
                  </div>
                  <div class="col s12 m8">
                    <div class="card">
                      <div class="card-content no-padding">
                        <span class="card-title cPadding no-margin grey lighten-4"><b>Route and stoppage details of bus: <?php echo $busNumber; ?></b></span>
                        <hr class="no-margin">
                        <div class="scrollable">
                          <table class="striped">
                            <thead>
                              <tr>
                                  <th>Route</th>
                                  <th>Stoppage</th>
                                  <th>Estimated time</th>
                                  <th>Fee rate</th>
                                  <th style="min-width: 63px">Action</th>

                              </tr>
                            </thead>
                            <tbody>
                            <?php  if (count((array)$bus_details)) {                                        
                              foreach ($bus_details as $busDetails) {
                
                                    echo "<tr>
                                      <td>" . $busDetails->bus_route. "<input type='hidden' id='".$busDetails->bus_route_id."' value='".$busDetails->bus_route."'> </td>
                                      <td>" . $busDetails->bus_stop. "<input type='hidden' id='a".$busDetails->bus_route_id."' value='".$busDetails->bus_stop."'></td>
                                      <td>" . date('h:i A', strtotime($busDetails->bus_time)). "<input type='hidden' id='b".$busDetails->bus_route_id."' value='".date('h:i A', strtotime($busDetails->bus_time))."'></td>
                                      <td>" . $busDetails->bus_fee_rate. "<input type='hidden' id='c".$busDetails->bus_route_id."' value='".$busDetails->bus_fee_rate."'></td>
                                      <td>
                                      <a  id='".$busDetails->bus_route_id."' onClick='set_variable(this.id)' href='#'><i class='material-icons green-text text-lighten-1'>edit</i></a>
                                      </td>
                                      </tr>";
                                    
                                    } }else{?>
                                    <tr>
                                        <td colspan="5" class="center">Sorry, no details found</td>
                                      </tr>
                                    <?php } ?>
                                </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
            </section>


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

<script type="text/javascript">
    function set_variable(obj)
    {

        var busRoute=document.getElementById(obj).value;
        var busStop=document.getElementById("a"+obj).value;
        var busTime=document.getElementById("b"+obj).value;
        var busFeeRate=document.getElementById("c"+obj).value;

      document.getElementById("bus_route").value = busRoute;
      document.getElementById("bus_stop").value = busStop;
      document.getElementById("bus_time").value = busTime;
      document.getElementById("fee_rate").value = busFeeRate;

      document.getElementById("bus_route_id").value = obj;
      document.getElementById("bus_route_action_and_request").value = "update";
      var btn=document.getElementById("submit_btn").innerHTML="update";
      

    }
</script>

<script>
$(document).ready(function (e) 
{
  $("#add_bus_route_and_stoppage_form").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "addscript.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#err").fadeOut();
          },
          success: function(data)
          { 
            if (data.trim() === 'Bus route succesfully added' || data.trim() === 'Bus route succesfully updated') {

              window.location.reload();

            }else {
             Materialize.toast(data, 4000, 'red rounded');

             $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data) {
                  //alert(data);
                }
              });
             
           }
          },
          error: function(e) 
          {
            alert('Sorry Try Again !!');
          }          
    });
  }));
  
});

</script>