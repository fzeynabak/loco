document.addEventListener('DOMContentLoaded', function() {
    const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
    const avatarInput = document.createElement('input');
    avatarInput.type = 'file';
    avatarInput.accept = 'image/*';
    avatarInput.style.display = 'none';
    avatarWrapper.appendChild(avatarInput);

    // اضافه کردن قابلیت drag & drop
    avatarWrapper.addEventListener('dragover', (e) => {
        e.preventDefault();
        avatarWrapper.classList.add('dragover');
    });

    avatarWrapper.addEventListener('dragleave', () => {
        avatarWrapper.classList.remove('dragover');
    });

    avatarWrapper.addEventListener('drop', (e) => {
        e.preventDefault();
        avatarWrapper.classList.remove('dragover');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            handleImageUpload(file);
        }
    });

    // کلیک روی آواتار
    avatarWrapper.addEventListener('click', () => {
        avatarInput.click();
    });

    avatarInput.addEventListener('change', (e) => {
        if (e.target.files.length) {
            handleImageUpload(e.target.files[0]);
        }
    });

    function handleImageUpload(file) {
        const formData = new FormData();
        formData.append('avatar', file);
        formData.append('csrf_token', document.querySelector('input[name="csrf_token"]').value);

        fetch(BASE_URL + '/profile/update-avatar', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('.profile-avatar').src = data.avatar_url;
                showToast('success', 'تصویر پروفایل با موفقیت بروزرسانی شد');
            } else {
                showToast('error', data.message || 'خطا در بروزرسانی تصویر پروفایل');
            }
        })
        .catch(error => {
            showToast('error', 'خطا در ارتباط با سرور');
            console.error('Error:', error);
        });
    }

    function showToast(type, message) {
        // اگر از SweetAlert2 استفاده می‌کنید
        Swal.fire({
            icon: type,
            text: message,
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
    }
});