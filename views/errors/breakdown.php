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
                            <input type="text" name="occurrence_date" id="occurrence_date" 
                                   class="form-control" required 
                                   placeholder="مثال: 1402/12/29 14:30"
                                   pattern="\d{4}/\d{2}/\d{2} \d{2}:\d{2}">
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
                            <input type="number" name="current_mileage" class="form-control" 
                                   min="0" step="1" placeholder="به کیلومتر">
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
                            <label class="form-label">تصاویر</label>
                            <input type="file" name="images[]" class="form-control" multiple
                                   accept="image/jpeg,image/png,image/gif">
                            <div class="form-text">
                                حداکثر 5 تصویر با فرمت JPG، PNG یا GIF (هر تصویر حداکثر 2MB)
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">فیلم</label>
                            <input type="file" name="videos[]" class="form-control" multiple
                                   accept="video/mp4,video/webm">
                            <div class="form-text">
                                حداکثر 2 فیلم با فرمت MP4 یا WebM (هر فیلم حداکثر 50MB)
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <!-- دکمه‌های فرم -->
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save me-1"></i>
                            ثبت گزارش خرابی
                        </button>
                        <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-secondary me-2">
                            <i class="bi bi-x-circle me-1"></i>
                            انصراف
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- استایل‌های اختصاصی -->
<style>
.section-title {
    color: #2c3345;
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    padding-bottom: 0.5rem;
    border-bottom: 2px solid #e9ecef;
}

.form-label {
    font-weight: 500;
    color: #2c3345;
}

.select2-container--default .select2-selection--single {
    border: 1px solid #dee2e6;
    border-radius: var(--border-radius);
    height: 38px;
    padding: 0.375rem 0.75rem;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

/* فایل آپلود */
.custom-file-input::-webkit-file-upload-button {
    visibility: hidden;
}

.custom-file-input::before {
    content: 'انتخاب فایل';
    display: inline-block;
    background: linear-gradient(top, #f9f9f9, #e3e3e3);
    border: 1px solid #999;
    border-radius: 3px;
    padding: 5px 8px;
    outline: none;
    white-space: nowrap;
    cursor: pointer;
    text-shadow: 1px 1px #fff;
    font-weight: 700;
    font-size: 10pt;
}

.custom-file-input:hover::before {
    border-color: black;
}

.custom-file-input:active::before {
    background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
}
</style>

<!-- اسکریپت‌های اختصاصی -->
<script>
$(document).ready(function() {
    // راه‌اندازی Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        dir: 'rtl'
    });

    // لود شهرها بر اساس استان
    $('#province').on('change', function() {
        const provinceId = $(this).val();
        if (provinceId) {
            $.get(`<?php echo BASE_URL; ?>/api/cities/${provinceId}`, function(cities) {
                let options = '<option value="">انتخاب کنید</option>';
                cities.forEach(city => {
                    options += `<option value="${city.id}">${city.name}</option>`;
                });
                $('#city').html(options).trigger('change');
            });
        } else {
            $('#city').html('<option value="">ابتدا استان را انتخاب کنید</option>').trigger('change');
        }
    });

    // لود ایستگاه‌ها بر اساس شهر
    $('#city').on('change', function() {
        const cityId = $(this).val();
        if (cityId) {
            $.get(`<?php echo BASE_URL; ?>/api/stations/${cityId}`, function(stations) {
                let options = '<option value="">انتخاب کنید</option>';
                stations.forEach(station => {
                    options += `<option value="${station.id}">${station.name}</option>`;
                });
                $('#station').html(options).trigger('change');
            });
        } else {
            $('#station').html('<option value="">ابتدا شهر را انتخاب کنید</option>').trigger('change');
        }
    });

    // تنظیم DateTimePicker برای تاریخ و ساعت
    $('#occurrence_date').persianDatepicker({
        format: 'YYYY/MM/DD HH:mm',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            }
        },
        initialValue: false,
        autoClose: true,
        onlyTimePicker: false,
        onSelect: function() {
            $('#occurrence_date').trigger('input');
        }
    });

    // اعتبارسنجی فایل‌ها
    $('input[type="file"]').on('change', function() {
        const files = this.files;
        const maxFiles = $(this).attr('name') === 'images[]' ? 5 : 2;
        const maxSize = $(this).attr('name') === 'images[]' ? 2 * 1024 * 1024 : 50 * 1024 * 1024;
        
        if (files.length > maxFiles) {
            alert(`حداکثر ${maxFiles} فایل می‌توانید انتخاب کنید`);
            this.value = '';
            return;
        }

        for (let i = 0; i < files.length; i++) {
            if (files[i].size > maxSize) {
                alert(`حجم فایل ${files[i].name} بیشتر از حد مجاز است`);
                this.value = '';
                return;
            }
        }
    });

    // اعتبارسنجی فرم
    (function () {
        'use strict'
        const form = document.querySelector('.needs-validation');
        
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    })();
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>