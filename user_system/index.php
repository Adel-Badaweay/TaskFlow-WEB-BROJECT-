<?php
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/includes/functions.php');

$page_title = "الرئيسية";
include(__DIR__ . '/includes/header.php');

// جلب أحدث المهام إذا كان مسجلاً
$latest_tasks = [];
if (isLoggedIn()) {
    $db = new Database();
    $conn = $db->getConnection();
    $stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at DESC LIMIT 3");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $latest_tasks = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<section class="hero-section">
    <div class="container">
        <div class="hero-content">
            <h1>أهلاً بك في <?php echo SITE_NAME; ?></h1>
            <p class="hero-text">نظام متكامل لإدارة المهام وزيادة الإنتاجية</p>
            
            <?php if (!isLoggedIn()): ?>
                <div class="hero-actions">
                    <a href="<?php echo SITE_URL; ?>/auth/register.php" class="btn btn-primary btn-lg">
                        <i class="fas fa-user-plus"></i> إنشاء حساب جديد
                    </a>
                    <a href="<?php echo SITE_URL; ?>/auth/login.php" class="btn btn-outline btn-lg">
                        <i class="fas fa-sign-in-alt"></i> تسجيل الدخول
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php if (isLoggedIn()): ?>
<section class="dashboard-section">
    <div class="container">
        <div class="section-header">
            <h2>لوحة التحكم السريعة</h2>
            <p>إبدأ إدارة مهامك اليوم</p>
        </div>
        
        <div class="quick-actions">
            <a href="<?php echo TASKS_PAGE; ?>" class="quick-action">
                <div class="action-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <h3>المهام</h3>
                <p>إدارة قائمة المهام اليومية</p>
            </a>
            
            <a href="<?php echo TIMER_PAGE; ?>" class="quick-action">
                <div class="action-icon">
                    <i class="fas fa-stopwatch"></i>
                </div>
                <h3>المؤقت</h3>
                <p>مؤقت بومودورو 45 دقيقة</p>
            </a>
            
            <a href="<?php echo TEAM_PAGE; ?>" class="quick-action">
                <div class="action-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>الفريق</h3>
                <p>تعرف على أعضاء الفريق</p>
            </a>
            
            <a href="<?php echo COMPLETED_TASKS_PAGE; ?>" class="quick-action">
                <div class="action-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>المكتملة</h3>
                <p>عرض المهام المنتهية</p>
            </a>
        </div>
        
        <?php if (!empty($latest_tasks)): ?>
        <div class="latest-tasks">
            <div class="section-header">
                <h2>أحدث المهام</h2>
                <a href="<?php echo TASKS_PAGE; ?>" class="btn btn-link">عرض الكل</a>
            </div>
            
            <div class="tasks-list">
                <?php foreach ($latest_tasks as $task): ?>
                <div class="task-card <?php echo $task['completed'] ? 'completed' : ''; ?>">
                    <div class="task-checkbox">
                        <input type="checkbox" id="task_<?php echo $task['id']; ?>" <?php echo $task['completed'] ? 'checked' : ''; ?>>
                        <label for="task_<?php echo $task['id']; ?>"></label>
                    </div>
                    <div class="task-details">
                        <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                        <p class="task-desc"><?php echo htmlspecialchars($task['description']); ?></p>
                        <div class="task-meta">
                            <span class="task-date"><i class="far fa-calendar-alt"></i> <?php echo date('Y-m-d', strtotime($task['created_at'])); ?></span>
                            <?php if ($task['due_date']): ?>
                                <span class="task-due <?php echo (strtotime($task['due_date']) < time()) && !$task['completed'] ? 'overdue' : ''; ?>">
                                    <i class="far fa-clock"></i> <?php echo date('Y-m-d', strtotime($task['due_date'])); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="task-actions">
                        <button class="btn-icon edit-task" data-task-id="<?php echo $task['id']; ?>">
                            <i class="far fa-edit"></i>
                        </button>
                        <button class="btn-icon delete-task" data-task-id="<?php echo $task['id']; ?>">
                            <i class="far fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>

<section class="features-section">
    <div class="container">
        <div class="section-header center">
            <h2>مميزات نظام <?php echo SITE_NAME; ?></h2>
            <p>اكتشف كيف يمكننا مساعدتك في تنظيم عملك</p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <h3>إدارة المهام</h3>
                <p>نظام متكامل لإدارة وتنظيم المهام اليومية بسهولة وفعالية</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-stopwatch"></i>
                </div>
                <h3>مؤقت العمل</h3>
                <p>مؤقت بومودورو 45 دقيقة لزيادة الإنتاجية والتركيز</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h3>فريق العمل</h3>
                <p>تعرف على أعضاء فريق العمل وطرق التواصل معهم</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>تقارير أداء</h3>
                <p>تقارير وإحصائيات عن أدائك وإنجازاتك اليومية</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-bell"></i>
                </div>
                <h3>التنبيهات</h3>
                <p>نظام تنبيهات للمهام الهامة والمواعيد النهائية</p>
            </div>
            
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="fas fa-mobile-alt"></i>
                </div>
                <h3>متجاوب</h3>
                <p>تصميم متجاوب يعمل على جميع الأجهزة والشاشات</p>
            </div>
        </div>
    </div>
</section>

<?php include(__DIR__ . '/includes/footer.php'); ?>