<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate CAB**/
if(isset($_REQUEST['arr_ids'])){
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)){
		$str_ids = implode(',', $arr_ids);
		if(isset($_REQUEST['Delete'])){
			$sql = "delete from  tbl_cab where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Conductores seleccionados eliminados");
		}else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x'])){
			$sql = "update tbl_cab  set status = '1' where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Conductores seleccionados activados");
		}else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x'])){
			$sql = "update tbl_cab set status = '0' where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Conductores seleccionados desactivados");
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql=($_REQUEST[parent_id]!='')?" from tbl_cab where category='$_REQUEST[parent_id]' and status!='2'":" from tbl_cab where status!='2'";
if($keyword!=""){
	switch($type){
		case 'cab_number':
			$sql .=" And cab_number like '%$keyword%' ";
			break;
	}
}
if(isset($_REQUEST['cid'])) $sql .= " and category='".$_REQUEST['cid']."'";
$sql .= " order by id";

$sql_count = "select count(*) ".$sql;

$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;
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
	var i=0;
	
	for( i=0 ; i<len ; i++){
		if (objForm.elements[i].type=='checkbox'){
			objForm.elements[i].checked=objForm.check_all.checked;
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
                    $menu_active= "taxi";
                    include("left.inc.php");
                    
                }?>

	</div>
	<div class="main-content">
		<?php
			$title_bread = "Administrar Conductores";
			include("top.inc.php");
		?>
            <div class="row">
                <div class="col-sm-12">
                    <div align="center message"><strong class=""><?=display_sess_msg()?></strong></div>
                    <div align="center"><?=display_sess_msg()?></div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div align="left">Registros por pagina:
                    <?=pagesize_dropdown('pagesize', $pagesize);?>
                    </div>
                </div>
                <div class="col-sm-6 text-right">
                    <a class="btn btn-xs btn-blue" href="cab_add.php?set_flag=add&start=<?=$start?><?=($parent_id!='')?"&parent_id=$parent_id":""?>">Agregar una nueva unidad </a>
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
        <th>Numero de unidad</th>
        <th>Costo por KM</th>
        <th>Foto</th>
        <th>Estado</th>
        </tr>
    </thead>
    <tbody>
<?php
if($start==0){
	$cnt=0;
}else{
	$cnt=$start;
}

while ($line_raw = ms_stripslashes(mysql_fetch_array($result))){
	$cnt++;
	$css = ($css=='trOdd')?'trEven':'trOdd';
?>
<tr class="<?=$css?>">
<td><?=$cnt;?> <input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$line_raw['id'];?>" /><input type="hidden" name="u_status_arr[]"  value="<?=($status=='Active')?'Active':'Inactive';?>" /></td>
<td><a class="btn btn-default btn-sm btn-icon icon-left" href="cab_add.php?id=<?=$line_raw['id']?>&set_flag=update<?=$_REQUEST[parent_id]!=''?'&parent_id='.$_REQUEST[parent_id]:''?>"><i class="entypo-pencil"></i>Editar</a></td>
<td><?=stripslashes($line_raw['cab_number']);?><br />(Categoria = <?php displaycategoryName($line_raw['category']);?>)</td>
<td><?=$line_raw['fare_per_km'];?> S/.</td>
<td><?php if($line_raw['cab_image1']!='' && file_exists("cab_images/".$line_raw['cab_image1'])){$cab_image2="cab_images/".$line_raw['cab_image1'];?><img src="<?=$cab_image2?>" border="0" width="100" ><?php }?></td>
<td><?=($line_raw['status']==1)?"Activo":"Inactivo";?></td>
</tr>
<?php }?>
</table>
<div class="row">
    <?php include("paging.inc.php");?>
</div>
<div class="col-sm-12 text-right margintop30">
    <input name="Activate" class="btn btn-green" type="submit" value="Activar" class="button" onClick="return validcheck('arr_ids[]', 'Activate', 'CAB');"/>
    <input name="Deactivate" class="btn btn-default" type="submit" class="button" value="Desactivar" onClick="return validcheck('arr_ids[]', 'Deactivate', 'CAB');"/>
    <input name="Delete" class="btn btn-warning" type="submit" class="button" value="Eliminar" onClick="return validcheck('arr_ids[]', 'delete', 'CAB');"/>
</div>

</form>
                       </div>
<?php } ?>

         

	</div>   
</div>
<?php
include './footer.php';
?>
</body>
</html>