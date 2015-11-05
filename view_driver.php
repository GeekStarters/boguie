<?php
require_once('includes/main.inc.php');
$sql_fectch_city=mysql_query("select *, date_format(add_date,'%b %d, %Y') as rdate from tbl_user where id='".$_REQUEST['did']."' and usertype='driver'") or die(mysql_error());
$fetch_record=mysql_fetch_array($sql_fectch_city);
@extract($fetch_record);?>

<?php
include './header.php';
?>


</head>
<body>
<table  border="0" align="center" class="tableSearch table table-bordered">
	<tr bgcolor="#f1f1f1"><td valign="top"class="tdLabel" colspan="2" align="center"><b>Detalles conductor</b></td></tr>
	<tr><td valign="top" colspan="2">&nbsp;</td></tr>
	<tr bgcolor="#f1f1f1"><td valign="top"class="tdLabel" colspan="2"><b><font color="#C05813">Información inicio </font></b></td></tr>
	<tr><td valign="top" colspan="2">&nbsp;</td></tr>
	<tr>
		<td valign="top" class="tdLabel" width="18%"><b>Email</b></td>
		<td class="tdLabel"><?=$email?></td>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Password</b></td>
		<td class="tdLabel"><?=$password?></td>
	</tr>
	
	<tr bgcolor="#f1f1f1">
		<td valign="top"class="tdLabel" colspan="3"><b><font color="#C05813">Detalles personales</font></b></td>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Imagen</b></td>
		<?php  if ($image != '') { ?>
                    <td class="tdLabel"><img src="./profile_pic/<?php echo $image; ?>" width="100"></td>
                <?php }?>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Nombre</b></td>
		<td class="tdLabel"><?=ucwords(strtolower($fullname))?></td>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Móvil</b></td>
		<td class="tdLabel"><?=ucwords(strtolower($mobile))?></td>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Nombre en unidad</b></td>
		<td class="tdLabel"><?=$name_on_card?></td>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Licencia</b></td>
		<td class="tdLabel"><?=$card_num?></td>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Fecha expiracion</b></td>
		<td class="tdLabel"><?=$exp_date?></td>
	</tr>
	
	<tr>
		<td valign="top" class="tdLabel"><b>Agregado</b></td>
		<td class="tdLabel"><?=$add_date?></td>
	</tr>
	<tr>
		<td valign="top" class="tdLabel"><b>Tipo de usuario</b></td>
		<td class="tdLabel"><?=$usertype?></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td align="center">&nbsp;</td>
	</tr>
</table>
    <div align="center"><strong><a class="btn btn-info" href="javascript:window.close();">Cerrar</a></strong></div>
<br><br><br>
</body>
</html>
