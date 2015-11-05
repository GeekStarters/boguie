<?php
$menu_active = "asociar";
include './header.php';
?>

<?php require_once("includes/main.inc.php");

$sql_drivers = "SELECT * FROM tbl_user WHERE usertype='driver' AND taxi =''";
$sql_taxis = "SELECT * FROM tbl_cab WHERE with_driver='0'";
$result_drivers = mysql_query($sql_drivers);
$result_taxis = mysql_query($sql_taxis);
?>
<script src="../js/validation.js"></script>
<link href="styles.css" rel="stylesheet" type="text/css">

<style type="text/css">
    #drivers, #taxis{
        background: #f5f5f5;
        width: 300px;
        border: solid 1px #d1d1d1;
        height: 300px;
        font-size: 15px;
        color: #2d2d2d;
    }
	.center {
    	margin: auto;
    	width: 700px;
	}
	#r{
		float: left;
	}
	#l{
		float: right;
	}
</style>

</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php
                    $menu_active = "taxi";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
		<?php
			$title_bread = "Asociar taxi a taxista";
			include("top.inc.php");
		?>
		
		<div class="row margintop30">
                    <div class="col-sm-6">
                        <div id="l"><strong>Conductores</strong><br/>
                        <select id="drivers" size="10">
                                <?php 
                                        while ($line_raw = mysql_fetch_array($result_drivers, MYSQL_ASSOC)) {
                                ?>
                                <option value=<?= $line_raw['id']; ?>><?= $line_raw['fullname']; ?></option>
                                <?php } ?>
                        </select>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div id="r"><strong>Taxis</strong><br/>
                        <select id="taxis" size="10">
                                <?php 
                                        while ($line_raw = mysql_fetch_array($result_taxis, MYSQL_ASSOC)) {
                                ?>
                                <option value=<?= $line_raw['id']; ?>><?= $line_raw['cab_number']; ?></option>
                                <?php } ?>
                        </select>
                        </div>
                    </div>
                    
		</div>
            <div class="row text-center">
                <button type="button" class="btn btn-success" onclick="send()">Asociar</button>
            </div>
	</div>
</div>
<?php
include './footer.php';
?>
<script type="text/javascript">
function send(){
	var driverSelected = $("#drivers option:selected").val();
	var taxiSelected = $("#taxis option:selected").val();
	$.post( "associate.php", { taxi: taxiSelected, driver: driverSelected },function(result){
        location.reload();
    });
}

</script>
</body>
</html>