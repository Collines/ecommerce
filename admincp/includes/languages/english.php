<?php
    function lang($phrase) {
        static $lang = array(
            "WELCOME" => "Welcome to Administration Control Panel",
            "MENU" => "Menu"
        );

        return $lang[$phrase];
    }