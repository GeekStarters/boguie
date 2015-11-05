<?php
function CategoryName($cat_id)
{
	if($cat_id == "0"){	
		return "Parent Category";
	}else{
		$sqlCategory = mysql_query("select * from tbl_category where cat_id='$cat_id'");
		$resCategory = mysql_fetch_array($sqlCategory);
		return $resCategory['cat_name'];
	}
}

function getContentTitle($cid)
{
	$sqlCategory = mysql_query("select page_title from tbl_content where page_id='$cid'");
	$resCategory = mysql_fetch_array($sqlCategory);
	echo $resCategory['page_title'];
}

function getContent($cid)
{
	$sqlCategory = mysql_query("select page_text from tbl_content where page_id='$cid'");
	$resCategory = mysql_fetch_array($sqlCategory);
	echo $resCategory['page_text'];
}

function ProductName($product_id)
{
	$sqlProduct = mysql_query("select * from tbl_product where product_id='$product_id'");
	$resProduct = mysql_fetch_array($sqlProduct);
	echo $resProduct['product_name'];
}

function ProductCount($product_cat_id)
{
	$sqlProductCount = mysql_query("select count(*) as totalitem from tbl_product where product_cat_id='$product_cat_id'");
	$resProductCount = mysql_fetch_array($sqlProductCount);
	echo $resProductCount['totalitem'];
}

function newProductCount($product_cat_id)
{
	$sqlProductCount = mysql_query("select count(*) as totalitem from tbl_product where product_cat_id='$product_cat_id' and is_new='Y' ");
	$resProductCount = mysql_fetch_array($sqlProductCount);
	echo $resProductCount['totalitem'];
}

function saleProductCount($product_cat_id)
{
	$sqlProductCount = mysql_query("select count(*) as totalitem from tbl_product where product_cat_id='$product_cat_id' and is_sale='Y' ");
	$resProductCount = mysql_fetch_array($sqlProductCount);
	echo $resProductCount['totalitem'];
}

function StaticPageContents($page_id)
{
	$sqlContent = mysql_query("select * from tbl_content where page_id='$page_id' ");
	$resContent = mysql_fetch_array($sqlContent);
	echo $resContent['page_text'];
}

function saveResizedImage2($file_name, $width, $height, $source_folder, $destination_folder) {
	
	if (!file_exists($destination_folder)) {
		mkdir($destination_folder, 0777);
		chmod($destination_folder, 0777);
	}
	
	$source_path=$source_folder."/".$file_name;
	$destination_path=$destination_folder."/".$file_name;
	$ext=explode(".",$file_name);
	
	if($ext[1]=="gif" or $ext[1]=="GIF") {
		$mainimage=imagecreatefromgif($source_path);
	}
	elseif($ext[1]=="png" or $ext[1]=="PNG") {
		$mainimage=imagecreatefrompng($source_path);
	}
	elseif($ext[1]=="jpg" or $ext[1]=="JPG") {
		$mainimage=imagecreatefromjpeg($source_path);
	}
	$mainwidth=imagesx($mainimage);
	$mainheight=imagesy($mainimage);
	
	if($mainwidth<=$width and $mainheight<=$height) {
		$thumbleheight=$mainheight;
		$thumblewidth=$mainwidth;	
	}
	else {
		if($mainwidth>$width) {
			$thumblewidth=$width;
			$thumbleheight=(($width/$mainwidth)*$mainheight);	
		}
		else if($mainheight>$height) {
			$thumbleheight=$height;
			$thumblewidth=(($height/$mainheight)*$mainwidth);	
		}
	}
	
	$thumbleimage=imagecreate($thumblewidth,$thumbleheight);
	$thumbleimage=@ImageCreateTrueColor($thumblewidth,$thumbleheight);
	$my_temp_file= imagecopyresized($thumbleimage,$mainimage,0,0,0,0,$thumblewidth,$thumbleheight,$mainwidth,$mainheight);
	imagejpeg($thumbleimage,$destination_path,100);
	imagedestroy($thumbleimage);
	imagedestroy($mainimage);
}

function CountCartItems()
{
	$sqlcheck="select * from tbl_addbasket where session_id='".session_id()."'";
	$rescheck=mysql_query($sqlcheck);
	return mysql_num_rows($rescheck);
}

function getProductAttribute($field, $id)
{
	$sql = "select $field from tbl_product where product_id='$id'";
	$rs = mysql_query($sql);
	$rc = mysql_fetch_array($rs);
	return $rc[0];
}

function getUserAttribute($field, $id)
{
	$sql = "select $field from registration where id='$id'";
	$rs = mysql_query($sql);
	$rc = mysql_fetch_array($rs);
	return $rc[0];
}

function getDHLShippingCharge($userid, $weight)
{
	$country = getUserAttribute('country', $userid);
	$sql = "select shipping_charge from tbl_zone_rate where weight>=".$weight." and zone=(select zone from tbl_country_master where contCode='".$country."')";
	$rs = mysql_query($sql);
	$rc = mysql_fetch_array($rs);
	return $rc['shipping_charge'];
}

function getShippingTime($userid)
{
	$country = getUserAttribute('country', $userid);
	$sql = "select shipping_time from tbl_country_master where contCode='".$country."'";
	$rs = mysql_query($sql);
	$rc = mysql_fetch_array($rs);
	return $rc['shipping_time'];
}
function getCountryNameByCode($code)
{
	$sql = "select * from tbl_country_master where contCode='".$code."'";
	$rs = mysql_fetch_array(mysql_query($sql));
	return $rs['contName'];
}
function getBusinessType($type)
{
	$sql = "select * from tbl_business_type where id='".$type."'";
	$rs = mysql_fetch_array(mysql_query($sql));
	return $rs['type'];
}
function getMembership($membership)
{
	$sql = "select * from tbl_membership where id='".$membership."'";
	$rs = mysql_fetch_array(mysql_query($sql));
	return $rs['title'];
}
function getUserType($uid)
{
	$sql = "select user_type from tbl_user where id='".$uid."'";
	$rs = mysql_query($sql);
	$rc = mysql_fetch_array($rs);
	return $rc['user_type'];
}
function getUserMembership($uid)
{
	$sql = "select membership from tbl_user where id='".$uid."'";
	$rs = mysql_query($sql);
	$rc = mysql_fetch_array($rs);
	return $rc['membership'];
}
?>
