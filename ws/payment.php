<?php
include ('../includes/include_files.php');
//include ('process_payment.php');
$user_email = $_REQUEST['email'];
$payment_id = $_REQUEST['payment_id'];
$user_id = mysql_fetch_object(mysql_query("select * from tbl_user where email='$user_email'"));

if (isset($_POST['coupon'])) {

    $coupon_code = $_REQUEST['coupon_code'];

    $sel_coupon = mysql_query("select * from tbl_coupon where coupon='$coupon_code' and status='1'");
    $row_count = mysql_num_rows($sel_coupon);
    if ($row_count > 0) {
        $sel_code = mysql_fetch_array($sel_coupon);
        //$coupon_amount = $sel_code['flat_discount'];

        $sel_coupon2 = mysql_query("select * from tbl_user where email='$user_email'");
        $row = mysql_fetch_array($sel_coupon2);
        if ($row['coupon_code'] == $sel_code['coupon']) {

            $msg = "Invalid Coupon Code!!";
        } else {
            $coupon_amount = $sel_code['flat_discount'];
            $update_coupon = mysql_query("update tbl_user set coupon_code = '$coupon_code' where email='$user_email'");
        }
    } else {
        $msg = "Invalid Coupon Code!!";
    }
}
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
            <!--  <div data-role="header" data-theme="f" class="header">
                  <h1><a href="index.php" rel="external">Book Cab Now</a></h1>
                  <a href="#left-panel" data-shadow="false" ><i class="fa fa-indent fa-2x"></i></a>
                  <!--<a href="#right-panel" data-shadow="false" ><i class="fa fa-bars fa-2x"></i></a>-->
            <!--</div>-->
            <!-- header Ends -->
            <div data-role="content">

                <!-- Form Starts -->
                <div class="form-element" style="padding-top: 20px;">

                    <div id='message_post'><?php echo $msg; ?></div>

                    <div class="form">
                        <form method="post" action="">

                            <input type="text" name="coupon_code" class="text r_amount" value="" placeholder="Enter Coupon Code" style="width:100%"/>

                            <div class="all-button" style="padding-top: 10px;">
                                <input type="submit" value="" data-theme="cc" name='coupon' id="coupon" style="width: 250px;height: 63px;"/>
                            </div>
                        </form>


                    </div>

                    <div class="form">
                        <div>
                            <?php
                            $sel_amount = mysql_query("select * from tbl_payments where passenger_id='" . $user_id->id . "' and status='pending'");
                            $row = mysql_fetch_array($sel_amount);
                            $total_amount = $row['amount'];
                            ?>
                            <table width="100%">
                                <tr>
                                    <td width="70%">Amount For this ride</td>
                                    <td width="30%">$<?php echo $total_amount; ?></td>
                                </tr>
                                <?php if ($coupon_amount != '') { ?>
                                    <tr>
                                        <td width="70%">Your Coupon Code Amount</td>
                                        <td width="30%">$<?php echo $coupon_amount; ?></td>
                                    </tr>
                                    <?php
                                }

                                if ($coupon_amount != '') {

                                    $total_amount = $total_amount - $coupon_amount;
                                    ?>
                                    <tr>
                                        <td width="70%">Total Amount For this ride</td>
                                        <td width="30%">$<?php echo $total_amount; ?></td>
                                    </tr>
                                <?php } else { ?>
                                    <tr>
                                        <td width="70%">Total Amount For this ride</td>
                                        <td width="30%">$<?php echo $total_amount; ?></td>
                                    </tr>

                                <?php } ?>
                            </table>


                        </div>
                        <script>
                            function payment() {
                                window.android.clickOnMakePayment("<?php echo $total_amount; ?>", "<?php echo $payment_id; ?>", "<?php echo "USD"; ?>");

                            }
                        </script>

                        <form class="paypal" action="" method="post" id="paypal_form">

<!-- <input type='hidden' name='cmd' value='_xclick' />
<input type='hidden' name='amount' value='<?php echo $total_amount; ?>' />
<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
<input type='hidden' name='no_shipping' value='0' />
<input type='hidden' name='item_name' value='demo1<?php //echo $product['name']    ?>' />
<input type='hidden' name='item_number' value='0071<?php //echo $product['id']    ?>' />
<input type='hidden' name='invoice' value='WS-21<?php //echo $product['id']    ?>' />
<input type='hidden' name='user_id' value="<?php echo $user_id->id; ?>" />
<input type='hidden' name='currency_code' value='USD' />-->

                            <div class="all-button" style="padding-top: 30px;">
                                <input type="button" value="" data-theme="mp" name='submit' id="submitt" onclick="payment();" style="width: 250px;height: 63px;"/>
                            </div>
                        </form>


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


    </body>
</html>