<?php require_once 'views/layouts/header.php'; ?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>لیست خطاهای لوکوموتیو</h2>
        <?php if (is_admin()): ?>
            <a href="<?php echo BASE_URL; ?>/errors/add" class="btn btn-primary">افزودن خطای جدید</a>
        <?php endif; ?>
    </div>
    
    <div class="card mb-4">
        <div class="card-body">
            <form action="<?php echo BASE_URL; ?>/errors" method="GET" class="form-inline">
                <div class="input-group w-100">
                    <input type="text" name="search" class="form-control" placeholder="جستجو در کد خطا، توضیحات یا راه حل..." value="<?php echo htmlspecialchars($search ?? ''); ?>">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary">جستجو</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <?php show_flash_messages(); ?>
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>کد خطا</th>
                    <th>توضیحات</th>
                    <th>راه حل</th>
                    <th>دسته بندی</th>
                    <?php if (is_admin()): ?>
                        <th>عملیات</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($errors)): ?>
                    <tr>
                        <td colspan="<?php echo is_admin() ? 5 : 4; ?>" class="text-center">هیچ خطایی یافت نشد</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($errors as $error): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($error['error_code']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($error['description'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($error['solution'])); ?></td>
                            <td><?php echo htmlspecialchars($error['category']); ?></td>
                            <?php if (is_admin()): ?>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/errors/edit/<?php echo $error['id']; ?>" class="btn btn-sm btn-info">ویرایش</a>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="confirmDelete(<?php echo $error['id']; ?>)">حذف</button>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <?php if ($total_pages > 1): ?>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php echo $page == $i ? 'active' : ''; ?>">
                        <a class="page-link" href="<?php echo BASE_URL; ?>/errors?page=<?php echo $i; ?><?php echo $search ? '&search=' . urlencode($search) : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    <?php endif; ?>
</div>

<script>
function confirmDelete(id) {
    if (confirm('آیا از حذف این خطا اطمینان دارید؟')) {
        window.location.href = '<?php echo BASE_URL; ?>/errors/delete/' + id;
    }
}
</script>

<?php require_once 'views/layouts/footer.php'; ?>