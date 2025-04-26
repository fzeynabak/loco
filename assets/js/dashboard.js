document.addEventListener('DOMContentLoaded', function() {
    // SweetAlert برای نمایش پیام‌های سیستم
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });

    // نمایش پیام خوش‌آمدگویی
    Toast.fire({
        icon: 'success',
        title: 'خوش آمدید',
        text: 'به سیستم مدیریت خطاهای لوکوموتیو خوش آمدید'
    });

    // مدیریت کلیک روی دکمه‌های عملیات
    document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const action = this.dataset.action;
            const id = this.dataset.id;

            if (action === 'view') {
                viewError(id);
            } else if (action === 'edit') {
                editError(id);
            }
        });
    });

    // نمایش جزئیات خطا
    function viewError(id) {
        fetch(`${BASE_URL}/errors/get/${id}`)
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: `جزئیات خطای ${data.error_code}`,
                    html: `
                        <div class="text-right">
                            <p><strong>شدت:</strong> ${data.severity}</p>
                            <p><strong>نوع لوکوموتیو:</strong> ${data.locomotive_type}</p>
                            <p><strong>توضیحات:</strong> ${data.description}</p>
                            <p><strong>تاریخ ثبت:</strong> ${data.created_at}</p>
                        </div>
                    `,
                    confirmButtonText: 'بستن'
                });
            });
    }

    // ویرایش خطا
    function editError(id) {
        Swal.fire({
            title: 'آیا مطمئن هستید؟',
            text: "می‌خواهید این خطا را ویرایش کنید؟",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'بله، ویرایش کن',
            cancelButtonText: 'انصراف'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `${BASE_URL}/errors/edit/${id}`;
            }
        });
    }

    // به‌روزرسانی خودکار آمار
    setInterval(() => {
        fetch(`${BASE_URL}/dashboard/stats`)
            .then(response => response.json())
            .then(data => {
                // به‌روزرسانی آمار در کارت‌ها
                document.getElementById('total-errors').textContent = data.total;
                document.getElementById('critical-errors').textContent = data.critical;
                if (data.active_users) {
                    document.getElementById('active-users').textContent = data.active_users;
                }
            });
    }, 30000); // هر 30 ثانیه
});