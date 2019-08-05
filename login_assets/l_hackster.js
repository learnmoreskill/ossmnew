
    var widgetId1;
   


    var onloadCallback = function() {
    widgetId1 = grecaptcha.render(document.getElementById('admin1'), {
      'sitekey' : '6LfF2UUUAAAAAKNdIxZwz7dh4A8i0UO3wpKE9Cnw'
    });

  };
  
  
  
  
  
  function hideErrMsgAdmin()
      {
       document.getElementById("admin_login_failed").innerHTML='';
      document.getElementById("admin_recaptcha_failed").innerHTML='';
      }
      
      
      
$(document).ready(function (e) 
{
/*======================== for admin login ==============================*/
var ab1 = document.getElementById("admin_login_failed");
var ab2 = document.getElementById("admin_recaptcha_failed");

  $("#admin_login").on('submit',(function(e) 
  {
    e.preventDefault();
    $.ajax
    ({
          url: "linker/login.php",
          type: "POST",
          data:  new FormData(this),
          contentType: false,
          cache: false,
          processData:false,
          beforeSend : function()
          {
            $("#submitBtn").hide();
            $("#loadingBtn").show();
          },
          success: function(data)
          {

            $("#loadingBtn").hide();
            //alert(data);  data!='Login success as admin' && 
            if (data.trim() === 'Incorrect reCaptcha'.trim()) { 
              ab1.innerHTML='';
              ab2.innerHTML = data; 
               $("#submitBtn").show();

              grecaptcha.reset(widgetId1);   

            }else if (data.trim() === 'Login success as admin'.trim()) {

              window.location.href = 'admin/welcome.php';

            }else if (data.trim() === 'Login success as manager'.trim()) {

              window.location.href = 'admin/welcome.php';

            }else if (data.trim() === 'Login success as teacher'.trim()) {

              window.location.href = 'nsk/welcome.php';
              
            }else if (data.trim() === 'Login success as student'.trim()) {

              window.location.href = 'smart/swelcome.php';
              
            }else if (data.trim() === 'Login success as parent'.trim()) {

              window.location.href = 'parents/welcome.php';
              
            }else {
              ab1.innerHTML = data; 
              ab2.innerHTML=''; 
              $("#submitBtn").show();
              
              grecaptcha.reset(widgetId1);  
              
            }

            
          },
          error: function(e) 
          {
            $("#submitBtn").show();
            $("#loadingBtn").hide();
            alert('Sorry Try Again !!');
          }          
    });
  }));



  
});
