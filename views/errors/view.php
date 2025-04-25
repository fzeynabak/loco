<?php require_once 'views/layouts/header.php'; ?>

<!-- تصویر سراسری در بالای صفحه -->
<div class="error-header position-relative" style="height: 250px; overflow: hidden;">
    <img src="<?php echo BASE_URL; ?>/assets/img/locomotive-banner.jpg" 
         class="w-100 h-100" 
         style="object-fit: cover; filter: brightness(0.7);"
         alt="تصویر سراسری لوکوموتیو">
    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center">
        <div class="text-center text-white">
            <h1 class="display-4 mb-0"><?php echo htmlspecialchars($error['error_code']); ?></h1>
            <p class="lead mb-0"><?php echo htmlspecialchars($error['locomotive_type']); ?></p>
        </div>
    </div>
</div>

<div class="container-fluid mt-n5 px-4">
    <div class="row">
        <!-- ستون سمت راست - اطلاعات اصلی -->
        <div class="col-md-3">
            <!-- کارت وضعیت -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <span class="badge bg-<?php
                            echo match($error['severity']) {
                                'critical' => 'danger',
                                'major' => 'warning',
                                'minor' => 'info',
                                'warning' => 'secondary',
                                default => 'primary'
                            };
                        ?> p-2 px-3 fs-6">
                            <?php echo get_severity_label($error['severity']); ?>
                        </span>
                    </div>
                    <hr>
                    <!-- اطلاعات سیستمی -->
                    <div class="text-start small">
                        <div class="mb-2">
                            <i class="bi bi-person-circle"></i>
                            <span class="ms-2">ثبت کننده: <?php echo htmlspecialchars($error['created_by_name']); ?></span>
                        </div>
                        <div class="mb-2">
                            <i class="bi bi-calendar-check"></i>
                            <span class="ms-2">تاریخ ثبت: <?php echo format_date($error['created_at']); ?></span>
                        </div>
                        <?php if ($error['updated_by']): ?>
                            <div class="mb-2">
                                <i class="bi bi-pencil-square"></i>
                                <span class="ms-2">آخرین ویرایش: <?php echo htmlspecialchars($error['updated_by_name']); ?></span>
                            </div>
                            <div>
                                <i class="bi bi-clock-history"></i>
                                <span class="ms-2">تاریخ ویرایش: <?php echo format_date($error['updated_at']); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- درخت قطعات -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">ساختار قطعات</h6>
                </div>
                <div class="card-body">
                    <div id="error-tree"></div>
                </div>
            </div>

            <!-- دکمه‌های عملیات -->
            <div class="d-grid gap-2">
                <?php if (is_admin() || has_permission('edit_error')): ?>
                    <a href="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" 
                       class="btn btn-warning">
                        <i class="bi bi-pencil-square me-2"></i>ویرایش
                    </a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-right me-2"></i>بازگشت به لیست
                </a>
            </div>
        </div>

        <!-- ستون اصلی - محتوای خطا -->
        <div class="col-md-9">
            <!-- کارت اطلاعات کلی -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h6 class="card-title mb-0">اطلاعات کلی</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h6 class="text-muted mb-3">اطلاعات فنی</h6>
                            <table class="table table-sm">
                                <tr>
                                    <th style="width: 150px;">کد خطا:</th>
                                    <td><?php echo htmlspecialchars($error['error_code']); ?></td>
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
                        <div class="col-md-6 mb-4">
                            <h6 class="text-muted mb-3">اطلاعات تکمیلی</h6>
                            <table class="table table-sm">
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
                </div>
            </div>

            <!-- تب‌های اطلاعات -->
            <div class="card shadow-sm">
                <div class="card-header bg-light p-0">
                    <ul class="nav nav-tabs card-header-tabs m-0" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active px-4" data-bs-toggle="tab" data-bs-target="#description" type="button">
                                <i class="bi bi-file-text me-2"></i>شرح و علائم
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link px-4" data-bs-toggle="tab" data-bs-target="#solution" type="button">
                                <i class="bi bi-tools me-2"></i>راه‌حل و تعمیر
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link px-4" data-bs-toggle="tab" data-bs-target="#diagnosis" type="button">
                                <i class="bi bi-search me-2"></i>تشخیص
                            </button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link px-4" data-bs-toggle="tab" data-bs-target="#safety" type="button">
                                <i class="bi bi-shield-check me-2"></i>ایمنی
                            </button>
                        </li>
                        <?php if ($error['technical_diagram'] || $error['video_guide']): ?>
                            <li class="nav-item">
                                <button class="nav-link px-4" data-bs-toggle="tab" data-bs-target="#media" type="button">
                                    <i class="bi bi-image me-2"></i>رسانه
                                </button>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <!-- تب شرح و علائم -->
                        <div class="tab-pane fade show active" id="description">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <h6 class="text-muted mb-3">توضیحات</h6>
                                    <p class="mb-4"><?php echo nl2br(htmlspecialchars($error['description'])); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">علائم</h6>
                                    <p><?php echo nl2br(htmlspecialchars($error['symptoms'] ?? 'اطلاعاتی ثبت نشده است.')); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">علت</h6>
                                    <p><?php echo nl2br(htmlspecialchars($error['cause'] ?? 'اطلاعاتی ثبت نشده است.')); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- تب راه‌حل و تعمیر -->
                        <div class="tab-pane fade" id="solution">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <h6 class="text-muted mb-3">راه‌حل</h6>
                                    <p><?php echo nl2br(htmlspecialchars($error['solution'])); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">مراحل تعمیر</h6>
                                    <div class="repair-steps">
                                        <?php 
                                        $steps = explode("\n", $error['repair_steps'] ?? '');
                                        if (!empty($steps) && $steps[0] !== ''): 
                                            echo '<ol class="list-group list-group-numbered">';
                                            foreach ($steps as $step): ?>
                                                <li class="list-group-item"><?php echo htmlspecialchars($step); ?></li>
                                            <?php 
                                            endforeach;
                                            echo '</ol>';
                                        else:
                                            echo '<p class="text-muted">اطلاعاتی ثبت نشده است.</p>';
                                        endif;
                                        ?>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted mb-3">نکات تکمیلی</h6>
                                    <p><?php echo nl2br(htmlspecialchars($error['repair_notes'] ?? 'اطلاعاتی ثبت نشده است.')); ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- تب تشخیص -->
                        <div class="tab-pane fade" id="diagnosis">
                            <div class="row">
                                <div class="col-md-12">
                                    <h6 class="text-muted mb-3">مراحل تشخیص</h6>
                                    <div class="diagnosis-steps">
                                        <?php 
                                        $steps = explode("\n", $error['diagnosis_steps'] ?? '');
                                        if (!empty($steps) && $steps[0] !== ''): 
                                            echo '<ol class="list-group list-group-numbered">';
                                            foreach ($steps as $step): ?>
                                                <li class="list-group-item"><?php echo htmlspecialchars($step); ?></li>
                                            <?php 
                                            endforeach;
                                            echo '</ol>';
                                        else:
                                            echo '<p class="text-muted">اطلاعاتی ثبت نشده است.</p>';
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- تب ایمنی -->
                        <div class="tab-pane fade" id="safety">
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>نکات ایمنی مهم:</strong>
                            </div>
                            <?php echo nl2br(htmlspecialchars($error['safety_notes'] ?? 'اطلاعاتی ثبت نشده است.')); ?>
                        </div>

                        <!-- تب رسانه -->
                        <?php if ($error['technical_diagram'] || $error['video_guide']): ?>
                            <div class="tab-pane fade" id="media">
                                <div class="row">
                                    <?php if ($error['technical_diagram']): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">نقشه فنی</h6>
                                                </div>
                                                <div class="card-body p-0">
                                                    <a href="<?php echo BASE_URL . '/uploads/diagrams/' . $error['technical_diagram']; ?>" 
                                                       data-fancybox="gallery">
                                                        <img src="<?php echo BASE_URL . '/uploads/diagrams/' . $error['technical_diagram']; ?>" 
                                                             class="img-fluid w-100" 
                                                             alt="نقشه فنی">
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($error['video_guide']): ?>
                                        <div class="col-md-6 mb-4">
                                            <div class="card">
                                                <div class="card-header bg-light">
                                                    <h6 class="mb-0">ویدیوی راهنما</h6>
                                                </div>
                                                <div class="card-body">
                                                    <div class="ratio ratio-16x9">
                                                        <video controls>
                                                            <source src="<?php echo BASE_URL . '/uploads/videos/' . $error['video_guide']; ?>" type="video/mp4">
                                                            مرورگر شما از پخش ویدیو پشتیبانی نمی‌کند.
                                                        </video>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- استایل‌های اختصاصی -->
<style>
.error-header {
    margin-bottom: 3rem;
    box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
}

.card {
    border: none;
    margin-bottom: 1.5rem;
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid rgba(0,0,0,.125);
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    padding: 1rem 1.5rem;
}

.nav-tabs .nav-link:hover {
    border: none;
    color: #495057;
}

.nav-tabs .nav-link.active {
    color: #0d6efd;
    border: none;
    border-bottom: 2px solid #0d6efd;
}

.tab-content {
    padding: 1.5rem 0;
}

.table th {
    font-weight: 500;
    color: #6c757d;
}

.list-group-item {
    border-left: none;
    border-right: none;
    border-radius: 0;
    padding: 1rem;
}

.badge {
    font-weight: 500;
}

/* درخت قطعات */
#error-tree {
    font-size: 0.9rem;
}

.jstree-default .jstree-icon {
    color: #6c757d;
}

/* Fancybox */
.fancybox-bg {
    background: rgba(0, 0, 0, 0.85);
}
</style>

<!-- اسکریپت‌ها -->
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/themes/default/style.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.3.12/jstree.min.js"></script>

<script>
$(document).ready(function() {
    // تنظیمات Fancybox
    Fancybox.bind("[data-fancybox]", {
        loop: true,
        buttons: [
            "zoom",
            "slideShow",
            "fullScreen",
            "download",
            "close"
        ]
    });

    // ساختار درختی قطعات
    $('#error-tree').jstree({
        'core': {
            'themes': {
                'name': 'default',
                'responsive': true
            },
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
                                            'icon': 'bi bi-exclamation-triangle-fill text-warning'
                                        }
                                    ]
                                }
                                <?php else: ?>
                                {
                                    'text': '<?php echo htmlspecialchars($error['error_code']); ?>',
                                    'icon': 'bi bi-exclamation-triangle-fill text-warning'
                                }
                                <?php endif; ?>
                            ]
                        }
                    ]
                }
            ]
        },
        'plugins': ['types']
    });
});
</script>

<?php require_once 'views/layouts/footer.php'; ?>