<div class="container">
  <div class="col-md-12">

    <!--<a href="index.php?page=location&all_rooms=TRUE">Show all rooms</a><br>-->
  <?php


   if (isset($_SESSION)){
      if (isset($_GET['room_name'])){

        $room_name = htmlspecialchars($_GET['room_name']);
        if ($room_name=="all_rooms"){
          echo '<h2>All rooms</h2>';
        }else{
          echo '<h2>Class room <a href="'.$app_path.'room_schedule/'.str_replace("+", "%2B", $room_name).'">'.$room_name.'</a></h2>';
        }
      }else{
        echo '<h2>No class room set!</h2>';
      }
    }
    ?>
  </div>
</div>

<i>Please report if location is wrong!</i>

<div id="map_wrapper">
    <div id="map_canvas" class="mapping"></div>
</div>

<div id="map"></div>








      <?php
        if (isset($_SESSION)){
          if (isset($_GET['room_name'])){

            $room_name = htmlspecialchars($_GET['room_name']);
            if ($room_name=="all_rooms"){
              echo '<script>
                      jQuery(function($) {
                          // Asynchronously Load the map API
                          var script = document.createElement(\'script\');
                          script.src = \'https://maps.googleapis.com/maps/api/js?key=AIzaSyAN89kGNr9Uaj80RTxfAU6o8piZxu0_DrM&callback=initMap\';
                          document.body.appendChild(script);
                      });

                      function initMap() {
                          var map;
                          var bounds = new google.maps.LatLngBounds();
                          var mapOptions = {
                              mapTypeId: \'roadmap\'
                          };

                          // Display a map on the page
                          map = new google.maps.Map(document.getElementById(\'map_canvas\'), mapOptions);
                          map.setTilt(45);

                          // Multiple Markers
                          var markers = [';


                            //include("includes\connection.php");


                            $return_arr = "[";

                            //Fetch data to be used in the searchbox:
                            $query = "SELECT room_name, latitude, longitude FROM `room_location` ORDER BY `room_name` DESC";

                            if ($result = mysqli_query($link, $query)){
                              while ($row = mysqli_fetch_assoc($result)){
                                echo "['".str_replace("+", "%2B", $row['room_name'])."',".$row['latitude'].",".$row['longitude']."],\n";
                              }
                            }

                          echo '];

                          // Display multiple markers on a map
                          var infoWindow = new google.maps.InfoWindow(), marker, i;

                          // Loop through our array of markers & place each one on the map
                          for( i = 0; i < markers.length; i++ ) {
                              var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
                              bounds.extend(position);
                              marker = new google.maps.Marker({
                                  position: position,
                                  map: map,
                                  title: markers[i][0],
                                  label: markers[i][0]
                              });

                              // Allow each marker to have an info window
                              google.maps.event.addListener(marker, \'click\', (function(marker, i) {
                                  return function() {';
                                echo 'infoWindow.setContent("<a href=\"'.$app_path.'room_schedule/" + markers[i][0] + "\">" + markers[i][0].replace("%2B", "+") + "</a>") ;
                                      infoWindow.open(map, marker);
                                              }
                                          })(marker, i));

                                          // Automatically center the map fitting all markers on the screen
                                          map.fitBounds(bounds);
                                      }

                                      // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
                                      var boundsListener = google.maps.event.addListener((map), \'bounds_changed\', function(event) {
                                          this.setZoom(17);
                                          google.maps.event.removeListener(boundsListener);
                                      });

                                  }
                  </script>

                ';

            }else{
              $room_name = $_GET['room_name'];
              $result = get_room_location($room_name);
              $room_name = str_replace('+','%2B',$room_name);

              echo '<script>function initMap() {';
              echo ' var myLatLng = {lat: '.$result[0].', lng: '.$result[1].'};';

              echo 'var map = new google.maps.Map(document.getElementById("map_canvas"), {
                      center: myLatLng,
                      scrollwheel: false,
                      zoom: 17
                    });';
              echo 'var marker = new google.maps.Marker({
                      map: map,
                      position: myLatLng,
                      url: "https://www.google.fi/maps/place//@" + myLatLng["lat"] + "," + myLatLng["lng"] + ",17z"

                    });';
              echo 'google.maps.event.addListener(marker, "click", function () {
                      //alert(this.url);
                       window.open(this.url, "_blank");
                    });

                    }';
              echo '</script>
                  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAN89kGNr9Uaj80RTxfAU6o8piZxu0_DrM&callback=initMap"
                      async defer></script>';

            }

          }


        }else{
        	header("location: index.php");
        }
      ?>
