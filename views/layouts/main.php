<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سیستم مدیریت خطاهای لوکوموتیو</title>
    
    <!-- بوت‌استرپ RTL -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
    
    <!-- فونت‌آوسام و بوت‌استرپ آیکون -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-bootstrap-4/bootstrap-4.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <!-- استایل سفارشی -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/style.css">
    
<style>
body {
    overflow-x: hidden;
    min-height: 100vh;
    background-color: #f8f9fa;
}

.wrapper {
    display: flex;
    align-items: stretch;
    min-height: 100vh;
}

.content-wrapper {
    flex: 1;
    padding: 20px;
    margin-right: 280px;
    min-height: 100vh;
    transition: margin-right 0.3s ease;
    overflow-y: auto;
    background-color: #f8f9fa;
}

.sidebar {
    position: fixed;
    width: 280px;
    height: 100vh;
    top: 0;
    right: 0;
    z-index: 1030;
    background: #fff;
    box-shadow: -2px 0 5px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    overflow-y: auto;
}

@media (max-width: 768px) {
    .content-wrapper {
        margin-right: 0;
    }
    .sidebar {
        transform: translateX(280px);
    }
    .sidebar.active {
        transform: translateX(0);
    }
}

.page-content {
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
</style>
</head>
<body>
    <div class="wrapper">
        <?php if (is_authenticated()): ?>
            <!-- دکمه منو در حالت موبایل -->
            <button type="button" id="sidebarCollapse" class="btn btn-primary sidebar-toggle">
                <i class="bi bi-list"></i>
            </button>
            
            <!-- سایدبار -->
            <?php require_once 'views/layouts/sidebar.php'; ?>
        <?php endif; ?>
        
        <!-- محتوای اصلی -->
        <div class="content-wrapper">
            <div class="container-fluid">
                <?php if (isset($_SESSION['flash_message'])): ?>
                    <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show mb-4" role="alert">
                        <?php echo $_SESSION['flash_message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
                <?php endif; ?>
                
                <?php echo $content ?? ''; ?>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    $(document).ready(function() {
        // سایدبار موبایل
        $('#sidebarCollapse').on('click', function() {
            $('.sidebar').toggleClass('active');
        });
        
        // مخفی کردن سایدبار با کلیک خارج از آن در حالت موبایل
        $(document).click(function(e) {
            if (!$(e.target).closest('.sidebar, #sidebarCollapse').length) {
                $('.sidebar').removeClass('active');
            }
        });
        
        // Select2
        $('.select2').select2({
            dir: 'rtl',
            language: 'fa'
        });
    });
    </script>
</body>
</html>