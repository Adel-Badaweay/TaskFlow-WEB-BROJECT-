<?php
require_once(__DIR__ . '/../includes/config.php');
require_once(__DIR__ . '/../includes/functions.php');

// بدء الجلسة إذا لم تكن بدأت
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// مسح جميع بيانات الجلسة
$_SESSION = array();

// إذا كنت تريد حذف الكوكي أيضاً
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// تدمير الجلسة بالكامل
session_destroy();

// التوجيه الفوري لصفحة تسجيل الدخول
header("Location: login.php");
exit();
?>