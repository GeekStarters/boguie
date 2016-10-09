<?php
$menu_active = "add_driver";
include './header.php';
?>
<?php
require_once("includes/main.inc.php");
include_once('thumbnail.inc.php');
@extract($_POST);
$id = $_GET['id'];

if (isset($_REQUEST['set_flag']) && $_REQUEST['set_flag'] == 'update') {
    $category_id = $_REQUEST['category_id'];
    $sql_fectch_city = mysql_query("select * from tbl_user  where id=$id and usertype='driver'") or die(mysql_error());
    $fetch_record = mysql_fetch_array($sql_fectch_city);
    @extract($fetch_record);
}

/* * **************************** Add A new CAB ************************************ */
if (isset($_REQUEST['submit'])) {
    $found = mysql_num_rows(db_query("select * from tbl_user where card_num='$_REQUEST[email]'"));

    if ($found == 0) {
        $found_dni = mysql_num_rows(db_query("select * from tbl_user where dni='$_REQUEST[dni]'"));
        if ($found_dni ==0) {
            $fullname = addslashes($_REQUEST['fullname']);
            $email = $_REQUEST['email'];
            $password = addslashes($_REQUEST['password']);
            $mobile = $_REQUEST['mobile'];
            //$name_on_card = addslashes($_REQUEST['name_on_card']);
            //$card_num = $_REQUEST['card_num'];
            //$exp_date = $_REQUEST['exp_date'];
            //$cvv_num = $_REQUEST['cvv_num'];
            $balance = $_REQUEST['balance'];
            $dni = $_REQUEST['dni'];
            $address = $_REQUEST['address'];
            $paid_yet = $_REQUEST['paid_yet'];
            $add_date = $_REQUEST['add_date'];
            $usertype = $_REQUEST['usertype'];
            $status= $_REQUEST['status_id'];

            if ($_FILES[image][size] > 0) {
                $driver_images_1 = md5(uniqid(rand(), true)) . '.' . file_ext($_FILES[image]['name']);
                $driver_images_1 = str_replace(' ', '-', $driver_images_1);
                copy($_FILES[image]['tmp_name'], "./profile_pic/" . $driver_images_1) or die("Error: Imagen no guardada");

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
            taxi = '$taxi_id',
            dni = '$dni',
            address = '$address',
            balance='$balance',
            paid_yet='$paid_yet',
            add_date ='$add_date',
            usertype = '$usertype',
            image='$driver_images_1',
            status='$status'") or die(mysql_error());

            if ($taxi_id != "") {
                $sql_update = mysql_query("update tbl_cab set with_driver='1' where id='" . $taxi_id . "'") or die(mysql_error());
            }
            

             set_session_msg("Taxista actualizado correctamente");
            ?>
        <script language="javascript">location.href = 'manage_driver.php'</script>
        <?php
        exit;
        }else{
            set_session_msg("Error: DNI duplicado.");
        }
    } else {
        set_session_msg("Error: Condutor ya existe.");
    }
}

/* * *************************************************************************************************** */
if (isset($_REQUEST['update'])) {
    $found = mysql_num_rows(db_query("select * from tbl_user where card_num='$_REQUEST[email]' and id !='$_GET[id]'"));
    if ($found == 0) {
        $found_dni = mysql_num_rows(db_query("select * from tbl_user where dni='$_REQUEST[dni]' and id !='$_GET[id]'"));
        if ($found_dni ==0) {
            $fullname = addslashes($_REQUEST['fullname']);
            $email = $_REQUEST['email'];
            $password = addslashes($_REQUEST['password']);
            $mobile = $_REQUEST['mobile'];
            $address= $_REQUEST['address'];
            //$name_on_card = addslashes($_REQUEST['name_on_card']);
            //$card_num = $_REQUEST['card_num'];
            //$exp_date = $_REQUEST['exp_date'];
            //$cvv_num = $_REQUEST['cvv_num'];
            //$balance = $_REQUEST['balance'];
            $dni = $_REQUEST['dni'];
            $paid_yet = $_REQUEST['paid_yet'];
            $add_date = $_REQUEST['add_date'];
            $usertype = $_REQUEST['usertype'];
            $status= $_REQUEST['status_id'];
            
            
            if ($_FILES[image][tmp_name]!='') {
                $cat_res = mysql_fetch_array(db_query("select * from tbl_user where id='$id'"));
                if (strlen($cat_res[image]) && file_exists("./profile_pic/" . $cat_res[image])) {
                    unlink("./profile_pic/" . $cat_res[image]);
                    unlink("./profile_pic/large/" . $cat_res[image]);
                }
                $driver_images_1 = md5(uniqid(rand(), true)) . '.' . file_ext($_FILES[image]['name']);
                copy($_FILES[image]['tmp_name'], "./profile_pic/" . $driver_images_1) or die("Error: Imagen no guardada");

                $thumb2 = new Thumbnail("./profile_pic/$driver_images_1");
                $thumb2->resize("600", "725");
                $thumb2->save("./profile_pic/large/$driver_images_1", "100%");

                $thumb = new Thumbnail("./profile_pic/$driver_images_1");
                $thumb->resize("150", "200");
                $thumb->save("./profile_pic/$driver_images_1", "100%");

                db_query("update tbl_user set image='" . $driver_images_1 . "' where id='" . $id . "'");
            }
           
            if ($taxi_id != "") {
                $sql_update = mysql_query("update tbl_cab set with_driver='0' where id='" . $fetch_record['taxi'] . "'") or die(mysql_error());
                $sql_update = mysql_query("update tbl_cab set with_driver='1' where id='" . $taxi_id . "'") or die(mysql_error());
            }elseif ($taxi_id == "") {
                $sql_update = mysql_query("update tbl_cab set with_driver='0' where id='" . $fetch_record['taxi'] . "'") or die(mysql_error());
            }

            $mysql_var = "update tbl_user set
    		fullname='$fullname',
    		email='$email',
    		password ='$password',
    		mobile = '$mobile',
                taxi = '$taxi_id',
                dni = '$dni',
                address = '$address',
    		balance='$balance',
    		paid_yet='$paid_yet',
    		add_date ='$add_date',
    		usertype = '$usertype',
    		status='$status' where id='" . $id . "'";
            $sql_update = mysql_query($mysql_var) or die(mysql_error());
            set_session_msg("Taxista actualizado correctamente");
            ?>
            
        <script language="javascript">location.href = 'manage_driver.php'</script>
      <?php
        exit;
        }else{
            set_session_msg("Error: DNI duplicado.");
        }
    } else {
        set_session_msg("Error: Condutor ya existe.");
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
                    $title_bread = "Editar Taxista";
                }else{
                    $title_bread = "Agregar Taxista"; }
                    include("top.inc.php");
		?>
		<div class="row">
                <div class="col-sm-12">
                    <center class="msg"><?=$msg;?></center>
                    <?=display_sess_msg()?>
                </div>
            </div>
		<div class="row">

            <form method="post" class="form-horizontal form-groups-b" action="" name="form2" id="form2" enctype="multipart/form-data">
             <div class="form-group">
                <label class="col-sm-3 control-label" >Taxi<span class="star">*</span></label>
                <div class="col-sm-5">
                    <select class="form-control" name="taxi_id" id="taxi_id">
                            <option value="">Sin taxi</option>
                            <?php $sel="SELECT * FROM `tbl_cab`";
                            $exe=mysql_query($sel) or die("can't access");
                            while($data=mysql_fetch_array($exe)){?> 
                            <? if($fetch_record['taxi']==$data['id']){?>
                                <option value="<?=$data['id']?>" <? { echo "selected"; }?>><?=$data['cab_number']?></option>
                            <? }else{ ?>
                                <option value="<?=$data['id']?>"><?=$data['cab_number']?></option>
                            <? }?>
                            <? }?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">DNI<span class="star">*</span></label>
                <div class="col-sm-5">
                    <input data-validation="custom" data-validation-regexp="^[\w-]+$" data-validation="required" data-validation-error-msg="Ingrese un DNI válido" class="form-control" name="dni" id="dni" size="48" type="text" value="<?= stripslashes($dni) ?>" />
                </div>
            </div>        
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Nombre<span class="star">*</span></label>
                <div class="col-sm-5">
                     <input data-validation="custom" data-validation-regexp="^[a-zA-ZáéíóúàèìòùÀÈÌÒÙÁÉÍÓÚñÑüÜ ]+$" data-validation="required" data-validation-error-msg="Ingrese un nombre válido" class="form-control" name="fullname" id="fullname" size="48" type="text" value="<?= stripslashes($fullname) ?>" />
                </div>
            </div>
             <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Email <span class="star">*</span></label>
                <div class="col-sm-5">
                      <input data-validation="email" data-validation="required" data-validation-error-msg="Ingrese un e-mail válido" class="form-control" name="email" id="email"  size="48" type="email" value="<?= $email ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Password <span class="star">*</span></label>
                <div class="col-sm-5">
                      <input data-validation="required" data-validation-error-msg="Debes ingresar una contraseña" class="form-control" name="password"  id="password" size="48" type="password" value="<?= $password ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Móvil<span class="star">*</span></label>
                <div class="col-sm-5">
                      <input data-validation="custom" data-validation-regexp="^(\d+-?)+\d+$" data-validation="required" data-validation-error-msg="Ingrese un número de teléfono válido" class="form-control" name="mobile"  id="mobile" size="48" type="text" value="<?= $mobile ?>" />
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Dirección<span class="star">*</span></label>
                <div class="col-sm-5">
                      <input data-validation="required" data-validation-error-msg="Ingrese una dirección" class="form-control" name="address"  id="address" size="48" type="text" value="<?= stripslashes($address) ?>" />
                </div>
            </div>
            
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Foto Taxista</label>
                <div class="col-sm-5">
                      <input class="form-control" name="image" type="file" >
                      <?php if($_REQUEST['set_flag'] == 'update'){?>
                      Imagen Actual: <br>
                      <?php if ($image) { ?>
                                <img src="./profile_pic/<?= $image ?>" border="0" width="102" height="102"><br>
                            <?php }
                      }?>
                </div>
            </div>
                    
                    
                    
                    
                    
                    
                    


                    <!-- <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr> -->
                    <!-- <tr>
                        <td class="lightGrayBg" width="20%">Balance<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="balance"  size="48" type="text" value="<?= stripslashes($balance) ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Pagado<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="paid_yet" size="48" type="text" value="<?= $paid_yet ?>" /></td>
                    </tr> -->
            <div class="form-group">
                <label class="col-sm-3 control-label" for="pickup_address">Miembro desde<span class="star">*</span></label>
                <div class="col-sm-5">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="entypo-calendar"></i></span>
                        <input data-validation="required" data-validation-error-msg="Seleccione fecha" class="form-control" name="add_date" readonly id="add_date" size="48" type="text" value="<?= $add_date ?>" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" >Estado</label>
                <div class="col-sm-5">
                    <select class="form-control" name="status_id" id="status_id">
                            <option <?php if($status=="Active"){ echo " selected "; } ?>value="1">Activado</option>
                            <option <?php if($status=="Inactive"){ echo " selected "; } ?>value="2">Desactivado</option>

                    </select>
<?php //echo $status; ?>
                </div>
            </div>
             <div class="form-group">
                 <div class="col-sm-offset-3 col-sm-5">
                    <input name="usertype" size="48" type="text" style="display:none" value="<?= driver ?>" />
                    <a class="btn btn-default" href="<?= $_SERVER[HTTP_REFERER] ?>">Volver </a>
                    <?php if ($_REQUEST['set_flag'] == 'update') { ?>
                        <input type="submit" class="btn btn-info"  name="update" value='Actualizar' >
                    <?php } else { ?>
                        <input type="submit" class="btn btn-info" name="submit" value='Guardar' >
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
<script type="text/javascript">
  $(function() {
    $('#add_date').datepicker({ 
        dateFormat: 'yy-mm-dd',
        yearRange: "1990:<?php echo date("Y");?>",
        changeMonth: true,
        changeYear: true}).val();

    $( "#add_date_img" ).click(function() {
        $('#add_date').datepicker('show');
    });

  });

  /*function validate(){
    valor = $("#fare_per_km").val();
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if(!$("#dni").val()) {
        alert("Ingrese DNI");
        return false;
    }else if(!$("#fullname").val()) {
        alert("Ingrese nombre");
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
    }else if(!$("#address").val()) {
        alert("Ingrese dirección");
        return false;
    }else if(!$("#add_date").val()) {
        alert("Ingrese fecha");
        return false;
    }

     return true;

  }*/
</script>
<script> $.validate(); </script>
</body>
</html>