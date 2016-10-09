<?php
include ('../includes/include_files.php');
$driver_email = $_REQUEST['email'];
$driver_id = mysql_fetch_object(mysql_query("select * from tbl_user where email='$driver_email'"));
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

            <div data-role="content">
                <div id="details">
                    <?php
                    $sel = "select * from tbl_payments where driver_id='$driver_id->id' and status='approved'";
                    $sel_exe = mysql_query($sel);
                    $count = mysql_num_rows($sel_exe);
                    $amount = 0.00;
                    while ($data = mysql_fetch_array($sel_exe)) {
                        $amount  = $amount + $data['amount'];
                    }
                    ?>


                    <div class="rate-card">Amount</div><div class="rate-card" style="text-align:right;">$<?php echo $amount; ?></div>

                </div>
                <!-- Form Ends-->

                <!-- Footer Starts -->
                <?php include '../includes/footer.php'; ?>
                <!-- Footer Ends -->
            </div>
            <!-- /content -->

            <div data-role="panel" id="left-panel" data-theme="b" style="margin-top: -20px;">


            </div>
            <!-- Left Panel Ends
                ================================================== -->

            <!-- ToTop Starts
                ================================================== -->
            <!-- <a href="#" class="scrollup">Scroll</a>-->
            <!-- ToTop Ends
                ================================================== -->
        </div>
        <!-- Page Contents Ends
            ================================================== -->

    </body>
</html>