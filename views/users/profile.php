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
                    <h5 class="profile-card-title">اطلاعات تماس و محل کار</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">ایمیل *</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?php echo htmlspecialchars($user['email']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">آدرس</label>
                                <textarea name="address" class="form-control" rows="3"><?php echo htmlspecialchars($user['address'] ?? ''); ?></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">استان *</label>
                                <select name="province" id="province" class="form-select" required>
                                    <option value="">انتخاب کنید</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">شهرستان *</label>
                                <select name="city" id="city" class="form-select" required>
                                    <option value="">ابتدا استان را انتخاب کنید</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="form-label">ایستگاه راه آهن محل خدمت *</label>
                                <select name="railway_station" id="railway_station" class="form-select" required>
                                    <option value="">ابتدا شهرستان را انتخاب کنید</option>
                                </select>
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

<script>
    $(document).ready(function() {
    // اعتبارسنجی کد ملی
    const nationalCodeInput = $('input[name="national_code"]');
    
    function validateNationalCode(code) {
        if (!/^\d{10}$/.test(code)) return false;
        
        const check = parseInt(code[9]);
        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(code[i]) * (10 - i);
        }
        const remainder = sum % 11;
        return (remainder < 2 && check == remainder) || (remainder >= 2 && check == (11 - remainder));
    }
    
    nationalCodeInput.on('input', function() {
        const value = $(this).val();
        const isValid = validateNationalCode(value);
        
        if (value.length > 0) {
            if (!isValid) {
                $(this).removeClass('is-valid').addClass('is-invalid');
                // حذف پیام خطای قبلی اگر وجود داشت
                $(this).siblings('.invalid-feedback').remove();
                // اضافه کردن پیام خطای جدید
                $(this).after('<div class="invalid-feedback">کد ملی وارد شده صحیح نیست</div>');
            } else {
                $(this).removeClass('is-invalid').addClass('is-valid');
                $(this).siblings('.invalid-feedback').remove();
            }
        } else {
            $(this).removeClass('is-valid is-invalid');
            $(this).siblings('.invalid-feedback').remove();
        }
    });

    // ذخیره فرم و نمایش نوتیفیکیشن
    $('.profile-form').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        // جمع‌آوری مقادیر تغییر یافته
        const formData = new FormData(this);
        const changedFields = [];
        const oldValues = {
            name: '<?php echo htmlspecialchars($user['name']); ?>',
            email: '<?php echo htmlspecialchars($user['email']); ?>',
            mobile: '<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>',
            personnel_number: '<?php echo htmlspecialchars($user['personnel_number'] ?? ''); ?>',
            national_code: '<?php echo htmlspecialchars($user['national_code'] ?? ''); ?>',
            province: '<?php echo htmlspecialchars($user['province'] ?? ''); ?>',
            city: '<?php echo htmlspecialchars($user['city'] ?? ''); ?>',
            railway_station: '<?php echo htmlspecialchars($user['railway_station'] ?? ''); ?>',
            address: '<?php echo htmlspecialchars($user['address'] ?? ''); ?>'
        };

        for (let [key, value] of formData.entries()) {
            // رمز عبور را بررسی نمی‌کنیم
            if (key.includes('password')) continue;
            
            // فقط فیلدهای تغییر کرده را اضافه می‌کنیم
            if (value !== oldValues[key]) {
                const label = $(`[name="${key}"]`).closest('.form-group').find('.form-label').text().replace(' *', '');
                changedFields.push(`${label}: ${oldValues[key]} ➜ ${value}`);
            }
        }

        if (changedFields.length > 0) {
            const confirmMessage = changedFields.map(field => `<p>${field}</p>`).join('');

            e.preventDefault();
            
            Swal.fire({
                title: 'تایید تغییرات',
                html: confirmMessage,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'ذخیره تغییرات',
                cancelButtonText: 'انصراف',
                customClass: {
                    popup: 'swal2-rtl',
                    title: 'text-right'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        }
    });



    // لود کردن لیست استان‌ها
    $.getJSON('<?php echo BASE_URL; ?>/assets/plugins/iran-cities/ostan.json', function(data) {
        // پر کردن لیست استان‌ها
        let provinceSelect = $('#province');
        data.forEach(function(province) {
            provinceSelect.append(new Option(province.name, province.id));
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
    });
    
    // لود کردن ایستگاه‌های راه آهن
    $.getJSON('<?php echo BASE_URL; ?>/assets/plugins/iran-cities/list-railway.json', function(data) {
        let railwayStations = data['tehran-mashhad'].stations;
        let stationSelect = $('#railway_station');
        
        // پر کردن لیست ایستگاه‌ها به صورت مستقل
        stationSelect.empty().append('<option value="">انتخاب کنید</option>');
        railwayStations.forEach(station => {
            stationSelect.append(new Option(station.name, station.id));
        });
        
        // تنظیم ایستگاه فعلی
        if ('<?php echo $user['railway_station'] ?? ''; ?>') {
            stationSelect.val('<?php echo $user['railway_station']; ?>');
        }
    });
});

function updateCities(provinceId, selectedCity = '') {
    $.getJSON('<?php echo BASE_URL; ?>/assets/plugins/iran-cities/shahr.json', function(data) {
        let citySelect = $('#city');
        citySelect.empty().append('<option value="">انتخاب کنید</option>');
        
        if (provinceId) {
            let cities = data.filter(city => city.ostan === parseInt(provinceId));
            cities.forEach(function(city) {
                citySelect.append(new Option(city.name, city.id));
            });
            
            if (selectedCity) {
                citySelect.val(selectedCity);
                citySelect.trigger('change');
            }
        }
    });
}

// اعتبارسنجی فرم
$('form').on('submit', function(e) {
    if (!this.checkValidity()) {
        e.preventDefault();
        e.stopPropagation();
    }
    $(this).addClass('was-validated');
});


// اضافه کردن اعتبارسنجی کد ملی و نوتیفیکیشن به اسکریپت‌های موجود

</script>
<script src="<?php echo BASE_URL; ?>/assets/js/profile-validation.js"></script>
<?php require_once 'views/layouts/footer.php'; ?>
