<div class="sidebar-menu-inner">
			
			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
                                    <a href="admin_welcome.php">
                                        <h1 style="padding: 0px !important;margin: 0px !important;color: white;font-weight: bold;font-size: 35px;">Boguie</h1>
					</a>
				</div>

				<!-- logo collapse icon -->
				<div class="sidebar-collapse">
					<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
						<i class="entypo-menu"></i>
					</a>
				</div>

								
				<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
				<div class="sidebar-mobile-menu visible-xs">
					<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
						<i class="entypo-menu"></i>
					</a>
				</div>

			</header>
			
									
			<ul id="main-menu" class="main-menu">
				<!-- add class "multiple-expanded" to allow multiple submenus to open -->
				<!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
				<li class=" <?php if($menu_active == "categorias"){?> active opened <?php } ?>">
					<a href="#">
						<i class="entypo-list-add"></i>
						<span class="title">Administrar categorias</span>
					</a>
					<ul>
                                            <li <?php if($menu_active == "categorias"){?> class="active" <?php } ?>>
							<a href="manage_category.php">
								<span class="title">Categorias de taxis</span>
							</a>
						</li>
					</ul>
				</li>
                                <li class="<?php if($menu_active == "taxi" || $menu_active == "taxiservicio"){?> active opened <?php } ?>">
					<a href="#">
						<i class="entypo-layout"></i>
						<span class="title">Administrar unidades</span>
					</a>
					<ul>
						<li <?php if($menu_active == "taxi"){?> class="active" <?php } ?>>
							<a href="manage_cab.php">
								<span class="title">Taxis</span>
							</a>
						</li>
						<li <?php if($menu_active == "taxiservicio"){?> class="active" <?php } ?>>
							<a href="map.php">
								<span class="title">En Servicio</span>
							</a>
						</li>
						<li>
							<a href="taxi_driver.php">
								<span class="title">Taxi - Taxista</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="<?php if($menu_active == "conductores" || $menu_active == "add_driver" || $menu_active == "pasajeros" || $menu_active == "add_passenger"){?> active opened <?php } ?>">
					<a href="#">
						<i class="entypo-users"></i>
						<span class="title">Administrar usuarios</span>
					</a>
					<ul>
                                            <li class="<?php if($menu_active == "conductores"){?> active<?php } ?>">
							<a href="manage_driver.php">
								<span class="title">Taxistas</span>
							</a>
						</li>
						<li class="<?php if($menu_active == "pasajeros" || $menu_active == "add_passenger"){?> active<?php } ?>">
							<a href="manage_passenger.php">
								<span class="title">Pasajeros</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="<?php if($menu_active == "reservaciones" || $menu_active == "carrera_taxista" || $menu_active == "carrera_cliente" || $menu_active == "carreras" || $menu_active == "ingresoscarreras" || $menu_active == "balance" || $menu_active == "porconductor" || $menu_active == "ingresos"){?> active opened <?php } ?>">
					<a href="#">
						<i class="entypo-docs"></i>
						<span class="title">Reportes</span>
					</a>
					<ul>
						<li class="<?php if($menu_active == "reservaciones"){?> active<?php } ?>">
							<a href="manage_reservations.php">
								
								<span class="title">Reservaciones</span>
							</a>
						</li>
						<!--<li  class="<?php if($menu_active == "carreras"){?> active<?php } ?>">
							<a href="ride_report.php">
								
								<span class="title">Reporte de servicios</span>
							</a>
						</li>-->
                                                <li  class="<?php if($menu_active == "carrera_cliente"){?> active<?php } ?>">
                                                    <a href="carreras_cliente.php">
								
								<span class="title">Reporte - Servicios por Cliente</span>
							</a>
						</li>
                                                <li  class="<?php if($menu_active == "carrera_taxista"){?> active<?php } ?>">
							<a href="carreras_taxista.php">
								
								<span class="title">Reporte - Servicios por Taxista</span>
							</a>
						</li>
						<!--<li class="<?php if($menu_active == "porconductor"){?> active<?php } ?>">
							<a href="carrier_report.php">
								
								<span class="title">Por conductor</span>
							</a>
						</li>
                                                <li class="<?php if($menu_active == "balance"){?> active<?php } ?>">
							<a href="balance_report.php">
								
								<span class="title">Reporte de ingresos por taxis</span>
							</a>
						</li>
                                                <li>
							<a href="ride_report.php">
								
								<span class="title">Reporte de ingresos por carreras</span>
							</a>
						</li>-->
					</ul>
				</li>
				<li class="<?php if($menu_active == "cupones" || $menu_active == "descuento" ||  $menu_active == "tdestino" || $menu_active == "torigen" || $menu_active == "puntos" || $menu_active == "calendario" || $menu_active == "notificacion" || $menu_active == "radio"){?>opened active<?php } ?>">
					<a href="#">
						<i class="entypo-cog"></i>
						<span class="title">Administrar</span>
					</a>
					<ul>
                                           
						<li class="<?php if($menu_active == "cupones"){?> active<?php } ?>">
							<a href="manage_coupon.php">
								<span class="title">Cupones de descuento</span>
							</a>
						</li>
						<li class="<?php if($menu_active == "calendario"){?> active<?php } ?>">
							<a href="manage_calendar.php">
								<span class="title">Calendario festivo</span>
							</a>
						</li>
						<li class="<?php if($menu_active == "notificacion"){?> active<?php } ?>">
							<a href="send_notification.php">
								<span class="title">Enviar notificación</span>
							</a>
						</li>
						<li class="<?php if($menu_active == "radio"){?> active<?php } ?>">
							<a href="manage_radio.php">
								<span class="title">Cambiar radio de busqueda</span>
							</a>
						</li>
                            <li class="<?php if($menu_active == "torigen"){?> active<?php } ?>">
							<a href="manage_torigen.php">
								<span class="title">Tarifas</span>
							</a>
						</li>
					</ul>
				</li>
				<li class="<?php if($menu_active == "textos" || $menu_active == "password"){?>opened active<?php } ?>">
					<a href="#">
						<i class="entypo-window"></i>
						<span class="title">Plataforma</span>
					</a>
					<ul>
						<li class="<?php if($menu_active == "textos"){?> active<?php } ?>">
							<a href="page_list.php">
								<span class="title">Textos estaticos del app</span>
							</a>
						</li>
						<li class="<?php if($menu_active == "password"){?> active<?php } ?>">
							<a href="change_pwd.php">
								<span class="title">Cambiar contraseña de mi usuario</span>
							</a>
						</li>
                                                <li>
							<a href="logout.php">
								<span class="title">Salir</span>
							</a>
						</li>
					</ul>
				</li>
				
				
			</ul>
			
		</div>