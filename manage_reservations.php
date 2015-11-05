<?php
$menu_active= "reservaciones";
include './header.php';
?>
<?php 
require_once("includes/main.inc.php");
if($_SESSION['sess_admin_id']==''){
    header("location:index.php");
}

?>
<?php
require_once("includes/main.inc.php");

$sql_print = "";

$start = intval($start);
$pagesize = intval($pagesize) == 0 ? $pagesize = DEF_PAGE_SIZE : $pagesize;

$columns = "SELECT *  FROM tbl_ride WHERE ride_type =  'reservation' ";
/*and ride_status = 'canceled' 
and pickup_date BETWEEN '2015-09-22' AND '2015-09-25'
LIMIT 2, 3";*/
$sql_count = "SELECT COUNT( * ) AS total FROM tbl_ride WHERE ride_type =  'reservation' ";

if(isset($_POST["estado"])){
    
    if($_POST["estado"] == "cancelado"){
        $columns .="and ride_status = 'canceled' ";
        $sql_count .="and ride_status = 'canceled' ";
    }elseif ($_POST["estado"] == "pendiente") {
        $columns .="and ride_status = 'pending' ";
        $sql_count .="and ride_status = 'pending' ";
    }elseif ($_POST["estado"] == "confirmado") {
        $columns .="and ride_status = 'confirmed' ";
        $sql_count .="and ride_status = 'confirmed' ";
    }else{
        $columns .="";
        $sql_count .="";
    }
    
    if(isset($_POST["fechas"])){
        $columns .="and pickup_date BETWEEN '".$_POST["desde"]."' AND '".$_POST["hasta"]."' ";
        $sql_count .="and pickup_date BETWEEN '".$_POST["desde"]."' AND '".$_POST["hasta"]."' ";
    }else{
        $columns .="";
        $sql_count .="";
    }
}

$sql_print = $columns;

$columns .="LIMIT ".$start.", ".$pagesize.";";

//echo $columns;

//$columns = "SELECT *  FROM tbl_ride WHERE ride_type =  'reservation' LIMIT $start, $pagesize ";
//$sql_count = "SELECT COUNT( * ) AS total FROM tbl_ride WHERE ride_type =  'reservation' AND ride_status =  'pending'";
//$sql_count = "SELECT COUNT( * ) AS total FROM tbl_ride WHERE ride_type =  'reservation'";
//echo $sql;
$result = mysql_query($columns);
$count_result = mysql_query($sql_count);
$reccnt = mysql_result($count_result, 0);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
$(document).ready(function(){
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
    $("#desde").prop("disabled", true);
    $("#hasta").prop("disabled", true);
    $("#fechas").change(function(){
        if(this.checked){
            $("#desde").prop("disabled", false);
            $("#hasta").prop("disabled", false);
        }else{
            $("#desde").prop("disabled", true);
            $("#hasta").prop("disabled", true);
        }
    });
    
    $("#send").click(function(){
        var marcado = $("#fechas").prop('checked');
        if(marcado === true){
            if($("#desde").val() == "" || $("#hasta").val() == ""){
                alert("Debes seleccionar un rago de fechas.");
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    });
    
});
function clearform(){
        $("#desde").val("");
        $("#hasta").val("");
        $("#desde").prop("disabled", true);
        $("#hasta").prop("disabled", true);
        $("#fechas").attr('checked', false); 
        $("select#estado").val("todos");
    }
    
function printpdf(){
    $("#pdf").submit();
}
function printexcel(){
    $("#excel").submit();
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
			$title_bread = "Ultimas notificaciones / reservaciones";
			include("top.inc.php");
		?>
            <div class="row margintop30">
                <font class="msg"><?=display_sess_msg();?></font>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div align="left">Registros por pagina:
                    <?=pagesize_dropdown('pagesize', $pagesize);?>
                    </div>
                </div>
                <div class="col-sm-6 text-right">
                <?php if ($reccnt == 0) { ?>
                    <div class="msg">No se encontraron registros.</div>
                <?php } else { ?>
                    Mostrando registros: <?= $start + 1 ?>  -  <?= ($reccnt < $start + $pagesize) ? ($reccnt - $start) : ($start + $pagesize) ?> <br> Total de registros: <?= $reccnt ?>
                <?php } ?>
                </div>
            </div>
            <div class="row">
			<div class="col-md-12">
				
				<div class="panel panel-primary" data-collapsed="1">
				
					<div class="panel-heading">
						<div class="panel-title">
							Filtrar búsqueda
						</div>
						
						<div class="panel-options">
							<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                                                        <a href="#" data-rel="reload" onclick="clearform();"><i class="entypo-arrows-ccw"></i></a>
						</div>
					</div>
					
					<div style="" class="panel-body">
						
						<div class="row">
                                                    <form id="filters" action="" method="POST">
                                                        
							<div class="col-md-4">
                                                            <select id="estado" name="estado" class="form-control">
                                                                <option value="todos" <?php if($_POST["estado"] == "todos"){ echo 'selected=""'; } ?>>Todos los estados</option>
                                                                    <option value="pendiente" <?php if($_POST["estado"] == "pendiente"){ echo 'selected=""'; } ?>>Pendientes</option>
                                                                    <option value="confirmado" <?php if($_POST["estado"] == "confirmado"){ echo 'selected=""'; } ?>>Confirmados</option>
                                                                    <option value="cancelado" <?php if($_POST["estado"] == "cancelado"){ echo 'selected=""'; } ?>>Cancelados</option>
                                                                </select>
							</div>

							<div class="col-md-2">
                                                            <label>Filtrar fechas</label>
                                                            <input id="fechas" name="fechas" type="checkbox">
							</div>
							
							<div class="col-md-2">
                                                            <div class="input-group">
                                                                <input name="desde" id="desde" class="form-control datepicker" value="<?php echo $_POST['desde']; ?>" data-format="D, dd MM yyyy" type="text" readonly="">
                                                                <div class="input-group-addon">
                                                                        <a href="#"><i class="entypo-calendar"></i></a>
                                                                </div>
                                                            </div>
							</div>
							
							<div class="col-md-2">
                                                            <div class="input-group">
                                                                <input name="hasta" id="hasta" class="form-control datepicker" value="<?php echo $_POST['hasta']; ?>" data-format="D, dd MM yyyy" type="text" readonly="">
                                                                <div class="input-group-addon">
                                                                        <a href="#"><i class="entypo-calendar"></i></a>
                                                                </div>
                                                            </div>
							</div>
							
							<div class="col-md-2">
                                                            <button id="send" class="btn btn-blue" name="btn-submit">Buscar</button>
							</div>
							
							<div class="clear"></div>
					
                                                    </form>
						</div>
                                            
					</div>
				
				</div>
			
			</div>
		</div>
            <div class="row">
                <div class="col-md-12">
                <form style="display: inline-block;" target="_blank" method="post" action="dowdload_reservation.php" id="pdf">
                    <input type="hidden" value="<?php echo $sql_print; ?>" name="sql">
                    <input type="hidden" value="pdf" name="formato">
                    <a href="javascript:void(0);" onclick="printpdf();">Guardar como PDF</a>
                </form>
                    <form style="display: inline-block;" target="_blank" method="post" action="dowdload_reservation.php" id="excel">
                    <input type="hidden" value="<?php echo $sql_print; ?>" name="sql">
                    <input type="hidden" value="excel" name="formato">
                    <a href="javascript:void(0);" onclick="printexcel();"> - Guardar como Excel</a>
                </form>    
                </div>
                
            </div>
            <div class="row">
                <div id="content" class="col-sm-12">
                    <?php if ($reccnt !=0){?>
                    <form method="post" name="form1" id="form1" onsubmit="">
                            <table class="tableList table table-bordered">
                                <thead>
                                <tr>
                                    <th>id </th>
                                    <th>&nbsp;</th>
                                    <th>Conductor</th>
                                    <th>Pasajero</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Estado reserva</th>
                                    <th>Estado carrera</th>
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
                                ?>
                                <tbody>
                                    <tr>
                                        <td><?= $line_raw['id']; ?></td>
                                        <td><a class="btn btn-default btn-sm btn-icon icon-left" href="change_reservation.php?id=<?= $line_raw['id']?>"><i class="entypo-pencil"></i>Editar</a></td>
                                        <td ><? $driver = $line_raw['driver']; $result_driver = mysql_query("SELECT `fullname` FROM tbl_user WHERE id = '$driver'") or die(mysql_error()); while($row = mysql_fetch_assoc($result_driver)){ echo $row['fullname']; } ?><br />
                                            <a href='javascript:;' onClick="window.open('view_driver.php?did=<?= $line_raw['driver']; ?>', '_blank', 'toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');">Ficha completa</a></td>
                                        <td><? $passenger = $line_raw['passenger']; $result_passenger = mysql_query("SELECT `fullname` FROM tbl_user WHERE id = '$passenger'") or die(mysql_error()); while($row = mysql_fetch_assoc($result_passenger)){ echo $row['fullname']; } ?><br />
                                            <a href='javascript:;' onClick="window.open('view_passenger.php?pid=<?= $line_raw['passenger']; ?>', '_blank', 'toolbar=no,menubar=no,scrollbars=yes,resizable=1,height=500,width=750');">Perfil completo</a></td>
                                        <td><?= $line_raw['pickup_date']; ?></td>
                                        <td><?= $line_raw['pickup_time']; ?></td>
                                        <td>
                                            <?php
                                        if ($line_raw['ride_status'] == 'pending') {
                                            echo "Pendiente";
                                        }elseif ($line_raw['ride_status'] == 'canceled') {
                                            echo "Cancelada";
                                        }else{
                                            echo "Confirmada";
                                            }
                                        ?></td>
                                        <td><?
                                        if ($line_raw['status'] == 0) {
                                             echo "Pendiente";
                                         }else{
                                            echo "Completada";
                                            }  ?>
                                        </td>
                                    </tr>
                                    </tbody>
                            <?php }?>
                            </table>
                    </form>
                    <?php } ?>
                </div>
                <div class="col-sm-12">
                    <?php include("paging.inc.php"); ?>
                </div>
            </div>
	</div>
</div>
<?php
include './footer.php';
?>

</body>
</html>