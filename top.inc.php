<?php //include("header.inc.php");?>

<div class="row border_b">
    
    <div class="col-sm-8 pull-left">
        <h2><?php echo $title_bread; ?></h2>
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