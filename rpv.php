<?php require_once("includes/main.inc.php");


if(isset($_REQUEST['update'])){
	
}

?>
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="fckeditor/fckeditor.js"></script>
<? include("top.inc.php");?>
<center class="msg"><?=$msg;?></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td id="pageHead"><div id="txtPageHead">Reporte de reservaciones</div></td>
	</tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<table width="100%"  border="0" cellpadding="0" cellspacing="1" class="tableList">
                        <tr>
                            <th width="5%">Seleccionar todos<input name="check_all" type="checkbox" id="check_all" value="1" onclick="checkall(this.form)" /></th>
                            <th width="5%">&nbsp;</th>
                            <th width="20%" nowrap="nowrap">Cliente</th>
                            <th width="20%" nowrap="nowrap">Punto partida</th>
                            <th width="10%" nowrap="nowrap">Punto llegada</th>
                            <th width="10%" nowrap="nowrap">Fecha</th>
                            <th width="10%" nowrap="nowrap">Hora</th>
                            <th width="15%">Estado</th>
                        </tr>

	</table>
<? include("bottom.inc.php");?>








