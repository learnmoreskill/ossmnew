    $(document).ready(function (e) 
    {
        $("#update_current_session_year_form").on('submit',(function(e) 
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
                    // $("#submitBtn").hide();
                    // $("#loadingBtn").show();
                  },
                  success: function(data)
                  {
                    var result = JSON.parse(data);

                    if (result.status == 200) {

                        alert('Academic Session Changed');
                        $('#modal_change_current_session').modal('close');
                        location.reload();

                    }else{
                        Materialize.toast(result.errormsg, 4000, 'red rounded');
                    }
                    
                     
                    // $("#submitBtn").show();
                    // $("#loadingBtn").hide();
                  },
                  error: function(e) 
                  {
                    Materialize.toast('Sorry Try Again !!', 4000, 'red rounded');
                    // $("#submitBtn").show();
                    // $("#loadingBtn").hide();
                  }          
            });
        }));
    });