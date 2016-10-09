<?php
$menu_active = "taxiservicio";
require_once("includes/main.inc.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Boguie - Admin" />
	<meta name="author" content="" />

	<title>Boguie - Admin</title>

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">
        
        <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">
	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

<script type="text/javascript" src = "http://maps.google.com/maps/api/js?key=AIzaSyDrSJS7jcs8XNS1Azg0D4-zrO2Tq0ohtHg"></script>
<script src="assets/js/jquery-1.11.0.min.js"></script>
<script type="text/javascript">
    var markers = [];
    var infoWindowContent = [];
<?php
//SELECT * from nearest_driver as a inner join tbl_user as b where a.driver_email = b.email
//SELECT a.id, a.driver_email, a.latitude, a.longitude, b.fullname, b.id as user_id, b.mobile from nearest_driver as a inner join tbl_user as b where a.driver_email = b.email
//$query="SELECT a.id, a.driver_email, a.latitude, a.longitude, a.driver_status, b.fullname, b.id as user_id, b.mobile from nearest_driver as a inner join tbl_user as b where a.driver_email = b.email";
if(isset($_POST['buscar'])){
    $query = "SELECT 
	posicion.id, 
	posicion.driver_email, 
	posicion.latitude, 
	posicion.longitude, 
	posicion.driver_status, 
	taxista.fullname, 
	taxista.id as user_id, 
	taxista.mobile, 
	taxi.id as taxi_id, 
	taxi.cab_number 
from 
	nearest_driver as posicion 
	inner join tbl_user as taxista 
	inner join tbl_cab as taxi 
where 
	posicion.driver_email = taxista.email 
	and taxista.taxi = taxi.id
    and (taxista.fullname like '%".$_POST['buscar']."%'
    or taxista.id = '".$_POST['buscar']."')";    
}else{
    $query = "SELECT posicion.id, posicion.driver_email, posicion.latitude, posicion.longitude, posicion.driver_status, taxista.fullname, taxista.id as user_id, taxista.mobile, taxi.id as taxi_id, taxi.cab_number from nearest_driver as posicion inner join tbl_user as taxista inner join tbl_cab as taxi where posicion.driver_email = taxista.email and taxista.taxi = taxi.id";
}
    $result=mysql_query($query);
    $filas = mysql_num_rows($result);
    while($row = mysql_fetch_array($result)){
        $id = $row['id'];
        $title = $row['driver_email'];
        $lapt = $row['latitude'];
        $long = $row['longitude'];
        $status = $row['driver_status'];
        $driver_id = $row['user_id'];
        $fullname = $row['fullname'];
        $taxi_name = $row['cab_number'];
        $mobile = $row['mobile'];
        $email = $row['driver_email'];
        $icon;
        if($status=="available"){
            $icon = "images/available.png";
        }elseif ($status=="booked") {
            $icon = "images/booked.png";
        }  else {
            $icon = "images/cdn.png";
        }
        ?>
            markers.push(['<?php echo $fullname ?>', <?php echo $lapt ?>,<?php echo $long ?>, '<?php echo $icon ?>']);
            infoWindowContent.push(['<div class="mappop"><h4><a target=_blank href=view_driver.php?did=<?php echo $driver_id ?>><?php echo $fullname ?></a> - <?php echo $taxi_name ?></h4><p>Estado: <?php echo $status ?><br>Tel: <?php echo $mobile ?><br>Email: <?php echo $email ?><br></p></div>']);
        <?php
    }
    
if($filas > 0){
?>
$(document).ready(function initMap() {
    var styles = [
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "labels.text",
        "stylers": [
            {
                "visibility": "on"
            },
            {
                "hue": "#ff0000"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "#10ade4"
            },
            {
                "visibility": "on"
            }
        ]
    }
];
    var map;
    var bounds = new google.maps.LatLngBounds();
    var styledMap = new google.maps.StyledMapType(styles, {name: "Styled Map"});

    var mapOptions = {
        zoom: 11,
        streetViewControl:false,
        scrollwheel: true,
        mapTypeControl:false,
        mapTypeControlOptions: {
            mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
        }
    };
    
    map = new google.maps.Map(document.getElementById('map'), mapOptions);    
    map.mapTypes.set('map_style', styledMap);
    map.setMapTypeId('map_style');
    
    
      
      var infoWindow = new google.maps.InfoWindow(), marker, i;
      
      for( i = 0; i < markers.length; i++ ) {
            var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
            bounds.extend(position);
            marker = new google.maps.Marker({
                position: position,
                map: map,
                title: markers[i][0],
                icon: markers[i][3]
            });

            // Allow each marker to have an info window    
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infoWindow.setContent(infoWindowContent[i][0]);
                    infoWindow.open(map, marker);
                }
            })(marker, i));

            // Automatically center the map fitting all markers on the screen
            map.fitBounds(bounds);
        }
        
        // Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
        var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
            //this.setZoom(14);
            google.maps.event.removeListener(boundsListener);
        });
  }
);
<?php } ?>
</script>
<?php 
require_once("includes/main.inc.php");
if($_SESSION['sess_admin_id']==''){
	header("location:index.php");
}?>



<style>
    .buscar{
        padding-bottom: 10px;
        display: none;
    }
    .hideshow{
        margin: auto;
        font-size: 20px;
    }
    .hideshow a{
        background: #ebebeb;
        border-radius: 2px;
        padding: 5px;
        margin-top: 10px;
    }
</style>
</head>
<body class="page-body  page-fade">
    <div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
		<?php
			$title_bread = "Mapa de vehiculos en servivio";
			//include("top.inc.php");
		?>
                        <div class="row border_b">
    
                            <div class="col-sm-4 pull-left">
                                <h2><?php echo $title_bread; ?></h2>
                            </div>
                            <div class="col-sm-4 text-center">
                                <div class="hideshow">
                                    <a id="btn-buscar" class="bg" a href="javascript:void(0);">
                                        <i class="entypo-search"></i>
                                    </a>
                                </div>
                            </div>
    <!-- Profile Info and Notifications -->
                        <div class="col-sm-4 clearfix pull-right">

            <ul class="user-info pull-right pull-none-xsm">

                    <!-- Profile Info -->
                    <li class="profile-info dropdown"><!-- add class "pull-right" if you want to place this from right -->

                            <a href="admin_welcome.php" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="entypo-user"></i>
                                Bienvenido <strong><?php echo $_SESSION['sess_admin_login_id']; ?></strong>
                            </a>

                            <ul class="dropdown-menu">

                                    <!-- Reverse Caret -->
                                    <li class="caret"></li>

                                    <!-- Profile sub-links -->
                                    <li>
                                            <a href="change_pwd.php">
                                                    <i class="entypo-user"></i>
                                                    Cambiar contraseña
                                            </a>
                                    </li>

                                    <li>
                                            <a href="logout.php">
                                                    <i class="entypo-mail"></i>
                                                    Salir
                                            </a>
                                    </li>
                            </ul>
                                    </li>

                            </ul>
                    </div>
                </div>
            <div class="row buscar">
                <div class="col-sm-6">
                    <form  class="form-horizontal form-groups-b" action="" method="post">
                        <div class="input-group">
                            <input class="form-control" placeholder="Escriba el nombre o id del conductor" name="buscar" type="text">
                            <span class="input-group-btn">
                                <button class="btn btn-blue" type="submit">Buscar</button>
                            </span>
                        </div>
                    </form>
                </div>
                <div class="col-sm-6">
                    <div class="col-sm-4 text-center">
                        <img src="images/available.png" alt="Available">
                        <br>
                        Available
                    </div>
                    <div class="col-sm-4 text-center">
                        <img src="images/booked.png" alt="Booked">
                        <br>
                        Booked
                    </div>
                    <div class="col-sm-4 text-center">
                        <img src="images/cdn.png" alt="CDN">
                        <br>
                        CDN
                    </div>
                </div>
            </div>
            <?php
            
            if(isset($_POST['search']) && $_POST['buscar'] == "" || $filas <=0){
                ?>
            <div class="row">
                <div class="col-sm-12">
                    No hay resultados de búsqueda. <?php $filas ?>
                </div>
            </div>
                <?php
            }
            ?>
		<div class="row map-full">
                    <div id="map" style="width: 100%; height: 700px; background-color: gray"></div>    
                </div>
	</div>
    </div>


<!-- Imported styles on this page -->
	
        
        
	<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<!--<script src="assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>-->


	<!-- Imported scripts on this page -->
	<!--<script src="assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>-->
	<script src="assets/js/jquery.sparkline.min.js"></script>
	<script src="assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="assets/js/raphael-min.js"></script>
	<script src="assets/js/morris.min.js"></script>
	<script src="assets/js/toastr.js"></script>
	<!--<script src="assets/js/neon-chat.js"></script>-->


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>
        <script type="text/javascript">
            $("#btn-buscar").click(function(){
                $(".buscar").toggle( "fast" );
            });
        </script>
</body>
</html>