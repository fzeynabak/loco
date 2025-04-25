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
case 'permissions':
    if (!is_admin()) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('dashboard');
        break;
    }
    require_once 'controllers/UserController.php';
    $controller = new UserController();
    $controller->permissions();
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

    case 'users/toggle-status':
    if (!is_admin()) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('users');
        break;
    }
    require_once 'controllers/UserController.php';
    $controller = new UserController();
    $controller->toggleStatus();
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
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->index();
        break;

    case 'errors/create':
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->create();
        break;

    case (preg_match('/^errors\/edit\/(\d+)$/', $route, $matches) ? true : false):
        if (!is_admin() && !has_permission('edit_error')) {
            set_flash_message('error', 'شما دسترسی لازم را ندارید');
            redirect('errors');
            break;
        }
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->edit($matches[1]);
        break;

    case (preg_match('/^errors\/view\/(\d+)$/', $route, $matches) ? true : false):
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->view($matches[1]);
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
    case 'errors/edit':
    if (!is_admin() && !has_permission('edit_error')) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('errors');
        break;
    }
    require_once 'controllers/ErrorController.php';
    $controller = new ErrorController();
    $controller->edit($parts[2] ?? null);  // اینجا متد edit رو صدا میزنه
    break;

case 'api/provinces':
    require_once 'controllers/ApiController.php';
    $controller = new ApiController();
    $controller->getProvinces();
    break;

case (preg_match('/^api\/cities\/(\d+)$/', $route, $matches) ? true : false):
    require_once 'controllers/ApiController.php';
    $controller = new ApiController();
    $controller->getCities($matches[1]);
    break;

case (preg_match('/^api\/stations\/(\d+)$/', $route, $matches) ? true : false):
    require_once 'controllers/ApiController.php';
    $controller = new ApiController();
    $controller->getStations($matches[1]);
    break;

    case 'admin/categories':
    if (!is_admin()) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('dashboard');
        break;
    }
    require_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->categories();
    break;

case 'admin/locomotives':
    if (!is_admin()) {
        set_flash_message('error', 'شما دسترسی لازم را ندارید');
        redirect('dashboard');
        break;
    }
    require_once 'controllers/AdminController.php';
    $controller = new AdminController();
    $controller->locomotives();
    break;

    case 'profile':
    if (is_authenticated()) {
        require_once 'controllers/ProfileController.php';
        $controller = new ProfileController();
        $controller->index();
    } else {
        redirect('login');
    }
    break;

    case 'profile/update':
    require_once 'controllers/ProfileController.php';
    $controller = new ProfileController();
    $controller->update();
    break;

case 'errors/breakdown':
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->storeBreakdown();
        break;
    }
    require_once 'controllers/ErrorController.php';
    $controller = new ErrorController();
    $controller->showBreakdownForm();
    break;
}