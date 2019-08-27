<?php
    include "connect.php";
    // Routes
    $tpl = "includes/templates/";   // Template Directory
    $js = "layout/js/";     // Javascript Directory
    $css = "layout/css/";       // CSS Directory
    $lang = "includes/languages/";     // Languages Directory
    $funct = "includes/functions/";      // Functions Directory

    // include important files
    include $lang . "english.php";
    include $tpl . "header.inc";
    // To Put navbar in specific pages
    if(!isset($noNavBar)) {
        include $tpl . "navbar.inc";
    }
