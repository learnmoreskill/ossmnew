<?php
require_once('../important/marksheetview.php');
?>










<!-- =============== Modal Structure ==================================== -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <form id="update_mark_form" action="" method="post" novalidate >
        <h6 align="center">Edit mark</h6>
        <div class="divider"></div>

        <input type="hidden" name="update_mark" id="mid2" value="">
        <input type="hidden" name="subtype2" id="subtype2" value="">

        <div class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Subject Name</h6>
            </div>
            <div class="input-field col s6">
              <input name="sub2" id="sub2" type="text" class="validate" value="" required readonly >
            </div>
        </div>

        <div id="theorydiv" class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Theory</h6>
            </div>
            <div class="input-field col s6">
              <input name="theory2" id="theory2" type="text" class="validate" value="" placeholder="eg. 45 (type ab for absent/s for suspend)" required>
            </div>
        </div>

        <div id="practicaldiv" class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Practical</h6>
            </div>
            <div class="input-field col s6">
              <input name="practical2" id="practical2" type="text" class="validate" value="" placeholder="eg. 15 (type ab for absent/s for suspend)" required>
            </div>
        </div>
        <div id="obtaineddiv" class="row">
            <div class="col s2 offset-m1">
                <h6 style="padding-top: 20px">Obtained</h6>
            </div>
            <div class="input-field col s6">
              <input name="obtained2" id="obtained2" type="text" class="validate" value="" placeholder="eg. 75 (type ab for absent/s for suspend)" required>
            </div>
        </div>

    <div class="modal-footer">
      <button class="modal-action waves-effect waves-green btn-flat blue lighten-2" type="submit" >Update<i class="material-icons right">send</i></button>
    </div>

    </form>
    </div>
  </div>
<!-- ============== End Model =========================== -->

<script type="text/javascript">
    function set_variable(obj)
    {

      document.getElementById("mid2").value=obj;

      var subject=document.getElementById(obj).value;
      var theory=document.getElementById("c"+obj).value;
      var practical=document.getElementById("d"+obj).value;
      var totalobtained=document.getElementById("e"+obj).value;
      var subjecttype=document.getElementById("f"+obj).value;

      if (subjecttype == 0) {

        document.getElementById("theorydiv").style.display = 'none';
        document.getElementById("practicaldiv").style.display = 'none';
        document.getElementById("obtaineddiv").style.display = 'block';


        document.getElementById("obtained2").value = totalobtained;
        //document.getElementById("theory2").value = '';
        //document.getElementById("practical2").value = '';

        

      }else if (subjecttype == 3) {
        
        document.getElementById("theorydiv").style.display = 'none';
        document.getElementById("practicaldiv").style.display = 'none';
        document.getElementById("obtaineddiv").style.display = 'block';

        document.getElementById("obtained2").value = totalobtained;
        document.getElementById("obtained2").placeholder = "eg. A+ (type ab for absent/s for suspend)";
        //document.getElementById("theory2").value = '';
        //document.getElementById("practical2").value = '';

        
      }else if (subjecttype == 1) {

        document.getElementById("theorydiv").style.display = 'block';
        document.getElementById("practicaldiv").style.display = 'block';
        document.getElementById("obtaineddiv").style.display = 'none'; 

        //document.getElementById("obtained2").value = '';
        document.getElementById("theory2").value = theory;
        document.getElementById("practical2").value = practical;
               
      }

      document.getElementById("subtype2").value = subjecttype;
      document.getElementById("sub2").value = subject;
      
      
    }
</script>

<?php 
  if (isset($_SESSION['result_success'])) 
  {
    $result1=$_SESSION['result_success'];
    echo "<script>Materialize.toast('$result1', 3000, 'rounded'); </script>";
  unset($_SESSION['result_success']);
  }

?>
<script>
$(document).ready(function (e) 
{
  $("#update_mark_form").on('submit',(function(e) 
  { 
    e.preventDefault();
    $.ajax
    ({
          url: "updatescript.php",
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
            //alert(data);
            if (data.trim() !== 'Mark successfully updated'.trim()) {
              Materialize.toast(data, 4000, 'red rounded');
               $.ajax({
                type: "post",
                url: "../important/clearSuccess.php",
                data: 'request=' + 'result_success',
                success: function (data1) {
                }
              }); 
             } 
            else 
              if (data.trim() === 'Mark successfully updated'.trim()) {
                $('#modal1').modal('close');
              window.location.href =  window.location.href;
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
