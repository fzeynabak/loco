<?php
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
    exit;
}

// مسیریابی
switch ($route) {
    case '':
        require_once 'views/landing.php';
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
        
    case 'dashboard':
        require_once 'views/dashboard.php';
        break;
        
    case 'logout':
        session_destroy();
        redirect('login');
        break;
        
    default:
        header("HTTP/1.0 404 Not Found");
        require_once 'views/404.php';
        break;
}