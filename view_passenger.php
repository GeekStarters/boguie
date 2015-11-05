<?php
require_once('includes/main.inc.php');
$sql_fectch_city = mysql_query("select *, date_format(add_date,'%b %d, %Y') as rdate from tbl_user where id='" . $_REQUEST['pid'] . "' and usertype='passenger'") or die(mysql_error());
$fetch_record = mysql_fetch_array($sql_fectch_city);
@extract($fetch_record);
?>

<?php
include './header.php';
?>


    </head>
    <body>
        <table class="tableSearch table table-bordered">
            <tr bgcolor="#f1f1f1"><td valign="top"class="tdLabel" colspan="2" align="center"><b>Passenger Details</b></td></tr>
            <tr><td valign="top" colspan="2">&nbsp;</td></tr>
            <tr bgcolor="#f1f1f1"><td valign="top"class="tdLabel" colspan="2"><b><font color="#C05813">Login Info </font></b></td></tr>
            <tr><td valign="top" colspan="2">&nbsp;</td></tr>
            <tr>
                <td valign="top" class="tdLabel" width="18%"><b>Email</b></td>
                <td class="tdLabel"><?= $email ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Password</b></td>
                <td class="tdLabel"><?= $password ?></td>
            </tr>

            <tr bgcolor="#f1f1f1">
                <td valign="top"class="tdLabel" colspan="3"><b><font color="#C05813">Personal Details</font></b></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Driver Image</b></td>
                <?php  if ($image != '') { ?>
                    <td class="tdLabel"><img src="./profile_pic/<?php echo $image; ?>" width="100"></td>
                <?php }?>
                
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Fullname</b></td>
                <td class="tdLabel"><?= ucwords(strtolower($fullname)) ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Mobile</b></td>
                <td class="tdLabel"><?= ucwords(strtolower($mobile)) ?></td>
            </tr>
            <!--<tr>
                <td valign="top" class="tdLabel"><b>Name on Card</b></td>
                <td class="tdLabel"><?= $name_on_card ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Card Number</b></td>
                <td class="tdLabel"><?= $card_num ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Expiry Date</b></td>
                <td class="tdLabel"><?= $exp_date ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>cvv Number</b></td>
                <td class="tdLabel"><?= $cvv_num ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Balance</b></td>
                <td class="tdLabel"><?= nl2br($balance) ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>Paid Yet</b></td>
                <td class="tdLabel"><?= $paid_yet ?></td>
            </tr>-->
            <tr>
                <td valign="top" class="tdLabel"><b>Add Date</b></td>
                <td class="tdLabel"><?= $add_date ?></td>
            </tr>
            <tr>
                <td valign="top" class="tdLabel"><b>User Type</b></td>
                <td class="tdLabel"><?= $usertype ?></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td align="center">&nbsp;</td>
            </tr>
        </table>
        <div align="center"><strong><a class="btn btn-info" href="javascript:window.close();">Close Window</a></strong></div>
        <br><br><br>
    </body>
</html>
