<?php 
include_once('thumbnail.inc.php');
@extract($_POST);
if(isset($_REQUEST['submit']))
{
if($_FILES[product_image1][tmp_name]!='')
{
$product_image1	 = $_FILES[product_image1]['name'];
move_uploaded_file($_FILES[product_image1]['tmp_name'], "product_images/".$product_image1) or die("Image is not uploaded 1");	
if($product_image1!='')
{
$thumb2 = new Thumbnail("product_images/$product_image1");
$thumb2->resize("600","900");
$thumb2->save("product_images/large/$product_image1","100%");

$thumb = new Thumbnail("product_images/$product_image1");
$thumb->resize("300","380");
$thumb->save("product_images/$product_image1","100%");
}
}

if($_FILES[product_image2][tmp_name]!='')
{
$product_image2	 = $_FILES[product_image2]['name'];
copy($_FILES[product_image2]['tmp_name'], "product_images/".$product_image2) or die("Image is not uploaded 2");	

$thumb2 = new Thumbnail("product_images/$product_image2");
$thumb2->resize("600","900");
$thumb2->save("product_images/large/$product_image2","100%");

$thumb = new Thumbnail("product_images/$product_image2");
$thumb->resize("300","380");
$thumb->save("product_images/$product_image2","100%");
}

if($_FILES[product_image3][tmp_name]!='')
{
$product_image3	 = $_FILES[product_image3]['name'];
copy($_FILES[product_image3]['tmp_name'], "product_images/".$product_image3) or die("Image is not uploaded 3");	

$thumb2 = new Thumbnail("product_images/$product_image3");
$thumb2->resize("600","900");
$thumb2->save("product_images/large/$product_image3","100%");

$thumb = new Thumbnail("product_images/$product_image3");
$thumb->resize("300","380");
$thumb->save("product_images/$product_image3","100%");
}


if($_FILES[product_image4][tmp_name]!='')
{
$product_image4	 = $_FILES[product_image4]['name'];
copy($_FILES[product_image4]['tmp_name'], "product_images/".$product_image4) or die("Image is not uploaded 4");	

$thumb2 = new Thumbnail("product_images/$product_image4");
$thumb2->resize("600","900");
$thumb2->save("product_images/large/$product_image4","100%");

$thumb = new Thumbnail("product_images/$product_image4");
$thumb->resize("300","380");
$thumb->save("product_images/$product_image4","100%");
}

?>


<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="pageHead">
<div id="txtPageHead"></div>
</td>
</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td id="content" align="center"><form method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate(this);">
<input type="hidden" name="product_id" value="<?php echo $_REQUEST['product_id'];?>" />
<input type="hidden" name="color" value="<?php echo $_REQUEST['color'];?>" />

<br />
<table  border="0" width="70%"align="center" cellpadding="2" cellspacing="0" class="tableSearch">
<tr align="center">
<th colspan="2"><? if($_REQUEST['set_flag']=='update')
echo "Edit Product Description for color " .$_REQUEST['color']; else echo "Add Product Description for color " .$_REQUEST['color'];?></th>
</tr>

<tr><td width="20%" height="10"></td></tr>


<tr>
<td class="tdLabel">Related  Image1</td>
<td class="tdLabel">

<input name="product_image1" type="file" ><br />
<?php
if($resData['product_image1'])
{
?><?php } ?></td>
</tr>


<tr>
<td class="tdLabel">Related  Image2</td>
<td class="tdLabel">
<input name="product_image2" type="file" ><br />
<?php
if($resData['product_image2'])
{
?><?php } ?></td>
</tr>

<tr>
<td class="tdLabel">Related  Image3</td>
<td class="tdLabel">
<input name="product_image3" type="file" ><br />
<?php
if($resData['product_image3'])
{
?><?php } ?></td>
</tr>

<tr>
<td class="tdLabel">Related  Image4</td>
<td class="tdLabel">
<input name="product_image4" type="file" ><br />
</td>
</tr>

<tr>
<td align="center" colspan="2">
<input type="submit" class="btn btn-info"  name="submit" value='Submit' >				</td>
</tr>
</table>
</form>
</td>
</tr>
</table>
