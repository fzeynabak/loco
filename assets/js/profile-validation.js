/**
 * اعتبارسنجی کد ملی ایرانی
 * @param {string} code - کد ملی وارد شده
 * @returns {boolean} - نتیجه اعتبارسنجی
 */
function validateNationalCode(code) {
    // حذف فاصله‌ها از ابتدا و انتها
    code = code.trim();
    
    // بررسی طول کد ملی
    if (code.length !== 10) {
        return false;
    }

    // بررسی عددی بودن
    if (!/^\d{10}$/.test(code)) {
        return false;
    }

    // بررسی الگوریتم کد ملی
    const check = parseInt(code[9]);
    let sum = 0;
    for (let i = 0; i < 9; i++) {
        sum += parseInt(code[i]) * (10 - i);
    }
    const remainder = sum % 11;
    return (remainder < 2 && check == remainder) || (remainder >= 2 && check == (11 - remainder));
}

/**
 * ذخیره موقت اطلاعات فرم
 */
function saveFormData() {
    const formData = {};
    const form = document.querySelector('.profile-form');
    const inputs = form.querySelectorAll('input, select, textarea');
    
    inputs.forEach(input => {
        if (input.type !== 'password') { // رمزهای عبور ذخیره نشوند
            formData[input.name] = input.value;
        }
    });
    
    localStorage.setItem('profile_form_data', JSON.stringify(formData));
}

/**
 * بازیابی اطلاعات فرم
 */
function restoreFormData() {
    const savedData = localStorage.getItem('profile_form_data');
    if (savedData) {
        const formData = JSON.parse(savedData);
        const form = document.querySelector('.profile-form');
        
        Object.keys(formData).forEach(key => {
            const input = form.querySelector(`[name="${key}"]`);
            if (input) {
                input.value = formData[key];
            }
        });
        
        // پاک کردن اطلاعات ذخیره شده
        localStorage.removeItem('profile_form_data');
    }
}

// اضافه کردن اعتبارسنجی به فرم
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.profile-form');
    const nationalCodeInput = form.querySelector('[name="national_code"]');
    
    // اعتبارسنجی آنی کد ملی
    if (nationalCodeInput) {
        nationalCodeInput.addEventListener('input', function() {
            const isValid = validateNationalCode(this.value);
            
            // نمایش یا مخفی کردن پیام خطا
            let errorDiv = this.nextElementSibling;
            if (!errorDiv || !errorDiv.classList.contains('invalid-feedback')) {
                errorDiv = document.createElement('div');
                errorDiv.className = 'invalid-feedback';
                this.parentNode.appendChild(errorDiv);
            }
            
            if (!isValid && this.value.length > 0) {
                this.classList.add('is-invalid');
                this.classList.remove('is-valid');
                errorDiv.textContent = 'کد ملی وارد شده معتبر نیست';
                errorDiv.style.display = 'block';
            } else if (this.value.length > 0) {
                this.classList.add('is-valid');
                this.classList.remove('is-invalid');
                errorDiv.style.display = 'none';
            } else {
                this.classList.remove('is-valid', 'is-invalid');
                errorDiv.style.display = 'none';
            }
        });
    }
    
    // ذخیره اطلاعات فرم قبل از ارسال
    form.addEventListener('submit', function(e) {
        if (!form.checkValidity()) {
            e.preventDefault();
            saveFormData();
        }
    });
    
    // بازیابی اطلاعات فرم در صورت وجود
    restoreFormData();
});