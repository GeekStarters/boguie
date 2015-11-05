<?
if($reccnt>$pagesize){
	
$num_pages=$reccnt/$pagesize;

$PHP_SELF=$_SERVER['PHP_SELF'];
$qry_str=$_SERVER['argv'][0];

$m=$_GET;
unset($m['start']);

$qry_str=qry_str($m);

//echo "$qry_str : $p<br>";

//$j=abs($num_pages/10)-1;
$j=$start/$pagesize-5;
//echo("<br>$j");
if($j<0) {
	$j=0;
}
$k=$j+10;
if($k>$num_pages)	{
	$k=$num_pages;
}
$j=intval($j);
?>
	 <? if($start!=0){?><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>"  class="redcolor">Previous Photo</a> | <? }else{ echo "&nbsp;";}?>
<? }
?>
<? if($start+$pagesize < $reccnt){?><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>" class="redcolor">Next Photo</a> | <? }else{ echo "&nbsp;";}?>

