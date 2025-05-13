<?php
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/includes/functions.php');

// إنشاء جلسة ضيف إذا لم يكن مسجلاً دخول
if (!isLoggedIn()) {
    $_SESSION['guest_mode'] = true;
    $_SESSION['user_id'] = 0; // ID 0 للضيف
    $_SESSION['username'] = 'ضيف';
}

$page_title = "وضع الضيف";
include(__DIR__ . '/includes/header.php');
?>

<section class="guest-section">
    <div class="container">
        <div class="guest-warning">
            <i class="fas fa-info-circle"></i>
            <h2>أنت تستخدم النظام كضيف</h2>
            <p>في هذا الوضع يمكنك تجربة النظام ولكن لن يتم حفظ بياناتك بشكل دائم</p>
            <a href="<?php echo SITE_URL; ?>/auth/register.php" class="btn btn-primary">
                <i class="fas fa-user-plus"></i> إنشاء حساب دائم
            </a>
        </div>
        
        <div class="guest-features">
            <div class="feature">
                <i class="fas fa-tasks"></i>
                <h3>إدارة المهام</h3>
                <p>جرب نظام إدارة المهام المتكامل</p>
                <a href="<?php echo TASKS_PAGE; ?>" class="btn btn-outline">ابدأ الآن</a>
            </div>
            
            <div class="feature">
                <i class="fas fa-stopwatch"></i>
                <h3>مؤقت العمل</h3>
                <p>جرب تقنية بومودورو لزيادة الإنتاجية</p>
                <a href="<?php echo TIMER_PAGE; ?>" class="btn btn-outline">ابدأ الآن</a>
            </div>
            
            <div class="feature">
                <i class="fas fa-chart-line"></i>
                <h3>التقارير</h3>
                <p>شاهد نماذج من التقارير والإحصائيات</p>
                <a href="<?php echo SITE_URL; ?>/reports.php" class="btn btn-outline">عرض التقارير</a>
            </div>
        </div>
    </div>
</section>

<?php include(__DIR__ . '/includes/footer.php'); ?>