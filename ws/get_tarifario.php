<?php

// response json
$json = array();
include_once '../includes/db_functions.php';

$db = new DB_Functions();
$origen= array();
$destino= array();
$origen_primero="";
$contador=0;


$sql_direccion=mysql_query("SELECT * , tarifario_destino.id AS id_destino
FROM tarifario_destino, tarifario_origen
WHERE tarifario_destino.id_origen = tarifario_origen.id and tarifario_destino.status='Active' and tarifario_origen.status='Active' ORDER BY origen ASC");
while ($fila=mysql_fetch_array($sql_direccion)) {
    $contador++;
    $destino['origen'] = $fila['origen'];
    $destino['destino'] = $fila['destino'];
    $destino['precio'] = $fila['precio'];
    $contenedor_value[]=$destino;
    $destino="";
    
}

echo json_encode($contenedor_value);

?>