<?php
require_once 'layouts/header.php';

// اتصال به دیتابیس برای دریافت آمار
$db = Database::getInstance()->getConnection();

// دریافت تعداد کل خطاها
$stmt = $db->query("SELECT COUNT(*) FROM locomotive_errors");
$total_errors = $stmt->fetchColumn();

// دریافت تعداد کاربران (فقط برای ادمین)
$total_users = 0;
$pending_users = 0;
if (is_admin()) {
    $stmt = $db->query("SELECT COUNT(*) FROM users");
    $total_users = $stmt->fetchColumn();
    
    $stmt = $db->query("SELECT COUNT(*) FROM users WHERE status = 'pending'");
    $pending_users = $stmt->fetchColumn();
}
?>

<div class="container-fluid mt-4">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    منوی کاربری
                </div>
                <div class="list-group list-group-flush">
                    <a href="<?php echo BASE_URL; ?>/dashboard" class="list-group-item list-group-item-action active">
                        <i class="bi bi-speedometer2"></i> داشبورد
                    </a>
                    <a href="<?php echo BASE_URL; ?>/errors/search" class="list-group-item list-group-item-action">
                        <i class="bi bi-search"></i> جستجوی خطاها
                    </a>
                    <?php if (is_admin()): ?>
                        <a href="<?php echo BASE_URL; ?>/admin/users" class="list-group-item list-group-item-action">
                            <i class="bi bi-people"></i> مدیریت کاربران
                        </a>
                        <a href="<?php echo BASE_URL; ?>/admin/settings" class="list-group-item list-group-item-action">
                            <i class="bi bi-gear"></i> تنظیمات
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9 col-lg-10">
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
                            <h2 class="display-4"><?php echo number_format($total_errors); ?></h2>
                        </div>
                    </div>
                </div>

                <?php if (is_admin()): ?>
                    <div class="col-md-4">
                        <div class="card bg-success text-white h-100">
                            <div class="card-body">
                                <h5 class="card-title">تعداد کل کاربران</h5>
                                <h2 class="display-4"><?php echo number_format($total_users); ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card bg-warning h-100">
                            <div class="card-body">
                                <h5 class="card-title">کاربران در انتظار تایید</h5>
                                <h2 class="display-4"><?php echo number_format($pending_users); ?></h2>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Recent Errors -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">آخرین خطاهای ثبت شده</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>کد خطا</th>
                                    <th>توضیحات</th>
                                    <th>دسته‌بندی</th>
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
                                        <td colspan="5" class="text-center">هیچ خطایی ثبت نشده است</td>
                                    </tr>
                                <?php else:
                                    foreach ($recent_errors as $error): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($error['error_code']); ?></td>
                                            <td><?php echo htmlspecialchars(substr($error['description'], 0, 100)) . '...'; ?></td>
                                            <td><?php echo htmlspecialchars($error['category']); ?></td>
                                            <td><?php echo date('Y/m/d H:i', strtotime($error['created_at'])); ?></td>
                                            <td>
                                                <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>" class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php if (is_admin()): ?>
                                                    <a href="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" class="btn btn-sm btn-warning">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-danger" 
                                                            onclick="confirmDelete('<?php echo BASE_URL; ?>/errors/delete/<?php echo $error['id']; ?>')">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                <?php endif; ?>
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

<script>
function confirmDelete(url) {
    Swal.fire({
        title: 'آیا مطمئن هستید؟',
        text: "این عملیات قابل بازگشت نیست!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'بله، حذف شود',
        cancelButtonText: 'انصراف'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}
</script>

<?php require_once 'layouts/footer.php'; ?>