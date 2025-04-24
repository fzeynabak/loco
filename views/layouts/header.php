<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم مدیریت خطاهای لوکوموتیو</title>
    
    <!-- فونت‌آوسام و بوت‌استرپ آیکون -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- بوت‌استرپ RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>    <!-- استایل سفارشی -->
    <style>
    .sidebar {
        border-radius: 0.25rem;
        background-color: #fff;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .sidebar .list-group-item {
        border-left: none;
        border-right: none;
        padding: 0.75rem 1.25rem;
    }
    .sidebar .list-group-item:first-child {
        border-top: none;
    }
    .sidebar .list-group-item:last-child {
        border-bottom: none;
    }
    .sidebar .list-group-item.active {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .sidebar .list-group-item .collapse {
        margin-left: -1.25rem;
        margin-right: -1.25rem;
    }
    .sidebar .list-group-item .collapse .list-group-item {
        padding-left: 2.5rem;
    }
    </style>
</head>
<body>
    <!-- نوار ناوبری -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">سیستم مدیریت خطاها</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <?php if (is_authenticated()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/dashboard">داشبورد</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo BASE_URL; ?>/errors">خطاها</a>
                        </li>
                        <?php if (is_admin()): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?php echo BASE_URL; ?>/users">کاربران</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <?php if (is_authenticated()): ?>
                    <div class="d-flex">
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">پروفایل</a></li>
                                <?php if (is_admin()): ?>
                                    <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>/settings">تنظیمات</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="<?php echo BASE_URL; ?>/logout" method="POST" id="logout-form">
                                        <?php if (function_exists('insert_csrf_token')) insert_csrf_token(); ?>
                                    </form>
                                    <a class="dropdown-item text-danger" href="javascript:void(0)" 
                                    onclick="if(confirm('آیا مطمئن هستید که می‌خواهید خارج شوید؟')) document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i> خروج
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- نمایش پیام‌های فلش -->
    <?php show_flash_messages(); ?>