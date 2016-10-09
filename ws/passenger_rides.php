<?php
include ('../includes/include_files.php');

$user_email = mysql_real_escape_string(addslashes($_REQUEST['email']));
$user_id = mysql_fetch_object(mysql_query("select * from tbl_user where email='$user_email'"));
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

            <!-- header Ends -->
            <div data-role="content">


                <h2>Rides</h2>
                <div data-role="collapsible-set" data-theme="c" data-content-theme="d">
                    <div data-role="collapsible">
                        <h3>Current Ride</h3>
                        <ul class="fa-ul">
                            <?php
                            $sel = "select * from tbl_ride where passenger='$user_id->id' and ride_status='confirm' order by pickup_date and pickuptime limit 1";
                            $sel_exe = mysql_query($sel);
                            $data_count = mysql_num_rows($sel_exe);
                            $data = mysql_fetch_array($sel_exe);

                            if ($data_count > 0) {
                                ?>
                                <li><i class="fa-li fa fa-arrow-right"></i>
                                    <?php echo "From " . '<i class="fa-li fa fa-arrow-right"></i>' . $data['pickup_address'] . " To " . $data['dropoff_address'] . " ON " . $data['pickup_date'] . "--" . $data['pickuptime'] ?>
                                </li>
                            <?php } else { ?>

                                <li><i class="fa-li fa fa-arrow-right"></i>
                                    No Ride Found
                                </li>

                            <?php } ?>
                        </ul>
                        <?php
                        //echo '<br/>';
                        $sel_pay_id = "select * from tbl_payments where passenger_id='$user_id->id' and driver_id='" . $data['driver'] . "' and pickup_date='" . $data['pickup_date'] . "' and status='pending' ";
                        $sel_pay_exe = mysql_query($sel_pay_id);
                        $count = mysql_num_rows($sel_pay_exe);
                        $payment_id = mysql_fetch_array($sel_pay_exe);
                        if ($count > 0) {
                            ?>

                            <a href="payment.php?email=<?php echo $user_email; ?>&payment_id=<?php echo $payment_id['payment_id']; ?>">Make Payment</a>
                        <?php } ?>
                    </div>
                    <div data-role="collapsible">
                        <h3>Upcoming</h3>
                        <ul class="fa-ul">
                            <?php
                            $sel = "select * from tbl_ride where passenger='$user_id->id' and ride_status='confirm' order by pickup_date and pickuptime limit 1,10";
                            $sel_exe = mysql_query($sel);
                            $data_count = mysql_num_rows($sel_exe);
                            if ($data_count > 0) {
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
                            $sel = "select * from tbl_ride where passenger='$user_id->id' and  ride_status='completed' ";
                            $sel_exe = mysql_query($sel);
                            $data_count = mysql_num_rows($sel_exe);
                            if ($data_count > 0) {
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