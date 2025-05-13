<?php
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/includes/functions.php');

if (!isLoggedIn()) {
    redirect(SITE_URL . '/auth/login.php');
}

$db = new Database();
$conn = $db->getConnection();

// جلب جميع المهام
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY 
                        CASE WHEN completed = 0 THEN 0 ELSE 1 END,
                        CASE WHEN due_date IS NULL THEN 1 ELSE 0 END,
                        due_date ASC");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$tasks = $result->fetch_all(MYSQLI_ASSOC);

// التحقق من المهام المتأخرة
$overdue_tasks = array_filter($tasks, function($task) {
    return !$task['completed'] && $task['due_date'] && strtotime($task['due_date']) < time();
});

$page_title = "إدارة المهام";
include(__DIR__ . '/includes/header.php');
?>

<section class="tasks-section">
    <div class="container">
        <div class="section-header">
            <h1>إدارة المهام</h1>
            <div class="actions">
                <button id="addTaskBtn" class="btn btn-primary">
                    <i class="fas fa-plus"></i> إضافة مهمة
                </button>
                <a href="<?php echo COMPLETED_TASKS_PAGE; ?>" class="btn btn-outline">
                    <i class="fas fa-check-circle"></i> المكتملة
                </a>
                <button id="exportPdfBtn" class="export-pdf-btn">
                    <i class="fas fa-file-pdf"></i> تصدير PDF
                </button>
            </div>
        </div>
        
        <div class="tasks-view-options">
            <button id="listView" class="btn btn-outline active"><i class="fas fa-list"></i> عرض قائمة</button>
            <button id="gridView" class="btn btn-outline"><i class="fas fa-th-large"></i> عرض شبكي</button>
        </div>
        
        <div class="tasks-container">
            <div class="tasks-filters">
                <div class="filter-group">
                    <label for="filterStatus">حالة المهمة:</label>
                    <select id="filterStatus" class="form-select">
                        <option value="all">الكل</option>
                        <option value="pending">قيد التنفيذ</option>
                        <option value="completed">مكتملة</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label for="filterDate">ترتيب حسب:</label>
                    <select id="filterDate" class="form-select">
                        <option value="newest">الأحدث</option>
                        <option value="oldest">الأقدم</option>
                        <option value="due">تاريخ الاستحقاق</option>
                    </select>
                </div>
                
                <div class="search-box">
                    <input type="text" id="taskSearch" placeholder="ابحث عن مهمة...">
                    <button class="search-btn"><i class="fas fa-search"></i></button>
                </div>
            </div>
            
            <div class="tasks-list" id="tasksList">
                <?php if (empty($tasks)): ?>
                    <div class="empty-state">
                        <img src="<?php echo SITE_URL; ?>/assets/images/no-tasks.svg" alt="لا توجد مهام">
                        <h3>لا توجد مهام حالياً</h3>
                        <p>يمكنك إضافة مهمة جديدة بالضغط على زر "إضافة مهمة"</p>
                        <button id="addFirstTask" class="btn btn-primary">
                            <i class="fas fa-plus"></i> إضافة أول مهمة
                        </button>
                    </div>
                <?php else: ?>
                    <?php foreach ($tasks as $task): ?>
                    <div class="task-item" data-task-id="<?= $task['id'] ?>" 
                         data-status="<?= $task['completed'] ? 'completed' : 'pending' ?>"
                         data-due-date="<?= $task['due_date'] ?? '' ?>">
                        <div class="task-title" onclick="toggleTaskDetails(this)">
                            <i class="fas fa-chevron-down"></i>
                            <?= htmlspecialchars($task['title']) ?>
                            <?php if (!$task['completed'] && $task['due_date'] && strtotime($task['due_date']) < time()): ?>
                                <span class="badge badge-danger">متأخرة</span>
                            <?php endif; ?>
                        </div>
                        <div class="task-details">
                            <?php if ($task['image']): ?>
                            <div class="task-image">
                                <img src="<?= $task['image'] ?>" alt="صورة المهمة">
                            </div>
                            <?php endif; ?>
                            <p><?= htmlspecialchars($task['description']) ?></p>
                            <div class="task-meta">
                                <span class="task-date"><i class="far fa-calendar-alt"></i> <?= date('Y-m-d', strtotime($task['created_at'])) ?></span>
                                <?php if ($task['due_date']): ?>
                                    <span class="task-due <?= (strtotime($task['due_date']) < time()) && !$task['completed'] ? 'overdue' : '' ?>">
                                        <i class="far fa-clock"></i> <?= date('Y-m-d', strtotime($task['due_date'])) ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            <div class="task-actions">
                                <button class="btn-icon edit-task" data-task-id="<?= $task['id'] ?>">
                                    <i class="far fa-edit"></i>
                                </button>
                                <button class="btn-icon delete-task" data-task-id="<?= $task['id'] ?>">
                                    <i class="far fa-trash-alt"></i>
                                </button>
                                <a href="<?= TIMER_PAGE ?>?task=<?= urlencode($task['title']) ?>" class="btn-icon start-timer" title="بدء المؤقت لهذه المهمة">
                                    <i class="fas fa-stopwatch"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<!-- نموذج إضافة/تعديل المهمة -->
<div class="modal" id="taskModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 id="modalTitle">إضافة مهمة جديدة</h3>
            <button class="close-modal">&times;</button>
        </div>
        <div class="modal-body">
            <form id="taskForm" enctype="multipart/form-data">
                <input type="hidden" id="taskId">
                
                <div class="form-group">
                    <label for="taskTitle">عنوان المهمة *</label>
                    <input type="text" id="taskTitle" class="form-control" required>
                </div>
                
                <div class="form-group">
                    <label for="taskDesc">وصف المهمة</label>
                    <textarea id="taskDesc" class="form-control" rows="3"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="taskImage">صورة المهمة (اختياري)</label>
                    <input type="file" id="taskImage" name="image" class="form-control" accept="image/*">
                    <small class="form-text">الصيغ المسموحة: JPG, PNG, GIF (بحد أقصى 2MB)</small>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="taskDueDate">تاريخ الاستحقاق</label>
                        <input type="date" id="taskDueDate" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label for="taskPriority">الأولوية</label>
                        <select id="taskPriority" class="form-control">
                            <option value="low">منخفضة</option>
                            <option value="medium" selected>متوسطة</option>
                            <option value="high">عالية</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" id="taskCompleted" class="form-check-input">
                        <label for="taskCompleted" class="form-check-label">مكتملة</label>
                    </div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-outline close-modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ المهمة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="<?= SITE_URL ?>/assets/js/tasks.js"></script>
<script>
// حفظ المهام في localStorage للوضع الضيف
<?php if (isset($_SESSION['guest_mode'])): ?>
    const tasks = <?= json_encode($tasks) ?>;
    localStorage.setItem('guest_tasks', JSON.stringify(tasks));
<?php endif; ?>

// عرض إشعار للمهام المتأخرة
<?php if (!empty($overdue_tasks)): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const notificationCount = <?= count($overdue_tasks) ?>;
        if (notificationCount > 0) {
            showNotification(`لديك ${notificationCount} مهام متأخرة`, 'danger');
            
            // إضافة بادج للإشعارات في الهيدر
            const navItem = document.createElement('div');
            navItem.className = 'nav-item';
            navItem.innerHTML = `
                <a href="<?= TASKS_PAGE ?>" class="nav-link position-relative">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">${notificationCount}</span>
                </a>
            `;
            document.querySelector('.main-nav ul').prepend(navItem);
        }
    });
<?php endif; ?>

// تصدير إلى PDF
document.getElementById('exportPdfBtn').addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    doc.setFont('tajawal', 'normal');
    doc.text('تقرير المهام', 105, 15, { align: 'center' });
    
    let y = 30;
    <?php foreach ($tasks as $task): ?>
        doc.setFontSize(12);
        doc.text(`- ${<?= json_encode($task['title']) ?>}`, 15, y);
        doc.setFontSize(10);
        y += 7;
        doc.text(`الحالة: ${<?= $task['completed'] ? "'مكتملة'" : "'قيد التنفيذ'" ?>}`, 25, y);
        y += 7;
        doc.text(`تاريخ الإنشاء: ${<?= date('Y-m-d', strtotime($task['created_at'])) ?>}`, 25, y);
        y += 7;
        <?php if ($task['due_date']): ?>
            doc.text(`تاريخ الاستحقاق: ${<?= date('Y-m-d', strtotime($task['due_date'])) ?>}`, 25, y);
            y += 7;
        <?php endif; ?>
        y += 5;
    <?php endforeach; ?>
    
    doc.save('تقرير_المهام.pdf');
});
</script>

<?php include(__DIR__ . '/includes/footer.php'); ?>