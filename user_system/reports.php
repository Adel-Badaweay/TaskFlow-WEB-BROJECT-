<?php
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/includes/functions.php');

if (!isLoggedIn()) {
    redirect(SITE_URL . '/auth/login.php');
}

$db = new Database();
$conn = $db->getConnection();

// إحصائيات المهام
$stats = [];
$stmt = $conn->prepare("SELECT 
    COUNT(*) as total_tasks,
    SUM(completed = 1) as completed_tasks,
    SUM(completed = 0 AND due_date < CURDATE()) as overdue_tasks
    FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$stats = $result->fetch_assoc();

// المهام حسب الأولوية
$priority_stats = [];
$stmt = $conn->prepare("SELECT 
    priority, 
    COUNT(*) as count,
    SUM(completed = 1) as completed
    FROM tasks 
    WHERE user_id = ?
    GROUP BY priority");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $priority_stats[$row['priority']] = $row;
}

$page_title = "التقارير والإحصائيات";
include(__DIR__ . '/includes/header.php');
?>

<section class="reports-section">
    <div class="container">
        <div class="section-header">
            <h1>تقارير وإحصائيات الأداء</h1>
            <p>تحليل إنتاجيتك وأداء مهامك</p>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-info">
                    <h3>إجمالي المهام</h3>
                    <p><?php echo $stats['total_tasks']; ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>المهام المكتملة</h3>
                    <p><?php echo $stats['completed_tasks']; ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info">
                    <h3>المهام المتأخرة</h3>
                    <p><?php echo $stats['overdue_tasks']; ?></p>
                </div>
            </div>
            
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-info">
                    <h3>معدل الإنجاز</h3>
                    <p><?php echo $stats['total_tasks'] > 0 ? round(($stats['completed_tasks'] / $stats['total_tasks']) * 100) : 0; ?>%</p>
                </div>
            </div>
        </div>
        
        <div class="charts-container">
            <div class="chart-card">
                <h3>توزيع المهام حسب الأولوية</h3>
                <canvas id="priorityChart"></canvas>
            </div>
            
            <div class="chart-card">
                <h3>إنجاز المهام حسب الأولوية</h3>
                <canvas id="completionChart"></canvas>
            </div>
        </div>
        
        <div class="productivity-tips">
            <h3>نصائح لزيادة الإنتاجية:</h3>
            <ul>
                <li>ركز على المهام عالية الأولوية أولاً</li>
                <li>استخدم مؤقت بومودورو (45 دقيقة عمل + 5 دقائق راحة)</li>
                <li>قسم المهام الكبيرة إلى مهام صغيرة</li>
                <li>حدد مواعيد نهائية واقعية للمهام</li>
            </ul>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?php echo SITE_URL; ?>/assets/js/reports.js"></script>

<script>
const priorityData = {
    low: <?php echo $priority_stats['low']['count'] ?? 0; ?>,
    medium: <?php echo $priority_stats['medium']['count'] ?? 0; ?>,
    high: <?php echo $priority_stats['high']['count'] ?? 0; ?>
};

const completionData = {
    low: <?php echo $priority_stats['low']['completed'] ?? 0; ?>,
    medium: <?php echo $priority_stats['medium']['completed'] ?? 0; ?>,
    high: <?php echo $priority_stats['high']['completed'] ?? 0; ?>
};
</script>

<?php include(__DIR__ . '/includes/footer.php'); ?>