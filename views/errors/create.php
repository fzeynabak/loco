<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">راهنمای ثبت خطا</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h6 class="alert-heading">نکات مهم:</h6>
                        <ul class="mb-0">
                            <li>کد خطا باید منحصر به فرد باشد</li>
                            <li>تمامی فیلدهای ستاره‌دار الزامی هستند</li>
                            <li>توضیحات دقیق و کامل وارد کنید</li>
                            <li>مراحل تشخیص و رفع خطا را گام به گام بنویسید</li>
                            <li>در صورت وجود نقشه فنی یا ویدیو، آن‌ها را آپلود کنید</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">افزودن خطای جدید</h5>
                    <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-secondary">
                        <i class="bi bi-arrow-right"></i> بازگشت به لیست
                    </a>
                </div>
                <div class="card-body">
                    <form action="<?php echo BASE_URL; ?>/errors/create" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                        <div class="row">
                            <!-- اطلاعات اصلی -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">کد خطا *</label>
                                    <input type="text" name="error_code" class="form-control" required>
                                    <div class="invalid-feedback">کد خطا الزامی است</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">شدت خطا *</label>
                                    <select name="severity" class="form-select" required>
                                        <option value="">انتخاب کنید</option>
                                        <option value="critical">بحرانی</option>
                                        <option value="major">اصلی</option>
                                        <option value="minor">جزئی</option>
                                        <option value="warning">هشدار</option>
                                    </select>
                                    <div class="invalid-feedback">شدت خطا را انتخاب کنید</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">دسته‌بندی *</label>
                                    <select name="category" class="form-select" required>
                                        <option value="">انتخاب کنید</option>
                                        <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category['id']; ?>">
                                                <?php echo htmlspecialchars($category['name']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">دسته‌بندی را انتخاب کنید</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">نوع لوکوموتیو *</label>
                                    <select name="locomotive_type" class="form-select" required>
                                        <option value="">انتخاب کنید</option>
                                        <?php foreach ($locomotive_types as $type): ?>
                                            <option value="<?php echo $type['id']; ?>">
                                                <?php echo htmlspecialchars($type['name'] . ' - ' . $type['model']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">نوع لوکوموتیو را انتخاب کنید</div>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">قطعه اصلی *</label>
                                    <input type="text" name="component" class="form-control" required>
                                    <div class="invalid-feedback">قطعه اصلی الزامی است</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">زیر قطعه</label>
                                    <input type="text" name="sub_component" class="form-control">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">زمان تقریبی تعمیر</label>
                                    <input type="text" name="estimated_repair_time" class="form-control" 
                                           placeholder="مثال: 2-3 ساعت">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">اولویت قطعات یدکی</label>
                                    <select name="parts_priority" class="form-select">
                                        <option value="">انتخاب کنید</option>
                                        <option value="high">ضروری - نیاز فوری</option>
                                        <option value="medium">متوسط - نیاز در آینده نزدیک</option>
                                        <option value="low">کم - موجودی احتیاطی</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">علت خطا *</label>
                                <textarea name="cause" class="form-control" rows="4" required></textarea>
                                <div class="invalid-feedback">علت خطا الزامی است</div>
                            </div>
                            <!-- توضیحات خطا -->
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">شرح خطا *</label>
                                    <textarea name="description" class="form-control" rows="4" required></textarea>
                                    <div class="invalid-feedback">شرح خطا الزامی است</div>
                                </div>
                            </div>
                            
                            <!-- علائم و تشخیص -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">علائم خطا *</label>
                                    <textarea name="symptoms" class="form-control" rows="4" required></textarea>
                                    <div class="invalid-feedback">علائم خطا الزامی است</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">مراحل تشخیص *</label>
                                    <textarea name="diagnosis_steps" class="form-control" rows="4" required></textarea>
                                    <div class="invalid-feedback">مراحل تشخیص الزامی است</div>
                                </div>
                            </div>
                            
                            <!-- راه حل و پیشگیری -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">مراحل رفع خطا *</label>
                                    <textarea name="solution_steps" class="form-control" rows="4" required></textarea>
                                    <div class="invalid-feedback">مراحل رفع خطا الزامی است</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">اقدامات پیشگیرانه</label>
                                    <textarea name="prevention_steps" class="form-control" rows="4"></textarea>
                                </div>
                            </div>
                            
                            <!-- ابزار و قطعات -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">ابزار مورد نیاز</label>
                                    <textarea name="required_tools" class="form-control" rows="3"
                                              placeholder="هر ابزار را در یک خط بنویسید"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">قطعات یدکی مورد نیاز</label>
                                    <textarea name="required_parts" class="form-control" rows="3"
                                              placeholder="نام قطعه - کد فنی - تعداد"></textarea>
                                </div>
                            </div>
                            
                            <!-- نکات ایمنی و فایل‌ها -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">نکات ایمنی</label>
                                    <textarea name="safety_notes" class="form-control" rows="3"></textarea>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">نقشه فنی</label>
                                    <input type="file" name="technical_diagram" class="form-control" 
                                           accept="image/*">
                                    <div class="form-text">فرمت‌های مجاز: JPG، PNG، PDF</div>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">ویدیوی راهنما</label>
                                    <input type="file" name="video_guide" class="form-control" 
                                           accept="video/mp4,video/webm">
                                    <div class="form-text">حداکثر حجم: 50MB</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> ثبت خطا
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// اعتبارسنجی فرم
(function () {
    'use strict'
    var forms = document.querySelectorAll('.needs-validation')
    Array.prototype.slice.call(forms)
        .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                    
                    // نمایش پیام خطا
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا!',
                        text: 'لطفاً تمام فیلدهای الزامی را پر کنید.',
                        confirmButtonText: 'باشه'
                    });
                }
                form.classList.add('was-validated')
            }, false)
        })
})()

// محدودیت حجم فایل
document.querySelector('input[name="video_guide"]').addEventListener('change', function() {
    if (this.files[0].size > 50 * 1024 * 1024) {
        this.value = '';
        Swal.fire({
            icon: 'error',
            title: 'خطا!',
            text: 'حجم فایل ویدیو نباید بیشتر از 50 مگابایت باشد.',
            confirmButtonText: 'باشه'
        });
    }
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>