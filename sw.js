const CACHE_NAME = 'helix_m_c-v1';
const ASSETS = [
    './',
    './index.html',
    './manifest.json',
    './helix_config.json',
    './helix-icon.png'
];

// Instalar y cachear archivos
self.addEventListener('install', (e) => {
    e.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(ASSETS))
    );
});

// Responder desde el caché
self.addEventListener('fetch', (e) => {
    e.respondWith(
        caches.match(e.request).then((res) => res || fetch(e.request))
    );
});