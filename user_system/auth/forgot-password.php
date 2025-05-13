<?php
require_once(__DIR__ . '/../includes/config.php');
require_once(__DIR__ . '/../includes/functions.php');

$page_title = "استعادة كلمة المرور";
include(__DIR__ . '/../includes/header.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    
    $db = new Database();
    $conn = $db->getConnection();
    
    $stmt = $conn->prepare("SELECT id FROM users2 WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        $stmt = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user['id'], $token, $expires);
        $stmt->execute();
        
        // في الواقع هنا ترسل الإيميل بالمحتوى التالي:
        $reset_link = SITE_URL . "/auth/reset-password.php?token=$token";
        $message = "لإعادة تعيين كلمة المرور، يرجى الضغط على الرابط التالي: $reset_link";
        
        echo displaySuccess("تم إرسال رابط إعادة التعيين إلى بريدك الإلكتروني");
    } else {
        echo displayError("البريد الإلكتروني غير مسجل");
    }
}
?>

<section class="auth-section">
    <div class="container">
        <div class="auth-form">
            <h2>استعادة كلمة المرور</h2>
            <form method="POST">
                <div class="form-group">
                    <label for="email">البريد الإلكتروني</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">إرسال رابط التعيين</button>
                    <a href="<?php echo SITE_URL; ?>/auth/login.php" class="btn btn-outline">العودة لتسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include(__DIR__ . '/../includes/footer.php'); ?>