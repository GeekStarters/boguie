<?php
date_default_timezone_set('America/Mexico_City');
require_once("includes/main.inc.php");
include_once('thumbnail.inc.php');
$hora_actual=date('H:i:s');  
echo $hora_actual;
$kilometro="2.3";
$hora1 =  strtotime($hora_actual);
$total=0;
$sql="SELECT * FROM tarifas WHERE $kilometro BETWEEN desde AND hasta LIMIT 1";
$query=mysql_query($sql);
while($filas=mysql_fetch_array($query)){
    $hora2 =  strtotime($filas['horario_nocturno_desde']);
    $hora3 =  strtotime($filas['horario_nocturno_hasta']);
    if($hora1>=$hora2){
        $total=$filas['costo']+$filas['factor_app']+$filas['factor_nocturno'];
    }elseif($hora1<=$hora3){
        $total=$filas['costo']+$filas['factor_app']+$filas['factor_nocturno'];
    }else{
        $total=$filas['costo']+$filas['factor_app'];
    }
}

if($total==0){
    $total="No definido";
}

echo $total;
?>