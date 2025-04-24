<?php require_once 'views/layouts/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            <!-- نمایش درختی خطا -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">ساختار درختی خطا</h5>
                </div>
                <div class="card-body">
                    <div id="error-tree"></div>
                </div>
            </div>
            
            <!-- اطلاعات ثبت و بروزرسانی -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">اطلاعات سیستمی</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">ثبت کننده:</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($error['created_by_name']); ?></dd>
                        
                        <dt class="col-sm-4">تاریخ ثبت:</dt>
                        <dd class="col-sm-8"><?php echo format_date($error['created_at']); ?></dd>
                        
                        <?php if ($error['updated_by']): ?>
                            <dt class="col-sm-4">آخرین ویرایش:</dt>
                            <dd class="col-sm-8"><?php echo htmlspecialchars($error['updated_by_name']); ?></dd>
                            
                            <dt class="col-sm-4">تاریخ ویرایش:</dt>
                            <dd class="col-sm-8"><?php echo format_date($error['updated_at']); ?></dd>
                        <?php endif; ?>
                    </dl>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">جزئیات خطا: <?php echo htmlspecialchars($error['error_code']); ?></h5>
                    <div>
                        <?php if (is_admin() || has_permission('edit_error')): ?>
                            <a href="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" class="btn btn-warning">
                                <i class="bi bi-pencil"></i> ویرایش
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-secondary">
                            <i class="bi bi-arrow-right"></i> بازگشت به لیست
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 150px;">کد خطا:</th>
                                    <td><?php echo htmlspecialchars($error['error_code']); ?></td>
                                </tr>
                                <tr>
                                    <th>شدت خطا:</th>
                                    <td>
                                        <span class="badge bg-<?php
                                            echo match($error['severity']) {
                                                'critical' => 'danger',
                                                'major' => 'warning',
                                                'minor' => 'info',
                                                'warning' => 'secondary',
                                                default => 'primary'
                                            };
                                        ?>">
                                            <?php echo get_severity_label($error['severity']); ?>
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>نوع لوکوموتیو:</th>
                                    <td><?php echo htmlspecialchars($error['locomotive_type']); ?></td>
                                </tr>
                                <tr>
                                    <th>قطعه اصلی:</th>
                                    <td><?php echo htmlspecialchars($error['component']); ?></td>
                                </tr>
                                <tr>
                                    <th>زیر قطعه:</th>
                                    <td><?php echo htmlspecialchars($error['sub_component'] ?? '-'); ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-striped">
                                <tr>
                                    <th style="width: 150px;">دسته‌بندی:</th>
                                    <td><?php echo htmlspecialchars($error['category']); ?></td>
                                </tr>
                                <tr>
                                    <th>زمان تعمیر:</th>
                                    <td><?php echo htmlspecialchars($error['estimated_repair_time'] ?? '-'); ?></td>
                                </tr>
                                <tr>
                                    <th>ابزار مورد نیاز:</th>
                                    <td><?php echo nl2br(htmlspecialchars($error['required_tools'] ?? '-')); ?></td>
                                </tr>
                                <tr>
                                    <th>قطعات یدکی:</th>
                                    <td><?php echo nl2br(htmlspecialchars($error['required_parts'] ?? '-')); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#description" type="button">شرح خطا</button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#symptoms" type="button">علائم</button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#diagnosis" type="button">تشخیص</button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#solution" type="button">راه حل</button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#prevention" type="button">پیشگیری</button>
                                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#safety" type="button">نکات ایمنی</button>
                                    <?php if ($error['technical_diagram'] || $error['video_guide']): ?>
                                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#media" type="button">رسانه</button>
                                    <?php endif; ?>
                                </div>
                            </nav>
                            <div class="tab-content mt-3">
                                <div class="tab-pane fade show active" id="description">
                                    <?php echo nl2br(htmlspecialchars($error['description'])); ?>
                                </div>
                                <div class="tab-pane fade" id="symptoms">
                                    <?php echo nl2br(htmlspecialchars($error['symptoms'])); ?>
                                </div>
                                <div class="tab-pane fade" id="diagnosis">
                                    <?php echo nl2br(htmlspecialchars($error['diagnosis_steps'])); ?>
                                </div>
                                <div class="tab-pane fade" id="solution">
                                    <?php echo nl2br(htmlspecialchars($error['solution_steps'])); ?>
                                </div>
                                <div class="tab-pane fade" id="prevention">
                                    <?php echo nl2br(htmlspecialchars($error['prevention_steps'] ?? 'اطلاعاتی ثبت نشده است.')); ?>
                                                </div>
                                <div class="tab-pane fade" id="safety">
                                    <?php echo nl2br(htmlspecialchars($error['safety_notes'] ?? 'اطلاعاتی ثبت نشده است.')); ?>
                                </div>
                                <?php if ($error['technical_diagram'] || $error['video_guide']): ?>
                                    <div class="tab-pane fade" id="media">
                                        <div class="row">
                                            <?php if ($error['technical_diagram']): ?>
                                                <div class="col-md-6 mb-3">
                                                    <h6>نقشه فنی:</h6>
                                                    <img src="<?php echo BASE_URL . '/uploads/diagrams/' . $error['technical_diagram']; ?>" 
                                                         class="img-fluid" 
                                                         alt="نقشه فنی">
                                                </div>
                                            <?php endif; ?>
                                            
                                            <?php if ($error['video_guide']): ?>
                                                <div class="col-md-6 mb-3">
                                                    <h6>ویدیوی راهنما:</h6>
                                                    <div class="ratio ratio-16x9">
                                                        <video controls>
                                                            <source src="<?php echo BASE_URL . '/uploads/videos/' . $error['video_guide']; ?>" type="video/mp4">
                                                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                                        </video>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- تاریخچه تعمیرات -->
                    <?php if ($error['maintenance_history']): ?>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>تاریخچه تعمیرات</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>تاریخ</th>
                                                <th>شرح تعمیرات</th>
                                                <th>قطعات تعویضی</th>
                                                <th>تعمیرکار</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $maintenance_history = json_decode($error['maintenance_history'], true);
                                            if (is_array($maintenance_history)):
                                                foreach ($maintenance_history as $record): 
                                            ?>
                                                <tr>
                                                    <td><?php echo format_date($record['date']); ?></td>
                                                    <td><?php echo htmlspecialchars($record['description']); ?></td>
                                                    <td><?php echo htmlspecialchars($record['parts'] ?? '-'); ?></td>
                                                    <td><?php echo htmlspecialchars($record['technician']); ?></td>
                                                </tr>
                                            <?php 
                                                endforeach;
                                            endif;
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- اضافه کردن کتابخانه jsTree -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

<script>
$(document).ready(function() {
    // ساختار درختی خطا
    $('#error-tree').jstree({
        'core': {
            'data': [
                {
                    'text': '<?php echo htmlspecialchars($error['locomotive_type']); ?>',
                    'icon': 'bi bi-train-front',
                    'state': { 'opened': true },
                    'children': [
                        {
                            'text': '<?php echo htmlspecialchars($error['component']); ?>',
                            'icon': 'bi bi-gear',
                            'children': [
                                <?php if ($error['sub_component']): ?>
                                {
                                    'text': '<?php echo htmlspecialchars($error['sub_component']); ?>',
                                    'icon': 'bi bi-gear-fill',
                                    'children': [
                                        {
                                            'text': '<?php echo htmlspecialchars($error['error_code']); ?>',
                                            'icon': 'bi bi-exclamation-triangle-fill text-danger'
                                        }
                                    ]
                                }
                                <?php else: ?>
                                {
                                    'text': '<?php echo htmlspecialchars($error['error_code']); ?>',
                                    'icon': 'bi bi-exclamation-triangle-fill text-danger'
                                }
                                <?php endif; ?>
                            ]
                        }
                    ]
                }
            ]
        }
    });
    
    // نمایش تب‌ها با کلیک روی لینک‌های مربوطه
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        history.pushState({}, '', $(this).attr('href'));
    });
    
    // نمایش تب فعال بر اساس هش URL
    let hash = window.location.hash;
    if (hash) {
        $('.nav-tabs a[href="' + hash + '"]').tab('show');
    }
});

// بزرگنمایی تصاویر
document.querySelectorAll('.tab-pane img').forEach(image => {
    image.addEventListener('click', () => {
        Swal.fire({
            imageUrl: image.src,
            imageAlt: 'نقشه فنی',
            width: '90%',
            confirmButtonText: 'بستن'
        });
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>