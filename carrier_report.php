<?php
$menu_active= "porconductor";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate Driver**/
if(isset($_REQUEST['arr_ids'])){
	$arr_ids = $_REQUEST['arr_ids'];
	if(is_array($arr_ids)){
		$str_ids = implode(',', $arr_ids);
		if(isset($_REQUEST['Delete'])){
			$sql = "delete from  tbl_user where id in ($str_ids)";
			db_query($sql);
			set_session_msg("Selected drivers have been deleted successfully");
		
		}
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql=" from tbl_user where usertype='driver' ";
if($keyword!=""){
	switch($type){
		case 'fullname':
			$sql .=" And fullname like '%$keyword%' ";
			break;
		case 'email':
			$sql .=" And email like '%$keyword%' ";
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
                    include("left.inc.php");
                    
                }?>
	</div>
	<div class="main-content">
		<?php
			$title_bread = "Reporte por conductor";
			include("top.inc.php");
		?>
            <div class="row margintop30">
                <font class="msg"><?=display_sess_msg();?></font>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-6">
                    <div align="left">Registros por pagina: <?=pagesize_dropdown('pagesize', $pagesize);?></div>
                </div>
                
                <div class="col-sm-6 text-right">
                    <?php
                    $conteo = mysql_num_rows($result);
                    if($conteo == 0){?>
                    <div class="msg">Sin resultados..</div>
                    <?php
                    }else{ ?>
                    <div align="right"> Mostrando registros: <?= $start+1?> a <?=($reccnt<$start+$pagesize)?($reccnt-$start):($start+$pagesize)?> de <?= $reccnt?></div>
                    <?php } ?>
                </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                <form method="post" name="form1" id="form1" onsubmit="">
                    <?php if($conteo != 0){ ?>
                    <table class="tableList table table-bordered">
                        <thead>
                            <tr>
                            <th>Selecionar Todo <input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                            <th>Conductor</th>
                            <th>Reporte</th>
                            </tr>
                        </thead>
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
                        <body>
                            <tr class="<?=$css?>">
                            <td><?=$cnt;?> <input name="arr_ids[]" type="checkbox" id="arr_ids[]" value="<?=$line_raw['id'];?>" /><input type="hidden" name="u_status_arr[]"  value="<?=($status=='Active')?'Active':'Inactive';?>" /></td>
                            <td><?=stripslashes($line_raw['fullname']);?>
                            <td><a href="view_driver_detail.php?did=<?=$line_raw['id'];?>">Ver todo</a></td>
                            </tr>
                        </body>
                <?php }?>
                </table>
                    <?php }?>
                </form>
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