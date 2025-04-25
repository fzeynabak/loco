<?php require_once 'views/layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-4">
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="https://www.gravatar.com/avatar/<?php echo md5($user['email']); ?>?s=150&d=mp" 
                             class="rounded-circle mb-3" alt="تصویر پروفایل">
                        <h5 class="card-title mb-1"><?php echo htmlspecialchars($user['name']); ?></h5>
                        <p class="text-muted"><?php echo htmlspecialchars($user['role'] === 'admin' ? 'مدیر سیستم' : 'کاربر'); ?></p>
                    </div>
                </div>
            </div>
        
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">ویرایش اطلاعات</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/profile/update" method="POST" class="needs-validation" novalidate>
                        <?php insert_csrf_token(); ?>
                        
                        <div class="row">
                            <!-- اطلاعات شخصی -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">نام و نام خانوادگی *</label>
                                    <input type="text" name="name" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">شماره پرسنلی *</label>
                                    <input type="text" name="personnel_number" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['personnel_number'] ?? ''); ?>" required
                                           pattern="[0-9]{5,10}">
                                    <div class="form-text">شماره پرسنلی باید بین 5 تا 10 رقم باشد</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">کد ملی *</label>
                                    <input type="text" name="national_code" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['national_code'] ?? ''); ?>" required
                                           pattern="[0-9]{10}">
                                    <div class="form-text">کد ملی باید 10 رقم باشد</div>
                                </div>
                            </div>
                            
                            <!-- اطلاعات تماس -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">ایمیل *</label>
                                    <input type="email" name="email" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">شماره موبایل *</label>
                                    <input type="tel" name="mobile" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>" required
                                           pattern="09[0-9]{9}">
                                    <div class="form-text">شماره موبایل باید با 09 شروع شود و 11 رقم باشد</div>
                                </div>
                            </div>
                            
                            <!-- اطلاعات محل خدمت -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">استان *</label>
                                    <select name="province" id="province" class="form-select" required>
                                        <option value="">انتخاب کنید</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">شهر *</label>
                                    <select name="city" id="city" class="form-select" required>
                                        <option value="">ابتدا استان را انتخاب کنید</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">ایستگاه راه آهن *</label>
                                    <input type="text" name="station" class="form-control" 
                                           value="<?php echo htmlspecialchars($user['station'] ?? ''); ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="mb-3">
                            <label class="form-label">رمز عبور فعلی (در صورت تغییر رمز)</label>
                            <input type="password" name="current_password" class="form-control">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">رمز عبور جدید</label>
                                    <input type="password" name="new_password" class="form-control">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">تکرار رمز عبور جدید</label>
                                    <input type="password" name="confirm_password" class="form-control">
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-lg"></i>
                                ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

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