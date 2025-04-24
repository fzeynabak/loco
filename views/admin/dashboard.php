<?php require_once 'layouts/header.php'; ?>

<div class="container mt-4">
    <div class="row">
        <!-- بخش نوار کناری -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    پنل کاربری
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?php echo BASE_URL; ?>/dashboard" class="list-group-item list-group-item-action active">
                        <i class="bi bi-speedometer2 me-2"></i> داشبورد
                    </a>
                    <a href="<?php echo BASE_URL; ?>/errors" class="list-group-item list-group-item-action">
                        <i class="bi bi-search me-2"></i> جستجوی خطاها
                    </a>
                    <?php if (is_admin()): ?>
                    <a href="<?php echo BASE_URL; ?>/admin/users" class="list-group-item list-group-item-action">
                        <i class="bi bi-people me-2"></i> مدیریت کاربران
                    </a>
                    <a href="<?php echo BASE_URL; ?>/admin/settings" class="list-group-item list-group-item-action">
                        <i class="bi bi-gear me-2"></i> تنظیمات
                    </a>
                    <?php endif; ?>
                    <a href="<?php echo BASE_URL; ?>/profile" class="list-group-item list-group-item-action">
                        <i class="bi bi-person me-2"></i> پروفایل
                    </a>
                </div>
            </div>
        </div>
        
        <!-- بخش اصلی -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">خوش آمدید <?php echo htmlspecialchars($_SESSION['user_name']); ?></h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <!-- کارت تعداد خطاها -->
                        <div class="col-md-4">
                            <div class="card bg-primary text-white">
                                <div class="card-body">
                                    <h5 class="card-title">تعداد کل خطاها</h5>
                                    <?php
                                    $stmt = Database::getInstance()->getConnection()->query("SELECT COUNT(*) FROM locomotive_errors");
                                    $errorCount = $stmt->fetchColumn();
                                    ?>
                                    <h2 class="mb-0"><?php echo number_format($errorCount); ?></h2>
                                </div>
                            </div>
                        </div>
                        
                        <?php if (is_admin()): ?>
                        <!-- کارت تعداد کاربران -->
                        <div class="col-md-4">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <h5 class="card-title">تعداد کاربران</h5>
                                    <?php
                                    $stmt = Database::getInstance()->getConnection()->query("SELECT COUNT(*) FROM users");
                                    $userCount = $stmt->fetchColumn();
                                    ?>
                                    <h2 class="mb-0"><?php echo number_format($userCount); ?></h2>
                                </div>
                            </div>
                        </div>
                        
                        <!-- کارت کاربران در انتظار تایید -->
                        <div class="col-md-4">
                            <div class="card bg-warning text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">در انتظار تایید</h5>
                                    <?php
                                    $stmt = Database::getInstance()->getConnection()->query("SELECT COUNT(*) FROM users WHERE status = 'pending'");
                                    $pendingCount = $stmt->fetchColumn();
                                    ?>
                                    <h2 class="mb-0"><?php echo number_format($pendingCount); ?></h2>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- جدول آخرین خطاهای ثبت شده -->
                    <div class="mt-4">
                        <h5>آخرین خطاهای ثبت شده</h5>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>کد خطا</th>
                                        <th>توضیحات</th>
                                        <th>دسته‌بندی</th>
                                        <th>تاریخ ثبت</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $stmt = Database::getInstance()->getConnection()->query(
                                        "SELECT * FROM locomotive_errors ORDER BY created_at DESC LIMIT 5"
                                    );
                                    $latestErrors = $stmt->fetchAll();
                                    
                                    if (empty($latestErrors)): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">هیچ خطایی ثبت نشده است</td>
                                        </tr>
                                    <?php else:
                                        foreach ($latestErrors as $error): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($error['error_code']); ?></td>
                                                <td><?php echo htmlspecialchars(substr($error['description'], 0, 100)) . '...'; ?></td>
                                                <td><?php echo htmlspecialchars($error['category']); ?></td>
                                                <td><?php echo date('Y/m/d H:i', strtotime($error['created_at'])); ?></td>
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
</div>

<?php require_once 'layouts/footer.php'; ?>