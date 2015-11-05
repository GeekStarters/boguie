<? require_once('includes/main.inc.php');
if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}
?>


<link href="styles.css" rel="stylesheet" type="text/css">


<? 


if($_REQUEST[product_id]!='' && $_REQUEST[product_id]!=0){


$img	=	db_scalar("select ".$_REQUEST[pos1]." from tbl_product where product_id='$_REQUEST[product_id]'");





#$img_arr=explode("~",$img);


#$p=$_REQUEST[pos1];


#$image=$img_arr[$p];


?>


<br>


<div align="center"><img border="0"  src="<?="product_images/".$img;?>" align="center"></div>


<br>


<? }


elseif($_REQUEST[banner_id]!='' && $_REQUEST[banner_id]!=0){


$img	=	db_scalar("select banner_image from tbl_banner  where banner_id='$_REQUEST[banner_id]'");





?>


<br>


<div align="center"><img border="0" src="<?=UP_FILES_WS_PATH."/banner_image/".$img;?>" align="center"></div>


<br>


<? }


elseif($_REQUEST[t_id]!='' && $_REQUEST[t_id]!=0){


$img	=	db_scalar("select t_image from tbl_testimonial  where t_id='$_REQUEST[t_id]'");





?>


<br>


<div align="center"><img border="0" src="<?=UP_FILES_WS_PATH."/testimonial_image/".$img;?>" align="center"></div>


<br>


<? }


elseif($_REQUEST[cat_id]!='' && $_REQUEST[cat_id]!=0){


$img	=	db_scalar("select cat_image from tbl_category  where cat_id='$_REQUEST[cat_id]'");





?>


<br>


<div align="center"><img border="0" src="<?=UP_FILES_WS_PATH."/cat_image/".$img;?>" align="center"></div>


<br>


<? }


elseif($_REQUEST[slno]!='' && $_REQUEST[slno]!=0){


$img	=	db_scalar("select uploade_photo from tbl_claim  where cat_id='$_REQUEST[slno]'");





?>


<br>


<div align="center"><img border="0" src="<?=UP_FILES_WS_PATH."/claim/".$img;?>" align="center"></div>


<br>


<? }


?>





<div align="center"><a href="javascript:window.close();" ><strong>Close</strong></a></div> 