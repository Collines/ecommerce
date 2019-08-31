<?php
    include "connect.php";
    // Routes
    $tpl = "includes/templates/";   // Template Directory
    $js = "layout/js/";     // Javascript Directory
    $css = "layout/css/";       // CSS Directory
    $languages = "includes/languages/";     // Languages Directory
    $funct = "includes/functions/";     // Languages Directory

    // include important files
    include $languages . "english.php";
    include $funct . "functions.php";
    include $tpl . "header.inc";
    // To Put navbar in specific pages
    function addNavBar() {
        global $activeClass;
        include "includes/templates/navbar.inc";
    }