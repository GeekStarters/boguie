
<?php 
require_once("includes/main.inc.php");
if($_SESSION['sess_admin_id']==''){
	header("location:index.php");
}?>
<link href="styles.css" rel="stylesheet" type="text/css">
<?php include("top.inc.php");?>


<script type="text/javascript" src = "http://maps.google.com/maps/api/js?key=AIzaSyDrSJS7jcs8XNS1Azg0D4-zrO2Tq0ohtHg
"></script>


<div id="map" style="width: 100%; height: 500px; background-color: gray"></div>    
<?
require_once("includes/main.inc.php");
?>
<script type="text/javascript">
var locations = [
<?php
$query="SELECT * from nearest_driver";
$result=mysql_query($query);
{
    if ($num=mysql_numrows($result)) {
        $i=0;
        while ($i < $num) {
            $id=mysql_result($result,$i,"id");
            $title=mysql_result($result,$i,"driver_email");
            $lapt=mysql_result($result,$i,"latitude");
            $long=mysql_result($result,$i,"longitude");
            $status=mysql_result($result,$i,"driver_status");

                $query2="SELECT * from tbl_user WHERE email = '$title'";
                $result2=mysql_query($query2);
                $driver_id=mysql_result($result2,0,"id");
            echo "['<div><h4>$title</h4><br><a target='_blank' href=view_passenger.php?pid=$driver_id>$title</a></div>', $lapt, $long, '$status'],";
            $i++;
        }
    }
}
?>
];

    var iconURLPrefix = "http://graymatter.a2hosted.com/cab/admin/images/";
    console.log(locations);
    var map = new google.maps.Map(document.getElementById("map"), {
        zoom: -5,
        center: new google.maps.LatLng(40.715618, -74.011133),
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        mapTypeControl: false,
        streetViewControl: false,
        disableDefaultUI: true,
        panControl: false,
        zoomControlOptions: {
        position: google.maps.ControlPosition.LEFT_BOTTOM
    }
    });

    var infowindow = new google.maps.InfoWindow({
        maxWidth: 400,
        maxHeight: 350
    });

    var marker;
    var markers = new Array();

    var iconCounter = 0;

    for (var i = 0; i < locations.length; i++) {
        marker = new google.maps.Marker({
        position: new google.maps.LatLng(locations[i][1], locations[i][2]),
        map: map,
        icon : iconURLPrefix+locations[i][3]+'.png',
    });
    markers.push(marker);
    console.log(markers);

    google.maps.event.addListener(marker, 'click', (function(marker, i) {
    return function() {
        infowindow.setContent(locations[i][0]);
        infowindow.open(map, marker);
    }
    })(marker, i));

    }
    function AutoCenter() {
        var bounds = new google.maps.LatLngBounds();
        $.each(markers, function (index, marker) {
            bounds.extend(marker.position);
        });
        map.fitBounds(bounds);
        }
    AutoCenter();
</script>

<?php include("bottom.inc.php");?>

