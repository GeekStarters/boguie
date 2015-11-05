<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate category**/
if(isset($_REQUEST['arr_publicidad_ids'])){
	$arr_publicidad_ids = $_REQUEST['arr_publicidad_ids'];
	if(is_array($arr_publicidad_ids)){
		$str_publicidad_ids = implode(',', $arr_publicidad_ids);
	
		if(isset($_REQUEST['Delete'])){
			//DELETE FROM `grandmoda`.`publicidad` WHERE `publicidad`.`id_publicidad` = 6 
			$sql = "delete from  publicidad  where id_publicidad in ($str_publicidad_ids)";
			db_query($sql);
			set_session_msg("Banner eliminado correctamente");
		}else if(isset($_REQUEST['Activate'])){
			$sql = "update publicidad  set status = 'Active' where id_publicidad in ($str_publicidad_ids)";
			db_query($sql);
			set_session_msg("Banner activado correctamente");
		}else if(isset($_REQUEST['Deactivate'])){
			$sql = "update publicidad  set status = 'Inactive' where id_publicidad in ($str_publicidad_ids)";
			db_query($sql);
			set_session_msg("Banner desactivado correctamente");
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
	$sql = " from publicidad";
else
	$sql = " from publicidad";
$sql .= " order by id_publicidad";

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
<style type="text/css">
    .table-img{
        max-height: 200px;
        max-width: 320px;
    }
</style>
</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php $menu_active= "publicidad"; include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
		<?php
			$title_bread = "Publicidad - Banners ";
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
                            
                             <a class="btn btn-xs btn-blue" href="ads_add.php?set_flag=add&start=<?=$start?><?=($cat_parent_id!='' && $cat_parent_id!='')?"":""?>">Agregar nuevo banner </a>
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
                                  <th>URL</th>
                                  <th>Banner</th>
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
                        if($line_raw[status]=="Active"){
                                $astatus="Deactivate";
                                $img_name="unpublish.gif";	
                        }elseif($line_raw[status]=="Inactive"){
                                $astatus="Activate";
                                $img_name="publish.gif";
                        }?>
                        <tr class="<?=$css?>">
                        <td>&nbsp;&nbsp;<?=$cnt;?> <input name="arr_publicidad_ids[]" type="checkbox" id="arr_id_publicidads[]" value="<?=$line_raw['id_publicidad'];?>" />
                        <input type="hidden" name="u_status_arr[]"  value="<?=($status=='Active')?'Active':'Inactive';?>" /></td>
                        <td><a class="btn btn-default btn-sm btn-icon icon-left" href="ads_add.php?ads_id=<?=$line_raw['id_publicidad']?>&set_flag=update"><i class="entypo-pencil"></i>Editar</a> </td>
                        <td><?=stripslashes($line_raw['url_open']);?></td>                        
                        <td><img class="table-img" src="./ads/<?=stripslashes($line_raw['src_banner']);?>" alt="Banner"></td>
                        <td><?=$line_raw['status'];?></td>
                        </tr>
                        <?php }?>
                        </tbody>
                        </table>

                            <div class="pull-right text-right">

                                <input name="Activate" type="submit"  value="Activar" class="btn btn-green" id="Activate" onClick="return validcheck('arr_publicidad_ids[]','Activate','Category');"/>
                                <input name="Deactivate" type="submit" class="btn btn-default" value="Desactivar" id="Deactivate"  onClick="return validcheck('arr_publicidad_ids[]','Deactivate','Category');"/>
                                <input name="Delete" type="submit" class="btn btn-warning" id="Delete" value="Eliminar"  onClick="return validcheck('arr_publicidad_ids[]','delete','Category');"/>

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