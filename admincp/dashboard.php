<?php
$pageTitle = "Admin Dashboard"; //lang("ADMIN_DASHBOARD");
include "init.php";
session_start();
if(isset($_SESSION['Username'])) {
    addNavBar();
    outputMessage('success', lang("ADMIN_WELCOME") . $_SESSION['Username']);
    include $tpl . "footer.inc";
} else {
    outputMessage('error', "You're not Autorized to enter this page! Redirecting..");
    header( "refresh:1;url=index.php" );
}