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
    
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <style>
    /* Reset */
    *, *::before, *::after {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
    
    html {
        height: 100%;
    }
    
    body {
        font-family: "Vazirmatn", system-ui, -apple-system, "Segoe UI", sans-serif;
        background: #f8f9fa;
        min-height: 100%;
        position: relative;
        display: flex;
        flex-direction: column;
    }
    
    /* Layout */
    .wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }
    
    /* Sidebar */
    .sidebar-wrapper {
        width: 280px;
        background: #fff;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        position: fixed;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 1030;
        overflow-y: auto;
        transition: transform 0.3s ease-in-out;
    }
    
    /* Main Content */
    .main-content {
        flex: 1;
        width: calc(100% - 280px);
        margin-right: 280px;
        min-height: 100vh;
        padding: 1.5rem;
        transition: margin-right 0.3s ease-in-out;
        background: #f8f9fa;
    }
    
    /* Cards & Tables */
    .card {
        border: none;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        margin-bottom: 1.5rem;
    }
    
    .table-responsive {
        margin-bottom: 1.5rem;
    }
    
    /* Mobile Toggle Button */
    .sidebar-toggle {
        position: fixed;
        top: 1rem;
        right: 1rem;
        z-index: 1040;
        display: none;
    }
    
    /* Responsive Breakpoints */
    @media (max-width: 1199.98px) {
        .main-content {
            width: calc(100% - 240px);
            margin-right: 240px;
        }
        .sidebar-wrapper {
            width: 240px;
        }
    }
    
    @media (max-width: 991.98px) {
        .sidebar-wrapper {
            transform: translateX(100%);
        }
        
        .sidebar-wrapper.show {
            transform: translateX(0);
        }
        
        .main-content {
            width: 100%;
            margin-right: 0;
        }
        
        .sidebar-toggle {
            display: block;
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1029;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
        }
        
        .overlay.show {
            display: block;
            opacity: 1;
        }
    }
    
    @media (max-width: 767.98px) {
        .main-content {
            padding: 1rem;
        }
    }
    
    @media (max-width: 575.98px) {
        .main-content {
            padding: 0.75rem;
        }
    }
    </style>
</head>
<body>

<div class="wrapper">
    <?php if (is_authenticated()): ?>
        <!-- Sidebar Toggle Button for Mobile -->
        <button class="btn btn-primary d-lg-none position-fixed top-0 end-0 mt-2 me-2" 
                type="button" 
                onclick="toggleSidebar()">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Overlay -->
        <div class="overlay" onclick="toggleSidebar()"></div>
        
        <!-- Sidebar -->
        <div class="sidebar-wrapper">
            <?php require_once 'views/layouts/sidebar.php'; ?>
        </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <div class="main-content">
        <?php if (isset($_SESSION['flash_message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                <?php echo $_SESSION['flash_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
        <?php endif; ?>
        
        <?php echo $content ?? ''; ?>
    </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
function toggleSidebar() {
    document.querySelector('.sidebar-wrapper').classList.toggle('show');
    document.querySelector('.overlay').classList.toggle('show');
}

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

</body>
</html>