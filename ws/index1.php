<?php
include ('../includes/include_files.php');
if(isset($_POST['submit'])){

  $ucount=mysql_query("select * from tbl_user where email='".$_POST['uname']."' and password='".$_POST['password']."' ");
  $set=mysql_fetch_object($ucount);
		
  if($set==""){
    $msg="Your Login Details are In-correct. "; 
	
  }else{
  
	 $uinfo=mysql_query("select * from tbl_user where email='".$_POST['uname']."' and password='".$_POST['password']."' ");
	 $res=mysql_fetch_object($uinfo);
	 
		   
	 $_SESSION['id']=$res->id;
	 $_SESSION['fullname']=$res->fullname;
	 $_SESSION['password']=$res->password;
	 $_SESSION['email']=$res->email;
	 $_SESSION['user_type']=$res->usertype; 
	
	 	echo "<script> android();</script>";
         //echo "<script>alert('hello');</script>"; 
                   
	 }
}
	

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Book Cab Now</title>
        <!-- All Stylesheets -->
        <!--<link rel="stylesheet"  href="css/All-Stylesheets.css">-->
        <!-- Add 2 Home -->
        <!--<script type="text/javascript" src="js/add2home.js" charset="utf-8"></script>-->
        <!-- Javascript File -->
        <!--<script src="js/jquery.js"></script>-->
        
        <!-- Donut Chart -->
        <!--<script type="text/javascript" src="js/jquery.donutchart.js"></script>-->
       
        <!-- Glyphicons -->
        <!--<script type="text/javascript" async src="js/glyphicons/ga.js"></script>-->
        <!--Start form validation JS and CSS -->
		<link rel="stylesheet" href="js/validation/validationEngine.jquery.css" type="text/css"/>
		<script src="js/validation/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/validation/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
		<script>
			jQuery(document).ready( function() {
				// binds form submission and fields to the validation engine
				jQuery("#LoginForm").validationEngine({promptPosition : "topRight:-130"});
			});
		</script>
                
		<!--End form validation JS and CSS --> 
    </head>
    <body>
        <script type=javascript>
                  function android(){
                      window.demo.clickOnAndroid();
                        
                    }
                </script>
        <!-- Page Contents Starts
            ================================================== -->
        <div data-role="page" id="page" data-theme="d">
            
            <div style="z-index: 10;position: absolute;left:50%;top:50%;"><img id="loading" alt="" src="images/ajax-loader.gif"/></div>
            <!-- header Starts -->
           <!-- <div data-role="header" data-theme="f" class="header">
                <h1><a href="index.php" rel="external">Book Cab Now</a></h1>
                <?php  if($_SESSION['id'] !=""){ ?>
                <a href="#left-panel" data-shadow="false" ><i class="fa fa-indent fa-2x"></i></a>
                <?php } ?>
                <!--<a href="#right-panel" data-shadow="false" ><i class="fa fa-bars fa-2x"></i></a>-->
         <!--   </div>-->
            <!-- header Ends -->
            <div data-role="content">
                <div class="logo"><img src="images/cab-logo.png" width="300"> </div>
                <!-- Form Starts -->
                <div class="form-element">
                    
                    <div id='message_post'><?php echo $msg; ?></div>
                    <div class="form">
                        <form method='post' action='' name='LoginForm' id='LoginForm'>
                            <input type="text" name="uname" class="validate[required] text" placeholder="Username(Email) *" style="width:100%"/>
                            <input type="password" name="password" class="validate[required] text"  placeholder="Password *" style="width:100%"/>
                            <div class="all-button f-button">
                            <input type="submit" value="" data-theme="f" name='submit' id="submit" onclick="window.demo.clickOnAndroid();" style="width: 250px;height: 63px;"/>
                            </div>
                        </form>
                        <div class="login-links">
                        <a href="forgot_password.php">Forgot Password?</a><br>
                        <strong>or</strong><br>
                        <a href="user_register.php">Register Now >></a><br>
                        </div>
                    </div>
                </div>
                <!-- Form Ends-->

                <!-- Footer Starts -->
               <?php include 'includes/footer.php'; ?>
                <!-- Footer Ends -->
            </div>
            <!-- /content -->
            <!-- Left Panel Starts
                ================================================== -->
            <!-- Left Panel Starts
                ================================================== -->
            <div data-role="panel" id="left-panel" data-theme="b" style="margin-top: -20px;">
                
                <?php //include 'includes/menu.php'; ?>
                <!-- Main Menu Ends -->
                <!-- Main Menu Ends -->
            </div>
            <!-- Left Panel Ends
                ================================================== -->
         
            <!-- ToTop Starts
                ================================================== -->
            <!--<a href="#" class="scrollup">Scroll</a>-->
            <!-- ToTop Ends
                ================================================== -->
        </div>
        <!-- Page Contents Ends
            ================================================== -->
        <!-- Javascript Files
            ================================================== -->
      <!--  <script src="owl-carousel/owl-carousel/owl.carousel.js"></script>-->
        <!-- Custom JS File -->
      <!--  <script src="js/custom.js"></script>
        <script src="menu/js/main.js"></script>-->
        
        
        <!-- Retina Display -->
       <!-- <script src="js/Retina/retina.js"></script>-->
        <script>
        $(window).load(function()
{
    $("#loading").hide();
});
</script>
    </body>
</html>