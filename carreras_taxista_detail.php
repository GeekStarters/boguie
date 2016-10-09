<?php
$menu_active = "carrera_taxista";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");
if(!isset($_GET['cli'])){
    exit();
}
if(isset($_GET['d']) && isset($_GET['h'])){
    $sql = "SELECT carrera.id, carrera.pickup_date, carrera.pickup_time, carrera.pickup_address, cliente.fullname as cliente_name, taxista.fullname as taxista_name from tbl_ride as carrera INNER JOIN tbl_user as taxista ON carrera.driver = taxista.id LEFT JOIN tbl_user as cliente ON carrera.passenger = cliente.id WHERE taxista.usertype = 'driver' AND carrera.driver = ".$_GET['cli']." and carrera.pickup_date BETWEEN '".$_GET["d"]."' AND '".$_GET['h']."'";
    
}else{
    $sql = "SELECT carrera.id, carrera.pickup_date, carrera.pickup_time, carrera.pickup_address, cliente.fullname as cliente_name, taxista.fullname as taxista_name from tbl_ride as carrera INNER JOIN tbl_user as taxista ON carrera.driver = taxista.id LEFT JOIN tbl_user as cliente ON carrera.passenger = cliente.id WHERE taxista.usertype = 'driver' AND carrera.driver = ".$_GET['cli'];
}
//print_r($sql);
$result = db_query($sql);
?>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.0.3/js/buttons.html5.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    $('#example').DataTable({
        "language": {
            "url": "js/es.json"
        },
        dom: 'Bfrtip',
        buttons: [
        'excel', 'pdf'
        ]
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

                <?php $title_bread = "Servicios por taxista";
                include("top.inc.php");
		?>
            <div class="row">
                <div class="col-sm-12">
                    <?=display_sess_msg()?>
                    <center class="msg"><?=$msg;?></center>
                </div>
                
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
                <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>N°</th>
                <th>Taxista</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Dirección</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>N°</th>
                <th>Taxista</th>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Dirección</th>
            </tr>
        </tfoot>
 
        <tbody>
            <?php
            $n  = 1;
             while ($line_raw = ms_stripslashes(mysql_fetch_array($result))){
                 ?>
                <tr>
                <td><?=$n;?></td>
                <td><?php if(!$line_raw['taxista_name']){ echo 'No disponible'; }else{ echo $line_raw['taxista_name']; } ?></td>
                <td><?=$line_raw['cliente_name'];?></td>
                <td><?=$line_raw['pickup_date'];?></td>
                <td><?=date("H:i:s",strtotime($line_raw['pickup_time']));?></td>
                <td><?=$line_raw['pickup_address'];?></td>
                </tr>
                 <?php
                 $n++;
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