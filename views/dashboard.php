<?php require_once 'views/layouts/main.php'; ?>

<!-- استایل‌های داشبورد -->
<style>
/* متغیرهای رنگ */
:root {
    --green-gradient: linear-gradient(45deg, #4CAF50, #8BC34A);
    --red-gradient: linear-gradient(45deg, #F44336, #FF5722);
    --blue-gradient: linear-gradient(45deg, #2196F3, #03A9F4);
    --purple-gradient: linear-gradient(45deg, #9C27B0, #673AB7);
}

/* استایل‌های عمومی */
.dashboard-container {
    padding: 1rem;
}

@media (min-width: 768px) {
    .dashboard-container {
        padding: 1.5rem;
    }
}

/* کارت‌های آمار */
.stat-card {
    height: 100%;
    border: none;
    border-radius: 15px;
    overflow: hidden;
    transition: transform 0.2s ease;
}

.stat-card:active {
    transform: scale(0.98);
}

.stat-card .card-body {
    padding: 1.25rem;
}

@media (min-width: 768px) {
    .stat-card .card-body {
        padding: 1.5rem;
    }
    
    .stat-card:hover {
        transform: translateY(-5px);
    }
}

/* آیکون کارت */
.stat-icon {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 12px;
    margin-bottom: 0;
}

.stat-icon i {
    font-size: 1.5rem;
}

/* محتوای کارت */
.stat-content {
    flex-grow: 1;
}

.stat-title {
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 0;
}

@media (min-width: 768px) {
    .stat-title {
        font-size: 1rem;
    }
    
    .stat-value {
        font-size: 1.75rem;
    }
}

/* لینک مشاهده همه */
.stat-link {
    display: flex;
    align-items: center;
    margin-top: 0.75rem;
    font-size: 0.875rem;
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: color 0.2s ease;
}

.stat-link:hover,
.stat-link:focus {
    color: #fff;
}

.stat-link i {
    margin-right: 0.5rem;
    font-size: 0.75rem;
}

/* جدول خطاها */
.recent-errors {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.04);
    margin-top: 1.5rem;
}

.recent-errors .card-header {
    background: transparent;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.table-responsive {
    margin: 0;
    padding: 0.5rem;
}

.dashboard-table {
    margin: 0;
}

.dashboard-table th {
    white-space: nowrap;
    font-weight: 500;
    color: #6c757d;
    border-bottom-width: 1px;
}

.dashboard-table td {
    vertical-align: middle;
    padding: 1rem 0.75rem;
}

.dashboard-table tr:last-child td {
    border-bottom: none;
}

/* نشانگر وضعیت */
.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 0.5rem;
}

.status-critical {
    background-color: #dc3545;
}

.status-warning {
    background-color: #ffc107;
}

.status-normal {
    background-color: #198754;
}

/* نمودار وضعیت */
.chart-container {
    position: relative;
    height: 300px;
    margin-top: 1.5rem;
}

@media (max-width: 767.98px) {
    .chart-container {
        height: 250px;
    }
}
</style>

<div class="dashboard-container">
    <!-- آمار و ارقام -->
    <div class="row g-3 mb-4">
        <!-- تعداد کل خطاها -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card shadow-sm">
                <div class="card-body" style="background: var(--green-gradient);">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-white bg-opacity-25">
                            <i class="bi bi-exclamation-triangle text-white"></i>
                        </div>
                        <div class="stat-content ms-3">
                            <h6 class="stat-title text-white">تعداد کل خطاها</h6>
                            <h3 class="stat-value text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM locomotive_errors");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/errors" class="stat-link">
                        مشاهده همه
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- خطاهای بحرانی -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card shadow-sm">
                <div class="card-body" style="background: var(--red-gradient);">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-white bg-opacity-25">
                            <i class="bi bi-exclamation-circle text-white"></i>
                        </div>
                        <div class="stat-content ms-3">
                            <h6 class="stat-title text-white">خطاهای بحرانی</h6>
                            <h3 class="stat-value text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM locomotive_errors WHERE severity = 'critical'");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/errors?severity=critical" class="stat-link">
                        مشاهده همه
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <?php if (is_admin()): ?>
        <!-- کاربران فعال -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card shadow-sm">
                <div class="card-body" style="background: var(--blue-gradient);">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-white bg-opacity-25">
                            <i class="bi bi-people text-white"></i>
                        </div>
                        <div class="stat-content ms-3">
                            <h6 class="stat-title text-white">کاربران فعال</h6>
                            <h3 class="stat-value text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM users WHERE status = 'active'");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/users" class="stat-link">
                        مشاهده همه
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- گزارشات امروز -->
        <div class="col-12 col-md-6 col-lg-3">
            <div class="stat-card shadow-sm">
                <div class="card-body" style="background: var(--purple-gradient);">
                    <div class="d-flex align-items-center">
                        <div class="stat-icon bg-white bg-opacity-25">
                            <i class="bi bi-journal-text text-white"></i>
                        </div>
                        <div class="stat-content ms-3">
                            <h6 class="stat-title text-white">گزارشات امروز</h6>
                            <h3 class="stat-value text-white mb-0">
                                <?php
                                $stmt = $db->query("SELECT COUNT(*) FROM reports WHERE DATE(created_at) = CURRENT_DATE");
                                echo number_format($stmt->fetchColumn());
                                ?>
                            </h3>
                        </div>
                    </div>
                    <a href="<?php echo BASE_URL; ?>/reports" class="stat-link">
                        مشاهده همه
                        <i class="bi bi-chevron-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- جدول آخرین خطاها -->
    <div class="recent-errors">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">آخرین خطاهای گزارش شده</h5>
            <a href="<?php echo BASE_URL; ?>/errors" class="btn btn-primary btn-sm">
                مشاهده همه
                <i class="bi bi-chevron-left me-1"></i>
            </a>
        </div>
        <div class="table-responsive">
            <table class="table dashboard-table">
                <thead>
                    <tr>
                        <th>وضعیت</th>
                        <th>عنوان خطا</th>
                        <th>لوکوموتیو</th>
                        <th>گزارش‌دهنده</th>
                        <th>تاریخ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $stmt = $db->query("
    SELECT e.*, e.locomotive_type as loco_name, u.name as user_name 
    FROM locomotive_errors e
    LEFT JOIN users u ON e.created_by = u.id
    ORDER BY e.created_at DESC LIMIT 5
");
                    while ($error = $stmt->fetch()): 
                    ?>
                    <tr>
                        <td>
                            <span class="status-indicator status-<?php echo $error['severity']; ?>"></span>
                            <?php echo $error['severity'] === 'critical' ? 'بحرانی' : ($error['severity'] === 'warning' ? 'هشدار' : 'عادی'); ?>
                        </td>
                        <td>
                            <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>" 
                               class="text-decoration-none text-dark">
                                <?php echo htmlspecialchars($error['title']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($error['loco_name']); ?></td>
                        <td><?php echo htmlspecialchars($error['user_name']); ?></td>
                        <td><?php echo jdate('Y/m/d H:i', strtotime($error['created_at'])); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once 'views/layouts/footer.php'; ?>