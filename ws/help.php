<?php
include ('../includes/include_files.php');
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

                <div id="details">
                    <?php
                    $select_con = mysql_query("select * from tbl_content where page_id = '4'");
                    $fetch_data = mysql_fetch_object($select_con);
                    ?>

                    <h2><?php echo $fetch_data->page_title; ?></h2>
                    <p><?php echo $fetch_data->page_text; ?></p>
                </div>
                <!-- Form Ends-->

                <!-- Footer Starts -->
                <?php include '../includes/footer.php'; ?>
                <!-- Footer Ends -->
            </div>
            <!-- /content -->

            <div data-role="panel" id="left-panel" data-theme="b" style="margin-top: -20px;">

                <?php //include 'includes/menu.php';  ?>
                <!-- Main Menu Ends -->
                <!-- Main Menu Ends -->
            </div>

        </div>
        <!-- Page Contents Ends
            ================================================== -->

    </body>
</html>