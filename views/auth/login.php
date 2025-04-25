<?php require_once 'views/layouts/main.php'; ?>

<div class="auth-container">
    <div class="auth-card">
        <div class="auth-row">
            <!-- بخش سمت چپ -->
            <div class="auth-left">
                <div class="auth-left-content">
                    <h2>مدیریت خطاهای لوکوموتیو</h2>
                    <p>سیستم جامع مدیریت و پایش خطاهای لوکوموتیو با امکانات پیشرفته و رابط کاربری حرفه‌ای. به ما بپیوندید و تجربه مدیریت کارآمد را آغاز کنید.</p>
                    <img src="<?php echo BASE_URL; ?>/assets/images/train-illustration.svg" alt="تصویر قطار" class="img-fluid">
                </div>
            </div>
            
            <!-- بخش سمت راست -->
            <div class="auth-right">
                <div class="auth-form-container">
                    <div class="auth-header">
                        <h3>خوش آمدید</h3>
                        <p>برای ورود به سیستم، اطلاعات خود را وارد کنید</p>
                    </div>
                    
                    <form id="loginForm" action="<?php echo BASE_URL; ?>/login" method="POST" class="needs-validation" novalidate>
                        <?php insert_csrf_token(); ?>
                        
                        <div class="form-floating">
                            <i class="bi bi-person input-icon"></i>
                            <input type="text" class="form-control" id="username" name="username" 
                                   placeholder="نام کاربری"
                                   value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>"
                                   required>
                            <label for="username">نام کاربری</label>
                            <div class="invalid-feedback">
                                لطفاً نام کاربری را وارد کنید
                            </div>
                        </div>
                        
                        <div class="form-floating">
                            <i class="bi bi-key input-icon"></i>
                            <input type="password" class="form-control" id="password" name="password" 
                                   placeholder="رمز عبور" required>
                            <button class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted pe-3" 
                                    type="button" id="togglePassword">
                                <i class="bi bi-eye"></i>
                            </button>
                            <label for="password">رمز عبور</label>
                            <div class="invalid-feedback">
                                لطفاً رمز عبور را وارد کنید
                            </div>
                        </div>
                        
                        <div class="auth-links">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">مرا به خاطر بسپار</label>
                            </div>
                            <a href="<?php echo BASE_URL; ?>/forgot-password">فراموشی رمز عبور؟</a>
                        </div>
                        
                        <button type="submit" class="btn btn-auth">
                            <i class="bi bi-box-arrow-in-left me-2"></i>
                            ورود به سیستم
                        </button>
                        
                        <div class="social-auth">
                            <p>یا با استفاده از</p>
                            <div class="social-buttons">
                                <button type="button" class="btn btn-social">
                                    <i class="bi bi-google"></i>
                                </button>
                                <button type="button" class="btn btn-social">
                                    <i class="bi bi-microsoft"></i>
                                </button>
                                <button type="button" class="btn btn-social">
                                    <i class="bi bi-github"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <p class="mb-0">حساب کاربری ندارید؟ 
                                <a href="<?php echo BASE_URL; ?>/register">ثبت‌نام کنید</a>
                            </p>
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

// اعتبارسنجی فرم با SweetAlert2
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
<?php show_flash_message(); ?>
</script>

<?php require_once 'views/layouts/footer.php'; ?>