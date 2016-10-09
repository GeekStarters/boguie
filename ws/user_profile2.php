<?php
include ('../includes/include_files.php');

 $user_id = $_REQUEST['email']; 
 $user_type = $_REQUEST['user_type']; 
 
 //echo "<pre>";print_r($_SESSION);exit; 

if(isset($_POST['submit'])){
    
    //echo "<pre>";print_r($_REQUEST);exit;
    
 $full_name = mysql_real_escape_string(addslashes($_REQUEST['fname'])); 
 //$email_address = mysql_real_escape_string(addslashes($_REQUEST['email']));
 $pass = mysql_real_escape_string(addslashes($_REQUEST['password']));
 $cpass = mysql_real_escape_string(addslashes($_REQUEST['cpassword']));
 $contact_no = mysql_real_escape_string(addslashes($_REQUEST['mobile']));
 $cabtype = mysql_real_escape_string(addslashes($_REQUEST['cab-type']));
 $cabno = mysql_real_escape_string(addslashes($_REQUEST['cab_no']));
 //echo "<pre>";print_r($_REQUEST);exit;
 if($full_name != "" && $pass!="" && $contact_no!=""){
     
     if($pass == $cpass){
    
if($user_type == 'passenger'){
  
  $reg_ins = mysql_query("UPDATE tbl_user set `fullname`='$full_name', `password`='$pass', `mobile`='$contact_no', `cab_type`='',`cab_no`='null' where email='$user_id' ");
   
}else{
 $reg_ins = mysql_query("UPDATE tbl_user set `fullname`='$full_name', `password`='$pass', `mobile`='$contact_no', `cab_type`='$cabtype',`cab_no`='$cabno' where email='$user_id' "); 
}
  if($reg_ins){
      
       $msg="Your Profile has been updated successfully.";
	 	
         //echo "<script>window.android.clickOnRegister();</script>";
         
  }

 }else{
     $msg=" Password and Confirm Password Do Not Match.";
 }
}else{
    
    $msg="Please fill all required fields *";
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
			jQuery(document).ready( function() {
				// binds form submission and fields to the validation engine
				jQuery("#SignForm").validationEngine({promptPosition : "topRight:-130"});
			});
		</script>
               
		<!--End form validation JS and CSS --> 
    </head>
    <body>
        
        <!-- Page Contents Starts
            ================================================== -->
        <div data-role="page" id="page" data-theme="d">

            <div data-role="content">

                <!-- Form Starts -->
                <div class="form-element" style="padding-top: 5px;">
                    
                    <div id='message_post'><?php echo $msg; ?></div>
                    
                     
                            <div class="" style="padding-top: 20px;margin: 0 auto;width: 175px;">
                                <?php $sel_img = mysql_query("select * from tbl_user where email='$user_id'"); 
                                        $fetch_img = mysql_fetch_object($sel_img); 
                                        if($fetch_img->image == ""){ ?>
                                <img src="../images/user-icon.jpg" width="150" height="150">                                
                                        <?php }else{ ?>
                                <img src="../profile_pic/<?php echo $fetch_img->image; ?>" width="150">   
                                        <?php } ?>
                                <a href="#" onClick="window.uploadpic.clickOnUploadPic();" style="margin-left: 35px;">Upload Pic</a>                            
                            </div>
                        
                    <div class="form">
                        <form method='post' name='SignForm' id='SignForm'>
                            
                            <input type="text" name="fname" class="validate[required] text ur-name" placeholder="Full Name *" value="<?php echo $fetch_img->fullname; ?>" style="width:100%"/>
                           <!-- <input type="email" name="email" class="validate[required,custom[email]] text"  placeholder="Email *" style="width:100%"/>  -->                         
                            <input type="password" name="password" id="password" class="validate[required] text ur-pwd"  placeholder="Password *" value="<?php echo $fetch_img->password; ?>" style="width:100%"/>
                            <input type="password" name="cpassword" id="cpassword" class="validate[required,equals[password]] text ur-pwd"  placeholder="Confirm Password *" value="<?php echo $fetch_img->password; ?>" style="width:100%"/>
                             <input type="text" name="mobile" class="validate[required] text ur-mobile" placeholder="Mobile *" value="<?php echo $fetch_img->mobile; ?>" style="width:100%"/>
                             <?php  if($user_type == 'driver'){ ?>
                             <select class="text" style="width:100%;padding:10px !important" name="cab-type">
                                 
                                 <?php $sel_cab = mysql_query("select * from tbl_category where cat_status = 'Active' order by cat_id"); 
                                        while($row = mysql_fetch_array($sel_cab)){
                                 ?>
                                 <option value="<?php echo $row['cat_id'] ?>" <?php if($fetch_img->cab_type == $row['cat_id'] ){ echo 'selected="selected"' ; } ?>><?php echo $row['cat_name']; ?></option>                                
                                 
                                        <?php } ?>
                             </select>
                             <input type="text" name="cab_no" class="validate[required] text ur-cab" placeholder="Cab Number *" value="<?php echo $fetch_img->cab_no; ?>" style="width:100%"/>
                             <?php } ?>
                             <div class="all-button" style="padding-top: 30px;">
                            <input type="submit" value="" data-theme="up" name='submit' id="submitt" style="width: 250px;height: 63px;"/>                            
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

            <div data-role="panel" id="left-panel" data-theme="b" style="margin-top: -20px;">

            </div>
            <!-- Left Panel Ends
                ================================================== -->

        </div>
        <!-- Page Contents Ends
            ================================================== -->

    </body>
</html>