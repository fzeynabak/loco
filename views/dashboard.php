<?php require_once 'views/layouts/header.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <?php require_once 'views/layouts/sidebar.php'; ?>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">خوش آمدید <?php echo htmlspecialchars($_SESSION['user_name']); ?></h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">تعداد کل خطاها</h5>
                            <h2 class="display-4">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM locomotive_errors");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card bg-warning h-100">
                        <div class="card-body">
                            <h5 class="card-title">خطاهای حل نشده</h5>
                            <h2 class="display-4">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM locomotive_errors WHERE status = 'open'");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>

                <?php if (is_admin()): ?>
                <div class="col-md-4">
                    <div class="card bg-info text-white h-100">
                        <div class="card-body">
                            <h5 class="card-title">کاربران فعال</h5>
                            <h2 class="display-4">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM users WHERE status = 'active'");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h2>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Recent Errors -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">آخرین خطاهای ثبت شده</h5>
                    <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-primary btn-sm">
                        مشاهده همه
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>کد خطا</th>
                                    <th>شدت</th>
                                    <th>توضیحات</th>
                                    <th>نوع لوکوموتیو</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $db->query("SELECT * FROM locomotive_errors ORDER BY created_at DESC LIMIT 5");
                                $recent_errors = $stmt->fetchAll();
                                
                                if (empty($recent_errors)): ?>
                                    <tr>
                                        <td colspan="6" class="text-center">هیچ خطایی ثبت نشده است</td>
                                    </tr>
                                <?php else:
                                    foreach ($recent_errors as $error): ?>
                                        <tr>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>">
                                                    <?php echo htmlspecialchars($error['error_code']); ?>
                                                </a>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php
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
                                            <td><?php echo htmlspecialchars(substr($error['description'], 0, 50)) . '...'; ?></td>
                                            <td><?php echo htmlspecialchars($error['locomotive_type']); ?></td>
                                            <td><?php echo format_date($error['created_at']); ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>" 
                                                   class="btn btn-sm btn-info" title="مشاهده">
                                                    <i class="bi bi-eye"></i>
                                                </a>
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
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>