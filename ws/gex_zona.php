<?php
  header('Content-Type: application/json; Charset=ISO-8859-1');
  include('ws_settings.php');
  $idChildrenCategory ='';
  $categoryId = "";
  $categoryName = "";
  $categoryDesc = "";
  $categoryCustomTitle = "";
  $categorySlug = "";
  $categoryMediaId = "";
  $objectCatDB = array();

  /*$subCategoryCatQuery = "SELECT * FROM h7jml_virtuemart_category_categories WHERE category_parent_id = 0";
  $subCategoryCatResult = mysql_query($subCategoryCatQuery);

  while($subCategoryCatRow = mysql_fetch_assoc($subCategoryCatResult)){
    $idChildrenCategory = $subCategoryCatRow['category_child_id'];*/

   // $categoryQuery = "SELECT * FROM h7jml_virtuemart_categories_es_es INNER JOIN h7jml_virtuemart_category_medias ON  h7jml_virtuemart_category_medias.virtuemart_category_id = h7jml_virtuemart_categories_es_es.virtuemart_category_id  WHERE h7jml_virtuemart_categories_es_es.virtuemart_category_id = '".$idChildrenCategory."';";
    
    $zonaQuery = "SELECT * FROM h7jml_virtuemart_shipmentmethods_es_es AS NameZona,h7jml_virtuemart_shipmentmethods AS PublishName ";
    $zonaQuery.="WHERE NameZona.virtuemart_shipmentmethod_id=PublishName.virtuemart_shipmentmethod_id and PublishName.published and PublishName.published='1' ";
    $zonaQuery.="ORDER BY PublishName.ordering ASC";
    $sql_zona=mysql_query($zonaQuery);
      
    while($filas=mysql_fetch_array($sql_zona)){
      $shipment_name=$filas['shipment_name'];
      $shipment_params=$filas['shipment_params'];
      $virtuemart_shipmentmethod_id=$filas['virtuemart_shipmentmethod_id'];
      $parciar= explode("cost=", $shipment_params);
      $parciar_comillas= explode('"', $parciar[1]);
      $parciar_comillas[1]=number_format($parciar_comillas[1],2);
      $contenedor_value[]=array("id"=>$virtuemart_shipmentmethod_id,"nombre"=>$shipment_name,"precio"=>$parciar_comillas[1]);
    }

    $objectBannerJSON = json_encode($contenedor_value);
    echo '{"zona":'.$objectBannerJSON.'}';

    
    
   


  /*
    h7jml_virtuemart_category_medias
    h7jml_virtuemart_medias
  */
?>
