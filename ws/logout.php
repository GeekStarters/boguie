<?php
session_start();

$_SESSION['user_type']='' ;
        $_SESSION['user_id']= '';
        $_SESSION['user_email']= '';
         
         session_destroy();
         header("location:index.php");


?>