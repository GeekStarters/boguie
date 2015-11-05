<? 
$out = array();

 for($i=1; $i<=15; $i++){   
    $data = date('Y-m-d', strtotime("+".$i." days"));
    $out[] = array(
        'id' => $i,
        'title' => 'Event name '.$i,
        'url' => 'http://hola.com',
        'class' => 'event-important',
        'start' => strtotime($data).'000'
    );
}

echo json_encode(array('success' => 1, 'result' => $out));

?>