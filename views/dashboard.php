<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid py-4">
    <!-- آمار و ارقام -->
    <div class="row g-4 mb-4">
        <!-- تعداد کل خطاها -->
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4" style="background: linear-gradient(45deg, #4CAF50, #8BC34A);">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="bi bi-exclamation-triangle fs-2 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white mb-0">تعداد کل خطاها</h6>
                            <h3 class="text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM locomotive_errors");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/errors" class="text-white text-decoration-none d-flex align-items-center">
                        <small>مشاهده همه</small>
                        <i class="bi bi-chevron-left ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- خطاهای بحرانی -->
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4" style="background: linear-gradient(45deg, #F44336, #FF5722);">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="bi bi-exclamation-circle fs-2 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white mb-0">خطاهای بحرانی</h6>
                            <h3 class="text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM locomotive_errors WHERE severity = 'critical'");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/errors?severity=critical" class="text-white text-decoration-none d-flex align-items-center">
                        <small>مشاهده همه</small>
                        <i class="bi bi-chevron-left ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <?php if (is_admin()): ?>
        <!-- کاربران فعال -->
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4" style="background: linear-gradient(45deg, #2196F3, #03A9F4);">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="bi bi-people fs-2 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white mb-0">کاربران فعال</h6>
                            <h3 class="text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM users WHERE status = 'active'");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/users" class="text-white text-decoration-none d-flex align-items-center">
                        <small>مشاهده همه</small>
                        <i class="bi bi-chevron-left ms-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- مدیریت دسترسی‌ها -->
        <div class="col-lg-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm overflow-hidden">
                <div class="card-body p-4" style="background: linear-gradient(45deg, #9C27B0, #673AB7);">
                    <div class="d-flex align-items-center mb-3">
                        <div class="flex-shrink-0 bg-white bg-opacity-25 rounded-3 p-3">
                            <i class="bi bi-shield-check fs-2 text-white"></i>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="text-white mb-0">مدیریت دسترسی‌ها</h6>
                            <h3 class="text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(DISTINCT user_id) FROM user_permissions");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/users/permissions" class="text-white text-decoration-none d-flex align-items-center">
                        <small>مدیریت دسترسی‌ها</small>
                        <i class="bi bi-chevron-left ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- آخرین خطاها و نمودارها -->
    <div class="row g-4">
        <!-- آخرین خطاها -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">آخرین خطاهای ثبت شده</h5>
                    <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-outline-primary btn-sm">
                        مشاهده همه
                        <i class="bi bi-arrow-left ms-1"></i>
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="py-3">کد خطا</th>
                                    <th class="py-3">شدت</th>
                                    <th class="py-3">توضیحات</th>
                                    <th class="py-3">نوع لوکوموتیو</th>
                                    <th class="py-3">تاریخ ثبت</th>
                                    <th class="py-3">عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $db->query("SELECT * FROM locomotive_errors ORDER BY created_at DESC LIMIT 5");
                                $recent_errors = $stmt->fetchAll();
                                
                                if (empty($recent_errors)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center py-4">هیچ خطایی ثبت نشده است</td>
                                    </tr>
                                <?php else:
                                    foreach ($recent_errors as $error): ?>
                                        <tr>
                                            <td class="py-3">
                                                <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>" class="text-decoration-none">
                                                    <?php echo htmlspecialchars($error['error_code']); ?>
                                                </a>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge rounded-pill bg-<?php
                                                    echo match($error['severity']) {
                                                        'critical' => 'danger',
                                                        'major' => 'warning',
                                                        'minor' => 'info',
                                                        'warning' => 'secondary'
                                                    };
                                                ?>">
                                                    <?php echo get_severity_label($error['severity']); ?>
                                                </span>
                                            </td>
                                            <td class="py-3"><?php echo htmlspecialchars(substr($error['description'], 0, 50)) . '...'; ?></td>
                                            <td class="py-3"><?php echo htmlspecialchars($error['locomotive_type']); ?></td>
                                            <td class="py-3"><?php echo format_date($error['created_at']); ?></td>
                                            <td class="py-3">
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>" 
                                                       class="btn btn-light" title="مشاهده">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <?php if (is_admin() || has_permission('edit_error')): ?>
                                                    <a href="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" 
                                                       class="btn btn-light" title="ویرایش">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach;
                                endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- وضعیت خطاها -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0">وضعیت خطاها</h5>
                </div>
                <div class="card-body">
                    <?php
                    // آمار خطاها بر اساس شدت
                    $stmt = $db->query("SELECT severity, COUNT(*) as count FROM locomotive_errors GROUP BY severity");
                    $severity_stats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
                    
                    $total = array_sum($severity_stats);
                    foreach (['critical', 'major', 'minor', 'warning'] as $severity):
                        $count = $severity_stats[$severity] ?? 0;
                        $percentage = $total > 0 ? round(($count / $total) * 100) : 0;
                        $color = match($severity) {
                            'critical' => '#dc3545',
                            'major' => '#ffc107',
                            'minor' => '#0dcaf0',
                            'warning' => '#6c757d'
                        };
                    ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span><?php echo get_severity_label($severity); ?></span>
                            <span class="text-muted small"><?php echo $count; ?> مورد</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: <?php echo $percentage; ?>%; background-color: <?php echo $color; ?>;"
                                 aria-valuenow="<?php echo $percentage; ?>" 
                                 aria-valuemin="0" 
                                 aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>