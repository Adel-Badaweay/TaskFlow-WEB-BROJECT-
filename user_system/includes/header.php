<?php
if (!isset($page_title)) {
    $page_title = SITE_NAME;
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title) . ' | ' . SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo SITE_URL; ?>/assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="<?php echo SITE_URL; ?>/assets/images/logo.png" type="image/png">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    window.jsPDF = window.jspdf.jsPDF;
</script>
</head>
<body>
    <div class="user-actions">
    <?php if (isLoggedIn()): ?>
        <div class="user-dropdown">
            <button class="user-btn">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                <i class="fas fa-chevron-down"></i>
            </button>
            <div class="dropdown-content">
                <a href="<?php echo SITE_URL; ?>/profile.php"><i class="fas fa-user"></i> الملف الشخصي</a>
                <a href="<?php echo SITE_URL; ?>/auth/logout.php" class="logout-link">
                    <i class="fas fa-sign-out-alt"></i> تسجيل الخروج
                </a>
            </div>
        </div>
    <?php else: ?>
        <a href="<?php echo SITE_URL; ?>/auth/login.php" class="btn btn-outline">
            <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
        </a>
    <?php endif; ?>
</div>
    <div class="page-wrapper">
        <header class="main-header">
            <div class="container">
                <div class="logo">
                    <a href="<?php echo SITE_URL; ?>">
                        <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="<?php echo SITE_NAME; ?>">
                        <span><?php echo SITE_NAME; ?></span>
                    </a>
                </div>
                
                <nav class="main-nav">
                    <ul>
                        <li><a href="<?php echo SITE_URL; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">
                            <i class="fas fa-home"></i> الرئيسية
                        </a></li>
                        <li><a href="<?php echo TASKS_PAGE; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'tasks.php' ? 'active' : ''; ?>">
                            <i class="fas fa-tasks"></i> المهام
                        </a></li>
                        <li><a href="<?php echo TIMER_PAGE; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'timer.php' ? 'active' : ''; ?>">
                            <i class="fas fa-stopwatch"></i> المؤقت
                        </a></li>
                        <li><a href="<?php echo TEAM_PAGE; ?>" class="<?php echo basename($_SERVER['PHP_SELF']) == 'team.php' ? 'active' : ''; ?>">
                            <i class="fas fa-users"></i> الفريق
                        </a></li>
                    </ul>
                </nav>
                
                <div class="user-actions">
                    <?php if (isLoggedIn()): ?>
                        <div class="user-dropdown">
                            <button class="user-btn">
                                <i class="fas fa-user-circle"></i>
                                <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="dropdown-content">
                                <a href="<?php echo SITE_URL; ?>/profile.php"><i class="fas fa-user"></i> الملف الشخصي</a>
                                <a href="<?php echo SITE_URL; ?>/auth/logout.php"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="<?php echo SITE_URL; ?>/auth/login.php" class="btn btn-outline">
                            <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                        </a>
                    <?php endif; ?>
                </div>
                
                <button class="mobile-menu-btn">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </header>

        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="<?php echo SITE_NAME; ?>">
                <button class="close-menu-btn"><i class="fas fa-times"></i></button>
            </div>
            <ul>
                <li><a href="<?php echo SITE_URL; ?>"><i class="fas fa-home"></i> الرئيسية</a></li>
                <li><a href="<?php echo TASKS_PAGE; ?>"><i class="fas fa-tasks"></i> المهام</a></li>
                <li><a href="<?php echo TIMER_PAGE; ?>"><i class="fas fa-stopwatch"></i> المؤقت</a></li>
                <li><a href="<?php echo TEAM_PAGE; ?>"><i class="fas fa-users"></i> الفريق</a></li>
                
                <?php if (isLoggedIn()): ?>
                    <li><a href="<?php echo SITE_URL; ?>/profile.php"><i class="fas fa-user"></i> الملف الشخصي</a></li>
                    <li><a href="<?php echo SITE_URL; ?>/auth/logout.php"><i class="fas fa-sign-out-alt"></i> تسجيل الخروج</a></li>
                <?php else: ?>
                    <li><a href="<?php echo SITE_URL; ?>/auth/login.php"><i class="fas fa-sign-in-alt"></i> تسجيل الدخول</a></li>
                <?php endif; ?>
            </ul>
        </div>

        <main class="main-content">