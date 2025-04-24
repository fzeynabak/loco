<?php
function is_authenticated() {
    return isset($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function has_permission($permission) {
    // اینجا می‌تونید منطق بررسی دسترسی‌ها رو پیاده‌سازی کنید
    if (is_admin()) return true;
    
    // برای مثال:
    $user_permissions = [
        'create_error' => ['admin', 'manager'],
        'edit_error' => ['admin', 'manager', 'editor'],
        'delete_error' => ['admin']
    ];
    
    return isset($user_permissions[$permission]) && 
           in_array($_SESSION['user_role'], $user_permissions[$permission]);
}

function set_flash_message($type, $message) {
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message
    ];
}

function show_flash_messages() {
    if (!isset($_SESSION['flash_messages']) || empty($_SESSION['flash_messages'])) {
        return;
    }
    
    foreach ($_SESSION['flash_messages'] as $message) {
        echo '<div class="alert alert-' . $message['type'] . ' alert-dismissible fade show m-3" role="alert">';
        echo $message['message'];
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
        echo '</div>';
    }
    
    // پاک کردن پیام‌ها بعد از نمایش
    $_SESSION['flash_messages'] = [];
}

function redirect($path) {
    header("Location: " . BASE_URL . "/$path");
    exit;
}

function format_date($date) {
    return date('Y/m/d H:i', strtotime($date));
}

function get_severity_label($severity) {
    return match($severity) {
        'critical' => 'بحرانی',
        'major' => 'اصلی',
        'minor' => 'جزئی',
        'warning' => 'هشدار',
        default => $severity
    };
}