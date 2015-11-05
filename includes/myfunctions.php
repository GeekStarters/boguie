<?php
error_reporting(0);
function fun_db_output($str){
	echo  stripslashes($str);
}
function fun_db_input($str){
	$str = trim($str);
	if(!get_magic_quotes_gpc()){
		return addslashes($str);
	}else{
		return $str;
	}
}

function checkCategoryExist($catID){
		$checkCategory	=	db_query("Select cat_name,cat_desc from tbl_category where md5(cat_id)	=	'".$catID."' ");
		if(mysql_num_rows($checkCategory)==0)
			{
				return 0;
				}
		else
			{		
				$categoryData	=	ms_stripslashes(mysql_fetch_array($checkCategory));
				return $categoryData;
				}
}

function checkProductExistOrNot($prodID){
	$addressQuery	=	db_query("select * from tbl_product where active_status = 'Active' and md5(product_id) = '".$prodID."'");
	if(mysql_num_rows($addressQuery)==0)
		{
			return "No";
			}
	else{
			$addressData	=	ms_stripslashes(mysql_fetch_assoc($addressQuery));
			return $addressData;
		}		
}
function displaycategoryName($catID){
		$catQuery	=	db_query("Select cat_name from tbl_category where cat_id = '".$catID."'");
		$catData		=	ms_stripslashes(mysql_fetch_array($catQuery));
		echo $catData[cat_name];
}
function showProductsInCart(){
	$cartQuery	=	mysql_num_rows(db_query("Select * from tbl_temp where session_id = '".session_id()."'"));
	echo $cartQuery;
}

function checkUserLogin($LoginID){
	$checkLoginQuery =  db_query("select * from  tbl_member where md5(member_id) = '".$LoginID."' and status = 'Active'");
	if(mysql_num_rows($checkLoginQuery)==0){
			return 0;
		}
	else{
			return 1;
		}	
}



function displaytitle($selkey="-1"){
		$titles			=	array("0"=>"Mr.","1"=>"Miss.","3"=>"Mrs.");
		$displaytitle 	=	"";
		foreach($titles as $key=>$value){
			  if($key==$selkey)
			  	{
			  	  $displaytitle.="<option value='".$key."' selected='selected'>".$value."</option>";
				  }
				    else
					{
						$displaytitle.="<option value='".$key."'>".$value."</option>";
						}
		}
		return $displaytitle;
		 	
}

function siteMainData(){
	$siteMainDataQuery	=	db_query("select  *  from tbl_admin where admin_id= '1'"); 
    $siteMainDataData	=	mysql_fetch_assoc($siteMainDataQuery);
	return $siteMainDataData;	
}

function getdynamiccontent($pagename){
	$db1=mysql_query($kp="select page_title,page_desc,page_keyword  from tbl_meta where  page_link = '".$pagename."' ");
	#	echo $kp;
	$res2	=	mysql_fetch_assoc($db1);
	$res2 	= 	ms_stripslashes($res2);
	#print_r($res2);
	return $res2;
}

function trimBodyText($theText, $lmt=70, $s_chr="\n", $s_cnt=1){
	  $pos = 0;
	  $trimmed = FALSE;
	  for($i=0; $i <= $s_cnt; $i++){
		  if($tmp = strpos($theText, $s_chr, $pos)){
			  $pos = $tmp;
			  $trimmed = TRUE;
		  }else{
			  $pos = strlen($theText);
			  $trimmed = FALSE;
			  break;
		  }
	  }
	  $theText = substr($theText, 0, $pos);
	  if(strlen($theText) > $lmt){
		  $theText = substr($theText, 0, $lmt);
		  $theText = substr($theText, 0, strrpos($theText, ' '));
		  $trimmed = TRUE;
	  }
	  if($trimmed){
		  $theText .= "...";
	  }
	  return $theText;
  }

# Function to diaplay shot description of product
function showsortdescription($prodID){
	$descQuery	=	db_query("Select product_full_desc from tbl_product where md5(product_id)='".$prodID."'");
	$descData	=	ms_stripslashes(mysql_fetch_assoc($descQuery));
	echo trimBodyText($descData[product_full_desc],70);
}

function showproductImage($prodID){
	$descQuery	=	db_query("Select product_image1 from tbl_product where md5(product_id)='".$prodID."'");
	$descData	=	ms_stripslashes(mysql_fetch_assoc($descQuery));
	return $descData[product_image1];

}
function checkCategoryExistorNot($catID){
	$checkQuery		=	db_query("select 1 from tbl_category where md5(cat_id) = '".$catID."'");
	if($checkQuery==0)
	{
		return -1;
	}
	else
	{
		return 1;
	}

}

function chekProductExistorNot(){
	$checkQuery		=	db_query("select 1 from tbl_product where md5(product_id) = '".$catID."'");
	if($checkQuery==0)
	{
		return -1;
	}
	else
	{
		return 1;
	}
}

function diplayCategory(){
	$actualCategoryData		=	array();	
	$categoryQuery			=	db_query("select * from tbl_category where cat_status = 'Active'");
    while($categoryData		=	mysql_fetch_assoc($categoryQuery))
	{
	  $actualCategoryData[]	=	$categoryData;
	}
		return $actualCategoryData;
}

function displayCategoryDetails($catID){
	$categoryQuery			=	db_query("select cat_name,cat_desc from tbl_category where md5(cat_id) = '".$catID."'");
	$catgoryData			=	mysql_fetch_assoc($categoryQuery);
	return $catgoryData;

}

function checkProductExistCart($prodID){
	$checkCartQuery	=	db_query("Select cart_id from tbl_temp where session_id = '".session_id()."'  
								  and prod_id = '".$prodID."'");
	if(mysql_num_rows($checkCartQuery)==0)
		{
			return "ADD";	
			}
		else
			{	
				$checkCartID	=	mysql_fetch_assoc($checkCartQuery);
				return $checkCartID[cart_id];
				}

}


function checkProductExistWishList($prodID){
	$checkCartQuery	=	db_query("Select 1 from tbl_wishlist where wishlist_member_id = '".$_SESSION['userLoginID']."'  
								  and wishlist_product_id = '".$prodID."'");
	if(mysql_num_rows($checkCartQuery)==0)
		{
			return "ADD";	
			}
		else
			{	
				return "PRESENT";
				}

}


function CheckProductDetail($prodID)
{
	$productQuery	=	db_query("select * from tbl_product where md5(product_id) = '".$prodID."'");
	$productData	=	mysql_fetch_array($productQuery);
	return $productData;
	}


# To check tbl_temp is empty or Not (Table that contain products of cart before login	)
function CheckTempCart()
{
	$checkTempCartQuery	=	db_query("Select 1 from tbl_temp where session_id = '".session_id()."'");
	if(mysql_num_rows($checkTempCartQuery)==0)
		{
			return 0;
			}
	else
		{
			return 1;
			}		
}

function checkOrderExistOrNot($orderID){
	$checkQuery		=	db_query("Select * from tbl_order where md5(order_id) = '".$orderID."'");
	if(mysql_num_rows($checkQuery)==0)
		{
			return 0;
			}
	else
	{
		$checkData		=	mysql_fetch_assoc($checkQuery);
		return $checkData;
		}		

}

function dislaycategories(){
	$optionList	=	'';
	$catQuery	=	db_query("Select cat_id,cat_name from tbl_category where cat_parent_id = '0' and cat_status= 'Active'");
	if(mysql_num_rows($catQuery)==0)
		{
			$optionList.= "<option value=''>No Category Added</option>"; 
			}
	else{
			$optionList.="<option value=''>Select Category</option>";
			while($catData	=	mysql_fetch_array($catQuery))
			{
				$optionList.="<option value='".$catData[cat_id]."'>".$catData[cat_name]."</option>";   	
				}
	}		
	echo $optionList;
}

function ShowUserDetails($userID){
	$userQuery		=	db_query("Select * from tbl_member where md5(member_id) = '".$userID."' ");
	$userData		=	ms_stripslashes(mysql_fetch_assoc($userQuery));
	return $userData;

}

function checkOrderDetail($orderID){
	$checkQuery		=	db_query("Select * from tbl_order where order_id = '".$orderID."'");
	if(mysql_num_rows($checkQuery)==0)
		{
			return 0;
			}
	else
	{
		$checkData		=	mysql_fetch_assoc($checkQuery);
		return $checkData;
		}		

}


function GetReferEmailContent(){
	$referQuery	=	db_query("Select refer_content  from tbl_refer_friend_content");
	$referData	=	mysql_fetch_assoc($referQuery);
	return $referData[refer_content];
	}
	
	
function showbreadcrum($catID){
$firstQuery		=	mysql_fetch_array(db_query("select * from tbl_category where cat_id = '".$catID."'"));
$displayData[]	=	"<a href = 'subcat_listing.php?cat_parent_id=".$firstQuery[cat_id]."' >".ucfirst($firstQuery[cat_name])."</a>";
if($firstQuery[cat_parent_id]==0)
	{
		$flag = 0;
		}
else
{
	$flag = 1;
	}		
$newCatID	=	$firstQuery[cat_parent_id];
while($flag==1)
	{
			$SecondQuery	=	mysql_fetch_array(db_query("select * from tbl_category 
																where cat_id = '".$newCatID."'"));	
			$displayData[]	=	"<a href = 'subcat_listing.php?cat_parent_id=".$SecondQuery[cat_id]."' >".ucfirst($SecondQuery[cat_name])."</a>";
				if($SecondQuery[cat_parent_id]==0)
					{
						$flag = 0;
						}
				else
				{
					$flag = 1;
					}		
				$newCatID	=	$SecondQuery[cat_parent_id];
	}
	$displayData	=	array_reverse($displayData);
	return $displayData;
}
?>