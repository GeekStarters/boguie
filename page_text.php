<?php
$menu_active = "none";
include './header.php';
?>
<?php include_once("includes/main.inc.php");
if($_SESSION['sess_admin_id']==''){
	header("location:index.php");
}
include("session_check.php");

if(is_post_back()){
	if($page_id!='') {
		$sql = "update tbl_content set page_title='$page_title', page_text='$page_text' where page_id = $page_id ";
		db_query($sql);
		
		set_session_msg("Texto actualizado correctamente.");
	}
	
	header("Location: page_list.php?start=$start");
	exit;
}

$page_id = $_REQUEST['page_id'];

if($page_id!='') {
	$sql = "select * from tbl_content where page_id = '$page_id'";
	$result = db_query($sql);

	if($line_raw = mysql_fetch_array($result)) {
		@extract($line_raw);
	}
}?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    $menu_active = "textos";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">

                <?php $title_bread = "Administrar contenido del App";
                include("top.inc.php");
		?>
            <div class="row">
                <?=display_sess_msg()?>
                <center class="msg"><?=$msg;?></center>
            </div>
            <div class="row">
<form class="form-horizontal form-groups-b" method="post" action="" enctype="multipart/form-data" name="form1" id="form1" onSubmit="return validate(this);">
	<div class="form-group">
            <label class="col-sm-3 control-label">Nombre texto </label>
            <div class="col-sm-5">
                 <input data-validation="required" data-validation-error-msg="Campo requerido" type="text" class="form-control" name="page_title" value="<?=$page_title?>" size="75" />
            </div>
        </div>
	<div class="form-group">
            <label class="col-sm-3 control-label">Texto</label>
            <div class="col-sm-5">
                <textarea data-validation="required" data-validation-error-msg="Campo requerido" class="form-control" name="page_text" id="page_text" rows="10" cols="50"><?=$page_text?></textarea>
            </div>
        </div>
     <div class="form-group">
         <div class="col-sm-offset-3 col-sm-5">
            <a class="btn btn-default" href="page_list.php?start=<?=$start?>" class="redcolor">Volver</a>
            <input class="btn btn-blue" type=submit name="submit" value="Guardar">
         </div>
     </div>
       
	
        
		
	</form>
        </div>
        </div>
</div>
<?php
include './footer.php';
?>
<script type="text/javascript">
    /*CKEDITOR.replace( 'page_text', {
        toolbar: [
                [ 'Source','-','Cut','Copy','Paste','-','Undo','Redo','Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt','-','Bold','Italic','Underline','-','Strike','Subscript','Superscript','-','NumberedList','BulletedList','-','Outdent','Indent','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
                [ 'BidiLtr','BidiRtl','Link','Unlink','Anchor','-','Image','Flash','Table','HorizontalRule','SpecialChar','Iframe','-','TextColor','BGColor','Styles','Format','Font','FontSize' ]
        ],
        enterMode: CKEDITOR.ENTER_BR,
        toolbarStartupExpanded : true,
        toolbarCanCollapse : false,
        width: 727,
        height: 400
    });*/
</script>
<script> $.validate(); </script>
</body>
</html>