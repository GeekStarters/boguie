<?php
$menu_active = "none";
include './header.php';
?><?php
require_once ('includes/main.inc.php'); 
if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}

if(isset($_POST['old_password'])){
    $pass_actual = $_POST['old_password'];
    $pass_uno = $_POST['password'];
    $pass_dos = $_POST['repassword'];

    if($pass_uno!=$pass_dos) {
            set_session_msg("La nueva contraseña no coincide, vuelve a intentarlo.");
    }else{
        $sql="select admin_password from tbl_admin where admin_id= '".$_SESSION['sess_admin_id']."' ";
        $result = db_query($sql);
        if ($line = mysql_fetch_array($result)) {
            $db_adm_password=$line['admin_password'];
            if($db_adm_password == $pass_actual) {
                    $sql="update tbl_admin set admin_password = '".$pass_uno."' where admin_id= '".$_SESSION['sess_admin_id']."'";
                    db_query($sql);
                    session_destroy();
                    set_session_msg("La contraseña ha sido cambiada, vuelva a iniciar sesión");
                    header("Location: index.php?redirect=1");
            }else {
                    set_session_msg("La contraseña actual es incorrecta.");
            }
        }
    }
}
?>

</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    $menu_active = "password";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
            <?php
                $title_bread = "Cambiar contraseña: ". $_SESSION['sess_admin_login_id'];
                include("top.inc.php");
            ?>
            <div class="row">
                <div class="col-sm-12">
                    
                <?php display_sess_msg(); ?>
                <center class="msg"><?=$msg;?></center>
                
                </div>
            </div>
            <div class="row margintop30">
                <div class="col-sm-12">
                    
<form class="form-horizontal form-groups-b" action="" method="post" name="form1" id="form1" onsubmit="return validate(this);"> 
        <div class="form-group">
            <label class="col-sm-3 control-label">Contraseña actual: <span class="star">*</span></label>
            <div class="col-sm-5">
                <input data-validation="required" data-validation-error-msg="Ingrese su contraseña actual" class="form-control" type="password" name="old_password" class="textfield">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-3 control-label">Nueva contraseña: <span class="star">*</span></label>
            <div class="col-sm-5">
                <input data-validation="required" data-validation-error-msg="Ingrese una nueva contraseña" class="form-control" type="password" name="password" class="textfield"> 
            </div>
        </div>
    <div class="form-group">
            <label class="col-sm-3 control-label">Confirmar nueva contraseña: <span class="star">*</span></label>
            <div class="col-sm-5">
                <input data-validation="required" data-validation-error-msg="Repita su nueva contraseña" class="form-control" type="password" name="repassword" class="textfield"> 
            </div>
        </div>
    
    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-5">
             <input class="btn btn-success" type="submit" value="Cambiar">
        </div>
    </div> 

  
 
  
  </form>
                </div>
            </div>
        </div>
</div>
<?php
include './footer.php';
?>
<script> $.validate(); </script>
</body>
</html>
                    