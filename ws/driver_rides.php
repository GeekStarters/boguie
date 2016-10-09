<?php
include ('../includes/include_files.php');

$driver_email = $_REQUEST['email'];
$driver_id = mysql_fetch_object(mysql_query("select * from tbl_user where email='$driver_email'"));


/* --Changes by KKB on 17 April 2015 -- */
if (isset($_REQUEST['update_payment'])) {

    $amount = $_REQUEST['ride_amount'];
    $pickup_date = $_REQUEST['pickup_date'];
    $pickup_time = $_REQUEST['pickup_time'];
    $passenger = $_REQUEST['passenger'];
    $driver = $_REQUEST['driver'];

//echo $text123="update tbl_payments set amount='$amount' where driver_id='".$driver."' and passenger_id='".$passenger."' and pickup_date='".$pickup_date."' and pickup_time='".$pickup_time."' and status='pending'";
    $update = mysql_query("update tbl_payments set amount='$amount' where driver_id='" . $driver . "' and passenger_id='" . $passenger . "' and pickup_date='" . $pickup_date . "' and pickup_time='" . $pickup_time . "' and status='pending'");
    if ($update) {

        $msg = "Fare Updated Successfully.";
    }
    else{
        $msg = "Fare not updated.";
    }
}
/* --Changes by KKB on 17 April 2015 -- */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Cab Now</title>
    </head>
    <body>

        <!-- Page Contents Starts
            ================================================== -->
        <div data-role="page" id="page" data-theme="d">
            <!-- header Starts -->

            <div data-role="content">
                <div id='message_post'><?php echo $msg; ?></div>

                <h2>Rides</h2>
                <div data-role="collapsible-set" data-theme="c" data-content-theme="d">
                    <div data-role="collapsible">
                        <h3>Current Ride</h3>
                        <ul class="fa-ul">
                            <?php
                            $sel = "select * from tbl_ride where driver='$driver_id->id' and ride_status='confirm' and ride_type= 'now' order by id desc limit 1";
                            $sel_exe = mysql_query($sel);
                            $count = mysql_num_rows($sel_exe);
                            if ($count > 0) {
                                while ($data = mysql_fetch_array($sel_exe)) {
                                    ?>

                                    <li><i class="fa-li fa fa-arrow-right"></i>
                                        <?php echo "From " . '<i class="fa-li fa fa-arrow-right"></i>' . $data['pickup_address'] . " To " . $data['dropoff_address'] . " ON " . $data['pickup_date'] . "--" . $data['pickuptime'] ?>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li><i class="fa-li fa fa-arrow-right"></i>
                                    No Ride Found
                                </li>
                            <?php } ?>
                        </ul>
                        <?php if ($count > 0) {
                            $sel_exe1 = mysql_query($sel);
                            $data = mysql_fetch_array($sel_exe1);
                            ?>
                            <div class="form">
                                <form method="post" action="">
                                    <!-- --Changes by KKB on 17 April 2015 -- -->
                                    <input type="text" name="ride_amount" class="text r_amount" value="" placeholder="Entre monto a cobrar" style="width:100%"/>
                                    <input type="hidden" name="pickup_date" value="<?php echo $data['pickup_date'] ?>" />
                                    <input type="hidden" name="pickup_time" value="<?php echo $data['pickuptime'] ?>" />
                                    <input type="hidden" name="passenger" value="<?php echo $data['passenger'] ?>" />
                                    <input type="hidden" name="driver" value="<?php echo $data['driver'] ?>" />
                                    <div class="all-button update-payment" style="padding-top: 10px;">
                                        <input type="submit" value="Actualizar monto de cobro" data-theme="upb" name='update_payment' id="update_payment" style="width: 180px;height: 45px;"/>
                                    </div>
                                    <!-- --Changes by KKB on 17 April 2015 -- -->
                                </form>


                            </div>
                        <?php } ?>
                    </div>
                    <div data-role="collapsible">
                        <h3>Upcoming</h3>
                        <ul class="fa-ul">
                            <?php
                            $sel = "select * from tbl_ride where driver='$driver_id->id' and ride_status='confirm' order by id desc limit 1,10";
                            $sel_exe = mysql_query($sel);
                            $count = mysql_num_rows($sel_exe);
                            if ($count > 0) {
                                while ($data = mysql_fetch_array($sel_exe)) {
                                    ?>

                                    <li><i class="fa-li fa fa-arrow-right"></i>
                                        <?php echo "From " . $data['pickup_address'] . " To " . $data['dropoff_address'] . " ON " . $data['pickup_date'] . "--" . $data['pickuptime'] ?>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li><i class="fa-li fa fa-arrow-right"></i>
                                    No Ride Found
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                    <div data-role="collapsible">
                        <h3>Completed</h3>
                        <ul class="fa-ul">
                            <?php
                            $sel = "select * from tbl_ride where driver='$driver_id->id' and  ride_status='completed' ";
                            $sel_exe = mysql_query($sel);
                            $count = mysql_num_rows($sel_exe);
                            if ($count > 0) {
                                while ($data = mysql_fetch_array($sel_exe)) {
                                    ?>

                                    <li><i class="fa-li fa fa-arrow-right"></i>
                                        <?php echo "From " . $data['pickup_address'] . " To " . $data['dropoff_address'] . " ON " . $data['pickup_date'] . "--" . $data['pickuptime'] ?>
                                    </li>
                                    <?php
                                }
                            } else {
                                ?>
                                <li><i class="fa-li fa fa-arrow-right"></i>
                                    No Ride Found
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <!-- Form Ends-->

                <!-- Footer Starts -->
                <?php include '../includes/footer.php'; ?>
                <!-- Footer Ends -->
            </div>
            <!-- /content -->
            <!-- Left Panel Starts
                ================================================== -->

            <div data-role="panel" id="left-panel" data-theme="b" style="margin-top: -20px;">

            </div>
            <!-- Left Panel Ends
                ================================================== -->

        </div>
        <!-- Page Contents Ends
            ================================================== -->

    </body>
</html>