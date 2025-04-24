<?php
// توابع احراز هویت
function is_authenticated() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function is_admin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

function has_permission($permission) {
    if (is_admin()) return true;
    
    $user_permissions = [
        'create_error' => ['admin', 'manager'],
        'edit_error' => ['admin', 'manager', 'editor'],
        'delete_error' => ['admin']
    ];
    
    return isset($user_permissions[$permission]) && 
           in_array($_SESSION['user_role'], $user_permissions[$permission]);
}

// توابع پیام‌رسانی
function set_flash_message($type, $message) {
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message
    ];
}

function show_flash_message() {
    if (!isset($_SESSION['flash_messages']) || empty($_SESSION['flash_messages'])) {
        return;
    }

    echo "<script>";
    foreach ($_SESSION['flash_messages'] as $message) {
        $icon = match($message['type']) {
            'success' => 'success',
            'error', 'danger' => 'error',
            'warning' => 'warning',
            'info' => 'info',
            default => 'info'
        };
        
        echo "Swal.fire({
            icon: '$icon',
            title: '" . addslashes($message['message']) . "',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });";
    }
    echo "</script>";
    
    $_SESSION['flash_messages'] = [];
}

// توابع مسیریابی
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