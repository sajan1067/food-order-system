<?php 
//Include constant.php for SITEURL
include('../config/constants.php'); //unsets $_session['user']
    //1.destoryed thr session and 
    session_destroy();


    //2.Redirect to login page
    header('location:'.SITEURL.'admin/login.php');
?>