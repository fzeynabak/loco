<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">ورود به سیستم</h3>
                </div>
                <div class="card-body">
                    <?php show_flash_messages(); ?>
                    
                    <form action="<?php echo BASE_URL; ?>/login" method="POST" class="needs-validation" novalidate>
                        <?php insert_csrf_token(); ?>
                        
                        <div class="form-group">
                            <label for="username">نام کاربری</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <div class="invalid-feedback">
                                لطفاً نام کاربری را وارد کنید
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">رمز عبور</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                            <div class="invalid-feedback">
                                لطفاً رمز عبور را وارد کنید
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">ورود</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="<?php echo BASE_URL; ?>/register">ثبت نام</a> |
                            <a href="<?php echo BASE_URL; ?>/forgot-password">فراموشی رمز عبور</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>