<?php require_once 'views/layouts/header.php'; ?>

<div class="container-fluid py-4">
    <div class="row g-4">
        <!-- سایدبار -->
        <div class="col-lg-3">
            <?php require_once 'views/layouts/sidebar.php'; ?>
        </div>

        <!-- محتوای اصلی -->
        <div class="col-lg-9">
            <div class="card shadow-sm">
                <div class="card-header bg-light py-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">ویرایش خطا</h5>
                        <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-right me-1"></i>
                            بازگشت به لیست
                        </a>
                    </div>
                </div>
                
                <div class="card-body p-4">
                    <form action="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" 
                          method="POST" 
                          class="needs-validation" 
                          novalidate>
                        
                        <?php insert_csrf_token(); ?>
                        
                        <!-- اطلاعات اصلی -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">کد خطا <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="error_code" 
                                       class="form-control" 
                                       required
                                       value="<?php echo htmlspecialchars($error['error_code']); ?>">
                            </div>
                            
                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">شدت خطا <span class="text-danger">*</span></label>
                                <select name="severity" class="form-select" required>
                                    <option value="critical" <?php echo $error['severity'] === 'critical' ? 'selected' : ''; ?>>بحرانی</option>
                                    <option value="major" <?php echo $error['severity'] === 'major' ? 'selected' : ''; ?>>اصلی</option>
                                    <option value="minor" <?php echo $error['severity'] === 'minor' ? 'selected' : ''; ?>>جزئی</option>
                                    <option value="warning" <?php echo $error['severity'] === 'warning' ? 'selected' : ''; ?>>هشدار</option>
                                </select>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                                <select name="category" class="form-select" required>
                                    <option value="">انتخاب کنید</option>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?php echo $cat['id']; ?>" 
                                                <?php echo $error['category'] == $cat['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($cat['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-12">
                                <label class="form-label">توضیحات <span class="text-danger">*</span></label>
                                <textarea name="description" 
                                          class="form-control" 
                                          rows="3" 
                                          required><?php echo htmlspecialchars($error['description']); ?></textarea>
                            </div>
                        </div>

                        <!-- اطلاعات لوکوموتیو -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-12 mb-2">
                                <h6 class="fw-bold text-muted">اطلاعات لوکوموتیو</h6>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">نوع لوکوموتیو <span class="text-danger">*</span></label>
                                <select name="locomotive_type" class="form-select" required>
                                    <option value="">انتخاب کنید</option>
                                    <?php foreach ($locomotive_types as $type): ?>
                                        <option value="<?php echo $type['id']; ?>" 
                                                <?php echo $error['locomotive_type'] == $type['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($type['name'] . ' - ' . $type['model']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">قطعه <span class="text-danger">*</span></label>
                                <input type="text" 
                                       name="component" 
                                       class="form-control" 
                                       required
                                       value="<?php echo htmlspecialchars($error['component']); ?>">
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">زیر قطعه</label>
                                <input type="text" 
                                       name="sub_component" 
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($error['sub_component'] ?? ''); ?>">
                            </div>
                        </div>

                        <!-- علائم و تشخیص -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-12 mb-2">
                                <h6 class="fw-bold text-muted">علائم و تشخیص</h6>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">علائم</label>
                                <textarea name="symptoms" 
                                          class="form-control" 
                                          rows="3"><?php echo htmlspecialchars($error['symptoms'] ?? ''); ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">علت</label>
                                <textarea name="cause" 
                                          class="form-control" 
                                          rows="3"><?php echo htmlspecialchars($error['cause'] ?? ''); ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">مراحل تشخیص</label>
                                <textarea name="diagnosis_steps" 
                                          class="form-control" 
                                          rows="3"><?php echo htmlspecialchars($error['diagnosis_steps'] ?? ''); ?></textarea>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">مراحل رفع خطا</label>
                                <textarea name="solution_steps" 
                                          class="form-control" 
                                          rows="3"><?php echo htmlspecialchars($error['solution_steps'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <!-- اطلاعات تعمیر -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-12 mb-2">
                                <h6 class="fw-bold text-muted">اطلاعات تعمیر</h6>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">ابزار مورد نیاز</label>
                                <input type="text" 
                                       name="required_tools" 
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($error['required_tools'] ?? ''); ?>">
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">قطعات مورد نیاز</label>
                                <input type="text" 
                                       name="required_parts" 
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($error['required_parts'] ?? ''); ?>">
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <label class="form-label">زمان تقریبی تعمیر</label>
                                <input type="text" 
                                       name="estimated_repair_time" 
                                       class="form-control"
                                       value="<?php echo htmlspecialchars($error['estimated_repair_time'] ?? ''); ?>">
                            </div>
                        </div>

                        <!-- نکات ایمنی -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-12 mb-2">
                                <h6 class="fw-bold text-muted">نکات ایمنی</h6>
                            </div>

                            <div class="col-12">
                                <textarea name="safety_notes" 
                                          class="form-control" 
                                          rows="3"><?php echo htmlspecialchars($error['safety_notes'] ?? ''); ?></textarea>
                            </div>
                        </div>

                        <!-- دکمه‌های فرم -->
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check2-circle me-1"></i>
                                ذخیره تغییرات
                            </button>
                            <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle me-1"></i>
                                انصراف
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* استایل‌های اختصاصی */
.form-label {
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
    color: #4b5563;
}

.card {
    border: none;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
    transition: box-shadow 0.3s ease-in-out;
}

.card:hover {
    box-shadow: 0 4px 6px rgba(0,0,0,0.12), 0 2px 4px rgba(0,0,0,0.24);
}

.form-control, .form-select {
    font-size: 0.875rem;
    padding: 0.5rem 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #3b82f6;
    box-shadow: 0 0 0 0.2rem rgba(59, 130, 246, 0.25);
}

textarea.form-control {
    min-height: 100px;
}

@media (max-width: 576px) {
    .card-body {
        padding: 1rem;
    }
}
</style>

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
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>

<?php require_once 'views/layouts/footer.php'; ?>