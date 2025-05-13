<?php
require_once(__DIR__ . '/../includes/config.php');
require_once(__DIR__ . '/../includes/functions.php');

if (isLoggedIn()) {
    redirect(SITE_URL);
}

$page_title = "تسجيل الدخول";
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    $username = sanitizeInput($_POST['username']);
    $password = sanitizeInput($_POST['password']);

    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT id, username, password FROM users2 WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['user_type'] = 'registered';
            
            $redirect_url = $_SESSION['redirect_url'] ?? SITE_URL;
            unset($_SESSION['redirect_url']);
            redirect($redirect_url);
        } else {
            $error = "كلمة المرور غير صحيحة";
        }
    } else {
        $error = "اسم المستخدم غير مسجل";
    }
}

if (isset($_GET['guest'])) {
    $_SESSION['user_id'] = 0;
    $_SESSION['username'] = 'ضيف';
    $_SESSION['user_type'] = 'guest';
    redirect(SITE_URL);
}

include(__DIR__ . '/../includes/header.php');
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <div class="auth-header">
                <img src="<?= SITE_URL ?>/assets/images/logo.png" alt="Logo" class="auth-logo">
                <h2>تسجيل الدخول</h2>
                <p>اختر طريقة الدخول إلى النظام</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="username">اسم المستخدم</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="password">كلمة المرور</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    <small class="form-text">
                        <a href="<?= SITE_URL ?>/auth/forgot-password.php">نسيت كلمة المرور؟</a>
                    </small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-block">تسجيل الدخول</button>
                </div>
            </form>

            <div class="guest-option">
                <p>أو</p>
                <a href="<?= SITE_URL ?>/auth/login.php?guest=1" class="btn btn-outline btn-block">
                    <i class="fas fa-user-clock"></i> الدخول كضيف
                </a>
            </div>

            <div class="auth-footer">
                <p>ليس لديك حساب؟ <a href="<?= SITE_URL ?>/auth/register.php">إنشاء حساب جديد</a></p>
            </div>
        </div>
    </div>
</section>

<?php include(__DIR__ . '/../includes/footer.php'); ?>