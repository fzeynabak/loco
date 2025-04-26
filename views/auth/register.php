<?php require_once 'views/layouts/main.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-row">
            <!-- بخش سمت راست - فرم ثبت‌نام -->
            <div class="auth-right">
                <div class="auth-form-container">
                    <div class="auth-header text-center mb-4">
                        <img src="<?php echo BASE_URL; ?>/assets/images/logo.svg" alt="لوگو" class="auth-logo mb-3">
                        <h3 class="fw-bold">ثبت‌نام در سیستم</h3>
                        <p class="text-muted">برای ایجاد حساب کاربری، اطلاعات زیر را تکمیل کنید</p>
                    </div>
                    
                    <form id="registerForm" action="<?php echo BASE_URL; ?>/register" method="POST" class="needs-validation" novalidate>
                        <?php insert_csrf_token(); ?>
                        
                        <div class="form-floating mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-start-0">
                                    <i class="bi bi-person-badge text-primary"></i>
                                </span>
                                <input type="text" 
                                       class="form-control border-end-0 ps-0" 
                                       id="name" 
                                       name="name" 
                                       placeholder="نام و نام خانوادگی"
                                       required>
                                <label for="name" class="ms-4">نام و نام خانوادگی</label>
                            </div>
                            <div class="invalid-feedback">
                                لطفاً نام و نام خانوادگی را وارد کنید
                            </div>
                        </div>

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
                                    <i class="bi bi-envelope text-primary"></i>
                                </span>
                                <input type="email" 
                                       class="form-control border-end-0 ps-0" 
                                       id="email" 
                                       name="email" 
                                       placeholder="ایمیل"
                                       required>
                                <label for="email" class="ms-4">ایمیل</label>
                            </div>
                            <div class="invalid-feedback">
                                لطفاً یک ایمیل معتبر وارد کنید
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
                            <div class="form-text text-muted small">
                                رمز عبور باید حداقل 8 کاراکتر و شامل حروف و اعداد باشد
                            </div>
                            <div class="invalid-feedback">
                                لطفاً رمز عبور را وارد کنید
                            </div>
                        </div>

                        <div class="form-floating mb-4">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-start-0">
                                    <i class="bi bi-shield-check text-primary"></i>
                                </span>
                                <input type="password" 
                                       class="form-control border-end-0 border-start-0 ps-0" 
                                       id="password_confirm" 
                                       name="password_confirm" 
                                       placeholder="تکرار رمز عبور"
                                       required>
                                <span class="input-group-text bg-white border-end-0 pe-0">
                                    <button type="button" 
                                            class="btn btn-link text-muted p-0" 
                                            id="togglePasswordConfirm">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </span>
                                <label for="password_confirm" class="ms-4">تکرار رمز عبور</label>
                            </div>
                            <div class="invalid-feedback">
                                لطفاً تکرار رمز عبور را وارد کنید
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 mb-4 py-2 rounded-3">
                            <i class="bi bi-person-plus me-2"></i>
                            ایجاد حساب کاربری
                        </button>

                        <div class="position-relative text-center mb-4">
                            <hr class="text-muted">
                            <span class="position-absolute top-50 start-50 translate-middle px-3 bg-white text-muted">
                                یا ثبت‌نام با
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
                            قبلاً ثبت‌نام کرده‌اید؟
                            <a href="<?php echo BASE_URL; ?>/login" class="text-primary text-decoration-none fw-bold">
                                وارد شوید
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
                            به خانواده ما خوش آمدید
                        </h2>
                        <p class="lead text-white-50">
                            با ثبت‌نام در سیستم مدیریت خطاهای لوکوموتیو، به جمع متخصصان ما بپیوندید
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
/* استایل‌های مشترک با login.php */
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

/* استایل‌های اختصاصی register.php */
.auth-right {
    padding-top: 2rem;
    padding-bottom: 2rem;
}

.invalid-feedback {
    font-size: 0.875em;
}

.form-text {
    font-size: 0.875em;
    margin-top: 0.25rem;
}

/* Password strength indicator */
.password-strength {
    height: 4px;
    margin-top: 0.5rem;
    border-radius: 2px;
    transition: all 0.3s ease;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Toggle password visibility
    function setupPasswordToggle(inputId, toggleId) {
        const toggleBtn = document.getElementById(toggleId);
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function() {
                const input = document.getElementById(inputId);
                const icon = this.querySelector('i');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('bi-eye');
                    icon.classList.add('bi-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('bi-eye-slash');
                    icon.classList.add('bi-eye');
                }
            });
        }
    }

    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('password_confirm', 'togglePasswordConfirm');

    // Validate password match
    const registerForm = document.getElementById('registerForm');
    if (registerForm) {
        registerForm.addEventListener('submit', function(event) {
            const password = document.getElementById('password');
            const passwordConfirm = document.getElementById('password_confirm');

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
            } else if (password.value !== passwordConfirm.value) {
                event.preventDefault();
                
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: 'رمز عبور و تکرار آن یکسان نیستند',
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