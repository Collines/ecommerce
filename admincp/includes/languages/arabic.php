<?php
function lang($phrase) {
    static $lang = array(
        "WELCOME" => "مرحباً بك في لوحة التحكم",
        "MENU" => "القائمة"
    );

    return $lang[$phrase];
}