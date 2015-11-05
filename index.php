<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="HeyTaxi - Login" />
	<meta name="author" content="" />

	<title>HeyTaxi - Login</title>

	<link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="assets/css/bootstrap.css">
	<link rel="stylesheet" href="assets/css/neon-core.css">
	<link rel="stylesheet" href="assets/css/neon-theme.css">
	<link rel="stylesheet" href="assets/css/neon-forms.css">
	<link rel="stylesheet" href="assets/css/custom.css">

	<script src="assets/js/jquery-1.11.0.min.js"></script>
	<script>$.noConflict();</script>

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
<?php
include_once("includes/main.inc.php");
error_reporting(E_ERROR | E_PARSE);
header('Content-Type: text/html; charset=utf-8');

if($_SESSION['sess_admin_login_id'])
{
    echo '<script type="text/javascript"> window.location.replace("admin_welcome.php") </script>';
    exit();
}
if(is_post_back()) {
    $sql="select * from tbl_admin where admin_name='".$login_id."'";
    $result = db_query($sql);
    if ($line_raw = mysql_fetch_assoc($result)) {
        @extract($line_raw);
    if($admin_password==$_POST['password']){
        $_SESSION['sess_admin_login_id'] = $admin_name;
        $_SESSION['sess_admin_id'] 		 = $admin_id;
        $_SESSION['sess_admin_type'] 	 = $admin_type;		
        $update	="update tbl_admin set admin_last_login='".$adm_mysql_date_time."' where admin_id='".$admin_id."'";
        db_query($update);
        echo '<script type="text/javascript"> window.location.replace("admin_welcome.php") </script>';
        exit();
    } else {
        set_session_msg("Usuario o contraseña inválidos.");
    }
    }else{
        set_session_msg("Usuario o contraseña inválidos.");
    }
}
?>

</head>
<body class="page-body login-page login-form-fall">
    <div class="login-container">

        <div class="login-header login-caret">

                <div class="login-content">
                        <div class="login-progressbar-indicator">
                                <h3>43%</h3>
                                <span>logging in...</span>
                        </div>
                </div>

        </div>

        <div class="login-progressbar">
                <div></div>
        </div>

        <div class="login-form">

                <div class="login-content">
                    <div class="row">
                        <div class="col-sm-12">
                            <?php
                            if(isset($_GET['redirect'])){
                                ?>
                            <div class="msg-error alert alert-default">
                                La contraseña ha sido cambiada, vuelva a iniciar sesión
                            </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <div class="" <?php if($_SESSION['sess_msg']!=''){ ?> style="display: block!important;" <?php }  ?>>
                            <p><?=display_sess_msg();?></p>
                            
                        </div>

                        <form accept-charset="UTF-8" role="form" action="" method="post">

                                <div class="form-group">

                                        <div class="input-group">
                                                <div class="input-group-addon">
                                                        <i class="entypo-user"></i>
                                                </div>

                                                <input class="form-control" placeholder="Usuario" name="login_id" type="text" id="login_id" value="<?=$_POST['login_id']?>" alt="NOBLANK~Username~DM~">
                                        </div>

                                </div>

                                <div class="form-group">

                                        <div class="input-group">
                                                <div class="input-group-addon">
                                                        <i class="entypo-key"></i>
                                                </div>

                                                <input class="form-control" placeholder="Contraseña" name="password" type="password" value="<?=$_POST['password']?>" size="30" alt="NOBLANK~Password~DM~" >
                                        </div>

                                </div>

                                <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-block btn-login">
                                                <i class="entypo-login"></i>
                                                Entrar
                                        </button>
                                </div>
                        </form>

                </div>

        </div>

    </div>
<!-- Bottom scripts (common) -->
	<script src="assets/js/gsap/main-gsap.js"></script>
	<script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="assets/js/bootstrap.js"></script>
	<script src="assets/js/joinable.js"></script>
	<script src="assets/js/resizeable.js"></script>
	<script src="assets/js/neon-api.js"></script>
	<script src="assets/js/jquery.validate.min.js"></script>
	<script src="assets/js/neon-login.js"></script>


	<!-- JavaScripts initializations and stuff -->
	<script src="assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="assets/js/neon-demo.js"></script>

</body>
</html>