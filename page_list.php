<?php
include './header.php';
?>
<?php require_once("includes/main.inc.php");

if($_SESSION['sess_admin_id']==''){
	header("location:index.php");
}

$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql = " from tbl_content ";
$sql .= " where 1 ";

$order_by == '' ? $order_by = 'page_id' : true;
$order_by2 == '' ? $order_by2 = 'asc' : true;

$sql_count = "select count(*) ".$sql; 
$sql .= "order by $order_by $order_by2 ";
$sql .= "limit $start, $pagesize ";

$sql = $columns.$sql;
$result = db_query($sql);
$reccnt = db_scalar($sql_count);
?>

</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    $menu_active = "textos";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">

                <?php $title_bread = "Administrar contenido del App";
                include("top.inc.php");
		?>
            <div class="row">
                <?=display_sess_msg()?>
                <center class="msg"><?=$msg;?></center>
            </div>
            <div class="row">
                     <div class="col-sm-6">
                         <div align="left">Registros por página:
                                <?=pagesize_dropdown('pagesize', $pagesize);?>
                            </div>
                     </div>
                     <div class="col-sm-6 text-right">
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
            <div class="row margintop30">
                <div class="col-sm-12">
		<form method="post" name="form1" id="form1" onSubmit="confirm_submit(this)">
                    <?php if($conteo != 0){ ?>
		<table class="tableList table table-bordered">
                    <thead>
			<tr>
				<th>Línea</th>
				<th>Titulo</th>
				<th>Texto</th>
				<th >Editar       </th>
			</tr>
                        </thead>
                        <tbody>
			<?php if($start==0){ 
				$cnt=0;
			}else{
				$cnt=$start;
			}

			while ($line_raw = mysql_fetch_array($result)) {
				$cnt++;
				$line = ms_display_value($line_raw);
				@extract($line);
				$css = ($css=='trOdd')?'trEven':'trOdd';?>
				<tr class="<?=$css?>">
					<td  valign="top"><?=$cnt;?></td>
					<td  valign="top"><?=$page_title?></td>
					<td  valign="top"><a href='javascript:;' onClick="window.open('view_1.php?page_id=<?=$page_id?>','_blank','toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');">Ver</a></td>
					<td align="center" valign="top"><a class="btn btn-default btn-sm btn-icon icon-left" href="page_text.php?page_id=<?=$page_id?>&start=<?=$start?>"><i class="entypo-pencil"></i>Editar</a></td>
				</tr>
			<?php }?>
                                </tbody>
		</table>
                    <?php }?>
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