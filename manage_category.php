<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate category**/
if(isset($_REQUEST['arr_category_ids'])){
	$arr_category_ids = $_REQUEST['arr_category_ids'];
	if(is_array($arr_category_ids)){
		$str_category_ids = implode(',', $arr_category_ids);
	
		if(isset($_REQUEST['Delete'])){
			//DELETE FROM `grandmoda`.`tbl_category` WHERE `tbl_category`.`cat_id` = 6 
			$sql = "delete from  tbl_category  where cat_id in ($str_category_ids)";
			db_query($sql);
			set_session_msg("Categoria eliminada correctamente");
		}else if(isset($_REQUEST['Activate'])){
			$sql = "update tbl_category  set cat_status = 'Active' where cat_id in ($str_category_ids)";
			db_query($sql);
			set_session_msg("Categoria activada correctamente");
		}else if(isset($_REQUEST['Deactivate'])){
			$sql = "update tbl_category  set cat_status = 'Inactive' where cat_id in ($str_category_ids)";
			db_query($sql);
			set_session_msg("Categoria desactivada correctamente");
		}
	}
	
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
if(isset($_REQUEST['pid']))
	$sql = " from tbl_category where cat_status!='Delete' and cat_parent_id='".$_REQUEST['pid']."'";
else
	$sql = " from tbl_category where cat_status!='Delete' and cat_parent_id='0'";
$sql .= " order by cat_name";

$sql_count = "select count(*) ".$sql;

$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>
<?php
include './header.php';
?>

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
                    <?php $menu_active= "categorias"; include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
		<?php
			$title_bread = "Categorias de vehiculos";
			include("top.inc.php");
		?>
            <div class="row">
                <div class="col-sm-12">
                    <div align="center message"><strong class=""><?=display_sess_msg()?></strong></div>
                </div>
            </div>
		 <div class="row">
                     <div class="col-sm-6">
                         <div align="left">Registros por página:
                                <?=pagesize_dropdown('pagesize', $pagesize);?>
                            </div>
                     </div>
                     <div class="col-sm-6 text-right">
                            
                             <a class="btn btn-xs btn-blue" href="category_add.php?set_flag=add&start=<?=$start?><?=($cat_parent_id!='' && $cat_parent_id!='')?"&cat_parent_id=$cat_parent_id":""?>">Agregar nueva categoria de taxi </a>
                             <br><br>
                            <?php
                            if(mysql_num_rows($result)==0){?>
                                <div class="msg">No se encontraron registros.</div>
                            <?php
                            }else{ ?>
                            <div align="right"> Mostrando registros:
                                <?= $start+1?> a <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> <br>
                                Total de registros: <?= $reccnt?>
                            </div>
                            
                     </div>
                            
                            
                </div>
		<div class="row">
                    <div class="col-sm-12">
                        <form method="post" name="form1" id="form1" onsubmit="confirm_submit(this)">
                        <table class="tableList table table-bordered">
                            <thead>
                                <tr>
                                  <th>Marcar todos <input name="check_all" type="checkbox" id="check_all" value="1" onClick="checkall(this.form)" /></th>
                                  <th >&nbsp;</th>						
                                  <th>Nombre categoria</th>
                                  <th>Taxis</th>
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
                        while ($line_raw = mysql_fetch_array($result)){
                        $cnt++;
                        $css = ($css=='trOdd')?'trEven':'trOdd';
                        if($line_raw[cat_status]=="Active"){
                                $astatus="Deactivate";
                                $img_name="unpublish.gif";	
                        }elseif($line_raw[cat_status]=="Inactive"){
                                $astatus="Activate";
                                $img_name="publish.gif";
                        }?>
                        <tr class="<?=$css?>">
                        <td>&nbsp;&nbsp;<?=$cnt;?> <input name="arr_category_ids[]" type="checkbox" id="arr_cat_ids[]" value="<?=$line_raw['cat_id'];?>" />
                        <input type="hidden" name="u_status_arr[]"  value="<?=($cat_status=='Active')?'Active':'Inactive';?>" /></td>
                        <td><a class="btn btn-default btn-sm btn-icon icon-left" href="category_add.php?category_id=<?=$line_raw['cat_id']?>&set_flag=update"><i class="entypo-pencil"></i>Editar</a> </td>
                        <td><?=stripslashes($line_raw['cat_name']);?></td>
                        <td><a href="manage_cab.php?cid=<?php echo $line_raw['cat_id'];?>">Ver Vehiculo</a></td>
                        <td><?=$line_raw['cat_status'];?></td>
                        </tr>
                        <?php }?>
                        </tbody>
                        </table>

                            <div class="pull-right text-right">

                                <input name="Activate" type="submit"  value="Activar" class="btn btn-green" id="Activate" onClick="return validcheck('arr_category_ids[]','Activate','Category');"/>
                                <input name="Deactivate" type="submit" class="btn btn-default" value="Desactivar" id="Deactivate"  onClick="return validcheck('arr_category_ids[]','Deactivate','Category');"/>
                                <input name="Delete" type="submit" class="btn btn-warning" id="Delete" value="Eliminar"  onClick="return validcheck('arr_category_ids[]','delete','Category');"/>

                            </div>
                        </form>
                        <?php }?>
                        <?php include("paging.inc.php");?>

            </div>
	</div>
    </div>
</div>
<?php
include './footer.php';
?>
</body>
</html>