<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate Coupon**/
if(isset($_REQUEST['arr_ids'])){
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)){
		$str_ids = implode(',', $arr_ids);
                print_r($str_ids);
		if(isset($_REQUEST['Delete'])){
			$sql = "delete from  tbl_coupon where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Cupones seleccionados han sido eliminados con éxito.");
		}else if(isset($_REQUEST['Activate']) || isset($_REQUEST['Activate_x'])){
			$sql = "update tbl_coupon  set status = '1' where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Cupones seleccionados han sido activados con éxito");
		}else if(isset($_REQUEST['Deactivate']) || isset($_REQUEST['Deactivate_x'])){
			$sql = "update tbl_coupon set status = '0' where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Cupones seleccionados han sido desactivados con éxito");
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select *, date_format(add_date,'%b %d, %Y') as adddate ";
$sql=" from tbl_coupon";
if($keyword!=""){
	switch($type){
		case 'coupon':
			$sql .=" And coupon like '%$keyword%' ";
			break;
	}
}

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
                    $menu_active= "cupones"; 
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
		<?php
			$title_bread = "Cupones";
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
                            
                             <a class="btn btn-xs btn-blue" href="coupon_add.php?set_flag=add&start=<?=$start?><?=($parent_id!='')?"&parent_id=$parent_id":""?>">Nuevo cupón</a>
                             <br><br>
                            <?php
                            $conteo = mysql_num_rows($result);
                            if($conteo==0){?>
                                <div class="msg">No se encontraron registros.</div>
                            <?php
                            }else{ ?>
                            <div align="right"> Mostrando registros: <?= $start+1?> a <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> <br>
                                Total de registros: <?= $reccnt?>
                            </div>
                            <?php } ?>
                     </div>
                            
                            
                </div>
            <div class="row">
                <div class="col-sm-12">
                    <form method="post" name="form1" id="form1" onsubmit="">
                        <?php if($conteo != 0) {?>
                <table class="tableList table table-bordered">
                    <thead>
                <tr>
                <th>Seleccionar todos <input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                <th>&nbsp;</th>
                <th>Cupón número</th>
                <th>Descuento neto</th>
                <th>Descuento (en %)</th>
                <th>Creado</th>
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
                <td><a class="btn btn-default btn-sm btn-icon icon-left" href="coupon_add.php?id=<?=$line_raw['id']?>&set_flag=update<?=$_REQUEST[parent_id]!=''?'&parent_id='.$_REQUEST[parent_id]:''?>"><i class="entypo-pencil"></i>Editar</a></td>
                <td><?=stripslashes($line_raw['coupon']);?></td>
                <td>$<?=$line_raw['flat_discount'];?> USD</td>
                <td><?=$line_raw['percentile'];?>%</td>
                <td><?php echo $line_raw['adddate'];?></td>
                <td><?=($line_raw['status']==1)?"Active":"Inactive";?></td>
                </tr>
                
                <?php }?>
                </tbody>
                </table>
                        
                <div class="pull-right text-right">
                    <input name="Activate" type="submit" value="Activar" class="btn btn-green" onClick="return validcheck('arr_ids[]', 'Activate', 'Coupon');"/>
                    <input name="Deactivate" type="submit" class="btn btn-default" value="Desactivar" onClick="return validcheck('arr_ids[]', 'Deactivate', 'Coupon');"/>
                    <input name="Delete" type="submit" class="btn btn-warning" value="Eliminar" onClick="return validcheck('arr_ids[]', 'delete', 'Coupon');"/>
                </div>
                
                <?php } ?>
                </form>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
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