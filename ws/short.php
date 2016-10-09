<?php
/*$ref = array(49.648881, -103.575312);

$items = array(
    '0' => array('item1','otheritem1details....','55.645645','-42.5323'),
    '1' => array('item1','otheritem1details....','100.645645','-402.5323')
);

$distances = array_map(function($item) use($ref) {
    $a = array_slice($item, -2);
    return distance($a, $ref);
}, $items);

asort($distances);

echo 'Closest item is: ', var_dump($items[key($distances)]);

function distance($a, $b)
{
    list($lat1, $lon1) = $a;
    list($lat2, $lon2) = $b;

    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    return $miles;
}*/
include '../includes/database_connection.php';

$slatitude = 28.6772717;
$slongitude = 77.3179828;
$miles = 200;

echo $query = "SELECT *, ( 3959 * acos( cos( radians($slatitude) ) * cos( radians( latitude ) ) * cos( radians( longitude ) - radians($slongitude) ) + sin( radians($slatitude) ) * sin( radians( latitude ) ) ) ) "
        . "AS distance FROM gcm_users HAVING distance < 250 ORDER BY distance LIMIT 1";

$query = mysql_query($query);
//$numrows = mysql_num_rows($query);


while ($row = mysql_fetch_array($query)){
$id = $row['id'];
$cityname = $row['distance'];
$latitude = $row['latitude'];
$longitude = $row['longitude'];

echo "$cityname<br />";

}



?>