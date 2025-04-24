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
    .content-wrapper {
        margin-right: 280px;
        transition: margin-right .3s ease-in-out;
    }
    
    @media (max-width: 768px) {
        .content-wrapper {
            margin-right: 0;
        }
        .sidebar {
            transform: translateX(280px);
        }
        .sidebar.show {
            transform: translateX(0);
        }
    }
    
    .sidebar {
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 100;
        transition: transform .3s ease-in-out;
    }
    </style>
</head>
<body>
    <?php 
    if (is_authenticated()) {
        require_once 'views/layouts/sidebar.php';
    }
    ?>
    
    <div class="content-wrapper">
        <div class="container-fluid p-4">
            <?php echo $content ?? ''; ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Toggle sidebar on mobile
    document.querySelector('.navbar-toggler').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('show');
    });
    
    // Initialize Select2
    $(document).ready(function() {
        $('.select2').select2({
            dir: 'rtl',
            language: 'fa'
        });
    });
    </script>
</body>
</html>