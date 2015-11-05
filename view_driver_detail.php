<?php
$menu_active= "porconductor";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate Driver**/

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select * ";
$sql=" from tbl_user u INNER JOIN tbl_ride r ON u.id=r.driver where u.usertype='driver' and u.id='".$_REQUEST['did']."' ";
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
                                <th>SLeleccionar Todo</th>
                                <th>Driver Name</th>
                                <th>Cab Name</th>
                                <th>Puckup Date & time</th>
                                <th>Pickup Address</th>
                                <th>Dropoff time</th>
                                <th>Dropoff Address</th>
                                <th>Status</th>
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
                    <tbody>
                    <tr class="<?=$css?>">
                    <?php $sql="select * from tbl_cab where id='".$line_raw['cab']."'";
                    $rs=mysql_query($sql);
                    $rss=mysql_fetch_array($rs);?><td align="center" valign="top"><?=$cnt;?><input type="hidden" name="u_status_arr[]"  value="<?=($status=='Active')?'Active':'Inactive';?>" /></td>
                    <td align="left" valign="top"><?=stripslashes(ucwords($line_raw['fullname']));?></td>
                    <td align="left" valign="top"><?=ucwords($rss['cab_number']);?></td>
                    <td align="left" valign="top"><?=$line_raw['pickup_date'];?> & <?=$line_raw['pickup_time'];?> </td>
                    <td align="left" valign="top"><?=ucwords($line_raw['pickup_address']);?></td>
                    <td align="left" valign="top"><?=$line_raw['dropoff_time'];?></td>
                    <td align="left" valign="top"><?=ucwords($line_raw['dropoff_address']);?></td>
                    <td align="center" valign="top"><?=($line_raw['status'])?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                    </table>
                         <?php } ?>

                    </form>
                    </div>
            </div>
            <div class="row">
                <?php include("paging.inc.php");?>
            </div>
        </div>
</div>

<?php
include './footer.php';
?>
</body>
</html>