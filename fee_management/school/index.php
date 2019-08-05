
<!DOCTYPE html>
<html lang="en">
<?php
include('../session.php'); 
include('../load_backstage.php'); 
require('../head.php');
include('../header.php');

?>

<link href="../assets\css\nprogress.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>

  <body>

    <section id="container" >
        
        <?php include('../config/navbar.php'); ?>

        <!--main content start-->
        <section id="main-content">

        <section class="wrapper">
            <div class="row mt">
                <!-- SERVER STATUS PANELS -->
                <div class="col-md-4 col-sm-4 mb">
                  <a href='../school/today_report.php'>
                      <div class="white-panel pn donut-chart" style="height: 150px;">
                        <div class="white-header" style='background: #4c4742;'>
                          <h5>Day Book</h5>
                        </div>
                          <div class="row">
                            <div class="col-sm-12 col-xs-12 goleft">
                              <p><i class="fa fa-database"></i>Today Record</p>
                            </div>
                            <h3 style="margin-right: 5px;color:red;">Income - Expenses
                            </h3>
                          </div>
                      </div>
                  </a>
                </div>
                 
                <div class="col-md-4 col-sm-4 mb">
                  <a href='../school/balance-sheet.php'>
                    <div class="white-panel pn donut-chart" style="height: 150px;">
                      <div class="white-header" style='background: #4c4742;'>
                        <h5>Balance Sheet</h5>
                      </div>
                      <div class="row">
                        <div class="col-sm-12 col-xs-12 goleft">
                          <p style="width:100%;"><i class="fa fa-database"></i> Over All Balance</p>
                        </div>
                        <h2 style="margin-right: 5px;">View</h2>
                      </div>
                    </div>
                  </a>
                </div>

                <div class="col-md-4 col-sm-4 mb">
                  <a href='../school/view_bill_record.php'>
                    <div class="white-panel pn donut-chart" style="height: 150px;">
                      <div class="white-header" style='background: #4c4742;'>
                          <h5>Bill Record</h5>
                      </div>
                      <div class="row">
                          <div class="col-sm-12 col-xs-12 goleft">
                            <p style="width:100%;"><i class="fa fa-database"></i> View Privous Bill</p>
                          </div>
                          <h2 style="margin-right: 5px;">View</h2>
                      </div>
                    </div>
                  </a>  
                </div>          
            </div> 

            <br>        


            <div class="row">
                <div class="col-md-12">
                    <div class="white-panel">

                        <?php
                          $months=array();
                        ?>

                        <canvas id="myChart1" width="400" height="120">
                        </canvas>
                        <script>
                            var ctx = document.getElementById('myChart1').getContext('2d');

                            var myLineChart = new Chart(ctx, {
                                // The type of chart we want to create
                                type: 'line',

                                // The data for our dataset
                                data: {
                                    labels: ["Bai", "Jes", "Ash", "Shr", "Bha", "Asj", "Kar", "Man", "Pou", "Mag", "Fal", "Cha"],
                                    datasets: [{
                                        label: "Expenses",
                                        fill:false,
                                        borderColor: 'rgb(255, 99, 132)',
                                        backgroundColor: 'rgb(255,255,255)',
                                        data: [30, 10, 5, 2, 20]
                                    },{
                                        label: "Income",   
                                        fill: false,
                                        borderColor: 'rgb(75, 192, 192, 1)',
                                        backgroundColor: 'rgb(255,255,255)',
                                        data: [50, 20, 15, 22, 26]}]
                                },

                                  // Configuration options go here
                                  options: {
                                      scales: {
                                      yAxes: [{
                                          display: true,
                                          ticks: {
                                              suggestedMax: 100,
                                              suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                                              beginAtZero: true   // minimum value will be 0.
                                          }
                                      }]
                                    }
                                  }   
                            });
                        </script> 
                    </div>  
                </div>                          
            </div> 
              
        </section>
        </section>

        <!--main content end-->
        <!--footer start-->
        <footer class="site-footer">
          <div class="text-center">
             
              <a href="index.php#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
        </footer>
      <!--footer end-->
    </section>

<?php require('../config/commonFooter.php'); ?>  
<script src="../assets/js/nprogress.js"></script>


<!-- start check date to update by hackster -->
<?php

    
            date_default_timezone_get('Asia/Kathmandu');

            //Get Current Nepali Date from session/nepaliDate
            $newDate = $nepaliDate->full;

            //Get Account Date from school details
            $accountDate=$school_details->account_date;

            if(empty($accountDate)) { //if empty then put

              $account->update_account_date($newDate);

              $oldValue = $newDate;
            
            } else { //if file exist
              $oldValue = $school_details->account_date;
            }

            list($ad_year, $ad_month, $ad_day) = explode('-', $oldValue);

            ?><script> console.log('Account date: <?php echo $oldValue; ?>');
            console.log('Current date: <?php echo $newDate; ?>'); </script><?php

            $flag = false;

            if($ad_year<$nepaliDate->year){

                ?><script>    console.log('Year completed'); </script><?php
              $flag = true;

            }else if($ad_month < $nepaliDate->nmonth) {   //account month is less than current month

                    ?><script>    console.log('Month completed'); </script><?php

                $flag = true;

              /*    if($nepaliDate->nmonth - $ad_month < 2) {
                $flag = true;
                $oldEnd = explode('-',$oldValue->monthEnd)[2];
                $diff = $oldEnd - $oldValue->date + $nepaliDate->date;

                if($diff<=30) {
                  $flag = false;
                }


              } else {
                $flag = true;
              } */

              

            }


      if ($school_details->account_auto_update) {
        ?><script> console.log('Account Auto Update Is True'); </script><?php

        if($flag) {

          $account->update_account_date($newDate);
          
            
            ?><script>
                $.ajax({
                    url: "access.php?requestcode=hacksterupdate",
                    type: "get",
                    contentType: false,
                    cache: false,
                    processData:false,
                    beforeSend : function()
                    {
                        NProgress.start();
                        alert('Wait Data is Syncing !!');
                    },
                    success: function(data)
                    {
                        NProgress.done();
                        console.log(data.trim());
                        //location.reload();
                        
                    },
                    error: function(e) 
                    {
                        alert('Data couldnot be sync !!');
                    }          
                });
            </script><?php

        } else{ 

            ?><script>
                  console.log('Year/Month not yet completed');
            </script><?php
         }
      }else{ 
        ?><script> console.log('Account Auto Update Is False'); </script><?php
      }

?>



    <script type="text/javascript">
        $(document).ready(function () {
            $("#date-popover").popover({html: true, trigger: "manual"});
            $("#date-popover").hide();
            $("#date-popover").click(function (e) {
                $(this).hide();
            });
        
            $("#my-calendar").zabuto_calendar({
                action: function () {
                    return myDateFunction(this.id, false);
                },
                action_nav: function () {
                    return myNavFunction(this.id);
                },
                ajax: {
                    url: "show_data.php?action=1",
                    modal: true
                },
                legend: [
                    {type: "text", label: "Special event", badge: "00"},
                    {type: "block", label: "Regular event", }
                ]
            });

        });
        
        
        // function myNavFunction(id) {
        //     $("#date-popover").hide();
        //     var nav = $("#" + id).data("navigation");
        //     var to = $("#" + id).data("to");
        //     console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        // }
    </script>
  </body>
</html>