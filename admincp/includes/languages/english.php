<?php
    function lang($phrase) {
        static $lang = array(
            // Admin panel
            "ADMIN_LOGO" => "Administration Control Panel",
            "ADMIN_WELCOME" => "Welcome back, ",
            "ADMIN_LOGIN" => "Administration Login",
            "ADMIN_LOGIN_SUCCESS" => "You've logged in! directing...",
            "ADMIN_NOT_AUTH_LOGIN" => "You're not authorized to use Admin Control Panel as you're not administrator",
            "ADMIN_USER_NOT_EXIST" => "Your account doesn't exist in our Database",
//            "ADMIN_HOME" => "Home",
            "ADMIN_CATEGORIES" => "Categories",
            "ADMIN_ITEMS" => "Items",
            "ADMIN_MEMBERS" => "Members",
            "ADMIN_STATISTICS" => "Statistics",
            "ADMIN_LOGS" => "Logs",
            "SETTINGS" => "Settings",
            "USERNAME" => "Username",
            "PASSWORD" => "Password",
            "LOGIN" => "Login",
            "LOGOUT" => "Logout",
        );

        return $lang[$phrase];
    }