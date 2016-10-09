<?php

// response json
$json = array();

/**
 * Store user's lat and long in tbl
 */
if (isset($_REQUEST["email_user"])) {
    
    $email_user = $_REQUEST["email_user"];
    // Store user details in db
    include_once '../includes/db_functions.php';
    
    $db = new DB_Functions();

    $sql_direccion=mysql_query("SELECT * from tbl_address where email_user='".$email_user."'");
    while ($fila=mysql_fetch_array($sql_direccion)) {
        $description=$fila['description'];
        $lat=$fila['lat'];
        $lon=$fila['lon'];
        $house=$fila['house'];
        $reference=$fila['reference'];
        $title = $fila["title"];
        $id = $fila["id_address"];
        $contenedor_value[]=array("description"=>$description,"lat"=>$lat,"lon"=>$lon,"house"=>$house,"reference"=>$reference,"title"=>$title,"id"=>$id);

    }

    $objectBannerJSON = json_encode($contenedor_value);
    echo '{"direcciones":'.$objectBannerJSON.'}';
}
?>