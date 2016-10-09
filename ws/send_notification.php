<?php
    require_once("includes/main.inc.php");
    include_once('thumbnail.inc.php');
    if (isset($_REQUEST['submit'])) {
        $q;
        $reciepments = $_REQUEST['reciepments'];
        if ($reciepments == "all") {
            $q = "SELECT * FROM gcm_users";
        }else{
            $q = "SELECT * FROM gcm_users WHERE user_type='$reciepments'";
        }
        // $sel_query = mysql_query($q);
        // $row = mysql_fetch_array($sel_query);
        // $user_regID[] = $row['gcm_regid'];
        // $value = $_REQUEST["message"];
        // $msg ="[$push_date][$value]";
        // include_once '../includes/GCM.php';
        // $gcm = new GCM();
        // $registatoin_ids = $driver_regID;
        // $message = array("discount_action" => $msg);
        // $result = $gcm->send_notification($registatoin_ids, $message);
        // set_session_msg("Enviado");
            $users= array();
            $regID= array();
            $sel_query = mysql_query($q);
            while($row = mysql_fetch_assoc($sel_query)){ 
               // echo $row['gcm_regid'];
                //echo "<br>";
                $regID[] = $row['gcm_regid']; 
            } 
            $push_date = date("F j, Y, g:i a");
            $value = $_REQUEST["message"];
            $msg ="[$push_date][$value]";
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $registatoin_ids = $regID;
            $message = array("info" => $msg);
            $result = $gcm->send_notification($registatoin_ids, $message);


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
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
  <script>
  function validate(){
    valor = $("#fare_per_km").val();
    var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

    if(!$("#message").val()) {
        alert("Debes escribir un mensaje");
        return false;
    }

     return true;

  }
</script>


<center class="msg"><?= $msg; ?></center>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td id="pageHead"><div id="txtPageHead">Enviar una nueva notificacion</div></td></tr>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td id="content" align="center"><strong class="msg"><?= display_sess_msg() ?></strong>
            <form method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate();">
                <br />
                <table  border="0" width="30%"align="center" cellpadding="2" cellspacing="0" class="tableSearch">
                    <tr align="center">
                        <th colspan="2">Notificacion</th>
                    </tr>
                    <tr><td height="10"></td></tr>
                    <tr>
                        <td class="lightGrayBg" width="20%">Receptores<span class="star">*</span></td>
                        <td class="tdLabel"><select name="reciepments" id="reciepments" style="width:200px; "/>
                            <option value="driver">Conductores</option>
                            <option value="passenger">Pasajeros</option>
                            <option value="all">Todos</option>
                        </td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr>
                        <td class="lightGrayBg" valign="top" nowrap>Mensaje<span class="star">*</span></td>
                        <td class="lightGrayBg"><textarea rows="4" cols="50" name="message" id="message" size="48" type="text" value="" maxlength="150"></textarea></td>
                    </tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>
                    <tr><td class='tdLabel' colspan='2'>&nbsp;</td></tr>

                        <td align="center" colspan="2">
                        <input type="submit" class="btn btn-info"  name="submit" value='Enviar' >
                    </tr>
                </table>
            </form>
            <br />
            <?php include("paging.inc.php"); ?>
        </td>
    </tr>
</table>
<?php include("bottom.inc.php"); ?>