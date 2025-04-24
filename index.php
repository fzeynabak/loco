<?php
require_once 'config/config.php';
require_once 'includes/functions.php';
require_once 'includes/auth.php';

// Security headers
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("X-Content-Type-Options: nosniff");
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval'; style-src 'self' 'unsafe-inline';");
header("Referrer-Policy: same-origin");

// Route handling
$route = $_GET['route'] ?? 'home';
$action = $_GET['action'] ?? 'index';

// CSRF Protection
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token()) {
        die("Invalid CSRF token");
    }
}

// Authentication check
$public_routes = ['login', 'register', 'forgot-password'];
if (!in_array($route, $public_routes) && !is_authenticated()) {
    redirect('login');
}

// Route mapping
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
        
    case 'admin':
        if (!is_admin()) {
            redirect('dashboard');
        }
        require_once 'controllers/AdminController.php';
        $controller = new AdminController();
        $controller->$action();
        break;
        
    case 'errors':
        require_once 'controllers/ErrorController.php';
        $controller = new ErrorController();
        $controller->$action();
        break;
        
    case 'users':
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->$action();
        break;
        
    default:
        if (is_authenticated()) {
            redirect('dashboard');
        } else {
            redirect('login');
        }
        break;
}