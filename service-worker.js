const CACHE_NAME = 'loco-cache-v1';
const URLS_TO_CACHE = [
    '/loco/',
    '/loco/dashboard',
    '/loco/manifest.json',
    '/loco/assets/images/icons/icon-192x192.png'
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(URLS_TO_CACHE))
    );
});

self.addEventListener('fetch', (event) => {
    event.respondWith(
        fetch(event.request)
            .catch(() => caches.match(event.request))
    );
});