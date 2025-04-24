<?php
session_start();

// تنظیمات پایه
define('BASE_URL', 'http://localhost/loco');
define('DB_HOST', 'localhost');
define('DB_USER', 'root'); // نام کاربری دیتابیس خود را وارد کنید
define('DB_PASS', ''); // رمز عبور دیتابیس خود را وارد کنید
define('DB_NAME', 'locomotive_errors');

// گزارش خطاها
error_reporting(E_ALL);
ini_set('display_errors', 1); // برای محیط توسعه 1 و برای محیط تولید 0
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// تنظیمات امنیتی
define('HASH_COST', 12);
define('SESSION_LIFETIME', 3600);
define('CSRF_TOKEN_SECRET', 'your-secret-key-here');

// تنظیمات برنامه
define('ITEMS_PER_PAGE', 10);
define('ALLOWED_ATTEMPTS', 3);
define('LOCKOUT_TIME', 900);