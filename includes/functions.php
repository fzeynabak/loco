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
    if (!isset($_SESSION['flash_messages'])) {
        $_SESSION['flash_messages'] = [];
    }
    $_SESSION['flash_messages'][] = [
        'type' => $type,
        'message' => $message
    ];
}

function show_flash_message() {
    if (!isset($_SESSION['flash_messages']) || empty($_SESSION['flash_messages'])) {
        return;
    }

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {";
    
    foreach ($_SESSION['flash_messages'] as $message) {
        $icon = match($message['type']) {
            'success' => 'success',
            'error', 'danger' => 'error',
            'warning' => 'warning',
            'info' => 'info',
            default => 'info'
        };
        
        echo "
        Swal.fire({
            icon: '" . $icon . "',
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
    
    echo "
    });
    </script>";
    
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

// CSRF Protection
function generate_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function insert_csrf_token() {
    echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars(generate_csrf_token()) . '">';
}

function verify_csrf_token() {
    if (!isset($_POST['csrf_token']) || !isset($_SESSION['csrf_token']) || 
        $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        return false;
    }
    return true;
}
function check_permission($permission_name) {
    if (is_admin()) return true;
    
    try {
        $db = Database::getInstance()->getConnection();
        $stmt = $db->prepare(
            "SELECT COUNT(*) FROM user_permissions up 
             JOIN permissions p ON up.permission_id = p.id 
             WHERE up.user_id = ? AND p.permission_name = ?"
        );
        $stmt->execute([$_SESSION['user_id'], $permission_name]);
        return $stmt->fetchColumn() > 0;
    } catch (PDOException $e) {
        error_log("Error checking permission: " . $e->getMessage());
        return false;
    }
}