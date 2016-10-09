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
        <script>
            function rate_card_details(id) {
                //alert(id);
                //cab_id = "cabid="+ id;
                $.ajax({
                    url: "rate_card_details.php",
                    type: "POST",
                    data: {cabid: id},
                    success: function(response) {

                        $('#details').html(response);
                    }
                });

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

                            <select class="text" style="width:100%;padding:10px !important" name="cab-type" onchange="rate_card_details(this.value);">
                                <?php
                                $sel_cab = mysql_query("select * from tbl_category where cat_status = 'Active' order by cat_id");
                                while ($row = mysql_fetch_array($sel_cab)) {
                                    ?>
                                    <option value="<?php echo $row['cat_id'] ?>"><?php echo $row['cat_name']; ?></option>

                                <?php } ?>
                            </select>

                        </form>


                    </div>
                </div>

                <div id="details">
                    <h2>Standard Rates</h2>
                    <?php
                    $sel_cab_detail = mysql_query("select * from tbl_cab where category = '7'");
                    $detail = mysql_fetch_object($sel_cab_detail);
                    ?>

                    <div class="rate-card">Fare Per Hour</div><div class="rate-card" style="text-align:right;"><?php echo "$" . $detail->fare_per_hour; ?></div>
                    <div class="rate-card">Fare Per KM</div><div class="rate-card" style="text-align:right;"><?php echo "$" . $detail->fare_per_km; ?></div>
                    <div class="rate-card" style="min-height: 38px;">Waiting Charge Per 10 min</div><div class="rate-card" style="text-align:right;min-height: 38px;"><?php echo "$" . $detail->waiting_charge_per_10_min; ?></div>




                </div>
                <!-- Form Ends-->

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