<?php
session_start();
ob_start();

if(isset($_SESSION['Username'])) {
    $pageTitle = "Items"; //TODO: lang("ADMIN_ITEMS");
    include "init.php";
    addNavBar();
    $do = isset($_GET['do']) ? $_GET['do'] : "manage";
    if($do == 'manage') {

    } else if ($do == 'add') {

    } else if ($do == 'edit') {

    } else if ($do == 'delete') {

    }

    include $tpl . 'footer.inc';

} else {
    redirectPage("You can't browse this page without logging in", 'error', 'index.php', 2);
}

ob_end_flush();