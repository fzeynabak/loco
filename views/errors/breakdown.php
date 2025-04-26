<?php require_once 'views/layouts/main.php'; ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.css">
<script src="https://cdn.jsdelivr.net/npm/@majidh1/jalalidatepicker/dist/jalalidatepicker.min.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script src="<?php echo BASE_URL; ?>/assets/js/railway-map.js"></script>
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
                            <select name="province_id" id="province" class="form-select" required>
                                <option value="">انتخاب کنید</option>
                            </select>
                            <div class="invalid-feedback">لطفاً استان را انتخاب کنید</div>
                        </div>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">شهر <span class="text-danger">*</span></label>
                            <select name="city_id" id="city" class="form-select" required>
                                <option value="">ابتدا استان را انتخاب کنید</option>
                            </select>
                            <div class="invalid-feedback">لطفاً شهر را انتخاب کنید</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">ایستگاه <span class="text-danger">*</span></label>
                            <select name="station_id" id="station" class="form-select" required>
                                <option value="">ابتدا شهر را انتخاب کنید</option>
                            </select>
                            <div class="invalid-feedback">لطفاً ایستگاه را انتخاب کنید</div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">تاریخ <span class="text-danger">*</span></label>
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
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">ساعت <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" 
                                    name="occurrence_time" 
                                    id="occurrence_time" 
                                    class="form-control" 
                                    required 
                                    pattern="^([0-1]?[0-9]|2[0-3]):[0-5][0-9]$"
                                    placeholder="مثال: 14:30">
                                <span class="input-group-text"><i class="bi bi-clock"></i></span>
                            </div>
                            <div class="invalid-feedback">لطفاً ساعت را به فرمت صحیح وارد کنید (مثال: 14:30)</div>
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
                            <select name="locomotive_type_id" class="form-select" required>
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
        font-size: 16px;
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
/* استایل نقشه */
#railwayMap {
    width: 100%;
    height: 400px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
    box-shadow: 0 .125rem .25rem rgba(0,0,0,.075);
}

/* استایل مسیرهای راه آهن */
.railway-line {
    stroke-dasharray: 2, 10;
    animation: dash 20s linear infinite;
}

@keyframes dash {
    to {
        stroke-dashoffset: -1000;
    }
}

/* استایل نقاط ایستگاه */
.station-marker {
    background: transparent;
}

.station-point {
    width: 100%;
    height: 100%;
    background: #3498db;
    border: 2px solid #fff;
    border-radius: 50%;
    box-shadow: 0 0 10px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
}

.station-marker.active .station-point {
    background: #e74c3c;
    transform: scale(1.2);
}

/* استایل پاپ‌آپ ایستگاه */
.station-popup {
    text-align: right;
    direction: rtl;
    padding: 5px;
}

/* استایل Select2 */
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

/* استایل‌های موبایل */
@media (max-width: 768px) {
    #railwayMap {
        height: 300px;
    }
}
</style>

<!-- تعریف متغیر BASE_URL برای استفاده در اسکریپت -->
<script>
    const BASE_URL = '<?php echo BASE_URL; ?>';
</script>
// جایگزین کردن اسکریپت قبلی با این کد
<script>

</script>

<?php require_once 'views/layouts/footer.php'; ?>