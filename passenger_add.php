<?php
$menu_active = "add_passenger";
include './header.php';
?>
<?php
require_once("includes/main.inc.php");
include_once('thumbnail.inc.php');
@extract($_POST);
$id = $_GET['id'];

if (isset($_REQUEST['set_flag']) && $_REQUEST['set_flag'] == 'update') {
    $category_id = $_REQUEST['category_id'];
    $sql_fectch_city = mysql_query("select * from tbl_user  where id=$id and usertype='passenger'") or die(mysql_error());
    $fetch_record = mysql_fetch_array($sql_fectch_city);
    @extract($fetch_record);
    $own_email = $fetch_record['email'];
}

/* * **************************** Add A new CAB ************************************ */
if (isset($_REQUEST['submit'])) {
    $found = mysql_num_rows(db_query("select * from tbl_user where email='".$_REQUEST['email']."'"));

    if ($found == 0) {
        $fullname = addslashes($_REQUEST['fullname']);
        $email = $_REQUEST['email'];
        $password = addslashes($_REQUEST['password']);
        $mobile = $_REQUEST['mobile'];
        $name_on_card = addslashes($_REQUEST['name_on_card']);
        $card_num = $_REQUEST['card_num'];
        $exp_date = $_REQUEST['exp_date'];
        $cvv_num = $_REQUEST['cvv_num'];
        $balance = $_REQUEST['balance'];
        $paid_yet = $_REQUEST['paid_yet'];
        $add_date = $_REQUEST['add_date'];
        $usertype = $_REQUEST['usertype'];
        $status = $_REQUEST['status'];
        $birthday = $_REQUEST['birthday'];

        if ($_FILES[image][size] > 0) {
            $driver_images_1 = md5(uniqid(rand(), true)) . '.' . file_ext($_FILES[image]['name']);
            $driver_images_1 = str_replace(' ', '-', $driver_images_1);
            copy($_FILES[image]['tmp_name'], "./profile_pic/" . $driver_images_1) or die("Imagen no subida");

            $thumb2 = new Thumbnail("./profile_pic/$driver_images_1");
            $thumb2->resize("600", "725");
            $thumb2->save("./profile_pic/large/$driver_images_1", "100%");

            $thumb = new Thumbnail("./profile_pic/$driver_images_1");
            $thumb->resize("150", "200");
            $thumb->save("./profile_pic/$driver_images_1", "100%");
        }

        $sql_insert = mysql_query("insert into tbl_user set
		fullname='$fullname',
		email='$email',
		password ='$password',
		mobile = '$mobile',
		name_on_card='$name_on_card',
		card_num='$card_num',
		exp_date ='$exp_date',
		cvv_num = '$cvv_num',
        birthday ='$birthday',
		balance='$balance',
		paid_yet='$paid_yet',
		add_date ='$add_date',
		usertype = '$usertype',
		image='$driver_images_1',
		status='1'") or die(mysql_error());

        set_session_msg("Pasajero ha sido guardado correctamente");
        ?>

        <script language="javascript">location.href = 'manage_passenger.php'</script>
        <?php
        exit;
    } else {
        set_session_msg("El pasajero ya existe.");
    }
}

/* * *************************************************************************************************** */
if (isset($_REQUEST['update'])) {
    $email = $_REQUEST['email'];
    $found = mysql_num_rows(db_query("select * from tbl_user where email='".$_REQUEST['email']."' and email !='".$own_email."';"));
    if ($found == 0) {
        $fullname = addslashes($_REQUEST['fullname']);
        $email = $_REQUEST['email'];
        $password = addslashes($_REQUEST['password']);
        $mobile = $_REQUEST['mobile'];
        //$name_on_card	=	addslashes($_REQUEST['name_on_card']);
        //$card_num = $_REQUEST['card_num'];
        //$exp_date = $_REQUEST['exp_date'];
        //$cvv_num = $_REQUEST['cvv_num'];
        //$balance = $_REQUEST['balance'];
        //$paid_yet = $_REQUEST['paid_yet'];
        $add_date = $_REQUEST['add_date'];
        $usertype = $_REQUEST['usertype'];
        $status = $_REQUEST['status'];
        $birthday = $_REQUEST['birthday'];

        if ($_FILES[image][size] > 0) {
            $cat_res = mysql_fetch_array(db_query("select * from tbl_user where id='$id'"));
            if (strlen($cat_res[image]) && file_exists("cab_images/" . $cat_res[image])) {
                unlink("./profile_pic/" . $cat_res[image]);
                unlink("./profile_pic/large/" . $cat_res[image]);
            }
            $driver_images_1 = md5(uniqid(rand(), true)) . '.' . file_ext($_FILES[image]['name']);
            copy($_FILES[image]['tmp_name'], "./profile_pic/" . $driver_images_1) or die("Imagen no subida");

            $thumb2 = new Thumbnail("./profile_pic/$driver_images_1");
            $thumb2->resize("600", "725");
            $thumb2->save("./profile_pic/large/$driver_images_1", "100%");

            $thumb = new Thumbnail("./profile_pic/$driver_images_1");
            $thumb->resize("150", "200");
            $thumb->save("./profile_pic/$driver_images_1", "100%");

            db_query("update tbl_user set image='" . $driver_images_1 . "' where id='" . $id . "'");
        }

        $sql_update = mysql_query("update tbl_user set
		fullname='$fullname',
		email='$email',
		password ='$password',
		mobile = '$mobile',
		birthday ='$birthday',
		add_date ='$add_date',
		usertype = '$usertype',
		status='1' where id='" . $id . "'") or die(mysql_error());

        set_session_msg("Pasajero actualizado");
        ?>
        <script language="javascript">location.href = 'manage_passenger.php'</script>
        <?php
        exit;
    } else {
        set_session_msg("Este email ya existe.");
    }
}

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
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
                if ($_REQUEST['set_flag'] == 'update'){
                    $title_bread = "Editar pasajero";
                }else{
                    $title_bread = "Agregar pasajero"; }
                    include("top.inc.php");
		?>
		<div class="row">
                <div class="col-sm-12">
                    <center class="msg"><?=$msg;?></center>
                    <?=display_sess_msg()?>
                </div>
            </div>
		<div class="row margintop30">
 
            <form class="form-horizontal form-groups-b" method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate(this);">
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pickup_address">Nombre<span class="star">*</span></label>
                    <div class="col-sm-5">
                        <input data-validation="custom" data-validation-regexp="^[a-zA-Z ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" class="form-control" name="fullname" id="fullname"  size="48" type="text" value="<?= stripslashes($fullname) ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pickup_address">Email <span class="star">*</span></label>
                    <div class="col-sm-5">
                        <input data-validation="email" data-validation="required" data-validation-error-msg="Ingrese un e-mail válido" name="email" id="email" class="form-control"  size="48" type="email" value="<?= $email ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pickup_address">Password<span class="star">*</span></label>
                    <div class="col-sm-5">
                        <input data-validation="required" data-validation-error-msg="Ingrese una contraseña" name="password" class="form-control" id="password"  size="48" type="password" value="<?= $password ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pickup_address">Móvil<span class="star">*</span></label>
                    <div class="col-sm-5">
                        <input data-validation="custom" data-validation-regexp="^(\d+-?)+\d+$" data-validation="required" data-validation-error-msg="Ingrese un número de teléfono válido" name="mobile" class="form-control"  id="mobile" size="48" type="text" value="<?= $mobile ?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pickup_address">Avatar</label>
                    <div class="col-sm-5">
                        <input name="image" class="form-control" type="file" >
                         <?php if ($image) { ?>
                        Imagen Actual: <br>
                            <img src="./profile_pic/<?= $image ?>" border="0" width="102" height="102">
                        <?php } ?>
                    </div>
                </div>
                
               
                        
                    <!--<tr>
                            <td class="lightGrayBg" width="20%">Name on Card<span class="star">*</span></td>
                            <td class="lightGrayBg"><input name="name_on_card"  size="48" type="text" value="<?= stripslashes($name_on_card) ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                            <td class="lightGrayBg" valign="top" nowrap>Card Number<span class="star">*</span></td>
                            <td class="lightGrayBg"><input name="card_num" size="48" type="text" value="<?= $card_num ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                            <td class="lightGrayBg" valign="top" nowrap>Expiry Date<span class="star">*</span></td>
                            <td class="lightGrayBg"><input name="exp_date" size="48" type="text" value="<?= $exp_date ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                            <td class="lightGrayBg" valign="top" nowrap>Cvv Number<span class="star">*</span></td>
                            <td class="lightGrayBg"><input name="cvv_num" size="48" type="text" value="<?= $cvv_num ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                            <td class="lightGrayBg" width="20%">Balance<span class="star">*</span></td>
                            <td class="lightGrayBg"><input name="balance"  size="48" type="text" value="<?= stripslashes($balance) ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                            <td class="lightGrayBg" valign="top" nowrap>Paid yet<span class="star">*</span></td>
                            <td class="lightGrayBg"><input name="paid_yet" size="48" type="text" value="<?= $paid_yet ?>" /></td>
                    </tr>-->
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pickup_address">Miembro desde</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                        <input class="form-control"  id="add_date"  readonly name="add_date" size="48" type="text" value="<?= $add_date ?>" />
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-3 control-label" for="pickup_address">Fecha de nacimiento</label>
                    <div class="col-sm-5">
                        <div class="input-group">
                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                        <input class="form-control"  id="add_date2"  readonly name="birthday" size="48" type="text" value="<?= $birthday ?>" />
                        </div>
                    </div>
                </div>
                
                <input style="display:none" name="usertype" size="48" type="text" value="<?= passenger ?>" />
                    
                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-5">
                        <a  class="btn btn-default" href="<?= $_SERVER[HTTP_REFERER] ?>">Volver </a>
                        <?php if ($_REQUEST['set_flag'] == 'update') { ?>
                            <input type="submit" class="btn btn-info"  name="update" value='Actualizar' >
                        <?php } else { ?>
                            <input type="submit" class="btn btn-info"  name="submit" value='Guardar' >
                        <?php } ?>
                    </div>
                </div>
                    
                                
            </form>
            <br />
            <?php include("paging.inc.php"); ?>
        </td>
    </tr>
</table>
</div>
	</div>
</div>
<?php
include './footer.php';
?>


<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  $(function() {
    $('#add_date').datepicker({ 
        dateFormat: 'yy-mm-dd', 
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:<?php echo date("Y");?>",
  }).val();

    $( "#add_date_img" ).click(function() {
        $('#add_date').datepicker('show');
    });

    $('#add_date2').datepicker({ 
        dateFormat: 'yy-mm-dd',
        changeMonth: true,
        changeYear: true,
        yearRange: "1990:<?php echo date("Y");?>",
    }).val();

    $( "#add_date_img2" ).click(function() {
        $('#add_date2').datepicker('show');
    });

  });

  /*function validate(){
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if(!$("#fullname").val()) {
        alert("Seleccione nombre");
        return false;
     }else if(!regex.test($('#email').val().trim())) {
        alert("Email invalido");
        return false;
    }else if(!$("#password").val()) {
        alert("Ingrese contraseña");
        return false;
    }else if(!$("#mobile").val()) {
        alert("Ingrese movil");
        return false;
    }



     return true;

  }*/
</script>
<script> $.validate(); </script>
</body>
</html>