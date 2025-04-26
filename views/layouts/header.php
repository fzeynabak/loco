<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم مدیریت خطاهای لوکوموتیو</title>
    
    <!-- فونت ایران‌سنس -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    
    <!-- بوت‌استرپ RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- فونت‌آوسام و بوت‌استرپ آیکون -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">


    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        :root {
            --bs-primary: #2563eb;
            --bs-primary-rgb: 37, 99, 235;
        }
        
        body {
            font-family: "Vazirmatn", system-ui, -apple-system, "Segoe UI", sans-serif;
        }

        /* هدر اصلی */
        .main-header {
            background: linear-gradient(to right, #2563eb, #1e40af);
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .main-header .navbar-brand {
            color: white !important;
            font-size: 1.25rem;
            font-weight: 600;
        }

        .main-header .nav-link {
            color: rgba(255,255,255,0.9) !important;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s;
        }

        .main-header .nav-link:hover,
        .main-header .nav-link.active {
            background: rgba(255,255,255,0.1);
            color: white !important;
        }

        /* دکمه همبرگر */
        .main-header .navbar-toggler {
            border-color: rgba(255,255,255,0.5);
        }

        .main-header .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.7%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* منوی کاربر */
        .user-menu .dropdown-toggle {
            color: white !important;
            border: 1px solid rgba(255,255,255,0.3);
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            background: rgba(255,255,255,0.1);
        }

        .user-menu .dropdown-toggle:hover,
        .user-menu .dropdown-toggle:focus {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
        }

        .user-menu .dropdown-menu {
            margin-top: 0.5rem;
            border: none;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
        }

        /* زیرمنوها */
        .submenu {
            position: relative;
        }

        .submenu .dropdown-menu {
            right: 100%;
            top: 0;
            margin: 0;
        }

        /* ریسپانسیو */
        @media (max-width: 992px) {
            .main-header .navbar-collapse {
                background: rgba(0,0,0,0.1);
                padding: 1rem;
                border-radius: 0.5rem;
                margin-top: 1rem;
            }

            .submenu .dropdown-menu {
                right: 0;
                top: 100%;
            }
        }

        /* انیمیشن‌های منو */
        .dropdown-menu {
            animation: slideDown 0.2s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <!-- نوار ناوبری -->
    <nav class="navbar navbar-expand-lg main-header">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?php echo BASE_URL; ?>">
                <i class="bi bi-train-front me-2"></i>
                سیستم مدیریت خطاها
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <?php if (function_exists('is_authenticated') && is_authenticated()): ?>
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?php echo $route === 'dashboard' ? 'active' : ''; ?>" 
                               href="<?php echo BASE_URL; ?>/dashboard">
                                <i class="bi bi-speedometer2 me-1"></i>
                                داشبورد
                            </a>
                        </li>

                        <!-- مدیریت خطاها -->
                        <li class="nav-item submenu">
                            <a class="nav-link <?php echo strpos($route, 'errors') === 0 ? 'active' : ''; ?>" 
                               href="<?php echo BASE_URL; ?>/errors">
                                <i class="bi bi-exclamation-triangle me-1"></i>
                                خطاها
                            </a>
                        </li>

                        <!-- دسترسی مدیر -->
                        <?php if (function_exists('is_admin') && is_admin()): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    <i class="bi bi-gear me-1"></i>
                                    مدیریت
                                </a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/users">
                                            <i class="bi bi-people me-2"></i>
                                            مدیریت کاربران
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/categories">
                                            <i class="bi bi-folder me-2"></i>
                                            دسته‌بندی‌ها
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/admin/locomotives">
                                            <i class="bi bi-train-front me-2"></i>
                                            انواع لوکوموتیو
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>

                    <!-- منوی کاربر -->
                    <div class="user-menu">
                        <div class="dropdown">
                            <button class="btn dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i>
                                <?php echo htmlspecialchars($_SESSION['user_name'] ?? ''); ?>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">
                                        <i class="bi bi-person me-2"></i>
                                        پروفایل
                                    </a>
                                </li>
                                <?php if (function_exists('is_admin') && is_admin()): ?>
                                    <li>
                                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>/settings">
                                            <i class="bi bi-sliders me-2"></i>
                                            تنظیمات
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="confirmLogout()">
                                        <i class="bi bi-box-arrow-right me-2"></i>
                                        خروج
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
    <?php if (function_exists('show_flash_message')) show_flash_message(); ?>

    <!-- اسکریپت تایید خروج -->
    <script>
    function confirmLogout() {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: "آیا می‌خواهید از سیستم خارج شوید؟",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'بله، خارج شوم',
            cancelButtonText: 'انصراف'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = '<?php echo BASE_URL; ?>/logout';
            }
        });
    }
    </script>

    <!-- اسکریپت Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>