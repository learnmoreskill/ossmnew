<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/jquery-1.8.3.min.js"></script>
<script src="../assets/js/jquery.cookie.js"></script>

<script src="../assets/js/bootstrap.min.js"></script>
<script class="include" type="text/javascript" src="../assets/js/jquery.dcjqaccordion.2.7.js"></script>
<script src="../assets/js/jquery.scrollTo.min.js"></script>
<script src="../assets/js/jquery.sparkline.js"></script>
<script src="../assets/js/common-scripts.js"></script>
<script type="text/javascript" src="../assets/js/gritter/js/jquery.gritter.js"></script>
<script type="text/javascript" src="../assets/js/gritter-conf.js"></script>
<script src="../assets/js/sparkline-chart.js"></script>    
<script src="../assets/js/zabuto_calendar.js"></script>

<script type="text/javascript">
        $(document).ready(function (e) 
    {
        $("#update_current_session_year_form").on('submit',(function(e) 
          {
            e.preventDefault();
            $.ajax
            ({
                  url: "../config/submitscript.php",
                  type: "POST",
                  data:  new FormData(this),
                  contentType: false,
                  cache: false,
                  processData:false,
                  beforeSend : function()
                  {
                    // $("#submitBtn").hide();
                    // $("#loadingBtn").show();
                  },
                  success: function(data)
                  {
                    var result = JSON.parse(data);

                    if (result.status == 200) {

                        alert('Academic Session Changed');
                        $('#modal_change_current_session').modal('hide');
                        location.reload();

                    }else{
                        alert(result.errormsg);
                    }
                    
                     
                    // $("#submitBtn").show();
                    // $("#loadingBtn").hide();
                  },
                  error: function(e) 
                  {
                    alert('Sorry Try Again !!');
                    // $("#submitBtn").show();
                    // $("#loadingBtn").hide();
                  }          
            });
        }));
    });
</script>