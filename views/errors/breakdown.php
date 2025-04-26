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
                            <label class="form-label">تاریخ و ساعت <span class="text-danger">*</span></label>
                            <input type="text" 
                                name="occurrence_date" 
                                id="occurrence_date" 
                                data-jdp 
                                class="form-control" 
                                placeholder="انتخاب کنید" 
                                required 
                                autocomplete="off">
                            <div class="invalid-feedback">لطفاً تاریخ و ساعت را به فرمت صحیح وارد کنید</div>
                        </div>
                    </div>
                </div>
        <input type="hidden" id="occurrence_date_alt" name="occurrence_date_timestamp">

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
</style>

<!-- تعریف متغیر BASE_URL برای استفاده در اسکریپت -->
<script>
    const BASE_URL = '<?php echo BASE_URL; ?>';
</script>
// جایگزین کردن اسکریپت قبلی با این کد
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تنظیمات تاریخ
    let selectedDate = null;
    
    // ایجاد تقویم شمسی با استفاده از persianDatepicker
    $('#occurrence_date').persianDatepicker({
        format: 'YYYY/MM/DD',
        initialValue: false,
        autoClose: true,
        toolbox: {
            calendarSwitch: {
                enabled: false
            }
        },
        dayPicker: {
            onSelect: function(unix) {
                selectedDate = unix;
                updateTimestamp();
            }
        },
        observer: true,
        onSelect: function(unix) {
            selectedDate = unix;
            updateTimestamp();
        }
    });

    // مدیریت ورودی ساعت
    const timeInput = document.getElementById('occurrence_time');
    timeInput.addEventListener('input', function(e) {
        let value = e.target.value;
        
        // اضافه کردن : بعد از ساعت
        if (value.length === 2 && !value.includes(':')) {
            value += ':';
            e.target.value = value;
        }
        
        // اعتبارسنجی فرمت ساعت
        if (value.length === 5) {
            const [hours, minutes] = value.split(':');
            if (hours >= 0 && hours < 24 && minutes >= 0 && minutes < 60) {
                updateTimestamp();
            }
        }
    });

    // آپدیت timestamp
    function updateTimestamp() {
        if (selectedDate && timeInput.value) {
            const [hours, minutes] = timeInput.value.split(':');
            const date = new persianDate(selectedDate);
            date.hour(parseInt(hours));
            date.minute(parseInt(minutes));
            document.getElementById('occurrence_timestamp').value = date.unix();
        }
    }

    // تنظیمات نقشه
    const map = L.map('railwayMap').setView([35.6892, 51.3890], 6);
    
    // اضافه کردن لایه نقشه
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);

    // آرایه برای نگهداری مارکرها
    let markers = [];
    let railwayPath = null;
    let selectedMarker = null;

    // لود مسیرهای ریلی
    fetch(BASE_URL + '/assets/plugins/iran-cities/list-railway.json')
        .then(response => response.json())
        .then(railways => {
            Object.values(railways).forEach(route => {
                const coordinates = [];
                route.stations.forEach(station => {
                    // اضافه کردن مختصات هر ایستگاه
                    const stationCoords = getStationCoordinates(station.name);
                    if (stationCoords) {
                        coordinates.push(stationCoords);
                        
                        // ایجاد مارکر برای هر ایستگاه
                        const marker = L.marker(stationCoords, {
                            icon: L.divIcon({
                                className: 'station-marker',
                                html: `<div class="marker-pin"></div>`,
                                iconSize: [30, 30],
                                iconAnchor: [15, 15]
                            })
                        })
                        .bindPopup(station.name)
                        .addTo(map);
                        
                        markers.push(marker);
                    }
                });

                // رسم خط ریلی بین ایستگاه‌ها
                if (coordinates.length > 1) {
                    railwayPath = L.polyline(coordinates, {
                        color: '#2563eb',
                        weight: 3,
                        opacity: 0.8
                    }).addTo(map);
                }
            });

            // تنظیم zoom به اندازه مناسب
            if (railwayPath) {
                map.fitBounds(railwayPath.getBounds());
            }
        })
        .catch(error => console.error('خطا در لود مسیرهای ریلی:', error));

    // تابع برای گرفتن مختصات ایستگاه‌ها
    function getStationCoordinates(stationName) {
        // مختصات ایستگاه‌های اصلی (به عنوان مثال)
        const coordinates = {
            'تهران': [35.6892, 51.3890],
            'گرمسار': [35.2182, 52.3409],
            'سمنان': [35.2282, 53.3915],
            'دامغان': [36.1680, 54.3480],
            'شاهرود': [36.4182, 54.9763],
            'میامی': [36.4097, 55.6542],
            'سبزوار': [36.2152, 57.6678],
            'نیشابور': [36.2146, 58.7958],
            'مشهد': [36.2605, 59.6168]
        };
        return coordinates[stationName];
    }

    // اضافه کردن قابلیت کلیک روی مسیر برای انتخاب محل خرابی
    map.on('click', function(e) {
        // حذف مارکر قبلی اگر وجود داشته باشد
        if (selectedMarker) {
            map.removeLayer(selectedMarker);
        }

        // ایجاد مارکر جدید
        selectedMarker = L.marker(e.latlng, {
            icon: L.divIcon({
                className: 'breakdown-marker',
                html: '<div class="marker-pin breakdown"></div>',
                iconSize: [30, 30],
                iconAnchor: [15, 15]
            })
        }).addTo(map);

        // ذخیره موقعیت در input مخفی
        document.getElementById('selected_location').value = `${e.latlng.lat},${e.latlng.lng}`;
    });

    // اضافه کردن استایل برای مارکرها
    const style = document.createElement('style');
    style.textContent = `
        .marker-pin {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: #2563eb;
            border: 2px solid #fff;
            box-shadow: 0 0 4px rgba(0,0,0,0.3);
        }
        .marker-pin.breakdown {
            background: #dc2626;
            animation: pulse 1.5s infinite;
        }
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
    `;
    document.head.appendChild(style);
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>