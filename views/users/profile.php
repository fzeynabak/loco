<?php require_once 'views/layouts/header.php'; ?>

<div class="profile-header">
    <div class="container">
        <div class="profile-content text-center">
            <div class="profile-avatar-wrapper">
                <img src="<?php echo !empty($user['avatar']) ? $user['avatar'] : 'https://www.gravatar.com/avatar/' . md5($user['email']) . '?s=150&d=mp'; ?>" 
                     class="profile-avatar" alt="تصویر پروفایل">
                <div class="profile-avatar-upload">
                    <span>تغییر تصویر</span>
                </div>
            </div>
            <h1 class="profile-name"><?php echo htmlspecialchars($user['name']); ?></h1>
            <p class="profile-role"><?php echo $user['role'] === 'admin' ? 'مدیر سیستم' : 'کاربر'; ?></p>
        </div>
    </div>
</div>

<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <div class="profile-card">
                <h5 class="profile-card-title">اطلاعات حساب کاربری</h5>
                <div class="mb-3">
                    <label class="text-muted">نام کاربری</label>
                    <p class="mb-0"><?php echo htmlspecialchars($user['username']); ?></p>
                </div>
                <div class="mb-3">
                    <label class="text-muted">ایمیل</label>
                    <p class="mb-0"><?php echo htmlspecialchars($user['email']); ?></p>
                </div>
                <div class="mb-0">
                    <label class="text-muted">تاریخ عضویت</label>
<p class="mb-0"><?php echo format_date($user['created_at']); ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-8">
            <form action="<?php echo BASE_URL; ?>/profile/update" method="POST" class="needs-validation profile-form" novalidate>
                <?php insert_csrf_token(); ?>
                
                <div class="profile-card">
                    <h5 class="profile-card-title">اطلاعات شخصی</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">نام و نام خانوادگی *</label>
                                <input type="text" name="name" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">شماره پرسنلی *</label>
                                <input type="text" name="personnel_number" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['personnel_number'] ?? ''); ?>" 
                                       pattern="[0-9]{5,10}" required>
                                <div class="form-text">شماره پرسنلی باید بین 5 تا 10 رقم باشد</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">شماره موبایل *</label>
                                <input type="tel" name="mobile" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>" 
                                       pattern="09[0-9]{9}" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">کد ملی *</label>
                                <input type="text" name="national_code" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['national_code'] ?? ''); ?>" 
                                       pattern="[0-9]{10}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="profile-card">
                    <h5 class="profile-card-title">تغییر رمز عبور</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">رمز عبور فعلی</label>
                                <input type="password" name="current_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">رمز عبور جدید</label>
                                <input type="password" name="new_password" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">تکرار رمز عبور جدید</label>
                                <input type="password" name="confirm_password" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-update-profile">
                        <i class="bi bi-check-lg me-2"></i>
                        ذخیره تغییرات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="<?php echo BASE_URL; ?>/assets/js/profile.js"></script>

<script>
// لود کردن لیست استان‌ها و شهرها
$(document).ready(function() {
    // لود کردن فایل JSON استان‌ها و شهرها
    $.getJSON('<?php echo BASE_URL; ?>/assets/js/iran-cities.json', function(data) {
        // پر کردن لیست استان‌ها
        let provinces = Object.keys(data);
        let provinceSelect = $('#province');
        provinces.forEach(function(province) {
            provinceSelect.append(new Option(province, province));
        });
        
        // تنظیم استان فعلی
        if ('<?php echo $user['province'] ?? ''; ?>') {
            provinceSelect.val('<?php echo $user['province']; ?>');
            updateCities('<?php echo $user['province']; ?>', '<?php echo $user['city'] ?? ''; ?>');
        }
        
        // آپدیت شهرها با تغییر استان
        provinceSelect.on('change', function() {
            updateCities(this.value);
        });
        
        function updateCities(province, selectedCity = '') {
            let citySelect = $('#city');
            citySelect.empty().append(new Option('انتخاب کنید', ''));
            
            if (province && data[province]) {
                data[province].forEach(function(city) {
                    citySelect.append(new Option(city, city));
                });
                
                if (selectedCity) {
                    citySelect.val(selectedCity);
                }
            }
        }
    });
    
    // اعتبارسنجی فرم
    $('form').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
        }
        $(this).addClass('was-validated');
    });
});

</script>

<?php require_once 'views/layouts/footer.php'; ?>