<?php include_once('current_session_modal.php'); ?>
 
  <footer class="page-footer fixed">
            <!-- Detailed Footer starts -->

            <!-- Detailed Footer Ends-->

            <!-- Simple Footer starts -->
            <div class="footer-copyright">
                <div class="container capFirstAll">
                    <!-- © A1 Pathshala, All rights reserved. -->
                    © <?php echo $login_session_a." ".date('Y', strtotime($login_session_h)).". "; ?> <?php echo $lang['all_rights_reserved']; ?>.
                    
                </div>
            </div>
            <!-- Simple Footer Ends-->
    </footer>
        <!--Import jQuery before materialize.js-->
        <!--  Scripts-->
        <script type="text/javascript" src="../js/jquery-2.1.4.min.js"> </script>
        <script type="text/javascript" src="../js/jquery.timeago.min.1.4.3.js"></script>
        <script src="../bin/materialize.js"></script>

        <script type="text/javascript">

            $('.datepicker').on('mousedown',function(event){ event.preventDefault(); });
            $('.datepicker1').on('mousedown',function(event){ event.preventDefault(); });

            $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 120, // Creates a dropdown of 15 years to control year,
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: false // Close upon selecting a date,
          });
            
        //materialize date picker
        $('.datepicker1').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 120, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd',
            today: 'Today',
            clear: 'Clear',
            close: 'Ok',
            closeOnSelect: false 
        });
        </script>

        <script src="../js/materialize.clockpicker.js"></script>

        <script type="text/javascript">

        $('.timepicker').on('mousedown',function(event){ event.preventDefault(); });

        $('.timepicker').pickatime({
            default: 'now', // Set default time: 'now', '1:30AM', '16:30'
            fromnow: 0,       // set default time to * milliseconds from now (using with default = 'now')
            twelvehour: true, // Use AM/PM or 24-hour format
            donetext: 'Done', // text for done-button
            cleartext: 'Clear', // text for clear-button
            canceltext: 'Cancel', // Text for cancel-button
            autoclose: false, // automatic close timepicker
            ampmclickable: true, // make AM PM clickable
            darktheme: false,       // set to dark theme
            aftershow: function(){} //Function for after opening timepicker
          });
        </script>
        
        
        <script src="../bin/init.js"></script>
        <script src="../js/custom.js"></script>

        <!-- for Nepali date picker -->
        <script type="text/javascript" src="../js/jquery.nepaliDatePicker.min.js"> </script>
        <link rel="stylesheet" href="../css/nepaliDatePicker.min.css">


        <!-- for Single nepali picker -->
        <script type="text/javascript">
            $(".bod-picker").nepaliDatePicker({
              dateFormat: "%y-%m-%d",
              closeOnDateSelect: true
          });
          function eventLog(event){
                var datePickerData = event.datePickerData;
                var month = ("0" + datePickerData.bsMonth).slice(-2);
                var day = ("0" + datePickerData.bsDate).slice(-2);

                var output = datePickerData.bsYear+'-'+month+'-'+day;
                $(".bod-picker").val(output);
            }
            $(".bod-picker").on("dateSelect", function (event) {
                eventLog(event);
            });

        </script>



        <!-- for multiple nepali picker -->
        <script type="text/javascript">
          //Nepali date picker
          var idnew="";
          function mypicker(id){
            idnew=id;
            }
            $(".bod-picker1").nepaliDatePicker({
              dateFormat: "%y-%m-%d",
              closeOnDateSelect: true
          });
          function eventLog1(event){
                var datePickerData = event.datePickerData;
                var month = ("0" + datePickerData.bsMonth).slice(-2);
                var day = ("0" + datePickerData.bsDate).slice(-2);

                var output = datePickerData.bsYear+'-'+month+'-'+day;
                var abc = document.getElementById(idnew);
                abc.value=output;
            }
            $(".bod-picker1").on("dateSelect", function (event) {
                eventLog1(event);
            });
        </script>

        <script src="../js/update_session.js"></script>

</body>
</html>