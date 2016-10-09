<?php
include '../includes/database_connection.php';
 $cab_id = $_POST['cabid'];
?>
<h2>Standard Rates</h2>
                    <?php $sel_cab_detail = mysql_query("select * from tbl_cab where category = '$cab_id'"); 
                      $detail = mysql_fetch_object($sel_cab_detail); ?>
                    
                    <div class="rate-card">Fare Per Hour</div><div class="rate-card" style="text-align:right;"><?php echo "$".$detail->fare_per_hour; ?></div>                        
                        <div class="rate-card">Fare Per KM</div><div class="rate-card" style="text-align:right;"><?php echo "$".$detail->fare_per_km; ?></div>                         
                         <div class="rate-card" style="min-height: 38px;">Waiting Charge Per 10 min</div><div class="rate-card" style="text-align:right;min-height: 38px;"><?php echo "$".$detail->waiting_charge_per_10_min; ?></div>
                         


