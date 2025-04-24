<?php require_once 'views/layouts/main.php'; ?>

<div class="row">
    <!-- سایدبار -->
    <div class="col-md-3">
        <?php require_once 'views/layouts/sidebar.php'; ?>
    </div>

    <!-- محتوای اصلی -->
    <div class="col-md-9">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">ویرایش خطا</h5>
            </div>
            <div class="card-body">
                <form action="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" method="POST" class="needs-validation" novalidate>
                    <?php insert_csrf_token(); ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">کد خطا <span class="text-danger">*</span></label>
                            <input type="text" name="error_code" class="form-control" required
                                   value="<?php echo htmlspecialchars($error['error_code']); ?>">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">شدت خطا <span class="text-danger">*</span></label>
                            <select name="severity" class="form-select" required>
                                <option value="critical" <?php echo $error['severity'] === 'critical' ? 'selected' : ''; ?>>بحرانی</option>
                                <option value="major" <?php echo $error['severity'] === 'major' ? 'selected' : ''; ?>>اصلی</option>
                                <option value="minor" <?php echo $error['severity'] === 'minor' ? 'selected' : ''; ?>>جزئی</option>
                                <option value="warning" <?php echo $error['severity'] === 'warning' ? 'selected' : ''; ?>>هشدار</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">توضیحات <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($error['description']); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">دسته‌بندی <span class="text-danger">*</span></label>
                            <select name="category" class="form-select" required>
                                <option value="">انتخاب کنید</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo $error['category'] == $cat['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">نوع لوکوموتیو <span class="text-danger">*</span></label>
                            <select name="locomotive_type" class="form-select" required>
                                <option value="">انتخاب کنید</option>
                                <?php foreach ($locomotive_types as $type): ?>
                                    <option value="<?php echo $type['id']; ?>" <?php echo $error['locomotive_type'] == $type['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($type['name'] . ' - ' . $type['model']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">قطعه <span class="text-danger">*</span></label>
                            <input type="text" name="component" class="form-control" required
                                   value="<?php echo htmlspecialchars($error['component']); ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">زیر قطعه</label>
                            <input type="text" name="sub_component" class="form-control"
                                   value="<?php echo htmlspecialchars($error['sub_component'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">علائم</label>
                        <textarea name="symptoms" class="form-control" rows="3"><?php echo htmlspecialchars($error['symptoms'] ?? ''); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">علت</label>
                        <textarea name="cause" class="form-control" rows="3"><?php echo htmlspecialchars($error['cause'] ?? ''); ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">مراحل تشخیص</label>
                            <textarea name="diagnosis_steps" class="form-control" rows="3"><?php echo htmlspecialchars($error['diagnosis_steps'] ?? ''); ?></textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">مراحل رفع خطا</label>
                            <textarea name="solution_steps" class="form-control" rows="3"><?php echo htmlspecialchars($error['solution_steps'] ?? ''); ?></textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">ابزار مورد نیاز</label>
                            <input type="text" name="required_tools" class="form-control"
                                   value="<?php echo htmlspecialchars($error['required_tools'] ?? ''); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">قطعات مورد نیاز</label>
                            <input type="text" name="required_parts" class="form-control"
                                   value="<?php echo htmlspecialchars($error['required_parts'] ?? ''); ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">زمان تقریبی تعمیر</label>
                            <input type="text" name="estimated_repair_time" class="form-control"
                                   value="<?php echo htmlspecialchars($error['estimated_repair_time'] ?? ''); ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">نکات ایمنی</label>
                        <textarea name="safety_notes" class="form-control" rows="3"><?php echo htmlspecialchars($error['safety_notes'] ?? ''); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check2-circle me-1"></i>
                            ذخیره تغییرات
                        </button>
                        <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right me-1"></i>
                            بازگشت
                        </a>
                    </div>
                </form>
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
                }
                form.classList.add('was-validated')
            }, false)
        })
})()
</script>