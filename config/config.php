<?php
session_start();

// تنظیمات پایه
define('BASE_URL', 'https://pertech.ir');  // آدرس دامنه خودتون رو بذارید
define('DB_HOST', 'localhost');  // معمولاً localhost هست، نیاز به تغییر نداره
define('DB_USER', 'h312739_loco-tepars-user');  // نام کاربری که در cPanel ساختید
define('DB_PASS', '&H!]9b4y@C6h+awz#H456o');  // رمز عبوری که برای دیتابیس تنظیم کردید
define('DB_NAME', 'h312739_tepars-db-locomotive');  // نام دیتابیسی که در cPanel ساختید

// گزارش خطاها - برای محیط تولید
error_reporting(E_ALL);
ini_set('display_errors', 0);  // در محیط تولید باید 0 باشه
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// بقیه تنظیمات بدون تغییر می‌مونه
define('HASH_COST', 12);
define('SESSION_LIFETIME', 3600);
define('CSRF_TOKEN_SECRET', 'your-secret-key-here');
define('ITEMS_PER_PAGE', 10);
define('ALLOWED_ATTEMPTS', 3);
define('LOCKOUT_TIME', 900);