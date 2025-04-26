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
    <title>سیستم مدیریت خطاهای لوکوموتیو</title>    <!-- فونت ایران‌سنس -->
    <link href="https://cdn.jsdelivr.net/gh/rastikerdar/vazirmatn@v33.003/Vazirmatn-font-face.css" rel="stylesheet" type="text/css" />
    
    <!-- بوت‌استرپ RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- فونت‌آوسام و بوت‌استرپ آیکون -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- PWA Meta Tags -->
    <meta name="application-name" content="مدیریت خطاها">
    <meta name="theme-color" content="#0d6efd">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="مدیریت خطاها">
    <meta name="msapplication-TileColor" content="#0d6efd">
    <meta name="msapplication-config" content="<?php echo BASE_URL; ?>/assets/images/icons/browserconfig.xml">

    <!-- PWA Icons -->
    <link rel="icon" type="image/png" sizes="192x192" href="<?php echo BASE_URL; ?>/assets/images/icons/icon-192x192.png">
    <link rel="apple-touch-icon" sizes="192x192" href="<?php echo BASE_URL; ?>/assets/images/icons/icon-192x192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="<?php echo BASE_URL; ?>/assets/images/icons/icon-512x512.png">
    <link rel="apple-touch-icon" sizes="512x512" href="<?php echo BASE_URL; ?>/assets/images/icons/icon-512x512.png">
    <link rel="manifest" href="<?php echo BASE_URL; ?>/manifest.json">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
    /* Reset */
    *, *::before, *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html, body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    body {
    font-family: "Vazirmatn", system-ui, -apple-system, "Segoe UI", sans-serif;
    background: #f8f9fa;
    }
    body.has-header {
    padding-top: 70px;
}

    /* متغیرهای CSS */
    :root {
        --primary-color: #0d6efd;
        --primary-hover: #0b5ed7;
        --header-height: 70px;
        --header-height-scrolled: 60px;
        --header-bg: #fff;
        --header-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        --header-shadow-scrolled: 0 2px 10px rgba(0, 0, 0, 0.1);
        --border-radius: 8px;
        --transition-speed: 0.3s;
    }

    /* Header */
    .main-header {
        position: fixed;
        top: 0;
        right: 0;
        left: 0;
        height: var(--header-height);
        background: var(--header-bg);
        box-shadow: var(--header-shadow);
        z-index: 1040;
        transition: all var(--transition-speed) ease;
    }

    .main-header.scrolled {
        height: var(--header-height-scrolled);
        box-shadow: var(--header-shadow-scrolled);
    }

    .header-brand {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        text-decoration: none;
        display: flex;
        align-items: center;
    }

    .header-brand:hover {
        color: var(--primary-color);
    }

    .header-brand i {
        font-size: 1.5rem;
        margin-left: 0.5rem;
    }

    /* Main Navigation */
    .header-nav .nav-link {
        color: #2c3e50;
        font-weight: 500;
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        transition: all var(--transition-speed) ease;
    }

    .header-nav .nav-link:hover {
        color: var(--primary-color);
        background: rgba(13, 110, 253, 0.1);
    }

    .header-nav .nav-link.active {
        color: #fff;
        background: var(--primary-color);
    }

    /* User Menu */
    .user-menu {
        display: flex;
        align-items: center;
        padding: 0.25rem;
        border-radius: 50px;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        transition: all var(--transition-speed) ease;
    }

    .user-menu:hover {
        background: #e9ecef;
        border-color: #dee2e6;
    }

    .user-avatar {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        margin-left: 0.5rem;
    }

    .user-info {
        margin-left: 0.5rem;
        line-height: 1.2;
    }

    .user-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .user-role {
        color: #6c757d;
        font-size: 0.8rem;
    }

    /* Dropdown Menus */
    .dropdown-menu {
        border: none;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        border-radius: var(--border-radius);
        padding: 0.5rem;
    }

    .dropdown-item {
        padding: 0.5rem 1rem;
        border-radius: var(--border-radius);
        transition: all var(--transition-speed) ease;
    }

    .dropdown-item:hover {
        background: rgba(13, 110, 253, 0.1);
        color: var(--primary-color);
    }

    .dropdown-item.active {
        background: var(--primary-color);
        color: #fff;
    }

    /* Main Content */
    .main-content {
        padding: 1.5rem;
        width: 100%;
        max-width: 1400px;
        margin: 0 auto;
    }

    /* Cards */
    .card {
        border: none;
        border-radius: var(--border-radius);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        transition: all var(--transition-speed) ease;
    }

    .card:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background: #fff;
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        padding: 1rem;
    }

    /* Forms */
    .form-control:focus,
    .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.25);
    }

    /* Tables */
    .table {
        margin: 0;
    }

    .table th {
        font-weight: 600;
        background: #f8f9fa;
        border-top: none;
    }

    .table td {
        vertical-align: middle;
    }

    /* Mobile Menu */
    @media (max-width: 991.98px) {
        .header-nav {
            position: fixed;
            top: var(--header-height);
            right: 0;
            left: 0;
            background: var(--header-bg);
            padding: 1rem;
            box-shadow: var(--header-shadow);
            transform: translateY(-100%);
            opacity: 0;
            transition: all var(--transition-speed) ease;
        }

        .header-nav.show {
            transform: translateY(0);
            opacity: 1;
        }

        .header-nav .nav-link {
            padding: 0.75rem 1rem;
            margin-bottom: 0.25rem;
        }

        .user-menu {
            margin-right: 1rem;
        }
    }

    /* Small Devices */
    @media (max-width: 575.98px) {
        .user-info {
            display: none;
        }

        .user-menu {
            padding: 0.25rem;
        }

        .main-content {
            padding: 1rem;
        }
    }

    /* Profile Page Styles */
    .profile-card {
        background: #fff;
        border-radius: var(--border-radius);
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        transition: all var(--transition-speed) ease;
    }

    .profile-card:hover {
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .profile-header {
        padding: 2rem;
        text-align: center;
        background: linear-gradient(45deg, #4A90E2, #67B8F7);
        color: #fff;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
    }

    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        border: 4px solid rgba(255, 255, 255, 0.3);
    }

    .profile-name {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .profile-role {
        color: rgba(255, 255, 255, 0.9);
        font-size: 0.9rem;
    }

    .profile-body {
        padding: 2rem;
    }

    .profile-section {
        margin-bottom: 2rem;
    }

    .profile-section:last-child {
        margin-bottom: 0;
    }

    .profile-section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
    }
    </style>
</head>
<body>
    <?php if (is_authenticated()): ?>
    <!-- Header -->
    <header class="main-header">
        <nav class="navbar h-100">
            <div class="container-fluid">
                <!-- Brand -->
                <a href="<?php echo BASE_URL; ?>" class="header-brand">
                    <i class="bi bi-train-front-fill"></i>
                    <span>مدیریت خطاها</span>
                </a>

                <!-- Mobile Menu Toggle -->
                <button class="navbar-toggler border-0 d-lg-none" type="button" onclick="toggleMenu()">
                    <i class="bi bi-list fs-4"></i>
                </button>

                <!-- Main Navigation -->
                <div class="header-nav" id="mainNav">
                    <ul class="nav">
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/dashboard" 
                               class="nav-link <?php echo $route === 'dashboard' ? 'active' : ''; ?>">
                                <i class="bi bi-speedometer2 me-2"></i>
                                <span>داشبورد</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/errors" 
                               class="nav-link <?php echo $route === 'errors' ? 'active' : ''; ?>">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <span>لیست خطاها</span>
                            </a>
                        </li>
                        
                        <?php if (has_permission('create_error')): ?>
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/errors/create" 
                               class="nav-link <?php echo $route === 'errors/create' ? 'active' : ''; ?>">
                                <i class="bi bi-plus-circle me-2"></i>
                                <span>افزودن خطا</span>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a href="<?php echo BASE_URL; ?>/errors/breakdown" 
                               class="nav-link <?php echo $route === 'errors/breakdown' ? 'active' : ''; ?>">
                                <i class="bi bi-wrench me-2"></i>
                                <span>گزارش خرابی</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        
                        <?php if (is_admin()): ?>
                        <!-- منوی مدیریت -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear me-2"></i>
                                <span>مدیریت</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/users" 
                                       class="dropdown-item <?php echo $route === 'users' ? 'active' : ''; ?>">
                                        <i class="bi bi-people me-2"></i>
                                        مدیریت کاربران
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/admin/categories" 
                                       class="dropdown-item <?php echo $route === 'admin/categories' ? 'active' : ''; ?>">
                                        <i class="bi bi-folder me-2"></i>
                                        مدیریت دسته‌بندی‌ها
                                    </a>
                                </li>
                                <li>
                                    <a href="<?php echo BASE_URL; ?>/admin/locomotives" 
                                       class="dropdown-item <?php echo $route === 'admin/locomotives' ? 'active' : ''; ?>">
                                        <i class="bi bi-train-front me-2"></i>
                                        مدیریت لوکوموتیوها
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                <!-- User Menu -->
                <div class="dropdown">
                    <a href="#" class="user-menu text-decoration-none" data-bs-toggle="dropdown">
                        <img src="https://www.gravatar.com/avatar/<?php echo md5($_SESSION['email'] ?? ''); ?>?s=45&d=mp" 
                             alt="تصویر پروفایل" 
                             class="user-avatar">
                        <div class="user-info">
                            <div class="user-name"><?php echo htmlspecialchars($_SESSION['name'] ?? ''); ?></div>
                            <div class="user-role"><?php echo htmlspecialchars($_SESSION['username'] ?? ''); ?></div>
                        </div>
                        <i class="bi bi-chevron-down ms-2"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="<?php echo BASE_URL; ?>/profile">
                                <i class="bi bi-person me-2"></i>
                                پروفایل
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="javascript:void(0)" onclick="confirmLogout()">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                خروج
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <?php endif; ?>

    <!-- Main Content -->
        <?php if (is_authenticated()): ?>
        <main class="main-content">
            <?php if (isset($_SESSION['flash_message'])): ?>
                <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['flash_message']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
            <?php endif; ?>
            
            <?php echo $content ?? ''; ?>
        </main>
    <?php else: ?>
        <?php echo $content ?? ''; ?>
    <?php endif; ?>
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
    // Toggle Mobile Menu
    function toggleMenu() {
        document.getElementById('mainNav').classList.toggle('show');
    }

    // Header Scroll Effect
    window.addEventListener('scroll', function() {
        const header = document.querySelector('.main-header');
        if (window.scrollY > 10) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Initialize Select2
    $(document).ready(function() {
        $('.select2').select2({
            dir: 'rtl',
            width: '100%'
        });
    });

    // Logout confirmation
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
    
        <!-- PWA Installation -->
    <script>
    let deferredPrompt;

    // اگر PWA قبلاً نصب نشده باشد
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        
        // اگر کاربر لاگین کرده باشد
        if (document.querySelector('.user-menu')) {
            // نمایش پیام نصب بعد از 3 ثانیه
            setTimeout(() => {
                showInstallPrompt();
            }, 3000);
        }
    });

    function showInstallPrompt() {
        if (!deferredPrompt) return;

        Swal.fire({
            title: 'نصب برنامه',
            html: `
                <div class="text-right">
                    <p>با نصب این برنامه می‌توانید:</p>
                    <ul class="text-right list-unstyled">
                        <li><i class="bi bi-check2 text-success me-2"></i>دسترسی سریع‌تر داشته باشید</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>در حالت آفلاین کار کنید</li>
                        <li><i class="bi bi-check2 text-success me-2"></i>فضای کمتری اشغال کنید</li>
                    </ul>
                </div>
            `,
            icon: 'info',
            showCancelButton: true,
            confirmButtonText: 'نصب برنامه',
            cancelButtonText: 'بعداً',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        Swal.fire({
                            title: 'نصب موفق',
                            text: 'برنامه با موفقیت نصب شد',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }
                    deferredPrompt = null;
                });
            } else {
                // ذخیره زمان رد کردن نصب
                localStorage.setItem('pwaInstallPromptLastShown', Date.now());
            }
        });
    }

    // بررسی آپدیت سرویس ورکر
    if ('serviceWorker' in navigator) {
        let refreshing = false;

        // ثبت سرویس ورکر
        navigator.serviceWorker.register('<?php echo BASE_URL; ?>/service-worker.js', {
            scope: '<?php echo BASE_URL; ?>/'
        }).then(registration => {
            console.log('Service Worker registered with scope:', registration.scope);

            // بررسی آپدیت در هر بار لود صفحه
            registration.update();

            // وقتی سرویس ورکر جدید نصب می‌شود
            registration.addEventListener('updatefound', () => {
                const newWorker = registration.installing;
                
                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        // نمایش پیام آپدیت
                        Swal.fire({
                            title: 'به‌روزرسانی',
                            text: 'نسخه جدیدی از برنامه در دسترس است. می‌خواهید صفحه را به‌روز کنید؟',
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonText: 'به‌روزرسانی',
                            cancelButtonText: 'بعداً'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                newWorker.postMessage({ action: 'skipWaiting' });
                            }
                        });
                    }
                });
            });
        }).catch(error => {
            console.error('Service Worker registration failed:', error);
        });

        // وقتی سرویس ورکر کنترل صفحه را به دست می‌گیرد
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            if (!refreshing) {
                refreshing = true;
                window.location.reload();
            }
        });

        // هندل کردن وضعیت آفلاین/آنلاین
        window.addEventListener('online', updateOnlineStatus);
        window.addEventListener('offline', updateOnlineStatus);
    }

    // آپدیت وضعیت اتصال
    function updateOnlineStatus() {
        const status = navigator.onLine ? 'online' : 'offline';
        
        if (!navigator.onLine) {
            Swal.fire({
                title: 'عدم اتصال به اینترنت',
                text: 'شما در حالت آفلاین هستید. برخی امکانات محدود خواهند بود.',
                icon: 'warning',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }

        document.body.dataset.connectionStatus = status;
    }

    // چک کردن وضعیت اولیه
    updateOnlineStatus();
    </script>
</body>
</html>