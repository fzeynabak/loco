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
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }
    
    body {
        font-family: "Vazirmatn", system-ui, -apple-system, "Segoe UI", sans-serif;
        min-height: 100vh;
        background: #f8f9fa;
    }
    
    /* Layout */
    .main-wrapper {
        display: flex;
        min-height: 100vh;
        width: 100%;
    }
    
    /* Sidebar */
/* Sidebar */
.sidebar-wrapper {
    width: 280px;
    min-height: 100vh;
    background: #fff;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    z-index: 1;
}

/* Main Content */
.main-content {
    margin-right: 280px; /* برابر با عرض سایدبار */
    padding: 1.5rem;
    min-height: 100vh;
    background: #f8f9fa;
    position: relative;
    z-index: 0;
}

/* Responsive */
@media (max-width: 992px) {
    .main-content {
        margin-right: 0;
    }
    
    .sidebar-wrapper {
        z-index: 1040;
        transform: translateX(100%);
        transition: transform 0.3s ease;
    }
    
    .sidebar-wrapper.show {
        transform: translateX(0);
    }
}
    
    /* Main Content */
    .main-content {
        flex: 1;
        margin-right: 280px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }
    
    /* Responsive */
    @media (max-width: 992px) {
        .sidebar {
            transform: translateX(100%);
        }
        
        .sidebar.show {
            transform: translateX(0);
        }
        
        .main-content {
            margin-right: 0;
        }
    }
    </style>
</head>
<body>

<div class="main-wrapper">
    <!-- Sidebar Toggle Button for Mobile -->
    <?php if (is_authenticated()): ?>
        <button class="btn btn-primary d-lg-none position-fixed top-0 end-0 mt-2 me-2" 
                type="button" 
                data-bs-toggle="collapse" 
                data-bs-target="#sidebar" 
                aria-expanded="false">
            <i class="bi bi-list"></i>
        </button>
        
        <!-- Sidebar -->
        <div class="sidebar collapse d-lg-block" id="sidebar">
            <?php require_once 'views/layouts/sidebar.php'; ?>
        </div>
    <?php endif; ?>
    
    <!-- Main Content -->
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
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2
    $('.select2').select2({
        dir: 'rtl',
        width: '100%'
    });
    
    // Handle Sidebar on Mobile
    $(document).on('click touchstart', function(e) {
        if (!$(e.target).closest('.sidebar, .btn-primary').length) {
            $('#sidebar').collapse('hide');
        }
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