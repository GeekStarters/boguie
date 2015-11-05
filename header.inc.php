<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">
<link href="iamedia.css" rel="stylesheet" type="text/css">
<script language="javascript" src="ajax7.js"></script>
<script language="javascript" src="ajax1.js"></script>
<script language="javascript" src="ajax10.js"></script>
<script language="javascript" src="../js/validation.js"></script>

<link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
<link href="dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
<link href="dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
<link href="plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />
<link href="plugins/morris/morris.css" rel="stylesheet" type="text/css" />
<link href="plugins/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
<link href="plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
<body class="skin-blue sidebar-mini">
    <div class="wrapper">
      <header class="main-header">
        <nav class="navbar navbar-static-top" role="navigation">
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- User Account: style can be found in dropdown.less -->
              <? if($_SESSION['sess_admin_id']!=""){?>
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <span class="hidden-xs">Bienvenido <?php echo $_SESSION["sess_admin_login_id"];?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <p>
                        <?php echo $_SESSION["sess_admin_login_id"];?>
                        <small>Member since Nov. 2012</small>
                      </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="change_pwd.php" class="btn btn-default btn-flat">Cambiar contraseña</a>
                      </div>
                      <div class="pull-right">
                        <a href="logout.php" class="btn btn-default btn-flat">Salir</a>
                      </div>
                    </li>
                  </ul>
                </li>
              <? }?>
              <!-- Control Sidebar Toggle Button -->
              <li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>
            </ul>
          </div>

        </nav>
  
  
</header>
