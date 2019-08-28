<?php
session_start();
include "includes/functions/functions.php";
if(isset($_SESSION['Username'])) {
    include "init.php";
    outputMessage('success', lang("ADMIN_WELCOME") . $_SESSION['Username']);
    include "includes/templates/footer.inc";
} else {
    outputMessage('error', "You're not Autorized to enter this page! Redirecting..");
    header( "refresh:3;url=index.php" );
}