<?php
$menu_active = "carreras";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate Driver**/

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;
$columns = "select *, COUNT( * ) AS numero_carrera, SUM(amount) AS suma_carreras, u.pickup_date as fecha_carrera ";
$sql=" from tbl_ride AS u,tbl_payments AS p WHERE u.id=p.transaction_id";


$sql_count = "select count(*) ".$sql;
$sql .= " group by u.pickup_date";
if($_GET['carrera']!=""){
	$sql .=" HAVING numero_carrera>".$_GET['carrera'];
}else if($_GET['desde']!=""){
	$sql .=" HAVING (fecha_carrera BETWEEN '".$_GET['desde']."' AND '".$_GET['hasta']."')";
}



$sql .= " ORDER BY u.pickup_date DESC";
$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;
//echo $sql;


$result = db_query($sql);
$reccnt = db_scalar($sql_count);
$url="http://".$_SERVER['HTTP_HOST'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URI'];
$url="http://www.graymatter.a2hosted.com/cab/admin/ride_report.php";
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

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
			$title_bread = "Reportes de carrera";
			include("top.inc.php");
		?>
        <div class="row margintop30">
                <font class="msg"><?= display_sess_msg();?></font>
        </div>
        <form method="post" name="form1" id="form1" onsubmit="">
            <div class="row">
                <div class="col-sm-4">
                    <div align="left">Registros por pagina: <?=pagesize_dropdown('pagesize', $pagesize);?></div>
                </div>
                <div class="col-sm-4 text-center">
                    <select class="form-control" name="select_buscar" id="select_buscar" class="pagesize_dropdown" onchange="mostrar()">
                        <option value="0">Buscar por</option>
                        <option value="1">Fechas</option>
                        <option value="2">Cantidad Carreras</option>
                    </select>
                </div>
                <div class="col-sm-4 text-right">
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
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="fechas" style="display:none">
                            <div class="col-sm-6">
                                Desde: 
                                <input class="form-control" name="desde" readonly id="desde" size="20" type="text" value="" />
                            </div>
                            <div class="col-sm-6">
                                Hasta: 
                                <input class="form-control" name="hasta" readonly id="hasta" size="20" type="text" value="" />
                            </div>
                        </div>
                    </div>
                        
                    <div class="row">
                        <div class="carrera col-sm-5  text-center" style="display:none; margin: auto; float: none;">
                            Carreras mayor a:
                            <input class="form-control" name="desde" id="carrera" size="20" type="text" value="" />
                        </div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="boton_buscar" style="display:none">
                            <input name="Bt_buscar" id="Bt_buscar" type="button" value="Buscar" class="btn btn-blue" onclick="return validcheck('s');">
                        </div>
                    </div>

                        <table class="tableList table table-bordered margintop30">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Total carreras</th>
                                    <th>Tarifas calculadas</th>
                                    <th>Monto a pagar a taxistas</th>
                                    <th> </th>
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
                        <tr class="<?=$css?>">
                        <td><?=$line_raw['fecha_carrera'];?></td>
                        <td><?=$line_raw['numero_carrera'];?></td>
                        <td><?=$line_raw['suma_carreras'];?></td>
                        <td><?=($line_raw['suma_carreras']*0.20);?></td>
                        <td><a class="btn btn-default btn-sm btn-icon icon-left" href="view_driver_ride_report.php?did=<?=$line_raw['fecha_carrera'];?>"><i class="entypo-eye"></i>Ver</a></td>

                        </tr>
                        <?php }?>
                        </table>


                </div>
            </div>
        </form>
        <div class="row">
            <?php include("paging.inc.php");?>
        </div>
    </div>
 </div>

<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
  var seleccionado;
  $(function() {
    $('#desde').datepicker({ dateFormat: 'yy-mm-dd'}).val();
	$('#hasta').datepicker({ dateFormat: 'yy-mm-dd'}).val();

    $( "#desde_img" ).click(function() {
        $('#desde').datepicker('show');
    });

    $( "#hasta_img" ).click(function() {
        $('#hasta').datepicker('show');
    });

	$("#Bt_buscar").click(function() {

      if(seleccionado=="1"){
      	desde=$("#desde").val();
      	hasta=$("#hasta").val();
      	window.location='<?php echo $url;?>?desde='+desde+"&hasta="+hasta;
      }

      if(seleccionado=="2"){
      	carrera=$("#carrera").val();
      	window.location='<?php echo $url;?>?carrera='+carrera;
      }
    });
  });

    function mostrar(){
        seleccionado=$('#select_buscar').val();
        $('.fechas').hide();
        $('.carrera').hide();
        $('.boton_buscar').hide();


        if(seleccionado=="1"){
                $('.fechas').show();
                $('.boton_buscar').show();
        }
        if(seleccionado=="2"){
                $('.carrera').show();
                $('.boton_buscar').show();
        }
    }
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
<?php
include './footer.php';
?>
</body>
</html>