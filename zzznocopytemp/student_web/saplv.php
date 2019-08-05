<?php
   include('ssession.php');
?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>School Management</title>
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="http://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet" type="text/css">

        <!--Import materialize.css-->
        <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection" />
        <link type="text/css" rel="stylesheet" href="../css/custom.css" media="screen,projection" />

        <!--Let browser know website is optimized for mobile-->
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="An advance digital school management system. ">
        <!--  Android 5 Chrome Color -->
        <meta name="theme-color" content="#009FFF">
        <!-- Windows Phone -->
        <meta name="msapplication-navbutton-color" content="#009FFF">
        <!-- iOS Safari -->
        <meta name="apple-mobile-web-app-status-bar-style" content="#009FFF">
        <style>
            body {
                display: flex;
                min-height: 100vh;
                flex-direction: column;
            }
            
            main {
                flex: 1 0 auto;
            }
        </style>
        <script>
            history.pushState({
                page: 1
            }, "title 1", "#nbb");
            window.onhashchange = function(event) {
                window.location.hash = "nbb";
            };
        </script>
        
    </head>

    <body>
        <?php include_once("../smart/navbarstudent.php");?>

        <script type="text/javascript">
        function showMessage() { 
            
            ustartDate = document.getElementById("sdate").value; 
            
            var startDate = new Date(ustartDate);
            fyear = startDate.getFullYear(); 
            fmonth = startDate.getUTCMonth() + 1; 
            fdate = startDate.getDate();    
           
            uendDate = document.getElementById("edate").value; 
            var endDate = new Date(uendDate); 
            syear = endDate.getFullYear(); 
            smonth = endDate.getUTCMonth() + 1;
            sdate = endDate.getDate(); 
           
        if( fyear > syear)
            {
                document.getElementById("sdate").value="";
                document.getElementById("edate").value="";
                alert('Start Date is more than End Date');
            }
           else if ( fmonth > smonth )
               {
                   document.getElementById("sdate").value="";
                   document.getElementById("edate").value="";
                   alert('Start Date is more than End Date');
               }
           else if ( fdate > sdate )
               {
                   document.getElementById("sdate").value="";
                   document.getElementById("edate").value="";
                   alert('Start Date is more than End Date');
               }

    }
        </script>
        
        <main>
            <div class="section no-pad-bot" id="index-banner">
                <div class="container">
                    <div class="row center"><a class="white-text text-lighten-4" href="#">School Management</a></div>
                </div>
                <div class="github-commit">
                    <div class="container">
                        <div class="row center"><a class="white-text text-lighten-4" href="#">Leave Manager</a></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m12">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title flow-text"><span style="color:#008ee6;">Request For Leave</span></span>
                            <p class="flow-text">Just fill the form below and submit.</p><br/>

                            <form method="post" action="saplvscript.php?upd">
                                 <input type="date" id="sdate" class="datepicker" name="sdate" required>
                                <label for="sdate">Enter Start Date</label>
                                 <input type="date" id="edate" class="datepicker" name="edate" required>
                                <label for="edate">Enter End Date</label>
                            
                                
                                <p>Mention the reason :</p>
                               
                                <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="lvreason" name="lvreason" class="materialize-textarea" length="3000" required></textarea>
                                            <label for="lvreason">Reason</label>
                                        </div>
                                    </div>
                                
                                <button class="btn waves-effect waves-light blue lighten-2" type="submit" onclick="showMessage();" name="action">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>       
        </main>


        <footer class="page-footer fixed">
            <!-- Detailed Footer starts -->

            <!-- Detailed Footer Ends-->

            <!-- Simple Footer starts -->
            <div class="footer-copyright">
                <div class="container">
                    © Grab Technology Pvt. Ltd, All rights reserved.
                    
                </div>
            </div>
            <!-- Simple Footer Ends-->
        </footer>
        <!--Import jQuery before materialize.js-->
        <!--  Scripts-->
        <script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="../bin/materialize.js"></script>
        <script src="../bin/init.js"></script>
                <script>
	$('.datepicker').each(function(){
  	var pickr = $(this).pickadate({
      selectMonths: true, // Creates a dropdown to control month
      selectYears: 5, // Creates a dropdown of 15 years to control year
      editable: true
    });
    
    $(this).click(function(){
    	pickr.pickadate('open');
    });
  })
  
  $('select').material_select();
        </script>
    
    </body>

    </html>