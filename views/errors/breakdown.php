<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid pt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ثبت خرابی لوکوموتیو</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/errors/breakdown" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                <?php insert_csrf_token(); ?>
                
                <!-- مکان و زمان خرابی -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="section-title">
                            <i class="bi bi-geo-alt me-2"></i>
                            مکان و زمان خرابی
                        </h6>
                    </div>

                    <!-- نقشه ریلی -->
                    <div class="col-12 mb-4">
                        <div id="railwayMap" style="height: 400px; border-radius: 8px;"></div>
                        <input type="hidden" id="selected_location" name="selected_location">
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">استان <span class="text-danger">*</span></label>
                            <select name="province_id" id="province" class="form-select select2" required>
                                <option value="">انتخاب کنید</option>
                                <?php foreach ($provinces as $province): ?>
                                    <option value="<?php echo $province['id']; ?>">
                                        <?php echo htmlspecialchars($province['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">لطفاً استان را انتخاب کنید</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">شهر <span class="text-danger">*</span></label>
                            <select name="city_id" id="city" class="form-select select2" required>
                                <option value="">ابتدا استان را انتخاب کنید</option>
                            </select>
                            <div class="invalid-feedback">لطفاً شهر را انتخاب کنید</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">ایستگاه <span class="text-danger">*</span></label>
                            <select name="station_id" id="station" class="form-select select2" required>
                                <option value="">ابتدا شهر را انتخاب کنید</option>
                            </select>
                            <div class="invalid-feedback">لطفاً ایستگاه را انتخاب کنید</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">تاریخ و ساعت <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" 
                                       name="occurrence_date" 
                                       id="occurrence_date" 
                                       class="form-control" 
                                       required 
                                       data-jdp
                                       autocomplete="off"
                                       placeholder="انتخاب کنید">
                                <span class="input-group-text"><i class="bi bi-calendar3"></i></span>
                            </div>
                            <div class="invalid-feedback">لطفاً تاریخ و ساعت را به فرمت صحیح وارد کنید</div>
                        </div>
                    </div>
                </div>

                <!-- اطلاعات لوکوموتیو -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="section-title">
                            <i class="bi bi-train-front me-2"></i>
                            اطلاعات لوکوموتیو
                        </h6>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">نوع لوکوموتیو <span class="text-danger">*</span></label>
                            <select name="locomotive_type_id" class="form-select select2" required>
                                <option value="">انتخاب کنید</option>
                                <?php foreach ($locomotive_types as $type): ?>
                                    <option value="<?php echo $type['id']; ?>">
                                        <?php echo htmlspecialchars($type['name'] . ' - ' . $type['model']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">لطفاً نوع لوکوموتیو را انتخاب کنید</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">شماره سریال <span class="text-danger">*</span></label>
                            <input type="text" name="serial_number" class="form-control" required
                                   placeholder="مثال: GT-123456">
                            <div class="invalid-feedback">لطفاً شماره سریال را وارد کنید</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">کیلومتراژ فعلی</label>
                            <div class="input-group">
                                <input type="number" name="current_mileage" class="form-control" 
                                       min="0" step="1" placeholder="به کیلومتر">
                                <span class="input-group-text">کیلومتر</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- شرح خرابی -->
                <div class="row mb-4">
                    <div class="col-12">
                        <h6 class="section-title">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            شرح خرابی
                        </h6>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">علائم خرابی <span class="text-danger">*</span></label>
                            <textarea name="breakdown_symptoms" class="form-control" rows="3" required
                                    placeholder="لطفاً علائم و نشانه‌های خرابی را شرح دهید..."></textarea>
                            <div class="invalid-feedback">لطفاً علائم خرابی را شرح دهید</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">اقدامات انجام شده <span class="text-danger">*</span></label>
                            <textarea name="actions_taken" class="form-control" rows="3" required
                                    placeholder="اقدامات انجام شده برای رفع خرابی را شرح دهید..."></textarea>
                            <div class="invalid-feedback">لطفاً اقدامات انجام شده را شرح دهید</div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-3">
                            <label class="form-label">نتیجه نهایی</label>
                            <textarea name="final_result" class="form-control" rows="3"
                                    placeholder="نتیجه نهایی و توضیحات تکمیلی را وارد کنید..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- مستندات -->
                <div class="row">
                    <div class="col-12">
                        <h6 class="section-title">
                            <i class="bi bi-file-earmark me-2"></i>
                            مستندات
                        </h6>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">تصاویر خرابی</label>
                            <input type="file" name="images[]" class="form-control" accept="image/*" multiple
                                   data-max-files="5">
                            <div class="form-text">حداکثر 5 تصویر، هر تصویر حداکثر 2 مگابایت</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">فایل‌های پیوست</label>
                            <input type="file" name="attachments[]" class="form-control" multiple
                                   data-max-files="2">
                            <div class="form-text">حداکثر 2 فایل، هر فایل حداکثر 5 مگابایت</div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-2"></i>
                            ثبت گزارش
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* استایل‌های اضافی برای PWA و موبایل */
@media (max-width: 768px) {
    .container-fluid {
        padding: 0.5rem;
    }
    
    #railwayMap {
        height: 300px !important;
    }
    
    .card {
        border-radius: 0;
        box-shadow: none;
    }
    
    .form-control, .form-select {
        font-size: 16px; /* برای جلوگیری از زوم خودکار در iOS */
    }
}

/* Custom styles for select2 */
.select2-container--default .select2-selection--single {
    height: 38px;
    border-color: #dee2e6;
    border-radius: 0.375rem;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
    padding-right: 12px;
    padding-left: 12px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

/* استایل برای نقشه */
.leaflet-container {
    font-family: inherit !important;
}

.station-marker {
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
}

.station-marker.active {
    border-color: #0d6efd;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.7); }
    70% { box-shadow: 0 0 0 10px rgba(13, 110, 253, 0); }
    100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // ذخیره دیتای فایل‌های JSON
    let provinces = [];
    let cities = [];
    let railways = {};

    // لود فایل JSON استان‌ها
    fetch('<?php echo BASE_URL; ?>/assets/plugins/iran-cities/ostan.json')
        .then(response => response.json())
        .then(data => {
            provinces = data;
            // آپدیت سلکت باکس استان‌ها
            const provinceSelect = document.getElementById('province');
            provinceSelect.innerHTML = '<option value="">انتخاب کنید</option>';
            provinces.forEach(province => {
                provinceSelect.add(new Option(province.name, province.id));
            });
        })
        .catch(error => console.error('Error loading provinces:', error));

    // لود فایل JSON شهرها
    fetch('<?php echo BASE_URL; ?>/assets/plugins/iran-cities/shahr.json')
        .then(response => response.json())
        .then(data => {
            cities = data;
        })
        .catch(error => console.error('Error loading cities:', error));

    // لود فایل JSON ایستگاه‌ها
    fetch('<?php echo BASE_URL; ?>/assets/plugins/iran-cities/list-railway.json')
        .then(response => response.json())
        .then(data => {
            railways = data;
        })
        .catch(error => console.error('Error loading railway stations:', error));

    // تنظیمات Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        language: {
            noResults: function() {
                return "نتیجه‌ای یافت نشد";
            }
        }
    });

    // تنظیمات PersianDatepicker
    $('#occurrence_date').persianDatepicker({
        initialValue: false,
        format: 'YYYY/MM/DD HH:mm',
        altField: '#occurrence_date_alt',
        timePicker: {
            enabled: true,
            meridian: {
                enabled: false
            }
        },
        autoClose: true,
        onSelect: function(unix) {
            $('#occurrence_date').trigger('input');
        },
        navigator: {
            scroll: {
                enabled: false
            }
        },
        toolbox: {
            calendarSwitch: {
                enabled: false
            }
        },
        onlyTimePicker: false,
        responsive: true
    });

    // لود شهرها بر اساس استان
    $('#province').on('change', function() {
        const provinceId = parseInt($(this).val());
        const citySelect = $('#city');
        citySelect.empty().append('<option value="">انتخاب کنید</option>');
        
        if (provinceId && cities.length > 0) {
            // فیلتر شهرهای استان انتخاب شده
            const provinceCities = cities.filter(city => city.ostan === provinceId);
            provinceCities.forEach(city => {
                citySelect.append(new Option(city.name, city.id));
            });
        }
        
        citySelect.trigger('change');
    });

    // لود ایستگاه‌ها بر اساس شهر
    $('#city').on('change', function() {
        const cityId = parseInt($(this).val());
        const stationSelect = $('#station');
        stationSelect.empty().append('<option value="">انتخاب کنید</option>');
        
        if (cityId && cities.length > 0 && Object.keys(railways).length > 0) {
            const selectedCity = cities.find(c => c.id === cityId);
            if (selectedCity) {
                Object.values(railways).forEach(route => {
                    route.stations.forEach(station => {
                        if (station.city === selectedCity.name) {
                            const option = new Option(station.name, station.id);
                            if (!Array.from(stationSelect.options).some(opt => opt.text === station.name)) {
                                stationSelect.add(option);
                            }
                        }
                    });
                });
            }
        }
        
        stationSelect.trigger('change');
    });

    // اعتبارسنجی فرم
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        if (!form.checkValidity()) {
            event.preventDefault();
            event.stopPropagation();
            
            Swal.fire({
                icon: 'error',
                title: 'خطا!',
                text: 'لطفاً تمام فیلدهای الزامی را پر کنید',
                confirmButtonText: 'باشه'
            });
        }
        form.classList.add('was-validated');
    }, false);

    // اعتبارسنجی فایل‌ها
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const files = this.files;
            const maxFiles = parseInt(this.dataset.maxFiles);
            const maxSize = this.name === 'images[]' ? 2 : 5; // مگابایت

            if (files.length > maxFiles) {
                this.value = '';
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: `حداکثر تعداد فایل مجاز ${maxFiles} عدد است`,
                    confirmButtonText: 'باشه'
                });
                return;
            }

            for (let file of files) {
                if (file.size > maxSize * 1024 * 1024) {
                    this.value = '';
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا!',
                        text: `حجم هر فایل نباید بیشتر از ${maxSize} مگابایت باشد`,
                        confirmButtonText: 'باشه'
                    });
                    break;
                }
            }
        });
    });
});
</script>
<script src="<?php echo BASE_URL; ?>/assets/js/breakdown.js"></script>
<?php require_once 'views/layouts/footer.php'; ?>