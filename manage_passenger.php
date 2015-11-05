<?php
require_once("includes/main.inc.php");
header('Content-Type: text/html; charset=utf-8');
/* * for activate delete and deactivate Driver* */
if (isset($_REQUEST['arr_ids'])) {
    $arr_ids = $_REQUEST['arr_ids'];
    if (is_array($arr_ids)) {
        $str_ids = implode(',', $arr_ids);
        if (isset($_REQUEST['Delete'])) {
            $sql = "delete from  tbl_user where id in ($str_ids)";
            db_query($sql);
            set_session_msg("Pasajeros seleccionados han sido eliminados");
        } else if (isset($_REQUEST['Activate'])) {
            $sql = "update tbl_user  set status = 'Active' where id in ($str_ids)";
            db_query($sql);
            set_session_msg("Pasajeros seleccionados han sido activados");
        } else if (isset($_REQUEST['Deactivate'])) {
            $sql = "update tbl_user set status = 'Inactive' where id in ($str_ids)";
            db_query($sql);
            set_session_msg("Pasajeros seleccionados han sido desactivados");
        }
    }
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

/* * End of checking** */
$start = intval($start);
$pagesize = intval($pagesize) == 0 ? $pagesize = DEF_PAGE_SIZE : $pagesize;
$columns = "select * ";
$sql = " from tbl_user where usertype='passenger' ";
if ($keyword != "") {
    switch ($type) {
        case 'fullname':
            $sql .=" And fullname like '%$keyword%' ";
            break;
        case 'email':
            $sql .=" And email like '%$keyword%' ";
            break;
    }
}

$sql .= " order by id";

$sql_count = "select count(*) " . $sql;
$sql .= " limit $start, $pagesize ";
$sql = $columns . $sql;
//echo $sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>
<?php
include './header.php';
?>
<script src="../js/validation.js"></script>


<script language="javascript">
    function checkall(objForm)
    {
        len = objForm.elements.length;
        var i = 0;

        for (i = 0; i < len; i++) {
            if (objForm.elements[i].type == 'checkbox') {
                objForm.elements[i].checked = objForm.check_all.checked;
            }
        }
    }
</script>


</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    $menu_active= "pasajeros";
                    include("left.inc.php");
                    
                }?>

	</div>
	<div class="main-content">
		<?php
			$title_bread = "Administrar pasajeros";
			include("top.inc.php");
		?>
            <div class="row">
                <div class="col-sm-12">
                    <div align="center message"><strong class=""><?=display_sess_msg()?></strong></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div align="left">Registros por pagina:
                    <?=pagesize_dropdown('pagesize', $pagesize);?>
                    </div>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-xs btn-blue" href="passenger_add.php?set_flag=add&start=<?=$start?>">Agregar nuevo pasajero </a>
                    <br><br><?php
                    if(mysql_num_rows($result)==0){?>
                    <div class="msg">No se encontraron registros.</div>
                    <?php
                    }else{ ?>
                    <div align="right"> Mostrando registros:
                    <?= $start+1?> a <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?>  <br>
                    Total de registros: <?= $reccnt?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
                

                <form method="post" name="form1" id="form1" onsubmit="">
                    <table class="tableList table table-bordered">
                        <thead>
                        <tr>
                            <th>Seleccionar todos <input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                            <th>&nbsp;</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Movil</th>
                            <th>Foto</th>
                            <th>Estado</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if ($start == 0) {
                            $cnt = 0;
                        } else {
                            $cnt = $start;
                        }

                        while ($line_raw = ms_stripslashes(mysql_fetch_array($result))) {
                            $cnt++;
                            $css = ($css == 'trOdd') ? 'trEven' : 'trOdd';
                            ?>
                            <tr class="<?= $css ?>">
                                <td><?= $cnt; ?> <input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?= $line_raw['id']; ?>" /><input type="hidden" name="u_status_arr[]"  value="<?= ($status == 'Active') ? 'Active' : 'Inactive'; ?>" /></td>
                                <td><a class="btn btn-default btn-sm btn-icon icon-left" href="passenger_add.php?id=<?= $line_raw['id'] ?>&set_flag=update<?= $_REQUEST[parent_id] != '' ? '&parent_id=' . $_REQUEST[parent_id] : '' ?>"><i class="entypo-pencil"></i>Editar</a></td>
                                <td><?= stripslashes($line_raw['fullname']); ?><br />
                                    <a href='javascript:;' onClick="window.open('view_passenger.php?pid=<?= $line_raw['id']; ?>', '_blank', 'toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');">Perfil completo</a></td>
                                <td><?= $line_raw['email']; ?></td>
                                <td><?= $line_raw['password']; ?></td>
                                <td><?= $line_raw['mobile']; ?></td>
                                <td><?php
                                    if ($line_raw['image'] != '' && file_exists("./profile_pic/" . $line_raw['image'])) {
                                        $driver_image2 = "./profile_pic/" . $line_raw['image'];
                                        ?><img src="<?= $driver_image2 ?>" border="0" width="100" ><?php } ?></td>
                                <td><?= ($line_raw['status']) ?></td>
                            </tr>
    <?php } ?>
                            </tbody>
                    </table>
                    <div class="row">
                        <?php include("paging.inc.php"); ?>
                    </div>
                    <div class="row text-right">
                        <input name="Activate" type="submit" value="Activar" class="btn btn-green" onClick="return validcheck('arr_ids[]', 'Activate', 'Driver');"/>
                        <input name="Deactivate" type="submit" class="btn btn-default" value="Desactivar" onClick="return validcheck('arr_ids[]', 'Deactivate', 'Driver');"/>
                        <input name="Delete" type="submit" class="btn btn-warning" value="Eliminar" onClick="return validcheck('arr_ids[]', 'delete', 'Driver');"/>
                    </div>
                </form>
                    </div>
            <?php } ?>
                
           </div>
	</div>
</div>
<?php
include './footer.php';
?>
</body>
</html>