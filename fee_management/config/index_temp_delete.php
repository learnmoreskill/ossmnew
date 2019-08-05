
<?php
include('session.php');
require("nepaliDate.php");
require("account_management.php");
$account = new account_management_classes();
$student_details = json_decode($account->get_student_details());
$school_details = json_decode($account->get_school_details_by_id());

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>A1Pathshala</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <!-- <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" /> -->
    <link rel="stylesheet" type="text/css" href="assets/fontawesome--5.0.13/web-fonts-with-css/css/fontawesome-all.min.css"> 
    <link rel="stylesheet" type="text/css" href="assets/css/zabuto_calendar.css">
    <link rel="stylesheet" type="text/css" href="assets/js/gritter/css/jquery.gritter.css" />
    <link rel="stylesheet" type="text/css" href="assets/lineicons/style.css">    
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets\css\nprogress.css" rel="stylesheet">

    <link href="assets/css/style-responsive.css" rel="stylesheet">
    <script src="assets/js/chart-master/Chart.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.js"></script>

  </head>

  <body>

  <section id="container" >
        <header class="header black-bg" style="background: #252423;">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.php" class="logo"><b><?php echo $school_details->school_name; ?></b></a>
            <!--logo end-->
            <div class="top-menu">
                <ul class="nav pull-right top-menu">
                    <li><a class="logout" href="login.html">Logout</a></li>
                </ul>
            </div>
        </header>
     
<?php include('externalnavbar.php'); ?>

      <!--main content start-->
      <section id="main-content">

          <section class="wrapper">
            <div class="row mt">
                      <!-- SERVER STATUS PANELS -->
                           <!-- <div class="col-md-1 col-sm-1 mb"></div> -->
                         <div class="col-md-4 col-sm-4 mb">
                          <a href='./school/today_report.php'>
                              <div class="white-panel pn donut-chart" style="height: 150px;">
                              <div class="white-header" style='background: #4c4742;'>
                                  <h5>Day Book</h5>
                              </div>
                                  <div class="row">
                                  <div class="col-sm-12 col-xs-12 goleft">
                                    <p><i class="fa fa-database"></i>Today Record</p>
                                  </div>
                                  <h3 style="margin-right: 5px;color:red;">
                                    Income - Expenses

                                  </h3>
                                   </div>
                              </div>
                          </a>
                        </div>
                         
                         <div class="col-md-4 col-sm-4 mb">
                          <a href='./school/balance-sheet.php'>
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
                             
        
                         <a href='./school/view_bill_record.php'>
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

                       
               </div> <br>        


              <div class="row">
                 <div class="col-md-12">
                  <div class="white-panel">


                <canvas id="myChart1" width="400" height="120"></canvas>
                  <script>
                  var ctx = document.getElementById('myChart1').getContext('2d');

                  var myLineChart = new Chart(ctx, {
                      // The type of chart we want to create
                      type: 'line',

                      // The data for our dataset
                      data: {
                          labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
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

    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery-1.8.3.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/jquery.scrollTo.min.js"></script>
    <script src="assets/js/jquery.sparkline.js"></script>
    <script src="assets/js/common-scripts.js"></script>
    <script type="text/javascript" src="assets/js/gritter/js/jquery.gritter.js"></script>
    <script type="text/javascript" src="assets/js/gritter-conf.js"></script>
    <script src="assets/js/sparkline-chart.js"></script>    
    <script src="assets/js/zabuto_calendar.js"></script>    
    <script src="assets/js/nprogress.js"></script>
    
    
    <script>
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

            <?php

            $file = 'date.txt';
            date_default_timezone_get('Asia/Kathmandu');
            $current_date = $nepaliDate->full;
            
            if(!file_exists($file)) {
              file_put_contents($file, json_encode($nepaliDate));
              $oldValue = $nepaliDate;
            } else {
              $oldValue = json_decode(file_get_contents($file));
            }
            $flag = false;       
            if($oldValue->nmonth > $nepaliDate->nmonth) {
              if($nepaliDate->month - $oldValue->month < 2) {
                $flag = true;
                $oldEnd = explode('-',$oldValue->monthEnd)[2];
                $diff = $oldEnd - $oldValue->date + $nepaliDate->date;
                if($diff<=30) {
                  $flag = false;
                }
              }
            } else if($oldValue->year<$nepaliDate->year){
              $flag = true;
            }

            if($flag) {
              file_put_contents($file, json_encode($nepaliDate));
            ?>

            $.ajax({
                url: "access.php",
                type: "get",
                contentType: false,
                cache: false,
                processData:false,
                beforeSend : function()
                {
                    NProgress.start();
                },
                success: function(data)
                {
                    NProgress.done();
                    //location.reload();
                    
                },
                error: function(e) 
                {
                    alert('Wait Data is Syncing !!');
                }          
            });
        <?php
        } else{
          echo'Month not yet completed';
        }
        ?>
        });
        
        
        function myNavFunction(id) {
            $("#date-popover").hide();
            var nav = $("#" + id).data("navigation");
            var to = $("#" + id).data("to");
            console.log('nav ' + nav + ' to: ' + to.month + '/' + to.year);
        }
    </script>
  </body>
</html>
