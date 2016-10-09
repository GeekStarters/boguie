<?php
    $info = getdate();
    $date = $info['mday'];
    $month = $info['mon'];
    $year = $info['year'];
    $hour = $info['hours'];
    $min = $info['minutes'];
    $sec = $info['seconds'];
    echo $current_date = "$year-$month-$date $hour:$min:$sec";
    echo "<br><br>";
    echo $dateServer = "2015-08-26 18:12:45";
    echo "<br><br>";
    $timeFirst  = strtotime($dateServer);
    $timeSecond = strtotime($current_date);
    echo $differenceInSeconds = $timeSecond - $timeFirst;
?>