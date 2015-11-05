<?php
include './header.php';
?>
<?php
    require_once("includes/main.inc.php");
    include_once('thumbnail.inc.php');
    if (isset($_REQUEST['submit'])) {
        $q;
        $reciepments = $_REQUEST['reciepments'];
        if ($reciepments == "all") {
            $q = "SELECT * FROM gcm_users where gcm_regid!=''";
        }else{
            $q = "SELECT * FROM gcm_users WHERE gcm_regid!='' and user_type='$reciepments'";
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
            //echo $q;
            $sel_query = mysql_query($q);
            while($row = mysql_fetch_assoc($sel_query)){ 
               /* echo $row['gcm_regid'];
                echo "<br>";
                echo $row['email'];
                echo "<br><br><br>";*/
                $regID[] = $row['gcm_regid']; 
            } 
            $push_date = date("F j, Y, g:i a");
            $value = $_REQUEST["message"];
            $msg ="[$push_date][$value]";
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            /*foreach ($regID as &$valor) {
                echo $valor;
                echo "<br><br><br>";
            }*/

            $registatoin_ids = $regID;
            $message = array("info" => $msg);
            $result = $gcm->send_notification($registatoin_ids, $message);


    }
?>


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

</head>
<body class="page-body  page-fade">

<div class="page-container">
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php 
                    $menu_active = "notificacion";
                    include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">

                <?php $title_bread = "Enviar una nueva notificacion";
                include("top.inc.php");
		?>
            <div class="row">
                <?=display_sess_msg()?>
                <center class="msg"><?=$msg;?></center>
            </div>
            
            <div class="row margintop30">
                
                    <form class="form-horizontal form-groups-b" method="post" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate();">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Receptores<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <select class="form-control" name="reciepments" id="reciepments" style="width:200px; ">
                                    <option value="driver">Conductores</option>
                                    <option value="passenger">Pasajeros</option>
                                    <option value="all">Todos</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Mensaje<span class="star">*</span></label>
                            <div class="col-sm-5">
                                <textarea class="form-control" rows="4" cols="50" name="message" id="message" size="48" type="text" value="" maxlength="150"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <input type="submit" class="btn btn-info"  name="submit" value='Enviar' >
                            </div>
                        </div>
                    </form>
            </div>
            
            <div class="row">
                <div class="col-sm-12">
                    <?php include("paging.inc.php"); ?>
                </div>
            </div>
        </div>
</div>
<?php
include './footer.php';
?>
</body>
</html>