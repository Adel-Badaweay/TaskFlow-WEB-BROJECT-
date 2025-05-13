<?php
require_once(__DIR__ . '/../includes/config.php');
require_once(__DIR__ . '/../includes/functions.php');

if (isLoggedIn()) {
    redirect(SITE_URL);
}

$page_title = "إنشاء حساب جديد";
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = sanitizeInput($_POST['username']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $confirm_password = sanitizeInput($_POST['confirm_password']);

    // التحقق من تطابق كلمتي المرور
    if ($password !== $confirm_password) {
        $error = "كلمتا المرور غير متطابقتين";
    } else {
        $db = new Database();
        $conn = $db->getConnection();

        // التحقق من عدم وجود اسم مستخدم أو بريد إلكتروني مسجل مسبقاً
        $stmt = $conn->prepare("SELECT id FROM users2 WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error = "اسم المستخدم أو البريد الإلكتروني مسجل مسبقاً";
        } else {
            // تسجيل المستخدم الجديد
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users2 (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                $success = "تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول";
            } else {
                $error = "حدث خطأ أثناء إنشاء الحساب. يرجى المحاولة لاحقاً";
            }
        }
    }
}

include(__DIR__ . '/../includes/header.php');
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <div class="auth-header">
                <img src="<?php echo SITE_URL; ?>/assets/images/logo.png" alt="Logo" class="auth-logo">
                <h2>إنشاء حساب جديد</h2>
                <p>املأ النموذج للتسجيل في نظام إدارة المهام</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php elseif (!empty($success)): ?>
                <div class="alert alert-success"><?php echo $success; ?></div>
                <div class="text-center mt-3">
                    <a href="<?php echo SITE_URL; ?>/auth/login.php" class="btn btn-primary">تسجيل الدخول الآن</a>
                </div>
                <?php include(__DIR__ . '/../includes/footer.php'); ?>
                <?php exit(); ?>
            <?php endif; ?>

            <form method="POST" class="register-form">
                <div class="form-group">
                    <label for="username">اسم المستخدم *</label>
                    <input type="text" id="username" name="username" class="form-control" required
                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="email">البريد الإلكتروني *</label>
                    <input type="email" id="email" name="email" class="form-control" required
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور *</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small class="form-text">يجب أن تحتوي كلمة المرور على 8 أحرف على الأقل</small>
                </div>

                <div class="form-group">
                    <label for="confirm_password">تأكيد كلمة المرور *</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">إنشاء الحساب</button>
                </div>
            </form>

            <div class="auth-footer">
                <p>لديك حساب بالفعل؟ <a href="<?php echo SITE_URL; ?>/auth/login.php">سجل الدخول الآن</a></p>
            </div>
        </div>
    </div>
</section>

<?php include(__DIR__ . '/../includes/footer.php'); ?>