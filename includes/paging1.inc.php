<? $total	=	ceil($reccnt/$pagesize);
if($reccnt>$pagesize){
$num_pages=$reccnt/$pagesize;
//$x	=	$reccnt/$pagesize;
$PHP_SELF=$_SERVER['PHP_SELF'];
$qry_str=$_SERVER['argv'][0];
$m=$_GET;
unset($m['start']);
$qry_str=qry_str($m);
$j=$start/$pagesize-5;
if($j<0) {
	$j=0;
}
$k=$j+10;
if($k>$num_pages)	{
	$k=$num_pages;
}
$j=intval($j);
//="reccnt=$reccnt, start=$start, pagesize=$pagesize, num_pages=$num_pages : j=$j : k=$k"?>
<table width="98%"  border="0" align="center" cellpadding="0" cellspacing="0">
                    <tr>
<?		if($start!=0){?>
<td width="16%" class="head_sub"><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start-$pagesize?>" class="head_sub"><img src="images/arrow_pre.gif" border="0" width="12" height="13" alt="Previous Page"> Previous</a> </td>
<? }?> 
		<td width="71%" align="center">
<?	
	    for($i=$j;$i<$k;$i++){
		   if(($pagesize*($i))!=$start)
		    { ?><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$pagesize*($i)?>" class="head_sub"><?=$i+1?></a> | <?  }else{ ?><?=$i+1?> | <? }
 		}?></td>

<? if($start+$pagesize < $reccnt){?>
		 <td width="13%" align="right" class="head_sub"><a href="<?=$PHP_SELF?><?=$qry_str?>&start=<?=$start+$pagesize?>" class="head_sub">Next <img border="0" src="images/arrow_next.gif" width="12" height="13" alt="Next Page"></a></td>
<? }?>
	
</tr></table>
<? }?>