// تابع نمایش تأییدیه حذف
function confirmDelete(url, title = 'آیا مطمئن هستید؟') {
    Swal.fire({
        title: title,
        text: "این عملیات قابل بازگشت نیست!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'بله، حذف کن',
        cancelButtonText: 'لغو',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url;
        }
    });
}

// تابع نمایش پیام موفقیت
function showSuccess(message) {
    Swal.fire({
        icon: 'success',
        title: message,
        confirmButtonText: 'باشه',
        timer: 3000,
        timerProgressBar: true
    });
}

// تابع نمایش پیام خطا
function showError(message) {
    Swal.fire({
        icon: 'error',
        title: 'خطا!',
        text: message,
        confirmButtonText: 'باشه'
    });
}

// تابع نمایش پیام هشدار
function showWarning(message) {
    Swal.fire({
        icon: 'warning',
        title: 'هشدار!',
        text: message,
        confirmButtonText: 'باشه'
    });
}

// اعتبارسنجی فرم‌ها
document.addEventListener('DOMContentLoaded', function() {
    const forms = document.querySelectorAll('.needs-validation');
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                // نمایش پیام خطای اعتبارسنجی
                showError('لطفاً همه فیلدهای الزامی را پر کنید');
            }
            form.classList.add('was-validated');
        }, false);
    });
});