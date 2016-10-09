<?php
include ('../includes/include_files.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Cab Now</title>

        <!-- Include Google Maps API -->
        <script src="http://maps.google.com/maps/api/js?sensor=false"></script>
        <!-- Geolocation JS -->
        <script type="text/javascript">

            function showMap() {

                //If HTML5 Geolocation Is Supported In This Browser
                if (navigator.geolocation) {

                    //Use HTML5 Geolocation API To Get Current Position
                    navigator.geolocation.getCurrentPosition(function(position) {

                        //Get Latitude From Geolocation API
                        var latitude = position.coords.latitude;

                        //Get Longitude From Geolocation API
                        var longitude = position.coords.longitude;

                        //Define New Google Map With Lat / Lon
                        var coords = new google.maps.LatLng(latitude, longitude);

                        //Specify Google Map Options
                        var mapOptions = {
                            zoom: 15,
                            center: coords,
                            disableDefaultUI: true,
                            //zoomControl:false,
                            mapTypeControl: false,
                            navigationControlOptions: {style: google.maps.NavigationControlStyle.SMALL}, mapTypeId: google.maps.MapTypeId.ROADMAP};
                        map = new google.maps.Map(document.getElementById("page"), mapOptions);
                        var marker = new google.maps.Marker({
                            position: coords,
                            map: map,
                            title: "You Are Here!"
                                    //clickable: true,
                                    //icon: 'http://google-maps-icons.googlecode.com/files/factory.png'
                        });
<?php
//echo $mi="<script type='text/javascript'>document.write(17.434545);</script>";
//echo $mi; // print 5234
?>
                        var geocoder;
                        geocoder = new google.maps.Geocoder();
                        var latlng = new google.maps.LatLng(latitude, longitude);
                        var infowindow = new google.maps.InfoWindow();
                        //var latlngStr = input.split(',', 2);
                        // var lat = parseFloat(latlngStr[0]);
                        // var lng = parseFloat(latlngStr[1]);
                        //var latlng = new google.maps.LatLng(lat, lng);
                        geocoder.geocode({'latLng': latlng}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                                if (results[1]) {
                                    map.setZoom(15);
                                    marker = new google.maps.Marker({
                                        position: latlng,
                                        map: map,
                                        title: "You Are Here!"
                                    });
                                    infowindow.setContent(results[1].formatted_address);
                                    infowindow.open(map, marker);
                                } else {
                                    alert('No results found');
                                }
                            } else {
                                alert('Geocoder failed due to: ' + status);
                            }
                        });

                    });



                } else {

                    //Otherwise - Gracefully Fall Back If Not Supported... Probably Best Not To Use A JS Alert Though :)
                    alert("Geolocation API is not supported in your browser.");
                }

            }

            //Once Page Is Populated - Initiate jQuery
            $(document).ready(function() {

                //Show The Map
                showMap();

                // When The Viewing Window Is Resized
                $(window).resize(function() {

                    //CSS Resizes Container So Lets Recall The Map Function
                    showMap();

                });

            });

        </script>
    </head>
    <body>
        <?php

        function getPlaceName($latitude, $longitude) {
            //This below statement is used to send the data to google maps api and get the place
            //name in different formats. we need to convert it as required.
            $geocode = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='
                    . $latitude . ',' . $longitude . '&sensor=false');


            $output = json_decode($geocode);

            //Here "formatted_address" is used to display the address in a user friendly format.
            echo $output->results[0]->formatted_address;
        }
        ?>
        <!-- Page Contents Starts
            ================================================== -->
        <div data-role="page" id="page" data-theme="d">

            <div data-role="content">
                <div id="mapContainer"></div>


                <!-- Footer Starts -->
                <?php include '../includes/footer.php'; ?>
                <!-- Footer Ends -->
            </div>
            <!-- /content -->
            <!-- Left Panel Starts
                ================================================== -->

            <div data-role="panel" id="left-panel" data-theme="b" style="margin-top: -20px;">


            </div>
            <!-- Left Panel Ends
                ================================================== -->

            <!-- ToTop Starts
                ================================================== -->
            <!--<a href="#" class="scrollup">Scroll</a>-->
            <!-- ToTop Ends
                ================================================== -->
        </div>
        <!-- Page Contents Ends
            ================================================== -->

    </body>
</html>