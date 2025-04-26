let map, markers = [], selectedMarker;

function initRailwayMap() {
    // تنظیمات اولیه نقشه
    map = L.map('railwayMap').setView([32.4279, 53.6880], 6);
    
    // اضافه کردن لایه نقشه
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);
}

function updateMapStations(stations) {
    // پاک کردن مارکرهای قبلی
    markers.forEach(marker => map.removeLayer(marker));
    markers = [];
    
    // اضافه کردن مارکرهای جدید
    stations.forEach(station => {
        if (station.lat && station.lng) {
            const marker = L.marker([station.lat, station.lng], {
                title: station.name
            }).addTo(map);
            
            marker.on('click', function() {
                if (selectedMarker) {
                    selectedMarker.getElement().classList.remove('active');
                }
                selectedMarker = marker;
                marker.getElement().classList.add('active');
                
                // ذخیره موقعیت انتخاب شده
                $('#selected_location').val(JSON.stringify({
                    name: station.name,
                    lat: station.lat,
                    lng: station.lng
                }));
                
                // انتخاب خودکار شهر و ایستگاه
                const citySelect = $('#city');
                const stationSelect = $('#station');
                
                const cityOption = Array.from(citySelect[0].options).find(opt => 
                    opt.text === station.city
                );
                if (cityOption) {
                    citySelect.val(cityOption.value).trigger('change');
                    
                    // منتظر می‌مانیم تا گزینه‌های ایستگاه لود شوند
                    setTimeout(() => {
                        const stationOption = Array.from(stationSelect[0].options).find(opt => 
                            opt.text === station.name
                        );
                        if (stationOption) {
                            stationSelect.val(stationOption.value).trigger('change');
                        }
                    }, 500);
                }
            });
            
            markers.push(marker);
        }
    });
    
    // تنظیم محدوده نقشه به گونه‌ای که همه مارکرها دیده شوند
    if (markers.length > 0) {
        const group = new L.featureGroup(markers);
        map.fitBounds(group.getBounds().pad(0.1));
    }
}

// اضافه کردن کد به صفحه
document.addEventListener('DOMContentLoaded', () => {
    // مقداردهی اولیه نقشه
    initRailwayMap();
    
    // بروزرسانی نقشه وقتی شهر تغییر می‌کند
    $('#city').on('change', function() {
        const cityId = parseInt($(this).val());
        if (cityId && cities.length > 0 && railways) {
            const selectedCity = cities.find(c => c.id === cityId);
            if (selectedCity) {
                const stations = [];
                Object.values(railways).forEach(route => {
                    route.stations.forEach(station => {
                        if (station.city === selectedCity.name) {
                            stations.push(station);
                        }
                    });
                });
                updateMapStations(stations);
            }
        }
    });
});