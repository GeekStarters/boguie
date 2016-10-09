<?php
include ('../includes/include_files.php');
$msg = "";


/* ----ON SUBMIT------ */
if (isset($_POST['submit'])) {

    $date = date('Y-m-d');

    $full_name = mysql_real_escape_string(addslashes($_REQUEST['fname']));
    $email_address = mysql_real_escape_string(addslashes($_REQUEST['email']));
    $pass = mysql_real_escape_string(addslashes($_REQUEST['password']));
    $contact_no = mysql_real_escape_string(addslashes($_REQUEST['mobile']));
    $usertype = mysql_real_escape_string(addslashes($_REQUEST['user-type']));
    if($usertype='driver'){
        $status='Inactive';
    }
    else
    {
        $status="Active";
    }

    if ($full_name != "" && $email_address != "" && $pass != "" && $contact_no != "" && $usertype != "") {

        $checkinfo = mysql_query("select * from tbl_user where email='" . $_POST['email'] . "' ");
        $count_email = mysql_num_rows($checkinfo);
        if ($count_email == 0) {

            $reg_ins = mysql_query("insert into tbl_user(`fullname`, `email`, `password`, `mobile`, `usertype`,`add_date`, `status` ) values ('$full_name','$email_address','$pass','$contact_no','$usertype','$date', '$status')");

            if ($reg_ins) {

                $uinfo = mysql_query("select * from tbl_user where email='" . $_POST['email'] . "' and password='" . $_POST['password'] . "' ");
                $res = mysql_fetch_object($uinfo);

                echo "<script>window.android.clickOnRegister();</script>";
            }
        } else {

            $msg = " Email ID Already Exist.";
        }
    } else {

        $msg = "Please fill all required fields *";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Cab Now</title>

        <!--Start form validation JS and CSS -->
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
        <script>
            function RegisterToLogin() {
                //window.loginAndroid.clickOnRegister();
                alert("hello");
            }
        </script>
        <!-- Page Contents Starts
            ================================================== -->
        <div data-role="page" id="page" data-theme="d">
            <!-- header Starts -->

            <div data-role="content">

                <!-- Form Starts -->
                <div class="form-element" style="padding-top: 20px;">

                    <div id='message_post'><?php echo $msg; ?></div>
                    <div class="form">
                        <form method='post' action='' name='SignForm' id='SignForm'>

                            <input type="text" name="fname" class="validate[required] text ur-name" placeholder="Full Name *" style="width:100%"/>
                            <input type="email" name="email" class="validate[required,custom[email]] text ur-email"  placeholder="Email *" style="width:100%"/>                           
                            <input type="password" name="password" class="validate[required] text ur-pwd"  placeholder="Password *" style="width:100%"/>
                            <input type="tel" name="mobile" class="validate[required] text ur-mobile" placeholder="Mobile *" style="width:100%"/>

                            <select class="text" style="width:100%;padding:10px !important" name="user-type">
                                <option value="passenger">Passenger</option>
                                <option value="driver">Driver</option>
                            </select>
                            <div class="all-button" style="padding-top: 30px;">
                                <input type="submit" value="" data-theme="ab" name='submit' id="submit" style="width: 250px;height: 63px;"/>
                            </div>



                        </form>
                        <div class="login-links">

                            <a onClick="window.android.clickOnAlreadyRegister();">Already Registered ? Login Here</a><br>
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

            </div>
            <!-- Left Panel Ends
                ================================================== -->

        </div>
        <!-- Page Contents Ends-->

    </body>
</html>