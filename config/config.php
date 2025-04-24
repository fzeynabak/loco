<?php
session_start();

define('BASE_URL', 'http://your-domain.com/locomotive-error-system');
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'locomotive_errors');

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/error.log');

// Security configurations
define('HASH_COST', 12); // For password hashing
define('SESSION_LIFETIME', 3600); // 1 hour
define('CSRF_TOKEN_SECRET', 'change-this-to-a-random-string');

// Application settings
define('ITEMS_PER_PAGE', 10);
define('ALLOWED_ATTEMPTS', 3);
define('LOCKOUT_TIME', 900); // 15 minutes