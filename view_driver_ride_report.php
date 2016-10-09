<?php
$menu_active= "carreras";
include './header.php';
?>
<?php require_once("includes/main.inc.php");

/**for activate delete and deactivate Driver**/

/**End of checking***/
$start = intval($start);
$pagesize = intval($pagesize)==0?$pagesize=DEF_PAGE_SIZE:$pagesize;

$sql_pasajero="(select fullname from tbl_user where id=u.passenger) as nombre_pasajero";
$sql_conductor="(select fullname from tbl_user where id=u.driver) as nombre_conductor";


$columns = "select *, u.pickup_date as fecha_carrera, ".$sql_pasajero.", ".$sql_conductor." ";
$sql=" from tbl_ride AS u,tbl_payments AS p where u.id=p.transaction_id and u.pickup_date='".$_REQUEST['did']."'";




$sql_count = "select count(*) ".$sql;
//$sql .= " group by u.pickup_date";
if($_GET['pasajero']!=""){
	$sql .=" HAVING nombre_pasajero LIKE '%".$_GET['pasajero']."%'";
}else if($_GET['conductor']!=""){
	$sql .=" HAVING nombre_conductor LIKE '%".$_GET['conductor']."%'";
}else if($_GET['distancia']!=""){
	$sql .=" HAVING p.distance>".$_GET['distancia'];
}else if($_GET['monto']!=""){
	$_GET['monto']=$_GET['monto']/.20;
	$sql .=" HAVING amount>".$_GET['monto'];
}


//$sql .= " group by u.pickup_date";
$sql .= " ORDER BY u.pickup_date DESC";
$sql .= " limit $start, $pagesize ";
$sql = $columns.$sql;

//echo $sql;

$result = db_query($sql);
$reccnt = db_scalar($sql_count);

$url="http://www.graymatter.a2hosted.com/cab/admin/view_driver_ride_report.php?did=".$_GET['did'];
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
			$title_bread = "Manage Carrier Report";
			include("top.inc.php");
		?>
            <div class="row margintop30">
                <font class="msg"><?=display_sess_msg();?></font>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <div align="left">Registros por pagina: <?=pagesize_dropdown('pagesize', $pagesize);?></div>
                </div>
                <div class="col-sm-4 text-center">
                    <select name="select_buscar" id="select_buscar" class="pagesize_dropdown form-control" onchange="mostrar()">
                            <option value="0">Buscar por</option>
                            <option value="3">Pasajero</option>
                            <option value="4">Conductor</option>
                            <option value="5">Distancia</option>
                            <option value="6">Monto</option>
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
                    <div class="fechas row" style="display:none; margin: auto; float: none;">
                        <div class="col-sm-6">
                            Desde: 
                            <input class="form-control" name="desde" readonly id="desde" size="20" type="text" value="" />
                        </div>
                        <div class="col-sm-6">
                            Hasta: 
                            <input class="form-control" name="hasta" readonly id="hasta" size="20" type="text" value="" />
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="carrera col-sm-5  text-center" style="display:none; margin: auto; float: none;">
                        Servicios mayor a: 
                        <input class="form-control" name="desde" id="carrera" size="20" type="text" value="" />

                        </div>
                    </div>

                    <div class="row">
                        <div class="pasajero col-sm-5  text-center" style="display:none; margin: auto; float: none;">
                        Nombre pasajero: 
                        <input class="form-control" name="pasajero" id="pasajero" size="20" type="text" value="" />

                        </div>
                    </div>

                    <div class="row">
                        <div class="conductor col-sm-5  text-center" style="display:none; margin: auto; float: none;">
                        Nombre conductor: 
                        <input class="form-control" name="conductor" id="conductor" size="20" type="text" value="" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="distancia col-sm-5  text-center" style="display:none; margin: auto; float: none;">
                        Distancia mayor a: 
                        <input class="form-control" name="distancia" id="distancia" size="20" type="text" value="" />
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="monto col-sm-5  text-center" style="display:none; margin: auto; float: none;">
                        Monto mayor a: <input class="form-control" name="monto" id="monto" size="20" type="text" value="" />
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="boton_buscar col-sm-5  text-center" style="display:none; margin: auto; float: none;">
                            <input name="Bt_buscar" id="Bt_buscar" type="button" value="Buscar" class="btn btn-blue" onclick="return validcheck('s');">
                        </div>
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
                                <th>Pasajero</th>
                                <th>Conductor</th>
                                <th>Origen</th>
                                <th>Destino</th>
                                <th>Hora</th>
                                <th>Tarifa</th>
                                <th>Distancia</th>
                                <th>Valoración</th>
                                <th>Monto taxista</th>
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
                    <td align="left" valign="top"><?=$line_raw['nombre_pasajero'];?></td>
                    <td align="left" valign="top"><?=$line_raw['nombre_conductor'];?></td>
                    <?php
                    $start_geo = str_replace("&", ",", $line_raw['start_geo']);
                    $finish_geo = str_replace(" ", ",", $line_raw['finish_geo']);
                    $array = explode(" ", $line_raw['start_time']);
                    $hora=$array[1];
                    if($line_raw['points']=="0"){
                            $points="Sin valoracion";
                    }else{
                            $points=$line_raw['points'];
                    }


                    ?>
                    <td align="left" valign="top"><a target="_blank" href="https://www.google.com.sv/maps/place/<?=$start_geo;?>">Ver</a></td>
                    <td align="left" valign="top"><a target="_blank" href="https://www.google.com.sv/maps/place/<?=$finish_geo;?>">Ver</a></td>
                    <td align="left" valign="top"><?=$hora;?></td>
                    <td align="left" valign="top"><?=$line_raw['amount'];?></td>
                    <td align="left" valign="top"><?=number_format($line_raw['distance'], 2, ".", ".");?> KM</td>
                    <td align="left" valign="top"><?=$points;?></td>
                    <td align="left" valign="top"><?=($line_raw['amount']*0.20);?></td>
                    </tr>
                    </tbody>
                    <?php }?>
                    </table>
                        <?php } ?>

                    </form>   
                </div>
            </div>
            <div class="row">
                <?php include("paging.inc.php");?>
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



      if(seleccionado=="3"){
      	carrera=$("#pasajero").val();
      	window.location='<?php echo $url;?>&pasajero='+carrera;
      }


      if(seleccionado=="4"){
      	carrera=$("#conductor").val();
      	window.location='<?php echo $url;?>&conductor='+carrera;
      }

      if(seleccionado=="5"){
      	carrera=$("#distancia").val();
      	window.location='<?php echo $url;?>&distancia='+carrera;
      }

      if(seleccionado=="6"){
      	carrera=$("#monto").val();
      	window.location='<?php echo $url;?>&monto='+carrera;
      }

    });




  });

	function mostrar(){
		seleccionado=$('#select_buscar').val();
		$('.fechas').hide();
		$('.carrera').hide();
		$('.pasajero').hide();
		$('.conductor').hide();
		$('.distancia').hide();
		$('.monto').hide();
		$('.boton_buscar').hide();

		
		if(seleccionado=="1"){
			$('.fechas').show();
			$('.boton_buscar').show();
		}

		if(seleccionado=="2"){
			$('.carrera').show();
			$('.boton_buscar').show();
		}

		if(seleccionado=="3"){
			$('.pasajero').show();
			$('.boton_buscar').show();
		}

		if(seleccionado=="4"){
			$('.conductor').show();
			$('.boton_buscar').show();
		}

		if(seleccionado=="5"){
			$('.distancia').show();
			$('.boton_buscar').show();
		}

		if(seleccionado=="6"){
			$('.monto').show();
			$('.boton_buscar').show();
		}

	}
</script>
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
<?php
include './footer.php';
?>
</body>
</html>