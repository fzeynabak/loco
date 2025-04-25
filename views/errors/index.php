<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-3">
            <!-- فیلترها -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">جستجو و فیلتر</h5>
                </div>
                <div class="card-body">
                    <form action="" method="GET">
                        <div class="mb-3">
                            <label class="form-label">جستجو</label>
                            <input type="text" name="search" class="form-control" value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">دسته‌بندی</label>
                            <select name="category" class="form-select">
                                <option value="">همه</option>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?php echo $cat['id']; ?>" <?php echo (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($cat['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">شدت خطا</label>
                            <select name="severity" class="form-select">
                                <option value="">همه</option>
                                <option value="critical" <?php echo (isset($_GET['severity']) && $_GET['severity'] == 'critical') ? 'selected' : ''; ?>>بحرانی</option>
                                <option value="major" <?php echo (isset($_GET['severity']) && $_GET['severity'] == 'major') ? 'selected' : ''; ?>>اصلی</option>
                                <option value="minor" <?php echo (isset($_GET['severity']) && $_GET['severity'] == 'minor') ? 'selected' : ''; ?>>جزئی</option>
                                <option value="warning" <?php echo (isset($_GET['severity']) && $_GET['severity'] == 'warning') ? 'selected' : ''; ?>>هشدار</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">نوع لوکوموتیو</label>
                            <select name="locomotive_type" class="form-select">
                                <option value="">همه</option>
                                <?php foreach ($locomotive_types as $type): ?>
                                    <option value="<?php echo $type['id']; ?>" <?php echo (isset($_GET['locomotive_type']) && $_GET['locomotive_type'] == $type['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($type['name'] . ' - ' . $type['model']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <button type="submit" class="btn btn-primary w-100">اعمال فیلتر</button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">لیست خطاها</h5>
                    <?php if (is_admin() || has_permission('create_error')): ?>
                        <a href="<?php echo BASE_URL; ?>/errors/create" class="btn btn-primary">
                            <i class="bi bi-plus-lg"></i> افزودن خطای جدید
                        </a>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>کد خطا</th>
                                    <th>شدت</th>
                                    <th>توضیحات</th>
                                    <th>نوع لوکوموتیو</th>
                                    <th>قطعه</th>
                                    <th>تاریخ ثبت</th>
                                    <th>عملیات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($errors)): ?>
                                    <tr>
                                        <td colspan="7" class="text-center">هیچ خطایی یافت نشد</td>
                                    </tr>
                                <?php else: foreach ($errors as $error): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>" class="text-decoration-none">
                                                <?php echo htmlspecialchars($error['error_code']); ?>
                                            </a>
                                        </td>
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
                                        <td><?php echo htmlspecialchars(substr($error['description'], 0, 100)) . '...'; ?></td>
                                        <td><?php echo htmlspecialchars($error['locomotive_type']); ?></td>
                                        <td><?php echo htmlspecialchars($error['component']); ?></td>
                                        <td><?php echo format_date($error['created_at']); ?></td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="<?php echo BASE_URL; ?>/errors/view/<?php echo $error['id']; ?>" 
                                                   class="btn btn-info" title="مشاهده">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <?php if (is_admin() || has_permission('edit_error')): ?>
                                                    <a href="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" 
                                                       class="btn btn-warning" title="ویرایش">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                <?php endif; ?>
                                                <?php if (is_admin()): ?>
                                                    <button type="button" 
                                                            class="btn btn-danger" 
                                                            onclick="confirmDelete('<?php echo BASE_URL; ?>/errors/delete/<?php echo $error['id']; ?>')"
                                                            title="حذف">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- پیجینیشن -->
                    <?php if ($total_pages > 1): ?>
                        <nav aria-label="صفحه‌بندی">
                            <ul class="pagination justify-content-center">
                                <?php if ($page > 1): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>">
                                            قبلی
                                        </a>
                                    </li>
                                <?php endif; ?>
                                
                                <?php for ($i = max(1, $page - 2); $i <= min($total_pages, $page + 2); $i++): ?>
                                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $i; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>">
                                            <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>
                                
                                <?php if ($page < $total_pages): ?>
                                    <li class="page-item">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&<?php echo http_build_query(array_diff_key($_GET, ['page' => ''])); ?>">
                                            بعدی
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript برای نمایش درختی و تایید حذف -->
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

<?php require_once 'views/layouts/footer.php'; ?>