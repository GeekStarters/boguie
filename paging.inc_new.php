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
}
?>
  
				 <div class="tabIndex" align="center" valign='top'> <a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>" class="floatLeft enlarge"><? if($start!=0)
		{ echo "&laquo; Previous";}?></a> <? if($start+$pagesize < $reccnt){
		?><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>" class="floatRight enlarge">Next&raquo;</a>
     <?
		}?>
				 
				 
				  <div class="tabs" ><?
			
			for($i=$j;$i<$k;$i++)
			{
				if($i==$j);
			   if(($pagesize*($i))!=$start)
				  {
	  ?>
      &nbsp;<a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>" style="text-decoration:none;" class="navBarTxt">
      <?=$i+1?>
      </a>&nbsp;
      <?
				  }
	  else{
	  ?>
      <b>
      <?=$i+1?>&nbsp;
      </b>
      <?
	  }
 }?>
     </div>
	
	