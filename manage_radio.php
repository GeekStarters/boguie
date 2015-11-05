<?php
$menu_active = "none";
include './header.php';
?>
<?php require_once("includes/main.inc.php");
    

if(isset($_REQUEST['radio'])){
	$radio = $_REQUEST['radio'];
	$query = db_query("UPDATE tbl_radio SET radio='$radio'  WHERE id='1'");
        set_session_msg("Readio de búsqueda actualizado correctamente.");
	//header("Refresh:0");
}

$sql = " select *  from tbl_radio WHERE id='1'";
    $result = db_query($sql);
    // $reccnt = db_scalar($sql_count);
    $row = mysql_fetch_array($result);
    $radio_actual = $row["radio"];
?>


</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    $menu_active = "radio";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">

                <?php $title_bread = "Radio de búsqueda";
                include("top.inc.php");
		?>
            <div class="row">
                <div class="col-sm-12">
                    <?=display_sess_msg()?>
                    <center class="msg"><?=$msg;?></center>
                </div>
                
            </div>
            
            <div class="row margintop30">
                <form class="form-horizontal form-groups-b" method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>>
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Radio (km):</label>
                            <div class="col-sm-5">
                                <input data-validation="custom" data-validation-regexp="^\d+(\.\d+)?$" data-validation="required" data-validation-error-msg="Ingrese un radio válido en kilometros, enteros o decimales."  type="tetx" name="radio" id="radio" class="form-control" value="<?= $radio_actual ?>"><br>
                            </div>
                        </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <input type="submit" class="btn btn-info" value="Guardar">
                        </div>
                    </div>
                        
                </form>
            </div>
        </div>
</div>
<?php
include './footer.php';
?>
<script> $.validate(); </script>
</body>
</html>