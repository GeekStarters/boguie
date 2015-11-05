<?php
$menu_active = "descuento";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");

$sql = "SELECT tbl_ride.passenger, tbl_user.email, tbl_user.fullname, COUNT(tbl_ride.passenger) as carreras from tbl_ride INNER JOIN tbl_user ON tbl_ride.passenger = tbl_user.id WHERE tbl_user.usertype = 'passenger' GROUP BY tbl_ride.passenger;";

$acumuladas_cupones = "";
//print_r($sql);
$result = db_query($sql);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    
    $('#desde').datepicker({ 
        dateFormat: 'yy-mm-dd',
        yearRange: "1990:<?php echo date("Y");?>",
        changeMonth: true,
        changeYear: true});
    $('#hasta').datepicker({ 
        dateFormat: 'yy-mm-dd',
        yearRange: "1990:<?php echo date("Y");?>",
        changeMonth: true,
        changeYear: true});
   
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

                <?php $title_bread = "Aplicar descuento a clientes";
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
                    <a class="btn btn-xs btn-blue" href="descuento_manage.php">Descuentos activos </a>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
                <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Carreras totales</th>
                <th>Carreras acumuladas</th>
                <th>Detalles</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Cliente</th>
                <th>Email</th>
                <th>Carreras totales</th>
                <th>Carreras acumuladas</th>
                <th>Detalles</th>
            </tr>
        </tfoot>
 
        <tbody>
            <?php
             while ($line_raw = ms_stripslashes(mysql_fetch_array($result))){
                $acumuladas = db_query("SELECT accumulated AS suma FROM `tbl_coupon` WHERE id_user = ".$line_raw['passenger']." order by id DESC");
                //print_r($acumuladas);
                $acu_result = mysql_fetch_array($acumuladas);
                //print_r($acu_result);
                extract($acu_result);
                if(isset($acu_result['suma'])){
                    $c_acu = $line_raw['carreras'] - $acu_result['suma'];
                }else{
                    $c_acu = $line_raw['carreras'];
                }
                 ?>
                <tr>
                <td><?=$line_raw['passenger'];?></td>
                <td><a href='javascript:;' onClick="window.open('view_passenger.php?pid=<?= $line_raw['passenger']; ?>', '_blank', 'toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');"><?=$line_raw['fullname'];?></a></td>
                <td><?=$line_raw['email'];?></td>
                <td><?=$line_raw['carreras'];?></td>
                <td><?=$c_acu;?></td>
                <td><a href="descuento_aply.php?cli=<?=$line_raw['passenger'];?>">Aplicar descuento</a></td>
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