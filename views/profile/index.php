<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">پروفایل کاربری</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['flash_message'])): ?>
                        <div class="alert alert-<?php echo $_SESSION['flash_type']; ?> alert-dismissible fade show" role="alert">
                            <?php echo $_SESSION['flash_message']; ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
                    <?php endif; ?>

                    <form action="<?php echo BASE_URL; ?>/profile/update" method="POST" class="needs-validation" novalidate>
                        <?php insert_csrf_token(); ?>
                        
                        <div class="row">
                            <!-- اطلاعات شخصی -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="mb-0">اطلاعات شخصی</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">نام و نام خانوادگی</label>
                                            <input type="text" name="name" class="form-control" required
                                                   value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">شماره موبایل</label>
                                            <input type="tel" name="mobile" class="form-control" 
                                                   pattern="^09[0-9]{9}$"
                                                   value="<?php echo htmlspecialchars($user['mobile'] ?? ''); ?>">
                                            <div class="form-text">مثال: 09123456789</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">کد ملی</label>
                                            <input type="text" name="national_code" class="form-control"
                                                   pattern="^[0-9]{10}$"
                                                   value="<?php echo htmlspecialchars($user['national_code'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- اطلاعات محل کار -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="mb-0">اطلاعات محل کار</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">استان</label>
                                            <select name="province_id" id="province" class="form-select" required>
                                                <option value="">انتخاب کنید</option>
                                                <!-- استان‌ها با AJAX لود می‌شوند -->
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">شهرستان</label>
                                            <select name="city_id" id="city" class="form-select" required>
                                                <option value="">ابتدا استان را انتخاب کنید</option>
                                                <!-- شهرستان‌ها با AJAX لود می‌شوند -->
                                            </select>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">ایستگاه راه‌آهن</label>
                                            <select name="station_id" id="station" class="form-select" required>
                                                <option value="">ابتدا شهرستان را انتخاب کنید</option>
                                                <!-- ایستگاه‌ها با AJAX لود می‌شوند -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- اطلاعات حساب -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="mb-0">اطلاعات حساب</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">نام کاربری</label>
                                            <input type="text" value="<?php echo htmlspecialchars($user['username'] ?? ''); ?>" 
                                                   class="form-control" readonly>
                                            <div class="form-text">نام کاربری قابل تغییر نیست</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">ایمیل</label>
                                            <input type="email" name="email" class="form-control" required
                                                   value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- تغییر رمز عبور -->
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-header">
                                        <h6 class="mb-0">تغییر رمز عبور</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">رمز عبور فعلی</label>
                                            <input type="password" name="current_password" class="form-control">
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">رمز عبور جدید</label>
                                            <input type="password" name="new_password" class="form-control"
                                                   pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$">
                                            <div class="form-text">حداقل 8 کاراکتر شامل حروف و اعداد</div>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label class="form-label">تکرار رمز عبور جدید</label>
                                            <input type="password" name="confirm_password" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="button" class="btn btn-outline-secondary" onclick="window.history.back()">
                                <i class="bi bi-arrow-right me-1"></i>
                                بازگشت
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i>
                                ذخیره تغییرات
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- استایل‌های اختصاصی -->
<style>
.card {
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    transition: all 0.3s ease;
}
.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}
.card-header {
    background-color: #fff;
    border-bottom: 1px solid rgba(0, 0, 0, 0.125);
    padding: 1rem;
}
.form-control:focus,
.form-select:focus {
    border-color: #80bdff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}
</style>

<!-- اسکریپت‌های مربوط به استان و شهر -->
<script>
$(document).ready(function() {
    // لود استان‌ها در هنگام بارگذاری صفحه
    loadProvinces();
    
    // رویداد تغییر استان
    $('#province').change(function() {
        const provinceId = $(this).val();
        if (provinceId) {
            loadCities(provinceId);
        } else {
            $('#city').html('<option value="">ابتدا استان را انتخاب کنید</option>');
            $('#station').html('<option value="">ابتدا شهرستان را انتخاب کنید</option>');
        }
    });
    
    // رویداد تغییر شهر
    $('#city').change(function() {
        const cityId = $(this).val();
        if (cityId) {
            loadStations(cityId);
        } else {
            $('#station').html('<option value="">ابتدا شهرستان را انتخاب کنید</option>');
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

function loadProvinces() {
    $.get('<?php echo BASE_URL; ?>/api/provinces', function(data) {
        let options = '<option value="">انتخاب کنید</option>';
        data.forEach(function(province) {
            options += `<option value="${province.id}">${province.name}</option>`;
        });
        $('#province').html(options);
        
        // اگر استان قبلاً انتخاب شده بود
        const selectedProvince = '<?php echo $user['province_id'] ?? ''; ?>';
        if (selectedProvince) {
            $('#province').val(selectedProvince).trigger('change');
        }
    });
}

function loadCities(provinceId) {
    $.get(`<?php echo BASE_URL; ?>/api/cities/${provinceId}`, function(data) {
        let options = '<option value="">انتخاب کنید</option>';
        data.forEach(function(city) {
            options += `<option value="${city.id}">${city.name}</option>`;
        });
        $('#city').html(options);
        
        // اگر شهر قبلاً انتخاب شده بود
        const selectedCity = '<?php echo $user['city_id'] ?? ''; ?>';
        if (selectedCity) {
            $('#city').val(selectedCity).trigger('change');
        }
    });
}

function loadStations(cityId) {
    $.get(`<?php echo BASE_URL; ?>/api/stations/${cityId}`, function(data) {
        let options = '<option value="">انتخاب کنید</option>';
        data.forEach(function(station) {
            options += `<option value="${station.id}">${station.name}</option>`;
        });
        $('#station').html(options);
        
        // اگر ایستگاه قبلاً انتخاب شده بود
        const selectedStation = '<?php echo $user['station_id'] ?? ''; ?>';
        if (selectedStation) {
            $('#station').val(selectedStation);
        }
    });
}
</script>