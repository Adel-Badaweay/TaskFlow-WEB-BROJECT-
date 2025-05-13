<?php
require_once(__DIR__ . '/includes/config.php');
require_once(__DIR__ . '/includes/functions.php');

if (!isLoggedIn()) {
    redirect(SITE_URL . '/auth/login.php');
}
$current_task = isset($_GET['task']) ? htmlspecialchars($_GET['task']) : 'لم يتم تحديد مهمة';

$page_title = "مؤقت العمل";
include(__DIR__ . '/includes/header.php');
?>

<style>
    /* تدرج الألوان للخلفية كاملة */
    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
        min-height: 100vh;
    }
    
    .timer-section {
        background: transparent;
    }
    
    /* تكبير حجم المؤقت */
    .timer-display {
        font-size: 5rem;
        font-weight: 700;
        color: #2c3e50;
        margin: 20px 0;
        text-align: center;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    .timer-display span {
        padding: 0 10px;
    }
    
    /* تحسينات التايمر */
    .timer-container {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }
    
    .timer-header h1 {
        font-size: 2.5rem;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    
    .timer-header p {
        font-size: 1.2rem;
        color: #7f8c8d;
    }
    
    /* بقية الأنماط كما هي مع تعديلات طفيفة */
    .inspiration-section {
        margin-top: 50px;
        padding: 30px 0;
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }
    
    .inspiration-header h3 {
        color: #2c3e50;
        font-size: 1.8rem;
        margin-bottom: 15px;
    }
    
    .inspiration-container {
        display: flex;
        justify-content: space-between;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }
    
    .inspiration-left, .inspiration-right {
        width: 48%;
    }
    
    .inspiration-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 6px 15px rgba(0,0,0,0.1);
        margin-bottom: 25px;
        transition: all 0.3s ease;
        border-left: 4px solid #4e54c8;
    }
    
    .card-right {
        border-left: none;
        border-right: 4px solid #8f94fb;
    }
    
    .inspiration-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 20px rgba(0,0,0,0.15);
    }
    
    .inspiration-img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .inspiration-text {
        padding: 18px;
        text-align: center;
        font-weight: 600;
        color: #495057;
        font-size: 1.1rem;
    }
    
    @media (max-width: 768px) {
        .timer-display {
            font-size: 3.5rem;
        }
        
        .inspiration-container {
            flex-direction: column;
        }
        
        .inspiration-left, .inspiration-right {
            width: 100%;
        }
    }
</style>

<section class="timer-section">
    <div class="container">
        <div class="timer-header">
            <h1>مؤقت العمل</h1>
            <p> (45 دقيقة عمل)</p>
        </div>
        <div class="timer-container">
            <div class="timer-display">
                <span id="minutes">45</span>:<span id="seconds">00</span>
            </div>
            <div class="timer-controls">
                <button id="startTimer" class="btn btn-primary btn-lg">
                    <i class="fas fa-play"></i> بدء
                </button>
                <button id="pauseTimer" class="btn btn-outline btn-lg" disabled>
                    <i class="fas fa-pause"></i> إيقاف
                </button>
                <button id="resetTimer" class="btn btn-outline btn-lg">
                    <i class="fas fa-redo"></i> إعادة تعيين
                </button>
            </div>
            <div class="current-task-box">
                <h3>المهمة الحالية:</h3>
                <div class="task-name" id="currentTaskText"><?php echo $current_task; ?></div>
                <div class="task-actions">
                    <a href="<?php echo TASKS_PAGE; ?>" class="btn btn-outline">
                        <i class="fas fa-tasks"></i> اختر مهمة أخرى
                    </a>
                </div>
            </div>
            
            <div class="timer-stats">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h4>الجلسات المكتملة</h4>
                        <p id="completedSessions">0</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h4>الوقت الإجمالي</h4>
                        <p id="totalTime">00:00:00</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="timer-tips">
            <h3>نصائح للتركيز:</h3>
            <ul>
                <li>ل دقيقة تقضيها في الدراسة هي استثمار في مستقبلك</li>
                <li>النجاح يبدأ بخطوة واحدة صغيرة في كل يوم</li>
                <li>خذ استراحة 5 دقائق بعد كل جلسة عمل</li>
                <li>بعد 4 جلسات عمل، خذ استراحة أطول (15-30 دقيقة)</li>
            </ul>
        </div>
        
        <!-- قسم الصور الإلهامية -->
        <div class="inspiration-section">
            <div class="inspiration-header">
                <h3>إلهام لمواصلة العمل</h3>
                <div class="divider"></div>
            </div>
            <div class="inspiration-container">
                <div class="inspiration-left">
                    <div class="inspiration-card card-left">
                        <img src="<?php echo SITE_URL; ?>/assets/images/5.png" alt="NEVER give up" class="inspiration-img">
                        <div class="inspiration-text">لا تستسلم أبداً</div>
                    </div>
                    <div class="inspiration-card card-left">
                        <img src="<?php echo SITE_URL; ?>/assets/images/8.jpg" alt="Sales growth" class="inspiration-img">
                        <div class="inspiration-text">تتبع تقدمك</div>
                    </div>
                </div>
                <div class="inspiration-right">
                    <div class="inspiration-card card-right">
                        <img src="<?php echo SITE_URL; ?>/assets/images/6.jpg" alt="Be yourself" class="inspiration-img">
                        <div class="inspiration-text">كن نفسك بتميز</div>
                    </div>
                    <div class="inspiration-card card-right">
                        <img src="<?php echo SITE_URL; ?>/assets/images/9.png" alt="TEAMWORK" class="inspiration-img">
                        <div class="inspiration-text">معاً نبلغ القمة</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="<?php echo SITE_URL; ?>/assets/js/timer.js"></script>

<?php include(__DIR__ . '/includes/footer.php'); ?>