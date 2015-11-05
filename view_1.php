<? require_once("includes/main.inc.php");

if($_SESSION['sess_admin_id']=='')
{
	header("location:index.php");
}
if($_REQUEST['page_id']!=''){

$title=searchSingleRecord("tbl_content","page_title","page_id",$page_id);
$msg=searchSingleRecord("tbl_content","page_text","page_id",$page_id);


}


?>


<link href="styles.css" rel="stylesheet" type="text/css"><br />



<div style="padding-left:10px;"><h2><?php echo $title;?></h2></div>


<div style="padding-left:10px;"><?=$msg?></div>


  <br /><br>


 <div align="center"><a href='javascript:' onclick="self.close();">Close</a></div>