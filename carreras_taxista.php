<?php
$menu_active = "carrera_taxista";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");
if((isset($_POST['desde']) && $_POST['desde'] != "") && (isset($_POST['hasta']) && $_POST['hasta'] != "")){
    $sql = "SELECT tbl_ride.driver, tbl_user.email, tbl_user.fullname, COUNT(*) as carreras from tbl_ride INNER JOIN tbl_user ON tbl_ride.driver = tbl_user.id WHERE tbl_user.usertype = 'driver' and tbl_ride.pickup_date BETWEEN '".$_POST["desde"]."' AND '".$_POST['hasta']."' GROUP BY tbl_ride.driver;";
    
}else{
    $sql = "SELECT tbl_ride.driver, tbl_user.email, tbl_user.fullname, COUNT(*) as carreras from tbl_ride INNER JOIN tbl_user ON tbl_ride.driver = tbl_user.id WHERE tbl_user.usertype = 'driver' GROUP BY tbl_ride.driver;";
}
$result = db_query($sql);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.9/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.9/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.0.3/js/buttons.html5.min.js"></script>

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
    $("#send").click(function(){
        var desde = $("#desde").val();
        var hasta = $("#hasta").val();
        
        if(desde == "" || hasta == ""){
            alert("Debes seleccionar un rago de fechas.");
            return false;
        }else{
            return true;
        }
    });
    
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

                <?php $title_bread = "Servicios por conductor";
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
                    <h4>Filtrar por fecha</h4>
                </div>
                    <form id="filters" action="" method="POST">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input placeholder="Fecha de inicio" name="desde" id="desde" class="form-control datepicker" value="<?php echo $_POST['desde']; ?>" data-format="D, dd MM yyyy" type="text" readonly="">
                                <div class="input-group-addon">
                                        <a href="#"><i class="entypo-calendar"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="input-group">
                                <input placeholder="Fecha final" name="hasta" id="hasta" class="form-control datepicker" value="<?php echo $_POST['hasta']; ?>" data-format="D, dd MM yyyy" type="text" readonly="">
                                <div class="input-group-addon">
                                        <a href="#"><i class="entypo-calendar"></i></a>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <button id="send" class="btn btn-blue" name="btn-submit">Buscar</button>
                        </div>
                        <div class="col-sm-3">
                            
                        </div>
                    </form>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    
                <table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Conductor</th>
                <th>Email</th>
                <th>Servicios</th>
                <th>Detalles</th>
            </tr>
        </thead>
 
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Conductor</th>
                <th>Email</th>
                <th>Servicios</th>
                <th>Detalles</th>
            </tr>
        </tfoot>
 
        <tbody>
            <?php
             while ($line_raw = ms_stripslashes(mysql_fetch_array($result))){
                 ?>
                <tr>
                <td><?=$line_raw['driver'];?></td>
                <td><?=$line_raw['fullname'];?></td>
                <td><?=$line_raw['email'];?></td>
                <td><?=$line_raw['carreras'];?></td>
                <?php
                if(isset($_POST['desde']) && isset($_POST['hasta'])){
                ?>
                <td><a href="carreras_taxista_detail.php?cli=<?=$line_raw['driver'];?>&d=<?php echo $_POST['desde'] ?>&h=<?php echo $_POST['hasta'] ?>">Ver detalles</a></td>
                <?php
                }else{
                ?>
                <td><a href="carreras_taxista_detail.php?cli=<?=$line_raw['driver'];?>">Ver detalles</a></td>
                <?php
                }
                ?>
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