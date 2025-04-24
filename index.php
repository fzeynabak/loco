<?php
session_start();
require_once 'config/config.php';
require_once 'includes/database.php';
require_once 'includes/functions.php';

// مسیریابی ساده
$route = $_GET['route'] ?? '';

// بررسی احراز هویت برای مسیرهای محافظت شده
$public_routes = ['', 'login', 'register', 'forgot-password'];
if (!in_array($route, $public_routes) && !is_authenticated()) {
    set_flash_message('error', 'لطفاً ابتدا وارد شوید');
    redirect('login');
}

// اتصال به دیتابیس برای استفاده در تمام صفحات
$db = Database::getInstance()->getConnection();

// مسیریابی
switch ($route) {
    case '':
        // اگر کاربر لاگین نکرده به صفحه لاگین هدایت شود
        if (!is_authenticated()) {
            redirect('login');
            break;
        }
        // در غیر این صورت به داشبورد برود
        require_once 'views/dashboard.php';
        break;
        
    case 'dashboard':
        require_once 'views/dashboard.php';
        break;
        case 'users':
    if (!is_admin()) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('dashboard');
        break;
    }
    require_once 'controllers/UserController.php';
    $controller = new UserController();
    $controller->index();
    break;

case 'users/permissions':
    if (!is_admin()) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('dashboard');
        break;
    }
    require_once 'controllers/UserController.php';
    $controller = new UserController();
    $controller->updatePermissions();
    break;
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
        
    case 'register':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;
        
    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        // حذف تمام داده‌های session
        $_SESSION = array();
        
        // حذف کوکی session
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time()-42000, '/');
        }
        
        // نابود کردن session
        session_destroy();
        
        // ریدایرکت به صفحه لاگین
        header("Location: " . BASE_URL . "/login");
        exit;
        break;

        
    // مسیرهای مربوط به خطاها
    case 'errors':
    case (preg_match('/^errors\//', $route) ? true : false):
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        
        if ($route === 'errors') {
            $controller->index();
        } elseif ($route === 'errors/create') {
            $controller->create();
        } elseif (preg_match('/^errors\/view\/(\d+)$/', $route, $matches)) {
            $controller->view($matches[1]);
        } else {
            require_once 'views/404.php';
        }
        break;
        
    default:
        require_once 'views/404.php';
        break;

    case 'errors/edit':
    if (!is_admin() && !has_permission('edit_error')) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('errors');
        break;
    }
    require_once 'controllers/ErrorController.php';
    $controller = new ErrorController();
    $controller->edit($parts[2] ?? null);
    break;

case 'errors/delete':
    if (!is_admin()) {
        set_flash_message('error', 'فقط مدیر سیستم می‌تواند خطاها را حذف کند');
        redirect('errors');
        break;
    }
    require_once 'controllers/ErrorController.php';
    $controller = new ErrorController();
    $controller->delete($parts[2] ?? null);
    break;
}