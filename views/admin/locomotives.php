<?php require_once 'views/layouts/main.php'; ?>

<div class="container-fluid pt-3">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">مدیریت انواع لوکوموتیو</h5>
            <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addLocomotiveModal">
                <i class="bi bi-plus-circle me-1"></i>
                افزودن نوع لوکوموتیو جدید
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>نام</th>
                            <th>مدل</th>
                            <th>سازنده</th>
                            <th>توضیحات</th>
                            <th>تاریخ ایجاد</th>
                            <th>عملیات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($locomotive_types)): ?>
                            <tr>
                                <td colspan="6" class="text-center">هیچ نوع لوکوموتیوی یافت نشد</td>
                            </tr>
                        <?php else: foreach ($locomotive_types as $type): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($type['name']); ?></td>
                                <td><?php echo htmlspecialchars($type['model']); ?></td>
                                <td><?php echo htmlspecialchars($type['manufacturer']); ?></td>
                                <td><?php echo htmlspecialchars($type['description'] ?? '-'); ?></td>
                                <td><?php echo format_date($type['created_at']); ?></td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-warning" 
                                            onclick="editLocomotive(<?php echo $type['id']; ?>, 
                                                '<?php echo htmlspecialchars($type['name']); ?>',
                                                '<?php echo htmlspecialchars($type['model']); ?>',
                                                '<?php echo htmlspecialchars($type['manufacturer']); ?>',
                                                '<?php echo htmlspecialchars($type['description'] ?? ''); ?>')">
                                        <i class="bi bi-pencil-square"></i>
                                        ویرایش
                                    </button>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="deleteLocomotive(<?php echo $type['id']; ?>)">
                                        <i class="bi bi-trash"></i>
                                        حذف
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal افزودن لوکوموتیو -->
<div class="modal fade" id="addLocomotiveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">افزودن نوع لوکوموتیو جدید</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>/admin/locomotives" method="POST">
                <?php insert_csrf_token(); ?>
                <input type="hidden" name="action" value="add">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">نام <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">مدل <span class="text-danger">*</span></label>
                        <input type="text" name="model" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">سازنده <span class="text-danger">*</span></label>
                        <input type="text" name="manufacturer" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">توضیحات</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">بستن</button>
                    <button type="submit" class="btn btn-primary">ذخیره</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal ویرایش لوکوموتیو -->
<div class="modal fade" id="editLocomotiveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">ویرایش نوع لوکوموتیو</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo BASE_URL; ?>/admin/locomotives" method="POST">
                <?php insert_csrf_token(); ?>
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="id" id="edit_locomotive_id">
                
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">نام <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="edit_locomotive_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">مدل <span class="text-danger">*</span></label>
                        <input type="text" name="model" id="edit_locomotive_model" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">سازنده <span class="text-danger">*</span></label>
                        <input type="text" name="manufacturer" id="edit_locomotive_manufacturer" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">توضیحات</label>
                        <textarea name="description" id="edit_locomotive_description" class="form-control" rows="3"></textarea>
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

<script>
function editLocomotive(id, name, model, manufacturer, description) {
    $('#edit_locomotive_id').val(id);
    $('#edit_locomotive_name').val(name);
    $('#edit_locomotive_model').val(model);
    $('#edit_locomotive_manufacturer').val(manufacturer);
    $('#edit_locomotive_description').val(description);
    $('#editLocomotiveModal').modal('show');
}

function deleteLocomotive(id) {
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
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?php echo BASE_URL; ?>/admin/locomotives';
            
            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'action';
            actionInput.value = 'delete';
            
            const idInput = document.createElement('input');
            idInput.type = 'hidden';
            idInput.name = 'id';
            idInput.value = id;
            
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = 'csrf_token';
            csrfInput.value = '<?php echo $_SESSION['csrf_token']; ?>';
            
            form.appendChild(actionInput);
            form.appendChild(idInput);
            form.appendChild(csrfInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
}
</script>

<?php require_once 'views/layouts/footer.php'; ?>