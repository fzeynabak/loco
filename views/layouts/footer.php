    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">درباره ما</h5>
                    <p class="mb-0">سیستم مدیریت خطاهای لوکوموتیو، راهکاری جامع برای مدیریت و عیب‌یابی مشکلات لوکوموتیو</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="mb-3">لینک‌های مفید</h5>
                    <ul class="list-unstyled">
                        <li><a href="<?php echo BASE_URL; ?>/" class="text-light text-decoration-none">صفحه اصلی</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/about" class="text-light text-decoration-none">درباره ما</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/contact" class="text-light text-decoration-none">تماس با ما</a></li>
                        <li><a href="<?php echo BASE_URL; ?>/terms" class="text-light text-decoration-none">قوانین و مقررات</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5 class="mb-3">تماس با ما</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i>تهران، خیابان آزادی</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i>۰۲۱-۱۲۳۴۵۶۷۸</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i>support@example.com</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 bg-light">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> تمامی حقوق محفوظ است.</p>
            </div>
        </div>
    </footer>

    <!-- اسکریپت‌های اصلی -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- اسکریپت سفارشی -->
    <script src="<?php echo BASE_URL; ?>/assets/js/main.js"></script>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>