const map = L.map('railwayMap').setView([35.6892, 51.3890], 6);
document.addEventListener('DOMContentLoaded', function () {
    // متغیرهای سراسری
    let map, railways = {}, selectedStation = null;
    let provinces = [], cities = [];

    // راه‌اندازی نقشه
    function initMap() {
        map = L.map('railwayMap').setView([32.4279, 53.6880], 6);
        
        // اضافه کردن لایه نقشه
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // اضافه کردن کنترل‌های نقشه
        L.control.scale({
            imperial: false,
            position: 'bottomright'
        }).addTo(map);
    }

    // رسم مسیرهای راه آهن
    function drawRailwayLines() {
        if (!railways || !Object.keys(railways).length) return;

        Object.values(railways).forEach(route => {
            if (route.stations && route.stations.length >= 2) {
                // رسم خط آهن
                const coordinates = route.stations.map(station => [station.lat, station.lng]);
                const path = L.polyline(coordinates, {
                    color: '#2c3e50',
                    weight: 4,
                    opacity: 0.8,
                    smoothFactor: 1,
                    className: 'railway-line'
                }).addTo(map);

                // اضافه کردن ایستگاه‌ها
                route.stations.forEach(station => {
                    if (station.lat && station.lng) {
                        const marker = L.marker([station.lat, station.lng], {
                            icon: L.divIcon({
                                className: 'station-marker',
                                html: '<div class="station-point"></div>',
                                iconSize: [12, 12],
                                iconAnchor: [6, 6]
                            })
                        }).addTo(map);

                        // پاپ‌آپ ایستگاه
                        marker.bindPopup(`
                            <div class="station-popup">
                                <strong>${station.name}</strong><br>
                                ${station.city}
                            </div>
                        `);

                        // رویداد کلیک روی ایستگاه
                        marker.on('click', function() {
                            if (selectedStation) {
                                selectedStation.getElement().classList.remove('active');
                            }
                            selectedStation = marker;
                            marker.getElement().classList.add('active');

                            // ذخیره موقعیت انتخاب شده
                            $('#selected_location').val(JSON.stringify({
                                name: station.name,
                                lat: station.lat,
                                lng: station.lng
                            }));

                            // انتخاب خودکار در فرم
                            selectLocationInForm(station);
                        });
                    }
                });
            }
        });
    }

    // انتخاب موقعیت در فرم
    function selectLocationInForm(station) {
        if (cities.length === 0 || !station.city) return;

        const selectedCity = cities.find(c => c.name === station.city);
        if (selectedCity) {
            const province = provinces.find(p => p.id === selectedCity.ostan);
            if (province) {
                // تنظیم استان
                $('#province').val(province.id).trigger('change');

                // تنظیم شهر با تاخیر
                setTimeout(() => {
                    $('#city').val(selectedCity.id).trigger('change');
                    
                    // تنظیم ایستگاه با تاخیر
                    setTimeout(() => {
                        const stationSelect = $('#station');
                        const stationOption = Array.from(stationSelect[0].options).find(opt => 
                            opt.text === station.name
                        );
                        if (stationOption) {
                            stationSelect.val(stationOption.value).trigger('change');
                        }
                    }, 500);
                }, 500);
            }
        }
    }

    // راه‌اندازی Select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        language: {
            noResults: () => "نتیجه‌ای یافت نشد"
        }
    });

    // تنظیمات PersianDatepicker
    $('#occurrence_date').persianDatepicker({
        initialValue: false,
        format: 'YYYY/MM/DD HH:mm',
        altField: '#occurrence_date_alt',
        altFormat: 'X',
        observer: true,
        timePicker: {
            enabled: true,
            hour: {
                enabled: true,
                step: 1
            },
            minute: {
                enabled: true,
                step: 1
            },
            second: {
                enabled: false
            },
            meridian: {
                enabled: false
            }
        },
        toolbox: {
            enabled: true,
            submitButton: {
                enabled: true,
                text: 'تایید'
            },
            todayButton: {
                enabled: true,
                text: 'امروز'
            },
            calendarSwitch: {
                enabled: false
            }
        },
        navigator: {
            scroll: {
                enabled: false
            }
        },
        onSelect: function(unix) {
            const date = new persianDate(unix);
            const formatted = date.format('YYYY/MM/DD HH:mm');
            $('#occurrence_date').val(formatted);
            $('#occurrence_date_alt').val(unix);
            $('#occurrence_date').trigger('input');
        },
        onShow: function() {
            if (!$('#occurrence_date').val()) {
                const now = new persianDate();
                this.model.state.setSelectedDateTime('hour', now.hour());
                this.model.state.setSelectedDateTime('minute', now.minute());
                this.model.view.renderTimePartial();
            }
        }
    });

    // لود فایل‌های JSON
    Promise.all([
        fetch(BASE_URL + '/assets/plugins/iran-cities/ostan.json').then(r => r.json()),
        fetch(BASE_URL + '/assets/plugins/iran-cities/shahr.json').then(r => r.json()),
        fetch(BASE_URL + '/assets/plugins/iran-cities/list-railway.json').then(r => r.json())
    ]).then(([provincesData, citiesData, railwaysData]) => {
        provinces = provincesData;
        cities = citiesData;
        railways = railwaysData;

        // راه‌اندازی نقشه و رسم خطوط
        initMap();
        drawRailwayLines();
    }).catch(error => {
        console.error('Error loading data:', error);
        alert('خطا در بارگذاری اطلاعات. لطفاً صفحه را رفرش کنید.');
    });

    // رویداد تغییر استان
    $('#province').on('change', function() {
        const provinceId = parseInt($(this).val());
        const citySelect = $('#city');
        
        citySelect.empty().append('<option value="">انتخاب کنید</option>');
        citySelect.prop('disabled', !provinceId);
        
        if (provinceId && cities) {
            const provinceCities = cities.filter(city => city.ostan === provinceId);
            provinceCities.forEach(city => {
                citySelect.append(new Option(city.name, city.id));
            });
        }
        
        citySelect.trigger('change');
    });

    // رویداد تغییر شهر
    $('#city').on('change', function() {
        const cityId = parseInt($(this).val());
        const stationSelect = $('#station');
        
        stationSelect.empty().append('<option value="">انتخاب کنید</option>');
        stationSelect.prop('disabled', !cityId);
        
        if (cityId && cities && railways) {
            const selectedCity = cities.find(c => c.id === cityId);
            if (selectedCity) {
                Object.values(railways).forEach(route => {
                    route.stations.forEach(station => {
                        if (station.city === selectedCity.name) {
                            const option = new Option(station.name, station.id);
                            if (!Array.from(stationSelect[0].options).some(opt => opt.text === station.name)) {
                                stationSelect.append(option);
                            }
                        }
                    });
                });
            }
        }
    });

    
// تنظیمات نقشه


// اضافه کردن لایه نقشه
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// آرایه برای ذخیره مسیر و ایستگاه‌ها
let railwayPath = null;
let stationMarkers = [];
let selectedPoint = null;

// خواندن فایل مسیر ریلی
fetch('/assets/plugins/iran-cities/list-railway.json')
    .then(response => response.json())
    .then(data => {
        const tehranMashhad = data['tehran-mashhad'];
        const stations = tehranMashhad.stations;
        const coordinates = [];

        // اضافه کردن مارکر برای هر ایستگاه
        stations.forEach(station => {
            // اینجا باید مختصات هر ایستگاه رو از یک فایل دیگه بخونیم
            // فعلا به عنوان نمونه از مختصات فرضی استفاده می‌کنیم
            const coord = getStationCoordinates(station.name);
            if (coord) {
                coordinates.push(coord);
                const marker = L.marker(coord, {
                    icon: L.divIcon({
                        className: 'station-marker',
                        html: `<div class="station-icon"></div>`,
                        iconSize: [12, 12]
                    })
                }).addTo(map);

                marker.bindPopup(station.name);
                stationMarkers.push({
                    marker: marker,
                    station: station
                });
            }
        });

        // رسم مسیر ریلی
        if (coordinates.length > 1) {
            railwayPath = L.polyline(coordinates, {
                color: '#1a73e8',
                weight: 3,
                opacity: 0.8
            }).addTo(map);

            // تنظیم محدوده نقشه بر اساس مسیر
            map.fitBounds(railwayPath.getBounds());
        }
    });

// وقتی روی نقشه کلیک می‌شه
map.on('click', function(e) {
    // اگر قبلا نقطه‌ای انتخاب شده، حذفش می‌کنیم
    if (selectedPoint) {
        map.removeLayer(selectedPoint);
    }

    // اضافه کردن مارکر جدید
    selectedPoint = L.marker(e.latlng, {
        icon: L.divIcon({
            className: 'selected-point',
            html: '<div class="point-icon"></div>',
            iconSize: [16, 16]
        })
    }).addTo(map);

    // ذخیره مختصات در input مخفی
    document.getElementById('selected_location').value = `${e.latlng.lat},${e.latlng.lng}`;

    // پیدا کردن نزدیک‌ترین ایستگاه
    const nearestStation = findNearestStation(e.latlng);
    if (nearestStation) {
        // آپدیت کردن select‌های استان/شهر/ایستگاه
        updateLocationSelects(nearestStation.station);
    }
});

// تابع پیدا کردن نزدیک‌ترین ایستگاه
function findNearestStation(point) {
    let nearest = null;
    let minDist = Infinity;

    stationMarkers.forEach(sm => {
        const marker = sm.marker;
        const dist = point.distanceTo(marker.getLatLng());
        if (dist < minDist) {
            minDist = dist;
            nearest = sm;
        }
    });

    return nearest;
}

// تابع آپدیت کردن select‌ها
function updateLocationSelects(station) {
    // پیدا کردن و انتخاب استان
    const provinceSelect = $('#province');
    const province = provinces.find(p => p.name === station.province);
    if (province) {
        provinceSelect.val(province.id).trigger('change');

        // منتظر می‌مونیم تا شهرها لود بشن
        setTimeout(() => {
            // پیدا کردن و انتخاب شهر
            const citySelect = $('#city');
            const city = cities.find(c => c.name === station.city);
            if (city) {
                citySelect.val(city.id).trigger('change');

                // منتظر می‌مونیم تا ایستگاه‌ها لود بشن
                setTimeout(() => {
                    // انتخاب ایستگاه
                    const stationSelect = $('#station');
                    const stationOption = Array.from(stationSelect[0].options)
                        .find(opt => opt.text === station.name);
                    if (stationOption) {
                        stationSelect.val(stationOption.value).trigger('change');
                    }
                }, 100);
            }
        }, 100);
    }
}

// تابع گرفتن مختصات ایستگاه (این باید با داده‌های واقعی جایگزین بشه)
function getStationCoordinates(stationName) {
    const coordinates = {
        'تهران': [35.6892, 51.3890],
        'گرمسار': [35.2182, 52.3409],
        'سمنان': [35.5769, 53.3950],
        'دامغان': [36.1680, 54.3480],
        'شاهرود': [36.4181, 54.9763],
        'میامی': [36.4097, 55.6542],
        'سبزوار': [36.2152, 57.6678],
        'نیشابور': [36.2140, 58.7956],
        'مشهد': [36.2605, 59.6168]
    };
    return coordinates[stationName];
}
    
});