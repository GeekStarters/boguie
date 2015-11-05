<?php
$menu_active = "descuento";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");

if(isset($_GET['de']) && is_numeric($_GET['de'])){
    $sql = "UPDATE `tbl_coupon` SET `status` = '0' WHERE `tbl_coupon`.`id` = ".$_GET['de'].";";
    db_query($sql);
    set_session_msg("Descuento desactivado correctamente.");	
}

$sql = "SELECT tbl_coupon.id as id_des, tbl_coupon.coupon, tbl_coupon.flat_discount, tbl_coupon.add_date, tbl_coupon.status, tbl_user.fullname, tbl_user.id as id_user, tbl_user.email FROM tbl_coupon INNER join tbl_user ON tbl_coupon.id_user = tbl_user.id WHERE tbl_coupon.status = 1;";
$result = db_query($sql);
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
   
    $('#example').DataTable({
        "language": {
            "url": "js/es.json"
        }
    });

});
</script>

</head>

<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    //$menu_active = "radio";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">

                <?php $title_bread = "Descuentos activos";
                include("top.inc.php");
		?>
            <div class="row">
                <div class="col-sm-12">
                    <?=display_sess_msg()?>
                    <center class="msg"><?=$msg;?></center>
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-3 pull-right" style="text-align: right;">
                    <a class="btn btn-xs btn-blue" href="descuento_cliente.php">Nuevo descuento</a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
                <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Código</th>
                <th>Descuento</th>
                <th>Válido hasta</th>                
                <th>Desactivar</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>Cliente</th>
                <th>Código</th>
                <th>Descuento</th>
                <th>Válido hasta</th>
                <th>Desactivar</th>
            </tr>
        </tfoot>
 
        <tbody>
            <?php
             while ($line_raw = ms_stripslashes(mysql_fetch_array($result))){
                 ?>
                <tr>
                <td><a href='javascript:;' onClick="window.open('view_passenger.php?pid=<?= $line_raw['id_user']; ?>', '_blank', 'toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');"><?=$line_raw['fullname']." (".$line_raw['email'].")";?></a></td>
                <td><?=$line_raw['coupon'];?></td>
                <td><?=$line_raw['flat_discount'];?></td>
                <td><?=$line_raw['add_date'];?></td>
                <td><a href="descuento_manage.php?de=<?=$line_raw['id_des'];?>">Desactivar descuento</a></td>
                </tr>
                 <?php
             }
            ?>
        </tbody>
    </table>
                    
                    
                </div>
            </div>
        </div>
</div>
<?php
include './footer.php';
?>

</body>
</html>