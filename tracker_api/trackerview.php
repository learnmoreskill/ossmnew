<?php
include('conf.php');
    $page = $_SERVER['PHP_SELF'];
    $sec = "10";

    $sql1 = "select * from tracker where bid = '1'";
    $result1 = $db->query($sql1);
?>
<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="refresh" content="10">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Tracker Alpha</title>

        <!-- Bootstrap -->
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
            <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
    </style>
        <!-- <script>
        history.pushState({ page:1},"title 1","#nbb"); window.onhashchange =function(event){ window.location.hash ="nbb";};
        </script> -->
    </head>

    <body>
        <nav class="navbar navbar-inverse navbar-static-top">
            <div class="container-fluid">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="trackerview.php">tracker</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="trackerview.php">Last recorded Location <span class="sr-only">(current)</span></a></li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container-fluid -->
        </nav>
                <div class="container">
                        <div class="table-responsive">
                            <table class="table table-condesnsed table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Latitude</th>
                                        <th>Longitude</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                 <tbody>
                                    <?php if ($result1->num_rows > 0) { 
                                    // output data of each row
                        $count=1;
                                    while($row = $result1->fetch_assoc()) { ?>
                                        <tr>
                                            <th>
                                                <?php echo $count ; ?>
                                            </th>
                                            <td id="lati"> <?php echo $row["blat"];?> </td>
                                            <td id="longi"> <?php echo $row["blong"];?> </td>
                                            <td> <?php echo $row["bdate"];?> </td>
                                            <td> <?php echo $row["btime"];?> </td>
                                        </tr>
                                            <?php   $count=$count+1; } //while end
                                            }else {?>   
                                        <tr>
                                            <th>
                                                -
                                            </th>
                                            <td> 
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td> 
                                                -
                                            </td>
                                        </tr> 
                                        <?php } ?>

                                </tbody>

                            </table>
                        </div>
                </div>
        <div class="container">
        <div id="map" style="width:1142px;height:400px"></div>
            </div>
            
    <script>
      // Note: This example requires that you consent to location sharing when
      // prompted by your browser. If you see the error "The Geolocation service
      // failed.", it means you probably did not give permission for the browser to
      // locate you.
      var map, infoWindow;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 19
        });
        infoWindow = new google.maps.InfoWindow;

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
              var point = new google.maps.LatLng(
                  parseFloat(document.getElementById('lati').innerText),
                  parseFloat(document.getElementById('longi').innerText));
            infoWindow.setPosition(point);
            infoWindow.setContent('Location found.');
            infoWindow.open(map);
            map.setCenter(point);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      }

      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
        infoWindow.open(map);
      }
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD_UTF6NCoUfYioglesA3UXqWXUOq4fWgo&callback=initMap">
    </script>


        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <!-- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </body>

    </html>
