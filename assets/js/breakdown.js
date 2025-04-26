document.addEventListener('DOMContentLoaded', () => {
    // بارگذاری فایل‌های JSON
    let provinces = [];
    let cities = [];
    let railways = {};

    // خواندن فایل استان‌ها
    fetch('/assets/plugins/iran-cities/ostan.json')
        .then(response => response.json())
        .then(data => {
            provinces = data;
            // پر کردن سلکت باکس استان‌ها
            const provinceSelect = document.getElementById('province');
            provinces.forEach(province => {
                const option = new Option(province.name, province.id);
                provinceSelect.add(option);
            });
        });

    // خواندن فایل شهرها
    fetch('/assets/plugins/iran-cities/shahr.json')
        .then(response => response.json())
        .then(data => {
            cities = data;
        });

    // خواندن فایل ایستگاه‌های راه‌آهن
    fetch('/assets/plugins/iran-cities/list-railway.json')
        .then(response => response.json())
        .then(data => {
            railways = data;
        });

    // Initialize select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Initialize Persian Datepicker with better configuration
    $('#occurrence_date').persianDatepicker({
        initialValue: false,
        format: 'YYYY/MM/DD HH:mm',
        altField: '#occurrence_date_alt',
        altFormat: 'X',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: false
            }
        },
        toolbox: {
            enabled: true,
            calendarSwitch: {
                enabled: false
            }
        },
        navigator: {
            scroll: {
                enabled: false
            }
        },
        dayPicker: {
            onSelect: function(unix) {
                // Trigger input event after selection
                document.getElementById('occurrence_date').dispatchEvent(new Event('input'));
            }
        },
        observer: true,
        onSelect: function(unix) {
            // Format the date
            const date = new persianDate(unix);
            const formatted = date.format('YYYY/MM/DD HH:mm');
            $('#occurrence_date').val(formatted);
        }
    });

    // وقتی استان تغییر می‌کند
    $('#province').on('change', function() {
        const provinceId = parseInt($(this).val());
        const citySelect = $('#city');
        citySelect.empty().append('<option value="">انتخاب کنید</option>');
        
        if (provinceId) {
            // فیلتر کردن شهرهای استان انتخاب شده
            const provinceCities = cities.filter(city => city.ostan === provinceId);
            provinceCities.forEach(city => {
                citySelect.append(new Option(city.name, city.id));
            });
        }
        
        citySelect.trigger('change');
    });

    // وقتی شهر تغییر می‌کند
    $('#city').on('change', function() {
        const cityId = parseInt($(this).val());
        const stationSelect = $('#station');
        stationSelect.empty().append('<option value="">انتخاب کنید</option>');
        
        if (cityId) {
            // پیدا کردن شهر انتخاب شده
            const selectedCity = cities.find(c => c.id === cityId);
            if (selectedCity) {
                // پیدا کردن ایستگاه‌های راه‌آهن مرتبط
                Object.values(railways).forEach(route => {
                    route.stations.forEach(station => {
                        if (station.city === selectedCity.name) {
                            stationSelect.append(new Option(station.name, station.id));
                        }
                    });
                });
            }
        }
        
        stationSelect.trigger('change');
    });

    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
                
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: 'لطفاً تمام فیلدهای الزامی را پر کنید',
                    confirmButtonText: 'باشه'
                });
            }
            form.classList.add('was-validated');
        }, false);
    }

    // اعتبارسنجی فایل‌ها
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const files = this.files;
            const maxFiles = parseInt(this.dataset.maxFiles);
            const maxSize = this.name === 'images[]' ? 2 : 5; // مگابایت

            if (files.length > maxFiles) {
                this.value = '';
                Swal.fire({
                    icon: 'error',
                    title: 'خطا!',
                    text: `حداکثر تعداد فایل مجاز ${maxFiles} عدد است`,
                    confirmButtonText: 'باشه'
                });
                return;
            }

            for (let file of files) {
                if (file.size > maxSize * 1024 * 1024) {
                    this.value = '';
                    Swal.fire({
                        icon: 'error',
                        title: 'خطا!',
                        text: `حجم هر فایل نباید بیشتر از ${maxSize} مگابایت باشد`,
                        confirmButtonText: 'باشه'
                    });
                    break;
                }
            }
        });
    });
});