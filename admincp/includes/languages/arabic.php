<?php
function lang($phrase) {
    static $lang = array(
        // Admin panel
        "ADMIN_LOGO" => "لوحة تحكم الإدارة",
        "ADMIN_WELCOME" => "مرحبا بعودتك، ",
        "ADMIN_LOGIN" => "تسجيل دخول الإدارة",
        "ADMIN_LOGIN_SUCCESS" => "لقد قمت بتسجيل الدخول! جاري التحويل...",
        "ADMIN_NOT_AUTH_LOGIN" => "غير مصرح لك باستخدام لوحة التحكم لأنك لست مدير",
        "ADMIN_USER_NOT_EXIST" => "حسابك غير موجود في قاعدة البيانات الخاصة بنا",
//        "ADMIN_HOME" => "الرئيسية",
        "ADMIN_CATEGORIES" => "الأقسام",
        "ADMIN_ITEMS" => "السلع",
        "ADMIN_MEMBERS" => "الاعضاء",
        "ADMIN_STATISTICS" => "الإحصائيات",
        "ADMIN_LOGS" => "السجلات",
        "SETTINGS" => "الإعدادات",
        "USERNAME" => "اسم المستخدم",
        "PASSWORD" => "كلمة السر",
        "LOGIN" => "تسجيل الدخول",
        "LOGOUT" => "تسجيل الخروج",
    );

        return $lang[$phrase];
    }