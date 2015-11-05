<?php
include './header.php';
?>
<?php require_once("includes/main.inc.php");
if(isset($_REQUEST['update'])){
    
}

?>
<style type="text/css">
.contenedor{
    width: 100%;
}
</style>
</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    $menu_active = "calendario";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">

                <?php $title_bread = "Calendario";
                include("top.inc.php");
		?>
            <div class="row">
                <?=display_sess_msg()?>
                <center class="msg"><?=$msg;?></center>
            </div>
		<div class="row">

                    <center class="msg"><?=$msg;?></center>
                       <div class="contenedor" style="width: 95%;">
                           <iframe frameBorder="0" style="width: 100%;" onload='javascript:resizeIframe(this);' src="./calendario/index.html"></iframe>
                       </div>
                </div>
        </div>
</div>
<script language="javascript" type="text/javascript">
    function resizeIframe(obj) {
        alto=obj.contentWindow.document.body.scrollHeight+60;
        obj.style.height = alto + 'px';
    }
</script>
<?php
include './footer.php';
?>
</body>
</html>