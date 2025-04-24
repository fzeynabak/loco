<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">ورود به سیستم</h4>
                </div>
                <div class="card-body p-4">
                    <form id="loginForm" action="<?php echo BASE_URL; ?>/login" method="POST" class="needs-validation" novalidate>
                        <?php insert_csrf_token(); ?>
                        
                        <div class="mb-4">
                            <label for="username" class="form-label">نام کاربری</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                                       required autofocus>
                            </div>
                            <div class="invalid-feedback">
                                لطفاً نام کاربری را وارد کنید
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label for="password" class="form-label">رمز عبور</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="bi bi-key"></i></span>
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                لطفاً رمز عبور را وارد کنید
                            </div>
                        </div>

                        <div class="mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">مرا به خاطر بسپار</label>
                            </div>
                        </div>
                        
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-box-arrow-in-left me-2"></i>
                                ورود
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

// Form validation with SweetAlert2
document.getElementById('loginForm').addEventListener('submit', function(event) {
    if (!this.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
        
        Swal.fire({
            icon: 'error',
            title: 'خطا!',
            text: 'لطفاً تمام فیلدهای الزامی را پر کنید',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
    }
    this.classList.add('was-validated');
});

// نمایش پیام‌های فلش با SweetAlert2
<?php show_flash_message_script(); ?>
</script>

<?php require_once 'views/layouts/footer.php'; ?>