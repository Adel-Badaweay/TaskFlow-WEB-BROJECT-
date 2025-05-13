<?php
require_once(__DIR__ . '/db.php');

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function displayError($message) {
    return '<div class="alert alert-danger">'.htmlspecialchars($message).'</div>';
}

function displaySuccess($message) {
    return '<div class="alert alert-success">'.htmlspecialchars($message).'</div>';
}

function getUserById($id) {
    $db = new Database();
    $conn = $db->getConnection();
    
    $stmt = $conn->prepare("SELECT * FROM users2 WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    return $result->fetch_assoc();
}

function logError($error) {
    file_put_contents(__DIR__ . '/../error_log.txt', date('Y-m-d H:i:s') . ' - ' . $error . PHP_EOL, FILE_APPEND);
}
?>