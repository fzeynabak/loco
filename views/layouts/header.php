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
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

    <!-- Leaflet -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Persian Date -->
    <link rel="stylesheet" href="https://unpkg.com/persian-datepicker@1.2.0/dist/css/persian-datepicker.min.css">
    <script src="https://unpkg.com/persian-date@1.1.0/dist/persian-date.min.js"></script>
    <script src="https://unpkg.com/persian-datepicker@1.2.0/dist/js/persian-datepicker.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
<!-- Leaflet -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

<!-- Select2 -->
<link href="<?php echo BASE_URL; ?>/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="<?php echo BASE_URL; ?>/assets/plugins/select2/css/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="<?php echo BASE_URL; ?>/assets/plugins/select2/js/select2.full.min.js"></script>

<!-- Persian Datepicker -->
<link href="<?php echo BASE_URL; ?>/assets/plugins/persian-datepicker/dist/css/persian-datepicker.min.css" rel="stylesheet" />
<script src="<?php echo BASE_URL; ?>/assets/plugins/persian-datepicker/dist/js/persian-datepicker.min.js"></script>

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

        /* PWA Optimizations */
        @media (display-mode: standalone) {
            .container-fluid {
                padding-top: env(safe-area-inset-top);
                padding-bottom: env(safe-area-inset-bottom);
                padding-left: env(safe-area-inset-left);
                padding-right: env(safe-area-inset-right);
            }
        }

        /* Select2 RTL Fixes */
        .select2-container--bootstrap-5 .select2-selection {
            padding: 0.375rem 0.75rem;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
            padding: 0;
        }

        .select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
            left: 0.75rem;
            right: auto;
        }

        /* Persian Datepicker RTL Fixes */
        .datepicker-plot-area {
            font-family: "Vazirmatn", system-ui, -apple-system, "Segoe UI", sans-serif !important;
        }

        .plotarea-days-box, 
        .datepicker-plot-area .datepicker-day-view .table-days td,
        .datepicker-plot-area .datepicker-year-view .year-item,
        .datepicker-plot-area .datepicker-month-view .month-item {
            font-size: 14px;
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