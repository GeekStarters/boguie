<?php
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");
if($_SESSION['sess_admin_id']==''){
	header("location:index.php");
}?>




<?php
require_once("includes/main.inc.php");

$start = intval($start);
$pagesize = intval($pagesize) == 0 ? $pagesize = DEF_PAGE_SIZE : $pagesize;
$columns = "SELECT *  FROM tbl_ride WHERE ride_type =  'reservation' AND ride_status =  'pending'  LIMIT $start, $pagesize ";
$sql_count = "SELECT COUNT( * ) AS total FROM tbl_ride WHERE ride_type =  'reservation' AND ride_status =  'pending'";
//echo $sql;
$result = mysql_query($columns);
$count_result = mysql_query($sql_count);
$reccnt = mysql_result($count_result, 0);
?>
</head>
<body class="page-body  page-fade">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
		<?php
                $title_bread = "Ultimas notificaciones / Reservaciones Pendientes";
                include("top.inc.php")
                ;?>
            <div class="row">
                <div class="col-sm-12">
                    <?=display_sess_msg();?>
                    <strong class="msg"><div align="center"><?= display_sess_msg() ?></div></strong>
                    <? if ($reccnt == 0) { ?>
                        <div class="msg">No se encontraron registros.</div>
                    <? } else {
                        ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-left">
                    Registros por página: <?= pagesize_dropdown('pagesize', $pagesize); ?>
                </div>
                <div class="col-xs-6 col-right text-right">
                    Mostrando registros: <?= $start + 1 ?>  -  <?= ($reccnt < $start + $pagesize) ? ($reccnt - $start) : ($start + $pagesize) ?> <br> Total de registros: <?= $reccnt ?>
                </div>
            </div>
            
            <div class="row">
                
                <div class="col-sm-12">
                                        <form method="post" name="form1" id="form1" onsubmit="">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th width="5%">id </th>
                                                    <th width="5%">&nbsp;</th>
                                                    <th width="20%" nowrap="nowrap">Conductor</th>
                                                    <th width="20%" nowrap="nowrap">Pasajero</th>
                                                    <th width="10%" nowrap="nowrap">Fecha</th>
                                                    <th width="10%" nowrap="nowrap">Hora</th>
                                                    <th width="15%">Estado reserva</th>
                                                    <th width="15%">Estado carrera</th>
                                                </tr>
                                                </thead>
                                                <?php
                                                if($start==0){
                                                    $cnt=0;
                                                }else{
                                                    $cnt=$start;
                                                }
                                                while ($line_raw = mysql_fetch_array($result, MYSQL_ASSOC)) {
                                                    $cnt++;
                                                    //print_r($line_raw);
                                                ?>
                                                <tbody>
                                                    <tr >
                                                        <td align="center" valign="top"><?= $line_raw['id']; ?></td>
                                                        <td align="center" valign="top"><a class="btn btn-default btn-sm btn-icon icon-left" href="change_reservation.php?id=<?= $line_raw['id']?>"><i class="entypo-pencil"></i>Editar</a></td>
                                                        <td align="left" valign="top"><? $driver = $line_raw['driver']; $result_driver = mysql_query("SELECT `fullname` FROM tbl_user WHERE id = '$driver'") or die(mysql_error()); while($row = mysql_fetch_assoc($result_driver)){ echo $row['fullname']; } ?><br />
                                                            <a href='javascript:;' onClick="window.open('view_driver.php?did=<?= $line_raw['driver']; ?>', '_blank', 'toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');">Ficha completa</a></td>
                                                        <td align="left" valign="top"><? $passenger = $line_raw['passenger']; $result_passenger = mysql_query("SELECT `fullname` FROM tbl_user WHERE id = '$passenger'") or die(mysql_error()); while($row = mysql_fetch_assoc($result_passenger)){ echo $row['fullname']; } ?><br />
                                                            <a href='javascript:;' onClick="window.open('view_passenger.php?pid=<?= $line_raw['passenger']; ?>', '_blank', 'toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');">Perfil completo</a></td>
                                                        <td align="left" valign="top"><?= $line_raw['pickup_date']; ?></td>
                                                        <td align="left" valign="top"><?= $line_raw['pickup_time']; ?></td>
                                                        <td align="left" valign="top"><?php 
                                                        if ($line_raw['ride_status'] == 'pending') {
                                                            echo "Pendiente";
                                                        }elseif ($line_raw['ride_status'] == 'canceled') {
                                                            echo "Cancelada";
                                                        }else{
                                                            echo "Confirmada";
                                                            }
                                                        ?></td>
                                                        <td align="left" valign="top"><?
                                                        if ($line_raw['status'] == 0) {
                                                             echo "Pendiente";
                                                         }else{
                                                            echo "Completada";
                                                            }  ?></td>
                                                    </tr>
                                                    </tbody>
                                            <?php }?>
                                            </table>
                                        </form>
                                    <?php } ?>
                                    
                             
                        </div>
                    
                </div>
            <div class="row">
                <div class="col-sm-12">
                    <?php include("paging.inc.php"); ?>
                </div>
            </div>
            </div>
	</div>
</div>
<?php
include './footer.php';
?>
</body>
</html>