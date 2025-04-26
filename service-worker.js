const CACHE_VERSION = 'v1';
const CACHE_NAME = `loco-cache-${CACHE_VERSION}`;

// پیش‌نیازهای اصلی برنامه
const CORE_ASSETS = [
    '/loco/',
    '/loco/manifest.json',
    '/loco/assets/images/icons/icon-192x192.png',
    '/loco/assets/images/icons/icon-512x512.png'
];

// استراتژی‌های کش
const CACHE_STRATEGIES = {
    CACHE_FIRST: 'cache-first',    // اول از کش، اگر نبود از شبکه
    NETWORK_FIRST: 'network-first', // اول از شبکه، اگر آفلاین بود از کش
    STALE_WHILE_REVALIDATE: 'stale-while-revalidate' // نمایش از کش و آپدیت در پس‌زمینه
};

// تنظیمات مسیرها و استراتژی کش آنها
const ROUTE_SETTINGS = [
    { urlPattern: /\/loco\/$/, strategy: CACHE_STRATEGIES.NETWORK_FIRST },
    { urlPattern: /\/loco\/dashboard/, strategy: CACHE_STRATEGIES.NETWORK_FIRST },
    { urlPattern: /\/loco\/errors$/, strategy: CACHE_STRATEGIES.NETWORK_FIRST },
    { urlPattern: /\/loco\/api\//, strategy: CACHE_STRATEGIES.NETWORK_FIRST },
    { urlPattern: /\/loco\/assets\//, strategy: CACHE_STRATEGIES.CACHE_FIRST },
    { urlPattern: /\.(?:js|css|png|jpg|jpeg|svg|gif)$/, strategy: CACHE_STRATEGIES.STALE_WHILE_REVALIDATE }
];

// نصب سرویس ورکر و ذخیره فایل‌های اصلی
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(CORE_ASSETS))
            .then(() => self.skipWaiting())
    );
});

// فعال‌سازی و پاک کردن کش‌های قدیمی
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames
                        .filter(cacheName => cacheName.startsWith('loco-cache-') && cacheName !== CACHE_NAME)
                        .map(cacheName => caches.delete(cacheName))
                );
            })
            .then(() => self.clients.claim())
    );
});

// هندل کردن درخواست‌ها با استراتژی‌های مختلف
self.addEventListener('fetch', event => {
    // فقط درخواست‌های GET را مدیریت می‌کنیم
    if (event.request.method !== 'GET') return;

    const url = new URL(event.request.url);

    // اگر درخواست برای مانیفست یا سرویس ورکر است، مستقیم به سرور می‌رود
    if (url.pathname.endsWith('manifest.json') || url.pathname.endsWith('service-worker.js')) {
        return;
    }

    // پیدا کردن استراتژی مناسب برای مسیر
    const routeSetting = ROUTE_SETTINGS.find(setting => setting.urlPattern.test(url.pathname));
    const strategy = routeSetting ? routeSetting.strategy : CACHE_STRATEGIES.NETWORK_FIRST;

    switch (strategy) {
        case CACHE_STRATEGIES.CACHE_FIRST:
            event.respondWith(cacheFirst(event.request));
            break;

        case CACHE_STRATEGIES.NETWORK_FIRST:
            event.respondWith(networkFirst(event.request));
            break;

        case CACHE_STRATEGIES.STALE_WHILE_REVALIDATE:
            event.respondWith(staleWhileRevalidate(event.request));
            break;

        default:
            event.respondWith(networkFirst(event.request));
    }
});

// Cache-first strategy
async function cacheFirst(request) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
        return cachedResponse;
    }
    return fetch(request).then(response => {
        if (response.ok) {
            const responseToCache = response.clone();
            caches.open(CACHE_NAME).then(cache => {
                cache.put(request, responseToCache);
            });
        }
        return response;
    });
}

// Network-first strategy
async function networkFirst(request) {
    try {
        const response = await fetch(request);
        if (response.ok) {
            const responseToCache = response.clone();
            caches.open(CACHE_NAME).then(cache => {
                cache.put(request, responseToCache);
            });
        }
        return response;
    } catch (error) {
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        throw error;
    }
}

// Stale-while-revalidate strategy
async function staleWhileRevalidate(request) {
    const cachedResponse = await caches.match(request);

    const fetchPromise = fetch(request).then(response => {
        if (response.ok) {
            const responseToCache = response.clone();
            caches.open(CACHE_NAME).then(cache => {
                cache.put(request, responseToCache);
            });
        }
        return response;
    });

    return cachedResponse || fetchPromise;
}

// هندل کردن پیام‌ها از طرف صفحه
self.addEventListener('message', event => {
    if (event.data === 'skipWaiting') {
        self.skipWaiting();
    }
});

// هندل کردن sync events برای عملیات آفلاین
self.addEventListener('sync', event => {
    if (event.tag === 'sync-errors') {
        event.waitUntil(syncErrors());
    }
});

// هندل کردن push notifications
self.addEventListener('push', event => {
    const options = {
        body: event.data.text(),
        icon: '/loco/assets/images/icons/icon-192x192.png',
        badge: '/loco/assets/images/icons/badge-72x72.png',
        dir: 'rtl',
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        }
    };

    event.waitUntil(
        self.registration.showNotification('مدیریت خطاها', options)
    );
});

// باز کردن صفحه مربوطه وقتی روی نوتیفیکیشن کلیک می‌شود
self.addEventListener('notificationclick', event => {
    event.notification.close();
    event.waitUntil(
        clients.openWindow('/loco/')
    );
});

// همگام‌سازی خطاها در حالت آفلاین
async function syncErrors() {
    try {
        const response = await fetch('/loco/api/sync-errors', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        });
        if (!response.ok) throw new Error('Sync failed');
        return response;
    } catch (error) {
        console.error('Error syncing:', error);
        throw error;
    }
}