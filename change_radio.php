
<?php
    require_once("includes/main.inc.php");
    $id = $_GET['id'];

    mysql_query("SET NAMES 'utf8'");

    $sql = " select *  from tbl_radio WHERE id='1'";
    $result = db_query($sql);
    // $reccnt = db_scalar($sql_count);

    $row = mysql_fetch_array($result);
    $radio_actual = $row["radio"];

    if (isset($_REQUEST['submit'])) {
        $newRadio = $_REQUEST['newRadio'];
        $sql_update = mysql_query("update tbl_radio setradio='$newRadio' WHERE id='1'") or die(mysql_error());
        header("Refresh:0");
    }
?>
        
<link href="styles.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script language="javascript" src="js/admin.js"></script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="ajax_scab.js"></script>
<script language="javascript" src="../js/jquery-1.3.2.min.js"></script>

<? include("top.inc.php"); ?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">


<center class="msg"><?= $msg; ?></center>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
            <form method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate(this);">
                <br />
                <table  border="0" width="70%"align="center" cellpadding="2" cellspacing="0" class="tableSearch">
            <tr align="center">
                <th colspan="2">Radio de busqueda de taxis</span>
                </th>
            </tr>
            
            <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
            <tr>
                <td class="lightGrayBg" valign="top" nowrap>Dirección de Partida <span class="star">*</span></td>
                <td class="lightGrayBg"><input name="newRadio" id="newRadio"  size="48" type="text" value="<?= $radio_actual ?>" /></td>
            </tr>
            
            <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
            <input type="submit" class="btn btn-info" name="submit" value='Guardar' >
            </tr>
                </table>
            </form>
            <br />
            <?php include("paging.inc.php"); ?>
        </td>
    </tr>
</table>
<?php include("bottom.inc.php"); ?>