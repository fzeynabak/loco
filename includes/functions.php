<?php
// توابع کمکی برای احراز هویت
function is_authenticated() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function redirect($path) {
    header("Location: " . BASE_URL . "/$path");
    exit;
}

// توابع مدیریت پیام‌های فلش
function set_flash_message($type, $message) {
    $_SESSION['sweet_alert'] = [
        'type' => $type,
        'message' => $message
    ];
}

function show_flash_messages() {
    if (isset($_SESSION['sweet_alert'])) {
        $message = $_SESSION['sweet_alert'];
        $type = ($message['type'] === 'error') ? 'error' : 
                ($message['type'] === 'success' ? 'success' : 'info');
        
        show_sweet_alert($type, $message['message']);
        unset($_SESSION['sweet_alert']);
    }
}

// تابع بررسی توکن CSRF
function verify_csrf_token() {
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $_POST['csrf_token']);
}

function insert_csrf_token() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    echo '<input type="hidden" name="csrf_token" value="' . $token . '">';
}
function show_sweet_alert($type, $message) {
    echo "<script>
        Swal.fire({
            icon: '$type',
            title: '$message',
            confirmButtonText: 'باشه',
            timer: 3000,
            timerProgressBar: true
        });
    </script>";
}