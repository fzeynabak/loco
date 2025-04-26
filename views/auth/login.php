<?php require_once 'views/layouts/main.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-row">
            <!-- بخش سمت راست - فرم لاگین -->
            <div class="auth-right">
                <div class="auth-form-container">
                    <div class="auth-header text-center mb-4">
                        <img src="<?php echo BASE_URL; ?>/assets/images/logo.svg" alt="لوگو" class="auth-logo mb-3">
                        <h3 class="fw-bold">خوش آمدید</h3>
                        <p class="text-muted">برای ورود به سیستم، اطلاعات خود را وارد کنید</p>
                    </div>
                    
                    <form id="loginForm" action="<?php echo BASE_URL; ?>/login" method="POST" class="needs-validation" novalidate>
                        <?php insert_csrf_token(); ?>
                        
                        <div class="form-floating mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-start-0">
                                    <i class="bi bi-person text-primary"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-end-0 ps-0" 
                                       id="username" 
                                       name="username" 
                                       placeholder="نام کاربری"
                                       value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                                       required>
                                <label for="username" class="ms-4">نام کاربری</label>
                            </div>
                            <div class="invalid-feedback">
                                لطفاً نام کاربری را وارد کنید
                            </div>
                        </div>
                        
                        <div class="form-floating mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-start-0">
                                    <i class="bi bi-shield-lock text-primary"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-end-0 border-start-0 ps-0" 
                                       id="password" 
                                       name="password" 
                                       placeholder="رمز عبور" 
                                       required>
                                <span class="input-group-text bg-white border-end-0 pe-0">
                                    <button type="button" 
                                            class="btn btn-link text-muted p-0" 
                                            id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </span>
                                <label for="password" class="ms-4">رمز عبور</label>
                            </div>
                            <div class="invalid-feedback">
                                لطفاً رمز عبور را وارد کنید
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input type="checkbox" 
                                       class="form-check-input" 
                                       id="remember" 
                                       name="remember">
                                <label class="form-check-label user-select-none" for="remember">
                                    مرا به خاطر بسپار
                                </label>
                            </div>
                            <a href="<?php echo BASE_URL; ?>/forgot-password" class="text-primary text-decoration-none">
                                فراموشی رمز عبور؟
                            </a>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100 mb-4 py-2 rounded-3">
                            <i class="bi bi-box-arrow-in-left me-2"></i>
                            ورود به سیستم
                        </button>
                        
                        <div class="position-relative text-center mb-4">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted">
                                یا ورود با
                            </span>
                        </div>
                        
                        <div class="social-auth mb-4">
                            <div class="d-flex justify-content-center gap-3">
                                <button type="button" class="btn btn-outline-light social-btn">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/google.svg" alt="Google" width="24">
                                </button>
                                <button type="button" class="btn btn-outline-light social-btn">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/microsoft.svg" alt="Microsoft" width="24">
                                </button>
                                <button type="button" class="btn btn-outline-light social-btn">
                                    <img src="<?php echo BASE_URL; ?>/assets/images/github.svg" alt="GitHub" width="24">
                                </button>
                            </div>
                        </div>
                        
                        <p class="text-center mb-0">
                            حساب کاربری ندارید؟ 
                            <a href="<?php echo BASE_URL; ?>/register" class="text-primary text-decoration-none fw-bold">
                                ثبت‌نام کنید
                            </a>
                        </p>
                    </form>
                </div>
            </div>
            
            <!-- بخش سمت چپ - تصویر -->
            <div class="auth-left d-none d-lg-block">
                <div class="auth-left-content">
                    <div class="text-center mb-5">
                        <h2 class="display-6 fw-bold text-white mb-4">
                            سیستم مدیریت خطاهای لوکوموتیو
                        </h2>
                        <p class="lead text-white-50">
                            سیستم جامع مدیریت و پایش خطاهای لوکوموتیو با امکانات پیشرفته و رابط کاربری حرفه‌ای
                        </p>
                    </div>
                    <div class="auth-illustration">
                        <img src="<?php echo BASE_URL; ?>/assets/images/train-illustration.svg" 
                             alt="تصویر قطار" 
                             class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
/* استایل‌های صفحه لاگین */
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
}

.auth-card {
    width: 100%;
    max-width: 1200px;
    background: #fff;
    border-radius: 20px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.auth-row {
    display: flex;
    flex-direction: row-reverse;
}

.auth-right {
    flex: 1;
    padding: 3rem;
}

.auth-left {
    flex: 1;
    background: linear-gradient(135deg, #0d6efd 0%, #0099ff 100%);
    padding: 3rem;
    display: flex;
    align-items: center;
    position: relative;
}

.auth-logo {
    height: 48px;
    object-fit: contain;
}

.auth-form-container {
    max-width: 400px;
    margin: 0 auto;
}

.form-floating > .form-control:focus ~ label {
    color: #0d6efd;
}

.form-control:focus {
    border-color: #0d6efd;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
}

.social-btn {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    padding: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    border: 2px solid #e9ecef;
}

.social-btn:hover {
    background-color: #f8f9fa;
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.auth-illustration {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 80%;
}

.input-group-text {
    border-color: #dee2e6;
}

.form-control {
    border-color: #dee2e6;
}

.form-floating > .form-control,
.form-floating > .form-control:focus {
    padding-right: 45px;
}

/* Animation */
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
    100% { transform: translateY(0px); }
}

.auth-illustration img {
    animation: float 6s ease-in-out infinite;
}

/* Responsive */
@media (max-width: 991.98px) {
    .auth-right {
        padding: 2rem;
    }
    
    .auth-form-container {
        max-width: 100%;
    }
}

@media (max-width: 575.98px) {
    .auth-container {
        padding: 1rem;
    }
    
    .auth-right {
        padding: 1.5rem;
    }
    
    .auth-card {
        border-radius: 10px;
    }
}
label.ms-4 {
    margin-right: unset;
    margin-left: 12px;
}
input#username {
    padding-left: 12px !important;
    text-align: left;
}
.input-group {
    direction: ltr;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // Toggle password visibility
    const togglePassword = document.getElementById('togglePassword');
    if (togglePassword) {
        togglePassword.addEventListener('click', function() {
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
    }

    // Form validation with SweetAlert2
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
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
                    timerProgressBar: true,
                    customClass: {
                        popup: 'swal2-rtl'
                    }
                });
            }
            this.classList.add('was-validated');
        });
    }
    
    // Show flash messages
    <?php show_flash_message(); ?>
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>