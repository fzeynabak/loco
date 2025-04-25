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
    // تعریف تابع updateCities خارج از درخواست‌های AJAX
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

    // اعتبارسنجی فرم و نمایش تغییرات
    $('.profile-form').on('submit', function(e) {
        if (!this.checkValidity()) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('was-validated');
            return;
        }

        // تهیه لیست فیلدهای قابل مقایسه
        const fieldsToCompare = {
            'name': 'نام و نام خانوادگی',
            'email': 'ایمیل',
            'mobile': 'شماره موبایل',
            'personnel_number': 'شماره پرسنلی',
            'national_code': 'کد ملی',
            'province': 'استان',
            'city': 'شهرستان',
            'railway_station': 'ایستگاه راه آهن',
            'address': 'آدرس'
        };

        // جمع‌آوری تغییرات
        const changedFields = [];
        
        Object.entries(fieldsToCompare).forEach(([key, label]) => {
            const input = $(`[name="${key}"]`);
            if (input.length) {
                const newValue = input.val();
                const oldValue = '<?php echo addslashes($user[$key] ?? ""); ?>';
                
                // فقط اگر مقدار تغییر کرده باشد و هر دو مقدار معتبر باشند
                if (newValue !== oldValue && (newValue || oldValue)) {
                    // برای select‌ها، متن گزینه انتخاب شده را نمایش می‌دهیم
                    if (input.is('select')) {
                        const newText = input.find('option:selected').text();
                        const oldText = input.find(`option[value="${oldValue}"]`).text() || 'تعیین نشده';
                        changedFields.push(`${label}: ${oldText} ➜ ${newText}`);
                    } else {
                        changedFields.push(`${label}: ${oldValue || 'تعیین نشده'} ➜ ${newValue}`);
                    }
                }
            }
        });

        // اگر تغییری وجود داشته باشد
        if (changedFields.length > 0 || $('[name="new_password"]').val()) {
            e.preventDefault();
            
            let message = '<div class="text-start" style="direction: rtl">';
            
            if (changedFields.length > 0) {
                message += '<h6 class="mb-3">تغییرات اطلاعات:</h6>';
                message += changedFields.map(field => `<div class="mb-2">${field}</div>`).join('');
            }
            
            if ($('[name="new_password"]').val()) {
                message += '<div class="mt-3 text-warning">رمز عبور نیز تغییر خواهد کرد.</div>';
            }
            
            message += '</div>';

            Swal.fire({
                title: 'تایید تغییرات',
                html: message,
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
        } else {
            this.submit();
        }
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>