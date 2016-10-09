<style>
.sublinkshead {
    color: #A90108;
    font-size: 12px;
    font-weight: bold;
}
li{
    font-size: 13px;
}

#left_navbar{
	background:#eeeeee; 
	padding:10px; 
	width:230px;
	height: 102%;
}


</style>
<div id="left_navbar">
<ul>
<li><a href="admin_welcome.php"><strong>Bienvenido <?php echo $_SESSION['sess_admin_login_id']; ?></strong></a></li>

<li><br><b><span class="sublinkshead">Administrar categorias</span></b></li>
<li><a href="manage_category.php">Categorias de taxis</a></li>

<li><br><b><span class="sublinkshead">Administrar unidades</span></b></li>
<li><a href="manage_cab.php">Vehiculos</a></li>
<li><a href="map.php">Mapa de vehiculos</a></li>
<li><a href="taxi_driver.php">Vehiculos - Conductores</a></li>

<li><br><b><span class="sublinkshead">Administrar usuarios</span></b></li>
<li><a href="manage_driver.php">Conductores</a></li>
<li><a href="manage_passenger.php">Pasajeros</a></li>

<li><br><b><span class="sublinkshead">Reportes</span></b></li>
<li><a href="manage_reservations.php">Reservaciones</a></li>
<li><a href="ride_report.php">Reporte de servicios</a></li>
<li><a href="carrier_report.php">Por condunctor</a></li>
<li><a href="balance_report.php">Reporte de ingresos por taxis</a></li>
<li><a href="ride_report.php">Reporte de ingresos por servicios</a></li>


<li><br><b><span class="sublinkshead">Administrar</span></b></li>
<li><a href="manage_coupon.php">Cupones</a></li>
<li><a href="manage_points.php">Puntos Chiclayo</a></li>
<li><a href="manage_calendar.php">Calendario festivo</a></li>
<li><a href="send_notification.php">Enviar notificación</a></li>
<li><a href="manage_radio.php">Cambiar radio de busqueda</a></li>

<li><br><b><span class="sublinkshead">Plataforma</span></b></li>
<li><a href="page_list.php">Textos estaticos del app</a></li>
<li><a href="change_pwd.php">Cambiar contraseña de mi usuario</a></li>
<li><a href="logout.php">Salir</a></li> 
</ul>

</div>