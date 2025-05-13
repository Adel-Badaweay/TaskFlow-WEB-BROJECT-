<?php
// إعدادات قاعدة البيانات
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'user_system');

// إعدادات الموقع
define('SITE_URL', 'http://localhost/user_system');
define('SITE_NAME', 'TaskFlow');
define('SITE_SLOGAN', 'نظام إدارة المهام والفريق');

// بدء الجلسة
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// إعداد المنطقة الزمنية
date_default_timezone_set('Africa/Cairo');

// روابط الصفحات
define('TASKS_PAGE', SITE_URL . '/tasks.php');
define('TIMER_PAGE', SITE_URL . '/timer.php');
define('TEAM_PAGE', SITE_URL . '/team.php');
define('COMPLETED_TASKS_PAGE', SITE_URL . '/completed_tasks.php');
?>