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
            $status = $_REQUEST['status'];

            if ($_FILES[image][size] > 0) {
                $driver_images_1 = md5(uniqid(rand(), true)) . '.' . file_ext($_FILES[image]['name']);
                $driver_images_1 = str_replace(' ', '-', $driver_images_1);
                copy($_FILES[image]['tmp_name'], "../profile_pic/" . $driver_images_1) or die("Error: Imagen no guardada");

                $thumb2 = new Thumbnail("../profile_pic/$driver_images_1");
                $thumb2->resize("600", "725");
                $thumb2->save("../profile_pic/large/$driver_images_1", "100%");

                $thumb = new Thumbnail("../profile_pic/$driver_images_1");
                $thumb->resize("150", "200");
                $thumb->save("../profile_pic/$driver_images_1", "100%");
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
            status='1'") or die(mysql_error());

            if ($taxi_id != "") {
                $sql_update = mysql_query("update tbl_cab set with_driver='1' where id='" . $taxi_id . "'") or die(mysql_error());
            }
            

            set_session_msg("Conductor guardado correctamente");
        }else{
            set_session_msg("DNI duplicado.");
        }
        
        ?>

        <script language="javascript">location.href = 'manage_driver.php'</script>
        <?
        exit;
    } else {
        set_session_msg("Condutor ya existe.");
    }
}

/* * *************************************************************************************************** */
if (isset($_REQUEST['update'])) {
    $found = mysql_num_rows(db_query("select * from tbl_user where card_num='$_REQUEST[email]' and id !='$_GET[id]'"));
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
            //$balance = $_REQUEST['balance'];
            $dni = $_REQUEST['dni'];
            $paid_yet = $_REQUEST['paid_yet'];
            $add_date = $_REQUEST['add_date'];
            $usertype = $_REQUEST['usertype'];
            $status = $_REQUEST['status'];

            if ($_FILES[image][size] > 0) {
                $cat_res = mysql_fetch_array(db_query("select * from tbl_user where id='$id'"));
                if (strlen($cat_res[image]) && file_exists("cab_images/" . $cat_res[image])) {
                    unlink("../profile_pic/" . $cat_res[image]);
                    unlink("../profile_pic/large/" . $cat_res[image]);
                }
                $driver_images_1 = md5(uniqid(rand(), true)) . '.' . file_ext($_FILES[image]['name']);
                copy($_FILES[image]['tmp_name'], "../profile_pic/" . $driver_images_1) or die("Error: Imagen no guardada");

                $thumb2 = new Thumbnail("../profile_pic/$driver_images_1");
                $thumb2->resize("600", "725");
                $thumb2->save("../profile_pic/large/$driver_images_1", "100%");

                $thumb = new Thumbnail("../profile_pic/$driver_images_1");
                $thumb->resize("150", "200");
                $thumb->save("../profile_pic/$driver_images_1", "100%");

                db_query("update tbl_user set image='" . $driver_images_1 . "' where id='" . $id . "'");
            }
           
            if ($taxi_id != "") {
                $sql_update = mysql_query("update tbl_cab set with_driver='0' where id='" . $fetch_record['taxi'] . "'") or die(mysql_error());
                $sql_update = mysql_query("update tbl_cab set with_driver='1' where id='" . $taxi_id . "'") or die(mysql_error());
            }elseif ($taxi_id == "") {
                $sql_update = mysql_query("update tbl_cab set with_driver='0' where id='" . $fetch_record['taxi'] . "'") or die(mysql_error());
            }

            $sql_update = mysql_query("update tbl_user set
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
    		status='1' where id='" . $id . "'") or die(mysql_error());

            set_session_msg("Conductor actualizado correctamente");
        }else{
            set_session_msg("DNI duplicado.");
        }
        ?>
        <script language="javascript">location.href = 'manage_driver.php'</script>
        <?
        exit;
    } else {
        set_session_msg("Condutor ya existe.");
    }
}

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script language="javascript" src="js/admin.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ajax_scab.js"></script>
<script language="javascript" src="../js/jquery-1.3.2.min.js"></script>

<? include("top.inc.php"); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  $(function() {
    $('#add_date').datepicker({ dateFormat: 'yy-mm-dd'}).val();

    $( "#add_date_img" ).click(function() {
        $('#add_date').datepicker('show');
    });

  });

  function validate(){
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

  }
</script>


<center class="msg"><?= $msg; ?></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td id="pageHead"><div id="txtPageHead"><?php if ($_REQUEST['set_flag'] == 'update') echo "Editar conductor";
else echo "Agregar conductor"; ?></div></td></tr>
</table>
<div align="right" style="padding-right:5px;"><a href="<?= $_SERVER[HTTP_REFERER] ?>"><<<<< Volver </a></div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td id="content" align="center"><strong class="msg"><?= display_sess_msg() ?></strong>
            <form method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate();">
                <br />
                <table  border="0" width="70%"align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                    <tr align="center">
                        <th colspan="2"><? if ($_REQUEST['set_flag'] == 'update') echo "Editar conductor";
                    else echo "Agregar conductor"; ?></th>
                    </tr>
                    <tr><td height="10"></td></tr>
                    <tr>
                        <td class="lightGrayBg" width="20%">Vehiculo</td>
                        <td class="tdLabel"><select name="taxi_id" id="taxi_id" style="width:200px; "/>
                            <option value="">Sin taxi</option>
                            <?php $sel="SELECT * FROM `tbl_cab`";
                            $exe=mysql_query($sel) or die("can't access");
                            while($data=mysql_fetch_array($exe)){?> 
                            <? if($data['with_driver'] == 0){?>
                                <option value="<?=$data['id']?>"><?=$data['cab_number']?></option>
                            <? } elseif ($fetch_record['taxi']==$data['id']) { ?>
                                <option value="<?=$data['id']?>" <? { echo "selected"; }?>><?=$data['cab_number']?></option>
                            <? }?>
                            <? }?>
                        </td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Licencia<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="dni" id="dni" size="48" type="text" value="<?= stripslashes($dni) ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" width="20%">Nombre<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="fullname" id="fullname" size="48" type="text" value="<?= stripslashes($fullname) ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Email <span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="email" id="email"  size="48" type="email" value="<?= $email ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Password<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="password"  id="password" size="48" type="password" value="<?= $password ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Móvil<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="mobile"  id="mobile" size="48" type="text" value="<?= $mobile ?>" /></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>

                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Dirección<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="address"  id="address" size="48" type="text" value="<?= stripslashes($address) ?>" /></td>
                    </tr>


                    <tr>
                        <td class="lightGrayBg" valign="bottom">Foto conductor</td>
                        <td class="lightGrayBg"><input name="image" type="file" > <br><br><br>
                            <?php if ($image) { ?>
                            Imagen Actual: <br>
                                <img src="../profile_pic/<?= $image ?>" border="0" width="102" height="102"><br>
                            <?php } ?></td>
                    </tr>
                


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
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Miembro desde<span class="star">*</span></td>
                        <td class="lightGrayBg"><input name="add_date" readonly id="add_date" size="48" type="text" value="<?= $add_date ?>" /><img id="add_date_img" src="images/calendar.png" style="margin-left: 5px; width: 20px;"></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg"><input name="usertype" size="48" type="text" style="display:none" value="<?= driver ?>" /></td>
                    </tr>
                    <tr><td colspan="2">&nbsp;</td></tr>
                    <tr>
                        <td align="center" colspan="2"><?php if ($_REQUEST['set_flag'] == 'update') { ?>
                                <input type="submit" class="btn btn-info"  name="update" value='Actualizar' >
                            <?php } else { ?>
                                <input type="submit" class="btn btn-info" name="submit" value='Guardar' >
                            <?php } ?></td>
                    </tr>
                </table>
            </form>
            <br />
            <?php include("paging.inc.php"); ?>
        </td>
    </tr>
</table>
<?php include("bottom.inc.php"); ?>