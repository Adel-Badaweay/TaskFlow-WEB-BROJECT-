<?php
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/includes/functions.php');

if (!isLoggedIn()) {
    redirect(SITE_URL . '/auth/login.php');
}

$db = new Database();
$conn = $db->getConnection();

// جلب المهام المكتملة فقط
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? AND completed = 1 ORDER BY created_at DESC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$completed_tasks = $result->fetch_all(MYSQLI_ASSOC);

$page_title = "المهام المكتملة";
include(__DIR__ . '/includes/header.php');
?>

<section class="completed-tasks-section">
    <div class="container">
        <div class="section-header">
            <h1>المهام المكتملة</h1>
            <a href="<?php echo TASKS_PAGE; ?>" class="btn btn-outline">
                <i class="fas fa-arrow-right"></i> العودة إلى المهام
            </a>
        </div>
        
        <div class="tasks-list">
            <?php if (empty($completed_tasks)): ?>
                <div class="empty-state">
                    <img src="<?php echo SITE_URL; ?>/assets/images/team1" alt="لا توجد مهام مكتملة">
                    <h3>لا توجد مهام مكتملة بعد</h3>
                    <p>عند إكمالك للمهام، ستظهر هنا</p>
                </div>
            <?php else: ?>
                <?php foreach ($completed_tasks as $task): ?>
                <div class="task-card completed">
                    <div class="task-checkbox">
                        <input type="checkbox" id="completed_task_<?php echo $task['id']; ?>" checked disabled>
                        <label for="completed_task_<?php echo $task['id']; ?>"></label>
                    </div>
                    <div class="task-details">
                        <h3><?php echo htmlspecialchars($task['title']); ?></h3>
                        <p class="task-desc"><?php echo htmlspecialchars($task['description']); ?></p>
                        <div class="task-meta">
                            <span class="task-date"><i class="far fa-calendar-alt"></i> <?php echo date('Y-m-d', strtotime($task['created_at'])); ?></span>
                            <span class="completed-date"><i class="fas fa-check-circle"></i> تم الإكمال في: <?php echo date('Y-m-d', strtotime($task['completed_at'] ?? $task['created_at'])); ?></span>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include(__DIR__ . '/includes/footer.php'); ?>