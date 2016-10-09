<?php
   //$str="[{\"section\":\"directory\",\"object_id\":\"350\"},{\"section\":\"directory\",\"object_id\":\"355\"},{\"section\":\"news\",\"object_id\":\"190\"}]";
    $str=stripcslashes($_POST["favorites"]);
    $json = json_decode($str,true);
    //var_dump($json);
    foreach ($json as $key => $value){
        echo "section ".$value['section'];
        echo "<br>";
        echo "object_id ".$value['object_id'];
        echo "<br>.......<br>";
    };
?>