
<?php
    require_once("includes/main.inc.php");
    $id = $_GET['id'];

    mysql_query("SET NAMES 'utf8'");

    $sql = " select *  from tbl_ride where id='$id'";
    $result = db_query($sql);
    // $reccnt = db_scalar($sql_count);

    $row = mysql_fetch_array($result);
    $driver = $row["driver"];
    $passenger = $row["passenger"];
    $p_id = $row["passenger"];
    $pickup_time = $row['pickup_time'];
    $pickup_date = $row['pickup_date'];
    $ride_status = $row["ride_status"];
    $dropoff_address = $row["dropoff_address"];
    $pickup_address = $row["pickup_address"];
    $driver_email = $row["driver"];
    $result = mysql_query("SELECT `fullname` FROM tbl_user WHERE id = '$passenger'") or die(mysql_error()); while($row = mysql_fetch_assoc($result)){ $passenger =  $row['fullname']; } 
    $result = mysql_query("SELECT `email` FROM tbl_user WHERE id = '$driver'") or die(mysql_error()); while($row = mysql_fetch_assoc($result)){ $passenger =  $driver_email['email']; } 

if (isset($_REQUEST['submit'])) {
        $driver_id = $_REQUEST['driver_id'];
        $cab;
        $q = mysql_query("SELECT * FROM tbl_user WHERE id = '$driver_id'") or die(mysql_error()); while($row = mysql_fetch_assoc($q)){ $cab =  $row['taxi'];}
        $cab_name;
        $q2 = mysql_query("SELECT * FROM tbl_cab WHERE id = '$cab'") or die(mysql_error()); while($row = mysql_fetch_assoc($q2)){ $cab_name =  $row['cab_number'];}
        $set_ride_status = $_REQUEST['ride_status'];
        $drop = $_REQUEST['dropoff_address'];
        $pick = $_REQUEST['pickup_address'];

        $sql_update = mysql_query("update tbl_ride set
		driver='$driver_id',
		cab='$cab',
		cab_number ='$cab_name',
		dropoff_address  = '$drop',
		pickup_address ='$pick',
		ride_status='$set_ride_status' where id='" . $id . "'") or die(mysql_error());

        ///// GCM
        if ($set_ride_status == "confirmed") {
            /// DRIVER
            $sql = "select *  from tbl_ride where id='$id'";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $p_id = $row['passenger'];
            $driverID = $row["driver"];
            $newDate = $row["pickup_date"];
            $time = $row["pickup_time"];
            $pick_add = $row["pickup_address"];
            $dest_add = $row["dest_add"];
            $insert_id = $id;
            $discount = $row["discount"];
            $driver= array();
            $driver_regID= array();
            $sqlD = "select *  from tbl_user where id='$driverID'";
            $resultD = mysql_query($sqlD);
            $rowD = mysql_fetch_array($resultD);
            $emailD = $rowD['email'];
            //obtener gcm_users
            $sql_gcm=mysql_query("Select * from gcm_users where email='$emailD'");
            while ($fila=mysql_fetch_array($sql_gcm)) {
                $driver_regID[] = $fila['gcm_regid'];
            }
            $sql_user=mysql_query("Select * from tbl_user where id='$p_id' LIMIT 1");
            while ($fila_user=mysql_fetch_array($sql_user)) {
                $user_name= $fila_user['fullname'];
                $user_no= $fila_user['mobile'];
            }
            $msg ="[$user_name][$user_no][$newDate][$time][$pick_add][$dest_add][$insert_id][$discount]";
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $message = array("ride_now_confirm_msg" => $msg);
            $result = $gcm->send_notification($driver_regID, $message);


            //PASSANGER
            $sqlP = "select *  from tbl_user where id='$p_id'";
            $resultP = mysql_query($sqlP);
            $rowP = mysql_fetch_array($resultP);
            $emailP = $rowP['email'];
            $passenger_regID= array();
            $new_sql_gcm=mysql_query("Select * from gcm_users where email='$p_id'");
            while ($fila=mysql_fetch_array($new_sql_gcm)) {
                $passenger_regID[] = $fila['gcm_regid'];
            }
            $driver_info = "select * from tbl_user where id='$driverID'";
            $driver_data = mysql_fetch_object(mysql_query($driver_info));
            $driver_name = $driver_data->fullname;
            $driver_no = $driver_data->mobile;
            $driver_cab = $driver_data->taxi;

            $cab_info = "select * from tbl_cab where id='$driver_cab'";
            $cab_data = mysql_fetch_object(mysql_query($driver_info));
            $cab = $driver_data->cab_number;

            $cero = "10";
            $msg ="[$id][$driver_name][$driver_no][$cab][$cero][$cero][$insert_id]";
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $message = array("carrera_confirmada" => $msg);
            $result = $gcm->send_notification($passenger_regID, $message);
        }

        /// GCM Canceled
        elseif($set_ride_status == "canceled") {
            $sql = "select *  from tbl_ride where id='$id'";
            $result = mysql_query($sql);
            $row = mysql_fetch_array($result);
            $p_id = $row['passenger'];
            $driverID = $row["driver"];
            $driver= array();
            $regID= array();

            ///Driver
            $sqlD = "select *  from tbl_user where id='$driverID'";
            $resultD = mysql_query($sqlD);
            $rowD = mysql_fetch_array($resultD);
            $emailD = $rowD['email'];
            $sql_gcm=mysql_query("Select * from gcm_users where email='$emailD'");
            while ($fila=mysql_fetch_array($sql_gcm)) {
                $regID[] = $fila['gcm_regid'];
            }

            //Passanger
            $sqlP = "select *  from tbl_user where id='$p_id'";
            $resultP = mysql_query($sqlP);
            $rowP = mysql_fetch_array($resultP);
            $emailP = $rowP['email'];
            $sql_gcm=mysql_query("Select * from gcm_users where email='$emailP'");
            while ($fila=mysql_fetch_array($sql_gcm)) {
                $regID[] = $fila['gcm_regid'];
            }
            include_once '../includes/GCM.php';
            $gcm = new GCM();
            $registatoin_ids = $regID;
            $cancelar="cancelar";
            $msgE ="[$cancelar][$id]";
            $message = array("cancelar_carrera" => $msgE);
            $result = $gcm->send_notification($regID, $message);
        }
        ?>
        <script language="javascript">location.href = 'admin_welcome.php'</script>
        <?
        exit;
    }


?>
<?php include './header.php'; ?>
</head>
<body class="page-body  page-fade">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<div class="sidebar-menu">

		<?php if($_SESSION['sess_admin_id']!=""){?>
                    <?php include("left.inc.php");?>
                <? }?>

	</div>
	<div class="main-content">
		<?php
                $title_bread = "Ultimas notificaciones / reservaciones";
                include("top.inc.php")
                ;?>
            <div class="row margintop30">
                
<center class="msg"><?= $msg; ?></center>



    
    <form method="post" class="form-horizontal form-groups-b" action="" name="form2" id="form2" enctype="multipart/form-data"onsubmit="return validate(this);">
        <div class="form-group" style="display: none;">
            <p>Cambiar reservación de : <span style="color:black"><?php echo $passenger;?></span></p>
        </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="driver_id">Conductor asignado<span class="star">*</span></label>
                        <div class="col-sm-5">
                            <select name="driver_id" id="driver_id" class="form-control">
                                <option value=""></option>
                                <?php $sel="SELECT * FROM `tbl_user` WHERE usertype = 'driver'";
                                $exe=mysql_query($sel) or die("can't access");
                                while($data=mysql_fetch_array($exe)){?> 
                                <? if($driver == $data['id']){?>
                                    <option value="<?=$data['id']?>" <? { echo "selected"; }?>><?=$data['fullname']?></option>
                                <? } else { ?>
                                   <option value="<?=$data['id']?>"><?=$data['fullname']?></option>
                                <? }?>
                                <? }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="pickup_address">Dirección de Partida <span class="star">*</span></label>
                        <div class="col-sm-5">
                            <input name="pickup_address" id="pickup_address" class="form-control"  size="48" type="text" value="<?= $pickup_address ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="pickup_address">Dirección de llegada <span class="star">*</span></label>
                        <div class="col-sm-5">
                            <input name="dropoff_address" id="dropoff_address" class="form-control" size="48" type="text" value="<?= $dropoff_address ?>" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="pickup_address">Estado <span class="star">*</span></label>
                        <div class="col-sm-5">
                            <select name="ride_status" id="ride_status" class="form-control">
                            <? if($ride_status == "pending"){?>
                                    <option value="pending" <? { echo "selected"; }?>>Pendiente</option>
                                    <option value="confirmed" >Confirmada</option>
                                    <option value="canceceled" >Cancelada</option>
                            <? } elseif ($ride_status == "confirmed") { ?>
                                    <option value="confirmed" <? { echo "selected"; }?>>Confirmada</option>
                                    <option value="canceled" >Cancelada</option>
                            <? } else { ?>
                                    <option value="confirmed" <? { echo "canceled"; }?>>Cancelada</option>
                            <? }?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-5">
                            <a class="btn btn-default" href="<?= $_SERVER[HTTP_REFERER] ?>">Volver </a>
                            <? if ($ride_status != "canceled") {?>              
                                    <input type="submit" class="btn btn-info" name="submit" value='Guardar' >
                            <? } ?>
                        </div>
                    </div>
   
           <input style="display:none" name="usertype" size="48" type="text" value="<?= passenger ?>" />
           
                
                
            </form>

            </div>
            <br />
            <?php include("paging.inc.php"); ?>
</div>
	</div>
</div>
<?php
include './footer.php';
?>
</body>
</html>