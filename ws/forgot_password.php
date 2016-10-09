<?php
include ('../includes/include_files.php');
if (isset($_POST['submit'])) {


    $email_address = mysql_real_escape_string(addslashes($_REQUEST['email']));

    if ($email_address != "") {

        $checkinfo = mysql_query("select * from tbl_user where email='" . $_POST['email'] . "' ");
        $count_email = mysql_num_rows($checkinfo);
        if ($count_email != 0) {


            $res = mysql_fetch_object($checkinfo);
            $passwd = $res->password;

            $to = "$email_address";
            $subject = "Your Password For Cab Book Now App";

            $message = "
<html>
<head>
<title>Your Password For Cab Book Now App</title>
</head>
<body>
<table>
<tr>
<td>User Name:</td>
<td>$email_address</td>
</tr>
<tr>
<td>Password:</td>
<td>$passwd</td>
</tr>
</table>
</body>
</html>
";

// Always set content-type when sending HTML email
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

// More headers
            $headers .= 'From:Cab Book Now <' . $admin_mail . ">\r\n";
//$headers .= 'Cc: myboss@example.com' . "\r\n";

            $mail = mail($to, $subject, $message, $headers);

            if ($mail) {

                $msg = "Please Check Your Email For Password.";
            }
        } else {

            $msg = " Email ID Doesn't Exist.";
        }
    } else {

        $msg = "Please Enter Email ID";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Cab Now</title>
        <link rel="stylesheet" href="../js/validation/validationEngine.jquery.css" type="text/css"/>
        <script src="../js/validation/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
        <script src="../js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
        <script>
            jQuery(document).ready(function() {
                // binds form submission and fields to the validation engine
                jQuery("#SignForm").validationEngine({promptPosition: "topRight:-130"});
            });
        </script>
        <!--End form validation JS and CSS -->

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
                        <form method='post' action='' name='SignForm' id='SignForm'>


                            <input type="email" name="email" class="validate[required,custom[email]] text ur-email"  placeholder="Email *" style="width:100%"/>                           
                            <div class="all-button" style="padding-top: 30px;">
                                <input type="submit" value="" data-theme="fp" name='submit' id="submit" style="width: 250px;height: 63px;"/>
                            </div>
                        </form>
                        <div class="login-links">

                            <a onClick="window.android.clickOnAndroidLogin();">Remember Password ? Login Now</a><br>
                        </div>
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
            <!-- Left Panel Starts
                ================================================== -->
            <div data-role="panel" id="left-panel" data-theme="b" style="margin-top: -20px;">

<?php //include 'includes/menu.php';  ?>
                <!-- Main Menu Ends -->
                <!-- Main Menu Ends -->
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
        <!-- Javascript Files
            ================================================== -->
       <!-- <script src="owl-carousel/owl-carousel/owl.carousel.js"></script>-->
        <!-- Custom JS File -->
       <!-- <script src="js/custom.js"></script>
        <script src="menu/js/main.js"></script>-->


        <!-- Retina Display -->
        <!--<script src="js/Retina/retina.js"></script>-->
    </body>
</html>