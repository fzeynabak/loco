<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid pt-3"> <!-- افزودن فاصله از بالا -->
    <div class="card page-content">
        <div class="card-header">
            <h5 class="mb-0">مدیریت کاربران و دسترسی‌ها</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>نام کاربری</th>
                            <th>نام</th>
                            <th>ایمیل</th>
                            <th>نقش</th>
                            <th>وضعیت</th>
                            <th>دسترسی‌ها</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo $user['role'] === 'admin' ? 'danger' : 'primary'; ?>">
                                    <?php echo $user['role'] === 'admin' ? 'مدیر' : 'کاربر'; ?>
                                </span>
                            </td>
                            <td>
                                <?php if (is_admin() && $user['role'] !== 'admin'): ?>
                                    <form action="<?php echo BASE_URL; ?>/users/toggle-status" method="POST" class="d-inline">
                                        <?php insert_csrf_token(); ?>
                                        <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                        <button type="submit" class="btn btn-sm <?php echo $user['status'] === 'active' ? 'btn-warning' : 'btn-success'; ?>">
                                            <?php if ($user['status'] === 'active'): ?>
                                                <i class="bi bi-x-circle"></i>
                                                غیرفعال کردن
                                            <?php else: ?>
                                                <i class="bi bi-check-circle"></i>
                                                فعال کردن
                                            <?php endif; ?>
                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="badge bg-<?php echo $user['status'] === 'active' ? 'success' : 'warning'; ?>">
                                        <?php echo $user['status'] === 'active' ? 'فعال' : 'غیرفعال'; ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php 
                                $permissions = !empty($user['permissions']) ? explode(',', $user['permissions']) : [];
                                foreach ($permissions as $permission): 
                                    if (empty($permission)) continue;
                                ?>
                                    <span class="badge bg-info me-1"><?php echo htmlspecialchars($permission); ?></span>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#permissionModal<?php echo $user['id']; ?>">
                                    <i class="bi bi-shield-check"></i>
                                    مدیریت دسترسی‌ها
                                </button>
                                
                                <!-- Modal -->
                                <div class="modal fade" id="permissionModal<?php echo $user['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">
                                                    مدیریت دسترسی‌های <?php echo htmlspecialchars($user['name']); ?>
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="<?php echo BASE_URL; ?>/users/permissions" method="POST">
                                                <?php insert_csrf_token(); ?>
                                                <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                                
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label d-block">دسترسی‌ها</label>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" 
                                                                   name="permissions[]" value="create_error"
                                                                   <?php echo in_array('create_error', $permissions) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label">افزودن خطا</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" 
                                                                   name="permissions[]" value="view_users"
                                                                   <?php echo in_array('view_users', $permissions) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label">مشاهده کاربران</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" class="form-check-input" 
                                                                   name="permissions[]" value="manage_permissions"
                                                                   <?php echo in_array('manage_permissions', $permissions) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label">مدیریت دسترسی‌ها</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                                                    <button type="submit" class="btn btn-primary">ذخیره تغییرات</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    // انتخاب همه چک‌باکس‌ها
    $('.select-all').click(function() {
        $(this).closest('.modal-body').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
    });
});
</script>