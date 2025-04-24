<?php
// لود کردن فایل‌های مورد نیاز
require_once 'config/config.php';
require_once 'includes/functions.php';
require_once 'includes/database.php';

// مسیریابی ساده
$route = $_GET['route'] ?? '';

// اگر مسیر خالی باشد، صفحه اصلی را نمایش بده
if (empty($route)) {
    require_once 'views/landing.php';
    exit;
}

// مسیریابی به سایر صفحات
switch ($route) {
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
        
    default:
        // صفحه 404
        header("HTTP/1.0 404 Not Found");
        require_once 'views/404.php';
        break;
}